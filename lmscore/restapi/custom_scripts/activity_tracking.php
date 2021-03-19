<?php

/*
* @author : Suniti Yadav
* description : User activity tracking - On Activity/ Module modification such as add , edit , delete to notify admin
*/

require_once '../../config.php';
require_once '../src/Mandrill.php';

$mandrill = new Mandrill($CFG->md_api_key);

global $DB, $CFG, $SESSION;

//Set time zone
date_default_timezone_set('Asia/Kolkata');

header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: access");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Allow-Credentials: true");
header('Content-Type: application/json');
header("HTTP/1.0 200 Successfull operation");

// Function to get the client IP address
function get_client_ip() {
    $ipaddress = '';
    if (isset($_SERVER['HTTP_CLIENT_IP']))
        $ipaddress = $_SERVER['HTTP_CLIENT_IP'];
    else if(isset($_SERVER['HTTP_X_FORWARDED_FOR']))
        $ipaddress = $_SERVER['HTTP_X_FORWARDED_FOR'];
    else if(isset($_SERVER['HTTP_X_FORWARDED']))
        $ipaddress = $_SERVER['HTTP_X_FORWARDED'];
    else if(isset($_SERVER['HTTP_FORWARDED_FOR']))
        $ipaddress = $_SERVER['HTTP_FORWARDED_FOR'];
    else if(isset($_SERVER['HTTP_FORWARDED']))
        $ipaddress = $_SERVER['HTTP_FORWARDED'];
    else if(isset($_SERVER['REMOTE_ADDR']))
        $ipaddress = $_SERVER['REMOTE_ADDR'];
    else
        $ipaddress = 'UNKNOWN';
    return $ipaddress;
}

$wsfunction = $_POST['wsfunction'];  
$response = array();

