<?php
function dbconnect($user, $password) {
	$host = 'localhost';
	$db = 'cars';
	$conn = new mysqli($host, $user, $password, $db);
	if (mysqli_connect_errno())
		die('Cannot open database ->Exiting');
	return $conn;
}
?>