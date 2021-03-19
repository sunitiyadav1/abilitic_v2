<?php 
global $DB;
if(isset($_REQUEST['action']) && $_REQUEST['action'] == "edit" && isset($_REQUEST['t']) && $_REQUEST['t'] != null && $_REQUEST['t'] > 0)
{
	/*$sql = 'SELECT t.id,GROUP_CONCAT(DISTINCT(concat(u.firstname," ",u.lastname))) as name,t.*,GROUP_CONCAT(distinct(f.file_name)) as filelist 
                    FROM mdl_trainingform as t 
                    join mdl_trainingform_files as f on t.id=f.trainingformid 
                    join mdl_trainingform_user_files as tu on (t.id= tu.trainingformid and f.id = tu.fileid) 
                    join mdl_user as u on tu.userid =u.id 
                    where t.id ='.$_REQUEST['t'].'
                    group by t.id
					ORDER BY `u`.`id` ASC';*/
				
               // echo $sql;
			//	$rs = $DB->get_record_sql($sql);
			$rs = $DB->get_record("trainingform",array('id'=>$_REQUEST['t'],"deleted"=>0));
			//echo "<pre>";
				//print_r($rs);
				
}
?>
<style>
	label.error {
		color: red;
	}

	.select2-container--default .select2-selection--multiple {
		width: 420px;
	}
	#trainingform{
		margin-left: 25px;
	}
</style>
<form name="trainingform" id="trainingform" method="post" enctype="multipart/form-data" action="submit_trainingform.php">
	<fieldset id="external_block">
	<input type="hidden" name="formtype" id="formtype" value="EXTERNAL">
	<input type = "hidden" name ="action" id="action" value="edit">
	<input type = "hidden" name ="trainingformid" id="trainingformid" value="<?php echo $rs->id; ?>">
	<input type = "hidden" name ="existing_userids" id="existing_userids" value="<?php echo $rs->userid; ?>">
	<input type = "hidden" name ="existing_fileids" id="existing_fileids" value="<?php echo $rs->certificate_file; ?>">
		<!-- <legend>Log External Team</legend> -->
		<div id="external_div">
			<div class="row">
				<div class="form-group col-12">
					<div class="col-md-12">
						<label for="userid"> <?php echo get_string('emp_name', 'local_trainingform'); ?></label>
					</div>
					<!-- emp id -->
					<div class="col-sm-6">
						<?php $res = getAllEmployees();
							if($rs->userid != ''){
								$seluserid = explode(",",$rs->userid);
								//print_r($seluserid);
							}
						?>
						<select class="form-control" id="ex_userid" name="ex_userid[]" required multiple="multiple">
							<?php
							if ($res != null) {
								foreach ($res as $k => $r) {
							?>
									<option value="<?php echo trim($k); ?>" <?php echo ((in_array($k, $seluserid))==true?"selected":""); ?>> <?php echo trim($r); ?></option>
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
						<input list="list_training_program_name" type="text" class="form-control" name="training_program_name" id="training_program_name" value="<?php echo $rs->training_program_name; ?>" required>
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
						<input list="list_training_duration" type="number" class="form-control" name="training_duration" id="training_duration" value="<?php echo $rs->training_duration;?>" required>
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
						<input list="list_training_provider_name" type="text" class="form-control" name="training_provider_name" id="training_provider_name" value="<?php echo $rs->training_provider_name; ?>" required>
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
						<input type="date" class="form-control" name="ex_start_date" id="ex_start_date" value="<?php echo date("Y-m-d",$rs->start_date);?>" required>
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
						<input type="date" class="form-control" name="ex_end_date" id="ex_end_date" value="<?php echo date("Y-m-d",$rs->end_date);?>" required>
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
							<option value="1" <?php echo ($rs->is_certification_program == '1'?"selected":""); ?>>No</option>
							<option value="0" <?php echo ($rs->is_certification_program == '0'?"selected":""); ?>>Yes</option>
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
						Add New : <input type="file" class="form-control" accept="*" name="doc_file[]" id="doc_file[]" value="<?php echo explode(",",$rs->certificate_file); ?>" onChange="validate(this.value)" required multiple="multiple">
						<BR>
						<div id="existing_filemsg" class="alert alert-danger" style="display:none;"></div>
						<div id="existing_file_div">
						 <?php echo getExistingfileList($rs->id); ?>
						</div>
					</div>
				</div>
			</div>
		</div>
	</fieldset>
	<fieldset id="button_block">
		<input type="submit" name="btn_edit_submit" id="btn_edit_submit" value="Submit" class="btn btn-primary">
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
	$sql = "Select distinct(" . $fieldname . ") from {trainingform} where " . $fieldname . " !='' and deleted =0";
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