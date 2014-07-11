<?php
session_start();
// if session variable not set, redirect to login page
if (!isset($_SESSION['authenticated'])) {
  header('Location: http://localhost/pdc/dealerlog.php');
  exit;
}
?>
<!doctype html>
<html>
<head>
	<title>Dealer</title>
	<link rel="stylesheet" type="text/css" href="css/style3.css"/>
</head>
<body>
<script src="js/jquery.min.js"></script>
<script>
$(document).ready(function () {
	$.ajax({
		data: {choice: 2},
		type: "post",
		url: "http://localhost/pdc/customerinfo.php",
		success: function (response) {
			$("#main").empty();
			$("#main").html(response);
		}
	});	
	$("#inbox").click(function () {
		$.ajax({
			data: {choice: 2},
			type: "post",
			url: "http://localhost/pdc/customerinfo.php",
			success: function (response) {
				$("#main").empty();
				$("#main").html(response);
			}
		});
	});
	$("#old").click(function () {
		$.ajax({
			data: {choice: 3},
			type: "post",
			url: "http://localhost/pdc/customerinfo.php",
			success: function (response) {
				$("#main").empty();
				$("#main").html(response);
			}
		});
	});
});
</script>
<header>
<h1>Welcome</h1>
<a href="dealerlog1.php">Change Password</a>
<?php 
	include('./includes/logout.inc.php');
	logout("http://localhost/pdc/dealerlog.php");
?>
</header>
<?php
if (!empty($message)) {
	echo "<p>$message</p>";
}
else {?>
<div id="menu">
	<nav id="navigation">
		<ul>
			<li id="inbox">Inbox
			<li id="old">Old
		</ul>
	</nav>
</div>
<div id="main">
</div>
<?php } ?>
</body>
</html>
	