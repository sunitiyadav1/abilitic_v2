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
define('AJAX_SCRIPT', true);
define('NO_MOODLE_COOKIES', true);
require_once '../config.php';
require_once($CFG->libdir.'/moodlelib.php');
require_once 'src/Mandrill.php'; //Not required with Composer
$mandrill = new Mandrill('nBzzc7slBBQ5uEMAPWU50g');

global $DB, $CFG, $SESSION ,$USER;

$CFG = new stdClass();
$CFG->wwwroot  = 'https://learn.zinghr.com/datametica/lms';
$CFG->dataroot = '/var/www/datametica_lmsdata_live';
$CFG->cookiename = 'MoodleSession';
$sesskey = $USER->sesskey;

header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: access");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Allow-Credentials: true");
header('Content-Type: application/json');
header("HTTP/1.0 200 Successfull operation");
// echo '=============+++++++';exit;
    $wsfunction = $_POST['wsfunction'];  

    //print_r($sesskey); exit();

    $response = array();
	if($wsfunction == "get_trainer_sessions"){
        $wsToken       = $_POST['wsToken'];
        $employee_code = $_POST['employee_code'];
        $company_code  = $_POST['company_code'];
        $session_type  = $_POST['session_type'];
        $qry 		   = "";
        // print_r($session_type); //exit();

            if($wsToken != '' && $employee_code!= '' && $company_code != ''){ 
               $query_fetch_user = $DB->get_records_sql("SELECT u.id as userid FROM mdl_user_bulk as ub LEFT JOIN mdl_user as u ON ub.user_id = u.id LEFT JOIN mdl_external_tokens as et ON u.id = et.userid WHERE ub.employee_code = '$employee_code' && ub.company_code = '$company_code' && et.token = '$wsToken'");
                if(!empty($query_fetch_user)){
                    foreach($query_fetch_user as $rs_fetch_user)  {  
                        $fetch_user_data =  $rs_fetch_user;
                    }
                    $userid = $fetch_user_data->userid;
                    $ctime=time(); 

                    if($session_type === "past")
                    {
                    	$qry="SELECT e.id, e.name, e.description,e.courseid,e.instance,DATE_FORMAT(FROM_UNIXTIME(`timestart`), '%Y-%m-%d') as timestart,e.timemodified FROM  mdl_event as e WHERE (e.userid=$userid OR e.eventtype='facetofacesession') AND  DATE_FORMAT(FROM_UNIXTIME(`timestart`), '%Y-%m-%d') < DATE_FORMAT(CURRENT_TIMESTAMP, '%Y-%m-%d') ORDER BY e.timestart DESC";

                    }
                    else if($session_type === "present")
                    {
                    	// $qry="SELECT e.id, e.name, e.description,e.courseid,e.timestart, DATE_FORMAT(FROM_UNIXTIME(`timestart`), '%d-%m-%Y %h:%i:%s') as 'mod_timestart',e.timemodified FROM  mdl_event as e WHERE e.userid=$userid AND `timestart` = CURRENT_TIMESTAMP() ORDER BY e.timestart DESC";

                    	// $qry="SELECT e.id, e.name, e.description,e.courseid,DATE_FORMAT(FROM_UNIXTIME(`timestart`), '%Y-%m-%d') as timestart,e.timemodified FROM  mdl_event as e WHERE e.userid=$userid AND  DATE_FORMAT(FROM_UNIXTIME(`timestart`), '%Y-%m-%d') = DATE_FORMAT(CURRENT_TIMESTAMP, '%Y-%m-%d') ORDER BY e.timestart DESC";

                        $qry="SELECT e.id, e.name, e.description,e.courseid,e.instance,DATE_FORMAT(FROM_UNIXTIME(`timestart`), '%Y-%m-%d') as timestart,e.timemodified FROM  mdl_event as e WHERE (e.userid=$userid OR e.eventtype='facetofacesession') AND  DATE_FORMAT(FROM_UNIXTIME(`timestart`), '%Y-%m-%d') = DATE_FORMAT(CURRENT_TIMESTAMP, '%Y-%m-%d') ORDER BY e.timestart DESC";

                    }
                    else if($session_type === "future")
                    {
                    	// $qry="SELECT e.id, e.name, e.description,e.courseid,DATE_FORMAT(FROM_UNIXTIME(`timestart`), '%Y-%m-%d') as timestart,e.timemodified FROM  mdl_event as e WHERE e.userid=$userid AND  DATE_FORMAT(FROM_UNIXTIME(`timestart`), '%Y-%m-%d') > DATE_FORMAT(CURRENT_TIMESTAMP, '%Y-%m-%d') ORDER BY e.timestart DESC";

                        $qry="SELECT e.id, e.name, e.description,e.courseid,e.instance,DATE_FORMAT(FROM_UNIXTIME(`timestart`), '%Y-%m-%d') as timestart,e.timemodified FROM  mdl_event as e WHERE (e.userid=$userid OR e.eventtype='facetofacesession') AND  DATE_FORMAT(FROM_UNIXTIME(`timestart`), '%Y-%m-%d') > DATE_FORMAT(CURRENT_TIMESTAMP, '%Y-%m-%d') ORDER BY e.timestart DESC";
                    }
                    else
                    {
                    	$qry="SELECT e.id, e.name, e.description,e.courseid,DATE_FORMAT(FROM_UNIXTIME(`timestart`), '%Y-%m-%d') as timestart,e.timemodified FROM  mdl_event as e WHERE (e.userid=$userid OR e.eventtype='facetofacesession')  ORDER BY e.timestart DESC";
                    }

                    // echo $qry; exit();

					$query_fetch_event = $DB->get_records_sql($qry);

					$status    = 0;
                    $get_desc  = "";
                    
					$message="Session Not Available.";
			        foreach($query_fetch_event as $rs_fetch_event)
			        {
                        $get_desc   = strip_tags($rs_fetch_event->description);
                        $desc_assoc = explode("\n\n", $get_desc);
                        $dec_object = [];

                        foreach ($desc_assoc as $dkey => $dvalue) {
                            if($dvalue)
                            {
                                $desc_detail_assoc = explode("\n",trim($dvalue));
                                $dec_object[$desc_detail_assoc[0]] = $desc_detail_assoc[1];
                            }
                        }

						$rs_fetch_event->description=$dec_object;
			            $fetch_event_data[] =  $rs_fetch_event;
						$status=1;
						$message="Session Available.";
			        }
					$returndata['status']=$status;
					$returndata['message']=$message;
					$returndata['session']=$fetch_event_data;
					
			        echo $data = json_encode($returndata);
                }else{
               	   echo $data = json_encode(['Message'=>'Invalid Api Token']);
                }
            }else{
           	  echo $data = json_encode(['Message'=>'Parameters are missing']);
            }
    }else if($wsfunction == "get_trainer_facetoface_sessions1"){
        $wsToken       = $_POST['wsToken'];
        $employee_code = $_POST['employee_code'];
        $company_code  = $_POST['company_code'];
        $session_type  = $_POST['session_type'];
        $qry           = "";

            if($wsToken != '' && $employee_code!= '' && $company_code != '' && $session_type != ''){ 
               $query_fetch_user = $DB->get_records_sql("SELECT u.id as userid FROM mdl_user_bulk as ub LEFT JOIN mdl_user as u ON ub.user_id = u.id LEFT JOIN mdl_external_tokens as et ON u.id = et.userid WHERE ub.employee_code = '$employee_code' && ub.company_code = '$company_code' && et.token = '$wsToken'");
                if(!empty($query_fetch_user)){
                    foreach($query_fetch_user as $rs_fetch_user)  {  
                        $fetch_user_data =  $rs_fetch_user;
                    }
                    $userid = $fetch_user_data->userid;
                    $ctime=time(); 

                    if($session_type === "past")
                    {

                        $qry="SELECT fsd.id as facetofaceSessionDates, f.id as facetofaceId ,fs.id as facetofaceSession,fs.capacity, f.course, f.name, f.display, fsd.timestart, fsd.timefinish, GROUP_CONCAT(fsda.data) as loc_data, GROUP_CONCAT(fsf.name) as location_description, count(DISTINCT fss.userid) as joinies ,u.id,u.username,en.id,en.courseid,c.fullname
                            FROM `mdl_user` as u
                            JOIN mdl_user_enrolments as uen
                            ON uen.userid = u.id
                            JOIN mdl_enrol as en
                            ON en.id = uen.enrolid
                            JOIN mdl_course as c
                            On c.id = en.courseid
                            JOIN mdl_facetoface as f
                            ON f.course = c.id
                            JOIN mdl_facetoface_sessions as fs
                            ON fs.facetoface = f.id 
                            JOIN mdl_facetoface_sessions_dates as fsd
                            ON fsd.sessionid = fs.id 
                            JOIN mdl_facetoface_session_data as fsda
                            ON fsda.sessionid = fs.id 
                            JOIN mdl_facetoface_session_field as fsf
                            ON fsf.id = fsda.fieldid
                            JOIN mdl_facetoface_signups as fss
                            ON fss.sessionid = fs.id
                            WHERE u.id=$userid 
                            AND  DATE_FORMAT(FROM_UNIXTIME(fsd.timestart), '%Y-%m-%d') < DATE_FORMAT(CURRENT_TIMESTAMP, '%Y-%m-%d') 
                            GROUP BY fsd.timestart,fsd.timefinish,fsd.id, fs.id ,en.id
                            ORDER BY fsd.timestart DESC";


                    }
                    else if($session_type === "present")
                    {
                       $qry="SELECT fsd.id as facetofaceSessionDates, f.id as facetofaceId ,fs.id as facetofaceSession,fs.capacity, f.course,c.fullname, f.name, f.display, fsd.timestart, fsd.timefinish, GROUP_CONCAT(fsda.data) as loc_data, GROUP_CONCAT(fsf.name) as location_description, count(DISTINCT fss.userid) as joinies,en.id,en.courseid,c.fullname
                            FROM `mdl_user` as u
                            JOIN mdl_user_enrolments as uen
                            ON uen.userid = u.id
                            JOIN mdl_enrol as en
                            ON en.id = uen.enrolid
                            JOIN mdl_course as c
                            On c.id = en.courseid
                            JOIN mdl_facetoface as f
                            ON f.course = c.id
                            JOIN mdl_facetoface_sessions as fs
                            ON fs.facetoface = f.id 
                            JOIN mdl_facetoface_sessions_dates as fsd
                            ON fsd.sessionid = fs.id 
                            JOIN mdl_facetoface_session_data as fsda
                            ON fsda.sessionid = fs.id 
                            JOIN mdl_facetoface_session_field as fsf
                            ON fsf.id = fsda.fieldid
                            JOIN mdl_facetoface_signups as fss
                            ON fss.sessionid = fs.id
                            WHERE DATE_FORMAT(FROM_UNIXTIME(fsd.timestart), '%Y-%m-%d') < DATE_FORMAT(CURRENT_TIMESTAMP, '%Y-%m-%d') 
                            AND fss.userid = $userid
                            GROUP BY fsd.timestart,fsd.timefinish,fsd.id, fs.id ,en.id
                            ORDER BY fsd.timestart DESC";


                    }
                    else if($session_type === "future")
                    {
                       $qry="SELECT fsd.id as facetofaceSessionDates, f.id as facetofaceId ,fs.id as facetofaceSession,fs.capacity, f.course, f.name, f.display, fsd.timestart, fsd.timefinish, GROUP_CONCAT(fsda.data) as loc_data, GROUP_CONCAT(fsf.name) as location_description, count(DISTINCT fss.userid) as joinies ,u.id,u.username,en.id,en.courseid,c.fullname
                            FROM `mdl_user` as u
                            JOIN mdl_user_enrolments as uen
                            ON uen.userid = u.id
                            JOIN mdl_enrol as en
                            ON en.id = uen.enrolid
                            JOIN mdl_course as c
                            On c.id = en.courseid
                            JOIN mdl_facetoface as f
                            ON f.course = c.id
                            JOIN mdl_facetoface_sessions as fs
                            ON fs.facetoface = f.id 
                            JOIN mdl_facetoface_sessions_dates as fsd
                            ON fsd.sessionid = fs.id 
                            JOIN mdl_facetoface_session_data as fsda
                            ON fsda.sessionid = fs.id 
                            JOIN mdl_facetoface_session_field as fsf
                            ON fsf.id = fsda.fieldid
                            JOIN mdl_facetoface_signups as fss
                            ON fss.sessionid = fs.id
                            WHERE u.id=$userid 
                            AND  DATE_FORMAT(FROM_UNIXTIME(fsd.timestart), '%Y-%m-%d') < DATE_FORMAT(CURRENT_TIMESTAMP, '%Y-%m-%d') 
                            GROUP BY fsd.timestart,fsd.timefinish,fsd.id, fs.id ,en.id
                            ORDER BY fsd.timestart DESC";

                    }

                    $query_fetch_event = $DB->get_records_sql($qry);

                    $status    = 0;
                    $get_desc  = "";
                    
                    $message="Session Not Available.";
                    foreach($query_fetch_event as $rs_fetch)
                    {
                        $get_loc_data = explode(',', $rs_fetch->loc_data);
                        $get_loc_desc = explode(',', $rs_fetch->location_description);
                        $loc_details[$get_loc_desc[0]] = $get_loc_data[0];
                        $loc_details[$get_loc_desc[1]] = $get_loc_data[1];
                        $loc_details[$get_loc_desc[2]] = $get_loc_data[2];
                        $loc_details['user_id']        = $userid;
                        $fetch_array1       = json_decode(json_encode($rs_fetch), true);
                        $fetch_event_data[] = array_merge($fetch_array1,$loc_details);

                        $status=1;
                        $message="Session Available.";
                    }
                    $returndata['status']=$status;
                    $returndata['message']=$message;
                    $returndata['session']=$fetch_event_data;
                    
                    echo $data = json_encode($returndata);
                }else{
                   echo $data = json_encode(['Message'=>'Invalid Api Token']);
                }
            }else{
              echo $data = json_encode(['Message'=>'Parameters are missing']);
            }
    }else if($wsfunction == "get_trainer_facetoface_sessions_trainer"){
        $wsToken       = $_POST['wsToken'];
        $employee_code = $_POST['employee_code'];
        $company_code  = $_POST['company_code'];
        $session_type  = $_POST['session_type'];
        $status        = 0;
        $message       = "Session not Available.";
        $result        = [];
        $query_session = "";

            if($wsToken != '' && $employee_code!= '' && $company_code != '' && $session_type != ''){ 
               $query_fetch_user = $DB->get_records_sql("SELECT e.id,u.id as userid, u.email, e.instance FROM mdl_user_bulk as ub JOIN mdl_user as u ON ub.user_id = u.id LEFT JOIN mdl_external_tokens as et ON u.id = et.userid JOIN mdl_event as e ON e.userid = u.id
                WHERE ub.employee_code = '$employee_code' && ub.company_code = '$company_code' && et.token = '$wsToken' 
                AND e.instance != 0 AND ub.trainer = 1 GROUP BY e.instance" );

                if(!empty($query_fetch_user)){
                    $ctime         = time(); 
                    $output_data   = [];
                    foreach($query_fetch_user as $rs_fetch_user)  {  

                        $fetch_user_data =  $rs_fetch_user;
                        $userid          = $fetch_user_data->userid;
                        $user_email      = $fetch_user_data->email; //'t'; 
                        $facetoface_id   = $fetch_user_data->instance;

                        if($session_type === "past")
                        {

                            $query_session="SELECT fsd.id as facetofaceSessionDates, f.id as facetofaceId ,fs.id as facetofaceSession,fs.capacity, f.course, f.name, f.display, fsd.timestart, fsd.timefinish, GROUP_CONCAT(fsda.data) as loc_data, GROUP_CONCAT(fsf.name) as location_description
                                FROM mdl_facetoface as f
                                JOIN mdl_facetoface_sessions as fs
                                ON fs.facetoface = f.id 
                                JOIN mdl_facetoface_sessions_dates as fsd
                                ON fsd.sessionid = fs.id 
                                JOIN mdl_facetoface_session_data as fsda
                                ON fsda.sessionid = fs.id 
                                JOIN mdl_facetoface_session_field as fsf
                                ON fsf.id = fsda.fieldid
                                WHERE  f.id = $facetoface_id
                                AND CURRENT_TIMESTAMP > FROM_UNIXTIME(`timefinish`)
                                GROUP BY fsd.timestart,fsd.timefinish,fsd.id, fs.id
                                ORDER BY fsd.timestart DESC";


                        }
                        else if($session_type === "present")
                        {
                           $query_session="SELECT fsd.id as facetofaceSessionDates, f.id as facetofaceId ,fs.id as facetofaceSession,fs.capacity, f.course, f.name, f.display, fsd.timestart, fsd.timefinish, GROUP_CONCAT(fsda.data) as loc_data, GROUP_CONCAT(fsf.name) as location_description
                                FROM mdl_facetoface as f
                                JOIN mdl_facetoface_sessions as fs
                                ON fs.facetoface = f.id 
                                JOIN mdl_facetoface_sessions_dates as fsd
                                ON fsd.sessionid = fs.id 
                                JOIN mdl_facetoface_session_data as fsda
                                ON fsda.sessionid = fs.id 
                                JOIN mdl_facetoface_session_field as fsf
                                ON fsf.id = fsda.fieldid
                                WHERE  f.id = $facetoface_id
                                AND DATE_FORMAT(CURRENT_TIMESTAMP, '%Y-%m-%d %h:%i') >= DATE_FORMAT(FROM_UNIXTIME(`timestart`), '%Y-%m-%d %h:%i')
                                AND DATE_FORMAT(CURRENT_TIMESTAMP, '%Y-%m-%d %h:%i') <= DATE_FORMAT(FROM_UNIXTIME(`timefinish`), '%Y-%m-%d %h:%i')
                                GROUP BY fsd.timestart,fsd.timefinish,fsd.id, fs.id
                                ORDER BY fsd.timestart DESC";
                                

                        }
                        else if($session_type === "future")
                        {
                           $query_session="SELECT fsd.id as facetofaceSessionDates, f.id as facetofaceId ,fs.id as facetofaceSession,fs.capacity, f.course, f.name, f.display, fsd.timestart, fsd.timefinish, GROUP_CONCAT(fsda.data) as loc_data, GROUP_CONCAT(fsf.name) as location_description
                                FROM mdl_facetoface as f
                                JOIN mdl_facetoface_sessions as fs
                                ON fs.facetoface = f.id 
                                JOIN mdl_facetoface_sessions_dates as fsd
                                ON fsd.sessionid = fs.id 
                                JOIN mdl_facetoface_session_data as fsda
                                ON fsda.sessionid = fs.id 
                                JOIN mdl_facetoface_session_field as fsf
                                ON fsf.id = fsda.fieldid
                                WHERE  f.id = $facetoface_id
                                AND DATE_FORMAT(CURRENT_TIMESTAMP, '%Y-%m-%d %h:%i:%s') < DATE_FORMAT(FROM_UNIXTIME(`timestart`), '%Y-%m-%d %h:%i:%s')
                                AND DATE_FORMAT(CURRENT_TIMESTAMP, '%Y-%m-%d %h:%i:%s') < DATE_FORMAT(FROM_UNIXTIME(`timefinish`), '%Y-%m-%d %h:%i:%s')
                                GROUP BY fsd.timestart,fsd.timefinish,fsd.id, fs.id
                                ORDER BY fsd.timestart DESC";
                        }

                        $result = $DB->get_records_sql($query_session);
                        //print_r($result); exit();

                        if(count($result) > 0)
                        {   
                            foreach($result as $rs_fetch)
                            {  
                               /*
                                $get_loc_data = explode(',', $rs_fetch->loc_data);
                                $get_loc_desc = explode(',', $rs_fetch->location_description);
                                $loc_details[$get_loc_desc[0]] = $get_loc_data[0];
                                $loc_details[$get_loc_desc[1]] = $get_loc_data[1];
                                $loc_details[$get_loc_desc[2]] = $get_loc_data[2];
                                $loc_details['user_id']        = $userid;
                                $fetch_array1       = json_decode(json_encode($rs_fetch), true);
                                $fetch_event_data[] = array_merge($fetch_array1,$loc_details);
                                */

                                



                                $qry = "SELECT fsps.signupid,f.id,fs.id as f2fsessionid
                                        FROM mdl_facetoface as f
                                        JOIN mdl_facetoface_sessions as fs
                                        ON fs.facetoface = f.id 
                                        JOIN mdl_facetoface_sessions_dates as fsd
                                        ON fsd.sessionid = fs.id 
                                        JOIN mdl_facetoface_session_data as fsda
                                        ON fsda.sessionid = fs.id 
                                        JOIN mdl_facetoface_session_field as fsf
                                        ON fsf.id = fsda.fieldid
                                        JOIN mdl_facetoface_signups as fss
                                        ON fss.sessionid = fs.id
                                        JOIN mdl_facetoface_signups_status as fsps
                                        ON fsps.signupid = fss.id 
                                        JOIN mdl_user as u
                                        ON u.id = fss.userid
                                        left JOIN mdl_user_bulk as ub
                                        ON ub.user_id = u.id
                                        WHERE  f.id = $rs_fetch->facetofaceid
                                        AND fs.id = $rs_fetch->facetofacesession
                                        AND fsd.id = $rs_fetch->facetofacesessiondates
                                        AND fsps.statuscode IN (40,50,70)
                                        AND fsps.superceded = 1
                                        GROUP BY f.id,fsps.signupid 
                                        ORDER BY f.id DESC";

                                $fetch_attendee = $DB->get_records_sql($qry);

                                $jrqry = "SELECT t.start_time,t.end_time,j.file_name
                                        -- FROM mdl_journal as j
                                        -- JOIN mdl_training_session as t
                                        FROM mdl_training_session as t
                                        left JOIN mdl_journal as j
                                        ON t.journal_id = j.id 
                                        WHERE  t.facetoface_id = $rs_fetch->facetofaceid
                                        AND t.facetoface_sess_id = $rs_fetch->facetofacesession
                                        AND t.facetoface_sess_date_id = $rs_fetch->facetofacesessiondates";


                                $fetch_journal = $DB->get_record_sql($jrqry);


                                $additional_fields = [
                                    "user_id"   => $userid, 
                                    "type"      => $session_type, 
                                    "joinies"   => !empty($fetch_attendee) ? count($fetch_attendee) : null , 
                                    "journal_pdf_url"       => (!empty($fetch_journal) && !empty($fetch_journal->file_name)) ? 'http://learn.zinghr.com/bmai/assets/journal/'.$userid.'/'.$fetch_journal->file_name : null,
                                    "training_start_time"   => !empty($fetch_journal) ? $fetch_journal->start_time : null, 
                                    "training_end_time"     => !empty($fetch_journal) ? $fetch_journal->end_time : null
                                ];

                                if($rs_fetch->loc_data == null || $rs_fetch->location_description == null)
                                {
                                    $arr =  ["Location" => null,"Venue" => null,"Room" => null,"Trainer Name" => null, "Trainer's Email ID" => null];
                                }
                                else
                                {
                                    $get_loc_data   = explode(',', $rs_fetch->loc_data);
                                    $get_loc_desc   = explode(',', $rs_fetch->location_description);
                                    $arr            = array_combine($get_loc_desc, $get_loc_data);
                                }

                                if(in_array($user_email,$arr))
                                {
                                    $fetch_array1       = json_decode(json_encode($rs_fetch), true);
                                    $arr_mrg            = array_merge($fetch_array1,$arr);
                                    $fetch_event_data[] = array_merge($arr_mrg,$additional_fields);
                                }

                                
                                
                                $status=1;
                                $message="Session Available.";
                            }
                        }  
                        // else
                        // {
                        //     $status = 0;
                        //     $message ="Session data not available.";
                        // }

                    }
                    $returndata['status']  = $status;
                    $returndata['message'] = $message;
                    $returndata['session'] = $fetch_event_data;
                    
                    echo $data = json_encode($returndata);
                }else{
                   echo $data = json_encode(['Message'=>'Invalid Api Token']);
                }
            }else{
              echo $data = json_encode(['Message'=>'Parameters are missing']);
            }
    }else if($wsfunction == "get_trainer_facetoface_sessions"){
        $wsToken       = $_POST['wsToken'];
        $employee_code = $_POST['employee_code'];
        $company_code  = $_POST['company_code'];
        $session_type  = $_POST['session_type'];
        $status        = 0;
        $message       = "Session not Available.";
        $result        = [];
        $user_arr      = $CFG->bmasiteadmins;

        if($wsToken != '' && $employee_code!= '' && $company_code != '' && $session_type != ''){ 
          
            $query_fetch_user = $DB->get_record_sql("SELECT u.id as userid FROM mdl_user_bulk as ub JOIN mdl_user as u ON ub.user_id = u.id LEFT JOIN mdl_external_tokens as et ON u.id = et.userid WHERE ub.employee_code = '$employee_code' && ub.company_code = '$company_code' && et.token = '$wsToken'" );

            $userid = $query_fetch_user->userid;

            if(!empty($query_fetch_user)){
                $ctime         = time(); 
                $output_data   = [];
                $query_session = "";
                        
                $query_session .= "SELECT fsd.id as facetofaceSessionDates,e.instance, f.id as facetofaceId ,fs.id as facetofaceSession,fs.capacity, f.course, f.name, f.display, fsd.timestart, fsd.timefinish, GROUP_CONCAT(fsda.data) as loc_data, GROUP_CONCAT(fsf.name) as location_description
                        FROM mdl_event as e
                        join mdl_facetoface as f
                        on f.id = e.instance
                        JOIN mdl_facetoface_sessions as fs
                        ON fs.facetoface = f.id 
                        JOIN mdl_facetoface_sessions_dates as fsd
                        ON fsd.sessionid = fs.id 
                        JOIN mdl_facetoface_session_data as fsda
                        ON fsda.sessionid = fs.id 
                        JOIN mdl_facetoface_session_field as fsf
                        ON fsf.id = fsda.fieldid";

                if($session_type === "past")
                {
                    $query_session .= " WHERE DATE_FORMAT(CURRENT_TIMESTAMP, '%Y-%m-%d') > DATE_FORMAT(FROM_UNIXTIME(fsd.timestart), '%Y-%m-%d')";
                }
                else if($session_type === "present")
                {
                    $query_session .= " WHERE DATE_FORMAT(CURRENT_TIMESTAMP, '%Y-%m-%d') = DATE_FORMAT(FROM_UNIXTIME(fsd.timestart), '%Y-%m-%d')";
                }
                else if($session_type === "future")
                {
                    $query_session .= " WHERE DATE_FORMAT(CURRENT_TIMESTAMP, '%Y-%m-%d') < DATE_FORMAT(FROM_UNIXTIME(fsd.timestart), '%Y-%m-%d')";
                }

                if(!(in_array($userid, $user_arr)))
                {
                    $query_session .= "AND fs.trainer_id = '".$userid."'";
                }
                $query_session .= " GROUP BY fsd.timestart,fsd.timefinish,fsd.id, fs.id
                                    ORDER BY fsd.timestart DESC";

                //echo $query_session; exit();     
                $result = $DB->get_records_sql($query_session);
                // print_r($result); exit();
                        
                if(count($result) > 0)
                {   
                    foreach($result as $key=>$rs_fetch)
                    {  
                    	if($key===3) break;

                        $qry = "SELECT fsps.signupid,f.id,fs.id as f2fsessionid
                                FROM mdl_facetoface as f
                                JOIN mdl_facetoface_sessions as fs
                                ON fs.facetoface = f.id 
                                JOIN mdl_facetoface_sessions_dates as fsd
                                ON fsd.sessionid = fs.id 
                                JOIN mdl_facetoface_session_data as fsda
                                ON fsda.sessionid = fs.id 
                                JOIN mdl_facetoface_session_field as fsf
                                ON fsf.id = fsda.fieldid
                                JOIN mdl_facetoface_signups as fss
                                ON fss.sessionid = fs.id
                                JOIN mdl_facetoface_signups_status as fsps
                                ON fsps.signupid = fss.id 
                                JOIN mdl_user as u
                                ON u.id = fss.userid
                                left JOIN mdl_user_bulk as ub
                                ON ub.user_id = u.id
                                WHERE  f.id = $rs_fetch->facetofaceid
                                AND fs.id = $rs_fetch->facetofacesession
                                AND fsd.id = $rs_fetch->facetofacesessiondates
                                AND fsps.statuscode = 70
                                GROUP BY f.id,fsps.signupid 
                                ORDER BY f.id DESC";

                        $fetch_attendee = $DB->get_records_sql($qry);
                        //print_r($fetch_attendee); //exit();

                        $jrqry = "SELECT t.start_time,t.end_time,j.file_name
                                FROM mdl_training_session as t
                                left JOIN mdl_journal as j
                                ON t.journal_id = j.id 
                                WHERE  t.facetoface_id = $rs_fetch->facetofaceid
                                AND t.facetoface_sess_id = $rs_fetch->facetofacesession
                                AND t.facetoface_sess_date_id = $rs_fetch->facetofacesessiondates";


                        $fetch_journal = $DB->get_record_sql($jrqry);
                        //print_r($fetch_journal);
                        $training_status = 0;

                        if(!empty($fetch_journal))
                        {
                            if($fetch_journal->end_time == null && $fetch_journal->start_time != null)
                            {
                                $training_status = 1;
                            }
                            else
                            {
                                $training_status = 2;
                            }
                        }

                        $additional_fields = [
                            "user_id"   => $userid, 
                            "type"      => $session_type, 
                            "joinies"   => !empty($fetch_attendee) ? count($fetch_attendee) : null , 
                            "journal_pdf_url"       => (!empty($fetch_journal) && !empty($fetch_journal->file_name)) ? $CFG->wwwroot.'/assets/journal/'.$userid.'/'.$fetch_journal->file_name : null,
                            "training_status"   => $training_status
                        ];

                        //print_r($additional_fields);

                        if($rs_fetch->loc_data == null || $rs_fetch->location_description == null)
                        {
                            $arr =  ["Location" => null,"Venue" => null,"Room" => null,"Trainer's Employee Code" => null];
                        }
                        else
                        {
                            $get_loc_data   = explode(',', $rs_fetch->loc_data);
                            $get_loc_desc   = explode(',', $rs_fetch->location_description);

                            // $get_chunk_loc_data  = array_chunk($get_loc_data, 20); 
                            // $get_chunk_loc_desc  = array_chunk($get_loc_desc, 20); 
                            $get_chunk_loc_data  = array_unique($get_loc_data); 
                            print_r($get_chunk_loc_data);
                            $get_chunk_loc_desc  = array_unique($get_loc_desc); 
                            print_r($get_chunk_loc_desc);

                            /*
                            if(in_array("Location", $get_chunk_loc_desc[0]) == 0)
                            {
                            	array_push($get_chunk_loc_desc[0], "Location");
                            	array_push($get_chunk_loc_data[0], "null");
                            }
                            if(in_array("Venue", $get_chunk_loc_desc[0]) == 0)
                            {
                            	array_push($get_chunk_loc_desc[0], "Venue");
                            	array_push($get_chunk_loc_data[0], "null");
                            }
                            if(in_array("Room", $get_chunk_loc_desc[0]) == 0)
                            {
                            	array_push($get_chunk_loc_desc[0], "Room");
                            	array_push($get_chunk_loc_data[0], "null");
                            }
                            if(in_array("Trainer's Employee Code", $get_chunk_loc_desc[0]) == 0)
                            {
                                array_push($get_chunk_loc_desc[0], "Trainer's Employee Code");
                                array_push($get_chunk_loc_data[0], "null");
                            }
                             $arr            = array_combine($get_chunk_loc_desc[0], $get_chunk_loc_data[0]);
                            */

                            $arr            = array_combine($get_chunk_loc_desc, $get_chunk_loc_data);
                            print_r($arr);
                        }
                        $fetch_array1       = json_decode(json_encode($rs_fetch), true); 
                        $arr_mrg            = array_merge($fetch_array1,$arr);
                        $fetch_event_data[] = array_merge($arr_mrg,$additional_fields);
                        
                        // echo $key;
                        // print_r($get_loc_data);
                        // print_r($get_loc_desc);

                      //   if($key== 592)
                      //   {
                      //   	print_r($get_loc_data);
                      //       print_r($get_loc_desc);
                      //   	echo"fetch_array1"; print_r($fetch_array1); 
                    		// echo"arr"; print_r($arr);
                      //   	echo"arr_mrg"; print_r($arr_mrg);
                    		// echo"additional_fields"; print_r($additional_fields);
                      //   	echo"fetch_event_data"; print_r($fetch_event_data);
                      //   }

                        $status=1;
                        $message="Session Available.";
                    }
                }
                else
                {
                    $status  = 0;
                    $message = " Record not found.";
                }  
                    
                $returndata['status']  = $status;
                $returndata['message'] = $message;
                $returndata['session'] = $fetch_event_data;
                
                echo $data = json_encode($returndata);
            }else{
               echo $data = json_encode(['Message'=>'Invalid Api Token']);
            }
        }else{
          echo $data = json_encode(['Message'=>'Parameters are missing']);
        }
    }else if($wsfunction == "get_facetoface_signup_users_old"){
        
        $wsToken                = $_POST['wsToken'];
        $facetofaceId           = $_POST['facetoface_id'];
        $facetofacesession      = $_POST['facetofacesession'];
        $facetofacesessiondates = $_POST['facetofacesessiondates'];

        $fetch_event_data = [];
        $qry           = "";
        $status        = 0; 

        if($wsToken != '' && $facetofaceId!= ''){ 
             
            /*$qry = "SELECT f.id,u.id,u.firstname, u.lastname, u.email, ub.gender,fsps.signupid
                    FROM  mdl_facetoface as f
                    JOIN mdl_facetoface_sessions as fs
                    ON fs.facetoface = f.id 
                    JOIN mdl_facetoface_signups as fss
                    ON fss.sessionid = fs.id
                    JOIN mdl_facetoface_signups_status as fsps
                    ON fsps.signupid = fss.id 
                    JOIN mdl_user as u
                    ON u.id = fss.userid
                    left JOIN mdl_user_bulk as ub
                    ON ub.user_id = u.id
                    WHERE fs.id = $facetofaceId
                    AND fsps.statuscode IN (40,50,70)
                    AND fsps.superceded = 1"; */

            $qry = "SELECT f.id,u.id,u.firstname, u.lastname, u.email, ub.gender,fsps.id as signup_statusid,fsps.signupid,fs.id as f2fsessionid
                    FROM mdl_facetoface as f
                    JOIN mdl_facetoface_sessions as fs
                    ON fs.facetoface = f.id 
                    JOIN mdl_facetoface_sessions_dates as fsd
                    ON fsd.sessionid = fs.id 
                    JOIN mdl_facetoface_session_data as fsda
                    ON fsda.sessionid = fs.id 
                    JOIN mdl_facetoface_session_field as fsf
                    ON fsf.id = fsda.fieldid
                    JOIN mdl_facetoface_signups as fss
                    ON fss.sessionid = fs.id
                    JOIN mdl_facetoface_signups_status as fsps
                    ON fsps.signupid = fss.id 
                    JOIN mdl_user as u
                    ON u.id = fss.userid
                    left JOIN mdl_user_bulk as ub
                    ON ub.user_id = u.id
                    WHERE  f.id = $facetofaceId
                    AND fs.id = $facetofacesession
                    AND fsd.id = $facetofacesessiondates
                    AND fsps.statuscode IN (40,50,70)
                    AND fsps.superceded = 1
                    GROUP BY f.id,fsps.signupid 
                    ORDER BY f.id DESC";

            //print_r($qry); exit();

            $query_fetch_event  = $DB->get_records_sql($qry);
            $message            = "No users have signed-up for this session.";
            $attendance         = 'N';

            foreach($query_fetch_event as $rs_fetch_event)
            {
                $get_attendance = $DB->get_record_sql("SELECT * from mdl_facetoface_signups_status where signupid = '$rs_fetch_event->signupid' and superceded = '0' ");

                if(!empty($get_attendance))
                {
                    if($get_attendance->statuscode == 80)
                    {
                        $attendance = 'A';
                    }
                    else if($get_attendance->statuscode == 100)
                    {
                        $attendance = 'P';
                    }
                }

                $rs_fetch_event->attendance = $attendance;
                $fetch_event_data[] = $rs_fetch_event;
                $status=1;
                $message="Users have signed-up for this session.";
            }
            $returndata['status']=$status;
            $returndata['message']=$message;
            $returndata['session']=$fetch_event_data;
            
            echo $data = json_encode($returndata);
        }
    }else if($wsfunction == "get_course_facetoface"){
        $wsToken       = $_POST['wsToken'];
        $employee_code = $_POST['employee_code'];
        $company_code  = $_POST['company_code'];
        $courseid      = $_POST['courseid'];
        $qry           = "";
        $status        = 0;
        $message       = "Facetoface not found for this course.";
        $fetch_event_data = [];

            if($wsToken != '' && $employee_code!= '' && $company_code != '' && $courseid != ''){ 
               $query_fetch_user = $DB->get_record_sql("SELECT u.id as userid FROM mdl_user_bulk as ub LEFT JOIN mdl_user as u ON ub.user_id = u.id LEFT JOIN mdl_external_tokens as et ON u.id = et.userid WHERE ub.employee_code = '$employee_code' && ub.company_code = '$company_code' && et.token = '$wsToken'");
                
                if(!empty($query_fetch_user)){
                    
                    $userid = $query_fetch_user->userid;
                    $ctime  = time(); 

                    $qry = "SELECT f.id,f.name
                            FROM mdl_course as c
                            JOIN mdl_facetoface as f
                            ON f.course = c.id
                            WHERE c.id = $courseid";

                    $query_fetch_event = $DB->get_records_sql($qry); //print_r($query_fetch_event); exit();

                    if(!empty($query_fetch_event)){

                        foreach($query_fetch_event as $rs_fetch)
                        {  
                            $fetch_event_data[] = $rs_fetch;
                        }

                        $status  = 1;
                        $message = "Facetoface is available for this course.";
                    }

                    $returndata['status']       = $status;
                    $returndata['message']      = $message;
                    $returndata['facetoface']   = $fetch_event_data;
                    
                    echo $data = json_encode($returndata);
                }else{
                   echo $data = json_encode(['Message'=>'Invalid Api Token']);
                }
            }else{
              echo $data = json_encode(['Message'=>'Parameters are missing']);
            }
    }else if($wsfunction == "get_course_facetoface_session"){
        $facetoface_id = $_POST['facetoface_id'];
        $userid        = $_POST['userid'];
        $qry           = "";
        $flag_signup   = 0;
        $status        = 0;
        $message       = "Facetoface sessions not found for this course.";
        $fetch_event_data = [];

        if($facetoface_id != '' && $userid != ''){ 

            $query  = " SELECT fsd.id as facetofaceSessionDatesId, fs.facetoface as facetofaceId ,fs.id as facetofaceSessionId,fs.capacity, fsd.timestart, fsd.timefinish, GROUP_CONCAT(fsda.data) as loc_data, GROUP_CONCAT(fsf.name) as location_description, count(DISTINCT fss.userid) as joinies
                        FROM mdl_facetoface_sessions as fs
                        LEFT JOIN mdl_facetoface_sessions_dates as fsd
                        ON fsd.sessionid = fs.id 
                        LEFT JOIN mdl_facetoface_session_data as fsda
                        ON fsda.sessionid = fs.id 
                        LEFT JOIN mdl_facetoface_session_field as fsf
                        ON fsf.id = fsda.fieldid
                        LEFT JOIN mdl_facetoface_signups as fss
                        ON fss.sessionid = fs.id
                        WHERE fs.facetoface = $facetoface_id
                        GROUP BY fsd.timestart,fsd.timefinish,fsd.id, fs.id
                        ORDER BY fsd.timestart DESC ";

            $result  = $DB->get_records_sql($query); //print_r($result); exit();
            $count = 0;
            if(!empty($result)){

                foreach($result as $rs_fetch)
                {
                    //print_r($rs_fetch->facetofacesessionid);

                    $ftof_query  = "SELECT fsps.*
                                    FROM mdl_facetoface_signups as fsp
                                    JOIN mdl_facetoface_signups_status as fsps
                                    ON fsps.signupid = fsp.id 
                                    WHERE fsp.sessionid = $rs_fetch->facetofacesessionid 
                                    AND fsp.userid = $userid 
                                    AND fsps.statuscode = 70";
                    //echo $ftof_query; //exit();

                    $ftof_result  = $DB->get_records_sql($ftof_query); //print_r($ftof_result); exit();
                    if(!empty($result)){
                        $count++;
                    }

                    if($rs_fetch->loc_data == null || $rs_fetch->location_description == null)
                    {
                        $arr =  ["Location" => null,"Venue" => null,"Room" => null,"Trainer's Employee Code" => null];
                    }
                    else
                    {
                        $get_loc_data   = explode(',', $rs_fetch->loc_data);
                        $get_loc_desc   = explode(',', $rs_fetch->location_description);

                        $get_chunk_loc_data  = array_chunk($get_loc_data, 20); 
                        $get_chunk_loc_desc  = array_chunk($get_loc_desc, 20); 

                        if(in_array("Location", $get_chunk_loc_desc[0]) == 0)
                        {
                            array_push($get_chunk_loc_desc[0], "Location");
                            array_push($get_chunk_loc_data[0], "null");
                        }
                        if(in_array("Venue", $get_chunk_loc_desc[0]) == 0)
                        {
                            array_push($get_chunk_loc_desc[0], "Venue");
                            array_push($get_chunk_loc_data[0], "null");
                        }
                        if(in_array("Room", $get_chunk_loc_desc[0]) == 0)
                        {
                            array_push($get_chunk_loc_desc[0], "Room");
                            array_push($get_chunk_loc_data[0], "null");
                        }
                        if(in_array("Trainer's Employee Code", $get_chunk_loc_desc[0]) == 0)
                        {
                            array_push($get_chunk_loc_desc[0], "Trainer's Employee Code");
                            array_push($get_chunk_loc_data[0], "null");
                        }

                        $arr            = array_combine($get_chunk_loc_desc[0], $get_chunk_loc_data[0]);
                    }
                    $fetch_array1       = json_decode(json_encode($rs_fetch), true); 
                    $arr_mrg            = array_merge($fetch_array1,$arr);
                    // $fetch_event_data[] = array_merge($arr_mrg,$additional_fields);
                    $fetch_event_data[] = $arr_mrg;
                }

                if($count > 0)
                {
                    $show_signup = 0;
                }
                else
                {
                    $show_signup = 1;
                }

                $status  = 1;
                $message = "Facetoface sessions is available for this course.";
            }
            
            $returndata['status']       = $status;
            $returndata['message']      = $message;
            $returndata['facetoface']   = $fetch_event_data;
            $returndata['show_signup']  = $show_signup;
            
            echo $data = json_encode($returndata);
            
        }else{
          echo $data = json_encode(['Message'=>'Parameters are missing']);
        }
    }else if($wsfunction == "facetoface_session_signup"){
        $session_id    = $_POST['facetoface_session_id'];
        $userid        = $_POST['userid'];
        $courseid      = $_POST['courseid'];
        $timestart     = $_POST['timestart'];
        $timefinish    = $_POST['timefinish'];
        $room          = $_POST['room'];
        $location      = $_POST['location'];
        $venue         = $_POST['venue'];

        $qry           = "";
        $status        = 0;
        $message       = "Please try again.";
        $fetch_event_data = [];

        if($session_id != '' && $userid != ''){ 

            $is_exist = $DB->get_record_sql("SELECT * FROM `mdl_facetoface_signups` as fs join mdl_facetoface_signups_status as fss on fs.id = fss.signupid WHERE fs.sessionid = '$session_id' and fs.userid = '$userid' ");

            if(empty($is_exist))
            {
                /*
                $rec_insert = new stdClass();
                $rec_insert->sessionid      = $session_id;
                $rec_insert->userid         = $userid;
                $rec_insert->mailedreminder = 0;
                $rec_insert->discountcode   = NULL;
                $rec_insert->notificationtype = 3;

                $result  = $DB->insert_record('facetoface_signups', $rec_insert, true);
                */

                $sql = 'INSERT INTO mdl_facetoface_signups(sessionid,userid,mailedreminder,discountcode,notificationtype) VALUES ('.$session_id.','.$userid.',0,NULL,3)';
                        //echo $sql; //exit();
                $DB->execute($sql);

                $get_signupid = $DB->get_record_sql("select id from mdl_facetoface_signups where sessionid = '$session_id' and userid = '$userid' ");

                /*
                $frec_insert = new stdClass();
                $frec_insert->signupid       = $result;
                $frec_insert->statuscode     = 40;
                $frec_insert->superceded     = 0;
                //grade, note, advice
                $frec_insert->createdby      = $userid;
                $frec_insert->timecreated    = time();

                $DB->insert_record('facetoface_signups_status', $frec_insert, true);
                */

                $sql = 'INSERT INTO mdl_facetoface_signups_status(signupid,statuscode,superceded,createdby,timecreated) VALUES ('.$get_signupid->id.',40,0,'.$userid.','.time().')';
                        //echo $sql; //exit();
                $DB->execute($sql);
                
                $query_fetch_user = $DB->get_record_sql(" SELECT u.*,ub.managersemail,ub.reporting_manager_id,au.email as manager_email,CONCAT(au.firstname, ' ', au.lastname) AS manager_name,aau.email as rep_manager_email,CONCAT(aau.firstname, ' ', aau.lastname) AS rep_manager_name 
                            FROM `mdl_user` as u 
                            left join `mdl_user_bulk` as ub on u.id = ub.user_id 
                            left JOIN `mdl_user` as au ON ub.managersemail = au.email 
                            left JOIN `mdl_user` as aau ON ub.reporting_manager_id = aau.id
                            WHERE u.id = '$userid'");

                $managers_email = $query_fetch_user->managersemail;
                $get_course     = $DB->get_record('course',array('id' => $courseid));
                $portal_link    = "https://portal.zinghr.ae/2015/pages/authentication/bma.htm";
                 
                $messagehtml = "<p> Dear ".$query_fetch_user->manager_name.",<br><br> 
                Your Associate ".$query_fetch_user->firstname." ".$query_fetch_user->lastname." has nominated himself/herself for attending the Course <b>".$get_course->fullname."</b>.Training Event Scheduled On ".$timestart." to ".$timefinish." at <br>
                Location    : ".$location." <br> 
                Venue       : ".$venue." <br> 
                Room        : ".$room." <br>
                Kindly click on the link to approve / reject the same. <br> 
                ".$CFG->wwwroot."/mod/facetoface/attendees.php?s=".$session_id."#unapproved <br>
                To know more about the training program click here ".$portal_link." <br> [ NOTE : LMS link - ".$CFG->wwwroot."/course/view.php?name=".$get_course->shortname." ] <br>
                Happy Learning !!<br><br> 
                Regards,<br>
                <i>BMA Learning & Development Team </i> </p> ";

                $subject     = " Course booking  request for <b>".$get_course->fullname."</b>";
                 

                $message = new stdClass();
                $message->html = $messagehtml;
                $message->text = "Congrats";
                $message->subject = $subject;
                $message->from_email = "hris@bma.ae";
                $message->from_name  = "BMA Admin (via BMALearn)";
                $message->to = array(array("email" => $managers_email));
                //$message->to = array(array("email" => 'sunitineo@gmail.com'));
                $message->track_opens = true;

                $response = $mandrill->messages->send($message);
            
                $message = "Your booking request has been sent to your manager. You will receive a confirmation email once your request has been approved.";
                $status  = 1;
            }
            else
            {
                $message = "You have already signed up for this session.";
                $status  = 1;
            }
            
            $returndata['status']  = $status;
            $returndata['message'] = $message;
            echo $data = json_encode($returndata);
        }else{
          echo $data = json_encode(['Message'=>'Parameters are missing']);
        }
    }else if($wsfunction == "set_gallery"){
        
        // $token               = $_POST['ws_token'];
        $facetoface_id       = $_POST['facetoface_id'];
        $facetoface_sess_id  = $_POST['facetoface_sess_id'];
        $facetoface_sess_date_id  = $_POST['facetoface_sess_date_id'];
        $user_id             = $_POST['user_id'];
        $file                = $_FILES['file'];
        $status              = 0; 
        $message             = "File not uploaded !!!";
        // $employee_code       = $_POST['employee_code'];
        // $company_code        = $_POST['company_code'];

        if($facetoface_id != '' && $facetoface_sess_id!= ''  && $facetoface_sess_date_id!= ''  && $user_id!= ''  && $file != ''){ 
             
            if($_FILES["file"]["error"] == UPLOAD_ERR_NO_FILE){
                $message = "Please, Select the file to upload!!!";
            }
            else{

                // ini_set('post_max_size', '2M');
                // ini_set('upload_max_filesize', '2M');

               $query_fetch_user = $DB->get_records_sql("SELECT u.* FROM mdl_user_bulk as ub JOIN mdl_user as u ON ub.user_id = u.id LEFT JOIN mdl_external_tokens as et ON u.id = et.userid WHERE u.id = '$user_id' limit 1");

               // print_r($query_fetch_user); exit();

                if(!empty($query_fetch_user)){

                    foreach($query_fetch_user as $rs_fetch_user)  { 
                        $fetch_user_data =  $rs_fetch_user;
                    }

                    $user = $fetch_user_data;
                    //print_r($user->username); //exit();

                    print_r(authenticate_user_login($user->id, null)); //exit();

                    print_r(complete_user_login($user)); exit();

                    if(complete_user_login($user))
                    {
                        if (!file_exists('/var/www/html/bmai/assets/img/'.$user_id)) {
                            mkdir('/var/www/html/bmai/assets/img/'.$user_id, 0777, true);
                        }
                        $file_get    = file_get_contents($_FILES["file"]["tmp_name"]);
                        

                        $is_uploaded = file_put_contents("/var/www/html/bmai/assets/img/".$user_id."/".$_FILES["file"]["name"],$file_get);

                        //print_r($is_uploaded); exit();
                        //$is_uploaded = move_uploaded_file($_FILES["file"]["tmp_name"], "/var/www/html/bmai/assets/img/".$user_id."/".$_FILES["file"]["name"]);
                        //$is_uploaded == 1

                        if($is_uploaded)
                        {
                            $rec_insert = new stdClass();
                            $rec_insert->facetoface_id      = $facetoface_id;
                            $rec_insert->facetoface_sess_id = $facetoface_sess_id;
                            $rec_insert->facetoface_sess_date_id= $facetoface_sess_date_id;
                            $rec_insert->user_id            = $user_id;
                            $rec_insert->pic_name           = $_FILES["file"]["name"];
                            $rec_insert->pic_type           = $_FILES["file"]["type"];

                            $result  = $DB->insert_record('upload_gallery', $rec_insert, true);
                            $message = "File uploaded successfully!!!";
                            $status  = 1;
                        }
                    }
                    else
                    {
                        $returndata['Message'] = "not login";
                    }
                    
                    $returndata['status']  = $status;
                    $returndata['message'] = $message;
                    echo $data = json_encode($returndata);

                }else{
                   echo $data = json_encode(['Message'=>'Invalid Api Token']);
                }
            }
        }
    }else if($wsfunction == "get_gallery"){
        
        $facetoface_id       = $_POST['facetoface_id'];
        $facetoface_sess_id  = $_POST['facetoface_sess_id'];
        $facetoface_sess_date_id  = $_POST['facetoface_sess_date_id'];
        $user_id             = $_POST['user_id'];
        $status              = 0; 

        if($facetoface_id != '' && $facetoface_sess_id!= ''  && $facetoface_sess_date_id!= ''  && $user_id!= ''){ 
             
            $qry =  "SELECT *
                    FROM mdl_upload_gallery as ug
                    WHERE ug.facetoface_id = $facetoface_id
                    AND ug.facetoface_sess_id = $facetoface_sess_id
                    AND ug.facetoface_sess_date_id= $facetoface_sess_date_id
                    AND ug.user_id = $user_id";

            $fetch_gallery = $DB->get_records_sql($qry);

            $message="Gallery not found for this session.";
            foreach($fetch_gallery as $rs_fetch)
            {
                $details['image_path'] = "https://learn.zinghr.com/bmai/assets/img/".$user_id."/".$rs_fetch->pic_name;
                $fetch_array1       = json_decode(json_encode($rs_fetch), true);
                $fetch_event_data[] = array_merge($fetch_array1,$details);
                $status=1;
                $message="Gallery found for this session.";
            }

            $returndata['status']  = $status;
            $returndata['message'] = $message;
            $returndata['result']  = $fetch_event_data;
            echo $data = json_encode($returndata);
        }
    }else if($wsfunction == "encrypt_algo"){
        
        $employee_code = $_POST['employee_code'];
        $company_code  = $_POST['company_code'];

        $max_msg_size  = 1000;
        $emp_message   = substr($employee_code, 0, $max_msg_size);
        $cmp_message   = substr($company_code, 0, $max_msg_size);
        $password      = 'sso';
        $salt          = sha1(mt_rand());
        $iv            = substr(sha1(mt_rand()), 0, 7);

        $emp_cd_encrypted = openssl_encrypt(
         "$emp_message", 'aes-256-cbc', "$salt:$employee_code", null, $iv
        );

        $com_cd_encrypted = openssl_encrypt(
         "$cmp_message", 'aes-256-cbc', "$salt:$company_code", null, $iv
        );

        $emp_cd_bundle = "$salt:$iv:$emp_cd_encrypted";
        $cmp_cd_bundle = "$salt:$iv:$com_cd_encrypted";
        $login_url     = "https://learn.zinghr.com/bmai/restapi/login.php?$emp_cd_bundle&$cmp_cd_bundle";

        echo $login_url; 
    }else if($wsfunction == "decrypt_algo"){
        
        $login_url = explode('?', $_POST['login_url']); 
        $get_code  = explode('&', $login_url[1]);

        $password     = 'sso';
        $emp_bundle   = $get_code[0]; 
        $cmp_bundle   = $get_code[1];

        $emp_components = explode( ':', $emp_bundle );
        $emp_salt          = $emp_components[0];
        $emp_iv            = $emp_components[1];
        $emp_encrypted_msg = $emp_components[2];

        $cmp_components = explode( ':', $cmp_bundle );

        $cmp_salt          = $cmp_components[0];
        $cmp_iv            = $cmp_components[1];
        $cmp_encrypted_msg = $cmp_components[2];

        $emp_decrypted_cd = openssl_decrypt(
          "$emp_encrypted_msg", 'aes-256-cbc', "$emp_salt:$password", null, $emp_iv
        );

        $cmp_decrypted_cd = openssl_decrypt(
          "$cmp_encrypted_msg", 'aes-256-cbc', "$cmp_salt:$password", null, $cmp_iv
        );

        if ( $emp_decrypted_cd === false || $cmp_decrypted_cd === false) {
          die("Unable to decrypt message! (check password) \n");
        }

        $msg = substr( $emp_decrypted_cd, 41 );
        echo "\n Employee Decrypted code: $emp_decrypted_cd <br>";
        echo "\n Company Decrypted code: $cmp_decrypted_cd \n";
    }else if($wsfunction == "set_training_start_time_old"){
        
        $facetoface_id       = $_POST['facetoface_id'];
        $facetoface_sess_id  = $_POST['facetoface_sess_id'];
        $facetoface_sess_date_id  = $_POST['facetoface_sess_date_id'];
        $user_id             = $_POST['user_id'];
        $status              = 0; 
        $message             = "Record already present!!!";

        if($facetoface_id != '' && $facetoface_sess_id!= ''  && $facetoface_sess_date_id!= ''  && $user_id!= ''){ 
             
            $get_training_sess = $DB->get_records_sql("SELECT count(*) from mdl_training_session where facetoface_id = '$facetoface_id' and facetoface_sess_id = '$facetoface_sess_id' and facetoface_sess_date_id = '$facetoface_sess_date_id' and user_id = '$user_id'");
            //print_r($get_training_sess); exit();

            if(empty($get_training_sess))
            {
                $rec_insert = new stdClass();
                $rec_insert->facetoface_id      = $facetoface_id;
                $rec_insert->facetoface_sess_id = $facetoface_sess_id;
                $rec_insert->facetoface_sess_date_id = $facetoface_sess_date_id;
                $rec_insert->user_id            = $user_id;
                $rec_insert->start_time         = date('Y-m-d H:i:s');
                $rec_insert->end_time           = date('Y-m-d H:i:s');

                $result  = $DB->insert_record('training_session', $rec_insert, true);
                
                $message = "Record inserted  successfully!!!";
                $status  = 1;
            }

            $returndata['status']  = $status;
            $returndata['message'] = $message;
            $returndata['result']  = $result;

        }
        else
        {
            $returndata['status']  = 0;
            $returndata['message'] = "Parameter Missing.";
            $returndata['result']  = null;
        }

        echo $data = json_encode($returndata);
    }else if($wsfunction == "get_trainees"){
        
        $facetoface_sess_id  = $_POST['facetoface_sess_id'];
        $status              = 0; 
        $message             = "Record not found successfully!!!";

        if($facetoface_sess_id!= ''){ 
             
            $get_trainees = $DB->get_records_sql("SELECT u.id,ub.employee_code,u.firstname,u.lastname,u.email FROM `mdl_facetoface_signups` as s join mdl_facetoface_signups_status as ss on s.id = ss.signupid left join mdl_user as u on u.id = s.userid left join mdl_user_bulk as ub on ub.user_id = u.id WHERE s.`sessionid` = '$facetoface_sess_id' and ss.statuscode = 100 and ss.superceded = 0");
           
            if(!empty($get_trainees))
            {   
                foreach ($get_trainees as $key => $value) {
                    $result[] = $value;
                }
                $message = "Record found successfully!!!";
                $status  = 1;
            }

            $returndata['status']  = $status;
            $returndata['message'] = $message;
            $returndata['result']  = $result;

        }
        else
        {
            $returndata['status']  = 0;
            $returndata['message'] = "Parameter Missing.";
            $returndata['result']  = null;
        }

        echo $data = json_encode($returndata);
    }else if($wsfunction == "set_training_start_time_olss"){
        
        $facetoface_id       = $_POST['facetoface_id'];
        $facetoface_sess_id  = $_POST['facetoface_sess_id'];
        $facetoface_sess_date_id  = $_POST['facetoface_sess_date_id'];
        $user_id             = $_POST['user_id'];
        $status              = 0; 
        $message             = "Record already present!!!";

        if($facetoface_id != '' && $facetoface_sess_id!= ''  && $facetoface_sess_date_id!= ''  && $user_id!= ''){ 
             
            $get_training_sess = $DB->get_record_sql("SELECT id from mdl_training_session where facetoface_id = '$facetoface_id' and facetoface_sess_id = '$facetoface_sess_id' and facetoface_sess_date_id = '$facetoface_sess_date_id' and user_id = '$user_id'");

            $query_signup = "SELECT * FROM `mdl_facetoface_signups` WHERE sessionid = ? AND userid = ?";
            $get_signup_id= $DB->get_record_sql($query_signup, array('sessionid' => $facetoface_sess_id, 'userid' => $user_id), $strictness=IGNORE_MISSING);

            //print_r($get_signup_id); exit();

            $query_signup_status = "SELECT * FROM `mdl_facetoface_signups_status` WHERE signupid = ? AND superceded = ? ORDER BY `id` DESC";
            $getcurrentstatus = $DB->get_record_sql($query_signup_status, array('signupid' => $get_signup_id->id, 'superceded' => 0), $strictness=IGNORE_MISSING);

            // print_r($getcurrentstatus); exit();

            if($getcurrentstatus->statuscode == 30)
            {
                $status_array = ['40' => '1','50' => '1','70' => '1','100' => '0'];
            }
            else if($getcurrentstatus->statuscode == 40)
            {
                $status_array = ['50' => '1','70' => '1','100' => '0'];
            }
            else if($getcurrentstatus->statuscode == 50)
            {
                $status_array = ['70' => '1','100' => '0'];
            }
            else if($getcurrentstatus->statuscode == 70)
            {
                $status_array = ['100' => '0'];
            }
            else if($getcurrentstatus->statuscode == 100)
            {
                $status_array = [];
            }
            else
            {
                $status_array = ['30' => '1', '40' => '1','50' => '1','70' => '1','100' => '0'];
            }

            if(count($status_array) > 0)
            {
                foreach ($status_array as $key => $value) {
                    $frec_insert = new stdClass();
                    $frec_insert->signupid       = $get_signup_id->id;
                    $frec_insert->statuscode     = $key;
                    $frec_insert->superceded     = $value;
                    //grade, note, advice
                    $frec_insert->createdby      = $user_id;
                    $frec_insert->timecreated    = time();
                    $DB->insert_record('facetoface_signups_status', $frec_insert);
                }
            }
           
            if(empty($get_training_sess) || count($get_training_sess) == 0)
            {
                $rec_insert = new stdClass();
                $rec_insert->facetoface_id      = $facetoface_id;
                $rec_insert->facetoface_sess_id = $facetoface_sess_id;
                $rec_insert->facetoface_sess_date_id = $facetoface_sess_date_id;
                $rec_insert->user_id            = $user_id;
                $rec_insert->start_time         = date('Y-m-d H:i:s');
                $rec_insert->journal_id         = 0;
                $result  = $DB->insert_record('training_session', $rec_insert, true);
                
                $message = "Record inserted  successfully!!!";
                $status  = 1;
            }
            else
            {
                $result = $get_training_sess->id;
            }

            $returndata['status']  = $status;
            $returndata['message'] = $message;
            $returndata['result']  = $result;

        }
        else
        {
            $returndata['status']  = 0;
            $returndata['message'] = "Parameter Missing.";
            $returndata['result']  = null;
        }

        echo $data = json_encode($returndata);
    }else if($wsfunction == "set_training_end_time"){
        
        $training_session    = $_POST['id'];
        $user_id             = $_POST['user_id'];
        //$courseid            = $_POST['course'];
        $course_name         = $_POST['course_name'];
        $file_name           = $_POST['file_name'];
        $status              = 0; 
        $message             = "Record not updated successfully!!!";

        if($training_session != ''){ 

            $sql    = "UPDATE mdl_training_session SET end_time = '".date('Y-m-d H:i:s')."' WHERE id=".$training_session;
            $result = $DB->execute($sql);

            if($result)
            {
                //$get_course     = $DB->get_record('course',array('id' => $courseid));
                $get_user       = $DB->get_record_sql("SELECT u.*,ub.managersemail,ub.reporting_manager_id,au.email as manager_email,CONCAT(au.firstname, ' ', au.lastname) AS manager_name,aau.email as rep_manager_email,CONCAT(aau.firstname, ' ', aau.lastname) AS rep_manager_name FROM `mdl_user` as u join `mdl_user_bulk` as ub on u.id = ub.user_id JOIN `mdl_user` as au ON ub.managersemail = au.email JOIN `mdl_user` as aau ON ub.reporting_manager_id = aau.id WHERE u.`id` = $user_id");

                $managers_email = $get_user->managersemail;
                $messagehtml    = "<p>Dear ".$get_user->manager_name.",<br> This is to notify that ".$get_user->firstname." ".$get_user->lastname." has completed the course facetoface training session name <b> ".$course_name." </b> <br> Click on the link to access the submitted journal by the trainer. <br> http://learn.zinghr.com/bmai/assets/journal/".$user_id."/".$file_name." <br> Happy Learning !! <br> Regards, <br> <i> BMA Learning & Development Team </i></p>";
                $subject    = "Facetoface training completion notification";
             

                $message = new stdClass();
                $message->html = $messagehtml;
                $message->text = "Congrats";
                $message->subject = $subject;
                $message->from_email = "hris@bma.ae";
                $message->from_name  = "Do not reply to this email (via BMALearn)";
                $message->to = array(array("email" => $managers_email));
                $message->track_opens = true;

                $response = $mandrill->messages->send($message);
                $message->to = array(array("email" => $get_user->email));
                $mandrill->messages->send($message);

                $message = "Record updated  successfully!!!";
                $status  = 1;
            }

            $returndata['status']  = $status;
            $returndata['message'] = $message;
        }
        else
        {
            $returndata['status']  = 0;
            $returndata['message'] = "Parameter Missing.";
        }

        echo $data = json_encode($returndata);
    }else if($wsfunction == "get_trainer_historical_sessions"){
        $wsToken       = $_POST['wsToken'];
        $employee_code = $_POST['employee_code'];
        $company_code  = $_POST['company_code'];
        $page_index    = $_POST['page_index'];
        $page_size     = 10;
        $qry           = "";
        $status        = 0;
        $message       = "No record found.";

        $limit  = ($page_index - 1) * $page_size ;
        $offset = $page_size; //$page_index * $page_size;

            if($wsToken != '' && $employee_code!= '' && $company_code != ''){ 
               $query_fetch_user = $DB->get_records_sql("SELECT u.id as userid FROM mdl_user_bulk as ub LEFT JOIN mdl_user as u ON ub.user_id = u.id LEFT JOIN mdl_external_tokens as et ON u.id = et.userid WHERE ub.employee_code = '$employee_code' && ub.company_code = '$company_code' && et.token = '$wsToken'");
               // print_r($query_fetch_user); exit();

                if(!empty($query_fetch_user)){
                    foreach($query_fetch_user as $rs_fetch_user)  {  
                        $fetch_user_data =  $rs_fetch_user;
                    }
                    $userid = $fetch_user_data->userid;
                    $ctime  = time();
                    $result = []; 

                    // $qry="SELECT cust_program_id,`program_name`,`trainer`,`session_start_date`,`session_end_date`,`session_duration`,count(`program_name`) as cnt FROM `mdl_new_historical_data` WHERE `trainer_id` = '$userid' GROUP by `program_name`,`trainer`,`session_start_date`,`session_end_date`,`session_duration` ORDER BY STR_TO_DATE(session_start_date, '%D %M %Y') DESC  LIMIT $limit, $offset";

                    $qry="SELECT id,cust_program_id,`program_name`,`trainer`,`session_start_date`,`session_end_date`,`session_duration`,count(`program_name`) as cnt FROM `mdl_new_historical_data` WHERE `trainer_id` = '$userid' GROUP by `program_name`,`trainer`,`session_start_date`,`session_end_date`,`session_duration` ORDER BY id DESC  LIMIT $limit, $offset";

                    $query_fetch_event = $DB->get_records_sql($qry);
                   /* MYsql issue for unique id
                    $count = 1;
                    foreach ($query_fetch_event as $key => $value) {
                        
                        $record->id              = $value->id;
                        $record->cust_program_id = $count;
                        $DB->update_record('new_historical_data', $record);
                        $count++;
                    }
                   */
                    if(!empty($query_fetch_event))
                    {
                        foreach ($query_fetch_event as $key => $value) {
                            $result[] = $value;
                        }

                        $status        = 1;
                        $message       = "Record found successfully.";
                    }

                    $returndata['status']  = $status;
                    $returndata['message'] = $message;
                    $returndata['session'] = $result;
                    
                    echo $data = json_encode($returndata);
                }else{
                   echo $data = json_encode(['Message'=>'Invalid Api Token']);
                }
            }else{
              echo $data = json_encode(['Message'=>'Parameters are missing']);
            }
    }else if($wsfunction == "set_journal_old"){
        //exit();
        $journal       = $_POST['journal'];
        $userid        = $_POST['userid'];
        $file          = $_FILES['file'];

        echo "here";
        print_r($userid);
        print_r($file);
        print_r($journal);
        
        exit();

        $qry           = "";
        $status        = 0;
        $file_result   = null;
        $message       = "No record found.";

        if($journal != ''){ 
           
            $get_journal = json_decode($journal);

            $record = new stdClass();
            $record->employee_code      = isset($get_journal->employee_code)?$get_journal->employee_code:null;
            $record->user_id            = isset($get_journal->user_id)?$get_journal->user_id:null;
            $record->facetofaceid       = isset($get_journal->facetofaceid)?$get_journal->facetofaceid:null;
            $record->facetofacesession  = isset($get_journal->facetofacesession)?$get_journal->facetofacesession:null;
            $record->token              = isset($get_journal->token)?$get_journal->token:null;
            $record->program_name       = isset($get_journal->program_name)?$get_journal->program_name:null;
            $record->trainer_name       = isset($get_journal->trainer_name)?$get_journal->trainer_name:null;
            $record->country            = isset($get_journal->country)?$get_journal->country:null;
            $record->region             = isset($get_journal->region)?$get_journal->region:null;
            $record->total_participants = isset($get_journal->total_participants)?$get_journal->total_participants:null;
            $record->session_date       = isset($get_journal->session_date)?date('Y-m-d',strtotime($get_journal->session_date)):null;
            $record->brand              = isset($get_journal->brand)?$get_journal->brand:null;
            $record->thirty_day_review  = isset($get_journal->thirty_day_review)?$get_journal->thirty_day_review:null;
            $record->sixty_day_review   = isset($get_journal->sixty_day_review)?$get_journal->sixty_day_review:null;
            $record->ninty_day_review   = isset($get_journal->ninty_day_review)?$get_journal->ninty_day_review:null;
            $record->trainees_participation = isset($get_journal->trainees_participation)?$get_journal->trainees_participation:null;
            $record->trainees_participation_comment = isset($get_journal->trainees_participation_comment)?$get_journal->trainees_participation_comment:null;
            $record->people_management_challenges_comment = isset($get_journal->people_management_challenges_comment)?$get_journal->people_management_challenges_comment:null;
            $record->star_performer_name    = isset($get_journal->star_performer_name)?$get_journal->star_performer_name:null;
            $record->star_performer_comment = isset($get_journal->star_performer_comment)?$get_journal->star_performer_comment:null;
            $record->low_performer_name     = isset($get_journal->low_performer_name)?$get_journal->low_performer_name:null;
            $record->low_performer_comment  = isset($get_journal->low_performer_comment)?$get_journal->low_performer_comment:null;
            $record->trainees_action_plan   = isset($get_journal->trainees_action_plan)?$get_journal->trainees_action_plan:null;
            $record->supervisor_action_plan = isset($get_journal->supervisor_action_plan)?$get_journal->supervisor_action_plan:null;
            $record->possible_challenges    = isset($get_journal->possible_challenges)?$get_journal->possible_challenges:null;
            //echo "<pre>"; print_r($record);

            if($_FILES['file'])
            {
                if (!file_exists('/var/www/html/bmai/assets/journal/'.$userid)) {
                    mkdir('/var/www/html/bmai/assets/journal/'.$userid, 0777, true);
                }
                $file_get    = file_get_contents($_FILES["file"]["tmp_name"]);

                //Add the allowed mime-type files to an 'allowed' array 
                $allowed = array('application/pdf');

                //Check uploaded file type is in the above array (therefore valid)  
                if(in_array($_FILES['file']['type'], $allowed)){

                   //If filetypes allowed types are found, continue to check filesize:
                   // if($_FILES["file"]["size"] < 800000 ){ //8kb

                        //if both files are below given size limit, allow upload
                        //Begin filemove here....

                        $is_uploaded = file_put_contents("/var/www/html/bmai/assets/journal/".$userid."/".$_FILES["file"]["name"],$file_get);

                        if($is_uploaded)
                        {
                            $record->file_name           = $_FILES["file"]["name"];
                            $record->file_type           = $_FILES["file"]["type"];
                            $file_result                 = $_FILES["file"]["name"];
                        }else{
                            $status        = 0;
                            $message       = "File not uploaded successfully.";
                        }

                    // }else{
                    //     $status        = 0;
                    //     $message       = "File size should be less than 8kb.";
                    // }

                }else{
                    $status        = 0;
                    $message       = "File type should be PDF only";
                }

            }

            $result      = $DB->insert_record('journal',$record);

            $hist_record = new stdClass();
            $hist_record->year    = isset($get_journal->session_date)?date('Y', strtotime($get_journal->session_date)):null;
            $hist_record->month   = isset($get_journal->session_date)?date("F", strtotime($get_journal->session_date)):null;
            $hist_record->country = $record->country;
            $hist_record->region  = $record->region;
            $hist_record->store_category  = isset($get_journal->store_category)?$get_journal->store_category:null;
            $hist_record->employee_status = isset($get_journal->employee_status)?$get_journal->employee_status:null;

            $hist_record->program_name    =  $record->program_name;
            $hist_record->program_category= isset($get_journal->program_category)?$get_journal->program_category:null;
            $hist_record->trainer_id      = isset($get_journal->user_id)?$get_journal->user_id:null;
            $hist_record->training_mandays= isset($get_journal->training_mandays)?$get_journal->training_mandays:null;
            $hist_record->session_start_date = $get_journal->session_start_date; // "30-May-16";
            $hist_record->session_end_date   = $get_journal->session_end_date; //"31-May-16";

            $date1 = strtotime($hist_record->session_end_date);
            $date2 = strtotime($hist_record->session_start_date); 
            $diff  = abs($date1 - $date2);
            
            $day    = $diff/(60*60*24); // in day
            $dayFix = floor($day);
            $dayPen = $day - $dayFix;
            if($dayPen > 0)
            {
                $hour = $dayPen*(24); // in hour (1 day = 24 hour)
                $hourFix = floor($hour);
                $hourPen = $hour - $hourFix;
                if($hourPen > 0)
                {
                    $min = $hourPen*(60); // in hour (1 hour = 60 min)
                    $minFix = floor($min);
                    $minPen = $min - $minFix;
                    if($minPen > 0)
                    {
                        $sec = $minPen*(60); // in sec (1 min = 60 sec)
                        $secFix = floor($sec);
                    }
                }
            }

            $str = "";
            // if($dayFix > 0)
            //     $str.= $dayFix." day ";
            if($hourFix > 0)
                $str = $hourFix;
            /*
            if($minFix > 0)
                $str.= $minFix." min ";
            if($secFix > 0)
                $str.= $secFix." sec ";
            return $str;
            */

            $hist_record->session_duration    = $get_journal->session_duration; //$str;

            foreach ($get_journal->participants as $key => $value) {
                $hist_record->org_unit      = isset($value->org_unit)?$value->org_unit:null;
                $hist_record->department    = isset($value->department)?$value->department:null;
                $hist_record->employee_code = isset($value->employee_code)?$value->employee_code:null;
                $hist_record->employee_name = isset($value->firstname)?$value->firstname:null;
                $DB->insert_record('new_historical_data',$hist_record);
            }
            
            if(!empty($result)){
                $status        = 1;
                $message       = "Record inserted successfully.";   
            }else{
                $status        = 0;
                $message       = "Not inserted successfully.";
            }

            $returndata['status']     = $status;
            $returndata['message']    = $message;
            $returndata['file_name']  = $file_result;
            echo $data = json_encode($returndata);
        }else{
          echo $data = json_encode(['Message'=>'Parameters are missing']);
        }
    }else if($wsfunction == "self_nomination"){
      $wsToken       = $_POST['wsToken'];
      $employee_code = $_POST['employee_code'];
      $company_code  = $_POST['company_code'];
      $courseid      = $_POST['courseid'];
      $userid        = '';
      $check_course  = 0;
               
      if($wsToken != '' && $employee_code!= '' && $company_code != '' && $courseid != ''){ 
               
        $query_fetch_user = $DB->get_record_sql("SELECT u.*,ub.managersemail,ub.reporting_manager_id FROM mdl_user_bulk as ub LEFT JOIN mdl_user as u ON ub.user_id = u.id LEFT JOIN mdl_external_tokens as et ON u.id = et.userid WHERE ub.employee_code = '$employee_code' && ub.company_code = '$company_code' && et.token = '$wsToken'");

        if(!empty($query_fetch_user)){
            
          $userid = $query_fetch_user->id;
          $time   = time();

                $qry_check_course = $DB->get_record_sql("select * from {course} where id = $courseid");
                $check_course     = 0;
                if(!empty($query_fetch_user)){
                    $check_course = 1;
                }

                if($check_course == 1){
                
                    $qry="SELECT e.id AS enrolid 
                                FROM {user_enrolments} as ue
                                LEFT JOIN {enrol} e ON e.id = ue.enrolid
                                WHERE ue.userid=$userid and e.courseid=$courseid";
                    $query_check_enrol = $DB->get_record_sql($qry);
                    $check=0;

                    if(!empty($query_check_enrol)){
                      $check = 1;
                    }

                    if($check == 1)
                    {
                        $status=0;
                        $message="Already enrolled in this course";
                    }
                    else
                    {
                        $rec_insert= new stdClass();
                        $rec_insert->enrol          = 'self';
                        $rec_insert->courseid       = $courseid;
                        $rec_insert->timecreated    = $time;
                        $enrolid                    = "dummy";
        //              print_r($rec_insert);
                        $enrolid = $DB->insert_record('enrol', $rec_insert, true);
                        $rec_insert1= new stdClass();
                        $rec_insert1->enrolid= $enrolid;
                        $rec_insert1->userid= $userid;
                        $rec_insert1->timecreated= $time;
                        $enrolmentid ="Dummy";
        //              print_r($rec_insert1);
                        $enrolmentid = $DB->insert_record('user_enrolments', $rec_insert1, true);
                        $status      = 1;
           
                        $managers_email = $query_fetch_user->managersemail;
                        $get_course     = $DB->get_record('course',array('id' => $courseid));
                         
                        $messagehtml = "Dear ".$query_fetch_user->firstname." ".$query_fetch_user->lastname.",<br>
                                          You have enrolled yourself for the course ".$get_course->fullname."<br>
                                          Please click here to access the course https://learn.zinghr.com/bmai/course/view.php?name=".$get_course->shortname."<br>
                                          Happy Learning !! ";
                        $subject     = "Welcome to ".$get_course->fullname;
                         

                        $message = new stdClass();
                        $message->html = $messagehtml;
                        $message->text = "Congrats";
                        $message->subject = $subject;
                        $message->from_email = "hris@bma.ae";
                        $message->from_name  = "Do not reply to this email (via BMALearn)";
                        $message->to = array(array("email" => $managers_email));
                        $message->track_opens = true;

                        $response = $mandrill->messages->send($message);
                        $message->to = array(array("email" => $query_fetch_user->email));
                        $mandrill->messages->send($message);
                        $message="Successfully Enrolled";
                }
            }
            else{
                $status=0;
                $message="Course Not Found";
            }
            
            $jsondata=array();
            $jsondata['status']=$status;
            $jsondata['message']=$message;
    
        echo $data = json_encode($jsondata);

               }else{
                   echo $data = json_encode(['Message'=>'Invalid Api Token']);
               }
           }else{
              echo $data = json_encode(['Message'=>'Parameters are missing']);
           }
    }else if($wsfunction == "self_nomination_with_approval"){
      $wsToken       = $_POST['wsToken'];
      $employee_code = $_POST['employee_code'];
      $company_code  = $_POST['company_code'];
      $courseid      = $_POST['courseid'];
      $userid        = '';
      $check_course  = 0;
               
      if($wsToken != '' && $employee_code!= '' && $company_code != '' && $courseid != ''){ 
               
        /*
        $query_fetch_user = $DB->get_record_sql("SELECT u.*,ub.managersemail,ub.reporting_manager_id FROM mdl_user_bulk as ub LEFT JOIN mdl_user as u ON ub.user_id = u.id LEFT JOIN mdl_external_tokens as et ON u.id = et.userid WHERE ub.employee_code = '$employee_code' && ub.company_code = '$company_code' && et.token = '$wsToken'");
        */

        $query_fetch_user = $DB->get_record_sql(" SELECT u.*,ub.managersemail,ub.reporting_manager_id,au.email as manager_email,CONCAT(au.firstname, ' ', au.lastname) AS manager_name,aau.email as rep_manager_email,CONCAT(aau.firstname, ' ', aau.lastname) AS rep_manager_name 
                        FROM `mdl_user` as u 
                        left join `mdl_user_bulk` as ub on u.id = ub.user_id 
                        left JOIN `mdl_user` as au ON ub.managersemail = au.email 
                        left JOIN `mdl_user` as aau ON ub.reporting_manager_id = aau.id
                        LEFT JOIN `mdl_external_tokens` as et ON u.id = et.userid 
                        WHERE ub.employee_code = '$employee_code' && ub.company_code = '$company_code' && et.token = '$wsToken'");

        if(!empty($query_fetch_user)){
            
          $userid = $query_fetch_user->id;
          $time   = time();

                $qry_check_course = $DB->get_record_sql("select * from {course} where id = $courseid");
                $check_course     = 0;
                if(!empty($query_fetch_user)){
                    $check_course = 1;
                }

                if($check_course == 1){
                
                    $qry="  SELECT e.id AS enrolid 
                            FROM {enrol} as e
                            JOIN {user_enrolments} ue ON e.id = ue.enrolid
                            JOIN {enrol_apply_applicationinfo} app ON ue.id = app.userenrolmentid
                            WHERE ue.userid=$userid and e.courseid=$courseid";

                    $query_check_enrol = $DB->get_record_sql($qry);
                    $check=0;

                    if(!empty($query_check_enrol)){
                      $check = 1;
                    }

                    if($check == 1)
                    {
                        $status=0;
                        $message="Already you have requested for this course";
                    }
                    else
                    {
                        $rec_insert = new stdClass();
                        $rec_insert->enrol          = 'apply';
                        $rec_insert->courseid       = $courseid;
                        $rec_insert->sortorder      = 2;
                        $rec_insert->name           = '';
                        $rec_insert->roleid         = 5;
                        $rec_insert->timecreated    = $time;
                        $rec_insert->timemodified   = $time;
                        $enrolid = $DB->insert_record('enrol', $rec_insert, true);

                        $rec_insert_userenrol = new stdClass();
                        $rec_insert_userenrol->status         = 1;
                        $rec_insert_userenrol->enrolid        = $enrolid;
                        $rec_insert_userenrol->userid         = $userid;
                        $rec_insert_userenrol->timestart      = 0; 
                        $rec_insert_userenrol->timeend        = 0; 
                        $rec_insert_userenrol->modifierid     = $userid;
                        $rec_insert_userenrol->timecreated    = $time;
                        $rec_insert_userenrol->timemodified   = $time;
                        $user_enrolmentid = $DB->insert_record('user_enrolments', $rec_insert_userenrol, true);

                        $rec_insert_apply = new stdClass();
                        $rec_insert_apply->userenrolmentid  = $user_enrolmentid;
                        $rec_insert_apply->comment          = "request through mobile";
                        $enrol_applyid = $DB->insert_record('enrol_apply_applicationinfo', $rec_insert_apply, true);

                        $status      = 1;
           
                        $managers_email = $query_fetch_user->managersemail;
                        $get_course     = $DB->get_record('course',array('id' => $courseid));
                         
                        $messagehtml = "Dear Manager ".$query_fetch_user->manager_name.",<br><br> Your Associate ".$query_fetch_user->firstname." ".$query_fetch_user->lastname." has nominated himself/herself for attending the elearning Course ".$get_course->fullname.".<br><br> Kindly click on the link to approve / reject the same. <br> <a href='https://learn.zinghr.com/bmai/enrol/apply/manage.php'> Manage Enrol Applications </a> <br><br>
                            To konw more about the training program click here https://learn.zinghr.com/bmai/course/view.php?name=".$get_course->shortname."<br>
                                          Happy Learning !! ";
                        $subject     = "Manage Course ".$get_course->fullname;
                         

                        $message = new stdClass();
                        $message->html = $messagehtml;
                        $message->text = "Congrats";
                        $message->subject = $subject;
                        $message->from_email = "hris@bma.ae";
                        $message->from_name  = "Do not reply to this email (via BMALearn)";
                        $message->to = array(array("email" => $managers_email));
                        //$message->to = array(array("email" => 'sunitineo@gmail.com'));
                        $message->track_opens = true;

                        $response = $mandrill->messages->send($message);
                        $message  = "Your course enrolment request has been sent.";
                }
            }
            else{
                $status=0;
                $message="Course Not Found";
            }
            
            $jsondata=array();
            $jsondata['status']=$status;
            $jsondata['message']=$message;
    
        echo $data = json_encode($jsondata);

               }else{
                   echo $data = json_encode(['Message'=>'Invalid Api Token']);
               }
           }else{
              echo $data = json_encode(['Message'=>'Parameters are missing']);
           }
    }else if($wsfunction == "custom_email"){
        $userid = '72'; //'4310';
        $result_array = array();

        // $sql = "SELECT au.* FROM `mdl_user` as u left join `mdl_user_bulk` as ub on u.id = ub.user_id left JOIN `mdl_user` as au ON ub.managersemail = au.email WHERE u.`id` = ?";

        $sql = "SELECT u.*,ub.managersemail,ub.reporting_manager_id,au.email as manager_email,CONCAT(au.firstname, ' ', au.lastname) AS manager_name,aau.email as rep_manager_email,CONCAT(aau.firstname, ' ', aau.lastname) AS rep_manager_name 
                        FROM `mdl_user` as u 
                        left join `mdl_user_bulk` as ub on u.id = ub.user_id 
                        left JOIN `mdl_user` as au ON ub.managersemail = au.email 
                        left JOIN `mdl_user` as aau ON ub.reporting_manager_id = aau.id 
                        WHERE u.`id` = 4357";


        // $sql = 'SELECT DISTINCT u.email as "User Email",ccat.name AS "Course Catagory",c.fullname as "Course Name",
        //         case 
        //           when ccom.timecompleted IS NULL then "Not Completed" 
        //           when ccom.timecompleted IS NOT NULL then "Completed"
        //         end as "Completion Status"
        //         FROM {user} AS u 
        //           JOIN {course_completions} AS ccom ON u.id = ccom.userid
        //           JOIN {course} AS c ON c.id = ccom.course
        //           JOIN {course_categories} AS ccat ON c.category = ccat.id
        //         ORDER BY u.email,ccat.name,c.fullname';

        $result = $DB->get_records_sql($sql);
        echo "<pre>";
        print_r($result); exit();


        $sql = "SELECT au.*,aau.* FROM `mdl_user` as u left join `mdl_user_bulk` as ub on u.id = ub.user_id left JOIN `mdl_user` as au ON ub.managersemail = au.email left JOIN `mdl_user` as aau ON ub.reporting_manager_id = aau.id WHERE u.`id` = ?";
                        
        $result = $DB->get_records_sql($sql, array('id' => $userid), $strictness=IGNORE_MISSING);
        //echo"<pre>";
        print_r($result); exit();

        $ans = list($array1, $array2) = array_chunk($result, ceil(count($result) / 2));
        print_r($ans);
        exit();



         $sql = "SELECT u.*,ub.managersemail,ub.reporting_manager_id,au.email as manager_email,CONCAT(au.firstname, ' ', au.lastname) AS manager_name,aau.email as rep_manager_email,CONCAT(aau.firstname, ' ', aau.lastname) AS rep_manager_name 
                    FROM `mdl_user` as u 
                    join `mdl_user_bulk` as ub on u.id = ub.user_id 
                    JOIN `mdl_user` as au ON ub.managersemail = au.email 
                    JOIN `mdl_user` as aau ON ub.reporting_manager_id = aau.id 
                    WHERE u.`id` = ?";

        $users = $DB->get_record_sql($sql, array('id' => $userid), $strictness=IGNORE_MISSING); print_r($users->managersemail); exit();


        // print_r($DB->get_record('user', array('id' => $userid), '*', MUST_EXIST)); exit();
        $sql = "SELECT u.*,ub.managersemail FROM `mdl_user` as u
                        JOIN `mdl_user_bulk` as ub
                        ON u.id = ub.user_id
                        WHERE u.id = ? limit 1";
                $get_user = $DB->get_record_sql($sql, array('id' => $userid), $strictness=IGNORE_MISSING);
                //echo"<pre>"; print_r($get_user); exit();


       /*
        $mail = get_mailer();   // This will get the moodle mailer configuration.
        $from = 'sunitineo@gmail.com';
        $to = 'sunitiyadav1@gmail.com';

        $mail->Sender = $from;
        $mail->From = $from;
        $mail->AddReplyTo($from);
        $mail->Subject = "subject api";
        $mail->AddAddress($to);
        $mail->Body = "You have been enrolled to course"."<br/><br/>"."Please login to start your course."."<br/><br/>"."Thanks,"."<br/>Admin";
        $mail->IsHTML(false);

        print_r($mail);
        print_r($mail->Send()); exit();
        
        if ($mail->Send()) {
            $mail->IsSMTP();
            // use SMTP directly
            if (!empty($mail->SMTPDebug)) {
                echo '</pre>';
                echo 'mail sent';
            }
        } else {
            if (!empty($mail->SMTPDebug)) {
                echo '</pre>';
            }
            //Send Error
            return $mail->ErrorInfo;
        }
        */
    }else if($wsfunction == "set_managersemail"){
        /*
         $sql = "SELECT u.*,ub.managersemail,ub.reporting_manager_id,au.email as manager_email,CONCAT(au.firstname, ' ', au.lastname) AS manager_name,aau.email as rep_manager_email,CONCAT(aau.firstname, ' ', aau.lastname) AS rep_manager_name 
                    FROM `mdl_user` as u 
                    join `mdl_user_bulk` as ub on u.id = ub.user_id 
                    JOIN `mdl_user` as au ON ub.managersemail = au.email 
                    JOIN `mdl_user` as aau ON ub.reporting_manager_id = aau.id 
                    WHERE u.`id` = ?";
        */

        $count = 0;
        $sql   = "SELECT u.id,ub.managersemail FROM `mdl_user` as u join `mdl_user_bulk` as ub on u.id = ub.user_id where ub.managersemail != '' and ub.managersemail != 'null' ";

        $users = $DB->get_records_sql($sql); //print_r($users); exit();

        foreach ($users as $key => $value) {

                  $record = new stdClass();
                  $record->userid      = $value->id;
                  $record->fieldid     = 7;
                  $record->data        = $value->managersemail;
                  //$record->dataformat  = 0;  
                  $DB->insert_record('user_info_data',$record,true);
                  $count++;
            
            /*
            $query   = "SELECT * FROM `mdl_user_info_data` where userid = ? and fieldid =? and data = ? ";
            $result  = $DB->get_record_sql($query, array('userid' => $value->id, 'fieldid' => 7, 'data' =>$value->managersemail), $strictness=IGNORE_MISSING);
            print_r( $result); //exit();

            if (empty($result)) 
            {
                return false;
            }
            else
            {       
                  $record = new stdClass();
                  $record->userid      = $value->id;
                  $record->fieldid     = 7;
                  $record->data        = $value->managersemail;
                  //$record->dataformat  = 0;  
                  $DB->insert_record('mdl_user_info_data',$record,true);
                  //print_r($record); exit();

                  //print_r($DB->insert_record('user_info_data',$record,true)); exit();
                  $count++;
            }
            */
            
        }

        return $count;
    }else if($wsfunction == "get_all_courses"){
        $wsToken        = $_POST['wsToken'];
        $employee_code  = $_POST['employee_code'];
        $company_code   = $_POST['company_code'];
        
        if($wsToken != '' && $employee_code!= '' && $company_code != ''){ 
                   
            $query_fetch_user = $DB->get_record_sql("SELECT u.id as userid FROM mdl_user_bulk as ub LEFT JOIN mdl_user as u ON ub.user_id = u.id LEFT JOIN mdl_external_tokens as et ON u.id = et.userid WHERE ub.employee_code = '$employee_code' && ub.company_code = '$company_code' && et.token = '$wsToken'");
            
            if(!empty($query_fetch_user)){
                    
                $userid = $query_fetch_user->userid;

                $qry="select c.id, c.fullname, c.shortname, c.summary, c.startdate, c.enddate, c.visible, c.enablecompletion from {course} as c ";
                $query_mandatory_course = $DB->get_records_sql($qry);

                foreach($query_mandatory_course as $rs_mandatory_course)
                {
                    $rs_mandatory_course->summary = strip_tags($rs_mandatory_course->summary);
                    $courseid                     = $rs_mandatory_course->id;
                    $startdate                    = $rs_mandatory_course->startdate;
                    $enddate                      = $rs_mandatory_course->enddate;
                    $courseduration               = "";

                    if($enddate == 0 || $startdate == 0)
                    {
                      $courseduration="No Limit";
                    }
                    else
                    {
                      $enddate   = date_create(date("Y-m-d H:i:s",$enddate));
                      $startdate = date_create(date("Y-m-d H:i:s",$startdate));
                      $diff      = date_diff($enddate,$startdate);
                      $courseduration = $diff;
                      $courseduration = $diff->y." Year-".$diff->m." Month-".$diff->d." Days ".$diff->h." hours:".$diff->i." minutes:".$diff->s." seconds";
                    }
                    $rs_mandatory_course->courseduration = $courseduration;

                    $qry ="select contextid,component,filearea,sortorder,filename from mdl_files where contextid = ( select c.id as 'cid' from mdl_context as c left join mdl_course as cs on cs.id = c.instanceid where c.contextlevel = 50 and c.instanceid=$courseid) and filename !='.' and filearea='overviewfiles'";
                    $query_course_img = $DB->get_records_sql($qry);
                    $course_img = "";
                    foreach($query_course_img as $rs_course_img)
                    {
                        $course_img =  'https://learn.zinghr.com/bmai/pluginfile.php/'.$rs_course_img->contextid.'/'.$rs_course_img->component.'/'.$rs_course_img->filearea.'/'.$rs_course_img->filename;
                    }
                    $rs_mandatory_course->courseimage =  $course_img;
                    
                    // for setting a flag that user is enrolled or not in a course
                    $course_qry ="select c.id, c.fullname, c.shortname, c.summary, c.startdate, c.enddate, c.visible, c.enablecompletion from {course_categories} as cc left join {course} as c on c.category = cc.id left join {enrol} as e on e.courseid = c.id left join {user_enrolments} as ue on e.id=ue.enrolid where c.id=$courseid and ue.userid=$userid";
                    $query_course = $DB->get_records_sql($course_qry);
                    $rs_mandatory_course->is_my_course =  0;

                    if(!empty($query_course))
                    {
                      foreach ($query_course as $key => $value) {
                        if($value->id == $courseid)
                        {
                            $rs_mandatory_course->is_my_course =  1;
                        }
                      }
                    }

                    $mandatory_course_data[] =  $rs_mandatory_course;
                }
            
                $mandatory_course_details = array();
                $mandatory_course_details["coursedetails"]=$mandatory_course_data;
                echo json_encode($mandatory_course_details);
            }else{
               echo $data = json_encode(['Message'=>'Invalid Api Token']);
            }
        }else{
            echo $data = json_encode(['Message'=>'Parameters are missing']);
        }
    }else if($wsfunction == 'get_all_courses_nomination'){
        $wsToken        = $_POST['wsToken'];
        $employee_code  = $_POST['employee_code'];
        $company_code   = $_POST['company_code'];
        $companycode    = $_POST['categoryid'];
      
        if($wsToken != '' && $employee_code!= '' && $company_code != '' && $companycode != ''){ 
            $query_fetch_user = $DB->get_record_sql("SELECT u.* FROM mdl_user_bulk as ub LEFT JOIN mdl_user as u ON ub.user_id = u.id LEFT JOIN mdl_external_tokens as et ON u.id = et.userid WHERE ub.employee_code = '$employee_code' && ub.company_code = '$company_code' && et.token = '$wsToken'");
            
            if(!empty($query_fetch_user)){
                $userid = $query_fetch_user->id;
                $qry="select c.id, c.fullname, c.shortname, c.summary, c.startdate, c.enddate, c.visible, c.enablecompletion from {course_categories} as cc left join {course} as c on c.category = cc.id left join {enrol} as e on e.courseid = c.id left join {user_enrolments} as ue on e.id=ue.enrolid where cc.id=$companycode and ue.userid=$userid";
                $query_mandatory_course = $DB->get_records_sql($qry);
                foreach($query_mandatory_course as $rs_mandatory_course)
                {
                      $summary   = strip_tags($rs_mandatory_course->summary);
                      $str       = explode('Enroll Users', $summary);
                      $sumry     = htmlspecialchars($str[1]);
                      $sumry     = str_replace("&nbsp;", "", $sumry);
                      $rs_mandatory_course->summary = str_replace("&amp;nbsp;", "", $sumry);
                      $courseid  = $rs_mandatory_course->id;
                      $startdate = $rs_mandatory_course->startdate;
                      $enddate   = $rs_mandatory_course->enddate;
                      $courseduration = "";
                      if($enddate == 0 || $startdate == 0)
                      {
                        $courseduration="No Limit";
                      }
                      else
                      {
                        $enddate   = date_create(date("Y-m-d H:i:s",$enddate));
                        $startdate = date_create(date("Y-m-d H:i:s",$startdate));
                        $diff      = date_diff($enddate,$startdate);
                        $courseduration = $diff;
                        $courseduration = $diff->y." Year-".$diff->m." Month-".$diff->d." Days ".$diff->h." hours:".$diff->i." minutes:".$diff->s." seconds";
                      }
                      $rs_mandatory_course->courseduration = $courseduration;
                      $qry = "select contextid,component,filearea,sortorder,filename from mdl_files where contextid = ( select c.id as 'cid' from mdl_context as c left join mdl_course as cs on cs.id = c.instanceid where c.contextlevel = 50 and c.instanceid=$courseid) and filename !='.' and filearea='overviewfiles'";
                      $query_course_img = $DB->get_records_sql($qry);
                      $course_img       = "";
                
                      foreach($query_course_img as $rs_course_img)
                      {
                          $course_img =  $CFG->wwwroot.'/pluginfile.php/'.$rs_course_img->contextid.'/'.$rs_course_img->component.'/'.$rs_course_img->filearea.'/'.$rs_course_img->filename;
                      }
                      $rs_mandatory_course->courseimage =  $course_img;
              
                      $qry="SELECT count(instance) as 'ti' from {course_modules} where course = $courseid and module=16 and deletioninprogress=0";
                      $query_quiz_summery = $DB->get_records_sql($qry);
                      foreach($query_quiz_summery as $rs_quiz_summery)
                      {
                          $total_quiz =  $rs_quiz_summery;
                      }

                      $qry="select count(DISTINCT coursemoduleid) as tcm from {course_modules_completion} where coursemoduleid in (SELECT id FROM {course_modules} where course = $courseid and module=16 and deletioninprogress=0)";
                      $query_quiz_summery = $DB->get_records_sql($qry);
                      $total_completion=0;
                      foreach($query_quiz_summery as $rs_quiz_summery)
                      {
                          $total_completion =  $rs_quiz_summery;
                      }
                      $completionpercent=($total_completion->tcm / $total_quiz->ti) * 100;

                      $query_course_papers = $DB->get_records_sql("select cm.id as id,q.name as name from {course_modules} as cm left join {quiz} as q on cm.instance = q.id where cm.module=16 and cm.course= $courseid and cm.deletioninprogress=0");
                
                      $course_papers_data=array();
                      foreach($query_course_papers as $rs_course_papers)
                      {
                          $course_papers_data[] =  $rs_course_papers;
                      }
                      $rs_mandatory_course->quizes =  $course_papers_data;

                      $qry="select 
                      
                      cm.id as 'cmid',
                      f.id as 'id',
                      f.contextid as 'contextid',
                      f.component as 'component',
                      f.filearea as 'filearea',
                      f.sortorder as 'sortorder',
                      f.filename as 'filename',
                        r.id as 'res_id',
                        r.name as 'res_name',
                        r.intro as 'res_intro'
                      
                      from {course_modules} as cm 
                      left join {context} as c on cm.id = c.instanceid 
                      left join {files} as f on c.id = f.contextid
                      left join {resource} as r on cm.instance = r.id
                      where c.contextlevel = 70 and cm.deletioninprogress = 0 and cm.module=17 and c.id in (select c.id as 'cid' from {course_modules} as cm left join {context} as c on cm.id = c.instanceid where c.contextlevel = 70 and cm.deletioninprogress = 0 and cm.module=17 and cm.course=".$courseid.") and f.filename !='.'
                     ";
                     // echo $qry;

                      $query_fetch_files = $DB->get_records_sql($qry);
                      $fetch_files_data =array();
                      $fetch_video_data = array();
                      foreach($query_fetch_files as $rs_fetch_files)
                      {
                          $extn = explode(".",$rs_fetch_files->filename);
                          $rs_fetch_lession->contents=strip_tags($rs_fetch_lession->contents);

                          if($extn[1] === 'mp4' || in_array('mp4', $extn))
                          {
                            $vediodetails = array();
                            $vediodetails['cmid']  = $rs_fetch_files->cmid;
                            $vediodetails['fid']   = $rs_fetch_files->id;
                            $vediodetails['resid'] = $rs_fetch_files->res_id;
                            $vediodetails['name']  = $rs_fetch_files->res_name;
                            $vediodetails['intro'] = strip_tags($rs_fetch_files->res_intro);
                            $vediodetails['file']  = $CFG->wwwroot.'/pluginfile.php/'.$rs_fetch_files->contextid.'/'.$rs_fetch_files->component.'/'.$rs_fetch_files->filearea.'/'.$rs_fetch_files->sortorder.'/'.$rs_fetch_files->filename;
                            $fetch_video_data[] = $vediodetails;
                          }
                          else
                          {
                            $filedetails=array();
                            $filedetails['cmid']  = $rs_fetch_files->cmid;
                            $filedetails['fid']   = $rs_fetch_files->id;
                            $filedetails['resid'] = $rs_fetch_files->res_id;
                            $filedetails['name']  = $rs_fetch_files->res_name;
                            $filedetails['intro'] = strip_tags($rs_fetch_files->res_intro);
                            $filedetails['file']  = $CFG->wwwroot.'/pluginfile.php/'.$rs_fetch_files->contextid.'/'.$rs_fetch_files->component.'/'.$rs_fetch_files->filearea.'/'.$rs_fetch_files->sortorder.'/'.$rs_fetch_files->filename;
                            $fetch_files_data[] = $filedetails;
                          }
                      }    
                  
                        $rs_mandatory_course->files =  $fetch_files_data;
                        $rs_mandatory_course->videos =  $fetch_video_data;
                        $query_fetch_url = $DB->get_records_sql("select cm.id,u.name, u.externalurl from mdl_course_modules as cm left join mdl_url as u on cm.instance = u.id where cm.module=20 and cm.deletioninprogress=0 and cm.course=$courseid");
                        $fetch_url_data=array();
                        foreach($query_fetch_url as $rs_fetch_url)
                        {
                          $fetch_url_data[] =  $rs_fetch_url;
                        }
                        $rs_mandatory_course->url =  $fetch_url_data;
              
                        $query_fetch_lession = $DB->get_records_sql("select ls.id,ls.name, ls.intro,lsp.title, lsp.contents from mdl_modules as m left join mdl_course_modules as cm on m.id = cm.module left join mdl_lesson as ls on cm.instance = ls.id left join mdl_lesson_pages as lsp on ls.id = lsp.lessonid where m.id=13 and cm.deletioninprogress=0 and cm.course=$courseid");
                        $fetch_lession_data=array();
                        foreach($query_fetch_lession as $rs_fetch_lession)
                        {
                            $rs_fetch_lession->intro=strip_tags($rs_fetch_lession->intro);
                            $rs_fetch_lession->contents=strip_tags($rs_fetch_lession->contents);
                            $fetch_lession_data[] =  $rs_fetch_lession;
                        }

                        $rs_mandatory_course->lession =  $fetch_lession_data;
                        $query_fetch_feedback = $DB->get_records_sql("select cm.id as 'cmid',f.id as 'fid',f.name as 'name', f.intro as 'intro' from mdl_course_modules as cm left join mdl_feedback as f on cm.instance = f.id  where cm.module=7 and cm.deletioninprogress=0 and cm.course=$courseid");
                        $fetch_feedback_data=array();
                        foreach($query_fetch_feedback as $rs_fetch_feedback)
                        {
                            $feedbackid=$rs_fetch_feedback->fid;
                            $rs_fetch_feedback->intro=strip_tags($rs_fetch_feedback->intro);
                            $qry_feedback_item=$DB->get_records_sql("select id,name from {feedback_item} where feedback = $feedbackid");
                            $rs_fetch_feedback->feedback_question=$qry_feedback_item;
                            $fetch_feedback_data[] =  $rs_fetch_feedback;
                        }
                    
                        $rs_mandatory_course->feedback =  $fetch_feedback_data;

                        //For SCORM -
                        /*
                        $query_fetch_scorm = $DB->get_records_sql("SELECT f.id,f.contextid FROM `mdl_files` as f join mdl_scorm as s on f.contenthash = s.sha1hash WHERE f.component = 'mod_scorm' and s.course = $courseid");
                        */

                        $query_fetch_scorm = $DB->get_records_sql("SELECT id,contextid,component,filearea,itemid,filepath,filename,userid,filesize FROM `mdl_files` WHERE `component` = 'mod_scorm' AND `filename` in ('index.html','index_lms_html5.html') and `contextid` = ( SELECT f.contextid FROM `mdl_modules` as m join mdl_course_modules as cm on m.id = cm.module join mdl_scorm as s on cm.instance = s.id join mdl_files as f on f.contenthash = s.sha1hash WHERE m.`name` = 'scorm' and cm.deletioninprogress = 0 and f.component = 'mod_scorm' and s.course = $courseid ORDER by cm.id DESC ) ");

                        //print_r($query_fetch_scorm); exit();

                        $fetch_scorm_data = array();
                        foreach($query_fetch_scorm as $value)
                        {
                           
                            $value->module_id = $value->id;
                            $value->name      = $value->filename;
                            $value->url       = $CFG->wwwroot."/pluginfile.php/".$value->contextid."/".$value->component."/".$value->filearea."/".$value->itemid.$value->filepath.$value->filename;
                            
                            $fetch_scorm_data[]= $value;
                               
                        }

                        // For ILT sessiosn

                        $query_session = "SELECT fsd.id as facetofaceSessionDates, f.id as facetofaceId ,fs.id as facetofaceSession, f.course, f.name,fsd.timestart, fsd.timefinish,u.id  as user_id, fs.trainer_id
                                            FROM mdl_course as c 
                                            join mdl_facetoface as f
                                            on f.course = c.id
                                            JOIN mdl_facetoface_sessions as fs
                                            ON fs.facetoface = f.id 
                                            JOIN mdl_facetoface_sessions_dates as fsd
                                            ON fsd.sessionid = fs.id 
                                            JOIN mdl_facetoface_session_data as fsda
                                            ON fsda.sessionid = fs.id 
                                            JOIN mdl_facetoface_session_field as fsf
                                            ON fsf.id = fsda.fieldid
                                            join mdl_facetoface_signups as s 
                                            on s.sessionid = fs.id
                                            join mdl_facetoface_signups_status as ss 
                                            on s.id = ss.signupid 
                                            left join mdl_user as u on u.id = s.userid 
                                            left join mdl_user_bulk as ub on ub.user_id = u.id 
                                            WHERE DATE_FORMAT(CURRENT_TIMESTAMP, '%Y-%m-%d') = DATE_FORMAT(FROM_UNIXTIME(fsd.timestart), '%Y-%m-%d')
                                            -- and ss.statuscode IN ('70','100')
                                            and ss.statuscode = 100
                                            and ss.superceded = 0
                                            and u.id = '$userid'
                                            and c.id = '$rs_mandatory_course->id'
                                            GROUP BY fsd.timestart,fsd.timefinish,fsd.id, fs.id,u.id
                                            ORDER BY fsd.timestart DESC";

                        $get_ILT = $DB->get_records_sql($query_session);
                        if(!empty($get_ILT))
                        {
                            foreach ($get_ILT as $key1 => $value1) {
                                $fetch_ILT_data[] = $value1;
                                $get_noti = $DB->get_records_sql("SELECT player_id from mdl_push_notification where user_id = '$value1->trainer_id' and status = 'A'");
                                foreach ($get_noti as $key2 => $value2) {
                                    $player_id[]  = $value2->player_id;
                                    $qry_player   = " SELECT *
                                                      FROM mdl_push_notification as p
                                                      WHERE p.player_id = '$value2->player_id' 
                                                      and p.user_id != '$value1->trainer_id'";
                                    $fetch_player_rec = $DB->get_records_sql($qry_player);

                                    if(!empty($fetch_player_rec))
                                    {
                                        foreach ($fetch_player_rec as $key => $value) {
                                             $sql    = "UPDATE mdl_push_notification SET status = 'D' WHERE id = ".$value->id;
                                              $DB->execute($sql);
                                        }
                                          
                                    }  

                                }
                                
                            }
                        }
                        $rs_mandatory_course->scorm =  $fetch_scorm_data;
                        $rs_mandatory_course->ILT   =  $fetch_ILT_data;
                        $rs_mandatory_course->trainer_playerid   =  $player_id;
                        $mandatory_course_data[]    =  $rs_mandatory_course;

                }
                
                $mandatory_course_details=array();
                $mandatory_course_details["coursedetails"]=$mandatory_course_data;
                echo json_encode($mandatory_course_details);        
            }
            else
            {
                echo $data = json_encode(['Message'=>'Invalid Api Token']);
            }
        }
        else
        {
            echo $data = json_encode(['Message'=>'Parameters are missing']);
        }
    }else if($wsfunction == "set_facetoface_attendance_old"){
        $facetoface_id       = $_POST['facetoface_id'];
        $facetoface_sess_id  = $_POST['facetoface_sess_id'];
        $facetoface_sess_date_id  = $_POST['facetoface_sess_date_id'];
        $user_id             = $_POST['user_id'];
        $trainer_id          = $_POST['trainer_id'];
        $attendance          = $_POST['attendance'];

        //print_r($_POST); exit();

        $status              = 0; 
        $message             = "Record already present!!!";

        if($facetoface_id != '' && $facetoface_sess_id != ''  && $facetoface_sess_date_id != ''  && $user_id != '' && $trainer_id != '' && $attendance != ''){ 
             
            $get_attendance = $DB->get_records_sql("SELECT * from mdl_facetoface_attendance where facetoface_id = '$facetoface_id' and facetoface_sess_id = '$facetoface_sess_id' and facetoface_sess_date_id = '$facetoface_sess_date_id' and user_id = '$user_id' and trainer_id = '$trainer_id' ");
            //print_r(count($get_attendance)); exit();

            if(empty($get_attendance) || count($get_attendance) == 0)
            {
                //print_r("here"); exit();

                $rec_insert = new stdClass();
                $rec_insert->facetoface_id      = $facetoface_id;
                $rec_insert->facetoface_sess_id = $facetoface_sess_id;
                $rec_insert->facetoface_sess_date_id = $facetoface_sess_date_id;
                $rec_insert->user_id            = $user_id;
                $rec_insert->trainer_id         = $trainer_id;
                $rec_insert->attendance         = $attendance;
                //$rec_insert->created_at         = date('Y-m-d H:i:s');

                $result  = $DB->insert_record('facetoface_attendance', $rec_insert, true);
                
                $message = "Record inserted  successfully!!!";
                $status  = 1;
            }

            $returndata['status']  = $status;
            $returndata['message'] = $message;
            $returndata['result']  = $result;

        }
        else
        {
            $returndata['status']  = 0;
            $returndata['message'] = "Parameter Missing.";
            $returndata['result']  = null;
        }

        echo $data = json_encode($returndata);
    }else if($wsfunction == "submit_feedback"){
      $wsToken          = $_POST['wsToken'];
      $employee_code    = $_POST['employee_code'];
      $company_code     = $_POST['company_code'];
      $coursemoduleid   = $_POST['coursemoduleid'];
      $feedbacktext     = $_POST['feedbacktext'];
      $feedback_question= $_POST['feedback_question'];
      $facetofaceSessionDates= $_POST['facetofaceSessionDates'];
      $facetofaceId     = $_POST['facetofaceId'];
      $facetofaceSession= $_POST['facetofaceSession'];


        if($wsToken != '' && $employee_code!= '' && $company_code != '' && $feedback_question != '' && $coursemoduleid != '' && $feedbacktext != ''){ 
          $query_fetch_user = $DB->get_record_sql("SELECT u.id as userid FROM mdl_user_bulk as ub LEFT JOIN mdl_user as u ON ub.user_id = u.id LEFT JOIN mdl_external_tokens as et ON u.id = et.userid WHERE ub.employee_code = '$employee_code' && ub.company_code = '$company_code' && et.token = '$wsToken'");
            if(!empty($query_fetch_user)){
                $userid = $query_fetch_user->userid;
                $time   = time();
                $qry    = "select cm.instance from {course_modules} as cm join {feedback_item} as fi on fi.feedback = cm.instance where cm.id = $coursemoduleid and cm.module=7 and fi.id=$feedback_question";
                $get_feedbackid = $DB->get_record_sql($qry);
                
                if(!empty($get_feedbackid)){
                    $feedbackid         = $get_feedbackid->instance;
                    $submited_feedback  = $DB->get_record_sql("select fc.id from {feedback_completed} as fc where fc.feedback = $feedbackid and userid=$userid");
                    //print_r($submited_feedback); exit();

                    if(!empty($submited_feedback))
                    {    
                       $sbfid = $submited_feedback->id;
                    }
                    else
                    {
                        /*
                        $rec_insert= new stdClass();
                        $rec_insert->feedback  = $feedbackid;
                        $rec_insert->userid    = $userid;
                        $rec_insert->timemodified = $time;
                        $rec_insert->anonymous_response = 1 ;
                        $sbfid = $DB->insert_record('feedback_completed', $rec_insert, true);
                        */

                        $sql = 'INSERT INTO mdl_feedback_completed(feedback,userid,timemodified,anonymous_response) VALUES ('.$feedbackid.','.$userid.','.$time.',1)';
                        //echo $sql; //exit();
                        $DB->execute($sql);

                        $get_record_sql = "Select id from mdl_feedback_completed where feedback = ".$feedbackid." and userid = ".$userid;
                        $get_record = $DB->get_record_sql($get_record_sql);
                        $sbfid = $get_record->id;

                        $qry = "select * from {course_modules_completion} where coursemoduleid = $coursemoduleid and userid = $userid";
                        $qry_check_module=$DB->get_records_sql($qry);
                        $check_module=0;
                        foreach($qry_check_module as $rs_check_module){
                            $check_module=1;
                        }
                        if($check_module==0){
                            /*
                            $rec_insert3= new stdClass();
                            $rec_insert3->coursemoduleid=$coursemoduleid;
                            $rec_insert3->userid= $userid;
                            $rec_insert3->completionstate= 1;
                            $rec_insert3->timemodified= $time;
                            $cmcid = $DB->insert_record('course_modules_completion', $rec_insert3, true);
                            */
                            $sql = 'INSERT INTO mdl_course_modules_completion(coursemoduleid,userid,completionstate,timemodified) VALUES ('.$coursemoduleid.','.$userid.',1,'.$time.')';
                            //echo $sql; exit();
                            $DB->execute($sql);

                        } 
                    }
        
                    $get_ans = $DB->get_record_sql("select * from mdl_feedback_value as fv where (fv.item ='$feedback_question' && fv.user_id ='$userid' && fv.facetofaceSessionDates = '$facetofaceSessionDates' && fv.facetofaceId = '$facetofaceId' && fv.facetofaceSession = '$facetofaceSession')");
                    //print_r($get_ans);

                    $rec_insert1  = new stdClass();
                    $rec_insert1->item      = $feedback_question;
                    $rec_insert1->completed = $sbfid;
                    $rec_insert1->value     = $feedbacktext ;
                    $rec_insert1->user_id   = $userid;
                    $rec_insert1->feedback_description   = isset($_POST['description']) ? $_POST['description'] : 'NULL';
                    $rec_insert1->facetofaceSessionDates = isset($facetofaceSessionDates)?$facetofaceSessionDates : 0;
                    $rec_insert1->facetofaceId      = isset($facetofaceId)?$facetofaceId : 0;
                    $rec_insert1->facetofaceSession = isset($facetofaceSession)?$facetofaceSession : 0;

                    if(empty($get_ans))
                    {
                        //$sbfv = $DB->insert_record('feedback_value', $rec_insert1, true);

                        $sql_inst = 'INSERT INTO mdl_feedback_value(item,completed,value,user_id,feedback_description,facetofaceSessionDates,facetofaceId,facetofaceSession) VALUES ('.$rec_insert1->item.','.$rec_insert1->completed.','.$rec_insert1->value.','.$rec_insert1->user_id.','.$rec_insert1->feedback_description.','.$rec_insert1->facetofaceSessionDates.','.$rec_insert1->facetofaceId.','.$rec_insert1->facetofaceSession.')';
                        //echo "inst". $sql_inst; //exit();
                        $DB->execute($sql_inst);

                        $status  = 1;
                        $message = "feedback submitted Successfully.";
                    }
                    else
                    {
                        $rec_insert1->id = $get_ans->id;
                        //$DB->update_record('feedback_value', $rec_insert1);

                        $sql_upd = 'UPDATE mdl_feedback_value SET item ='.$rec_insert1->item.', completed = '.$rec_insert1->completed.', value = '.$rec_insert1->value.', user_id = '.$rec_insert1->user_id.', feedback_description = '.$rec_insert1->feedback_description.', facetofaceSessionDates = '.$rec_insert1->facetofaceSessionDates.', facetofaceId = '.$rec_insert1->facetofaceId.', facetofaceSession = '.$rec_insert1->facetofaceSession.' WHERE id = '.$rec_insert1->id;
                        //echo "upd". $sql_upd; //exit();
                        $DB->execute($sql_upd);

                        $status  = 1;
                        $message = "feedback updated Successfully.";
                    }
                }
                else
                {
                    $status  = 0;
                    $message = "Feedback question not found.";
                }
                $jsondata=array();
                $jsondata['status']=$status;
                $jsondata['message']=$message;
                echo $data = json_encode($jsondata);
            }else{
              echo $data = json_encode(['Message'=>'Invalid Api Token']);
            }
        }else{
          echo $data = json_encode(['Message'=>'Parameters are missing']);
        }
    }else if($wsfunction == "get_average_feedback"){
      $wsToken          = $_POST['wsToken'];
      $user_id          = $_POST['user_id'];
      $facetofaceSessionDates= $_POST['facetofaceSessionDates'];
      $facetofaceId     = $_POST['facetofaceId'];
      $facetofaceSession= $_POST['facetofaceSession'];


        if($wsToken != '' && $user_id!= '' && $facetofaceSessionDates != '' && $facetofaceId != '' && $facetofaceSession != ''){ 
          
          $query_fetch_user = $DB->get_record_sql("SELECT u.id as userid FROM mdl_user_bulk as ub LEFT JOIN mdl_user as u ON ub.user_id = u.id LEFT JOIN mdl_external_tokens as et ON u.id = et.userid WHERE u.id = '$user_id' and et.token = '$wsToken'");

            if(!empty($query_fetch_user)){
                $userid = $query_fetch_user->userid;
                $time   = time();
                $qry    = " SELECT i.id as que_id,i.`name` , sum(v.value)/count(v.value) as avg, count(v.value) as total FROM `mdl_feedback_item` as i join mdl_feedback_value as v on i.id = v.item WHERE v.facetofaceSessionDates = '$facetofaceSessionDates' AND v.facetofaceId = '$facetofaceId' and v.facetofaceSession = '$facetofaceSession' GROUP by i.id ";
                $get_avg = $DB->get_records_sql($qry);
                
                if(!empty($get_avg)){
                    
                    foreach ($get_avg as $key => $value) {
                        $comments = array();
                        $qry1    = "SELECT v.feedback_description FROM `mdl_feedback_item` as i join mdl_feedback_value as v on i.id = v.item WHERE v.facetofaceSessionDates = '$facetofaceSessionDates' AND v.facetofaceId = '$facetofaceId' and v.facetofaceSession = '$facetofaceSession' and i.id = '$value->que_id' ";

                        // $qry1    = " SELECT feedback_description FROM mdl_feedback_value WHERE facetofaceSessionDates = '$facetofaceSessionDates' AND facetofaceId = '$facetofaceId' and facetofaceSession = '$facetofaceSession' and feedback_description != '' ";
                        $get_comments    = $DB->get_records_sql($qry1);
                        foreach ($get_comments as $key1 => $value1) {
                            $comments[] = isset($value1->feedback_description)?$value1->feedback_description:[];
                        }
                        $value->comments = $comments;
                        $result[] = $value;
                    }

                    $status  = 1;
                    $message = "Record found successfully.";
                }
                else
                {
                    $status  = 0;
                    $message = "Record not found.";
                }
                $jsondata = array();
                $jsondata['status']  = $status;
                $jsondata['message'] = $message;
                $jsondata['result']  = isset($result)?$result:[];

                echo $data = json_encode($jsondata);
            }else{
              echo $data = json_encode(['Message'=>'Invalid Api Token']);
            }
        }else{
          echo $data = json_encode(['Message'=>'Parameters are missing']);
        }
    }else if($wsfunction == "ILT_attendance"){
        $signup_statusid     = $_POST['signup_statusid'];
        $signupid            = $_POST['signupid'];
        $trainer_id          = $_POST['trainer_id'];
        $attendance          = $_POST['attendance'];
        $status              = 0; 
        $message             = "Record already present!!!";
        $int_result          = null;
        $absent_code         = (int) 80;
        $present_code        = (int) 100;
        $absent_grade        = number_format(0, 5);
        $present_grade       = number_format($present_code, 5);
        $absent_symbol       = 'A';
        $statuscode          = (isset($attendance) && $attendance == $absent_symbol) ? $absent_code : $present_code;
        $deletecode          = (isset($statuscode) && $statuscode == $absent_code) ? $present_code : $absent_code;
       
        if($signupid != '' && $trainer_id != '' && $attendance != '' && $signup_statusid != ''){ 

            try {
                //echo 'point 1';
                $sql    = "UPDATE mdl_facetoface_signups_status SET superceded = 1 WHERE id = ".$signup_statusid;
                $result = $DB->execute($sql);
               // echo 'point 2'.$result; //exit();

                if($result)
                {
                    try {
                        //echo 'point 3';
                        $get_attendance = $DB->get_records_sql("SELECT * from mdl_facetoface_signups_status where signupid = '$signupid' and statuscode = '$statuscode' ");
                        //echo 'point 4';

                        $condition = array('signupid' => $signupid,'statuscode' => $deletecode);
                        $DB->delete_records('facetoface_signups_status', $condition); 
                        //echo 'point 5';
                        if(empty($get_attendance) || count($get_attendance) == 0)
                        {
                            $grade = (isset($attendance) && $attendance == $absent_symbol ) ? $absent_grade : $present_grade;

                            $sql = 'INSERT INTO mdl_facetoface_signups_status(signupid,statuscode,superceded,grade,createdby,timecreated) VALUES ('.$signupid.','.$statuscode.',0,'.$grade.','.$trainer_id.','.time().')';
                            //echo $sql; exit();

                            $int_result  = $DB->execute($sql);

                            $message = "Record inserted  successfully!!!";
                            $status  = 1;
                        }
                    }catch(Exception $e) {
                          $message = 'Message: ' .$e->getMessage();
                    }
                }
                
                
            }catch(Exception $e) {
                  $message = 'Message: ' .$e->getMessage();
            }

            $returndata['status']  = $status;
            $returndata['message'] = $message;
            $returndata['result']  = $int_result;
        }
        else
        {
            $returndata['status']  = 0;
            $returndata['message'] = "Parameter Missing.";
            $returndata['result']  = null;
        }
        echo $data = json_encode($returndata);
    }else if($wsfunction == "attempt_question"){
        $wsToken        = $_POST['wsToken'];
        $employee_code  = $_POST['employee_code'];
        $company_code   = $_POST['company_code'];
        $questionatmpid = $_POST['questionatmpid'];
        $answer_data    = $_POST['answer_data'];
               
        if($wsToken != '' && $employee_code!= '' && $company_code != '' && $questionatmpid != "" && $answer_data != ""){ 
            
            $query_fetch_user = $DB->get_record_sql("SELECT u.id as userid FROM mdl_user_bulk as ub LEFT JOIN mdl_user as u ON ub.user_id = u.id LEFT JOIN mdl_external_tokens as et ON u.id = et.userid WHERE ub.employee_code = '$employee_code' && ub.company_code = '$company_code' && et.token = '$wsToken'");
            
            if(!empty($query_fetch_user)){

                $userid = $query_fetch_user->userid; //print_r($userid); //exit();
                $time   = time();

                $qry = "select max(id) as id,max(sequencenumber) as 'seq' FROM {question_attempt_steps} where questionattemptid=$questionatmpid";
                $query_fetch_seq = $DB->get_record_sql($qry); //print_r($query_fetch_seq); //exit();
                
                $qas_seq = isset($query_fetch_seq->seq) ? $query_fetch_seq->seq : 0;
                $qas_id  = isset($query_fetch_seq->id) ? $query_fetch_seq->id : '';

                if(!empty($query_fetch_seq))
                {
                    $query_fetch_seq_val = $DB->get_record_sql("SELECT value FROM {question_attempt_step_data} WHERE attemptstepid= $qas_id and name='answer'"); 

                    $qasd_val = isset($query_fetch_seq_val->value) ? $query_fetch_seq_val->value : '';

                    if($qasd_val != $answer_data)
                    {
                        $qas_seq++;
                        $qas_id++;

                        $sql = 'INSERT INTO mdl_question_attempt_steps(questionattemptid,sequencenumber,state,timecreated,userid) VALUES ('.$questionatmpid.','.$qas_seq.',\'complete\','.$time.','.$userid.')';
                        
                        $DB->execute($sql);
                        
                        $get_q_a_steps = $DB->get_record_sql("SELECT id FROM `mdl_question_attempt_steps` ORDER BY `id` DESC limit 1");
                        if(!empty($get_q_a_steps))
                        {
                            $q_a_steps = $get_q_a_steps->id;
                            $sql_query = 'INSERT INTO mdl_question_attempt_step_data(attemptstepid,name,value) VALUES ('.$q_a_steps.',\'answer\','.$answer_data.')';
                            $q_a_s_data  = $DB->execute($sql_query); //echo "<br> point 2 - "; print_r($q_a_s_data); //exit();
                            $data_array = array("Updated");
                        }
                        else
                        {
                            $data_array = array("Not Updated");
                        }
                    }
                    else
                    {
                        $data_array = array("Not Updated");
                    }
                }
                else
                {
                    $data_array = array("Not Updated");
                }
          
            }
            else
            {
                $data_array = array("not found");
            }
        }
        else
        {
            $data_array = array("Parameter Missing.");
        }
        echo $data = json_encode($data_array);
    }else if($wsfunction == "finish_attempt_old"){
      $wsToken = $_POST['wsToken'];
      $employee_code = $_POST['employee_code'];
      $company_code = $_POST['company_code'];
      $quizattemptid = $_POST['quizattemptid'];
               
      if($wsToken != '' && $employee_code!= '' && $company_code != '' && $quizattemptid != ''){ 
               
        $query_fetch_user = $DB->get_records_sql("SELECT u.id as userid FROM mdl_user_bulk as ub LEFT JOIN mdl_user as u ON ub.user_id = u.id LEFT JOIN mdl_external_tokens as et ON u.id = et.userid WHERE ub.employee_code = '$employee_code' && ub.company_code = '$company_code' && et.token = '$wsToken'");
        
        if(!empty($query_fetch_user)){
              foreach($query_fetch_user as $rs_fetch_user)  {  
                $fetch_user_data =  $rs_fetch_user;
              }
              $userid = $fetch_user_data->userid;
              $time=time();
              $finishAttempt=array();
              //$finishAttempt[] = "Find usageid";
              $query_get_usageid= $DB->get_records_sql("SELECT uniqueid, quiz FROM {quiz_attempts} WHERE id=$quizattemptid and userid=$userid and timefinish=0");
              $usageid="";
              $quizid="";
              foreach($query_get_usageid as $rs_get_usageid)
              {
                  $usageid=$rs_get_usageid->uniqueid;
                  $quizid=$rs_get_usageid->quiz;
              }

              if($usageid != "")
              {
                  //$finishAttempt[] = "usage_id=== ".$usageid;
                  //$finishAttempt[] = "Find Question attempt";
                  $sumgrade=0;
                  $query_get_questionattemptid= $DB->get_records_sql("select id,questionid from {question_attempts} where questionusageid=$usageid");
                  $usageid="";
                  foreach($query_get_questionattemptid as $rs_get_questionattemptid)
                  {
                      $questionattemptid=$rs_get_questionattemptid->id;
                      $questionattempted=$rs_get_questionattemptid->questionid;
                      //$finishAttempt[] = "question attempt id ".$questionattemptid. " question id ".$questionattempted;
                      $query_fetch_seq = $DB->get_records_sql("select max(id) as id,max(sequencenumber) as 'seq' FROM {question_attempt_steps} where questionattemptid=$questionattemptid");
                      $qas_seq="";
                      $qas_id="";
                      foreach($query_fetch_seq as $rs_fetch_seq)
                      {
                          $qas_seq=$rs_fetch_seq->seq;
                          $qas_id=$rs_fetch_seq->id;
                      }
                      //$finishAttempt[] = "question attempt step id ".$qas_id."question attempt step sequesnce ".$qas_seq;
                      if($qas_seq==0)
                      {
                          $finishAttempt[] = "Gaveup";
                          $rec_insert= new stdClass();
                          $rec_insert->questionattemptid= $questionattemptid;
                          $rec_insert->sequencenumber= $qas_seq+1;
                          $rec_insert->state= 'gaveup';
                          $rec_insert->timecreated= $time;
                          $rec_insert->userid= $userid;
                          $q_a_steps="dummy";
                          //$finishAttempt[] = "insert question attempt step";
                          $finishAttempt[] = $rec_insert;
                          $q_a_steps = $DB->insert_record('question_attempt_steps', $rec_insert, true);
                          $rec_insert1= new stdClass();
                          $rec_insert1->attemptstepid= $q_a_steps;
                          $rec_insert1->name= '-finish';
                          $rec_insert1->value= 1;
                          //$finishAttempt[] = "insert question attempt step data";
                          $finishAttempt[] = $rec_insert1;
                          $q_a_s_data = $DB->insert_record('question_attempt_step_data', $rec_insert1, true);
                      }
                      else
                      {
                              $query_fetch_submittedanswer = $DB->get_records_sql("SELECT qasd.value FROM {question_attempt_step_data} as qasd where qasd.attemptstepid=$qas_id");
                              $submitted_ans="";
                              foreach($query_fetch_submittedanswer as $rs_fetch_submittedanswer)
                              {
                                  $submitted_ans=$rs_fetch_submittedanswer->value;
                              }
                               //$finishAttempt[] = "Submitted Answer= ".$submitted_ans;
                               $query_fetch_answer = $DB->get_records_sql("SELECT qa.id,qa.answer,qa.answerformat,qa.fraction,qa.feedback,qa.feedbackformat,q.defaultmark from {question} as q left join {question_answers} as qa on qa.question = q.id WHERE qa.fraction = 1 and q.id = $questionattempted");
                              $answer_id="";
                              $answer="";
                              $answer_format="";
                              $ans_feedback="";
                              foreach($query_fetch_answer as $rs_fetch_answer)
                              {
                                  $answer_id=$rs_fetch_answer->id;
                                  $answer=$rs_fetch_answer->answer;
                                  $answer_format=$rs_fetch_answer->answerformat;
                                  $ans_feedback=$rs_fetch_answer->feedback;
                              }
                              $ans_defaultmark=0;
                              $query_fetch_marks = $DB->get_records_sql("SELECT maxmark from {quiz_slots} WHERE quizid=$quizid and questionid = $questionattempted");
                              foreach($query_fetch_marks as $rs_fetch_marks)
                              {
                                $ans_defaultmark=$rs_fetch_marks->maxmark;
                              }

                              $val_ans="";
                              if($answer_format==0)
                              {
                                  if($answer=="True")
                                  {
                                    $val_ans=1;
                                  }
                                  else
                                  {
                                    $val_ans=0;
                                  }
                              }
                             
                              if($answer_format==1)
                              {
                                  //$finishAttempt[] = "Question option Sequence";
                                  $query_fetch_answerseq = $DB->get_records_sql("SELECT qasd.value as optseq FROM {question_attempt_steps} as qas left join {question_attempt_step_data} as qasd on qas.id=qasd.attemptstepid where qas.questionattemptid=$questionattemptid and qasd.name='_order'");
                                  $opseq="";
                                  foreach($query_fetch_answerseq as $rs_fetch_answerseq)
                                  {
                                    $opseq=explode(",",$rs_fetch_answerseq->optseq);
                                  }
                                  $val_ans=array_search($answer_id,$opseq);
                              }

                              $ans_state="";
                              $ans_fraction="";
                              //$finishAttempt[] = "Answer val= ".$val_ans;
                              if($submitted_ans == $val_ans){$ans_state="gradedright";$ans_fraction=1;$sumgrade+=$ans_defaultmark;}else{$ans_state="gradedwrong";$ans_fraction=0;}
                              //$finishAttempt[] = "Answer state= ".$ans_state;
                              //$finishAttempt[] = "Answer fraction= ".$ans_fraction;
                            
                              $rec_insert= new stdClass();
                              $rec_insert->questionattemptid= $questionattemptid;
                              $rec_insert->sequencenumber= $qas_seq+1;
                              $rec_insert->state= $ans_state;
                              $rec_insert->fraction= $ans_fraction;
                              $rec_insert->timecreated= $time;
                              $rec_insert->userid= $userid;
                              $q_a_steps="dummy";
                              //$finishAttempt[] = "insert question attempt step";
                              $finishAttempt[] = $rec_insert;
                              $q_a_steps = $DB->insert_record('question_attempt_steps', $rec_insert, true);
                              $rec_insert1= new stdClass();
                              $rec_insert1->attemptstepid= $q_a_steps;
                              $rec_insert1->name= '-finish';
                              $rec_insert1->value= 1;
                              $finishAttempt[] = "insert question attempt step data";
                              $finishAttempt[] = $rec_insert1;
                              $q_a_s_data = $DB->insert_record('question_attempt_step_data', $rec_insert1, true);
                              $rec_update= new stdClass();
                              $rec_update->id= $questionattemptid;
                              $rec_update->responsesummary= strip_tags($answer);
                              $rec_update->timemodified= $time;
                              //$finishAttempt[] = "Update Question Attempt";
                              $finishAttempt[] = $rec_update;
                              $DB->update_record('question_attempts', $rec_update, false);
                      }
                  }
                  $rec_update1= new stdClass();
                  $rec_update1->id= $quizattemptid;
                  $rec_update1->state= 'finished';
                  $rec_update1->timefinish= $time;
                  $rec_update1->timemodified= $time;
                  $rec_update1->sumgrades= $sumgrade;
                  //$finishAttempt[] = "Update Quiz Attempt";
                  $finishAttempt[] = $rec_update1;
                  $DB->update_record('quiz_attempts', $rec_update1, false);
                  $api_status=1;
                  $api_msg="Successfully Submited";
              }
              else
              {
                  $api_status=0;
                  $api_msg="Already Submitted";
                  $finishAttempt[] = "Quiz Already Submitted";
              }
            
                //print_r($finishAttempt); exit();
              $data_array = array();
              $data_array["status"] = $api_status;
              $data_array["message"] = $api_msg;
              echo $data = json_encode($data_array);

        }else{
             echo $data = json_encode(['Message'=>'Invalid Api Token']);
        }
      }else{
        echo $data = json_encode(['Message'=>'Parameters are missing']);
      }
    }else if($wsfunction == "finish_attempt"){
        $wsToken        = $_POST['wsToken'];
        $employee_code  = $_POST['employee_code'];
        $company_code   = $_POST['company_code'];
        $quizattemptid  = $_POST['quizattemptid'];
            
        if($wsToken != '' && $employee_code!= '' && $company_code != '' && $quizattemptid != ''){ 
            
            $query_fetch_user = $DB->get_record_sql("SELECT u.id as userid FROM mdl_user_bulk as ub LEFT JOIN mdl_user as u ON ub.user_id = u.id LEFT JOIN mdl_external_tokens as et ON u.id = et.userid WHERE ub.employee_code = '$employee_code' && ub.company_code = '$company_code' && et.token = '$wsToken'");
            
            if(!empty($query_fetch_user)){

                $userid = $query_fetch_user->userid;
                $time   = time();
                $finishAttempt = array();

                $query_get_usageid= $DB->get_record_sql("SELECT uniqueid, quiz FROM {quiz_attempts} WHERE id=$quizattemptid and userid = $userid and timefinish = 0");

                $usageid = isset($query_get_usageid->uniqueid) ? $query_get_usageid->uniqueid : '';
                $quizid  = isset($query_get_usageid->quiz) ? $query_get_usageid->quiz : '';

                if($usageid != "")
                {
                    $sumgrade=0;
                    $query_get_questionattemptid = $DB->get_records_sql("select id,questionid from {question_attempts} where questionusageid=$usageid");
                    //echo "<br> <pre> point  - "; print_r($query_get_questionattemptid); 

                    foreach($query_get_questionattemptid as $rs_get_questionattemptid)
                    {
                        $questionattemptid = isset($rs_get_questionattemptid->id) ? $rs_get_questionattemptid->id : '';
                        $questionattempted = isset($rs_get_questionattemptid->questionid) ? $rs_get_questionattemptid->questionid : '';

                        $query_fetch_seq = $DB->get_record_sql("select max(id) as id,max(sequencenumber) as 'seq' FROM {question_attempt_steps} where questionattemptid=$questionattemptid");
                        $qas_seq = isset($query_fetch_seq->seq) ? $query_fetch_seq->seq : '';
                        $qas_id  = isset($query_fetch_seq->id) ? $query_fetch_seq->id : '';
                        //echo "<br> <pre> point 1 - "; print_r($query_fetch_seq); //exit();

                        if($qas_seq == 0)
                        {
                            $finishAttempt[] = "Gaveup";
                            $sequencenumber = $qas_seq+1;
                            //$q_a_steps      = $qas_id+1; //print_r($q_a_steps);
                            $state          = 'gaveup';

                            $sql = 'INSERT INTO mdl_question_attempt_steps(questionattemptid,sequencenumber,state,timecreated,userid) VALUES ('.$questionattemptid.','.$sequencenumber.',\''.$state.'\','.$time.','.$userid.')';
                            $DB->execute($sql); //print_r($q_a_steps); //exit();
                            // $get_q_a_steps = $DB->get_record_sql("SELECT id FROM `mdl_question_attempt_steps` ORDER BY `id` DESC limit 1");
                            $get_q_a_steps = $DB->get_record_sql("SELECT id FROM `mdl_question_attempt_steps` WHERE questionattemptid = '$questionattemptid' and sequencenumber = '$sequencenumber' and state = '$state' and userid = '$userid' ORDER BY `id` DESC limit 1");

                            if(!empty($get_q_a_steps))
                            {
                                $q_a_steps = $get_q_a_steps->id;
                                $sql_query = 'INSERT INTO mdl_question_attempt_step_data(attemptstepid,name,value) VALUES ('.$q_a_steps.',\'-finish\',1)';
                                $q_a_s_data  = $DB->execute($sql_query); //echo "<br> point 2 - "; print_r($q_a_s_data); //exit();
                            }
                            else
                            {
                                $api_status = 0;
                                $api_msg    = "not Submitted";
                                //$finishAttempt[] = "Quiz not able to Submit";
                            }
                            
                        }
                        else
                        {
                            $query_fetch_submittedanswer = $DB->get_record_sql("SELECT qasd.value FROM {question_attempt_step_data} as qasd where qasd.attemptstepid=$qas_id");
                            //echo "<br> pointElse 1 - "; print_r($query_fetch_submittedanswer); //exit();

                            if(! empty($query_fetch_submittedanswer))
                            {
                                $submitted_ans = isset($query_fetch_submittedanswer->value) ? $query_fetch_submittedanswer->value : '';
                                $query_fetch_answer = $DB->get_record_sql("SELECT qa.id,qa.answer,qa.answerformat,qa.fraction,qa.feedback,qa.feedbackformat,q.defaultmark from {question} as q left join {question_answers} as qa on qa.question = q.id WHERE qa.fraction = 1 and q.id = $questionattempted");

                                //echo "if"; print_r($query_fetch_answer); //exit();

                                if(!empty($query_fetch_answer))
                                {
                                        $answer_id  =   isset($query_fetch_answer->id) ? $query_fetch_answer->id : '';
                                        $answer     =   isset($query_fetch_answer->answer) ? $query_fetch_answer->answer : '';
                                        $answer_format= isset($query_fetch_answer->answerformat) ? $query_fetch_answer->answerformat : '';
                                        $ans_feedback=  isset($query_fetch_answer->feedback) ? $query_fetch_answer->feedback : '';
                                         
                                        $query_fetch_marks = $DB->get_record_sql("SELECT maxmark from {quiz_slots} WHERE quizid=$quizid and questionid = $questionattempted");
                                        //print_r($query_fetch_marks); exit();

                                        $ans_defaultmark = isset($query_fetch_marks->maxmark) ? $query_fetch_marks->maxmark : 0;
                                        
                                        $val_ans="";
                                        
                                        if($answer_format == 0)
                                        {
                                           if($answer=="True")
                                            {
                                                $val_ans = 1;
                                            }
                                            else
                                            {
                                                $val_ans = 0;
                                            }
                                        }
                                     
                                        if($answer_format==1)
                                        {
                                            $query_fetch_answerseq = $DB->get_record_sql("SELECT qasd.value as optseq FROM {question_attempt_steps} as qas left join {question_attempt_step_data} as qasd on qas.id=qasd.attemptstepid where qas.questionattemptid=$questionattemptid and qasd.name='_order'");
                                            //print_r($query_fetch_answerseq); exit();
                                            $opseq   = explode(",",$query_fetch_answerseq->optseq);
                                            //$val_ans = in_array($answer_id,$opseq);
                                            $val_ans = array_search($answer_id,$opseq);
                                        }
                                        
                                        if($submitted_ans == $val_ans)
                                        {
                                            $ans_state    = "gradedright";
                                            $ans_fraction = 1;
                                            $sumgrade+=$ans_defaultmark;
                                        }
                                        else
                                        {
                                            $ans_state    = "gradedwrong";
                                            $ans_fraction = 0;
                                        }

                                        $sequencenumber = $qas_seq+1;

                                        $sql = 'INSERT INTO mdl_question_attempt_steps(questionattemptid,sequencenumber,state,fraction,timecreated,userid) VALUES ('.$questionattemptid.','.$sequencenumber.',\''.$ans_state.'\','.$ans_fraction.','.$time.','.$userid.')';
                                        //echo $sql; exit();
                                        $DB->execute($sql);

                                        // $get_q_a_steps = $DB->get_record_sql("SELECT id FROM `mdl_question_attempt_steps` ORDER BY `id` DESC limit 1");

                                        $get_q_a_steps = $DB->get_record_sql("SELECT id FROM `mdl_question_attempt_steps` WHERE questionattemptid = '$questionattemptid' and sequencenumber = '$sequencenumber' and state = '$state' and userid = '$userid' ORDER BY `id` DESC limit 1");
                                        

                                        if(!empty($get_q_a_steps))
                                        {
                                            $q_a_steps = $get_q_a_steps->id;
                                            $sql_query = 'INSERT INTO mdl_question_attempt_step_data(attemptstepid,name,value) VALUES ('.$q_a_steps.',\'-finish\',1)';
                                            //echo $sql_query; 
                                            $DB->execute($sql_query);

                                            $up_sql = "UPDATE mdl_question_attempts SET responsesummary = '".strip_tags($answer)."', timemodified = ".$time." WHERE id = ".$questionattemptid; 
                                            //echo $up_sql; //exit();
                                            $DB->execute($up_sql); 
                                        }
                                        else
                                        {
                                            $api_status = 0;
                                            $api_msg    = "not Submitted";
                                        }
                                }
                            }
                            else
                            {
                                $api_status = 0;
                                $api_msg    = "Already Submitted";
                            }
                            
                        }

                    }

                    $upd_sql = "UPDATE mdl_quiz_attempts SET state = 'finished', timefinish = ".$time.",timemodified = ".$time.", sumgrades = ".$sumgrade." WHERE id = ".$quizattemptid; 
                    $DB->execute($upd_sql); 

                    $api_status = 1;
                    $api_msg    = "Successfully Submited";
                }
                else
                {
                  $api_status = 0;
                  $api_msg    = "Already Submitted";
                }
            
                $data_array = array();
                $data_array["status"] = $api_status;
                $data_array["message"] = $api_msg;
                echo $data = json_encode($data_array);

            }else{
                echo $data = json_encode(['Message'=>'Invalid Api Token']);
            }
        }else{
              echo $data = json_encode(['Message'=>'Parameters are missing']);
        }
    }else if($wsfunction == "quiz_review"){
        $wsToken = $_POST['wsToken'];
        $employee_code = $_POST['employee_code'];
        $company_code = $_POST['company_code'];
        $quizattemptid = $_POST['quizattemptid'];
        
        if($wsToken != '' && $employee_code!= '' && $company_code != '' && $quizattemptid != ''){ 

            $query_fetch_user = $DB->get_record_sql("SELECT u.id as userid FROM mdl_user_bulk as ub LEFT JOIN mdl_user as u ON ub.user_id = u.id LEFT JOIN mdl_external_tokens as et ON u.id = et.userid WHERE ub.employee_code = '$employee_code' && ub.company_code = '$company_code' && et.token = '$wsToken'");

            if(!empty($query_fetch_user)){

                $userid = $query_fetch_user->userid;
                $qry    = "select qa.id as 'attemptid', q.id as 'quizid', qa.uniqueid as 'unique_id',  qa.attempt as 'attemptno', qa.state as 'quizstate', DATE_FORMAT(FROM_UNIXTIME(qa.timestart), '%W, %d %M %Y %h:%k %p') as 'starttime', DATE_FORMAT(FROM_UNIXTIME(qa.timefinish), '%W, %d %M %Y %h:%k %p') as 'finishedtime', qa.sumgrades as 'grade', qg.grade as 'totalgrade', q.name as 'papername' from  {course_modules} as cm  LEFT JOIN {quiz_attempts} as qa on cm.instance = qa.quiz left join {quiz} as q on cm.instance = q.id  LEFT JOIN {quiz_grades} as qg ON qa.quiz =qg.quiz  where qa.id=$quizattemptid";

                $query_quiz_summery = $DB->get_records_sql($qry);
                $usage_id = "";
                foreach($query_quiz_summery as $rs_quiz_summery)
                {
                    $quiz_summery_data[] = $rs_quiz_summery;
                    $usage_id            = $rs_quiz_summery->unique_id;
                }

                $qry = "select q.id as 'qid',qa.id as 'id',q.name as 'name', q.questiontext as 'questiontext', q.qtype as 'qtype', qa.slot as 'slot', qa.questionsummary as 'questionsummary', qa.rightanswer as 'rightanswer', qa.responsesummary as 'response', qa.flagged as 'flag' from {question_attempts} as qa left join {question} as q on qa.questionid = q.id where qa.questionusageid=$usage_id";
                $query_fetch_question = $DB->get_records_sql($qry);

                $fetch_question_data = array();
                $qtype    = "";
                $correct  = 0;
                $incorrect= 0;
                $gaveup   = 0;

                //print_r($query_fetch_question); exit();
                if(!empty($query_fetch_question))
                {
                    foreach($query_fetch_question as $rs_fetch_question)
                    {
                        $rs_fetch_question->questiontext    = strip_tags($rs_fetch_question->questiontext);
                        $rs_fetch_question->questionsummary = strip_tags($rs_fetch_question->questionsummary);
                        $rs_fetch_question->rightanswer     = strip_tags($rs_fetch_question->rightanswer);
                        $qtype                              = $rs_fetch_question->qtype;
                        $question_id                        = $rs_fetch_question->id;
                        $slot                               = $rs_fetch_question->slot;

                        $query_fetch_options = $DB->get_records_sql("select an.id , an.answer as 'option' , an.answerformat , an.fraction as 'answerfraction' ,CASE WHEN an.fraction =0 THEN 'incorrect' WHEN an.fraction =1 THEN 'correct' END AS 'answer' from {question_attempts} as qa left join {question} as q on qa.questionid = q.id left join {question_answers} as an on q.id = an.question where qa.questionusageid=$usage_id and qa.slot=$slot");
                        $allanswer = array();
                        
                        foreach($query_fetch_options as $rs_fetch_options)
                        {
                            $rs_fetch_options->option   = strip_tags($rs_fetch_options->option);
                            $allanswer[]                = $rs_fetch_options;
                        }
                        $rs_fetch_question->allanswer = $allanswer;
                        
                        if($qtype=="multichoice")
                        {
                            $query_fetch_optstep = $DB->get_record_sql("SELECT qasd.value FROM {question_attempts} as qa LEFT JOIN {question_attempt_steps} as qas on qa.id = qas.questionattemptid LEFT JOIN {question_attempt_step_data} as qasd on qasd.attemptstepid = qas.id WHERE qa.questionusageid = $usage_id and `slot` = $slot and qasd.name='_order'");
                            $answerseq = isset($query_fetch_optstep->value) ? $query_fetch_optstep->value : '';
                            $rs_fetch_question->answerseq = explode(",",$answerseq);

                        }
                        
                        $qry = "select qas.id,qas.sequencenumber,qas.state,qas.fraction,qasd.name,qasd.value from {question_attempts} as qa left join {question_attempt_steps} as qas on qa.id = qas.questionattemptid left join {question_attempt_step_data} as qasd on qasd.attemptstepid = qas.id where qa.id=$question_id";
                        $query_fetch_ansval = $DB->get_records_sql($qry);
                        $allanswerval       = array();
                        $iscorrect          = "Incorrect";

                        //print_r($query_fetch_ansval); //exit();

                        foreach($query_fetch_ansval as $rs_fetch_ansval)
                        {
                            $allanswerval[]=$rs_fetch_ansval;
                            if($rs_fetch_ansval->name == '-finish' && $rs_fetch_ansval->state == 'gradedwrong')
                            {
                              $incorrect++;
                              $iscorrect="Incorrect";
                            }
                            else if($rs_fetch_ansval->name == '-finish' && $rs_fetch_ansval->state == 'gradedright')
                            {
                              $correct++;
                              $iscorrect="Correct";
                            }
                            else if($rs_fetch_ansval->name == '-finish' && $rs_fetch_ansval->state == 'gaveup')
                            {
                              $gaveup++;
                              $iscorrect="Gaveup";
                            }
                        }
                    
                        $rs_fetch_question->givenanswer       = $allanswerval;
                        $rs_fetch_question->givenanswerstatus = $iscorrect;
                        $fetch_question_data[]                = $rs_fetch_question;
                    }
                }
      
                $quizreview = array();
                $quizreview['quizdetails']      = $quiz_summery_data;
                $quizreview['questiondetails']  = $fetch_question_data;
            
                $quizreview['correct']      = $correct;
                $quizreview['incorrect']    = $incorrect;
                $quizreview['gaveup']       = $gaveup;
            
                echo json_encode($quizreview);

            }else{
               echo $data = json_encode(['Message'=>'Invalid Api Token']);
            }
        }else{
          echo $data = json_encode(['Message'=>'Parameters are missing']);
        }
    }else if($wsfunction == "set_module_completed"){
        $wsToken        = $_POST['wsToken'];
        $employee_code  = $_POST['employee_code'];
        $company_code   = $_POST['company_code'];
        $coursemoduleid = $_POST['coursemoduleid'];

        if($wsToken != '' && $employee_code!= '' && $company_code != '' && $coursemoduleid != ''){ 
            $query_fetch_user = $DB->get_record_sql("SELECT u.id as userid FROM mdl_user_bulk as ub LEFT JOIN mdl_user as u ON ub.user_id = u.id LEFT JOIN mdl_external_tokens as et ON u.id = et.userid WHERE ub.employee_code = '$employee_code' && ub.company_code = '$company_code' && et.token = '$wsToken'");
      
            $userid = $query_fetch_user->userid;
            $time   = time();
            $comp   = null;
            $view   = null;
            $qry    = "select * from {course_modules_completion} where coursemoduleid = $coursemoduleid and userid = $userid";

             //check completion status
             $qry_check_status =  $DB->get_record_sql($qry); //print_r($qry_check_status); exit();

            if (!empty($qry_check_status)) {
              $comp             =  $qry_check_status->completionstate;
              $view             =  $qry_check_status->viewed;

              if($comp == "1"){
                $status  = 0;
                $message = "Module already completed";
              }else{
            
                $is_mark_complete_sql = "UPDATE mdl_course_modules_completion SET completionstate = 1, viewed = 1 WHERE (coursemoduleid = $coursemoduleid) AND (userid = $userid)"; 
                $status = $DB->execute($is_mark_complete_sql);   
                if($status){
                  $status  = 1;
                  $message = "Module completed successfully";
                 
                }else{
                  $status=0;
                  $message="query error";
                }       
              } 
            }
            else {
              
              /*
              $rec_insert= new stdClass();
              $rec_insert->coursemoduleid=$coursemoduleid;
              $rec_insert->userid= $userid;
              $rec_insert->completionstate= 1;
              $rec_insert->timemodified= $time;
              $cmcid   = $DB->insert_record('course_modules_completion', $rec_insert, true);
              */

              $sql = 'INSERT INTO mdl_course_modules_completion(coursemoduleid,userid,completionstate,timemodified) VALUES ('.$coursemoduleid.','.$userid.',1,'.$time.')';
              $cmcid = $DB->execute($sql);

              $status  = 1;
              $message = " Module inserted successfully ";
            }
            

            $jsondata = array();
            $jsondata['status']  = $status;
            $jsondata['message'] = $message;
            $jsondata['comp']    = $comp;
            $jsondata['view']    = $view;
      
             echo $data = json_encode($jsondata);

        }else{
              echo $data = json_encode(['Message'=>'Parameters are missing']);
        }
    }else if($wsfunction == "get_urls"){
        $company_code        = strtolower($_POST['company_code']);
        $mobile_web_flag     = strtolower($_POST['mobile_web_flag']);
        $status              = 0; 
        $message             = "Record not found!!!";
        $result              = [];
        $get_result          = [];

        if($company_code != '' && $mobile_web_flag != ''){ 
            
            try {
                $sql    = "SELECT * from mdl_manage_url_calls WHERE company_code = '$company_code' AND status = '$mobile_web_flag'";
                $get_result = $DB->get_records_sql($sql);

                if($get_result)
                {   
                    foreach ($get_result as $key => $value) {
                        $result[] = $value;
                    }
                    $message = "Record found successfully!!!";
                    $status  = 1;
                }
            }
            catch(Exception $e) {
              $message = 'Message: ' .$e->getMessage();
            }

            $returndata['status']  = $status;
            $returndata['message'] = $message;
            $returndata['result']  = isset($result)?$result:$get_result;
        }
        else
        {
            $returndata['status']  = 0;
            $returndata['message'] = "Parameter Missing.";
            $returndata['result']  = null;
        }

        echo $data = json_encode($returndata);
    }else if($wsfunction == "get_facetoface_signup_users"){
        
        $wsToken                = $_POST['wsToken'];
        $facetofaceId           = $_POST['facetoface_id'];
        $facetofacesession      = $_POST['facetofacesession'];
        $facetofacesessiondates = $_POST['facetofacesessiondates'];

        $fetch_event_data = [];
        $qry           = "";
        $status        = 0; 

        if($wsToken != '' && $facetofaceId!= ''){ 

            $qry = " SELECT u.id as user_id,ub.org_unit,
                    u.country,
                    ub.region,
                    u.department,
                    ub.subdepartment as store_category,
                    ub.Ethnicity as employee_status,
                    ub.employee_code as employee_code,
                    concat(u.firstname, u.lastname) as employee_name,
                    ub.designation,
                    f.id as facetoface_id,
                    u.firstname, u.lastname, 
                    u.email, 
                    ub.gender,
                    fsps.id as signup_statusid,fsps.signupid,fs.id as f2fsessionid, c.fullname as course_name, 
                    f.name as facetoface_name
                    FROM mdl_course as c 
                    join mdl_facetoface as f
                    on f.course = c.id
                    JOIN mdl_facetoface_sessions as fs
                    ON fs.facetoface = f.id 
                    JOIN mdl_facetoface_sessions_dates as fsd
                    ON fsd.sessionid = fs.id 
                    JOIN mdl_facetoface_session_data as fsda
                    ON fsda.sessionid = fs.id 
                    JOIN mdl_facetoface_session_field as fsf
                    ON fsf.id = fsda.fieldid
                    JOIN mdl_facetoface_signups as fss
                    ON fss.sessionid = fs.id
                    JOIN mdl_facetoface_signups_status as fsps
                    ON fsps.signupid = fss.id 
                    JOIN mdl_user as u
                    ON u.id = fss.userid
                    left JOIN mdl_user_bulk as ub
                    ON ub.user_id = u.id
                    WHERE  f.id = $facetofaceId
                    AND fs.id = $facetofacesession
                    AND fsd.id = $facetofacesessiondates
                    AND fsps.statuscode = 70
                    GROUP BY f.id,fsps.signupid,ub.gender,fsps.id
                    ORDER BY f.id DESC";

            $query_fetch_event  = $DB->get_records_sql($qry);
            $message            = "No users have signed-up for this session.";
            $attendance         = 'N';

            foreach($query_fetch_event as $rs_fetch_event)
            {
                $get_attendance = $DB->get_record_sql("SELECT * from mdl_facetoface_signups_status where signupid = '$rs_fetch_event->signupid' and superceded = '0' ");

                if(!empty($get_attendance))
                {
                    if($get_attendance->statuscode == 80)
                    {
                        $attendance = 'A';
                    }
                    else if($get_attendance->statuscode == 100)
                    {
                        $attendance = 'P';
                    }
                }

                $get_noti = $DB->get_record_sql("SELECT player_id from mdl_push_notification where user_id = '$rs_fetch_event->user_id' and status = 'A'");

                $rs_fetch_event->player_id  = $get_noti->player_id;
                $rs_fetch_event->attendance = $attendance;
                $fetch_event_data[] = $rs_fetch_event;
                $status     = 1;
                $message    = "Users have signed-up for this session.";
            }

            $returndata['status']  = $status;
            $returndata['message'] = $message;
            $returndata['session'] = $fetch_event_data;
            
            echo $data = json_encode($returndata);
        }
    }else if($wsfunction == "set_journal"){
        $journal       = $_POST['journal'];
        $userid        = $_POST['userid'];
        $courseid      = $_POST['courseid'];
        //$trainer       = $_POST['trainer'];
        $file          = $_FILES['file'];

        $qry           = "";
        $status        = 0;
        $file_result   = null;
        $file_url      = null;
        $message       = "No record found.";

        if($journal != '' && $file != '' && $userid != '' && $courseid != ''){ 
           
            $get_journal = json_decode($journal);
            //print_r($get_journal); exit();

            $record = new stdClass();
            $record->employee_code      = isset($get_journal->employee_code)?$get_journal->employee_code:null;
            $record->user_id            = isset($get_journal->user_id)?$get_journal->user_id:null;
            $record->facetofaceid       = isset($get_journal->facetofaceid)?$get_journal->facetofaceid:null;
            $record->facetofacesession  = isset($get_journal->facetofacesession)?$get_journal->facetofacesession:null;
            $record->token              = isset($get_journal->token)?trim(preg_replace('/[^A-Za-z0-9\.\,\'@!-& ]/', '', $get_journal->token),' '):null;
            $record->program_name       = isset($get_journal->program_name)?trim(preg_replace('/[^A-Za-z0-9\.\,\'@!-& ]/', '', $get_journal->program_name),' '):null;
            $record->trainer_name       = isset($get_journal->trainer_name)?trim(preg_replace('/[^A-Za-z0-9\.\,\'@!-& ]/', '', $get_journal->trainer_name),' '):null;
            $record->country            = isset($get_journal->country)?trim(preg_replace('/[^A-Za-z0-9\.\,\'@!-& ]/', '', $get_journal->country),' '):null;
            $record->region             = isset($get_journal->region)?trim(preg_replace('/[^A-Za-z0-9\.\,\'@!-& ]/', '', $get_journal->region),' '):null;
            $record->total_participants = isset($get_journal->total_participants)?trim(preg_replace('/[^A-Za-z0-9\.\,\'@!-& ]/', '', $get_journal->total_participants),' '):null;
            $record->session_date       = isset($get_journal->session_date)?date('Y-m-d',strtotime($get_journal->session_date)):null;
            $record->brand              = isset($get_journal->brand)?trim(preg_replace('/[^A-Za-z0-9\.\,\'@!-& ]/', '', $get_journal->brand),' '):null;
            $record->thirty_day_review  = isset($get_journal->thirty_day_review)?trim(preg_replace('/[^A-Za-z0-9\.\,\'@!-& ]/', '', $get_journal->thirty_day_review),' '):null;
            $record->sixty_day_review   = isset($get_journal->sixty_day_review)?trim(preg_replace('/[^A-Za-z0-9\.\,\'@!-& ]/', '', $get_journal->sixty_day_review),' '):null;
            $record->ninty_day_review   = isset($get_journal->ninty_day_review)?trim(preg_replace('/[^A-Za-z0-9\.\,\'@!-& ]/', '', $get_journal->ninty_day_review),' '):null;
            $record->trainees_participation = isset($get_journal->trainees_participation)?trim(preg_replace('/[^A-Za-z0-9\.\,\'@!-& ]/', '', $get_journal->trainees_participation),' '):null;
            $record->trainees_participation_comment = isset($get_journal->trainees_participation_comment)?trim(preg_replace('/[^A-Za-z0-9\.\,\'@!-& ]/', '', $get_journal->trainees_participation_comment),' '):null;
            $record->people_management_challenges_comment = isset($get_journal->people_management_challenges_comment)?trim(preg_replace('/[^A-Za-z0-9\.\,\'@!-& ]/', '', $get_journal->people_management_challenges_comment),' '):null;
            $record->star_performer_name    = isset($get_journal->star_performer_name)?trim(preg_replace('/[^A-Za-z0-9\.\,\'@!-& ]/', '', $get_journal->star_performer_name),' '):null;
            $record->star_performer_comment = isset($get_journal->star_performer_comment)?trim(preg_replace('/[^A-Za-z0-9\.\,\'@!-& ]/', '', $get_journal->star_performer_comment),' '):null;
            $record->low_performer_name     = isset($get_journal->low_performer_name)?trim(preg_replace('/[^A-Za-z0-9\.\,\'@!-& ]/', '', $get_journal->low_performer_name),' '):null;
            $record->low_performer_comment  = isset($get_journal->low_performer_comment)?trim(preg_replace('/[^A-Za-z0-9\.\,\'@!-& ]/', '', $get_journal->low_performer_comment),' '):null;
            $record->trainees_action_plan   = isset($get_journal->trainees_action_plan)?trim(preg_replace('/[^A-Za-z0-9\.\,\'@!-& ]/', '', $get_journal->trainees_action_plan),' '):null;
            $record->supervisor_action_plan = isset($get_journal->supervisor_action_plan)?trim(preg_replace('/[^A-Za-z0-9\.\,\'@!-& ]/', '', $get_journal->supervisor_action_plan),' '):null;
            $record->possible_challenges    = isset($get_journal->possible_challenges)?trim(preg_replace('/[^A-Za-z0-9\.\,\'@!-& ]/', '', $get_journal->possible_challenges),' '):null;
            //echo "<pre>"; print_r($record); exit();

            // $get_rec = $DB->get_record_sql("SELECT * FROM `mdl_journal` WHERE `employee_code` = '$record->employee_code' and `user_id` = '$record->user_id' and facetofaceid = '$record->facetofaceid' and facetofacesession = '$record->facetofacesession'");
            // //print_r($get_rec); exit();

            // if(empty($get_rec))
            // {
                if($_FILES['file'])
                {
                    $root_dir = "/var/www/html/bmai/";

                    if (!file_exists($root_dir.'assets/journal/'.$userid)) {
                        mkdir($root_dir.'assets/journal/'.$userid, 0777, true);
                    }
                    $file_get    = file_get_contents($_FILES["file"]["tmp_name"]);

                    //Add the allowed mime-type files to an 'allowed' array 
                    $allowed = array('application/pdf');

                    //Check uploaded file type is in the above array (therefore valid)  
                    if(in_array($_FILES['file']['type'], $allowed)){

                       //If filetypes allowed types are found, continue to check filesize:
                       // if($_FILES["file"]["size"] < 800000 ){ //8kb

                            //if both files are below given size limit, allow upload
                            //Begin filemove here....

                            $is_uploaded = file_put_contents($root_dir."assets/journal/".$userid."/".$_FILES["file"]["name"],$file_get);

                            if($is_uploaded)
                            {
                                $record->file_name   = $_FILES["file"]["name"];
                                $record->file_type   = $_FILES["file"]["type"];
                                $file_result         = $_FILES["file"]["name"];
                                $file_url            = $CFG->wwwroot."/assets/journal/".$userid."/".$file_result;
                            }else{
                                $status        = 0;
                                $message       = "File not uploaded successfully.";
                            }

                        // }else{
                        //     $status        = 0;
                        //     $message       = "File size should be less than 8kb.";
                        // }

                    }else{
                        $status        = 0;
                        $message       = "File type should be PDF only";
                    }

                }

                // $str = trim(preg_replace('/[^A-Za-z0-9\.\,\'@!-& ]/', '', $record->low_performer_,' ')name);
                // echo $str; exit();

                $sql = "INSERT INTO mdl_journal(employee_code,user_id,facetofaceid,facetofacesession,token,program_name,trainer_name, country,region,total_participants,session_date,brand,thirty_day_review,sixty_day_review,ninty_day_review,trainees_participation,trainees_participation_comment,people_management_challenges_comment,star_performer_name,star_performer_comment, low_performer_name,low_performer_comment,trainees_action_plan,supervisor_action_plan,possible_challenges,file_name,file_type) VALUES 
                (\"".$record->employee_code."\",\"".$record->user_id."\",\"".$record->facetofaceid."\",\"".$record->facetofacesession."\",\"".$record->token."\",\"".$record->program_name."\",\"".$record->trainer_name."\",\"".$record->country."\",\"".$record->region."\",\"".$record->total_participants."\",\"".$record->session_date."\",\"".$record->brand."\",\"".$record->thirty_day_review."\",\"".$record->sixty_day_review."\",\"".$record->ninty_day_review."\",\"".$record->trainees_participation."\",\"".$record->trainees_participation_comment."\",\"".$record->people_management_challenges_comment."\",\"".$record->star_performer_name."\",\"".$record->star_performer_comment."\",\"".$record->low_performer_name."\",\"".$record->low_performer_comment."\",\"".$record->trainees_action_plan."\",\"".$record->supervisor_action_plan."\",\"".$record->possible_challenges."\",\"".$record->file_name."\",\"".$record->file_type."\")";
                //echo $sql; //exit();

                $int_result  = $DB->execute($sql); //print_r($int_result); exit();

                $result = $DB->get_record_sql("SELECT id FROM `mdl_journal` WHERE `employee_code` = '$record->employee_code' and `user_id` = '$record->user_id' and facetofaceid = '$record->facetofaceid' and facetofacesession = '$record->facetofacesession' ORDER by id desc limit 1");

                //print_r($result); exit();

                $qry     =  " SELECT cc.plain_name FROM `mdl_course` as c join mdl_course_categories as cc on c.category = cc.id WHERE c.id = '$courseid'";
                $get_program = $DB->get_record_sql($qry);
                $get_program_category = $get_program->plain_name;

                $get_qry     =  " SELECT CONCAT(u.firstname, ' ', u.lastname) as username FROM `mdl_user` as u join mdl_user_bulk as ub on u.id = ub.user_id WHERE u.id = '$get_journal->user_id'";
                $get_user    = $DB->get_record_sql($get_qry);
                $get_user_name = $get_user->username;
                // print_r($get_program_category); exit();

                $hist_record = new stdClass();
                $hist_record->year    = isset($get_journal->session_date)?date('Y', strtotime($get_journal->session_date)):null;
                $hist_record->month   = isset($get_journal->session_date)?date("F", strtotime($get_journal->session_date)):null;
                $hist_record->country = $record->country;
                $hist_record->region  = $record->region;
                //$hist_record->store_category  = isset($get_journal->store_category)?$get_journal->store_category:null;
                //$hist_record->employee_status = isset($get_journal->employee_status)?$get_journal->employee_status:null;

                $hist_record->program_name    =  $record->program_name;
                $hist_record->program_category= isset($get_program_category)?$get_program_category:null;
                $hist_record->trainer_id      = isset($get_journal->user_id)?$get_journal->user_id:$record->user_id;
                $hist_record->trainer         = isset($get_user_name) ? $get_user_name : $record->trainer_name;
                $hist_record->session_start_date = $get_journal->session_start_date; // "30-May-16";
                $hist_record->session_end_date   = $get_journal->session_end_date; //"31-May-16";
                $hist_record->session_duration   = $get_journal->session_duration; //$str;
                $hist_record->training_mandays   = isset($get_journal->session_duration) ? ($get_journal->session_duration/8) : null;

                //print_r($hist_record); exit();

                foreach ($get_journal->participants as $key => $value) {
                    
                    if($get_journal->brand == "Redtag")
                    {
                        $brand = "RT Retail";
                    }
                    else
                    {
                        $brand = "T4 Retail";
                    }

                    $hist_record->org_unit      = isset($brand)?trim(preg_replace('/[^A-Za-z0-9\.\,\'@!-& ]/', '', $brand),' '):null;
                    $hist_record->department    = isset($value->department)?trim(preg_replace('/[^A-Za-z0-9\.\,\'@!-& ]/', '', $value->department),' '):null;
                    $hist_record->designation   = isset($value->designation)?trim(preg_replace('/[^A-Za-z0-9\.\,\'@!-& ]/', '', $value->designation),' '):null;
                    $hist_record->store_category= isset($value->store_category)?trim(preg_replace('/[^A-Za-z0-9\.\,\'@!-& ]/', '', $value->store_category),' '):null;
                    $hist_record->employee_status= isset($value->employee_status)?trim(preg_replace('/[^A-Za-z0-9\.\,\'@!-& ]/', '', $value->employee_status),' '):null;
                    $hist_record->employee_code = isset($value->employee_code)?trim(preg_replace('/[^A-Za-z0-9\.\,\'@!-& ]/', '', $value->employee_code),' '):null;
                    $hist_record->employee_name = isset($value->employee_name)?trim(preg_replace('/[^A-Za-z0-9\.\,\'@!-& ]/', '', $value->employee_name),' '):null;
                    //print_r($hist_record); //exit();
                    //$DB->insert_record('new_historical_data',$hist_record);

                    $his_sql = "INSERT INTO `mdl_new_historical_data` (`year`, `month`, `org_unit`, `country`, `region`, `department`, `store_category`, `employee_status`, `employee_code`, `employee_name`, `designation`, `program_name`, `program_category`, `trainer_id`, `trainer`, `session_start_date`, `session_end_date`, `session_duration`, `training_mandays`) VALUES (\"".$hist_record->year."\",\"".$hist_record->month."\",\"".$hist_record->org_unit."\",\"".$hist_record->country."\",\"".$hist_record->region."\",\"".$hist_record->department."\",\"".$hist_record->store_category."\",\"".$hist_record->employee_status."\",\"".$hist_record->employee_code."\",\"".$hist_record->employee_name."\",\"".$hist_record->designation."\",\"".$hist_record->program_name."\",\"".$hist_record->program_category."\",\"".$hist_record->trainer_id."\",\"".$hist_record->trainer."\",\"".$hist_record->session_start_date."\",\"".$hist_record->session_end_date."\",\"".$hist_record->session_duration."\",\"".$hist_record->training_mandays."\")";
                    //echo $his_sql; exit();
                    $DB->execute($his_sql);
                }

                if(!empty($result)){
                    $status        = 1;
                    $message       = "Record inserted successfully.";   
                }else{
                    $status        = 0;
                    $message       = "Not inserted successfully.";
                }
            // }
            // else
            // {
            //     $status        = 0;
            //     $message       = "Journal Already exist.";
            //     $file_result   = $get_rec->file_name;
            //     $file_url      = $CFG->wwwroot."/assets/journal/".$userid."/".$file_result;
            //     $result->id    = $get_rec->id;
            // }

            $returndata['status']     = $status;
            $returndata['message']    = $message;
            $returndata['file_name']  = $file_result;
            $returndata['file_url']   = $file_url;
            $returndata['journal_id'] = !empty($result) ? $result->id : null;

            echo $data = json_encode($returndata);
        }else{
          echo $data = json_encode(['Message'=>'Parameters are missing']);
        }
    }else if($wsfunction == "set_training_start_time_oldla"){
        
        $facetoface_id       = $_POST['facetoface_id'];
        $facetoface_sess_id  = $_POST['facetoface_sess_id'];
        $facetoface_sess_date_id  = $_POST['facetoface_sess_date_id'];
        $user_id             = $_POST['user_id'];
        $status              = 0; 
        $message             = "Record already present!!!";

        if($facetoface_id != '' && $facetoface_sess_id!= ''  && $facetoface_sess_date_id!= ''  && $user_id!= ''){ 
             
            $get_training_sess = $DB->get_record_sql("SELECT id from mdl_training_session where facetoface_id = '$facetoface_id' and facetoface_sess_id = '$facetoface_sess_id' and facetoface_sess_date_id = '$facetoface_sess_date_id' and user_id = '$user_id'");

            /*
            $query_signup = "SELECT * FROM `mdl_facetoface_signups` WHERE sessionid = ? AND userid = ?";
            $get_signup_id= $DB->get_record_sql($query_signup, array('sessionid' => $facetoface_sess_id, 'userid' => $user_id), $strictness=IGNORE_MISSING);

            $query_signup_status = "SELECT * FROM `mdl_facetoface_signups_status` WHERE signupid = ? AND superceded = ? ORDER BY `id` DESC";
            $getcurrentstatus = $DB->get_record_sql($query_signup_status, array('signupid' => $get_signup_id->id, 'superceded' => 0), $strictness=IGNORE_MISSING);
            */

            //print_r($get_signup_id); exit();

            $query_signup = "SELECT fss.statuscode,fss.id, fs.id as fid FROM `mdl_facetoface_signups`as fs join `mdl_facetoface_signups_status` as fss on fss.signupid = fs.id  WHERE fs.sessionid = ? AND fs.userid = ? AND superceded = 0 ORDER BY `statuscode` DESC limit 1";
            //echo $query_signup; exit();
            $getcurrentstatus= $DB->get_record_sql($query_signup, array('sessionid' => $facetoface_sess_id, 'userid' => $user_id), $strictness=IGNORE_MISSING);
            
             //print_r($getcurrentstatus); exit();

            if($getcurrentstatus->statuscode == 30)
            {
                $status_array = ['40' => '1','50' => '1','70' => '1','100' => '0'];
            }
            else if($getcurrentstatus->statuscode == 40)
            {
                $status_array = ['50' => '1','70' => '1','100' => '0'];
            }
            else if($getcurrentstatus->statuscode == 50)
            {
                $status_array = ['70' => '1','100' => '0'];
            }
            else if($getcurrentstatus->statuscode == 70)
            {
                $status_array = ['100' => '0'];
            }
            else if($getcurrentstatus->statuscode == 100)
            {
                $status_array = [];
            }
            else
            {
                $status_array = ['30' => '1', '40' => '1','50' => '1','70' => '1','100' => '0'];
            }

            print_r($status_array); //exit();

            if(count($status_array) > 0)
            {
                foreach ($status_array as $key => $value) {
                    $frec_insert = new stdClass();
                    $frec_insert->signupid       = $getcurrentstatus->fid;
                    $frec_insert->statuscode     = $key;
                    $frec_insert->superceded     = $value;
                    //grade, note, advice
                    $frec_insert->createdby      = $user_id;
                    $frec_insert->timecreated    = time();

                    print_r($frec_insert); exit();
                    //$DB->insert_record('facetoface_signups_status', $frec_insert);

                    $sql = 'INSERT INTO mdl_facetoface_signups_status(signupid,statuscode,superceded,createdby,timecreated) VALUES
            (\''.$frec_insert->signupid.'\','.$frec_insert->statuscode.','.$frec_insert->superceded.','.$frec_insert->createdby.',\''.$frec_insert->timecreated.'\')';
            echo $sql; exit();

                    $DB->execute($sql);

                }
            }
           
            if(empty($get_training_sess) || count($get_training_sess) == 0)
            {
                $rec_insert = new stdClass();
                $rec_insert->facetoface_id      = $facetoface_id;
                $rec_insert->facetoface_sess_id = $facetoface_sess_id;
                $rec_insert->facetoface_sess_date_id = $facetoface_sess_date_id;
                $rec_insert->user_id            = $user_id;
                $rec_insert->start_time         = date('Y-m-d H:i:s');
                $rec_insert->journal_id         = 0;
                // print_r($rec_insert); exit();
                // $result  = $DB->insert_record('training_session', $rec_insert, true);

                $ssql = 'INSERT INTO mdl_training_session(facetoface_id,facetoface_sess_id,facetoface_sess_date_id,user_id,start_time,journal_id) VALUES
            (\''.$rec_insert->facetoface_id.'\','.$rec_insert->facetoface_sess_id.','.$rec_insert->facetoface_sess_date_id.','.$rec_insert->user_id.',\''.$rec_insert->start_time.'\''.$rec_insert->journal_id.'\')';
            //echo $sql; exit();

                $DB->execute($ssql);

                if($getcurrentstatus->statuscode != 100)
                {
                    $sql    = "UPDATE mdl_facetoface_signups_status SET superceded = '1' WHERE id=".$getcurrentstatus->id;
                    //echo $sql; exit();
                    $result = $DB->execute($sql);
                }
                
                $message = "Record inserted  successfully!!!";
                $status  = 1;
            }
            else
            {
                $result = $get_training_sess->id;
            }

            $returndata['status']  = $status;
            $returndata['message'] = $message;
            $returndata['result']  = $result;

        }
        else
        {
            $returndata['status']  = 0;
            $returndata['message'] = "Parameter Missing.";
            $returndata['result']  = null;
        }

        echo $data = json_encode($returndata);
    }else if($wsfunction == "set_training_start_time"){
        
        $facetoface_id       = $_POST['facetoface_id'];
        $facetoface_sess_id  = $_POST['facetoface_sess_id'];
        $facetoface_sess_date_id  = $_POST['facetoface_sess_date_id'];
        $user_id             = $_POST['user_id'];
        $status              = 0; 
        $message             = "Record already present!!!";

        if($facetoface_id != '' && $facetoface_sess_id!= ''  && $facetoface_sess_date_id!= ''  && $user_id!= ''){ 
             
            $get_training_sess = $DB->get_record_sql("SELECT id from mdl_training_session where facetoface_id = '$facetoface_id' and facetoface_sess_id = '$facetoface_sess_id' and facetoface_sess_date_id = '$facetoface_sess_date_id' and user_id = '$user_id'");
            // print_r($get_training_sess); exit();

            $query_signup = "SELECT * FROM `mdl_facetoface_signups` WHERE sessionid = ? AND userid = ?";

            $get_signup_id= $DB->get_record_sql($query_signup, array('sessionid' => $facetoface_sess_id, 'userid' => $user_id), $strictness=IGNORE_MISSING);

            //print_r($get_signup_id); exit();

            if(empty($get_signup_id))
            {
            	$fs_insert = new stdClass();
                $fs_insert->sessionid  	= $facetoface_sess_id;
                $fs_insert->userid     	= $user_id;
                $fs_insert->mailedreminder= '0';
                // $fs_insert->discountcode  = null;
                $fs_insert->notificationtype= '3';
                $DB->insert_record('facetoface_signups', $fs_insert);
            }

            $query_signup_status = "SELECT * FROM `mdl_facetoface_signups_status` WHERE signupid = ? AND superceded = ? ORDER BY `id` DESC";
            $getcurrentstatus = $DB->get_record_sql($query_signup_status, array('signupid' => $get_signup_id->id, 'superceded' => 0), $strictness=IGNORE_MISSING);

            //print_r($getcurrentstatus); exit();

            if($getcurrentstatus->statuscode == 30)
            {
                $status_array = ['40' => '1','50' => '1','70' => '1','100' => '0'];
            }
            else if($getcurrentstatus->statuscode == 40)
            {
                $status_array = ['50' => '1','70' => '1','100' => '0'];
            }
            else if($getcurrentstatus->statuscode == 50)
            {
                $status_array = ['70' => '1','100' => '0'];
            }
            else if($getcurrentstatus->statuscode == 70)
            {
                $status_array = ['100' => '0'];
            }
            else if($getcurrentstatus->statuscode == 100)
            {
                $status_array = [];
            }
            else
            {
                $status_array = ['30' => '1', '40' => '1','50' => '1','70' => '1','100' => '0'];
            }

            if(count($status_array) > 0)
            {
                foreach ($status_array as $key => $value) {
                    $frec_insert = new stdClass();
                    $frec_insert->signupid       = $get_signup_id->id;
                    $frec_insert->statuscode     = $key;
                    $frec_insert->superceded     = $value;
                    //grade, note, advice
                    $frec_insert->createdby      = $user_id;
                    $frec_insert->timecreated    = time();
                    $DB->insert_record('facetoface_signups_status', $frec_insert);
                }
                if($getcurrentstatus->statuscode != 100)
                {
                    $sql    = "UPDATE `mdl_facetoface_signups_status` SET `superceded` = '1' WHERE `mdl_facetoface_signups_status`.`id` = ".$getcurrentstatus->id;
                    $result = $DB->execute($sql);
                }
            }
           
            if(empty($get_training_sess) || count($get_training_sess) == 0)
            {
                $rec_insert = new stdClass();
                $rec_insert->facetoface_id      = $facetoface_id;
                $rec_insert->facetoface_sess_id = $facetoface_sess_id;
                $rec_insert->facetoface_sess_date_id = $facetoface_sess_date_id;
                $rec_insert->user_id            = $user_id;
                $rec_insert->start_time         = date('Y-m-d H:i:s');
                $rec_insert->journal_id         = 0;
                $result  = $DB->insert_record('training_session', $rec_insert, true);
                
                $message = "Record inserted  successfully!!!";
                $status  = 1;
            }
            else
            {
                $result = $get_training_sess->id;
            }

            $returndata['status']  = $status;
            $returndata['message'] = $message;
            $returndata['result']  = $result;

        }
        else
        {
            $returndata['status']  = 0;
            $returndata['message'] = "Parameter Missing.";
            $returndata['result']  = null;
        }

        echo $data = json_encode($returndata);
    }else if($wsfunction == "sso"){
        
        $client_id      = 'TEST';
        $client_secret  = 'TEST';
        $device_id      = 'TEST';
        $company_code   =  $_POST['company_code'];
        $employee_code  =  $_POST['employee_code'];
        $login_url      =  "https://" . $_SERVER['SERVER_NAME'] .'/bmai/login/index.php'; 
        
        if($company_code != '' && $employee_code != '' && $client_id != ''&& $client_secret != '' && $device_id != ''){
         
            $sql = "SELECT u.firstaccess,ub.user_id,t.token,u.deleted,u.username FROM mdl_user as u join mdl_user_bulk as ub on u.id = ub.user_id left join mdl_external_tokens as t on ub.user_id = t.userid WHERE ub.company_code='$company_code' and ub.employee_code='$employee_code' and u.deleted = 0 ";
            $query_fetch_user = $DB->get_record_sql($sql);
            if(!empty($query_fetch_user))
            {
                $firstaccess = $query_fetch_user->firstaccess;
                $userid      = $query_fetch_user->user_id;
                $token       = $query_fetch_user->token;
                $username    = $query_fetch_user->username;

                if(!empty($token))
                {
                    if($firstaccess == 0){
                       
                       $up_sql = "UPDATE mdl_user SET firstaccess = '".time()."', lastaccess = '".time()."' WHERE id = ".$userid; 
                        $DB->execute($up_sql); 

                    }else{
                        
                        $up_sql = "UPDATE mdl_user SET lastaccess = '".time()."' WHERE id = ".$userid; 
                        $DB->execute($up_sql); 
                    }
                    $returndata['Token']     = $token;
                    $returndata['userid']    = $userid;
                    $returndata['username']  = $username;
                    $returndata['login_url'] = $login_url;
                }
                else
                {
                    $ch = curl_init();  
                    curl_setopt($ch,CURLOPT_URL,"https://learn.zinghr.com/bmai/login/token.php?username=".$query_fetch_user->username."&password=Test@123&service=moodle_mobile_app");
                    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                    curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true); 
                    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false); 
                    $output = curl_exec($ch);
                    $result = json_decode($output, true);
                    $token  = $result['token'];
                    $returndata['Token']     = $token;
                    $returndata['userid']    = $userid;
                    $returndata['username']  = $username;
                    $returndata['login_url'] = $login_url;
                }

                $str       =  'username -'.$username; // 'a:1:{s:8:\"username\";s:29:\"'.$username.'\";}';
                $eventname = "core_event_user_loggedin"; //"\core\event\user_loggedin";
                $sql_query = "INSERT INTO `mdl_logstore_standard_log` (`id`, `eventname`, `component`, `action`, `target`, `objecttable`, `objectid`, `crud`, `edulevel`, `contextid`, `contextlevel`, `contextinstanceid`, `userid`, `courseid`, `relateduserid`, `anonymous`, `other`, `timecreated`, `origin`, `ip`, `realuserid`) VALUES (NULL, '".$eventname."', 'core', 'loggedin', 'user', 'user', '".$userid."', 'r', '0', '1', '10', '0', '".$userid."', '0', NULL, '0', '".$str."', '".time()."', 'mobile', 'mobile', NULL)";
                $DB->execute($sql_query);
                echo $data = json_encode($returndata);
            }
            else
            {
               echo $data = json_encode(['Token'=>null, 'userid'=> 0]);
            }

        }else{
            echo $data = json_encode(['Message'=>'Some parameters is missing ']);
        }
    }else if($wsfunction == "add_notification_details"){

        $user_id    = $_POST['user_id'];
        $player_id  = $_POST['player_id'];
        $returndata = array();
        if($user_id != '' && $player_id != '')
        {
            try {
                $qry   =  " SELECT *
                        FROM mdl_push_notification as p
                        WHERE p.user_id = $user_id
                        AND p.player_id = '$player_id'";
                $fetch_rec = $DB->get_record_sql($qry);

                if(!empty($fetch_rec))
                {
                    //print_r($fetch_rec->status); exit();
                    if($fetch_rec->status == "A")
                    {
                        $message = "Record already present!!!";
                        $status  = 0;
                    }
                    else
                    {
                        /*$record_upd = new stdClass();
                        $record_upd->id     = $fetch_rec->id;
                        $record_upd->status = 'A';
                        $ans = $DB->update_record('push_notification',$record_upd,true);
                        */
                        $sql    = "UPDATE mdl_push_notification SET status = 'A' WHERE id = ".$fetch_rec->id;
                        $result = $DB->execute($sql);

                        //print_r($result); exit();

                        $qry_player  = "SELECT *
                                    FROM mdl_push_notification as p
                                    WHERE p.player_id = '$player_id' 
                                    and p.user_id != '$user_id'";
                        $fetch_player_rec = $DB->get_records_sql($qry_player);

                        if(!empty($fetch_player_rec))
                        {
                            foreach ($fetch_player_rec as $key => $value) {
                                  /*
                                  $record_upd = new stdClass();
                                  $record_upd->id     = $value->id;
                                  $record_upd->status = 'D';
                                  $DB->update_record('push_notification',$record_upd,true);
                                  */
                                  $sql    = "UPDATE mdl_push_notification SET status = 'D' WHERE id = ".$value->id;
                                  $DB->execute($sql);
                            }
                              
                        }

                        $message = "Player id is activated successfully!!!";
                        $status  = 0;

                    }
                    
                }
                else
                { 
                    $qry_player  = "SELECT *
                                    FROM mdl_push_notification as p
                                    WHERE p.player_id = '$player_id'";
                    $fetch_player_rec = $DB->get_records_sql($qry_player);

                    if(!empty($fetch_player_rec))
                    {
                        foreach ($fetch_player_rec as $key => $value) {
                              /*
                              $record_upd = new stdClass();
                              $record_upd->id     = $value->id;
                              $record_upd->status = 'D';
                              $DB->update_record('push_notification',$record_upd,true);
                              */
                              $sql    = "UPDATE mdl_push_notification SET status = 'D' WHERE id = ".$value->id;
                              $DB->execute($sql);
                        }
                          
                    }

                    $record = new stdClass();
                    $record->user_id     = $user_id;
                    $record->player_id   = $player_id;
                    $DB->insert_record('push_notification',$record,true);

                    $message = "Record inserted  successfully!!!";
                    $status  = 1;

                } 

            } catch (Exception $e) {
                echo "error - ".$e;
            }
        }
        else
        {
            $message = "Parameter missing.";
            $status  = 0;
        }
          
        $returndata['status']  = $status;
        $returndata['message'] = $message;

        echo $data = json_encode($returndata);
    }else if($wsfunction == "dashboard_stats"){
        $wsToken        = $_POST['wsToken'];
        $employee_code  = $_POST['employee_code'];
        $company_code   = $_POST['company_code'];
      
        if($wsToken != '' && $employee_code!= '' && $company_code != '' )
        {   
             
            $query_fetch_user = $DB->get_record_sql("SELECT u.id as userid,u.username FROM mdl_user_bulk as ub LEFT JOIN mdl_user as u ON ub.user_id = u.id LEFT JOIN mdl_external_tokens as et ON u.id = et.userid WHERE ub.employee_code = '$employee_code' && ub.company_code = '$company_code' && et.token = '$wsToken'"); 
          
            if(!empty($query_fetch_user))
            {
                $userid       = $query_fetch_user->userid;
                $username     = $query_fetch_user->username;
                $currenttime  = time();
                $time         = time();
                $query_course = $DB->get_records_sql(" 
                                                SELECT 
                                                c.id AS courseid,c.fullname as coursefullname,c.summary as 'summary',c.category as categoryid, c.startdate as 'startdate',c.enddate as 'enddate' 
                                                FROM {user} u
                                                LEFT JOIN {user_enrolments} ue ON ue.userid = u.id
                                                LEFT JOIN {enrol} e ON e.id = ue.enrolid
                                                LEFT JOIN {course} c ON e.courseid = c.id 
                                                WHERE u.id=$userid and c.visible = 1 and c.category != 0 
                                                group by c.id
                                                order by c.fullname asc");

                $completionstatus      =  array();
                $finalCompletionModule =  0;
                $finalTotalModule      =  0;
                $overall               = array();
                if(!empty($query_course))
                {
                    $datewisemodule   = array();
                    $datewisetimeline = array();
                    $enrolled_course  = array();

                    foreach($query_course as $rs_course)
                    {
                        //print_r($rs_course); exit();

                        $enrolled_course[]  = $rs_course->courseid;
                        $rs_course->summary = strip_tags($rs_course->summary);
                        $courseid           = $rs_course->courseid;
                        $startdate          = $rs_course->startdate;
                        $enddate            = $rs_course->enddate;

                        //print_r($courseid); print_r($userid);
                        $query_course_comp = $DB->get_record_sql(" 
                            SELECT * FROM mdl_course_completions WHERE userid = $userid and course = $courseid and timecompleted IS NOT NULL");
                        
                        if(!empty($query_course_comp))
                        {
                            $rs_course->completepercent = (int) 100;
                        }
                        else
                        {
                            // $qry = "SELECT count(instance) as 'ti' from {course_modules} where course = $courseid and module in ('7','16','17','18','20','26') and deletioninprogress=0";
                            $qry = "SELECT count(instance) as 'ti' from {course_modules} where course = $courseid and deletioninprogress = 0 and module != 9";
                            //print_r($qry); exit();
                            $query_course_module    = $DB->get_record_sql($qry);
                            $total_module           = !empty($query_course_module) ? $query_course_module->ti : 0;
                            $rs_course->totalmodule = $total_module;
                  
                            // $qry="select count(DISTINCT coursemoduleid) as tcm from {course_modules_completion} where coursemoduleid in (SELECT id FROM {course_modules} where course = $courseid and module in ('7','16','17','18','20','26') and deletioninprogress=0) and userid = $userid";
                            $qry="select count(DISTINCT coursemoduleid) as tcm from {course_modules_completion} where coursemoduleid in (SELECT id FROM {course_modules} where course = $courseid and deletioninprogress = 0 and module != 9) and userid = $userid and completionstate = 1";
                            $query_quiz_summery = $DB->get_record_sql($qry);
                            $total_completion   = !empty($query_quiz_summery) ? $query_quiz_summery->tcm : 0;
                            $rs_course->completedmodule = $total_completion;
                            $completionpercent          = (int) (($total_completion / $total_module) * 100);
                            $rs_course->completepercent = $completionpercent;
                        }
              
                        $timeline=array();
                        $query_quizes = $DB->get_records_sql("select cm.id as 'cmid', cm.module as 'mid', c.fullname as 'course', q.name as 'course_module', q.timeclose as 'timeclose' from mdl_course_modules as cm left join mdl_quiz as q on cm.instance = q.id left join mdl_course as c on q.course = c.id where cm.deletioninprogress = 0 and cm.course =$courseid and cm.module = 16 and q.timeclose > $time and c.enddate != 0");
                        foreach($query_quizes as $rs_quizes)
                        {
                            $module_details=array();
                            $module_details['cmid']=$rs_quizes->cmid;
                            $module_details['mid']=$rs_quizes->mid;
                            $module_details['course']=$rs_quizes->course;
                            $module_details['course_module']=$rs_quizes->course_module;
                            $module_details['timeclose']=$rs_quizes->timeclose;
                            $timeline[]=$module_details;
                        }

                        $query_assign = $DB->get_records_sql("select cm.id as 'cmid', cm.module as 'mid', c.fullname as 'course', a.name as 'course_module', a.duedate as 'timeclose' from mdl_course_modules as cm left join mdl_assign as a on cm.instance = a.id left join mdl_course as c on a.course = c.id where cm.deletioninprogress = 0 and cm.course =$courseid and cm.module = 1 and a.duedate > $time and c.enddate != 0");
                        foreach($query_assign as $rs_assign)
                        {
                            $module_details=array();
                            $module_details['cmid']=$rs_assign->cmid;
                            $module_details['mid']=$rs_assign->mid;
                            $module_details['course']=$rs_assign->course;
                            $module_details['course_module']=$rs_assign->course_module;
                            $module_details['timeclose']=$rs_assign->timeclose;
                            $timeline[]=$module_details;
                        }
                          
                        usort($timeline, function($a, $b) {
                            if($a['timeclose']==$b['timeclose']) return 0;
                            return $a['timeclose'] < $b['timeclose']?1:-1;
                        });
            
                        $timeline1  = array();
                        $time7      = $time+(60*60*24*7);
                        $time30     = $time+(60*60*24*30);

                        foreach($timeline as $val)
                        {
                            $endtime=$val['timeclose'];
                            if($endtime > $time)
                            {
                              $timeline1['within7'][]=$val;
                            }
                            if($endtime > $time7 && $endtime < $time30)
                            {
                              $timeline1['within30'][]=$val;
                            }
                            if($endtime > $time30)
                            {
                              $timeline1['future'][]=$val;
                            }     
                            
                        }

                        $rs_course->timeline    = $timeline1;
                        $finalTotalModule       = $finalTotalModule + $rs_course->totalmodule;
                        $finalCompletionModule  = $finalCompletionModule + $rs_course->completedmodule;
                        //print_r($enddate); exit();

                        if($enddate < $currenttime && $enddate != 0)
                        {
                            $completionstatus['past'][] = $rs_course;
                        }
                        else if($startdate > $currenttime)
                        {
                            $completionstatus['future'][] = $rs_course;
                        }
                        else
                        {
                            // $rs_course->timeline    = $timeline1;
                            // $finalTotalModule       = $finalTotalModule + $rs_course->totalmodule;
                            // $finalCompletionModule  = $finalCompletionModule + $rs_course->completedmodule;
                            $completionstatus['inprogress'][]=$rs_course;
                        }
              
                    }
                      
                    $enrolled_course=implode(',',$enrolled_course);
                  
                    if(!empty($enrolled_course))
                    {
                        $query_quizes = $DB->get_records_sql("select cm.id as 'cmid', cm.module as 'mid', c.fullname as 'course', q.name as 'course_module', q.timeclose as 'timeclose' from mdl_course_modules as cm left join mdl_quiz as q on cm.instance = q.id left join mdl_course as c on q.course = c.id where cm.deletioninprogress = 0 and cm.course in($enrolled_course) and cm.module = 16 and q.timeclose > $time");
                        foreach($query_quizes as $rs_quizes)
                        {
                            $module_details=array();
                            $module_details['cmid']=$rs_quizes->cmid;
                            $module_details['mid']=$rs_quizes->mid;
                            $module_details['course']=$rs_quizes->course;
                            $module_details['course_module']=$rs_quizes->course_module;
                            $module_details['timeclose']=$rs_quizes->timeclose;
                            $datewisetimeline[]=$module_details;
                        }

                        $query_assign = $DB->get_records_sql("select cm.id as 'cmid', cm.module as 'mid', c.fullname as 'course', a.name as 'course_module', a.duedate as 'timeclose' from mdl_course_modules as cm left join mdl_assign as a on cm.instance = a.id left join mdl_course as c on a.course = c.id where cm.deletioninprogress = 0 and cm.course in($enrolled_course) and cm.module = 1 and a.duedate > $time");
                        foreach($query_assign as $rs_assign)
                        {
                            $module_details=array();
                            $module_details['cmid']=$rs_assign->cmid;
                            $module_details['mid']=$rs_assign->mid;
                            $module_details['course']=$rs_assign->course;
                            $module_details['course_module']=$rs_assign->course_module;
                            $module_details['timeclose']=$rs_assign->timeclose;
                            $datewisetimeline[]=$module_details;
                        }
                        usort($datewisetimeline, function($a, $b) {
                            if($a['timeclose'] == $b['timeclose']) return 0;
                            return $a['timeclose'] < $b['timeclose']?1:-1;
                        });
                    }

                    $datewise = array();
                    $time7    = $time+(60*60*24*7);
                    $time30   = $time+(60*60*24*30);

                    foreach($datewisetimeline as $val)
                    {
                        $endtime=$val['timeclose'];
                        if($endtime > $time)
                        {
                          $datewise['within7'][]=$val;
                        }
                        if($endtime > $time7 && $endtime < $time30)
                        {
                          $datewise['within30'][]=$val;
                        }
                        if($endtime > $time30)
                        {
                          $datewise['future'][]=$val;
                        }     
                        
                    }

                      // print_r($finalTotalModule); 
                      // print_r($finalCompletionModule);
                      // print_r((($finalCompletionModule/$finalTotalModule) * 100 ));
                      

                    $overall['TotalModule']             = $finalTotalModule;
                    $overall['TotalCompleteModule']     = $finalCompletionModule;
                    $overall['finalCompletionpercent']  = (($finalCompletionModule/$finalTotalModule) * 100 );

                    $returndata['courses']              = $completionstatus;
                    $returndata['overall']              = $overall;
                    $returndata['timeline_datewise']    = $datewise;

                      // print_r($overall);
                      // //print_r($returndata);
                      // exit();
                    //print_r($courseid); exit();
                    $str       =  'N'; // 'a:1:{s:8:\"username\";s:29:\"'.$username.'\";}';
                    $eventname = "core_event_dashboard_viewed"; //"\core\event\user_loggedin";
                    $sql_query = "INSERT INTO `mdl_logstore_standard_log` (`id`, `eventname`, `component`, `action`, `target`, `objecttable`, `objectid`, `crud`, `edulevel`, `contextid`, `contextlevel`, `contextinstanceid`, `userid`, `courseid`, `relateduserid`, `anonymous`, `other`, `timecreated`, `origin`, `ip`, `realuserid`) VALUES (NULL, '".$eventname."', 'core', 'viewed', 'dashboard', '', '0', 'r', '0', '5', '30', '2', '".$userid."', '".$courseid."', '0', '0', '".$str."', '".time()."', 'mobile', 'mobile', NULL)";
                    $DB->execute($sql_query);

                    echo $data = json_encode($returndata);
                }else{
                    echo $data = json_encode(['Message' => 'No course Enrol for this user']);
                }

            }else{
                echo $data = json_encode(['Message'=>'Invalid Api Token']);
            }
        }else{
            echo $data = json_encode(['Message'=>'Parameters are missing']);
        }

    }else{
       echo $data = json_encode(['Message'=>'Function Name Parameter wsfunction is missing']);
    }
?>