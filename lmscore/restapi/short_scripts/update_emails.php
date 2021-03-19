<?php

require_once '../config.php';
$count = 0 ;
$get_records = $DB->get_records_sql('SELECT * FROM `mdl_user` where `email` = "" ');
foreach ($get_records as $key => $value) {
	$email = "support@bma.ae_".$value->username;
	$sql    	= "UPDATE mdl_user SET email = '$email' WHERE id='$value->id'";
	$result = $DB->execute($sql);
	$count++;
}

  print_r($count);
?>