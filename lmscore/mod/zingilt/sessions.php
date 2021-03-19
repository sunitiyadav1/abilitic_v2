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
require_once($CFG->dirroot . '/mod/zingilt/resourcemgmt/locallib.php');

$id = optional_param('id', 0, PARAM_INT); // Course Module ID.
$f = optional_param('f', 0, PARAM_INT); // zingilt Module ID.
$s = optional_param('s', 0, PARAM_INT); // zingilt session ID.
$c = optional_param('c', 0, PARAM_INT); // Copy session.
$d = optional_param('d', 0, PARAM_INT); // Delete session.
$confirm = optional_param('confirm', false, PARAM_BOOL); // Delete confirmation.

$nbdays = 1; // Default number to show.

$session = null;
if ($id && !$s) {
    if (!$cm = $DB->get_record('course_modules', array('id' => $id))) {
        print_error('error:incorrectcoursemoduleid', 'zingilt');
    }
    if (!$course = $DB->get_record('course', array('id' => $cm->course))) {
        print_error('error:coursemisconfigured', 'zingilt');
    }
    if (!$zingilt = $DB->get_record('zingilt', array('id' => $cm->instance))) {
        print_error('error:incorrectcoursemodule', 'zingilt');
    }
} else if ($s) {
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
        print_error('error:incorrectcoursemoduleid', 'zingilt');
    }

    $nbdays = count($session->sessiondates);
} else {
    if (!$zingilt = $DB->get_record('zingilt', array('id' => $f))) {
        print_error('error:incorrectzingiltid', 'zingilt');
    }
    if (!$course = $DB->get_record('course', array('id' => $zingilt->course))) {
        print_error('error:coursemisconfigured', 'zingilt');
    }
    if (!$cm = get_coursemodule_from_instance('zingilt', $zingilt->id, $course->id)) {
        print_error('error:incorrectcoursemoduleid', 'zingilt');
    }
}

require_course_login($course);
$errorstr = '';
$context = context_course::instance($course->id);
$modulecontext = context_module::instance($cm->id);
require_capability('mod/zingilt:editsessions', $context);

$PAGE->set_cm($cm);
$PAGE->set_url('/mod/zingilt/sessions.php', array('f' => $f));

$returnurl = "view.php?f=$zingilt->id";

$editoroptions = array(
    'noclean'  => false,
    'maxfiles' => EDITOR_UNLIMITED_FILES,
    'maxbytes' => $course->maxbytes,
    'context'  => $modulecontext,
);


// Handle deletions.
if ($d and $confirm) {
    if (!confirm_sesskey()) {
        print_error('confirmsesskeybad', 'error');
    }

    if (zingilt_delete_session($session)) {

        // Logging and events trigger.
        $params = array(
            'context'  => $modulecontext,
            'objectid' => $session->id
        );
        $event = \mod_zingilt\event\delete_session::create($params);
        $event->add_record_snapshot('zingilt_sessions', $session);
        $event->add_record_snapshot('zingilt', $zingilt);
        $event->trigger();
    } else {

        // Logging and events trigger.
        $params = array(
            'context'  => $modulecontext,
            'objectid' => $session->id
        );
        $event = \mod_zingilt\event\delete_session_failed::create($params);
        $event->add_record_snapshot('zingilt_sessions', $session);
        $event->add_record_snapshot('zingilt', $zingilt);
        $event->trigger();
        print_error('error:couldnotdeletesession', 'zingilt', $returnurl);
    }
    redirect($returnurl);
}

$customfields = zingilt_get_session_customfields();

$sessionid = isset($session->id) ? $session->id : 0;

$details = new stdClass();
$details->id = isset($session) ? $session->id : 0;
$details->details = isset($session->details) ? $session->details : '';
$details->detailsformat = FORMAT_HTML;
$details = file_prepare_standard_editor($details, 'details', $editoroptions, $modulecontext, 'mod_zingilt', 'session', $sessionid);

$mform = new mod_zingilt_session_form(null, compact('id', 'zingilt', 'f', 's', 'c', 'nbdays', 'customfields', 'course', 'editoroptions'));

if ($mform->is_cancelled()) {
    redirect($returnurl);
}

