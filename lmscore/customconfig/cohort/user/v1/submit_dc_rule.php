<?php

require_once('../../../../config.php');
require_login(); // We need login
global $CFG, $DB;

define('MAX_BULK_USERS', 2000);

// error_reporting(E_ALL | E_STRICT); 
// ini_set('display_errors', '1'); 
// $CFG->debug = (E_ALL | E_STRICT); 
// $CFG->debugdisplay = 1;
// $CFG->debugdeveloper= 1;

// echo"<pre>";
// print_r($_POST);
$version      		= "U:V1";
$post_item          = $_POST;
$cohort_name 		= $_POST['cohort_name'];
$rule_name   		= $_POST['rule_name'];
$param 	 			= array();
$param['exguest'] 	= 1;
$total 	 			= count($_POST['tbl_columns']);
$tog_val 			= $total - 2;
$sqlselect 			= "select * from mdl_user where";
$sqlwhere  			= "id<>:exguest AND deleted <> 1 AND";

foreach ($_POST['tbl_columns'] as $key => $value) {

	if($_POST['tbl_condition'][$key] == 1)
	{
		//contains
		$sqlwhere 				.= " ".$value." LIKE :ex_text".$key." ESCAPE '\\'";
		$param['ex_text'.$key]  = "%".$_POST['tbl_value'][$key]."%";
	}
	else if($_POST['tbl_condition'][$key] == 2)
	{
		//doesn't contain
		$sqlwhere 				.= " ".$value." NOT LIKE :ex_text".$key." ESCAPE '\\'";
		$param['ex_text'.$key]  = "%".$_POST['tbl_value'][$key]."%";
	}
	else if($_POST['tbl_condition'][$key] == 3)
	{
		//is equal to
		$sqlwhere 				.= " ".$value." LIKE :ex_text".$key." ESCAPE '\\'";
		$param['ex_text'.$key]  = $_POST['tbl_value'][$key];
	}
	else if($_POST['tbl_condition'][$key] == 4)
	{
		//starts with
		$sqlwhere 				.= " ".$value." LIKE :ex_text".$key." ESCAPE '\\'";
		$param['ex_text'.$key]  = $_POST['tbl_value'][$key]."%";
	}
	else if($_POST['tbl_condition'][$key] == 5)
	{
		//ends with
		$sqlwhere 				.= " ".$value." LIKE :ex_text".$key." ESCAPE '\\'";
		$param['ex_text'.$key]  = "%".$_POST['tbl_value'][$key];
	}
	else if($_POST['tbl_condition'][$key] == 6)
	{
		//is empty
		$sqlwhere 				.= " ".$value." = :ex_text".$key." ESCAPE '\\'";
		$param['ex_text'.$key]  = "";
	}
	else if($_POST['tbl_condition'][$key] == 7)
	{
		//distinct
		$dist_sql 			  = "select distinct ".$value." from mdl_user where id <> 1 and deleted = 0";
		$get_distinct_records = $DB->get_records_sql($dist_sql);
		$sqlwhere 			 .= " ".$value." LIKE :ex_text".$key." ESCAPE '\\'";

		foreach ($get_distinct_records as $distkey => $distvalue) {
			$param['ex_text'.$key]   = $distkey;
			$set_cohort_name 		 = $cohort_name.'_'.$distkey;
			$set_rule_name 			 = $rule_name.'_'.$distkey;
			
			dynamic_cohort_creation($set_cohort_name,$param,$_POST,$sqlwhere,$set_rule_name,$sqlselect);
		}

		$returnurl = new moodle_url('/customconfig/cohort/user/v1/dynamic_cohort.php');
		redirect($returnurl);
	}
	else if($_POST['tbl_condition'][$key] == 8)
	{
		//is not empty
		$sqlwhere 				.= " ".$value." != :ex_text".$key." ESCAPE '\\'";
		$param['ex_text'.$key]  = "";
	}
	else if($_POST['tbl_condition'][$key] == 9)
	{
		//less than
		$sqlwhere 				.= " ".$value." < :ex_text".$key." ESCAPE '\\'";
		$param['ex_text'.$key]  = $_POST['tbl_value'][$key];
	}
	else if($_POST['tbl_condition'][$key] == 10)
	{
		//greater than
		$sqlwhere 				.= " ".$value." > :ex_text".$key." ESCAPE '\\'";
		$param['ex_text'.$key]  = $_POST['tbl_value'][$key];
	}
	else if($_POST['tbl_condition'][$key] == 11)
	{
		//less & equals to
		$sqlwhere 				.= " ".$value." <= :ex_text".$key." ESCAPE '\\'";
		$param['ex_text'.$key]  = $_POST['tbl_value'][$key];
	}
	else if($_POST['tbl_condition'][$key] == 12)
	{
		//greater & equals to
		$sqlwhere 				.= " ".$value." >= :ex_text".$key." ESCAPE '\\'";
		$param['ex_text'.$key]  = $_POST['tbl_value'][$key];
	}
	else if($_POST['tbl_condition'][$key] == 13)
	{
		//not equals to
		$sqlwhere 				.= " ".$value." != :ex_text".$key." ESCAPE '\\'";
		$param['ex_text'.$key]  = $_POST['tbl_value'][$key];
	}
	else if($_POST['tbl_condition'][$key] == 14)
	{
		//between
		// $sqlwhere 				.= " ".$value." between :ex_text".$key." ESCAPE '\\'";
		// $split_val 				= explode(',', $_POST['tbl_value'][$key]);
		// $param['ex_text'.$key]  = $split_val[0]." and ".$split_val[1];

		$sqlwhere 				 .= " ".$value." between :ex_textb".$key." and :ex_textb1".$key." ESCAPE '\\'";
		$split_val 				  = explode(',', $_POST['tbl_value'][$key]);
		$param['ex_textb'.$key]   = $split_val[0];
		$param['ex_textb1'.$key]  = $split_val[1];

	}
	else if($_POST['tbl_condition'][$key] == 15)
	{
		//not between
		// $sqlwhere 				.= " ".$value." not between :ex_text".$key." ESCAPE '\\'";
		// $split_val 				= explode(',', $_POST['tbl_value'][$key]);
		// $param['ex_text'.$key]  = $split_val[0]." and ".$split_val[1];

		$sqlwhere 				  .= " ".$value." not between :ex_textnb".$key." and :ex_textnb1".$key." ESCAPE '\\'";
		$split_val 				   = explode(',', $_POST['tbl_value'][$key]);
		$param['ex_textnb'.$key]   = $split_val[0];
		$param['ex_textnb1'.$key]  = $split_val[1];
	}

	if($total > 1 && $key <= $tog_val)
	{
		$sqlwhere .= $_POST['toggle_value'][$key];
	}
}

