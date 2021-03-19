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
 * Task log table.
 *
 * @package    core_admin
 * @copyright  2018 Andrew Nicols <andrew@nicols.co.uk>
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

namespace mod_zingilt;


defined('MOODLE_INTERNAL') || die();
require_once '../../config.php';
require_once 'lib.php';
require_once $CFG->libdir . '/formslib.php';
require_once "classes/resources.php";
//require_once dirname(__FILE__) . '/../../../config.php';
//require_once($CFG->libdir . '/tablelib.php');
//require_once $CFG->libdir . '/formslib.php';
/**
 * Table to display list of Resources.
 *
 * @copyright  2018 Andrew Nicols <andrew@nicols.co.uk>
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
class resources {
    
    /**
     * Constructor for the Resources table.
     *
     * @param   string      $filter
     * @param   int         $resultfilter
     */
    public function __construct() {
       
    }
    public function add($data)
    {
        global $DB, $CFG, $USER;

        if (!empty($data->en_resource_name)) {
            if ($DB->record_exists('resources', array('en_resource_name' => $data->en_resource_name))) {
                throw new moodle_exception(get_string('resourcenametaken'), '', '', $data->en_resource_name);
            }
        }
        /* if ($errorcode = course_validate_dates((array)$data)) {
        throw new moodle_exception($errorcode);
        }*/
        $data->en_resource_desc = $data->en_resource_desc['text'];
        $data->ar_resource_desc = $data->ar_resource_desc['text'];
        $data->startdate = date("Y-m-d H:i:s", $data->startdate);
        $data->enddate = date("Y-m-d H:i:s", $data->enddate);
        $data->overbooking_flag = isset($data->overbooking_flag) ? $data->overbooking_flag : 0;
        $data->isdeleted = 0;
        $data->brief_about_trainer = isset($data->brief_about_trainer) ? $data->brief_about_trainer : "";
        $data->trainer_sign = isset($data->trainer_sign) ? $data->trainer_sign : "";
        $data->created_by = $data->userid;
        $data->created_at = !empty($data->timecreated) ? $data->timecreated : date('Y-m-d H:i:s');
        $data->trainer_request_id = !empty($data->trainer_request_id) ? $data->trainer_request_id : 0;
        $data->updated_by = $data->userid;
        $data->updated_at = time();//$data->timecreated;
        //   echo "<pre>";print_r($data);die("here");
        $data->id = $DB->insert_record('resources', $data);
        return $data->id;
    }
    public function list(){
        global $DB;
        $sql = "SELECT r.id,r.resource_name as resource_name,rs.en_name as resource_type,rs.ar_name,r.startdate,r.enddate FROM {resources} as r JOIN {resource_subtype} as rs ON r.resource_subtype_id = rs.id" ;
        $resources = $DB->get_records_sql($sql);
        return $resources;
    }
    public function edit($data){
        global $DB, $CFG, $USER;

        $data->en_resource_desc = $data->en_resource_desc['text'];
        $data->ar_resource_desc = $data->ar_resource_desc['text'];
        $data->startdate = date("Y-m-d H:i:s", $data->startdate);
        $data->enddate = date("Y-m-d H:i:s", $data->enddate);
        $data->overbooking_flag = isset($data->overbooking_flag) ? $data->overbooking_flag : 0;
        $data->isdeleted = 0;
        $data->brief_about_trainer = isset($data->brief_about_trainer) ? $data->brief_about_trainer : "";
        $data->trainer_sign = isset($data->trainer_sign) ? $data->trainer_sign : "";
        //$data->created_by = $data->userid;
        //$data->created_at = !empty($data->timecreated) ? $data->timecreated : date('Y-m-d H:i:s');
        $data->updated_by = $data->userid;
        $data->updated_at = $data->timecreated;
        // echo "<pre>";print_r($data);die("here");
        $DB->update_record('resources', $data);
        //$data->id = $DB->insert_record('resources', $data);
        return $data->id;
    }
    public function delete($id){

    }
    
}
