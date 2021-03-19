<?php

require_once('../../config.php');
require_login(); // We need login
global $CFG, $DB;

define('MAX_BULK_USERS', 2000);

error_reporting(E_ALL | E_STRICT); 
ini_set('display_errors', '1'); 
$CFG->debug = (E_ALL | E_STRICT); 
$CFG->debugdisplay = 1;
$CFG->debugdeveloper= 1;

// echo"<pre>";
// print_r($_POST);
// exit();

$post_item          = $_POST;
$cohort_name 		= $_POST['cohort_name'];
$rule_name   		= $_POST['rule_name'];
$param 	 			= array();
$param['exguest'] 	= 1;
$total 	 			= count($_POST['tbl_columns']);
$tog_val 			= $total - 2;
// $sqlselect 			= "select * from mdl_user where";
// $sqlwhere  			= "id<>:exguest AND deleted <> 1 AND";
// SELECT * FROM mdl_user as u join mdl_user_attribute_mapping as m on m.user_id = u.id join mdl_custom_user_field_detail as a on a.id = m.attribute_id where a.field = 'grade' and m.attribute_value = 'A'

foreach ($_POST['tbl_columns'] as $key => $value) {
	$get_column 	= $DB->get_record_sql("SELECT field,field_type,is_default FROM `mdl_custom_user_field_detail` where id = ?", 
		array('id' => $value));
	$get_column_name	= $get_column->field;
	$get_column_type	= $get_column->field_type;
	$get_column_flag	= $get_column->is_default;
		
	if($get_column_type == "DT")
	{
		// 2020-07-07T19:05
		$exdate 	= explode('T',$_POST['tbl_value'][$key]);
		$fulldate 	= $exdate[0].''.$exdate[1];
		$set_val 	= strtotime($fulldate);
	}
	else
	{
		$set_val 	= $_POST['tbl_value'][$key];
	}


	if($get_column_flag == 1)
	{
		// Defaut

		$sqlselect 			= "select * from mdl_user where";
		$sqlwhere  			= "id<>:exguest AND deleted <> 1 AND";


		if($_POST['tbl_condition'][$key] == 1)
		{
			//contains
			$sqlwhere 				.= " ".$get_column_name." LIKE :ex_text".$key." ESCAPE '\\'";
			$param['ex_text'.$key]  = "%".$set_val."%";
		}
		else if($_POST['tbl_condition'][$key] == 2)
		{
			//doesn't contain
			$sqlwhere 				.= " ".$get_column_name." NOT LIKE :ex_text".$key." ESCAPE '\\'";
			$param['ex_text'.$key]  = "%".$set_val."%";
		}
		else if($_POST['tbl_condition'][$key] == 3)
		{
			//is equal to
			$sqlwhere 				.= " ".$get_column_name." LIKE :ex_text".$key." ESCAPE '\\'";
			$param['ex_text'.$key]  = $set_val;
		}
		else if($_POST['tbl_condition'][$key] == 4)
		{
			//starts with
			$sqlwhere 				.= " ".$get_column_name." LIKE :ex_text".$key." ESCAPE '\\'";
			$param['ex_text'.$key]  = $set_val."%";
		}
		else if($_POST['tbl_condition'][$key] == 5)
		{
			//ends with
			$sqlwhere 				.= " ".$get_column_name." LIKE :ex_text".$key." ESCAPE '\\'";
			$param['ex_text'.$key]  = "%".$set_val;
		}
		else if($_POST['tbl_condition'][$key] == 6)
		{
			//is empty
			$sqlwhere 				.= " ".$get_column_name." = :ex_text".$key." ESCAPE '\\'";
			$param['ex_text'.$key]  = "";
		}
		else if($_POST['tbl_condition'][$key] == 7)
		{
			//distinct
			$dist_sql 			  = "select distinct ".$get_column_name." from mdl_user where id <> 1 and deleted = 0";
			$get_distinct_records = $DB->get_records_sql($dist_sql);
			$sqlwhere 			 .= " ".$get_column_name." LIKE :ex_text".$key." ESCAPE '\\'";

			foreach ($get_distinct_records as $distkey => $distvalue) {
				$param['ex_text'.$key]   = $distkey;
				$set_cohort_name 		 = $cohort_name.'_'.$distkey;
				$set_rule_name 			 = $rule_name.'_'.$distkey;
				
				dynamic_cohort_creation($set_cohort_name,$param,$_POST,$sqlwhere,$set_rule_name,$sqlselect);
			}

			$returnurl = new moodle_url('/customconfig/cohort/dynamic_cohort.php');
			redirect($returnurl);
		}
		else if($_POST['tbl_condition'][$key] == 8)
		{
			//is not empty
			$sqlwhere 				.= " ".$get_column_name." != :ex_text".$key." ESCAPE '\\'";
			$param['ex_text'.$key]  = "";
		}
		else if($_POST['tbl_condition'][$key] == 9)
		{
			//less than
			$sqlwhere 				.= " ".$get_column_name." < :ex_text".$key." ESCAPE '\\'";
			$param['ex_text'.$key]  = $set_val;
		}
		else if($_POST['tbl_condition'][$key] == 10)
		{
			//greater than
			$sqlwhere 				.= " ".$get_column_name." > :ex_text".$key." ESCAPE '\\'";
			$param['ex_text'.$key]  = $set_val;
		}
		else if($_POST['tbl_condition'][$key] == 11)
		{
			//less & equals to
			$sqlwhere 				.= " ".$get_column_name." <= :ex_text".$key." ESCAPE '\\'";
			$param['ex_text'.$key]  = $set_val;
		}
		else if($_POST['tbl_condition'][$key] == 12)
		{
			//greater & equals to
			$sqlwhere 				.= " ".$get_column_name." >= :ex_text".$key." ESCAPE '\\'";
			$param['ex_text'.$key]  = $set_val;
		}
		else if($_POST['tbl_condition'][$key] == 13)
		{
			//not equals to
			$sqlwhere 				.= " ".$get_column_name." != :ex_text".$key." ESCAPE '\\'";
			$param['ex_text'.$key]  = $set_val;
		}
		else if($_POST['tbl_condition'][$key] == 14)
		{
			//between
			$exdate1 	= explode('T',$_POST['tbl_value_bet'][$key]);
			$fulldate1 	= $exdate1[0].''.$exdate1[1];
			$set_val1	= strtotime($fulldate1);

			$sqlwhere 				 .= " ".$get_column_name." between :ex_textb".$key." and :ex_textb1".$key." ESCAPE '\\'";
			$param['ex_textb'.$key]   = $set_val;
			$param['ex_textb1'.$key]  = $set_val1;

		}
		else if($_POST['tbl_condition'][$key] == 15)
		{
			//not between
			$exdate1 	= explode('T',$_POST['tbl_value_ntbet'][$key]);
			$fulldate1 	= $exdate1[0].''.$exdate1[1];
			$set_val1	= strtotime($fulldate1);
			
			$sqlwhere 				  .= " ".$get_column_name." not between :ex_textnb".$key." and :ex_textnb1".$key." ESCAPE '\\'";
			$param['ex_textnb'.$key]   = $set_val;
			$param['ex_textnb1'.$key]  = $set_val1;
		}
		else if($_POST['tbl_condition'][$key] == 16)
		{
			//IN()
			$sqlwhere 				.= " ".$get_column_name." IN ( :ex_text".$key." ) ESCAPE '\\'";
			$param['ex_text'.$key]  = $set_val;
		}
		else if($_POST['tbl_condition'][$key] == 17)
		{
			//NOT IN()
			$sqlwhere 				.= " ".$get_column_name." NOT IN ( :ex_text".$key." ) ESCAPE '\\'";
			$param['ex_text'.$key]  = $set_val;
		}

	}
	else
	{
		// Attribute

		$sqlselect 			= " SELECT u.* FROM mdl_user as u 
								join mdl_user_attribute_mapping as m on m.user_id = u.id 
								join mdl_custom_user_field_detail as a on a.id = m.attribute_id 
								where ";
		$sqlwhere  			= "u.id<>:exguest AND u.deleted <> 1 AND";


		if($_POST['tbl_condition'][$key] == 1)
		{
			//contains
			$sqlwhere 				.= " a.field = '".$get_column_name."' and m.attribute_value LIKE :ex_text".$key;
			$param['ex_text'.$key]  = "%".$set_val."%";
		}
		else if($_POST['tbl_condition'][$key] == 2)
		{
			//doesn't contain
			$sqlwhere 				.= " a.field = '".$get_column_name."' and m.attribute_value NOT LIKE :ex_text".$key;
			$param['ex_text'.$key]  = "%".$set_val."%";
		}
		else if($_POST['tbl_condition'][$key] == 3)
		{
			//is equal to
			$sqlwhere 				.= " a.field = '".$get_column_name."' and m.attribute_value LIKE :ex_text".$key;
			$param['ex_text'.$key]  = $set_val;
		}
		else if($_POST['tbl_condition'][$key] == 4)
		{
			//starts with
			$sqlwhere 				.= " a.field = '".$get_column_name."' and m.attribute_value LIKE :ex_text".$key;
			$param['ex_text'.$key]  = $set_val."%";
		}
		else if($_POST['tbl_condition'][$key] == 5)
		{
			//ends with
			$sqlwhere 				.= " a.field = '".$get_column_name."' and m.attribute_value LIKE :ex_text".$key;
			$param['ex_text'.$key]  = "%".$set_val;
		}
		else if($_POST['tbl_condition'][$key] == 6)
		{
			//is empty
			$sqlwhere 				.= " a.field = '".$get_column_name."' and m.attribute_value = :ex_text".$key;
			$param['ex_text'.$key]  = "";
		}
		else if($_POST['tbl_condition'][$key] == 7)
		{
			//distinct

			// SELECT DISTINCT m.attribute_value FROM mdl_user as u join mdl_user_attribute_mapping as m on m.user_id = u.id join mdl_custom_user_field_detail as a on a.id = m.attribute_id where a.field = 'grade'

			$dist_sql 			  = "SELECT DISTINCT m.attribute_value FROM mdl_user as u join mdl_user_attribute_mapping as m on m.user_id = u.id join mdl_custom_user_field_detail as a on a.id = m.attribute_id where a.field = '".$get_column_name."' and u.id <> 1 and u.deleted = 0";

			$get_distinct_records = $DB->get_records_sql($dist_sql);
			$sqlwhere 			 .= " a.field = '".$get_column_name."' and m.attribute_value LIKE :ex_text".$key;

			foreach ($get_distinct_records as $distkey => $distvalue) {
				$param['ex_text'.$key]   = $distkey;
				$set_cohort_name 		 = $cohort_name.'_'.$distkey;
				$set_rule_name 			 = $rule_name.'_'.$distkey;
				
				dynamic_attribute_cohort_creation($set_cohort_name,$param,$_POST,$sqlwhere,$set_rule_name,$sqlselect);
			}

			$returnurl = new moodle_url('/customconfig/cohort/dynamic_cohort.php');
			redirect($returnurl);
		}
		else if($_POST['tbl_condition'][$key] == 8)
		{
			//is not empty
			$sqlwhere 				.= " a.field = '".$get_column_name."' and m.attribute_value != :ex_text".$key;
			$param['ex_text'.$key]  = "";
		}
		else if($_POST['tbl_condition'][$key] == 9)
		{
			//less than
			$sqlwhere 				.= " a.field = '".$get_column_name."' and m.attribute_value < :ex_text".$key;
			$param['ex_text'.$key]  = $set_val;
		}
		else if($_POST['tbl_condition'][$key] == 10)
		{
			//greater than
			$sqlwhere 				.= " a.field = '".$get_column_name."' and m.attribute_value > :ex_text".$key;
			$param['ex_text'.$key]  = $set_val;
		}
		else if($_POST['tbl_condition'][$key] == 11)
		{
			//less & equals to
			$sqlwhere 				.= " a.field = '".$get_column_name."' and m.attribute_value <= :ex_text".$key;
			$param['ex_text'.$key]  = $set_val;
		}
		else if($_POST['tbl_condition'][$key] == 12)
		{
			//greater & equals to
			$sqlwhere 				.= " a.field = '".$get_column_name."' and m.attribute_value >= :ex_text".$key;
			$param['ex_text'.$key]  = $set_val;
		}
		else if($_POST['tbl_condition'][$key] == 13)
		{
			//not equals to
			$sqlwhere 				.= " a.field = '".$get_column_name."' and m.attribute_value != :ex_text".$key;
			$param['ex_text'.$key]  = $set_val;
		}
		else if($_POST['tbl_condition'][$key] == 14)
		{
			//between
			$exdate1 	= explode('T',$_POST['tbl_value_bet'][$key]);
			$fulldate1 	= $exdate1[0].''.$exdate1[1];
			$set_val1	= strtotime($fulldate1);

			$sqlwhere 				 .= " a.field = '".$get_column_name."' and m.attribute_value between :ex_textb".$key." and :ex_textb1".$key;
			$param['ex_textb'.$key]   = $set_val;
			$param['ex_textb1'.$key]  = $set_val1;

		}
		else if($_POST['tbl_condition'][$key] == 15)
		{
			//not between
			$exdate1 	= explode('T',$_POST['tbl_value_ntbet'][$key]);
			$fulldate1 	= $exdate1[0].''.$exdate1[1];
			$set_val1	= strtotime($fulldate1);
			
			$sqlwhere 				  .= " a.field = '".$get_column_name."' and m.attribute_value not between :ex_textnb".$key." and :ex_textnb1".$key;
			$param['ex_textnb'.$key]   = $set_val;
			$param['ex_textnb1'.$key]  = $set_val1;
		}
		else if($_POST['tbl_condition'][$key] == 16)
		{
			//IN()
			$sqlwhere 				.= " a.field = '".$get_column_name."' and m.attribute_value IN ( :ex_text".$key." ) ";
			$param['ex_text'.$key]  = $set_val;
		}
		else if($_POST['tbl_condition'][$key] == 17)
		{
			//NOT IN()
			$sqlwhere 				.= " a.field = '".$get_column_name."' and m.attribute_value NOT IN ( :ex_text".$key." ) ";
			$param['ex_text'.$key]  = $set_val;
		}

	}

	if($total > 1 && $key <= $tog_val)
	{
		$sqlwhere .= $_POST['toggle_value'][$key];
	}

	if($get_column_flag == 1)
	{
		dynamic_cohort_creation($cohort_name,$param,$post_item,$sqlwhere,$rule_name,$sqlselect);
	}
	else
	{
		dynamic_attribute_cohort_creation($cohort_name,$param,$post_item,$sqlwhere,$rule_name,$sqlselect);
	}
}

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
	exit();
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

	$set_sql     = 'INSERT INTO mdl_dynamic_cohort_cust_rule_set (rule_name, cohort_id, sqlselect, sqlwhere, sqlparam, check_all_users,total_users, description, created_by, updated_by) VALUES (?,?,?,?,?,?,?,?,?,?)';

	$hparams = array();
	$hparams['rule_name']   = $rule_name;
	$hparams['cohort_id']   = $cohort_id;
	$hparams['sqlselect']   = $sqlselect;
	$hparams['sqlwhere']    = $sqlwhere;
	$hparams['sqlparam']    = $sqlparam;
	$hparams['check_all_users'] = 0;
	$hparams['total_users'] = $no_of_users;
	$hparams['description'] = $description;
	$hparams['created_by']  = $USER->id;
	$hparams['updated_by']  = $USER->id;
	//echo"<pre>"; print_r($hparams); //exit();
	$DB->execute($set_sql, $hparams);

	return true;
}

