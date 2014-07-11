<?php
require('includes/connection.inc.php');
$dbc = dbconnect('root','');
$stmt = $dbc->stmt_init();
if(isset($_POST['submit']))
{
	$message = '';
	if(!isset($_POST['Dealerid']) || !isset($_POST['password']))
	{
		 $message = '<p>Please enter username and password.</p>';
	}
	else
	{
		session_start();
		$error='';
		//on success
		$redirect = "./dealer.php";
		$user_username = mysqli_real_escape_string($dbc, trim($_POST['Dealerid']));
		$user_password = mysqli_real_escape_string($dbc, trim($_POST['password']));
		$user_password=hash('sha256',$user_password);
		$query = "SELECT loginid, passwd, dealerid FROM dealer WHERE loginid = ? AND passwd = ?";
		$stmt->prepare($query);
		$stmt->bind_param('ss', $user_username, $user_password);
		$stmt->execute();
		$data = $stmt->get_result();
		if (mysqli_num_rows($data) == 1) {
			$row = mysqli_fetch_array($data);
			$username = $row['loginid'];
			$paswd = $row['passwd'];
			$_SESSION['dealerid'] = $row['dealerid'];
			$_SESSION['authenticated'] = $username;
			session_regenerate_id();
			header("Location: $redirect");
			exit;
		}
		else
		{
			$error='Invalid Username or Password';
		}
	}
}
?>
<html>
<head>
	<title>Dealer Login</title>
	<style type="text/css" rel="stylesheet">
		#container {
			margin: 0 auto;
			margin-top: 5%;
			width: 50%;
		}
		#login {
			background: rgba(0, 0, 127, 0.5);
			border-color: rgba(145, 80, 255, 0.7);
			border-radius: 3px;
			color: white;
			cursor: pointer;
			font-size: 18px;
			padding: 10px 20px 10px 20px;
		}
		#login:hover {
			background: rgba(145, 90, 255, 0.5);
		}
	</style>
</head>
<body>
	<div id="container">
	<h2>Dealer</h2>
	<?php
	if((isset($message)) && !empty($message)) {
		echo "<p>$message</p>";
	}
	if ((isset($error)) && !empty($error)) {
		echo "<p>$error</p>";
	}
	?>
		<form id="form1" method="post" action="dealerlog.php">
			<p>
				<label for="Dealerid">Dealer ID:</label>
				<input type="text" name="Dealerid" placeholder="Login" autofocus required>
			</p>
			<p>
				<label for="password">Password</label>
				<input type="password" name="password" placeholder="Password" required>
			</p>
			<p>
				<input type="submit" name="submit" id="login" value="Login">
			</p>
		</form>
	</div>
</body>
</form>
</html>