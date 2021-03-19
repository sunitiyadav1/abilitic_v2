<?php
/* Progress Block Library for all the Customized Calculation and Structure making function Calls
 *  @author : Kajal Tailor
 * 
 * @todo:
 * */
require_once dirname(__FILE__) . '/../../config.php';

use core_completion\progress;
/* Data Processing Section
 *  Helper functions for processing data
 * */

/**
 *  Re-structures the data for further processing
 *                Moves Original data to 'rawData' node.
 *                Adds the node 'summaryData' for summary data
 *                Adds Charting Information Structure 'chartInfo' which contains charting (data, options, style, tooltip e.t.c)options and can be populated.
 *                Adds data download permission node 'dataDownloadAllowed' which is false by default.
 *                Adds node 'dataProcessorFunction' to specify which function will process the raw data.
 *                   This would be different for different types of data and charts.
 * @param {JSON}  dataJSON - The data in JSON format string OR a JSON object
 * @return {JSON} finalJSON - The restructured JSON object
 */
function restructuredData($data)
{
    $finaldata = new stdClass;
    if ($data != null && (is_array($data) || is_object($data))) {

        $chartStyleInfo = new stdClass;
        $chartStyleInfo->width = '';
        $chartStyleInfo->height = '';
        $chartStyleInfo->colorScheemId = 0;
        $chartStyleInfo->strokeColor = '#FFFFFF';

        $tooltipInfo = new stdClass;
        $tooltipInfo->tooltipHTML = '';
        $tooltipInfo->showAdditionalData = true;
        $tooltipInfo->dataColorStyleType = "color";

        $finaldata->summaryData = new stdClass;
        $finaldata->childrenData = [];
        $finaldata->dataDownloadAllowed = false;
        $finaldata->dataProcessorFunction = '';
        $finaldata->filtersAvailable = ""; //@todo:aditya:implement filters available
        $finaldata->filtersApplied = ""; //@todo:aditya:implement filters applied
        $chartInfo = new stdClass;
        $chartInfo->type = '';
        $chartInfo->title = '';
        $chartInfo->pic = '';
        $chartInfo->picClickCallbackFunction = '';
        $chartInfo->animate = '';
        $chartInfo->data = '';
        $chartInfo->tooltipInfo = $tooltipInfo;
        $chartInfo->style = $chartStyleInfo;
        $finaldata->chartInfo = $chartInfo;
        $finaldata->rawData = $data;
        $finaldata->isDataRestructured = true;
    } else {
        $finaldata = [];
        //echo "No Data Found";
        // $finaldata=$data;
    }
    return $finaldata;
}

/**
 * getUserquerydata 
 *  this function executes query for MY progress and Team Progresss Block and Generate
 *  all the users  Data and Return the result Array for Re-structures the data for further processing
 *                
 * @param {int}  userid - id of user of which the block data will be generated
 * @param {string} queryfor - Default : SELF - for My progress and TEAM - for Team Progress
 */
function getUserQueryData($userid, $queryfor = 'SELF')
{

    global $DB, $USER;
    //$userid = $USER->id;
    $newsql = "SELECT  @s:=@s+1 as 'id',u.id as 'userid',u.firstname,u.lastname,c.id as 'courseid',c.fullname as 'coursename',
                IF((select ue.id from mdl_user_enrolments as ue join mdl_enrol as e on ue.enrolid =e.id where ue.userid = u.id and e.courseid =c.id)IS NULL,False,True) as isenrolled,
                (CASE
                WHEN m.name = 'label' then (select name from mdl_label where id = cm.instance ORDER BY id desc limit 1)
                WHEN m.name = 'assign' then (select name from mdl_assign where id = cm.instance ORDER BY id desc limit 1)
                WHEN m.name = 'quiz' then (select name FROM mdl_quiz where id = cm.instance ORDER BY id desc limit 1)
                WHEN m.name = 'scorm' then (select name FROM mdl_scorm where id = cm.instance ORDER BY id desc limit 1)
                WHEN m.name = 'feedback' then (select name from mdl_feedback where id = cm.instance ORDER BY id desc limit 1)
                #WHEN m.name = 'hvp' then (select name from mdl_hvp where id = cm.instance ORDER BY id desc limit 1)
                WHEN m.name = 'forum' then (select name from mdl_forum where id = cm.instance  ORDER BY id desc limit 1)
                WHEN m.name = 'url' then (select name from mdl_url where id = cm.instance  ORDER BY id desc limit 1)
                WHEN m.name = 'page' then (select name from mdl_page where id = cm.instance  ORDER BY id desc limit 1)
                WHEN m.name = 'resource' then (select name from mdl_resource where id = cm.instance  ORDER BY id desc limit 1)
                #WHEN m.name = 'certificate' then (select name from mdl_certificate where id = cm.instance  ORDER BY id desc limit 1)
                WHEN m.name = 'zingilt' then (select name from mdl_zingilt where id = cm.instance  ORDER BY id desc limit 1)
                WHEN m.name = 'lesson' then (select name from mdl_lesson where id = cm.instance  ORDER BY id desc limit 1)
                ELSE '-'
                END) AS 'activityname'
                ,IF((select cmc.completionstate from mdl_course_modules_completion as cmc where cmc.coursemoduleid = cm.id and cmc.userid=u.id)>0 ,true,false) as 'iscompleted'
                from mdl_user as u ,mdl_course as c 
                JOIN `mdl_course_modules` as cm on c.id = cm.course
                join mdl_modules as m on cm.module =m.id
                ,(SELECT @s:= 0) AS s
                WHERE u.id !=1 and m.name not in('forum','label') " .
        ($queryfor == 'SELF' ? "AND u.id= " . $userid . ' ' : ' and u.reporting_manager_code=(select employee_code from mdl_user where id=' . $userid . ')') .
        // ' and u.reporting_manager_code=(select employee_code from mdl_user where id=' . $userid . ')' . (is_siteadmin() ? '' :)
        " ORDER BY `u`.`id` ASC";
    $rs = $DB->get_records_sql($newsql);
    $progressData = array_values($rs);
    return $progressData;
}

