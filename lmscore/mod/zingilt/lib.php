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

require_once($CFG->libdir . '/gradelib.php');
require_once($CFG->dirroot . '/grade/lib.php');
require_once($CFG->dirroot . '/lib/adminlib.php');
require_once($CFG->dirroot . '/user/selector/lib.php');
require_once($CFG->libdir . '/completionlib.php');
//require_once($CFG->dirroot . '/resourcemgmt/locallib.php'); // For Resource Management Operations...

/*
 * Definitions for setting notification types.
 */

// Utility definitions.
define('MDL_ZILT_ICAL',   1);
define('MDL_ZILT_TEXT',   2);
define('MDL_ZILT_BOTH',   3);
define('MDL_ZILT_INVITE', 4);
define('MDL_ZILT_CANCEL', 8);

// Definitions for use in forms.
define('MDL_ZILT_INVITE_BOTH', 7);     // Send a copy of both 4+1+2.
define('MDL_ZILT_INVITE_TEXT', 6);     // Send just a plain email 4+2.
define('MDL_ZILT_INVITE_ICAL', 5);     // Send just a combined text/ical message 4+1.
define('MDL_ZILT_CANCEL_BOTH', 11);    // Send a copy of both 8+2+1.
define('MDL_ZILT_CANCEL_TEXT', 10);    // Send just a plan email 8+2.
define('MDL_ZILT_CANCEL_ICAL', 9);     // Send just a combined text/ical message 8+1.

// Name of the custom field where the manager's email address is stored.
define('MDL_ZILT_MANAGERSEMAIL_FIELD', 'managersemail');

// Custom field related constants.
define('ZILT_CUSTOMFIELD_DELIMITER', '##SEPARATOR##');
define('ZILT_CUSTOMFIELD_TYPE_TEXT',        0);
define('ZILT_CUSTOMFIELD_TYPE_SELECT',      1);
define('ZILT_CUSTOMFIELD_TYPE_MULTISELECT', 2);

// Calendar-related constants.
define('ZILT_CALENDAR_MAX_NAME_LENGTH', 15);
define('ZILT_CAL_NONE',   0);
define('ZILT_CAL_COURSE', 1);
define('ZILT_CAL_SITE',   2);

// Signup status codes (remember to update zingilt_statuses()).
define('MDL_ZILT_STATUS_USER_CANCELLED', 10);

// SESSION_CANCELLED is not yet implemented.
define('MDL_ZILT_STATUS_SESSION_CANCELLED',  20);
define('MDL_ZILT_STATUS_DECLINED',           30);
define('MDL_ZILT_STATUS_REQUESTED',          40);
define('MDL_ZILT_STATUS_APPROVED',           50);
define('MDL_ZILT_STATUS_WAITLISTED',         60);
define('MDL_ZILT_STATUS_BOOKED',             70);
define('MDL_ZILT_STATUS_NO_SHOW',            80);
define('MDL_ZILT_STATUS_PARTIALLY_ATTENDED', 90);
define('MDL_ZILT_STATUS_FULLY_ATTENDED',     100);

/**
 * Returns the list of possible zingilt status.
 *
 * @param int $statuscode One of the MDL_ZILT_STATUS* constants
 * @return string $string Human readable code
 */
function zingilt_statuses()
{
    // This array must match the status codes above, and the values
    // must equal the end of the constant name but in lower case.

    return array(
        MDL_ZILT_STATUS_USER_CANCELLED      => 'user_cancelled',
        // MDL_ZILT_STATUS_SESSION_CANCELLED   => 'session_cancelled', // Not yet implemented.
        MDL_ZILT_STATUS_DECLINED            => 'declined',
        MDL_ZILT_STATUS_REQUESTED           => 'requested',
        MDL_ZILT_STATUS_APPROVED            => 'approved',
        MDL_ZILT_STATUS_WAITLISTED          => 'waitlisted',
        MDL_ZILT_STATUS_BOOKED              => 'booked',
        MDL_ZILT_STATUS_NO_SHOW             => 'no_show',
        MDL_ZILT_STATUS_PARTIALLY_ATTENDED  => 'partially_attended',
        MDL_ZILT_STATUS_FULLY_ATTENDED      => 'fully_attended',
    );
}

/**
 * Returns the human readable code for a zing ILT status
 *
 * @param int $statuscode One of the MDL_ZILT_STATUS* constants
 * @return string $string Human readable code
 */
function zingilt_get_status($statuscode)
{
    $statuses = zingilt_statuses();

    // Check code exists.
    if (!isset($statuses[$statuscode])) {
        print_error('ZILT status code does not exist: ' . $statuscode);
    }

    // Get code.
    $string = $statuses[$statuscode];

    // Check to make sure the status array looks to be up-to-date.
    if (constant('MDL_ZILT_STATUS_' . strtoupper($string)) != $statuscode) {
        print_error('ZILT status code array does not appear to be up-to-date: ' . $statuscode);
    }

    return $string;
}

/**
 * Prints the cost amount along with the appropriate currency symbol.
 *
 * To set your currency symbol, set the appropriate 'locale' in
 * lang/en_utf8/langconfig.php (or the equivalent file for your
 * language).
 *
 * @param int  $amount     Numerical amount without currency symbol
 * @param bool $htmloutput Whether the output is in HTML or not
 */
function zilt_format_cost($amount, $htmloutput = true)
{
    setlocale(LC_MONETARY, get_string('locale', 'langconfig'));
    $localeinfo = localeconv();

    $symbol = $localeinfo['currency_symbol'];
    if (empty($symbol)) {

        // Cannot get the locale information, default to en_US.UTF-8.
        return '$' . $amount;
    }

    // Character between the currency symbol and the amount.
    $separator = '';
    if ($localeinfo['p_sep_by_space']) {
        $separator = $htmloutput ? '&nbsp;' : ' ';
    }

    // The symbol can come before or after the amount.
    if ($localeinfo['p_cs_precedes']) {
        return $symbol . $separator . $amount;
    } else {
        return $amount . $separator . $symbol;
    }
}

/**
 * Returns the effective cost of a session depending on the presence
 * or absence of a discount code.
 *
 * @param class $sessiondata contains the discountcost and normalcost
 */
