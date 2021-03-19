<?php

require_once '../config.php';

$count = 0;
$records = [];
$query_fetch_users = $DB->get_records_sql("SELECT DISTINCT aub.id, au.id as mangrid,aub.managersemail FROM `mdl_user_bulk` as ub join mdl_user_bulk as aub on ub.reporting_manager_code = aub.employee_code JOIN `mdl_user` as au ON aub.user_id = au.id"); 
   
if(!empty($query_fetch_users)){ 

  foreach ($query_fetch_users as $key => $value) {
    $cust_record = new stdClass();
    $cust_record->id  = $value->id;
    $cust_record->managersemail  = $value->managersemail;
    $cust_record->manager_id     = $value->mangrid;

    // array_push($records,$cust_record);
    $DB->update_record('user_bulk',$cust_record);
  }
  
  // $DB->update_records('user_bulk',$records);
}
         
?>