function processCourseCompletionData($data)
{
    global $DB;
    $courseData = restructuredData($data);
    if ($courseData != null) {
        if ($courseData !== null && $courseData->rawData !== null) {
            $completedCourses = 0;
            $totalModules = 0;
            $completedModules = 0;
            $totalCourses = 0;
            $rawData = $courseData->rawData;
            foreach ($rawData as $k => $x) {
                $courseCompleted = 0;
                $cdata = $x;
                $cdata->courseId = intval($x->courseid);
                $cdata->courseName = $x->coursename;
                if ($cdata->completedmodules === $cdata->totalmodules) {
                    $courseCompleted = 1;
                    $completedCourses++;
                }
                $totalModules = $totalModules + intval($cdata->totalmodules);
                $completedModules = $completedModules + intval($cdata->completedmodules);
                $totalCourses++;
                $cdata->totalModule = intval($cdata->totalmodules);
                $cdata->completedModule = intval($cdata->completedModules);
                $cdata->courseCompleted = $courseCompleted;
                unset($cdata->totalmodules);
                unset($cdata->completedmodules);
                unset($cdata->courseid);
                unset($cdata->coursename);

                ////set course Chart data here//////////            
                $newcrdata = restructuredData($cdata);
                $crdata = coursewiseStructure($newcrdata);
                $courseData->childrenData[] = $crdata;
                ////////////////////////
            }
            $summaryData = new stdClass;
            $summaryData->totalCourses = $totalCourses;
            $summaryData->completedCourses = $completedCourses;
            $summaryData->inCompleteCourses = $totalCourses - $completedCourses;

            $summaryData->completionPercentage = ($completedCourses / $totalCourses) * 100;
            $summaryData->nonCompletionPercentage = (($totalCourses - $completedCourses) / $totalCourses) * 100;
            $summaryData->totalModules = $totalModules;
            $summaryData->completedModules = $completedModules;
            $summaryData->incompleteModules = $totalModules - $completedModules;
            global $USER, $PAGE;
            $PAGE->set_context(context_system::instance());
            $user_obj = $DB->get_record('user', array('id' => $USER->id));
            $userpicture = new \user_picture($user_obj);
            $userpicture->size = 1;
            $userPic = $userpicture->get_url($PAGE)->out(false);
            $summaryData->userPic = $userPic;

            $courseData->summaryData = $summaryData;

            $chartData = [];
            $additionalDataArr = [];
            $additionalDataArr[] = $addDataTotalCourses = (object) array('dataKey' => "Total Courses", 'dataValue' => $courseData->summaryData->totalCourses);
            $additionalDataArr[] = $addDataTotalModules = (object) array('dataKey' => "Total Modules", 'dataValue' => $courseData->summaryData->totalModules);
            $additionalDataArr[] = $addDataCompletedModules = (object) array('dataKey' => "Completed Modules", 'dataValue' => $courseData->summaryData->completedModules);
            $addDataIncompleteModules = (object) array('dataKey' => "Incomplete Modules", 'dataValue' => $courseData->summaryData->incompleteModules);

            //additionalDataArr.push(addDataTotalCourses);
            //additionalDataArr.push(addDataTotalModules);
            //additionalDataArr.push(addDataCompletedModules);
            $completedCoursesObj = (object) [
                'dataKey' => 'Completed',
                'dataValue' => $courseData->summaryData->completedCourses,
                'dataPercentage' => $courseData->summaryData->completionPercentage,
                'dataAdditional' => $additionalDataArr
            ];

            $additionalDataArr = [];
            $additionalDataArr[] = $addDataTotalCourses;
            $additionalDataArr[] = $addDataTotalModules;
            $additionalDataArr[] = $addDataIncompleteModules;

            $incompleteCoursesObj = (object) [
                'dataKey' => 'Incomplete',
                'dataValue' => $courseData->summaryData->inCompleteCourses,
                'dataPercentage' => $courseData->summaryData->nonCompletionPercentage,
                'dataAdditional' => $additionalDataArr
            ];
            $additionalDataArr = [];
            $additionalDataArr[] = $addDataTotalCourses;
            $additionalDataArr[] = $addDataTotalModules;
            $additionalDataArr[] = $addDataIncompleteModules;

            /*@Todo:aditya: delete this, this is testing data */
            $chartData[] = $completedCoursesObj;
            $chartData[] = $incompleteCoursesObj;

            $courseData->chartInfo->data = $chartData;
            //logDebugMessage(chartData);
        }
    }
    //logDebugMessage(courseData);
    return $courseData;
}

function coursewiseStructureold($rdata)
{

    $courseCompleted = 0;
    $courseData = $rdata->rawData;
    if ($courseData->completedModules === $courseData->totalModules) {
        $courseCompleted = 1;
    }
    $notcompletedModules = $courseData->totalModules - $courseData->completedModules;
    $summaryData = new stdClass;


    $courseData->courseCompleted = $courseCompleted;
    $courseData->incompleteModules = $notcompletedModules;
    $courseData->completionPercentage = ($courseData->completedModules / $courseData->totalModules) * 100;
    $courseData->incompletionPercentage = ($courseData->incompleteModules / $courseData->totalModules) * 100;
    //console.log(courseData);

    $rdata->summaryData = $courseData;
    //echo "<pre>";print_r($courseData);die;

    $chartData = [];
    $additionalDataArr = [];
    //let addDataTotalCourses = {dataKey: "Total Courses", dataValue: };
    $additionalDataArr[] = $courseName = (object) ['dataKey' => "Course Name", 'dataValue' => $courseData->courseName];
    $additionalDataArr[] = $addDataTotalModules = (object) ['dataKey' => "Total Modules", 'dataValue' => $courseData->totalModules];
    $additionalDataArr[] = $addDataCompletedModules = ['dataKey' => "Completed Modules", 'dataValue' => $courseData->completedModules];
    $addDataIncompleteModules = ['dataKey' => "Incomplete Modules", 'dataValue' => $courseData->incompleteModules];

    $completedCoursesObj = (object) [
        'dataKey' => 'Completed Activities',
        'dataValue' => $courseData->completedModules,
        'dataPercentage' => $courseData->completionPercentage,
        'dataAdditional' => $additionalDataArr
    ];

    $additionalDataArr = [];
    // additionalDataArr.push(addDataTotalCourses);
    $additionalDataArr[] = $courseName;
    $additionalDataArr[] = $addDataTotalModules;
    $additionalDataArr[] = $addDataIncompleteModules;
    $incompleteCoursesObj =  (object) [
        'dataKey' => 'Incomplete Activities',
        'dataValue' => $courseData->incompleteModules,
        'dataPercentage' => $courseData->incompletionPercentage,
        'dataAdditional' => $additionalDataArr
    ];
    $additionalDataArr = [];
    $additionalDataArr[] = $addDataTotalModules;
    $additionalDataArr[] = $addDataIncompleteModules;

    $chartData[] = $completedCoursesObj;
    $chartData[] = $incompleteCoursesObj;
    $rdata->chartInfo->data = $chartData;
    $rdata->dataDownloadAllowed = false;
    unset($rdata->childrenData);
    return $rdata;
}

