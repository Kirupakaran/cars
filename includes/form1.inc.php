<?php 
$missing=array(); 
if(isset($_POST[ 'submit'])) { 
	$required=array( "kilometer", "days", "carname"); 
	foreach($_POST as $key=>$value) { 
		$temp = is_array($value) ? $value : trim($value); 
		if (empty($temp) && in_array($key, $required)) { 
			$missing[] = $key; 
		} 
		${$key}=$temp; 
	} 
} ?>

<form id="petrolvsdiesel" method="post" action="includes/pvdc.php">
	<table>
		<tr>
			<td>
				<label for="kilometer" id="kilometerlabel">Kilometers/Day:</label>
			</td>
			<td>
				<input type="text" name="kilometer" id="kilometer" required <?php if ($missing) { echo 'value="' . htmlentities($kilometer, ENT_COMPAT, 'UTF-8') . '"'; } ?>></td>
			<td>
				<p>
					<?php if($missing&&in_array( 'kilometer',$missing)){ ?>
					<span class="error">enter the kilometers per day</span>
					<?php } ?>
				</p>
			</td>
		</tr>
		<tr>
			<td>
				<label for="days" id="daylabel">Days/Month:</label>
			</td>
			<td>
				<input type="text" name="days" id="days" required <?php if ($missing) { echo 'value="' . htmlentities($days, ENT_COMPAT, 'UTF-8') . '"'; } else { echo 'value=25'; }?>></td>
			<td>
				<p>
					<?php if($missing&&in_array( 'days',$missing)){ ?>
					<span class="error">enter the days you drive per month</span>
					<?php } ?>
				</p>
			</td>
		</tr>
		<tr>
			<td>
				<label for="carname" id="carlabel">Car Name:</label>
			</td>
			<td>
				<input type="text" name="carname" id="carname" required <?php if ($missing) { echo 'value="' . htmlentities($carname, ENT_COMPAT, 'UTF-8') . '"'; } ?>></td>
			<td>
				<p>
					<?php if($missing&&in_array( 'carname',$missing)){ ?>
					<span class="error">enter the car name</span>
					<?php } ?>
				</p>
			</td>
		</tr>
		<tr>
			<td>
				<label for="carname2" id="carlabel2">Car Name 2:</label>
			</td>
			<td>
				<input type="text" name="carname2" id="carname2" required <?php if ($missing) { echo 'value="' . htmlentities($carname, ENT_COMPAT, 'UTF-8') . '"'; } ?>></td>
			<td>
				<p>
					<?php if($missing&&in_array( 'carname',$missing)){ ?>
					<span class="error">enter the car name</span>
					<?php } ?>
				</p>
			</td>
		</tr>
		<tr>
			<td>
				<label for="location" id="locationlabel">Location:</label>
			</td>
			<td>
				<select name="location">
					<?php $locationarray=array( "chennai", "mumbai", "delhi", "calcutta"); foreach($locationarray as $loc) { ?>
						<option <?php if (isset($_POST['location']) && $_POST['location']==$loc) { echo 'selected'; } ?>>
						<?php echo $loc ?>
					</option>
					<?php } ?>
			</td>
		</tr>
		<tr>
			<td>
				<label for="petrolprice" id="petrollabel">Petrol Price:</label>
			</td>
			<td>
				<input type="text" name="petrolprice" id="petrolprice" <?php if ($missing) { echo 'value="' . htmlentities($petrolprice, ENT_COMPAT, 'UTF-8') . '"'; } ?>>
			</td>
		</tr>
		<tr>
			<td>
				<label for="dieselprice" id="diesellabel">Diesel Price:</label>
			</td>
			<td>
				<input type="text" name="dieselprice" id="dieselprice" <?php if ($missing) { echo 'value="' . htmlentities($dieselprice, ENT_COMPAT, 'UTF-8') . '"'; } ?>></td>
		</tr>

	</table>
	<input type="submit" name="submit" value="GO" id="go" class="button">
</form>