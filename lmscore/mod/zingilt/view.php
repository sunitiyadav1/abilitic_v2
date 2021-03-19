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
require_once('renderer.php');

global $DB, $OUTPUT;

$id = optional_param('id', 0, PARAM_INT); // Course Module ID.
$f = optional_param('f', 0, PARAM_INT); // zingilt ID.
$location = optional_param('location', '', PARAM_TEXT); // Location.
$download = optional_param('download', '', PARAM_ALPHA); // Download attendance.

if ($id) {
    if (!$cm = $DB->get_record('course_modules', array('id' => $id))) {
        print_error('error:incorrectcoursemoduleid', 'zingilt');
    }
    if (!$course = $DB->get_record('course', array('id' => $cm->course))) {
        print_error('error:coursemisconfigured', 'zingilt');
    }
    if (!$zingilt = $DB->get_record('zingilt', array('id' => $cm->instance))) {
        print_error('error:incorrectcoursemodule', 'zingilt');
    }
} else if ($f) {
    if (!$zingilt = $DB->get_record('zingilt', array('id' => $f))) {
        print_error('error:incorrectzingiltid', 'zingilt');
    }
    if (!$course = $DB->get_record('course', array('id' => $zingilt->course))) {
        print_error('error:coursemisconfigured', 'zingilt');
    }
    if (!$cm = get_coursemodule_from_instance('zingilt', $zingilt->id, $course->id)) {
        print_error('error:incorrectcoursemoduleid', 'zingilt');
    }
} else {
    print_error('error:mustspecifycoursemodulezingilt', 'zingilt');
}

$context = context_module::instance($cm->id);
$PAGE->set_url('/mod/zingilt/view.php', array('id' => $cm->id));
$PAGE->set_context($context);
$PAGE->set_cm($cm);
$PAGE->set_pagelayout('standard');

if (!empty($download)) {
    require_capability('mod/zingilt:viewattendees', $context);
    zingilt_download_attendance($zingilt->name, $zingilt->id, $location, $download);
    exit();
}

require_course_login($course, true, $cm);
require_capability('mod/zingilt:view', $context);

// Logging and events trigger.
$params = array(
    'context'  => $context,
    'objectid' => $zingilt->id
);
$event = \mod_zingilt\event\course_module_viewed::create($params);
$event->add_record_snapshot('course_modules', $cm);
$event->add_record_snapshot('course', $course);
$event->add_record_snapshot('zingilt', $zingilt);
$event->trigger();

$title = $course->shortname . ': ' . format_string($zingilt->name);

$PAGE->set_title($title);
$PAGE->set_heading($course->fullname);

$pagetitle = format_string($zingilt->name);

$ZILTrenderer = $PAGE->get_renderer('mod_zingilt');

$completion = new completion_info($course);
$completion->set_module_viewed($cm);

echo $OUTPUT->header();

if (empty($cm->visible) and !has_capability('mod/zingilt:viewemptyactivities', $context)) {
    notice(get_string('activityiscurrentlyhidden'));
}
echo $OUTPUT->box_start();
echo $OUTPUT->heading(get_string('allsessionsin', 'zingilt', $zingilt->name), 2);

if ($zingilt->intro) {
    echo $OUTPUT->box_start('generalbox', 'description');
    echo format_module_intro('zingilt', $zingilt, $cm->id);
    echo $OUTPUT->box_end();
} else {
    echo html_writer::empty_tag('br');
}
$locations = get_locations($zingilt->id);
if (count($locations) > 2) {
    echo html_writer::start_tag('form', array('action' => 'view.php', 'method' => 'get', 'class' => 'formlocation'));
    echo html_writer::start_tag('div');
    echo html_writer::empty_tag('input', array('type' => 'hidden', 'name' => 'f', 'value' => $zingilt->id));
    echo html_writer::select($locations, 'location', $location, '', array('onchange' => 'this.form.submit();'));
    echo html_writer::end_tag('div'). html_writer::end_tag('form');
}

print_session_list($course->id, $zingilt->id, $location);

if (has_capability('mod/zingilt:viewattendees', $context)) {
    echo $OUTPUT->heading(get_string('exportattendance', 'zingilt'));
    echo html_writer::start_tag('form', array('action' => 'view.php', 'method' => 'get'));
    echo html_writer::start_tag('div');
    echo html_writer::empty_tag('input', array('type' => 'hidden', 'name' => 'f', 'value' => $zingilt->id));
    echo get_string('format', 'zingilt') . '&nbsp;';
    $formats = array('excel' => get_string('excelformat', 'zingilt'),
                     'ods' => get_string('odsformat', 'zingilt'));
    echo html_writer::select($formats, 'download', 'excel', '');
    echo html_writer::empty_tag('input', array('type' => 'submit', 'value' => get_string('exporttofile', 'zingilt')));
    echo html_writer::end_tag('div'). html_writer::end_tag('form');
}

