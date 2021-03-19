<?php

$base = __DIR__ . '/../../../../';
define('CLI_SCRIPT', true);
require_once $base.'config.php';

//require_once '../config.php';

define('MAX_BULK_USERS', 2000);
date_default_timezone_set("Asia/Kolkata");

error_reporting(E_ALL | E_STRICT); 
ini_set('display_errors', '1'); 

ini_set('max_execution_time', '0');

$CFG->debug = (E_ALL | E_STRICT); 
$CFG->debugdisplay = 1;
$CFG->debugdeveloper= 1;

$version      = "A:V1";
$total_count  = 0;
$insert_count = 0;
$delete_count = 0;
$update_count = 0;

$total_data  = "";
$insert_data = "";
$delete_data = "";
$update_data = "";

$get_rule_set = $DB->get_records_sql("SELECT * FROM `mdl_dynamic_cohort_cust_rule_set` where is_active = ? and is_deleted = ? and version = ?", array('is_active' => 1, 'is_deleted' => 0, 'version' => $version));


foreach ($get_rule_set as $key => $value) {
	// With defined rule set
	$all_filtered_users = array();
	$params   			= unserialize($value->sqlparam);

	// Actual result should be -
	$set_query = $value->sqlselect.$value->sqlwhere.$value->sql_group;
	$response  = $DB->get_records_sql($set_query,$params);

	// Delete deactivated users from existing cohort members -
	$DB->execute("DELETE FROM mdl_cohort_members where cohortid = ? and userid in ( SELECT userid FROM (SELECT cm.userid FROM mdl_cohort_members as cm join mdl_user as u on u.id = cm.userid where cm.cohortid = ? and u.deleted = 1) as c)", array($value->cohort_id, $value->cohort_id));


	// Delete ruleset whose cohort doesn't exist -
	$get_cohort_q = $DB->get_record_sql("SELECT * FROM `mdl_cohort` where id = $value->cohort_id");

	if(empty($get_cohort_q))
	{
		// delete cohort member and ruleset.
		$DB->execute("DELETE FROM mdl_cohort_members where cohortid = ?", array($value->cohort_id));
		$DB->execute("DELETE FROM mdl_dynamic_cohort_cust_rule_set where cohort_id = ?", array($value->cohort_id));
		break;
	}


	// Currently present cohort memebers -
	$query_cohort_mem = $DB->get_records_sql("SELECT cm.userid,u.deleted FROM `mdl_cohort` as c join mdl_cohort_members as cm on cm.cohortid = c.id join mdl_user as u on u.id = cm.userid where c.id = $value->cohort_id");

	$total_data .= "Cohort ID - ".$value->cohort_id;
	$total_data .= "<br>";

	// echo $total_data;

	if(!empty($query_cohort_mem))
	{
		// echo "<br> resp count - ";print_r(count($response));
		// echo "<br> get cohort count - ";print_r(count($query_cohort_mem));

		// check if count is differ
		if(count($response) != count($query_cohort_mem))
		{
			// get all the cohort members in array
			foreach ($query_cohort_mem as $gkey => $gvalue) {
				$all_filtered_users[] = $gvalue->userid;
			}

			// print_r($all_filtered_users);
			// echo "res -".$subkey1;

			foreach ($response as $subkey1 => $subvalue1) 
			{
				// if response user not present in array then add it
				if(!in_array($subkey1, $all_filtered_users))
				{  
					$rec_insert= new stdClass();
			        $rec_insert->cohortid  = $value->cohort_id;
			        $rec_insert->userid    = $subkey1;
			        $rec_insert->timeadded = time();
			        $DB->insert_record('cohort_members', $rec_insert, true);
			        $insert_count++;

			        $insert_data .= "Cohort ID - ".$value->cohort_id;
			        $insert_data .= "User ID - ".$subkey1;
					$insert_data .= "<br>";
				}
			}
		}
	}
	else
	{
		foreach ($response as $res_key => $res_value) 
		{
			$rec_insert= new stdClass();
	        $rec_insert->cohortid  = $value->cohort_id;
	        $rec_insert->userid    = $res_key;
	        $rec_insert->timeadded = time();
	        $DB->insert_record('cohort_members', $rec_insert, true);
	        $insert_count++;

	        $insert_data .= "Cohort ID - ".$value->cohort_id;
	        $insert_data .= "User ID - ".$res_key;
			$insert_data .= "<br>";
		}
	}

	//$arr = array_unique($all_filtered_users);
	$total_count++;
	// $DB->execute("update mdl_dynamic_cohort_cust_rule_set set updated_at = ? where id = ?",array('updated_at' => date('Y-m-d H:i:s'), 'id' => $value->id));

	$get_cohort_count = $DB->get_record_sql("SELECT count(*) as total FROM `mdl_cohort_members` WHERE `cohortid` = $value->cohort_id ORDER BY `cohortid` ASC");

	$DB->execute("update mdl_dynamic_cohort_cust_rule_set set updated_at = ?, total_users = ? where id = ?",array('updated_at' => date('Y-m-d H:i:s'), 'total_users' =>!empty($get_cohort_count)?$get_cohort_count->total:0, 'id' => $value->id));

}

echo "executed properly";
//echo $total_data;

$rec_insert1 			    = new stdClass();
$rec_insert1->name  	    = "Dynamic Cohort Version 3 attribute set";
$rec_insert1->execution_datetime= date("Y-m-d H:i:s");
$rec_insert1->total_count   = $total_count;
$rec_insert1->total_data    = $total_data;
$rec_insert1->insert_count  = $insert_count;
$rec_insert1->insert_data   = $insert_data;
$rec_insert1->delete_count  = $delete_count;
$rec_insert1->delete_data   = $delete_data;
$rec_insert1->update_count  = $update_count;
$rec_insert1->update_data   = $update_data;
//echo "<pre>"; print_r($rec_insert1);
$DB->insert_record('custom_cron_logs', $rec_insert1, true);

// $cron_sql = "INSERT INTO mdl_custom_cron_logs(name, execution_datetime, total_count, total_data, insert_count, insert_data, delete_count, delete_data, update_count, update_data) VALUES ('".$rec_insert1->name."','".$rec_insert1->execution_datetime."','".$rec_insert1->total_count."',\"".$rec_insert1->total_data."\",'".$rec_insert1->insert_count."',\"".$rec_insert1->insert_data."\",'".$rec_insert1->delete_count."',\"".$rec_insert1->delete_data."\",'".$rec_insert1->update_count."',\"".$rec_insert1->update_data."\")";
// $DB->execute($cron_sql,true);