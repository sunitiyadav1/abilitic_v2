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
 * This file processes AJAX enrolment actions and returns JSON for the manual enrolments plugin
 *
 * The general idea behind this file is that any errors should throw exceptions
 * which will be returned and acted upon by the calling AJAX script.
 *
 * @package    enrol_manual
 * @copyright  2010 Sam Hemelryk
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

define('AJAX_SCRIPT', true);

require('../../config.php');
require_once($CFG->dirroot.'/enrol/locallib.php');
require_once($CFG->dirroot.'/group/lib.php');
require_once($CFG->dirroot.'/enrol/manual/locallib.php');
require_once($CFG->dirroot.'/cohort/lib.php');
require_once($CFG->dirroot . '/enrol/manual/classes/enrol_users_form.php');

/*
* @author     : Suniti Yadav
* description : Manual enrolment email notification when admin or manager enrols. Based on custom configuration settings.
*/

global $CFG, $USER; // SY

$id      = required_param('id', PARAM_INT); // Course id.
$action  = required_param('action', PARAM_ALPHANUMEXT);

$PAGE->set_url(new moodle_url('/enrol/ajax.php', array('id'=>$id, 'action'=>$action)));

$course   = $DB->get_record('course', array('id'=>$id), '*', MUST_EXIST);
$context  = context_course::instance($course->id, MUST_EXIST);

/* SY - code start */
$str_date = date('d M Y h:i:s a', $course->startdate);
$end_date = date('d M Y h:i:s a', $course->enddate); 

$roleid   = optional_param('roletoassign', null, PARAM_INT);
$course_link = $CFG->wwwroot."/course/view.php?id=".$course->id;

// $get_category      = $DB->get_record_sql("SELECT * FROM `mdl_course_categories` where id = '$course->category'");
// $get_category_name = $get_category->name;

$get_manual_enrl_email_noti_id    = 1; // Manual enrolment email notification ID
$get_config                       = $DB->get_record('custom_configurations', array('id' => $get_manual_enrl_email_noti_id), '*', MUST_EXIST);

if(empty($get_config))
{
    $set_config = 0;
}
else
{
    $set_config = $get_config->is_active;
}

function send_email_notification($get_user,$course,$str_date,$end_date,$course_link,$USER,$get_manual_enrl_email_noti_id)
{
    global $DB;

    $body    = "<p>Congratulations ".$get_user->firstname." ".$get_user->lastname." !! <br><br>
        You have been nominated by your <b> Manager ".$get_user->reporting_manager_name." </b> for the Course <b>".$course->fullname." </b> whose start date is <b> ".$str_date."</b> and end date is <b>".$end_date."</b> <br>
             <a href='".$course_link."'>Please click here to access the course. </a> <br>
            NOTE : [ To enter the course please click on the course in the Dashboard. ] <br>
            Happy Learning !! <br><br>
            Regards,<br>
            <i> Learning & Development Team </i></p>"; 

    $is_sent = email_to_user($get_user,$USER,'Enrollment Notification','The text of the message',$body);
    
    $rec_insert  = new stdClass();
    $rec_insert->userid_notified            = $get_user->id;
    $rec_insert->action_userid              = $USER->id;
    $rec_insert->is_email_sent              = empty($is_sent)?0:1;
    $rec_insert->action_userid_ip_address   = $_SERVER['REMOTE_ADDR'];
    $rec_insert->cust_config_id             = $get_manual_enrl_email_noti_id;
    $rec_insert->course_id                  = $course->id;

    //print_r($rec_insert); exit();

    $sql = "INSERT INTO `mdl_custom_configurations_logs` (`userid_notified`, `action_userid`, `action_userid_ip_address`, `is_email_sent`, `cust_config_id`, `course_id`) VALUES ('$rec_insert->userid_notified', '$rec_insert->action_userid', '$rec_insert->action_userid_ip_address', '$rec_insert->is_email_sent', '$rec_insert->cust_config_id', '$rec_insert->course_id')";
    $DB->execute($sql);

}
/* SY - code end */

if ($course->id == SITEID) {
    throw new moodle_exception('invalidcourse');
}

require_login($course);
require_capability('moodle/course:enrolreview', $context);
require_sesskey();

echo $OUTPUT->header(); // Send headers.

$manager = new course_enrolment_manager($PAGE, $course);

$outcome = new stdClass();
$outcome->success = true;
$outcome->response = new stdClass();
$outcome->error = '';

$searchanywhere = get_user_preferences('userselector_searchanywhere', false);

