<?php

$base = __DIR__ . '/../';
define('CLI_SCRIPT', true);
require_once $base.'config.php';

//require_once '../config.php';

error_reporting(E_ALL | E_STRICT); 
ini_set('display_errors', '1'); 
$CFG->debug = (E_ALL | E_STRICT); 
$CFG->debugdisplay = 1;
$CFG->debugdeveloper= 1;

$data = array (
  'SubscriptionName' => $CFG->dbname,
  'Token' => $CFG->api_token,
  "Fromdate" => date('d-m-Y',strtotime("-2 days")), 
  "Todate" => date('d-m-Y') 
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
$result       = curl_exec($ch); 
$jsonResponse = json_decode($result, true); 
// print($result);die;
$count = count($jsonResponse['Employees']);
$count_insert   = 0;
$count_update   = 0;
$count_delete   = 0;
$insert_records = '';
$update_records = '';
$delete_records = '';
$company_code   = $CFG->dbname;

if(count($jsonResponse['Employees']) > 0)
{
    foreach (array_chunk($jsonResponse['Employees'],50) as $mainkey => $mainvalue) {
        foreach ($mainvalue as $key => $value) {
        
            $user_record  = new stdClass();
            $user_record->firstname         = isset($value['FirstName']) ? trim($value['FirstName']) : ''; 
             $user_record->lastname         = (isset($value['LastName']) && !empty($value['LastName']))?$value['LastName']:$value['MiddleName']; 
            $user_record->email             = (isset($value['Email']) && !empty($value['Email'])) ? trim($value['Email']) : 'support@'.$CFG->dbname.'.com_'.$value['EmployeeCode']; 
            $user_record->username          = isset($value['EmployeeCode']) ? $value['EmployeeCode'] : ''; 
            $user_record->employee_code     = isset($value['EmployeeCode']) ? $value['EmployeeCode'] : '';
            $user_record->gender            = isset($value['Gender'] ) ? $value['Gender']  : '';
            $user_record->dob               = !empty($value['DateofBirth'] ) ? strtotime(trim($value['DateofBirth']," ")) : 0;
            $user_record->company_code      = $company_code;
            $user_record->date_of_joining   =  !empty($value['DateOfJoining'] ) ? strtotime($value['DateOfJoining']) : 0;
            $user_record->date_of_confirmation  = !empty($value['Dateofconfirmation'] ) ? strtotime($value['Dateofconfirmation']) : 0;
            $user_record->date_of_leaving   = !empty($value['DateOfLeaving'] ) ? strtotime($value['DateOfLeaving']) : 0;
            $user_record->reporting_manager_code = isset($value['ReportingManagerCode'] ) ? $value['ReportingManagerCode'] : '';
            $user_record->reporting_manager_name = isset($value['ReportingManagerName'] ) ? $value['ReportingManagerName'] : '';
            $user_record->phone1                 = isset($value['Mobile'] ) ? $value['Mobile'] : '';   
            $user_record->employement_type       = isset($value['EmploymentType'] ) ? $value['EmploymentType'] : '';
            $user_record->employee_status        = isset($value['EmployeeStatus'] ) ? $value['EmployeeStatus'] : 'Existing';

            $user_record->department    = ''; //department 
            $user_record->designation   = ''; //designation
            $user_record->institution   = ''; //grade
            $user_record->middlename    = ''; //middle name
            $user_record->region        = ''; //Region
            $user_record->city          = ''; 

            
            $status = isset($value['EmployeeStatus']) ? $value['EmployeeStatus'] : '';

            foreach ($value['Attributes'] as $attkey => $attvalue) {

                if($attvalue['AttributeTypeID'] == '90')
                {
                  $user_record->city = $attvalue['AttributeTypeUnitDesc'];
                }

                if($attvalue['AttributeTypeID'] == '1109')
                {
                  $user_record->region = $attvalue['AttributeTypeUnitDesc'];
                }

                 if($attvalue['AttributeTypeID'] == '42')
                {
                  $user_record->department = $attvalue['AttributeTypeUnitDesc'];
                }

                 if($attvalue['AttributeTypeID'] == '45')
                {
                  $user_record->designation = $attvalue['AttributeTypeUnitDesc'];
                }
               
            }

            if($status == 'Existing' || $status == 'NewJoinee' || $status == 'Hold')
            {
                $query_fetch_user = $DB->get_record_sql('SELECT u.id FROM mdl_user as u WHERE employee_code = ? ',array( $value['EmployeeCode'] ) );

                if(!empty($query_fetch_user))
                {
                    $user_record->id = $query_fetch_user->id;
                 
                    $sql_upd = 'UPDATE mdl_user SET firstname ="'.$user_record->firstname.'", lastname = "'.$user_record->lastname.'", email = "'.$user_record->email.'", username = "'.$user_record->username.'", department = "'.$user_record->department.'" , employee_code ="'.$user_record->employee_code.'", gender = "'.$user_record->gender.'", dob = "'.$user_record->dob.'", company_code = "'.$user_record->company_code.'",date_of_joining ="'.$user_record->date_of_joining.'", date_of_confirmation = "'.$user_record->date_of_confirmation.'", date_of_leaving = "'.$user_record->date_of_leaving.'", reporting_manager_code = "'.$user_record->reporting_manager_code.'", reporting_manager_name = "'.$user_record->reporting_manager_name.'", phone1 = "'.$user_record->phone1.'", employement_type = "'.$user_record->employement_type.'", employee_status = "'.$user_record->employee_status.'",department ="'.$user_record->department.'", designation = "'.$user_record->designation.'", institution = "'.$user_record->institution.'", middlename = "'.$user_record->middlename.'",city = "'.$user_record->city.'",region = "'.$user_record->region.'",deleted = 0 WHERE id = '.$user_record->id;
                      
                      
                    //echo "upd". $sql_upd; exit();
                    $ans = $DB->execute($sql_upd);

                    $count_update++;
                    $update_records .= " User Id : ".$query_fetch_user->id;
                    $update_records .= " User Email : ".$user_record->email;
                    $update_records .= " User EmployeeCode : ".$value['EmployeeCode'];
                
                }
                else
                {
                    $password                = "Test@123";
                    $user_record->password   = md5($password); 
                    $user_record->confirmed  = 1;
                    $user_record->mnethostid = 1;
                    $user_record->is_mandatory_completed = 0;

                    $sql = "INSERT INTO mdl_user(firstname,lastname,username,email,password,confirmed,mnethostid,employee_code,gender,dob,company_code,date_of_joining,date_of_confirmation,date_of_leaving,reporting_manager_code,reporting_manager_name,phone1, employement_type,employee_status,designation, institution,department, middlename,city,region) VALUES (\"".$user_record->firstname."\",\"".$user_record->lastname."\",\"".$user_record->username."\",\"".$user_record->email."\",\"".$user_record->password."\",\"".$user_record->confirmed."\",\"".$user_record->mnethostid."\",\"".$user_record->employee_code."\",\"".$user_record->gender."\",\"".$user_record->dob."\",\"".$user_record->company_code."\",\"".$user_record->date_of_joining."\",\"".$user_record->date_of_confirmation."\",\"".$user_record->date_of_leaving."\",\"".$user_record->reporting_manager_code."\",\"".$user_record->reporting_manager_name."\",\"".$user_record->phone1."\",\"".$user_record->employement_type."\",\"".$user_record->employee_status."\",\"".$user_record->designation."\",\"".$user_record->institution."\",\"".$user_record->department."\",\"".$user_record->middlename."\",\"".$user_record->city."\",\"".$user_record->region."\")";
                    //echo $sql; exit();
                    $DB->execute($sql);

                    $count_insert++;

                    /* generate token */

                    $ch = curl_init();
                    curl_setopt($ch,CURLOPT_URL,$CFG->wwwroot."/login/token.php?username=".$user_record->username."&password=Test@123&service=moodle_mobile_app");  
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
            else if($status == 'FnF Initiated' || $status == 'FnF Locked' || $status == 'FnFInitiated' || $status == 'FnFLocked')
            {
                $query_fetch_user = $DB->get_record_sql('SELECT u.id,u.deleted FROM mdl_user as u WHERE employee_code = ? ',array( $value['EmployeeCode'] ) );

                if(!empty($query_fetch_user) && $query_fetch_user->deleted == 0)
                {
                    $up_user_record  = new stdClass();
                    $up_user_record->id         = $query_fetch_user->id; 
                    $up_user_record->deleted    = 1;
                    $up_user_record->employee_status = "'".$status."'";
                    $up_user = $DB->update_record('user', $up_user_record);
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

print_r($count);

$cron_record = new stdClass();
$cron_record->name          = "New User  data upload"; 
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