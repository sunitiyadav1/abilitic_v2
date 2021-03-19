<?php

require_once('../../../../config.php');
require_login(); // We need login
global $DB;

//Set time zone
date_default_timezone_set('Asia/Kolkata');

$wsfunction = $_POST['wsfunction'];

if($wsfunction == "get_condition"){

	$field_id  	= $_POST['tbl_columns_id'];
	$data 		= array();
	
	if($field_id)
	{
		try {
			
			$get_response = $DB->get_records_sql("SELECT c.*,dc.id as mapping_id FROM `mdl_custom_user_field_detail_condition` AS dc join mdl_custom_user_field_condition as c on dc.condition_id = c.id WHERE dc.field_id = ?", array('field_id' => $field_id));
			
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
}else if($wsfunction == "get_disitnct_values"){

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
}else{
	echo $data = json_encode(['Message'=>'Function Name Parameter wsfunction is missing']);
}

?>