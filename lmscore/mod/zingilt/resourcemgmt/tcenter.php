<?php
require_once('../../../config.php');
require_login(); // We need login
global $CFG, $USER;
require "$CFG->libdir/tablelib.php";
$context = context_system::instance();
$PAGE->set_context($context);
// Set the name for the page.
$pluginname = 'mod_zingilt';
$linktext = get_string('tcenter_list', $pluginname);
// Set the url.
$linkurl = new moodle_url('/mod/zingilt/resourcemgmt/tcenter.php');
// Print the page header.
$PAGE->set_context($context);
$PAGE->set_url($linkurl);
$PAGE->set_pagelayout('admin');
$PAGE->set_title($linktext);
$mainurl = new moodle_url('/mod/zingilt/resourcemgmt/index.php');
// Set the page heading.
$PAGE->set_heading(get_string('myhome') . " - $linktext");
$PAGE->navbar->add(get_string('dashboard', 'mod_zingilt'), $mainurl);
$PAGE->navbar->add($linktext, $linkurl);
echo $OUTPUT->header();
?>
<html>
<?php require_once('includes/default_structure.php'); ?>

<body>
  <?php require_once("includes/menubar.php"); ?>
  <div id="showMessage" class="alert"  style="display: none;"></div>
  <button id="btnaddtcenter" class="btn btn-primary"><?php echo  get_string('tcenter_add', 'mod_zingilt') ?></button><BR><BR>
  <!-- Modal -->
  <div id="tcenterFormDialog" role="dialog" class="modal fade">
    <div class="modal-dialog modal-lg">
      <div class="modal-content" id="res_model_form">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title" id="formtitle">Add / Edit Training Center</h4>          
        </div>
        <form class="cmxform" id="tcenterForm" name="tcenterForm" method="post" action="">
          <div class="modal-body" id="tcenter_form">
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
  <table id="tbltcenter" class="display" style="width:100%">
    <thead>
      <tr>
        <th>Training Center Name</th>
        <th>Location</th>
        <th>Action</th>
      </tr>
    </thead>
  </table>

  <div id="confirmModal" role="dialog" class="modal fade">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
           <button type="button" data-dismiss="modal" class="close">&times;</button>
          <h4 class="modal-title">Confirm </h4>         
        </div>
        <div class="modal-body">
          <p>Do you really Want to Delete this Training Center?</p>
          <input type="text" name="del_tcenter_id" id="del_tcenter_id" value="">
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-primary" id="btnyes">Yes</button>
          <button type="button" data-dismiss="modal" class="btn btn-default">No</button>
        </div>
      </div>
    </div>
  </div>
</body>
</html>
<script src="<?php echo $CFG->wwwroot; ?>/mod/zingilt/resourcemgmt/scripts/js/customjs.js"></script>
<?php
echo $OUTPUT->footer();
