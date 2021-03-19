<?php
require_once('../../config.php');
require_login(); // We need login
global $CFG, $USER;
define('STUDENT_ROLE_ID',5);
$CFG->debug         = (E_ALL | E_STRICT); 
 $CFG->debugdisplay  = 1;
 $CFG->debugdeveloper= 1;
//define("UPLOAD_FOLDER",$CFG->dataroot."\\trainingform_uploads\\");
//define("UPLOAD_FOLDER",'./uploads/');
define("UPLOAD_FOLDER","./../../custom_upload/trainingform_files/");

if (isset($_REQUEST['btn_submit']) && $_REQUEST['btn_submit'] == "Submit") {
    $status = 0;
    $message = 0;
    $formtype = $_REQUEST['formtype'];
    switch ($formtype) {
        case "INTERNAL":
            $formtypename = 'Nominate Your Team';
            if (isset($_REQUEST['courseid']) && is_array($_REQUEST['courseid']) && count($_REQUEST['courseid']) > 0) {
                $courseid = implode(",", $_REQUEST['courseid']);
                $carr= $_REQUEST['courseid'];
            } else {
                $courseid = '';
            }
            $start_date = strtotime($_REQUEST['in_start_date']);
            $end_date = strtotime($_REQUEST['in_end_date']);
            if (isset($_REQUEST['in_userid']) && is_array($_REQUEST['in_userid']) && count($_REQUEST['in_userid']) > 0) {
                $userid = implode(",", $_REQUEST['in_userid']);
                $uarr= $_REQUEST['in_userid'];
            } else {
                $userid = '';
            }
            $training_program_name = '';
            $training_duration = '0';
            $training_provider_name = '';
            $is_certification_program = 1;
            $certificate_file = '';

            if($carr != null && $uarr != null && count($carr) >0 && count($uarr)>0){
               // user_enrol_course($uarr,$carr);
                 all_user_course_enrolment($uarr,$carr);
            }

            
            break;
        case "EXTERNAL":
            $formtypename = 'Log External Team';
            $courseid = '';
            $start_date = strtotime($_REQUEST['ex_start_date']);
            $end_date = strtotime($_REQUEST['ex_end_date']);
            if (isset($_REQUEST['ex_userid']) && is_array($_REQUEST['ex_userid']) && count($_REQUEST['ex_userid']) > 0) {
                $userid = implode(",", $_REQUEST['ex_userid']);                
            } else {
                $userid = '';
            }
            $training_program_name = $_REQUEST['training_program_name'];
            $training_duration = $_REQUEST['training_duration'];
            $training_provider_name = $_REQUEST['training_provider_name'];
            $is_certification_program = $_REQUEST['is_certification_program'];
            $certificate_file = $_FILES['certificate_file'];

            break;
    }
    
    $tformobj = new stdClass;
    $tformobj->formtype = $formtype;
    $tformobj->formtypename = $formtype;
    $tformobj->userid = $userid;
    $tformobj->courseid = $courseid;
    $tformobj->start_date = $start_date;
    $tformobj->end_date = $end_date;
    $tformobj->training_program_name = $training_program_name;
    $tformobj->training_duration = $training_duration;
    $tformobj->training_provider_name = $training_provider_name;
    $tformobj->is_certification_program = $is_certification_program;
    //  $tformobj->certificate_file = $certificate_file;
    $tformobj->created_by = $USER->id;
    $tformobj->created_at = time();
    if ($tformobj->id = $DB->insert_record("trainingform", $tformobj)) {
        $status = 0;
        $message = get_string('formsubmitted', 'local_trainingform'); // "Form Submitted Successfully";
    } else {
        $status = 1;
        $message = get_string('formnotsubmitted', 'local_trainingform'); //"Form not Submitted";
    }
    if ($status == 0) {
        $totalfilecount = count($certificate_file['name']);
        //print_r($_FILES);
        //print_r($certificate_file);
        $trainingformid = $tformobj->id;
        $fileids = update_trainingform_files($trainingformid,$certificate_file);
        $userids = $_REQUEST['ex_userid'];
        $fileusers = update_trainingform_user_files($trainingformid,$userids,$fileids);
        /*
        if($totalfilecount>0 && is_array($certificate_file)){
            $certarray =array();
            for($i=0;$i<$totalfilecount;$i++){
                //echo $i;
    
                if (is_array($certificate_file) && $certificate_file['size'][$i] > 0 && $certificate_file['name'][$i] != null) {
                    //
                    $fileTmpPath = $certificate_file['tmp_name'][$i];
                    $fileName = $certificate_file['name'][$i];
                    $fileSize = $certificate_file['size'][$i];
                    $fileType = $certificate_file['type'][$i];
                    $fileNameCmps = explode(".", $fileName);
                    $fileExtension = strtolower(end($fileNameCmps));
                    // directory in which the uploaded file will be moved
                    $uploadFileDir = UPLOAD_FOLDER;
                    $dest_path[$i] = $uploadFileDir . $tformobj->id . '_' . $fileName;
                   
                    if (move_uploaded_file($fileTmpPath, $dest_path[$i])) {
                        $attachmessage = 'File is successfully uploaded.';
                        $certfile = new stdClass;
                        $certfile->trainingformid=$tformobj->id;
                        $certfile->file_name = $fileName;
                        $certfile->file_type = $fileType;
                        $certfile->file_size = $fileSize;
                        $certfile->file_path = $dest_path[$i];
                        $certfile->created_by = $USER->id;
                        $certfile->created_at = time();
                        $certfile->id = $DB->insert_record("trainingform_files", $certfile);
                        $certarray[] =$certfile->id;                        
                    } else {
                        $attachmessage = 'Certificate File Not Uploaded.';
                        $message  = $message."<Br>".$attachmessage;
                    }
                    if(count($certarray)>0){
                        $certificates = implode(",",$certarray);
                         $tformobj->certificate_file = $certificates;
                         $DB->update_record('trainingform', $tformobj);
                    }
                    
                }
            }
        }
        */
        /////////////////////////
        //success msg notification will be sent here....
        $linkurl = new moodle_url('/local/trainingform/trainingform_table.php');
        redirect($linkurl, $message, null, \core\output\notification::NOTIFY_SUCCESS);
    } else {
        //error msg notification will be sent here.... 
        $linkurl = new moodle_url('/local/trainingform/trainingform_table.php');
        redirect($linkurl, $message, null, \core\output\notification::NOTIFY_ERROR);
    }
    echo $attachmessage;
}
else if(isset($_REQUEST['btn_edit_submit']) && $_REQUEST['btn_edit_submit'] == "Submit") {
  //  echo  "in edit here";print_r($_REQUEST);print_r($_FILES);
    $status = 0;
    $message = 0;
    $formtype = $_REQUEST['formtype'];
   
            $formtypename = 'Log External Team';
            $courseid = '';
            $start_date = strtotime($_REQUEST['ex_start_date']);
            $end_date = strtotime($_REQUEST['ex_end_date']);
            if (isset($_REQUEST['ex_userid']) && is_array($_REQUEST['ex_userid']) && count($_REQUEST['ex_userid']) > 0) {
                $userid = implode(",", $_REQUEST['ex_userid']);                
            } else {
                $userid = '';
            }
            $training_program_name = $_REQUEST['training_program_name'];
            $training_duration = $_REQUEST['training_duration'];
            $training_provider_name = $_REQUEST['training_provider_name'];
            $is_certification_program = $_REQUEST['is_certification_program'];
            $certificate_file = $_FILES['doc_file'];
    
    $tformobj = new stdClass;
    $tformobj->id = $_REQUEST['trainingformid'];
    $tformobj->formtype = $formtype;
    $tformobj->formtypename = $formtype;
    $tformobj->userid = $userid;
    $tformobj->courseid = $courseid;
    $tformobj->start_date = $start_date;
    $tformobj->end_date = $end_date;
    $tformobj->training_program_name = $training_program_name;
    $tformobj->training_duration = $training_duration;
    $tformobj->training_provider_name = $training_provider_name;
    $tformobj->is_certification_program = $is_certification_program;
    //  $tformobj->certificate_file = $certificate_file;
    $tformobj->updated_by = $USER->id;
    $tformobj->updated_at = time();
   // print_r($tformobj);die("here");
    if ($DB->update_record("trainingform", $tformobj)) {
        $status = 0;
        $message = get_string('formsubmitted', 'local_trainingform'); // "Form Submitted Successfully";
    } else {
        $status = 1;
        $message = get_string('formnotsubmitted', 'local_trainingform'); //"Form not Submitted";
    }
    if ($status == 0) {
        $totalfilecount = count($certificate_file['name']);
 //       echo $totalfilecount;
        if($tformobj->is_certification_program !='1'){
        $trainingformid = $tformobj->id;
        $fileids = update_trainingform_files($trainingformid,$certificate_file);



        $userids = $_REQUEST['ex_userid'];
        $fileusers = update_trainingform_user_files($trainingformid,$userids,$fileids);
    }
        /////////////////////////
        //success msg notification will be sent here....
        $linkurl = new moodle_url('/local/trainingform/trainingform_table.php');
        redirect($linkurl, $message, null, \core\output\notification::NOTIFY_SUCCESS);
    } else {
        //error msg notification will be sent here.... 
        $linkurl = new moodle_url('/local/trainingform/trainingform_table.php');
        redirect($linkurl, $message, null, \core\output\notification::NOTIFY_ERROR);
    }
    echo $attachmessage;
}

 function send_mail_to_admin($userobj,$coursename){
    global $USER;
    //print_r($userobj); //   print_r($coursename);
    $tablecontent ='';
    if($userobj != null && $coursename != null){
        
        foreach($userobj as $u){
            foreach($coursename as $c){
                $tablecontent.= "<tr><td>".$u->firstname.' '.$u->lastname.'('.$u->username.')]</td><td>'.$c[$u->id]."</td></tr>";
            }
        }
    //echo "<table>".$tablecontent."</table>";die;
        $srs = $DB->get_record_sql("select * from mdl_config where name='siteadmins'");
        if($srs !=null){
            if($srs->value != ""){
                $siteadminids = $srs->value;
                $rs = $DB->get_record_sql("select GROUP_CONCAT(email) as email from {user} where id in(".$srs->value.")");
                if($rs !=null){
                    $siteadminemails = $rs->email;    
                }
            }
        }
        
     $from_name      = 'noreply';
     $from_address   = 'mobile@zinghr.com';
     if($siteadminemails != ""){
        $to = $siteadminemails;
     }
     else{
         $to = "awaish.khan@redtag.ae,shameer.patka@redtag.ae,awaish.khan@bma.ae";
        //$to = "kajaltailor@yahoo.com"; 
    }
   //  $to = "kajaltailor@yahoo.com"; 
    $subject = "Nominate Your Team Notification from ".$USER->firstname." ".$USER->lastname." (".$USER->username.")";
    $message = "
    <html>
    <head>
    <title>Nominate Your Team Notification</title>
    </head>
    <body>
    <p>This is to inform you that ".$USER->firstname." ".$USER->lastname." (".$USER->username.") has made the following enrollments.</p>
    <table>
    <tr>
    <th>Employee</th>
    <th>Course</th>
    </tr>
   ".$tablecontent."
    </table>
    <p>Thanks and Regards,<BR>
    ILearn</p>

    </body>
    </html>
    ";

    // Always set content-type when sending HTML email
    $headers = "MIME-Version: 1.0" . "\r\n";
    $headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";

    // More headers
    $headers .= 'ILearn : <noreply@zinghr.com>' . "\r\n";
    $headers .= 'Cc: aditya.rao@zinghr.com, kajaltailor@yahoo.com' . "\r\n";
    mail($to,$subject,$message,$headers);
    }
 }
