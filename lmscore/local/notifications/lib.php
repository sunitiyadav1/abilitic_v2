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
 * Plugin version info
 *
 * @package    local_smart_klass
 * @copyright  KlassData <kttp://www.klassdata.com>
 * @author     Oscar Ruesga <oscar@klassdata.com>
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

defined('MOODLE_INTERNAL') || die();

/**
 * Function to be run periodically according to the moodle cron
 * Prepare all statemenst and send it to an LRS
 * throw the xAPI services
 * @return void
 */

function local_notifications_cron()
{
    global $CFG;
    // if ($CFG->version < SMART_KLASS_MOODLE_27) local_smart_klass_harvest();
    local_notifications_send();
}
function local_notifications_send()
{
    global $DB;

    $count = 0;
    $count_insert = 0;
    $count_update = 0;
    $insert_records = '';
    $update_records = '';
    try
    {
        //for immediate notification
        $sql_playerid_immediate = $DB->get_records_sql('Select id,user_id,player_id,title,message,module_name,tries_count from mdl_push_notification_log where status = ? and player_id is not null and tries_count < config_count and notification_type = ? and frequency = ?', [0, 2, 'I']);

        if (count($sql_playerid_immediate) > 0) {
            foreach ($sql_playerid_immediate as $value) {

                //notification logic
                $fields = array(
                    'app_id' => "6bbfb8cd-f972-4b8d-8760-8af614bbcc6a",
                    'include_player_ids' => array($value->player_id),
                    'data' => array("foo" => "bar"),
                    // 'large_icon' =>"maxresdefault.jpg",
                    'contents' => array('en' => $value->message),
                    'headings' => array('en' => $value->title),
                );

                $fields = json_encode($fields);

                $ch = curl_init();
                curl_setopt($ch, CURLOPT_URL, "https://onesignal.com/api/v1/notifications");
                curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json; charset=utf-8'));
                curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                curl_setopt($ch, CURLOPT_HEADER, false);
                curl_setopt($ch, CURLOPT_POST, true);
                curl_setopt($ch, CURLOPT_POSTFIELDS, $fields);
                curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);

                $response = curl_exec($ch);
                curl_close($ch);

                $obj = json_decode($response, true);

                //$DB->update($sql_playerid);

                if (isset($obj['recipients']) && $obj['recipients'] > 0) {
                    $update_player_id = new stdClass();
                    $update_player_id->id = $value->id;
                    $update_player_id->status = 1;
                    $update_player_id->tries_count = $value->tries_count + 1;
                    $update_player_id->updated_at = time();
                    $update_player_id->response = $response;

                    $count_insert++;

                    $insert_records .= 'User Received Notification successfully :' . $value->user_id . ' and player_id :' . $value->player_id . ' ';
                } else {
                    $update_player_id = new stdClass();
                    $update_player_id->id = $value->id;
                    $update_player_id->tries_count = $value->tries_count + 1;
                    $update_player_id->updated_at = time();
                    $update_player_id->response = $response;

                    $count_update++;

                    $update_records .= 'User Notification Failed :' . $value->user_id . ' and player_id :' . $value->player_id . ' ';
                }

                $DB->update_record('push_notification_log', $update_player_id, $bulk = false);

                $count++;

            } //end of foreach loop
        }

        //for schedule notification
        $sql_playerid_schedule = $DB->get_records_sql('Select id,user_id,player_id,title,message,module_name,tries_count from mdl_push_notification_log where status = ? and player_id is not null and tries_count < config_count and notification_type = ? and frequency = ? and schedule_time <= unix_timestamp(now())', [0, 2, 'S']);

        if (count($sql_playerid_schedule) > 0) {
            foreach ($sql_playerid_schedule as $value) {

                //notification logic
                $fields = array(
                    'app_id' => "6bbfb8cd-f972-4b8d-8760-8af614bbcc6a",
                    'include_player_ids' => array($value->player_id),
                    'data' => array("foo" => "bar"),
                    // 'large_icon' =>"maxresdefault.jpg",
                    'contents' => array('en' => $value->message),
                    'headings' => array('en' => $value->title),
                );

                $fields = json_encode($fields);

                $ch = curl_init();
                curl_setopt($ch, CURLOPT_URL, "https://onesignal.com/api/v1/notifications");
                curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json; charset=utf-8'));
                curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                curl_setopt($ch, CURLOPT_HEADER, false);
                curl_setopt($ch, CURLOPT_POST, true);
                curl_setopt($ch, CURLOPT_POSTFIELDS, $fields);
                curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);

                $response = curl_exec($ch);
                curl_close($ch);

                $obj = json_decode($response, true);

                //$DB->update($sql_playerid);

                if (isset($obj['recipients']) && $obj['recipients'] > 0) {
                    $update_player_id = new stdClass();
                    $update_player_id->id = $value->id;
                    $update_player_id->status = 1;
                    $update_player_id->tries_count = $value->tries_count + 1;
                    $update_player_id->updated_at = time();
                    $update_player_id->response = $response;

                    $count_insert++;

                    $insert_records .= 'User Received Notification successfully :' . $value->user_id . ' and player_id :' . $value->player_id . ' ';
                } else {
                    $update_player_id = new stdClass();
                    $update_player_id->id = $value->id;
                    $update_player_id->tries_count = $value->tries_count + 1;
                    $update_player_id->updated_at = time();
                    $update_player_id->response = $response;

                    $count_update++;

                    $update_records .= 'User Notification Failed :' . $value->user_id . ' and player_id :' . $value->player_id . ' ';
                }

                $DB->update_record('push_notification_log', $update_player_id, $bulk = false);

                $count++;

            } //end of foreach loop
        }

    } catch (Exception $e) {
        $insert_records .= 'Exception Occur:' . $e . ' ';
    }

    $cron_record = new stdClass();
    $cron_record->name = "Push Notification log";
    $cron_record->cron_job_time = date('Y-m-d h:i:s');
    $cron_record->no_of_records = $count;
    $cron_record->insert_count = $count_insert;
    $cron_record->update_count = $count_update;
    $cron_record->inserted_record = $insert_records;
    $cron_record->updated_record = $update_records;

    $sql = "INSERT INTO mdl_custom_cron(name, cron_job_time, no_of_records, inserted_record, insert_count, updated_record, update_count) VALUES ('" . $cron_record->name . "','" . $cron_record->cron_job_time . "'," . $cron_record->no_of_records . ",'" . $cron_record->inserted_record . "'," . $cron_record->insert_count . ",'" . $cron_record->updated_record . "'," . $cron_record->update_count . ")";
