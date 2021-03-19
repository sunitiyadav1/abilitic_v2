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
 * Copyright (C) 2007-2011 Catalyst IT (http://www.catalyst.net.nz)
 * Copyright (C) 2011-2013 Totara LMS (http://www.totaralms.com)
 * Copyright (C) 2014 onwards Catalyst IT (http://www.catalyst-eu.net)
 *
 * @package    mod
 * @subpackage zingilt
 * @copyright  2014 onwards Catalyst IT <http://www.catalyst-eu.net>
 * @author     Stacey Walker <stacey@catalyst-eu.net>
 * @author     Alastair Munro <alastair.munro@totaralms.com>
 * @author     Aaron Barnes <aaron.barnes@totaralms.com>
 * @author     Francois Marier <francois@catalyst.net.nz>
 */

defined('MOODLE_INTERNAL') || die();

require_once($CFG->libdir . '/formslib.php');
require_once($CFG->dirroot . '/mod/zingilt/lib.php');

class mod_zingilt_cohort_form extends moodleform
{

  public function definition()
  {
    global $CFG, $DB;
    $mform = &$this->_form;
    $mform->_attributes['id'] = "frmcohort";
    //echo "<pre>";print_r($mform);die;
    //$context = context_course::instance($this->_customdata['course']->id);
    $mform->addElement('hidden', 's', $this->_customdata['s']);

    $session = $DB->get_record("zingilt_sessions", array("id" => $this->_customdata['s']));
    if ($session != null) {

      $capacity = $session->capacity;
    } else {
      $capacity = 0;
    }
    $enrolled_capacity = zingilt_get_num_attendees($session->id);

    $remaining_capacity = $capacity - $enrolled_capacity;
    $mform->setType('s', PARAM_INT);
    $mform->addElement('hidden', 'uids2', '', array('id' => 'uids2'));
    $mform->setType("uids2", PARAM_RAW);
    $mform->addElement('hidden', 'total_uids2', '0', array('id' => 'total_uids2'));
    $mform->setType("total_uids2", PARAM_INT);
    $mform->addElement('hidden', 'session_capacity2', $capacity, array('id' => 'session_capacity2'));
    $mform->setType("session_capacity2", PARAM_RAW);
    $mform->addElement('hidden', 'enrolled_session_capacity2', $enrolled_capacity, array('id' => 'enrolled_session_capacity2'));
    $mform->setType("enrolled_session_capacity2", PARAM_RAW);
    //$mform->addElement('header', 'general', get_string('general', 'form'),null,array("style"=>"display:none;"));
    //$mform->setExpanded('general',true);
    $mform->addElement("html", '<div id="show_loader2" style="display:none;"><img src="./scripts/loader.gif" height="100px" width="100px"></div>
          <div class="alert alert-success" role="alert" id ="pmsgbodysuccess2" style="display:none;">
        A simple success alert—check it out!
    </div>
    <div class="alert alert-danger" role="alert" id="pmsgbodyerror2" style="display:none;">
      This is a danger alert—check it out!
    </div>');
    /*   $options = array( 
            'multiple' => true,
            //'noselectionstring' => get_string('nouser', 'zingilt'),
            'id' => "userids"
        );         
        $mform->addElement('autocomplete', 'userids', get_string('select_user', 'zingilt'), $this->get_users($session->id), $options);
       */
    $options1 = array(
      'multiple' => true,
      // 'noselectionstring' => get_string('nocohort', 'zingilt'),
      'id' => "cohortids"
    );
    $mform->addElement('autocomplete', 'cohortids', get_string('select_cohort', 'zingilt'), $this->get_cohorts(), $options1);
    //  $mform->addElement("html","<div>Cohort Size: </div>");
    $mform->addElement("static", 'total_users2', get_string("total_users", "zingilt"), array("id" => "total_users2"));
    $mform->setDefault('total_users2', '<div id="total_user_div2">0</div>');
    // $mform->addElement('text', 'name', get_string('forumname', 'forum'), $attributes);
    //adding modal html code 
    $mform->addElement("html", '<!-- Modal -->
      <div id="cohortModal" class="modal fade" role="dialog">
        <div class="modal-dialog modal-lg">    
          <!-- Modal content-->
          <div class="modal-content">
            <div class="modal-header">              
              <h4 class="modal-title">Cohort Enrolment</h4>
              <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <div class="modal-body"><b>
             <!--  <table class="table">
              <tr>
                <td><p>Total No of Users (for Enrolment) : <span id="tuser2">0</span>  </p></td>
                <td><p>Session Capacity  : <span id="scap2">' . $capacity . '</span> </p></td>
              </tr>
              <tr>
                <td><p>Enrolled Session Capacity : <span id="escap2">' . $enrolled_capacity . '</span> </p></td>
                <td><p>Remaining Capacity :<span id="remcap2">' . $remaining_capacity . '</span> </p></td>
              </tr>
              </table></B>
                <p>Do you want to increase the capacity of the session to total no of Enrollment?  </p>-->
                The number of users you wish to enroll, exceeds the current seats available in the session. Do you wish to increase the current number of Capacity and proceed?
                <p>if Yes then please proceed otherwise Cancel.   </p> </b>    
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-default" data-dismiss="modal" id="btnproceed2">Proceed</button>
              <button type="button" class="btn btn-default" data-dismiss="modal" id="btncancel2">Cancel</button>
            </div>
          </div>    
        </div>
      </div>');
    /*$mform->addElement("html", '<!-- Modal -->
      <div id="cohortresultModal" class="modal fade" role="dialog">
        <div class="modal-dialog modal-lg">    
          <!-- Modal content-->
          <div class="modal-content">
            <div class="modal-header">              
              <h4 class="modal-title">User Enrolment</h4>
              <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <div class="modal-body">
            <div class="alert alert-success" role="alert" id ="msgbodysuccess" style="display:none;">
                A simple success alert—check it out!
            </div>
            <div class="alert alert-danger" role="alert" id="msgbodyerror" style="display:none;">
              This is a danger alert—check it out!
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-default" data-dismiss="modal" id="btnclose" data-url="'.$CFG->wwwroot.'/mod/zingilt/attendees.php?s='.$this->_customdata['s'].'">Close</button>
            </div>
          </div>    
        </div>
      </div>');*/
    // $this->add_action_buttons(true, 'Add Attendees');
    $buttonarray = array();
    $buttonarray[] = $mform->createElement('submit', 'submitbutton2', get_string('add_attendees', 'zingilt'));
    $buttonarray[] = $mform->createElement('cancel', 'cancel2', get_string('reset'));
    //$buttonarray[] = $mform->createElement('cancel');
    $mform->addGroup($buttonarray, 'buttonar', '', ' ', false);
  }

  public function validation($data, $files)
  {
    $errors = parent::validation($data, $files);
    return $errors;
  }
  //Added By Kajal for populating trainer dropdown with the users list 
  public function get_users($sessionid)
  {
    global $DB, $USER, $CFG;
    $sql_trainer = "select u.id ,u.employee_code, u.firstname,u.lastname 
          from {user} as u
         where u.deleted =0 and u.id>2 ";
    $rs =  $DB->get_records_sql($sql_trainer);
    //echo count($rs); die("here");
    $trainerresult = array();
    // $trainerresult[''] = 'Select User';
    foreach ($rs as $value) {
      $trainerresult[$value->id] = $value->employee_code . "_" . $value->firstname . ' ' . $value->lastname;
    }
    return $trainerresult;
  }
  public function get_cohorts()
  {
    global $DB, $USER, $CFG;
    $sql = "select id,name from {cohort}";
    $rs =  $DB->get_records_sql($sql);
    $cresult = array();
    // $cresult[''] = 'Select Cohort';
    foreach ($rs as $value) {
      $cresult[$value->id] = $value->name;
    }
    return $cresult;
  }
}