function all_user_course_enrolment($userids,$courseids){
    global $DB,$USER;
    //user_enrol_course($uarr,$carr);
    if($userids != null && $courseids != null && is_array($userids) && is_array($courseids)){
        $useremails = array();
        $coursename = array();
        foreach($userids as $u){
            //user ids loop
            foreach($courseids as $c){
                $course = $DB->get_record('course', array('id' => $c));
                $userrec = $DB->get_record("user",array('id' => $u));
                $userid[] = user_enrol_course($u,$course);
                if($userrec->email != null){
                    $userrs[$u] = $userrec;
                    $coursename[$c][$u] = $course->fullname;
                }
            }
        }
        send_mail_to_admin($userrs,$coursename);
    }  
}
function user_enrol_course($userid,$course)
{ 
    global $DB,$USER;  
 // echo $userid."=====";
    if($userid !=0 && $userid!=null && $userid !=""){
        $from       = $DB->get_record('user', array('id'=> $USER->id));
        $sql        = "SELECT u.* from {user} as u  where u.id = ? and u.deleted = ?";
        $user       = $DB->get_record_sql($sql, array($userid,0), $strictness=IGNORE_MISSING);
       if($user != null){
            // student Course enrollment
            $enrol      = $DB->get_record_sql('SELECT id,enrol FROM `mdl_enrol` WHERE `courseid` = ? and status = 0 ORDER BY id asc limit 0,1', array('courseid' => $course->id)); //print_r($enrol); //exit();
            $course_status = 0;

            if(!empty($enrol))
            {
                $uenrol = $DB->get_record_sql('SELECT * FROM `mdl_user_enrolments` where enrolid = ? and userid = ?', array('enrolid' => $enrol->id , 'userid' => $user->id));
                
                if(empty($uenrol))
                {
                    // course enrollment
                    $rec = new stdClass(); 
                    $rec->status            = $course_status; 
                    $rec->enrolid           = $enrol->id;
                    $rec->userid            = $user->id;
                    $rec->timestart         = time();
                    $rec->timeend           = 0;
                    $rec->modifierid        = $USER->id;
                    $rec->timecreated       = time();
                    $rec->timemodified      = time();
                    $DB->insert_record('user_enrolments', $rec);
                }
            }
            //die("herer".$userid);

            //STUDENT_ROLE_ID role assignment at course level
            $context = isset($context)?$context:context_system::instance(); //print_r($context->id); print_r($context); exit();

            $r_assign = $DB->get_record_sql('SELECT * FROM `mdl_role_assignments` WHERE `contextid` = ? and userid = ? and roleid = ? ORDER BY id asc limit 0,1', array('contextid' => $context->id, 'userid' => $user->id, 'roleid' => STUDENT_ROLE_ID));
            // print_r($context); print_r($user->id);
            // print_r($r_assign); exit();

            if(empty($r_assign))
            {
                $ins_rec = new stdClass(); 
                $ins_rec->roleid      = STUDENT_ROLE_ID;
                $ins_rec->contextid   = $context->id;
                $ins_rec->userid      = $user->id;
                $ins_rec->modifierid  = $USER->id;
                $ins_rec->timecreated = time();
                $ins_rec->component   = '';
                $ins_rec->itemid      = 0;
                $ins_rec->sortorder   = 0;
                //print_r($ins_rec); exit();
                $DB->insert_record('role_assignments', $ins_rec);
            }
            
        }
    }
  return $userid;
}

