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
 * This block allows the user to give the course a rating, which
 * is displayed in a custom table (<prefix>_block_external_courses).
 *
 * @package    block
 * 
 * @copyright  2020 Kajal Tailor
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 *
 * Code was Rewritten for Moodle 2.X By Atar + Plus LTD for Comverse LTD.
 * @copyright &copy; 2011 Comverse LTD.
 * @license http://www.gnu.org/copyleft/gpl.html GNU Public License
 */

use core_completion\progress;

class block_progress extends block_base
{

    public function init()
    {
        $this->title = get_string('pluginname', 'block_progress');
    }

    public function instance_allow_multiple()
    {
        return true;
    }

    public function has_config()
    {
        return false;
    }

    public function instance_allow_config()
    {
        return true;
    }

    public function applicable_formats()
    {
        return array(
            'admin' => false,
            'site-index' => true,
            'course-view' => true,
            'mod' => false,
            'my' => true,
        );
    }

    public function specialization()
    {
        if (empty($this->config->title)) {
            $this->title = ''; //get_string('progress', 'block_progress');
        } else {
            $this->title = $this->config->title;
        }
    }

    public function get_content()
    {
        global $CFG, $PAGE;
        $PAGE->requires->jquery();
        // $PAGE->requires->jquery_plugin('ui');
        if ($this->content !== null) {
            return $this->content;
        }
        $this->content = new stdClass();
        $this->content->text = '';
        $this->content->text .= ' <link rel="stylesheet" href="' . $CFG->wwwroot . '/blocks/progress/css/chart.css">
        <link rel="stylesheet" href="' . $CFG->wwwroot . '/blocks/progress/css/block.css">
        
        ';
        //'.(!is_siteadmin()?"fixcolumn":"column").'
        $this->content->text .= '<div class="row"><div class="fixcolumn"><div class="card">';
        $this->content->text .= '<div id="progress_dataviz"></div>
                                <div id="progress_div1">';
        for ($i = 0; $i < 6; $i++) {
            //for loader content for My Progress Block 
            $this->content->text .= '<div class="d-flex flex-row align-items-center" style="height: 32px">
                                            <div class="bg-pulse-grey rounded-circle" style="height: 32px; width:32px;">
                                            </div>
                                            <div style="flex:1" class="pl-2">
                                                <div class="bg-pulse-grey w-100" style="height: 15px;"></div>
                                                <div class="bg-pulse-grey w-75 mt-1" style="height: 10px;"></div>
                                            </div>
                                        </div>';
        }
        $this->content->text .= '</div>
                                    </div>
                                </div>';
if(is_siteadmin()){}else{
        $this->content->text .= '<div class="fixcolumn">
                                    <div class="card">
                                    <div id="team_progress_div1">';
        for ($i = 0; $i < 6; $i++) {
            //for loader content for Team Progress Block
            $this->content->text .= '<div class="d-flex flex-row align-items-center" style="height: 32px">
                            <div class="bg-pulse-grey rounded-circle" style="height: 32px; width:32px;">
                            </div>
                            <div style="flex:1" class="pl-2">
                                <div class="bg-pulse-grey w-100" style="height: 15px;"></div>
                                <div class="bg-pulse-grey w-75 mt-1" style="height: 10px;"></div>
                            </div>
                        </div>';
        }
        $this->content->text .= '</div>';
        $this->content->text .= '<!-- Create a div where the graph will take place -->
            <div id="team_progress_dataviz"></div>            
    </div>
  </div>';
}
        $this->content->text .= '</div>';

        //Details My progress view starts here ...
        $this->content->text .= '
        <input type ="hidden" name="pdetail_json" id="pdetail_json" value="">
      
      <div class="col-md-12" id="progress_details" style ="display:none;">
        <table class="table">
            <tr>
                <td>' . get_string('all_sub_courses', 'block_progress') . '</td>
                <td id= "myprogress-totalcourses">  {{totalcourses}} </td>
                <td>' . get_string('all_sub_completed_courses', 'block_progress') . '</td>
                <td id="myprogress-completedcourses">  {{completedcourses}}</td>
            </tr>
            <tr>
                <td>' . get_string('all_sub_activities', 'block_progress') . '</td>
                <td id="myprogress-total-activities">  {{totalactivities}}  </td>
                <td>' . get_string('all_sub_completed_activities', 'block_progress') . '</td>
                <td id="myprogress-completed-activities">  {{completedactivities}}  </td>
            </tr>
        </table>     
        <div class ="row no-gutter col-md-12" id ="my_progress_courses"></div>           
        </div>      
        ';


        //Details My Team progress view starts here ...
        $this->content->text .= '
        <input type ="hidden" name="pteamdetail_json" id="pteamdetail_json" value="">
        <div class="col-md-12" id="team_progress_details"  style ="display:none;">
        <table class="table">
        <tr>
            <td>' . get_string('all_sub_courses', 'block_progress') . '</td>
            <td id= "teamprogress-totalcourses">  {{totalcourses}} </td>
            <td>' . get_string('all_sub_completed_courses', 'block_progress') . '</td>
            <td id="teamprogress-completedcourses">  {{completedcourses}}</td>
        </tr>
        <tr>
            <td>' . get_string('all_sub_activities', 'block_progress') . '</td>
            <td id="teamprogress-total-activities">  {{totalactivities}}  </td>
            <td>' . get_string('all_sub_completed_activities', 'block_progress') . '</td>
            <td id="teamprogress-completed-activities">  {{completedactivities}}  </td>
        </tr>
    </table>  
    <div class ="row no-gutter col-md-12" id ="team_progress_users"></div>         
        </div>';

        $this->content->text .= '<script src="' . $CFG->wwwroot . '/blocks/progress/js/jquery.min.js"></script>
                                <script src="' . $CFG->wwwroot . '/blocks/progress/js/d3/d3.min.js"></script>
                                <script src="' . $CFG->wwwroot . '/blocks/progress/js/DataHelper.js"></script>                                 
                                <script src="' . $CFG->wwwroot . '/blocks/progress/js/showcontentnew.js"></script> 
                                <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=DM+Mono:ital,wght@0,300;1,300">
                                <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Teko:wght@300">
                                
                                ';
        return $this->content;
    }
}
