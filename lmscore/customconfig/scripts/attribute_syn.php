<?php

/**
 * @author        Suniti Yadav
 * @description   Syn Attribute from portal to LMS in mdl_custom_user_field_detail & mdl_custom_user_field_detail_condition
 */

$base = __DIR__ . '/../../';
define('CLI_SCRIPT', true);
require_once $base.'config.php';

define('MAX_BULK_USERS', 2000);
date_default_timezone_set("Asia/Kolkata");

error_reporting(E_ALL | E_STRICT); 
ini_set('display_errors', '1'); 
$CFG->debug = (E_ALL | E_STRICT); 
$CFG->debugdisplay = 1;
$CFG->debugdeveloper= 1;

$curl = curl_init();

curl_setopt_array($curl, array(
  CURLOPT_URL => "https://mservices.zinghr.com/common/api/v1/LMSIntegration/LoadAttributes?CompanyCode=".$CFG->dbname,
  CURLOPT_RETURNTRANSFER => true,
  CURLOPT_ENCODING => "",
  CURLOPT_MAXREDIRS => 10,
  CURLOPT_TIMEOUT => 0,
  CURLOPT_FOLLOWLOCATION => true,
  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
  CURLOPT_CUSTOMREQUEST => "GET",
));

$response = curl_exec($curl);
curl_close($curl); // echo $response;

$jsonResponse = json_decode($response, true); // echo"<pre>"; print_r($jsonResponse); exit();

$total_count = count($jsonResponse['data']);
$insert_count = 0;
$delete_count = 0;
$update_count = 0;

$total_data  = "";
$insert_data = "";
$delete_data = "";
$update_data = "";

if($jsonResponse['code'] > 0)
{
	foreach ($jsonResponse['data'] as $key => $value) {
		// print_r($value['attributeTypeId']); exit();

		$total_data .= "attribute name - ".$value['attributeTypeCode'];
		$total_data .= "<br>";

		// check whether its present or not in 'mdl_custom_user_field_detail'
		$query_fetch = $DB->get_record_sql("SELECT * FROM `mdl_custom_user_field_detail` WHERE field = ?",array('field' => $value['attributeTypeCode']));

		// If not then add it
		if(empty($query_fetch))
		{
			// Add in attribute table
			$res = $DB->execute("INSERT INTO `mdl_custom_user_field_detail` (`field`, `attributeTypeId`, `attributeTypeUnitID`, `attributeTypeUnitCode`, `attributeTypeDescription`, `attributeTypeUnitDescription`) VALUES (?,?,?,?,?,?)", array('field' => $value['attributeTypeCode'], 'attributeTypeId' => $value['attributeTypeId'], 'attributeTypeUnitID' => $value['attributeTypeUnitID'], 'attributeTypeUnitCode' => $value['attributeTypeUnitCode'], 'attributeTypeDescription' => $value['attributeTypeDescription'], 'attributeTypeUnitDescription' => $value['attributeTypeUnitDescription']));
			//print_r($res); exit();
			$insert_count++;

			$insert_data .= "attribute name - ".$value['attributeTypeCode'];
	        $insert_data .= "<br>";

			if($res)
			{
				// get attribute id
				$query_fetch_id = $DB->get_record_sql("SELECT id FROM `mdl_custom_user_field_detail` WHERE field = ?",array('field' => $value['attributeTypeCode']));

				// Add in attribute condition table
				$sql = "INSERT INTO `mdl_custom_user_field_detail_condition` (`field_id`, `condition_id`) VALUES ('".$query_fetch_id->id."', '1'),('".$query_fetch_id->id."', '2'),('".$query_fetch_id->id."', '3'),('".$query_fetch_id->id."', '4'),('".$query_fetch_id->id."', '5'),('".$query_fetch_id->id."', '6'),('".$query_fetch_id->id."', '7'),('".$query_fetch_id->id."', '8')";
				$DB->execute($sql);

			}

		}

	}
	echo "executed properly";
}
else
{
    echo "No data found";
}
//echo $total_data;

$query_fetch_ud = $DB->get_records_sql("SELECT * FROM `mdl_custom_user_field_detail` WHERE id > 65 ");

// print_r(count($query_fetch_ud));
// exit();

if(!empty($query_fetch_ud))
{
	// DROP VIEW
	$DB->execute("DROP VIEW IF EXISTS user_attributes");

	$view_text = "create view user_attributes as(
	SELECT u.*,";

	$data_count = (count($query_fetch_ud) - 1);
	//print_r($data_count);
	$count_f = 0;
	foreach ($query_fetch_ud as $key1 => $value1) {
		$fetch_attr = $DB->get_record_sql("SELECT * FROM mdl_custom_user_field_detail where field = ? and is_default = ?", array('field' => $value1->field , 'is_default' => '0'));

		if(!empty($fetch_attr))
		{
			$view_text .= "(select attribute_value from mdl_user_attribute_mapping where attribute_id = ".$value1->id." and user_id = u.id) as '".$value1->field."'";
			//print_r($count_f);

			if($data_count != $count_f)
			{
				$view_text .= ",";
			}
		}
		$count_f++;
	}
	//exit();

	$view_text .= "FROM mdl_user as u 
	left join mdl_user_attribute_mapping as m on m.user_id = u.id 
	where u.deleted = 0
	group by u.id
	)";

	$DB->execute($view_text);
}


$rec_insert1 			    = new stdClass();
$rec_insert1->name  	    = "Attribute master Syn (V1)";
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
