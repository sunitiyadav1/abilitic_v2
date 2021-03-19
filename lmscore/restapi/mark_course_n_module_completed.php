<?php
// mark_course_n_module_completed.php

/* 
// BMAI specific 
	@author: Suniti Yadav 
	description : To mark course and modules as completed.
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


// Get all the elearning courses without tag 'archive'
$get_elearn_course_list = $DB->get_records_sql("SELECT c.id as courseid
											FROM mdl_course_categories AS cc
											JOIN mdl_course AS c ON cc.id = c.category
											WHERE cc.id = 25 
											#and c.id = 151
											and c.id not in (SELECT ti.itemid FROM `mdl_tag` as t join mdl_tag_instance as ti on ti.tagid = t.id where t.name = 'archive' and ti.itemtype = 'course')
											"); 

// echo "<pre> get_elearn_course_list -"; print_r($get_elearn_course_list); //exit();

foreach ($get_elearn_course_list as $key => $value) {
	
	// Get all the users who has achived the certificate
	$get_certified_users = $DB->get_records_sql("SELECT * FROM `mdl_customcert_issues` 
		where userid = 9885
		and customcertid in (SELECT instance 
		FROM `mdl_course_modules` 
		WHERE `course` = $value->courseid and module = 28 and deletioninprogress = 0 
		and id not in (SELECT ti.itemid FROM `mdl_tag` as t 
		join mdl_tag_instance as ti on ti.tagid = t.id 
		where t.name = 'archive' and ti.itemtype = 'course_modules')) ");

	// echo "<pre> get_certified_users -"; print_r($get_certified_users);

	foreach($get_certified_users as $cukey =>$cuvalue)
	{
		// update incomplete modules
		$DB->execute("update mdl_course_modules_completion set timemodified ='$set_time', completionstate = 1 where timemodified = 0 and userid = '$cuvalue->userid' and coursemoduleid in (SELECT id FROM `mdl_course_modules` WHERE `course` = $value->courseid  and deletioninprogress = 0)");

		// Get modules which is not completed
		$get_other_modules = $DB->get_records_sql("SELECT * FROM `mdl_course_modules` as cm 
			WHERE `course` = $value->courseid and deletioninprogress = 0 
			and cm.id not in (SELECT coursemoduleid FROM `mdl_course_modules_completion` 
			where userid = $cuvalue->userid and coursemoduleid = cm.id )");

		// echo "<pre> get_other_modules -"; print_r($get_other_modules);

		foreach ($get_other_modules as $omkey => $omvalue) {
			// print_r($cuvalue->userid);
			
			// mark module as completed
			$DB->execute("INSERT INTO mdl_course_modules_completion(coursemoduleid,userid, completionstate, viewed, timemodified) VALUES ('$omvalue->id','$cuvalue->userid','1','1','$set_time')");
			

		}
		// mark course as completed
		// $DB->execute("INSERT INTO mdl_course_completions(userid, course, timeenrolled, timestarted, timecompleted, reaggregate) VALUES ('$cuvalue->userid','$value->courseid','$set_time','$set_time','$set_time','$set_time')");

		$get_course_comp = $DB->get_record_sql("SELECT * FROM mdl_course_completions WHERE userid = ? AND course = ?", array('userid' => $cuvalue->userid, 'course' => $value->courseid)); 

		if(!empty($get_course_comp))
		{
			if(empty($get_course_comp->timestarted))
			{
				// Update it - Mark course as completed
				$DB->execute("update mdl_course_completions set timestarted ='$set_time', timecompleted ='$set_time' where id = $get_course_comp->id");
			}
			else if(empty($get_course_comp->timecompleted))
			{
				// Update it - Mark course as completed
				$DB->execute("update mdl_course_completions set timecompleted ='$set_time' where id = $get_course_comp->id");
			}
		}
		else
		{
			// Insert it - Mark course as completed
			$DB->execute("INSERT INTO mdl_course_completions(userid, course, timeenrolled, timestarted, timecompleted, reaggregate) VALUES ('$cuvalue->userid','$value->courseid','$set_time','$set_time','$set_time','$set_time')");
		}

	}

}

?>