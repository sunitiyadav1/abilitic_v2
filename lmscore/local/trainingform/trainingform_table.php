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
require_once("lib.php");
global $DB;
$block = 'local_trainingform';
$baseurl = new moodle_url(basename(__FILE__), array());
$returnurl = $baseurl;
// Get the SYSTEM context.
$context = context_system::instance();
require_login(null, false); // Adds to $PAGE, creates $OUTPUT.
// Correct the navbar.
// Set the name for the page.
$linktext = get_string('trainingform', $block);
// Set the url.
$linkurl = new moodle_url('/local/trainingform/index.php');
// Print the page header.
$PAGE->set_context($context);
$PAGE->set_url($linkurl);
$PAGE->set_pagelayout('admin');
$PAGE->set_title($linktext);
// Set the page heading.
$PAGE->set_heading($linktext . " - " . get_string('trainingform_report', 'local_trainingform'));
$PAGE->navbar->add($linktext, $linkurl);
$PAGE->navbar->add(get_string('trainingform_report', 'local_trainingform'));
$PAGE->requires->jquery();

//if (has_capability('local/trainingform:manage', context_system::instance(), $USER->id)) {
if (is_siteadmin()) {
    echo $OUTPUT->header();
    $link = new moodle_url('/local/trainingform/index.php');
    echo '<a class="btn btn-primary" href="' . $link . '">Add New TrainingForm Data</a><Br><BR>';
    echo "<div id='table_msg' class='alert alert-danger' style='display:none;'></div>";
    echo '<link href="' . $CFG->wwwroot . '/local/trainingform/scripts/jquery-datatable/jquery.dataTables.min.css" rel="stylesheet" />
    <script src="' . $CFG->wwwroot . '/local/trainingform/scripts/jquery-datatable/jquery.dataTables.min.js"></script>
    <script src="' . $CFG->wwwroot . '/local/trainingform/scripts/js/table.js"></script>';
    echo "<div id='table_div'>";
    //echo getTrainingFormList();
   
    echo '<table id="tbltraining" >
    <thead>
        <tr>
            <th>ID</th>
           
            <th>User Count</th>
            <th>Start Date</th>
            <th>End date</th>
            <th>Docment Submitted?</th>
            <th>Submitted On</th>
            <th>Action</th>
        </tr>
    </thead>
    <!--- <tfoot>
        <tr>
        <th>ID</th>
        <th>Form Type</th>
        <th>User Count</th>
        <th>Start Date</th>
        <th>End date</th>
        <th>Docment Submitted?</th>
        <th>Submitted On</th>
        <th>Action</th>
        </tr>
    </tfoot>-->
</table>';
 echo "</div>";
    echo '    <!-- Modal -->
<div id="deleteModal" role="dialog" class="modal fade">
   <div class="modal-dialog modal-lg">
        <div class="modal-content" >
            <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title" id="formtitle"><B>Delete Training Form</B></h4>                
            </div>
                <div class="modal-body" >
                    <p><B >Do you really want to delete this Training Form?</B></p>
                    <input type="hidden" id="deleteid" name="deleteid" value="">
                </div>
                <div class="modal-footer">               
                    <button type="button" class="btn btn-default" id="btnyes">Yes</button>     
                    <button type="button" class="btn btn-default" data-dismiss="modal">No</button>
                </div>
        </div>
    </div>
</div>';
    echo '    <!-- Modal -->
<div id="viewdetailModal" role="dialog" class="modal fade">
    <div class="modal-dialog modal-lg">
        <div class="modal-content" id="res_model_form">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title" id="formtitle"><B>View Detail</B></h4>                
            </div>
                <div class="modal-body" id="detail_div" style="margin-left:10px;overflow-y: scroll;max-height:400px;padding-left: 30px;">
                    <div id ="loader_div"><img src="scripts/jquery-modal/images/LoaderIcon.gif" id="loaderimg"/> </div>
                    <div id ="cert_div" style="display:none"><img id="cert_image" ></div>                   
                    <div id ="viewdetail_div" style="display:none;"></div>
                </div>
                <div class="modal-footer">                    
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                </div>
        </div>
    </div>
</div>


<link href="' . $CFG->wwwroot . '/local/trainingform/scripts/jquery-datatable/jquery.dataTables.min.css" rel="stylesheet" />
    <script src="' . $CFG->wwwroot . '/local/trainingform/scripts/jquery-datatable/jquery.dataTables.min.js"></script>
    <script src="' . $CFG->wwwroot . '/local/trainingform/scripts/js/table.js"></script>
';
    $link = new moodle_url('/my');
    echo '<a class="btn btn-primary" href="' . $link . '">' . get_string('todashboard', 'local_trainingform') . '</a>';
    echo $OUTPUT->footer();
} else {
    redirect($link, get_string('noaccesscapabilitymsg', 'local_trainingform'), null, \core\output\notification::NOTIFY_ERROR);
}
