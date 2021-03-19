<?php

require_once '../config.php';

$count = 0;
$records = [];
// $query_fetch_users = $DB->get_records_sql("SELECT DISTINCT u.id,ub.managersemail FROM `mdl_user` as u JOIN `mdl_user_bulk` as ub on u.id = ub.user_id JOIN `mdl_user` as au ON ub.managersemail = au.email"); 

$query_fetch_users = $DB->get_records_sql("SELECT DISTINCT u.id,ub.managersemail FROM `mdl_user` as u JOIN `mdl_user_bulk` as ub on u.id = ub.user_id JOIN `mdl_user` as au ON ub.managersemail = au.email where u.id >= '9049' order by id desc"); 

   
if(!empty($query_fetch_users)){ 

  foreach ($query_fetch_users as $key => $value) {
    $cust_record = new stdClass();
    $cust_record->userid      = $value->id;
    $cust_record->fieldid     = 7;
    $cust_record->data        = $value->managersemail;

    array_push($records,$cust_record);
  }
  
  $DB->insert_records('user_info_data',$records);
}
         
?>