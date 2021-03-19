<?php
require_once(dirname(dirname(dirname(dirname(dirname(__FILE__))))) . '/config.php');
require_login(); // We need login
global $DB,$USER;

error_reporting(E_ALL | E_STRICT); 
ini_set('display_errors', '1'); 
$CFG->debug = (E_ALL | E_STRICT); 
$CFG->debugdisplay = 1;
$CFG->debugdeveloper= 1;

define('MAX_BULK_USERS', 2000);

//Set time zone
date_default_timezone_set('Asia/Kolkata');

$wsfunction = $_POST['wsfunction'];

if($wsfunction == "get_condition"){

	$field_id  	= $_POST['tbl_columns_id'];
	$data 		= array();
	
	if($field_id)
	{
		try {
			
			$get_response = $DB->get_records_sql("SELECT c.*,dc.id as mapping_id FROM `mdl_custom_user_field_detail_condition` AS dc join mdl_custom_user_field_condition as c on dc.condition_id = c.id WHERE dc.field_id = ? and c.field_condition !='distinct'", array('field_id' => $field_id));
			
            foreach ($get_response as $key => $value) {
               $data[$value->id] = $value->field_condition;
            }

            $get_type   = $DB->get_record_sql("SELECT field_type FROM `mdl_custom_user_field_detail` where id = ?", array('id' => $field_id));

            $status     = 1;
            $message    = "Success";
            $field_type = $get_type->field_type; 

		}catch(Exception $e) {
	          $message = 'Message: ' .$e->getMessage();
	    }

    }
    else
    {
        $returndata['status']  = 0;
        $returndata['message'] = "Parameter Missing.";
        $returndata['result']  = null;
    }

    $returndata['status']  = $status;
    $returndata['message'] = $message;
    $returndata['result']  = isset($data)?$data:[];
    $returndata['field_type'] = isset($field_type)?$field_type:'T';

    echo $data = json_encode($returndata);
}else if($wsfunction == "get_disitnct_values_old"){

    $column   = $_POST['tbl_columns'];
    $data       = array();
    
    if($column)
    {
        try {
            
            $sql          = "SELECT distinct ".$column." FROM mdl_user where deleted = 0 and id <> 1";
            //echo $sql; exit();

            $get_response = $DB->get_records_sql($sql);
            //print_r($get_response);

            foreach ($get_response as $key => $value) {
                $data[] = $key;
            }

            //print_r($data); exit();

            $status     = 1;
            $message    = "Success"; 

        }catch(Exception $e) {
              $message = 'Message: ' .$e->getMessage();
        }

    }
    else
    {
        $returndata['status']  = 0;
        $returndata['message'] = "Parameter Missing.";
        $returndata['data']    = null;
    }

    $returndata['status']  = $status;
    $returndata['message'] = $message;
    $returndata['data']    = isset($data)?$data:[];

    echo $data = json_encode($returndata);
}else if($wsfunction == "get_disitnct_values"){

    $column   = trim($_POST['tbl_columns']);
    $data     = array();
    
    if($column)
    {
        try {
            
            $sql1   =     "SELECT DISTINCT m.attribute_value 
                            FROM mdl_user as u 
                            join mdl_user_attribute_mapping as m on m.user_id = u.id 
                            join mdl_custom_user_field_detail as a on a.id = m.attribute_id 
                            where a.field = ?";
            $get_response = $DB->get_records_sql($sql1,array($column));
            // print_r($get_response);

            if(empty($get_response))
            {
                $get_response = $DB->get_records_sql("SELECT distinct $column FROM mdl_user where deleted = 0 and id <> 1 and $column != '' ");
            }

            foreach ($get_response as $key => $value) {
                $data[] = $key;
            }

            //print_r($data); exit();

            $status     = 1;
            $message    = "Success"; 

        }catch(Exception $e) {
            $status     = 0;
            $message    = 'Message: ' .$e->getMessage();
        }

    }
    else
    {
        $returndata['status']  = 0;
        $returndata['message'] = "Parameter Missing.";
        $returndata['data']    = null;
    }

    $returndata['status']  = $status;
    $returndata['message'] = $message;
    $returndata['data']    = isset($data)?$data:[];

    echo $data = json_encode($returndata);
}else if($wsfunction == "update_dc_status"){
    $config_id      = $_POST['config_id'];
    $user_id        = $_POST['user_id'];
    $set_config_val = '';
    $returndata  = array();

    if($config_id != '')
    {
        try {

            $query          =  " SELECT * FROM `mdl_dynamic_cohort_cust_rule_set` WHERE id = '$config_id'";
            $get_config     = $DB->get_record_sql($query);
            //print_r($get_config);

            if(!empty($get_config))
            {
                if($get_config->is_active == 1)
                {
                    $set_config_val = 0;
                }
                else
                {
                    $set_config_val = 1;
                }

                //print_r($set_config_val);
                $sql    = "UPDATE `mdl_dynamic_cohort_cust_rule_set` SET `is_active` = '".$set_config_val."' , updated_at = '".date('Y-m-d H:i:s')."', updated_by = '".$user_id."' WHERE `id` = ".$config_id;
                //echo $sql; exit();
                $DB->execute($sql);
                
                $message = "Updated successfully !";
                $status  = 1;
            }
            else
            {
                $message = "No record found !";
                $status  = 0;
            }

        } catch (Exception $e) {
            echo "error - ".$e;
        }
    }
    else
    {
        $message = "Parameter missing.";
        $status  = 0;
    }
      
    $returndata['status']  = $status;
    $returndata['message'] = $message;
    $returndata['set_config_val'] = $set_config_val;

    echo $data = json_encode($returndata);
}else if($wsfunction == "delete_dc"){
    $dc_id          = $_POST['dc_id'];
    $user_id        = $_POST['user_id'];
    $returndata     = array();

    if($dc_id != '')
    {
        try {

            $get_config     = $DB->get_record_sql("SELECT * FROM `mdl_dynamic_cohort_cust_rule_set` WHERE id = ? and is_default = ?", array('id' => $dc_id, 'is_default' => 0));

            if(!empty($get_config))
            {
                $DB->execute("DELETE FROM `mdl_cohort_members` WHERE cohortid = ?", array('cohortid' => $get_config->cohort_id));
                $DB->execute("DELETE FROM `mdl_cohort` WHERE id = ?",array('id' => $get_config->cohort_id));
                $DB->execute("UPDATE `mdl_dynamic_cohort_cust_rule_set` SET is_deleted = ? , total_users = ?, updated_by = ?, updated_at = ? WHERE id = ?", array('is_deleted' => 1, 'total_users' => 0, 'updated_by' => $user_id, 'updated_at' => date('Y-m-d H:i:s'), 'id' => $dc_id));
                
                $message = "Deleted successfully !";
                $status  = 1;
            }
            else
            {
                $message = "No record found !";
                $status  = 0;
            }

        } catch (Exception $e) {
            echo "error - ".$e;
        }
    }
    else
    {
        $message = "Parameter missing.";
        $status  = 0;
    }
      
    $returndata['status']  = $status;
    $returndata['message'] = $message;

    echo $data = json_encode($returndata);
}else if($wsfunction == "execute_query_old"){
   // print_r($_POST);
    $param 	 			= array();
    $param['exguest'] 	= 1;
    $total 	 			= count($_POST['tbl_columns']);
    $tog_val 			= $total - 2;

	$sqlselect 			= " SELECT u.* 
								FROM mdl_user as u 
								left join mdl_user_attribute_mapping as m on m.user_id = u.id 
								left join mdl_custom_user_field_detail as a on a.id = m.attribute_id 
								where ";
	$sqlwhere  			= "u.id<>:exguest AND u.deleted <> 1 AND ";



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

		// Attribute
		//SELECT u.* FROM mdl_user as u left join mdl_user_attribute_mapping as m on m.user_id = u.id left join mdl_custom_user_field_detail as a on a.id = m.attribute_id where a.field = 'grade' and m.attribute_value = 'A' and `firstname` LIKE '%s%' GROUP by u.id

		
		if($get_column_flag == 1)
		{
			// Defaut

			// $sqlselect 			= "select * from mdl_user where";
			// $sqlwhere  			= "id<>:exguest AND deleted <> 1 AND";


			if($_POST['tbl_condition'][$key] == 1)
			{
				//contains
				$sqlwhere 				.= " ".$get_column_name." LIKE :ex_text".$key;
				$param['ex_text'.$key]  = "%".$set_val."%";
			}
			else if($_POST['tbl_condition'][$key] == 2)
			{
				//doesn't contain
				$sqlwhere 				.= " ".$get_column_name." NOT LIKE :ex_text".$key;
				$param['ex_text'.$key]  = "%".$set_val."%";
			}
			else if($_POST['tbl_condition'][$key] == 3)
			{
				//is equal to
				$sqlwhere 				.= " ".$get_column_name." LIKE :ex_text".$key;
				$param['ex_text'.$key]  = $set_val;
			}
			else if($_POST['tbl_condition'][$key] == 4)
			{
				//starts with
				$sqlwhere 				.= " ".$get_column_name." LIKE :ex_text".$key;
				$param['ex_text'.$key]  = $set_val."%";
			}
			else if($_POST['tbl_condition'][$key] == 5)
			{
				//ends with
				$sqlwhere 				.= " ".$get_column_name." LIKE :ex_text".$key;
				$param['ex_text'.$key]  = "%".$set_val;
			}
			else if($_POST['tbl_condition'][$key] == 6)
			{
				//is empty
				$sqlwhere 				.= " ".$get_column_name." = :ex_text".$key;
				$param['ex_text'.$key]  = "";
			}
			else if($_POST['tbl_condition'][$key] == 7)
			{
				//distinct
				$dist_sql 			  = "select distinct ".$get_column_name." from mdl_user where id <> 1 and deleted = 0";
				$get_distinct_records = $DB->get_records_sql($dist_sql);
				$sqlwhere 			 .= " ".$get_column_name." LIKE :ex_text".$key;

				foreach ($get_distinct_records as $distkey => $distvalue) {
					$param['ex_text'.$key]   = $distkey;
					$set_cohort_name 		 = $cohort_name.'_'.$distkey;
					$set_rule_name 			 = $rule_name.'_'.$distkey;
					
					dynamic_attribute_cohort_creation($set_cohort_name,$param,$_POST,$sqlwhere,$set_rule_name,$sqlselect);
				}

				$returnurl = new moodle_url('/customconfig/cohort/attribute/v1/dynamic_cohort.php');
				redirect($returnurl);
			}
			else if($_POST['tbl_condition'][$key] == 8)
			{
				//is not empty
				$sqlwhere 				.= " ".$get_column_name." != :ex_text".$key;
				$param['ex_text'.$key]  = "";
			}
			else if($_POST['tbl_condition'][$key] == 9)
			{
				//less than
				$sqlwhere 				.= " ".$get_column_name." < :ex_text".$key;
				$param['ex_text'.$key]  = $set_val;
			}
			else if($_POST['tbl_condition'][$key] == 10)
			{
				//greater than
				$sqlwhere 				.= " ".$get_column_name." > :ex_text".$key;
				$param['ex_text'.$key]  = $set_val;
			}
			else if($_POST['tbl_condition'][$key] == 11)
			{
				//less & equals to
				$sqlwhere 				.= " ".$get_column_name." <= :ex_text".$key;
				$param['ex_text'.$key]  = $set_val;
			}
			else if($_POST['tbl_condition'][$key] == 12)
			{
				//greater & equals to
				$sqlwhere 				.= " ".$get_column_name." >= :ex_text".$key;
				$param['ex_text'.$key]  = $set_val;
			}
			else if($_POST['tbl_condition'][$key] == 13)
			{
				//not equals to
				$sqlwhere 				.= " ".$get_column_name." != :ex_text".$key;
				$param['ex_text'.$key]  = $set_val;
			}
			else if($_POST['tbl_condition'][$key] == 14)
			{
				//between
				$exdate1 	= explode('T',$_POST['tbl_value_bet'][$key]);
				$fulldate1 	= $exdate1[0].''.$exdate1[1];
				$set_val1	= strtotime($fulldate1);

				$sqlwhere 				 .= " ".$get_column_name." between :ex_textb".$key." and :ex_textb1".$key;
				$param['ex_textb'.$key]   = $set_val;
				$param['ex_textb1'.$key]  = $set_val1;

			}
			else if($_POST['tbl_condition'][$key] == 15)
			{
				//not between
				$exdate1 	= explode('T',$_POST['tbl_value_ntbet'][$key]);
				$fulldate1 	= $exdate1[0].''.$exdate1[1];
				$set_val1	= strtotime($fulldate1);
				
				$sqlwhere 				  .= " ".$get_column_name." not between :ex_textnb".$key." and :ex_textnb1".$key;
				$param['ex_textnb'.$key]   = $set_val;
				$param['ex_textnb1'.$key]  = $set_val1;
			}
			else if($_POST['tbl_condition'][$key] == 16)
			{
				//IN()
				$sqlwhere 				.= " ".$get_column_name." IN ( :ex_text".$key." ) ";
				$param['ex_text'.$key]  = $set_val;
			}
			else if($_POST['tbl_condition'][$key] == 17)
			{
				//NOT IN()
				$sqlwhere 				.= " ".$get_column_name." NOT IN ( :ex_text".$key." ) ";
				$param['ex_text'.$key]  = $set_val;
			}

		}
		else
		{
			// Attribute

			// $sqlselect 			= " SELECT u.* FROM mdl_user as u 
			// 						join mdl_user_attribute_mapping as m on m.user_id = u.id 
			// 						join mdl_custom_user_field_detail as a on a.id = m.attribute_id 
			// 						where ";
			// $sqlwhere  			= "u.id<>:exguest AND u.deleted <> 1 AND";


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
					//$set_cohort_name 		 = $cohort_name.'_'.$distkey;
					//$set_rule_name 			 = $rule_name.'_'.$distkey;
					
					//dynamic_attribute_cohort_creation($set_cohort_name,$param,$_POST,$sqlwhere,$set_rule_name,$sqlselect);
				}

				//$returnurl = new moodle_url('/customconfig/cohort/attribute/v1/dynamic_cohort.php');
			//	redirect($returnurl);
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
			$sqlwhere .= ' '.$_POST['toggle_value'][$key];
		}

		

	}
	$sqlgroup  = " group by u.id";
	$set_query = $sqlselect.$sqlwhere.$sqlgroup;
	$response  = $DB->get_records_sql($set_query,$param);
	 //   $response = $DB->get_records_select('user', $sqlstr, $param, 'fullname', 'id,'.$DB->sql_fullname().' AS fullname,username AS employee_code,department', 0, MAX_BULK_USERS);

    //print_r($response);
    $total_users = 0;
    $uids = array();
    if($response != null){
        $table = new html_table();
        $table->head = array('Employee Code', 'Name', 'Department');
        foreach($response as $r){
            $fullname = $r->firstname." ".$r->lastname;
            $table->data[] = array($r->employee_code,$fullname,$r->department);
            $uids[$r->id] = $r->id;
            $total_users++;
        }        
        $tablecontent = html_writer::table($table);
        $message = "No record found !";
        $status  = 1;
    }
    else{
        $tablecontent =  "No User Found";
        $message = "No User Found !";
        $status  = 0;
    }
    echo $data = json_encode(['Message'=>$message,'status'=>$status,'tablecontent'=>$tablecontent,"total_users"=>$total_users,"userIds"=>$uids]);
}else if($wsfunction == "execute_query"){
   // print_r($_POST);
    $param 	 			= array();
    $param['exguest'] 	= 1;
    $total 	 			= count($_POST['tbl_columns']);
    $tog_val 			= $total - 2;

	$sqlselect 			= " SELECT * 
								FROM user_attributes as u
								where ";

	if(is_siteadmin()){
		$sqlwhere  			= "id<>:exguest AND deleted = 0 AND (";
	}
	else
	{
		$get_branch 	= $DB->get_record_sql("SELECT attribute_value as branch FROM `mdl_user_attribute_mapping` WHERE `attribute_id` = 68 and user_id = $USER->id");

		if(empty($get_branch))
		{
			$sqlwhere  			= "id<>:exguest AND deleted = 0 AND (";
		}
		else
		{
			$sqlwhere  			= "id<>:exguest AND deleted = 0 AND Branch = '$get_branch->branch' AND (";
		}
	}


	// SELECT * FROM `user_attributes` where Grade = "Level 1" and Outlet = "DEL-ROHINI" and department LIKE 'F and B Service'

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

		// Attribute
		//SELECT u.* FROM mdl_user as u left join mdl_user_attribute_mapping as m on m.user_id = u.id left join mdl_custom_user_field_detail as a on a.id = m.attribute_id where a.field = 'grade' and m.attribute_value = 'A' and `firstname` LIKE '%s%' GROUP by u.id

		

			// Defaut

			// $sqlselect 			= "select * from mdl_user where";
			// $sqlwhere  			= "id<>:exguest AND deleted <> 1 AND";


			if($_POST['tbl_condition'][$key] == 1)
			{
				//contains
				$sqlwhere 				.= " `".$get_column_name."` LIKE :ex_text".$key;
				$param['ex_text'.$key]  = "%".$set_val."%";
			}
			else if($_POST['tbl_condition'][$key] == 2)
			{
				//doesn't contain
				$sqlwhere 				.= " `".$get_column_name."` NOT LIKE :ex_text".$key;
				$param['ex_text'.$key]  = "%".$set_val."%";
			}
			else if($_POST['tbl_condition'][$key] == 3)
			{
				//is equal to
				$sqlwhere 				.= " `".$get_column_name."` LIKE :ex_text".$key;
				$param['ex_text'.$key]  = $set_val;
			}
			else if($_POST['tbl_condition'][$key] == 4)
			{
				//starts with
				$sqlwhere 				.= " `".$get_column_name."` LIKE :ex_text".$key;
				$param['ex_text'.$key]  = $set_val."%";
			}
			else if($_POST['tbl_condition'][$key] == 5)
			{
				//ends with
				$sqlwhere 				.= " `".$get_column_name."` LIKE :ex_text".$key;
				$param['ex_text'.$key]  = "%".$set_val;
			}
			else if($_POST['tbl_condition'][$key] == 6)
			{
				//is empty
				$sqlwhere 				.= " `".$get_column_name."` = :ex_text".$key;
				$param['ex_text'.$key]  = "";
			}
			else if($_POST['tbl_condition'][$key] == 7)
			{
				//distinct
				$dist_sql 			  = "select distinct `".$get_column_name."` from user_attributes where id <> 1 and deleted = 0";
				$get_distinct_records = $DB->get_records_sql($dist_sql);
				$sqlwhere 			 .= " `".$get_column_name."` LIKE :ex_text".$key;

				foreach ($get_distinct_records as $distkey => $distvalue) {
					$param['ex_text'.$key]   = $distkey;
					// $set_cohort_name 		 = $cohort_name.'_'.$distkey;
					// $set_rule_name 			 = $rule_name.'_'.$distkey;
					
					// dynamic_attribute_cohort_creation($set_cohort_name,$param,$_POST,$sqlwhere,$set_rule_name,$sqlselect);
				}

				// $returnurl = new moodle_url('/customconfig/cohort/attribute/v1/dynamic_cohort.php');
				// redirect($returnurl);
			}
			else if($_POST['tbl_condition'][$key] == 8)
			{
				//is not empty
				$sqlwhere 				.= " `".$get_column_name."` != :ex_text".$key;
				$param['ex_text'.$key]  = "";
			}
			else if($_POST['tbl_condition'][$key] == 9)
			{
				//less than
				$sqlwhere 				.= " `".$get_column_name."` < :ex_text".$key;
				$param['ex_text'.$key]  = $set_val;
			}
			else if($_POST['tbl_condition'][$key] == 10)
			{
				//greater than
				$sqlwhere 				.= " `".$get_column_name."` > :ex_text".$key;
				$param['ex_text'.$key]  = $set_val;
			}
			else if($_POST['tbl_condition'][$key] == 11)
			{
				//less & equals to
				$sqlwhere 				.= " `".$get_column_name."` <= :ex_text".$key;
				$param['ex_text'.$key]  = $set_val;
			}
			else if($_POST['tbl_condition'][$key] == 12)
			{
				//greater & equals to
				$sqlwhere 				.= " `".$get_column_name."` >= :ex_text".$key;
				$param['ex_text'.$key]  = $set_val;
			}
			else if($_POST['tbl_condition'][$key] == 13)
			{
				//not equals to
				$sqlwhere 				.= " `".$get_column_name."` != :ex_text".$key;
				$param['ex_text'.$key]  = $set_val;
			}
			else if($_POST['tbl_condition'][$key] == 14)
			{
				//between
				$exdate1 	= explode('T',$_POST['tbl_value_bet'][$key]);
				$fulldate1 	= $exdate1[0].''.$exdate1[1];
				$set_val1	= strtotime($fulldate1);

				$sqlwhere 				 .= " `".$get_column_name."` between :ex_textb".$key." and :ex_textb1".$key;
				$param['ex_textb'.$key]   = $set_val;
				$param['ex_textb1'.$key]  = $set_val1;

			}
			else if($_POST['tbl_condition'][$key] == 15)
			{
				//not between
				$exdate1 	= explode('T',$_POST['tbl_value_ntbet'][$key]);
				$fulldate1 	= $exdate1[0].''.$exdate1[1];
				$set_val1	= strtotime($fulldate1);
				
				$sqlwhere 				  .= " `".$get_column_name."` not between :ex_textnb".$key." and :ex_textnb1".$key;
				$param['ex_textnb'.$key]   = $set_val;
				$param['ex_textnb1'.$key]  = $set_val1;
			}
			else if($_POST['tbl_condition'][$key] == 16)
			{
				//IN()
				$sqlwhere 				.= " `".$get_column_name."` IN ( :ex_text".$key." ) ";
				$param['ex_text'.$key]  = $set_val;
			}
			else if($_POST['tbl_condition'][$key] == 17)
			{
				//NOT IN()
				$sqlwhere 				.= " `".$get_column_name."` NOT IN ( :ex_text".$key." ) ";
				$param['ex_text'.$key]  = $set_val;
			}

		


		if($total > 1 && $key <= $tog_val)
		{
			$sqlwhere .= ' '.$_POST['toggle_value'][$key];
		}

		

	}

	$sqlgroup  = " ) group by u.id";
	$set_query = $sqlselect.$sqlwhere.$sqlgroup;

	// echo $set_query; print_r($param); //exit();

	$response  = $DB->get_records_sql($set_query,$param);
	 //   $response = $DB->get_records_select('user', $sqlstr, $param, 'fullname', 'id,'.$DB->sql_fullname().' AS fullname,username AS employee_code,department', 0, MAX_BULK_USERS);

    // print_r($response);
    $total_users = 0;
    $uids = array();
    if($response != null){
        $table = new html_table();
        $table->head = array('Employee Code', 'Name', 'Department');
        foreach($response as $r){
            $fullname = $r->firstname." ".$r->lastname;
            $table->data[] = array($r->employee_code,$fullname,$r->department);
            $uids[$r->id] = $r->id;
            $total_users++;
        }        
        $tablecontent = html_writer::table($table);
        $message = "No record found !";
        $status  = 1;
    }
    else{
        $tablecontent =  "No User Found";
        $message = "No User Found !";
        $status  = 0;
    }
    echo $data = json_encode(['Message'=>$message,'status'=>$status,'tablecontent'=>$tablecontent,"total_users"=>$total_users,"userIds"=>$uids]);
}else{
	echo $data = json_encode(['Message'=>'Function Name Parameter wsfunction is missing']);
}
