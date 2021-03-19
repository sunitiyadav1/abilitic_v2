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

/**
 * Structure step to restore one zingilt activity
 */
class restore_zingilt_activity_structure_step extends restore_activity_structure_step {

    protected function define_structure() {
        $paths = array();
        $userinfo = $this->get_setting_value('userinfo');

        $paths[] = new restore_path_element('zingilt', '/activity/zingilt');
        $paths[] = new restore_path_element('zingilt_session', '/activity/zingilt/sessions/session');
        $paths[] = new restore_path_element('zingilt_sessions_dates', '/activity/zingilt/sessions/session/sessions_dates/sessions_date');
        $paths[] = new restore_path_element('zingilt_session_data', '/activity/zingilt/sessions/session/session_data/session_data_element');
        $paths[] = new restore_path_element('zingilt_session_field', '/activity/zingilt/sessions/session/session_field/session_field_element');
        if ($userinfo) {
            $paths[] = new restore_path_element('zingilt_signup', '/activity/zingilt/sessions/session/signups/signup');
            $paths[] = new restore_path_element('zingilt_signups_status', '/activity/zingilt/sessions/session/signups/signup/signups_status/signup_status');
            $paths[] = new restore_path_element('zingilt_session_roles', '/activity/zingilt/sessions/session/session_roles/session_role');
        }

        // Return the paths wrapped into standard activity structure.
        return $this->prepare_activity_structure($paths);
    }

    protected function process_zingilt($data) {
        global $DB;

        $data = (object)$data;
        $oldid = $data->id;
        $data->course = $this->get_courseid();

        // Insert the zingilt record.
        $newitemid = $DB->insert_record('zingilt', $data);
        $this->apply_activity_instance($newitemid);
    }

    protected function process_zingilt_session($data) {
        global $DB;

        $data = (object)$data;
        $oldid = $data->id;

        $data->zingilt = $this->get_new_parentid('zingilt');

        $data->timecreated = $this->apply_date_offset($data->timecreated);
        $data->timemodified = $this->apply_date_offset($data->timemodified);

        // Insert the entry record.
        $newitemid = $DB->insert_record('zingilt_sessions', $data);
        $this->set_mapping('zingilt_session', $oldid, $newitemid, true); // Childs and files by itemname.
    }

    protected function process_zingilt_signup($data) {
        global $DB;

        $data = (object)$data;
        $oldid = $data->id;

        $data->sessionid = $this->get_new_parentid('zingilt_session');
        $data->userid = $this->get_mappingid('user', $data->userid);

        // Insert the entry record.
        $newitemid = $DB->insert_record('zingilt_signups', $data);
        $this->set_mapping('zingilt_signup', $oldid, $newitemid, true); // Childs and files by itemname.
    }

    protected function process_zingilt_signups_status($data) {
        global $DB;

        $data = (object)$data;
        $oldid = $data->id;

        $data->signupid = $this->get_new_parentid('zingilt_signup');

        $data->timecreated = $this->apply_date_offset($data->timecreated);

        // Insert the entry record.
        $newitemid = $DB->insert_record('zingilt_signups_status', $data);
    }

    protected function process_zingilt_session_roles($data) {
        global $DB;

        $data = (object)$data;
        $oldid = $data->id;

        $data->sessionid = $this->get_new_parentid('zingilt_session');
        $data->userid = $this->get_mappingid('user', $data->userid);
        $data->roleid = $this->get_mappingid('role', $data->roleid);

        // Insert the entry record.
        $newitemid = $DB->insert_record('zingilt_session_roles', $data);
    }

    protected function process_zingilt_session_data($data) {
        global $DB;

        $data = (object)$data;
        $oldid = $data->id;

        $data->sessionid = $this->get_new_parentid('zingilt_session');
        $data->fieldid = $this->get_mappingid('zingilt_session_field');

        // Insert the entry record.
        $newitemid = $DB->insert_record('zingilt_session_data', $data);
        $this->set_mapping('zingilt_session_data', $oldid, $newitemid, true); // Childs and files by itemname.
    }

    protected function process_zingilt_session_field($data) {
        global $DB;

        $data = (object)$data;
        $oldid = $data->id;

        // Insert the entry record.
        $newitemid = $DB->insert_record('zingilt_session_field', $data);
    }

    protected function process_zingilt_sessions_dates($data) {
        global $DB;

        $data = (object)$data;
        $oldid = $data->id;

        $data->sessionid = $this->get_new_parentid('zingilt_session');

        $data->timestart = $this->apply_date_offset($data->timestart);
        $data->timefinish = $this->apply_date_offset($data->timefinish);

        // Insert the entry record.
        $newitemid = $DB->insert_record('zingilt_sessions_dates', $data);
    }

    protected function after_execute() {
        // zing ILT doesn't have any related files.
        // Add zingilt related files, no need to match by itemname (just internally handled context).
    }
}
