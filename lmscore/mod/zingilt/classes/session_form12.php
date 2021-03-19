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
require_once($CFG->dirroot.'/local/resourcemgmt/locallib.php');

class mod_zingilt_session_form extends moodleform {

    public function definition() {
        global $CFG, $DB;

        $mform =& $this->_form;
        $context = context_course::instance($this->_customdata['course']->id);

        // Course Module ID.
        $mform->addElement('hidden', 'id', $this->_customdata['id']);
        $mform->setType('id', PARAM_INT);

        // zingilt Instance ID.
        $mform->addElement('hidden', 'f', $this->_customdata['f']);
        $mform->setType('f', PARAM_INT);

        // zingilt Session ID.
        $mform->addElement('hidden', 's', $this->_customdata['s']);
        $mform->setType('s', PARAM_INT);

        // Copy Session Flag.
        $mform->addElement('hidden', 'c', $this->_customdata['c']);
        $mform->setType('c', PARAM_INT);

        $mform->addElement('header', 'general', get_string('general', 'form'));

        $editoroptions = $this->_customdata['editoroptions'];

        // Show all custom fields.
        $customfields = $this->_customdata['customfields'];
        zingilt_add_customfields_to_form($mform, $customfields);

        // Hack to put help files on these custom fields.
        // TODO: add to the admin page a feature to put help text on custom fields.
        if ($mform->elementExists('custom_location')) {
            $mform->addHelpButton('custom_location', 'location', 'zingilt');
        }
        if ($mform->elementExists('custom_venue')) {
            $mform->addHelpButton('custom_venue', 'venue', 'zingilt');
        }
        if ($mform->elementExists('custom_room')) {
            $mform->addHelpButton('custom_room', 'room', 'zingilt');
        }

        $formarray  = array();
        $formarray[] = $mform->createElement('selectyesno', 'datetimeknown', get_string('sessiondatetimeknown', 'zingilt'));
        //$formarray[] = $mform->createElement('hidden', 'datetimeknown', 1);
        //$formarray[] = $mform->createElement('static', 'datetimeknownhint', '',    html_writer::tag('span', get_string('datetimeknownhinttext', 'zingilt'), array('class' => 'hint-text')));
        //$mform->addGroup($formarray, 'datetimeknown_group', get_string('sessiondatetimeknown', 'zingilt'), array('style' =>"display:none;"), false);
        //$mform->addGroupRule('datetimeknown_group', null, 'required', null, 'client');
        $mform->setDefault('datetimeknown', true);
       // $mform->addHelpButton('datetimeknown_group', 'sessiondatetimeknown', 'zingilt');
        
        $repeatarray = array();
        $repeatarray[] = &$mform->createElement('hidden', 'sessiondateid', 0);
        $mform->setType('sessiondateid', PARAM_INT);
        //$repeatarray[] = &$mform->createElement('date_time_selector', 'timestart', get_string('timestart', 'zingilt'));
        //$repeatarray[] = &$mform->createElement('date_time_selector', 'timefinish', get_string('timefinish', 'zingilt'));
        $repeatarray[] = &$mform->createElement('date_time_selector', 'timestart', get_string('timestart', 'zingilt'). "  :: ",array(),array("onChange" => "checkDate('timestart','hidden_startdate');validateDate();"));
        $repeatarray[] = &$mform->createElement('date_time_selector', 'timefinish', get_string('timefinish', 'zingilt'). "  :: ",array(),array("onChange" => "checkDate('timefinish','hidden_enddate');validateDate();"));
        //$checkboxelement = &$mform->createElement('checkbox', 'datedelete', '', get_string('dateremove', 'zingilt'));
        //unset($checkboxelement->_attributes['id']); // Necessary until MDL-20441 is fixed.
        //$repeatarray[] = $checkboxelement;
        $repeatarray[] = &$mform->createElement('html', html_writer::empty_tag('br')); // Spacer.
        
        $repeatcount = $this->_customdata['nbdays'];

        $repeatoptions = array();
        $repeatoptions['timestart']['disabledif'] = array('datetimeknown', 'eq', 0);
        $repeatoptions['timefinish']['disabledif'] = array('datetimeknown', 'eq', 0);
        $mform->setType('timestart', PARAM_INT);
        $mform->setType('timefinish', PARAM_INT);
        $mform->addGroup($repeatarray, 'startenddate_group', get_string('sessiondatetimeknown', 'zingilt'), array('style' =>"display:none;"), false);
        $mform->addGroupRule('startenddate_group', null, 'required', null, 'client');
        
        //$this->repeat_elements($repeatarray, $repeatcount, $repeatoptions, 'date_repeats', 'date_add_fields', 1, get_string('dateadd', 'zingilt'), true);

        if (has_capability('mod/zingilt:configurecancellation', $context)) {
            $mform->addElement('advcheckbox', 'allowcancellations', get_string('allowcancellations', 'zingilt'));
            $mform->setDefault('allowcancellations', $this->_customdata['zingilt']->allowcancellationsdefault);
            $mform->addHelpButton('allowcancellations', 'allowcancellations', 'zingilt');
        }

        $mform->addElement('text', 'capacity', get_string('capacity', 'zingilt'), 'size="5"');
        $mform->addRule('capacity', null, 'required', null, 'client');
        $mform->setType('capacity', PARAM_INT);
        $mform->setDefault('capacity', 10);
        $mform->addHelpButton('capacity', 'capacity', 'zingilt');

        $mform->addElement('checkbox', 'allowoverbook', get_string('allowoverbook', 'zingilt'));
        $mform->addHelpButton('allowoverbook', 'allowoverbook', 'zingilt');

        $mform->addElement('text', 'duration', get_string('duration', 'zingilt'), 'size="5"');
        $mform->setType('duration', PARAM_TEXT);
        $mform->addHelpButton('duration', 'duration', 'zingilt');

        if (!get_config(null, 'zingilt_hidecost')) {
            $formarray  = array();
            $formarray[] = $mform->createElement('text', 'normalcost', get_string('normalcost', 'zingilt'), 'size="5"');
            $formarray[] = $mform->createElement('static', 'normalcosthint', '', html_writer::tag('span',
                get_string('normalcosthinttext', 'zingilt'), array('class' => 'hint-text')));
            $mform->addGroup($formarray, 'normalcost_group', get_string('normalcost', 'zingilt'), array(' '), false);
            $mform->setType('normalcost', PARAM_TEXT);
            $mform->addHelpButton('normalcost_group', 'normalcost', 'zingilt');

            if (!get_config(null, 'zingilt_hidediscount')) {
                $formarray  = array();
                $formarray[] = $mform->createElement('text', 'discountcost', get_string('discountcost', 'zingilt'), 'size="5"');
                $formarray[] = $mform->createElement('static', 'discountcosthint', '', html_writer::tag('span',
                    get_string('discountcosthinttext', 'zingilt'), array('class' => 'hint-text')));
                $mform->addGroup($formarray, 'discountcost_group', get_string('discountcost', 'zingilt'), array(' '), false);
                $mform->setType('discountcost', PARAM_TEXT);
                $mform->addHelpButton('discountcost_group', 'discountcost', 'zingilt');
            }
        }

        $mform->addElement('editor', 'details_editor', get_string('details', 'zingilt'), null, $editoroptions);
        $mform->setType('details_editor', PARAM_RAW);
        $mform->addHelpButton('details_editor', 'details', 'zingilt');

        // Choose users for trainer roles.
        $rolenames = zingilt_get_trainer_roles();

        if ($rolenames) {

            // Get current trainers.
            $currenttrainers = zingilt_get_trainers($this->_customdata['s']);

            // Loop through all selected roles.
            $headershown = false;
            foreach ($rolenames as $role => $rolename) {
                $rolename = $rolename->name;

                // Attempt to load users with this role in this course.
                $usernamefields = get_all_user_name_fields(true);
                $rs = $DB->get_recordset_sql("
                    SELECT
                        u.id,
                        {$usernamefields}
                    FROM
                        {role_assignments} ra
                    LEFT JOIN
                        {user} u
                      ON ra.userid = u.id
                    WHERE
                        contextid = {$context->id}
                    AND roleid = {$role}
                ");

                if (!$rs) {
                    continue;
                }

                $choices = array();
                foreach ($rs as $roleuser) {
                    $choices[$roleuser->id] = fullname($roleuser);
                }
                $rs->close();

                // Show header (if haven't already).
                if ($choices && !$headershown) {
                    $mform->addElement('header', 'trainerroles', get_string('sessionroles', 'zingilt'));
                    $headershown = true;
                }

                // If only a few, use checkboxes.
                if (count($choices) < 4) {
                    $roleshown = false;
                    foreach ($choices as $cid => $choice) {

                        // Only display the role title for the first checkbox for each role.
                        if (!$roleshown) {
                            $roledisplay = $rolename;
                            $roleshown = true;
                        } else {
                            $roledisplay = '';
                        }

                        $mform->addElement('advcheckbox', 'trainerrole[' . $role . '][' . $cid . ']', $roledisplay, $choice,
                            null, array('', $cid));
                        $mform->setType('trainerrole[' . $role . '][' . $cid . ']', PARAM_INT);
                    }
                } else {
                    $mform->addElement('select', 'trainerrole[' . $role . ']', $rolename, $choices,
                        array('multiple' => 'multiple'));
                    $mform->setType('trainerrole[' . $role . ']', PARAM_SEQUENCE);
                }

                // Select current trainers.
                if ($currenttrainers) {
                    foreach ($currenttrainers as $role => $trainers) {
                        $t = array();
                        foreach ($trainers as $trainer) {
                            $t[] = $trainer->id;
                            $mform->setDefault('trainerrole[' . $role . '][' . $trainer->id . ']', $trainer->id);
                        }

                        $mform->setDefault('trainerrole[' . $role . ']', implode(',', $t));
                    }
                }
            }
        }
    /*
             Resource Booking
            */            
            $zingiltid=$this->_customdata['f'];
            $sessionid = $this->_customdata['s'];
            if($sessionid!=""){
                $action = "edit_session";
            }
            else{
                $action = "add_session";
            }
            $action = "session";
            //echo $zingiltid;
            //echo $sessionid;
            //die("here");
            //resource_booking_form_generate($mform,$zingiltid,$sessionid,$action);
            newResourceBookingForm($mform,$zingiltid,$sessionid,$action);

        $this->add_action_buttons();
    }

    public function validation($data, $files) {
        $errors = parent::validation($data, $files);
        $dateids = $data['sessiondateid'];
        $dates = count($dateids);
        for ($i = 0; $i < $dates; $i++) {
            $starttime = $data["timestart"][$i];
            $endtime = $data["timefinish"][$i];
            $removecheckbox = empty($data["datedelete"]) ? array() : $data["datedelete"];
            if ($starttime > $endtime && !isset($removecheckbox[$i])) {
                $errstr = get_string('error:sessionstartafterend', 'zingilt');
                $errors['timestart'][$i] = $errstr;
                $errors['timefinish'][$i] = $errstr;
                unset($errstr);
            }
        }

        if (!empty($data['datetimeknown'])) {
            $datefound = false;
            for ($i = 0; $i < $data['date_repeats']; $i++) {
                if (empty($data['datedelete'][$i])) {
                    $datefound = true;
                    break;
                }
            }

            if (!$datefound) {
                $errors['datetimeknown'] = get_string('validation:needatleastonedate', 'zingilt');
            }
        }

        return $errors;
    }
}