//dynamic_attribute_cohort_creation
function dynamic_attribute_cohort_creation($cohort_name,$param,$post_item,$sqlwhere,$rule_name,$sqlselect)
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

	/*
	echo "select - ".$sqlselect;
	echo "<br> where - ".$sqlwhere;
	echo "<br> param - "; print_r($param);
	echo "<br> post_item - "; print_r($post_item);
	exit();
	*/

	$set_query = $sqlselect.$sqlwhere;
	$response  = $DB->get_records_sql($set_query,$param);
	// echo "<pre>"; print_r($fetch_rec); exit();

	$no_of_users = count($response);

	foreach ($response as $res_key => $res_value) 
	{
		$rec_insert= new stdClass();
	    $rec_insert->cohortid  = $cohort_id;
	    $rec_insert->userid    = $res_key;
	    $rec_insert->timeadded = time();
	    $DB->insert_record('cohort_members', $rec_insert, true);
	}

	$set_sql     = 'INSERT INTO mdl_dynamic_cohort_cust_rule_set (rule_name, cohort_id, sqlselect, sqlwhere, sqlparam, check_all_users,total_users, description, created_by, updated_by) VALUES (?,?,?,?,?,?,?,?,?,?)';

	$hparams = array();
	$hparams['rule_name']   = $rule_name;
	$hparams['cohort_id']   = $cohort_id;
	$hparams['sqlselect']   = $sqlselect;
	$hparams['sqlwhere']    = $sqlwhere;
	$hparams['sqlparam']    = $sqlparam;
	$hparams['check_all_users'] = 0;
	$hparams['total_users'] = $no_of_users;
	$hparams['description'] = $description;
	$hparams['created_by']  = $USER->id;
	$hparams['updated_by']  = $USER->id;
	//echo"<pre>"; print_r($hparams); //exit();
	$DB->execute($set_sql, $hparams);

	return true;
}

$returnurl = new moodle_url('/customconfig/cohort/dynamic_cohort.php');
redirect($returnurl);

?>
