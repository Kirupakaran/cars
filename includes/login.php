<?php
if(isset($_POST['submit']))
{
	if(!isset($_POST['Adminid'])||!isset($_POST['Password']))
	{
	echo '<p><a href="login.php">&lt;&lt;Back to admin page</a></p>';
	}
	else
	{
		require('connection.inc.php');
		$dbc=dbconnect('root','');
		$stmt = $dbc->stmt_init();
		$user_username = mysqli_real_escape_string($dbc, trim($_POST['Adminid']));
		$user_password = mysqli_real_escape_string($dbc, trim($_POST['Password']));
		$user_password=hash('sha256',$user_password);
		$query = "SELECT adminname, passwd FROM admin WHERE adminname = ? AND passwd = ?";
		$stmt->prepare($query);
		$stmt->bind_param('ss', $user_username, $user_password);
		$stmt->execute();
		$data = $stmt->get_result();
		if (mysqli_num_rows($data) == 1) {
			$row = mysqli_fetch_array($data);
			$username = $row['adminname'];
			$paswd = $row['passwd']; ?>
			<script> alert("welcome");
			</script>
		<?php 
		}
	}
}
?>
<html>
<head>
	<title>Admin - Login</title>
</head>
<body>
<h3>WELCOME<h3>
<form align="center" action="" method="post">
<label>AdminID</label>
<input type="text" name="Adminid" id="adminidentity"><br>
<label>Password</label>
<input type="password" name="Password" id="adminpwd"><br>
<input type="submit" name="submit" value="Submit" id="submit" align="center">
<a href="login1.php">Change Password</a>
</body>
</form>
</html>