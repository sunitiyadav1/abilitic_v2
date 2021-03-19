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
require_once($CFG->dirroot . '/mod/zingilt/resourcemgmt/locallib.php');
class mod_zingilt_session_form extends moodleform {

    public function definition() {
        global $CFG, $DB;

        $mform =& $this->_form;
        $context = context_course::instance($this->_customdata['course']->id);
// echo "<pre>";print_r($context);die;
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
        //Kajal - added name field
        $mform->addElement('text', 'name', get_string('session_name', 'zingilt'));
        $mform->addRule('name', get_string('pleaseentername', 'zingilt'), 'required', null, 'client');
        $mform->setType("name",PARAM_RAW);
        /////////////////////////////////////
        $mform->addElement('static', 'startdateinfo', '', '', ' ');
        $formarray  = array();
        $formarray[] = $mform->createElement('hidden', 'datetimeknown','');
        //$formarray[] = $mform->createElement('selectyesno', 'datetimeknown', get_string('sessiondatetimeknown', 'zingilt'));
        //$formarray[] = $mform->createElement('static', 'datetimeknownhint', '',
            //html_writer::tag('span', get_string('datetimeknownhinttext', 'zingilt'), array('class' => 'hint-text')));
         $mform->addGroup($formarray, 'datetimeknown_group', '', array(' '), false); //get_string('sessiondatetimeknown', 'zingilt')
        // $mform->addGroupRule('datetimeknown_group', null, 'required', null, 'client');
        $mform->setDefault('datetimeknown', true);
        $mform->setType("datetimeknown",PARAM_INT);
        //$mform->addHelpButton('datetimeknown_group', 'sessiondatetimeknown', 'zingilt');
        
        $repeatarray = array();
        $repeatarray[] = &$mform->createElement('hidden', 'sessiondateid', 0);
        $mform->setType('sessiondateid', PARAM_INT);
        $repeatarray[] = &$mform->createElement('date_time_selector', 'timestart', get_string('timestart', 'zingilt'),array(),array("class"=>"testdatestartclass","onChange" => "checkDate('timestart','hidden_startdate');validateDate();check_all_resource_availability();"));
        $repeatarray[] = &$mform->createElement('date_time_selector', 'timefinish', get_string('timefinish', 'zingilt'),array(),array("class"=>"testdateendclass","onChange" => "checkDate('timefinish','hidden_enddate');validateDate();check_all_resource_availability();"));
        $repeatarray[] = &$mform->createElement('hidden', 'txttimestart','');
        $repeatarray[] = &$mform->createElement('hidden', 'txttimefinish','');
        
        $repeatarray[] = &$mform->createElement('hidden', 'hidden_startdate','');
        $repeatarray[] = &$mform->createElement('hidden', 'hidden_enddate','');
        
        $checkboxelement = &$mform->createElement('checkbox', 'datedelete', '', get_string('dateremove', 'zingilt'),array(),array("onClick" => "check_all_resource_availability();"));
        unset($checkboxelement->_attributes['id']); // Necessary until MDL-20441 is fixed.
        $repeatarray[] = $checkboxelement;
        $repeatarray[] = &$mform->createElement('html', html_writer::empty_tag('br')); // Spacer.

        $repeatcount = $this->_customdata['nbdays'];

        $repeatoptions = array();
        $repeatoptions['timestart']['disabledif'] = array('datetimeknown', 'eq', 0);
        $repeatoptions['timefinish']['disabledif'] = array('datetimeknown', 'eq', 0);
        $mform->setType('timestart', PARAM_INT);
        $mform->setType('timefinish', PARAM_INT);
        $mform->setType('txttimestart', PARAM_RAW);
        $mform->setType('txttimefinish', PARAM_RAW);
        $mform->setType('hidden_startdate', PARAM_RAW);
        $mform->setType('hidden_enddate', PARAM_RAW);

        $this->repeat_elements($repeatarray, $repeatcount, $repeatoptions, 'date_repeats', 'date_add_fields',
                               1, get_string('dateadd', 'zingilt'), true);
        $mform->addElement('static', 'enddateinfo', '', '', ' ');
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

  /*      // Choose users for trainer roles.
        $rolenames = zingilt_get_trainer_roles();

        if ($rolenames) {

            // Get current trainers.
            $currenttrainers = zingilt_get_trainers($this->_customdata['s']);
            //print_r($currenttrainers);
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
               // echo "SELECT  u.id, {$usernamefields} FROM {role_assignments} ra LEFT JOIN {user} u  ON ra.userid = u.id
               //  WHERE contextid = {$context->id} AND roleid = {$role}";
              //  print_r($rs);
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
                }//die("here");
              
                

            }
        }  */
/*
                    Resource Booking
                */
                $zingiltid = $this->_customdata['f'];
                $sessionid = $this->_customdata['s'];
                $copysession = $this->_customdata['c'];
                //echo $copysession;die;
                if ($sessionid != "") {
                    if($copysession =='1'){
                        if(empty($zingiltid) || $zingiltid ==0){
                            global $zingilt;
                            $zingiltid =$zingilt->id;
                        }
                        $sessionid=0;
                        //echo $sessionid."===".$zingiltid;
                        //die("here");
                        $action = "add_session";    
                        $mform->addElement("html",'<div class="alert alert-info">
                        <strong>Info!</strong> In this Session Copy, existing Resources can not be Booked. Please add new Resources for this session.
                    </div>');
                    }
                    else{
                        $action = "edit_session";
                    }
                } else {
                    $action = "add_session";
                }
                // $action = "session";
                newResourceBookingForm($mform, $zingiltid, $sessionid, $action);
                //resource_booking_form_generate($mform,$zingiltid,$sessionid,$action);
        $this->add_action_buttons();
    }
    public function duplicate_check($startdate,$enddate){
        global $DB;
        //check other session in this ilt for the same date time
        $sql="select * from {zingilt_sessions} as s join {zingilt_sessions_dates} as d on s.id =d.sessionid where zingilt = ".$zingilt->id ."";
        if($data['s'] != "" && $data['s']!=null){
            $sql .= " and s.id !=".$data['s'];
        }
      //  echo $sql;
        $st= $DB->get_records_sql($sql);
        if($st!= null){
            foreach($st as $s){
              //  print_r($s);
                /*if(
                    (($s->timestart >$sd->startdate && $s->timestart > $sd->finishdate) && ($s->timefinish >$sd->startdate && $s->timefinish > $sd->finishdate))
                    || 
                    (($s->timestart <$sd->startdate && $s->timestart < $sd->finishdate) && ($s->timefinish <$sd->startdate && $s->timefinish < $sd->finishdate))
                )
                    {
                        // echo "<br>".date("Y-m-d H:i:s",$s->timestart)."==".date("Y-m-d H:i:s",$s->timefinish);
                        // echo "<br>".date("Y-m-d H:i:s",$sd->startdate)."==".date("Y-m-d H:i:s",$sd->finishdate);
                        // echo "in if";
                    }
                    else{
                        $errstr = "Session already exist for this date time =>".date("Y-m-d H:i:s",$sd->startdate)."==".date("Y-m-d H:i:s",$sd->finishdate);
                        $errors['startdateinfo'] = $errstr;
                        // $errors['enddateinfo'] = $errstr;
                        unset($errstr);
                        break;
                    }*/

                    if ($sd->startdate <= $s->timestart && $sd->finishdate >= $s->timefinish) {
                        //echo "partial";
                        $errstr = "Session already exist for this date time =>".date("Y-m-d H:i:s",$sd->startdate)."==".date("Y-m-d H:i:s",$sd->finishdate);
                        $errors['startdateinfo'] = $errstr;
                        // $errors['enddateinfo'] = $errstr;
                        unset($errstr);
                        break;
                    } else {
                        //echo "available";
                    }
                //echo "<HR>";
            }
        }
    }
    public function validation($data, $files) {
        global $zingilt,$DB;
        $errors = parent::validation($data, $files);
        $dateids = $data['sessiondateid'];
        $dates = count($dateids);
      // echo "<pre>"; print_r($data);
        for ($i = 0; $i < $dates; $i++) {
            $starttime = $data["timestart"][$i];
            $endtime = $data["timefinish"][$i];
            $removecheckbox = empty($data["datedelete"]) ? array() : $data["datedelete"];
            if (empty($data['datedelete'][$i])) {
            if ($starttime > $endtime && !isset($removecheckbox[$i])) {
                $errstr = get_string('error:sessionstartafterend', 'zingilt');
                $errors['startdateinfo'] = $errstr;
               // $errors['enddateinfo'] = $errstr;
                unset($errstr);
            }
            if ($starttime == $endtime && !isset($removecheckbox[$i])) {
                $errstr = "Start datetime and End Datetime Should not be Same in each Datetime Range.";
                // $errors['timestart'][$i] = $errstr;
                // $errors['timefinish'][$i] = $errstr;
                $errors['enddateinfo'] = $errstr;
                unset($errstr);
            }

            $starttime = $data["timestart"][$i];
            $startdate = date("Y-m-d", $starttime);
            $endtime = $data["timefinish"][$i];
            $enddate = date("Y-m-d", $endtime);
            //          echo $startdate."=====".$enddate;
            if ($startdate != $enddate) {
                $errstr = "Start date and End Date should be same for each Datetime range";
                // $errstr = get_string('error:sessionstartafterend', 'zingilt');
                // $errstr = "session startafter end";
                $errors['startdateinfo'] = $errstr;
                // $errors['enddateinfo'] = $errstr;
                unset($errstr);
            }
            //check other session in this ilt for the same date time
            $sql="select * from {zingilt_sessions} as s join {zingilt_sessions_dates} as d on s.id =d.sessionid where zingilt = ".$zingilt->id ."";
            //print_r($data);
            if($data['c'] != '1' && $data['s'] != "" && $data['s']!=null){
                $sql .= " and s.id !=".$data['s'];
            }
           // echo $sql;
          
            $st= $DB->get_records_sql($sql);
            if($st!= null){
                foreach($st as $s){
                    //echo "<BR>". $starttime ."=====".$endtime;
                    //echo "<BR>". $s->timestart ."=====".$s->timefinish;
                    
                    //     $datefound = true;
                    //     break;
                    
                        if ($starttime <= $s->timestart && $endtime >= $s->timefinish) {
                            //echo "partial";
                            $errstr = "Session already exist for this Date Time Selection in Same Zing ILT";
                            $errors['startdateinfo'] = $errstr;
                            // $errors['enddateinfo'] = $errstr;
                            unset($errstr);
                            break;
                        }
                        else if(($starttime >= $s->timestart && $starttime <= $s->timefinish) && $endtime >= $s->timefinish){
                            //echo "partial";

                            $errstr = "Session already exist for this Date Time Selection in Same Zing ILT";
                      //      echo $errstr;
                            $errors['startdateinfo'] = $errstr;
                            // $errors['enddateinfo'] = $errstr;
                            unset($errstr);
                            break;
                        }
                        else {
                            //echo "available";
                        }
                    //echo "<HR>";
                }
            }
            }
        }
       //    die;
        if (!empty($data['datetimeknown'])) {
            $datefound = false;
            for ($i = 0; $i < $data['date_repeats']; $i++) {
                if (empty($data['datedelete'][$i])) {
                    $datefound = true;
                    break;
                }
            }

            if (!$datefound) {
                $errors['startdateinfo'] = get_string('validation:needatleastonedate', 'zingilt');
            }
        }
            //print_r($errors);die;
        return $errors;
    }
}
