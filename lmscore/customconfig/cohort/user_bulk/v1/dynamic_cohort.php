<?php
require_once('../../../../config.php');
require_login(); // We need login
global $CFG, $USER;
require "$CFG->libdir/tablelib.php";


$context = context_system::instance();
$PAGE->set_context($context);
$PAGE->set_url('/customconfig/cohort/user_bulk/v1/dynamic_cohort.php');
//$download = optional_param('download', '', PARAM_ALPHA);

$table = new table_sql('uniqueid');
// Print the page header
$PAGE->set_title($CFG->app_name);
$PAGE->set_heading('Dynamic Cohorts');
$PAGE->navbar->add('Dynamic Cohort - ub:v1', new moodle_url('/customconfig/cohort/user_bulk/v1/dynamic_cohort.php'));
echo $OUTPUT->header();

?>

<html>
    <?php require "default_structure.php"; ?>
    <body>
    	<a href="<?php echo $CFG->wwwroot.'/customconfig/cohort/user_bulk/v1/set_dc_rule.php'; ?>">
    		<button type="button" class="btn btn-primary">
    			<i style="font-size:12px" class="fa">&#xf067;</i> Add Rule Set
    		</button>
    	</a>
    	<br><br>
		<form id="frm-example" action="/path/to/your/script" method="POST">
		    <table id="example" class="display" cellspacing="0" width="100%">
			   <thead>
			      	<tr>
			            <th><input name="select_all" value="1" id="example-select-all" type="checkbox" /></th>
			         	<!-- <th>Name</th> -->
			         	<th>Rule Name</th>
			         	<th>No. of Users</th>
			         	<th>Created Date Time</th>
			         	<th>Updated Date Time</th>
			         	<th>Active</th>
			         	<th>Delete</th>
			      	</tr>
			   </thead>
			   <tfoot>
			      	<tr>
			         	<th></th>
			         	<!-- <th>Name</th> -->
			         	<th>Rule Name</th>
			         	<th>No. of Users</th>
			         	<th>Created Date Time</th>
			         	<th>Updated Date Time</th>
			         	<th>Active</th>
			         	<th>Delete</th>
			      		</tr>
			   </tfoot>
			</table>
			<hr>

			<p> 
				<button type="submit" class="btn btn-primary"> <i class="fa fa-archive"> Active/ Deactive </i></button>
				<button type="button" id="delete_btn" class="btn btn-primary"><i style="font-size:15px" class="fa">&#xf014;</i> Delete</button>
			</p>

			<!-- <pre id="example-console">
			</pre> -->

		</form>
    </body>
</html>

<script type="text/javascript">
	$(document).ready(function (){ 
	    var loc = "<?php echo $CFG->wwwroot.'/customconfig/cohort/user_bulk/v1/get_dynamic_cohort.php'; ?>";  
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
	         	'targets': 5,
	         	'searchable':false,
	         	'orderable':false,
	         	'className': 'dt-body-center',
	         	'render': function (data, type, full, meta){
	             	if(data == 0)
	             	{
	             		return '<a class="active_inactive" href="#" id="in_'+ $('<div/>').text(full[0]).html() + '" > <i style="font-size:24px" class="fa">&#xf070;</i></a>';	
	             	}
	             	else
	             	{
	             		return '<a class="active_inactive" href="#" id="a_'+ $('<div/>').text(full[0]).html() + '" > <i style="font-size:24px" class="fa">&#xf06e;</i></a>';
	             	}
	         	}
	        }, 
	        {
	         	'targets': 6,
	         	'searchable':false,
	         	'orderable':false,
	         	'className': 'dt-body-center',
	         	'render': function (data, type, full, meta){
	             	// return '<a class="delete" href="'+ $('<div/>').text(data).html() + '" > <i style="font-size:24px" class="fa">&#xf014;</i></a>';

	             	// console.log(data);
	             	// console.log(type);
	             	// console.log(full);
	             	// console.log(meta);
	             	
	             	if(data == 0)
	             	{
	             		return '<a class="delete" href="#" id="'+ $('<div/>').text(full[0]).html() + '" > <i style="font-size:24px" class="fa">&#xf014;</i></a>';	
	             	}
	             	else
	             	{
	             		return "<p>NA</p>";
	             	}
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
                var loc_url    = "<?php echo $CFG->wwwroot.'/customconfig/cohort/user_bulk/v1/dc_api.php'; ?>";
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
	    	var set_url 	= "<?php echo $CFG->wwwroot.'/customconfig/cohort/user_bulk/v1/dc_api.php'; ?>";
	    	var wsfunction  = "delete_dc";
	    	var dc_id 		= $(this).attr('id');
	    	var user_id     = "<?php echo $USER->id; ?>";

			var checkstr =  confirm('Are you sure you want to delete this?');
			if(checkstr == true){
		    	$.ajax({
	                url: set_url,
	                type: "POST",
	                data: {wsfunction : wsfunction, dc_id : dc_id,user_id:user_id},
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

		$('#delete_btn').on('click', function (e) {
	    	var checkstr 	=  confirm('Are you sure you want to delete selected rows ?');
			if(checkstr == true){
		    	$.each($("input[name='id']:checked"), function(){
	                console.log($(this).val());
	                var wsfunction  = "delete_dc";
	                var dc_id  		= $(this).val();
	                var user_id     = "<?php echo $USER->id; ?>";
	                var set_url     = "<?php echo $CFG->wwwroot.'/customconfig/cohort/user_bulk/v1/dc_api.php'; ?>";
	                
			    	$.ajax({
		                url: set_url,
		                type: "POST",
		                data: {wsfunction : wsfunction, dc_id : dc_id, user_id:user_id},
		                success: function(data){
		                	// $(this).closest('tr').remove();
		                }
		            });

	            });
            }else{
				return false;
			}

            location.reload();
	      	// Prevent actual form submission
	      	e.preventDefault();
		});

		$('#example').on('click', '.active_inactive', function (e) {
	    	//console.log($(this).attr('id'));
	    	var set_url 	= "<?php echo $CFG->wwwroot.'/customconfig/cohort/user_bulk/v1/dc_api.php'; ?>";
	    	var wsfunction  = "update_dc_status";
	    	var get_id      = $(this).attr('id');
	    	var res 		= get_id.split("_"); 
	    	var config_id   = res[1];
	    	var user_id     = "<?php echo $USER->id; ?>";
			var checkstr =  confirm('Are you sure you want to active / deactive this?');
			if(checkstr == true){
		    	$.ajax({
	                url: set_url,
	                type: "POST",
	                data: {wsfunction : wsfunction, config_id : config_id, user_id : user_id},
	                success: function(data){
	                	
	                	if(res[0] == "a")
	                	{
	                		$(".active_inactive#a_"+config_id).find("i").remove();
	                		$(".active_inactive#a_"+config_id).append('<i style="font-size:24px" class="fa">&#xf070;</i>');
	                		$(".active_inactive#a_"+config_id).prop('id', "in_"+config_id);
	                	}
	                	else
	                	{
	                		$(".active_inactive#in_"+config_id).find("i").remove();
	                		$(".active_inactive#in_"+config_id).append('<i style="font-size:24px" class="fa">&#xf06e;</i>');
	                		$(".active_inactive#in_"+config_id).prop('id', "a_"+config_id);
	                	}
	                }
	            });
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