/**
 * teamCourseCompletionData 
 *  this function calculates all the required calculations for the all the subordinate courses data
 * and generate the structured JSON structure for the chart to be generated 
 *                
 * @param {array}  data - Array data generated by the query 
 * @return {array} courseData - Return the Course Data array in structured formate
 */
function teamCourseCompletionData($data)
{
    global $DB;
    //echo "<pre>";//print_r($data);//die;
    $courseData = restructuredData($data);
    if ($data != null) {
        $totalcc = [];
        $totalcc1 = [];
        $a = [];
        $b = [];
        $teamtotalModules = 0;
        $teamcompletedModules = 0;
        $teamtotalEnrolled = 0;
        $teamtotalCourses = 0;
        $teamcompletedCourses = 0;

        $completedCourses = [];
        $totalModules = [];
        $completedModules = [];
        $totalCourses = [];
        $totalEnrolled = [];
        foreach ($data as $r) {
            if ($r->isenrolled == 1) {
                $teamtotalModules++;
                if ($r->iscompleted == 1) {
                    $teamcompletedModules++;
                }
                if (!isset($totalModules[$r->userid])) {
                    $totalModules[$r->userid] = 0;
                }
                $totalModules[$r->userid]++;

                if ($r->iscompleted == 1) {
                    if (!isset($completedModules[$r->userid])) {
                        $completedModules[$r->userid] = 0;
                    }
                    $completedModules[$r->userid]++;
                }
                if (!isset($totalCourses[$r->userid][$r->courseid])) {
                    $totalCourses[$r->userid][$r->courseid] = 0;
                }
                $totalCourses[$r->userid][$r->courseid] = 1;
                //   $completedcoursecount++;

                $course = $DB->get_record("course", array("id" => $r->courseid));
                $percentage = progress::get_course_progress_percentage($course, $r->userid);
                if (intval($percentage) == 100) {
                    if (!isset($completedCourses[$r->userid][$r->courseid])) {
                        $completedCourses[$r->userid][$r->courseid] = 0;
                    }
                    $completedCourses[$r->userid][$r->courseid] = 1;
                }
                $final = array();
                array_walk_recursive($totalCourses, function ($item, $key) use (&$final) {
                    $final[$key] = isset($final[$key]) ?  $item + $final[$key] : $item;
                });
                $final1 = array();
                array_walk_recursive($completedCourses, function ($item, $key) use (&$final1) {
                    $final1[$key] = isset($final1[$key]) ?  $item + $final1[$key] : $item;
                });
                $teamtotalCourses = array_sum($final);
                $teamcompletedCourses  = array_sum($final1);
            } else {
                if (!isset($totalModules[$r->userid])) {
                    $totalModules[$r->userid] = 0;
                }
                if (!isset($completedModules[$r->userid])) {
                    $completedModules[$r->userid] = 0;
                }
                if (!isset($completedCourses[$r->userid][$r->courseid])) {
                    $completedCourses[$r->userid][$r->courseid] = 0;
                }
                if (!isset($totalCourses[$r->userid][$r->courseid])) {
                    $totalCourses[$r->userid][$r->courseid] = 0;
                }
            }
            if (!(isset($arr[$r->userid]) && $arr[$r->userid] != null)) {
                $arr[$r->userid] = new stdClass;
            }
            $arr[$r->userid]->userId = $r->userid;
            $arr[$r->userid]->firstName = $r->firstname;
            $arr[$r->userid]->lastName = $r->lastname;
            global $USER, $PAGE;
            $PAGE->set_context(context_system::instance());
            $user_obj = $DB->get_record('user', array('id' => $r->userid));
            $userpicture = new \user_picture($user_obj);
            $userpicture->size = 1;
            $userPic = $userpicture->get_url($PAGE)->out(false);
            $arr[$r->userid]->userPic = $userPic;

            $arr[$r->userid]->totalModules = (isset($totalModules[$r->userid]) && $totalModules[$r->userid] != '' ? $totalModules[$r->userid] : 0);
            $arr[$r->userid]->completedModules = (isset($completedModules[$r->userid]) && $completedModules[$r->userid] != '' ? $completedModules[$r->userid] : 0);
            $arr[$r->userid]->totalCourses = (isset($totalCourses[$r->userid]) && $totalCourses[$r->userid] != '' ? array_sum($totalCourses[$r->userid]) : 0);
            $arr[$r->userid]->completedCourses = (isset($completedCourses[$r->userid]) && $completedCourses[$r->userid] != '' ? array_sum($completedCourses[$r->userid]) : 0);
        }


        ////set Userwise Chart data here//////////            
        if ($arr != null) {
            $userdata = array_values($arr);
            foreach ($userdata as $u) {
                $newcrdata = restructuredData($u);
                //  $newcrdata->summaryData = $u;
                // unset($newcrdata->childrenData);
                $crdata = userwiseStructure($newcrdata);
                $courseData->childrenData[] = $newcrdata;
            }
        }
        ////////////////////////

        // $teamtotalCourses = array_sum($final);
        // $teamcompletedCourses = array_sum($final1);
        // $teamtotalModules = $totalModules;
        // $teamcompletedModules = $completedModules;

        $summaryData = new stdClass;
        $summaryData->totalCourses = $teamtotalCourses;
        $summaryData->completedCourses = $teamcompletedCourses;
        $summaryData->inCompleteCourses = $teamtotalCourses - $teamcompletedCourses;

        $summaryData->completionPercentage = ($teamcompletedCourses != 0 ? intval(($teamcompletedCourses / $teamtotalCourses) * 100) : 0);
        $summaryData->nonCompletionPercentage = (($teamtotalCourses - $teamcompletedCourses) != 0 ? intval((($teamtotalCourses - $teamcompletedCourses) / $teamtotalCourses) * 100) : 0);
        $summaryData->totalModules = $teamtotalModules;
        $summaryData->completedModules = $teamcompletedModules;
        $summaryData->incompleteModules = $teamtotalModules - $teamcompletedModules;
        $courseData->summaryData = $summaryData;

        $chartData = [];
        $additionalDataArr = [];
        $additionalDataArr[] = $addDataTotalCourses = (object) array('dataKey' => "Total Courses", 'dataValue' => $courseData->summaryData->totalCourses);
        $additionalDataArr[] = $addDataTotalModules = (object) array('dataKey' => "Total Modules", 'dataValue' => $courseData->summaryData->totalModules);
        $additionalDataArr[] = $addDataCompletedModules = (object) array('dataKey' => "Completed Modules", 'dataValue' => $courseData->summaryData->completedModules);
        $addDataIncompleteModules = (object) array('dataKey' => "Incomplete Modules", 'dataValue' => $courseData->summaryData->incompleteModules);

        //additionalDataArr.push(addDataTotalCourses);
        //additionalDataArr.push(addDataTotalModules);
        //additionalDataArr.push(addDataCompletedModules);
        $completedCoursesObj = (object) [
            'dataKey' => 'Completed',
            'dataValue' => $courseData->summaryData->completedCourses,
            'dataPercentage' => $courseData->summaryData->completionPercentage,
            'dataAdditional' => $additionalDataArr
        ];

        $additionalDataArr = [];
        $additionalDataArr[] = $addDataTotalCourses;
        $additionalDataArr[] = $addDataTotalModules;
        $additionalDataArr[] = $addDataIncompleteModules;

        $incompleteCoursesObj = (object) [
            'dataKey' => 'Incomplete',
            'dataValue' => $courseData->summaryData->inCompleteCourses,
            'dataPercentage' => $courseData->summaryData->nonCompletionPercentage,
            'dataAdditional' => $additionalDataArr
        ];
        $additionalDataArr = [];
        $additionalDataArr[] = $addDataTotalCourses;
        $additionalDataArr[] = $addDataTotalModules;
        $additionalDataArr[] = $addDataIncompleteModules;


        $chartData[] = $completedCoursesObj;
        $chartData[] = $incompleteCoursesObj;

        $courseData->chartInfo->data = $chartData;
    }

    //logDebugMessage(courseData);
    //print_r($courseData);
    // echo json_encode($courseData);
    return $courseData;
}

