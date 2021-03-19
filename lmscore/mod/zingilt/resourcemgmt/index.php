<?php
require_once('../../../config.php');
//global $CFG; echo "<pre>";print_r($CFG);die;
require_login(); // We need login
global $CFG, $USER;
require "$CFG->libdir/tablelib.php";
$context = context_system::instance();
$PAGE->set_context($context);
// Set the name for the page.
$pluginname = 'mod_zingilt';
$linktext = get_string('myresources', $pluginname);
// Set the url.
$linkurl = new moodle_url('/mod/zingilt/resourcemgmt/index.php');
// Print the page header.
$PAGE->set_context($context);
$PAGE->set_url($linkurl);
$PAGE->set_pagelayout('admin');
$PAGE->set_title($linktext);
// Set the page heading.
$PAGE->set_heading(get_string('myhome') . " - $linktext");
//$PAGE->navbar->add(get_string('dashboard', 'local_resources'));
$PAGE->navbar->add($linktext, $linkurl);
function rand_color()
{
    return sprintf('#%06X', mt_rand(0, 0xFFFFFF));
}
echo $OUTPUT->header();
?>
<html>
<?php require_once('includes/default_structure.php'); ?>
<?php //require_once("../../user/lib.php"); ?>
<body>
    <?php require_once("includes/menubar.php"); ?>
    <?php
    //create_user_record( 'testuser2','Test@123' );
    // echo "user created";
   /* $user = new stdClass;
    $user->firstname = "kajal";
    $user->lastname = "Tailor";
    $user->email = "kajaltailor@gmail.com";
    $user->username = "kajaltailor@gmail.com";

    echo user_create_user($user);
    echo "user created";*/
    ?>
    <div id="showMessage" class="alert" style="display: none;"></div>
    <button id="btnaddresource" class="btn btn-primary"><?php echo  get_string('resources_add', 'mod_zingilt') ?></button><BR><BR>
    <!-- Modal -->
    <div id="resourceFormDialog" role="dialog" class="modal fade">
        <div class="modal-dialog modal-lg">
            <div class="modal-content" id="res_model_form">
                <div class="modal-header">
                      <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title" id="formtitle">Add / Edit Resources</h4>                  
                </div>
                <form class="cmxform" id="resourceForm" name="resourceForm" method="post" action="" enctype="multipart/form-data">
                    <div class="modal-body" id="resource_form">
                        <img src='scripts/jquery-modal/images/LoaderIcon.gif' />
                        <?php// require_once('resources.php'); //resource form will be here..?>
                    </div>
                    <div class="modal-footer">
                        <button class="btn btn-primary">Save</button>
                        <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
                    </div>
                </form>

            </div>
        </div>
    </div>
    <table id="tblresources" class="display" style="width:100%">
        <thead>
            <tr>
                <th>Resource Name</th>
                <th>Resource Type</th>
                <th>Resource Subtype</th>
                <th>Resource Mode</th>
                <th>Active?</th>
                <th>Action</th>
            </tr>
        </thead>
        <!-- <tfoot>
            <tr>
				<th>Resource Name</th>
				<th>Resource Type</th>
				<th>Resource Subtype</th>
                <th>Resource Mode</th>                
				<th>Action</th> 
            </tr>
        </tfoot>  -->
    </table>

    <div id="confirmModal" role="dialog" class="modal fade">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" data-dismiss="modal" class="close">&times;</button>
                    <h4 class="modal-title">Confirm </h4>                    
                </div>
                <div class="modal-body">
                    <p>Do you really Want to Delete this Resource?</p>
                    <input type="hidden" name="del_resource_id" id="del_resource_id" value="">
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-primary" id="btnyes">Yes</button>
                    <button type="button" data-dismiss="modal" class="btn btn-default">No</button>
                </div>
            </div>
        </div>
    </div>

      <div id="resourceAttachmentDialog" role="dialog" class="modal fade">
        <div class="modal-dialog modal-lg">
            <div class="modal-content" >
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title" id="formtitle">Resource Attachment</h4>                    
                </div>
                    <div class="modal-body" id="resource_attachment_details">
                        <img src='scripts/jquery-modal/images/LoaderIcon.gif' />
                        
                    </div>
                    <div class="modal-footer">                        
                        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                    </div>                

            </div>
        </div>
    </div>
</body>

</html>
<?php //$PAGE->requires->js(new moodle_url($CFG->wwwroot . '/mod/zingilt/resourcemgmt/scripts/js/customjs.js')); 
?>
<script src="<?php echo $CFG->wwwroot; ?>/mod/zingilt/resourcemgmt/scripts/js/customjs.js"></script>
<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCN_7A6veN-qxSnzdGl-l9xEP9YAW9kHqw"></script>
<?php
echo $OUTPUT->footer();
