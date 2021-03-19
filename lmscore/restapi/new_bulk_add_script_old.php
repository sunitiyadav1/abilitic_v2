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

$data = array (
  'SubscriptionName' => $CFG->dbname, // 'abilitic',
  'Token' => $CFG->api_token, // '6c771e7a8524403585659a42360ff6b2',
  "Fromdate" => date('d-m-Y',strtotime("-2 days")), //"01-05-2018",
  "Todate" => date('d-m-Y') //"15-05-2018"
  //"EmployeeCode" => 'DMC0016'
);

$bodyData = json_encode($data); 
$url = "https://portal.zinghr.com/2015/route/EmployeeDetails/GetEmployeeBasicDetails";

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
//print_r(count($jsonResponse['Employees'])); exit();
// echo"<pre>"; print_r($jsonResponse); exit();

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
          $user_record->lastname      = (isset($value['LastName']) && !empty($value['LastName']))?$value['LastName']:$value['MiddleName']; 
        //$user_record->lastname      = $value['EmployeeCode']; 
        $user_record->email         = (isset($value['Email']) && !empty($value['Email'])) ? $value['Email'] : 'support@'.$value['EmployeeCode'].'.com'; 
        $user_record->username      = $value['EmployeeCode']; 
        $user_record->employee_code = isset($value['EmployeeCode']) ? $value['EmployeeCode'] : 'NULL';
        $user_record->gender        = isset($value['Gender'] ) ? $value['Gender']  : 'MALE';
        $user_record->dob           = isset($value['DateofBirth'] ) ? trim($value['DateofBirth']," ") : 'NULL';
        $user_record->company_code  = "datametica";
        $user_record->date_of_joining =  isset($value['DateOfJoining'] ) ? $value['DateOfJoining'] : 'NULL';
        $user_record->date_of_confirmation = isset($value['Dateofconfirmation'] ) ? $value['Dateofconfirmation'] : 'NULL';
        $user_record->date_of_leaving = (isset($value['DateOfLeaving'] ) && !empty($value['DateOfLeaving']))? $value['DateOfLeaving'] : 'NULL';
        $user_record->reporting_manager_code = isset($value['ReportingManagerCode'] ) ? $value['ReportingManagerCode'] : 'NULL';
        $user_record->reporting_manager_name = isset($value['ReportingManagerName'] ) ? $value['ReportingManagerName'] : 'NULL';
        $user_record->mobile        = isset($value['Mobile'] ) ? $value['Mobile'] : 'NULL';   
        $user_record->employement_type  = isset($value['EmploymentType'] ) ? $value['EmploymentType'] : 'NULL';
        $user_record->employee_status  = isset($value['EmployeeStatus'] ) ? $value['EmployeeStatus'] : 'Existing';
        $user_record->emp_group     = 'Common'; //Employee Group- 30
        $user_record->location      = 'NULL'; //Location - 42
        $user_record->work_location = 'NULL'; 
        $user_record->department    = 'NULL'; 
        $user_record->designation   = 'NULL'; // Designation - 49
        $user_record->region        = 'NULL'; 

        
        $status = isset($value['EmployeeStatus']) ? $value['EmployeeStatus'] : '';

        foreach ($value['Attributes'] as $attkey => $attvalue) {

            if($attvalue['AttributeTypeID'] == '30')
            {
              $user_record->emp_group = $attvalue['AttributeTypeUnitDesc'];
            }

            if($attvalue['AttributeTypeID'] == '42')
            {
              $user_record->location = $attvalue['AttributeTypeUnitDesc'];
            }

            // if($attvalue['AttributeTypeID'] == '43')
            // {
            //   $user_record->work_location      = $attvalue['AttributeTypeUnitDesc'];
            // }

            // if($attvalue['AttributeTypeID'] == '44')
            // {
            //   $user_record->department = $attvalue['AttributeTypeUnitDesc'];
            // }

            if($attvalue['AttributeTypeID'] == '49')
            {
              $user_record->designation = $attvalue['AttributeTypeUnitDesc'];
            }

            // if($attvalue['AttributeTypeID'] == '51')
            // {
            //   $user_record->region = $attvalue['AttributeTypeUnitDesc'];
            // }
            
        }

        //print_r($user_record); exit();

        if($status == 'Existing' || $status == 'NewJoinee' || $status == 'Hold')
        {

          $q = "SELECT id FROM mdl_user WHERE username = '".$value['EmployeeCode']."'";
          $query_fetch_user = $DB->get_record_sql($q);
          //print_r($query_fetch_user); //exit();

          if(!empty($query_fetch_user))
          {
              $user_record->id = $query_fetch_user->id; 
           
              $sql_upd = 'UPDATE mdl_user SET firstname ="'.$user_record->firstname.'", lastname = "'.$user_record->lastname.'", email = "'.$user_record->email.'", username = "'.$user_record->username.'", department = "'.$user_record->department.'", employee_code ="'.$user_record->employee_code.'", gender = "'.$user_record->gender.'", dob = "'.$user_record->dob.'", company_code = "'.$user_record->company_code.'",date_of_joining ="'.$user_record->date_of_joining.'", date_of_confirmation = "'.$user_record->date_of_confirmation.'", date_of_leaving = "'.$user_record->date_of_leaving.'", reporting_manager_code = "'.$user_record->reporting_manager_code.'", reporting_manager_name = "'.$user_record->reporting_manager_name.'", mobile = "'.$user_record->mobile.'", employement_type = "'.$user_record->employement_type.'", employee_status = "'.$user_record->employee_status.'", emp_group = "'.$user_record->emp_group.'", work_location = "'.$user_record->work_location.'", designation = "'.$user_record->designation.'", location = "'.$user_record->location.'",region ="'.$user_record->region.'",deleted = 0 WHERE id = '.$user_record->id;
                
                //echo "upd". $sql_upd; //exit();

                if($user_record->employee_code != "ETEST")
                {
                  $DB->execute($sql_upd);
                }
                //echo"---".$query_fetch_user->id;
                $update_records .= " User Id : ".$query_fetch_user->id;
                $update_records .= " User Email : ".$user_record->email;
                $update_records .= " User EmployeeCode : ".$value['EmployeeCode'];
          }
          else
          {
              $password                = "Test@123"; //$value['FirstName']."@123";
              $user_record->password   = md5($password); 
              $user_record->confirmed  = 1;
              $user_record->mnethostid = 1;
              $user_record->is_mandatory_completed = 0;

              $sql = "INSERT INTO mdl_user(firstname,lastname,username,email,department,password,confirmed,mnethostid,is_mandatory_completed,employee_code,gender,dob,company_code,date_of_joining,date_of_confirmation,date_of_leaving,reporting_manager_code,reporting_manager_name,mobile,employement_type,employee_status,emp_group,work_location,designation,region) VALUES (\"".$user_record->firstname."\",\"".$user_record->lastname."\",\"".$user_record->username."\",\"".$user_record->email."\",\"".$user_record->department."\",\"".$user_record->password."\",\"".$user_record->confirmed."\",\"".$user_record->mnethostid."\",\"".$user_record->is_mandatory_completed."\",\"".$user_record->employee_code."\",\"".$user_record->gender."\",\"".$user_record->dob."\",\"".$user_record->company_code."\",\"".$user_record->date_of_joining."\",\"".$user_record->date_of_confirmation."\",\"".$user_record->date_of_leaving."\",\"".$user_record->reporting_manager_code."\",\"".$user_record->reporting_manager_name."\",\"".$user_record->mobile."\",\"".$user_record->employement_type."\",\"".$user_record->employee_status."\",\"".$user_record->emp_group."\",\"".$user_record->work_location."\",\"".$user_record->designation."\",\"".$user_record->region."\")";
              
              //echo $sql; //exit();
              $DB->execute($sql);

              $count_insert++;

              /* generate token */

              $ch = curl_init();  
              curl_setopt($ch,CURLOPT_URL,"https://learn2.zinghr.com/datametica/lms/login/token.php?username=".$user_record->username."&password=Test@123&service=moodle_mobile_app");
              curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
              curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true); 
              curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false); 
              $output=curl_exec($ch);
              //$result = json_decode($output, true);
              $insert_records .= " User Email : ".$user_record->email;
              $insert_records .= " User EmployeeCode : ".$user_record->employee_code;
              $insert_records .= "----------------------";
          }

        }
        else if($status == 'FnF Initiated' || $status == 'FnF Locked' || $status == 'FnF InProcess' || $status == 'FnFInitiated' || $status == 'FnFLocked')
        {
          //echo "fnf";

            $q = "SELECT id,deleted FROM mdl_user WHERE employee_code = '".$value['EmployeeCode']."'";
            $query_fetch_user = $DB->get_record_sql($q);
            //print_r($query_fetch_user);

            if(!empty($query_fetch_user) && $query_fetch_user->deleted == 0)
            {
                $up_user_record  = new stdClass();
                $up_user_record->id      = $query_fetch_user->id; 
                $up_user_record->deleted = 1;
                $up_user_record->employee_status = $status;
                $up_user = $DB->update_record('user', $up_user_record);
                //print_r($up_user);

                $count_delete++;
                $delete_records .= " User Id : ".$query_fetch_user->id;
                $delete_records .= " User EmployeeCode : ".$value['EmployeeCode'];
                $delete_records .= "----------------------";
            }
        }
        else
        {
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

print_r($count);

$cron_record = new stdClass();
$cron_record->name          = "New User Bulk data upload"; 
$cron_record->cron_job_time = date('Y-m-d h:i:s');
$cron_record->updated_till  = date('Y-m-d h:i:s',strtotime("-1 days"));
$cron_record->no_of_records = isset($count)?$count:0;
$cron_record->insert_count  = isset($count_insert)?$count_insert:0;
$cron_record->update_count  = isset($count_update)?$count_update:0;
$cron_record->delete_count  = isset($count_delete)?$count_delete:0;
$cron_record->inserted_record   = isset($insert_records)?$insert_records:'0';
$cron_record->updated_record    = isset($update_records)?$update_records:'0';
$cron_record->deleted_records   = isset($delete_records)?$delete_records:'0';

$sql = "INSERT INTO mdl_custom_cron(name, cron_job_time, updated_till, no_of_records, inserted_record, insert_count, updated_record, update_count, deleted_records, delete_count) VALUES ('".$cron_record->name."','".$cron_record->cron_job_time."','".$cron_record->updated_till."',".$cron_record->no_of_records.",\"".$cron_record->inserted_record."\",".$cron_record->insert_count.",\"".$cron_record->updated_record."\",".$cron_record->update_count.",\"".$cron_record->deleted_records."\",".$cron_record->delete_count.")";
//echo $sql; //exit();

//$DB->execute($sql);

$DB->insert_record('custom_cron',$cron_record,true);

?>