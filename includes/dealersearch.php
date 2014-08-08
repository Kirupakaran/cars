<?php
require('connection.inc.php');
$con=dbconnect('root','');
$stmt = $con->stmt_init();
$phpself=$_SERVER['PHP_SELF'];
if( isset($_POST['car_id_p'])&&  isset($_POST['car_id_d']))
{
	$car_id_p=mysqli_real_escape_string($con, trim($_POST['car_id_p']));
	$car_id_d=mysqli_real_escape_string($con, trim($_POST['car_id_d']));
	$query = "SELECT * FROM cardetails WHERE car_id= ? ";
	$stmt->prepare($query);
	$stmt->bind_param('s', $car_id_p);
	$stmt->execute();
	$data=$stmt->get_result();
	if($row = mysqli_fetch_array($data))
	{
		$carname_p=$row['brand']." ".$row['carmodel']." ".$row['variant'];
		$carbrand_p=$row['brand'];
	}
	$query ="SELECT * FROM cardetails WHERE car_id= ? ";
	$stmt->prepare($query);
	$stmt->bind_param('s', $car_id_d);
	$stmt->execute();
	$data=$stmt->get_result();
	if($row = mysqli_fetch_array($data ))
	{
		$carname_d=$row['brand']." ".$row['carmodel']." ".$row['variant'];
		$carbrand_d=$row['brand'];
	}
}
$pagecontents = <<< EOPAGE
		<script src="js/dsscript.js"></script>

		<div class="mainbox">
		<div class="dscontainer">
		<p>Select your Preferred Car and Location to locate your dealer</p>
		<form id="dsform" class="pure-form" method="post" action="">
			<select id="carsel" name="carsel">
				<option value="">Select Car</option>
				<option value="$car_id_d">$carname_d</option>
				<option value="$car_id_p">$carname_p</option>
			</select>
			<select id="locsel" name="loc">
				<option value="">Select City</option>
				<option value="Bangalore">Bangalore</option>
				<option value="Chennai">Chennai</option>
				<option value="Delhi">Delhi</option>
				<option value="Mumbai">Mumbai</option>
			</select>

			<input type="hidden" value=$car_id_p name="car_id_p">
			<input type="hidden" value=$car_id_d name="car_id_d">
			<input type="submit" name="submit" class="pure-button pure-button-primary" id="dssubmit" value="Search">
		</form>
		</div>
EOPAGE;

