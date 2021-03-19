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
 * Version details
 *
 * @package    local_lingk
 * @copyright  (C) 2018 Lingk Inc (http://www.lingk.io)
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

$base = __DIR__ . '/../';
define('CLI_SCRIPT', true);
require_once $base.'config.php';

// error_reporting(E_ALL | E_STRICT); 
// ini_set('display_errors', '1'); 

//require_once '../config.php';
global $DB;


$count = 0;
$count_insert = 0;
$count_update=0;
$insert_records ='';
$update_records = '';
try
{
    //for immediate notification
    $sql_playerid_immediate = $DB->get_records_sql('Select id,user_id,player_id,title,message,module_name,tries_count from mdl_push_notification_log where status = ? and player_id is not null and tries_count < config_count and notification_type = ? and frequency = ?',[0,2,'I']);

    //to update status

        $update_sql_playerid_immediate = "update  mdl_push_notification_log set status = 2  where status = 0 and player_id is not null and tries_count < config_count and notification_type = 2 and frequency = 'I' ";
    $DB->execute($update_sql_playerid_immediate);


    if(count($sql_playerid_immediate) > 0)
    {
        foreach ($sql_playerid_immediate as  $value)
        {

            //notification logic $value->player_id
            $fields = array(
                'app_id' => "6bbfb8cd-f972-4b8d-8760-8af614bbcc6a",
                'include_player_ids' => array($value->player_id),
                'data' => array("foo" => "bar"),
               // 'large_icon' =>"maxresdefault.jpg",
                'contents' => array('en' => $value->message),
                'headings' => array('en' => $value->title)
            );

            $fields = json_encode($fields);
         
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, "https://onesignal.com/api/v1/notifications");
            curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json; charset=utf-8'));
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
            curl_setopt($ch, CURLOPT_HEADER, FALSE);
            curl_setopt($ch, CURLOPT_POST, TRUE);
            curl_setopt($ch, CURLOPT_POSTFIELDS, $fields);
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);    

            $response = curl_exec($ch);
            curl_close($ch);

            $obj = json_decode($response, true);
           


            //$DB->update($sql_playerid);


            if(isset($obj['recipients']) && $obj['recipients']  > 0)
            {
                $update_player_id = new stdClass();
                $update_player_id->id = $value->id;
                $update_player_id->status = 1;
                $update_player_id->tries_count = $value->tries_count + 1;
                $update_player_id->updated_at =time();
                $update_player_id->response = $response;

                $count_insert++;

                $insert_records .= 'User Received Notification successfully :'.$value->user_id.' and player_id :'.$value->player_id.' ';
            }
            else
            {
                $update_player_id = new stdClass();
                $update_player_id->id = $value->id;
                $update_player_id->status = 0;
                $update_player_id->tries_count = $value->tries_count + 1;
                $update_player_id->updated_at =time();
                $update_player_id->response = $response;

                $count_update++;

                $update_records .= 'User Notification Failed :'.$value->user_id.' and player_id :'.$value->player_id.' ';
            }

                $DB->update_record('push_notification_log',$update_player_id, $bulk=false);

            $count++;
         
        }//end of foreach loop
    }




    //for schedule notification
    $sql_playerid_schedule = $DB->get_records_sql('Select id,user_id,player_id,title,message,module_name,tries_count from mdl_push_notification_log where status = ? and player_id is not null and tries_count < config_count and notification_type = ? and frequency = ? and schedule_time <= unix_timestamp(now())',[0,2,'S']);



    //to update status

    $update_sql_playerid_schedule = "update  mdl_push_notification_log set status = 2  where status = 0 and player_id is not null and tries_count < config_count and notification_type = 2 and frequency = 'S' and schedule_time <= unix_timestamp(now())";
    $DB->execute($update_sql_playerid_schedule);



    if(count($sql_playerid_schedule) > 0)
    {
        foreach ($sql_playerid_schedule as  $value)
        {

            //notification logic //$value->player_id
            $fields = array(
                'app_id' => "6bbfb8cd-f972-4b8d-8760-8af614bbcc6a",
                'include_player_ids' => array($value->player_id),
                'data' => array("foo" => "bar"),
               // 'large_icon' =>"maxresdefault.jpg",
                'contents' => array('en' => $value->message),
                'headings' => array('en' => $value->title)
            );

            $fields = json_encode($fields);
         
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, "https://onesignal.com/api/v1/notifications");
            curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json; charset=utf-8'));
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
            curl_setopt($ch, CURLOPT_HEADER, FALSE);
            curl_setopt($ch, CURLOPT_POST, TRUE);
            curl_setopt($ch, CURLOPT_POSTFIELDS, $fields);
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);    

            $response = curl_exec($ch);
            curl_close($ch);

            $obj = json_decode($response, true);
           


            //$DB->update($sql_playerid);


            if(isset($obj['recipients']) && $obj['recipients']  > 0)
            {
                $update_player_id = new stdClass();
                $update_player_id->id = $value->id;
                $update_player_id->status = 1;
                $update_player_id->tries_count = $value->tries_count + 1;
                $update_player_id->updated_at =time();
                $update_player_id->response = $response;

                $count_insert++;

                $insert_records .= 'User Received Notification successfully :'.$value->user_id.' and player_id :'.$value->player_id.' ';
            }
            else
            {
                $update_player_id = new stdClass();
                $update_player_id->id = $value->id;
                $update_player_id->status = 0;
                $update_player_id->tries_count = $value->tries_count + 1;
                $update_player_id->updated_at =time();
                $update_player_id->response = $response;

                $count_update++;

                $update_records .= 'User Notification Failed :'.$value->user_id.' and player_id :'.$value->player_id.' ';
            }

                $DB->update_record('push_notification_log',$update_player_id, $bulk=false);

            $count++;
         
        }//end of foreach loop
    }


}
catch(Exception $e)
{
   $insert_records .= 'Exception Occur:'.$e.' ';
}


$cron_record                    = new stdClass();
$cron_record->name              = "Push Notification log"; 
$cron_record->cron_job_time     = date('Y-m-d h:i:s'); 
$cron_record->no_of_records     = $count;
$cron_record->insert_count      = $count_insert;
$cron_record->update_count      = $count_update;
$cron_record->inserted_record   = $insert_records;
$cron_record->updated_record    = $update_records;

$custom_sql = "INSERT INTO mdl_custom_cron(name, cron_job_time, no_of_records, inserted_record, insert_count, updated_record, update_count) VALUES ('".$cron_record->name."','".$cron_record->cron_job_time."',".$cron_record->no_of_records.",'".$cron_record->inserted_record."',".$cron_record->insert_count.",'".$cron_record->updated_record."',".$cron_record->update_count.")";
//echo $sql; exit();
$DB->execute($custom_sql);

?>
