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

.autocomplete {
  /*the container must be positioned relative:*/
  position: relative;
  display: inline-block;
}

.autocomplete-items {
  position: absolute;
  border: 1px solid grey;
  /* height: 150px;
    overflow-y: scroll; */
  border-bottom: none;
  border-top: none;
  z-index: 99;
  /*position the autocomplete items to be the same width as the container:*/
  top: 100%;
  left: 0;
  right: 0;
}
.autocomplete-items div {
  padding: 10px;
  cursor: pointer;
  background-color: #fff;
  border-bottom: 1px solid #d4d4d4;
}
.autocomplete-items div:hover {
  /*when hovering an item:*/
  background-color: #e9e9e9;
}
.autocomplete-active {
  /*when navigating through the items using the arrow keys:*/
  background-color: DodgerBlue !important;
  color: #ffffff;
}
</style>
<!-- <link href="<?php //echo new moodle_url('/mod/zingilt/resourcemgmt/scripts/jquery-autocomplete/jquery-autocomplete.css');?>"> -->
<input type="hidden" name="formaction" id="formaction" value="<?php echo $_REQUEST['action']; ?>">
<input type="hidden" name="tcenter_id" id="tcenter_id" value="<?php echo (isset($_REQUEST['id']) ? $_REQUEST['id'] : 0); ?>">
<fieldset id="general_block">
	<legend>General</legend>
	<div class="row">
		<div class="form-group col-5">
			<label for="tcenter_name">Training Center Name</label>
			<input type="text" class="form-control" id="tcenter_name" name="tcenter_name" placeholder="" default="0" value="<?php echo (isset($_REQUEST['name']) && $_REQUEST['name'] != "" ? $_REQUEST['name'] : '') ?>">
		</div>
	</div>
	<div class="row">
		<div class="form-group col-6">
			<label for="tcenter_desc">Training Center Description</label>
			<textarea class="form-control" id="tcenter_desc" name="tcenter_desc" rows="5"><?php
																							if (isset($_REQUEST['description']) && $_REQUEST['description'] != "") {
																								echo $_REQUEST['description'];
																							}
																							?></textarea>
		</div>
	</div>
	<div class="row">

		<div class="form-group col-5">
			<label for="location">Location</label>
			<input type="text" class="form-control" id="location" name="location" placeholder="" value="<?php echo (isset($_REQUEST['location']) && trim($_REQUEST['location']) != "" ? $_REQUEST['location'] : "") ?>">
		</div>
		<div class="form-group col-5">
			<label for="workers_total">Total Workers</label>
			<input type="number" class="form-control" id="workers_total" name="workers_total" placeholder="" value="<?php echo (isset($_REQUEST['workers_total']) && trim($_REQUEST['workers_total']) != "" ? $_REQUEST['workers_total'] : ""); ?>">
		</div>
		<!--<div class="form-group col-5">
			<label for="address">Address</label>
			<textarea class="form-control" id="address" name="address" rows="3"><?php
																			/*	if (isset($_REQUEST['address']) && trim($_REQUEST['address']) != "") {
																					echo $_REQUEST['address'];
																				}*/
																				?></textarea>
		</div>-->
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
	<!--	<div class="row">
						<div class="form-group col-5">
							<label for="google_map_lat">Google Map Latitude</label>
							<input type="number" class="form-control" id="google_map_lat" name="google_map_lat" placeholder="" value="<?php echo (isset($_REQUEST['google_map_lat']) && trim($_REQUEST['google_map_lat']) != "" ? $_REQUEST['google_map_lat'] : ""); ?>">
							<button type="button" id="btnid" >Show on Map</button>
						</div>
						<div class="form-group col-5">
							<label for="google_map_long">Google Map Longitude</label>
							<input type="number" class="form-control" id="google_map_long" name="google_map_long" placeholder="" value="<?php echo (isset($_REQUEST['google_map_long']) && trim($_REQUEST['google_map_long']) != "" ? $_REQUEST['google_map_long'] : ""); ?>">							
						</div>
					</div>
					<div  id="showmap">					
					<div id="map" class="form-group col-10" style=" width:600px; height: 300px; display:none;"></div>
					</div>-->
	<div class="row">
		<div class="form-group col-5">
			<label for="tax_type_id">Tax Type</label>
			<?php $rs =  getTaxType(0); ?>
			<select name="tax_type_id" id="tax_type_id" class="form-control">
			<?php foreach ($rs as $k => $r) {
					if (isset($_REQUEST['tax_type_id']) && trim($_REQUEST['tax_type_id']) == trim($k)) {
						$seltext = "selected";
					} else {
						$seltext = "";
					}
				?>
					<option value="<?php echo $k; ?>" <?php echo $seltext; ?>><?php echo $r; ?></option>
				<?php } ?>
			</select>
		</div>
		<?php 
			if (isset($_REQUEST['tax_type_id']) && trim($_REQUEST['tax_type_id']) == "1") {
				$gstdiv = "";
				$vatdiv = 'style="display:none;';
			}
			else if (isset($_REQUEST['tax_type_id']) && trim($_REQUEST['tax_type_id']) == "2") {
				$vatdiv = "";
				$gstdiv = 'style="display:none;';
			}
			else{
				$vatdiv = 'style="display:none;';
				$gstdiv = 'style="display:none;';
			}
		?>
		<div class="form-group col-5" id="vat_div" <?php echo $vatdiv; ?>>
			<label for="vat_registration_no">VAT Registration No</label>
			<input type="text" class="form-control" id="vat_registration_no" name="vat_registration_no" placeholder="" value="<?php echo (isset($_REQUEST['vat_registration_no']) && trim($_REQUEST['vat_registration_no']) != "" ? $_REQUEST['vat_registration_no'] : ""); ?>">
		</div>
		<div class="form-group col-5" id="tax_div" <?php echo $gstdiv; ?>>
			<label for="tax_identification_no">Tax Identification No</label>
			<input type="text" class="form-control" id="tax_identification_no" name="tax_identification_no" placeholder="" value="<?php echo (isset($_REQUEST['tax_identification_no']) && trim($_REQUEST['tax_identification_no']) != "" ? $_REQUEST['tax_identification_no'] : ""); ?>">
		</div>
	</div>
	<div class="row">
		<div class="form-group col-5">
			<label for="deputy_name1">Deputy Name 1</label>
			<input type="text" class="form-control" id="deputy_name1" name="deputy_name1" placeholder="" value="<?php echo (isset($_REQUEST['deputy_name1']) && trim($_REQUEST['deputy_name1']) != "" ? $_REQUEST['deputy_name1'] : ""); ?>">
		</div>
		<div class="form-group col-5">
			<label for="deputy_mobile1">Deputy Mobile 1</label>
			<input type="text" class="form-control" id="deputy_mobile1" name="deputy_mobile1" placeholder="" value="<?php echo (isset($_REQUEST['deputy_mobile1']) && trim($_REQUEST['deputy_mobile1']) != "" ? $_REQUEST['deputy_mobile1'] : ""); ?>">
		</div>
	</div>
	<div class="row">
		<div class="form-group col-5">
			<label for="deputy_name2">Deputy Name 2</label>
			<input type="text" class="form-control" id="deputy_name2" name="deputy_name2" placeholder="" value="<?php echo (isset($_REQUEST['deputy_name2']) && trim($_REQUEST['deputy_name2']) != "" ? $_REQUEST['deputy_name2'] : ""); ?>">
		</div>
		<div class="form-group col-5">
			<label for="deputy_mobile2">Deputy Mobile 2</label>
			<input type="text" class="form-control" id="deputy_mobile2" name="deputy_mobile2" placeholder="" value="<?php echo (isset($_REQUEST['deputy_mobile2']) && trim($_REQUEST['deputy_mobile2']) != "" ? $_REQUEST['deputy_mobile2'] : ""); ?>">
		</div>
	</div>
	<div class="row">
		<div class="form-group col-5">
			<label for="deputy_name3">Deputy Name 3</label>
			<input type="text" class="form-control" id="deputy_name3" name="deputy_name3" placeholder="" value="<?php echo (isset($_REQUEST['deputy_name3']) && trim($_REQUEST['deputy_name3']) != "" ? $_REQUEST['deputy_name3'] : ""); ?>">
		</div>
		<div class="form-group col-5">
			<label for="deputy_mobile3">Deputy Mobile 3</label>
			<input type="text" class="form-control" id="deputy_mobile3" name="deputy_mobile3" placeholder="" value="<?php echo (isset($_REQUEST['deputy_mobile3']) && trim($_REQUEST['deputy_mobile3']) != "" ? $_REQUEST['deputy_mobile3'] : ""); ?>">
		</div>
	</div>
	<div class="row">
		<div class="form-group col-5">
			<label for="taggroup"> Tag/Group</label>
			<input type="text" autocomplete="off" class="autocomplete form-control" id="taggroup" name="taggroup" placeholder="" value="<?php echo (isset($_REQUEST['taggroup']) && trim($_REQUEST['taggroup']) != "" ? $_REQUEST['taggroup'] : ""); ?>">
		</div>		
	</div>
