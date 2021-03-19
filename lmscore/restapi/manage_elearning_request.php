<?php
/* 
  @author: Suniti Yadav 
  description : For handling mamager's course approval, rejection call on email.
*/
require_once('../config.php');
require_once($CFG->dirroot.'/lib/enrollib.php');
require_once($CFG->dirroot.'/enrol/apply/lib.php');
require_once($CFG->dirroot.'/enrol/apply/manage_table.php');
require_once($CFG->dirroot.'/enrol/apply/renderer.php');

$userenrolments  =  array($_REQUEST['userenrolid']);
$formaction      =  $_REQUEST['action'];

if ($formaction != null && $userenrolments != null) {
    
    $enrolapply = enrol_get_plugin('apply');
    
    if ($formaction == 'confirm') {
        $get_result = $enrolapply->confirm_enrolment($userenrolments); 
    }
    else if ($formaction == 'wait') {
        $get_result = $enrolapply->wait_enrolment($userenrolments);
    }
    else if ($formaction == 'cancel') {
        $get_result = $enrolapply->cancel_enrolment($userenrolments);
    }

    header('Location: https://portal.zinghr.com');
}