/**
 * userwiseStructure
 *  this function individual Users Structured data for Chart
 *                
 * @param {array}  data - Array data generated by the query 
 * @return {array} courseData - Return the Course Data array in structured formate
 */
function userwiseStructure($rdata)
{

    $courseCompleted = 0;
    $courseData = $rdata->rawData;

    if ($courseData->completedModules === $courseData->totalModules) {
        $courseCompleted = 1;
    }
    $notcompletedModules = $courseData->totalModules - $courseData->completedModules;
    $summaryData = new stdClass;


    $courseData->courseCompleted = $courseCompleted;
    $courseData->incompleteModules = $notcompletedModules;
    $courseData->completionPercentage = (isset($courseData->completedModules) && $courseData->completedModules != 0 ? (($courseData->completedModules / $courseData->totalModules) * 100) : 0);
    $courseData->incompletionPercentage = (isset($courseData->completedModules) && $courseData->completedModules != 0 ? (($courseData->incompleteModules / $courseData->totalModules) * 100) : 0);
    //console.log(courseData);

    $rdata->summaryData = $courseData;
    //echo "<pre>";print_r($courseData);die;

    $chartData = [];
    $additionalDataArr = [];
    //let addDataTotalCourses = {dataKey: "Total Courses", dataValue: };
    $additionalDataArr[] = $courseName = (object) ['dataKey' => "User Name", 'dataValue' => $courseData->firstName . ' ' . $courseData->lastName];
    $additionalDataArr[] = $addDataTotalModules = (object) ['dataKey' => "Total Modules", 'dataValue' => $courseData->totalModules];
    $additionalDataArr[] = $addDataCompletedModules = ['dataKey' => "Completed Modules", 'dataValue' => $courseData->completedModules];
    $addDataIncompleteModules = ['dataKey' => "Incomplete Modules", 'dataValue' => $courseData->incompleteModules];

    $completedCoursesObj = (object) [
        'dataKey' => 'Completed Activities',
        'dataValue' => $courseData->completedModules,
        'dataPercentage' => $courseData->completionPercentage,
        'dataAdditional' => $additionalDataArr
    ];

    $additionalDataArr = [];
    // additionalDataArr.push(addDataTotalCourses);
    $additionalDataArr[] = $courseName;
    $additionalDataArr[] = $addDataTotalModules;
    $additionalDataArr[] = $addDataIncompleteModules;
    $incompleteCoursesObj =  (object) [
        'dataKey' => 'Incomplete Activities',
        'dataValue' => $courseData->incompleteModules,
        'dataPercentage' => $courseData->incompletionPercentage,
        'dataAdditional' => $additionalDataArr
    ];
    $additionalDataArr = [];
    $additionalDataArr[] = $addDataTotalModules;
    $additionalDataArr[] = $addDataIncompleteModules;

    $chartData[] = $completedCoursesObj;
    $chartData[] = $incompleteCoursesObj;
    $rdata->chartInfo->data = $chartData;
    $rdata->dataDownloadAllowed = false;
    unset($rdata->childrenData);
    return $rdata;
}
/**
 * course_image  
 *  this function to generate Course Image and return URL of the course Pic
 */
function course_image($set_course_id)
{
    global $CFG;

    $courseid = new stdClass();
    $courseid->id = $set_course_id;

    $course   = new core_course_list_element($courseid);
    $imageurl = '';
    $outputimage = '';
    foreach ($course->get_course_overviewfiles() as $file) {
        if ($file->is_valid_image()) {
            $imagepath = '/' . $file->get_contextid() .
                '/' . $file->get_component() .
                '/' . $file->get_filearea() .
                $file->get_filepath() .
                $file->get_filename();
            $imageurl = file_encode_url(
                $CFG->wwwroot . '/pluginfile.php',
                $imagepath,
                false
            );

            /* $outputimage = html_writer::tag('div',
	                html_writer::empty_tag('img', array('src' => $imageurl)),
	                array('class' => 'courseimage'));*/


            // Use the first image found.
            break;
        }
    }
    // return $outputimage;
    return $imageurl;
}