if ($fromform = $mform->get_data()) { // Form submitted.

    if (empty($fromform->submitbutton)) {
        print_error('error:unknownbuttonclicked', 'zingilt', $returnurl);
    }

    // Pre-process fields.
    if (empty($fromform->allowoverbook)) {
        $fromform->allowoverbook = 0;
    }
    if (empty($fromform->duration)) {
        $fromform->duration = 0;
    }
    if (empty($fromform->normalcost)) {
        $fromform->normalcost = 0;
    }
    if (empty($fromform->discountcost)) {
        $fromform->discountcost = 0;
    }

    $sessiondates = array();
    for ($i = 0; $i < $fromform->date_repeats; $i++) {
        if (!empty($fromform->datedelete[$i])) {
            continue; // Skip this date.
        }

        if (!empty($fromform->timestart[$i]) and !empty($fromform->timefinish[$i])) {
            $date = new stdClass();
            $date->timestart = $fromform->timestart[$i];
            $date->timefinish = $fromform->timefinish[$i];
            $sessiondates[] = $date;
        }
    }

    $todb = new stdClass();
    $todb->zingilt = $zingilt->id;
    $todb->name = $fromform->name;
    $todb->datetimeknown = true;
    $todb->capacity = $fromform->capacity;
    $todb->allowoverbook = $fromform->allowoverbook;
    $todb->duration = $fromform->duration;
    $todb->normalcost = $fromform->normalcost;
    $todb->discountcost = $fromform->discountcost;
    if (has_capability('mod/zingilt:configurecancellation', $context)) {
        $todb->allowcancellations = $fromform->allowcancellations;
    }
    $todb->trainer_id  = isset($fromform->trainer_id)?$fromform->trainer_id:0;
    /////#convert all the Resource Entries json to Startdate enddate wise json //////////////////////////////////
    $booking_data_json = json_decode($fromform->booking_data_json);
    if($booking_data_json != null && is_array($booking_data_json) && count($booking_data_json)>0){       
        $bs = array();
        $i =0;
        $a = array();
        foreach($booking_data_json as $bjs){            
            if(is_array($fromform->hidden_startdate) && count($fromform->hidden_startdate)>0){
                foreach($fromform->hidden_startdate as $k=>$sd){
                    if (!empty($fromform->datedelete[$k])) {
                        continue; // Skip this date.
                    }            
                    $a[$i] = new stdClass;
                    $a[$i]->hidden_startdate = $fromform->hidden_startdate[$k];
                    $a[$i]->hidden_enddate = $fromform->hidden_enddate[$k];
                    $a[$i] = (object) array_merge((array) $bjs, (array) $a[$i]);
                    $i++;
                }
            }
        }
        $fromform->new_booking_data_json = json_encode($a);
        $todb ->booking_data_json = $fromform->booking_data_json;
        $todb->new_booking_data_json = $fromform->new_booking_data_json;
    }
    ////////////////////////////////////////////////////////////////////////////////////////////////////

    // echo "<pre>";print_r($fromform);
    // //print_r($todb);
    // die;
    $sessionid = null;
   // $transaction = $DB->start_delegated_transaction();

    $update = false;
    if (!$c and $session != null) {
        $update = true;
        $sessionid = $session->id;

        $todb->id = $session->id;
        if (!zingilt_update_session($todb, $sessiondates)) {
           // $transaction->force_transaction_rollback();

            // Logging and events trigger.
            $params = array(
                'context'  => $modulecontext,
                'objectid' => $session->id
            );
            $event = \mod_zingilt\event\update_session_failed::create($params);
            $event->add_record_snapshot('zingilt_sessions', $session);
            $event->add_record_snapshot('zingilt', $zingilt);
            $event->trigger();
            print_error('error:couldnotupdatesession', 'zingilt', $returnurl);
        }

        // Remove old site-wide calendar entry.
        if (!zingilt_remove_session_from_calendar($session, SITEID)) {
         //   $transaction->force_transaction_rollback();
            print_error('error:couldnotupdatecalendar', 'zingilt', $returnurl);
        }
    } else {
        if (!$sessionid = zingilt_add_session($todb, $sessiondates)) {
          //  $transaction->force_transaction_rollback();

            // Logging and events trigger.
            $params = array(
                'context'  => $modulecontext,
                'objectid' => $zingilt->id
            );
            $event = \mod_zingilt\event\add_session_failed::create($params);
            $event->add_record_snapshot('zingilt', $zingilt);
            $event->trigger();
            print_error('error:couldnotaddsession', 'zingilt', $returnurl);
        }
    }

    foreach ($customfields as $field) {
        $fieldname = "custom_$field->shortname";
        if (!isset($fromform->$fieldname)) {
            $fromform->$fieldname = ''; // Need to be able to clear fields.
        }

        if (!zingilt_save_customfield_value($field->id, $fromform->$fieldname, $sessionid, 'session')) {
         //   $transaction->force_transaction_rollback();
            print_error('error:couldnotsavecustomfield', 'zingilt', $returnurl);
        }
    }

    // Save trainer roles.
    if (isset($fromform->trainerrole)) {
        zingilt_update_trainers($sessionid, $fromform->trainerrole);
    }
  ///////////////////////////////////////////////////
            /*  @author         :   Kajal Tailor
                @description    :   get all the Trainers from Resource Booking and Enrol/Unenrolment of course and session based on the cases.
                */
            // print_r($fromform);die;
            if ($fromform->booking_data_json != "") {
                $old_trainer_id = $todb->trainer_id;
                $booking_trainer_ids = manage_trainer_enrolment($fromform->booking_data_json, $course, $old_trainer_id, $sessionid, $sessiondates);
                if (!empty($sessionid) && !empty($booking_trainer_ids)) {
                    /*
                    $session_record->id         = $sessionid;
                    $session_record->trainer_id = $user->id;
                    print_r($session_record); exit();
                    $DB->update_record('zingilt_sessions', $session_record);
                    */
                }
                $sql = "UPDATE mdl_zingilt_sessions SET trainer_id = '" . $booking_trainer_ids . "' WHERE id=" . $sessionid;
                $DB->execute($sql);
                // Save trainer roles to all the trainers.
                // if (isset($fromform->trainerrole)) {

                if ($booking_trainer_ids != "") {
                    $trainerarr = array();
                    $trainers = explode(",", $booking_trainer_ids);
                    foreach ($trainers as $t) {
                        $trainerarr[TRAINER_ROLE_ID][$t] = $t;
                    }
                    //  }
                    // require_once("new.php");exit;
                    // $DB->commit_delegated_transaction($transaction);
                    zingilt_update_trainers($sessionid, $trainerarr);
                }
            };
            //  $transaction = $DB->start_delegated_transaction();
            //////////////////////////////////////////////////ends here   
    // Retrieve record that was just inserted/updated.
    if (!$session = zingilt_get_session($sessionid)) {
      //  $transaction->force_transaction_rollback();
        print_error('error:couldnotfindsession', 'zingilt', $returnurl);
    }

    // Update calendar entries.
    zingilt_update_calendar_entries($session, $zingilt);
    if ($update) {

        // Logging and events trigger.
        $params = array(
            'context'  => $modulecontext,
            'objectid' => $session->id
        );
        $event = \mod_zingilt\event\update_session::create($params);
        $event->add_record_snapshot('zingilt_sessions', $session);
        $event->add_record_snapshot('zingilt', $zingilt);
        $event->trigger();
    } else {

        // Logging and events trigger.
        $params = array(
            'context'  => $modulecontext,
            'objectid' => $session->id
        );
        $event = \mod_zingilt\event\add_session::create($params);
        $event->add_record_snapshot('zingilt_sessions', $session);
        $event->add_record_snapshot('zingilt', $zingilt);
        $event->trigger();
    }

    //$transaction->allow_commit();

    $data = file_postupdate_standard_editor($fromform, 'details', $editoroptions, $modulecontext, 'mod_zingilt', 'session', $session->id);
    $DB->set_field('zingilt_sessions', 'details', $data->details, array('id' => $session->id));

    redirect($returnurl);
} else if ($session != null) { // Edit mode.

    // Set values for the form.
    $toform = new stdClass();
    $toform = file_prepare_standard_editor($details, 'details', $editoroptions, $modulecontext, 'mod_zingilt', 'session', $session->id);
    $toform->name = $session->name;
    $toform->datetimeknown = true;// (1 == $session->datetimeknown);
    $toform->capacity = $session->capacity;
    $toform->allowoverbook = $session->allowoverbook;
    $toform->duration = $session->duration;
    $toform->normalcost = $session->normalcost;
    $toform->discountcost = $session->discountcost;
    if (has_capability('mod/zingilt:configurecancellation', $context)) {
        $toform->allowcancellations = $session->allowcancellations;
    }

    if ($session->sessiondates) {
        $i = 0;
        foreach ($session->sessiondates as $date) {
            $idfield = "sessiondateid[$i]";
            $timestartfield = "timestart[$i]";
            $timefinishfield = "timefinish[$i]";
            $toform->$idfield = $date->id;
            $toform->$timestartfield = $date->timestart;
            $toform->$timefinishfield = $date->timefinish;
            $i++;
        }
    }

    foreach ($customfields as $field) {
        $fieldname = "custom_$field->shortname";
        $toform->$fieldname = zingilt_get_customfield_value($field, $session->id, 'session');
    }

    $mform->set_data($toform);
}

