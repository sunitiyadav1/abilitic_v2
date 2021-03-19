<?php

require_once '../config.php';

$count = 0;
$records = [];
$query_fetch_users = $DB->get_records_sql('SELECT u.id,u.lastname,ub.employee_code FROM `mdl_user` as u join mdl_user_bulk as ub on u.id = ub.user_id'); 
//print_r($query_fetch_users); exit();

if(!empty($query_fetch_users)){ 

  foreach ($query_fetch_users as $key => $value) {
     $records  = new stdClass();
     $records->id       = $value->id; 
     $records->lastname = $value->lastname.' '.$value->employee_code;
     //print_r($records); exit();
     $DB->update_record('user',$records);
  }
  
}
   
?>