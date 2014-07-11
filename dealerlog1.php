<?php
if(isset($_POST['submit']))
{
	if(!isset($_POST['Dealerid'])||!isset($_POST['Password'])||!isset($_POST['Password1']))
	{
		echo '<p><a href="login1.php">&lt;&lt;Back to this page</a></p>';
	}
	else
	{
		require('connection.inc.php');
		$dbc=dbconnect('root','');
		$stmt = $dbc->stmt_init();
		$stmt2 = $dbc->stmt_init();
		$user_username = mysqli_real_escape_string($dbc, trim($_POST['Dealerid']));
		$user_password = mysqli_real_escape_string($dbc, trim($_POST['Password']));
		$user_password1= mysqli_real_escape_string($dbc, trim($_POST['Password1']));
		$user_password=hash('sha256',$user_password);
		$user_password1=hash('sha256',$user_password1);
		$query = "SELECT loginid, passwd FROM dealer WHERE loginid = ? AND passwd = ?";
		$stmt->prepare($query);
		$stmt->bind_param('ss', $user_username, $user_password);
		$stmt->execute();
		$data = $stmt->get_result();
		if (mysqli_num_rows($data) == 1) {
			$row = mysqli_fetch_array($data);
			$username = $row['loginid'];
			$paswd = $row['passwd']; 
			$query1="UPDATE dealer SET passwd=? WHERE loginid = ? AND passwd = ?";
			$stmt2->prepare($query1);
			$stmt2->bind_param('sss', $user_password1, $user_username, $user_password);
			$stmt2->execute();
			?>
			<script> alert("Password changed");
			</script>
		<?php 
		}
	}
}
?>
<html>
<head>
</head>
<body>
<h3>WELCOME <h3>
<form align="center" action="" method="post">
DealerID <input type="text" name="Dealerid" id="dealeridentity"><br>
Old Password  <input type="password" name="Password" id="dealerpwd"><br>
New Password  <input type="password" name="Password1" id="dealernewpwd"><br>
<input type="submit" name="submit" value="Change" id="submit" align="center">
</body>
</form>
</html>