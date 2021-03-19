<?php

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
 * External Web Service Template
 *
 * @package    block_progress
 * @copyright  2020 Kajal Tailor
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

//namespace block_progress;

use block_progress\classes\output\mobile;

defined('MOODLE_INTERNAL') || die();

require_once($CFG->libdir . "/externallib.php");
require_once('lib.php');

class block_progress_external extends external_api {
   
    /**
     * Returns description of method parameters
     *
     * @return external_function_parameters
     * @since Moodle 2.5
     */
    public static function get_myprogress_parameters() {
        return new external_function_parameters(           
                array(
                        'userid' => new external_value(PARAM_INT, 'id of user')
                    )           
                );    
    }

    /**
     * Retrieve My Progress Data in json format 
     *
     * @param array $param array of myprogress innformation
     * @return array of newly created groups
     * @since Moodle 2.5
     */
    public static function get_myprogress($userid) {
        
        $param['str_helloworld'] = "Hello World " .$userid;
        $userdata = getUserQueryData($userid, 'SELF');
        echo "<pre>"; //print_r($userdata);
        $udata = pivotstructureData($userdata,$userid);
        //print_r($udata);
        return $udata[$userid]->courses;
        //echo json_encode($udata[$USER->id]->courses);
        //return $param;
    }

    /**
     * Returns description of method result value
     *
     * @return external_description
     * @since Moodle 2.5
     */
    public static function get_myprogress_returns() {
      return 
            new external_multiple_structure(
                new external_single_structure(
                array(
                    'courseId'  => new external_value(PARAM_INT, 'ID of Course'),
                    'courseName' => new external_value(PARAM_TEXT, 'Name of Course'),
                    'coursePic' => new external_value(PARAM_TEXT, 'Pic URL of Course'),
                    'totalModules' => new external_value(PARAM_INT, 'Total Modules for The Course'),
                    'completedModules' => new external_value(PARAM_INT, 'Completed Modules for this course'),
                    'courseCompleted' => new external_value(PARAM_INT, 'Total Course count completed'),
                    'incompleteModules' => new external_value(PARAM_INT, 'Incomplete Modules count for the course'),
                    'completionPercentage' => new external_value(PARAM_INT, 'Completion Percentage for this user'),
                    'incompletionPercentage' => new external_value(PARAM_INT, 'Incompletion Percentage for this user'),
                )
                )
             );
    }

    
    /**
     * Returns description of method parameters
     *
     * @return external_function_parameters
     * @since Moodle 2.5
     */
    public static function get_teamprogress_parameters() {
        return new external_function_parameters(           
                array(
                        'userid' => new external_value(PARAM_INT, 'id of user')
                    )           
                );    
    }

    /**
     * Retrieve Team Progress Data in json format 
     *
     * @param array $param array of teamprogress innformation
     * @return array of newly created groups
     * @since Moodle 2.5
     */
    public static function get_teamprogress($userid) {
        
        //$param['str_helloworld'] = "Hello World " .$userid;
        $userdata = getUserQueryData($userid, 'SELF');
        //echo "<pre>"; //print_r($userdata);
        $udata = teampivotstructureData($userdata,$userid);
        //print_r($udata);
        return $udata;
        //echo json_encode($udata[$USER->id]->courses);
        //return $param;
    }

    /**
     * Returns description of method result value
     *
     * @return external_description
     * @since Moodle 2.5
     */
    public static function get_teamprogress_returns() {
       
      return 
            new external_multiple_structure(
                new external_single_structure(
                array(
                    'userId'  => new external_value(PARAM_INT, 'ID of User'),
                    'firstName' => new external_value(PARAM_TEXT, 'First Name of User'),
                    'lastName' => new external_value(PARAM_TEXT, 'Last Name of User'),
                    'userPic' => new external_value(PARAM_TEXT, 'Pic URL of User'),
                    'totalModules' => new external_value(PARAM_INT, 'Total Modules Enrolled by User'),
                    'completedModules' => new external_value(PARAM_INT, 'Completed Modules by User'),
                    'totalCourses' => new external_value(PARAM_INT, 'Total Modules for this User'),
                    'completedCourses' => new external_value(PARAM_INT, 'Completed Courses for this User'),
                    'courseCompleted' => new external_value(PARAM_INT, 'Total Course count completed'),                    
                    'incompleteCourses' => new external_value(PARAM_INT, 'Total Course count Incompleted'),
                    'incompleteModules' => new external_value(PARAM_INT, 'Incomplete Modules count for the User'),
                    'completionPercentage' => new external_value(PARAM_INT, 'Completion Percentage for this user'),
                    'incompletionPercentage' => new external_value(PARAM_INT, 'Incompletion Percentage for this user'),
                )
                )
             );
    }
}