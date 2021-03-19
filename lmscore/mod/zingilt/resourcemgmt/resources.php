<?php
require_once("lib.php");
if (isset($_REQUEST) && $_REQUEST != null) {
	// $action = $_REQUEST['action'];
	// $resource_id = $_REQUEST['id'];
	// $resource_type_id = $_REQUEST['resource_type_id'];
	// $resource_subtype_id = $_REQUEST['resource_subtype_id'];
	// $resource_mode = $_REQUEST['resource_mode'];
	// $resource_desc = $_REQUEST['resource_desc'];
	// $max_no_attendees
	foreach ($_REQUEST as $k => $r) {
		$$k = $r;
	}
}
?>
<style>
	label.error {
		color: red;
	}
</style>
<link rel="stylesheet" type="text/css" href="<?php echo $CFG->wwwroot; ?>/mod/zingilt/resourcemgmt/scripts/select2/jquery.dropdown.css">
<link rel="stylesheet" type="text/css" href="<?php echo $CFG->wwwroot; ?>/mod/zingilt/resourcemgmt/scripts/select2/chosen.jquery.css">
<script src="<?php echo $CFG->wwwroot; ?>/mod/zingilt/resourcemgmt/scripts/select2/jquery.dropdown.js"></script>

    
<input type="hidden" name="formaction" id="formaction" value="<?php echo $_REQUEST['action']; ?>">
<input type="hidden" name="resource_id" id="resource_id" value="<?php echo (isset($_REQUEST['id']) ? $_REQUEST['id'] : 0); ?>">
<fieldset id="general_block">
	<legend>General</legend>
	<div class="row">
		<div class="form-group col-5">
			<label for="exampleFormControlSelect1">Resource Type</label>
			<!--  Resource Type -->
			<?php $res = getResourceType(); ?>
			<select class="form-control" id="resource_type_id" name="resource_type_id" required>
				<?php if ($res != null) {
					foreach ($res as $k => $r) {
						if (isset($_REQUEST['resource_type_id']) && $_REQUEST['resource_type_id'] == $k) {
							$seltext = "selected";
						} else {
							$seltext = "";
						}
				?>
						<option value="<?php echo $k; ?>" <?php echo $seltext ?>><?php echo $r ?></option>
				<?php

					}
				} ?>
			</select>
		</div>
		<div class="form-group col-5">
			<label for="resource_subtype_id">Resource SubType</label>
			<!-- Resource Subtype -->

			<?php $res = getResourceSubType(isset($_REQUEST['resource_type_id']) ? $_REQUEST['resource_type_id'] : "0"); //print_r($res); 
			?>
			<span id="loaderspan" style="display:none;"><img src="./scripts/img/ajax-loader.gif"></span><select class="form-control" id="resource_subtype_id" name="resource_subtype_id" required>
				<?php if ($res != null) {
					foreach ($res as $k => $r) {
						if (isset($_REQUEST['resource_subtype_id']) && $_REQUEST['resource_subtype_id'] == $k) {
							$seltext = "selected";
						} else {
							$seltext = "";
						}
				?>
						?>
						<option value="<?php echo $k; ?>" <?php echo $seltext; ?>><?php echo $r ?></option>
				<?php
					}
				} ?>
			</select>
		</div>
	</div>
	<div class="row">
		<div class="form-group col-5">
			<label for="resource_mode">Resource Mode</label>
			<!-- Resource Mode -->
			<?php $res = getResourceMode();  ?>
			<select class="form-control" id="resource_mode" name="resource_mode" required>
				<?php if ($res != null) {
					foreach ($res as $k => $r) {
						if (isset($_REQUEST['resource_mode']) && trim($_REQUEST['resource_mode']) == trim($k)) {
							$seltext = "selected";
						} else {
							$seltext = "";
						}

				?>
						<option value="<?php echo trim($k); ?>" <?php echo $seltext; ?>><?php echo trim($r); ?></option>
				<?php
					}
				} ?>
			</select>

		</div>
		<div class="form-group col-5">
			<label for="resource_name">Resource Name</label>
			<!--   -->
			
			<?php $res = getEmployees();  ?>
			<div>
				<select data-placeholder="Choose a Employee" class="chosen-select" tabindex="2" name="trainer_resource_name1" id="trainer_resource_name1" style="display: none;">
					<option value="">Select</option>
				<?php if ($res != null) {
					foreach ($res as $k => $r) {
						if (isset($_REQUEST['trainer_request_id']) && trim($_REQUEST['trainer_request_id']) === trim($k)) {
							$seltext = "selected";
						} else {
							$seltext = "";
						}
				?>
						<option value="<?php echo $r->id; ?>" <?php $seltext; ?>><?php echo $r->name; ?></option>
				<?php
					}
				} ?>
	            </select>
        	</div>
			<!-- <div id="trainer_dd"><?php // echo $_REQUEST['trainer_request_id'];?>
			<div class="dropdown-sin-1"  style="display:none;">

			<select class="form-control"  name="trainer_resource_name" id="trainer_resource_name" style="display:none;">
      			<option value="">Select</option>
				<?php if ($res != null) {
					foreach ($res as $k => $r) {
						if (isset($_REQUEST['trainer_request_id']) && trim($_REQUEST['trainer_request_id']) === trim($k)) {
							$seltext = "selected";
						} else {
							$seltext = "";
						}
				?>
						<option value="<?php echo $r->id; ?>" <?php $seltext; ?>><?php echo $r->name; ?></option>
				<?php
					}
				} ?>
			</select>
			</div>
			</div> -->
			<input type="text" class="form-control" id="resource_name" name="resource_name" value="<?php echo isset($_REQUEST['resource_name']) ? $_REQUEST['resource_name'] : "" ?>" required>
		</div>
	
	</div>
	
	<div class="row">
		<div class="form-group col-5">
			<label for="resource_desc">Resource Description</label>
			<textarea class="form-control" id="resource_desc" name="resource_desc" rows="3"><?php
																							if (isset($_REQUEST['resource_desc']) && $_REQUEST['resource_desc'] != "") {
																								echo $_REQUEST['resource_desc'];
																							}
																							?></textarea>
		</div>
		<div class="form-group col-5" id="div_max_attendees">
			<label for="max_no_attendees">Max No of Attendees</label>
			<input type="number" class="form-control" id="max_no_attendees" name="max_no_attendees" placeholder="" default="0" value="<?php echo (isset($_REQUEST['max_no_attendees']) && $_REQUEST['max_no_attendees'] != "" ? $_REQUEST['max_no_attendees'] : '0') ?>">
		</div>
	</div>
	<script>
		<?php if (isset($_REQUEST['resource_mode']) && isset($_REQUEST['resource_subtype_id'])) {
			if ($_REQUEST['resource_subtype_id'] == '3') {
				if ($_REQUEST['resource_mode'] == "INTERNAL") {
		?>
					$("#resource_name").hide();
					//$("#trainer_resource_name").val('<?php echo isset($_REQUEST['trainer_request_id']) ? $_REQUEST['trainer_request_id'] : ""; ?>');
					$("#trainer_resource_name1").val('<?php echo isset($_REQUEST['trainer_request_id']) ? $_REQUEST['trainer_request_id'] : ""; ?>');
					 //$("div.dropdown-sin-1").show();   
					   $("div.chosen-container").show();    
				<?php
				} else {
				?>
				 $("div.dropdown-sin-1").hide();   
					$("#resource_name").show();
					$("#trainer_resource_name").hide();
					  $("div.chosen-container").hide();    
				<?php
				}
				?>
				$('#trainer_div').show();
				  $("div.chosen-container").show();    
			<?php
			} else {
			?>
			 $("div.dropdown-sin-1").hide();   
				$('#trainer_div').hide();
				$("#resource_name").show();
				$("#trainer_resource_name").hide();
				  $("div.chosen-container").hide();    
		<?php
			}
		} ?>
	</script>
		<script>
	/* $('.dropdown-sin-1').dropdown({
      readOnly: true,
	  input: '<input type="text" maxLength="20" placeholder="Search">',
	  searchNoData: '<li style="color:#ddd">No Results</li>',
	  choice:function () {$("#resource_name").val($('#trainer_resource_name').children("option:selected").text());},
    });*/
	
