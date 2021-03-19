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
 * Local Notifications Settings
 *
 * @package    local_notifications
 * @copyright  zinghr <kttp://www.zinghr.com>
 * @author     Kajal Tailor <kajal.tailor@zinghr.com>
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

defined('MOODLE_INTERNAL') || die;

$context = context_system::instance();
$roles = get_user_roles($context, $USER->id, true);
$has_mytestrole_role = FALSE;

if(in_array('manager',$roles)){
   $has_mytestrole_role = TRUE;
}

if (has_capability('local/notifications:manage', context_system::instance())) {
if (($hassiteconfig)||($has_mytestrole_role==TRUE)) {
   $ADMIN->add('root', new admin_category('local_notifications', get_string('pluginname', 'local_notifications')));

    $index_page = new admin_externalpage('local_notifications_index',get_string('pluginname', 'local_notifications'),new moodle_url('/local/notifications/index.php'));
    $ADMIN->add('local_notifications',$index_page);

    //$admin_page = new admin_externalpage( 'local_notifications_admin', get_string('settings','local_notifications'),new moodle_url('/local/notifications/notificationssettings.php'));
    //$ADMIN->add('local_notifications',$admin_page);

}
}