function zingilt_cost($userid, $sessionid, $sessiondata, $htmloutput = true)
{
    global $CFG, $DB;

    $count = $DB->count_records_sql("SELECT COUNT(*)
                               FROM {zingilt_signups} su,
                                    {zingilt_sessions} se
                              WHERE su.sessionid = ?
                                AND su.userid = ?
                                AND su.discountcode IS NOT NULL
                                AND su.sessionid = se.id", array($sessionid, $userid));
    if ($count > 0) {
        return zilt_format_cost($sessiondata->discountcost, $htmloutput);
    } else {
        return zilt_format_cost($sessiondata->normalcost, $htmloutput);
    }
}

/**
 * Human-readable version of the duration field used to display it to
 * users
 *
 * @param  int $duration duration in hours
 * @return string
 */
function zilt_format_duration($duration)
{
    $components = explode(':', $duration);

    // Default response.
    $string = '';

    // Check for bad characters.
    if (trim(preg_match('/[^0-9:\.\s]/', $duration))) {
        return $string;
    }

    if ($components and count($components) > 1) {

        // E.g. "1:30" => "1 hour and 30 minutes".
        $hours = round($components[0]);
        $minutes = round($components[1]);
    } else {

        // E.g. "1.5" => "1 hour and 30 minutes".
        $hours = floor($duration);
        $minutes = round(($duration - floor($duration)) * 60);
    }

    // Check if either minutes is out of bounds.
    if ($minutes >= 60) {
        return $string;
    }

    if (1 == $hours) {
        $string = get_string('onehour', 'zingilt');
    } else if ($hours > 1) {
        $string = get_string('xhours', 'zingilt', $hours);
    }

    // Insert separator between hours and minutes.
    if ($string != '') {
        $string .= ' ';
    }

    if (1 == $minutes) {
        $string .= get_string('oneminute', 'zingilt');
    } else if ($minutes > 0) {
        $string .= get_string('xminutes', 'zingilt', $minutes);
    }

    return $string;
}

/**
 * Converts minutes to hours
 */
function zingilt_minutes_to_hours($minutes)
{
    if (!intval($minutes)) {
        return 0;
    }

    if ($minutes > 0) {
        $hours = floor($minutes / 60.0);
        $mins = $minutes - ($hours * 60.0);
        return "$hours:$mins";
    } else {
        return $minutes;
    }
}

/**
 * Converts hours to minutes
 */
function zingilt_hours_to_minutes($hours)
{
    $components = explode(':', $hours);
    if ($components and count($components) > 1) {

        // E.g. "1:45" => 105 minutes.
        $hours = $components[0];
        $minutes = $components[1];
        return $hours * 60.0 + $minutes;
    } else {
        // E.g. "1.75" => 105 minutes.
        return round($hours * 60.0);
    }
}

/**
 * Turn undefined manager messages into empty strings and deal with checkboxes
 */
function zingilt_fix_settings($zingilt)
{

    if (empty($zingilt->emailmanagerconfirmation)) {
        $zingilt->confirmationinstrmngr = null;
    }
    if (empty($zingilt->emailmanagerreminder)) {
        $zingilt->reminderinstrmngr = null;
    }
    if (empty($zingilt->emailmanagercancellation)) {
        $zingilt->cancellationinstrmngr = null;
    }
    if (empty($zingilt->usercalentry)) {
        $zingilt->usercalentry = 0;
    }
    if (empty($zingilt->thirdpartywaitlist)) {
        $zingilt->thirdpartywaitlist = 0;
    }
    if (empty($zingilt->approvalreqd)) {
        $zingilt->approvalreqd = 0;
    }
}

/**
 * Given an object containing all the necessary data, (defined by the
 * form in mod.html) this function will create a new instance and
 * return the id number of the new instance.
 */
function zingilt_add_instance($zingilt)
{
    global $DB;

    $zingilt->timemodified = time();
    zingilt_fix_settings($zingilt);
    if ($zingilt->id = $DB->insert_record('zingilt', $zingilt)) {
        zingilt_grade_item_update($zingilt);
    }

    // Update any calendar entries.
    if ($sessions = zingilt_get_sessions($zingilt->id)) {
        foreach ($sessions as $session) {
            zingilt_update_calendar_entries($session, $zingilt);
        }
    }

    return $zingilt->id;
}

/**
 * Given an object containing all the necessary data, (defined by the
 * form in mod.html) this function will update an existing instance
 * with new data.
 */
function zingilt_update_instance($zingilt, $instanceflag = true)
{
    global $DB;

    if ($instanceflag) {
        $zingilt->id = $zingilt->instance;
    }

    zingilt_fix_settings($zingilt);
    if ($return = $DB->update_record('zingilt', $zingilt)) {
        zingilt_grade_item_update($zingilt);

        // Update any calendar entries.
        if ($sessions = zingilt_get_sessions($zingilt->id)) {
            foreach ($sessions as $session) {
                zingilt_update_calendar_entries($session, $zingilt);
            }
        }
    }

    return $return;
}

/**
 * Given an ID of an instance of this module, this function will
 * permanently delete the instance and any data that depends on it.
 */
function zingilt_delete_instance($id)
{
    global $CFG, $DB;

    if (!$zingilt = $DB->get_record('zingilt', array('id' => $id))) {
        return false;
    }

    $result = true;
    $transaction = $DB->start_delegated_transaction();
    $DB->delete_records_select(
        'zingilt_signups_status',
        "signupid IN
        (
            SELECT
            id
            FROM
    {zingilt_signups}
    WHERE
    sessionid IN
    (
        SELECT
        id
        FROM
    {zingilt_sessions}
    WHERE
    zingilt = ? ))
    ",
        array($zingilt->id)
    );

    $DB->delete_records_select('zingilt_signups', "sessionid IN (SELECT id FROM {zingilt_sessions} WHERE zingilt = ?)", array($zingilt->id));
    $DB->delete_records_select('zingilt_sessions_dates', "sessionid in (SELECT id FROM {zingilt_sessions} WHERE zingilt = ?)", array($zingilt->id));
    $DB->delete_records('zingilt_sessions', array('zingilt' => $zingilt->id));
    $DB->delete_records('zingilt', array('id' => $zingilt->id));
    $DB->delete_records('event', array('modulename' => 'zingilt', 'instance' => $zingilt->id)); // Course events.
    $DB->delete_records('event', array('modulename' => '0', 'eventtype' => 'zingiltsession', 'instance' => $zingilt->id)); // User events and Site events.
    $DB->delete_records_select('zingilt_session_roles', "sessionid in (SELECT id FROM {zingilt_sessions} WHERE zingilt = ?)", array($zingilt->id));
    $DB->delete_records_select('resource_booking', "facetoface_id =?", array($zingilt->id));
    zingilt_grade_item_delete($zingilt);
    $transaction->allow_commit();

    return $result;
}

/**
 * Prepare the user data to go into the database.
 */
function zilt_cleanup_session_data($session)
{

    // Convert hours (expressed like "1.75" or "2" or "3.5") to minutes.
    $session->duration = zingilt_hours_to_minutes($session->duration);

    // Only numbers allowed here.
    $session->capacity = preg_replace('/[^\d]/', '', $session->capacity);
    $maxcap = 100000;
    if ($session->capacity < 1) {
        $session->capacity = 1;
    } else if ($session->capacity > $maxcap) {
        $session->capacity = $maxcap;
    }

    // Get the decimal point separator.
    setlocale(LC_MONETARY, get_string('locale', 'langconfig'));
    $localeinfo = localeconv();
    $symbol = $localeinfo['decimal_point'];
    if (empty($symbol)) {

        // Cannot get the locale information, default to en_US.UTF-8.
        $symbol = '.';
    }

    // Only numbers or decimal separators allowed here.
    $session->normalcost = round(preg_replace("/[^\d$symbol]/", '', $session->normalcost));
    $session->discountcost = round(preg_replace("/[^\d$symbol]/", '', $session->discountcost));

    return $session;
}

/**
 * Create a new entry in the zingilt_sessions table
 */
function zingilt_add_session($session, $sessiondates)
{
    global $USER, $DB;
   // echo "<pre>"; print_r($session); die;

    $session->timecreated = time();
    $session = zilt_cleanup_session_data($session);

    $eventname = $DB->get_field('zingilt', 'name,id', array('id' => $session->zingilt));
    
    $session->id = $DB->insert_record('zingilt_sessions', $session);
    /*added by kajal for add record in the Resource Booking Table */
    if(isset($session->booking_data_json)){
        $booking_data_json = $session->booking_data_json;
        if ($booking_data_json != "") {
            $zingiltid = $session->zingilt;
            $sessionid = $session->id;
            $data = $session->new_booking_data_json;
            $resource_id = resource_booking_add_to_class($data, $zingiltid, $sessionid);
        }
    }
    if (empty($sessiondates)) {

        // Insert a dummy date record.
        $date = new stdClass();
        $date->sessionid = $session->id;
        $date->timestart = 0;
        $date->timefinish = 0;

        $DB->insert_record('zingilt_sessions_dates', $date);
    } else {
        foreach ($sessiondates as $date) {
            $date->sessionid = $session->id;
            $DB->insert_record('zingilt_sessions_dates', $date);
        }
    }

    // Create any calendar entries.
    $session->sessiondates = $sessiondates;
    zingilt_update_calendar_entries($session);

    return $session->id;
}

/**
 * Modify an entry in the zingilt_sessions table
 */
function zingilt_update_session($session, $sessiondates)
{
    global $DB;
    //echo "<pre>";print_r($session);die;
    $session->timemodified = time();
    $session = zilt_cleanup_session_data($session);

    $transaction = $DB->start_delegated_transaction();
    $DB->update_record('zingilt_sessions', $session);
    $DB->delete_records('zingilt_sessions_dates', array('sessionid' => $session->id));

    $zingiltid = $session->zingilt;
    if(isset($session->booking_data_json)){
        $booking_data_json = $session->booking_data_json;

        $sessionid = $session->id;
        /*added by kajal for add record in the Resource Booking Table */
        if ($booking_data_json != "") {
            $data = $session->new_booking_data_json;
            $resource_id = resource_booking_add_to_class($data, $zingiltid, $sessionid);
        }
     }
    if (empty($sessiondates)) {

        // Insert a dummy date record.
        $date = new stdClass();
        $date->sessionid = $session->id;
        $date->timestart = 0;
        $date->timefinish = 0;
        $DB->insert_record('zingilt_sessions_dates', $date);
    } else {
        foreach ($sessiondates as $date) {
            $date->sessionid = $session->id;
            $DB->insert_record('zingilt_sessions_dates', $date);
        }
    }

    // Update any calendar entries.
    $session->sessiondates = $sessiondates;
    zingilt_update_calendar_entries($session);
    $transaction->allow_commit();

    return zingilt_update_attendees($session);
}

/**
 * Update calendar entries for a given session
 *
 * @param int $session ID of session to update event for
 * @param int $zingilt ID of zingilt activity (optional)
 */
function zingilt_update_calendar_entries($session, $zingilt = null)
{
    global $USER, $DB;

    if (empty($zingilt)) {
        $zingilt = $DB->get_record('zingilt', array('id' => $session->zingilt));
    }

    // Remove from all calendars.
    zingilt_delete_user_calendar_events($session, 'booking');
    zingilt_delete_user_calendar_events($session, 'session');
    zingilt_remove_session_from_calendar($session, 0); // Session user event for session creator.
    zingilt_remove_session_from_calendar($session, $zingilt->course); // Session course event.
    zingilt_remove_session_from_calendar($session, SITEID); // Session site event.

    if (empty($zingilt->showoncalendar) && empty($zingilt->usercalentry)) {
        return true;
    }

    // Add to NEW calendartype.
    if ($zingilt->usercalentry) {

        // Get ALL enrolled/booked users.
        $users = zingilt_get_attendees($session->id);
        // If session creator is not enrolled in the course, add the session to his/her events user calendar.
        if (!in_array($USER->id, $users)) {
            zingilt_add_session_to_calendar($session, $zingilt, 'user', $USER->id, 'session');
        }

        foreach ($users as $user) {
            $eventtype = $user->statuscode == MDL_ZILT_STATUS_BOOKED ? 'booking' : 'session';
            zingilt_add_session_to_calendar($session, $zingilt, 'user', $user->id, $eventtype);
        }
    }

    if ($zingilt->showoncalendar == ZILT_CAL_COURSE) {
        zingilt_add_session_to_calendar($session, $zingilt, 'course', $USER->id);
    } else if ($zingilt->showoncalendar == ZILT_CAL_SITE) {
        zingilt_add_session_to_calendar($session, $zingilt, 'site', $USER->id);
    }

    return true;
}

/**
 * Update attendee list status' on booking size change
 */
function zingilt_update_attendees($session)
{
    global $USER, $DB;

    // Get zingilt.
    $zingilt = $DB->get_record('zingilt', array('id' => $session->zingilt));

    // Get course.
    $course = $DB->get_record('course', array('id' => $zingilt->course));

    // Update user status'.
    $users = zingilt_get_attendees($session->id);

    if ($users) {

        // No/deleted session dates.
        if (empty($session->datetimeknown)) {

            // Convert any bookings to waitlists.
            foreach ($users as $user) {
                if ($user->statuscode == MDL_ZILT_STATUS_BOOKED) {

                    if (!zingilt_user_signup($session, $zingilt, $course, $user->discountcode, $user->notificationtype, MDL_ZILT_STATUS_WAITLISTED, $user->id)) {
                        return false;
                    }
                }
            }
        } else {

            // Session dates exist.
            // Convert earliest signed up users to booked, and make the rest waitlisted.
            $capacity = $session->capacity;

            // Count number of booked users.
            $booked = 0;
            foreach ($users as $user) {
                if ($user->statuscode == MDL_ZILT_STATUS_BOOKED) {
                    $booked++;
                }
            }

            // If booked less than capacity, book some new users.
            if ($booked < $capacity) {
                foreach ($users as $user) {
                    if ($booked >= $capacity) {
                        break;
                    }

                    if ($user->statuscode == MDL_ZILT_STATUS_WAITLISTED) {

                        if (!zingilt_user_signup($session, $zingilt, $course, $user->discountcode, $user->notificationtype, MDL_ZILT_STATUS_BOOKED, $user->id)) {
                            return false;
                        }
                        $booked++;
                    }
                }
            }
        }
    }

    return $session->id;
}

/**
 * Return an array of all zingilt activities in the current course
 */
function zingilt_get_zingilt_menu()
{
    global $CFG, $DB;

    if ($zingilts = $DB->get_records_sql("SELECT f.id, c.shortname, f.name
                                            FROM {course} c, {zingilt} f
                                            WHERE c.id = f.course
                                            ORDER BY c.shortname, f.name")) {
        $i = 1;
        foreach ($zingilts as $zingilt) {
            $f = $zingilt->id;
            $zingiltmenu[$f] = $zingilt->shortname . ' --- ' . $zingilt->name;
            $i++;
        }

        return $zingiltmenu;
    } else {
        return '';
    }
}

/**
 * Delete entry from the zingilt_sessions table along with all
 * related details in other tables
 *
 * @param object $session Record from zingilt_sessions
 */
function zingilt_delete_session($session)
{
    global $CFG, $DB;

    $zingilt = $DB->get_record('zingilt', array('id' => $session->zingilt));

    // Cancel user signups (and notify users).
    $signedupusers = $DB->get_records_sql(
        "
            SELECT DISTINCT
                userid
            FROM
                {zingilt_signups} s
            LEFT JOIN
                {zingilt_signups_status} ss
             ON ss.signupid = s.id
            WHERE
                s.sessionid = ?
            AND ss.superceded = 0
            AND ss.statuscode >= ?
        ",
        array($session->id, MDL_ZILT_STATUS_REQUESTED)
    );

    if ($signedupusers and count($signedupusers) > 0) {
        foreach ($signedupusers as $user) {
            if (zingilt_user_cancel($session, $user->userid, true)) {
                zingilt_send_cancellation_notice($zingilt, $session, $user->userid);
            } else {
                return false; // Cannot rollback since we notified users already.
            }
        }
    }

    $transaction = $DB->start_delegated_transaction();

    // Remove entries from user calendars.
    $DB->delete_records_select(
        'event',
        "modulename = '0' AND
                                         eventtype like 'zingilt%' AND
                                         courseid = 0 AND instance = ?",
        array($zingilt->id)
    );

    // Remove entry from course calendar.
    zingilt_remove_session_from_calendar($session, $zingilt->course);

    // Remove entry from site-wide calendar.
    zingilt_remove_session_from_calendar($session, SITEID);

    // Delete session details.
    $DB->delete_records('zingilt_sessions', array('id' => $session->id));
    $DB->delete_records('zingilt_sessions_dates', array('sessionid' => $session->id));
    $DB->delete_records_select(
        'zingilt_signups_status',
        "signupid IN
        (
            SELECT
                id
            FROM
                {zingilt_signups}
            WHERE
                sessionid = {$session->id}
        )
        "
    );
    $DB->delete_records('zingilt_signups', array('sessionid' => $session->id));
    $DB->delete_records_select('zingilt_session_roles', "sessionid = ?", array($session->id));
 //   $DB->delete_records_select('resource_booking', "session_id =?", array($zingilt->id));
    
    $transaction->allow_commit();
    //Delete Respective Entries in Resource Booking also from Resource Management...
    resource_booking_delete_for_class($zingilt->id, $session->id);
    return true;
}

/**
 * Substitute the placeholders in email templates for the actual data
 *
 * Expects the following parameters in the $data object:
 * - datetimeknown
 * - details
 * - discountcost
 * - duration
 * - normalcost
 * - sessiondates
 *
 * @access  public
 * @param   string  $msg            Email message
 * @param   string  $zingiltname ZILT name
 * @param   int     $reminderperiod Num business days before event to send reminder
 * @param   obj     $user           The subject of the message
 * @param   obj     $data           Session data
 * @param   int     $sessionid      Session ID
 * @return  string
 */
function zingilt_email_substitutions($msg, $zingiltname, $reminderperiod, $user, $data, $sessionid)
{
    global $CFG, $DB;

    if (empty($msg)) {
        return '';
    }

    if ($data->datetimeknown) {

        // Scheduled session.
        $sessiondate = userdate($data->sessiondates[0]->timestart, get_string('strftimedate'));
        $starttime = userdate($data->sessiondates[0]->timestart, get_string('strftimetime'));
        $finishtime = userdate($data->sessiondates[0]->timefinish, get_string('strftimetime'));

        $alldates = '';
        foreach ($data->sessiondates as $date) {
            if ($alldates != '') {
                $alldates .= "\n";
            }
            $alldates .= userdate($date->timestart, get_string('strftimedate')) . ', ';
            $alldates .= userdate($date->timestart, get_string('strftimetime')) .
                ' to ' . userdate($date->timefinish, get_string('strftimetime'));
        }
    } else {

        // Wait-listed session.
        $sessiondate = get_string('unknowndate', 'zingilt');
        $alldates    = get_string('unknowndate', 'zingilt');
        $starttime   = get_string('unknowntime', 'zingilt');
        $finishtime  = get_string('unknowntime', 'zingilt');
    }

    $msg = str_replace(get_string('placeholder:zingiltname', 'zingilt'), $zingiltname, $msg);
    $msg = str_replace(get_string('placeholder:firstname', 'zingilt'), $user->firstname, $msg);
    $msg = str_replace(get_string('placeholder:lastname', 'zingilt'), $user->lastname, $msg);
    $msg = str_replace(get_string('placeholder:cost', 'zingilt'), zingilt_cost($user->id, $sessionid, $data, false), $msg);
    $msg = str_replace(get_string('placeholder:alldates', 'zingilt'), $alldates, $msg);
    $msg = str_replace(get_string('placeholder:sessiondate', 'zingilt'), $sessiondate, $msg);
    $msg = str_replace(get_string('placeholder:starttime', 'zingilt'), $starttime, $msg);
    $msg = str_replace(get_string('placeholder:finishtime', 'zingilt'), $finishtime, $msg);
    $msg = str_replace(get_string('placeholder:duration', 'zingilt'), zilt_format_duration($data->duration), $msg);
    if (empty($data->details)) {
        $msg = str_replace(get_string('placeholder:details', 'zingilt'), '', $msg);
    } else {
        $msg = str_replace(get_string('placeholder:details', 'zingilt'), html_to_text($data->details), $msg);
    }
    $msg = str_replace(get_string('placeholder:reminderperiod', 'zingilt'), $reminderperiod, $msg);

    // Replace more meta data.
    $msg = str_replace(get_string('placeholder:attendeeslink', 'zingilt'), $CFG->wwwroot . '/mod/zingilt/attendees.php?s=' . $sessionid, $msg);

    // Custom session fields (they look like "session:shortname" in the templates).
    $customfields = zingilt_get_session_customfields();
    $customdata = $DB->get_records('zingilt_session_data', array('sessionid' => $sessionid), '', 'fieldid, data');
    foreach ($customfields as $field) {
        $placeholder = "[session:{$field->shortname}]";
        $value = '';
        if (!empty($customdata[$field->id])) {
            if (ZILT_CUSTOMFIELD_TYPE_MULTISELECT == $field->type) {
                $value = str_replace(ZILT_CUSTOMFIELD_DELIMITER, ', ', $customdata[$field->id]->data);
            } else {
                $value = $customdata[$field->id]->data;
            }
        }

        $msg = str_replace($placeholder, $value, $msg);
    }

    return $msg;
}

/**
 * Function to be run periodically according to the moodle cron
 * Finds all zingilt notifications that have yet to be mailed out, and mails them.
 */
function zingilt_cron()
{
    global $CFG, $USER, $DB;

    $signupsdata = zingilt_get_unmailed_reminders();
    if (!$signupsdata) {
        echo "\n" . get_string('noremindersneedtobesent', 'zingilt') . "\n";
        return true;
    }

    $timenow = time();
    foreach ($signupsdata as $signupdata) {
        if (zingilt_has_session_started($signupdata, $timenow)) {

            // Too late, the session already started.
            // Mark the reminder as being sent already.
            $newsubmission = new stdClass();
            $newsubmission->id = $signupdata->id;
            $newsubmission->mailedreminder = 1; // Magic number to show that it was not actually sent.
            if (!$DB->update_record('zingilt_signups', $newsubmission)) {
                echo "ERROR: could not update mailedreminder for submission ID $signupdata->id";
            }
            continue;
        }

        $earlieststarttime = $signupdata->sessiondates[0]->timestart;
        foreach ($signupdata->sessiondates as $date) {
            if ($date->timestart < $earlieststarttime) {
                $earlieststarttime = $date->timestart;
            }
        }

        $reminderperiod = $signupdata->reminderperiod;

        // Convert the period from business days (no weekends) to calendar days.
        for ($reminderday = 0; $reminderday < $reminderperiod + 1; $reminderday++) {
            $reminderdaytime = $earlieststarttime - ($reminderday * 24 * 3600);

            // Use %w instead of %u for Windows compatability.
            $reminderdaycheck = userdate($reminderdaytime, '%w');

            // Note w runs from Sun=0 to Sat=6.
            if ($reminderdaycheck == 0 || $reminderdaycheck == 6) {

                /*
                 * Saturdays and Sundays are not included in the
                 * reminder period as entered by the user, extend
                 * that period by 1
                */
                $reminderperiod++;
            }
        }

        $remindertime = $earlieststarttime - ($reminderperiod * 24 * 3600);
        if ($timenow < $remindertime) {

            // Too early to send reminder.
            continue;
        }

        if (!$user = $DB->get_record('user', array('id' => $signupdata->userid))) {
            continue;
        }

        // Hack to make sure that the timezone and languages are set properly in emails.
        // (i.e. it uses the language and timezone of the recipient of the email).
        $USER->lang = $user->lang;
        $USER->timezone = $user->timezone;
        if (!$course = $DB->get_record('course', array('id' => $signupdata->course))) {
            continue;
        }
        if (!$zingilt = $DB->get_record('zingilt', array('id' => $signupdata->zingiltid))) {
            continue;
        }

        $postsubject = '';
        $posttext = '';
        $posttextmgrheading = '';
        if (empty($signupdata->mailedreminder)) {
            $postsubject = $zingilt->remindersubject;
            $posttext = $zingilt->remindermessage;
            $posttextmgrheading = $zingilt->reminderinstrmngr;
        }

        if (empty($posttext)) {

            // The reminder message is not set, don't send anything.
            continue;
        }

        $postsubject = zingilt_email_substitutions(
            $postsubject,
            $signupdata->zingiltname,
            $signupdata->reminderperiod,
            $user,
            $signupdata,
            $signupdata->sessionid
        );
        $posttext = zingilt_email_substitutions(
            $posttext,
            $signupdata->zingiltname,
            $signupdata->reminderperiod,
            $user,
            $signupdata,
            $signupdata->sessionid
        );
        $posttextmgrheading = zingilt_email_substitutions(
            $posttextmgrheading,
            $signupdata->zingiltname,
            $signupdata->reminderperiod,
            $user,
            $signupdata,
            $signupdata->sessionid
        );

        $posthtml = ''; // FIXME.
        if ($fromaddress = get_config(null, 'zingilt_fromaddress')) {
            $from = new stdClass();
            $from->maildisplay = true;
            $from->email = $fromaddress;
        } else {
            $from = null;
        }

        if (email_to_user($user, $from, $postsubject, $posttext, $posthtml)) {
            echo "\n" . get_string('sentreminderuser', 'zingilt') . ": $user->firstname $user->lastname $user->email";

            $newsubmission = new stdClass();
            $newsubmission->id = $signupdata->id;
            $newsubmission->mailedreminder = $timenow;
            if (!$DB->update_record('zingilt_signups', $newsubmission)) {
                echo "ERROR: could not update mailedreminder for submission ID $signupdata->id";
            }

            if (empty($posttextmgrheading)) {
                continue; // No manager message set.
            }

            $managertext = $posttextmgrheading . $posttext;
            $manager = $user;
            $manager->email = zingilt_get_manageremail($user->id);

            if (empty($manager->email)) {
                continue; // Don't know who the manager is.
            }

            // Send email to mamager.
            if (email_to_user($manager, $from, $postsubject, $managertext, $posthtml)) {
                echo "\n" . get_string('sentremindermanager', 'zingilt') . ": $user->firstname $user->lastname $manager->email";
            } else {
                $errormsg = array();
                $errormsg['submissionid'] = $signupdata->id;
                $errormsg['userid'] = $user->id;
                $errormsg['manageremail'] = $manager->email;
                echo get_string('error:cronprefix', 'zingilt') . ' ' . get_string('error:cannotemailmanager', 'zingilt', $errormsg) . "\n";
            }
        } else {
            $errormsg = array();
            $errormsg['submissionid'] = $signupdata->id;
            $errormsg['userid'] = $user->id;
            $errormsg['useremail'] = $user->email;
            echo get_string('error:cronprefix', 'zingilt') . ' ' . get_string('error:cannotemailuser', 'zingilt', $errormsg) . "\n";
        }
    }

    print "\n";
    return true;
}

/**
 * Returns true if the session has started, that is if one of the
 * session dates is in the past.
 *
 * @param class $session record from the zingilt_sessions table
 * @param integer $timenow current time
 */
function zingilt_has_session_started($session, $timenow)
{

    if (!$session->datetimeknown) {
        return false; // No date set.
    }

    foreach ($session->sessiondates as $date) {
        if ($date->timestart < $timenow) {
            return true;
        }
    }

    return false;
}

/**
 * Returns true if the session has started and has not yet finished.
 *
 * @param class $session record from the zingilt_sessions table
 * @param integer $timenow current time
 */
function zingilt_is_session_in_progress($session, $timenow)
{
    if (!$session->datetimeknown) {
        return false;
    }
    foreach ($session->sessiondates as $date) {
        if ($date->timefinish > $timenow && $date->timestart < $timenow) {
            return true;
        }
    }

    return false;
}

/**
 * Get all of the dates for a given session
 */
function zingilt_get_session_dates($sessionid)
{
    global $DB;

    $ret = array();
    if ($dates = $DB->get_records('zingilt_sessions_dates', array('sessionid' => $sessionid), 'timestart')) {
        $i = 0;
        foreach ($dates as $date) {
            $ret[$i++] = $date;
        }
    }

    return $ret;
}

/**
 * Get a record from the zingilt_sessions table
 *
 * @param integer $sessionid ID of the session
 */
function zingilt_get_session($sessionid)
{
    global $DB;

    $session = $DB->get_record('zingilt_sessions', array('id' => $sessionid));
    if ($session) {
        $session->sessiondates = zingilt_get_session_dates($sessionid);
        $session->duration = zingilt_minutes_to_hours($session->duration);
    }

    return $session;
}

/**
 * Get all records from zingilt_sessions for a given zingilt activity and location
 *
 * @param integer $zingiltid ID of the activity
 * @param string $location location filter (optional)
 */
function zingilt_get_sessions($zingiltid, $location = '')
{
    global $CFG, $DB;

    $fromclause = "FROM {zingilt_sessions} s";
    $locationwhere = '';
    $locationparams = array();
    if (!empty($location)) {
        $fromclause = "FROM {zingilt_session_data} d
                       JOIN {zingilt_sessions} s ON s.id = d.sessionid";
        $locationwhere .= " AND d.data = ?";
        $locationparams[] = $location;
    }
    $sessions = $DB->get_records_sql("SELECT s.*
                                   $fromclause
                        LEFT OUTER JOIN (SELECT sessionid, min(timestart) AS mintimestart
                                           FROM {zingilt_sessions_dates} GROUP BY sessionid) m ON m.sessionid = s.id
                                  WHERE s.zingilt = ?
                                        $locationwhere
                               ORDER BY s.datetimeknown, m.mintimestart", array_merge(array($zingiltid), $locationparams));

    if ($sessions) {
        foreach ($sessions as $key => $value) {
            $sessions[$key]->duration = zingilt_minutes_to_hours($sessions[$key]->duration);
            $sessions[$key]->sessiondates = zingilt_get_session_dates($value->id);
        }
    }

    return $sessions;
}

/**
 * Get a grade for the given user from the gradebook.
 *
 * @param integer $userid       ID of the user
 * @param integer $courseid     ID of the course
 * @param integer $zingiltid ID of the zing ILT activity
 *
 * @returns object String grade and the time that it was graded
 */
function zingilt_get_grade($userid, $courseid, $zingiltid)
{

    $ret = new stdClass();
    $ret->grade = 0;
    $ret->dategraded = 0;

    $gradinginfo = grade_get_grades($courseid, 'mod', 'zingilt', $zingiltid, $userid);
    if (!empty($gradinginfo->items)) {
        $ret->grade = $gradinginfo->items[0]->grades[$userid]->str_grade;
        $ret->dategraded = $gradinginfo->items[0]->grades[$userid]->dategraded;
    }

    return $ret;
}

/**
 * Get list of users attending a given session
 *
 * @access public
 * @param integer Session ID
 * @return array
 */
function zingilt_get_attendees($sessionid)
{
    global $CFG, $DB;

    $usernamefields = get_all_user_name_fields(true, 'u');
    $records = $DB->get_records_sql("
        SELECT u.id, {$usernamefields},
            u.email,
            su.id AS submissionid,
            s.discountcost,
            su.discountcode,
            su.notificationtype,
            f.id AS zingiltid,
            f.course,
            ss.grade,
            ss.statuscode,
            sign.timecreated
        FROM
            {zingilt} f
        JOIN
            {zingilt_sessions} s
         ON s.zingilt = f.id
        JOIN
            {zingilt_signups} su
         ON s.id = su.sessionid
        JOIN
            {zingilt_signups_status} ss
         ON su.id = ss.signupid
        LEFT JOIN
            (
            SELECT
                ss.signupid,
                MAX(ss.timecreated) AS timecreated
            FROM
                {zingilt_signups_status} ss
            INNER JOIN
                {zingilt_signups} s
             ON s.id = ss.signupid
            AND s.sessionid = ?
            WHERE
                ss.statuscode IN (?,?)
            GROUP BY
                ss.signupid
            ) sign
         ON su.id = sign.signupid
        JOIN
            {user} u
         ON u.id = su.userid
        WHERE
            s.id = ?
        AND ss.superceded != 1
        AND ss.statuscode >= ?
        ORDER BY
            sign.timecreated ASC,
            ss.timecreated ASC
    ", array($sessionid, MDL_ZILT_STATUS_BOOKED, MDL_ZILT_STATUS_WAITLISTED, $sessionid, MDL_ZILT_STATUS_APPROVED));

    return $records;
}

/**
 * Get a single attendee of a session
 *
 * @access public
 * @param integer Session ID
 * @param integer User ID
 * @return false|object
 */
function zingilt_get_attendee($sessionid, $userid)
{
    global $CFG, $DB;

    $record = $DB->get_record_sql("
        SELECT
            u.id,
            su.id AS submissionid,
            u.firstname,
            u.lastname,
            u.email,
            s.discountcost,
            su.discountcode,
            su.notificationtype,
            f.id AS zingiltid,
            f.course,
            ss.grade,
            ss.statuscode
        FROM
            {zingilt} f
        JOIN
            {zingilt_sessions} s
         ON s.zingilt = f.id
        JOIN
            {zingilt_signups} su
         ON s.id = su.sessionid
        JOIN
            {zingilt_signups_status} ss
         ON su.id = ss.signupid
        JOIN
            {user} u
         ON u.id = su.userid
        WHERE
            s.id = ?
        AND ss.superceded != 1
        AND u.id = ?
    ", array($sessionid, $userid));

    if (!$record) {
        return false;
    }

    return $record;
}

/**
 * Return all user fields to include in exports
 */
function zingilt_get_userfields()
{
    global $CFG;

    static $userfields = null;
    if (null == $userfields) {
        $userfields = array();

        if (function_exists('grade_export_user_fields')) {
            $fieldnames = grade_export_user_fields();
            foreach ($fieldnames as $key => $obj) {
                $userfields[$obj->shortname] = $obj->fullname;
            }
        } else {
            // Set default fields if the grade export patch is not detected (see MDL-17346).
            $fieldnames = array(
                'firstname', 'lastname', 'email', 'city',
                'idnumber', 'institution', 'department', 'address'
            );
            foreach ($fieldnames as $shortname) {
                $userfields[$shortname] = get_string($shortname);
            }
            $userfields['managersemail'] = get_string('manageremail', 'zingilt');
        }
    }

    return $userfields;
}

/**
 * Download the list of users attending at least one of the sessions
 * for a given zingilt activity
 */
function zingilt_download_attendance($zingiltname, $zingiltid, $location, $format)
{
    global $CFG;

    $timenow = time();
    $timeformat = str_replace(' ', '_', get_string('strftimedate', 'langconfig'));
    $downloadfilename = clean_filename($zingiltname . '_' . userdate($timenow, $timeformat));

    $dateformat = 0;
    if ('ods' === $format) {

        // OpenDocument format (ISO/IEC 26300).
        require_once($CFG->dirroot . '/lib/odslib.class.php');
        $downloadfilename .= '.ods';
        $workbook = new MoodleODSWorkbook('-');
    } else {

        // Excel format.
        require_once($CFG->dirroot . '/lib/excellib.class.php');
        $downloadfilename .= '.xls';
        $workbook = new MoodleExcelWorkbook('-');
        $dateformat = $workbook->add_format();
        $dateformat->set_num_format('d mmm yy'); // TODO: use format specified in language pack.
    }

    $workbook->send($downloadfilename);
    $worksheet = $workbook->add_worksheet('attendance');
    zingilt_write_worksheet_header($worksheet);
    zingilt_write_activity_attendance($worksheet, 1, $zingiltid, $location, '', '', $dateformat);
    $workbook->close();
    exit;
}

/**
 * Add the appropriate column headers to the given worksheet
 *
 * @param object $worksheet  The worksheet to modify (passed by reference)
 * @returns integer The index of the next column
 */
function zingilt_write_worksheet_header(&$worksheet)
{
    $pos = 0;
    $customfields = zingilt_get_session_customfields();
    foreach ($customfields as $field) {
        if (!empty($field->showinsummary)) {
            $worksheet->write_string(0, $pos++, $field->name);
        }
    }
    $worksheet->write_string(0, $pos++, get_string('session_name', 'zingilt'));
    $worksheet->write_string(0, $pos++, get_string('date', 'zingilt'));
    $worksheet->write_string(0, $pos++, get_string('timestart', 'zingilt'));
    $worksheet->write_string(0, $pos++, get_string('timefinish', 'zingilt'));
    $worksheet->write_string(0, $pos++, get_string('duration', 'zingilt'));
    $worksheet->write_string(0, $pos++, get_string('status', 'zingilt'));

    if ($trainerroles = zingilt_get_trainer_roles()) {
        foreach ($trainerroles as $role) {
            $worksheet->write_string(0, $pos++, get_string('role') . ': ' . $role->name);
        }
    }

    $userfields = zingilt_get_userfields();
    foreach ($userfields as $shortname => $fullname) {
        $worksheet->write_string(0, $pos++, $fullname);
    }

    $worksheet->write_string(0, $pos++, get_string('attendance', 'zingilt'));
    $worksheet->write_string(0, $pos++, get_string('attendancestatus', 'zingilt'));//Added by Kajal for Attendance Status
    $worksheet->write_string(0, $pos++, get_string('datesignedup', 'zingilt'));

    return $pos;
}

/**
 * Write in the worksheet the given zingilt attendance information
 * filtered by location.
 *
 * This function includes lots of custom SQL because it's otherwise
 * way too slow.
 *
 * @param object  $worksheet    Currently open worksheet
 * @param integer $startingrow  Index of the starting row (usually 1)
 * @param integer $zingiltid ID of the zingilt activity
 * @param string  $location     Location to filter by
 * @param string  $coursename   Name of the course (optional)
 * @param string  $activityname Name of the zingilt activity (optional)
 * @param object  $dateformat   Use to write out dates in the spreadsheet
 * @returns integer Index of the last row written
 */
function zingilt_write_activity_attendance(
    &$worksheet,
    $startingrow,
    $zingiltid,
    $location,
    $coursename,
    $activityname,
    $dateformat
) {
    global $CFG, $DB;

    $trainerroles = zingilt_get_trainer_roles();
    $userfields = zingilt_get_userfields();
    $customsessionfields = zingilt_get_session_customfields();
    $timenow = time();
    $i = $startingrow;

    $locationcondition = '';
    $locationparam = array();
    if (!empty($location)) {
        $locationcondition = "AND s.location = ?";
        $locationparam = array($location);
    }

    // Fast version of "zingilt_get_attendees()" for all sessions.
    $sessionsignups = array();
    $signups = $DB->get_records_sql("
        SELECT
            su.id AS submissionid,
            s.id AS sessionid,
            u.*,
            f.course AS courseid,
            ss.grade,
            sign.timecreated
        FROM
            {zingilt} f
        JOIN
            {zingilt_sessions} s
         ON s.zingilt = f.id
        JOIN
            {zingilt_signups} su
         ON s.id = su.sessionid
        JOIN
            {zingilt_signups_status} ss
         ON su.id = ss.signupid
        LEFT JOIN
            (
            SELECT
                ss.signupid,
                MAX(ss.timecreated) AS timecreated
            FROM
                {zingilt_signups_status} ss
            INNER JOIN
                {zingilt_signups} s
             ON s.id = ss.signupid
            INNER JOIN
                {zingilt_sessions} se
             ON s.sessionid = se.id
            AND se.zingilt = $zingiltid
            WHERE
                ss.statuscode IN (?,?)
            GROUP BY
                ss.signupid
            ) sign
         ON su.id = sign.signupid
        JOIN
            {user} u
         ON u.id = su.userid
        WHERE
            f.id = ?
        AND ss.superceded != 1
        AND ss.statuscode >= ?
        ORDER BY
            s.id, u.firstname, u.lastname
    ", array(MDL_ZILT_STATUS_BOOKED, MDL_ZILT_STATUS_WAITLISTED, $zingiltid, MDL_ZILT_STATUS_APPROVED));

    if ($signups) {

        // Get all grades at once.
        $userids = array();
        foreach ($signups as $signup) {
            if ($signup->id > 0) {
                $userids[] = $signup->id;
            }
        }
        $gradinginfo = grade_get_grades(
            reset($signups)->courseid,
            'mod',
            'zingilt',
            $zingiltid,
            $userids
        );

        foreach ($signups as $signup) {
            $userid = $signup->id;
            if ($customuserfields = zingilt_get_user_customfields($userid, $userfields)) {
                foreach ($customuserfields as $fieldname => $value) {
                    if (!isset($signup->$fieldname)) {
                        $signup->$fieldname = $value;
                    }
                }
            }

            // Set grade.
            if (!empty($gradinginfo->items) and !empty($gradinginfo->items[0]->grades[$userid])) {
                $signup->grade = $gradinginfo->items[0]->grades[$userid]->str_grade;
            }

            $sessionsignups[$signup->sessionid][$signup->id] = $signup;
        }
    }

    // Fast version of "zingilt_get_sessions($zingiltid, $location)".//added session name by Kajal tailor
    $sql = "SELECT d.id as dateid, s.id, s.name, s.datetimeknown, s.capacity,
                   s.duration, d.timestart, d.timefinish
              FROM {zingilt_sessions} s
              JOIN {zingilt_sessions_dates} d ON s.id = d.sessionid
              WHERE
                s.zingilt = ?
              AND d.sessionid = s.id
                   $locationcondition
                   ORDER BY s.datetimeknown, d.timestart";

    $sessions = $DB->get_records_sql($sql, array_merge(array($zingiltid), $locationparam));

    $i = $i - 1; // Will be incremented BEFORE each row is written.
    foreach ($sessions as $session) {
        $status      = get_string('wait-listed', 'zingilt');

        $sessiontrainers = zingilt_get_trainers($session->id);

        if ($session->datetimeknown) {
            if ($session->timestart < $timenow) {
                $status = get_string('sessionover', 'zingilt');
            } else {
                $signupcount = 0;
                if (!empty($sessionsignups[$session->id])) {
                    $signupcount = count($sessionsignups[$session->id]);
                }

                if ($signupcount >= $session->capacity) {
                    $status = get_string('bookingfull', 'zingilt');
                } else {
                    $status = get_string('bookingopen', 'zingilt');
                }
            }
        }

        if (!empty($sessionsignups[$session->id])) {
            foreach ($sessionsignups[$session->id] as $attendee) {
                $i++;
                $j = zingilt_write_activity_attendance_helper($worksheet, $i, $session, $customsessionfields, $status, $dateformat);
                if ($trainerroles) {
                    foreach (array_keys($trainerroles) as $roleid) {
                        if (!empty($sessiontrainers[$roleid])) {
                            $trainers = array();
                            foreach ($sessiontrainers[$roleid] as $trainer) {
                                $trainers[] = fullname($trainer);
                            }

                            $trainers = implode(', ', $trainers);
                        } else {
                            $trainers = '-';
                        }

                        $worksheet->write_string($i, $j++, $trainers);
                    }
                }

                foreach ($userfields as $shortname => $fullname) {
                    $value = '-';
                    if (!empty($attendee->$shortname)) {
                        $value = $attendee->$shortname;
                    }

                    if (
                        'firstaccess' == $shortname || 'lastaccess' == $shortname ||
                        'lastlogin' == $shortname || 'currentlogin' == $shortname
                    ) {
                        $worksheet->write_date($i, $j++, (int)$value, $dateformat);
                    } else {
                        $worksheet->write_string($i, $j++, $value);
                    }
                }
                $worksheet->write_string($i, $j++, $attendee->grade);

                //Added by Kajal for Attendance Status
                 if($status == get_string('sessionover', 'zingilt')){


                    if($attendee->grade == '-' || $attendee->grade == null ){
                           $gradestatus = ' - ';
                    }
                    else if($attendee->grade!="" && $attendee->grade < 1){
                        $gradestatus = "Absent";
                    }
                    else{
                        if($attendee->grade >=50){
                            $gradestatus = "Present";
                        }
                        else{
                            $gradestatus = "Absent";
                        }
                    }
                }
                else{
                    $gradestatus ='-';
                }
                 ////////////////////////////////////////
                $worksheet->write_string($i, $j++, $gradestatus);

                $worksheet->write_date($i, $j++, (int)$attendee->timecreated, $dateformat);

                if (!empty($coursename)) {
                    $worksheet->write_string($i, $j++, $coursename);
                }
                if (!empty($activityname)) {
                    $worksheet->write_string($i, $j++, $activityname);
                }
            }
        } else {
            // No one is sign-up, so let's just print the basic info.
            $i++;
            // helper
            $j = zingilt_write_activity_attendance_helper($worksheet, $i, $session, $customsessionfields, $status, $dateformat);

            foreach ($userfields as $unused) {
                $worksheet->write_string($i, $j++, '-');
            }
            $worksheet->write_string($i, $j++, '-');

            if (!empty($coursename)) {
                $worksheet->write_string($i, $j++, $coursename);
            }
            if (!empty($activityname)) {
                $worksheet->write_string($i, $j++, $activityname);
            }
        }
    }

    return $i;
}

/**
 * Helper function for write_activity_attendance.
 * Could do with further tidying.
 *
 * @param object $worksheet  The worksheet to modify (passed by reference)
 * @param int $i The current row being used.
 * @param object $session
 * @return int The next Column in the sheet.
 */

function zingilt_write_activity_attendance_helper(&$worksheet, $i, $session, $customsessionfields, $status, $dateformat)
{
    global $DB;

    $customdata = $DB->get_records('zingilt_session_data', array('sessionid' => $session->id), '', 'fieldid, data');
    $j = 0;

    $starttime   = get_string('wait-listed', 'zingilt');
    $finishtime  = get_string('wait-listed', 'zingilt');

    if ($session->datetimeknown) {
        $sessiondate = (int)$session->timestart;
        $starttime   = userdate($session->timestart, get_string('strftimetime', 'langconfig'));
        $finishtime  = userdate($session->timefinish, get_string('strftimetime', 'langconfig'));
    }

    foreach ($customsessionfields as $field) {
        if (empty($field->showinsummary)) {
            continue; // Skip.
        }

        $data = '-';
        if (!empty($customdata[$field->id])) {
            if (ZILT_CUSTOMFIELD_TYPE_MULTISELECT == $field->type) {
                $data = str_replace(ZILT_CUSTOMFIELD_DELIMITER, "\n", $customdata[$field->id]->data);
            } else {
                $data = $customdata[$field->id]->data;
            }
        }
        $worksheet->write_string($i, $j++, $data);
    }
    //added By Kajal C Tailor for Session Name
    if($session->name != "")
        $worksheet->write_string($i, $j++, $session->name);
    else
        $worksheet->write_string($i, $j++, '-');
    //////session name end here///
    if (empty($sessiondate)) {
        $worksheet->write_string($i, $j++, $status); // Session date.
    } else {
        $worksheet->write_date($i, $j++, $sessiondate, $dateformat);
    }
    $worksheet->write_string($i, $j++, $starttime);
    $worksheet->write_string($i, $j++, $finishtime);
    $worksheet->write_number($i, $j++, (int)$session->duration);
    $worksheet->write_string($i, $j++, $status);

    return $j;
}

/**
 * Return an object with all values for a user's custom fields.
 *
 * This is about 15 times faster than the custom field API.
 *
 * @param array $fieldstoinclude Limit the fields returned/cached to these ones (optional)
 */
function zingilt_get_user_customfields($userid, $fieldstoinclude = false)
{
    global $CFG, $DB;

    // Cache all lookup.
    static $customfields = null;
    if (null == $customfields) {
        $customfields = array();
    }

    if (!empty($customfields[$userid])) {
        return $customfields[$userid];
    }

    $ret = new stdClass();
    $sql = "SELECT uif.shortname, id.data
              FROM {user_info_field} uif
              JOIN {user_info_data} id ON id.fieldid = uif.id
              WHERE id.userid = ?";

    $customfields = $DB->get_records_sql($sql, array($userid));
    foreach ($customfields as $field) {
        $fieldname = $field->shortname;
        if (false === $fieldstoinclude or !empty($fieldstoinclude[$fieldname])) {
            $ret->$fieldname = $field->data;
        }
    }

    $customfields[$userid] = $ret;
    return $ret;
}

/**
 * Return list of marked submissions that have not been mailed out for currently enrolled students
 */
function zingilt_get_unmailed_reminders()
{
    global $CFG, $DB;

    $submissions = $DB->get_records_sql("
        SELECT
            su.*,
            f.course,
            f.id as zingiltid,
            f.name as zingiltname,
            f.reminderperiod,
            se.duration,
            se.normalcost,
            se.discountcost,
            se.details,
            se.datetimeknown
        FROM
            {zingilt_signups} su
        INNER JOIN
            {zingilt_signups_status} sus
         ON su.id = sus.signupid
        AND sus.superceded = 0
        AND sus.statuscode = ?
        JOIN
            {zingilt_sessions} se
         ON su.sessionid = se.id
        JOIN
            {zingilt} f
         ON se.zingilt = f.id
        WHERE
            su.mailedreminder = 0
        AND se.datetimeknown = 1
    ", array(MDL_ZILT_STATUS_BOOKED));

    if ($submissions) {
        foreach ($submissions as $key => $value) {
            $submissions[$key]->duration = zingilt_minutes_to_hours($submissions[$key]->duration);
            $submissions[$key]->sessiondates = zingilt_get_session_dates($value->sessionid);
        }
    }

    return $submissions;
}

/* made by suniti # for for avoiding approval flow for line manager. */
function zingilt_user_signup_new($session, $zingilt, $course, $discountcode,$notificationtype, $statuscode, $userid = false,$notifyuser = true, $loginuser) 
{
        global $CFG, $DB;

        // Get user ID.
        if (!$userid) {
            global $USER;
            $userid = $USER->id;
        }

        $return = false;
        $timenow = time();

        // Check to see if a signup already exists.
        if ($existingsignup = $DB->get_record('zingilt_signups', array('sessionid' => $session->id, 'userid' => $userid))) {
            $usersignup = $existingsignup;
        } else {

            // Otherwise, prepare a signup object.
            $usersignup = new stdclass;
            $usersignup->sessionid = $session->id;
            $usersignup->userid = $userid;
        }

        $usersignup->mailedreminder = 0;
        $usersignup->notificationtype = $notificationtype;

        $usersignup->discountcode = trim(strtoupper($discountcode));
        if (empty($usersignup->discountcode)) {
            $usersignup->discountcode = null;
        }

        // Update/insert the signup record.
        if (!empty($usersignup->id)) {
            $success = $DB->update_record('zingilt_signups', $usersignup);
        } else {
            $usersignup->id = $DB->insert_record('zingilt_signups', $usersignup);
            $success = (bool)$usersignup->id;
        }

        if (!$success) {
            print_error('error:couldnotupdatef2frecord', 'zingilt');
            return false;
        }

        // Work out which status to use.

        // If approval not required.
        if (!$zingilt->approvalreqd) {
            $newstatus = $statuscode;
        } else {

            //if user's line manager enrols user then user directly gets enrol.
            if(!empty($loginuser))
            {
                $status_array = [];
                $query_signup_status = "SELECT * FROM `mdl_zingilt_signups_status` WHERE signupid = ? AND superceded = ? ORDER BY `id` DESC";

                $getcurrentstatus = $DB->get_record_sql($query_signup_status, array('signupid' => $usersignup->id, 'superceded' => 0), $strictness=IGNORE_MISSING);

                if($getcurrentstatus->statuscode == 30)
                {
                    $status_array = ['40' => '1','50' => '0'];
                }
                else if($getcurrentstatus->statuscode == 40)
                {
                    $status_array = ['50' => '0'];
                }
                else if($getcurrentstatus->statuscode == 50)
                {
                    $status_array = [];
                }
                else
                {
                    $status_array = ['30' => '1', '40' => '1','50' => '0'];
                }

                 //manager details
                $sql = "select u.* from mdl_user as u where employee_code in(select mu.reporting_manager_code from mdl_user as mu where mu.id = ?)";

                $user_details = $DB->get_record_sql($sql, array('id' => $userid), $strictness=IGNORE_MISSING);

                if($user_details->id == $loginuser->id && count($status_array) > 0)
                {
                    if(!empty($getcurrentstatus))
                    {
                        $record = new stdclass;
                        $record->id         = $getcurrentstatus->id;
                        $record->superceded = 1;
                        $DB->update_record('zingilt_signups_status', $record);
                    }

                    foreach ($status_array as $key => $value) {

                        $frec_insert = new stdClass();
                        $frec_insert->signupid       = $usersignup->id;
                        $frec_insert->statuscode     = $key;
                        $frec_insert->superceded     = $value;
                        //grade, note, advice
                        $frec_insert->createdby      = $loginuser->id;
                        $frec_insert->timecreated    = time();

                        $DB->insert_record('zingilt_signups_status', $frec_insert);
                    }
                   
                }

            }


            // If approval required.
            // Get current status (if any).
            $currentstatus = $DB->get_field('zingilt_signups_status', 'statuscode', array('signupid' => $usersignup->id, 'superceded' => 0));

            // If approved, then no problem.
            if ($currentstatus == MDL_ZILT_STATUS_APPROVED) {
                $newstatus = $statuscode;
            } else if ($session->datetimeknown) {

                // Otherwise, send manager request.
                $newstatus = MDL_ZILT_STATUS_REQUESTED;
            } else {
                $newstatus = MDL_ZILT_STATUS_WAITLISTED;
            }
        }

        // Update status.
        if (!zingilt_update_signup_status($usersignup->id, $newstatus, $userid)) {
            print_error('error:f2ffailedupdatestatus', 'zingilt');
            return false;
        }

        // Add to user calendar -- if zingilt usercalentry is set to true.
        if ($zingilt->usercalentry) {
            if (in_array($newstatus, array(MDL_ZILT_STATUS_BOOKED, MDL_ZILT_STATUS_WAITLISTED))) {
                zingilt_add_session_to_calendar($session, $zingilt, 'user', $userid, 'booking');
            }
        }

        // Course completion.
        if (in_array($newstatus, array(MDL_ZILT_STATUS_BOOKED, MDL_ZILT_STATUS_WAITLISTED))) {
            $completion = new completion_info($course);
            if ($completion->is_enabled()) {
                $ccdetails = array(
                    'course' => $course->id,
                    'userid' => $userid,
                );

                $cc = new completion_completion($ccdetails);
                $cc->mark_inprogress($timenow);
            }
        }

        // If session has already started, do not send a notification.
        if (zingilt_has_session_started($session, $timenow)) {
            $notifyuser = false;
        }

        // Send notification.
        if ($notifyuser) {

            // If booked/waitlisted.

            switch ($newstatus) {
                case MDL_ZILT_STATUS_BOOKED:
                    $error = zingilt_send_confirmation_notice($zingilt, $session, $userid, $notificationtype, false);
                    break;

                case MDL_ZILT_STATUS_WAITLISTED:
                    $error = zingilt_send_confirmation_notice($zingilt, $session, $userid, $notificationtype, true);
                    break;

                case MDL_ZILT_STATUS_REQUESTED:
                    $error = zingilt_send_request_notice($zingilt, $session, $userid);
                    break;
            }

            if (!empty($error)) {
                print_error($error, 'zingilt');
                return false;
            }

            if (!$DB->update_record('zingilt_signups', $usersignup)) {
                print_error('error:couldnotupdatef2frecord', 'zingilt');
                return false;
            }
        }

        return true;
}

/**
 * Add a record to the zingilt submissions table and sends out an
 * email confirmation
 *
 * @param class $session record from the zingilt_sessions table
 * @param class $zingilt record from the zingilt table
 * @param class $course record from the course table
 * @param string $discountcode code entered by the user
 * @param integer $notificationtype type of notifications to send to user
 * @see {{MDL_ZILT_INVITE}}
 * @param integer $statuscode Status code to set
 * @param integer $userid user to signup
 * @param bool $notifyuser whether or not to send an email confirmation
 * @param bool $displayerrors whether or not to return an error page on errors
 */
function zingilt_user_signup(
    $session,
    $zingilt,
    $course,
    $discountcode,
    $notificationtype,
    $statuscode,
    $userid = false,
    $notifyuser = true
) {

    global $CFG, $DB;

    // Get user ID.
    if (!$userid) {
        global $USER;
        $userid = $USER->id;
    }

    $return = false;
    $timenow = time();

    // Check to see if a signup already exists.
    if ($existingsignup = $DB->get_record('zingilt_signups', array('sessionid' => $session->id, 'userid' => $userid))) {
        $usersignup = $existingsignup;
    } else {

        // Otherwise, prepare a signup object.
        $usersignup = new stdclass;
        $usersignup->sessionid = $session->id;
        $usersignup->userid = $userid;
    }

    $usersignup->mailedreminder = 0;
    $usersignup->notificationtype = $notificationtype;

    $usersignup->discountcode = trim(strtoupper($discountcode));
    if (empty($usersignup->discountcode)) {
        $usersignup->discountcode = null;
    }

    // Update/insert the signup record.
    if (!empty($usersignup->id)) {
        $success = $DB->update_record('zingilt_signups', $usersignup);
    } else {
        $usersignup->id = $DB->insert_record('zingilt_signups', $usersignup);
        $success = (bool)$usersignup->id;
    }

    if (!$success) {
        print_error('error:couldnotupdateZILTrecord', 'zingilt');
        return false;
    }

    // Work out which status to use.

    // If approval not required.
    if (!$zingilt->approvalreqd) {
        $newstatus = $statuscode;
    } else {

        // If approval required.
        // Get current status (if any).
        $currentstatus = $DB->get_field('zingilt_signups_status', 'statuscode', array('signupid' => $usersignup->id, 'superceded' => 0));

        // If approved, then no problem.
        if ($currentstatus == MDL_ZILT_STATUS_APPROVED) {
            $newstatus = $statuscode;
        } else if ($session->datetimeknown) {

            // Otherwise, send manager request.
            $newstatus = MDL_ZILT_STATUS_REQUESTED;
        } else {
            $newstatus = MDL_ZILT_STATUS_WAITLISTED;
        }
    }

    // Update status.
    if (!zingilt_update_signup_status($usersignup->id, $newstatus, $userid)) {
        print_error('error:ZILTfailedupdatestatus', 'zingilt');
        return false;
    }

    // Add to user calendar -- if zingilt usercalentry is set to true.
    if ($zingilt->usercalentry) {
        if (in_array($newstatus, array(MDL_ZILT_STATUS_BOOKED, MDL_ZILT_STATUS_WAITLISTED))) {
            zingilt_add_session_to_calendar($session, $zingilt, 'user', $userid, 'booking');
        }
    }

    // Course completion.
    if (in_array($newstatus, array(MDL_ZILT_STATUS_BOOKED, MDL_ZILT_STATUS_WAITLISTED))) {
        $completion = new completion_info($course);
        if ($completion->is_enabled()) {
            $ccdetails = array(
                'course' => $course->id,
                'userid' => $userid,
            );

            $cc = new completion_completion($ccdetails);
            $cc->mark_inprogress($timenow);
        }
    }

    // If session has already started, do not send a notification.
    if (zingilt_has_session_started($session, $timenow)) {
        $notifyuser = false;
    }

    // Send notification.
    if ($notifyuser) {

        // If booked/waitlisted.
        switch ($newstatus) {
            case MDL_ZILT_STATUS_BOOKED:
                $error = zingilt_send_confirmation_notice($zingilt, $session, $userid, $notificationtype, false);
                break;

            case MDL_ZILT_STATUS_WAITLISTED:
                $error = zingilt_send_confirmation_notice($zingilt, $session, $userid, $notificationtype, true);
                break;

            case MDL_ZILT_STATUS_REQUESTED:
                $error = zingilt_send_request_notice($zingilt, $session, $userid);
                break;
        }

        if (!empty($error)) {
            print_error($error, 'zingilt');
            return false;
        }

        if (!$DB->update_record('zingilt_signups', $usersignup)) {
            print_error('error:couldnotupdateZILTrecord', 'zingilt');
            return false;
        }
    }

    return true;
}

/**
 * Send booking request notice to user and their manager
 *
 * @param  object $zingilt zingilt instance
 * @param  object $session    Session instance
 * @param  int    $userid     ID of user requesting booking
 * @return string Error string, empty on success
 */
function zingilt_send_request_notice($zingilt, $session, $userid)
{
    global $DB;

    if (!$manageremail = zingilt_get_manageremail($userid)) {
        return 'error:nomanagersemailset';
    }

    $user = $DB->get_record('user', array('id' => $userid));
    if (!$user) {
        return 'error:invaliduserid';
    }

    if ($fromaddress = get_config(null, 'zingilt_fromaddress')) {
        $from = new stdClass();
        $from->maildisplay = true;
        $from->email = $fromaddress;
    } else {
        $from = null;
    }

    $postsubject = zingilt_email_substitutions(
        $zingilt->requestsubject,
        $zingilt->name,
        $zingilt->reminderperiod,
        $user,
        $session,
        $session->id
    );

    $posttext = zingilt_email_substitutions(
        $zingilt->requestmessage,
        $zingilt->name,
        $zingilt->reminderperiod,
        $user,
        $session,
        $session->id
    );

    $posttextmgrheading = zingilt_email_substitutions(
        $zingilt->requestinstrmngr,
        $zingilt->name,
        $zingilt->reminderperiod,
        $user,
        $session,
        $session->id
    );

    // Send to user.
    if (!email_to_user($user, $from, $postsubject, $posttext)) {
        return 'error:cannotsendrequestuser';
    }

    // Send to manager.
    $user->email = $manageremail;

    if (!email_to_user($user, $from, $postsubject, $posttextmgrheading . $posttext)) {
        return 'error:cannotsendrequestmanager';
    }

    return '';
}


/**
 * Update the signup status of a particular signup
 *
 * @param integer $signupid ID of the signup to be updated
 * @param integer $statuscode Status code to be updated to
 * @param integer $createdby User ID of the user causing the status update
 * @param string $note Cancellation reason or other notes
 * @param int $grade Grade
 * @param bool $usetransaction Set to true if database transactions are to be used
 *
 * @returns integer ID of newly created signup status, or false
 *
 */
function zingilt_update_signup_status($signupid, $statuscode, $createdby, $note = '', $grade = null)
{
    global $DB;
    $timenow = time();

    $signupstatus = new stdclass;
    $signupstatus->signupid = $signupid;
    $signupstatus->statuscode = $statuscode;
    $signupstatus->createdby = $createdby;
    $signupstatus->timecreated = $timenow;
    $signupstatus->note = $note;
    $signupstatus->grade = $grade;
    $signupstatus->superceded = 0;
    $signupstatus->mailed = 0;

    $transaction = $DB->start_delegated_transaction();

    if ($statusid = $DB->insert_record('zingilt_signups_status', $signupstatus)) {

        // Mark any previous signup_statuses as superceded.
        $where = "signupid = ? AND ( superceded = 0 OR superceded IS NULL ) AND id != ?";
        $whereparams = array($signupid, $statusid);
        $DB->set_field_select('zingilt_signups_status', 'superceded', 1, $where, $whereparams);
        $transaction->allow_commit();

        return $statusid;
    } else {
        return false;
    }
}

/**
 * Cancel a user who signed up earlier
 *
 * @param class $session       Record from the zingilt_sessions table
 * @param integer $userid      ID of the user to remove from the session
 * @param bool $forcecancel    Forces cancellation of sessions that have already occurred
 * @param string $errorstr     Passed by reference. For setting error string in calling function
 * @param string $cancelreason Optional justification for cancelling the signup
 */
function zingilt_user_cancel($session, $userid = false, $forcecancel = false, &$errorstr = null, $cancelreason = '')
{
    global $USER;

    if (!$userid) {
        $userid = $USER->id;
    }

    // If $forcecancel is set, cancel session even if already occurred used by zingilt_facetotoface_delete_session().
    if (!$forcecancel) {
        $timenow = time();

        // Don't allow user to cancel a session that has already occurred.
        if (zingilt_has_session_started($session, $timenow)) {
            $errorstr = get_string('error:eventoccurred', 'zingilt');
            return false;
        }
    }

    if (zingilt_user_cancel_submission($session->id, $userid, $cancelreason)) {
        // Remove entry from user's calendar.
        zingilt_remove_session_from_calendar($session, 0, $userid);
        zingilt_update_attendees($session);
        return true;
    }

    // Todo: is this necessary?
    $errorstr = get_string('error:cancelbooking', 'zingilt');

    return false;
}

/**
 * Common code for sending confirmation and cancellation notices
 *
 * @param string $postsubject Subject of the email
 * @param string $posttext Plain text contents of the email
 * @param string $posttextmgrheading Header to prepend to $posttext in manager email
 * @param string $notificationtype The type of notification to send
 * @see {{MDL_ZILT_INVITE}}
 * @param class $zingilt record from the zingilt table
 * @param class $session record from the zingilt_sessions table
 * @param integer $userid ID of the recipient of the email
 * @returns string Error message (or empty string if successful)
 */
function zingilt_send_notice(
    $postsubject,
    $posttext,
    $posttextmgrheading,
    $notificationtype,
    $zingilt,
    $session,
    $userid
) {
    global $CFG, $DB;

    $user = $DB->get_record('user', array('id' => $userid));
    if (!$user) {
        return 'error:invaliduserid';
    }

    if (empty($postsubject) || empty($posttext)) {
        return '';
    }

    // If no notice type is defined (TEXT or ICAL).
    if (!($notificationtype & MDL_ZILT_BOTH)) {

        // If none, make sure they at least get a text email.
        $notificationtype |= MDL_ZILT_TEXT;
    }

    // If we are cancelling, check if ical cancellations are disabled.
    if (($notificationtype & MDL_ZILT_CANCEL) &&
        get_config(null, 'zingilt_disableicalcancel')
    ) {
        $notificationtype |= MDL_ZILT_TEXT; // Add a text notification.
        $notificationtype &= ~MDL_ZILT_ICAL; // Remove the iCalendar notification.
    }

    // If we are sending an ical attachment, set file name.
    if ($notificationtype & MDL_ZILT_ICAL) {
        if ($notificationtype & MDL_ZILT_INVITE) {
            $attachmentfilename = 'invite.ics';
        } else if ($notificationtype & MDL_ZILT_CANCEL) {
            $attachmentfilename = 'cancel.ics';
        }
    }

    // Do iCal attachement stuff.
    $icalattachments = array();
    if ($notificationtype & MDL_ZILT_ICAL) {
        if (get_config(null, 'zingilt_oneemailperday')) {

            // Keep track of all sessiondates.
            $sessiondates = $session->sessiondates;

            foreach ($sessiondates as $sessiondate) {
                $session->sessiondates = array($sessiondate); // One day at a time.

                $filename = zingilt_get_ical_attachment($notificationtype, $zingilt, $session, $user);
                $subject = zingilt_email_substitutions(
                    $postsubject,
                    $zingilt->name,
                    $zingilt->reminderperiod,
                    $user,
                    $session,
                    $session->id
                );
                $body = zingilt_email_substitutions(
                    $posttext,
                    $zingilt->name,
                    $zingilt->reminderperiod,
                    $user,
                    $session,
                    $session->id
                );
                $htmlbody = ''; // TODO.
                $icalattachments[] = array(
                    'filename' => $filename, 'subject' => $subject,
                    'body' => $body, 'htmlbody' => $htmlbody
                );
            }

            // Restore session dates.
            $session->sessiondates = $sessiondates;
        } else {
            $filename = zingilt_get_ical_attachment($notificationtype, $zingilt, $session, $user);
            $subject = zingilt_email_substitutions(
                $postsubject,
                $zingilt->name,
                $zingilt->reminderperiod,
                $user,
                $session,
                $session->id
            );
            $body = zingilt_email_substitutions(
                $posttext,
                $zingilt->name,
                $zingilt->reminderperiod,
                $user,
                $session,
                $session->id
            );
            $htmlbody = ''; // FIXME.
            $icalattachments[] = array(
                'filename' => $filename, 'subject' => $subject,
                'body' => $body, 'htmlbody' => $htmlbody
            );
        }
    }

    // Fill-in the email placeholders.
    $postsubject = zingilt_email_substitutions(
        $postsubject,
        $zingilt->name,
        $zingilt->reminderperiod,
        $user,
        $session,
        $session->id
    );
    $posttext = zingilt_email_substitutions(
        $posttext,
        $zingilt->name,
        $zingilt->reminderperiod,
        $user,
        $session,
        $session->id
    );

    $posttextmgrheading = zingilt_email_substitutions(
        $posttextmgrheading,
        $zingilt->name,
        $zingilt->reminderperiod,
        $user,
        $session,
        $session->id
    );

    $posthtml = ''; // FIXME.
    if ($fromaddress = get_config(null, 'zingilt_fromaddress')) {
        $from = new stdClass();
        $from->maildisplay = true;
        $from->email = $fromaddress;
    } else {
        $from = null;
    }

    $usercheck = $DB->get_record('user', array('id' => $userid));

    // Send email with iCal attachment.
    if ($notificationtype & MDL_ZILT_ICAL) {
        foreach ($icalattachments as $attachment) {
            if (!email_to_user(
                $user,
                $from,
                $attachment['subject'],
                $attachment['body'],
                $attachment['htmlbody'],
                $attachment['filename'],
                $attachmentfilename
            )) {

                return 'error:cannotsendconfirmationuser';
            }
            unlink($CFG->dataroot . '/' . $attachment['filename']);
        }
    }

    // Send plain text email.
    if ($notificationtype & MDL_ZILT_TEXT) {
        if (!email_to_user($user, $from, $postsubject, $posttext, $posthtml)) {
            return 'error:cannotsendconfirmationuser';
        }
    }

    // Manager notification.
    $manageremail = zingilt_get_manageremail($userid);
    if (!empty($posttextmgrheading) and !empty($manageremail) and $session->datetimeknown) {
        $managertext = $posttextmgrheading . $posttext;
        $manager = $user;
        $manager->email = $manageremail;

        // Leave out the ical attachments in the managers notification.
        if (!email_to_user($manager, $from, $postsubject, $managertext, $posthtml)) {
            return 'error:cannotsendconfirmationmanager';
        }
    }

    // Third-party notification.
    if (
        !empty($zingilt->thirdparty) &&
        ($session->datetimeknown || !empty($zingilt->thirdpartywaitlist))
    ) {

        $thirdparty = $user;
        $recipients = explode(',', $zingilt->thirdparty);
        foreach ($recipients as $recipient) {
            $thirdparty->email = trim($recipient);

            // Leave out the ical attachments in the 3rd parties notification.
            if (!email_to_user($thirdparty, $from, $postsubject, $posttext, $posthtml)) {
                return 'error:cannotsendconfirmationthirdparty';
            }
        }
    }

    return '';
}

/**
 * Send a confirmation email to the user and manager
 *
 * @param class $zingilt record from the zingilt table
 * @param class $session record from the zingilt_sessions table
 * @param integer $userid ID of the recipient of the email
 * @param integer $notificationtype Type of notifications to be sent @see {{MDL_ZILT_INVITE}}
 * @param boolean $iswaitlisted If the user has been waitlisted
 * @returns string Error message (or empty string if successful)
 */
function zingilt_send_confirmation_notice($zingilt, $session, $userid, $notificationtype, $iswaitlisted)
{

    $posttextmgrheading = $zingilt->confirmationinstrmngr;

    if (!$iswaitlisted) {
        $postsubject = $zingilt->confirmationsubject;
        $posttext = $zingilt->confirmationmessage;
    } else {
        $postsubject = $zingilt->waitlistedsubject;
        $posttext = $zingilt->waitlistedmessage;

        // Don't send an iCal attachement when we don't know the date!
        $notificationtype |= MDL_ZILT_TEXT; // Add a text notification.
        $notificationtype &= ~MDL_ZILT_ICAL; // Remove the iCalendar notification.
    }

    // Set invite bit.
    $notificationtype |= MDL_ZILT_INVITE;

    return zingilt_send_notice(
        $postsubject,
        $posttext,
        $posttextmgrheading,
        $notificationtype,
        $zingilt,
        $session,
        $userid
    );
}

/**
 * Send a confirmation email to the user and manager regarding the
 * cancellation
 *
 * @param class $zingilt record from the zingilt table
 * @param class $session record from the zingilt_sessions table
 * @param integer $userid ID of the recipient of the email
 * @returns string Error message (or empty string if successful)
 */
function zingilt_send_cancellation_notice($zingilt, $session, $userid)
{
    global $DB;

    $postsubject = $zingilt->cancellationsubject;
    $posttext = $zingilt->cancellationmessage;
    $posttextmgrheading = $zingilt->cancellationinstrmngr;

    // Lookup what type of notification to send.
    $notificationtype = $DB->get_field(
        'zingilt_signups',
        'notificationtype',
        array('sessionid' => $session->id, 'userid' => $userid)
    );

    // Set cancellation bit.
    $notificationtype |= MDL_ZILT_CANCEL;

    return zingilt_send_notice(
        $postsubject,
        $posttext,
        $posttextmgrheading,
        $notificationtype,
        $zingilt,
        $session,
        $userid
    );
}

/**
 * Returns true if the user has registered for a session in the given
 * zingilt activity
 *
 * @global class $USER used to get the current userid
 * @returns integer The session id that we signed up for, false otherwise
 */
function zingilt_check_signup($zingiltid)
{
    global $USER;

    if ($submissions = zingilt_get_user_submissions($zingiltid, $USER->id)) {
        return reset($submissions)->sessionid;
    } else {
        return false;
    }
}

/**
 * Return the email address of the user's manager if it is
 * defined. Otherwise return an empty string.
 *
 * @param integer $userid User ID of the staff member
 */
function zingilt_get_manageremail($userid)
{
    global $DB;
    $fieldid = $DB->get_field('user_info_field', 'id', array('shortname' => MDL_ZILT_MANAGERSEMAIL_FIELD));
    if ($fieldid) {
        return $DB->get_field('user_info_data', 'data', array('userid' => $userid, 'fieldid' => $fieldid));
    } else {
        return ''; // No custom field => no manager's email.
    }
}

/**
 * Human-readable version of the format of the manager's email address
 */
function zingilt_get_manageremailformat()
{
    $addressformat = get_config(null, 'zingilt_manageraddressformat');
    if (!empty($addressformat)) {
        $readableformat = get_config(null, 'zingilt_manageraddressformatreadable');
        return get_string('manageremailformat', 'zingilt', $readableformat);
    }

    return '';
}

/**
 * Returns true if the given email address follows the format
 * prescribed by the site administrator
 *
 * @param string $manageremail email address as entered by the user
 */
function zingilt_check_manageremail($manageremail)
{
    $addressformat = get_config(null, 'zingilt_manageraddressformat');
    if (empty($addressformat) || strpos($manageremail, $addressformat)) {
        return true;
    } else {
        return false;
    }
}

/**
 * Mark the fact that the user attended the zingilt session by
 * giving that user a grade of 100
 *
 * @param array $data array containing the sessionid under the 's' key
 *                    and every submission ID to mark as attended
 *                    under the 'submissionid_XXXX' keys where XXXX is
 *                     the ID of the signup
 */
function zingilt_take_attendance($data)
{
    global $USER;

    $sessionid = $data->s;

    // Load session.
    if (!$session = zingilt_get_session($sessionid)) {
        // error_log('ZILT: Could not load zingilt session');
        return false;
    }

    // Check zingilt has finished.
    if ($session->datetimeknown && !zingilt_has_session_started($session, time())) {
        // error_log('ZILT: Can not take attendance for a session that has not yet started');
        return false;
    }

    /*
     * Record the selected attendees from the user interface - the other attendees will need their grades set
     * to zero, to indicate non attendance, but only the ticked attendees come through from the web interface.
     * Hence the need for a diff
     */
    $selectedsubmissionids = array();

    /*
     * FIXME: This is not very efficient, we should do the grade
     * query outside of the loop to get all submissions for a
     * given zing ILT ID, then call
     * zingilt_grade_item_update with an array of grade objects.
     */
    foreach ($data as $key => $value) {
        $submissionidcheck = substr($key, 0, 13);
        if ($submissionidcheck == 'submissionid_') {
            $submissionid = substr($key, 13);
            $selectedsubmissionids[$submissionid] = $submissionid;

            // Update status.
            switch ($value) {
                case MDL_ZILT_STATUS_NO_SHOW:
                    $grade = 0;
                    break;
                case MDL_ZILT_STATUS_PARTIALLY_ATTENDED:
                    $grade = 50;
                    break;
                case MDL_ZILT_STATUS_FULLY_ATTENDED:
                    $grade = 100;
                    break;
                default:
                    // This use has not had attendance set: jump to the next item in the foreach loop.
                    continue 2;
            }

            zingilt_update_signup_status($submissionid, $value, $USER->id, '', $grade);
            if (!zingilt_take_individual_attendance($submissionid, $grade)) {
                // error_log("ZILT: could not mark '$submissionid' as " . $value);
                return false;
            }
        }
    }

    return true;
}

/**
 * Mark users' booking requests as declined or approved
 *
 * @param array $data array containing the sessionid under the 's' key
 *                    and an array of request approval/denies
 */
function zingilt_approve_requests($data)
{
    global $USER, $DB;

    // Check request data.
    if (empty($data->requests) || !is_array($data->requests)) {
        // error_log('ZILT: No request data supplied');
        return false;
    }

    $sessionid = $data->s;

    // Load session.
    if (!$session = zingilt_get_session($sessionid)) {
        // error_log('ZILT: Could not load zingilt session');
        return false;
    }

    // Load zingilt.
    if (!$zingilt = $DB->get_record('zingilt', array('id' => $session->zingilt))) {
        // error_log('ZILT: Could not load zingilt instance');
        return false;
    }

    // Load course.
    if (!$course = $DB->get_record('course', array('id' => $zingilt->course))) {
        // error_log('ZILT: Could not load course');
        return false;
    }

    // Loop through requests.
    foreach ($data->requests as $key => $value) {

        // Check key/value.
        if (!is_numeric($key) || !is_numeric($value)) {
            continue;
        }

        // Load user submission.
        if (!$attendee = zingilt_get_attendee($sessionid, $key)) {
            // error_log('ZILT: User '.$key.' not an attendee of this session');
            continue;
        }

        // Update status.
        switch ($value) {

                // Decline.
            case 1:
                zingilt_update_signup_status(
                    $attendee->submissionid,
                    MDL_ZILT_STATUS_DECLINED,
                    $USER->id
                );

                // Send a cancellation notice to the user.
                zingilt_send_cancellation_notice($zingilt, $session, $attendee->id);

                break;

                // Approve.
            case 2:
                zingilt_update_signup_status(
                    $attendee->submissionid,
                    MDL_ZILT_STATUS_APPROVED,
                    $USER->id
                );

                if (!$cm = get_coursemodule_from_instance('zingilt', $zingilt->id, $course->id)) {
                    print_error('error:incorrectcoursemodule', 'zingilt');
                }

                $contextmodule = context_module::instance($cm->id);

                // Check if there is capacity.
                if (zingilt_session_has_capacity($session, $contextmodule)) {
                    $status = MDL_ZILT_STATUS_BOOKED;
                } else {
                    if ($session->allowoverbook) {
                        $status = MDL_ZILT_STATUS_WAITLISTED;
                    }
                }

                // Signup user.
                if (!zingilt_user_signup(
                    $session,
                    $zingilt,
                    $course,
                    $attendee->discountcode,
                    $attendee->notificationtype,
                    $status,
                    $attendee->id
                )) {
                    continue 2;
                }

                break;

            case 0:
            default:
                // Change nothing.
                continue 2;
        }
    }

    return true;
}

/*
 * Set the grading for an individual submission, to either 0 or 100 to indicate attendance
 *
 * @param $submissionid The id of the submission in the database
 * @param $grading Grade to set
 */
function zingilt_take_individual_attendance($submissionid, $grading)
{
    global $USER, $CFG, $DB;

    $timenow = time();
    $record = $DB->get_record_sql(
        "SELECT f.*, s.userid
                                FROM {zingilt_signups} s
                                JOIN {zingilt_sessions} fs ON s.sessionid = fs.id
                                JOIN {zingilt} f ON f.id = fs.zingilt
                                JOIN {course_modules} cm ON cm.instance = f.id
                                JOIN {modules} m ON m.id = cm.module
                                WHERE s.id = ? AND m.name='zingilt'",
        array($submissionid)
    );

    $grade = new stdclass();
    $grade->userid = $record->userid;
    $grade->rawgrade = $grading;
    $grade->rawgrademin = 0;
    $grade->rawgrademax = 100;
    $grade->timecreated = $timenow;
    $grade->timemodified = $timenow;
    $grade->usermodified = $USER->id;

    return zingilt_grade_item_update($record, $grade);
}
/**
 * Used in many places to obtain properly-formatted session date and time info
 *
 * @param int $start a start time Unix timestamp
 * @param int $end an end time Unix timestamp
 * @param string $tz a session timezone
 * @return object Formatted date, start time, end time and timezone info
 */
function zingilt_format_session_times($start, $end, $tz)
{

    $displaytimezones = get_config(null, 'zingilt_displaysessiontimezones');

    $formattedsession = new stdClass();
    if (empty($tz) or empty($displaytimezones)) {
        $targettz = core_date::get_user_timezone();
    } else {
        $targettz = core_date::get_user_timezone($tz);
    }

    $formattedsession->startdate = userdate($start, get_string('strftimedate', 'langconfig'), $targettz);
    $formattedsession->starttime = userdate($start, get_string('strftimetime', 'langconfig'), $targettz);
    $formattedsession->enddate = userdate($end, get_string('strftimedate', 'langconfig'), $targettz);
    $formattedsession->endtime = userdate($end, get_string('strftimetime', 'langconfig'), $targettz);
    if (empty($displaytimezones)) {
        $formattedsession->timezone = '';
    } else {
        $formattedsession->timezone = core_date::get_localised_timezone($targettz);
    }
    return $formattedsession;
}

/**
 * Used by course/lib.php to display a few sessions besides the
 * zingilt activity on the course page
 *
 * @param object $cm the cm_info object for the ZILT instance
 * @global class $USER used to get the current userid
 * @global class $CFG used to get the path to the module
 */
function zingilt_cm_info_view(cm_info $coursemodule)
{
    global $USER, $DB;
    $output = '';
    $span ='';
    $moreinfolink ='';

    if (!($zingilt = $DB->get_record('zingilt', array('id' => $coursemodule->instance)))) {
        return null;
    }

    $coursemodule->set_name($zingilt->name);

    $contextmodule = context_module::instance($coursemodule->id);
    if (!has_capability('mod/zingilt:view', $contextmodule)) {
        return null; // Not allowed to view this activity.
    }
    // Can view attendees.
    $viewattendees = has_capability('mod/zingilt:viewattendees', $contextmodule);
    // Can see "view all sessions" link even if activity is hidden/currently unavailable.
    $iseditor = has_any_capability(array(
        'mod/zingilt:viewattendees', 'mod/zingilt:editsessions',
        'mod/zingilt:addattendees', 'mod/zingilt:addattendees',
        'mod/zingilt:takeattendance'
    ), $contextmodule);

    $timenow = time();

    $strviewallsessions = get_string('viewallsessions', 'zingilt');
    $sessionsurl = new moodle_url('/mod/zingilt/view.php', array('f' => $zingilt->id));
    $htmlviewallsessions = html_writer::link($sessionsurl, $strviewallsessions, array('class' => 'ZILTsessionlinks ZILTviewallsessions', 'title' => $strviewallsessions));

    if ($submissions = zingilt_get_user_submissions($zingilt->id, $USER->id)) {
        // User has signedup for the instance.

        foreach ($submissions as $submission) {

            if ($session = zingilt_get_session($submission->sessionid)) {
                $userisinwaitlist = zingilt_is_user_on_waitlist($session, $USER->id);
                if ($session->datetimeknown && zingilt_has_session_started($session, $timenow) && zingilt_is_session_in_progress($session, $timenow)) {
                    $status = get_string('sessioninprogress', 'zingilt');
                } else if ($session->datetimeknown && zingilt_has_session_started($session, $timenow)) {
                    $status = get_string('sessionover', 'zingilt');
                } else if ($userisinwaitlist) {
                    $status = get_string('waitliststatus', 'zingilt');
                } else {
                    $status = get_string('bookingstatus', 'zingilt');
                }

                // Add booking information.
                $session->bookedsession = $submission;

                $sessiondates = '';

                if ($session->datetimeknown) {
                    foreach ($session->sessiondates as $date) {
                        if (!empty($sessiondates)) {
                            $sessiondates .= html_writer::empty_tag('br');
                        }
                        $sessionobj = zingilt_format_session_times($date->timestart, $date->timefinish, null);
                        if ($sessionobj->startdate == $sessionobj->enddate) {
                            $sessiondatelangkey = !empty($sessionobj->timezone) ? 'sessionstartdateandtime' : 'sessionstartdateandtimewithouttimezone';
                            $sessiondates .= get_string($sessiondatelangkey, 'zingilt', $sessionobj);
                        } else {
                            $sessiondatelangkey = !empty($sessionobj->timezone) ? 'sessionstartfinishdateandtime' : 'sessionstartfinishdateandtimewithouttimezone';
                            $sessiondates .= get_string($sessiondatelangkey, 'zingilt', $sessionobj);
                        }
                    }
                } else {
                    $sessiondates = get_string('wait-listed', 'zingilt');
                }

                $span = html_writer::tag('span', get_string('options', 'zingilt') . ':', array('class' => 'ZILTsessionnotice'));

                // Don't include the link to cancel a session if it has already occurred.
                $moreinfolink = '';
                $cancellink = '';
                if (!zingilt_has_session_started($session, $timenow)) {
                    // $strmoreinfo  = get_string('moreinfo', 'zingilt');
                    // $signupurl   = new moodle_url('/mod/zingilt/signup.php', array('s' => $session->id));
                    // $moreinfolink = html_writer::link($signupurl, $strmoreinfo, array('class' => 'ZILTsessionlinks ZILTsessioninfolink', 'title' => $strmoreinfo));
                }

                // Don't include the link to view attendees if user is lacking capability.
                $attendeeslink = '';
                if ($viewattendees) {
                    $strseeattendees = get_string('seeattendees', 'zingilt');
                    $attendeesurl = new moodle_url('/mod/zingilt/attendees.php', array('s' => $session->id));
                    $attendeeslink = html_writer::link($attendeesurl, $strseeattendees, array('class' => 'ZILTsessionlinks ZILTviewattendees', 'title' => $strseeattendees));
                }

                $output .= html_writer::start_tag('div', array('class' => 'ZILTsessiongroup'))
                    . html_writer::tag('span', $status, array('class' => 'ZILTsessionnotice'))
                    . html_writer::start_tag('div', array('class' => 'ZILTsession ZILTsignedup'))
                    . html_writer::tag('div', $sessiondates, array('class' => 'ZILTsessiontime'))
                    . html_writer::tag('div', $span . $moreinfolink . $attendeeslink . $cancellink, array('class' => 'ZILToptions'))
                    . html_writer::end_tag('div')
                    . html_writer::end_tag('div');
            }
        }
        // Add "view all sessions" row to table.
        $output .= $htmlviewallsessions;
    } else if ($sessions = zingilt_get_sessions($zingilt->id)) {
        if ($zingilt->display > 0) {
            $j = 1;

            $sessionsinprogress = array();
            $futuresessions = array();

            foreach ($sessions as $session) {
                if (!zingilt_session_has_capacity($session, $contextmodule, MDL_ZILT_STATUS_WAITLISTED) && !$session->allowoverbook) {
                    continue;
                }

                if ($session->datetimeknown && zingilt_has_session_started($session, $timenow) && !zingilt_is_session_in_progress($session, $timenow)) {
                    // Finished session, don't display.
                    continue;
                } else {
                    // $signupurl   = new moodle_url('/mod/zingilt/signup.php', array('s' => $session->id));
                    // $signuptext   = 'signup';
                    // $moreinfolink = html_writer::link($signupurl, get_string($signuptext, 'zingilt'), array('class' => 'ZILTsessionlinks ZILTsessioninfolink'));

                    // $span = html_writer::tag('span', get_string('options', 'zingilt') . ':', array('class' => 'ZILTsessionnotice'));
                }

                $multidate = '';
                $sessiondate = '';
                if ($session->datetimeknown) {
                    if (empty($session->sessiondates)) {
                        $sessiondate = get_string('unknowndate', 'zingilt');
                    } else {
                        $sessionobj = zingilt_format_session_times($session->sessiondates[0]->timestart, $session->sessiondates[0]->timefinish, null);
                        if ($sessionobj->startdate == $sessionobj->enddate) {
                            $sessiondatelangkey = !empty($sessionobj->timezone) ? 'sessionstartdateandtime' : 'sessionstartdateandtimewithouttimezone';
                            $sessiondate = get_string($sessiondatelangkey, 'zingilt', $sessionobj);
                        } else {
                            $sessiondatelangkey = !empty($sessionobj->timezone) ? 'sessionstartfinishdateandtime' : 'sessionstartfinishdateandtimewithouttimezone';
                            $sessiondate .= get_string($sessiondatelangkey, 'zingilt', $sessionobj);
                        }
                        if (count($session->sessiondates) > 1) {
                            $multidate = html_writer::empty_tag('br') . get_string('multidate', 'zingilt');
                        }
                    }
                } else {
                    $sessiondate = get_string('wait-listed', 'zingilt');
                }

                $sessionobject = new stdClass();
                $sessionobject->date = $sessiondate;
                $sessionobject->multidate = $multidate;

                if ($session->datetimeknown && (zingilt_has_session_started($session, $timenow)) && zingilt_is_session_in_progress($session, $timenow)) {
                    $sessionsinprogress[] = $sessionobject;
                } else {
                    $sessionobject->options = $span;
                    $sessionobject->moreinfolink = $moreinfolink;
                    $futuresessions[] = $sessionobject;
                }

                $j++;
                if ($j > $zingilt->display) {
                    break;
                }
            }

            if (!empty($sessionsinprogress)) {
                $output .= html_writer::start_tag('div', array('class' => 'ZILTsessiongroup'));
                $output .= html_writer::tag('span', get_string('sessioninprogress', 'zingilt'), array('class' => 'ZILTsessionnotice'));

                foreach ($sessionsinprogress as $session) {
                    $output .= html_writer::start_tag('div', array('class' => 'ZILTsession ZILTinprogress'))
                        . html_writer::tag('span', $session->date . $session->multidate, array('class' => 'ZILTsessiontime'))
                        . html_writer::end_tag('div');
                }
                $output .= html_writer::end_tag('div');
            }

            if (!empty($futuresessions)) {
                $output .= html_writer::start_tag('div', array('class' => 'ZILTsessiongroup'));
              //  $output .= html_writer::tag('span', get_string('signupforsession', 'zingilt'), array('class' => 'ZILTsessionnotice'));

                foreach ($futuresessions as $session) {
                    $output .= html_writer::start_tag('div', array('class' => 'ZILTsession ZILTfuture'))
                        . html_writer::tag('div', $session->date . $session->multidate, array('class' => 'ZILTsessiontime'))
                        . html_writer::tag('div', $session->options . $session->moreinfolink, array('class' => 'ZILToptions'))
                        . html_writer::end_tag('div');
                }
                $output .= html_writer::end_tag('div');
            }

            $output .= ($iseditor || ($coursemodule->visible && $coursemodule->available)) ? $htmlviewallsessions : $strviewallsessions;
        } else {
            // Show only name if session display is set to zero.
            $content = html_writer::tag('span', $htmlviewallsessions, array('class' => 'ZILTsessionnotice ZILTactivityname'));
            $coursemodule->set_content($content);
            return;
        }
    } else if (has_capability('mod/zingilt:viewemptyactivities', $contextmodule)) {
        $content = html_writer::tag('span', $htmlviewallsessions, array('class' => 'ZILTsessionnotice ZILTactivityname'));
        $coursemodule->set_content($content);
        return;
    } else {
        // Nothing to display to this user.
        $coursemodule->set_content('');
        return;
    }

    $coursemodule->set_content($output);
}

/**
 * Returns the ICAL data for a zingilt meeting.
 *
 * @param integer $method The method, @see {{MDL_ZILT_INVITE}}
 * @param object $zingilt A zing ILT object containing activity details
 * @param object $session A session object containing session details
 * @return string Filename of the attachment in the temp directory
 */
function zingilt_get_ical_attachment($method, $zingilt, $session, $user)
{
    global $CFG, $DB;

    // First, generate all the VEVENT blocks.
    $vevents = '';
    foreach ($session->sessiondates as $date) {

        /*
         * Date that this representation of the calendar information was created -
         * we use the time the session was created
         * http://www.kanzaki.com/docs/ical/dtstamp.html
         */
        $dtstamp = zingilt_ical_generate_timestamp($session->timecreated);

        // UIDs should be globally unique.
        $urlbits = parse_url($CFG->wwwroot);
        $sql = "SELECT COUNT(*)
            FROM {zingilt_signups} su
            INNER JOIN {zingilt_signups_status} sus ON su.id = sus.signupid
            WHERE su.userid = ?
                AND su.sessionid = ?
                AND sus.superceded = 1
                AND sus.statuscode = ? ";
        $params = array($user->id, $session->id, MDL_ZILT_STATUS_USER_CANCELLED);

        $uid = $dtstamp .
            '-' . substr(md5($CFG->siteidentifier . $session->id . $date->id), -8) .   // Unique identifier, salted with site identifier.
            '-' . $DB->count_records_sql($sql, $params) .                              // New UID if this is a re-signup.
            '@' . $urlbits['host'];                                                    // Hostname for this moodle installation.

        $dtstart = zingilt_ical_generate_timestamp($date->timestart);
        $dtend   = zingilt_ical_generate_timestamp($date->timefinish);

        // FIXME: currently we are not sending updates if the times of the session are changed. This is not ideal!
        $sequence = ($method & MDL_ZILT_CANCEL) ? 1 : 0;

        $summary     = zingilt_ical_escape($zingilt->name);
        $description = zingilt_ical_escape($session->details, true);

        // Get the location data from custom fields if they exist.
        $customfielddata = zingilt_get_customfielddata($session->id);
        $locationstring = '';
        if (!empty($customfielddata['room'])) {
            $locationstring .= $customfielddata['room']->data;
        }
        if (!empty($customfielddata['venue'])) {
            if (!empty($locationstring)) {
                $locationstring .= "\n";
            }
            $locationstring .= $customfielddata['venue']->data;
        }
        if (!empty($customfielddata['location'])) {
            if (!empty($locationstring)) {
                $locationstring .= "\n";
            }
            $locationstring .= $customfielddata['location']->data;
        }

        /*
         * NOTE: Newlines are meant to be encoded with the literal sequence
         * '\n'. But evolution presents a single line text field for location,
         * and shows the newlines as [0x0A] junk. So we switch it for commas
         * here. Remember commas need to be escaped too.
         */
        $location = str_replace('\n', '\, ', zingilt_ical_escape($locationstring));

        $organiseremail = get_config(null, 'zingilt_fromaddress');

        $role = 'REQ-PARTICIPANT';
        $cancelstatus = '';
        if ($method & MDL_ZILT_CANCEL) {
            $role = 'NON-PARTICIPANT';
            $cancelstatus = "\nSTATUS:CANCELLED";
        }

        $icalmethod = ($method & MDL_ZILT_INVITE) ? 'REQUEST' : 'CANCEL';

        // FIXME: if the user has input their name in another language, we need to set the LANGUAGE property parameter here.
        $username = fullname($user);
        $mailto   = $user->email;

        // The extra newline at the bottom is so multiple events start on their own lines. The very last one is trimmed outside the loop.
        $vevents .= <<<EOF
BEGIN:VEVENT
UID:{$uid}
DTSTAMP:{$dtstamp}
DTSTART:{$dtstart}
DTEND:{$dtend}
SEQUENCE:{$sequence}
SUMMARY:{$summary}
LOCATION:{$location}
DESCRIPTION:{$description}
CLASS:PRIVATE
TRANSP:OPAQUE{$cancelstatus}
ORGANIZER;CN={$organiseremail}:MAILTO:{$organiseremail}
ATTENDEE;CUTYPE=INDIVIDUAL;ROLE={$role};PARTSTAT=NEEDS-ACTION;
 RSVP=FALSE;CN={$username};LANGUAGE=en:MAILTO:{$mailto}
END:VEVENT

EOF;
    }

    $vevents = trim($vevents);

    // TODO: remove the hard-coded timezone!.
    $template = <<<EOF
BEGIN:VCALENDAR
CALSCALE:GREGORIAN
PRODID:-//Moodle//NONSGML zingilt//EN
VERSION:2.0
METHOD:{$icalmethod}
BEGIN:VTIMEZONE
TZID:/softwarestudio.org/Tzfile/Pacific/Auckland
X-LIC-LOCATION:Pacific/Auckland
BEGIN:STANDARD
TZNAME:NZST
DTSTART:19700405T020000
RRULE:FREQ=YEARLY;INTERVAL=1;BYDAY=1SU;BYMONTH=4
TZOFFSETFROM:+1300
TZOFFSETTO:+1200
END:STANDARD
BEGIN:DAYLIGHT
TZNAME:NZDT
DTSTART:19700928T030000
RRULE:FREQ=YEARLY;INTERVAL=1;BYDAY=-1SU;BYMONTH=9
TZOFFSETFROM:+1200
TZOFFSETTO:+1300
END:DAYLIGHT
END:VTIMEZONE
{$vevents}
END:VCALENDAR
EOF;

    $tempfilename = md5($template);
    $tempfilepathname = $CFG->dataroot . '/' . $tempfilename;
    file_put_contents($tempfilepathname, $template);
    return $tempfilename;
}

function zingilt_ical_generate_timestamp($timestamp)
{
    return gmdate('Ymd', $timestamp) . 'T' . gmdate('His', $timestamp) . 'Z';
}

/**
 * Escapes data of the text datatype in ICAL documents.
 *
 * See RFC2445 or http://www.kanzaki.com/docs/ical/text.html or a more readable definition
 */
function zingilt_ical_escape($text, $converthtml = false)
{
    if (empty($text)) {
        return '';
    }

    if ($converthtml) {
        $text = html_to_text($text);
    }

    $text = str_replace(
        array('\\',   "\n", ';',  ','),
        array('\\\\', '\n', '\;', '\,'),
        $text
    );

    // Text should be wordwrapped at 75 octets, and there should be one whitespace after the newline that does the wrapping.
    $text = wordwrap($text, 75, "\n ", true);

    return $text;
}

/**
 * Determine if a user is in the waitlist of a session.
 *
 * @param object $session A session object
 * @param int $userid The user ID
 * @return bool True if the user is on waitlist, false otherwise.
 */
function zingilt_is_user_on_waitlist($session, $userid = null)
{
    global $DB, $USER;

    if ($userid === null) {
        $userid = $USER->id;
    }

    $sql = "SELECT 1
            FROM {zingilt_signups} su
            JOIN {zingilt_signups_status} ss ON su.id = ss.signupid
            WHERE su.sessionid = ?
              AND ss.superceded != 1
              AND su.userid = ?
              AND ss.statuscode = ?";

    return $DB->record_exists_sql($sql, array($session->id, $userid, MDL_ZILT_STATUS_WAITLISTED));
}

/**
 * Update grades by firing grade_updated event
 *
 * @param object $zingilt null means all zingilt activities
 * @param int $userid specific user only, 0 mean all (not used here)
 */
function zingilt_update_grades($zingilt = null, $userid = 0)
{
    global $DB;

    if ($zingilt != null) {
        zingilt_grade_item_update($zingilt);
    } else {
        $sql = "SELECT f.*, cm.idnumber as cmidnumber
                  FROM {zingilt} f
                  JOIN {course_modules} cm ON cm.instance = f.id
                  JOIN {modules} m ON m.id = cm.module
                 WHERE m.name='zingilt'";
        if ($rs = $DB->get_recordset_sql($sql)) {
            foreach ($rs as $zingilt) {
                zingilt_grade_item_update($zingilt);
            }
            $rs->close();
        }
    }

    return true;
}

/**
 * Create grade item for given zing ILT session
 *
 * @param int zingilt  zing ILT activity (not the session) to grade
 * @param mixed grades    grades objects or 'reset' (means reset grades in gradebook)
 * @return int 0 if ok, error code otherwise
 */
function zingilt_grade_item_update($zingilt, $grades = null)
{
    global $CFG, $DB;

    if (!isset($zingilt->cmidnumber)) {

        $sql = "SELECT cm.idnumber as cmidnumber
                  FROM {course_modules} cm
                  JOIN {modules} m ON m.id = cm.module
                 WHERE m.name='zingilt' AND cm.instance = ?";
        $zingilt->cmidnumber = $DB->get_field_sql($sql, array($zingilt->id));
    }

    $params = array(
        'itemname' => $zingilt->name,
        'idnumber' => $zingilt->cmidnumber
    );

    $params['gradetype'] = GRADE_TYPE_VALUE;
    $params['grademin']  = 0;
    $params['gradepass'] = 100;
    $params['grademax']  = 100;

    if ($grades === 'reset') {
        $params['reset'] = true;
        $grades = null;
    }

    $retcode = grade_update(
        'mod/zingilt',
        $zingilt->course,
        'mod',
        'zingilt',
        $zingilt->id,
        0,
        $grades,
        $params
    );
    return ($retcode === GRADE_UPDATE_OK);
}

/**
 * Delete grade item for given zingilt
 *
 * @param object $zingilt object
 * @return object zingilt
 */
function zingilt_grade_item_delete($zingilt)
{
    $retcode = grade_update(
        'mod/zingilt',
        $zingilt->course,
        'mod',
        'zingilt',
        $zingilt->id,
        0,
        null,
        array('deleted' => 1)
    );
    return ($retcode === GRADE_UPDATE_OK);
}

/**
 * Return number of attendees signed up to a zingilt session
 *
 * @param integer $sessionid
 * @param integer $status MDL_ZILT_STATUS_* constant (optional)
 * @return integer
 */
function zingilt_get_num_attendees($sessionid, $status = MDL_ZILT_STATUS_BOOKED)
{
    global $CFG, $DB;

    $sql = 'SELECT count(ss.id)
        FROM
            {zingilt_signups} su
        JOIN
            {zingilt_signups_status} ss
        ON
            su.id = ss.signupid
        WHERE
            sessionid = ?
        AND
            ss.superceded=0
        AND
        ss.statuscode >= ?';

    // For the session, pick signups that haven't been superceded, or cancelled.
    return (int) $DB->count_records_sql($sql, array($sessionid, $status));
}

/**
 * Return all of a users' submissions to a zingilt
 *
 * @param integer $zingiltid
 * @param integer $userid
 * @param boolean $includecancellations
 * @return array submissions | false No submissions
 */
function zingilt_get_user_submissions($zingiltid, $userid, $includecancellations = false)
{
    global $CFG, $DB;

    $whereclause = "s.zingilt = ? AND su.userid = ? AND ss.superceded != 1";
    $whereparams = array($zingiltid, $userid);

    // If not show cancelled, only show requested and up status'.
    if (!$includecancellations) {
        $whereclause .= ' AND ss.statuscode >= ? AND ss.statuscode < ?';
        $whereparams = array_merge($whereparams, array(MDL_ZILT_STATUS_REQUESTED, MDL_ZILT_STATUS_NO_SHOW));
    }

    // TODO fix mailedconfirmation, timegraded, timecancelled, etc.
    return $DB->get_records_sql("
        SELECT
            su.id,
            s.zingilt,
            s.id as sessionid,
            su.userid,
            0 as mailedconfirmation,
            su.mailedreminder,
            su.discountcode,
            ss.timecreated,
            ss.timecreated as timegraded,
            s.timemodified,
            0 as timecancelled,
            su.notificationtype,
            ss.statuscode
        FROM
            {zingilt_sessions} s
        JOIN
            {zingilt_signups} su
         ON su.sessionid = s.id
        JOIN
            {zingilt_signups_status} ss
         ON su.id = ss.signupid
        WHERE
            {$whereclause}
        ORDER BY
            s.timecreated
    ", $whereparams);
}

/**
 * Cancel users' submission to a zingilt session
 *
 * @param integer $sessionid   ID of the zingilt_sessions record
 * @param integer $userid      ID of the user record
 * @param string $cancelreason Short justification for cancelling the signup
 * @return boolean success
 */
function zingilt_user_cancel_submission($sessionid, $userid, $cancelreason = '')
{
    global $DB;

    $signup = $DB->get_record('zingilt_signups', array('sessionid' => $sessionid, 'userid' => $userid));
    if (!$signup) {
        return true; // Not signed up, nothing to do.
    }

    return zingilt_update_signup_status($signup->id, MDL_ZILT_STATUS_USER_CANCELLED, $userid, $cancelreason);
}

/**
 * A list of actions in the logs that indicate view activity for participants
 */
function zingilt_get_view_actions()
{
    return array('view', 'view all');
}

/**
 * A list of actions in the logs that indicate post activity for participants
 */
function zingilt_get_post_actions()
{
    return array('cancel booking', 'signup');
}

/**
 * Return a small object with summary information about what a user
 * has done with a given particular instance of this module (for user
 * activity reports.)
 *
 * $return->time = the time they did it
 * $return->info = a short text description
 */
function zingilt_user_outline($course, $user, $mod, $zingilt)
{

    $result = new stdClass;
    $grade = zingilt_get_grade($user->id, $course->id, $zingilt->id);
    if ($grade->grade > 0) {
        $result = new stdClass;
        $result->info = get_string('grade') . ': ' . $grade->grade;
        $result->time = $grade->dategraded;
    } else if ($submissions = zingilt_get_user_submissions($zingilt->id, $user->id)) {
        $result->info = get_string('usersignedup', 'zingilt');
        $result->time = reset($submissions)->timecreated;
    } else {
        $result->info = get_string('usernotsignedup', 'zingilt');
    }

    return $result;
}

/**
 * Print a detailed representation of what a user has done with a
 * given particular instance of this module (for user activity
 * reports).
 */
function zingilt_user_complete($course, $user, $mod, $zingilt)
{
    $grade = zingilt_get_grade($user->id, $course->id, $zingilt->id);
    if ($submissions = zingilt_get_user_submissions($zingilt->id, $user->id, true)) {
        print get_string('grade') . ': ' . $grade->grade . html_writer::empty_tag('br');
        if ($grade->dategraded > 0) {
            $timegraded = trim(userdate($grade->dategraded, get_string('strftimedatetime')));
            print '(' . format_string($timegraded) . ')' . html_writer::empty_tag('br');
        }
        echo html_writer::empty_tag('br');

        foreach ($submissions as $submission) {
            $timesignedup = trim(userdate($submission->timecreated, get_string('strftimedatetime')));
            print get_string('usersignedupon', 'zingilt', format_string($timesignedup)) . html_writer::empty_tag('br');

            if ($submission->timecancelled > 0) {
                $timecancelled = userdate($submission->timecancelled, get_string('strftimedatetime'));
                print get_string('usercancelledon', 'zingilt', format_string($timecancelled)) . html_writer::empty_tag('br');
            }
        }
    } else {
        print get_string('usernotsignedup', 'zingilt');
    }

    return true;
}

/**
 * Add a link to the session to the courses calendar.
 *
 * @param class   $session          Record from the zingilt_sessions table
 * @param class   $eventname        Name to display for this event
 * @param string  $calendartype     Which calendar to add the event to (user, course, site)
 * @param int     $userid           Optional param for user calendars
 * @param string  $eventtype        Optional param for user calendar (booking/session)
 */
function zingilt_add_session_to_calendar($session, $zingilt, $calendartype = 'none', $userid = 0, $eventtype = 'session')
{
    global $CFG, $DB;

    if (empty($session->datetimeknown)) {
        return true; // Date unkown, can't add to calendar.
    }

    if (empty($zingilt->showoncalendar) && empty($zingilt->usercalentry)) {
        return true; // zingilt calendar settings prevent calendar.
    }

    $description = '';
    if (!empty($zingilt->description)) {
        $description .= html_writer::tag('p', clean_param($zingilt->description, PARAM_CLEANHTML));
    }
    $description .= zingilt_print_session($session, false, true, true);
     $linkurl = new moodle_url('/mod/zingilt/signup.php', array('s' => $session->id));
     $linktext = get_string('signupforthissession', 'zingilt');

    if ($calendartype == 'site' && $zingilt->showoncalendar == ZILT_CAL_SITE) {
        $courseid = SITEID;
        $modulename = '0';
        $description .= html_writer::link($linkurl, $linktext);
    } else if ($calendartype == 'course' && $zingilt->showoncalendar == ZILT_CAL_COURSE) {
        $courseid = $zingilt->course;
        $modulename = 'zingilt';
       $description .= html_writer::link($linkurl, $linktext);
    } else if ($calendartype == 'user' && $zingilt->usercalentry) {
        $courseid = 0;
        $modulename = '0';
        $urlvar = ($eventtype == 'session') ? 'attendees' : 'signup';
        $linkurl = $CFG->wwwroot . "/mod/zingilt/" . $urlvar . ".php?s=$session->id";
        $description .= get_string("calendareventdescription{$eventtype}", 'zingilt', $linkurl);
    } else {
        return true;
    }

    $shortname = $zingilt->shortname;
    if (empty($shortname)) {
        $shortname = substr($zingilt->name, 0, ZILT_CALENDAR_MAX_NAME_LENGTH);
    }

    $result = true;
    foreach ($session->sessiondates as $date) {
        $newevent = new stdClass();
        $newevent->name = $shortname;
        $newevent->description = $description;
        $newevent->format = FORMAT_HTML;
        $newevent->courseid = $courseid;
        $newevent->groupid = 0;
        $newevent->userid = $userid;
        $newevent->uuid = "{$session->id}";
        $newevent->instance = $session->zingilt;
        $newevent->modulename = $modulename;
        $newevent->eventtype = "zingilt{$eventtype}";
        $newevent->type = 0; // CALENDAR_EVENT_TYPE_STANDARD: Only display on the calendar, not needed on the block_myoverview.
        $newevent->timestart = $date->timestart;
        $newevent->timeduration = $date->timefinish - $date->timestart;
        $newevent->visible = 1;
        $newevent->timemodified = time();

        if ($calendartype == 'user' && $eventtype == 'booking') {

            // Check for and Delete the 'created' calendar event to reduce multiple entries for the same event.
            $DB->delete_records_select(
                'event',
                'userid = ? AND instance = ? AND '
                    . $DB->sql_compare_text('eventtype') . ' = ? AND ' . $DB->sql_compare_text('name') . ' = ?',
                array($userid, $session->zingilt, 'zingiltsession', $shortname)
            );
        }

        $result = $result && $DB->insert_record('event', $newevent);
    }

    return $result;
}

/**
 * Remove all entries in the course calendar which relate to this session.
 *
 * @param class $session    Record from the zingilt_sessions table
 * @param integer $courseid ID of the course - 0 for user event, SITEID for global event, 2+ for course event.
 * @param string $userid    ID of the user. If not specified, will match any used ID.
 */
function zingilt_remove_session_from_calendar($session, $courseid = 0, $userid = 0)
{
    global $DB;

    $modulename = '0';         // User events and Site events.
    if ($courseid > SITEID) {  // Course event.
        $modulename = 'zingilt';
    }
    if (empty($userid)) { // Match any UserID.
        $params = array($modulename, $session->zingilt, $courseid, $session->id);
        return $DB->delete_records_select('event', "modulename = ? AND
                                                    instance = ? AND
                                                    courseid = ? AND
                                                    uuid = ?", $params);
    } else {
        $params = array($modulename, $session->zingilt, $userid, $courseid, $session->id);
        return $DB->delete_records_select('event', "modulename = ? AND
                                                    instance = ? AND
                                                    userid = ? AND
                                                    courseid = ? AND
                                                    uuid = ?", $params);
    }
}

/**
 * Update the date/time of events in the Moodle Calendar when a
 * session's dates are changed.
 *
 * @param object $session       Record from the zingilt_sessions table
 * @param string $eventtype     Type of event to update
 */
function zingilt_update_user_calendar_events($session, $eventtype)
{
    global $DB;

    $zingilt = $DB->get_record('zingilt', array('id' => $session->zingilt));
    if (empty($zingilt->usercalentry) || $zingilt->usercalentry == 0) {
        return true;
    }

    $users = zingilt_delete_user_calendar_events($session, $eventtype);

    // Add this session to these users' calendar.
    foreach ($users as $user) {
        zingilt_add_session_to_calendar($session, $zingilt, 'user', $user->userid, $eventtype);
    }

    return true;
}

/**
 * Delete all user level calendar events for a face to face session
 *
 * @param class     $session    Record from the zingilt_sessions table
 * @param string    $eventtype  Type of the event (booking or session)
 * @return array    $users      Array of users who had the event deleted
 */
function zingilt_delete_user_calendar_events($session, $eventtype)
{
    global $CFG, $DB;

    $whereclause = "modulename = '0' AND
                    eventtype = 'zingilt$eventtype' AND
                    instance = ?";

    $whereparams = array($session->zingilt);

    if ('session' == $eventtype) {
        $likestr = "%attendees.php?s={$session->id}%";
        $like = $DB->sql_like('description', '?');
        $whereclause .= " AND $like";

        $whereparams[] = $likestr;
    }

    // Users calendar.
    $users = $DB->get_records_sql("SELECT DISTINCT userid
        FROM {event}
        WHERE $whereclause", $whereparams);

    if ($users && count($users) > 0) {

        // Delete the existing events.
        $DB->delete_records_select('event', $whereclause, $whereparams);
    }

    return $users;
}

/**
 * Confirm that a user can be added to a session.
 *
 * @param class  $session Record from the zingilt_sessions table
 * @param object $context (optional) A context object (record from context table)
 * @return bool True if user can be added to session
 **/
function zingilt_session_has_capacity($session, $context = false)
{
    if (empty($session)) {
        return false;
    }

    $signupcount = zingilt_get_num_attendees($session->id);
    if ($signupcount >= $session->capacity) {

        // If session is full, check if overbooking is allowed for this user.
        if (!$context || !has_capability('mod/zingilt:overbook', $context)) {
            return false;
        }
    }

    return true;
}

/**
 * Print the details of a session
 *
 * @param object $session         Record from zingilt_sessions
 * @param boolean $showcapacity   Show the capacity (true) or only the seats available (false)
 * @param boolean $calendaroutput Whether the output should be formatted for a calendar event
 * @param boolean $return         Whether to return (true) the html or print it directly (true)
 * @param boolean $hidesignup     Hide any messages relating to signing up
 */
function zingilt_print_session($session, $showcapacity, $calendaroutput = false, $return = false, $hidesignup = false)
{
    global $CFG, $DB;

    $table = new html_table();
    $table->summary = get_string('sessionsdetailstablesummary', 'zingilt');
    $table->attributes['class'] = 'generaltable ZILTsession';
    $table->align = array('right', 'left');
    if ($calendaroutput) {
        $table->tablealign = 'left';
    }

    $customfields = zingilt_get_session_customfields();
    $customdata = $DB->get_records('zingilt_session_data', array('sessionid' => $session->id), '', 'fieldid, data');
    foreach ($customfields as $field) {
        $data = '';
        if (!empty($customdata[$field->id])) {
            if (ZILT_CUSTOMFIELD_TYPE_MULTISELECT == $field->type) {
                $values = explode(ZILT_CUSTOMFIELD_DELIMITER, format_string($customdata[$field->id]->data));
                $data = implode(html_writer::empty_tag('br'), $values);
            } else {
                $data = format_string($customdata[$field->id]->data);
            }
        }
        $table->data[] = array(str_replace(' ', '&nbsp;', format_string($field->name)), $data);
    }
//print session name 
    $strsessionname = str_replace(' ', '&nbsp;', get_string('session_name', 'zingilt'));
    if ($session->name) {
        $html = '';
        $table->data[] = array($strsessionname, $session->name);
    } else {
        $table->data[] = array($strsessionname, '-');
    }

    $strdatetime = str_replace(' ', '&nbsp;', get_string('sessiondatetime', 'zingilt'));
    if ($session->datetimeknown) {
        $html = '';
        foreach ($session->sessiondates as $date) {
            if (!empty($html)) {
                $html .= html_writer::empty_tag('br');
            }
            $timestart = userdate($date->timestart, get_string('strftimedatetime'));
            $timefinish = userdate($date->timefinish, get_string('strftimedatetime'));
            $html .= "$timestart &ndash; $timefinish";
        }
        $table->data[] = array($strdatetime, $html);
    } else {
        $table->data[] = array($strdatetime, html_writer::tag('i', get_string('wait-listed', 'zingilt')));
    }

    $signupcount = zingilt_get_num_attendees($session->id);
    $placesleft = $session->capacity - $signupcount;

    if ($showcapacity) {
        if ($session->allowoverbook) {
            $table->data[] = array(get_string('capacity', 'zingilt'), $session->capacity . ' (' . strtolower(get_string('allowoverbook', 'zingilt')) . ')');
        } else {
            $table->data[] = array(get_string('capacity', 'zingilt'), $session->capacity);
        }
    } else if (!$calendaroutput) {
        $table->data[] = array(get_string('seatsavailable', 'zingilt'), max(0, $placesleft));
    }

    // Display requires approval notification.
    $zingilt = $DB->get_record('zingilt', array('id' => $session->zingilt));

    if ($zingilt->approvalreqd) {
        $table->data[] = array('', get_string('sessionrequiresmanagerapproval', 'zingilt'));
    }

    // Display waitlist notification.
    if (!$hidesignup && $session->allowoverbook && $placesleft < 1) {
        $table->data[] = array('', get_string('userwillbewaitlisted', 'zingilt'));
    }

    if (!empty($session->duration)) {
        $table->data[] = array(get_string('duration', 'zingilt'), zilt_format_duration($session->duration));
    }
    if (!empty($session->normalcost)) {
        $table->data[] = array(get_string('normalcost', 'zingilt'), zilt_format_cost($session->normalcost));
    }
    if (!empty($session->discountcost)) {
        $table->data[] = array(get_string('discountcost', 'zingilt'), zilt_format_cost($session->discountcost));
    }
    if (!empty($session->details)) {
        $details = clean_text($session->details, FORMAT_HTML);
        $table->data[] = array(get_string('details', 'zingilt'), $details);
    }

    // Display trainers.
    $trainerroles = zingilt_get_trainer_roles();

    if ($trainerroles) {

        // Get trainers.
        $trainers = zingilt_get_trainers($session->id);
        foreach ($trainerroles as $role => $rolename) {
            $rolename = $rolename->name;

            if (empty($trainers[$role])) {
                continue;
            }

            $trainernames = array();
            foreach ($trainers[$role] as $trainer) {
                $trainerurl = new moodle_url('/user/view.php', array('id' => $trainer->id));
                $trainernames[] = html_writer::link($trainerurl, fullname($trainer));
            }

            $table->data[] = array('Session Trainers', implode(', ', $trainernames));
        }
    }

    return html_writer::table($table, $return);
}

/**
 * Update the value of a customfield for the given session/notice.
 *
 * @param integer $fieldid    ID of a record from the zingilt_session_field table
 * @param string  $data       Value for that custom field
 * @param integer $otherid    ID of a record from the zingilt_(sessions|notice) table
 * @param string  $table      'session' or 'notice' (part of the table name)
 * @returns true if it succeeded, false otherwise
 */
function zingilt_save_customfield_value($fieldid, $data, $otherid, $table)
{
    global $DB;

    $dbdata = null;
    if (is_array($data)) {
        $dbdata = trim(implode(ZILT_CUSTOMFIELD_DELIMITER, $data), ';');
    } else {
        $dbdata = trim($data);
    }

    $newrecord = new stdClass();
    $newrecord->data = $dbdata;

    $fieldname = "{$table}id";
    if ($record = $DB->get_record("zingilt_{$table}_data", array('fieldid' => $fieldid, $fieldname => $otherid))) {
        if (empty($dbdata)) {

            // Clear out the existing value.
            return $DB->delete_records("zingilt_{$table}_data", array('id' => $record->id));
        }

        $newrecord->id = $record->id;
        return $DB->update_record("zingilt_{$table}_data", $newrecord);
    } else {
        if (empty($dbdata)) {
            return true; // No need to store empty values.
        }

        $newrecord->fieldid = $fieldid;
        $newrecord->$fieldname = $otherid;

        return $DB->insert_record("zingilt_{$table}_data", $newrecord);
    }
}

/**
 * Return the value of a customfield for the given session/notice.
 *
 * @param object  $field    A record from the zingilt_session_field table
 * @param integer $otherid  ID of a record from the zingilt_(sessions|notice) table
 * @param string  $table    'session' or 'notice' (part of the table name)
 * @returns string The data contained in this custom field (empty string if it doesn't exist)
 */
function zingilt_get_customfield_value($field, $otherid, $table)
{
    global $DB;

    if ($record = $DB->get_record("zingilt_{$table}_data", array('fieldid' => $field->id, "{$table}id" => $otherid))) {
        if (!empty($record->data)) {
            if (ZILT_CUSTOMFIELD_TYPE_MULTISELECT == $field->type) {
                return explode(ZILT_CUSTOMFIELD_DELIMITER, $record->data);
            }
            return $record->data;
        }
    }

    return '';
}

/**
 * Return the values stored for all custom fields in the given session.
 *
 * @param integer $sessionid  ID of zingilt_sessions record
 * @returns array Indexed by field shortnames
 */
function zingilt_get_customfielddata($sessionid)
{
    global $CFG, $DB;

    $sql = "SELECT f.shortname, d.data
              FROM {zingilt_session_field} f
              JOIN {zingilt_session_data} d ON f.id = d.fieldid
              WHERE d.sessionid = ?";

    $records = $DB->get_records_sql($sql, array($sessionid));

    return $records;
}

/**
 * Return a cached copy of all records in zingilt_session_field
 */
function zingilt_get_session_customfields()
{
    global $DB;

    static $customfields = null;
    if (null == $customfields) {
        if (!$customfields = $DB->get_records('zingilt_session_field')) {
            $customfields = array();
        }
    }
    return $customfields;
}

/**
 * Display the list of custom fields in the site-wide settings page
 */
function zingilt_list_of_customfields()
{
    global $CFG, $USER, $DB, $OUTPUT;

    if ($fields = $DB->get_records('zingilt_session_field', array(), 'name', 'id, name')) {
        $table = new html_table();
        $table->attributes['class'] = 'halfwidthtable';
        foreach ($fields as $field) {
            $fieldname = format_string($field->name);
            $editurl = new moodle_url('/mod/zingilt/customfield.php', array('id' => $field->id));
            $editlink = $OUTPUT->action_icon($editurl, new pix_icon('t/edit', get_string('edit')));
            $deleteurl = new moodle_url('/mod/zingilt/customfield.php', array('id' => $field->id, 'd' => '1', 'sesskey' => $USER->sesskey));
            $deletelink = $OUTPUT->action_icon($deleteurl, new pix_icon('t/delete', get_string('delete')));
            $table->data[] = array($fieldname, $editlink, $deletelink);
        }
        return html_writer::table($table, true);
    }

    return get_string('nocustomfields', 'zingilt');
}

function zingilt_update_trainers($sessionid, $form) {
    global $DB;

    // If we recieved bad data.
    if (!is_array($form)) {
        return false;
    }

    // Load current trainers.
    $oldtrainers = zingilt_get_trainers($sessionid);

   // $transaction = $DB->start_delegated_transaction();

    // Loop through form data and add any new trainers.
    foreach ($form as $roleid => $trainers) {

        // Loop through trainers in this role.
        foreach ($trainers as $trainer) {

            if (!$trainer) {
                continue;
            }

            // If the trainer doesn't exist already, create it.
            if (!isset($oldtrainers[$roleid][$trainer])) {

                $newtrainer = new stdClass();
                $newtrainer->userid = $trainer;
                $newtrainer->roleid = $roleid;
                $newtrainer->sessionid = $sessionid;

                if (!$DB->insert_record('zingilt_session_roles', $newtrainer)) {
                    print_error('error:couldnotaddtrainer', 'zingilt');
                  //  $transaction->force_transaction_rollback();

                    return false;
                }
            } else {
                unset($oldtrainers[$roleid][$trainer]);
            }
        }
    }

    // Loop through what is left of old trainers, and remove (as they have been deselected).
    if ($oldtrainers) {
        foreach ($oldtrainers as $roleid => $trainers) {

            // If no trainers left.
            if (empty($trainers)) {
                continue;
            }

            // Delete any remaining trainers.
            foreach ($trainers as $trainer) {
                $sql = "Delete from {zingilt_session_roles} where sessionid = ".$sessionid." and roleid = ".$roleid." and userid = ".$trainer->id;
             $DB->execute($sql);
                /*if (!$DB->delete_records('zingilt_session_roles', array('sessionid' => $sessionid, 'roleid' => $roleid, 'userid' => $trainer->id))) {
                    print_error('error:couldnotdeletetrainer', 'zingilt');
                   // $transaction->force_transaction_rollback();
                    return false;
                }*/
            }
        }
    }

 //   $transaction->allow_commit();

    return true;
}
/**
 * Return array of trainer roles configured for zing ILT
 *
 * @return array
 */
function zingilt_get_trainer_roles()
{
    global $CFG, $DB;

    // Check that roles have been selected.
    if (empty($CFG->zingilt_session_roles)) {
        return false;
    }

    // Parse roles.
    $cleanroles = clean_param($CFG->zingilt_session_roles, PARAM_SEQUENCE);
    $roles = explode(',', $cleanroles);
    list($rolesql, $params) = $DB->get_in_or_equal($roles);

    // Load role names.
    $rolenames = $DB->get_records_sql("
        SELECT
            r.id,
            r.name
        FROM
            {role} r
        WHERE
            r.id {$rolesql}
        AND r.id <> 0
    ", $params);

    // Return roles and names.
    if (!$rolenames) {
        return array();
    }

    return $rolenames;
}


/**
 * Get all trainers associated with a session, optionally
 * restricted to a certain roleid
 *
 * If a roleid is not specified, will return a multi-dimensional
 * array keyed by roleids, with an array of the chosen roles
 * for each role
 *
 * @param  integer $sessionid
 * @param  integer $roleid (optional)
 * @return array
 */
function zingilt_get_trainers($sessionid, $roleid = null)
{
    global $CFG, $DB;

    $usernamefields = get_all_user_name_fields(true, 'u');
    $sql = "
        SELECT
            u.id,
            r.roleid,
            {$usernamefields}
        FROM
            {zingilt_session_roles} r
        LEFT JOIN
            {user} u
         ON u.id = r.userid
        WHERE
            r.sessionid = ?
        ";
    $params = array($sessionid);

    if ($roleid) {
        $sql .= "AND r.roleid = ?";
        $params[] = $roleid;
    }

    $rs = $DB->get_recordset_sql($sql, $params);
    $return = array();
    foreach ($rs as $record) {

        // Create new array for this role.
        if (!isset($return[$record->roleid])) {
            $return[$record->roleid] = array();
        }
        $return[$record->roleid][$record->id] = $record;
    }
    $rs->close();

    // If we are only after one roleid.
    if ($roleid) {
        if (empty($return[$roleid])) {
            return false;
        }
        return $return[$roleid];
    }

    // If we are after all roles.
    if (empty($return)) {
        return false;
    }

    return $return;
}

/**
 * Determines whether an activity requires the user to have a manager (either for
 * manager approval or to send notices to the manager)
 *
 * @param  object $zingilt A database fieldset object for the zingilt activity
 * @return boolean whether a person needs a manager to sign up for that activity
 */
function zingilt_manager_needed($zingilt)
{
    return $zingilt->approvalreqd
        || $zingilt->confirmationinstrmngr
        || $zingilt->reminderinstrmngr
        || $zingilt->cancellationinstrmngr;
}

/**
 * Display the list of site notices in the site-wide settings page
 */
function zingilt_list_of_sitenotices()
{
    global $CFG, $USER, $DB, $OUTPUT;

    if ($notices = $DB->get_records('zingilt_notice', array(), 'name', 'id, name')) {
        $table = new html_table();
        $table->width = '50%';
        $table->tablealign = 'left';
        $table->data = array();
        $table->size = array('100%');
        foreach ($notices as $notice) {
            $noticename = format_string($notice->name);
            $editurl = new moodle_url('/mod/zingilt/sitenotice.php', array('id' => $notice->id));
            $editlink = $OUTPUT->action_icon($editurl, new pix_icon('t/edit', get_string('edit')));
            $deleteurl = new moodle_url('/mod/zingilt/sitenotice.php', array('id' => $notice->id, 'd' => '1', 'sesskey' => $USER->sesskey));
            $deletelink = $OUTPUT->action_icon($deleteurl, new pix_icon('t/delete', get_string('delete')));
            $table->data[] = array($noticename, $editlink, $deletelink);
        }
        return html_writer::table($table, true);
    }

    return get_string('nositenotices', 'zingilt');
}

/**
 * Add formslib fields for all custom fields defined site-wide.
 * (used by the session add/edit page and the site notices)
 */
function zingilt_add_customfields_to_form(&$mform, $customfields, $alloptional = false)
{
    foreach ($customfields as $field) {
        $fieldname = "custom_$field->shortname";

        $options = array();
        if (!$field->required) {
            $options[''] = get_string('none');
        }
        foreach (explode(ZILT_CUSTOMFIELD_DELIMITER, $field->possiblevalues) as $value) {
            $v = trim($value);
            if (!empty($v)) {
                $options[$v] = $v;
            }
        }

        switch ($field->type) {
            case ZILT_CUSTOMFIELD_TYPE_TEXT:
                $mform->addElement('text', $fieldname, $field->name);
                break;
            case ZILT_CUSTOMFIELD_TYPE_SELECT:
                $mform->addElement('select', $fieldname, $field->name, $options);
                break;
            case ZILT_CUSTOMFIELD_TYPE_MULTISELECT:
                $select = &$mform->addElement('select', $fieldname, $field->name, $options);
                $select->setMultiple(true);
                break;
            default:
                // error_log("zingilt: invalid field type for custom field ID $field->id");
                continue 2;
        }

        $mform->setType($fieldname, PARAM_TEXT);
        $mform->setDefault($fieldname, $field->defaultvalue);
        if ($field->required and !$alloptional) {
            $mform->addRule($fieldname, null, 'required', null, 'client');
        }
    }
}

/**
 * Get session cancellations
 *
 * @access  public
 * @param   integer $sessionid
 * @return  array
 */
function zingilt_get_cancellations($sessionid)
{
    global $CFG, $DB;

    $fullname = $DB->sql_fullname('u.firstname', 'u.lastname');
    $usernamefields = get_all_user_name_fields(true, 'u');
    $instatus = array(MDL_ZILT_STATUS_BOOKED, MDL_ZILT_STATUS_WAITLISTED, MDL_ZILT_STATUS_REQUESTED);
    list($insql, $inparams) = $DB->get_in_or_equal($instatus);

    // Nasty SQL follows:
    // Load currently cancelled users, include most recent booked/waitlisted time also.
    $sql = "
            SELECT
                u.id,
                {$usernamefields},
                su.id AS signupid,
                MAX(ss.timecreated) AS timesignedup,
                c.timecreated AS timecancelled,
                " . $DB->sql_compare_text('c.note', 250) . " AS cancelreason
            FROM
                {zingilt_signups} su
            JOIN
                {user} u
             ON u.id = su.userid
            JOIN
                {zingilt_signups_status} c
             ON su.id = c.signupid
            AND c.statuscode = ?
            AND c.superceded = 0
            LEFT JOIN
                {zingilt_signups_status} ss
             ON su.id = ss.signupid
             AND ss.statuscode $insql
            AND ss.superceded = 1
            WHERE
                su.sessionid = ?
            GROUP BY
                u.id, su.id,
                {$usernamefields},
                c.timecreated,
                " . $DB->sql_compare_text('c.note', 250) . "
            ORDER BY
                {$fullname},
                c.timecreated
    ";
    $params = array_merge(array(MDL_ZILT_STATUS_USER_CANCELLED), $inparams);
    $params[] = $sessionid;
    return $DB->get_records_sql($sql, $params);
}


/**
 * Get session unapproved requests
 *
 * @access  public
 * @param   integer $sessionid
 * @return  array
 */
function zingilt_get_requests($sessionid)
{
    global $CFG, $DB;

    $fullname = $DB->sql_fullname('u.firstname', 'u.lastname');
    $usernamefields = get_all_user_name_fields(true);

    $params = array($sessionid, MDL_ZILT_STATUS_REQUESTED);

    $sql = "SELECT u.id, su.id AS signupid, {$usernamefields},
                   ss.timecreated AS timerequested
              FROM {zingilt_signups} su
              JOIN {zingilt_signups_status} ss ON su.id=ss.signupid
              JOIN {user} u ON u.id = su.userid
             WHERE su.sessionid = ? AND ss.superceded != 1 AND ss.statuscode = ?
          ORDER BY $fullname, ss.timecreated";

    return $DB->get_records_sql($sql, $params);
}


/**
 * Get session declined requests
 *
 * @access  public
 * @param   integer $sessionid
 * @return  array
 */
function zingilt_get_declines($sessionid)
{
    global $CFG, $DB;

    $fullname = $DB->sql_fullname('u.firstname', 'u.lastname');
    $usernamefields = get_all_user_name_fields(true);

    $params = array($sessionid, MDL_ZILT_STATUS_DECLINED);

    $sql = "SELECT u.id, su.id AS signupid, {$usernamefields},
                   ss.timecreated AS timerequested
              FROM {zingilt_signups} su
              JOIN {zingilt_signups_status} ss ON su.id=ss.signupid
              JOIN {user} u ON u.id = su.userid
             WHERE su.sessionid = ? AND ss.superceded != 1 AND ss.statuscode = ?
          ORDER BY $fullname, ss.timecreated";
    return $DB->get_records_sql($sql, $params);
}


/**
 * Returns all other caps used in module
 * @return array
 */
function zingilt_get_extra_capabilities()
{
    return array('moodle/site:viewfullnames');
}


/**
 * @param string $feature FEATURE_xx constant for requested feature
 * @return mixed True if module supports feature, null if doesn't know
 */
function zingilt_supports($feature)
{
    switch ($feature) {
        case FEATURE_BACKUP_MOODLE2:
            return true;
        case FEATURE_GRADE_HAS_GRADE:
            return true;
        case FEATURE_COMPLETION_TRACKS_VIEWS:
            return true;
        default:
            return null;
    }
}

/*
 * zingilt assignment candidates
 */
class zingilt_candidate_selector extends user_selector_base
{
    protected $sessionid;

    public function __construct($name, $options)
    {
        $this->sessionid = $options['sessionid'];
        parent::__construct($name, $options);
    }

    /*
     * Candidate users
     * @param <type> $search
     * @return array
     */
    public function find_users($search)
    {
        global $DB;

        // All non-signed up system user.
        list($wherecondition, $params) = $this->search_sql($search, 'u');

        $fields      = 'SELECT ' . $this->required_fields_sql('u');
        $countfields = 'SELECT COUNT(u.id)';
        $sql = "
                  FROM {user} u
                 WHERE $wherecondition
                   AND u.id NOT IN
                       (
                       SELECT u2.id
                         FROM {zingilt_signups} s
                         JOIN {zingilt_signups_status} ss ON s.id = ss.signupid
                         JOIN {user} u2 ON u2.id = s.userid
                        WHERE s.sessionid = :sessid
                          AND ss.statuscode >= :statuswaitlisted
                          AND ss.superceded = 0
                       )
               ";
        $order = " ORDER BY u.lastname ASC, u.firstname ASC";
        $params = array_merge(
            $params,
            array(
                'sessid' => $this->sessionid,
                'statuswaitlisted' => MDL_ZILT_STATUS_WAITLISTED
            )
        );

        if (!$this->is_validating()) {
            $potentialmemberscount = $DB->count_records_sql($countfields . $sql, $params);
            if ($potentialmemberscount > 100) {
                return $this->too_many_results($search, $potentialmemberscount);
            }
        }

        $availableusers = $DB->get_records_sql($fields . $sql . $order, $params);

        if (empty($availableusers)) {
            return array();
        }

        $groupname = get_string('potentialusers', 'role', count($availableusers));

        return array($groupname => $availableusers);
    }

    protected function get_options()
    {
        $options = parent::get_options();
        $options['sessionid'] = $this->sessionid;
        $options['file'] = 'mod/zingilt/lib.php';
        return $options;
    }
}

/**
 * zingilt assignment candidates
 */
class zingilt_existing_selector extends user_selector_base
{
    protected $sessionid;

    public function __construct($name, $options)
    {
        $this->sessionid = $options['sessionid'];
        parent::__construct($name, $options);
    }

    /**
     * Candidate users
     * @param <type> $search
     * @return array
     */
    public function find_users($search)
    {
        global $DB;

        // By default wherecondition retrieves all users except the deleted, not confirmed and guest.
        list($wherecondition, $whereparams) = $this->search_sql($search, 'u');

        $fields  = 'SELECT ' . $this->required_fields_sql('u');
        $fields .= ', su.id AS submissionid, s.discountcost, su.discountcode, su.notificationtype, f.id AS zingiltid,
            f.course, ss.grade, ss.statuscode, sign.timecreated';
        $countfields = 'SELECT COUNT(1)';
        $sql = "
            FROM
                {zingilt} f
            JOIN
                {zingilt_sessions} s
             ON s.zingilt = f.id
            JOIN
                {zingilt_signups} su
             ON s.id = su.sessionid
            JOIN
                {zingilt_signups_status} ss
             ON su.id = ss.signupid
            LEFT JOIN
                (
                SELECT
                    ss.signupid,
                    MAX(ss.timecreated) AS timecreated
                FROM
                    {zingilt_signups_status} ss
                INNER JOIN
                    {zingilt_signups} s
                 ON s.id = ss.signupid
                AND s.sessionid = :sessid1
                WHERE
                    ss.statuscode IN (:statusbooked, :statuswaitlisted)
                GROUP BY
                    ss.signupid
                ) sign
             ON su.id = sign.signupid
            JOIN
                {user} u
             ON u.id = su.userid
            WHERE
                $wherecondition
            AND s.id = :sessid2
            AND ss.superceded != 1
            AND ss.statuscode >= :statusapproved
        ";
        $order = " ORDER BY sign.timecreated ASC, ss.timecreated ASC";
        $params = array('sessid1' => $this->sessionid, 'statusbooked' => MDL_ZILT_STATUS_BOOKED, 'statuswaitlisted' => MDL_ZILT_STATUS_WAITLISTED);
        $params = array_merge($params, $whereparams);
        $params['sessid2'] = $this->sessionid;
        $params['statusapproved'] = MDL_ZILT_STATUS_APPROVED;
        if (!$this->is_validating()) {
            $potentialmemberscount = $DB->count_records_sql($countfields . $sql, $params);
            if ($potentialmemberscount > 100) {
                return $this->too_many_results($search, $potentialmemberscount);
            }
        }

        $availableusers = $DB->get_records_sql($fields . $sql . $order, $params);
        if (empty($availableusers)) {
            return array();
        }

        $groupname = get_string('existingusers', 'role', count($availableusers));
        return array($groupname => $availableusers);
    }

    protected function get_options()
    {
        $options = parent::get_options();
        $options['sessionid'] = $this->sessionid;
        $options['file'] = 'mod/zingilt/lib.php';
        return $options;
    }
}