function update_trainingform_files($trainingformid,$certificate_file){
    global $DB,$USER;
    $totalfilecount = count($certificate_file['name']);
    $certarray = array();
    //print_r($_FILES);    //print_r($certificate_file);
    if($totalfilecount > 0 && is_array($certificate_file)){
        $certarray =array();
        for($i=0;$i<$totalfilecount;$i++){
            //echo $i;
            if (is_array($certificate_file) && $certificate_file['size'][$i] > 0 && $certificate_file['name'][$i] != null) {
                $fileTmpPath = $certificate_file['tmp_name'][$i];
                $fileName = $certificate_file['name'][$i];
                $fileSize = $certificate_file['size'][$i];
                $fileType = $certificate_file['type'][$i];
                $fileNameCmps = explode(".", $fileName);
                $fileExtension = strtolower(end($fileNameCmps));
                // directory in which the uploaded file will be moved
              // $uploadFileDir = "./uploads/";
                $uploadFileDir = UPLOAD_FOLDER;
                
                $dest_path[$i] = $uploadFileDir . $trainingformid . '_' . $fileName;
               
                if (move_uploaded_file($fileTmpPath, $dest_path[$i])) {
                    $attachmessage = 'File is successfully uploaded.';
                    $certfile = new stdClass;
                    $certfile->trainingformid=$trainingformid;
                    $certfile->file_name = $fileName;
                    $certfile->file_type = $fileType;
                    $certfile->file_size = $fileSize;
                    $certfile->file_path = $dest_path[$i];
                    $certfile->created_by = $USER->id;
                    $certfile->created_at = time();
                    $certfile->id = $DB->insert_record("trainingform_files", $certfile);
                    $certarray[] =$certfile->id;                        
                } else {
                    $attachmessage = 'Certificate File Not Uploaded.';
                 //   $message  = $message."<Br>".$attachmessage;
                }
               
                
            }
            
        }
       // return $certarray;
    }
    //if(count($certarray)>0){
        $certarr = array();
        $certres = $DB->get_records("trainingform_files",array("trainingformid"=>$trainingformid,"deleted"=>0));
        if($certres != null){
            foreach($certres as $c){
                $certarr[]=$c->id;
            }
            $certificates = implode(",",$certarr);
        }
        else{
            $certificates = implode(",",$certarray);
            $certarr = $certarray;
        }
      
            $tformobj = new stdclass;
            $tformobj->id = $trainingformid;
            $tformobj->certificate_file = $certificates;
            $DB->update_record('trainingform', $tformobj);
    //}
    return $certarr;
}