</script>
</fieldset>
<fieldset id="training_center_block">
	<legend>Other Details</legend>
	<div class="row">
		<div class="form-group col-5" id="div_training_provider">
			<label for="training_provider_id">Supplier/Training Provider</label>
			<!-- Training Provider -->
			<?php $res = getTrainingProvider(); //print_r($res); 
			?>
			<select class="form-control" id="training_provider_id" name="training_provider_id">
				<?php if ($res != null) {
					foreach ($res as $k => $r) {
						if (isset($_REQUEST['training_provider']) && trim($_REQUEST['training_provider']) == trim($k)) {
							$seltext = "selected";
						} else {
							$seltext = "";
						}
				?>
						<option value="<?php echo $k; ?>" <?php echo $seltext ?>><?php echo $r ?></option>
				<?php
					}
				} ?>
			</select>
		</div>
		<div class="form-group col-5" id="div_training_center">
			<label for="training_center_id">Training Center</label>
			<!-- Training Center -->
			<?php $res = getTrainingCenter(); //print_r($res); die;
			?>
			<?php //die("here");
			?>
			<select class="form-control" id="training_center_id" name="training_center_id">
				<?php if ($res != null) {
					foreach ($res as $k => $r) {
						if (isset($_REQUEST['training_center']) && trim($_REQUEST['training_center']) == trim($k)) {
							$seltext = "selected";
						} else {
							$seltext = "";
						}
				?>
						<option value="<?php echo $k; ?>" <?php echo $seltext; ?>><?php echo $r ?></option>
				<?php
					}
				}
				?>
			</select>
		</div>
	</div>
	<div class="row">
		<!-- <div class="form-group col-5">
			<label for="address">Address</label>
			<textarea class="form-control" id="address" name="address" rows="3"><?php
																				/*if (isset($_REQUEST['address']) && trim($_REQUEST['address']) != "") {
																					echo $_REQUEST['address'];
																				}*/
																				?></textarea>
		</div> -->
		<div class="form-group col-5">
			<label for="location">Location</label>
			<input type="text" class="form-control" id="location" name="location" placeholder="" value="<?php echo (isset($_REQUEST['location']) && trim($_REQUEST['location']) != "" ? $_REQUEST['location'] : "") ?>">
		</div>
	</div>
	
	<div class="row">
		<div class="form-group col-5">
			<label for="addrline1">Address Line 1</label>
			<input type="text" class="form-control" id="addrline1" name="addrline1" placeholder="" value="<?php echo (isset($_REQUEST['addrline1']) && trim($_REQUEST['addrline1']) != "" ? $_REQUEST['addrline1'] : "") ?>">
		</div>
		<div class="form-group col-5">
			<label for="addrline2">Address Line 2</label>
			<input type="text" class="form-control" id="addrline2" name="addrline2" placeholder="" value="<?php echo (isset($_REQUEST['addrline2']) && trim($_REQUEST['addrline2']) != "" ? $_REQUEST['addrline2'] : "") ?>">
		</div>
	</div>
	<div class="row">
		<div class="form-group col-5">
			<label for="city">City</label>
			<input type="text" class="form-control" id="city" name="city" placeholder="" value="<?php echo (isset($_REQUEST['city']) && trim($_REQUEST['city']) != "" ? $_REQUEST['city'] : "") ?>">
		</div>
		<div class="form-group col-5">
			<label for="pincode">Pincode</label>
			<input type="number" class="form-control" id="pincode" name="pincode" placeholder="" value="<?php echo (isset($_REQUEST['pincode']) && trim($_REQUEST['pincode']) != "" ? $_REQUEST['pincode'] : "") ?>">
		</div>
	</div>
	<div class="row">
		<div class="form-group col-5">
			<label for="country">Country</label>
			<?php $rs = getCountries(); ?>
			<select name="country" id="country" class="form-control">
				<?php foreach ($rs as $k => $r) {
					if (isset($_REQUEST['country']) && trim($_REQUEST['country']) == trim($k)) {
						$seltext = "selected";
					} else {
						$seltext = "";
					}
				?>

					<option value="<?php echo $k; ?>" <?php echo $seltext; ?>><?php echo $r; ?></option>
				<?php } ?>
			</select>
		</div>
		<div class="form-group col-5">
			<label for="state">State</label>
			<?php
			if (isset($_REQUEST['country']) && trim($_REQUEST['country']) != "") {
				$rs = getStates($_REQUEST['country']);
			} else {
				$rs = getStates(0);
			} ?>
			<select name="state" id="state" class="form-control">
				<?php foreach ($rs as $k => $r) {
					if (isset($_REQUEST['state']) && trim($_REQUEST['state']) == trim($k)) {
						$seltext = "selected";
					} else {
						$seltext = "";
					}
				?>
					<option value="<?php echo $k; ?>" <?php echo $seltext; ?>><?php echo $r; ?></option>
				<?php } ?>
			</select>
		</div>
	</div>
	<div class="row" id="div_google_map">
		<div class="form-group col-5">
			<label for="google_map_lat">Google Map Latitude</label>
			<input type="number" class="form-control" id="google_map_lat" name="google_map_lat" placeholder="" value="<?php echo (isset($_REQUEST['google_map_lat']) && trim($_REQUEST['google_map_lat']) != "" ? $_REQUEST['google_map_lat'] : ""); ?>">
			<button type="button" id="btnid">Show on Map</button>
		</div>
		<div class="form-group col-5">
			<label for="google_map_long">Google Map Longitude</label>
			<input type="number" class="form-control" id="google_map_long" name="google_map_long" placeholder="" value="<?php echo (isset($_REQUEST['google_map_long']) && trim($_REQUEST['google_map_long']) != "" ? $_REQUEST['google_map_long'] : ""); ?>">
		</div>
	</div>
	<div id="showmap">
		<div id="map" class="form-group col-10" style=" width:600px; height: 300px; display:none;"></div>
	</div>
	<div class="row" id="div_seating">
		<div class="form-group col-5">
			<label for="default_seating">Default Seating Orientation</label>
			<!-- get Seating Orientation -->
			<?php $res = getSeatingOrientation(); ?>
			<select class="form-control" id="default_seating" name="default_seating">
				<option value="" data-path="./images/seating-orientation/no-image.png">Select</option>
				<?php if ($res != null) {
					foreach ($res as $k => $r) {
						if (isset($_REQUEST['default_seating_arrangement']) && trim($_REQUEST['default_seating_arrangement']) == trim($k)) {
							$seltext = "selected";
							$seating_image =  $r->classimage;
						} else {
							$seltext = "";
						}
				?>
						<option value="<?php echo $r->id; ?>" data-path="<?php echo $r->classimage; ?>" <?php echo $seltext; ?>><?php echo $r->seating_name ?></option>
				<?php
					}
				}
				?>
			</select>
			<label for="reference">Reference</label>
			<textarea class="form-control" id="reference" name="reference" placeholder=""><?php
																							if (isset($_REQUEST['reference']) && trim($_REQUEST['reference']) !== "") {
																								echo $_REQUEST['reference'];
																							}
																							?></textarea>

		</div>
		<div class="form-group col-5">
			<div id="imgseating">
				<?php
				if (isset($seating_image) && trim($seating_image) != "") {
					$seating_image = $seating_image;
				} else {
					$seating_image = "./images/seating-orientation/no-image.png";
				}
				?>
				<img src="<?php echo $seating_image; ?>" width="150" height="150" id="imageseating">
			</div>

		</div>

	</div>
	<div class="row">
		<div class="form-group col-5">
			<label for="start_date">Start Availability Date</label>
			<input type="date" class="form-control" id="start_date" name="start_date" placeholder="" value="<?php echo (isset($_REQUEST['startdate']) && trim($_REQUEST['startdate']) != "" ? date("Y-m-d", strtotime($_REQUEST['startdate'])) : ""); ?>" >
		</div>
		<div class="form-group col-5">
			<label for="end_date">End Availability Date</label>
			<input type="date" class="form-control" id="end_date" name="end_date" placeholder="" value="<?php echo (isset($_REQUEST['enddate']) && trim($_REQUEST['enddate']) != "" ? date("Y-m-d", strtotime($_REQUEST['enddate'])) : ""); ?>" >
		</div>
	</div>
	<div class="row" id="div_price">
		<div class="form-group col-5">
			<label for="default_price">Default Price</label>
			<input type="number" class="form-control" id="default_price" name="default_price" placeholder="" value="<?php echo (isset($_REQUEST['default_price']) && trim($_REQUEST['default_price']) != "" ? $_REQUEST['default_price'] : ""); ?>">
		</div>
		<div class="form-group col-5">
			<label for="default_price_unit">Default Price Unit</label>
			<!-- Deafault Price Unit -->
			<?php $res = getPriceUnit(); ?>
			<select class="form-control" id="default_price_unit" name="default_price_unit">
				<?php if ($res != null) {
					foreach ($res as $k => $r) {
						if (isset($_REQUEST['default_price_unit']) && trim($_REQUEST['default_price_unit']) == trim($k)) {
							$seltext = "selected";
						} else {
							$seltext = "";
						}
				?>
						<option value="<?php echo $k; ?>" <?php echo $seltext; ?>><?php echo $r ?></option>
				<?php
					}
				}
				?>
			</select>
		</div>
	</div>
