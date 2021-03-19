<?php

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
 * External Web Service Template
 *
 * @package    localwstemplate
 * @copyright  2011 Moodle Pty Ltd (http://moodle.com)
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
require_once $CFG->libdir . "/externallib.php";
require_once "push_notification_form.php";
class local_notifications_external extends external_api
{

    /**
     * Returns description of method parameters
     * @return external_function_parameters
     */
    public static function save_notification_parameters()
    {
        return new external_function_parameters(
            array(
                'title' => new external_value(PARAM_TEXT, 'The Title of the Notification. By default it is null',VALUE_DEFAULT, ''),
                'message' => new external_value(PARAM_TEXT, 'The Message of the Notification. By default it is null',VALUE_DEFAULT, ''),
                'cohortids' => new external_multiple_structure(
                    new external_value(PARAM_INT, 'Cohort ids'), VALUE_DEFAULT, array()),
                'userids' => new external_multiple_structure(
                    new external_value(PARAM_INT, 'User ids'
                    , 'List of User ids. If empty return No User at all',
                    VALUE_OPTIONAL) ), 'options - operator OR is used', VALUE_DEFAULT, array(),
                'frequency' => new external_value(PARAM_TEXT, 'The Frequency of the Notification.  By default it is I - Immediately.. options are I- Immediately,S- Scheduled
                        ',VALUE_DEFAULT, 'I'),
                'notification_type_id' =>  new external_value(PARAM_INT, 'The Notification type of the Notification.  By default it is 2 - App/Mobile.. 
                    options are 1- Email,2- App/Mobile,3-web
                ',VALUE_DEFAULT, '2'),
                'scheduledate' => new external_value(PARAM_INT, 'The Timestamp Value for the schedule Date of the Notification.',
                VALUE_DEFAULT, strtotime(date("Y-m-d H:i:s")))
            )
        );
    }

    /**
     * Returns welcome message
     * @return string welcome message
     */
    public static function save_notification($welcomemessage = 'Hello world, ')
    {
        global $USER;
        //Parameter validation
        //REQUIRED
        $params = self::validate_parameters(self::save_notification_parameters(), 
                        array('title' => 'title',
                            'message'=>'message',
                            'cohortids'=> [],
                            'userids' => [],
                            'frequency' => 'I',
                            'notification_type_id' => 2,
                            'scheduledate' => strtotime(date("Y-m-d H:i:s"))
                        )
                    );

        $pn = new push_notification_form();
        $data = $pn->save($params);
        
        return $data;
        //return $params['welcomemessage'] . $USER->firstname;
    }

    /**
     * Returns description of method result value
     * @return external_description
     */
    public static function save_notification_returns()
    {
        //return new external_value(PARAM_ARRAY, []);
        /*
         $result['status'] = 0;
                $result['message'] = "Notification Log Created Successfully.";
                $result['result'] = $id;
        */
        return new external_multiple_structure(
            new external_single_structure(
                array(
                    'status' => new external_value(PARAM_INT, 'status'),
                    'message' => new external_value(PARAM_TEXT, 'message'),                    
                    'result' => new external_multiple_structure(
                        new external_value(PARAM_INT, 'id') ,'result')       
                ), 'List of results'
            )
        );
    }

}