if (isset($_POST['name'])  && isset($_POST['email']) && isset($_POST['phno']) && isset($_POST['dealid']) && isset($_POST['carid'])&& $_POST['name']!="" && $_POST['email']!=""  && $_POST['phno']!=""){
	$name= mysqli_real_escape_string($con, trim($_POST['name']));
	$email=mysqli_real_escape_string($con, trim($_POST['email']));
	$phno=mysqli_real_escape_string($con, trim($_POST['phno']));
	$dealid=mysqli_real_escape_string($con, trim($_POST['dealid']));
	$carid=mysqli_real_escape_string($con, trim($_POST['carid']));

	$sql = "SELECT COUNT(cust_name) as count FROM customerdetails WHERE cust_name =? and cust_mailid = ? and cust_phno= ? and car_id=1 and dealerid= ?";
	$stmt->prepare($sql);
	$stmt->bind_param('ssss', $name,$email,$phno,$dealid);
	$stmt->execute();
	$data=$stmt->get_result();
	$row =mysqli_fetch_array($data);
	if($row['count']==0)
	mysqli_query($con,"INSERT INTO customerdetails (cust_name,cust_mailid,cust_phno,car_id,dealerid)VALUES ('$name', '$email',$phno,$carid,$dealid)");
	$pagecontents = <<< EOPAGE
		<div class="mainbox">
		<div class="dscontainer">
		<p align='center'>Your Details has been sent to the dealer. You will be contacted soon...</p>
		</div></div>
EOPAGE;

}
if (isset($_POST['loc']) && isset($_POST['carsel']) && $_POST['loc']!="" && $_POST['carsel']!="" ){
	$loc= mysqli_real_escape_string($con, trim($_POST['loc']));
	$carid=mysqli_real_escape_string($con, trim($_POST['carsel']));
	$query = "SELECT * FROM cardetails WHERE car_id= ?";
	$stmt->prepare($query);
	$stmt->bind_param('s', $carid);
	$stmt->execute();
	$data=$stmt->get_result();
	if($row = mysqli_fetch_array($data ))
	{
		$brand=$row['brand'];
	}
	$query = "SELECT * FROM dealer WHERE city = ? and brand= ?";
	$stmt->prepare($query);
	$stmt->bind_param('ss', $loc,$brand);
	$stmt->execute();
	$data=$stmt->get_result();

	if($row = mysqli_fetch_array($data))
	{
		$sno=1;
		$k = 'k' . 1;
		$pagecontents .= <<< EOPAGE
		<div class="dealersearch">
			<h3> $brand car dealers in $loc</h3>
EOPAGE;
		do
		{
			$dealerid=$row['dealerid'];
			$dname=$row['dealershipname'];
			$address=$row['address'];
			$phno=$row['phnumber'];
			$email=$row['emailid'];
			$pagecontents .= <<< EOPAGE
				<div class="pure-g" onmouseover="showbutton(this,$sno)" onmouseout="hidebutton(this,$sno)">
					<div class="pure-u-md-1-12"></div>
					<div class="pure-u-1 pure-u-md-9-24">
						<p><b>$dname</b><br>
						$address</p>
					</div>
					<div class="pure-u-md-1-12"></div>
					<div class="pure-u-1 pure-u-md-7-24">
						<br>
						Phone : <b>$phno</b>
						<br>
						Email : <b>$email</b>
					</div>
					<div class-"pure-u-1 pure-u-md-1-6">
						<br>
						<button class="pure-button pure-button-primary button-success" style="display:none;" id="$sno" onclick="getDetails($sno, $dealerid, '$k')">Contact</button>
					</div>
					<div id="$k" class="pure-u-1"></div>
				</div>
EOPAGE;
			$sno++;
			$k = 'k' . $sno;
		}while($row = mysqli_fetch_array($data ));
		$pagecontents .= <<< EOPAGE
			</div>

			<div id="details" class="white-popup mfp-hide">
				<form id="custform" class="pure-form pure-form-stacked" name="custform" action="" onsubmit="$.magnificPopup.close();" method="post">
					<input placeholder="Name" type="text" id="custname" name="name">
					<input placeholder="Email" type="text" id="custemail" name="email">
					<input placeholder="Phone Number" type="text" id="custphno" name="phno">
					<input type="hidden" value=0 id="hiddentd" name="dealid" >
					<input type="hidden" value=$carid name="carid" >
					<input type="hidden" value=$car_id_p name="car_id_p">
					<input type="hidden" value=$car_id_d name="car_id_d">
					<input type="submit" value="Send" class="pure-button pure-button-primary button-success">
				</form>
			</div>

EOPAGE;
	}
	else
	{

		$pagecontents .= <<< EOPAGE
			<div>
				<p>No dealers found for $brand cars in $loc</p>
			</div>
EOPAGE;
	}
	$pagecontents .= <<< EOPAGE
	</div>
	<script>
	function showbutton(div,id)
	{
		document.getElementById(id).style.display="inline";
		div.style.backgroundColor="#DFE1F5";
	}
	function hidebutton(div,id)
	{
		document.getElementById(id).style.display="none";
		div.style.backgroundColor="Transparent";
	}

		function getDetails(dealerid, divid)
		{
			$(document).ready(function() {
				document.getElementById("hiddentd").value=dealerid;
				$.magnificPopup.open({
  				items: {
    				src: '#details',
    				type: 'inline'
  				}
				});
			});
		}

	</script>
EOPAGE;

}


$pagecontents .= <<< EOPAGE

EOPAGE;
echo $pagecontents;
mysqli_close($con);

?>