<div class="row" id="div_booking">
	<div class="form-group col-5">
		<label for="booking_instruction">Booking Instruction</label>
		<textarea class="form-control" id="booking_instruction" name="booking_instruction" rows="3"><?php
																									if (isset($_REQUEST['booking_instruction']) && trim($_REQUEST['booking_instruction']) != "") {
																										echo $_REQUEST['booking_instruction'];
																									}
																									?></textarea>
	</div>
	</div>
	<div class="row" id="div_overbookingflag">
	<div class="form-group col-5">
		<label for="overbookingflag">
			<?php
			if (isset($_REQUEST['overbooking_flag']) && trim($_REQUEST['overbooking_flag']) == 1) {
				$seltext = "checked";
			} else {
				$seltext = "";
			}
			?>
			<input type="checkbox" id="overbookingflag" name="overbookingflag" value="yes" <?php echo $seltext ?>> Allow Warning/Error on Overbooking
		</label>
	</div>
	</div>
</fieldset>

<fieldset id="contact_details_block">
	<legend>Contact Details</legend>
	<div class="row">
		<div class="form-group col-4">
			<label for="contact_name">Name</label>
			<input type="text" class="form-control" id="contact_name" name="contact_name" placeholder="" value="<?php echo (isset($_REQUEST['contact_name']) && trim($_REQUEST['contact_name']) != "" ? $_REQUEST['contact_name'] : ""); ?>">
		</div>
		<div class="form-group col-4">
			<label for="contact_email">Email</label>
			<input type="email" class="form-control" id="contact_email" name="contact_email" placeholder="" value="<?php echo (isset($_REQUEST['contact_email']) && trim($_REQUEST['contact_email']) != "" ? $_REQUEST['contact_email'] : ""); ?>">
		</div>
		<div class="form-group col-4">
			<label for="contact_phone_mobile">Phone/Mobile</label>
			<input type="text" class="form-control" id="contact_phone_mobile" name="contact_phone_mobile" placeholder="" value="<?php echo (isset($_REQUEST['contact_phone_mobile']) && trim($_REQUEST['contact_phone_mobile']) != "" ? $_REQUEST['contact_phone_mobile'] : ""); ?>">
		</div>
	</div>
	<div class="row" id="trainer_div" style="display:none;">
		<div class="form-group col-5">
			<label for="trainer_brief">Brief About Trainer</label>
			<textarea class="form-control" id="trainer_brief" name="trainer_brief" rows="3"><?php
																							if (isset($_REQUEST['brief_about_trainer']) && trim($_REQUEST['brief_about_trainer']) != "") {
																								echo $_REQUEST['brief_about_trainer'];
																							}
																							?></textarea>
		</div>
		<div class="form-group col-5">
			<label for="trainer_sign">Trainer Sign</label>
			<textarea class="form-control" id="trainer_sign" name="trainer_sign" rows="3"><?php
																							if (isset($_REQUEST['trainer_sign']) && trim($_REQUEST['trainer_sign']) != "") {
																								echo $_REQUEST['trainer_sign'];
																							}
																							?></textarea>
		</div>
	</div>