if ($c) {
    $heading = get_string('copyingsession', 'zingilt', $zingilt->name);
} else if ($d) {
    $heading = get_string('deletingsession', 'zingilt', $zingilt->name);
} else if ($id || $f) {
    $heading = get_string('addingsession', 'zingilt', $zingilt->name);
} else {
    $heading = get_string('editingsession', 'zingilt', $zingilt->name);
}

$pagetitle = format_string($zingilt->name);


$PAGE->set_title($pagetitle);
$PAGE->set_heading($course->fullname);

echo $OUTPUT->header();

echo $OUTPUT->box_start();
echo $OUTPUT->heading($heading);

if (!empty($errorstr)) {
    echo $OUTPUT->container(html_writer::tag('span', $errorstr, array('class' => 'errorstring')), array('class' => 'notifyproblem'));
}

if ($d) {
    $viewattendees = has_capability('mod/zingilt:viewattendees', $context);
    zingilt_print_session($session, $viewattendees);
    $optionsyes = array('sesskey' => sesskey(), 's' => $session->id, 'd' => 1, 'confirm' => 1);
    echo $OUTPUT->confirm(get_string('deletesessionconfirm', 'zingilt', format_string($zingilt->name)),
        new moodle_url('sessions.php', $optionsyes),
        new moodle_url($returnurl));
} else {
    $mform->display();
}

echo $OUTPUT->box_end();
echo $OUTPUT->footer($course);
