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

require_once($CFG->dirroot . '/mod/zingilt/lib.php');

$settings->add(new admin_setting_configtext(
    'zingilt_fromaddress',
    get_string('setting:fromaddress_caption', 'zingilt'),
    get_string('setting:fromaddress', 'zingilt'),
    get_string('setting:fromaddressdefault', 'zingilt'),
    "/^((?:[\w\.\-])+\@(?:(?:[a-zA-Z\d\-])+\.)+(?:[a-zA-Z\d]{2,4}))$/",
    30
));

// Load roles.
$choices = array();
if ($roles = role_fix_names(get_all_roles(), context_system::instance())) {
    foreach ($roles as $role) {
        $choices[$role->id] = format_string($role->localname);
    }
}

$settings->add(new admin_setting_configmultiselect(
    'zingilt_session_roles',
    get_string('setting:sessionroles_caption', 'zingilt'),
    get_string('setting:sessionroles', 'zingilt'),
    array(9),
    $choices
));
$settings->add(new admin_setting_configselect(
    'zingilt_RMsession_role',
    get_string('setting:RMsessionroles_caption', 'zingilt'),
    get_string('setting:RMsessionroles', 'zingilt'),
    '9',
    $choices
));


$settings->add(new admin_setting_heading(
    'zingilt_manageremail_header',
    get_string('manageremailheading', 'zingilt'),
    ''
));

$settings->add(new admin_setting_configcheckbox(
    'zingilt_addchangemanageremail',
    get_string('setting:addchangemanageremail_caption', 'zingilt'),
    get_string('setting:addchangemanageremail', 'zingilt'),
    0
));

$settings->add(new admin_setting_configtext(
    'zingilt_manageraddressformat',
    get_string('setting:manageraddressformat_caption', 'zingilt'),
    get_string('setting:manageraddressformat', 'zingilt'),
    get_string('setting:manageraddressformatdefault', 'zingilt'),
    PARAM_TEXT
));

$settings->add(new admin_setting_configtext(
    'zingilt_manageraddressformatreadable',
    get_string('setting:manageraddressformatreadable_caption', 'zingilt'),
    get_string('setting:manageraddressformatreadable', 'zingilt'),
    get_string('setting:manageraddressformatreadabledefault', 'zingilt'),
    PARAM_NOTAGS
));

$settings->add(new admin_setting_heading('zingilt_cost_header', get_string('costheading', 'zingilt'), ''));

$settings->add(new admin_setting_configcheckbox(
    'zingilt_hidecost',
    get_string('setting:hidecost_caption', 'zingilt'),
    get_string('setting:hidecost', 'zingilt'),
    0
));

$settings->add(new admin_setting_configcheckbox(
    'zingilt_hidediscount',
    get_string('setting:hidediscount_caption', 'zingilt'),
    get_string('setting:hidediscount', 'zingilt'),
    0
));

$settings->add(new admin_setting_heading('zingilt_icalendar_header', get_string('icalendarheading', 'zingilt'), ''));

$settings->add(new admin_setting_configcheckbox(
    'zingilt_oneemailperday',
    get_string('setting:oneemailperday_caption', 'zingilt'),
    get_string('setting:oneemailperday', 'zingilt'),
    0
));

$settings->add(new admin_setting_configcheckbox(
    'zingilt_disableicalcancel',
    get_string('setting:disableicalcancel_caption', 'zingilt'),
    get_string('setting:disableicalcancel', 'zingilt'),
    0
));

// List of existing custom fields.
$html  = zingilt_list_of_customfields();
$html .= html_writer::start_tag('p');
$url   = new moodle_url('/mod/zingilt/customfield.php', array('id' => 0));
$html .= html_writer::link($url, get_string('addnewfieldlink', 'zingilt'));
$html .= html_writer::end_tag('p');

$settings->add(new admin_setting_heading('zingilt_customfields_header', get_string('customfieldsheading', 'zingilt'), $html));

// List of existing site notices.
$html  = zingilt_list_of_sitenotices();
$html .= html_writer::start_tag('p');
$url  = new moodle_url('/mod/zingilt/sitenotice.php', array('id' => 0));
$html .= html_writer::link($url, get_string('addnewnoticelink', 'zingilt'));
$html .= html_writer::end_tag('p');

$settings->add(new admin_setting_heading('zingilt_sitenotices_header', get_string('sitenoticesheading', 'zingilt'), $html));
