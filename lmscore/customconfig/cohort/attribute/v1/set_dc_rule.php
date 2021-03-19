<?php
require_once('../../../../config.php');
require_login(); // We need login
global $CFG, $DB;
require "$CFG->libdir/tablelib.php";

$get_columns 	= $DB->get_records_sql("SELECT * FROM `mdl_custom_user_field_detail` where is_visible = '1' order by field");

$context = context_system::instance();
$PAGE->set_context($context);
$PAGE->set_url('/customconfig/cohort/attribute/v1/set_dc_rule.php');

$table = new table_sql('uniqueid');
// Print the page header
$PAGE->set_title($CFG->app_name);
$PAGE->set_heading('Add Rule Set');
$PAGE->navbar->add('Add Rule Set', new moodle_url('/customconfig/cohort/attribute/v1/set_dc_rule.php'));
echo $OUTPUT->header();

?>
<html>
   <?php require "default_structure.php"; ?>
    <body>
    	
    	<button type="button" id="clone_btn" class="btn btn-primary" >
    		<i style="font-size:12px" class="fa">&#xf067;</i> Add a Rule
    	</button>
    	<a href="<?php echo $CFG->wwwroot.'/customconfig/cohort/attribute/v1/dynamic_cohort.php'; ?>" style="float: right;">
    		<button type="button" class="btn btn-primary">
    			<i class="fa fa-arrow-left" aria-hidden="true"> Back</i>
    		</button>
    	</a>
    	<br><br>
    	<form method="post" id="rulesetform" name="rulesetform" action="submit_dc_rule.php">
	    	<div class="row">
	    		<div class="input-group mb-3 col-xs-6 col-sm-6">
				  <div class="input-group-prepend">
				    <label class="input-group-text" for="cohort_name">Cohort Name</label>
				  </div>
				  <input type="text" class="select_class" autocomplete="off" name="cohort_name" id="cohort_name" required></input>
				</div>

	    		<div class="input-group mb-3 col-xs-6 col-sm-6">
				  <div class="input-group-prepend">
				    <label class="input-group-text" for="rule_name">Rule Name</label>
				  </div>
				  <input type="text" class="select_class" autocomplete="off" name="rule_name" id="rule_name" required></input>
				</div>
	    	</div>

			<div id="parent_div">
				<div id="ruleset_1">
					<div class="row" id="row_1">	
						<div class="input-group mb-3 col-xs-6 col-sm-4">
						  <div class="input-group-prepend">
						    <label class="input-group-text" for="tbl_columns">Attribute</label>
						  </div>
						  <select class="select_class" name="tbl_columns[]" id="tbl_columns_1" required>
						    <option selected value="">Choose...</option>
						    <?php 
						    foreach ($get_columns as $key1 => $value1) 
						    {
						    ?>
						    	<option value="<?php echo $value1->id ?>"> <?php echo $value1->field ?> </option>
						    <?php	
						    }
						    ?>
						  </select>
						</div>

						<div class="input-group mb-3 col-xs-6 col-sm-4">
						  <div class="input-group-prepend">
						    <label class="input-group-text" for="tbl_condition">Condition</label>
						  </div>
						  <select class="select_class class_condition" name="tbl_condition[]" id="tbl_condition_1" required>
						    <option selected value="">Choose...</option>
					        <!-- <option value="1">contains</option>
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
					        <option value="14">between ( e.g 1,5 )</option>
					        <option value="15">not between ( e.g 1,5 )</option>
					        <option value="16">IN  ( e.g 1,2,3 )</option>
					        <option value="17">NOT IN (e.g 1,2,3 )</option> -->

						  </select>
						</div>

						<!--
						<div class="input-group mb-3 col-xs-6 col-sm-4">
						  <div class="input-group-prepend">
						    <label class="input-group-text" for="tbl_distinct">Distinct</label>
						  </div>
						  <input type="checkbox" class="select_class" style="width: 12% !important;" name="tbl_distinct[]" id="tbl_distinct_1"></input>
						</div>

						<div class="input-group mb-3 col-xs-6 col-sm-4">
						  <div class="input-group-prepend">
						    <label class="input-group-text" for="tbl_options">Options</label>
						  </div>
						  <select class="select_class class_condition" name="tbl_options[]" id="tbl_options_1" readonly="true" style="background-color: #e9ecef">
						    <option selected value="0">Choose...</option>
						  </select>
						</div>
						 -->

						<div class="input-group mb-3 col-xs-6 col-sm-4" id="value_class_1">
						  <div class="input-group-prepend" id="next_value_class_1">
						    <label class="input-group-text" for="tbl_value">Value</label>
						  </div>
						  <input type="text" class="select_class" autocomplete="off" name="tbl_value[]" id="tbl_value_1" required></input>
						</div>

					</div>
					<!-- style="display: none;" -->
					<label class="switch" id="switch_1" style="display: none;">
						<input type="hidden" name="toggle_value[]" id="toggle_value_1" value="and">
						<input type="checkbox" id="togBtn">
						<div class="slider round" id="slider_id_1"></div>
					</label>

					<button type="button" class="btn ruleset_btn" id="delete_ruleset_1" style="display: none;"> <i style="font-size:15px" class="fa">&#xf014;</i> Delete Rule</button>
					<br>
				</div>
			</div>
			<br>

			<button type="submit" id="submit" class="btn btn-primary"><i class="fa fa-archive"> Submit Rule Set </i></button>
		</form>
    </body>
