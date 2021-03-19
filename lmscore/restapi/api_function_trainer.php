<?php
/* 
  @author: Suniti Yadav 
  description : Having Trainer related API's
*/

require_once '../config.php';
require_once($CFG->libdir.'/moodlelib.php');
require_once 'src/Mandrill.php'; 
$mandrill = new Mandrill($CFG->md_api_key);

global $DB, $CFG, $SESSION, $USER;

$current_url = "https://" . $_SERVER['SERVER_NAME'] . $_SERVER['REQUEST_URI'];
$base_url    = explode('/restapi/api_function_trainer.php', $current_url);
if(empty($CFG->wwwroot))
{
  $CFG->wwwroot     = $base_url[0];
}

$admins             = $DB->get_record_sql("SELECT c.value FROM `mdl_config` as c where c.name = 'siteadmins'");
$CFG->admins        = $admins->value;
$CFG->root_dir      = "/var/www/html/".$CFG->dbname."/lmscore/";

header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: access");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Allow-Credentials: true");
header('Content-Type: application/json');
header("HTTP/1.0 200 Successfull operation");
// echo '=============+++++++';exit;
    $wsfunction = $_POST['wsfunction'];  
    $response = array();
    
	if($wsfunction == "get_trainer_sessions"){
        $wsToken       = $_POST['wsToken'];
        $employee_code = $_POST['employee_code'];
        $company_code  = $_POST['company_code'];
        $session_type  = $_POST['session_type'];
        $qry 		   = "";
        // print_r($session_type); //exit();

            if($wsToken != '' && $employee_code!= '' && $company_code != ''){ 
               $query_fetch_user = $DB->get_records_sql("SELECT u.id as userid FROM mdl_user as u LEFT JOIN mdl_external_tokens as et ON u.id = et.userid WHERE u.employee_code = '$employee_code' && u.company_code = '$company_code' && et.token = '$wsToken'");
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
    }else if($wsfunction == "get_trainer_facetoface_sessions"){
        $wsToken       = $_POST['wsToken'];
        $employee_code = $_POST['employee_code'];
        $company_code  = $_POST['company_code'];
        $session_type  = $_POST['session_type'];
        $status        = 0;
        $message       = "Session not Available.";
        $result        = [];
        $user_arr      = $CFG->admins;

        if($wsToken != '' && $employee_code!= '' && $company_code != '' && $session_type != ''){ 
          
            $query_fetch_user = $DB->get_record_sql("SELECT u.id as userid FROM mdl_user as u LEFT JOIN mdl_external_tokens as et ON u.id = et.userid WHERE u.employee_code = '$employee_code' && u.company_code = '$company_code' && et.token = '$wsToken'" );

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
                        
                if(count($result) > 0)
                {   
                    foreach($result as $rs_fetch)
                    {  
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
                                WHERE  f.id = $rs_fetch->facetofaceid
                                AND fs.id = $rs_fetch->facetofacesession
                                AND fsd.id = $rs_fetch->facetofacesessiondates
                                AND fsps.statuscode = 70
                                GROUP BY f.id,fsps.signupid 
                                ORDER BY f.id DESC";

                        $fetch_attendee = $DB->get_records_sql($qry);

                        $jrqry = "SELECT t.start_time,t.end_time,j.file_name
                                FROM mdl_training_session as t
                                left JOIN mdl_journal as j
                                ON t.journal_id = j.id 
                                WHERE  t.facetoface_id = $rs_fetch->facetofaceid
                                AND t.facetoface_sess_id = $rs_fetch->facetofacesession
                                AND t.facetoface_sess_date_id = $rs_fetch->facetofacesessiondates";


                        $fetch_journal = $DB->get_record_sql($jrqry);
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
                        $fetch_event_data[] = array_merge($arr_mrg,$additional_fields);
                        
                       /* else
                        {
                            $get_loc_data   = explode(',', $rs_fetch->loc_data);
                            $get_loc_desc   = explode(',', $rs_fetch->location_description);
                            $arr            = array_combine($get_loc_desc, $get_loc_data);
                        }
                        $fetch_array1       = json_decode(json_encode($rs_fetch), true); 
                        $arr_mrg            = array_merge($fetch_array1,$arr);
                        $fetch_event_data[] = array_merge($arr_mrg,$additional_fields);
                        */
                        
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
    }else if($wsfunction == "get_facetoface_signup_users"){
        
        $wsToken                = $_POST['wsToken'];
        $facetofaceId           = $_POST['facetoface_id'];
        $facetofacesession      = $_POST['facetofacesession'];
        $facetofacesessiondates = $_POST['facetofacesessiondates'];

        $fetch_event_data = [];
        $qry           = "";
        $status        = 0; 

        if($wsToken != '' && $facetofaceId!= ''){ 

            $qry = " SELECT u.id as user_id,
                    u.country,
                    u.region,
                    u.department,
                    u.employee_code,
                    concat(u.firstname, u.lastname) as employee_name,
                    u.designation,
                    f.id as facetoface_id,
                    u.firstname, u.lastname, 
                    u.email, 
                    u.gender,
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
                    WHERE  f.id = $facetofaceId
                    AND fs.id = $facetofacesession
                    AND fsd.id = $facetofacesessiondates
                    AND fsps.statuscode = 70
                    GROUP BY f.id,fsps.signupid,u.gender,fsps.id
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

                $get_noti = $DB->get_records_sql("SELECT player_id from mdl_push_notification where user_id = '$rs_fetch_event->user_id' and status = 'A'");
                //print_r($get_noti); //exit();
                $player_id = array();
                foreach ($get_noti as $key1 => $value1) {
                   $player_id[] = $value1->player_id;
                }
                //print_r($player_id); exit();
                $rs_fetch_event->player_id  = $player_id; //isset($get_noti)?$get_noti:[];//$get_noti->player_id;
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
               $query_fetch_user = $DB->get_record_sql("SELECT u.id as userid FROM mdl_user as u LEFT JOIN mdl_external_tokens as et ON u.id = et.userid WHERE u.employee_code = '$employee_code' && u.company_code = '$company_code' && et.token = '$wsToken'");
                
                if(!empty($query_fetch_user)){
                    
                    $userid = $query_fetch_user->userid;
                    $ctime  = time(); 

                    // $qry = "SELECT f.id,f.name
                    //         FROM mdl_course as c
                    //         JOIN mdl_facetoface as f
                    //         ON f.course = c.id
                    //         WHERE c.id = $courseid";

                    $qry = "SELECT f.id,f.name
                            FROM mdl_modules as m
                            join mdl_course_modules as cm on cm.module = m.id
                            JOIN mdl_facetoface as f ON f.id = cm.instance
                            join mdl_course as c on c.id = f.course
                            WHERE m.name = 'facetoface'
                            and cm.deletioninprogress = 0 
                            and c.id = $courseid";

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
                
                // $query_fetch_user = $DB->get_record_sql(" SELECT u.*,ub.managersemail,ub.reporting_manager_id,au.email as manager_email,CONCAT(au.firstname, ' ', au.lastname) AS manager_name,aau.email as rep_manager_email,CONCAT(aau.firstname, ' ', aau.lastname) AS rep_manager_name 
                //             FROM `mdl_user` as u 
                //             left join `mdl_user_bulk` as ub on u.id = ub.user_id 
                //             left JOIN `mdl_user` as au ON ub.managersemail = au.email 
                //             left JOIN `mdl_user` as aau ON ub.reporting_manager_id = aau.id
                //             WHERE u.id = '$userid'");

                $query_fetch_user = $DB->get_record_sql("SELECT u.*,u.reporting_manager_code FROM mdl_user as u LEFT JOIN mdl_external_tokens as et ON u.id = et.userid WHERE u.employee_code = '$employee_code' and u.deleted = 0 and u.company_code = '$company_code' and et.token = '$wsToken'");

                if(!empty($query_fetch_user)){
                    $query_fetch_manager = $DB->get_record_sql("SELECT u.* FROM mdl_user as u WHERE u.employee_code = '$query_fetch_user->reporting_manager_code'");
                }

                $managers_email = $query_fetch_manager->email;
                $get_course     = $DB->get_record('course',array('id' => $courseid));
                $get_category   = $DB->get_record_sql("SELECT * FROM `mdl_course_categories` where id = '$get_course->category'");
                $get_category_name = $get_category->plain_name;
                $portal_link    = "https://portal.zinghr.com";
                 
                $messagehtml = "<p> Dear ".$query_fetch_manager->firstname.",<br><br> 
                Your Associate ".$query_fetch_user->firstname." ".$query_fetch_user->lastname." has nominated himself/herself for attending the Course <b>".$get_course->fullname."</b>.Training Event Scheduled On ".$timestart." to ".$timefinish." at <br>
                Location    : ".$location." <br> 
                Venue       : ".$venue." <br> 
                Room        : ".$room." <br>
                Kindly click on the link to approve / reject the same. <br> 
                ".$CFG->wwwroot."/mod/facetoface/attendees.php?s=".$session_id."#unapproved <br>
                To know more about the training program click here ".$portal_link." <br> 
                NOTE : [ For LMS navigation - Please login with Portal Link and then click on LMS icon .You will land on 'Home' page of LMS. Click on category <b>".$get_category_name." </b>, with in this you will get course <b>".$get_course->fullname." </b> ] <br>
                Happy Learning !!<br><br> 
                Regards,<br>
                <i>ZingHR Learning & Development Team </i> </p> ";

                $subject     = " Course booking  request for <b>".$get_course->fullname."</b>";
                 
                $message = new stdClass();
                $message->html = $messagehtml;
                $message->text = "Congrats";
                $message->subject = $subject;
                $message->from_email = "zinghr@support.com";
                $message->from_name  = "Admin (via ZingHrLearn)";
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
        
        $facetoface_id       = $_POST['facetoface_id'];
        $facetoface_sess_id  = $_POST['facetoface_sess_id'];
        $facetoface_sess_date_id  = $_POST['facetoface_sess_date_id'];
        $user_id             = $_POST['user_id'];
        $file                = $_FILES['file'];
        $status              = 0; 
        $message             = "File not uploaded !!!";
        $returndata          = [];

        if($facetoface_id != '' && $facetoface_sess_id != ''  && $facetoface_sess_date_id != ''  && $user_id != ''  && $file != ''){ 
             
            if($_FILES["file"]["error"] == UPLOAD_ERR_NO_FILE){
                $message = "Please, Select the file to upload!!!";
            }else{

                // ini_set('post_max_size', '2M');
                // ini_set('upload_max_filesize', '2M');

                $root_dir = $CFG->root_dir;

                if (!file_exists($root_dir.'assets/img/'.$user_id)) {
                    mkdir($root_dir.'assets/img/'.$user_id, 0777, true);
                }

                $is_uploaded = move_uploaded_file($_FILES["file"]["tmp_name"], $root_dir."assets/img/".$user_id."/".$_FILES["file"]["name"]);
                
                // $file_get    = file_get_contents($_FILES["file"]["tmp_name"]);
                // $is_uploaded = file_put_contents("/var/www/html/sunpharmalive/lms/assets/img/".$user_id."/".$_FILES["file"]["name"],$file_get);


                if($is_uploaded == 1)
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

            $returndata['status']  = $status;
            $returndata['message'] = $message;
            $returndata['name'] = $_FILES["file"]["name"];
            echo $data = json_encode($returndata);
        }else{
            if($facetoface_id == '')
            {
                $returndata[] = 'facetoface_id';
            }
            if($facetoface_sess_id == '')
            {
                $returndata[] = 'facetoface_sess_id';
            }
            if($facetoface_sess_date_id == '')
            {
                $returndata[] = 'facetoface_sess_date_id';
            }
            if($user_id == '')
            {
                $returndata[] = 'user_id';
            }
            if($file == '')
            {
                $returndata[] = 'file';
            }

            echo $data = json_encode(['Message'=>'Parameters are missing', 'data' => $returndata]);
        }
    }else if($wsfunction == "delete_pics"){
        
        $facetoface_id       = $_POST['facetoface_id'];
        $facetoface_sess_id  = $_POST['facetoface_sess_id'];
        $facetoface_sess_date_id  = $_POST['facetoface_sess_date_id'];
        $user_id             = $_POST['user_id'];
        $file_path           = $_POST['file_path'];
        $file_id             = $_POST['file_id'];
        $status              = 0; 
        $message             = "file deleted successfully!!";
        $returndata          = [];

        if($facetoface_id != '' && $facetoface_sess_id != ''  && $facetoface_sess_date_id != ''  && $user_id != ''  && $file_path != '' && $file_id != ''){ 
                // print 'pass_1';
                $root_dir = $CFG->root_dir; //"/var/www/html/sunpharmalive/lms/";
                unlink($root_dir."assets/img".$file_path);
                // print $res;
                // print "/var/www/html/sunpharmalive/lms/assets/img".$file_path;
                $sql = "DELETE FROM mdl_upload_gallery WHERE id=".$file_id;
                $DB->execute($sql);
                // $sql = "DELETE FROM mdl_upload_gallery WHERE id=$file_id";
                // $DB->delete_records_select('upload_gallery', 'id = $file_id');
                // print 'pass_2';
                // if ($DB->query($sql) === TRUE) {
                //     print 'err4';
                //      echo "Record deleted successfully";
                // } else {
                //     print 'err5';
                //     echo "Error deleting record: " . $DB->error;
                // }
                $status  = 1;
                $returndata['status']  = $status;
                $returndata['message'] = $message;
                print 'err4';
            echo $data = json_encode($returndata);
        }else{
            if($facetoface_id == '')
            {
                $returndata[] = 'facetoface_id';
            }
            if($facetoface_sess_id == '')
            {
                $returndata[] = 'facetoface_sess_id';
            }
            if($facetoface_sess_date_id == '')
            {
                $returndata[] = 'facetoface_sess_date_id';
            }
            if($user_id == '')
            {
                $returndata[] = 'user_id';
            }
            if($file == '')
            {
                $returndata[] = 'file';
            }
            if($file_path == ''){
                $returndata[] = 'file_path';
            }
            if($file_id == ''){
                $returndata[] = 'file_id';
            }

            echo $data = json_encode(['Message'=>'Parameters are missing', 'data' => $returndata]);
        }
    }else if($wsfunction == "get_gallery"){

        $facetoface_id       = $_POST['facetoface_id'];
        $facetoface_sess_id  = $_POST['facetoface_sess_id'];
        $facetoface_sess_date_id  = $_POST['facetoface_sess_date_id'];
        $user_id             = $_POST['user_id'];
        $status              = 0; 
        $message             = " Gallery not found for this session.";
        $fetch_event_data    = [];

        if($facetoface_id != '' && $facetoface_sess_id!= ''  && $facetoface_sess_date_id!= ''  && $user_id!= ''){ 
             
            $qry =  "SELECT *
                    FROM mdl_upload_gallery as ug
                    WHERE ug.facetoface_id = $facetoface_id
                    AND ug.facetoface_sess_id = $facetoface_sess_id
                    AND ug.facetoface_sess_date_id= $facetoface_sess_date_id
                    AND ug.user_id = $user_id";

            $fetch_gallery = $DB->get_records_sql($qry);

            $message="Gallery not found for this session.";
            if(count($fetch_gallery) > 0)
            {
                foreach($fetch_gallery as $rs_fetch)
                {
                    $details['image_path'] = $CFG->wwwroot."/assets/img/".$user_id."/".$rs_fetch->pic_name;
                    $fetch_array1       = json_decode(json_encode($rs_fetch), true);
                    $fetch_event_data[] = array_merge($fetch_array1,$details);
                    $status=1;
                    $message="Gallery found for this session.";
                }
            }
           

            $returndata['status']  = $status;
            $returndata['message'] = $message;
            $returndata['result']  = $fetch_event_data;
            echo $data = json_encode($returndata);
        }
        else
        {
            if($facetoface_id == '')
            {
                $returndata[] = 'facetoface_id';
            }
            if($facetoface_sess_id == '')
            {
                $returndata[] = 'facetoface_sess_id';
            }
            if($facetoface_sess_date_id == '')
            {
                $returndata[] = 'facetoface_sess_date_id';
            }
            if($user_id == '')
            {
                $returndata[] = 'user_id';
            }

            echo $data = json_encode(['Message'=>'Parameters are missing', 'data' => $returndata]);
        }
    }else if($wsfunction == "get_trainees"){
        
        $facetoface_sess_id  = $_POST['facetoface_sess_id'];
        $status              = 0; 
        $message             = "Record not found successfully!!!";

        if($facetoface_sess_id!= ''){ 
             
            $get_trainees = $DB->get_records_sql("SELECT u.id,u.employee_code,u.firstname,u.lastname,u.email FROM `mdl_facetoface_signups` as s join mdl_facetoface_signups_status as ss on s.id = ss.signupid left join mdl_user as u on u.id = s.userid WHERE s.`sessionid` = '$facetoface_sess_id' and ss.statuscode = 100 and ss.superceded = 0");
           
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
    }else if($wsfunction == "set_training_start_time"){
        
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
            if(empty($get_signup_id))
            {
                $fs_insert = new stdClass();
                $fs_insert->sessionid   = $facetoface_sess_id;
                $fs_insert->userid      = $user_id;
                $fs_insert->mailedreminder= '0';
                // $fs_insert->discountcode  = null;
                $fs_insert->notificationtype= '3';
                $DB->insert_record('facetoface_signups', $fs_insert);
            }

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
    }else if($wsfunction == "set_training_end_time"){
        
        $training_session    = $_POST['id'];
        $user_id             = $_POST['user_id'];
        //$courseid            = $_POST['course'];
        $course_name         = $_POST['course_name'];
        $file_name           = $_POST['file_name'];
        $journal_id          = $_POST['journal_id'];
        $status              = 0; 
        $message             = "Record not updated successfully!!!";

        if($training_session != '' && $user_id != '' && $course_name != '' && $file_name != '' && $journal_id != ''){ 

            $sql    = "UPDATE mdl_training_session SET end_time = '".date('Y-m-d H:i:s')."',journal_id = ".$journal_id." WHERE id=".$training_session;
            $result = $DB->execute($sql);

            if($result)
            {
                //$get_course     = $DB->get_record('course',array('id' => $courseid));
                // $get_user       = $DB->get_record_sql("SELECT u.*,ub.managersemail,ub.reporting_manager_id,au.email as manager_email,CONCAT(au.firstname, ' ', au.lastname) AS manager_name,aau.email as rep_manager_email,CONCAT(aau.firstname, ' ', aau.lastname) AS rep_manager_name FROM `mdl_user` as u join `mdl_user_bulk` as ub on u.id = ub.user_id JOIN `mdl_user` as au ON ub.managersemail = au.email JOIN `mdl_user` as aau ON ub.reporting_manager_id = aau.id WHERE u.`id` = $user_id");

                $query_fetch_user = $DB->get_record_sql("SELECT u.*,u.reporting_manager_code FROM mdl_user as u WHERE u.`id` = $user_id");

                if(!empty($query_fetch_user)){
                    $query_fetch_manager = $DB->get_record_sql("SELECT u.* FROM mdl_user as u WHERE u.employee_code = '$query_fetch_user->reporting_manager_code'");
                }

                $managers_email = !empty($query_fetch_manager)?$query_fetch_manager->email:''; //$get_user->managersemail;
                $portal_link    = "https://portal.zinghr.com";

                $messagehtml    = "<p>Dear ".$query_fetch_manager->firstname.",<br><br> 
                This is to notify that ".$query_fetch_user->firstname." ".$query_fetch_user->lastname." has completed the facetoface training session name <b> ".$course_name." </b> <br> 
                Click on the link to access the submitted journal by the trainer. <br> ".$portal_link." <br> [ NOTE : LMS Link - ".$CFG->wwwroot."/assets/journal/".$user_id."/".$file_name." ]<br> 
                Happy Learning !! <br><br> 
                Regards, <br> 
                <i> ZingHR Learning & Development Team </i></p>";
                
                $subject    = "Facetoface training completion notification";
             

                $message = new stdClass();
                $message->html = $messagehtml;
                $message->text = "Congrats";
                $message->subject = $subject;
                $message->from_email = "zinghr@support.com";
                $message->from_name  = "Admin (via ZingHrLearn)";
                $message->to = array(array("email" => $managers_email));
                $message->track_opens = true;

                $response = $mandrill->messages->send($message);
                $message->to = array(array("email" => $query_fetch_user->email));
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
               $query_fetch_user = $DB->get_records_sql("SELECT u.id as userid FROM mdl_user as u LEFT JOIN mdl_external_tokens as et ON u.id = et.userid WHERE u.employee_code = '$employee_code' && u.company_code = '$company_code' && et.token = '$wsToken'");
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

            $qry     =  "SELECT `country` FROM `mdl_user` WHERE id = '$get_journal->country'";
            $get_country = $DB->get_record_sql($qry);

            $record->employee_code      = isset($get_journal->employee_code)?$get_journal->employee_code:null;
            $record->user_id            = isset($get_journal->user_id)?$get_journal->user_id:null;
            $record->facetofaceid       = isset($get_journal->facetofaceid)?$get_journal->facetofaceid:null;
            $record->facetofacesession  = isset($get_journal->facetofacesession)?$get_journal->facetofacesession:null;
            $record->token              = isset($get_journal->token)?trim(preg_replace('/[^A-Za-z0-9\.\,\'@!-& ]/', '', $get_journal->token),' '):null;
            $record->program_name       = isset($get_journal->program_name)?trim(preg_replace('/[^A-Za-z0-9\.\,\'@!-& ]/', '', $get_journal->program_name),' '):null;
            $record->trainer_name       = isset($get_journal->trainer_name)?trim(preg_replace('/[^A-Za-z0-9\.\,\'@!-& ]/', '', $get_journal->trainer_name),' '):null;
            // $record->country            = isset($get_journal->country)?trim(preg_replace('/[^A-Za-z0-9\.\,\'@!-& ]/', '', $get_journal->country),' '):null;
            $record->country            = $get_country->country;
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
                    $root_dir = $CFG->root_dir; //"/var/www/html/sunpharmalive/lms/";

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

                $get_qry     =  " SELECT CONCAT(u.firstname, ' ', u.lastname) as username FROM `mdl_user` as u WHERE u.id = '$get_journal->user_id'";
                $get_user    = $DB->get_record_sql($get_qry);
                $get_user_name = $get_user->username;
                // print_r($get_program_category); exit();

                $hist_record = new stdClass();
                $hist_record->year    = isset($get_journal->session_date)?date('Y', strtotime($get_journal->session_date)):null;
                $hist_record->month   = isset($get_journal->session_date)?date("F", strtotime($get_journal->session_date)):null;
                // $hist_record->country = $record->country;
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
                    $hist_record->country   = isset($value->country)?$value->country:$record->country;
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
    }else if($wsfunction == "set_facetoface_attendance"){
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
    }else if($wsfunction == "get_scrom_files"){

        $status     = 0; 
        $message    = "Record not found!!!";
        $result     = [];

        $get_records = $DB->get_records_sql("SELECT id,contextid,component,filearea,itemid,filename,filesize FROM `mdl_files` WHERE `component` LIKE 'mod_scorm' AND `filename` LIKE 'index.html' ORDER BY `id` DESC");

        if(!empty($get_records))
        {
            foreach ($get_records as $key => $value) {
                //$url = moodle_url::make_pluginfile_url($file->get_contextid(), $file->get_component(), $file->get_filearea(), $file->get_itemid(), $file->get_filepath(), $file->get_filename());

                $value->url = $CFG->wwwroot."/pluginfile.php/".$value->contextid."/".$value->component."/".$value->filearea."/".$value->itemid."/".$value->filename;
                $result[]   = $value;
            }
            
            $message = "Record found successfully!!!";
            $status  = 1;
        }

        $returndata['status']  = $status;
        $returndata['message'] = $message;
        $returndata['result']  = $result;

        echo $data = json_encode($returndata);
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
                        $message = "Player id is activated successfully!!!";
                        $status  = 0;

                    }

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
                    
                }
                else
                { 
                    $qry_player  = "SELECT *
                                    FROM mdl_push_notification as p
                                    WHERE p.player_id = '$player_id'";
                    $fetch_player_rec = $DB->get_records_sql($qry_player);
                    // print_r($fetch_player_rec); exit();

                    if(!empty($fetch_player_rec))
                    {
                        foreach ($fetch_player_rec as $key => $value) {
                            // print_r($value); exit();
                              /*
                              $record_upd = new stdClass();
                              $record_upd->id     = $value->id;
                              $record_upd->status = 'D';
                              $DB->update_record('push_notification',$record_upd,true);
                              */
                              $sql    = "UPDATE mdl_push_notification SET status = 'D' WHERE id = ".$value->id;
                              //print_r($sql); exit();
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
    }else{
       echo $data = json_encode(['Message'=>'Function Name Parameter wsfunction is missing']);
    }
?>