switch ($action) {
    case 'enrol':
        $enrolid = required_param('enrolid', PARAM_INT);
        $cohorts = $users = [];

        $userids = optional_param_array('userlist', [], PARAM_SEQUENCE);
        $userid = optional_param('userid', 0, PARAM_INT);
        /* Added by Kajal Tailor - Code for attribute value filter by enrolment */
        if(isset($_REQUEST['tabaction']) && $_REQUEST['tabaction'] =="enrol_av"){    
            if(isset($_REQUEST['uids']) && $_REQUEST['uids'] !=""){
                 $uids =json_decode($_REQUEST['uids']);
                 $userids = $uids;
             }
         }
        if ($userid) {
            $userids[] = $userid;
        }
        if ($userids) {
            foreach ($userids as $userid) {

                /* SY - Code */
                $get_user = $DB->get_record('user', array('id' => $userid), '*', MUST_EXIST);
                $users[]  = $get_user; 

                if($set_config == 1)
                {
                    send_email_notification($get_user,$course,$str_date,$end_date,$course_link,$USER,$get_manual_enrl_email_noti_id);
                }
                /* SY - code end */
            }
        }
        $cohortids = optional_param_array('cohortlist', [], PARAM_SEQUENCE);
        $cohortid = optional_param('cohortid', 0, PARAM_INT);
        if ($cohortid) {
            $cohortids[] = $cohortid;
        }
        if ($cohortids) {
            foreach ($cohortids as $cohortid) {
                $cohort = $DB->get_record('cohort', array('id' => $cohortid), '*', MUST_EXIST);
                if (!cohort_can_view_cohort($cohort, $context)) {
                    throw new enrol_ajax_exception('invalidenrolinstance'); // TODO error text!
                }
                $cohorts[] = $cohort;
            }
        }

        $roleid = optional_param('roletoassign', null, PARAM_INT);
        $duration = optional_param('duration', 0, PARAM_INT);
        $startdate = optional_param('startdate', 0, PARAM_INT);
        $recovergrades = optional_param('recovergrades', 0, PARAM_INT);
        $timeend = optional_param_array('timeend', [], PARAM_INT);

        if (empty($roleid)) {
            $roleid = null;
        }

        if (empty($startdate)) {
            if (!$startdate = get_config('enrol_manual', 'enrolstart')) {
                // Default to now if there is no system setting.
                $startdate = 4;
            }
        }

        switch($startdate) {
            case 2:
                $timestart = $course->startdate;
                break;
            case 4:
                // We mimic get_enrolled_sql round(time(), -2) but always floor as we want users to always access their
                // courses once they are enrolled.
                $timestart = intval(substr(time(), 0, 8) . '00') - 1;
                break;
            case 3:
            default:
                $today = time();
                $today = make_timestamp(date('Y', $today), date('m', $today), date('d', $today), 0, 0, 0);
                $timestart = $today;
                break;
        }
        if ($timeend) {
            $timeend = make_timestamp($timeend['year'], $timeend['month'], $timeend['day'], $timeend['hour'], $timeend['minute']);
        } else if ($duration <= 0) {
            $timeend = 0;
        } else {
            $timeend = $timestart + $duration;
        }

        $mform = new enrol_manual_enrol_users_form(null, (object)["context" => $context]);
        $userenroldata = [
                'startdate' => $timestart,
                'timeend' => $timeend,
        ];
        $mform->set_data($userenroldata);
        $validationerrors = $mform->validation($userenroldata, null);
        if (!empty($validationerrors)) {
            throw new enrol_ajax_exception('invalidenrolduration');
        }

        $instances = $manager->get_enrolment_instances();
        $plugins = $manager->get_enrolment_plugins(true); // Do not allow actions on disabled plugins.
        if (!array_key_exists($enrolid, $instances)) {
            throw new enrol_ajax_exception('invalidenrolinstance');
        }
        $instance = $instances[$enrolid];
        if (!isset($plugins[$instance->enrol])) {
            throw new enrol_ajax_exception('enrolnotpermitted');
        }
        $plugin = $plugins[$instance->enrol];
        if ($plugin->allow_enrol($instance) && has_capability('enrol/'.$plugin->get_name().':enrol', $context)) {
            
            foreach ($users as $user) {
                $plugin->enrol_user($instance, $user->id, $roleid, $timestart, $timeend, null, $recovergrades);
            }

            $counter = count($users);
            foreach ($cohorts as $cohort) {
                $totalenrolledusers = $plugin->enrol_cohort($instance, $cohort->id, $roleid, $timestart, $timeend, null, $recovergrades);
                $counter += $totalenrolledusers;

                /* SY - code start */
                $get_cohort_users = $DB->get_records_sql("SELECT cm.userid FROM `mdl_cohort` as c join mdl_cohort_members as cm on cm.cohortid = c.id where c.id = '$cohort->id'");
                
                if($set_config == 1)
                {
                    foreach ($get_cohort_users as $u) 
                    {
                        $get_user = $DB->get_record('user', array('id' => $u->userid), '*', MUST_EXIST);

                        send_email_notification($get_user,$course,$str_date,$end_date,$course_link,$USER,$get_manual_enrl_email_noti_id);
                    }
                }
                /* SY - code end */
            }
            // Display a notification message after the bulk user enrollment.
            if ($counter > 0) {
                \core\notification::info(get_string('totalenrolledusers', 'enrol', $counter));
            }
        } else {
            throw new enrol_ajax_exception('enrolnotpermitted');
        }
        $outcome->success = true;
        break;

    default:
        throw new enrol_ajax_exception('unknowajaxaction');
}

echo json_encode($outcome);