</html>
<script type="text/javascript">
	$(document).ready(function (){ 
		form_submit();
		// $('select').select2();
		// $(".select2-container .select2-selection--single").css('height','37px');

		$('form#submit').on('submit', function(event) {
		    //Add validation rule for dynamically generated fields
		    $('select[id^="tbl_columns_"]').each(function() {
		        $(this).rules("add", 
		            {
		                required: true,
		                messages: {
		                    required: "Please Select Attribute.",
		                }
		            });
		    });
		    
		    $('select[id^="tbl_condition_"]').each(function() {
		        $(this).rules("add", 
		            {
		                required: true,
		                messages: {
		                    required: "Please Select Condition."
		                }
		            });
		    });

		    $('[id^="tbl_value_"]').each(function() {
		    	var get_id  =  $(this).prop('id'); //console.log(get_id);
	    		var res 	= get_id.split("_"); 
	    		var condition_val = $("#tbl_condition_"+res[2]+" option:selected").val();

		    	if(condition_val != 6 || condition_val != 7 || condition_val != 8)
		    	{
		        	$(this).rules("add", 
		            {
		                required: true,
		                messages: {
		                    required: "Please Select/Enter Value."
		                }
		            });
		        }

		    });

		    $("#rulesetform").validate();

		});
		
		//$('#clone_btn').click(function(){
		$(document).on('click', "#clone_btn",function(){

			var $div 	 = $('div[id^="ruleset_"]:last');
			var num 	 = parseInt( $div.prop("id").match(/\d+/g), 10 ) +1;
			var $ruleset = $div.clone().prop('id', 'ruleset_'+num );
			var less_num = num - 1; //console.log(less_num);
			
			//$('select[id^="tbl_columns_"]:last').select2("destroy");

			$("#parent_div").append($ruleset);

			$('select[id^="tbl_columns_"]:last').prop('id', 'tbl_columns_'+num);
			$('select[id^="tbl_condition_"]:last').prop('id', 'tbl_condition_'+num);

			$('input[id^="tbl_value_"]:last').prop('id', 'tbl_value_'+num);
			$('label[id^="switch_"]:last').prop('id', 'switch_'+num);
			$('input[id^="toggle_value_"]:last').prop('id', 'toggle_value_'+num);

			$('div[id^="row_"]:last').prop('id', 'row_'+num);
			$('div[id^="slider_id_"]:last').prop('id', 'slider_id_'+num);
			$('div[id^="value_class_"]:last').prop('id', 'value_class_'+num);
			$('div[id^="next_value_class_"]:last').prop('id', 'next_value_class_'+num);
			$('div[id^="between_"]:last').prop('id', 'between_'+num);

			$('button[id^="delete_ruleset_"]:last').prop('id','delete_ruleset_'+num);
			$('#delete_ruleset_'+less_num).css('display','block');

			// $('select[id^="tbl_options_"]:last').prop('id', 'tbl_options_'+num);
			// $('input[id^="tbl_distinct_"]:last').prop('id', 'tbl_distinct_'+num);

			$('#switch_'+less_num).css('display','block');
			$('input[id^="tbl_value_'+num+'"]').val("");
			$('#between_'+num).remove();
			console.log("between delete -"+num);

			 /*
			$('#tbl_columns_'+num).next().remove();
			$('#tbl_columns_'+num).removeClass('select2-hidden-accessible');
			$('#tbl_columns_'+num)
		    .removeAttr('data-live-search')
		    .removeAttr('data-select2-id')
		    .removeAttr('aria-hidden')
		    .removeAttr('tabindex');
			$('select#tbl_columns_'+num).select2();
			*/

	    });

	    $(document).on('click', ".slider,.round",function(){
	    	// alert("here");
	    	var get_id = $(this).attr('id');
	    	var result = get_id.split('_');

	    	var get_val = $('#toggle_value_'+result[2]).val(); // console.log(get_val);
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
	    	var less_num= res[2] - 1; 

	    	$('#between_'+res[2]).remove();
	    	console.log("between delete -"+res[2]);
	    	console.log(get_val);
	    	$('#next_value_class_'+res[2]).find("label[for*='tbl_value']").text("Value");
	    	if(get_val == 6 || get_val == 7 || get_val == 8)
	    	{
	    		$('#tbl_value_'+res[2]).prop('required',false);
	    		$('#tbl_value_'+res[2]).prop('readonly',true);
	    		$('#tbl_value_'+res[2]).css('background-color','#e9ecef');
	    		
	    		// $('input[id^="tbl_value_'+res[2]+'"]').prop('readonly',true);
	    		// $('input[id^="tbl_value_'+res[2]+'"]').css('background-color','#e9ecef');

	    		// $('input[id^="tbl_distinct_'+res[2]+'"]').prop("checked", false);
	    		// $('input[id^="tbl_distinct_'+res[2]+'"]').prop('disabled',true);
	    		// $('input[id^="tbl_distinct_'+res[2]+'"]').css('background-color','#e9ecef');

	    		// $('select[id^="tbl_options_'+res[2]+'"]').val("");
	    		// $('select[id^="tbl_options_'+res[2]+'"]').prop('readonly',true);
	    		// $('select[id^="tbl_options_'+res[2]+'"]').css('background-color','#e9ecef');
	    		
	    	}
	    	else if(get_val == 14 || get_val == 15)
	    	{
	    		//DATE_FORMAT(date_arrival, "%Y-%m-%dT%H:%i");

	    		var d 	 	 = new Date();
	    		var set_date = d.getFullYear()+'-'+ ("0" + (d.getMonth() + 1)).slice(-2)+'-'+ ("0" + d.getDate()).slice(-2)+'T'+d.getHours()+':'+("0" + (d.getMinutes()+ 1)).slice(-2);

	    		$('#tbl_value_'+res[2]).prop('readonly',false);
	    		$('#tbl_value_'+res[2]).css('background-color','#fff');

	    		$('#next_value_class_'+res[2]).find("label[for*='tbl_value']").text("From Date");

	    		if(get_val == 14)
	    		{
	    			$("#row_"+res[2]).append('<div class="input-group mb-3 col-xs-6 col-sm-4" id="between_'+res[2]+'"><div class="input-group-prepend"><label class="input-group-text" for="tbl_value">To Date </label></div> <input type="datetime-local" style="width: 80% !important;" class="select_class" autocomplete="off" name="tbl_value_bet['+less_num+']" id="tbl_value_bet_'+res[2]+'" value="" min="2015-01-01T00:00" max="'+set_date+'" required></input></div>');
	    		}
	    		else if(get_val == 15)
	    		{
	    			$("#row_"+res[2]).append('<div class="input-group mb-3 col-xs-6 col-sm-4" id="between_'+res[2]+'"><div class="input-group-prepend"><label class="input-group-text" for="tbl_value">To Date</label></div> <input type="datetime-local" style="width: 80% !important;" class="select_class" autocomplete="off" name="tbl_value_ntbet['+less_num+']" id="tbl_value_ntbet_'+res[2]+'" value="" min="2015-01-01T00:00" max="'+set_date+'" required></input></div>');
	    		}
	    		
	    		// $('input[id^="tbl_distinct_'+res[2]+'"]').prop("checked", false);
	    		// $('input[id^="tbl_distinct_'+res[2]+'"]').prop('disabled',true);
	    		// $('input[id^="tbl_distinct_'+res[2]+'"]').css('background-color','#e9ecef');

	    		// $('select[id^="tbl_options_'+res[2]+'"]').val("");
	    		// $('select[id^="tbl_options_'+res[2]+'"]').prop('readonly',true);
	    		// $('select[id^="tbl_options_'+res[2]+'"]').css('background-color','#e9ecef');
	    		
	    	}
	    	else
	    	{
	    		$('#tbl_value_'+res[2]).prop('required',true);
	    		$('#tbl_value_'+res[2]).prop('readonly',false);
	    		$('#tbl_value_'+res[2]).css('background-color','#fff');

	    		// $('input[id^="tbl_distinct_'+res[2]+'"]').prop('disabled',false);
	    		// $('input[id^="tbl_distinct_'+res[2]+'"]').css('background-color','#fff');

	    		// $('select[id^="tbl_options_'+res[2]+'"]').prop('readonly',false);
	    		// $('select[id^="tbl_options_'+res[2]+'"]').css('background-color','#fff');
	    	}

	    	//$("#rulesetform").validate();

	    });

	    $(document).on('change', 'select[id^="tbl_columns_"]', function(){
	    	// var get_text =  $(this).text();
	    	// var get_val =  $(this).val();
	    	var get_id   =  $(this).prop('id'); //console.log(get_id);
	    	var res 	 = get_id.split("_");
	    	var get_text =  $("#"+get_id+" option:selected").text();
	    	var get_val  =  $("#"+get_id+" option:selected").val();

	    	set_condition_values(get_val,get_text,res[2]);

	    	if($("#tbl_distinct_"+res[2]).is(":checked")) 
	    	{
	    		set_distinct_values(get_text,res[2]);
	    	}

	    	//$("#rulesetform").validate();
	    });	

	    $(document).on('click', 'button[id^="delete_ruleset_"]',function(){
	    	var get_id   =  $(this).prop('id'); //console.log(get_id);
	    	var res 	 = get_id.split("_");
	    	var id       = parseInt(res[2]) + parseInt(1);
	    	console.log(id);
	    	$("#ruleset_"+id).remove();
	    	$("#switch_"+res[2]).css('display','none');
	    	$("#delete_ruleset_"+res[2]).css('display','none');
	    });

	    /*
	    $(document).on('click', 'input[id^="tbl_distinct_"]', function(){
	    	var get_val =  $(this).val();
	    	var get_id  =  $(this).prop('id'); //console.log(get_id);
	    	var res 	= get_id.split("_"); //console.log(res[2]);
	    	// $('#tbl_options_'+res[2]).empty();

	    	if($(this).is(":checked")) {
	            var returnVal = confirm("Are you sure you want distinct Options?");
	            var tbl_columns  = $("#tbl_columns_"+res[2]).text();
            	
            	$(this).attr("checked", returnVal);

            	if(tbl_columns == 0)
            	{
            		alert("Please select Attribute to see distinct Options.");
            	}
            	else
            	{
            		set_distinct_values(tbl_columns,res[2]);
            	}

	            $('input[id^="tbl_value_'+res[2]+'"]').prop('readonly',true);
	    		$('input[id^="tbl_value_'+res[2]+'"]').css('background-color','#e9ecef');

	    		$('select[id^="tbl_options_'+res[2]+'"]').prop('readonly',false);
	    		$('select[id^="tbl_options_'+res[2]+'"]').css('background-color','#fff');
	        }
        	else
        	{
        		$('input[id^="tbl_value_'+res[2]+'"]').prop('readonly',false);
	    		$('input[id^="tbl_value_'+res[2]+'"]').css('background-color','#fff');

	    		$('select[id^="tbl_options_'+res[2]+'"]').val("");
	    		$('select[id^="tbl_options_'+res[2]+'"]').prop('readonly',true);
	    		$('select[id^="tbl_options_'+res[2]+'"]').css('background-color','#e9ecef');
        	}
	    });

	    $(document).on('change', 'select[id^="tbl_options_"]', function(){

	    	var get_val =  $(this).val();
	    	var get_id  =  $(this).prop('id'); //console.log(get_id);
	    	var res 	= get_id.split("_"); //console.log(res[2]);
	    	$('input[id^="tbl_value_'+res[2]+'"]').val(get_val);
	    });
	    */

	});

	function get_distinct_values(tbl_columns,res)
	{
		// console.log(tbl_columns);
		// console.log(res);

		$('#tbl_value_'+res).append($('<option>', { 
							        value: '',
							        text : 'Choose...' 
							    }));

		var loc_url  	= "dc_api.php";
		var wsfunction  = "get_disitnct_values";
		$.ajax({
            url: loc_url,
            type: "POST",
            data: {wsfunction : wsfunction, tbl_columns : tbl_columns},
            success: function(data){
            	var resp = JSON.parse(data);
            	$.each(resp.data, function (i, item) {
            		// console.log(i);
            		// console.log(item);

				    $('#tbl_value_'+res).append($('<option>', { 
				        value: item,
				        text : item 
				    }));

				});

				//$('.mdb-select').materialSelect();
            }
        });
	}

	function set_condition_values(tbl_columns_id,tbl_columns,res)
	{
		//console.log(res);
		$('#tbl_condition_'+res).empty();
		$('#tbl_condition_'+res).append($('<option>', { 
							        value: '',
							        text : 'Choose...' 
							    }));

		var loc_url     =   "dc_api.php";
		var wsfunction  =   "get_condition";

		$.ajax({
            url: loc_url,
            type: "POST",
            data: {tbl_columns_id : tbl_columns_id, wsfunction : wsfunction},
            success: function(data){
            	var resp = JSON.parse(data);
            	var d 	 = new Date();
            	// var set_date = d.getFullYear()+'-'+d.getMonth()+'-'+d.getDate();
            	//var set_date = d.getFullYear()+'-'+ ("0" + (d.getMonth() + 1)).slice(-2)+'-'+ ("0" + d.getDate()).slice(-2);
            	var set_date = d.getFullYear()+'-'+ ("0" + (d.getMonth() + 1)).slice(-2)+'-'+ ("0" + d.getDate()).slice(-2)+'T'+d.getHours()+':'+("0" + (d.getMinutes()+ 1)).slice(-2);
            	//console.log(set_date);

            	$.each(resp.result, function (i, item) {
            		// console.log(i);
            		// console.log(item);

				    $('#tbl_condition_'+res).append($('<option>', { 
				        value: i,
				        text : item 
				    }));

				});

				console.log("between delete nxt-"+res);
            	$('#between_'+res).remove();

            	$('#next_value_class_'+res).nextAll().remove();
            	//$('#next_value_class_'+res).nextAll("#tbl_value_"+res).first().remove();
            	

				if(resp.field_type == 'T')
				{
					$("#value_class_"+res).append('<input type="text" class="select_class" autocomplete="off" name="tbl_value[]" id="tbl_value_'+res+'"></input>');
				}
				else if(resp.field_type == 'TA')
				{
					$("#value_class_"+res).append('<textarea class="select_class" name="tbl_value[]" id="tbl_value_'+res+'"></textarea>');
				}
				else if(resp.field_type == 'DT')
				{
					// $("label[for*='tbl_value']").text("Date");
					$("#value_class_"+res).append('<input type="datetime-local" style="width: 80% !important;" class="select_class" autocomplete="off" name="tbl_value[]" id="tbl_value_'+res+'" value="" min="2015-01-01T00:00" max="'+set_date+'" required>');
				}
				else if(resp.field_type == 'D')
				{
					$("#value_class_"+res).append('<select class="select_class class_condition mdb-select md-form" searchable="Search here.." name="tbl_value[]" id="tbl_value_'+res+'" required></select>');
					get_distinct_values(tbl_columns,res);
				}
				else if(resp.field_type == 'YN')
				{
					$("#value_class_"+res).append('<select class="select_class class_condition" name="tbl_value[]" id="tbl_value_'+res+'" required><option selected value="0"> NO </option><option value="1"> YES </option></select>');
				}
            }
        });
	}

	function form_submit()
	{
		$.validator.addMethod("alphanumbericspace", function(value, element) {
	        return this.optional(element) || /^[a-z0-9\-\s]+$/i.test(value);
	    }, "It must contain only letters, numbers, or dashes.");

		$("#rulesetform").validate({
		    rules: {
		      	cohort_name : {
		        	required: true,
		        	alphanumbericspace : true,
		        	minlength: 3,
		        	maxlength: 150
		      	},
		      	rule_name: {
		        	required: true,
		        	alphanumbericspace : true,
		        	minlength: 3,
		        	maxlength: 150
		      	},
		      	tbl_columns: {
		        	required: true
		      	},
		      	tbl_condition: {
		        	required: true
		      	},
		      	tbl_value: {
		        	required: function()
		        	{
		        		$('[id^="tbl_value_"]').each(function() {
					    	var get_id  =  $(this).prop('id'); //console.log(get_id);
				    		var res 	= get_id.split("_"); 
				    		var condition_val = $("#tbl_condition_"+res[2]+" option:selected").val();

					    	if(condition_val != 6 || condition_val != 7 || condition_val != 8)
					    	{
					        	return true;
					        }

					    });
		        	}
		      	},
		    },
		    messages : {
		      	cohort_name: {
		      		required: "Please Enter Cohort Name",
		        	minlength: "Cohort Name should be at least 3 characters long",
		        	maxlength: "Cohort Name should not be more than 150 characters long"
		      	},
		      	rule_name: {
		        	required: "Please Enter Rule Name",
		        	minlength: "Rule Name should be at least 3 characters long",
		        	maxlength: "Rule Name should not be more than 150 characters long"
		      	},
		      	tbl_columns: {
		        	required: "Please Select Attribute."
		      	},
		      	tbl_condition: {
		        	required: "Please Select Condition."
		      	},
		      	tbl_value: {
		      		required: "Please Select/ Enter Value."
		      	}
		    }
		});
	}

	/*
	function set_distinct_values(tbl_columns,res)
	{
		$('#tbl_options_'+res).empty();

		$('#tbl_options_'+res).append($('<option>', { 
							        value: 'Choose...',
							        text : 'Choose...' 
							    }));

		//var loc_url  = "get_disitnct_values.php";
		var loc_url  	= "dc_api.php";
		var wsfunction  = "get_disitnct_values";
		$.ajax({
            url: loc_url,
            type: "POST",
            data: {wsfunction:wsfunction, tbl_columns : tbl_columns},
            success: function(data){
            	$.each(JSON.parse(data), function (i, item) {
            		console.log(i);
            		console.log(item);

				    $('#tbl_options_'+res).append($('<option>', { 
				        value: item,
				        text : item 
				    }));

				});
            }
        });
	}
	*/

</script>

<?php
echo $OUTPUT->footer();
?>