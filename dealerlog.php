<?php
require('includes/connection.inc.php');
// dealer login page
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
	<link rel="stylesheet" href="css/pure/pure-min.css">
	<link rel="stylesheet" href="css/pure/grids-responsive-min.css">
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
		<form id="pure-form pure-form-aligned" method="post" action="dealerlog.php">
			<p>
				<label for="Dealerid">Dealer ID:</label>
				<input type="text" name="Dealerid" placeholder="Login" autofocus required>
			</p>
			<p>
				<label for="password">Password</label>
				<input type="password" name="password" placeholder="Password" required>
			</p>
			<p>
				<input type="submit" name="submit" id="login" class="pure-button pure-button-primary" value="Login">
			</p>
		</form>
	</div>
</body>
</form>
</html>
