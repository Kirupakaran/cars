<?php
require('connection.inc.php');
$con=dbconnect('root','');

$sql = 'SELECT DISTINCT(brand) FROM cardetails ';
$carbrand = $con->query($sql) or die(mysqli_error());

$missing=array();
if(isset($_POST[ 'submit'])) {
	$required=array( "kpd", "dpm","carname_p","carname_d","petrolvariant","dieselvariant");
	foreach($_POST as $key=>$value) {
		$temp = is_array($value) ? $value : trim($value);

		if ( empty($temp) && in_array($key, $required)) {
			$missing[] = $key;
		}
		${$key}=$temp;
	}
}
?>

<script>
$(document).ready(function() {
	$("#carbrand").change( function(){
		var e = document.getElementById("carbrand");
		var brand = e.options[e.selectedIndex].text;
		$.ajax({
			data: {carbrand:brand},
			type: "get",
			url: "http://localhost/pdc/includes/db.php",
			success: function(response) {
				$("#pvariant").html('<option value="" disabled selected>Petrol variant</option>');
				$("#dvariant").html('<option value="" disabled selected>Diesel variant</option>');
				$("#carmodel").empty();
				$('#carmodel').html(response);
			}
		});
		return false;
	});
	$("#carmodel").change( function(){
		var e1 = document.getElementById("carmodel");
		var model = e1.options[e1.selectedIndex].text;
		var e = document.getElementById("carbrand");
		var brand = e.options[e.selectedIndex].text;
		$.ajax({
			data: {carbrand:brand,carmodel:model},
			type: "get",
			url: "http://localhost/pdc/includes/db1.php",
			success: function(response) {
				$("#pvariant").empty();
				$('#pvariant').html(response);
			}

		});
		return false;
	});
	$("#carmodel").change( function(){
		var e1 = document.getElementById("carmodel");
		var model = e1.options[e1.selectedIndex].text;
		var e = document.getElementById("carbrand");
		var brand = e.options[e.selectedIndex].text;
		$.ajax({
			data: {carbrand:brand,carmodel:model},
			type: "get",
			url: "http://localhost/pdc/includes/db2.php",
			success: function(response) {
				$("#dvariant").empty();
				$('#dvariant').html(response);
			}
		});
		return false;
	});
});
</script>
<form class="pure-form pure-form-aligned" id="petrolvsdiesel" method="post" action="">
	<fieldset>
		<div class="pure-control-group pure-g">
			<div class="pure-u-1 pure-u-lg-11-24">
				<label for="kpd" class="pure-u-1">Kilometers Driven/Day</label>
			</div>
			<div class="pure-u-1 pure-u-lg-9-24">
				<input type="text" name="kpd" id="kilometer" class="pure-input-1" required <?php if ($missing) { echo 'value="' . htmlentities($kpd, ENT_COMPAT, 'UTF-8') . '"'; } ?>>
			</div>
		</div>
		<div class="pure-control-group pure-g">
			<div class="pure-u-1 pure-u-lg-11-24">
				<label for="dpm">Number of days driven/Month</label>
			</div>
			<div class="pure-u-1 pure-u-lg-9-24">
				<input type="text" name="dpm" id="days" default="25" class="pure-input-1" required <?php if ($missing) { echo 'value="' . htmlentities($dpm, ENT_COMPAT, 'UTF-8') . '"'; } else { echo 'value=25'; }?>>
			</div>
		</div>
		<div class="pure-control-group pure-g">
			<div class="pure-u-1 pure-u-lg-11-24">
				<label for="location" class="pure-u-1">	Location</label>
			</div>
			<div class="pure-u-1 pure-u-lg-9-24">
				<select name="location" required id="location" class="pure-input-1">
					<?php $locationarray=array( "Tamil Nadu", "Maharashtra", "Delhi", "Karnataka"); foreach($locationarray as $loc) { ?>
						<option <?php if (isset($_POST['location']) && $_POST['location']==$loc) { echo 'selected'; } ?>><?php echo $loc ?></option>
					<?php } ?>
				</select>
			</div>
		</div>
		<div class="pure-control-group pure-g">
			<div class="pure-u-1 pure-u-lg-11-24">
				<label for="carbrand" class="pure-u-1">Car Brand</label>
			</div>
			<div class="pure-u-1 pure-u-lg-9-24">
				<select name="carbrand" required id="carbrand" class="pure-input-1">
					<option value="" disabled selected>Select a brand</option>
					<?php while($row=$carbrand->fetch_assoc()) { ?>
						<option  value="<?php echo $row['brand']; ?>" <?php if (isset($_GET['carname_p']) && $_GET['carname_p']==$row['brand']) { echo 'selected'; } ?>><?php echo $row['brand']; ?></option>
					<?php } ?>
				</select>
			</div>
		</div>
		<div class="pure-control-group pure-g">
			<div class="pure-u-1 pure-u-lg-11-24">
				<label for="carmodel" class="pure-u-1">Car Model</label>
			</div>
			<div class="pure-u-1 pure-u-lg-9-24">
				<select name="carmodel" id="carmodel" class="pure-input-1" required>
					<option value="" disabled selected>Car Model</option>
				</select>
			</div>
		</div>
		<div class="pure-control-group pure-g">
			<div class="pure-u-1 pure-u-lg-11-24">
				<label for="car_id_p" class="pure-u-1">Petrol Variant</label>
			</div>
			<div class="pure-u-1 pure-u-lg-9-24">
				<select name="car_id_p" id="pvariant" class="pure-input-1" required>
					<option value="" disabled selected>Petrol variant</option>
				</select>
			</div>
		</div>
		<div class="pure-control-group pure-g">
			<div class="pure-u-1 pure-u-lg-11-24">
				<label for="car_id_d" class="pure-u-1">Diesel Variant</label>
			</div>
			<div class="pure-u-1 pure-u-lg-9-24">
				<select name="car_id_d" id="dvariant" class="pure-input-1" required>
					<option value="" disabled selected>Diesel variant</option>
				</select>
			</div>
		</div>
		<div class="pure-controls pure-g">
			<div class="pure-u-1-5 pure-u-md-9-24"></div>
			<div class="pure-u-3-5 pure-u-md-5-24">

				<input type="submit" name="submit" value="GO"  id="formsubmit" class="pure-button pure-button-primary button-success pure-input-1 button-xlarge">
			</div>
			<div class="pure-u-1-5 pure-u-md-5-24"></div>
		</div>
	</fieldset>
</form>
