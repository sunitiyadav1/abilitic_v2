<?php

/**
 * @author        Suniti Yadav
 * @description   Syn User from portal to LMS in mdl_user & mdl_user_attribute_mapping
 */

$base = __DIR__ . '/../../';
define('CLI_SCRIPT', true);
require_once $base.'config.php';

error_reporting(E_ALL | E_STRICT); 
ini_set('display_errors', '1'); 
$CFG->debug = (E_ALL | E_STRICT); 
$CFG->debugdisplay = 1;
$CFG->debugdeveloper= 1;

$pageIndex = 0;
$pageSize  = 20;
$companyCode = $CFG->dbname;
$fromDate   = date('Y-m-d',strtotime("-2 days"));
$toDate     = date('Y-m-d');

for ($i=1; $i > 0 ; $i++) {

    // $pageIndex = $pageIndex + $i;
    $pageIndex = $i;

    // For initiall setup
    $curl_url  = "https://mservices.zinghr.com/ed/api/v2/LMSIntegration/EmployeeDetails?companyCode=".$companyCode."&pageIndex=".$pageIndex."&pageSize=".$pageSize;

    // For regular  syn process -
    // $curl_url  = "https://mservices.zinghr.com/ed/api/v2/LMSIntegration/EmployeeDetails?companyCode=".$companyCode."&fromDate=".$fromDate."&toDate=".$toDate."&pageIndex=".$pageIndex."&pageSize=".$pageSize;

    $curl = curl_init();
    curl_setopt_array($curl, array(
      // CURLOPT_URL => "https://mservices.zinghr.com/ed/api/v2/LMSIntegration/EmployeeDetails?companyCode=bmai&fromDate=2020-01-01&toDate=2020-08-09&pageIndex=1&pageSize=10",
      CURLOPT_URL => $curl_url,
      CURLOPT_RETURNTRANSFER => true,
      CURLOPT_ENCODING => "",
      CURLOPT_MAXREDIRS => 10,
      CURLOPT_TIMEOUT => 0,
      CURLOPT_FOLLOWLOCATION => true,
      CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
      CURLOPT_CUSTOMREQUEST => "GET",
    ));

    $response = curl_exec($curl);

    curl_close($curl);
    // echo $response;

    $jsonResponse = json_decode($response, true); 
    // echo"<pre>"; print_r($jsonResponse); exit();

    $count = count($jsonResponse['data']);

    if ($count == 0) {
      break;
    }

    $total_count    = 0;
    $insert_count   = 0;
    $update_count   = 0;
    $delete_count   = 0;
    $total_data     = '';
    $insert_data    = '';
    $update_data    = '';
    $delete_data    = '';

    if($jsonResponse['code'] > 0)
    {
        foreach ($jsonResponse['data'] as $mainkey => $mainvalue) {
          // echo"<pre>"; print_r($mainvalue);
            $employeeCode = '';
            foreach ($mainvalue['detail'] as $dkey => $dvalue) {
              if($dkey == 'employeeCode')
              {
                $employeeCode = $dvalue;
              }
            }
            // print($employeeCode); exit();

            foreach ($mainvalue['attributes'] as $key => $value) {
              //print($employeeCode); exit();
                
                $fetch_attr = $DB->get_record_sql("SELECT m.* FROM mdl_user as u left join mdl_user_attribute_mapping as m on m.user_id = u.id left join mdl_custom_user_field_detail as a on a.id = m.attribute_id where a.field = ? and u.employee_code = ? and a.is_default = ? GROUP by u.id", array('field' => $value['attributeTypeDesc'] , 'employee_code' => $employeeCode , 'is_default' => '0'));

                if(empty($fetch_attr))
                {
                    $fetch_user = $DB->get_record_sql("SELECT u.* FROM mdl_user as u where u.employee_code = ? GROUP by u.id", array('employee_code' => $employeeCode));

                    $fetch_attr_id = $DB->get_record_sql("SELECT a.* FROM mdl_custom_user_field_detail as a where a.field = ? and a.is_default = ?", array('field' => $value['attributeTypeDesc'] , 'is_default' => '0'));

                    if($fetch_user && $fetch_attr_id)
                    {
                        // save attribute value w.r.t user_id & attribute_id
                        $amv_insert  = new stdClass();
                        $amv_insert->user_id         = $fetch_user->id;
                        $amv_insert->attribute_id    = $fetch_attr_id->id;
                        $amv_insert->attribute_value = $value['attributeTypeUnitDesc'];
                        $DB->insert_record('user_attribute_mapping', $amv_insert, true);

                        $total_count++;
                        $insert_count++;
                        $insert_data .= "User ID - ".$fetch_user->id;
                        $insert_data .= "attribute_value - ".$value['attributeTypeUnitDesc'];
                        $insert_data .= "<br>";

                        $total_data .= "User ID - ".$fetch_user->id;
                        $total_data .= "attribute_value - ".$value['attributeTypeUnitDesc'];
                        $total_data .= "<br>";
                    }
                }
                else
                {
                    if($fetch_attr->attribute_value != $value['attributeTypeUnitDesc'])
                    {
                        // update
                        $DB->execute("update mdl_user_attribute_mapping set attribute_value = ? where id = ?", array('attribute_value' => $value['attributeTypeUnitDesc'] , 'id' => $fetch_attr->id));

                        $total_count++;
                        $update_count++;
                        $update_data .= "User ID - ".$fetch_attr->user_id;
                        $update_data .= "attribute_value - ".$value['attributeTypeUnitDesc'];
                        $update_data .= "<br>";

                        $total_data .= "User ID - ".$fetch_attr->user_id;
                        $total_data .= "attribute_value - ".$value['attributeTypeUnitDesc'];
                        $total_data .= "<br>";
                    }
                }

            }

          //exit();
        }
        echo "executed properly";
    }
    else
    {
        echo "No data found";
        break;
    }
    

    $rec_insert1          = new stdClass();
    $rec_insert1->name        = "Attribute Data syn (V1)";
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

}

?>