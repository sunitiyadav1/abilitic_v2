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

$s = required_param('s', PARAM_INT); // zingilt session ID.
$backtoallsessions = optional_param('backtoallsessions', 0, PARAM_INT);

if (!$session = zingilt_get_session($s)) {
    print_error('error:incorrectcoursemodulesession', 'zingilt');
}
if (!$zingilt = $DB->get_record('zingilt', array('id' => $session->zingilt))) {
    print_error('error:incorrectzingiltid', 'zingilt');
}
if (!$course = $DB->get_record('course', array('id' => $zingilt->course))) {
    print_error('error:coursemisconfigured', 'zingilt');
}
if (!$cm = get_coursemodule_from_instance("zingilt", $zingilt->id, $course->id)) {
    print_error('error:incorrectcoursemoduleid', 'zingilt');
}

require_course_login($course, true, $cm);
$context = context_course::instance($course->id);
$contextmodule = context_module::instance($cm->id);
require_capability('mod/zingilt:view', $context);

$returnurl = "$CFG->wwwroot/course/view.php?id=$course->id";
if ($backtoallsessions) {
    $returnurl = "$CFG->wwwroot/mod/zingilt/view.php?f=$backtoallsessions";
}

$pagetitle = format_string($zingilt->name);

$PAGE->set_cm($cm);
$PAGE->set_url('/mod/zingilt/signup.php', array('s' => $s, 'backtoallsessions' => $backtoallsessions));

$PAGE->set_title($pagetitle);
$PAGE->set_heading($course->fullname);

// Guests can't signup for a session, so offer them a choice of logging in or going back.
if (isguestuser()) {
    $loginurl = $CFG->wwwroot.'/login/index.php';
    if (!empty($CFG->loginhttps)) {
        $loginurl = str_replace('http:', 'https:', $loginurl);
    }

    echo $OUTPUT->header();
    $out = html_writer::tag('p', get_string('guestsno', 'zingilt')) .
        html_writer::empty_tag('br') .
        html_writer::tag('p', get_string('continuetologin', 'zingilt'));
    echo $OUTPUT->confirm($out, $loginurl, get_local_referer(false));
    echo $OUTPUT->footer();
    exit();
}

$manageremail = false;
if (get_config(null, 'zingilt_addchangemanageremail')) {
    $manageremail = zingilt_get_manageremail($USER->id);
}

$showdiscountcode = ($session->discountcost > 0);

$mform = new mod_zingilt_signup_form(null, compact('s', 'backtoallsessions', 'manageremail', 'showdiscountcode'));
if ($mform->is_cancelled()) {
    redirect($returnurl);
}

if ($fromform = $mform->get_data()) { // Form submitted.

    if (empty($fromform->submitbutton)) {
        print_error('error:unknownbuttonclicked', 'zingilt', $returnurl);
    }

    // User can not update Manager's email (depreciated functionality).
    if (!empty($fromform->manageremail)) {

        // Logging and events trigger.
        $params = array(
            'context'  => $contextmodule,
            'objectid' => $session->id
        );
        $event = \mod_zingilt\event\update_manageremail_failed::create($params);
        $event->add_record_snapshot('zingilt_sessions', $session);
        $event->add_record_snapshot('zingilt', $zingilt);
        $event->trigger();
    }

    // Get signup type.
    if (!$session->datetimeknown) {
        $statuscode = MDL_ZILT_STATUS_WAITLISTED;
    } else if (zingilt_get_num_attendees($session->id) < $session->capacity) {

        // Save available.
        $statuscode = MDL_ZILT_STATUS_BOOKED;
    } else {
        $statuscode = MDL_ZILT_STATUS_WAITLISTED;
    }

    if (!zingilt_session_has_capacity($session, $context) && (!$session->allowoverbook)) {
        print_error('sessionisfull', 'zingilt', $returnurl);
    } else if (zingilt_get_user_submissions($zingilt->id, $USER->id)) {
        print_error('alreadysignedup', 'zingilt', $returnurl);
    } else if (zingilt_manager_needed($zingilt) && !zingilt_get_manageremail($USER->id)) {
        print_error('error:manageremailaddressmissing', 'zingilt', $returnurl);
    } else if ($submissionid = zingilt_user_signup($session, $zingilt, $course, $fromform->discountcode, $fromform->notificationtype, $statuscode)) {

        // Logging and events trigger.
        $params = array(
            'context'  => $contextmodule,
            'objectid' => $session->id
        );
        $event = \mod_zingilt\event\signup_success::create($params);
        $event->add_record_snapshot('zingilt_sessions', $session);
        $event->add_record_snapshot('zingilt', $zingilt);
        $event->trigger();

        $message = get_string('bookingcompleted', 'zingilt');
        if ($session->datetimeknown && $zingilt->confirmationinstrmngr) {
            $message .= html_writer::empty_tag('br') . html_writer::empty_tag('br') . get_string('confirmationsentmgr', 'zingilt');
        } else {
            $message .= html_writer::empty_tag('br') . html_writer::empty_tag('br') . get_string('confirmationsent', 'zingilt');
        }

        $timemessage = 4;
        redirect($returnurl, $message, $timemessage);
    } else {

        // Logging and events trigger.
        $params = array(
            'context'  => $contextmodule,
            'objectid' => $session->id
        );
        $event = \mod_zingilt\event\signup_failed::create($params);
        $event->add_record_snapshot('zingilt_sessions', $session);
        $event->add_record_snapshot('zingilt', $zingilt);
        $event->trigger();

        print_error('error:problemsigningup', 'zingilt', $returnurl);
    }

    redirect($returnurl);
} else if ($manageremail !== false) {

    // Set values for the form.
    $toform = new stdClass();
    $toform->manageremail = $manageremail;
    $mform->set_data($toform);
}