</fieldset>
<?php 
$sql ="select distinct taggroup from {training_center}";
$rs = $DB->get_records_sql($sql);
$arr= array();
if($rs != null){
	foreach($rs as $r){
		$arr[]=$r->taggroup;
	}
}

// echo json_encode($arr);
// print_r((array)$rs);
?>
<script src="<?php echo new moodle_url('/mod/zingilt/resourcemgmt/scripts/jquery-autocomplete/jquery-autocomplete.js');?>"></script>
<script>
	/*An array containing all the country names in the world:*/
	//var countries = ["Afghanistan","Albania","Algeria","Andorra","Angola","Anguilla","Antigua & Barbuda","Argentina","Armenia","Aruba","Australia","Austria","Azerbaijan","Bahamas","Bahrain","Bangladesh","Barbados","Belarus","Belgium","Belize","Benin","Bermuda","Bhutan","Bolivia","Bosnia & Herzegovina","Botswana","Brazil","British Virgin Islands","Brunei","Bulgaria","Burkina Faso","Burundi","Cambodia","Cameroon","Canada","Cape Verde","Cayman Islands","Central Arfrican Republic","Chad","Chile","China","Colombia","Congo","Cook Islands","Costa Rica","Cote D Ivoire","Croatia","Cuba","Curacao","Cyprus","Czech Republic","Denmark","Djibouti","Dominica","Dominican Republic","Ecuador","Egypt","El Salvador","Equatorial Guinea","Eritrea","Estonia","Ethiopia","Falkland Islands","Faroe Islands","Fiji","Finland","France","French Polynesia","French West Indies","Gabon","Gambia","Georgia","Germany","Ghana","Gibraltar","Greece","Greenland","Grenada","Guam","Guatemala","Guernsey","Guinea","Guinea Bissau","Guyana","Haiti","Honduras","Hong Kong","Hungary","Iceland","India","Indonesia","Iran","Iraq","Ireland","Isle of Man","Israel","Italy","Jamaica","Japan","Jersey","Jordan","Kazakhstan","Kenya","Kiribati","Kosovo","Kuwait","Kyrgyzstan","Laos","Latvia","Lebanon","Lesotho","Liberia","Libya","Liechtenstein","Lithuania","Luxembourg","Macau","Macedonia","Madagascar","Malawi","Malaysia","Maldives","Mali","Malta","Marshall Islands","Mauritania","Mauritius","Mexico","Micronesia","Moldova","Monaco","Mongolia","Montenegro","Montserrat","Morocco","Mozambique","Myanmar","Namibia","Nauro","Nepal","Netherlands","Netherlands Antilles","New Caledonia","New Zealand","Nicaragua","Niger","Nigeria","North Korea","Norway","Oman","Pakistan","Palau","Palestine","Panama","Papua New Guinea","Paraguay","Peru","Philippines","Poland","Portugal","Puerto Rico","Qatar","Reunion","Romania","Russia","Rwanda","Saint Pierre & Miquelon","Samoa","San Marino","Sao Tome and Principe","Saudi Arabia","Senegal","Serbia","Seychelles","Sierra Leone","Singapore","Slovakia","Slovenia","Solomon Islands","Somalia","South Africa","South Korea","South Sudan","Spain","Sri Lanka","St Kitts & Nevis","St Lucia","St Vincent","Sudan","Suriname","Swaziland","Sweden","Switzerland","Syria","Taiwan","Tajikistan","Tanzania","Thailand","Timor L'Este","Togo","Tonga","Trinidad & Tobago","Tunisia","Turkey","Turkmenistan","Turks & Caicos","Tuvalu","Uganda","Ukraine","United Arab Emirates","United Kingdom","United States of America","Uruguay","Uzbekistan","Vanuatu","Vatican City","Venezuela","Vietnam","Virgin Islands (US)","Yemen","Zambia","Zimbabwe"];
	var tags = <?php echo json_encode($arr); ?>;
  /*initiate the autocomplete function on the "myInput" element, and pass along the countries array as possible autocomplete values:*/
  autocomplete(document.getElementById("taggroup"), tags);
</script>