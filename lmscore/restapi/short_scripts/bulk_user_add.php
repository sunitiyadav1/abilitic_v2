<?php

// This file is part of Moodle - http://moodle.org/
//
// Moodle is free software: you can redistribute it and/or modify
// it under the terms of the GNU General Public License as published by
// the Free Software Foundation, either version 3 of the License, or
// (at your option) any later version.
//
// Moodle is distributed in the hope that it will be useful,
// but WITHOUT ANY WARRANTY; without even the implied warranty of
// MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
// GNU General Public License for more details.
//
// You should have received a copy of the GNU General Public License
// along with Moodle.  If not, see <http://www.gnu.org/licenses/>.
/**
 * Version details
 *
 * @package    local_lingk
 * @copyright  (C) 2018 Lingk Inc (http://www.lingk.io)
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
$base = __DIR__ . '/../';
define('CLI_SCRIPT', true);
require_once $base.'config.php';

//require_once '../config.php';

$data = array (
  'SubscriptionName' => 'bmai',
  'Token' => 'f6f0471fcc5149feb428107015280343',
  "Fromdate" => date('d-m-Y',strtotime("-1 days")), //"01-05-2018",
  "Todate" => date('d-m-Y') //"15-05-2018"
);
//print_r($data); //exit();

$bodyData = json_encode($data); //print_r($bodyData); exit();

$url = "https://portal.zinghr.ae/2015/route/EmployeeDetails/GetEmployeeBasicDetails";

$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, $url);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
curl_setopt($ch, CURLOPT_HTTPHEADER, array(
'Content-Type: application/json',
'Content-Length: '.strlen($bodyData)));
curl_setopt($ch, CURLOPT_POST, 1);
curl_setopt($ch, CURLOPT_POSTFIELDS, $bodyData);

$result = curl_exec($ch); // echo"<pre>";  print_r($result); //exit();

$jsonResponse = json_decode($result, true); 
//print_r(count($jsonResponse['Employees'])); //exit();
//echo"<pre>"; print_r($jsonResponse); //exit();

$count = count($jsonResponse['Employees']);
$count_insert   = 0;
$count_update   = 0;
$count_delete   = 0;
$insert_records = '';
$update_records = '';
$delete_records = '';

if(count($jsonResponse['Employees']) > 0)
{
    foreach (array_chunk($jsonResponse['Employees'],50) as $mainkey => $mainvalue) {
        foreach ($mainvalue as $key => $value) {
        
            $user_record  = new stdClass();
            $user_record->firstname  = isset($value['FirstName']) ? $value['FirstName'].' '.$value['LastName'] : ''; 
            // $user_record->lastname   = isset($value['LastName']) ? $value['LastName'] : $value['EmployeeCode']; 
            $user_record->lastname   = $value['EmployeeCode']; 
            //$user_record->email      = isset($value['Email']) ? $value['Email'].$value['EmployeeCode'] : ''; 
            $user_record->email      = (isset($value['Email']) && !empty($value['Email'])) ? $value['Email'] : 'support@bma.ae_'.$value['EmployeeCode']; 
            $user_record->username   = isset($value['Email']) ? $value['Email'].$value['EmployeeCode'] : $value['EmployeeCode']; 

            $bulk_record = new stdClass();
            $bulk_record->employee_code = isset($value['EmployeeCode']) ? $value['EmployeeCode'] : '';
            $bulk_record->gender        = isset($value['Gender'] ) ? $value['Gender']  : '';
            $bulk_record->dob           = isset($value['DateofBirth'] ) ? $value['DateofBirth'] : '';
            $bulk_record->expat_flag    = isset($value['EmpFlag'] ) ? $value['EmpFlag'] : '';    
            $bulk_record->company_code  = "bmai";
            $bulk_record->date_of_joining =  isset($value['DateOfJoining'] ) ? $value['DateOfJoining'] : '';
            $bulk_record->date_of_confirmation = isset($value['Dateofconfirmation'] ) ? $value['Dateofconfirmation'] : '';
            $bulk_record->date_of_leaving = isset($value['DateOfLeaving'] ) ? $value['DateOfLeaving'] : '';
            $bulk_record->reporting_manager_code = isset($value['ReportingManagerCode'] ) ? $value['ReportingManagerCode'] : '';
            $bulk_record->reporting_manager_name = isset($value['ReportingManagerName'] ) ? $value['ReportingManagerName'] : '';
            $bulk_record->father_name   = isset($value['FatherName'] ) ? $value['FatherName'] : '';
            $bulk_record->mobile        = isset($value['Mobile'] ) ? $value['Mobile'] : '';   
            $bulk_record->employement_type  = isset($value['EmploymentType'] ) ? $value['EmploymentType'] : '';
            $bulk_record->employee_status  = isset($value['EmployeeStatus'] ) ? $value['EmployeeStatus'] : 'Existing';
            // $bulk_record->emp_group  = 'BMA INTERNATIONAL';
            
            $status = isset($value['EmployeeStatus']) ? $value['EmployeeStatus'] : '';

            foreach ($value['Attributes'] as $attkey => $attvalue) {

                if($attvalue['AttributeTypeID'] == '1095')
                {
                  $bulk_record->emp_group = $attvalue['AttributeTypeUnitDesc'];
                }

                if($attvalue['AttributeTypeID'] == '1096')
                {
                  $user_record->country = $attvalue['AttributeTypeUnitDesc'];
                }

                if($attvalue['AttributeTypeID'] == '1097')
                {
                  $bulk_record->concept      = $attvalue['AttributeTypeUnitDesc'];
                  $bulk_record->concept_code = $attvalue['AttributeTypeUnitCode'];
                }

                if($attvalue['AttributeTypeID'] == '1098')
                {
                  $bulk_record->legal_entity = $attvalue['AttributeTypeUnitDesc'];
                }

                if($attvalue['AttributeTypeID'] == '1099')
                {
                  $bulk_record->work_location      = $attvalue['AttributeTypeUnitDesc'];
                  $bulk_record->work_location_code = $attvalue['AttributeTypeUnitCode'];
                }

                if($attvalue['AttributeTypeID'] == '1100')
                {
                  $user_record->department = $attvalue['AttributeTypeUnitDesc'];
                }

                if($attvalue['AttributeTypeID'] == '1101')
                {
                  $bulk_record->subdepartment = $attvalue['AttributeTypeUnitDesc'];
                }

                if($attvalue['AttributeTypeID'] == '1105')
                {
                  $bulk_record->designation = $attvalue['AttributeTypeUnitDesc'];
                }

                if($attvalue['AttributeTypeID'] == '1106')
                {
                  $bulk_record->Ethnicity = $attvalue['AttributeTypeUnitDesc'];
                }

                if($attvalue['AttributeTypeID'] == '1113')
                {
                  $bulk_record->region = $attvalue['AttributeTypeUnitDesc'];
                }

                if($attvalue['AttributeTypeID'] == '1118')
                {
                  $bulk_record->area = $attvalue['AttributeTypeUnitDesc'];
                }
            }

            //print_r($bulk_record); print_r($user_record); exit();

            if($status == 'Existing' || $status == 'NewJoinee' || $status == 'Hold')
            {

              $query_fetch_user = $DB->get_record_sql('SELECT u.id, ub.id as bulk_id, ub.user_id as userid FROM mdl_user as u left join `mdl_user_bulk` as ub on u.id = ub.user_id  WHERE employee_code = ? ',array( $value['EmployeeCode'] ) );

              if(!empty($query_fetch_user))
              {
                $user_record->id = $query_fetch_user->id; //print_r($user_record); exit();
                $up_user = $DB->update_record('user', $user_record);
                //print_r($up_user); exit();

                $update_records .= " User Id : ".$query_fetch_user->id;
                $update_records .= " User Email : ".$user_record->email;
                $update_records .= " User EmployeeCode : ".$value['EmployeeCode'];
              
                //get manager's details
                $query_manager = $DB->get_record_sql('SELECT u.id,u.email,ub.manager_id FROM `mdl_user` as u join `mdl_user_bulk` as ub on u.id = ub.user_id WHERE ub.employee_code = ?',array( $value['ReportingManagerCode']) ); 
                //print_r($query_manager); //exit();
                $query_manager_value = isset($query_manager->email)?$query_manager->email:'nikhil.mishra@zinghr.com';

                $query_cust  = $DB->get_record_sql('SELECT * FROM `mdl_user_info_data` where userid = ? and fieldid = ?', array('userid' => $query_fetch_user->id, 'fieldid' => 7) );
                //print_r($query_cust); //exit();

                if(!empty($query_manager)){
                  $bulk_record->manager_id            = $query_manager->id ;
                  $bulk_record->managersemail         = $query_manager_value;
                  $bulk_record->reporting_manager_id  = $query_manager->manager_id;
                }


                if(!empty($query_fetch_user->userid)){
                  $bulk_record->id = $query_fetch_user->bulk_id;
                  $DB->update_record('user_bulk', $bulk_record);
                  //echo 'Data updated Successfully';
                }
                else
                {
                  $bulk_record->user_id = $query_fetch_user->id; 
                  $DB->insert_record('user_bulk',$bulk_record,true);
                  //echo 'Data inserted Successfully';

                  /* generate token */

                  $ch = curl_init();  
                  curl_setopt($ch,CURLOPT_URL,"https://learn.zinghr.com/bmai/login/token.php?username=".$user_record->username."&password=Test@123&service=moodle_mobile_app");
                  curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                  curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true); 
                  curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false); 
                  $output=curl_exec($ch);
                  //$result = json_decode($output, true);

                }

                $cust_record = new stdClass();
                $cust_record->userid      = $query_fetch_user->id;
                $cust_record->fieldid     = 7;
                $cust_record->data        = $query_manager_value;

                if(empty($query_cust))
                {
                    $DB->insert_record('user_info_data',$cust_record,true);
                }
                else
                {
                    $cust_record->id      = $query_cust->id;
                    $DB->update_record('user_info_data',$cust_record,true);
                }

                $update_records .= " User Manager : ".$query_manager_value;
                $update_records .= "----------------------";
                $count_update++;

              }
              else
              {
                 $password                = "Test@123"; //$value['FirstName']."@123";
                 $user_record->password   = md5($password); 
                 $user_record->confirmed  = 1;
                 $user_record->mnethostid = 1;
                 $user_record->is_mandatory_completed = 0;

                 $userid = $DB->insert_record('user',$user_record,true);
                 $bulk_record->user_id = $userid; 

                 $query_manager = $DB->get_record_sql('SELECT u.id,u.email,ub.manager_id FROM `mdl_user` as u join `mdl_user_bulk` as ub on u.id = ub.user_id WHERE ub.employee_code = ?',array( $value['ReportingManagerCode']) ); 
                      //print_r($query_manager); exit();

                  if(!empty($query_manager)){
                    $bulk_record->manager_id            = $query_manager->id ;
                    //$bulk_record->managersemail         = $query_manager->email;
                    $bulk_record->managersemail         = isset($query_manager->email)?$query_manager->email:'nikhil.mishra@zinghr.com';
                    $bulk_record->reporting_manager_id  = $query_manager->manager_id;
                  }

                  $DB->insert_record('user_bulk',$bulk_record,true);
                  $count_insert++;

                  /* generate token */

                  $ch = curl_init();  
                  curl_setopt($ch,CURLOPT_URL,"https://learn.zinghr.com/bmai/login/token.php?username=".$user_record->username."&password=Test@123&service=moodle_mobile_app");
                  curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                  curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true); 
                  curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false); 
                  $output=curl_exec($ch);
                  //$result = json_decode($output, true);
                        
                  $query_manager_value = isset($query_manager->email)?$query_manager->email:'nikhil.mishra@zinghr.com';
                  $query_cust  = $DB->get_record_sql('SELECT * FROM `mdl_user_info_data` where userid = ? and fieldid = ?', array('userid' => $userid, 'fieldid' => 7) );

                  $cust_record = new stdClass();
                  $cust_record->userid      = $userid;
                  $cust_record->fieldid     = 7;
                  $cust_record->data        = $query_manager_value;

                  if(empty($query_cust))
                  {
                      $DB->insert_record('user_info_data',$cust_record,true);
                  }
                  else
                  {
                      $cust_record->id      = $query_cust->id;
                      $DB->update_record('user_info_data',$cust_record,true);
                  }

                  $insert_records .= " User Id : ".$userid;
                  $insert_records .= " User Email : ".$user_record->email;
                  $insert_records .= " User EmployeeCode : ".$bulk_record->employee_code;
                  $insert_records .= " User Manager : ".$query_manager_value;
                  $insert_records .= "----------------------";
              }

            }
            else if($status == 'FnF Initiated' || $status == 'FnF Locked' || $status == 'FnFInitiated' || $status == 'FnFLocked')
            {
                $query_fetch_user = $DB->get_record_sql('SELECT u.id, ub.id as bulk_id, ub.user_id as userid FROM mdl_user as u left join `mdl_user_bulk` as ub on u.id = ub.user_id  WHERE employee_code = ? ',array( $value['EmployeeCode'] ) );

                if(!empty($query_fetch_user))
                {
                    $user_record->id = $query_fetch_user->id; 
                    $user_record->deleted = 1;
                    $up_user = $DB->update_record('user', $user_record);
                    $count_delete++;
                    $delete_records .= " User Id : ".$query_fetch_user->id;
                    $delete_records .= " User EmployeeCode : ".$value['EmployeeCode'];
                    $delete_records .= "----------------------";
                }
            }else{
               echo 'Status must be update/new/delete - '.$status;
            }

        } 
    }
}

