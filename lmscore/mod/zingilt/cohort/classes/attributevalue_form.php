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

class mod_zingilt_attributevalue_form extends moodleform
{

  public function definition()
  {
    global $CFG, $DB;
    $mform = &$this->_form;
    $mform->_attributes['id'] = "frmattributevalue";
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
    $mform->addElement('hidden', 'uids3', '', array('id' => 'uids3'));
    $mform->setType("uids3", PARAM_RAW);
    $mform->addElement('hidden', 'total_uids3', '0', array('id' => 'total_uids3'));
    $mform->setType("total_uids3", PARAM_INT);
    $mform->addElement('hidden', 'session_capacity3', $capacity, array('id' => 'session_capacity3'));
    $mform->setType("session_capacity3", PARAM_RAW);
    $mform->addElement('hidden', 'enrolled_session_capacity3', $enrolled_capacity, array('id' => 'enrolled_session_capacity3'));
    $mform->setType("enrolled_session_capacity3", PARAM_RAW);
    //$mform->addElement('header', 'general', get_string('general', 'form'),null,array("style"=>"display:none;"));
    //$mform->setExpanded('general',true);
    $mform->addElement("html", '
      <div id="show_loader3" style="display:none;"><img src="./scripts/loader.gif" height="100px" width="100px"></div>
          <div class="alert alert-success" role="alert" id ="pmsgbodysuccess3" style="display:none;">
        A simple success alert—check it out!
    </div>
    <div class="alert alert-danger" role="alert" id="pmsgbodyerror3" style="display:none;">
      This is a danger alert—check it out!
    </div>');
    $mform->addElement("html", '<button type="button" id="clone_btn" class="btn btn-primary" >
        <i style="font-size:12px" class="fa">&#xf067;</i> Add a Rule
    </button>');
    $mform->addElement('html', '<table id="show_users_table"><tr><td>' . $this->getAttrvalueform() . '</td></tr>');

    $mform->addElement('html', '<tr><td>
        <button type="button" id="execute_btn" class="btn btn-secondary"> Execute Rule </button>
        </td></tr></table>');

    $mform->addElement('html', '<tr><td><div id="show_users_div">No User Selected</div></td></tr></table>');

    //show total no of users field   
    $mform->addElement("static", 'total_users3', get_string("total_users", "zingilt"), array("id" => "total_users3"));
    $mform->setDefault('total_users3', '<div id="total_user_div3">0</div>');

    //adding modal html code 
    $mform->addElement("html", '<!-- Modal -->
      <div id="avModal" class="modal fade" role="dialog">
        <div class="modal-dialog modal-lg">    
          <!-- Modal content-->
          <div class="modal-content">
            <div class="modal-header">              
              <h4 class="modal-title">Attribute/Value wise Enrolment</h4>
              <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <div class="modal-body"><b>
             <!--  <table class="table">
              <tr>
                <td><p>Total No of Users (for Enrolment) : <span id="tuser3">0</span>  </p></td>
                <td><p>Session Capacity  : <span id="scap3">' . $capacity . '</span> </p></td>
              </tr>
              <tr>
                <td><p>Enrolled Session Capacity : <span id="escap3">' . $enrolled_capacity . '</span> </p></td>
                <td><p>Remaining Capacity :<span id="remcap3">' . $remaining_capacity . '</span> </p></td>
              </tr>
              </table></B>
                <p>Do you want to increase the capacity of the session to total no of Enrollment?  </p>-->
                The number of users you wish to enroll, exceeds the current seats available in the session. Do you wish to increase the current number of Capacity and proceed?
                <p>if Yes then please proceed otherwise Cancel.   </p> </b>    
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-default" data-dismiss="modal" id="btnproceed3">Proceed</button>
              <button type="button" class="btn btn-default" data-dismiss="modal" id="btncancel3">Cancel</button>
            </div>
          </div>    
        </div>
      </div>');
    /* $mform->addElement("html", '<!-- Modal -->
      <div id="avresultModal" class="modal fade" role="dialog">
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
      </div></div>');*/
    // $this->add_action_buttons(true, 'Add Attendees');
    $buttonarray = array();
    $buttonarray[] = $mform->createElement('submit', 'submitbutton3', get_string('add_attendees', 'zingilt'));
    $buttonarray[] = $mform->createElement('cancel', 'cancel3', get_string('reset'));
    //$buttonarray[] = $mform->createElement('cancel');
    $mform->addGroup($buttonarray, 'buttonar', '', ' ', false);
  }

  public function validation($data, $files)
  {
    $errors = parent::validation($data, $files);
    return $errors;
  }
  public function getAttrvalueform()
  {
    global $DB, $USER, $CFG;
    $formtext = '';
    $sql_attr = "SELECT * FROM `mdl_custom_user_field_detail` where is_visible = '1' and field != 'deleted' order by field";
    $get_columns   = $DB->get_records_sql($sql_attr);
    $formtext .= '
    <div id="parent_div">
        <div id="ruleset_1">
            <div class="row" id="row_1" style="margin: 0px;">  
            <table width="100%"><tr><td>
                <div class="input-group mb-3 col-xs-6 col-sm-4">
                  <div class="input-group-prepend">
                    <label class="input-group-text" for="tbl_columns">Attribute</label>
                  </div>
                  <select class="select_class" name="tbl_columns[]" id="tbl_columns_1" required>
                                <option selected value="">Choose...</option>';
                foreach ($get_columns as $key1 => $value1) {
                  if($value1->id == 68 && is_siteadmin())
                  {
                      $formtext .= '<option value="' . $value1->id . '"> ' . $value1->field  . '</option>';
                  }
                  else if($value1->id != 68)
                  {
                      $formtext .= '<option value="' . $value1->id . '"> ' . $value1->field  . '</option>';
                  }
                }
                $formtext .= ' </select>
                </div>
                </td><td>
                <div class="input-group mb-3 col-xs-6 col-sm-4">
                  <div class="input-group-prepend">
                    <label class="input-group-text" for="tbl_condition">Condition</label>
                  </div>
                  <select class="select_class class_condition" name="tbl_condition[]" id="tbl_condition_1" required>
                    <option selected value="">Choose...</option>                    
                  </select>
                </div>
                </td><td>
                <div class="input-group mb-3 col-xs-6 col-sm-4" id="value_class_1">
                  <div class="input-group-prepend" id="next_value_class_1">
                    <label class="input-group-text" for="tbl_value">Value</label>
                  </div>
                  <input type="text" class="select_class" autocomplete="off" name="tbl_value[]" id="tbl_value_1" required></input>
                </div>
                </td></tr>
                </table>
            </div>
            <!-- style="display: none;" -->
            <label class="switch" id="switch_1" style="display: none;">
                <input type="hidden" name="toggle_value[]" id="toggle_value_1" value="and">
                <input type="checkbox" id="togBtn">
                <div class="slider round" id="slider_id_1"></div>
            </label>

            <button type="button" class="btn ruleset_btn" id="delete_ruleset_1" style="display: none;"> <i style="font-size:15px" class="fa">&#xf014;</i> Delete Rule</button>
            <br>
        </div>
    </div>
    ';
    return $formtext;
  }
  public function get_attributes()
  {
    global $DB, $USER, $CFG;
    $sql_attr = "SELECT * FROM `mdl_custom_user_field_detail` where is_visible = '1' order by field";
    $get_columns   = $DB->get_records_sql($sql_attr);
    $att_res = array();
    foreach ($get_columns as $key1 => $value1) {
      $att_res[$value1->id] = $value1->field;
    }
    return $att_res;
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
    $sql = "select * from {cohort}";
    $rs =  $DB->get_records_sql($sql);
    $cresult = array();
    // $cresult[''] = 'Select Cohort';
    foreach ($rs as $value) {
      $cresult[$value->id] = $value->name;
    }
    return $cresult;
  }
}
