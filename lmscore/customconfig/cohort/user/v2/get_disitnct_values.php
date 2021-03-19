<?php

//get_disitnct_values.php

require_once('../../../../config.php');
require_login(); // We need login

global $DB;

$column 	  = $_POST['tbl_columns'];
$data   	  = array();
$sql 		  = "SELECT distinct ".$column." FROM mdl_user where deleted = 0 and id <> 1";
//echo $sql; exit();

$get_response = $DB->get_records_sql($sql);

foreach ($get_response as $key => $value) {
	$data[] = $value->$column;
}
echo json_encode($data);
?>