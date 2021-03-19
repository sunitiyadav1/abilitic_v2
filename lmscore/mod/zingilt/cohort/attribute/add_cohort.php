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

require_once(dirname(dirname(dirname(dirname(dirname(__FILE__))))) . '/config.php');
require_once($CFG->dirroot . '/mod/zingilt/lib.php');
require_once($CFG->dirroot . '/mod/zingilt/cohort/classes/cohort_form.php');
require_once($CFG->dirroot . '/mod/zingilt/cohort/classes/user_form.php');
require_once($CFG->dirroot . '/mod/zingilt/cohort/classes/attributevalue_form.php');
//die("here");
// Face-to-face session ID.
$s = required_param('s', PARAM_INT);
//echo $s;
$backtoallsessions = optional_param('backtoallsessions', 0, PARAM_INT); // Face-to-face activity to return to.

// Load data.
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


/*
 * Capability checks to see if the current user can view this page
 *
 * This page is a bit of a special case in this respect as there are four uses for this page.
 *
 * 1) Viewing attendee list
 *   - Requires mod/zingilt:viewattendees capability in the course
 *
 * 2) Viewing cancellation list
 *   - Requires mod/zingilt:viewcancellations capability in the course
 *
 * 3) Taking attendance
 *   - Requires mod/zingilt:takeattendance capabilities in the course
 */
$context = context_course::instance($course->id);
$contextmodule = context_module::instance($cm->id);
require_course_login($course);
// Actions the user can perform.
$canviewattendees = has_capability('mod/zingilt:viewattendees', $context);
$cantakeattendance = has_capability('mod/zingilt:takeattendance', $context);
$canviewcancellations = has_capability('mod/zingilt:viewcancellations', $context);
$canviewsession = $canviewattendees || $cantakeattendance || $canviewcancellations;


/*
 * Print page header
 */


$pagetitle = format_string($zingilt->name);

$PAGE->set_url('/mod/zingilt/cohort/user/add_cohort.php', array('s' => $s));
$PAGE->set_context($context);
$PAGE->set_cm($cm);
$PAGE->set_pagelayout('standard');
$PAGE->set_title($pagetitle);
$PAGE->set_heading($course->fullname);
$PAGE->requires->css(new moodle_url("/mod/zingilt/cohort/scripts/style.css"));
$PAGE->requires->js(new moodle_url("/mod/zingilt/cohort/scripts/jquery.min.js"));
//$PAGE->requires->css(new moodle_url("/mod/zingilt/cohort/scripts/jquery-select2/select2.min.css"));
//$PAGE->requires->js(new moodle_url("/mod/zingilt/cohort/scripts/jquery-select2/select2.min.js"));
//$PAGE->requires->js(new moodle_url("/mod/zingilt/cohort/scripts/jquery.validate.min.js"));

$PAGE->requires->js(new moodle_url("/mod/zingilt/cohort/scripts/customjs.js"));
$PAGE->requires->js(new moodle_url("/mod/zingilt/cohort/scripts/attrvaluejs.js"));
$link = "{$CFG->wwwroot}/mod/zingilt/cohort/user/add_cohort.php?s={$session->id}";
$mform = new mod_zingilt_cohort_form($link, array('s' => $session->id));
$uform = new mod_zingilt_user_form($link, array('s' => $session->id));
$avform = new mod_zingilt_attributevalue_form($link, array('s' => $session->id));
/*
 * Handle submitted data
 */
global $DB;