echo $OUTPUT->box_end();
echo $OUTPUT->footer($course);

function print_session_list($courseid, $zingiltid, $location) {
    global $CFG, $USER, $DB, $OUTPUT, $PAGE;

    $ZILTrenderer = $PAGE->get_renderer('mod_zingilt');

    $timenow = time();

    $context = context_course::instance($courseid);
    $viewattendees = has_capability('mod/zingilt:viewattendees', $context);
    $editsessions = has_capability('mod/zingilt:editsessions', $context);

    $bookedsession = null;
    if ($submissions = zingilt_get_user_submissions($zingiltid, $USER->id)) {
        $submission = array_shift($submissions);
        $bookedsession = $submission;
    }

    $customfields = zingilt_get_session_customfields();

    $upcomingarray = array();
    $previousarray = array();
    $upcomingtbdarray = array();

    if ($sessions = zingilt_get_sessions($zingiltid, $location) ) {
        foreach ($sessions as $session) {

            $sessionstarted = false;
            $sessionfull = false;
            $sessionwaitlisted = false;
            $isbookedsession = false;

            $sessiondata = $session;
            $sessiondata->bookedsession = $bookedsession;

            // Add custom fields to sessiondata.
            $customdata = $DB->get_records('zingilt_session_data', array('sessionid' => $session->id), '', 'fieldid, data');
            $sessiondata->customfielddata = $customdata;

            // Is session waitlisted.
            if (!$session->datetimeknown) {
                $sessionwaitlisted = true;
            }

            // Check if session is started.
            $sessionstarted = zingilt_has_session_started($session, $timenow);
            if ($session->datetimeknown && $sessionstarted && zingilt_is_session_in_progress($session, $timenow)) {
                $sessionstarted = true;
            } else if ($session->datetimeknown && $sessionstarted) {
                $sessionstarted = true;
            }

            // Put the row in the right table.
            if ($sessionstarted) {
                $previousarray[] = $sessiondata;
            } else if ($sessionwaitlisted) {
                $upcomingtbdarray[] = $sessiondata;
            } else { // Normal scheduled session.
                $upcomingarray[] = $sessiondata;
            }
        }
    }

    // Upcoming sessions.
    echo $OUTPUT->heading(get_string('upcomingsessions', 'zingilt'));
    if (empty($upcomingarray) && empty($upcomingtbdarray)) {
        print_string('noupcoming', 'zingilt');
    } else {
        $upcomingarray = array_merge($upcomingarray, $upcomingtbdarray);
        echo $ZILTrenderer->print_session_list_table($customfields, $upcomingarray, $viewattendees, $editsessions);
    }

    if ($editsessions) {
        $addsessionlink = html_writer::link(
            new moodle_url('sessions.php', array('f' => $zingiltid)),
            get_string('addsession', 'zingilt')
        );
        echo html_writer::tag('p', $addsessionlink);
        $addrcmlink = html_writer::link(
            new moodle_url('/mod/zingilt/resourcemgmt/index.php'),
            get_string('myresources', 'zingilt')
        );
        echo html_writer::tag('p', $addrcmlink);
    }

    // Previous sessions.
    if (!empty($previousarray)) {
        echo $OUTPUT->heading(get_string('previoussessions', 'zingilt'));
        echo $ZILTrenderer->print_session_list_table($customfields, $previousarray, $viewattendees, $editsessions);
    }
}

/**
 * Get zingilt locations
 *
 * @param   interger    $zingiltid
 * @return  array
 */
function get_locations($zingiltid) {
    global $CFG, $DB;

    $locationfieldid = $DB->get_field('zingilt_session_field', 'id', array('shortname' => 'location'));
    if (!$locationfieldid) {
        return array();
    }

    $sql = "SELECT DISTINCT d.data AS location
              FROM {zingilt} f
              JOIN {zingilt_sessions} s ON s.zingilt = f.id
              JOIN {zingilt_session_data} d ON d.sessionid = s.id
             WHERE f.id = ? AND d.fieldid = ?";

    if ($records = $DB->get_records_sql($sql, array($zingiltid, $locationfieldid))) {
        $locationmenu[''] = get_string('alllocations', 'zingilt');

        $i = 1;
        foreach ($records as $record) {
            $locationmenu[$record->location] = $record->location;
            $i++;
        }

        return $locationmenu;
    }

    return array();
}
