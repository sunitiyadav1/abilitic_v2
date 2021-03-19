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
 * Mobile output functions.
 *
 * @package mod_oucontent
 * @copyright 2018 The Open University
 * @license http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

namespace block_progress\output;

defined('MOODLE_INTERNAL') || die();
//require_once dirname(__FILE__) . '/../../../../config.php';
require_once dirname(__FILE__) . '../../../lib.php';
/**
 * Mobile output functions.
 */
class mobile
{
    //
    public static function mobile_block_myprogress_view($args)
    {
        global $OUTPUT, $USER, $CFG;

        $args = (object) $args;
        //$cm = get_coursemodule_from_id('certificate', $args->cmid);
        $userdata = getUserQueryData($USER->id, 'SELF');
        $udata = pivotstructureData($userdata, $USER->id);


        $data =  ['issues' => $udata[$USER->id]->courses];
        return [
            'templates' => [
                [
                    'id' => 'mainview',
                    'html' => $OUTPUT->render_from_template('block_progress/mobile_block_myprogress_view', $data),
                ],
            ],
            'javascript' => file_get_contents($CFG->dirroot . '/lib/amd/src/chartjs.js'),
            // 'javascript' => '',
            'otherdata' => [],
            'files' => []
        ];
    }
    public static function mobile_block_teamprogress_view($args)
    {
        global $OUTPUT, $USER, $CFG;

        $args = (object) $args;
        //$cm = get_coursemodule_from_id('certificate', $args->cmid);
        $userdata = getUserQueryData($USER->id, 'TEAM');
        $udata = teampivotstructureData($userdata, $USER->id);

        $data =  ['team' => $udata];
        return [
            'templates' => [
                [
                    'id' => 'teamview',
                    'html' => $OUTPUT->render_from_template('block_progress/mobile_block_teamprogress_view', $data),
                ],
            ],
            'javascript' => file_get_contents($CFG->dirroot . '/lib/amd/src/chartjs.js'),
            // 'javascript' => '',
            'otherdata' => [],
            'files' => []
        ];
    }
    /**
     * Returns the SC document view page for the mobile app.
     *
     * @param array $args Arguments from tool_mobile_get_content WS
     * @return array HTML, javascript and otherdata
     */
    public static function mobile_block_myprogress(array $args): array
    {
        global $USER, $OUTPUT, $CFG;
        //my progress function
        $userdata = getUserQueryData($USER->id, 'SELF');
        $courseData = myProgressCourseCompletionData($userdata);
        //Team Progress function 
        $userdata = getUserQueryData($USER->id, 'TEAM');
        $udata = teamCourseCompletionData($userdata);

        // $data = [ 'random' => mt_rand(0, 100) ];
        $data = [ //'completed' => $courseData->summaryData->completionPercentage,
            //'notcompleted' => $courseData->summaryData->nonCompletionPercentage,
            'userid' => $USER->id,
            'siteadmin' => is_siteadmin($USER->id),
            //'teamcompleted' => $udata->summaryData->completionPercentage,
            //'teamnotcompleted' =>$udata->summaryData->nonCompletionPercentage,
            'myprogress' => $courseData->summaryData,
            'teamprogress' => $udata->summaryData
        ];
        /*$data['teamprogress'] = [ 'completed' => $udata->summaryData->completionPercentage,
                  'notcompleted' => $udata->summaryData->nonCompletionPercentage,
                 ];*/
        return [
            'templates' => [
                [
                    'id' => 'main',
                    'html' => $OUTPUT->render_from_template('block_progress/mobile_block_myprogress', $data),
                ],
            ],
            'javascript' => file_get_contents($CFG->dirroot . '/blocks/progress/js/progress_init.js'),
            // 'javascript' => '',
            'otherdata' => [],
            'files' => []
        ];
    }
}
