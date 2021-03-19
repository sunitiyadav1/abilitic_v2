<?php
/* Progress Block Ajax function Call File - newajaxfile.php 
 *  @author : Kajal Tailor
 * It will return the my progress and Team progress json Data on call of Action
 * @todo:
 * */

use core_completion\progress;

require_once dirname(__FILE__) . '/../../config.php';
require_once 'lib.php';
global $DB, $CFG, $USER, $OUTPUT, $PAGE;
if (isset($_REQUEST['action']) && $_REQUEST['action'] != "") {
    switch ($_REQUEST['action']) {
        case "get_my_progress_mobile":
            //dummy ajax call for tessting data
            //$userdata = my_progress_query($USER->id);
            //echo json_encode($userdata);
            $userdata = getUserQueryData($USER->id, 'SELF');
            echo "<pre>"; //print_r($userdata);
            $udata = pivotstructureData($userdata,$USER->id);
            print_r($udata);
            echo json_encode($udata[$USER->id]->courses);
            //$courseData = coursewiseMyprogress($udata);
            //echo  json_encode($courseData);
            break;
        case "get_team_progress_mobile":
            $userdata = getUserQueryData($USER->id, 'TEAM');
            //print_r($userdata);
            $udata = teampivotstructureData($userdata,$USER->id);
             echo "<pre>";print_r($udata);
           // echo json_encode($udata);
            // $udata = teamCourseCompletionData($userdata);
            break;
        case "get_my_progress":
            //AJax Call for My progress Block
            // $userdata = my_progress_query($USER->id);
            // $udata =processCourseCompletionData($userdata);
            // echo json_encode($udata);   
            $userdata = getUserQueryData($USER->id, 'SELF');
            $courseData = myProgressCourseCompletionData($userdata);
            echo  json_encode($courseData);
            break;
        case "get_team_progress":
           //Ajax Call for Team Progress Block
           if(is_siteadmin()){$udata =[];}
           else{
       $userdata = getUserQueryData($USER->id, 'TEAM');

       $udata = teamCourseCompletionData($userdata);
   }
       // print_r($udata);
       echo json_encode($udata);
            break;
    }
}