/**
 * myProgressCourseCompletionData 
 *  this function calculates all the required calculations for the all the current users courses data
 * and generate the structured JSON structure for the chart to be generated 
 *                
 * @param {array}  data - Array data generated by the query 
 * @return {array} courseData - Return the Course Data array in structured formate
 */
function myProgressCourseCompletionData($data)
{
    global $DB;
    // echo "<pre>";//print_r($data);die;
    $courseData = restructuredData($data);
    if ($data != null) {
        $totalcc = [];
        $totalcc1 = [];
        $a = [];
        $b = [];
        $teamtotalModules = 0;
        $teamcompletedModules = 0;
        $teamtotalEnrolled = 0;
        $teamtotalCourses = 0;
        $teamcompletedCourses = 0;

        $completedCourses = [];
        $totalModules = [];
        $completedModules = [];
        $totalCourses = [];
        $totalEnrolled = [];

        $totalcourseModules = [];
        $completedcourseModules = [];

        foreach ($data as $r) {
            if ($r->isenrolled == 1) {
                $teamtotalModules++;
                if ($r->iscompleted == 1) {
                    $teamcompletedModules++;
                }
                if (!isset($totalModules[$r->userid])) {
                    $totalModules[$r->userid] = 0;
                }
                $totalModules[$r->userid]++;

                if (!isset($totalcourseModules[$r->userid][$r->courseid])) {
                    $totalcourseModules[$r->userid][$r->courseid] = 0;
                }
                $totalcourseModules[$r->userid][$r->courseid]++;

                if ($r->iscompleted == 1) {
                    if (!isset($completedModules[$r->userid])) {
                        $completedModules[$r->userid] = 0;
                    }
                    $completedModules[$r->userid]++;
                    if (!isset($completedcourseModules[$r->userid][$r->courseid])) {
                        $completedcourseModules[$r->userid][$r->courseid] = 0;
                    }
                    $completedcourseModules[$r->userid][$r->courseid]++;
                }
                if (!isset($totalCourses[$r->userid][$r->courseid])) {
                    $totalCourses[$r->userid][$r->courseid] = 0;
                }
                $totalCourses[$r->userid][$r->courseid] = 1;
                //   $completedcoursecount++;

                $course = $DB->get_record("course", array("id" => $r->courseid));
                $percentage = progress::get_course_progress_percentage($course, $r->userid);
                if (intval($percentage) == 100) {
                    if (!isset($completedCourses[$r->userid][$r->courseid])) {
                        $completedCourses[$r->userid][$r->courseid] = 0;
                    }
                    $completedCourses[$r->userid][$r->courseid] = 1;
                }
                $final = array();
                array_walk_recursive($totalCourses, function ($item, $key) use (&$final) {
                    $final[$key] = isset($final[$key]) ?  $item + $final[$key] : $item;
                });
                $final1 = array();
                array_walk_recursive($completedCourses, function ($item, $key) use (&$final1) {
                    $final1[$key] = isset($final1[$key]) ?  $item + $final1[$key] : $item;
                });
                $teamtotalCourses = array_sum($final);
                $teamcompletedCourses  = array_sum($final1);
                if (!isset($courses[$r->courseid])) {
                    $courses[$r->courseid] = new stdClass;
                }
                $courses[$r->courseid]->courseId = $r->courseid;
                $courses[$r->courseid]->courseName = $r->coursename;
                $courses[$r->courseid]->coursePic = course_image($r->courseid);
                $courses[$r->courseid]->totalModules = (isset($totalcourseModules[$r->userid]) && $totalcourseModules[$r->userid] != '' ? array_sum($totalcourseModules[$r->userid]) : 0);
                $courses[$r->courseid]->completedModules = (isset($completedcourseModules[$r->userid]) && $completedcourseModules[$r->userid] != '' ? array_sum($completedcourseModules[$r->userid]) : 0);
            } else {
                if (!isset($totalModules[$r->userid])) {
                    $totalModules[$r->userid] = 0;
                }
                if (!isset($completedModules[$r->userid])) {
                    $completedModules[$r->userid] = 0;
                }
                if (!isset($completedCourses[$r->userid][$r->courseid])) {
                    $completedCourses[$r->userid][$r->courseid] = 0;
                }
                if (!isset($totalCourses[$r->userid][$r->courseid])) {
                    $totalCourses[$r->userid][$r->courseid] = 0;
                }
                if (!isset($courses[$r->courseid])) {
                    $courses[$r->courseid] = [];
                }
            }

            if (!(isset($arr[$r->userid]) && $arr[$r->userid] != null)) {
                $arr[$r->userid] = new stdClass;
            }
            $arr[$r->userid]->userId = $r->userid;
            $arr[$r->userid]->firstName = $r->firstname;
            $arr[$r->userid]->lastName = $r->lastname;
            global $USER, $PAGE;
            $PAGE->set_context(context_system::instance());
            $user_obj = $DB->get_record('user', array('id' => $r->userid));
            $userpicture = new \user_picture($user_obj);
            $userpicture->size = 1;
            $userPic = $userpicture->get_url($PAGE)->out(false);
            $arr[$r->userid]->userPic = $userPic;
            $arr[$r->userid]->totalModules = (isset($totalModules[$r->userid]) && $totalModules[$r->userid] != '' ? $totalModules[$r->userid] : 0);
            $arr[$r->userid]->completedModules = (isset($completedModules[$r->userid]) && $completedModules[$r->userid] != '' ? $completedModules[$r->userid] : 0);
            $arr[$r->userid]->totalCourses = (isset($totalCourses[$r->userid]) && $totalCourses[$r->userid] != '' ? array_sum($totalCourses[$r->userid]) : 0);
            $arr[$r->userid]->completedCourses = (isset($completedCourses[$r->userid]) && $completedCourses[$r->userid] != '' ? array_sum($completedCourses[$r->userid]) : 0);
            $arr[$r->userid]->courses = array_values($courses);
        }

        ////set Coursewise Chart data here//////////            
        if ($arr != null) {
            $coursedata = $arr[$USER->id]->courses;
            if ($coursedata != null) {
                foreach ($coursedata as $u) {
                    if ($u != null) {
                        // print_r($u);
                        $newcrdata = restructuredData($u);
                        //  $newcrdata->summaryData = $u;
                        // unset($newcrdata->childrenData);
                        $crdata = coursewiseStructure($newcrdata);
                        //print_r($crdata);die;
                        $courseData->childrenData[] = $crdata;
                    } else {
                    }
                }
            }
        }
        ////////////////////////

        // $teamtotalCourses = array_sum($final);
        // $teamcompletedCourses = array_sum($final1);
        // $teamtotalModules = $totalModules;
        // $teamcompletedModules = $completedModules;

        $summaryData = new stdClass;
        $summaryData->totalCourses = $teamtotalCourses;
        $summaryData->completedCourses = $teamcompletedCourses;
        $summaryData->inCompleteCourses = $teamtotalCourses - $teamcompletedCourses;

        $summaryData->completionPercentage = ($teamcompletedCourses != 0 ? intval(($teamcompletedCourses / $teamtotalCourses) * 100) : 0);
        $summaryData->nonCompletionPercentage = (($teamtotalCourses - $teamcompletedCourses) != 0 ? intval((($teamtotalCourses - $teamcompletedCourses) / $teamtotalCourses) * 100) : 0);
        $summaryData->totalModules = $teamtotalModules;
        $summaryData->completedModules = $teamcompletedModules;
        $summaryData->incompleteModules = $teamtotalModules - $teamcompletedModules;
        $summaryData->userPic = $arr[$USER->id]->userPic;
        $courseData->summaryData = $summaryData;

        $chartData = [];
        $additionalDataArr = [];
        $additionalDataArr[] = $addDataTotalCourses = (object) array('dataKey' => "Total Courses", 'dataValue' => $courseData->summaryData->totalCourses);
        $additionalDataArr[] = $addDataTotalModules = (object) array('dataKey' => "Total Modules", 'dataValue' => $courseData->summaryData->totalModules);
        $additionalDataArr[] = $addDataCompletedModules = (object) array('dataKey' => "Completed Modules", 'dataValue' => $courseData->summaryData->completedModules);
        $addDataIncompleteModules = (object) array('dataKey' => "Incomplete Modules", 'dataValue' => $courseData->summaryData->incompleteModules);

        //additionalDataArr.push(addDataTotalCourses);
        //additionalDataArr.push(addDataTotalModules);
        //additionalDataArr.push(addDataCompletedModules);
        $completedCoursesObj = (object) [
            'dataKey' => 'Completed',
            'dataValue' => $courseData->summaryData->completedCourses,
            'dataPercentage' => $courseData->summaryData->completionPercentage,
            'dataAdditional' => $additionalDataArr
        ];

        $additionalDataArr = [];
        $additionalDataArr[] = $addDataTotalCourses;
        $additionalDataArr[] = $addDataTotalModules;
        $additionalDataArr[] = $addDataIncompleteModules;

        $incompleteCoursesObj = (object) [
            'dataKey' => 'Incomplete',
            'dataValue' => $courseData->summaryData->inCompleteCourses,
            'dataPercentage' => $courseData->summaryData->nonCompletionPercentage,
            'dataAdditional' => $additionalDataArr
        ];
        $additionalDataArr = [];
        $additionalDataArr[] = $addDataTotalCourses;
        $additionalDataArr[] = $addDataTotalModules;
        $additionalDataArr[] = $addDataIncompleteModules;


        $chartData[] = $completedCoursesObj;
        $chartData[] = $incompleteCoursesObj;

        $courseData->chartInfo->data = $chartData;
    }

    //logDebugMessage(courseData);
    //print_r($courseData);
    // echo json_encode($courseData);
    return $courseData;
}
/**
 * coursewiseStructure 
 *  this function calculates all the required calculations for the Individual course Structure
 * and generate the structured JSON structure for the chart to be generated 
 *                
 * @param {array}  data - Array data generated by the query 
 * @return {array} courseData - Return the Course Data array in structured formate
 */
