<?php

require_once('../../../../config.php');
require_login(); // We need login

global $DB;

$data = array();
$get_rule_set = $DB->get_records_sql("SELECT dc.*,c.name FROM `mdl_dynamic_cohort_cust_rule_set` as dc
join mdl_cohort as c on c.id = dc.cohort_id where dc.is_deleted = 0");

foreach ($get_rule_set as $key => $value) {
	$data1 = array();
	$data1 [] = $value->id;
	// $data1 [] = $value->name;
	$data1 [] = $value->rule_name;
	$data1 [] = $value->total_users;

	/*
	if($value->is_active == 1)
	{
		$data1 [] = "Yes";
	}
	else
	{
		$data1 [] = "No";
	}
	*/

	$data1 [] = $value->created_at;
	$data1 [] = $value->updated_at;
	$data1 [] = $value->is_active;
	$data1 [] = $value->is_default;
	

	$data['data'][] = $data1;
}
echo json_encode($data);
?>