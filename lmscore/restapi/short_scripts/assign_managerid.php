<?php

require_once '../config.php';

$count = 0;
$records = [];
$query_fetch_users = $DB->get_records_sql("SELECT id,reporting_manager_code from  `mdl_user_bulk` where user_id >= '9049' "); 

//echo "<pre>"; print_r($query_fetch_users); exit();

if(!empty($query_fetch_users)){ 

  foreach ($query_fetch_users as $key => $value) {

  	$query_fetch = $DB->get_record_sql("SELECT au.id as managerid,au.email as manageremail FROM `mdl_user_bulk` as ub JOIN `mdl_user` as au ON ub.user_id = au.id where ub.employee_code = '$value->reporting_manager_code' ");

    // echo "<pre>";
    // print_r($query_fetch);
    // exit();

    $cust_record = new stdClass();
    $cust_record->id  = $value->id;
    $cust_record->managersemail  = $query_fetch->manageremail;
    $cust_record->manager_id     = $query_fetch->managerid;

    // array_push($records,$cust_record);
    $DB->update_record('user_bulk',$cust_record);
  }
  
  // $DB->update_records('user_bulk',$records);
}

?>