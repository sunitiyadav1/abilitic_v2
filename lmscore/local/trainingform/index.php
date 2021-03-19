<?php
require_once('../../config.php');
require_login(); // We need login
global $CFG, $USER;
require "$CFG->libdir/tablelib.php";
require_once("lib.php");
$context = context_system::instance();
$PAGE->set_context($context);
// Set the name for the page.
$pluginname = 'local_trainingform';
$linktext = get_string('trainingform', $pluginname);
// Set the url.
$linkurl = new moodle_url('/local/trainingform/index.php');
// Print the page header.
$PAGE->set_context($context);
$PAGE->set_url($linkurl);
$PAGE->set_pagelayout('admin');
$PAGE->set_title($linktext);
// Set the page heading.
$PAGE->set_heading("$linktext");
//$PAGE->navbar->add(get_string('dashboard', 'local_resources'));
$PAGE->navbar->add($linktext, $linkurl);
//$mform = new trainingform();
echo $OUTPUT->header();
?>
<?php require_once('includes/default_structure.php'); ?>
<?php //$mform->display(); ?>
<?php //print_r($_REQUEST);?>

<?php 
if(isset($_REQUEST['action']) && $_REQUEST['action'] == "edit" && isset($_REQUEST['t']) && $_REQUEST['t'] != null && $_REQUEST['t'] > 0){
	echo "<h4>Edit TrainingForm</h4>";
	require_once("training_form_edit.php");
}
else{
	echo "<h4>Add new TrainingForm</h4>";
	require_once("training_form_new.php"); 
}

$link = new moodle_url('/local/trainingform/trainingform_table.php');
echo '<BR><BR><a class="btn btn-primary" href="' . $link . '">Back to Trainingform List</a>';
?>
<script src="<?php echo $CFG->wwwroot; ?>/local/trainingform/scripts/js/customjs.js"></script>
<?php 
	/*if(isset($_GET['action']) && $_GET['action'] !=""){
		if($_GET['action'] == "INTERNAL" || $_GET['action'] == "EXTERNAL"){
			echo '<script>
			$("#formtype").val("'.$_GET['action'].'");
			$("#formtype").trigger("change");
			</script>';
		}
	}*/
	?>
<?php
echo $OUTPUT->footer();