function update_trainingform_user_files($trainingformid,$userids,$fileids){
    global $DB,$USER;
    $usertformarr = array();
   


    if($userids !=null && is_array($userids)){
        foreach($userids as $u){
            if($fileids != null && is_array($fileids)){
                foreach($fileids as $f){
                    $rs = $DB->get_record("trainingform_user_files",array("trainingformid"=>$trainingformid,"userid"=>$u,"fileid"=>$f));
                    if($rs != null){
                        //update
                        $usertform = new stdclass;
                        $usertform->id = $rs->id;
                        $usertform->trainingformid = $trainingformid;
                        $usertform->userid = $u;
                        $usertform->fileid = $f;
                        $usertform->deleted = 0;
                        $usertform->updated_at = time();
                        $usertform->updated_by = $USER->id;
                        $DB->update_record("trainingform_user_files",$usertform);
                        $usertformarr[] = $usertform->id;
                    }
                    else{//insert
                        $usertform = new stdclass;
                        $usertform->trainingformid = $trainingformid;
                        $usertform->userid = $u;
                        $usertform->fileid = $f;
                        $usertform->deleted = 0;
                        $usertform->created_at = time();
                        $usertform->created_by = $USER->id;
                        $usertform->id = $DB->insert_record("trainingform_user_files",$usertform);
                        $usertformarr[] = $usertform->id;
                    }
                }
            }
            else{

                 $rs = $DB->get_record("trainingform_user_files",array("trainingformid"=>$trainingformid,"userid"=>$u,"fileid"=>0));
                    if($rs != null){
                        //update
                        $usertform = new stdclass;
                        $usertform->id = $rs->id;
                        $usertform->trainingformid = $trainingformid;
                        $usertform->userid = $u;
                        $usertform->fileid = 0;
                        $usertform->deleted = 0;
                        $usertform->updated_at = time();
                        $usertform->updated_by = $USER->id;
                        $DB->update_record("trainingform_user_files",$usertform);
                        $usertformarr[] = $usertform->id;
                    }
                    else{//insert
                        $usertform = new stdclass;
                        $usertform->trainingformid = $trainingformid;
                        $usertform->userid = $u;
                        $usertform->fileid = 0;
                        $usertform->deleted = 0;
                        $usertform->created_at = time();
                        $usertform->created_by = $USER->id;
                        $usertform->id = $DB->insert_record("trainingform_user_files",$usertform);
                        $usertformarr[] = $usertform->id;
                    }
            }
            if($usertformarr != null && count($usertformarr)>0){
                $sql= "update {trainingform_user_files} set deleted =1,updated_at='".time()."',updated_by=".$USER->id." where trainingformid =".$trainingformid."
                and id not in(".implode(",",$usertformarr).")";
                $DB->execute($sql);
            }
        }
        return $usertformarr;
    }
    
}