function coursewiseStructure($rdata)
{

    $courseCompleted = 0;
    //print_r($rdata);
    $courseData = $rdata->rawData;

    if ($courseData->completedModules === $courseData->totalModules) {
        $courseCompleted = 1;
    }
    $notcompletedModules = $courseData->totalModules - $courseData->completedModules;
    $summaryData = new stdClass;


    $courseData->courseCompleted = $courseCompleted;
    $courseData->incompleteModules = $notcompletedModules;
    $courseData->completionPercentage = (isset($courseData->completedModules) && $courseData->completedModules != 0 ? (($courseData->completedModules / $courseData->totalModules) * 100) : 0);
    $courseData->incompletionPercentage = (isset($courseData->completedModules) && $courseData->completedModules != 0 ? (($courseData->incompleteModules / $courseData->totalModules) * 100) : 0);
    $courseData->coursePic = $courseData->coursePic;
    //console.log(courseData);

    $rdata->summaryData = $courseData;
    //echo "<pre>";print_r($courseData);die;

    $chartData = [];
    $additionalDataArr = [];
    //let addDataTotalCourses = {dataKey: "Total Courses", dataValue: };
    $additionalDataArr[] = $courseName = (object) ['dataKey' => "Course Name", 'dataValue' => $courseData->courseName];
    $additionalDataArr[] = $addDataTotalModules = (object) ['dataKey' => "Total Modules", 'dataValue' => $courseData->totalModules];
    $additionalDataArr[] = $addDataCompletedModules = ['dataKey' => "Completed Modules", 'dataValue' => $courseData->completedModules];
    $addDataIncompleteModules = ['dataKey' => "Incomplete Modules", 'dataValue' => $courseData->incompleteModules];

    $completedCoursesObj = (object) [
        'dataKey' => 'Completed Activities',
        'dataValue' => $courseData->completedModules,
        'dataPercentage' => $courseData->completionPercentage,
        'dataAdditional' => $additionalDataArr
    ];

    $additionalDataArr = [];
    // additionalDataArr.push(addDataTotalCourses);
    $additionalDataArr[] = $courseName;
    $additionalDataArr[] = $addDataTotalModules;
    $additionalDataArr[] = $addDataIncompleteModules;
    $incompleteCoursesObj =  (object) [
        'dataKey' => 'Incomplete Activities',
        'dataValue' => $courseData->incompleteModules,
        'dataPercentage' => $courseData->incompletionPercentage,
        'dataAdditional' => $additionalDataArr
    ];
    $additionalDataArr = [];
    $additionalDataArr[] = $addDataTotalModules;
    $additionalDataArr[] = $addDataIncompleteModules;

    $chartData[] = $completedCoursesObj;
    $chartData[] = $incompleteCoursesObj;
    $rdata->chartInfo->data = $chartData;
    $rdata->dataDownloadAllowed = false;
    unset($rdata->childrenData);
    return $rdata;
}
///////////////////////////////function for mobile development