echo $OUTPUT->header();

$heading = get_string('signupfor', 'zingilt', $zingilt->name);

$viewattendees = has_capability('mod/zingilt:viewattendees', $context);
$signedup = zingilt_check_signup($zingilt->id);

if ($signedup and $signedup != $session->id) {
    print_error('error:signedupinothersession', 'zingilt', $returnurl);
}

echo $OUTPUT->box_start();
echo $OUTPUT->heading($heading);

$timenow = time();

if ($session->datetimeknown && zingilt_has_session_started($session, $timenow)) {
    $inprogressstr = get_string('cannotsignupsessioninprogress', 'zingilt');
    $overstr = get_string('cannotsignupsessionover', 'zingilt');

    $errorstring = zingilt_is_session_in_progress($session, $timenow) ? $inprogressstr : $overstr;

    echo html_writer::empty_tag('br') . $errorstring;
    echo $OUTPUT->box_end();
    echo $OUTPUT->footer($course);
    exit;
}

if (!$signedup && !zingilt_session_has_capacity($session, $context) && (!$session->allowoverbook)) {
    print_error('sessionisfull', 'zingilt', $returnurl);
    echo $OUTPUT->box_end();
    echo $OUTPUT->footer($course);
    exit;
}

echo zingilt_print_session($session, $viewattendees);

if ($signedup) {
    if (!($session->datetimeknown && zingilt_has_session_started($session, $timenow)) && $session->allowcancellations) {

        // Cancellation link.
        $cancellationurl = new moodle_url('cancelsignup.php', array('s' => $session->id, 'backtoallsessions' => $backtoallsessions));
        echo html_writer::link($cancellationurl, get_string('cancelbooking', 'zingilt'), array('title' => get_string('cancelbooking', 'zingilt')));
        echo ' &ndash; ';
    }

    // See attendees link.
    if ($viewattendees) {
        $attendeesurl = new moodle_url('attendees.php', array('s' => $session->id, 'backtoallsessions' => $backtoallsessions));
        echo html_writer::link($attendeesurl, get_string('seeattendees', 'zingilt'), array('title' => get_string('seeattendees', 'zingilt')));
    }

    echo html_writer::empty_tag('br') . html_writer::link($returnurl, get_string('goback', 'zingilt'), array('title' => get_string('goback', 'zingilt')));
} else if (zingilt_manager_needed($zingilt) && !zingilt_get_manageremail($USER->id)) {

    // Don't allow signup to proceed if a manager is required.
    // Check to see if the user has a managers email set.
    echo html_writer::tag('p', html_writer::tag('strong', get_string('error:manageremailaddressmissing', 'zingilt')));
    echo html_writer::empty_tag('br') . html_writer::link($returnurl, get_string('goback', 'zingilt'), array('title' => get_string('goback', 'zingilt')));

} else if (!has_capability('mod/zingilt:signup', $context)) {
    echo html_writer::tag('p', html_writer::tag('strong', get_string('error:nopermissiontosignup', 'zingilt')));
    echo html_writer::empty_tag('br') . html_writer::link($returnurl, get_string('goback', 'zingilt'), array('title' => get_string('goback', 'zingilt')));
} else {

    // Signup form.
    $mform->display();
}

echo $OUTPUT->box_end();
echo $OUTPUT->footer($course);