echo $OUTPUT->header();
echo $OUTPUT->box_start();
echo $OUTPUT->heading(format_string($zingilt->name));
if ($canviewsession) {
    echo zingilt_print_session_for_cohort($session, true);
    echo '  [ ' . html_writer::link(new moodle_url('/mod/zingilt/attendees.php',array("s"=>$session->id,"backtoallsessions"=>$session->zingilt)),
        //'../attendees.php?s=' . $session->id . '&backtoallsessions=' . $session->zingilt,
        get_string('attendees', 'zingilt'),
        array('title' => get_string('seeattendees', 'zingilt'))
    ) . ' ]';

    //}

    // Go back.
    $url = new moodle_url('/course/view.php', array('id' => $course->id));
    if ($backtoallsessions) {
        $url = new moodle_url('/mod/zingilt/view.php', array('f' => $zingilt->id, 'backtoallsessions' => $backtoallsessions));
    }

    echo '  [ ' . html_writer::link($url, get_string('goback', 'zingilt')) . ' ]';

    $heading = get_string("user_enrolment", "zingilt"); //get_string('attendees', 'zingilt')."-".
    echo $OUTPUT->heading($heading);
    //$mform->display();
    unset($_SESSION['sess_enrolment_msg']);
    echo '<div id="show_loader" style="display:none;"><img src="../scripts/loader.gif" height="100px" width="100px"></div>
<div class="container">  <ul class="tabs">
        <li class="tab-link current" data-tab="tab-1">By Users</li>
        <li class="tab-link" data-tab="tab-2">By Cohorts</li>
        <li class="tab-link" data-tab="tab-3">By Custom Criteria</li>
    </ul>

    <div id="tab-1" class="tab-content current">';
    echo $uform->display();
    echo '</div>
    <div id="tab-2" class="tab-content">';
    echo $mform->display();
    echo '</div>
    <div id="tab-3" class="tab-content">';
    echo $avform->display();
    echo '</div>    
    </div>

    ';
    /*
 * Print page footer
 */
    echo $OUTPUT->box_end();
    echo $OUTPUT->footer($course);
}
function zingilt_print_session_for_cohort($session, $showcapacity, $calendaroutput = false, $return = false, $hidesignup = false)
{
    global $CFG, $DB;

    $table = new html_table();
    $table->summary = get_string('sessionsdetailstablesummary', 'zingilt');
    $table->attributes['class'] = 'generaltable f2fsession';
    $table->align = array('right', 'left');
    if ($calendaroutput) {
        $table->tablealign = 'left';
    }

    $customfields = zingilt_get_session_customfields();
    $customdata = $DB->get_records('zingilt_session_data', array('sessionid' => $session->id), '', 'fieldid, data');
    foreach ($customfields as $field) {
        $data = '';
        if (!empty($customdata[$field->id])) {
            if (CUSTOMFIELD_TYPE_MULTISELECT == $field->type) {
                $values = explode(CUSTOMFIELD_DELIMITER, format_string($customdata[$field->id]->data));
                $data = implode(html_writer::empty_tag('br'), $values);
            } else {
                $data = format_string($customdata[$field->id]->data);
            }
        }
        $table->data[] = array(str_replace(' ', '&nbsp;', format_string($field->name)), $data);
    }

    $strdatetime = str_replace(' ', '&nbsp;', get_string('sessiondatetime', 'zingilt'));
    if ($session->datetimeknown) {
        $html = '';
        foreach ($session->sessiondates as $date) {
            if (!empty($html)) {
                $html .= html_writer::empty_tag('br');
            }
            $timestart = userdate($date->timestart, get_string('strftimedatetime'));
            $timefinish = userdate($date->timefinish, get_string('strftimedatetime'));
            $html .= "$timestart &ndash; $timefinish";
        }
        $table->data[] = array($strdatetime, $html);
    } else {
        $table->data[] = array($strdatetime, html_writer::tag('i', get_string('wait-listed', 'zingilt')));
    }

    $signupcount = zingilt_get_num_attendees($session->id);
    $placesleft = $session->capacity - $signupcount;

    if ($showcapacity) {
        if ($session->allowoverbook) {
            $table->data[] = array(get_string('capacity', 'zingilt'), $session->capacity . ' (' . strtolower(get_string('allowoverbook', 'zingilt')) . ')');
        } else {
            $table->data[] = array(get_string('capacity', 'zingilt'), $session->capacity);
        }
    } //else if (!$calendaroutput) {
    $table->data[] = array(get_string('seatsavailable', 'zingilt'), max(0, $placesleft));
    // $table->data[] = array('', ||get_string('seeattendees', 'zingilt'));
    //  }

    // Display requires approval notification.
    $zingilt = $DB->get_record('zingilt', array('id' => $session->zingilt));

    if ($zingilt->approvalreqd) {
        $table->data[] = array('', get_string('sessionrequiresmanagerapproval', 'zingilt'));
    }

    // Display waitlist notification.
    if (!$hidesignup && $session->allowoverbook && $placesleft < 1) {
        $table->data[] = array('', get_string('userwillbewaitlisted', 'zingilt'));
    }

    if (!empty($session->duration)) {
        $table->data[] = array(get_string('duration', 'zingilt'), zilt_format_duration($session->duration));
    }
    if (!empty($session->normalcost)) {
        $table->data[] = array(get_string('normalcost', 'zingilt'), format_cost($session->normalcost));
    }
    if (!empty($session->discountcost)) {
        $table->data[] = array(get_string('discountcost', 'zingilt'), format_cost($session->discountcost));
    }
    if (!empty($session->details)) {
        $details = clean_text($session->details, FORMAT_HTML);
        $table->data[] = array(get_string('details', 'zingilt'), $details);
    }


    // Display trainers.
    $trainerroles = zingilt_get_trainer_roles();

    if ($trainerroles) {

        // Get trainers.
        $trainers = zingilt_get_trainers($session->id);
        foreach ($trainerroles as $role => $rolename) {
            $rolename = $rolename->name;

            if (empty($trainers[$role])) {
                continue;
            }

            $trainernames = array();
            foreach ($trainers[$role] as $trainer) {
                $trainerurl = new moodle_url('/user/view.php', array('id' => $trainer->id));
                $trainernames[] = html_writer::link($trainerurl, fullname($trainer));
            }

            $table->data[] = array($rolename, implode(', ', $trainernames));
        }
    }

    return html_writer::table($table, $return);
}
