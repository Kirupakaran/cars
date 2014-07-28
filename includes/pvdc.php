<?php
$con=mysqli_connect("127.0.0.1","root","","cars");
$stmt = $con->stmt_init();
// Check connection
if (mysqli_connect_errno())
{
	echo "Failed to connect to MySQL: " . mysqli_connect_error();
	exit("Unable to connect to Mysql");
}

$errors = array();
$missing = array();
if(!empty($_POST)) {
	$required=array( "kpd", "dpm","carbrand","carmodel","car_id_p","car_id_d","location");
	foreach($_POST as $key=>$value) {
		$temp = is_array($value) ? $value : trim($value);
		if (empty($temp) && in_array($key, $required)) {
			$missing[] = $key;
		}
		${$key}=$temp;
	}
	if( $missing&&in_array( 'kpd',$missing)){
		$errors[] = "Please enter the number of kilometers you're going to drive your car per day";
	}
	if($missing&&in_array( 'dpm',$missing)){
		$errors[] = "Please enter the number of days you will use the car in a month";
	}
	if($missing&&in_array( 'carbrand',$missing)){
		$errors[] = "Please select  a car brand";
	}
	if($missing&&in_array( 'carmodel',$missing)){
		$errors[] = "Please select  a Car Model";
	}
	if($missing&&in_array( 'car_id_p',$missing)) {
		$errors[] = "Please select a Petrol Variant";
	}
	if($missing&&in_array( 'car_id_d',$missing)){
		$errors[] = "Please select a Diesel Variant";
	}
	if($missing&&in_array( 'location',$missing)){
		$errors[] = "Please select  Location";
	}
}

