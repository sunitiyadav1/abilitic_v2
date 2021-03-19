<?php
/* 
	@author: Suniti Yadav 
	description : As per number of course modules, course will get marked as completed.
*/
$base = __DIR__ . '/../';
define('CLI_SCRIPT', true);
require_once $base.'config.php';

//require_once '../config.php';

//Set time zone
date_default_timezone_set('Asia/Kolkata');

$set_time = time();
$count 			= 0;
$count_insert   = 0;
$count_update   = 0;
$count_delete   = 0;
$insert_records = '';
$update_records = '';
$delete_records = '';

// Get course & its total modules
$get_course_modules = $DB->get_records_sql("SELECT c.id, COUNT(cm.id) AS total_modules
											FROM mdl_course_categories AS cc
											JOIN mdl_course AS c ON cc.id = c.category
											JOIN mdl_course_modules AS cm ON c.id = cm.course
											WHERE cm.deletioninprogress = 0 
											#AND c.visible = 1
											GROUP BY cm.course"); 
//echo"<pre> totalmodule -"; print_r($get_course_modules); 
if(!empty($get_course_modules)){ 

    foreach ($get_course_modules as $key => $value) {

    	// Get total completed modules by enroled users
		$get_enroled_user_comp_modules = $DB->get_records_sql("SELECT ue.userid,c.id AS courseid, 
													e.id AS enrolid, 
													COUNT(cm.id) AS totalcompletedmodules
													FROM mdl_enrol AS e
													JOIN mdl_user_enrolments AS ue ON e.id = ue.enrolid
													JOIN mdl_course AS c ON e.courseid = c.id
													JOIN mdl_course_modules AS cm ON c.id = cm.course
													JOIN mdl_course_modules_completion AS cmc ON cm.id = cmc.coursemoduleid AND cmc.userid = ue.userid
													WHERE cm.deletioninprogress = 0 
													#AND c.visible = 1 
													AND cmc.completionstate > 0
													AND c.id = ? 
													GROUP BY ue.userid",array('id' => $value->id)); 
		//echo"course modules -"; print_r($get_enroled_user_comp_modules); 
		foreach ($get_enroled_user_comp_modules as $key1 => $value1) {

			// Check who has completed all the modules
			if($value->total_modules == $value1->totalcompletedmodules)
			{
				//echo"userid "; print_r($value->id);
				//echo"totalcompletedmodules "; print_r($value1->totalcompletedmodules);
				//echo"courseid "; print_r($value1->courseid);
				// Check if already record is there
				$get_course_comp = $DB->get_record_sql("SELECT * FROM mdl_course_completions 
														WHERE userid = ? AND course = ?", array('userid' => $value1->userid, 'course' => $value1->courseid)); 
				if(!empty($get_course_comp))
				{
					if(empty($get_course_comp->timestarted))
					{
						// Update it - Mark course as completed
						$DB->execute("update mdl_course_completions set timestarted ='$set_time', timecompleted ='$set_time' where id = $get_course_comp->id");

						$update_records .= " User Id : ".$value1->userid;
			            $update_records .= " Course Id : ".$value1->courseid;
			            $update_records .= "----------------------";
			            $count_update++;
					}
					else if(empty($get_course_comp->timecompleted))
					{
						// Update it - Mark course as completed
						$DB->execute("update mdl_course_completions set timecompleted ='$set_time' where id = $get_course_comp->id");

						$update_records .= " User Id : ".$value1->userid;
		            	$update_records .= " Course Id : ".$value1->courseid;
		            	$update_records .= "----------------------";
		            	$count_update++;
					}
				}
				else
				{
					$insert_records .= " User Id : ".$value1->userid;
		            $insert_records .= " Course Id : ".$value1->courseid;
		            $insert_records .= "----------------------";

					// Insert it - Mark course as completed
					$DB->execute("INSERT INTO mdl_course_completions(userid, course, timeenrolled, timestarted, timecompleted, reaggregate) VALUES ('$value1->userid','$value1->courseid','$set_time','$set_time','$set_time','$set_time')");

					$count_insert++;
				}

				$count++;
			}
		}

	} 
}
         
         echo "completed process";

$cron_record = new stdClass();
$cron_record->name          = "Course Completion"; 
$cron_record->cron_job_time = date('Y-m-d H:i:s');
$cron_record->updated_till  = date('Y-m-d H:i:s',strtotime("-1 days"));
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

?>