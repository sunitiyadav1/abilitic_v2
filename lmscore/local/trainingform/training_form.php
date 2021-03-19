<style>
	label.error {
		color: red;
	}

	.select2-container--default .select2-selection--multiple {
		width: 420px;
	}
</style>
<form name="trainingform" id="trainingform" method="post" enctype="multipart/form-data" action="submit_trainingform.php">
	<fieldset id="general_block">
		<!-- <legend>General</legend> -->
		<div class="row">
        <div>
            <div tabindex="0">
                <span class="office-form-notice-long-text">Hi <?php echo $USER->firstname. ' '.$USER->lastname; ?>, when you submit this form, the owner will be able to see your name and email address.</span>
            </div>
        </div>
        <div><span class="office-form-required-notice-star"></span>
            <span class="info">Required</span></div>
    </div>
		<div class="row">
			<div class="form-group col-12">
				<div class="col-md-12">
					<label for="formtype"><?php echo get_string('trainingform', 'local_trainingform'); ?></label>
				</div>
				<!--  Training Form -->
				<div class="col-sm-6">
					<select class="form-control select2" id="formtype" name="formtype" required>
						<!--<option value="">Select</option>
						 <option value="INTERNAL"><?php //echo get_string('nominate_your_team', 'local_trainingform'); ?></option> -->
						<option value="EXTERNAL"><?php echo get_string('log_external_team', 'local_trainingform'); ?></option>
					</select>
				</div>
			</div>
		</div>
	</fieldset>
	
	<fieldset id="internal_block">
		<!-- <legend>Nominate Your Team</legend> -->
		<div id="internal_div">
			<div class="row">
				<div class="form-group col-12">
					<div class="col-md-12">
						<label for="courseid">2.<?php echo get_string('course_name', 'local_trainingform'); ?></label>
					</div>
					<!-- courseid -->
					<div class="col-sm-6">
						<?php $res = getAllCourses();  ?>
						<select class="form-control" id="courseid" name="courseid[]" required multiple="multiple">
							<?php if ($res != null) {
								foreach ($res as $k => $r) {
							?>
									<option value="<?php echo trim($k); ?>"><?php echo trim($r); ?></option>
							<?php
								}
							} ?>
						</select>
					</div>
				</div>
			</div>
			<div class="row">
				<div class="form-group col-12">
					<div class="col-md-12">
						<label for="start_date">3. <?php echo get_string('start_date', 'local_trainingform'); ?> </label>
					</div>
					<div class="col-sm-6">
						<!-- start Date  -->
						<input type="date" class="form-control" dateformat="d M y" name="in_start_date" id="in_start_date" value="" required>
					</div>
				</div>
			</div>
			<div class="row">
				<div class="form-group col-12">
					<div class="col-md-12">
						<label for="end_date">4. <?php echo get_string('end_date', 'local_trainingform'); ?></label>
					</div>
					<div class="col-sm-6">
						<!-- start Date  -->
						<input type="date" class="form-control" dateformat="d M y" name="in_end_date" id="in_end_date" value="" required>
					</div>
				</div>
			</div>
			<div class="row">
				<div class="form-group col-12">
					<div class="col-md-12">
						<label for="userid">5. <?php echo get_string('emp_name', 'local_trainingform'); ?></label>
					</div>
					<!-- emp id -->
					<!-- <input list="list_userid" class="form-control" id="in_userid" name="in_userid" required>
					<input type="hidden" id="in_uid" name="in_uid" value=""> -->
					<div class="col-sm-6">
						<?php $res = getAllEmployees();  ?>
						<select class="form-control" id="in_userid" name="in_userid[]" required multiple="multiple">
							<?php
							if ($res != null) {
								foreach ($res as $k => $r) {
							?>
									<option value="<?php echo trim($k); ?>"> <?php echo trim($r); ?></option>
							<?php
								}
							} ?>
						</select></div>

				</div>
			</div>
		</div>
	</fieldset>
	<fieldset id="external_block">
		<!-- <legend>Log External Team</legend> -->
		<div id="external_div">
			<div class="row">
				<div class="form-group col-12">
					<div class="col-md-12">
						<label for="userid"> <?php echo get_string('emp_name', 'local_trainingform'); ?></label>
					</div>
					<!-- <input id="autocomplete" type="text" />
					<input list="list_userid" type="text" id="ex_userid" name="ex_userid" required class="form-control">
					<input type="hidden" name="ex_uid" id="ex_uid" value=""> -->
					<!-- emp id -->
					<div class="col-sm-6">
						<?php $res = getAllEmployees();  ?>
						<select class="form-control" id="ex_userid" name="ex_userid[]" required multiple="multiple">
							<?php
							if ($res != null) {
								foreach ($res as $k => $r) {
							?>
									<option value="<?php echo trim($k); ?>"> <?php echo trim($r); ?></option>
							<?php
								}
							} ?>
						</select>
					</div>
				</div>
			</div>
			<div class="row">
				<div class="form-group col-12">
					<div class="col-md-12">
						<label for="training_program_name"> <?php echo get_string('training_program_name', 'local_trainingform'); ?> </label>
						<?php getAllFields("training_program_name"); ?>
					</div>
					<div class="col-sm-6">
						<!-- Training Program Name  -->
						<input list="list_training_program_name" type="text" class="form-control" name="training_program_name" id="training_program_name" value="" required>
					</div>
				</div>
			</div>
			<div class="row">
				<div class="form-group col-12">
					<div class="col-md-12">
						<?php getAllFields("training_duration"); ?>
						<label for="training_duration"> <?php echo get_string('training_duration', 'local_trainingform'); ?> </label>
					</div>
					<div class="col-sm-6">
						<!-- Training Duration  -->
						<input list="list_training_duration" type="number" class="form-control" name="training_duration" id="training_duration" value="" required>
					</div>
				</div>
			</div>
			<div class="row">
				<div class="form-group col-12">
					<div class="col-md-12">
						<?php getAllFields("training_provider_name"); ?>
						<label for="training_provider_name"> <?php echo get_string('training_provider_name', 'local_trainingform'); ?></label>
					</div>
					<div class="col-sm-6">
						<!-- Training Provider Name  -->
						<input list="list_training_provider_name" type="text" class="form-control" name="training_provider_name" id="training_provider_name" value="" required>
					</div>
				</div>
			</div>
			
			<div class="row">
				<div class="form-group col-5">
					<div class="col-md-12">
						<label for="start_date"> <?php echo get_string('training_start_date', 'local_trainingform'); ?> </label>
					</div>
					<div class="col-sm-6">
						<!-- start Date  -->
						<input type="date" class="form-control" name="ex_start_date" id="ex_start_date" value="" required>
					</div>
				</div>
			</div>
			<div class="row">
				<div class="form-group col-5">
					<div class="col-md-12">
						<label for="end_date"><?php echo get_string('training_end_date', 'local_trainingform'); ?> </label>
					</div>
					<div class="col-sm-6">
						<!-- start Date  -->
						<input type="date" class="form-control" name="ex_end_date" id="ex_end_date" value="" required>
					</div>
				</div>
			</div>
			<div class="row">
				<div class="form-group col-12">
					<div class="col-md-12">
						<label for="is_certification_program"> <?php echo get_string('is_certification_program', 'local_trainingform'); ?> </label>
					</div>
					<!-- Is it a Certification Program?  -->
					<div class="col-sm-6">
						<!-- <input type="text" name="is_certification_program" id="is_certification_program" value=""> -->
						<select class="form-control" name="is_certification_program" id="is_certification_program" required>
							<option value="1">No</option>
							<option value="0">Yes</option>
						</select>
					</div>
				</div>
			</div>
			
			<div class="row" id="certificate_div">
				<div class="form-group col-12">
					<div class="col-md-12">
						<label for="certificate_file"> <?php echo get_string('upload_certificate', 'local_trainingform'); ?> </label>
					</div>
					<div class="col-sm-6">
						<!-- Upload Certificate (Non-anonymous question)  -->
						<input type="file" class="form-control" accept="*" name="certificate_file[]" id="certificate_file[]" value="" onChange="validate(this.value)" required multiple="multiple">
						<!-- <span style="font-size:10px;"><?php //echo get_string('certificate_file_instr', 'local_trainingform'); ?></span> -->

						<!-- <div class="upload_box">
							<form name="fileUpload" id="fileUpload" action="javascript:void(0);" enctype="multipart/form-data">
							<div class="file_browser"><input type="file" name="multiple_files[]" id="_multiple_files" class="hide_broswe" multiple /></div>
							<div class="file_upload"><input type="submit" value="Upload" class="upload_button" /> </div>
							</form>
						</div>	


						<div class="file_boxes">

						</div>
						<span id="removed_files"></span>
 -->



					</div>
				</div>
			</div>
		</div>
	</fieldset>
	<fieldset id="button_block">
		<input type="submit" name="btn_submit" id="btn_submit" value="Submit" class="btn btn-primary">
	</fieldset>
</form>
<?php

function getAllEmployees()
{
	global $DB;
	$sql = "select * from {user} where deleted != 1 and id >2";
	$rs = $DB->get_records_sql($sql);
	$arr = [];
	if ($rs != null) {
		$arr[''] = 'Select';
		foreach ($rs as $r) {
			$arr[$r->id] = $r->firstname . ' ' . $r->lastname . ' [' . $r->username . ']';
		}
	}
	return $arr;
}
function getAllCourses()
{
	global $DB;
	$rs = get_courses();
	$arr = [];
	if ($rs != null) {
		$arr[''] = 'Select';
		foreach ($rs as $r) {
			$arr[$r->id] = $r->fullname;
		}
	}
	return $arr;
}
function getAllFields($fieldname)
{
	global $DB;
	$sql = "Select distinct(" . $fieldname . ") from {trainingform} where " . $fieldname . " !=''";
	$rs = $DB->get_records_sql($sql);
	//print_r($rs);
	echo '<datalist id="list_' . $fieldname . '">';
	if ($rs != null) {
		foreach ($rs as $r) {
			echo '<option value="' . $r->$fieldname . '">';
		}
	}
	echo '</datalist>';
}