//echo $sql; exit();
    $DB->execute($sql);
}

function local_notification_extend_settings_navigation(global_navigation $navigation) {
    global $CFG, $PAGE;
 
    // Only add this settings item on non-site course pages.
    // if (!$PAGE->course or $PAGE->course->id == 1) {
    //     return;
    // }
 
    // // Only let users with the appropriate capability see this settings item.
    // if (!has_capability('moodle/backup:backupcourse', context_course::instance($PAGE->course->id))) {
    //     return;
    // }
 
  /*  if ($home = $navigation->find('home', global_navigation::TYPE_SETTING)) {
        $strfoo = get_string('send_notification', 'local_notification');
        $url = new moodle_url('/local/notifications/index.php', array());
        $foonode = navigation_node::create(
            $strfoo,
            $url,
            navigation_node::NODETYPE_LEAF,
            'notifications',
            'notifications',
            new pix_icon('t/addcontact', $strfoo)
        );

die("sdfsdf");
$pmasternode = null;
$parent=0;
$url = new moodle_url('/local/notifications/index.php', array());
if ($parent) {
    $childnode = $pmasternode->add('Test Manual notifications', $url, navigation_node::TYPE_CUSTOM);
    $childnode->title("TESST MANUAL NOTIFICATION");
} else {
    $masternode = $PAGE->navigation->add('Test Manual notifications',$url, navigation_node::TYPE_CONTAINER);
    $masternode->title("TESST MANUAL NOTIFICATION");
   
        $masternode->isexpandable = true;
        $masternode->showinflatnavigation = true;
    
}*/

//}
      /*  if ($PAGE->url->compare($url, URL_MATCH_BASE)) {
            $foonode->make_active();
        }
        $home->add_node($foonode);
    }*/
}