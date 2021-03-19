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

for ($i=1; $i > 0 ; $i++) {

    // $pageIndex = $pageIndex + $i;
    $pageIndex = $i;
    $curl_url  = "https://mservices.zinghr.com/ed/api/v2/LMSIntegration/EmployeeDetails?companyCode=".$companyCode."&pageIndex=".$pageIndex."&pageSize=".$pageSize;

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
    //echo"<pre>"; print_r($jsonResponse); exit();

    // $count = count($jsonResponse['data']);

    // if ($count == 0) {
    //   break;
    // }

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
        if(empty($jsonResponse['data'])) 
        {
            break;
        }

        foreach ($jsonResponse['data'] as $mainkey => $mainvalue) {
            
            // echo"<pre>"; print_r($mainvalue['detail']['employeeCode']); exit();
            $employeeCode = $mainvalue['detail']['employeeCode'];
            
            $fetch_user = $DB->get_record_sql("SELECT * FROM mdl_user where employee_code = ?", array('employee_code' => $employeeCode));

            if(empty($fetch_user))
            {
                $user_record  = new stdClass();
                $user_record->firstname         = isset($mainvalue['detail']['firstName']) ? trim($mainvalue['detail']['firstName']) : '.'; 
                 $user_record->lastname         = (isset($mainvalue['detail']['lastName']) && !empty($mainvalue['detail']['lastName']))?$mainvalue['detail']['lastName']:$mainvalue['detail']['middleName'].'.'; 
                $user_record->email             = (isset($mainvalue['detail']['email']) && !empty($mainvalue['detail']['email'])) ? trim($mainvalue['detail']['email']) : 'support@'.$CFG->dbname.'.com_'.$mainvalue['detail']['employeeCode']; 
                $user_record->username          = isset($mainvalue['detail']['employeeCode']) ? $mainvalue['detail']['employeeCode'] : '.'; 
                $user_record->employee_code     = isset($mainvalue['detail']['employeeCode']) ? $mainvalue['detail']['employeeCode'] : '';
                $user_record->gender            = isset($mainvalue['detail']['gender'] ) ? $mainvalue['detail']['gender']  : '';
                $user_record->dob               = !empty($mainvalue['detail']['dateofBirth'] ) ? strtotime(trim($mainvalue['detail']['dateofBirth']," ")) : 0;
                $user_record->company_code      = $companyCode;
                $user_record->date_of_joining   =  !empty($mainvalue['detail']['dateOfJoining'] ) ? strtotime($mainvalue['detail']['dateOfJoining']) : 0;
                $user_record->date_of_confirmation  = !empty($mainvalue['detail']['dateofconfirmation'] ) ? strtotime($mainvalue['detail']['dateofconfirmation']) : 0;
                $user_record->date_of_leaving   = !empty($mainvalue['detail']['dateOfLeaving'] ) ? strtotime($mainvalue['detail']['dateOfLeaving']) : 0;
                $user_record->reporting_manager_code = isset($mainvalue['detail']['reportingManagercode'] ) ? $mainvalue['detail']['reportingManagercode'] : '';
                $user_record->reporting_manager_name = isset($mainvalue['detail']['reportingManagerName'] ) ? $mainvalue['detail']['reportingManagerName'] : '';
                $user_record->phone1                 = isset($mainvalue['detail']['mobile'] ) ? $mainvalue['detail']['mobile'] : '';   
                $user_record->employement_type       = isset($mainvalue['detail']['employmentType'] ) ? $mainvalue['detail']['employmentType'] : 'NA';
                $user_record->employee_status        = isset($mainvalue['detail']['employeeStatus'] ) ? $mainvalue['detail']['employeeStatus'] : 'Existing';
                $user_record->employeePhoto          = isset($mainvalue['detail']['employeePhoto'] ) ? $mainvalue['detail']['employeePhoto'] : 'NA';

                $user_record->department    = ''; //department 
                $user_record->designation   = ''; //designation
                $user_record->institution   = ''; //grade
                $user_record->middlename    = ''; //middle name
                $user_record->region        = ''; //Region
                $user_record->city          = ''; 

                
                $status = isset($mainvalue['detail']['employeeStatus']) ? $mainvalue['detail']['employeeStatus'] : '';

                foreach ($mainvalue['attributes'] as $attkey => $attvalue) {

                    if($attvalue['attributeTypeDesc'] == 'City')
                    {
                      $user_record->city = $attvalue['attributeTypeUnitDesc'];
                    }

                    if($attvalue['attributeTypeDesc'] == 'Region')
                    {
                      $user_record->region = $attvalue['attributeTypeUnitDesc'];
                    }

                     if($attvalue['attributeTypeDesc'] == 'Department')
                    {
                      $user_record->department = $attvalue['attributeTypeUnitDesc'];
                    }

                     if($attvalue['attributeTypeDesc'] == 'Designation')
                    {
                      $user_record->designation = $attvalue['attributeTypeUnitDesc'];
                    }
                   
                }

                $password                = "Test@123";
                $user_record->password   = md5($password); 
                $user_record->confirmed  = 1;
                $user_record->mnethostid = 1;

                /*
                $sql = "INSERT INTO mdl_user(firstname,lastname,username,email,password,confirmed,mnethostid,employee_code,gender,dob,company_code,date_of_joining,date_of_confirmation,date_of_leaving,reporting_manager_code,reporting_manager_name,phone1, employement_type,employee_status,designation, institution,department, middlename,city,region,employeePhoto) VALUES (\"".$user_record->firstname."\",\"".$user_record->lastname."\",\"".$user_record->username."\",\"".$user_record->email."\",\"".$user_record->password."\",\"".$user_record->confirmed."\",\"".$user_record->mnethostid."\",\"".$user_record->employee_code."\",\"".$user_record->gender."\",\"".$user_record->dob."\",\"".$user_record->company_code."\",\"".$user_record->date_of_joining."\",\"".$user_record->date_of_confirmation."\",\"".$user_record->date_of_leaving."\",\"".$user_record->reporting_manager_code."\",\"".$user_record->reporting_manager_name."\",\"".$user_record->phone1."\",\"".$user_record->employement_type."\",\"".$user_record->employee_status."\",\"".$user_record->designation."\",\"".$user_record->institution."\",\"".$user_record->department."\",\"".$user_record->middlename."\",\"".$user_record->city."\",\"".$user_record->region."\",\"".$user_record->employeePhoto."\")";
                
                echo $sql; //exit();
                $DB->execute($sql);
                */

                $DB->execute("INSERT INTO mdl_user(firstname,lastname,username,email,password,confirmed,mnethostid,employee_code,gender,dob,company_code,date_of_joining,date_of_confirmation,date_of_leaving,reporting_manager_code,reporting_manager_name,phone1, employement_type,employee_status,designation, institution,department, middlename,city,region,employeePhoto) VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)", array($user_record->firstname,$user_record->lastname,$user_record->username,$user_record->email,$user_record->password,$user_record->confirmed,$user_record->mnethostid,$user_record->employee_code,$user_record->gender,$user_record->dob,$user_record->company_code,$user_record->date_of_joining,$user_record->date_of_confirmation,$user_record->date_of_leaving,$user_record->reporting_manager_code,$user_record->reporting_manager_name,$user_record->phone1,$user_record->employement_type,$user_record->employee_status,$user_record->designation,$user_record->institution,$user_record->department,$user_record->middlename,$user_record->city,$user_record->region,$user_record->employeePhoto));

                // echo "executed"; exit();

                $insert_count++;

                /* generate token */

                $ch = curl_init();
                curl_setopt($ch,CURLOPT_URL,$CFG->wwwroot."/login/token.php?username=".$user_record->username."&password=Test@123&service=moodle_mobile_app");  
                curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true); 
                curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false); 
                $output=curl_exec($ch);
                //$result = json_decode($output, true);
                      
                
                $insert_data .= " User Email : ".$user_record->email;
                $insert_data .= " User EmployeeCode : ".$user_record->employee_code;
                $insert_data .= "----------------------";
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