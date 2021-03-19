<?php

require_once '../config.php';

$count = 0;
$records = [];
$query_fetch_users = $DB->get_records_sql('SELECT id FROM mdl_user'); 
//print_r($query_fetch_users); exit();

if(!empty($query_fetch_users)){ 

  foreach ($query_fetch_users as $key => $value) {
     $count++;
     
     $enrol_record  = new stdClass();
     $enrol_record->status       = 0; 
     $enrol_record->enrolid      = 1;
     $enrol_record->userid       = $value->id;
     $enrol_record->timestart    = time();
     $enrol_record->timeend      = 0;
     $enrol_record->modifierid   = 2;
     $enrol_record->timecreated  = time();
     $enrol_record->timemodified = time();

     array_push($records,$enrol_record);
  }

  //print_r($records); exit();
  $DB->insert_records('user_enrolments',$records);
}
   
?>