</fieldset>

<fieldset id="attachment_block">
	<legend>Attachment Details</legend>
	<div class="row">
		<!-- <div class="form-group col-5">
							<label for="attachment_type">Attachment Type</label>
							<select class="form-control" id="attachment_type" name="attachment_type">
								<option>1</option>
								<option>2</option>
								<option>3</option>
								<option>4</option>
								<option>5</option>
							</select>
						</div> -->
		<div class="form-group col-12">
			<label for="attachment_file">Attachment Files</label>
			<div class="alert alert-info" id= 'showattmsg' style="display:none;"></div>
			<div id ="div_attachment_files">
				
			<?php if (isset($_REQUEST['attachment']) && $_REQUEST['attachment'] != "") {
				//$attachment_fileids = $_REQUEST['attachment'];
				//echo "<BR><a href='" . $attachment_file . "' target='_blank'>Attachment File</a>";
				echo get_resource_attachments($_REQUEST['id']);
			} else {
				//$attachment_file = '';
			}
			
			?>
			</div>
			<input type="hidden" name="attachment_file_path" id="attachment_file_path" value="<?php echo $attachment_file; ?>">
			<input type="file" class="form-control" id="attachment_file" name="attachment_file[]" placeholder="" multiple>
		</div>
	</div>
</fieldset>
<?php if(isset($_REQUEST['resource_type_id']) && $_REQUEST['resource_type_id']!=''){
?>
<script>
	var tid = '<?php echo $_REQUEST['resource_type_id']; ?>';
	if(tid =='2'){
		$("#div_max_attendees").hide();
        $("#div_training_center").hide();
        $("#div_training_provider").hide();
        $("#div_google_map").hide();
        $("#showmap").hide();
        $("#div_seating").hide();
        $("#div_price").hide();
        $("#div_booking").hide();
        $("#div_overbookingflag").hide();
    }
    else{
      //  alert("in else");
        $("#div_max_attendees").show();
        $("#div_training_center").show();
        $("#div_training_provider").show();
        $("#div_google_map").show();
        $("#showmap").show();
        $("#div_seating").show();
        $("#div_price").show();
        $("#div_booking").show();
        $("#div_overbookingflag").show();
    }
</script>
<?php } ?>
 <!-- <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.7.1/jquery.min.js"></script> -->
 <script src="<?php echo $CFG->wwwroot; ?>/mod/zingilt/resourcemgmt/scripts/select2/chosen.jquery.js"></script>
  <script>
      $(function() {
        $('.chosen-select').chosen();  
        $("div.chosen-container").hide();  
        $(".chosen-select").chosen().change(function() {
    		//alert($(this).val()+"====="+$(this).children("option:selected").text());
    		//$('#' + $(this).val()).show();
    		 $("#resource_name").val($(this).children("option:selected").text());
		});
<?php if (isset($_REQUEST['resource_mode']) && isset($_REQUEST['resource_subtype_id'])) {
			if ($_REQUEST['resource_subtype_id'] == '3') {
				if ($_REQUEST['resource_mode'] == "INTERNAL") {
		?>
					$("#resource_name").hide();
					//$("#trainer_resource_name").val('<?php echo isset($_REQUEST['trainer_request_id']) ? $_REQUEST['trainer_request_id'] : ""; ?>');
					
					 //$("div.dropdown-sin-1").show();   
					   $("div.chosen-container").show();   

				<?php
				} else {
				?>
				 $("div.dropdown-sin-1").hide();   
					$("#resource_name").show();
					$("#trainer_resource_name").hide();
					  $("div.chosen-container").hide();    
				<?php
				}
				?>
				$('#trainer_div').show();
				  $("div.chosen-container").show();    
			<?php
			} else {
			?>
			 $("div.dropdown-sin-1").hide();   
				$('#trainer_div').hide();
				$("#resource_name").show();
				$("#trainer_resource_name").hide();
				  $("div.chosen-container").hide();    
		<?php
			}
		} ?>
      });
      document.getElementById('trainer_resource_name1').value = '<?php echo isset($_REQUEST['trainer_request_id']) ? $_REQUEST['trainer_request_id'] : ""; ?>';
					    $('#trainer_resource_name1').trigger('chosen:updated');
    </script>