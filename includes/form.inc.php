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
	<table align="center">
		<tr>
			<td>
				<label for="kpd" id="kilometerlabel">Kilometers Driven/Day:</label>
			</td>
			<td>
				<input style="height:20px;width:149pt" type="text" name="kpd" id="kilometer" required <?php if ($missing) { echo 'value="' . htmlentities($kpd, ENT_COMPAT, 'UTF-8') . '"'; } ?>></td>
			<td>
				<p>
					<?php if($missing&&in_array( 'kpd',$missing)){ ?>
					<span class="error">Enter the kilometers per day</span>
					<?php } ?>
				</p>
			</td>
		</tr>
		<tr>
			<td>
				<label for="dpm" id="daylabel">Enter the days you drive per month :</label>
			</td>
			<td>
				<input style="height:20px;width:149pt" type="text" name="dpm" id="days" required <?php if ($missing) { echo 'value="' . htmlentities($dpm, ENT_COMPAT, 'UTF-8') . '"'; } else { echo 'value=25'; }?>></td>
			<td>
				<p>
					<?php if($missing&&in_array( 'dpm',$missing)){ ?>
					<span class="error">Enter the days you drive per month</span>
					<?php } ?>
				</p>
			</td>
		</tr>
		<tr>
			<td>
				<label for="location" id="locationlabel">Location:</label>
			</td>
			<td>
				<select name="location" id="location>
					<option value="">select</option>
					<?php $locationarray=array( "Tamil Nadu", "Maharashtra", "Delhi", "Karnataka"); foreach($locationarray as $loc) { ?>
						<option <?php if (isset($_POST['location']) && $_POST['location']==$loc) { echo 'selected'; } ?>>
						<?php echo $loc ?>
					</option>
					<?php } ?>
			</td>
		</tr>
		<tr>
			<td colspan="3" align="center">
				Select Your Preferred Car
			</td>
			
		</tr>
		<tr>
			
			<td align="center" colspan="3" >
				<select name="carbrand" id="carbrand" >
					<option value="">Car Brand</option>
					<?php while($row=$carbrand->fetch_assoc()) { ?>
						<option  value="<?php echo $row['brand']; ?>" <?php if (isset($_GET['carname_p']) && $_GET['carname_p']==$row['brand']) { echo 'selected'; } ?>>
						<?php echo $row['brand']; ?>
					</option>
					<?php } ?>
				</select>
			</td>
			<td>
				<p>
					<?php if($missing&&in_array( 'carname_p',$missing)){ ?>
					<span class="error">Select the carbrand</span>
					<?php } ?>
				</p>
			</td>
		</tr>
		<tr>
			
			<td align="center" colspan="3" >
				<select name="carmodel" id="carmodel" style="display:none">
				<option value="">Car Model</option>
				</select>
			</td>
			<td>
				<p>
					<?php if($missing&&in_array( 'carname_d',$missing)){ ?>
					<span class="error">Select the carmodel</span>
					<?php } ?>
				</p>
			</td>
		</tr>
		<tr>
			
			<td align="center" colspan="3" >
				<select name="car_id_p" id="pvariant"  style="display:none">
				<option value="">Petrol variant</option>
				</select>
			</td>
			<td>
				<p>
					<?php if($missing&&in_array( 'petrolvaraiant',$missing)){ ?>
					<span class="error">Select the petrol variant</span>
					<?php } ?>
				</p>
			</td>
		</tr>
		<tr>
			
			<td align="center" colspan="3"  >
				<select name="car_id_d" id="dvariant"  style="display:none">
					<option value="">Diesel variant</option>
				</select>
			</td>
			<td>
				<p>
					<?php if($missing&&in_array( 'dieselvariant',$missing)){ ?>
					<span class="error">Select the diesel variant</span>
					<?php } ?>
				</p>
			</td>
		</tr>
		
		<tr>
		<td align="center" colspan="3" >
		<input type="submit" name="submit" value="GO" id="formsubmit" class="button">
		</td>
		</tr>
		
	</table>
	
</form>
</body>
</html>