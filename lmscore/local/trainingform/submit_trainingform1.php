<?php
require_once('../../config.php');
require_login(); // We need login
global $CFG, $USER;
define('STUDENT_ROLE_ID',5);
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
        if (is_array($certificate_file) && $certificate_file['size'] > 0 && $certificate_file['name'] != null) {
            //
            $fileTmpPath = $certificate_file['tmp_name'];
            $fileName = $certificate_file['name'];
            $fileSize = $certificate_file['size'];
            $fileType = $certificate_file['type'];
            $fileNameCmps = explode(".", $fileName);
            $fileExtension = strtolower(end($fileNameCmps));
            // directory in which the uploaded file will be moved
            $uploadFileDir = "./uploads/";
            $dest_path = $uploadFileDir . $tformobj->id . '_' . $fileName;

            if (move_uploaded_file($fileTmpPath, $dest_path)) {
                $attachmessage = 'File is successfully uploaded.';
                $tformobj->certificate_file = $dest_path;
                $DB->update_record('trainingform', $tformobj);
            } else {
                $attachmessage = 'Certificate File Not Uploaded.';
                $message  = $message."<Br>".$attachmessage;
            }
        }
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

function all_user_course_enrolment($userids,$courseids){
    global $DB,$USER;
    //user_enrol_course($uarr,$carr);
    if($userids != null && $courseids != null && is_array($userids) && is_array($courseids)){
        foreach($userids as $u){
            //user ids loop
            foreach($courseids as $c){
                $course = $DB->get_record('course', array('id' => $c));
                $userid[] = user_enrol_course($u,$course);
            }
        }
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