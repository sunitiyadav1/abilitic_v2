<?php
require_once('../../../config.php');
require_login(); // We need login
global $CFG, $DB, $USER;
require_once($CFG->libdir . '/coursecatlib.php');

$context = context_system::instance();
$PAGE->set_context($context);
$PAGE->set_url('/admin/tool/lp/competency_course_list.php');
$plan_id = optional_param('p', 0, PARAM_INT);

// Print the page header
$PAGE->set_title($CFG->app_name);
$PAGE->set_heading('Learning Plans');
$PAGE->navbar->add('Learning Plans', new moodle_url('/admin/tool/lp/competency_course_list.php'));
echo $OUTPUT->header();

function course_image($set_course_id)
{
	global $CFG;

	$courseid = new stdClass();
	$courseid->id = $set_course_id;

	$course   = new course_in_list($courseid);

	$outputimage = '';
	foreach ($course->get_course_overviewfiles() as $file) {
	    if ($file->is_valid_image()) {
	        $imagepath = '/' . $file->get_contextid() .
	                '/' . $file->get_component() .
	                '/' . $file->get_filearea() .
	                $file->get_filepath() .
	                $file->get_filename();
	        $imageurl = file_encode_url($CFG->wwwroot . '/pluginfile.php', $imagepath,
	                false);
	        /*
	        $outputimage = html_writer::tag('div',
	                html_writer::empty_tag('img', array('src' => $imageurl)),
	                array('class' => 'courseimage'));
	        */
	        
	        // Use the first image found.
	        break;
	    }
	}
	// return $outputimage;
	return $imageurl;
}

$sql = "SELECT  cc.courseid as course_id, p.id AS plan_id, p.name AS plan_name, cf.id AS fameworkid, 
			cf.shortname AS framework_name, c.id AS competencyid,
			c.shortname AS competencyname,c.sortorder,cc.courseid,
			cou.fullname AS coursename, ct.id AS templateid,ct.shortname AS temp_name
			FROM mdl_competency_framework AS cf
			JOIN mdl_competency AS c ON c.competencyframeworkid = cf.id
			JOIN mdl_competency_coursecomp AS cc ON cc.competencyid = c.id
			JOIN mdl_course AS cou ON cou.id = cc.courseid
			JOIN mdl_competency_templatecomp AS ctc ON ctc.competencyid = c.id
			JOIN mdl_competency_template AS ct ON ct.id = ctc.templateid
			JOIN mdl_competency_plan AS p ON p.templateid = ct.id
			WHERE ct.visible = 1 AND p.userid = '$USER->id' AND p.id = '$plan_id'
			GROUP BY cf.id,c.id,c.shortname,cc.courseid
			ORDER BY c.sortorder";
$get_data = $DB->get_records_sql($sql);

$get_plan = $DB->get_record_sql("select * from mdl_competency_plan where id= '$plan_id'");

?>
<html>
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta http-equiv="Pragma" content="no-cache">
        <meta http-equiv="no-cache">
        <meta http-equiv="Expires" content="-1">
        <meta http-equiv="Cache-Control" content="no-cache">

        <script src="<?php echo $CFG->wwwroot.'/theme/styles.php/mb2nl/1587211007_1/all'; ?>"></script>
    </head>
    <body>
    	<h3>
    		<?php echo $get_plan->name; ?>
    	</h3>
    	<br>
    	<?php 
    		foreach ($get_data as $key => $value) 
    		{
    	?>
    		<div class="class="courses frontpage-course-list-enrolled"">
	    		<div class="coursebox clearfix odd first noinfobox" data-courseid="<?php echo $value->courseid; ?>" data-type="1">
		    		<div class="content">
		    			<div class="content-inner fileandcontent">
		    				<div class="course-content">
			    				<div class="course-heading">
			    					<h3 class="coursename">
			    						<a href="<?php echo $CFG->wwwroot.'/course/view.php?id='.$value->courseid; ?>">
			    						<?php echo $value->coursename; ?>
			    						</a>
			    					</h3>
			    				</div>
			    				<div class="course-readmore">
			    					<a class="btn btn-primary" href="<?php echo $CFG->wwwroot.'/course/view.php?id='.$value->courseid; ?>">
			    					Enter this course
			    					</a>
			    				</div>
		    				</div>
			    			<div class="course-media">
			    				<img src="<?php echo course_image($value->courseid); ?>" class="courseimage">
			    			</div>
			    		</div>
			    	</div>
			    </div>
			</div>
    	<?php
    		}
    	?>
    </body>
</html>

<?php
echo $OUTPUT->footer();
?>