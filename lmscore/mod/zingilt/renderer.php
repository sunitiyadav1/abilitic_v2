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

class mod_zingilt_renderer extends plugin_renderer_base
{

    /**
     * Builds session list table given an array of sessions
     */
    public function print_session_list_table($customfields, $sessions, $viewattendees, $editsessions)
    {
        $output = '';

        $tableheader = array();
        foreach ($customfields as $field) {
            if (!empty($field->showinsummary)) {
                $tableheader[] = format_string($field->name);
            }
        }
        $tableheader[] = get_string('session_name', 'zingilt');
        $tableheader[] = get_string('date', 'zingilt');
        $tableheader[] = get_string('time', 'zingilt');
        if ($viewattendees) {
            $tableheader[] = get_string('capacity', 'zingilt');
        } else {
            $tableheader[] = get_string('seatsavailable', 'zingilt');
        }
        $tableheader[] = get_string('status', 'zingilt');
        $tableheader[] = get_string('options', 'zingilt');

        $timenow = time();

        $table = new html_table();
        $table->summary = get_string('previoussessionslist', 'zingilt');
        $table->head = $tableheader;
        $table->data = array();

        foreach ($sessions as $session) {
            $isbookedsession = false;
            $bookedsession = $session->bookedsession;
            $sessionstarted = false;
            $sessionfull = false;

            $sessionrow = array();

            // Custom fields.
            $customdata = $session->customfielddata;
            foreach ($customfields as $field) {
                if (empty($field->showinsummary)) {
                    continue;
                }

                if (empty($customdata[$field->id])) {
                    $sessionrow[] = '&nbsp;';
                } else {
                    if (ZILT_CUSTOMFIELD_TYPE_MULTISELECT == $field->type) {
                        $sessionrow[] = str_replace(ZILT_CUSTOMFIELD_DELIMITER, html_writer::empty_tag('br'), format_string($customdata[$field->id]->data));
                    } else {
                        $sessionrow[] = format_string($customdata[$field->id]->data);
                    }
                }
            }
            $sessionrow[] = !empty($session->name) ? $session->name : "-";
            // Dates/times.
            $allsessiondates = '';
            $allsessiontimes = '';
            if ($session->datetimeknown) {
                foreach ($session->sessiondates as $date) {
                    if (!empty($allsessiondates)) {
                        $allsessiondates .= html_writer::empty_tag('br');
                    }
                    $allsessiondates .= userdate($date->timestart, get_string('strftimedate'));
                    if (!empty($allsessiontimes)) {
                        $allsessiontimes .= html_writer::empty_tag('br');
                    }
                    $allsessiontimes .= userdate($date->timestart, get_string('strftimetime')) .
                        ' - ' . userdate($date->timefinish, get_string('strftimetime'));
                }
            } else {
                $allsessiondates = get_string('wait-listed', 'zingilt');
                $allsessiontimes = get_string('wait-listed', 'zingilt');
                $sessionwaitlisted = true;
            }
            $sessionrow[] = $allsessiondates;
            $sessionrow[] = $allsessiontimes;

            // Capacity.
            $signupcount = zingilt_get_num_attendees($session->id, MDL_ZILT_STATUS_APPROVED);
            $stats = $session->capacity - $signupcount;
            if ($viewattendees) {
                $stats = $signupcount . ' / ' . $session->capacity;
            } else {
                $stats = max(0, $stats);
            }
            $sessionrow[] = $stats;

            // Status.
            $status  = get_string('bookingopen', 'zingilt');
            if ($session->datetimeknown && zingilt_has_session_started($session, $timenow) && zingilt_is_session_in_progress($session, $timenow)) {
                $status = get_string('sessioninprogress', 'zingilt');
                $sessionstarted = true;
            } else if ($session->datetimeknown && zingilt_has_session_started($session, $timenow)) {
                $status = get_string('sessionover', 'zingilt');
                $sessionstarted = true;
            } else if ($bookedsession && $session->id == $bookedsession->sessionid) {
                $signupstatus = zingilt_get_status($bookedsession->statuscode);
                $status = get_string('status_' . $signupstatus, 'zingilt');
                $isbookedsession = true;
            } else if ($signupcount >= $session->capacity) {
                $status = get_string('bookingfull', 'zingilt');
                $sessionfull = true;
            }

            $sessionrow[] = $status;

            // Options.
            $options = '';
            if ($editsessions) {
                $options .= $this->output->action_icon(
                    new moodle_url('sessions.php', array('s' => $session->id)),
                    new pix_icon('t/edit', get_string('edit', 'zingilt')),
                    null,
                    array('title' => get_string('editsession', 'zingilt'))
                ) . ' ';
                $options .= $this->output->action_icon(
                    new moodle_url('sessions.php', array('s' => $session->id, 'c' => 1)),
                    new pix_icon('t/copy', get_string('copy', 'zingilt')),
                    null,
                    array('title' => get_string('copysession', 'zingilt'))
                ) . ' ';
                $options .= $this->output->action_icon(
                    new moodle_url('sessions.php', array('s' => $session->id, 'd' => 1)),
                    new pix_icon('t/delete', get_string('delete', 'zingilt')),
                    null,
                    array('title' => get_string('deletesession', 'zingilt'))
                ) . ' ';
                $options .= html_writer::empty_tag('br');
            }
            if ($viewattendees) {
                $options .= html_writer::link(
                    'attendees.php?s=' . $session->id . '&backtoallsessions=' . $session->zingilt,
                    get_string('attendees', 'zingilt'),
                    array('title' => get_string('seeattendees', 'zingilt'))
                ) . html_writer::empty_tag('br');

                //added by Kajal C Tailor for Enrol user link
                if (!$sessionstarted){
                    $options .= html_writer::link('./cohort/attribute/add_cohort.php?s='.$session->id.'&backtoallsessions='.$session->zingilt,
                            get_string('enrol_user', 'zingilt'),
                            array('title' => get_string('add_cohort', 'zingilt'))) . html_writer::empty_tag('br');
                }           
            }
            
            // Suniti Yadav - As there is no self signup flow in AISATS, only manager can enroll.
            /*if ($isbookedsession) {
                $options .= html_writer::link(
                    'signup.php?s=' . $session->id . '&backtoallsessions=' . $session->zingilt,
                    get_string('moreinfo', 'zingilt'),
                    array('title' => get_string('moreinfo', 'zingilt'))
                ) . html_writer::empty_tag('br');
                if ($session->allowcancellations) {
                    $options .= html_writer::link(
                        'cancelsignup.php?s=' . $session->id . '&backtoallsessions=' . $session->zingilt,
                        get_string('cancelbooking', 'zingilt'),
                        array('title' => get_string('cancelbooking', 'zingilt'))
                    );
                }
            } else if (!$sessionstarted and !$bookedsession) {
                $options .= html_writer::link(
                    'signup.php?s=' . $session->id . '&backtoallsessions=' . $session->zingilt,
                    get_string('signup', 'zingilt')
                );
            }
            if (empty($options)) {
                $options = get_string('none', 'zingilt');
            }
            */
            $sessionrow[] = $options;

            $row = new html_table_row($sessionrow);

            // Set the CSS class for the row.
            if ($sessionstarted) {
                $row->attributes = array('class' => 'dimmed_text');
            } else if ($isbookedsession) {
                $row->attributes = array('class' => 'highlight');
            } else if ($sessionfull) {
                $row->attributes = array('class' => 'dimmed_text');
            }

            // Add row to table.
            $table->data[] = $row;
        }

        $output .= html_writer::table($table);

        return $output;
    }
}
