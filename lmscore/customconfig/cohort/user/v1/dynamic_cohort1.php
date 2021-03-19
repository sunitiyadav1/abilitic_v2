<?php
require_once('../config.php');
require_login(); // We need login
global $CFG, $USER;
require "$CFG->libdir/tablelib.php";


$context = context_system::instance();
$PAGE->set_context($context);
$PAGE->set_url('/customconfig/dynamic_cohort.php');
//$download = optional_param('download', '', PARAM_ALPHA);

$table = new table_sql('uniqueid');
// Print the page header
$PAGE->set_title($CFG->app_name);
$PAGE->set_heading('Dynamic Cohort - Existing Rule Sets');
$PAGE->navbar->add('Dynamic Cohort', new moodle_url('/customconfig/dynamic_cohort.php'));
echo $OUTPUT->header();

?>
<style type="text/css">
	/*------ ADDED CSS ---------*/
	.slider:after
	{
	 content:'No' !important;
	 color: white;
	 display: block;
	 position: absolute;
	 transform: translate(-50%,-50%);
	 top: 50%;
	 left: 50%;
	 font-size: 10px;
	 font-family: Verdana, sans-serif;
	}

	input:checked + .slider:after
	{  
	  content:'Yes' !important;
	}

</style>
<html>
    <?php require "default_structure.php"; ?>
    <body>
    	<a href="<?php echo $CFG->wwwroot.'/customconfig/set_dc_rule.php'; ?>"><button type="button" id="clone_btn" class="btn btn-primary">Create New Rule Set</button></a>
    	<br><br>
		<form id="frm-example" action="/path/to/your/script" method="POST">
		    <table id="example" class="display" cellspacing="0" width="100%">
			   <thead>
			      	<tr>
			            <th><input name="select_all" value="1" id="example-select-all" type="checkbox" /></th>
			         	<th>Name</th>
			         	<th>Rule</th>
			         	<th>No. of Users</th>
			         	<th>Active</th>
			         	<th>Created Date Time</th>
			         	<th>Updated Date Time</th>
			         	<th>Edit</th>
			         	<th>Delete</th>
			      	</tr>
			   </thead>
			   <tfoot>
			      	<tr>
			         	<th></th>
			         	<th>Name</th>
			         	<th>Rule</th>
			         	<th>No. of Users</th>
			         	<th>Active</th>
			         	<th>Created Date Time</th>
			         	<th>Updated Date Time</th>
			         	<th>Edit</th>
			         	<th>Delete</th>
			      		</tr>
			   </tfoot>
			</table>
			<hr>

			<p><button type="submit" id="clone_btn" class="btn btn-primary" >Submit</button></p>

			<!-- <pre id="example-console">
			</pre> -->

		</form>
    </body>
</html>

