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
$linkurl = new moodle_url('/');
// Print the page header.
$PAGE->set_context($context);
$PAGE->set_url($linkurl);
$PAGE->set_pagelayout('admin');
$PAGE->set_title($linktext);

// Set the page heading.
$PAGE->set_heading($linktext . " - " . get_string('manual_notifications', 'local_notifications'));

$PAGE->navbar->add($linktext, $linkurl);
$PAGE->navbar->add(get_string('manual_notifications', 'local_notifications'));
$push_notification = new push_notification_form();
//$PAGE->requires->js_call_amd("local_notifications/validation", "init");
if ($data = $push_notification->get_data()) {
    //
    if ($data->cohortids == null && $data->userids == null) {
        echo "You must Select atleast one cohort or User in order to Send Notification";
        $errors['showerrors'] = "You must select Atleast Any User or Cohorts";
        exit;
    }
    $result = $push_notification->save($data);
    if ($result['status'] == 0) {
        redirect($returnurl, $result['message'], null, \core\output\notification::NOTIFY_SUCCESS);
    } else {
        redirect($returnurl, $result['message'], null, \core\output\notification::NOTIFY_ERROR);
    }
}
$link = new moodle_url('/my');
if (has_capability('local/notifications:manage', context_system::instance(),$USER->id)) {
echo $OUTPUT->header();
//$push_notification->set_data($data);

$push_notification->display();
echo "<BR><BR><a class=\"btn btn-success\" href=\"notification_report.php\">" . get_string('notification_report', $block) . "</a>&nbsp";

$link = new moodle_url('/my');
echo '<BR><a class="btn btn-primary" href="' . $link . '">' . get_string('todashboard', 'local_notifications') . '</a>';
echo $OUTPUT->footer();
}else{
    redirect($link, "You don't have Capability to access this module. Please Try again.", null, \core\output\notification::NOTIFY_ERROR);
  
}