function pivotstructureData($data,$userid)
{
    global $DB;
    $arr = array();
    if ($data != null) {
        $totalcc = [];
        $totalcc1 = [];
        $a = [];
        $b = [];
        $teamtotalModules = 0;
        $teamcompletedModules = 0;
        $teamtotalEnrolled = 0;
        $teamtotalCourses = 0;
        $teamcompletedCourses = 0;

        $completedCourses = [];
        $totalModules = [];
        $completedModules = [];
        $totalCourses = [];
        $totalEnrolled = [];

        $totalcourseModules = [];
        $completedcourseModules = [];

        foreach ($data as $r) {
            if ($r->isenrolled == 1) {
                $teamtotalModules++;
                if ($r->iscompleted == 1) {
                    $teamcompletedModules++;
                }
                if (!isset($totalModules[$r->userid])) {
                    $totalModules[$r->userid] = 0;
                }
                $totalModules[$r->userid]++;

                if (!isset($totalcourseModules[$r->userid][$r->courseid])) {
                    $totalcourseModules[$r->userid][$r->courseid] = 0;
                }
                $totalcourseModules[$r->userid][$r->courseid]++;

                if ($r->iscompleted == 1) {
                    if (!isset($completedModules[$r->userid])) {
                        $completedModules[$r->userid] = 0;
                    }
                    $completedModules[$r->userid]++;
                    if (!isset($completedcourseModules[$r->userid][$r->courseid])) {
                        $completedcourseModules[$r->userid][$r->courseid] = 0;
                    }
                    $completedcourseModules[$r->userid][$r->courseid]++;
                }
                if (!isset($totalCourses[$r->userid][$r->courseid])) {
                    $totalCourses[$r->userid][$r->courseid] = 0;
                }
                $totalCourses[$r->userid][$r->courseid] = 1;
                //   $completedcoursecount++;

                $course = $DB->get_record("course", array("id" => $r->courseid));
                $percentage = progress::get_course_progress_percentage($course, $r->userid);
                if (intval($percentage) == 100) {
                    if (!isset($completedCourses[$r->userid][$r->courseid])) {
                        $completedCourses[$r->userid][$r->courseid] = 0;
                    }
                    $completedCourses[$r->userid][$r->courseid] = 1;
                }
                $final = array();
                array_walk_recursive($totalCourses, function ($item, $key) use (&$final) {
                    $final[$key] = isset($final[$key]) ?  $item + $final[$key] : $item;
                });
                $final1 = array();
                array_walk_recursive($completedCourses, function ($item, $key) use (&$final1) {
                    $final1[$key] = isset($final1[$key]) ?  $item + $final1[$key] : $item;
                });
                $teamtotalCourses = array_sum($final);
                $teamcompletedCourses  = array_sum($final1);
                if (!isset($courses[$r->courseid])) {
                    $courses[$r->courseid] = new stdClass;
                }
                $courses[$r->courseid]->courseId = $r->courseid;
                $courses[$r->courseid]->courseName = $r->coursename;
                $courses[$r->courseid]->coursePic = course_image($r->courseid);
                $courses[$r->courseid]->totalModules = (isset($totalcourseModules[$r->userid]) && $totalcourseModules[$r->userid] != '' ? array_sum($totalcourseModules[$r->userid]) : 0);
                $courses[$r->courseid]->completedModules = (isset($completedcourseModules[$r->userid]) && $completedcourseModules[$r->userid] != '' ? array_sum($completedcourseModules[$r->userid]) : 0);
            } else {
                if (!isset($totalModules[$r->userid])) {
                    $totalModules[$r->userid] = 0;
                }
                if (!isset($completedModules[$r->userid])) {
                    $completedModules[$r->userid] = 0;
                }
                if (!isset($completedCourses[$r->userid][$r->courseid])) {
                    $completedCourses[$r->userid][$r->courseid] = 0;
                }
                if (!isset($totalCourses[$r->userid][$r->courseid])) {
                    $totalCourses[$r->userid][$r->courseid] = 0;
                }
                /*if (!isset($courses[$r->courseid])) {
                    $courses[$r->courseid] = null;
                }*/
            }

            if (!(isset($arr[$r->userid]) && $arr[$r->userid] != null)) {
                $arr[$r->userid] = new stdClass;
            }
            $arr[$r->userid]->userId = $r->userid;
            $arr[$r->userid]->firstName = $r->firstname;
            $arr[$r->userid]->lastName = $r->lastname;
            global $USER, $PAGE;
            $PAGE->set_context(context_system::instance());
            $user_obj = $DB->get_record('user', array('id' => $r->userid));
            $userpicture = new \user_picture($user_obj);
            $userpicture->size = 1;
            $userPic = $userpicture->get_url($PAGE)->out(false);
            $arr[$r->userid]->userPic = $userPic;
            $arr[$r->userid]->totalModules = (isset($totalModules[$r->userid]) && $totalModules[$r->userid] != '' ? $totalModules[$r->userid] : 0);
            $arr[$r->userid]->completedModules = (isset($completedModules[$r->userid]) && $completedModules[$r->userid] != '' ? $completedModules[$r->userid] : 0);
            $arr[$r->userid]->totalCourses = (isset($totalCourses[$r->userid]) && $totalCourses[$r->userid] != '' ? array_sum($totalCourses[$r->userid]) : 0);
            $arr[$r->userid]->completedCourses = (isset($completedCourses[$r->userid]) && $completedCourses[$r->userid] != '' ? array_sum($completedCourses[$r->userid]) : 0);
            $arr[$r->userid]->courses = array_values($courses);
        }
    }
    
    $cdata = coursewiseMyprogress($arr,$userid);
    // print_r($cdata);
    return $arr;
}
function coursewiseMyprogress($rdata,$userid)
{
   // global $USER;
    $coursearr = null;
    ////set Coursewise Chart data here//////////            
    if ($rdata != null) {
        $coursedata = $rdata[$userid]->courses;
        if ($coursedata != null && count($coursedata)>0) 
        {
            foreach ($coursedata as $u) {
                if ($u != null) {
                    $courseCompleted = 0;
                    $courseData = $u; //->rawData;
                    if ($courseData->completedModules === $courseData->totalModules) {
                        $courseCompleted = 1;
                    }
                    $notcompletedModules = $courseData->totalModules - $courseData->completedModules;
                    $summaryData = new stdClass;


                    $courseData->courseCompleted = $courseCompleted;
                    $courseData->incompleteModules = $notcompletedModules;
                    $courseData->completionPercentage = (isset($courseData->completedModules) && $courseData->completedModules != 0 ? intval(($courseData->completedModules / $courseData->totalModules) * 100) : 0);
                    $courseData->incompletionPercentage = (isset($courseData->completedModules) && $courseData->completedModules != 0 ? intval(($courseData->incompleteModules / $courseData->totalModules) * 100) : 0);
                    $courseData->coursePic = $courseData->coursePic;
                    //console.log(courseData);
                    //print_r($courseData);
                    $coursearr[] = $courseData;
                    // $rdata->summaryData = $courseData;
                }

            }
        }
        else{
            unset($rdata[$userid]->courses);
        }
    }
    return $rdata;
}

