<?php
require_once("lib.php");
if (isset($_REQUEST) && $_REQUEST != null) {
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
<input type="hidden" name="formaction" id="formaction" value="<?php echo $_REQUEST['action']; ?>">
<input type="hidden" name="tprovider_id" id="tprovider_id" value="<?php echo (isset($_REQUEST['id']) ? $_REQUEST['id'] : 0); ?>">
<fieldset id="general_block">
	<legend>General</legend>
	<div class="row">
		<div class="form-group col-5">
			<label for="tprovider_name">Training Provider Name</label>
			<input type="text" class="form-control" id="tprovider_name" name="tprovider_name" placeholder="" default="0" value="<?php echo (isset($_REQUEST['name']) && $_REQUEST['name'] != "" ? $_REQUEST['name'] : '') ?>">
		</div>
	</div>
	<div class="row">
		<div class="form-group col-6">
			<label for="tprovider_desc">Training Provider Description</label>
			<textarea class="form-control" id="tprovider_desc" name="tprovider_desc" rows="5"><?php
																								if (isset($_REQUEST['description']) && $_REQUEST['description'] != "") {
																									echo $_REQUEST['description'];
																								}
																								?></textarea>
		</div>
	</div>
	<div class="row">
		<div class="form-group col-5">
			<label for="is_active">
				<?php
				if (isset($_REQUEST['is_active']) && trim($_REQUEST['is_active']) == 1) {
					$seltext = "checked";
				} else {
					$seltext = "";
				}
				?>
				<input type="checkbox" id="is_active" name="is_active" value="yes" <?php echo $seltext ?>> Active
			</label>
		</div>
	</div>
</fieldset>