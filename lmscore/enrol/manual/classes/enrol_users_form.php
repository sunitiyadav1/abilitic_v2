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
 * Enrol users form.
 *
 * Simple form to search for users and add them using a manual enrolment to this course.
 *
 * @package enrol_manual
 * @copyright 2016 Damyon Wiese
 * @license http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

defined('MOODLE_INTERNAL') || die();

require_once($CFG->libdir . '/formslib.php');

class enrol_manual_enrol_users_form extends moodleform
{

    /**
     * Form definition.
     * @return void
     */
    public function definition()
    {
        global $PAGE, $DB, $CFG, $PAGE;

        $PAGE->requires->jquery();
        $PAGE->requires->js(new moodle_url('/enrol/manual/amd/src/enrolattributevalue.js'));
        require_once($CFG->dirroot . '/enrol/locallib.php');

        $context = $this->_customdata->context;

        // Get the course and enrolment instance.
        $coursecontext = $context->get_course_context();
        $course = $DB->get_record('course', ['id' => $coursecontext->instanceid]);
        $manager = new course_enrolment_manager($PAGE, $course);

        $instance = null;
        foreach ($manager->get_enrolment_instances() as $tempinstance) {
            if ($tempinstance->enrol == 'manual') {
                if ($instance === null) {
                    $instance = $tempinstance;
                    break;
                }
            }
        }

        $mform = $this->_form;
        $mform->setDisableShortforms();
        $mform->disable_form_change_checker();
        $periodmenu = enrol_get_period_list();
        $mform->_attributes['id'] = "frmattributevalue";
        // Work out the apropriate default settings.
        $defaultperiod = $instance->enrolperiod;
        if ($instance->enrolperiod > 0 && !isset($periodmenu[$instance->enrolperiod])) {
            $periodmenu[$instance->enrolperiod] = format_time($instance->enrolperiod);
        }
        if (empty($extendbase)) {
            if (!$extendbase = get_config('enrol_manual', 'enrolstart')) {
                // Default to now if there is no system setting.
                $extendbase = 4;
            }
        }

        // Build the list of options for the starting from dropdown.
        $now = time();
        $today = make_timestamp(date('Y', $now), date('m', $now), date('d', $now), 0, 0, 0);
        $dateformat = get_string('strftimedatefullshort');

        // Enrolment start.
        $basemenu = array();
        if ($course->startdate > 0) {
            $basemenu[2] = get_string('coursestart') . ' (' . userdate($course->startdate, $dateformat) . ')';
        }
        $basemenu[3] = get_string('today') . ' (' . userdate($today, $dateformat) . ')';
        $basemenu[4] = get_string('now', 'enrol_manual') . ' (' . userdate($now, get_string('strftimedatetimeshort')) . ')';

        $mform->addElement('header', 'main', get_string('enrolmentoptions', 'enrol'));
        //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
        $mform->addElement("html", '
                            <input type ="hidden" name="tabaction" id="tabaction" value="enrol">
                               <style>
                                    ul.tabs{ margin: 0px; padding: 0px; list-style: none;  }
                                    ul.tabs li{ background: none; color: #222; display: inline-block; padding: 10px 15px; cursor: pointer; }
                                    ul.tabs li.current{ background: #ededed; color: #222; }
                                    .tab-content{ display: none; background: #ededed; padding: 15px; }
                                    .tab-content.current{ display: inherit; }
                                    .row{margin-left:0;}
                               </style>
                               <div class="container">  <ul class="tabs">
                                    <li class="tab-link current" data-tab="enrol">By Users</li>
                                    <li class="tab-link" data-tab="enrol_av">By Attibute/Values</li>    
                                </ul>
                                <div id="enrol" class="tab-content current">');

        $options = array(
            'ajax' => 'enrol_manual/form-potential-user-selector',
            'multiple' => true,
            'courseid' => $course->id,
            'enrolid' => $instance->id,
            'perpage' => $CFG->maxusersperpage,
            'userfields' => implode(',', get_extra_user_fields($context))
        );
        $mform->addElement('autocomplete', 'userlist', get_string('selectusers', 'enrol_manual'), array(), $options);
        // Confirm the user can search for cohorts before displaying select.
        if (has_capability('moodle/cohort:manage', $context) || has_capability('moodle/cohort:view', $context)) {
            // Check to ensure there is at least one visible cohort before displaying the select box.
            // Ideally it would be better to call external_api::call_external_function('core_cohort_search_cohorts')
            // (which is used to populate the select box) instead of duplicating logic but there is an issue with globals
            // being borked (in this case $PAGE) when combining the usage of fragments and call_external_function().
            require_once($CFG->dirroot . '/cohort/lib.php');
            $availablecohorts = cohort_get_cohorts($context->id, 0, 1, '');
            $availablecohorts = $availablecohorts['cohorts'];
            if (!($context instanceof context_system)) {
                $availablecohorts = array_merge(
                    $availablecohorts,
                    cohort_get_available_cohorts($context, COHORT_ALL, 0, 1, '')
                );
            }
            if (!empty($availablecohorts)) {
                $options = ['contextid' => $context->id, 'multiple' => true];
                $mform->addElement('cohort', 'cohortlist', get_string('selectcohorts', 'enrol_manual'), $options);
            }
        }

        $mform->addElement("html", '</div>    <div id="enrol_av" class="tab-content">');
        ///////////////////////////////////////////////////////////
        $mform->addElement("html", '<style>.select_class{ width: 70% !important; display: inline-block;height: calc(1.5em + .75rem + 2px); padding: .375rem 1.75rem .375rem .75rem; font-size: .9375rem; font-weight: 400; line-height: 1.5;    color: #495057; vertical-align: middle; background-color: #fff; border: 1px solid #ced4da;  border-radius: 0; }
            .switch { position: relative;display: inline-block; width: 90px; height: 34px; }           
            .switch input {display:none;}
            .slider { position: absolute; cursor: pointer;  top: 0;  left: 0;  right: 0;  bottom: 0;  background-color: #ca2222;  -webkit-transition: .4s;  transition: .4s;   border-radius: 34px; }
            .slider:before { position: absolute;  content: "";  height: 26px;  width: 26px;  left: 4px;  bottom: 4px;  background-color: white;  -webkit-transition: .4s;  transition: .4s;  border-radius: 50%; }
            input:checked + .slider { background-color: #2ab934; }
            input:focus + .slider {  box-shadow: 0 0 1px #2196F3; }
            input:checked + .slider:before {  -webkit-transform: translateX(26px);  -ms-transform: translateX(26px);  transform: translateX(55px); }
            .slider:after{ content:"AND"; color: white; display: block; position: absolute; transform: translate(-50%,-50%); top: 50%; left: 50%; font-size: 10px; font-family: Verdana, sans-serif;}
            input:checked + .slider:after{  content:"OR";}
            p.note {  font-size: 1rem;  color: red;}
            label span { font-size: 1rem;}
            label.error { color: red; font-size: 1rem; display: block;  margin-top: 5px;}
            input.error, textarea.error { border: 1px dashed red; font-weight: 300; color: red;}
            .ruleset_btn{ float: right; margin: -40px 30px 0px 0px; display: block; border-radius: 34px; background-color: #ca2222;    color: white !important;}
            #show_users_div{    height: 200px;    overflow-y: scroll;    border: 1px grey;    border-style: outset;}
            #show_users_table{    border-style: solid;    width: 100%;    border-color: grey;}
            .input-group {
                position: relative;
                display: flex;
                flex-wrap: wrap;
                align-items: stretch;
                width: 100%;
                padding-top: 10px;
                padding-left: 0px;
            }

            .select_class {
                width: 100% !important;
                display: inline-block;
                height: calc(1.5em + .75rem + 2px);
                padding: .375rem 1.75rem .375rem .75rem;
                font-size: .9375rem;
                font-weight: 400;
                line-height: 1.5;
                color: #495057;
                vertical-align: middle;
                background-color: #fff;
                border: 1px solid #ced4da;
                border-radius: 0;
                margin: -36px 0px 0px 91px;
            }

            </style>');

        $mform->addElement("html", '
            <!--<div id="show_loader3" style="display:none;"><img src="./scripts/loader.gif" height="100px" width="100px"></div>-->
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

        //show total no of users field   get_string("total_users", "enrol_manual")
        $mform->addElement("static", 'total_users3', "Total Users ", array("id" => "total_users3"));
        $mform->setDefault('total_users3', '<div id="total_user_div3">0</div>');

        $mform->addElement("hidden", 'uids', '', array("id" => "uids"));


        /////////////////////////////////////////////////////////////////////////

        $mform->addElement("html", "</div>    </div>");
        /////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

        $roles = get_assignable_roles($context);
        $mform->addElement('select', 'roletoassign', get_string('assignrole', 'enrol_manual'), $roles);
        $mform->setDefault('roletoassign', $instance->roleid);

        $mform->addAdvancedStatusElement('main');

        $mform->addElement('checkbox', 'recovergrades', get_string('recovergrades', 'enrol'));
        $mform->setAdvanced('recovergrades');
        $mform->setDefault('recovergrades', $CFG->recovergradesdefault);
        $mform->addElement('select', 'startdate', get_string('startingfrom'), $basemenu);
        $mform->setDefault('startdate', $extendbase);
        $mform->setAdvanced('startdate');
        $mform->addElement('select', 'duration', get_string('enrolperiod', 'enrol'), $periodmenu);
        $mform->setDefault('duration', $defaultperiod);
        $mform->setAdvanced('duration');
        $mform->disabledIf('duration', 'timeend[enabled]', 'checked', 1);
        $mform->addElement('date_time_selector', 'timeend', get_string('enroltimeend', 'enrol'), ['optional' => true]);
        $mform->setAdvanced('timeend');
        $mform->addElement('hidden', 'id', $course->id);
        $mform->setType('id', PARAM_INT);
        $mform->addElement('hidden', 'action', 'enrol');
        $mform->setType('action', PARAM_ALPHA);
        $mform->addElement('hidden', 'enrolid', $instance->id);
        $mform->setType('enrolid', PARAM_INT);
    }

    /**
     * Validate the submitted form data.
     *
     * @param array $data array of ("fieldname"=>value) of submitted data
     * @param array $files array of uploaded files "element_name"=>tmp_file_path
     * @return array of "element_name"=>"error_description" if there are errors,
     *         or an empty array if everything is OK (true allowed for backwards compatibility too).
     */
    public function validation($data, $files)
    {
        $errors = parent::validation($data, $files);
        if (!empty($data['startdate']) && !empty($data['timeend'])) {
            if ($data['startdate'] >= $data['timeend']) {
                $errors['timeend'] = get_string('enroltimeendinvalid', 'enrol');
            }
        }
        return $errors;
    }

    public function getAttrvalueform()
    {
        global $DB, $USER, $CFG;
        $formtext = '';
        $sql_attr = "SELECT * FROM `mdl_custom_user_field_detail` where is_visible = '1' and field != 'deleted' order by field";
        $get_columns    = $DB->get_records_sql($sql_attr);
        $formtext .= '
        <div id="parent_div">
            <div id="ruleset_1">
                <div class="row" id="row_1">    
                    <div class="input-group mb-3 col-xs-6 col-sm-4">
                      <div class="input-group-prepend">
                        <label class="input-group-text" for="tbl_columns">Attribute</label>
                      </div>
                      <select class="select_class" name="tbl_columns[]" id="tbl_columns_1" required>
                        <option selected value="">Choose...</option>';
        foreach ($get_columns as $key1 => $value1) {
            $formtext .= '<option value="' . $value1->id . '"> ' . $value1->field  . '</option>';
        }
        $formtext .= ' </select>
                    </div>

                    <div class="input-group mb-3 col-xs-6 col-sm-4">
                      <div class="input-group-prepend">
                        <label class="input-group-text" for="tbl_condition">Condition</label>
                      </div>
                      <select class="select_class class_condition" name="tbl_condition[]" id="tbl_condition_1" required>
                        <option selected value="">Choose...</option>                    
                      </select>
                    </div>

                    <div class="input-group mb-3 col-xs-6 col-sm-4" id="value_class_1">
                      <div class="input-group-prepend" id="next_value_class_1">
                        <label class="input-group-text" for="tbl_value">Value</label>
                      </div>
                      <input type="text" class="select_class" autocomplete="off" name="tbl_value[]" id="tbl_value_1" required style="margin-left: 70px;"></input>
                    </div>

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
        $get_columns    = $DB->get_records_sql($sql_attr);
        $att_res = array();
        foreach ($get_columns as $key1 => $value1) {
            $att_res[$value1->id] = $value1->field;
        }
        return $att_res;
    }
}
