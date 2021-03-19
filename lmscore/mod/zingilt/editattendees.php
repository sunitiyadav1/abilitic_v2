<?php
// This file is part of Moodle - http://moodle.org/
//
// Moodle is free software: you can redistribute it and/or modify
// it under the terms of the GNU General Public License as published by
// the Free Software Foundation, either version 3 of the License, or
// (at your option) any later version.
//
// Moodle is distributed in the hope that it will be useful,
// but WITHOUT ANY WARRANTY; without even the implied warranty of
// MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
// GNU General Public License for more details.
//
// You should have received a copy of the GNU General Public License
// along with Moodle.  If not, see <http://www.gnu.org/licenses/>.

/**
 * Copyright (C) 2007-2011 Catalyst IT (http://www.catalyst.net.nz)
 * Copyright (C) 2011-2013 Totara LMS (http://www.totaralms.com)
 * Copyright (C) 2014 onwards Catalyst IT (http://www.catalyst-eu.net)
 *
 * @package    mod
 * @subpackage zingilt
 * @copyright  2014 onwards Catalyst IT <http://www.catalyst-eu.net>
 * @author     Stacey Walker <stacey@catalyst-eu.net>
 * @author     Alastair Munro <alastair.munro@totaralms.com>
 * @author     Aaron Barnes <aaron.barnes@totaralms.com>
 * @author     Francois Marier <francois@catalyst.net.nz>
 */

require_once(dirname(dirname(dirname(__FILE__))) . '/config.php');
require_once('lib.php');

define('MAX_USERS_PER_PAGE', 5000);

$s              = required_param('s', PARAM_INT); // zingilt session ID.
$add            = optional_param('add', 0, PARAM_BOOL);
$remove         = optional_param('remove', 0, PARAM_BOOL);
$showall        = optional_param('showall', 0, PARAM_BOOL);
$searchtext     = optional_param('searchtext', '', PARAM_TEXT); // Search string.
$suppressemail  = optional_param('suppressemail', false, PARAM_BOOL); // Send email notifications.
$previoussearch = optional_param('previoussearch', 0, PARAM_BOOL);
$backtoallsessions = optional_param('backtoallsessions', 0, PARAM_INT); // zingilt activity to go back to.

if (!$session = zingilt_get_session($s)) {
    print_error('error:incorrectcoursemodulesession', 'zingilt');
}
if (!$zingilt = $DB->get_record('zingilt', array('id' => $session->zingilt))) {
    print_error('error:incorrectzingiltid', 'zingilt');
}
if (!$course = $DB->get_record('course', array('id' => $zingilt->course))) {
    print_error('error:coursemisconfigured', 'zingilt');
}
if (!$cm = get_coursemodule_from_instance('zingilt', $zingilt->id, $course->id)) {
    print_error('error:incorrectcoursemodule', 'zingilt');
}

// Check essential permissions.
require_course_login($course);
$context = context_course::instance($course->id);
require_capability('mod/zingilt:viewattendees', $context);

// Get some language strings.
$strsearch = get_string('search');
$strshowall = get_string('showall');
$strsearchresults = get_string('searchresults');
$strzingilts = get_string('modulenameplural', 'zingilt');
$strzingilt = get_string('modulename', 'zingilt');

$errors = array();

// Get the user_selector we will need.
$potentialuserselector = new zingilt_candidate_selector('addselect', array('sessionid' => $session->id));
$existinguserselector = new zingilt_existing_selector('removeselect', array('sessionid' => $session->id));

