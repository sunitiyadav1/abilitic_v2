<?php
/*
* @author : Suniti Yadav
* description : API's for portal employee dossair
*/

// require_once '../../config.php';

define('AJAX_SCRIPT', true);
define('NO_MOODLE_COOKIES', true);
require_once '../../config.php';
require_once($CFG->libdir.'/moodlelib.php');


error_reporting(E_ALL | E_STRICT); 
ini_set('display_errors', '1'); 
$CFG->debug = (E_ALL | E_STRICT); 
$CFG->debugdisplay = 1;
$CFG->debugdeveloper= 1;

// global $DB, $CFG, $SESSION ,$USER;

header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: access");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Allow-Credentials: true");
header('Content-Type: application/json');
header("HTTP/1.0 200 Successfull operation");


$wsfunction = $_POST['wsfunction']; 

if($wsfunction == "completedCourseList_1")
{
    $employee_code       = $_POST['employee_code'];
    $company_code        = $_POST['company_code'];
    $page                = isset($_POST['page']) ? $_POST['page'] : 1;
    $limit               = isset($_POST['limit']) ? $_POST['limit'] : 10;
    $totalCount          = 0;
    $totoalPages         = 0;
    $status              = 0; 
    $message             = "Something went wrong.";
    $result          	 = [];

    if($company_code != '' && $employee_code != '')
    { 
        try 
        {
        	global $CFG;
        	$fetch_user = $DB->get_record_sql("SELECT * FROM mdl_user WHERE employee_code = ? and company_code = ?", array('employee_code' => $employee_code, 'company_code' => $company_code));

        	if(!empty($fetch_user))
        	{
                // Offset
                $paginationStart = ($page - 1) * $limit;

                // Get total records
                $fetch_cat_count = $DB->get_record_sql("SELECT count(cm.id) as total FROM mdl_course_categories as cc join mdl_course as c on c.category = cc.id join mdl_course_completions as cm on cm.course = c.id where 
                    c.visible = 1 and cm.userid = ? and cm.timecompleted != '' ", array('userid' => $fetch_user->id));

                $totalCount  = (!empty($fetch_cat_count)?$fetch_cat_count->total:0);

                // Calculate total pages
                $totoalPages = ceil(  $totalCount / $limit);

        		$get_comp_course = $DB->get_records_sql("SELECT cm.id,cc.id as category_id, cc.name as category_name, c.id as course_id, c.fullname as course_name, c.startdate as course_startdate, c.enddate as course_enddate ,cm.timecompleted FROM mdl_course_categories as cc join mdl_course as c on c.category = cc.id join mdl_course_completions as cm on cm.course = c.id where 
                    c.visible = 1 and cm.userid = ? and cm.timecompleted != '' LIMIT $paginationStart, $limit ", array('userid' => $fetch_user->id));

        		// print_r($get_comp_course);// exit();

        		if(!empty($get_comp_course))
        		{
        			foreach ($get_comp_course as $key => $value) {
        				$get_certificate = $DB->get_records_sql("SELECT cmc.*,cm.id as course_moduleid,cm.course,cm.instance,m.name as modulename, m.id as moduleid FROM `mdl_modules` as m join mdl_course_modules as cm on cm.module = m.id join mdl_course_modules_completion as cmc on cmc.coursemoduleid = cm.id WHERE m.name LIKE '%cert%' and cm.deletioninprogress = 0 and cm.course = ?", array('course' => $value->course_id));
        				if(!empty($get_certificate))
        				{
	        				foreach ($get_certificate as $key1 => $value1) {
	        					$get_module = $DB->get_record_sql("SELECT name FROM `mdl_certificate` WHERE id = ?", array('id' => $value1->instance));
	        					$value1->certificate_name = !empty($get_module)?$get_module->name:'';
	        					//https://learn2.zinghr.com/stepway/lms/mod/certificate/view.php?id=146&action=get
	        					$value1->certificate_url  = $CFG->wwwroot.'/mod/certificate/view.php?id='.$value1->course_moduleid.'&action=get';
	        					$value->certificate[] = $value1;
	        				}
	        			}
	        			else
	        			{
	        				$value->certificate = [];
	        			}
                        $value->courselink = (string)new moodle_url("/course/view.php", array("id" => $value->course_id));
	        			$result[] = $value;
	        		}
	        		$status     =  1;
	                $message    = "Record found successfully.";
        		}
        		else
        		{
    			    $status              = 0; 
					$message             = "Record not found.";
        		}
        	}
        	else
        	{
        		$message = "User doesn't exist.";
        	}
            
             
        }catch(Exception $e) {
              $message = 'Message: ' .$e->getMessage();
        }
        $returndata['totoalPages']  = $totoalPages;
        $returndata['totalCount']   = $totalCount;
        $returndata['status']       = $status;
        $returndata['message']      = $message;
        $returndata['result']       = $result;
    }
    else
    {
        $returndata['status']  = 0;
        $returndata['message'] = "Parameter Missing.";
        $returndata['result']  = [];
    }
    echo $data = json_encode($returndata);
}
else if($wsfunction == "completedCourseList")
{
    $employee_code       = $_POST['employee_code'];
    $company_code        = $_POST['company_code'];
    $page                = isset($_POST['page']) ? $_POST['page'] : 1;
    $limit               = isset($_POST['limit']) ? $_POST['limit'] : 10;
    $totalCount          = 0;
    $totoalPages         = 0;
    $status              = 0; 
    $message             = "Something went wrong.";
    $result              = [];

    if($company_code != '' && $employee_code != '')
    { 
        try 
        {
            global $CFG;
            $fetch_user = $DB->get_record_sql("SELECT * FROM mdl_user WHERE employee_code = ? and company_code = ?", array('employee_code' => $employee_code, 'company_code' => $company_code));

            if(!empty($fetch_user))
            {
                // Offset
                $paginationStart = ($page - 1) * $limit;

                // Get total records
                $fetch_cat_count = $DB->get_record_sql("SELECT count(cm.id) as total FROM mdl_course_categories as cc join mdl_course as c on c.category = cc.id join mdl_course_completions as cm on cm.course = c.id where 
                    c.visible = 1 and cm.userid = ? and cm.timecompleted != '' ", array('userid' => $fetch_user->id));

                $totalCount  = (!empty($fetch_cat_count)?$fetch_cat_count->total:0);

                // Calculate total pages
                $totoalPages = ceil(  $totalCount / $limit);

                $get_comp_course = $DB->get_records_sql("SELECT cm.id,cc.id as category_id, cc.name as category_name, c.id as course_id, c.fullname as course_name, c.startdate as course_startdate, c.enddate as course_enddate ,cm.timecompleted, 0 as refresher_requirement 
                    FROM mdl_course_categories as cc 
                    join mdl_course as c on c.category = cc.id 
                    join mdl_course_completions as cm on cm.course = c.id 
                    where c.visible = 1 and cm.userid = ? and cm.timecompleted != '' 
                    LIMIT $paginationStart, $limit ", array('userid' => $fetch_user->id));

                // print_r($get_comp_course);// exit();

                if(!empty($get_comp_course))
                {
                    foreach ($get_comp_course as $key => $value) {

                        if(!empty($value->refresher_requirement))
                        {
                            // sec = 31536000 (60*60*24*365 = 12 months)
                            $sec = 0;
                            
                            if($value->refresher_requirement == 12)
                            {
                                $sec = 31536000 * 1;
                            }
                            else if($value->refresher_requirement == 24)
                            {
                                $sec = 31536000 * 2;
                            }
                            else if($value->refresher_requirement == 36)
                            {
                                $sec = 31536000 * 3;
                            }

                            $value->certificate_expiry = $value->timecompleted + $sec;
                        }
                        else
                        {
                            $value->certificate_expiry = "NA";
                        }

                        $get_certificate = $DB->get_records_sql("SELECT cmc.*,cm.id as course_moduleid,cm.course,cm.instance,m.name as modulename, m.id as moduleid FROM `mdl_modules` as m join mdl_course_modules as cm on cm.module = m.id join mdl_course_modules_completion as cmc on cmc.coursemoduleid = cm.id WHERE m.name LIKE '%cert%' and cm.deletioninprogress = 0 and cm.course = ?", array('course' => $value->course_id));
                        if(!empty($get_certificate))
                        {
                            foreach ($get_certificate as $key1 => $value1) {
                                $get_module = $DB->get_record_sql("SELECT name FROM `mdl_certificate` WHERE id = ?", array('id' => $value1->instance));
                                $value1->certificate_name = !empty($get_module)?$get_module->name:'';
                                //https://learn2.zinghr.com/stepway/lms/mod/certificate/view.php?id=146&action=get
                                $value1->certificate_url  = $CFG->wwwroot.'/mod/certificate/view.php?id='.$value1->course_moduleid.'&action=get';
                                $value->certificate[] = $value1;
                            }
                        }
                        else
                        {
                            $value->certificate = [];
                        }
                        $value->courselink = (string)new moodle_url("/course/view.php", array("id" => $value->course_id));
                        $result[] = $value;
                    }
                    $status     =  1;
                    $message    = "Record found successfully.";
                }
                else
                {
                    $status              = 0; 
                    $message             = "Record not found.";
                }
            }
            else
            {
                $message = "User doesn't exist.";
            }
            
             
        }catch(Exception $e) {
              $message = 'Message: ' .$e->getMessage();
        }
        $returndata['totoalPages']  = $totoalPages;
        $returndata['totalCount']   = $totalCount;
        $returndata['status']       = $status;
        $returndata['message']      = $message;
        $returndata['result']       = $result;
    }
    else
    {
        $returndata['status']  = 0;
        $returndata['message'] = "Parameter Missing.";
        $returndata['result']  = [];
    }
    echo $data = json_encode($returndata);
}
else if($wsfunction == "getCategories_1")
{
    $company_code        = $_POST['company_code'];
    $page                = isset($_POST['page']) ? $_POST['page'] : 1;
    $limit               = isset($_POST['limit']) ? $_POST['limit'] : 10;
    $totalCount          = 0;
    $totoalPages         = 0;
    $status              = 0; 
    $message             = "Something went wrong.";
    $result              = [];

    if($company_code != '')
    { 
        try 
        {
            // Offset
            $paginationStart = ($page - 1) * $limit;

            // Get total records
            $fetch_cat_count = $DB->get_record_sql("SELECT count(id) as total FROM `mdl_course_categories` where visible = 1");
            
            $totalCount  = (!empty($fetch_cat_count)?$fetch_cat_count->total:0);

            // Calculate total pages
            $totoalPages = ceil(  $totalCount / $limit);

            $fetch_cat = $DB->get_records_sql("SELECT id as cat_id,name,path,coursecount,depth FROM `mdl_course_categories` where visible = 1 LIMIT $paginationStart, $limit ");

            if(!empty($fetch_cat))
            {
                foreach ($fetch_cat as $key => $value) {
                    $path_array = explode('/', $value->path);
                    // print_r($path_array); exit();

                    if( in_array($value->cat_id, $path_array) )
                    {
                        if($value->depth > 1)
                        {
                            $value->sub_cat = [];
                            $sub_cat[] = $value;
                            $result[$path_array[1]]->sub_cat     = $sub_cat;
                        }
                        else
                        {
                            $value->sub_cat = [];
                            $result[$path_array[1]] = $value;
                        }
                        $result[$path_array[1]]->total_level = $value->depth;
                    }
                }
                $status     =  1;
                $message    = "Record found successfully.";
            }
            else
            {
                $status     = 0; 
                $message    = "Record not found.";
            }
            
        }catch(Exception $e) {
              $message = 'Message: ' .$e->getMessage();
        }

        $returndata['totoalPages']  = $totoalPages;
        $returndata['totalCount']   = $totalCount;
        $returndata['status']       = $status;
        $returndata['message']      = $message;
        $returndata['result']       = $result;
    }
    else
    {
        $returndata['status']  = 0;
        $returndata['message'] = "Parameter Missing.";
        $returndata['result']  = [];
    }
    echo $data = json_encode($returndata);
}
else if($wsfunction == "getCategories")
{
    $company_code        = $_POST['company_code'];
    $page                = isset($_POST['page']) ? $_POST['page'] : 1;
    $limit               = isset($_POST['limit']) ? $_POST['limit'] : 10;
    $totalCount          = 0;
    $totoalPages         = 0;
    $status              = 0; 
    $message             = "Something went wrong.";
    $result              = [];

    if($company_code != '')
    { 
        try 
        {
            // Offset
            $paginationStart = ($page - 1) * $limit;

            // Get total records
            $fetch_cat_count = $DB->get_record_sql("SELECT count(id) as total FROM `mdl_course_categories` where `parent` = 0 and visible = 1");
            
            $totalCount  = (!empty($fetch_cat_count)?$fetch_cat_count->total:0);

            // Calculate total pages
            $totoalPages = ceil(  $totalCount / $limit);

            $fetch_cat = $DB->get_records_sql("SELECT id as cat_id,name,path,coursecount,depth,parent FROM `mdl_course_categories` where visible = 1 and `parent` = 0 LIMIT $paginationStart, $limit ");

            if(!empty($fetch_cat))
            {
                foreach ($fetch_cat as $key => $value) {
                    
                    $fetch_levels = $DB->get_record_sql("SELECT MAX(depth) as total_levels  FROM `mdl_course_categories` WHERE visible = 1 and `path` LIKE '%/$value->cat_id%' ");

                    $fetch_sub_cat = $DB->get_records_sql("SELECT id as cat_id,name,path,coursecount,depth,parent FROM `mdl_course_categories` where visible = 1 and `parent` = $value->cat_id");

                    $sub_cat = [];
                    foreach ($fetch_sub_cat as $key1 => $value1) {
                        $fetch_sub_cat2 = $DB->get_records_sql("SELECT id as cat_id,name,path,coursecount,depth,parent FROM `mdl_course_categories` where visible = 1 and `parent` = $value1->cat_id");
                        $sub_cat2 = [];
                        foreach ($fetch_sub_cat2 as $key2 => $value2) {
                            $sub_cat2[] = $value2;
                        }
                        $value1->sub_cat = $sub_cat2;
                        $sub_cat[] = $value1;

                    }
                    $value->sub_cat      = $sub_cat;
                    $value->total_levels = $fetch_levels->total_levels;
                    $result[]            = $value;
                }
                $status     =  1;
                $message    = "Record found successfully.";
            }
            else
            {
                $status     = 0; 
                $message    = "Record not found.";
            }
            
        }catch(Exception $e) {
              $message = 'Message: ' .$e->getMessage();
        }

        $returndata['totoalPages']  = $totoalPages;
        $returndata['totalCount']   = $totalCount;
        $returndata['status']       = $status;
        $returndata['message']      = $message;
        $returndata['result']       = $result;
    }
    else
    {
        $returndata['status']  = 0;
        $returndata['message'] = "Parameter Missing.";
        $returndata['result']  = [];
    }
    echo $data = json_encode($returndata);
}
else if($wsfunction == "getEnrolledCourses")
{
    $employee_code       = $_POST['employee_code'];
    $company_code        = $_POST['company_code'];
    $page                = isset($_POST['page']) ? $_POST['page'] : 1;
    $limit               = isset($_POST['limit']) ? $_POST['limit'] : 10;
    $totalCount          = 0;
    $totoalPages         = 0;
    $status              = 0; 
    $message             = "Something went wrong.";
    $result              = [];

    if($company_code != '' && $employee_code != '')
    { 
        try 
        {
            global $CFG;

            $fetch_user = $DB->get_record_sql("SELECT * FROM mdl_user WHERE employee_code = ? and company_code = ?", array('employee_code' => $employee_code, 'company_code' => $company_code));

            if(!empty($fetch_user))
            {
                // Offset
                $paginationStart = ($page - 1) * $limit;

                // Get total records
                $fetch_cat_count = $DB->get_record_sql("SELECT count(ue.id) as total 
                    FROM mdl_course_categories as cc 
                    join mdl_course as c on c.category = cc.id 
                    join mdl_enrol as e on e.courseid = c.id 
                    join mdl_user_enrolments as ue on ue.enrolid = e.id 
                    where c.visible = 1 and ue.userid = ? ", array('userid' => $fetch_user->id));
                
                $totalCount  = (!empty($fetch_cat_count)?$fetch_cat_count->total:0);

                // Calculate total pages
                $totoalPages = ceil(  $totalCount / $limit);

                $get_enrol_course = $DB->get_records_sql("SELECT ue.id as user_enrol_id,cc.id as category_id, cc.name as category_name, c.id as course_id, c.fullname as course_name, c.startdate as course_startdate, c.enddate as course_enddate ,ue.timecreated as enrol_date
                    FROM mdl_course_categories as cc 
                    join mdl_course as c on c.category = cc.id 
                    join mdl_enrol as e on e.courseid = c.id 
                    join mdl_user_enrolments as ue on ue.enrolid = e.id 
                    where c.visible = 1 and ue.userid = ? LIMIT $paginationStart, $limit ", array('userid' => $fetch_user->id));

                // print_r($get_enrol_course);// exit();

                if(!empty($get_enrol_course))
                {
                    foreach ($get_enrol_course as $key => $value) {
                        $result[] = $value;
                    }
                    $status     =  1;
                    $message    = "Record found successfully.";
                }
                else
                {
                    $status              = 0; 
                    $message             = "Record not found.";
                }
            }
            else
            {
                $message = "User doesn't exist.";
            }
            
             
        }catch(Exception $e) {
              $message = 'Message: ' .$e->getMessage();
        }

        $returndata['totoalPages']  = $totoalPages;
        $returndata['totalCount']   = $totalCount;
        $returndata['status']       = $status;
        $returndata['message']      = $message;
        $returndata['result']       = $result;
    }
    else
    {
        $returndata['status']  = 0;
        $returndata['message'] = "Parameter Missing.";
        $returndata['result']  = [];
    }
    echo $data = json_encode($returndata);
}
else if($wsfunction == "getRoles")
{
    $company_code        = $_POST['company_code'];
    $page                = isset($_POST['page']) ? $_POST['page'] : 1;
    $limit               = isset($_POST['limit']) ? $_POST['limit'] : 10;
    $totalCount          = 0;
    $totoalPages         = 0;
    $status              = 0; 
    $message             = "Something went wrong.";
    $result              = [];

    if($company_code != '')
    { 
        try 
        {
            // Offset
            $paginationStart = ($page - 1) * $limit;

            // Get total records
            $fetch_cat_count = $DB->get_record_sql("SELECT count(id) as total FROM `mdl_role`");
            
            $totalCount  = (!empty($fetch_cat_count)?$fetch_cat_count->total:0);

            // Calculate total pages
            $totoalPages = ceil(  $totalCount / $limit);

            $fetch_role = $DB->get_records_sql("SELECT id as role_id,shortname as name, description, archetype FROM `mdl_role` LIMIT $paginationStart, $limit");

            if(!empty($fetch_role))
            {
                foreach ($fetch_role as $key => $value) {
                    $result[] = $value;
                }
                $status     =  1;
                $message    = "Record found successfully.";
            }
            else
            {
                $status     = 0; 
                $message    = "Record not found.";
            }
            
        }catch(Exception $e) {
              $message = 'Message: ' .$e->getMessage();
        }

        $returndata['totoalPages']  = $totoalPages;
        $returndata['totalCount']   = $totalCount;
        $returndata['status']       = $status;
        $returndata['message']      = $message;
        $returndata['result']       = $result;
    }
    else
    {
        $returndata['status']  = 0;
        $returndata['message'] = "Parameter Missing.";
        $returndata['result']  = [];
    }
    echo $data = json_encode($returndata);
}
else if($wsfunction == "setUserRole_1")
{
    $company_code        = $_POST['company_code'];
    $modifier_code       = $_POST['modifier_code'];
    $employee_code       = $_POST['employee_code'];
    $role_id             = $_POST['role_id'];

    $status              = 0; 
    $message             = "Something went wrong.";

    if($company_code != '' && $modifier_code != '' && $employee_code != '' && $role_id != '')
    { 
        try 
        {
            $fetch_modifier = $DB->get_record_sql("SELECT id FROM mdl_user WHERE employee_code = ? and company_code = ?", array('employee_code' => $modifier_code, 'company_code' => $company_code));

            if(!empty($employee_code) && !empty($role_id))
            {
                foreach ($employee_code as $key => $value) {
                    $fetch_user = $DB->get_record_sql("SELECT id FROM mdl_user WHERE employee_code = ? and company_code = ?", array('employee_code' => $value, 'company_code' => $company_code));

                    $fetch_ra = $DB->get_record_sql("SELECT * FROM `mdl_role_assignments` where userid = ? and roleid = ?", array('userid' => $fetch_user->id, 'roleid' => $role_id[$key] ));

                    if(empty($fetch_ra))
                    {
                        $rec_insert = new stdClass();
                        $rec_insert->roleid      = $role_id[$key];
                        $rec_insert->contextid   = 1;
                        $rec_insert->userid      = $fetch_user->id;
                        $rec_insert->timemodified= time();
                        $rec_insert->modifierid  = isset($fetch_modifier) ? $fetch_modifier->id : 0;
                        $rec_insert->component   = 'NULL';

                        $DB->insert_record('role_assignments', $rec_insert, true);
                    }
                }
                $status     =  1;
                $message    = "Record found successfully.";
            }
            else
            {
                $status     = 0; 
                $message    = "Record not found.";
            }
            
        }catch(Exception $e) {
              $message = 'Message: ' .$e->getMessage();
        }

        $returndata['status']  = $status;
        $returndata['message'] = $message;
    }
    else
    {
        $returndata['status']  = 0;
        $returndata['message'] = "Parameter Missing.";
    }
    echo $data = json_encode($returndata);
}
else if($wsfunction == "setUserRole")
{
    // [{"emp_code":"0014","role_ids":"3,5"},{"emp_code":"0016","role_ids":"1"}]
    
    $company_code        = $_POST['company_code'];
    $modifier_code       = $_POST['modifier_code'];
    $empRoles            = $_POST['empRoles'];

    $status              = 0; 
    $message             = "Something went wrong.";
    $role_id_arr         = [];

    if($company_code != '' && $modifier_code != '' && $empRoles != '')
    { 
        try 
        {
            $fetch_modifier = $DB->get_record_sql("SELECT id FROM mdl_user WHERE employee_code = ? and company_code = ?", array('employee_code' => $modifier_code, 'company_code' => $company_code));

            if(!empty($empRoles))
            {
                foreach ( json_decode(trim($empRoles,'"')) as $key => $value) {
                    
                    $fetch_user = $DB->get_record_sql("SELECT id FROM mdl_user WHERE employee_code = ? and company_code = ?", array('employee_code' => $value->emp_code, 'company_code' => $company_code));

                    $role_id_arr = explode(',', trim($value->role_ids,'"'));

                    foreach ($role_id_arr as $key1 => $value1) {
                        //print_r($value1); exit();

                        $fetch_ra = $DB->get_record_sql("SELECT * FROM `mdl_role_assignments` where contextid = ? and userid = ? and roleid = ?", array('contextid' => 1,'userid' => $fetch_user->id, 'roleid' => $value1));

                        if(empty($fetch_ra))
                        {
                            $rec_insert = new stdClass();
                            $rec_insert->roleid      = $value1;
                            $rec_insert->contextid   = 1;
                            $rec_insert->userid      = $fetch_user->id;
                            $rec_insert->timemodified= time();
                            $rec_insert->modifierid  = isset($fetch_modifier) ? $fetch_modifier->id : 0;
                            $rec_insert->component   = 'NULL';

                            $DB->insert_record('role_assignments', $rec_insert, true);
                        }
                    }
                }
                $status     =  1;
                $message    = "Role assigned successfully.";
            }
            else
            {
                $status     = 0; 
                $message    = "Record not found.";
            }
            
        }catch(Exception $e) {
              $message = 'Message: ' .$e->getMessage();
        }

        $returndata['status']  = $status;
        $returndata['message'] = $message;
    }
    else
    {
        $returndata['status']  = 0;
        $returndata['message'] = "Parameter Missing.";
    }
    echo $data = json_encode($returndata);
}
else
{
   echo $data = json_encode(['Message'=>'Function Name Parameter wsfunction is missing']);
}