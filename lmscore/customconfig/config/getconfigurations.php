<?php

require_once('../../config.php');
require_login(); // We need login

global $DB;

$data = array();
$get_configurations = $DB->get_records('custom_configurations', null, $sort='', $fields='*', $limitfrom=0, $limitnum=0);
foreach ($get_configurations as $key => $value) {
	$data1 = array();
	$data1 [] = $value->id;
	$data1 [] = $value->name;
	$data1 [] = $value->defination;
	$data1 [] = $value->updated_at;
	$data1 [] = $value->is_active;
	

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

	

	$data['data'][] = $data1;
}
echo json_encode($data);
?>