// Process incoming user assignments.
if (optional_param('add', false, PARAM_BOOL) && confirm_sesskey()) {
    require_capability('mod/zingilt:addattendees', $context);
    $userstoassign = $potentialuserselector->get_selected_users();
    if (!empty($userstoassign)) {
        foreach ($userstoassign as $adduser) {
            if (!$adduser = clean_param($adduser->id, PARAM_INT)) {
                continue; // Invalid userid.
            }

            // Make sure that the user is enroled in the course.
            if (!has_capability('moodle/course:view', $context, $adduser)) {
                $user = $DB->get_record('user', array('id' => $adduser));
                // Make sure that the user is enroled in the course.
                if (!is_enrolled($context, $user)) {
                    if (!enrol_try_internal_enrol($course->id, $user->id)) {
                        $errors[] = get_string('error:enrolmentfailed', 'zingilt', fullname($user));
                        $errors[] = get_string('error:addattendee', 'zingilt', fullname($user));
                        continue; // Don't sign the user up.
                    }
                }
            }

            $usernamefields = get_all_user_name_fields(true);
            if (zingilt_get_user_submissions($zingilt->id, $adduser)) {
                $erruser = $DB->get_record('user', array('id' => $adduser), "id, {$usernamefields}");
                $errors[] = get_string('error:addalreadysignedupattendee', 'zingilt', fullname($erruser));
            } else {
                if (!zingilt_session_has_capacity($session, $context)) {
                    $errors[] = get_string('full', 'zingilt');
                    break; // No point in trying to add other people.
                }
                // Check if we are waitlisting or booking.
                if ($session->datetimeknown) {
                    $status = MDL_ZILT_STATUS_BOOKED;
                } else {
                    $status = MDL_ZILT_STATUS_WAITLISTED;
                }
                if (!zingilt_user_signup($session, $zingilt, $course, '', MDL_ZILT_BOTH,
                $status, $adduser, !$suppressemail)) {
                    $erruser = $DB->get_record('user', array('id' => $adduser), "id, {$usernamefields}");
                    $errors[] = get_string('error:addattendee', 'zingilt', fullname($erruser));
                }
            }
        }
        $potentialuserselector->invalidate_selected_users();
        $existinguserselector->invalidate_selected_users();
    }
}

// Process removing user assignments from session.
if (optional_param('remove', false, PARAM_BOOL) && confirm_sesskey()) {
    require_capability('mod/zingilt:removeattendees', $context);
    $userstoremove = $existinguserselector->get_selected_users();
    if (!empty($userstoremove)) {
        foreach ($userstoremove as $removeuser) {
            if (!$removeuser = clean_param($removeuser->id, PARAM_INT)) {
                continue; // Invalid userid.
            }

            if (zingilt_user_cancel($session, $removeuser, true, $cancelerr)) {

                // Notify the user of the cancellation if the session hasn't started yet.
                $timenow = time();
                if (!$suppressemail and !zingilt_has_session_started($session, $timenow)) {
                    zingilt_send_cancellation_notice($zingilt, $session, $removeuser);
                }
            } else {
                $errors[] = $cancelerr;
                $usernamefields = get_all_user_name_fields(true);
                $erruser = $DB->get_record('user', array('id' => $removeuser), "id, {$usernamefields}");
                $errors[] = get_string('error:removeattendee', 'zingilt', fullname($erruser));
            }
        }
        $potentialuserselector->invalidate_selected_users();
        $existinguserselector->invalidate_selected_users();

        // Update attendees.
        zingilt_update_attendees($session);
    }
}

// Main page.
$pagetitle = format_string($zingilt->name);

$PAGE->set_cm($cm);
$PAGE->set_url('/mod/zingilt/editattendees.php', array('s' => $s, 'backtoallsessions' => $backtoallsessions));

$PAGE->set_title($pagetitle);
$PAGE->set_heading($course->fullname);
echo $OUTPUT->header();

echo $OUTPUT->box_start();
echo $OUTPUT->heading(get_string('addremoveattendees', 'zingilt'));

// Create user_selector form.
$out = html_writer::start_tag('form', array('id' => 'assignform', 'method' => 'post', 'action' => $PAGE->url));
$out .= html_writer::start_tag('div');
$out .= html_writer::empty_tag('input', array('type' => 'hidden', 'name' => "previoussearch", 'value' => $previoussearch));
$out .= html_writer::empty_tag('input', array('type' => 'hidden', 'name' => "backtoallsessions", 'value' => $backtoallsessions));
$out .= html_writer::empty_tag('input', array('type' => 'hidden', 'name' => "sesskey", 'value' => sesskey()));

$table = new html_table();
$table->attributes['class'] = "generaltable generalbox boxaligncenter";
$cells = array();
$content = html_writer::start_tag('p') . html_writer::tag('label', get_string('attendees', 'zingilt'),
        array('for' => 'removeselect')) . html_writer::end_tag('p');