if($wsfunction == "user_activity_notifications"){
    $mdl_type    = $_POST['mdl_type'];
    $cm_id       = $_POST['cm_id'];
    $module_name = $_POST['module_name'];
    $action      = $_POST['action'];
    $user_id     = $_POST['user_id'];
    $course_id   = $_POST['course_id'];
    $course_name = '';
    $category    = '';
    $returndata  = array();

    if($action != '' && $module_name != '')
    {
        try {

            if($cm_id != 0)
            {
                $qry    =  "SELECT m.name ,c.fullname,substring_index(substring_index(substring_index(cc.name, '<span lang=\"en\" class=\"multilang\">', -1),'<span lang=\"ar\"', 1),'</span>',1) as category FROM `mdl_course_modules` as cm join mdl_modules as m on m.id = cm.module join `mdl_course` as c on c.id = cm.course join mdl_course_categories as cc on cc.id = c.category WHERE cm.id = '$cm_id'";
                $get_mdl_type   = $DB->get_record_sql($qry);
                $mdl_type       = $get_mdl_type->name;
                $course_name    = $get_mdl_type->fullname;
                $category       = $get_mdl_type->category;
            }

            if($course_id != 0)
            {
                $qry1    =  "SELECT c.id,c.fullname,substring_index(substring_index(substring_index(cc.name, '<span lang=\"en\" class=\"multilang\">', -1),'<span lang=\"ar\"', 1),'</span>',1) as category FROM `mdl_course` as c join mdl_course_categories as cc on cc.id = c.category where c.id = '$course_id'";
                $get_course_details = $DB->get_record_sql($qry1);
                $course_name        = $get_course_details->fullname;
                $category           = $get_course_details->category;
            }

            $qry1           =  " SELECT * FROM `mdl_user` WHERE id = '$user_id'";
            $modified_by    = $DB->get_record_sql($qry1);

            $sql        = "SELECT * FROM `mdl_config` WHERE `name` = 'siteadmins'";
            $get_admin  = $DB->get_record_sql($sql);
            $arr        = $get_admin->value;
            $ans        = explode(',',$arr);


            foreach ($ans as $key => $val) {
                if($modified_by->id != $val)
                {
                    $sql1    = "SELECT u.* FROM `mdl_user` as u where u.id = '$val'";
                    $users   = $DB->get_record_sql($sql1);

                    /*
                    $messagehtml    = "<p> Hi ".$users->firstname." ".$users->lastname.", <br><br>
                    The activity  <b>".$mdl_type." (".$module_name.") </b> from <b>".$category."</b> category and <b>".$course_name."</b> course has been ".$action." by <b> ".$modified_by->firstname."  ".$modified_by->lastname." </b> on Date Time <b>".date("jS F Y h:i:s A")."</b> . <br><br> Thanks & regards, <br>
                    <i>Learning & Development Team</i></p>";
                    */

                    $messagehtml    = "<p> Hi ".$users->firstname." ".$users->lastname.", <br><br>
                    There is an activity in the LMS for your review as it has been <b>".$action."</b> by user <b>".$modified_by->firstname."  ".$modified_by->lastname." (".$modified_by->employee_code.") </b> <br>  
                    <table style='width:100%; text-align:center;' border='1'>
                    <tr>
                    <th>Course Name</th>
                    <th>Category</th>
                    <th>Activity Type</th>
                    <th>Activity Name</th>
                    <th>Date Time</th>
                    <th>IP Address</th>
                    </tr>
                    <tr>
                    <td>".$course_name."</td>
                    <td>".$category."</td>
                    <td>".$mdl_type."</td>
                    <td>".$module_name."</td>
                    <td>".date("jS F Y h:i:s A")."</td>
                    <td>".get_client_ip()."</td>
                    </tr>
                    </table>
                    <br><br> Thanks & regards, <br>
                    <i>Learning & Development Team</i></p>";

                    $subject     = "User activity tracking notifications";
                     
                    $message = new stdClass();
                    $message->html = $messagehtml;
                    $message->text = "Congrats";
                    $message->subject = $subject;
                    $message->from_email = $modified_by->email;
                    $message->from_name  = $modified_by->firstname;
                    $message->to = array(array("email" => $users->email));
                    //$message->to = array(array("email" => 'sunitineo@gmail.com'));
                    $message->track_opens = true;
                    $response = $mandrill->messages->send($message);
                    
                    $rec_insert  = new stdClass();
                    $rec_insert->userid_notified            = $users->id;
                    $rec_insert->action_userid              = $modified_by->id;
                    $rec_insert->is_email_sent              = empty($response)?0:1;
                    $rec_insert->action_userid_ip_address   = get_client_ip();
                    $rec_insert->cust_config_id             = 2;
                    $rec_insert->course_id                  = $get_course_details->id;

                    $sql = "INSERT INTO `mdl_custom_configurations_logs` (`userid_notified`, `action_userid`, `action_userid_ip_address`, `is_email_sent`, `cust_config_id`, `course_id`) VALUES ('$rec_insert->userid_notified', '$rec_insert->action_userid', '$rec_insert->action_userid_ip_address', '$rec_insert->is_email_sent', '$rec_insert->cust_config_id', '$rec_insert->course_id')";
                    $DB->execute($sql);

                    //$DB->insert_record('custom_configurations_logs', $rec_insert, true);
                }
            }

            $message = "sent successfully!!!";
            $status  = 1;

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
}else if($wsfunction == "user_activity_notifications_del"){
    $delete_m    = $_POST['cm'];
    $user_id     = $_POST['user_id'];
    $returndata  = array();

    if($delete_m != '')
    {
        try {

            if(!empty($delete_m))
            {
                $module_name = '';
                $qry    =  "SELECT c.id,m.name ,c.fullname,substring_index(substring_index(substring_index(cc.name, '<span lang=\"en\" class=\"multilang\">', -1),'<span lang=\"ar\"', 1),'</span>',1) as category , cm.instance FROM `mdl_course_modules` as cm join mdl_modules as m on m.id = cm.module join `mdl_course` as c on c.id = cm.course join mdl_course_categories as cc on cc.id = c.category WHERE cm.id = '$delete_m'";
                $get_mdl_type   = $DB->get_record_sql($qry); //print_r($get_mdl_type);
                $mdl_type       = $get_mdl_type->name;
                $course_name    = $get_mdl_type->fullname;
                $category       = $get_mdl_type->category;
                $action         = "deleted";

                $qry2           =  "SELECT name FROM mdl_".$mdl_type." where id = '$get_mdl_type->instance'";
                //echo $qry2; exit();
                $get_module     = $DB->get_record_sql($qry2);
                $module_name    = $get_module->name;
                $qry1           =  " SELECT * FROM `mdl_user` WHERE id = '$user_id'";
                $modified_by    = $DB->get_record_sql($qry1);

                $sql        = "SELECT * FROM `mdl_config` WHERE `name` = 'siteadmins'";
                $get_admin  = $DB->get_record_sql($sql);
                $arr        = $get_admin->value;
                $ans        = explode(',',$arr);

                foreach ($ans as $key => $val) {
                    if($modified_by->id != $val)
                    {

                        $sql1    = "SELECT u.* FROM `mdl_user` as u where u.id = '$val'";
                        $users   = $DB->get_record_sql($sql1);

                        /*
                        $messagehtml    = "<p> Dear Admin, <br><br>
                        The activity  <b>".$mdl_type." ( ".$module_name." ) </b> from <b>".$category."</b> category and <b>".$course_name."</b> course has been ".$action." by <b> ".$modified_by->firstname."  ".$modified_by->lastname." </b> on Date Time <b>".date("jS F Y h:i:s A")."</b> . <br><br> Thanks & regards, <br>
                        <i>Learning & Development Team</i></p>";
                        */
                        $messagehtml    = "<p> Hi ".$users->firstname." ".$users->lastname.", <br><br>
                        There is an activity in the LMS for your review as it has been <b>".$action."</b> by user <b>".$modified_by->firstname."  ".$modified_by->lastname." (".$modified_by->employee_code.") </b> <br>  
                        <table style='width:100%; text-align:center;' border='1'>
                        <tr>
                        <th>Course Name</th>
                        <th>Category</th>
                        <th>Activity Type</th>
                        <th>Activity Name</th>
                        <th>Date Time</th>
                        <th>IP Address</th>
                        </tr>
                        <tr>
                        <td>".$course_name."</td>
                        <td>".$category."</td>
                        <td>".$mdl_type."</td>
                        <td>".$module_name."</td>
                        <td>".date("jS F Y h:i:s A")."</td>
                        <td>".get_client_ip()."</td>
                        </tr>
                        </table>
                        <br><br> Thanks & regards, <br>
                        <i>Learning & Development Team</i></p>";
                    
                        $subject     = "User activity tracking notifications";
                         
                        $message = new stdClass();
                        $message->html = $messagehtml;
                        $message->text = "Congrats";
                        $message->subject = $subject;
                        $message->from_email = $modified_by->email;
                        $message->from_name  = $modified_by->firstname;
                        $message->to = array(array("email" => $users->email));
                        //$message->to = array(array("email" => 'sunitineo@gmail.com'));
                        $message->track_opens = true;
                        $response = $mandrill->messages->send($message);
                        // print_r($response);
                        // exit();

                        $rec_insert  = new stdClass();
                        $rec_insert->userid_notified            = $users->id;
                        $rec_insert->action_userid              = $modified_by->id;
                        $rec_insert->is_email_sent              = empty($response)?0:1;
                        $rec_insert->action_userid_ip_address   = get_client_ip();
                        $rec_insert->cust_config_id             = 3;
                        $rec_insert->course_id                  = $get_mdl_type->id;
                        //$DB->insert_record('custom_configurations_logs', $rec_insert, true);

                        $ins_sql = "INSERT INTO `mdl_custom_configurations_logs` (`userid_notified`, `action_userid`, `action_userid_ip_address`, `is_email_sent`, `cust_config_id`, `course_id`) VALUES ('$rec_insert->userid_notified', '$rec_insert->action_userid', '$rec_insert->action_userid_ip_address', '$rec_insert->is_email_sent', '$rec_insert->cust_config_id', '$rec_insert->course_id')";
                        $DB->execute($ins_sql);
                    }

                }

                $message = "sent successfully!!!";
                $status  = 1;
            }
            else
            {
                $message = "course module id not found.";
                $status  = 0;
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
}else if($wsfunction == "update_status"){
    $config_id   = $_POST['config_id'];
    $user_id     = $_POST['user_id'];   
    $set_config_val = '';
    $returndata  = array();

    if($config_id != '' && $user_id != '')
    {
        try {

            $get_config     = $DB->get_record_sql("SELECT * FROM `mdl_custom_configurations` WHERE id = ?", array('id' => $config_id));

            if(!empty($get_config))
            {
                if($get_config->is_active == 1)
                {
                    $set_config_val = 0;
                }
                else
                {
                    $set_config_val = 1;
                }

                $DB->execute("UPDATE mdl_custom_configurations SET is_active = ? , updated_by = ?, updated_at = ? WHERE id = ?",array('is_active' => $set_config_val, 'updated_by' => $user_id, 'updated_at' => date('Y-m-d H:i:s'), 'id' => $config_id ));
                
                $message = "Updated successfully !";
                $status  = 1;
            }
            else
            {
                $message = "No record found !";
                $status  = 0;
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
    $returndata['set_config_val'] = $set_config_val;

    echo $data = json_encode($returndata);
}else if($wsfunction == "user_activity_tracking"){
    $mod_id      = $_POST['mod_id'];
    $user_id     = $_POST['user_id'];
    $returndata  = array();

    if($mod_id != '' && $user_id != '')
    {
        try {

            $get_session = $DB->get_record_sql("SELECT * FROM `mdl_sessions` where sid = ? and userid = ? ",array('session_id' => session_id(), 'userid' => $user_id));
            $get_cm      = $DB->get_record_sql(" SELECT * FROM `mdl_course_modules` WHERE `id` = ? ", array('id' => $mod_id));
            //print_r($get_cm); exit();
            if($get_cm)
            {
                $course_id    = $get_cm->course;
                $module_id    = $get_cm->module;
                
                $DB->execute("INSERT INTO `mdl_course_module_sess_track` (`course_id`, `module_id`, `user_id`,`session_id`,`access_start_time`) VALUES (?, ?,?, ?,?)",array('course_id' => $course_id, 'module_id' => $module_id, 'user_id' => $user_id , 'session_id' => isset($get_session) ? $get_session->id : 0 , 'access_start_time' => date('Y-m-d H:i:s')));
            }

            $message = "sent successfully!!!";
            $status  = 1;

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
}else if($wsfunction == "update_user_activity_tracking"){
    $course_id   = $_POST['course_id'];
    $user_id     = $_POST['user_id'];
    $returndata  = array();

    if($course_id != '' && $user_id != '')
    {
        try {

            // fetch last activity record w.r.t course, userid & for the same day and update session end time. If record not found than create a record w.r.t course where module id will be zero and this record will save enrty for course view & on page refresh/load it will update end time like above condition.

            $cur_date   = date('Y-m-d');
            $get_cm     = $DB->get_records_sql(" SELECT * FROM `mdl_course_module_sess_track` WHERE access_end_time is null and date(access_start_time) = '$cur_date' and `course_id` = ? and user_id = ? ", array( 'course_id' => $course_id,'user_id' => $user_id));
            //print_r($get_cm); exit();

            if($get_cm)
            {
                foreach ($get_cm as $key => $value) {
                    //update last time
                    $DB->execute("UPDATE mdl_course_module_sess_track SET access_end_time = ? WHERE id = ?",array('access_end_time' => date('Y-m-d H:i:s'), 'id' => $value->id ));
                }
            }
            else
            {
                $module_id   = 0;
                $get_record  = $DB->get_records_sql(" SELECT * FROM `mdl_course_module_sess_track` WHERE access_end_time is null and date(access_start_time) = '$cur_date' and `course_id` = ? and user_id = ? and module_id = ? order by id desc", array('course_id' => $course_id , 'user_id' => $user_id , 'module_id' => $module_id));

                if($get_record)
                {
                    foreach ($get_record as $key1 => $value1) {
                        //update last time
                        $DB->execute("UPDATE mdl_course_module_sess_track SET access_end_time = ? WHERE id = ?",array('access_end_time' => date('Y-m-d H:i:s'), 'id' => $value1->id ));
                    }
                
                }
                else
                {
                    $get_session = $DB->get_record_sql("SELECT * FROM `mdl_sessions` where sid = ? and userid = ? ",array('session_id' => session_id(), 'userid' => $user_id));

                    $DB->execute("INSERT INTO `mdl_course_module_sess_track` (`course_id`, `module_id`, `user_id`,`session_id`) VALUES (?, ?, ?, ?)",array('course_id' => $course_id, 'module_id' => $module_id, 'user_id' => $user_id , 'session_id' => $get_session->id ));  
                }
                 
            }

            $message = "sent successfully!!!";
            $status  = 1;

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