if(empty($missing)) {
	if (isset($_POST['dpm'])){
		$dpm= mysqli_real_escape_string($con, trim($_POST['dpm']));
	}
	else
		$dpm=25; //Days / Month

	if (isset($_POST['kpd'])){
		$kpd= mysqli_real_escape_string($con, trim($_POST['kpd']));
	}
	else
		$kpd=50; //Kilometers Driven / Day

	if (isset($_POST['car_id_p'])){
		$car_id_p= mysqli_real_escape_string($con, trim($_POST['car_id_p']));
	}
	else
		$car_id_p=1;

	if (isset($_POST['car_id_d'])){
		$car_id_d= mysqli_real_escape_string($con, trim($_POST['car_id_d']));
	}
	else
		$car_id_d=2;

	if (isset($_POST['location'])){
		$location= mysqli_real_escape_string($con, trim($_POST['location']));
	}
	else
		$location="Tamil Nadu";

	/*Obtaining fuel price from database */
	$sql = mysqli_query($con,"SELECT * FROM fuelprice");
	$row = mysqli_fetch_array($sql );
	$dprice= $row['diesel'];
	$pprice=$row['petrol'];


	/*For petrol car */

	$petrol_car_query = "SELECT * FROM cardetails WHERE car_id= ? ";
	$stmt->prepare($petrol_car_query);
	$stmt->bind_param('s', $car_id_p);
	$stmt->execute();
	$data=$stmt->get_result();
	$petrol_car = mysqli_fetch_array($data);
	$name_p=$petrol_car ['brand'];
	$name_p.=" ".$petrol_car ['carmodel'];
	$name_p.=" ".$petrol_car ['variant'];
	$mileage_p=$petrol_car['mileage'];
	$src_p="data:image/jpeg;base64,".base64_encode( $petrol_car ['image'] );
	/*Obtaining Petrol car price from db*/
	$sql = "SELECT COUNT(car_id) as count FROM carprice WHERE car_id = ? and state = ? ";
	$stmt->prepare($sql);
	$stmt->bind_param('ss', $car_id_p,$location);
	$stmt->execute();
	$row=$stmt->get_result();
	if (mysqli_num_rows($row) == 0)
		$car_price_p=$petrol_car['base_price'];
	else
	{
		$sql ="SELECT * FROM carprice WHERE car_id= ? and state = ? ";
		$stmt->prepare($sql);
		$stmt->bind_param('ss', $car_id_p,$location);
		$stmt->execute();
		$data=$stmt->get_result();
		$row = mysqli_fetch_array($data);
		$car_price_p=$row['price'];
	}


	$fuel_price_per_day_p	=($kpd/$mileage_p)*$pprice;
	$fuel_price_per_month_p	=$fuel_price_per_day_p*$dpm;
	$fuel_price_per_year_p	=$fuel_price_per_month_p*12;


	/*For diesel car */

	$diesel_car_query = "SELECT * FROM cardetails WHERE car_id = ? ";
	$stmt->prepare($diesel_car_query);
	$stmt->bind_param('s', $car_id_d);
	$stmt->execute();
	$data=$stmt->get_result();
	$diesel_car = mysqli_fetch_array($data);
	$name_d=$diesel_car ['brand'];
	$name_d.=" ".$diesel_car ['carmodel'];
	$name_d.=" ".$diesel_car ['variant'];
	$car_price_d=$diesel_car['base_price'];
	$mileage_d=$diesel_car['mileage'];
	$src_d="data:image/jpeg;base64,".base64_encode( $diesel_car ['image'] );
	/*Obtaining Diesel car price from db*/
	$sql = "SELECT COUNT(car_id) as count FROM carprice WHERE car_id= ? and state = ? ";
	$stmt->prepare($sql);
	$stmt->bind_param('ss', $car_id_d,$location);
	$stmt->execute();
	$row=$stmt->get_result();
	if(mysqli_num_rows($row) == 0)
		$car_price_d=$diesel_car['base_price'];
	else
	{
		$sql = "SELECT * FROM carprice WHERE car_id= ? and state = ? ";
		$stmt->prepare($sql);
		$stmt->bind_param('ss', $car_id_d,$location);
		$stmt->execute();
		$data=$stmt->get_result();
		$row = mysqli_fetch_array($data);
		$car_price_d=$row['price'];
	}

	$fuel_price_per_day_d	=($kpd/$mileage_d)*$dprice;
	$fuel_price_per_month_d	=$fuel_price_per_day_d*$dpm;
	$fuel_price_per_year_d	=$fuel_price_per_month_d*12;


	/*calculation using formula*/
	$yearly_cost_p		= array();
	$yearly_cost_d		= array();
	$final_d 			= array();
	$final_p 			= array();

	for($i=1;$i<=6;$i++)
	{
	$yearly_cost_p[$i]= $fuel_price_per_year_p*$i;
	$yearly_cost_d[$i]	=$fuel_price_per_year_d*$i;

	$diesel_savings	= $yearly_cost_p[$i] - $yearly_cost_d[$i]	;
	$car_price_diff	= $car_price_d-$car_price_p;
	$final = $diesel_savings-$car_price_diff;
	$final_d[$i]= round($final, 2);
	$final_p[$i]=-$final_d[$i];
	}


	mysqli_close($con);

	$pageContents = <<< EOPAGE
				<div class="pure-g">
					<div class="pure-u-1 pure-u-md-1-2">
						<img class="image pure-img" src=$src_p />
						<h2> $name_p </h2>
						<div class="pure-g">
							<div class="pure-u-1-2">
								<span>On Road Price</span>
							</div>
							<div class="pure-u-1-2">
								<span>&#8377; $car_price_p </span>
							</div>
						</div>
						<div class="pure-g">
							<div class="pure-u-1-2">
								<span>Fuel Type</span>
							</div>
							<div class="pure-u-1-2">
								<span>Petrol</span><br>
							</div>
						</div>
						<div class="pure-g">
							<div class="pure-u-1-2">
								<span>Mileage (kmpl)</span>
							</div>
							<div class="pure-u-1-2">
								<span> $mileage_p </span>
							</div>
						</div>
						<div class="pure-g">
							<div class="pure-u-1-2">
								<span>Petrol Savings for 2 years</span>
							</div>
							<div class="pure-u-1-2">
								<span id="p2" valign="20">&#8377; $final_p[2] </span>
							</div>
						</div>
						<div class="pure-g">
							<div class="pure-u-1-2">
								<span>Petrol Savings for 4 years</span>
							</div>
							<div class="pure-u-1-2">
								<span id="p4">&#8377; $final_p[4] </span>
							</div>
						</div>
						<div class="pure-g">
							<div class="pure-u-1-2">
								<span>Petrol Savings for 6 years</span>
							</div>
							<div class="pure-u-1-2">
								<span id="p6">&#8377; $final_p[6] </span>
							</div>
						</div>
					</div>
					<div class="pure-u-1 pure-u-md-1-2">
						<img class="image pure-img" src=$src_d />
						<h2>$name_d</h2>
						<div class="pure-g">
							<div class="pure-u-1-2">
								<span>On Road Price</span>
							</div>
							<div class="pure-u-1-2">
								<span>&#8377; $car_price_d </span>
							</div>
						</div>
						<div class="pure-g">
							<div class="pure-u-1-2">
								<span>Fuel Type</span>
							</div>
							<div class="pure-u-1-2">
								<span>Diesel</span>
							</div>
						</div>
						<div class="pure-g">
							<div class="pure-u-1-2">
								<span>Mileage (kmpl)</span>
							</div>
							<div class="pure-u-1-2">
								<span class="letterA">$mileage_d </span>
							</div>
						</div>
						<div class="pure-g">
							<div class="pure-u-1-2">
								<span>Diesel Savings for 2 years</span>
							</div>
							<div class="pure-u-1-2">
								<span id="d2">&#8377; $final_d[2] </span>
							</div>
						</div>
						<div class="pure-g">
							<div class="pure-u-1-2">
								<span>Diesel Savings for 4 years</span>
							</div>
							<div class="pure-u-1-2">
								<span id="d4">&#8377; $final_d[4] </span>
							</div>
						</div>
						<div class="pure-g">
							<div class="pure-u-1-2">
								<span>Diesel Savings for 6 years</span>
							</div>
							<div class="pure-u-1-2">
								<span id="d6">&#8377; $final_d[6] </span>
							</div>
						</div>
					</div>
				</div>
			<form id="contactdealerbuttonform" >
			<input type="hidden" value="$car_id_d" name="car_id_d"/>
			<input type="hidden" value="$car_id_p" name="car_id_p"/>
			<input type="submit" class="pure-button pure-button-primary" id="contactdealer" value="Contact Dealer Now!" />
			</form>

	<script>
		var final_d_2=$final_d[2];
		var final_d_4=$final_d[4];
		var final_d_6=$final_d[6];
		if(final_d_2>0)
		{
			document.getElementById("d2").style.backgroundColor= "rgba(0,200,0,0.6)";
			document.getElementById("p2").style.backgroundColor ="rgba(255,0,0,0.5)";
		}
		else
		{
			document.getElementById("d2").style.backgroundColor= "rgba(255,0,0,0.5)";
			document.getElementById("p2").style.backgroundColor ="rgba(0,200,0,0.6)";
		}
		if(final_d_4>0)
		{
			document.getElementById("d4").style.backgroundColor= "rgba(0,200,0,0.6)";
			document.getElementById("p4").style.backgroundColor ="rgba(255,0,0,0.5)";
		}
		else
		{
			document.getElementById("d4").style.backgroundColor= "rgba(255,0,0,0.5)";
			document.getElementById("p4").style.backgroundColor ="rgba(0,200,0,0.6)";
		}
		if(final_d_6>0)
		{
			document.getElementById("d6").style.backgroundColor= "rgba(0,200,0,0.6)";
			document.getElementById("p6").style.backgroundColor ="rgba(255,0,0,0.5)";
		}
		else
		{
			document.getElementById("d6").style.backgroundColor= "rgba(255,0,0,0.5)";
			document.getElementById("p6").style.backgroundColor ="rgba(0,200,0,0.6)";

		}
		$(document).ready(function() {

      $("#contactdealerbuttonform").submit( function(e)
           {
		   e.preventDefault();
           $.ajax({
			data: $(this).serialize(),
			type: "post",
			url: "http://localhost/pdc/includes/dealersearch.php",
			success: function(response) {
				$('html,body').animate({ scrollTop: $('#dealers').offset().top }, 1000);
				$('#dealers').html(response);
			}
		});
           }
      );

});
	</script>
EOPAGE;

	echo $pageContents;
	}
else {
	echo "<div class='mycontainer' style='min-height:200px !important;'><div class='mydiv' style='min-height:100px'>";
	foreach($errors as $error) {
		echo $error."<br>";
	}
	echo "</div></div>";
}
?>