$content .= $existinguserselector->display(true);
$cell = new html_table_cell($content);
$cell->attributes['id'] = 'existingcell';
$cells[] = $cell;
$content = html_writer::tag('div', html_writer::empty_tag('input',
    array('type' => 'submit', 'id' => 'add', 'name' => 'add', 'title' => get_string('add'),
        'value' => $OUTPUT->larrow().' '.get_string('add'))), array('id' => 'addcontrols'));
$content .= html_writer::tag('div', html_writer::empty_tag('input',
    array('type' => 'submit', 'id' => 'remove', 'name' => 'remove', 'title' => get_string('remove'),
        'value' => $OUTPUT->rarrow().' '.get_string('remove'))), array('id' => 'removecontrols'));
$cell = new html_table_cell($content);
$cell->attributes['id'] = 'buttonscell';
$cells[] = $cell;
$content = html_writer::start_tag('p') . html_writer::tag('label',
        get_string('potentialattendees', 'zingilt'), array('for' => 'addselect')) . html_writer::end_tag('p');
$content .= $potentialuserselector->display(true);
$cell = new html_table_cell($content);
$cell->attributes['id'] = 'potentialcell';
$cells[] = $cell;
$table->data[] = new html_table_row($cells);
$content = html_writer::checkbox('suppressemail', 1, $suppressemail, get_string('suppressemail', 'zingilt'),
    array('id' => 'suppressemail'));
$content .= $OUTPUT->help_icon('suppressemail', 'zingilt');
$cell = new html_table_cell($content);
$cell->attributes['id'] = 'backcell';
$cell->attributes['colspan'] = '3';
$table->data[] = new html_table_row(array($cell));

$out .= html_writer::table($table);

// Get all signed up non-attendees.
$nonattendees = 0;
$usernamefields = get_all_user_name_fields(true, 'u');
$nonattendeesrs = $DB->get_recordset_sql(
     "SELECT
            u.id,
            {$usernamefields},
            u.email,
            ss.statuscode
        FROM
            {zingilt_sessions} s
        JOIN
            {zingilt_signups} su
         ON s.id = su.sessionid
        JOIN
            {zingilt_signups_status} ss
         ON su.id = ss.signupid
        JOIN
            {user} u
         ON u.id = su.userid
        WHERE
            s.id = ?
        AND ss.superceded != 1
        AND ss.statuscode = ?
        ORDER BY
            u.lastname, u.firstname", array($session->id, MDL_ZILT_STATUS_REQUESTED)
);

$table = new html_table();
$table->head = array(get_string('name'), get_string('email'), get_string('status'));
foreach ($nonattendeesrs as $user) {
    $data = array();
    $data[] = new html_table_cell(fullname($user));
    $data[] = new html_table_cell($user->email);
    $data[] = new html_table_cell(get_string('status_' . zingilt_get_status($user->statuscode), 'zingilt'));
    $row = new html_table_row($data);
    $table->data[] = $row;
    $nonattendees++;
}

$nonattendeesrs->close();
if ($nonattendees) {
    $out .= html_writer::empty_tag('br');
    $out .= $OUTPUT->heading(get_string('unapprovedrequests', 'zingilt') . ' (' . $nonattendees . ')');
    $out .= html_writer::table($table);
}

$out .= html_writer::end_tag('div') . html_writer::end_tag('form');
echo $out;

if (!empty($errors)) {
    $msg = html_writer::start_tag('p');
    foreach ($errors as $e) {
        $msg .= $e . html_writer::empty_tag('br');
    }
    $msg .= html_writer::end_tag('p');
    echo $OUTPUT->box_start('center');
    echo $OUTPUT->notification($msg);
    echo $OUTPUT->box_end();
}

// Bottom of the page links.
echo html_writer::start_tag('p');
$url = new moodle_url('/mod/zingilt/attendees.php', array('s' => $session->id, 'backtoallsessions' => $backtoallsessions));
echo html_writer::link($url, get_string('goback', 'zingilt'));
echo html_writer::end_tag('p');
echo $OUTPUT->box_end();
echo $OUTPUT->footer($course);
