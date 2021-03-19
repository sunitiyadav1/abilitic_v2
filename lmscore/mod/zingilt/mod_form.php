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

require_once($CFG->dirroot.'/course/moodleform_mod.php');
require_once($CFG->dirroot.'/mod/zingilt/lib.php');

class mod_zingilt_mod_form extends moodleform_mod {

    public function definition() {
        global $CFG;

        $mform =& $this->_form;

        // General.
        $mform->addElement('header', 'general', get_string('general', 'form'));

        $mform->addElement('text', 'name', get_string('name'), array('size' => '64'));
        if (!empty($CFG->formatstringstriptags)) {
            $mform->setType('name', PARAM_TEXT);
        } else {
            $mform->setType('name', PARAM_CLEANHTML);
        }
        $mform->addRule('name', null, 'required', null, 'client');

        $this->standard_intro_elements();

        $mform->addElement('text', 'thirdparty', get_string('thirdpartyemailaddress', 'zingilt'), array('size' => '64'));
        $mform->setType('thirdparty', PARAM_NOTAGS);
        $mform->addHelpButton('thirdparty', 'thirdpartyemailaddress', 'zingilt');

        $mform->addElement('checkbox', 'thirdpartywaitlist', get_string('thirdpartywaitlist', 'zingilt'));
        $mform->addHelpButton('thirdpartywaitlist', 'thirdpartywaitlist', 'zingilt');

        $display = array();
        for ($i = 0; $i <= 18; $i += 2) {
            $display[$i] = $i;
        }
        $mform->addElement('select', 'display', get_string('sessionsoncoursepage', 'zingilt'), $display);
        $mform->setDefault('display', 6);
        $mform->addHelpButton('display', 'sessionsoncoursepage', 'zingilt');

        // Suniti Yadav - As there is no self signup flow in AISATS, only manager can enroll.
        // $mform->addElement('checkbox', 'approvalreqd', get_string('approvalreqd', 'zingilt'));
        // $mform->addHelpButton('approvalreqd', 'approvalreqd', 'zingilt');

        if (has_capability('mod/zingilt:configurecancellation', $this->context)) {
            $mform->addElement('advcheckbox', 'allowcancellationsdefault', get_string('allowcancellationsdefault', 'zingilt'));
            $mform->setDefault('allowcancellationsdefault', 1);
            $mform->addHelpButton('allowcancellationsdefault', 'allowcancellationsdefault', 'zingilt');
        }

        $mform->addElement('header', 'calendaroptions', get_string('calendaroptions', 'zingilt'));

        $calendaroptions = array(
            ZILT_CAL_NONE   => get_string('none'),
            ZILT_CAL_COURSE => get_string('course'),
            ZILT_CAL_SITE   => get_string('site')
        );
        $mform->addElement('select', 'showoncalendar', get_string('showoncalendar', 'zingilt'), $calendaroptions);
        $mform->setDefault('showoncalendar', ZILT_CAL_COURSE);
        $mform->addHelpButton('showoncalendar', 'showoncalendar', 'zingilt');

        $mform->addElement('advcheckbox', 'usercalentry', get_string('usercalentry', 'zingilt'));
        $mform->setDefault('usercalentry', true);
        $mform->addHelpButton('usercalentry', 'usercalentry', 'zingilt');

        $mform->addElement('text', 'shortname', get_string('shortname'), array('size' => 32, 'maxlength' => 32));
        $mform->setType('shortname', PARAM_TEXT);
        $mform->addHelpButton('shortname', 'shortname', 'zingilt');
        $mform->addRule('shortname', null, 'maxlength', 32);

        // Request message.
        $mform->addElement('header', 'request', get_string('requestmessage', 'zingilt'));
        $mform->addHelpButton('request', 'requestmessage', 'zingilt');

        $mform->addElement('text', 'requestsubject', get_string('email:subject', 'zingilt'), array('size' => '55'));
        $mform->setType('requestsubject', PARAM_TEXT);
        $mform->setDefault('requestsubject', get_string('setting:defaultrequestsubjectdefault', 'zingilt'));
        $mform->disabledIf('requestsubject', 'approvalreqd');

        $mform->addElement('textarea', 'requestmessage', get_string('email:message', 'zingilt'), 'wrap="virtual" rows="15" cols="70"');
        $mform->setDefault('requestmessage', get_string('setting:defaultrequestmessagedefault', 'zingilt'));
        $mform->disabledIf('requestmessage', 'approvalreqd');

        $mform->addElement('textarea', 'requestinstrmngr', get_string('email:instrmngr', 'zingilt'), 'wrap="virtual" rows="10" cols="70"');
        $mform->setDefault('requestinstrmngr', get_string('setting:defaultrequestinstrmngrdefault', 'zingilt'));
        $mform->disabledIf('requestinstrmngr', 'approvalreqd');

        // Confirmation message.
        $mform->addElement('header', 'confirmation', get_string('confirmationmessage', 'zingilt'));
        $mform->addHelpButton('confirmation', 'confirmationmessage', 'zingilt');

        $mform->addElement('text', 'confirmationsubject', get_string('email:subject', 'zingilt'), array('size' => '55'));
        $mform->setType('confirmationsubject', PARAM_TEXT);
        $mform->setDefault('confirmationsubject', get_string('setting:defaultconfirmationsubjectdefault', 'zingilt'));

        $mform->addElement('textarea', 'confirmationmessage', get_string('email:message', 'zingilt'), 'wrap="virtual" rows="15" cols="70"');
        $mform->setDefault('confirmationmessage', get_string('setting:defaultconfirmationmessagedefault', 'zingilt'));

        $mform->addElement('checkbox', 'emailmanagerconfirmation', get_string('emailmanager', 'zingilt'));
        $mform->addHelpButton('emailmanagerconfirmation', 'emailmanagerconfirmation', 'zingilt');

        $mform->addElement('textarea', 'confirmationinstrmngr', get_string('email:instrmngr', 'zingilt'), 'wrap="virtual" rows="4" cols="70"');
        $mform->addHelpButton('confirmationinstrmngr', 'confirmationinstrmngr', 'zingilt');
        $mform->disabledIf('confirmationinstrmngr', 'emailmanagerconfirmation');
        $mform->setDefault('confirmationinstrmngr', get_string('setting:defaultconfirmationinstrmngrdefault', 'zingilt'));

        // Reminder message.
        $mform->addElement('header', 'reminder', get_string('remindermessage', 'zingilt'));
        $mform->addHelpButton('reminder', 'remindermessage', 'zingilt');

        $mform->addElement('text', 'remindersubject', get_string('email:subject', 'zingilt'), array('size' => '55'));
        $mform->setType('remindersubject', PARAM_TEXT);
        $mform->setDefault('remindersubject', get_string('setting:defaultremindersubjectdefault', 'zingilt'));

        $mform->addElement('textarea', 'remindermessage', get_string('email:message', 'zingilt'), 'wrap="virtual" rows="15" cols="70"');
        $mform->setDefault('remindermessage', get_string('setting:defaultremindermessagedefault', 'zingilt'));

        $mform->addElement('checkbox', 'emailmanagerreminder', get_string('emailmanager', 'zingilt'));
        $mform->addHelpButton('emailmanagerreminder', 'emailmanagerreminder', 'zingilt');

        $mform->addElement('textarea', 'reminderinstrmngr', get_string('email:instrmngr', 'zingilt'), 'wrap="virtual" rows="4" cols="70"');
        $mform->addHelpButton('reminderinstrmngr', 'reminderinstrmngr', 'zingilt');
        $mform->disabledIf('reminderinstrmngr', 'emailmanagerreminder');
        $mform->setDefault('reminderinstrmngr', get_string('setting:defaultreminderinstrmngrdefault', 'zingilt'));

        $reminderperiod = array();
        for ($i = 1; $i <= 20; $i += 1) {
            $reminderperiod[$i] = $i;
        }
        $mform->addElement('select', 'reminderperiod', get_string('reminderperiod', 'zingilt'), $reminderperiod);
        $mform->setDefault('reminderperiod', 2);
        $mform->addHelpButton('reminderperiod', 'reminderperiod', 'zingilt');

        // Waitlisted message.
        $mform->addElement('header', 'waitlisted', get_string('waitlistedmessage', 'zingilt'));
        $mform->addHelpButton('waitlisted', 'waitlistedmessage', 'zingilt');

        $mform->addElement('text', 'waitlistedsubject', get_string('email:subject', 'zingilt'), array('size' => '55'));
        $mform->setType('waitlistedsubject', PARAM_TEXT);
        $mform->setDefault('waitlistedsubject', get_string('setting:defaultwaitlistedsubjectdefault', 'zingilt'));

        $mform->addElement('textarea', 'waitlistedmessage', get_string('email:message', 'zingilt'), 'wrap="virtual" rows="15" cols="70"');
        $mform->setDefault('waitlistedmessage', get_string('setting:defaultwaitlistedmessagedefault', 'zingilt'));

        // Cancellation message.
        $mform->addElement('header', 'cancellation', get_string('cancellationmessage', 'zingilt'));
        $mform->addHelpButton('cancellation', 'cancellationmessage', 'zingilt');

        $mform->addElement('text', 'cancellationsubject', get_string('email:subject', 'zingilt'), array('size' => '55'));
        $mform->setType('cancellationsubject', PARAM_TEXT);
        $mform->setDefault('cancellationsubject', get_string('setting:defaultcancellationsubjectdefault', 'zingilt'));

        $mform->addElement('textarea', 'cancellationmessage', get_string('email:message', 'zingilt'), 'wrap="virtual" rows="15" cols="70"');
        $mform->setDefault('cancellationmessage', get_string('setting:defaultcancellationmessagedefault', 'zingilt'));

        $mform->addElement('checkbox', 'emailmanagercancellation', get_string('emailmanager', 'zingilt'));
        $mform->addHelpButton('emailmanagercancellation', 'emailmanagercancellation', 'zingilt');

        $mform->addElement('textarea', 'cancellationinstrmngr', get_string('email:instrmngr', 'zingilt'), 'wrap="virtual" rows="4" cols="70"');
        $mform->addHelpButton('cancellationinstrmngr', 'cancellationinstrmngr', 'zingilt');
        $mform->disabledIf('cancellationinstrmngr', 'emailmanagercancellation');
        $mform->setDefault('cancellationinstrmngr', get_string('setting:defaultcancellationinstrmngrdefault', 'zingilt'));

        $features = new stdClass;
        $features->groups = false;
        $features->groupings = false;
        $features->groupmembersonly = false;
        $features->outcomes = false;
        $features->gradecat = false;
        $features->idnumber = true;
        $this->standard_coursemodule_elements($features);

        $this->add_action_buttons();
    }

    public function data_preprocessing(&$defaultvalues) {

        // Fix manager emails.
        if (empty($defaultvalues['confirmationinstrmngr'])) {
            $defaultvalues['confirmationinstrmngr'] = null;
        } else {
            $defaultvalues['emailmanagerconfirmation'] = 1;
        }

        if (empty($defaultvalues['reminderinstrmngr'])) {
            $defaultvalues['reminderinstrmngr'] = null;
        } else {
            $defaultvalues['emailmanagerreminder'] = 1;
        }

        if (empty($defaultvalues['cancellationinstrmngr'])) {
            $defaultvalues['cancellationinstrmngr'] = null;
        } else {
            $defaultvalues['emailmanagercancellation'] = 1;
        }
    }
}