dynamic_cohort_creation($cohort_name,$param,$post_item,$sqlwhere,$rule_name,$sqlselect);

function dynamic_cohort_creation($cohort_name,$param,$post_item,$sqlwhere,$rule_name,$sqlselect)
{
	global $DB, $USER;

	$cohort_insert  		  	= new stdClass();
	$cohort_insert->contextid   = 1;
	$cohort_insert->name    	= $cohort_name;
	$cohort_insert->descriptionformat = 1;
	$cohort_insert->timecreated = time();
	$cohort_insert->timemodified= time();
	$cohort_id = $DB->insert_record('cohort', $cohort_insert, true);

	$sqlparam 		= serialize( $param );
	$description 	= serialize( $post_item );
	$sqlstr 		= str_replace("ESCAPE '\\'"," ",$sqlwhere); //echo $sqlstr; exit();

	/*
	echo "select - ".$sqlselect;
	echo "<br> where - ".$sqlwhere;
	echo "<br> param - ".$sqlparam;
	//exit();
	*/

	$response = $DB->get_records_select_menu('user', $sqlstr, $param, 'fullname', 'id,'.$DB->sql_fullname().' AS fullname', 0, MAX_BULK_USERS);
	//print_r(count($response)); //exit();
	$no_of_users = count($response);

	foreach ($response as $res_key => $res_value) 
	{
		$rec_insert= new stdClass();
	    $rec_insert->cohortid  = $cohort_id;
	    $rec_insert->userid    = $res_key;
	    $rec_insert->timeadded = time();
	    $DB->insert_record('cohort_members', $rec_insert, true);
	}

	$set_sql     = 'INSERT INTO mdl_dynamic_cohort_cust_rule_set (rule_name, cohort_id, sqlselect, sqlwhere, sqlparam, check_all_users,total_users, description,version, created_by, updated_by) VALUES (?,?,?,?,?,?,?,?,?,?,?)';

	$hparams = array();
	$hparams['rule_name']   = $rule_name;
	$hparams['cohort_id']   = $cohort_id;
	$hparams['sqlselect']   = $sqlselect;
	$hparams['sqlwhere']    = $sqlwhere;
	$hparams['sqlparam']    = $sqlparam;
	$hparams['check_all_users'] = 0;
	$hparams['total_users'] = $no_of_users;
	$hparams['description'] = $description;
	$hparams['version'] 	= !empty($version)?$version:"U:V1";
	$hparams['created_by']  = $USER->id;
	$hparams['updated_by']  = $USER->id;
	//echo"<pre>"; print_r($hparams); //exit();
	$DB->execute($set_sql, $hparams);

	return true;
}

$returnurl = new moodle_url('/customconfig/cohort/user/v1/dynamic_cohort.php');
redirect($returnurl);

?>
