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

require_once '../../config.php';
require_once 'push_notification_form.php';

global $DB;
$block = 'local_notifications';
$baseurl = new moodle_url(basename(__FILE__), array());
$returnurl = $baseurl;
// Get the SYSTEM context.
$context = context_system::instance();
require_login(null, false); // Adds to $PAGE, creates $OUTPUT.
// Correct the navbar.
// Set the name for the page.
$linktext = get_string('notifications', $block);
// Set the url.
$linkurl = new moodle_url('/local/notifications/index.php');
// Print the page header.
$PAGE->set_context($context);
$PAGE->set_url($linkurl);
$PAGE->set_pagelayout('admin');
$PAGE->set_title($linktext);
// Set the page heading.
$PAGE->set_heading($linktext . " - " . get_string('notification_report', 'local_notifications'));
$PAGE->navbar->add($linktext, $linkurl);
$PAGE->navbar->add(get_string('notification_report', 'local_notifications'));
$push_notification = new push_notification_form();
//$PAGE->requires->js_call_amd("local_notifications/validation", "init");
if (has_capability('local/notifications:manage', context_system::instance(),$USER->id)) {
echo $OUTPUT->header();
//$push_notification->set_data($data);
//$push_notification->display();
echo $push_notification->getNotificationReportList();
$link = new moodle_url('/my');
echo '<a class="btn btn-primary" href="' . $link . '">' . get_string('todashboard', 'local_notifications') . '</a>';
echo $OUTPUT->footer();
}else{
    redirect($link, "You don't have Capability to access this module. Please Try again.", null, \core\output\notification::NOTIFY_ERROR);
  
}