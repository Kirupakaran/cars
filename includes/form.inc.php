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
} ?>
<html>
<head>
<script>
$(document).ready(function() {
	$("#carbrand").change( function(){
		var e = document.getElementById("carbrand");
		var brand = e.options[e.selectedIndex].text;
		$("#carmodel").css({ "display" : "block"});
		$.ajax({
			data: {carbrand:brand},
			type: "get",
			url: "http://localhost/pdc/includes/db.php",
			success: function(response) {
				$("#pvariant").empty();
				$("#dvariant").empty();
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
		$("#pvariant").css({ "display" : "block"});
		$("#dvariant").css({ "display" : "block"});
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
</head>
<body>
<form id="petrolvsdiesel" method="post" action="">
	<table>
		<tr>
			<td>
				<input type="text" name="kpd" id="kilometer" class="block text" placeholder="Kilometers Driven/Day" required <?php if ($missing) { echo 'value="' . htmlentities($kpd, ENT_COMPAT, 'UTF-8') . '"'; } ?>>
			</td>
		</tr>
		<tr>
			<td>
				<input type="text" name="dpm" id="days" class="block text" placeholder="Number of days driven/Month" required <?php if ($missing) { echo 'value="' . htmlentities($dpm, ENT_COMPAT, 'UTF-8') . '"'; } else { echo 'value=25'; }?>>
			</td>
		</tr>
		<tr>
			<td>
				<select name="location" required id="location" class="block text">
					<option value="" disabled selected>Select a Location</option>
					<?php $locationarray=array( "Tamil Nadu", "Maharashtra", "Delhi", "Karnataka"); foreach($locationarray as $loc) { ?>
						<option <?php if (isset($_POST['location']) && $_POST['location']==$loc) { echo 'selected'; } ?>>
						<?php echo $loc ?>
					</option>
					<?php } ?>
			</td>
		</tr>
		<tr>
			<td align="center">
				Select Your Preferred Car
			</td>
		</tr>
		<tr>
			<td>
				<select name="carbrand" required id="carbrand" class="block-half text">
					<option value="" disabled selected>Car Brand</option>
					<?php while($row=$carbrand->fetch_assoc()) { ?>
						<option  value="<?php echo $row['brand']; ?>" <?php if (isset($_GET['carname_p']) && $_GET['carname_p']==$row['brand']) { echo 'selected'; } ?>>
						<?php echo $row['brand']; ?>
					</option>
					<?php } ?>
				</select>
			</td>
			<td>
				<select name="carmodel" id="carmodel" class="block-half text" required style="display:none">
				<option value="" disabled selected>Car Model</option>
				</select>
			</td>
		</tr>
		<tr>
			<td>
				<select name="car_id_p" id="pvariant" required style="display:none" class="block-half text">
				<option value="" disabled selected>Petrol variant</option>
				</select>
			</td>
			<td>
				<select name="car_id_d" id="dvariant" required style="display:none" class="block-half text">
					<option value="" disabled selected>Diesel variant</option>
				</select>
			</td>
		</tr>
	</table>
	<input type="submit" name="submit" value="GO" id="formsubmit" class="button">
</form>
</body>
</html>
