<?php
require_once('../../../../config.php');
require_login(); // We need login
global $CFG, $DB;
require "$CFG->libdir/tablelib.php";

// $get_columns = $DB->get_records_sql("SHOW COLUMNS FROM mdl_user");
$get_columns 	= $DB->get_records_sql("SELECT COLUMN_NAME as field
										FROM information_schema.columns
										WHERE table_name = 'mdl_user' AND
										    #COLUMN_NAME LIKE '%name' AND
										COLUMN_NAME NOT LIKE '%password'");
// print_r($get_columns); exit();

$context = context_system::instance();
$PAGE->set_context($context);
$PAGE->set_url('/customconfig/cohort/user/v1/set_dc_rule.php');
//$download = optional_param('download', '', PARAM_ALPHA);

$table = new table_sql('uniqueid');
// Print the page header
$PAGE->set_title($CFG->app_name);
$PAGE->set_heading('Add Rule Set');
$PAGE->navbar->add('Add Rule Set', new moodle_url('/customconfig/cohort/user/v1/set_dc_rule.php'));
echo $OUTPUT->header();

?>
<html>
   <?php require "default_structure.php"; ?>
    <body>
    	
    	<button type="button" id="clone_btn" class="btn btn-primary" >
    		<i style="font-size:12px" class="fa">&#xf067;</i> Add a Rule
    	</button>
    	<br><br>
    	<form method="post" id="rulesetform" name="rulesetform" action="submit_dc_rule.php">
	    	<div class="row">
	    		<div class="input-group mb-3 col-xs-6 col-sm-6">
				  <div class="input-group-prepend">
				    <label class="input-group-text" for="cohort_name">Cohort Name</label>
				  </div>
				  <input type="text" class="select_class" autocomplete="off" name="cohort_name" id="cohort_name" required="true"></input>
				</div>

	    		<div class="input-group mb-3 col-xs-6 col-sm-6">
				  <div class="input-group-prepend">
				    <label class="input-group-text" for="rule_name">Rule Name</label>
				  </div>
				  <input type="text" class="select_class" autocomplete="off" name="rule_name" id="rule_name" required="true"></input>
				</div>
	    	</div>

			<div id="parent_div">
				<div id="ruleset_1">
					<div class="row">	
						<div class="input-group mb-3 col-xs-6 col-sm-4">
						  <div class="input-group-prepend">
						    <label class="input-group-text" for="tbl_columns">Attribute</label>
						  </div>
						  <select class="select_class" name="tbl_columns[]" id="tbl_columns_1" required="true">
						    <option selected value="">Choose...</option>
						    <?php 
						    foreach ($get_columns as $key1 => $value1) 
						    {
						    ?>
						    	<option value="<?php echo $value1->field ?>"> <?php echo $value1->field ?> </option>
						    <?php	
						    }
						    ?>
						  </select>
						</div>

						<div class="input-group mb-3 col-xs-6 col-sm-4">
						  <div class="input-group-prepend">
						    <label class="input-group-text" for="tbl_condition">Condition</label>
						  </div>
						  <select class="select_class class_condition" name="tbl_condition[]" id="tbl_condition_1" required="true">
						    <option selected value="">Choose...</option>
					        <option value="1">contains</option>
					        <option value="2">doesn't contain</option>
					        <option value="3">is equal to</option>
					        <option value="4">starts with</option>
					        <option value="5">ends with</option>
					        <option value="6">is empty</option>
					        <option value="7">distinct</option>
					        <option value="8">is not empty</option>
					        <option value="9">less than</option>
					        <option value="10">greater than</option>
					        <option value="11">less & equals to</option>
					        <option value="12">greater & equals to</option>
					        <option value="13">not equals to</option>
					        <option value="14">between</option>
					        <option value="15">not between</option>
					        <!-- <option value="16">IN (...)</option>
					        <option value="17">NOT IN (...)</option> -->

						  </select>
						</div>

						<div class="input-group mb-3 col-xs-6 col-sm-4">
						  <div class="input-group-prepend">
						    <label class="input-group-text" for="tbl_value">Value</label>
						  </div>
						  <input type="text" class="select_class" autocomplete="off" name="tbl_value[]" id="tbl_value_1"></input>
						</div>
					</div>
					<!-- style="display: none;" -->
					<label class="switch" id="switch_1" style="display: none;">
						<input type="hidden" name="toggle_value[]" id="toggle_value_1" value="and">
						<input type="checkbox" id="togBtn">
						<div class="slider round" id="slider_id_1"></div>
					</label>
					<br>
				</div>
			</div>
			<br>

			<button type="submit" id="submit" class="btn btn-primary" >Create Rule Set</button>
		</form>
    </body>
</html>

<script type="text/javascript">
	$(document).ready(function (){ 
		$('#clone_btn').click(function(){

			var $div 	 = $('div[id^="ruleset_"]:last');
			var num 	 = parseInt( $div.prop("id").match(/\d+/g), 10 ) +1;
			var $ruleset = $div.clone().prop('id', 'ruleset_'+num );
			var less_num = num - 1; console.log(less_num);
			$("#parent_div").append($ruleset);

			$('select[id^="tbl_columns_"]:last').prop('id', 'tbl_columns_'+num);
			$('select[id^="tbl_condition_"]:last').prop('id', 'tbl_condition_'+num);
			$('input[id^="tbl_value_"]:last').prop('id', 'tbl_value_'+num);
			$('label[id^="switch_"]:last').prop('id', 'switch_'+num);
			$('input[id^="toggle_value_"]:last').prop('id', 'toggle_value_'+num);
			$('div[id^="slider_id_"]:last').prop('id', 'slider_id_'+num);

			$('#switch_'+less_num).css('display','block');
			$('input[id^="tbl_value_'+num+'"]').val("");

	    });

	    $(document).on('click', ".slider,.round",function(){
	    	// alert("here");
	    	var get_id = $(this).attr('id');
	    	var result = get_id.split('_');

	    	var get_val = $('#toggle_value_'+result[2]).val(); console.log(get_val);
	    	if (get_val == 'and')
	    	{
	    		$('#toggle_value_'+result[2]).val('or');
	    	}
	    	else
	    	{
	    		$('#toggle_value_'+result[2]).val('and');
	    	}
	    });

	    $(document).on('change', 'select[id^="tbl_condition_"]', function(){
	    	var get_val =  $(this).val();
	    	var get_id  =  $(this).prop('id'); //console.log(get_id);
	    	var res 	= get_id.split("_"); //console.log(res[2]);
	    	if(get_val == 6 || get_val == 7)
	    	{
	    		$('input[id^="tbl_value_'+res[2]+'"]').prop('disabled',true);
	    		$('input[id^="tbl_value_'+res[2]+'"]').css('background-color','#e9ecef');
	    		//#e9ecef
	    	}
	    	else
	    	{
	    		$('input[id^="tbl_value_'+res[2]+'"]').prop('disabled',false);
	    		$('input[id^="tbl_value_'+res[2]+'"]').css('background-color','#fff');
	    	}
	    });
	});

</script>

<?php
echo $OUTPUT->footer();
?>