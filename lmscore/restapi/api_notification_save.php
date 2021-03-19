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
 * Version details
 *
 * @package    local_lingk
 * @copyright  (C) 2018 Lingk Inc (http://www.lingk.io)
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
require_once '../config.php';
//require_once '../lib/moodlelib.php';
// require_once($CFG->dirroot.'/lib/moodlelib.php');
require_once($CFG->libdir.'/moodlelib.php');
require_once 'src/Mandrill.php'; //Not required with Composer
$mandrill = new Mandrill('nBzzc7slBBQ5uEMAPWU50g');


global $DB, $CFG, $SESSION, $USER;
//echo "http://" . $_SERVER['SERVER_NAME'];
$current_url = "https://" . $_SERVER['SERVER_NAME'] . $_SERVER['REQUEST_URI'];
$base_url    = explode('/restapi/api_function_new.php', $current_url);

$CFG = new stdClass();
// $CFG->dataroot    = '/usr/src/moodle/moodledata';
$CFG->cookiename  = 'MoodleSession';
$CFG->wwwroot     = $base_url[0]; // 'https://learn2.zinghr.com/hdfcbkintuat/lms';
$CFG->debug    = (E_ALL | E_STRICT); 
$CFG->debugdisplay  = 1;
$CFG->debugdeveloper= 1;
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: access");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Allow-Credentials: true");
header('Content-Type: application/json');
header("HTTP/1.0 200 Successfull operation");
// echo '=============+++++++';exit;
    $wsfunction = $_POST['wsfunction'];  
    $response = array();
    
   if ($wsfunction == "save_push_notification") {
      # code...
      $data = new stdClass;
      $data->txtsubject = isset($_POST['subject'])?$_POST['subject']:'';// = "Subject Text";
      $data->txtmessage = isset($_POST['message'])?$_POST['message']:'';// = "message text";
      $data->cohortids = (isset($_POST['cohortids']) && is_array($_POST['cohortids']))?$_POST['cohortids']:null;// = array();
      $data->userids = (isset($_POST['userids']) && is_array($_POST['userids']))?$_POST['userids']:null;// = array(); = array();
      $data->frequency = isset($_POST['frequency']) ?$_POST['frequency']:'I'; //'I'-immediately 'S' - Scheduled
      $data->scheduled_on = isset($_POST['schedule_date']) ? $_POST['schedule_date'] :date("Y-m-d H:i:s");
      $data->notification_type_id= (isset($_POST['notification_type']) && is_array($_POST['notification_type']))? $_POST['notification_type'] :array(2=>2);
      $data->timezone1 = isset($_POST['timezone'])?$_POST['timezone']:date_default_timezone_get();      
   //   print_r($data);
      if($data->txtsubject != '' && $data->txtmessage != '' && ($data->cohortids != null || $data->userids != null )
        && strlen($data->frequency) == 1 && validateDate($data->scheduled_on) == true && isValidTimezone($data->timezone1) == true  )
      {
       //print_r($data);  
        $data->scheduled_on = strtotime($data->scheduled_on);
        $arr = savePushNotification($data);
        echo $data = json_encode($arr);
        //die("save here");
      }
      else{
       if(strlen($data->frequency) != 1 || ($data->frequency!='I' && $data->frequency !='S'))
       {
            echo $data = json_encode(['status'=>0,'message'=>"Frequency Should be 'I' or 'S'"]);
       }
       elseif(validateDate($data->scheduled_on) != true){
            echo $data = json_encode(['status'=>0,'message'=>"Invalid Schedule Date Format(Format should be 'Y-m-d H:i:s')"]);
       }
       elseif(isValidTimezone($data->timezone1) != true )
       {
            echo $data = json_encode(['status'=>0,'message'=>'Invalid Timezone']);
       }
       else{
          echo $data = json_encode(['status'=>0,'message'=>'Wrong Parameter Format']);
       }
       // die("wrong parameters");
      }
/*
      if($data->txtsubject != '' && $data->txtmessage != '' && ($data->cohortids != null || $data->userids != null )){
        //print_r($data);  
        $arr = savePushNotification($data);
        echo $data = json_encode($arr);
      }
      else{
            echo $data = json_encode(['message'=>'Some parameters are missing ']);
        }
      die;*/
   


    }
    else{
         echo $data = json_encode(['status'=>0,'message'=>'Function Name Parameter wsfunction is missing']);
    }
    function validateDate($date, $format = 'Y-m-d H:i:s')
    {
        $d = DateTime::createFromFormat($format, $date);
        return $d && $d->format($format) == $date;
    }
    function isValidTimezone($timezone) {
  return in_array($timezone, timezone_identifiers_list());
}
    function savePushNotification($data)
    {
        global $DB;
        $title = $data->txtsubject;
        $message = $data->txtmessage;
        $cohortids = $data->cohortids;
        $userids = $data->userids;
        $frequency = $data->frequency;
        $scheduledate = $data->scheduled_on;
        $notification_type = $data->notification_type_id;
        //echo "<pre>";
        $date = new DateTime(date("Y-m-d H:i:s",$data->scheduled_on), new DateTimeZone($data->timezone1));
        //echo $date->format('Y-m-d H:i:sP') . "\n";
        $date->setTimezone(new DateTimeZone(date_default_timezone_get()));
        //echo $date->format('Y-m-d H:i:sP') . "\n";
        $data->scheduled_on = strtotime($date->format('Y-m-d H:i:sP'));
        $userlistids = array();
        $cnt = 0;
        if ($cohortids != null && is_array($cohortids)) {
            foreach ($cohortids as $c) {
                $sql = "Select userid from {cohort_members} where cohortid = " . $c;
                $userarr = $DB->get_records_sql($sql);
                if ($userarr != null) {
                    foreach ($userarr as $u) {
                        $userlistids[$u->userid]['user_id'] = $u->userid;
                        $userlistids[$u->userid]['cohort_id'] = $c;
                        $cnt++;
                    }
                }
            }
        }
        if ($userids != null && is_array($userids)) {
            foreach ($userids as $u) {
                $userlistids[$u]['user_id'] = $u;
        $userlistids[$u]['cohort_id'] = (isset($userlistids[$u]['cohort_id']) ? $userlistids[$u]['cohort_id'] : 0);
        $userlistids[$u]['player_id'] = null;
                $cnt++;
            }
        }
        if ($userlistids != null) {
            $ukeys = array_keys($userlistids);
            $sql = "select * from {push_notification} where status ='A' ";
            if ($ukeys != "") {
                $sql .= "AND user_id IN(" . implode(",", $ukeys) . ")";
            }
            $sql .= " order by user_id asc";
            $playerids = $DB->get_records_sql($sql);

            if ($playerids != null) {
                foreach ($playerids as $p) {
                    $userlistids[$p->user_id]['player_id'][] = $p->player_id;
                }
            } 
    //print_r($userlistids);
     // die();
            $refno = getReferenceNo();
            if ($notification_type != null) {
                foreach ($notification_type as $n) {
                    //for mobile /APP notification
                    if ($n == 2) {
                        foreach ($userlistids as $u) {
                            $noti = new stdClass;
                            $noti->reference_code = $refno;
                            $noti->frequency = $frequency;
                            $noti->schedule_time = $scheduledate;
                            $noti->timezone = ($data->timezone1!=null? $data->timezone1:date_default_timezone_get());
                            $noti->module_name = 'SCHEDULED';
                            $noti->message = $message;
                            $noti->title = $title;
                            $noti->status = 0;
                            $noti->response = '';
                            $noti->image = '';
                            $noti->deeplink = '';
                            $noti->config_count = 3;
                            $noti->tries_count = 0;
                            $noti->created_at = time();
                            $noti->updated_at = time();
                            $noti->notification_type = $n;
                            $noti->user_id = $u['user_id'];
                            $noti->cohort_id = $u['cohort_id'];
              
                            if ($u['player_id'] != null) {
                                foreach ($u['player_id'] as $p) {
                                    $noti1 = $noti;
                  $noti1->player_id = $p;
                  //print_r($noti1);
                //  echo "<HR>";
                  $id[] = $DB->insert_record('push_notification_log', $noti1);
                                }
                            } else {
                $noti1 = $noti;
                $noti1->player_id = null;
                
                //print_r($noti1);
                                $id[] = $DB->insert_record('push_notification_log', $noti1);
                            }
                        }
          }
          
                }
                $result['status'] = 1;
                $result['message'] = "Notification Log Created Successfully.";
                $result['result'] = $id;
            } else {
                $result['status'] = 0;
                $result['message'] = "No Notification Type Found.";
                $result['result'] = $id;
            }
        } else {
            $result['status'] = 0;
            $result['message'] = "No User Found.";
            $result['result'] = $id;
        }
        return $result;
    }
    function getReferenceNo()
    {
        global $DB;
        $random = substr(number_format(time() . rand(10 * 45, 100 * 98), 0, '', ''), 7, 14);
        //print_r(mt_rand(100000,999999));echo "<BR>";
        //print_r($random);
        //$refno =
        $sql = "select count(*) as cnt from {push_notification_log} where reference_code='" . $random . "'";
        $rec = $DB->get_record_sql($sql);
        if ($rec->cnt == 0) {
            return $random;
        } else {
            return getReferenceNo();
        }
    }
?>
