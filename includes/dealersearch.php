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
		<div align="center" >
		<p>Select your Preferred Car and Location to locate your dealer</p>
		<form id="dsform" class="pure-form pue-form-aligned" method="post" action="">
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
			<input type="submit" name="submit" class="pure-button pure-button-primary"  id="dssubmit" value="Search">
		</form>
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
		<div  class="dscontainer">
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
		$pagecontents .= <<< EOPAGE
			<p> $brand car dealers in $loc</p>
			<div>

			<table class="dealertable" bgcolor="Transparent" style="table-layout: fixed; width: 70%; border-spacing:0">
EOPAGE;
		$sno=1;
		do
		{
			$dealerid=$row['dealerid'];
			$dname=$row['dealershipname'];
			$address=$row['address'];
			$phno=$row['phnumber'];
			$email=$row['emailid'];
			$pagecontents .= <<< EOPAGE
				<tr onmouseover="showbutton(this,$sno)" onmouseout="hidebutton(this,$sno)"><td><b>$dname</b><br>$address</td><td  style="width:40%;">Phone : <b>$phno</b><br>Email : <b>$email</b></td><td style="width:20%;"><button style="display:none; max-width:100%" id="$sno" onclick="insertdealerid($dealerid)" class="topopup" >Send Details</button></td> </tr>

EOPAGE;
			$sno++;
		}while($row = mysqli_fetch_array($data ));

	}
	else
	{

		$pagecontents .= <<< EOPAGE
			<div>
			<p>No dealers found for $brand cars in $loc</p>

EOPAGE;
	}
	$pagecontents .= <<< EOPAGE

	</table>
	</div>
	<div id="toPopup">

	<div class="close"></div>

	<div id="popup_content">

	<p>Send your details to the dealer.</p><br>
	<form id="custform" class="pure-form pure-form-aligned" name="custform" action="" method="post">
	<table class="custtable">
	<tr><td><input placeholder="Name" type="text" id="custname" name="name"></td></tr>
	<tr><td><input placeholder="Email" type="text" id="custemail" name="email"></td></tr>
	<tr><td><input placeholder="Phone Number" type="text" id="custphno" name="phno"></td></tr>
	<tr><td>
	<input type="hidden" value=0 id="hiddentd" name="dealid" >
	<input type="hidden" value=$carid name="carid" >
	<input type="hidden" value=$car_id_p name="car_id_p">
	<input type="hidden" value=$car_id_d name="car_id_d">
	</td><td></td></tr>
	<tr><td  align="center"><input type="submit" value="Send" class="topopup"></td></tr>
	</table>
	</form>

	</div>

	</div> <!--toPopup end-->

	<div class="loader"></div>
	<div id="backgroundPopup"></div>






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
	function insertdealerid(dealerid)
	{
		document.getElementById("hiddentd").value=dealerid;
	}


	</script>
EOPAGE;

}


$pagecontents .= <<< EOPAGE
</div>
EOPAGE;
echo $pagecontents;
mysqli_close($con);

?>