<script type="text/javascript">
	$(document).ready(function (){ 
	    var loc = "<?php echo $CFG->wwwroot.'/customconfig/get_dynamic_cohort.php'; ?>";  
	    var table = $('#example').DataTable({
	        'ajax': loc,
	        'columnDefs': [
	        {
	         	'targets': 0,
	         	'searchable':false,
	         	'orderable':false,
	         	'className': 'dt-body-center',
	         	'render': function (data, type, full, meta){
	             	return '<input type="checkbox" name="id" value="' 
	                + $('<div/>').text(data).html() + '">';
	         	}
	        },
	        {
	         	'targets': 4,
	         	'searchable':false,
	         	'orderable':false,
	         	'className': 'dt-body-center',
	         	'render': function (data, type, full, meta){
	             	return '<label class="switch" id="switch_'+ $('<div/>').text(data).html() + '"><input type="hidden" name="toggle_value[]" id="toggle_value_'+ $('<div/>').text(data).html() + '" value="and"><input type="checkbox" id="togBtn_'+ $('<div/>').text(data).html() + '"><div class="slider round" id="slider_id_'+ $('<div/>').text(data).html() + '"></div></label>';
	         	}
	        },
	        {
	         	'targets': 7,
	         	'searchable':false,
	         	'orderable':false,
	         	'className': 'dt-body-center',
	         	'render': function (data, type, full, meta){
	             	return '<a class="edit_action" href="#"   id="'+ $('<div/>').text(data).html() + '" > <i style="font-size:24px" class="fa">&#xf044;</i></a>';
	         	}
	        },
	        {
	         	'targets': 8,
	         	'searchable':false,
	         	'orderable':false,
	         	'className': 'dt-body-center',
	         	'render': function (data, type, full, meta){
	             	return '<a class="delete" href="#" id="'+ $('<div/>').text(data).html() + '" > <i style="font-size:24px" class="fa">&#xf014;</i></a>';
	         	}
	        }

	        ],
	      	'order': [1, 'asc']
	    });

	    // Handle click on "Select all" control
	    $('#example-select-all').on('click', function(){
	      	// Check/uncheck all checkboxes in the table
	      	var rows = table.rows({ 'search': 'applied' }).nodes();
	      	$('input[type="checkbox"]', rows).prop('checked', this.checked);
	    });

	    // Handle click on checkbox to set state of "Select all" control
	    $('#example tbody').on('change', 'input[type="checkbox"]', function(){
	      	// If checkbox is not checked
	      	if(!this.checked){
	         	var el = $('#example-select-all').get(0);
	         	// If "Select all" control is checked and has 'indeterminate' property
	         	if(el && el.checked && ('indeterminate' in el)){
	            	// Set visual state of "Select all" control 
	            	// as 'indeterminate'
	            	el.indeterminate = true;
	         	}
	      	}
	    });
	    
	    $('#frm-example').on('submit', function(e){
	      	var form = this;

	      	// Iterate over all checkboxes in the table
	      	table.$('input[type="checkbox"]').each(function(){
	        	// If checkbox doesn't exist in DOM
	         	if(!$.contains(document, this)){
		            // If checkbox is checked
		            if(this.checked){
		               // Create a hidden element 
		               $(form).append(
		                  $('<input>')
		                     .attr('type', 'hidden')
		                     .attr('name', this.name)
		                     .val(this.value)
		               );
		            }
	         	} 
	      	});

	      	// FOR TESTING ONLY
	      
	      	// Output form data to a console
	      	//$('#example-console').text($(form).serialize()); 
	      	//console.log("Form submission", $(form).serialize()); 

	       	$.each($("input[name='id']:checked"), function(){
                console.log($(this).val());
                var wsfunction = "update_dc_status";
                var config_id  = $(this).val();
                var user_id    = "<?php echo $USER->id; ?>";
                var loc_url    = "<?php echo $CFG->wwwroot.'/restapi/custom_scripts/activity_tracking.php'; ?>";
                //console.log(config_id);

                $.ajax({
	                url: loc_url,
	                type: "POST",
	                data: {wsfunction : wsfunction, config_id : config_id, user_id : user_id},
	                success: function(data){
	                	$('#example-console').text(data.message);
	                }
	            });

            });

            location.reload();
	      	// Prevent actual form submission
	      	e.preventDefault();
	    });

	    /*
	    $('.delete').bootstrap_confirm_delete({
        	heading: 'Delete',
		    message: 'Are you sure you want to delete this item?',
		    data_type: null,
            callback: function( event )
            {
                var link = event.data.originalObject;

                link.closest( 'tr' ).remove();
            }
        });
        */

	    $('#example').on('click', '.delete', function (e) {
	    	//console.log($(this).attr('id'));
	    	var set_url 	= "<?php echo $CFG->wwwroot.'/restapi/custom_scripts/activity_tracking.php'; ?>";
	    	var wsfunction  = "delete_dc";
	    	var dc_id 		= $(this).attr('id');

			var checkstr =  confirm('Are you sure you want to delete this?');
			if(checkstr == true){
		    	$.ajax({
	                url: set_url,
	                type: "POST",
	                data: {wsfunction : wsfunction, dc_id : dc_id},
	                success: function(data){
	                	// $(this).closest('tr').remove();
	                }
	            });
			}else{
				return false;
			}
		    e.preventDefault();
		    $(this).closest('tr').remove();
		});

		//edit_action
		$('#example').on('click', '.edit_action', function (e) {
	    	console.log($(this).attr('id'));
	    	var set_url 	= "<?php echo $CFG->wwwroot.'/restapi/custom_scripts/activity_tracking.php'; ?>";
	    	var wsfunction  = "edit_dc";
	    	var dc_id 		= $(this).attr('id');

			var checkstr =  confirm('Are you sure you want to edit this?');
			if(checkstr == true){
		    	/*
		    	$.ajax({
	                url: set_url,
	                type: "POST",
	                data: {wsfunction : wsfunction, dc_id : dc_id},
	                success: function(data){
	                	// $(this).closest('tr').remove();
	                }
	            });
	            */
			}else{
				return false;
			}
		    e.preventDefault();
		});
	});
</script>

<?php
echo $OUTPUT->footer();
?>