// echo "total insert";
// print_r($count_insert);
// echo " <br>total update";
// print_r($count_update);
// echo " <br>total delete";
// print_r($count_delete);

$cron_record = new stdClass();
$cron_record->name          = "User Bulk data upload"; 
$cron_record->cron_job_time = date('Y-m-d h:i:s');
$cron_record->updated_till  = date('Y-m-d h:i:s',strtotime("-1 days"));
$cron_record->no_of_records = $count;
$cron_record->insert_count  = $count_insert;
$cron_record->update_count  = $count_update;
$cron_record->delete_count  = $count_delete;
$cron_record->inserted_record   = $insert_records;
$cron_record->updated_record    = $update_records;
$cron_record->deleted_records   = $delete_records;

$sql = "INSERT INTO mdl_custom_cron(name, cron_job_time, updated_till, no_of_records, inserted_record, insert_count, updated_record, update_count, deleted_records, delete_count) VALUES ('".$cron_record->name."','".$cron_record->cron_job_time."','".$cron_record->updated_till."',".$cron_record->no_of_records.",'".$cron_record->inserted_record."',".$cron_record->insert_count.",'".$cron_record->updated_record."',".$cron_record->update_count.",'".$cron_record->deleted_records."',".$cron_record->delete_count.")";
//echo $sql; exit();
$DB->execute($sql);

//$DB->insert_record('custom_cron',$cron_record,true);

?>