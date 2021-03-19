<?php

$base = __DIR__ . '/../../../../';
// define('CLI_SCRIPT', true);
require_once $base.'config.php';

//require_once '../config.php';

define('MAX_BULK_USERS', 2000);
date_default_timezone_set("Asia/Kolkata");
ini_set('max_execution_time', 300);
error_reporting(E_ALL | E_STRICT); 
ini_set('display_errors', '1'); 
$CFG->debug = (E_ALL | E_STRICT); 
$CFG->debugdisplay = 1;
$CFG->debugdeveloper= 1;

$version      = "UB:V1";
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

	$set_query = $value->sqlselect.$value->sqlwhere.$value->sql_group;
	$response  = $DB->get_records_sql($set_query,$params);

	$query_cohort_mem = $DB->get_records_sql("SELECT cm.userid,u.deleted FROM `mdl_cohort` as c join mdl_cohort_members as cm on cm.cohortid = c.id join mdl_user as u on u.id = cm.userid where c.id = $value->cohort_id");

	$total_data .= "Cohort ID - ".$value->cohort_id;
	$total_data .= "<br>";

	if(!empty($query_cohort_mem))
	{
		foreach ($query_cohort_mem as $subkey => $subvalue) 
		{
			foreach ($response as $subkey1 => $subvalue1) 
			{
				$all_filtered_users[] = $subkey1;
				if($subkey1 != $subvalue->userid && !in_array($subvalue->userid, $all_filtered_users))
				{  
					$query = $DB->get_records_sql("SELECT userid FROM mdl_cohort_members where cohortid = $value->cohort_id and userid = $subkey1");
					
					if(empty($query))
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
				else
				{
					if($subvalue->deleted == 1)
					{
						$del_sql = "DELETE FROM mdl_cohort_members where userid = ? and cohortid = ?";
						$DB->execute($del_sql, array('userid' => $subvalue->userid, 'cohortid' => $value->cohort_id));
						$delete_count++;

						$delete_data .= "Cohort ID - ".$value->cohort_id;
				        $delete_data .= "User ID - ".$subvalue->userid;
						$delete_data .= "<br>";
					}
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
	$DB->execute("update mdl_dynamic_cohort_cust_rule_set set updated_at = ? where id = ?",array('updated_at' => date('Y-m-d H:i:s'), 'id' => $value->id));
}

echo "executed properly";
//echo $total_data;

$rec_insert1 			    = new stdClass();
$rec_insert1->name  	    = "Dynamic Cohort (User Bulk : V1)";
$rec_insert1->execution_datetime= date("Y-m-d H:i:s");
$rec_insert1->total_count   = $total_count;
$rec_insert1->total_data    = trim($total_data);
$rec_insert1->insert_count  = $insert_count;
$rec_insert1->insert_data   = $insert_data;
$rec_insert1->delete_count  = $delete_count;
$rec_insert1->delete_data   = $delete_data;
$rec_insert1->update_count  = $update_count;
$rec_insert1->update_data   = $update_data;
//echo "<pre>"; print_r($rec_insert1);
//$DB->insert_record('custom_cron_logs', $rec_insert1, true);

$cron_sql = "INSERT INTO mdl_custom_cron_logs(name, execution_datetime, total_count, total_data, insert_count, insert_data, delete_count, delete_data, update_count, update_data) VALUES ('".$rec_insert1->name."','".$rec_insert1->execution_datetime."','".$rec_insert1->total_count."',\"".$rec_insert1->total_data."\",'".$rec_insert1->insert_count."',\"".$rec_insert1->insert_data."\",'".$rec_insert1->delete_count."',\"".$rec_insert1->delete_data."\",'".$rec_insert1->update_count."',\"".$rec_insert1->update_data."\")";
$DB->execute($cron_sql);