function teampivotstructureData($data,$userid)
{
    global $DB;
    $arr = array();
    if ($data != null) {
        $totalcc = [];
        $totalcc1 = [];
        $a = [];
        $b = [];
        $teamtotalModules = 0;
        $teamcompletedModules = 0;
        $teamtotalEnrolled = 0;
        $teamtotalCourses = 0;
        $teamcompletedCourses = 0;

        $completedCourses = [];
        $totalModules = [];
        $completedModules = [];
        $totalCourses = [];
        $totalEnrolled = [];
        foreach ($data as $r) {
            if ($r->isenrolled == 1) {
                $teamtotalModules++;
                if ($r->iscompleted == 1) {
                    $teamcompletedModules++;
                }
                if (!isset($totalModules[$r->userid])) {
                    $totalModules[$r->userid] = 0;
                }
                $totalModules[$r->userid]++;

                if ($r->iscompleted == 1) {
                    if (!isset($completedModules[$r->userid])) {
                        $completedModules[$r->userid] = 0;
                    }
                    $completedModules[$r->userid]++;
                }
                if (!isset($totalCourses[$r->userid][$r->courseid])) {
                    $totalCourses[$r->userid][$r->courseid] = 0;
                }
                $totalCourses[$r->userid][$r->courseid] = 1;
                //   $completedcoursecount++;

                $course = $DB->get_record("course", array("id" => $r->courseid));
                $percentage = progress::get_course_progress_percentage($course, $r->userid);
                if (intval($percentage) == 100) {
                    if (!isset($completedCourses[$r->userid][$r->courseid])) {
                        $completedCourses[$r->userid][$r->courseid] = 0;
                    }
                    $completedCourses[$r->userid][$r->courseid] = 1;
                }
                $final = array();
                array_walk_recursive($totalCourses, function ($item, $key) use (&$final) {
                    $final[$key] = isset($final[$key]) ?  $item + $final[$key] : $item;
                });
                $final1 = array();
                array_walk_recursive($completedCourses, function ($item, $key) use (&$final1) {
                    $final1[$key] = isset($final1[$key]) ?  $item + $final1[$key] : $item;
                });
                $teamtotalCourses = array_sum($final);
                $teamcompletedCourses  = array_sum($final1);
            } else {
                if (!isset($totalModules[$r->userid])) {
                    $totalModules[$r->userid] = 0;
                }
                if (!isset($completedModules[$r->userid])) {
                    $completedModules[$r->userid] = 0;
                }
                if (!isset($completedCourses[$r->userid][$r->courseid])) {
                    $completedCourses[$r->userid][$r->courseid] = 0;
                }
                if (!isset($totalCourses[$r->userid][$r->courseid])) {
                    $totalCourses[$r->userid][$r->courseid] = 0;
                }
            }
            if (!(isset($arr[$r->userid]) && $arr[$r->userid] != null)) {
                $arr[$r->userid] = new stdClass;
            }
            $arr[$r->userid]->userId = $r->userid;
            $arr[$r->userid]->firstName = $r->firstname;
            $arr[$r->userid]->lastName = $r->lastname;
            global $USER, $PAGE;
            $PAGE->set_context(context_system::instance());
            $user_obj = $DB->get_record('user', array('id' => $r->userid));
            $userpicture = new \user_picture($user_obj);
            $userpicture->size = 1;
            $userPic = $userpicture->get_url($PAGE)->out(false);
            $arr[$r->userid]->userPic = $userPic;

            $arr[$r->userid]->totalModules = (isset($totalModules[$r->userid]) && $totalModules[$r->userid] != '' ? $totalModules[$r->userid] : 0);
            $arr[$r->userid]->completedModules = (isset($completedModules[$r->userid]) && $completedModules[$r->userid] != '' ? $completedModules[$r->userid] : 0);
            $arr[$r->userid]->totalCourses = (isset($totalCourses[$r->userid]) && $totalCourses[$r->userid] != '' ? array_sum($totalCourses[$r->userid]) : 0);
            $arr[$r->userid]->completedCourses = (isset($completedCourses[$r->userid]) && $completedCourses[$r->userid] != '' ? array_sum($completedCourses[$r->userid]) : 0);
        }
        // print_r($arr);//die;

        ////set Userwise Chart data here//////////            
        if ($arr != null) {
            $userdata = array_values($arr);
            foreach ($userdata as $u) {
                $courseCompleted = 0;
                $courseData = $u;

                if ($courseData->completedModules === $courseData->totalModules && $courseData->totalModules != 0) {
                    $courseCompleted = 1;
                }
                $notcompletedModules = $courseData->totalModules - $courseData->completedModules;
                $courseData = new stdClass;

                $u->courseCompleted = $courseCompleted;
                $u->incompleteCourses = $u->totalCourses - $u->completedCourses;
                $u->incompleteModules = $notcompletedModules;
                $u->completionPercentage = (isset($u->completedModules) && $u->completedModules != 0 ? intval(($u->completedModules / $u->totalModules) * 100) : 0);
                $u->incompletionPercentage = (isset($u->completedModules) && $u->completedModules != 0 ? intval(($u->incompleteModules / $u->totalModules) * 100) : 0);
            }
            $arr = array_values($arr);
        }
    }
    return $arr;
}