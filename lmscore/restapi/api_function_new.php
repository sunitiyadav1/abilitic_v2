<?php

/* 
  @author: Suniti Yadav 
  description : Having course related API's
*/
require_once '../config.php';
require_once($CFG->libdir.'/moodlelib.php');
require_once 'src/Mandrill.php'; 
$mandrill = new Mandrill($CFG->md_api_key);

global $DB, $CFG, $SESSION, $USER;

$current_url = "https://" . $_SERVER['SERVER_NAME'] . $_SERVER['REQUEST_URI'];
$base_url    = explode('/restapi/api_function_new.php', $current_url);
if(empty($CFG->wwwroot))
{
  $CFG->wwwroot     = $base_url[0];
}

header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: access");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Allow-Credentials: true");
header('Content-Type: application/json');
header("HTTP/1.0 200 Successfull operation");
// echo '=============+++++++';exit;
    $wsfunction = $_POST['wsfunction'];  
    $response = array();
    
    if($wsfunction == "sso"){
        global $CFG;
        $client_id      = 'TEST';
        $client_secret  = 'TEST';
        $device_id      = 'TEST';
        $company_code   =  $_POST['company_code'];
        $employee_code  =  $_POST['employee_code'];
        $login_url      =  $CFG->wwwroot .'/login/index.php';
        $std_password   = "Test@123"; 
        
        if($company_code != '' && $employee_code != '' && $client_id != ''&& $client_secret != '' && $device_id != ''){
         
            $sql = "SELECT u.firstaccess,u.id as user_id,t.token,u.deleted,u.username FROM mdl_user as u left join mdl_external_tokens as t on u.id = t.userid WHERE u.company_code='$company_code' and u.employee_code='$employee_code' and u.deleted = 0 ";
            $query_fetch_user = $DB->get_record_sql($sql);
            // print_r($query_fetch_user); exit();

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
                    $returndata['std_password']= $std_password;
                }
                else
                {
                    $ch = curl_init();  
                    curl_setopt($ch,CURLOPT_URL,$CFG->wwwroot."/login/token.php?username=".$username."&password=".$std_password."&service=moodle_mobile_app");
        
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
                    $returndata['std_password']= $std_password;
                }

                $str       =  'username -'.$username; // 'a:1:{s:8:\"username\";s:29:\"'.$username.'\";}';
                $eventname = "core_event_user_loggedin"; //"\core\event\user_loggedin";
                $sql_query = "INSERT INTO `mdl_logstore_standard_log` (`id`, `eventname`, `component`, `action`, `target`, `objecttable`, `objectid`, `crud`, `edulevel`, `contextid`, `contextlevel`, `contextinstanceid`, `userid`, `courseid`, `relateduserid`, `anonymous`, `other`, `timecreated`, `origin`, `ip`, `realuserid`) VALUES (NULL, '".$eventname."', 'core', 'loggedin', 'user', 'user', '".$userid."', 'r', '0', '1', '10', '0', '".$userid."', '0', NULL, '0', '".$str."', '".time()."', 'mobile', 'mobile', NULL)";
                $DB->execute($sql_query);
                echo $data = json_encode($returndata);
            }
            else
            {
               echo $data = json_encode(['Token'=>null, 'userid'=> 0, 'username'=>null, 'std_password'=>null]);
            }

        }else{
            echo $data = json_encode(['Message'=>'Some parameters is missing ']);
        }
    }else if($wsfunction == "get_cookie"){
          $wsToken = $_POST['wsToken'];
           $employee_code = $_POST['employee_code'];
           $company_code = $_POST['company_code'];
           global $CFG;
           
          if($wsToken != '' && $employee_code!= '' && $company_code != ''){   
             $query_fetch_user = $DB->get_records_sql("SELECT u.id,u.username FROM mdl_user as u LEFT JOIN mdl_external_tokens as et ON u.id = et.userid WHERE u.employee_code = '$employee_code' && u.company_code = '$company_code' && et.token = '$wsToken'");
             if(!empty($query_fetch_user)){
            foreach($query_fetch_user as $rs_fetch_user)  {  
                    $fetch_user_data =  $rs_fetch_user;
             }
            $userid=$fetch_user_data->user_id;
            $username=$fetch_user_data->username;
            $password='Kamals@123';
            $data = array('username'=>$username,'password'=>$password);
                    $ch = curl_init();   
                    curl_setopt($ch,CURLOPT_URL,$CFG->wwwroot."/login/index.php?authldap_skipntlmsso=1");
                    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                    curl_setopt($ch, CURLOPT_HEADER, 1);
                    curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true); 
                    curl_setopt($handle, CURLOPT_POSTFIELDS, $data);
                    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false); 
                    $str=curl_exec($ch);
                    curl_close($ch);
                    // print_r($output);exit;
                    $ex_str=explode("Cookie:",$str);
                    $ex_str=$ex_str[1];
                    $ex_str1=explode(";",$ex_str);
                    $finalstring=$ex_str1[0];
                    echo json_encode([$finalstring]);
         
          }else{
            echo $data = json_encode(['Message'=>'Invalid Api Token']);
          }
             }else{
                echo $data = json_encode(['Message'=>'Parameters are missing']);
            }
    }else if($wsfunction == "configuration"){ 
        $wsToken        = $_POST['wsToken'];
        $employee_code  = $_POST['employee_code'];
        $company_code   = $_POST['company_code'];

        if($wsToken != '' && $employee_code!= '' && $company_code != '')
        { 

            $fetch_user_data = $DB->get_record_sql("SELECT u.id,u.firstaccess as firstaccess,u.lastaccess as lastaccess,u.trainer as trainer , u.is_mandatory_completed FROM mdl_user as u LEFT JOIN mdl_external_tokens as et ON u.id = et.userid WHERE u.employee_code = '$employee_code' && u.company_code = '$company_code' && et.token = '$wsToken'");

            if(!empty($fetch_user_data)){
                

                if(empty($fetch_user_data->trainer) || $fetch_user_data->trainer == 0)
                {
                    $fetch_trainer = $DB->get_record_sql("SELECT ra.*,r.shortname FROM `mdl_role` as r join mdl_role_assignments as ra on ra.roleid = r.id WHERE r.shortname LIKE '%trainer%' and ra.userid = '$fetch_user_data->id'");

                    if(empty($fetch_trainer))
                    {
                      $trainer      = 0;
                    }
                    else
                    {
                      $trainer      = 1;
                    }
                }
                else
                {
                  $trainer      = $fetch_user_data->trainer;
                }

                $firstaccess  = $fetch_user_data->firstaccess;
                $lastaccess   = $fetch_user_data->lastaccess;
                // $trainer      = $fetch_user_data->trainer;
                $is_mandatory_completed   = $fetch_user_data->is_mandatory_completed;
                $mandatory_status         = false;

                /*  //old logic
                if($firstaccess == $lastaccess && $trainer == 0){
                    echo $data = json_encode(['Message'=>'Employee','Status'=>'New Joinee']);
                }else if($firstaccess < $lastaccess  && $trainer == 1){
                    echo $data = json_encode(['Message'=>'Trainer','Status'=>'Existing User']);
                }else if($firstaccess == $lastaccess  && $trainer == 1){
                   echo $data = json_encode(['Message'=>'Trainer','Status'=>'New Joinee']);
                }else{
                  echo $data = json_encode(['Message'=>'Employee','Status'=>'Existing User']);  
                }
                */

                if($is_mandatory_completed == true || $is_mandatory_completed == '1'){
                    $mandatory_status = true;
                }else if($is_mandatory_completed == false || $is_mandatory_completed == '0'){
                    $mandatory_status = false;
                }


                if($fetch_user_data->is_new_joinee == 1 && $trainer == 0){
                      echo $data = json_encode(['Message'=>'Employee','Status'=>'New Joinee', 'Trainer'=>false, 'Mandatory'=> $mandatory_status]);
                }else if($fetch_user_data->is_new_joinee == 0 && $trainer == 1){
                      echo $data = json_encode(['Message'=>'Employee','Status'=>'Existing', 'Trainer'=>true, 'Mandatory'=> $mandatory_status]);
                }else if($fetch_user_data->is_new_joinee == 0 && $trainer == 0){
                      echo $data = json_encode(['Message'=>'Employee','Status'=>'Existing', 'Trainer'=>false, 'Mandatory'=> $mandatory_status]);
                }else if($fetch_user_data->is_new_joinee == 1 && $trainer == 1){
                      echo $data = json_encode(['Message'=>'Employee','Status'=>'New Joinee', 'Trainer'=>True, 'Mandatory'=> $mandatory_status]);
                }else{
                      echo $data = json_encode(['Message'=>'Employee','Status'=>'Existing', 'Trainer'=>False, 'Mandatory'=> $mandatory_status]);
                }

            }else{
              echo $data = json_encode(['Message'=>'Invalid Api Token']);
            }
        }
        else
        {
            echo $data = json_encode(['Message'=>'Parameters are missing']);
        }
    }else if($wsfunction == "update_configuration_status"){ 
          $wsToken       = $_POST['wsToken'];
          $employee_code = $_POST['employee_code'];
          $company_code  = $_POST['company_code'];
          if($wsToken != '' && $employee_code!= '' && $company_code != ''){   
             $query_fetch_user = $DB->get_records_sql("SELECT u.id, u.is_new_joinee FROM mdl_user as u LEFT JOIN mdl_external_tokens as et ON u.id = et.userid WHERE u.employee_code = '$employee_code' && u.company_code = '$company_code' && et.token = '$wsToken'");
              if(!empty($query_fetch_user)){
                foreach($query_fetch_user as $rs_fetch_user)  {  
                        $fetch_user_data =  $rs_fetch_user;
                 }
                 // print_r($fetch_user_data);exit;
                $user_id        = $fetch_user_data->id;
                $is_new_joinee  = $fetch_user_data->is_new_joinee;

                if($is_new_joinee == '1')
                {
                    $record = new stdClass();
                    $record->is_new_joinee = '0';
                    $record->id = $user_id;
                    $ans = $DB->update_record('user',$record);

                    if($ans == 1)
                    {
                      $status  = 1;
                      $message = "Status Updated to Existing User";
                    }
                    else
                    {
                      $status  = 0;
                      $message = "Status not Updated.";
                    }
                }
                else
                {
                  $status  = 0;
                  $message = "Status not Updated cause user is Existing.";
                }
                
                $returndata['status']  = $status;
                $returndata['message'] = $message;
                echo $data = json_encode($returndata);

              }else{
                echo $data = json_encode(['Message'=>'Invalid Api Token']);
              }
          }else{
              echo $data = json_encode(['Message'=>'Parameters are missing']);
          }
    }else if($wsfunction == "update_mandatory_course_status"){ 
          $wsToken       = $_POST['wsToken'];
          $employee_code = $_POST['employee_code'];
          $company_code  = $_POST['company_code'];
          if($wsToken != '' && $employee_code!= '' && $company_code != ''){   
             $query_fetch_user = $DB->get_records_sql("SELECT u.id, u.is_mandatory_completed FROM mdl_user as u LEFT JOIN mdl_external_tokens as et ON u.id = et.userid WHERE u.employee_code = '$employee_code' && u.company_code = '$company_code' && et.token = '$wsToken'");
              if(!empty($query_fetch_user)){
                foreach($query_fetch_user as $rs_fetch_user)  {  
                        $fetch_user_data =  $rs_fetch_user;
                 }
                 // print_r($fetch_user_data);exit;
                $user_id = $fetch_user_data->id;
                $is_mandatory_completed = $fetch_user_data->is_mandatory_completed;
                print_r ($is_mandatory_completed);
                if($is_mandatory_completed == False)
                { 
                    // $record = new stdClass();
                    // $record->is_mandatory_completed = True;
                    // $record->id = $user_id;
                    // $ans = $DB->update_record('user',$record);
                    $sql = "UPDATE mdl_user SET is_mandatory_completed = True WHERE id=".$user_id;
                  $DB->execute($sql);

                    // if($ans == 1)
                    // {
                      $status  = 1;
                      $message = "Mandatory course completed";
                      $testMsg = 0;
                    // }
                    // else
                    // {
                      // $status  = 0;
                      // $message = "Mandatory course not completed";
                      // $testMsg = 1;
                    // }
                }
                else if($is_mandatory_completed == True)
                {
                  $status  = 1;
                  $message = "Mandatory course completed";
                  $testMsg = 2;
                }
                else{
                {
                  $status  = 1;
                  $message = "Mandatory course completed";
                  $testMsg = 3;
                }
                }
                
                $returndata['status']  = $status;
                $returndata['message'] = $message;
                $returndata['test'] = $testMsg;
                echo $data = json_encode($returndata);

              }else{
                echo $data = json_encode(['Message'=>'Invalid Api Token']);
              }
          }else{
              echo $data = json_encode(['Message'=>'Parameters are missing']);
          }
    }else if($wsfunction == "mandatory_course"){
      global $CFG;
      $wsToken = $_POST['wsToken'];
      $employee_code = $_POST['employee_code'];
      $company_code = $_POST['company_code'];
         
      if($wsToken != '' && $employee_code!= '' && $company_code != '')
      {   
        $query_fetch_user = $DB->get_records_sql("SELECT u.id as userid FROM mdl_user as u LEFT JOIN mdl_external_tokens as et ON u.id = et.userid WHERE u.employee_code = '$employee_code' && u.company_code = '$company_code' && et.token = '$wsToken'");
        if(!empty($query_fetch_user))
        {
          foreach($query_fetch_user as $rs_fetch_user)  
          {  
              $fetch_user_data =  $rs_fetch_user;
          }
          $userid = $fetch_user_data->userid;
           // $qry="select c.id, c.fullname, c.shortname, c.summary, c.startdate, c.enddate, c.visible, c.enablecompletion from {course_categories} as cc left join {course} as c on c.category = cc.id where ";
          $qry="select c.id, c.fullname, c.shortname, c.summary, c.startdate, c.enddate, c.visible, c.enablecompletion from {course_categories} as cc left join {course} as c on c.category = cc.id left join {enrol} as e on e.courseid = c.id left join {user_enrolments} as ue on e.id=ue.enrolid where cc.id=11 and ue.userid=$userid";
          $query_mandatory_course = $DB->get_records_sql($qry);
          //        print_r($query_mandatory_course);
          //$data = array();
          foreach($query_mandatory_course as $rs_mandatory_course)
          {
        
            $rs_mandatory_course->summary=strip_tags($rs_mandatory_course->summary);
                  $courseid=$rs_mandatory_course->id;
            $startdate=$rs_mandatory_course->startdate;
            $enddate=$rs_mandatory_course->enddate;
            $courseduration="";
            if($enddate == 0 || $startdate == 0)
            {
              $courseduration="No Limit";
            }
            else
            {
              $enddate=date_create(date("Y-m-d H:i:s",$enddate));
              $startdate=date_create(date("Y-m-d H:i:s",$startdate));
              $diff=date_diff($enddate,$startdate);
              $courseduration=$diff;
              $courseduration=$diff->y." Year-".$diff->m." Month-".$diff->d." Days ".$diff->h." hours:".$diff->i." minutes:".$diff->s." seconds";
            }
            $rs_mandatory_course->courseduration=$courseduration;
            $qry="select contextid,component,filearea,sortorder,filename from mdl_files where contextid = ( select c.id as 'cid' from mdl_context as c left join mdl_course as cs on cs.id = c.instanceid where c.contextlevel = 50 and c.instanceid=$courseid) and filename !='.' and filearea='overviewfiles'";
            $query_course_img = $DB->get_records_sql($qry);
            $course_img="";
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
            //        $rs_mandatory_course->completionpercent =  $completionpercent;
            $query_course_papers = $DB->get_records_sql("select cm.id as id,q.name as name from {course_modules} as cm left join {quiz} as q on cm.instance = q.id where cm.module=16 and cm.course= $courseid and cm.deletioninprogress=0");
            //print_r($query_course);
            //$data = array();
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
                $query_fetch_files = $DB->get_records_sql($qry);
                $fetch_files_data=array();
                foreach($query_fetch_files as $rs_fetch_files)
                {
              
                    $rs_fetch_lession->contents=strip_tags($rs_fetch_lession->contents);
                    $filedetails=array();
                    $filedetails['cmid']  = $rs_fetch_files->cmid;
                    $filedetails['fid']   = $rs_fetch_files->id;
                    $filedetails['resid'] = $rs_fetch_files->res_id;
                    $filedetails['name']  = $rs_fetch_files->res_name;
                    $filedetails['intro'] = strip_tags($rs_fetch_files->res_intro);
                    $filedetails['file']  = $CFG->wwwroot.'/pluginfile.php/'.$rs_fetch_files->contextid.'/'.$rs_fetch_files->component.'/'.$rs_fetch_files->filearea.'/'.$rs_fetch_files->sortorder.'/'.$rs_fetch_files->filename;
                        $fetch_files_data[]=$filedetails;
                }       
                $rs_mandatory_course->files =  $fetch_files_data;
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
                //        print_r($fetch_files_data);
         
        
                $mandatory_course_data[] =  $rs_mandatory_course;
          }
          $mandatory_course_details=array();
          $mandatory_course_details["coursedetails"]=$mandatory_course_data;
          
          echo json_encode($mandatory_course_details);
        }else{
          echo $data = json_encode(['Message'=>'Invalid Api Token']);
        }
      }else{
         echo $data = json_encode(['Message'=>'Parameters are missing']);
      }
    }else if($wsfunction == "dashboard_stats"){
        global $CFG;
        $wsToken        = $_POST['wsToken'];
        $employee_code  = $_POST['employee_code'];
        $company_code   = $_POST['company_code'];
      
        if($wsToken != '' && $employee_code!= '' && $company_code != '' )
        {   
             
            $query_fetch_user = $DB->get_record_sql("SELECT u.id as userid,u.username FROM mdl_user as u LEFT JOIN mdl_external_tokens as et ON u.id = et.userid WHERE u.employee_code = '$employee_code' && u.company_code = '$company_code' && et.token = '$wsToken'"); 
          
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
                        $rs_course->image   = course_image($courseid);
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
                    // print_r($enrolled_course); exit();

                    if(!empty($enrolled_course))
                    {
                        $query_quizes = $DB->get_records_sql("select cm.id as 'cmid', cm.module as 'mid', c.fullname as 'course', q.name as 'course_module', q.timeclose as 'timeclose' from mdl_course_modules as cm left join mdl_quiz as q on cm.instance = q.id left join mdl_course as c on q.course = c.id where cm.deletioninprogress = 0 and cm.course in($enrolled_course) and cm.module = 16 and q.timeclose > $time");
                        // print_r($query_quizes); exit();
                        if($query_quizes)
                        {
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
                        }
                        

                        $query_assign = $DB->get_records_sql("select cm.id as 'cmid', cm.module as 'mid', c.fullname as 'course', a.name as 'course_module', a.duedate as 'timeclose' from mdl_course_modules as cm left join mdl_assign as a on cm.instance = a.id left join mdl_course as c on a.course = c.id where cm.deletioninprogress = 0 and cm.course in($enrolled_course) and cm.module = 1 and a.duedate > $time");
                        // print_r($query_assign); exit();

                        if($query_assign)
                        {
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
                        
                        // print_r($datewisetimeline); exit();
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
                    $overall['finalCompletionpercent']  = ($finalTotalModule != 0)?(($finalCompletionModule/$finalTotalModule) * 100 ):0;

                    $returndata['courses']              = $completionstatus;
                    $returndata['overall']              = $overall;
                    $returndata['timeline_datewise']    = $datewise;

                    // print_r($overall);
                    // print_r($returndata);
                    // exit();

                    //print_r($courseid); exit();
                    $str       =  'N'; // 'a:1:{s:8:\"username\";s:29:\"'.$username.'\";}';
                    $eventname = "core_event_dashboard_viewed"; //"\core\event\user_loggedin";
                    $sql_query = "INSERT INTO `mdl_logstore_standard_log` (`id`, `eventname`, `component`, `action`, `target`, `objecttable`, `objectid`, `crud`, `edulevel`, `contextid`, `contextlevel`, `contextinstanceid`, `userid`, `courseid`, `relateduserid`, `anonymous`, `other`, `timecreated`, `origin`, `ip`, `realuserid`) VALUES (NULL, '".$eventname."', 'core', 'viewed', 'dashboard', '', '0', 'r', '0', '5', '30', '2', '".$userid."', '".$courseid."', '0', '0', '".$str."', '".time()."', 'mobile', 'mobile', NULL)";
                    $DB->execute($sql_query);

                    //print_r($returndata); exit();

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
    }else if($wsfunction == "categories_list"){
          global $CFG;
           $wsToken = $_POST['wsToken'];
           $employee_code = $_POST['employee_code'];
           $company_code = $_POST['company_code'];
           if($wsToken != '' && $employee_code!= '' && $company_code != '' ){ 
               $query_fetch_user = $DB->get_record_sql("SELECT u.id as userid FROM mdl_user as u LEFT JOIN mdl_external_tokens as et ON u.id = et.userid WHERE u.employee_code = '$employee_code' && u.company_code = '$company_code' && et.token = '$wsToken'");
                if(!empty($query_fetch_user)){
                  $query_fetch_category = $DB->get_records_sql("SELECT * FROM mdl_course_categories");
                  // $fetch_enrol_category = $DB->get_records_sql("SELECT DISTINCT cc.id,cc.name, c.fullname FROM `mdl_course_categories` as cc join mdl_course as c on c.category = cc.id join mdl_enrol as e on e.courseid = c.id join mdl_user_enrolments as ue on ue.enrolid = e.id join mdl_user as u on u.id = ue.userid where u.id = '$query_fetch_user->userid'");

                  $fetch_enrol_category = $DB->get_record_sql("SELECT DISTINCT GROUP_CONCAT(cc.id) as cat_id FROM `mdl_course_categories` as cc join mdl_course as c on c.category = cc.id join mdl_enrol as e on e.courseid = c.id join mdl_user_enrolments as ue on ue.enrolid = e.id join mdl_user as u on u.id = ue.userid where u.id ='$query_fetch_user->userid'");
                  //print_r($fetch_enrol_category); exit();
                  $diff_cat = explode(',', $fetch_enrol_category->cat_id);

                   foreach($query_fetch_category as $rs_fet_user)  { 

                      //print_r($rs_fet_user); print_r($diff_cat); 
                      if(in_array($rs_fet_user->id, $diff_cat)) 
                      {
                        $rs_fet_user->flag = '1';
                      }
                      else
                      {
                        $rs_fet_user->flag = '0';
                      }
                      $rs_fet_user->description = strip_tags($rs_fet_user->description);
                      $Final_data[] =  $rs_fet_user;
                   }
                    echo $data = json_encode(['categories' => $Final_data]);
                } else{
                  echo $data = json_encode(['Message'=>'Invalid Api Token']);
                }
           }else{
              echo $data = json_encode(['Message'=>'Parameters are missing']);
           }
    }else if($wsfunction == "course_activities"){
        global $CFG;
        $wsToken = $_POST['wsToken'];
        $employee_code = $_POST['employee_code'];
        $company_code = $_POST['company_code'];
        $companycode = $_POST['categoryid'];
        if($wsToken != '' && $employee_code!= '' && $company_code != '' && $companycode != '')
        {   
             
          $query_fetch_user = $DB->get_records_sql("SELECT u.id as userid FROM mdl_user as u LEFT JOIN mdl_external_tokens as et ON u.id = et.userid WHERE u.employee_code = '$employee_code' && u.company_code = '$company_code' && et.token = '$wsToken'");
          if(!empty($query_fetch_user))
          {
              foreach($query_fetch_user as $rs_fetch_user) 
              {  
                    $fetch_user_data =  $rs_fetch_user;
              }
              $userid = $fetch_user_data->userid;
              $qry="select c.id, c.fullname, c.shortname, c.summary, c.startdate, c.enddate, c.visible, c.enablecompletion from {course_categories} as cc left join {course} as c on c.category = cc.id where cc.id=$companycode";
              $query_mandatory_course = $DB->get_records_sql($qry);
              //        print_r($query_mandatory_course);
              //$data = array();
              foreach($query_mandatory_course as $rs_mandatory_course)
              {
      
                  $rs_mandatory_course->summary=strip_tags($rs_mandatory_course->summary);
                  $courseid=$rs_mandatory_course->id;
                  $startdate=$rs_mandatory_course->startdate;
                  $enddate=$rs_mandatory_course->enddate;
                  $courseduration="";
                  if($enddate == 0 || $startdate == 0)
                  {
                    $courseduration="No Limit";
                  }
                  else
                  {
                    $enddate=date_create(date("Y-m-d H:i:s",$enddate));
                    $startdate=date_create(date("Y-m-d H:i:s",$startdate));
                    $diff=date_diff($enddate,$startdate);
                    $courseduration=$diff;
                    $courseduration=$diff->y." Year-".$diff->m." Month-".$diff->d." Days ".$diff->h." hours:".$diff->i." minutes:".$diff->s." seconds";
                  }
                  $rs_mandatory_course->courseduration=$courseduration;
                  $qry="select contextid,component,filearea,sortorder,filename from mdl_files where contextid = ( select c.id as 'cid' from mdl_context as c left join mdl_course as cs on cs.id = c.instanceid where c.contextlevel = 50 and c.instanceid=$courseid) and filename !='.' and filearea='overviewfiles'";
                  $query_course_img = $DB->get_records_sql($qry);
                  $course_img="";
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
                  //$rs_mandatory_course->completionpercent =  $completionpercent;
                  $query_course_papers = $DB->get_records_sql("select cm.id as id,q.name as name from {course_modules} as cm left join {quiz} as q on cm.instance = q.id where cm.module=16 and cm.course= $courseid and cm.deletioninprogress=0");
                  //print_r($query_course);
                  //$data = array();
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
                  $query_fetch_files = $DB->get_records_sql($qry);
                  $fetch_files_data=array();
                  foreach($query_fetch_files as $rs_fetch_files)
                  {
              
                    $rs_fetch_lession->contents=strip_tags($rs_fetch_lession->contents);
                    $filedetails = array();
                    $filedetails['cmid']  = $rs_fetch_files->cmid;
                    $filedetails['fid']   = $rs_fetch_files->id;
                    $filedetails['resid'] = $rs_fetch_files->res_id;
                    $filedetails['name']  = $rs_fetch_files->res_name;
                    $filedetails['intro'] = strip_tags($rs_fetch_files->res_intro);
                    $filedetails['file']  = $CFG->wwwroot.'/pluginfile.php/'.$rs_fetch_files->contextid.'/'.$rs_fetch_files->component.'/'.$rs_fetch_files->filearea.'/'.$rs_fetch_files->sortorder.'/'.$rs_fetch_files->filename;
                        $fetch_files_data[]=$filedetails;
                  }       
                  $rs_mandatory_course->files =  $fetch_files_data;
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

                  $mandatory_course_data[] =  $rs_mandatory_course;

              }
              $mandatory_course_details=array();
              $mandatory_course_details["coursedetails"]=$mandatory_course_data;
              $mandatory_course_details["session"]=$SESSION;
              $mandatory_course_details["cookie"]=$_COOKIE;

              echo json_encode($mandatory_course_details);
          }else{
            echo $data = json_encode(['Message'=>'Invalid Api Token']);
          }
        }else{
           echo $data = json_encode(['Message'=>'Parameters are missing']);
        }
    }else if($wsfunction == "get_calender_details"){
        $wsToken = $_POST['wsToken'];
        $employee_code = $_POST['employee_code'];
        $company_code = $_POST['company_code'];
        if($wsToken != '' && $employee_code!= '' && $company_code != '')
        { 
          $query_fetch_user = $DB->get_records_sql("SELECT u.id as userid FROM mdl_user as u LEFT JOIN mdl_external_tokens as et ON u.id = et.userid WHERE u.employee_code = '$employee_code' && u.company_code = '$company_code' && et.token = '$wsToken'");
          if(!empty($query_fetch_user))
          {
               foreach($query_fetch_user as $rs_fetch_user)  
               {  
                        $fetch_user_data =  $rs_fetch_user;
               }
               $userid = $fetch_user_data->userid;
                 $qry="SELECT e.id, e.name, e.description,e.courseid,e.timestart,e.timemodified FROM  mdl_event as e WHERE (e.userid=$userid or e.eventtype='site' or e.eventtype='user' or e.eventtype='course' or e.eventtype='category' or e.eventtype='group')";
              $query_fetch_event = $DB->get_records_sql($qry);
              $status=0;
              $message="Events Not Available.";
              foreach($query_fetch_event as $rs_fetch_event)
              {
                $rs_fetch_event->description=strip_tags($rs_fetch_event->description);
                      $fetch_event_data[] =  $rs_fetch_event;
                $status=1;
                $message="Events Available.";
              }
              $returndata['status']=$status;
              $returndata['message']=$message;
              $returndata['events']=$fetch_event_data;
    
              echo $data = json_encode($returndata);
          } else{
            echo $data = json_encode(['Message'=>'Invalid Api Token']);
          }
        }else{
            echo $data = json_encode(['Message'=>'Parameters are missing']);
        }
    }else if($wsfunction == "get_quiztiming"){
        $wsToken = $_POST['wsToken'];
        $employee_code = $_POST['employee_code'];
        $company_code = $_POST['company_code'];
        $quizmoduleid = $_POST['quizmoduleid'];
         
        if($wsToken != '' && $employee_code!= '' && $company_code != '' && $quizmoduleid != '')
        { 
            $query_fetch_user = $DB->get_records_sql("SELECT u.id as userid FROM mdl_user as u LEFT JOIN mdl_external_tokens as et ON u.id = et.userid WHERE u.employee_code = '$employee_code' && u.company_code = '$company_code' && et.token = '$wsToken'");
            if(!empty($query_fetch_user))
            {
                    foreach($query_fetch_user as $rs_fetch_user)  {  
                        $fetch_user_data =  $rs_fetch_user;
                    }
                    $userid = $fetch_user_data->userid;
                    $qry="select q.id,q.timelimit as 'timelimit' from {course_modules} as cm left join {quiz} as q on cm.instance = q.id  where cm.module = 16 and cm.id = $quizmoduleid ";
                    $query_quiz_time = $DB->get_records_sql($qry);
                    // print_r($query_quiz_time);exit;
                    $quiz_time="";
                    $quiz_id="";
                    foreach($query_quiz_time as $rs_quiz_time)
                    {
                        $quiz_time =  $rs_quiz_time->timelimit;
                        $quiz_id =  $rs_quiz_time->id;
                    }
                    $jsondata=array();
                    $jsondata['quizid']=$quiz_id;
                    $jsondata['timelimit']=$quiz_time;

                    
                    $qry="select id,timestart,timefinish from {quiz_attempts}  where userid = $userid and quiz = $quiz_id order by attempt desc limit 1";
                    $query_quiza_time = $DB->get_records_sql($qry);
                    $start_time=0;
                    $finish_time=0;
                    $quiz_attempt=0;
                    foreach($query_quiza_time as $rs_quiza_time)
                    {
                        $start_time =  $rs_quiza_time->timestart;
                        $finish_time = $rs_quiza_time->timefinish;
                        $quiz_attempt =  $rs_quiza_time->id;
                    }
                    $jsondata['starttime']=$start_time;
                    $jsondata['finishtime']=$finish_time;

                    $ctime=time();
                    $jsondata['currenttimetime']=$ctime;
                    $jsondata['quiz_attemptid']=$quiz_attempt;
                
                    echo $data = json_encode($jsondata);
            }else{
                echo $data = json_encode(['Message'=>'Invalid Api Token']);
            }
        }else{
          echo $data = json_encode(['Message'=>'Parameters are missing']);
        }
    }else if($wsfunction == "new_attempt_quiz"){
        $wsToken = $_POST['wsToken'];
        $employee_code = $_POST['employee_code'];
        $company_code = $_POST['company_code'];
        $quizid = $_POST['quizid'];

        if($wsToken != '' && $employee_code!= '' && $company_code != '' && $quizid != '')
        { 
          $query_fetch_user = $DB->get_records_sql("SELECT u.id as userid FROM mdl_user as u LEFT JOIN mdl_external_tokens as et ON u.id = et.userid WHERE u.employee_code = '$employee_code' && u.company_code = '$company_code' && et.token = '$wsToken'");
          if(!empty($query_fetch_user))
          {
              foreach($query_fetch_user as $rs_fetch_user)  
              {  
                  $fetch_user_data =  $rs_fetch_user;
              }
              $userid = $fetch_user_data->userid;
              $query_check=$DB->get_records_sql("SELECT instance FROM {course_modules} where deletioninprogress =0 and module=16 and id=$quizid");
              $checkmodule=0;

              foreach($query_check as $rs_fetch_check)
              {
                $checkmodule=1;
              }
              if($checkmodule == 1)
              {

                $query_fetch_uniqueid = $DB->get_records_sql("select max(qa.uniqueid) as 'uniqueid',c.instance as 'quizid' from {course_modules} as c left join {quiz_attempts} as qa on c.instance = qa.quiz where c.id=$quizid");
                $qa_uniqueid=0;
                $qa_quizid=0;
                // print_r($query_fetch_uniqueid);exit;
                foreach($query_fetch_uniqueid as $rs_fetch_uniqueid)
                {
                  $qa_uniqueid=$rs_fetch_uniqueid->uniqueid;
                  $qa_quizid=$rs_fetch_uniqueid->quizid;
                }
                $query_fetch_attempt = $DB->get_records_sql("select qa.id,qa.attempt,qa.uniqueid, qa.currentpage,qa.timefinish from {course_modules} as cm left join {quiz_attempts} as qa on cm.instance = qa.quiz where qa.userid=$userid and cm.id=$quizid order by qa.attempt");

                $qa_attempt=0;
                $qa_avail=0;
                $qa_old_usageid=0;
                foreach($query_fetch_attempt as $rs_fetch_attempt)
                {
                  $qa_avail=1;
                  $qa_id=$rs_fetch_attempt->id;
                  $qa_attempt=$rs_fetch_attempt->attempt;
                  $qa_old_usageid=$rs_fetch_attempt->uniqueid;
                  $qa_currentpage=$rs_fetch_attempt->currentpage;
                  $qa_timefinish=$rs_fetch_attempt->timefinish;
                }
    
                if($qa_timefinish!=0 || $qa_avail==0)
                {
                  $qa_attempt=$qa_attempt+1;
                  $query_fetch_context = $DB->get_records_sql("select c.id as 'cid' from {course_modules} as cm left join {context} as c on cm.id = c.instanceid where c.contextlevel = 70 and cm.deletioninprogress = 0 and cm.module=16 and cm.id=$quizid");

                    $contextid=0;
                  foreach($query_fetch_context as $rs_fetch_context)
                  {
                    $contextid=$rs_fetch_context->cid;
                  }
                  $rec_insert= new stdClass();
                  $rec_insert->preferredbehaviour= 'deferredfeedback';
                  $rec_insert->component= 'mod_quiz';
                  $rec_insert->contextid= $contextid;
                  //$qa_uniqueid = "dummy";
                  //print_r($rec_insert);
                  $qa_uniqueid = $DB->insert_record('question_usages', $rec_insert, true);
                
                  $attempt_time=time();
                  $query_fetch_layout = $DB->get_records_sql("select qs.quizid,GROUP_CONCAT( qs.page,',',qs.requireprevious ORDER BY qs.page ASC SEPARATOR ',') as 'layout' from {course_modules} as c left join {quiz_slots} as qs on c.instance = qs.quizid where c.id=$quizid");
                  $qry="select qs.slot,qs.quizid,qs.page,qs.requireprevious from {course_modules} as c left join {quiz_slots} as qs on c.instance = qs.quizid where c.id=$quizid";
                  $query_fetch_layout = $DB->get_records_sql($qry);
                  $layout=array();
                  $oldpage=1;
                  foreach($query_fetch_layout as $rs_fetch_layout)
                  {
                    $newpage=$rs_fetch_layout->page;
                      if($oldpage != $newpage)
                      {
                        $layout[] = "0";
                        $oldpage = $newpage;
                      }
                    $layout[]= $rs_fetch_layout->slot;
                    $status=1;
                    $message="Employee enrollment details.";
                  }
                  $layout[] = "0";
                  $layoutdata=implode(",",$layout);
          
                  $record = new stdClass();
                  $record->quiz= $qa_quizid;
                  $record->userid = $userid;
                  $record->attempt = $qa_attempt;
                  $record->uniqueid = $qa_uniqueid;
                  $record->layout = $layoutdata;
                  $record->timestart = $attempt_time;
                  $record->timemodified = $attempt_time;
                  //$qa_new_attempt = "Dummy";
                  //print_r($record);
                  $qa_new_attempt = $DB->insert_record('quiz_attempts', $record, true);
                  //echo "insert into quiz attempt";

                  $query_fetch_qadetails = $DB->get_records_sql("SELECT qs.id,qza.uniqueid as 'questionusageid', qs.slot as 'slot', 'deferredfeedback' as 'behaviour', qs.questionid as 'questionid',q.qtype as 'qtype', '0', q.defaultmark as 'maxmark', q.questiontext as 'questionsummery', qa.answer as 'answer' FROM {quiz_attempts} as qza LEFT JOIN {quiz_slots} as qs on qza.quiz = qs.quizid LEFT JOIN {question} as q on qs.questionid = q.id LEFT JOIN {question_answers} as qa on q.id = qa.question and qa.fraction=1 where qza.id=$qa_new_attempt");
                  $fetch_qadetails_data=array();
                  $record1 = new stdClass();
                  $record2 = new stdClass();
                  $record3 = new stdClass();

                  foreach($query_fetch_qadetails as $rs_fetch_qadetails)
                  {
                      $fetch_qadetails_data=$rs_fetch_qadetails;
                      $question_id=$fetch_qadetails_data->questionid;
                      $question_type=$fetch_qadetails_data->qtype;
                      $record1->questionusageid= $qa_uniqueid;
                      $record1->slot = $fetch_qadetails_data->slot;
                      $record1->behaviour = $fetch_qadetails_data->behaviour;
                      $record1->questionid = $fetch_qadetails_data->questionid;
                      $record1->maxmark = $fetch_qadetails_data->maxmark;
                      $record1->minfraction = 0;
                      $record1->questionsummary = strip_tags($fetch_qadetails_data->questionsummery);
                      $record1->rightanswer = strip_tags($fetch_qadetails_data->answer);
                      $record1->timemodified = $attempt_time;
                      $question_id=$fetch_qadetails_data->questionid;
                      $question_type=$fetch_qadetails_data->qtype;
                      //$question_attempt="Dummy";
                      //print_r($record1);
                      $question_attempt = $DB->insert_record('question_attempts', $record1, true);
                      //echo "insert into Question attempt";

                      $record2->questionattemptid= $question_attempt;
                      $record2->sequencenumber = 0;
                      $record2->state = 'todo';
                      $record2->timecreated = $attempt_time;
                      $record2->userid = $userid;
                      //$question_attempt_steps="Dummy";
                      //print_r($record2);

                      $question_attempt_steps = $DB->insert_record('question_attempt_steps', $record2, true);
                      //echo "insert into Question attempt step";
                      if($question_type=='multichoice')
                      {
                          $query_getallOptions= $DB->get_records_sql("SELECT id FROM {question_answers} WHERE `question` =$question_id");
                          $data_getallOptions=array();
                        
                          foreach($query_getallOptions as $rs_getallOptions)
                          {
                            $data_getallOptions[]=$rs_getallOptions->id;
                          }
                          shuffle($data_getallOptions);
                          $data_getallOptions=implode(',',$data_getallOptions);
                          $record3->attemptstepid = $question_attempt_steps;
                          $record3->name = '_order';
                          $record3->value = $data_getallOptions;
                          //$question_attempt_steps_data="Dummy";
                          //print_r($record3);
                          $question_attempt_steps_data = $DB->insert_record('question_attempt_step_data', $record3, true);
                          //echo "insert into Question attempt step data";
                      }
                  
                  }
             
                  $json_data['quizid']=$qa_quizid;
                  $json_data['attemptid']=$qa_new_attempt;
                  $json_data['questionusageid']=$qa_uniqueid;
                  $json_data['attempt']=$qa_attempt;
                  $json_data['attemptstate']=1;
                  $json_data['attemptstatestate']="new";
                  $json_data['currentpage']=0;        
                }
                else
                {         
                  $json_data['quizid']=$qa_quizid;
                  $json_data['attemptid']=$qa_id;
                  $json_data['questionusageid']=$qa_old_usageid;
                  $json_data['attempt']=$qa_attempt;
                  $json_data['attemptstate']=0;
                  $json_data['attemptstatestate']="old";
                  $json_data['currentpage']=$qa_currentpage;
                }
                $json_data['attemptstatus']="inprogress";
                echo $data = json_encode($json_data);
              }
              else
              {
                echo json_encode(null);
              }
          }else{
             echo $data = json_encode(['Message'=>'Invalid Api Token']);
          }
        }else{
          echo $data = json_encode(['Message'=>'Parameters are missing']);
        }
    }else if($wsfunction == "fetch_all_question"){
          $wsToken = $_POST['wsToken'];
          $employee_code = $_POST['employee_code'];
          $company_code = $_POST['company_code'];
          $quizusageid = $_POST['quizusageid'];
               
          if($wsToken != '' && $employee_code!= '' && $company_code != '' && $quizusageid != '')
          { 
              $query_fetch_user = $DB->get_records_sql("SELECT u.id as userid FROM mdl_user as u LEFT JOIN mdl_external_tokens as et ON u.id = et.userid WHERE u.employee_code = '$employee_code' && u.company_code = '$company_code' && et.token = '$wsToken'");
              if(!empty($query_fetch_user))
              {

                  $qry="select q.id as 'qid',qa.id as 'id',q.name as 'name', q.questiontext as 'questiontext', q.qtype as 'qtype', qa.slot as 'slot' from {question_attempts} as qa left join {question} as q on qa.questionid = q.id where qa.questionusageid=$quizusageid";
                  $query_fetch_question = $DB->get_records_sql($qry);
                  $fetch_question_data = array();
                  $qtype="";
                  foreach($query_fetch_question as $rs_fetch_question)
                  {
                      $rs_fetch_question->questiontext=strip_tags($rs_fetch_question->questiontext);
                      $qtype=$rs_fetch_question->qtype;
                      $question_id=$rs_fetch_question->qid;
                      $slot=$rs_fetch_question->slot;
                      $query_fetch_options = $DB->get_records_sql("select an.id , an.answer as 'option' , an.answerformat , an.fraction as 'answerfraction' ,CASE WHEN an.fraction =0 THEN 'incorrect' WHEN an.fraction =1 THEN 'correct' END AS 'answer' from {question_attempts} as qa left join {question} as q on qa.questionid = q.id left join {question_answers} as an on q.id = an.question where qa.questionusageid=$quizusageid and qa.slot=$slot");
                      $allanswer=array();
                      foreach($query_fetch_options as $rs_fetch_options)
                      {
                        $rs_fetch_options->option=strip_tags($rs_fetch_options->option);
                        $allanswer[]=$rs_fetch_options;
                      }
                      $rs_fetch_question->allanswer=$allanswer;
                      if($qtype=="multichoice")
                      {
                          $query_fetch_optstep=$DB->get_records_sql("SELECT qasd.value FROM {question_attempts} as qa LEFT JOIN {question_attempt_steps} as qas on qa.id = qas.questionattemptid LEFT JOIN {question_attempt_step_data} as qasd on qasd.attemptstepid = qas.id WHERE qa.questionusageid = $quizusageid and `slot` = $slot and qasd.name='_order'");
                          $answerseq="";
                          foreach($query_fetch_optstep as $rs_fetch_optstep)
                          {
                            $answerseq=$rs_fetch_optstep->value;
                          }
                          $rs_fetch_question->answerseq=explode(",",$answerseq);
                          //            print_r($query_fetch_optstep);
                      }
      
      
      
      
                      $fetch_question_data[] =  $rs_fetch_question;
                  }
                  echo $data = json_encode($fetch_question_data);
              }else{
                 echo $data = json_encode(['Message'=>'Invalid Api Token']);
              }
          }else{
              echo $data = json_encode(['Message'=>'Parameters are missing']);
          }
    }else if($wsfunction == "attempt_question"){
        $wsToken        = $_POST['wsToken'];
        $employee_code  = $_POST['employee_code'];
        $company_code   = $_POST['company_code'];
        $questionatmpid = $_POST['questionatmpid'];
        $answer_data    = $_POST['answer_data'];
               
        if($wsToken != '' && $employee_code!= '' && $company_code != '' && $questionatmpid != "" && $answer_data != ""){ 
            
            $query_fetch_user = $DB->get_record_sql("SELECT u.id as userid FROM mdl_user as u LEFT JOIN mdl_external_tokens as et ON u.id = et.userid WHERE u.employee_code = '$employee_code' && u.company_code = '$company_code' && et.token = '$wsToken'");
            
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
    }else if($wsfunction == "modifyflagedquestion"){
        if($questionatmpid != "" && $flagvalue !="")
        {
          $time=time();
          $rec_update= new stdClass();
          $rec_update->id= $questionatmpid;
          $rec_update->flagged= $flagvalue;
          $rec_update->timemodified= $time;
          if($DB->update_record('question_attempts', $rec_update, false))
          {
            $status=1;
          }
          else
          {
            $status=0;
          }
          $data_array = array();
          $data_array["status"] = $status;
          echo $data = json_encode($data_array);
        }else{
            echo $data = json_encode(['Message'=>'Parameters are missing']);
        }
    }else if($wsfunction == "finish_attempt"){
      //finish_attempt_10Aug18
           $wsToken = $_POST['wsToken'];
              $employee_code = $_POST['employee_code'];
              $company_code = $_POST['company_code'];
              $quizattemptid = $_POST['quizattemptid'];
               if($wsToken != '' && $employee_code!= '' && $company_code != '' && $quizattemptid != ''){ 
               $query_fetch_user = $DB->get_records_sql("SELECT u.id as userid FROM mdl_user as u LEFT JOIN mdl_external_tokens as et ON u.id = et.userid WHERE u.employee_code = '$employee_code' && u.company_code = '$company_code' && et.token = '$wsToken'");
                if(!empty($query_fetch_user)){
                      foreach($query_fetch_user as $rs_fetch_user)  {  
                        $fetch_user_data =  $rs_fetch_user;
               }
                $userid = $fetch_user_data->userid;
        $time=time();
        $finishAttempt=array();
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
    }else if($wsfunction == "modify_flaged_question"){
        $wsToken = $_POST['wsToken'];
        $employee_code = $_POST['employee_code'];
        $company_code = $_POST['company_code'];
        $questionatmpid = $_POST['questionatmpid'];
        $flagvalue = $_POST['flagvalue'];

        if($wsToken != '' && $employee_code!= '' && $company_code != '' && $flagvalue != '' && $questionatmpid != '')
        { 
            $query_fetch_user = $DB->get_records_sql("SELECT u.id as userid FROM mdl_user as u LEFT JOIN mdl_external_tokens as et ON u.id = et.userid WHERE u.employee_code = '$employee_code' && u.company_code = '$company_code' && et.token = '$wsToken'");
            if(!empty($query_fetch_user)){
                foreach($query_fetch_user as $rs_fetch_user)  {  
                    $fetch_user_data =  $rs_fetch_user;
                }
                $userid = $fetch_user_data->userid;
                $time=time();
                $rec_update= new stdClass();
                $rec_update->id= $questionatmpid;
                $rec_update->flagged= $flagvalue;
                $rec_update->timemodified= $time;
                if($DB->update_record('question_attempts', $rec_update, false))
                {
                  $status=1;
                }
                else
                {
                  $status=0;
                }
                $data_array = array();
                $data_array["status"] = $status;
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

            $query_fetch_user = $DB->get_record_sql("SELECT u.id as userid FROM mdl_user as u LEFT JOIN mdl_external_tokens as et ON u.id = et.userid WHERE u.employee_code = '$employee_code' && u.company_code = '$company_code' && et.token = '$wsToken'");

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
          $query_fetch_user = $DB->get_record_sql("SELECT u.id as userid FROM mdl_user as u LEFT JOIN mdl_external_tokens as et ON u.id = et.userid WHERE u.employee_code = '$employee_code' && u.company_code = '$company_code' && et.token = '$wsToken'");
      
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
              $rec_insert= new stdClass();
              $rec_insert->coursemoduleid=$coursemoduleid;
              $rec_insert->userid= $userid;
              $rec_insert->completionstate= 1;
              $rec_insert->timemodified= $time;
        //      print_r($rec_insert);
              $cmcid = $DB->insert_record('course_modules_completion', $rec_insert, true);
              $status=1;
              $message=" Module inserted successfully";
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
    }else if($wsfunction == "check_module_completed"){
        $wsToken = $_POST['wsToken'];
        $employee_code = $_POST['employee_code'];
        $company_code = $_POST['company_code'];
        $coursemoduleid = $_POST['coursemoduleid'];
        if($wsToken != '' && $employee_code!= '' && $company_code != '' && $coursemoduleid != '')
        { 
            $query_fetch_user = $DB->get_records_sql("SELECT u.id as userid FROM mdl_user as u LEFT JOIN mdl_external_tokens as et ON u.id = et.userid WHERE u.employee_code = '$employee_code' && u.company_code = '$company_code' && et.token = '$wsToken'");
            if(!empty($query_fetch_user))
            {
                foreach($query_fetch_user as $rs_fetch_user)  
                {  
                    $fetch_user_data =  $rs_fetch_user;
                }
                $userid = $fetch_user_data->userid;
                $qry="select completionstate from {course_modules_completion} where coursemoduleid = $coursemoduleid and userid = $userid";
                //    echo $qry;
                $qry_check_module=$DB->get_records_sql($qry);
                foreach($qry_check_module as $rs_fetch_user)  {  
                  $fetch_check_data =  $rs_fetch_user;
                }
                $completionstate =  $fetch_check_data->completionstate;
                if($completionstate == 1)
                {
                    echo $data = json_encode(['message' => 'Module is completed']);
                }else{
                    echo $data = json_encode(['message' => 'Module is not completed']);
                }

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
          
          $query_fetch_user = $DB->get_record_sql("SELECT u.id as userid FROM mdl_user as u LEFT JOIN mdl_external_tokens as et ON u.id = et.userid WHERE u.id = '$user_id' and et.token = '$wsToken'");

            if(!empty($query_fetch_user)){
                $userid = $query_fetch_user->userid;
                $time   = time();
                $qry    = " SELECT i.id as que_id,i.`name` , sum(v.value)/count(v.value) as avg, count(v.value) as total FROM `mdl_feedback_item` as i join mdl_feedback_value as v on i.id = v.item WHERE v.facetofaceSessionDates = '$facetofaceSessionDates' AND v.facetofaceId = '$facetofaceId' and v.facetofaceSession = '$facetofaceSession' GROUP by i.id ";
                $get_avg = $DB->get_records_sql($qry);
                
                if(!empty($get_avg)){
                    
                    foreach ($get_avg as $key => $value) {
                        $comments = array();
                        $qry1    = "SELECT v.feedback_description FROM `mdl_feedback_item` as i join mdl_feedback_value as v on i.id = v.item WHERE v.facetofaceSessionDates = '$facetofaceSessionDates' AND v.facetofaceId = '$facetofaceId' and v.facetofaceSession = '$facetofaceSession' and i.id = '$value->que_id' and v.feedback_description != '' ";

                        // $qry1    = " SELECT feedback_description FROM mdl_feedback_value WHERE facetofaceSessionDates = '$facetofaceSessionDates' AND facetofaceId = '$facetofaceId' and facetofaceSession = '$facetofaceSession' and feedback_description != '' ";
                        $get_comments    = $DB->get_records_sql($qry1);
                        foreach ($get_comments as $key1 => $value1) {
                            if(isset($value1->feedback_description))
                            {
                              $comments[] = $value1->feedback_description;
                            }
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
          $query_fetch_user = $DB->get_record_sql("SELECT u.id as userid FROM mdl_user as u LEFT JOIN mdl_external_tokens as et ON u.id = et.userid WHERE u.employee_code = '$employee_code' && u.company_code = '$company_code' && et.token = '$wsToken'");
            if(!empty($query_fetch_user)){
                $userid = $query_fetch_user->userid;
                $time   = time();
                $qry    = "select cm.instance from {course_modules} as cm join {feedback_item} as fi on fi.feedback = cm.instance where cm.id = $coursemoduleid and cm.module=7 and fi.id=$feedback_question";
                $get_feedbackid = $DB->get_record_sql($qry);
                
                if(!empty($get_feedbackid)){
                    $feedbackid         = $get_feedbackid->instance;
                    $submited_feedback  = $DB->get_record_sql("select fc.id from {feedback_completed} as fc where fc.feedback = $feedbackid and userid=$userid");
                    //print_r($submited_feedback); exit();
                    //print_r('1');
                    if(!empty($submited_feedback))
                    {    
                       $sbfid = $submited_feedback->id;
                       //print_r('2');
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
                        //print_r('3');
                        $sql = 'INSERT INTO mdl_feedback_completed(feedback,userid,timemodified,anonymous_response) VALUES ('.$feedbackid.','.$userid.','.$time.',1)';
                        //echo $sql; //exit();
                        $DB->execute($sql);
                        //print_r('4');
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
              //print_r('3');
                    $get_ans = $DB->get_record_sql("select * from mdl_feedback_value as fv where (fv.item ='$feedback_question' && fv.user_id ='$userid' && fv.facetofaceSessionDates = '$facetofaceSessionDates' && fv.facetofaceId = '$facetofaceId' && fv.facetofaceSession = '$facetofaceSession')");
                    //print_r($get_ans);
                    //print_r('4');
                    $rec_insert1  = new stdClass();
                    $rec_insert1->item      = $feedback_question;
                    $rec_insert1->completed = $sbfid;
                    $rec_insert1->value     = $feedbacktext ;
                    $rec_insert1->user_id   = $userid;
                    $rec_insert1->feedback_description   = isset($_POST['description']) ? $_POST['description'] : 'NULL';
                    $rec_insert1->facetofaceSessionDates = isset($facetofaceSessionDates)?$facetofaceSessionDates : 0;
                    $rec_insert1->facetofaceId      = isset($facetofaceId)?$facetofaceId : 0;
                    $rec_insert1->facetofaceSession = isset($facetofaceSession)?$facetofaceSession : 0;
                    //print_r('5');
                    if(empty($get_ans))
                    {
                      // print_r('6');
                        //$sbfv = $DB->insert_record('feedback_value', $rec_insert1, true);
                        (empty($rec_insert1->facetofaceSessionDates)) ? $rec_insert1->facetofaceSessionDates = 0 : '';
                        (empty($rec_insert1->facetofaceId)) ? $rec_insert1->facetofaceId = 0 : '';
                        (empty($rec_insert1->facetofaceSession)) ? $rec_insert1->facetofaceSession = 0 : '';
                        
                        $sql_inst = 'INSERT INTO mdl_feedback_value(item,completed,value,user_id,feedback_description,facetofaceSessionDates,facetofaceId,facetofaceSession) VALUES ('.$rec_insert1->item.','.$rec_insert1->completed.','.$rec_insert1->value.','.$rec_insert1->user_id.',\''.$rec_insert1->feedback_description.'\','.$rec_insert1->facetofaceSessionDates.','.$rec_insert1->facetofaceId.','.$rec_insert1->facetofaceSession.')';
                        //echo "inst". $sql_inst; //exit();
                        $DB->execute($sql_inst);

                        $status  = 1;
                        $message = "feedback submitted Successfully.";
                    }
                    else
                    {
                      // print_r('7');
                       $rec_insert1->id = $get_ans->id;
                        //$rec_insert1->item
            // $rec_insert1->completed
            // $rec_insert1->value
            // $rec_insert1->user_id
            // $rec_insert1->feedback_description
            (empty($rec_insert1->facetofaceSessionDates)) ? $rec_insert1->facetofaceSessionDates = 0 : '';
            (empty($rec_insert1->facetofaceId)) ? $rec_insert1->facetofaceId = 0 : '';
            (empty($rec_insert1->facetofaceSession)) ? $rec_insert1->facetofaceSession = 0 : '';
            // $rec_insert1->id
                        //$DB->update_record('feedback_value', $rec_insert1);
                        // print_r('item '.$rec_insert1->item);
                        // print_r('completed '.$rec_insert1->completed);
                        // print_r('value '.$rec_insert1->value);
                        // print_r('uid '.$rec_insert1->user_id);
                        // print_r('feedback desc '.$rec_insert1->feedback_description);
                        // print_r('f2fsessdates '.$rec_insert1->facetofaceSessionDates);
                        // print_r('f2fid '.$rec_insert1->facetofaceId);
                        // print_r('f2fSess '.$rec_insert1->facetofaceSession);
                        // exit();
                        $sql_upd = 'UPDATE mdl_feedback_value SET item ='.$rec_insert1->item.', completed = '.$rec_insert1->completed.', value = '.$rec_insert1->value.', user_id = '.$rec_insert1->user_id.', feedback_description = \''.$rec_insert1->feedback_description.'\', facetofaceSessionDates = '.$rec_insert1->facetofaceSessionDates.', facetofaceId = '.$rec_insert1->facetofaceId.', facetofaceSession = '.$rec_insert1->facetofaceSession.' WHERE id = '.$rec_insert1->id;
                        //echo "upd". $sql_upd; exit();
                        $DB->execute($sql_upd);
                        // print_r('8');
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
    }else if($wsfunction == "get_trainer_calenderdetails"){
        $wsToken = $_POST['wsToken'];
        $employee_code = $_POST['employee_code'];
        $company_code = $_POST['company_code'];
        if($wsToken != '' && $employee_code!= '' && $company_code != '')
        { 
            $query_fetch_user = $DB->get_records_sql("SELECT u.id as userid FROM mdl_user as u LEFT JOIN mdl_external_tokens as et ON u.id = et.userid WHERE u.employee_code = '$employee_code' && u.company_code = '$company_code' && et.token = '$wsToken'");
            if(!empty($query_fetch_user))
            {
              foreach($query_fetch_user as $rs_fetch_user)  {  
                  $fetch_user_data =  $rs_fetch_user;
              }
              $userid = $fetch_user_data->userid;
              $ctime=time(); 
              $qry="SELECT e.id, e.name, e.description,e.courseid,e.timestart,e.timemodified FROM  mdl_event as e WHERE (e.userid=$userid or e.eventtype='site')";
              $query_fetch_event = $DB->get_records_sql($qry);
              $status=0;
              $message="Events Not Available.";
              foreach($query_fetch_event as $rs_fetch_event)
              {
                $rs_fetch_event->description=strip_tags($rs_fetch_event->description);
                      $fetch_event_data[] =  $rs_fetch_event;
                $status=1;
                $message="Events Available.";
              }
              $returndata['status']=$status;
              $returndata['message']=$message;
              $returndata['events']=$fetch_event_data;
          
              echo $data = json_encode($returndata);
            }else{
               echo $data = json_encode(['Message'=>'Invalid Api Token']);
            }
        }else{
          echo $data = json_encode(['Message'=>'Parameters are missing']);
        }
    }else if($wsfunction == "my_points"){
        $wsToken = $_POST['wsToken'];
        $employee_code = $_POST['employee_code'];
        $company_code = $_POST['company_code'];
        $courseid = $_POST['courseid'];

        if($wsToken != '' && $employee_code!= '' && $company_code != '' && $courseid != '')
        { 
            $query_fetch_user = $DB->get_records_sql("SELECT u.id as userid FROM mdl_user as u LEFT JOIN mdl_external_tokens as et ON u.id = et.userid WHERE u.employee_code = '$employee_code' && u.company_code = '$company_code' && et.token = '$wsToken'");
            if(!empty($query_fetch_user))
            {
                foreach($query_fetch_user as $rs_fetch_user)  {  
                    $fetch_user_data =  $rs_fetch_user;
                }
                $userid = $fetch_user_data->userid;

                $currenttime=time();
                $query_course = $DB->get_records_sql(" 
                    SELECT 
                    c.id AS courseid,c.fullname as coursefullname FROM {user} u
                    LEFT JOIN {user_enrolments} ue ON ue.userid = u.id
                    LEFT JOIN {enrol} e ON e.id = ue.enrolid
                    LEFT JOIN {course} c ON e.courseid = c.id WHERE u.id=$userid and c.visible = 1 and e.courseid = $courseid");
                $completionstatus=array();
                $checkenrol=0;
                $details=array();
                foreach($query_course as $rs_course)
                {
                  $checkenrol=1;
                  $cid=$rs_course->courseid;
                }
                if($checkenrol == 1)
                {
                    $qry_xpconfig=$DB->get_records_sql("select id as 'xpid',enabled,levelsdata from mdl_block_xp_config where courseid=$courseid and enabled = 1");
                    $check_xpconfig=0;
                    $levelsdata="dummy";
                    $levelsdata=json_decode('{"xp":{"1":0,"2":120,"3":276,"4":479,"5":743,"6":1086,"7":1532,"8":2112,"9":2866,"10":3846},"desc":{"1":"","2":"","3":"","4":"","5":"","6":"","7":"","8":"","9":"","10":""},"base":120,"coef":1.3,"usealgo":true}');
                    foreach($qry_xpconfig as $rs_xpconfig)
                    {
                      $check_xpconfig=1;
                      if($rs_xpconfig->levelsdata != "")
                      {
                        $levelsdata=json_decode($rs_xpconfig->levelsdata);
                      }
                    }
                    if($check_xpconfig == 1)
                    {
                      $status=1;
                      $message="My Points is enabled for this course";
                      //        $details['levelsdata']=$levelsdata;
                      $qry_points=$DB->get_records_sql("select xp,lvl from mdl_block_xp where courseid=$courseid and userid = $userid");
                      $xplevel=1;
                      $xppoint=0;
                      foreach($qry_points as $rs_points)
                      {
                        $xplevel=$rs_points->lvl;
                        $xppoint=$rs_points->xp;
                      }
                      $details['points']['level']=$xplevel;
                      $details['points']['point']=$xppoint;
                      $totalopints=0;
                      foreach($levelsdata->xp as $x=> $y)
                      {
                        if($x== ($xplevel+1))
                        {
                        $totalopints=$y;
                        }
                      }
                      $details['points']['total point']=$totalopints;
                      $details['points']['togo']=$totalopints-$xppoint;
                    }
                    else
                    {
                      $status=0;
                      $message="My Points is not enabled for this course";
                    }
                }
                else
                {
                  $status=0;
                  $message="User not enrolled in this course.";
                }

                $returndata['status']=$status;
                $returndata['message']=$message;
                $returndata['details']=$details;


                echo $data = json_encode($returndata);


            }else{
                 echo $data = json_encode(['Message'=>'Invalid Api Token']);
            }
        }else{
          echo $data = json_encode(['Message'=>'Parameters are missing']);
        }
    }else if($wsfunction == "all_points"){
        $wsToken = $_POST['wsToken'];
        $employee_code = $_POST['employee_code'];
        $company_code = $_POST['company_code'];
        $courseid = $_POST['courseid'];
         
        if($wsToken != '' && $employee_code!= '' && $company_code != '' && $courseid != '')
        { 
            $query_fetch_user = $DB->get_records_sql("SELECT u.id as userid FROM mdl_user as u LEFT JOIN mdl_external_tokens as et ON u.id = et.userid WHERE u.employee_code = '$employee_code' && u.company_code = '$company_code' && et.token = '$wsToken'");
            if(!empty($query_fetch_user))
            {
              foreach($query_fetch_user as $rs_fetch_user)  {  
                  $fetch_user_data =  $rs_fetch_user;
              }
              $userid = $fetch_user_data->userid;
              $details=array();
              $status=0;
              $message="My Points is not enabled for this course";
              $qry_xpconfig=$DB->get_records_sql("select id as 'xpid',enabled,levelsdata from mdl_block_xp_config where courseid=$courseid and enabled = 1");
              $check_xpconfig=0;
              $levelsdata="dummy";
              $levelsdata=json_decode('{"xp":{"1":0,"2":120,"3":276,"4":479,"5":743,"6":1086,"7":1532,"8":2112,"9":2866,"10":3846},"desc":{"1":"","2":"","3":"","4":"","5":"","6":"","7":"","8":"","9":"","10":""},"base":120,"coef":1.3,"usealgo":true}');
              foreach($qry_xpconfig as $rs_xpconfig)
              {
                $check_xpconfig=1;
                if($rs_xpconfig->levelsdata != "")
                {
                  $levelsdata=json_decode($rs_xpconfig->levelsdata);
                }
              }
              if($check_xpconfig == 1)
              {
                $status=1;
                $message="My Points is enabled for this course";
                //      $details['levelsdata']=$levelsdata;
                $qry_points=$DB->get_records_sql("select x.xp,x.lvl,u.firstname,u.lastname from mdl_block_xp as x left join mdl_user as u on x.userid = u.id where courseid=$courseid");
                //      print_r($qry_points);
                foreach($qry_points as $rs_points)
                {
                  $lblarray=array();
                  $xplevel=1;
                  $xppoint=0;
                  $xplevel=$rs_points->lvl;
                  $xppoint=$rs_points->xp;
                  $lblarray['user']=$rs_points->firstname ." ". $rs_points->lastname;
                  $lblarray['level']=$xplevel;
                  $lblarray['point']=$xppoint;
                  $totalopints=0;
                  foreach($levelsdata->xp as $x=> $y)
                  {
                    if($x== ($xplevel+1))
                    {
                      $totalopints=$y;
                    }
                  }
                  $lblarray['total point']=$totalopints;
                  $lblarray['togo']=$totalopints-$xppoint;
                  $details[]=$lblarray;
                }
              }   
              else
              {
                $status=0;
                $message="My Points is not enabled for this course";
              }
              $returndata['status']=$status;
              $returndata['message']=$message;
              $returndata['details']=$details;
              echo $data = json_encode($returndata);
            }else{
                echo $data = json_encode(['Message'=>'Invalid Api Token']);
            }
        }else{
            echo $data = json_encode(['Message'=>'Parameters are missing']);
        }
    }else if($wsfunction == "self_nomination"){
      global $CFG;
      $wsToken       = $_POST['wsToken'];
      $employee_code = $_POST['employee_code'];
      $company_code  = $_POST['company_code'];
      $courseid      = $_POST['courseid'];
      $userid        = '';
      $check_course  = 0;
               
      if($wsToken != '' && $employee_code!= '' && $company_code != '' && $courseid != ''){ 
               
        // $query_fetch_user = $DB->get_record_sql("SELECT u.*,u.managersemail,u.reporting_manager_id FROM mdl_user as u LEFT JOIN mdl_external_tokens as et ON u.id = et.userid WHERE u.employee_code = '$employee_code' and u.deleted = 0 and u.company_code = '$company_code' and et.token = '$wsToken'");

        $query_fetch_user = $DB->get_record_sql("SELECT u.* FROM mdl_user as u LEFT JOIN mdl_external_tokens as et ON u.id = et.userid WHERE u.employee_code = '$employee_code' and u.deleted = 0 and u.company_code = '$company_code'");

        if(!empty($query_fetch_user)){
            
          $userid = $query_fetch_user->id;
          $time   = time();

          $query_fetch_manager = $DB->get_record_sql("SELECT u.id,u.email FROM mdl_user as u WHERE u.employee_code = '$query_fetch_user->reporting_manager_code'");

          $qry_check_course = $DB->get_record_sql("select * from {course} where id = $courseid");
          $check_course     = 0;
          if(!empty($query_fetch_user)){
            $check_course = 1;
          }

          if($check_course==1)
          {
        
            $qry="SELECT e.id AS enrolid 
                  FROM {user_enrolments} as ue
                  LEFT JOIN {enrol} e ON e.id = ue.enrolid
                  WHERE ue.userid=$userid and e.courseid=$courseid";
            $query_check_enrol = $DB->get_record_sql($qry);
            $check=0;
            if(!empty($query_check_enrol)){
              $check = 1;
            }

            if($check==1)
            {
              $status=0;
              $message="Already enrolled in this course";
            }
            else
            {
              $rec_insert= new stdClass();
              $rec_insert->enrol='self';
              $rec_insert->courseid= $courseid;
              $rec_insert->timecreated= $time;
              $enrolid="dummy";
               //        print_r($rec_insert);
              $enrolid = $DB->insert_record('enrol', $rec_insert, true);
              $rec_insert1= new stdClass();
              $rec_insert1->enrolid= $enrolid;
              $rec_insert1->userid= $userid;
              $rec_insert1->timecreated= $time;
              $enrolmentid ="Dummy";
              //        print_r($rec_insert1);
              $enrolmentid = $DB->insert_record('user_enrolments', $rec_insert1, true);
              $status      = 1;
           
              $managers_email = $query_fetch_manager->email;
              $get_course     = $DB->get_record('course',array('id' => $courseid));
              $get_category   = $DB->get_record_sql("SELECT * FROM `mdl_course_categories` where id = '$get_course->category'");
              $get_category_name = $get_category->plain_name;
              $portal_link    = "https://portal.zinghr.com";
             
              $messagehtml    = "<p> Dear ".$query_fetch_user->firstname." ".$query_fetch_user->lastname.",<br><br>
                              You have enrolled yourself for the course <b>".$get_course->fullname."</b><br>
                              Please click here to access the course <br> ".$portal_link." <br> 
                              NOTE : [ For LMS navigation - Please login with Portal Link and then click on LMS icon .You will land on 'Home' page of LMS. Click on category <b>".$get_category_name." </b>, with in this you will get course <b>".$get_course->fullname." </b> ] <br>
                              Happy Learning !! <br><br> 
                              Regards, <br>
                              <i>  ZingHr Learning & Development Team <i/></p>";

              $subject    = "Welcome to <b>".$get_course->fullname."</b>";
             

              $message = new stdClass();
              $message->html = $messagehtml;
              $message->text = "Congrats";
              $message->subject = $subject;
              $message->from_email = "zinghr@support.com";
              $message->from_name  = "Admin (via ZingLearn)";
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
      global $CFG;
      $wsToken       = $_POST['wsToken'];
      $employee_code = $_POST['employee_code'];
      $company_code  = $_POST['company_code'];
      $courseid      = $_POST['courseid'];
      $userid        = '';
      $check_course  = 0;
               
      if($wsToken != '' && $employee_code!= '' && $company_code != '' && $courseid != ''){ 
               
        /*
        $query_fetch_user = $DB->get_record_sql("SELECT u.*,u.managersemail,u.reporting_manager_id FROM mdl_user as u LEFT JOIN mdl_external_tokens as et ON u.id = et.userid WHERE u.employee_code = '$employee_code' && u.company_code = '$company_code' && et.token = '$wsToken'");
        */

        // $query_fetch_user = $DB->get_record_sql(" SELECT u.*,u.managersemail,u.reporting_manager_id,au.email as manager_email,CONCAT(au.firstname, ' ', au.lastname) AS manager_name,au.deleted as is_manager_del,aau.email as rep_manager_email,CONCAT(aau.firstname, ' ', aau.lastname) AS rep_manager_name 
        //                 FROM `mdl_user` as u 
        //                 left join `mdl_user_bulk` as ub on u.id = u.id 
        //                 left JOIN `mdl_user` as au ON u.managersemail = au.email 
        //                 left JOIN `mdl_user` as aau ON u.reporting_manager_id = aau.id
        //                 LEFT JOIN `mdl_external_tokens` as et ON u.id = et.userid 
        //                 WHERE u.employee_code = '$employee_code' and u.deleted = 0 and u.company_code = '$company_code' and et.token = '$wsToken'");

        $query_fetch_user = $DB->get_record_sql("SELECT u.* FROM mdl_user as u LEFT JOIN mdl_external_tokens as et ON u.id = et.userid WHERE u.employee_code = '$employee_code' and u.deleted = 0 and u.company_code = '$company_code'");

        if(!empty($query_fetch_user)){
            
            $userid = $query_fetch_user->id;
            $time   = time();

            $query_fetch_manager = $DB->get_record_sql("SELECT u.* FROM mdl_user as u WHERE u.employee_code = '$query_fetch_user->reporting_manager_code'");

            $qry_check_course = $DB->get_record_sql("select * from {course} where id = $courseid");
            $check_course     = 0;
            if(!empty($query_fetch_user)){
                $check_course = 1;
            }

            if($check_course == 1){
            
                $qry="  SELECT e.id AS enrolid 
                        FROM {enrol} as e
                        JOIN {user_enrolments} ue ON e.id = ue.enrolid
                        WHERE ue.userid=$userid and e.courseid=$courseid";

                // $qry="  SELECT e.id AS enrolid 
                //         FROM {enrol} as e
                //         JOIN {user_enrolments} ue ON e.id = ue.enrolid
                //         JOIN {enrol_apply_applicationinfo} app ON ue.id = app.userenrolmentid
                //         WHERE ue.userid=$userid and e.courseid=$courseid";

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

                    // $rec_insert_apply = new stdClass();
                    // $rec_insert_apply->userenrolmentid  = $user_enrolmentid;
                    // $rec_insert_apply->comment          = "request through mobile";
                    // $enrol_applyid = $DB->insert_record('enrol_apply_applicationinfo', $rec_insert_apply, true);

                    $status      = 1;
       
                    $managers_email = $query_fetch_manager->email;
                    $get_course     = $DB->get_record('course',array('id' => $courseid));
                    $get_category   = $DB->get_record_sql("SELECT * FROM `mdl_course_categories` where id = '$get_course->category'");
                    $get_category_name = $get_category->plain_name;
                    $portal_link    = "https://portal.zinghr.com";
                     
                    $messagehtml = "<p> Dear Manager,<br><br> 
                    Your Associate ".$query_fetch_user->firstname." ".$query_fetch_user->lastname." has nominated himself/herself for attending the elearning Course <b>".$get_course->fullname.".</b><br>Kindly click on the link to approve / reject the same. <br>
                    <a href='".$CFG->wwwroot."/enrol/apply/manage.php'> Manage Enrol Applications </a> <br>
                    To know more about the training program click here ".$portal_link." <br>  
                    NOTE : [ For LMS navigation - Please login with Portal Link and then click on LMS icon .You will land on 'Home' page of LMS. Click on category <b>".$get_category_name." </b>, with in this you will get course <b>".$get_course->fullname." </b> ] <br>
                    Happy Learning !!<br><br> 
                    Regards,<br>
                    <i> ZingHr Learning & Development Team </i> </p>";

                    $subject     = "Manage Course ".$get_course->fullname;
                     
                    $message = new stdClass();
                    $message->html = $messagehtml;
                    $message->text = "Congrats";
                    $message->subject = $subject;
                    $message->from_email = "zinghr@support.com";
                    $message->from_name  = "Admin (via ZingLearn)";
                    $message->to = array(array("email" => $managers_email));
                    //$message->to = array(array("email" => 'sunitineo@gmail.com'));
                    $message->track_opens = true;

                    if($query_fetch_user->is_manager_del)
                    {
                      $response = $mandrill->messages->send($message);
                    }

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
    }else if($wsfunction == "get_training_status"){
              global $CFG;
              $wsToken = $_POST['wsToken'];
              $employee_code = $_POST['employee_code'];
              $company_code = $_POST['company_code'];
              // $employeeid = $_POST['employeeid'];
               if($wsToken != '' && $employee_code!= '' && $company_code != '' ){ 
               $query_fetch_user = $DB->get_records_sql("SELECT u.id as userid FROM mdl_user as u LEFT JOIN mdl_external_tokens as et ON u.id = et.userid WHERE u.employee_code = '$employee_code' && u.company_code = '$company_code' && et.token = '$wsToken'");
                if(!empty($query_fetch_user)){
                    foreach($query_fetch_user as $rs_fetch_user)  {  
                        $fetch_user_data =  $rs_fetch_user;
               }
                   $userid = $fetch_user_data->userid;
                   $qry="select c.id as 'courseid', c.fullname as 'course', r.shortname as 'rolename' from {user_enrolments} as ue left join {enrol} as e on ue.enrolid = e.id left join {course} as c on e.courseid = c.id left join {role} as r on e.roleid = r.id where ue.userid=$userid and c.visible = 1 and c.category != 0";
                  $query_fetch_enrollment = $DB->get_records_sql($qry);
                  $status=0;
                  $message="Employee not enrolled.";
                  $fetch_enrollment_data=array();
                      foreach($query_fetch_enrollment as $rs_fetch_enrollment)
                      {
                          $fetch_enrollment_data[] =  $rs_fetch_enrollment;
                    $status=1;
                    $message="Employee enrollment details.";
                      }
                  $returndata['status']=$status;
                  $returndata['message']=$message;
                  $returndata['enrollment']=$fetch_enrollment_data;
                  
                      echo $data = json_encode($returndata);
               }else{
                   echo $data = json_encode(['Message'=>'Invalid Api Token']);
               }
           }else{
              echo $data = json_encode(['Message'=>'Parameters are missing']);
           }
    }else if($wsfunction == "overall_completion_status"){
        global $CFG;
        $wsToken = $_POST['wsToken'];
        $employee_code = $_POST['employee_code'];
        $company_code = $_POST['company_code'];
               
        if($wsToken != '' && $employee_code!= '' && $company_code != ''){ 
               
            $query_fetch_user = $DB->get_records_sql("SELECT u.id as userid FROM mdl_user as u LEFT JOIN mdl_external_tokens as et ON u.id = et.userid WHERE u.employee_code = '$employee_code' && u.company_code = '$company_code' && et.token = '$wsToken'");
            
            if(!empty($query_fetch_user)){
                foreach($query_fetch_user as $rs_fetch_user)  
                {  
                    $fetch_user_data =  $rs_fetch_user;
                }
                $userid = $fetch_user_data->userid;
                $query_course = $DB->get_records_sql(" 
                      SELECT 
                      c.id AS courseid,c.fullname as coursefullname FROM {user} u
                      LEFT JOIN {user_enrolments} ue ON ue.userid = u.id
                      LEFT JOIN {enrol} e ON e.id = ue.enrolid
                      LEFT JOIN {course} c ON e.courseid = c.id WHERE u.id=$userid and c.visible = 1 and c.category != 0");
                $completionstatus=array();
                foreach($query_course as $rs_course)
                {
                    $courseid=$rs_course->courseid;
                    $qry="SELECT count(instance) as 'ti' from {course_modules} where course = $courseid and deletioninprogress=0";
                    $query_course_module = $DB->get_records_sql($qry);
                    $total_module=0;
                    foreach($query_course_module as $rs_course_module)
                    {
                        $total_module =  $rs_course_module->ti;
                    }
                    $rs_course->totalmodule=$total_module;
                    $qry="select count(DISTINCT coursemoduleid) as tcm from {course_modules_completion} where coursemoduleid in (SELECT id FROM {course_modules} where course = $courseid and deletioninprogress=0) and userid = $userid";
                    $query_quiz_summery = $DB->get_records_sql($qry);
                    $total_completion=0;
                    foreach($query_quiz_summery as $rs_quiz_summery)
                    {
                        $total_completion =  $rs_quiz_summery->tcm;
                    }
                    $rs_course->completedmodule=$total_completion;
                    $completionpercent=($total_completion / $total_module) * 100;
                    $rs_course->completepercent=$completionpercent;
                    $completionstatus[]=$rs_course;
              
                }
            
                $returndata['courses']=$completionstatus;
            
                echo $data = json_encode($returndata);     

            }else{
                 echo $data = json_encode(['Message'=>'Invalid Api Token']);
            }
        }else{
          echo $data = json_encode(['Message'=>'Parameters are missing']);
        }
    }else if($wsfunction == "reports"){
      $wsToken = $_POST['wsToken'];
      $employee_code = $_POST['employee_code'];
      $company_code = $_POST['company_code'];
      $country = $_POST['country'];
      $c_length = strlen($country);
      $course = $_POST['program'];
       
      if($wsToken != '' && $employee_code!= '' && $company_code != '')
      { 
          $query_fetch_user = $DB->get_records_sql("SELECT u.id as userid FROM mdl_user as u LEFT JOIN mdl_external_tokens as et ON u.id = et.userid WHERE u.employee_code = '$employee_code' && u.company_code = '$company_code' && et.token = '$wsToken'");
                
          if(!empty($query_fetch_user)){
               if($country != ''){
                  if($c_length <= 2){
                     $sql = "SELECT COUNT(c.id) as totalProgram,COUNT(u.username) as totalPeople,COUNT(c.startdate) as totalSession,COUNT(cmc.id) as totalPeopleTrained,COUNT(DISTINCT cmc.id) as totalUniquePeopleTrained
                                  FROM mdl_user as u 
                                  LEFT JOIN mdl_user_enrolments as ue ON u.id = ue.userid
                                  LEFT JOIN mdl_course_modules_completion as cmc ON u.id = cmc.userid
                                  LEFT JOIN {enrol} as e ON ue.enrolid = e.id
                                  LEFT JOIN {course} as c ON e.courseid = c.id
                                  LEFT JOIN {course_categories} as cc ON c.category = cc.id WHERE u.country = '$country' AND cmc.completionstate = 1"; 
                                  }else{
                                       echo $data = json_encode(['Message'=>'Country not more than 2 char']);
                                  }          
               }else if($gender != ''){
                  $sql = "SELECT COUNT(c.id) as totalProgram,COUNT(u.username) as totalPeople,COUNT(c.startdate) as totalSession,COUNT(cmc.id) as totalPeopleTrained,COUNT(DISTINCT cmc.id) as totalUniquePeopleTrained
                                  FROM mdl_user as u 
                                  LEFT JOIN mdl_user_enrolments as ue ON u.id = ue.userid
                                  LEFT JOIN mdl_course_modules_completion as cmc ON u.id = cmc.userid
                                  LEFT JOIN {enrol} as e ON ue.enrolid = e.id
                                  LEFT JOIN {course} as c ON e.courseid = c.id
                                  LEFT JOIN {course_categories} as cc ON c.category = cc.id WHERE u.gender = '$gender' AND cmc.completionstate = 1"; 
               }else{
                  $sql = "SELECT COUNT(c.id) as totalProgram,COUNT(u.username) as totalPeople,COUNT(c.startdate) as totalSession,COUNT(cmc.id) as totalPeopleTrained,COUNT(DISTINCT cmc.id) as totalUniquePeopleTrained
                                  FROM mdl_user as u 
                                  LEFT JOIN mdl_user_enrolments as ue ON u.id = ue.userid
                                  LEFT JOIN mdl_course_modules_completion as cmc ON u.id = cmc.userid
                                  LEFT JOIN {enrol} as e ON ue.enrolid = e.id
                                  LEFT JOIN {course} as c ON e.courseid = c.id
                                  LEFT JOIN {course_categories} as cc ON c.category = cc.id WHERE u.country = '$country' AND cmc.completionstate = 1"; 
               }
                 $query_report = $DB->get_records_sql($sql); 
                 // print_r($query_report);exit;
                 foreach($query_report as $f_rpt){
                          // $c_date = $f_rpt->startdate;
                          // $end_date = $f_rpt->startdate;
                          // if(!empty($c_date)){
                          //   $dateValue=date_create(date("Y-m-d H:i:s",($c_date)));
                          //   $time=strtotime($dateValue*1000);
                          //   $f_rpt->startdate = $dateValue;
                          //   $f_rpt->year = date("Y",$time);
                          //   $f_rpt->month = date("F",$time);
                          //   if(!empty($end_date)){
                          //     $endDateValue = date_create(date("Y-m-d H:i:s",($end_date)));
                          //     $f_rpt->enddate = $endDateValue;
                          //   }
                          // }else{
                          //   $f_rpt->year = 0;
                          //   $f_rpt->month = 0;
                          // }
                      //   if(!empty($startdate) && !empty($enddate))){
                      //   $enddate=date_create(date("Y-m-d H:i:s",$startdate));
                      //   $startdate=date_create(date("Y-m-d H:i:s",$startdate));
                      //   $diff=date_diff($enddate,$startdate);
                      //   $courseduration=$diff;
                      //   $courseduration=$diff->y." Year-".$diff->m." Month-".$diff->d." Days ".$diff->h." hours:".$diff->i." minutes:".$diff->s." seconds";
                      // }else{
                      //   $f_rpt->totalHoursOfTraining = 0;
                      // }
                      $finalData[] = $f_rpt;
                 } 
                 echo $data = json_encode(['report' => $finalData]);   
               }else{
                   echo $data = json_encode(['Message'=>'Invalid Api Token']);
               }
      }else{
        echo $data = json_encode(['Message'=>'Parameters are missing']);
      }
    }else if($wsfunction == "user_enrolled_course"){
        global $CFG;
        $wsToken = $_POST['wsToken'];
        $employee_code = $_POST['employee_code'];
        $company_code = $_POST['company_code'];
        $companycode = $_POST['categoryid'];
        if($wsToken != '' && $employee_code!= '' && $company_code != '' && $companycode != ''){ 
            $query_fetch_user = $DB->get_records_sql("SELECT u.* FROM mdl_user as u LEFT JOIN mdl_external_tokens as et ON u.id = et.userid WHERE u.employee_code = '$employee_code' && u.company_code = '$company_code' && et.token = '$wsToken'");
            if(!empty($query_fetch_user)){
                foreach($query_fetch_user as $rs_fetch_user)  {  
                    $fetch_user_data =  $rs_fetch_user;
                }
                $userid = $fetch_user_data->id;
                $qry="select c.id, c.fullname, c.shortname, c.summary, c.startdate, c.enddate, c.visible, c.enablecompletion from {course_categories} as cc left join {course} as c on c.category = cc.id left join {enrol} as e on e.courseid = c.id left join {user_enrolments} as ue on e.id=ue.enrolid where cc.id=$companycode and ue.userid=$userid";
                $query_mandatory_course = $DB->get_record_sql($qry);
                $mandatory_course_data[] =  $query_mandatory_course;
                $mandatory_course_details=array();
                $mandatory_course_details["coursedetails"]=$mandatory_course_data;

                echo json_encode($mandatory_course_details);
            }else{
               echo $data = json_encode(['Message'=>'Invalid Api Token']);
            }
        }else{
          echo $data = json_encode(['Message'=>'Parameters are missing']);
       }
    }else if($wsfunction == "get_all_courses"){
          global $CFG;
          $wsToken        = $_POST['wsToken'];
          $employee_code  = $_POST['employee_code'];
          $company_code   = $_POST['company_code'];
          
          if($wsToken != '' && $employee_code!= '' && $company_code != ''){ 
                     
              $query_fetch_user = $DB->get_record_sql("SELECT u.id as userid FROM mdl_user as u LEFT JOIN mdl_external_tokens as et ON u.id = et.userid WHERE u.employee_code = '$employee_code' && u.company_code = '$company_code' && et.token = '$wsToken'");
              
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
                          $course_img =  $CFG->wwwroot.'/pluginfile.php/'.$rs_course_img->contextid.'/'.$rs_course_img->component.'/'.$rs_course_img->filearea.'/'.$rs_course_img->filename;
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
                              // $mandatory_course_data[] =  $rs_mandatory_course;
                          }
                        }
                      }
                      else
                      {
                        $mandatory_course_data[] =  $rs_mandatory_course;
                      }

                      // $mandatory_course_data[] =  $rs_mandatory_course;
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
          global $CFG;
          $wsToken        = $_POST['wsToken'];
          $employee_code  = $_POST['employee_code'];
          $company_code   = $_POST['company_code'];
          $companycode    = $_POST['categoryid'];
        
          if($wsToken != '' && $employee_code!= '' && $company_code != '' && $companycode != ''){ 
              $query_fetch_user = $DB->get_record_sql("SELECT u.* FROM mdl_user as u LEFT JOIN mdl_external_tokens as et ON u.id = et.userid WHERE u.employee_code = '$employee_code' && u.company_code = '$company_code' && et.token = '$wsToken'");
              
              if(!empty($query_fetch_user)){
                  $userid = $query_fetch_user->id;
                  $qry="select c.id, c.fullname, c.shortname, c.summary, c.startdate, c.enddate, c.visible, c.enablecompletion from {course_categories} as cc left join {course} as c on c.category = cc.id left join {enrol} as e on e.courseid = c.id left join {user_enrolments} as ue on e.id=ue.enrolid where cc.id=$companycode and ue.userid=$userid";
                  $query_mandatory_course = $DB->get_records_sql($qry);
                  foreach($query_mandatory_course as $rs_mandatory_course)
                  {
                        $rs_mandatory_course->fullname   = strip_tags($rs_mandatory_course->fullname);
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

                        $query_course_papers = $DB->get_records_sql("select cm.id as id,q.name as name,q.timeopen,q.timeclose,q.timelimit from {course_modules} as cm left join {quiz} as q on cm.instance = q.id where cm.module=16 and cm.course= $courseid and cm.deletioninprogress=0");
                  
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

                          $query_fetch_scorm = $DB->get_records_sql("SELECT cm.id,s.name,m.name as mod_name,f.id as fileid,f.contextid FROM `mdl_modules` as m join mdl_course_modules as cm on m.id = cm.module join mdl_scorm as s on cm.instance = s.id join mdl_files as f on f.contenthash = s.sha1hash WHERE m.`name` = 'scorm' and cm.deletioninprogress = 0 and f.component = 'mod_scorm' and s.course = $courseid ORDER by cm.id DESC ");

                          //print_r($query_fetch_scorm); exit();

                          $fetch_scorm_data = array();
                          foreach($query_fetch_scorm as $rs_fetch_scorm)
                          {
                              $get_records = $DB->get_records_sql("SELECT id as fileid,contextid,component,filearea,itemid,filepath,filename,userid,filesize FROM `mdl_files` WHERE `component` = 'mod_scorm' AND `filename`  in ('index.html','story_html5.html') and `contextid` = $rs_fetch_scorm->contextid");

                              if(!empty($get_records))
                              {
                                  foreach ($get_records as $key => $value) {
                                      $value->id        = $rs_fetch_scorm->id;
                                      $value->module_id = $rs_fetch_scorm->id;
                                      $value->name      = $rs_fetch_scorm->name;

                                      /*
                                      if($value->filepath === '/')
                                      {
                                        $value->url       = $CFG->wwwroot."/pluginfile.php/".$value->contextid."/".$value->component."/".$value->filearea."/".$value->itemid."/".$value->filename;
                                      }
                                      else
                                      {
                                        $value->url       = $CFG->wwwroot."/pluginfile.php/".$value->contextid."/".$value->component."/".$value->filearea."/".$value->itemid."/res/".$value->filename;
                                      }*/

                                      $value->url       = $CFG->wwwroot."/pluginfile.php/".$value->contextid."/".$value->component."/".$value->filearea."/".$value->itemid.$value->filepath.$value->filename;
                                      
                                      $fetch_scorm_data[]= $value;
                                  }
                              }
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

                           //For H5P -

                          // $query_fetch_hvp = $DB->get_records_sql("SELECT cm.id FROM `mdl_modules` as m join mdl_course_modules as cm on m.id = cm.module join mdl_course as c on c.id = cm.course WHERE c.id = '$courseid' and m.name = 'hvp' and cm.deletioninprogress = 0 ORDER by cm.id DESC");

                          // $query_fetch_hvp = $DB->get_records_sql("SELECT DISTINCT cm.id,h.name FROM `mdl_modules` as m join mdl_course_modules as cm on m.id = cm.module join mdl_course as c on c.id = cm.course join mdl_hvp as h on h.course= c.id WHERE c.id = '$courseid' and m.name = 'hvp' and cm.deletioninprogress = 0 ORDER by cm.id DESC");

                          // $query_fetch_hvp = $DB->get_records_sql("SELECT cm.id,h.name FROM `mdl_course_modules` as cm join mdl_hvp as h on h.id = cm.instance WHERE cm.`course` = '$courseid' AND cm.`module` = 26 and cm.deletioninprogress = 0");

                          // $query_fetch_hvp = $DB->get_records_sql("SELECT cm.id,h.name FROM `mdl_course_modules` as cm join mdl_hvp as h on h.id = cm.instance WHERE cm.`course` = '$courseid' AND cm.`module` = (SELECT id FROM `mdl_modules` where name = 'hvp') and cm.deletioninprogress = 0");

                          $query_fetch_hvp = $DB->get_records_sql("SELECT cm.id,substring_index(substring_index(substring_index(h.name, '<span lang=\"en\" class=\"multilang\">', -1),'<span lang=\"ar\"', 1),'</span>',1) as name FROM `mdl_course_modules` as cm join mdl_hvp as h on h.id = cm.instance WHERE cm.`course` = '$courseid' AND cm.`module` = (SELECT id FROM `mdl_modules` where name = 'hvp') and cm.deletioninprogress = 0");

                          $fetch_hvp_data = array();
                          if(!empty($query_fetch_hvp))
                          {
                              foreach ($query_fetch_hvp as $key_hvp => $value_hvp) {
                                  $value_hvp->url = $CFG->wwwroot."/mod/hvp/embed.php?id=".$value_hvp->id;
                                  $fetch_hvp_data[]= $value_hvp;
                              }
                          }

                          // f2f count

                        $qry = "SELECT count(*) as total
                                FROM mdl_modules as m
                                join mdl_course_modules as cm on cm.module = m.id
                                JOIN mdl_facetoface as f ON f.id = cm.instance
                                join mdl_course as c on c.id = f.course
                                WHERE m.name = 'facetoface'
                                and cm.deletioninprogress = 0 
                                and c.id = $courseid";

                        $query_fetch_event = $DB->get_record_sql($qry);

                          $rs_mandatory_course->f2f   =  $query_fetch_event->total;
                          $rs_mandatory_course->hvp   =  $fetch_hvp_data;
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
    }else if($wsfunction == "mail"){    
        $message = new stdClass();
        $message->html = "html message";
        $message->text = "Congrats";
        $message->subject = "Testing";
        $message->from_email = "nikhil.mishra@zinghr.com";
        $message->from_name  = "From Name";
        $message->to = array(array("email" => "sunitineo@gmail.com"));
        $message->track_opens = true;

        $response = $mandrill->messages->send($message);
        echo 'mail sent';
    }else{
         echo $data = json_encode(['Message'=>'Function Name Parameter wsfunction is missing']);
    }

function course_image($set_course_id)
{
  global $CFG;
  require_once('../lib/coursecatlib.php');

  $courseid     = new stdClass();
  $courseid->id = $set_course_id;
  $course       = new course_in_list($courseid); //print_r($course); //exit();
  $outputimage  = '';
  $imageurl     = '';

  // print_r($course->get_course_overviewfiles());

  foreach ($course->get_course_overviewfiles() as $file) {
      if ($file->is_valid_image()) {
          $imagepath = '/' . $file->get_contextid() .
                  '/' . $file->get_component() .
                  '/' . $file->get_filearea() .
                  $file->get_filepath() .
                  $file->get_filename();
          $imageurl = file_encode_url($CFG->wwwroot . '/pluginfile.php', $imagepath,
                  false);
          /*
          $outputimage = html_writer::tag('div',
                  html_writer::empty_tag('img', array('src' => $imageurl)),
                  array('class' => 'courseimage'));
          */
          
          // Use the first image found.
          break;
      }
  }
  // return $outputimage;
  return $imageurl;
}

?>
