<?php

require_once '../../config.php';
// error_reporting(E_ALL | E_STRICT); 
// ini_set('display_errors', '1'); 
// $CFG->debug = (E_ALL | E_STRICT); 
// $CFG->debugdisplay = 1;
// $CFG->debugdeveloper= 1;

$get_rule_set = $DB->get_records_sql("SELECT * FROM `mdl_dynamic_cohort_rule_set` where cohort_id != 0");

foreach ($get_rule_set as $key => $value) {
	
	if($value->sqlwhere == "id<>:exguest AND deleted <> 1" && $value->check_all_users == "0")
	{
		// No rule set is defined - so its not a DC
	}
	else
	{
		// With defined rule set
		$all_filtered_users = array();
		$params   = unserialize($value->sqlparam);
		$response = $DB->get_records_select_menu('user', $value->sqlwhere, $params, 'fullname', 'id,'.$DB->sql_fullname().' AS fullname', 0, MAX_BULK_USERS);
		//print_r($response); exit();

		$query_cohort_mem = $DB->get_records_sql("SELECT cm.userid FROM `mdl_cohort` as c join mdl_cohort_members as cm on cm.cohortid = c.id where c.id = $value->cohort_id");

		if(!empty($query_cohort_mem))
		{
			foreach ($query_cohort_mem as $subkey => $subvalue) 
			{
				foreach ($response as $subkey1 => $subvalue1) 
				{
					$all_filtered_users[] = $subkey1;
					if($subkey1 != $subvalue->userid && !in_array($subvalue->userid, $all_filtered_users))
					{  
						$rec_insert= new stdClass();
				        $rec_insert->cohortid  = $value->cohort_id;
				        $rec_insert->userid    = $subkey1;
				        $rec_insert->timeadded = time();
				        $DB->insert_record('cohort_members', $rec_insert, true);
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
			}
		}

		$arr = array_unique($all_filtered_users);
		//$query_pgrp_del_users = $DB->execute("DELETE FROM `mdl_cohort_members` WHERE `cohortid` = ? AND `userid` not in ?",array('cohortid' => $value->cohort_id, 'userid' => array_values($arr) ));

		/*
		$set_sql = $value->sqlselect.' '.$value->sqlwhere;
		str_replace(":exguest","1",$set_sql);
		$get_data = $DB->get_records_sql("SELECT * FROM `mdl_dynamic_cohort_rule_set` where cohort_id != 0");
		*/
	}
}

// id<>:exguest AND deleted <> 1 AND CONCAT(firstname, ' ', lastname) LIKE :ex_text1  ESCAPE '\\'

// a:2:{s:7:"exguest";s:1:"1";s:8:"ex_text1";s:7:"%sahil%";}
// $array = unserialize( $string );