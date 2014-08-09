<?php
function logout($redirect) {
	// script for logout button
	if (isset($_POST['logout'])) {
		// empty session array
		$_SESSION = array();
		// invalidate session cookie
		if (isset($_COOKIE[session_name()])) {
			setcookie(session_name(), '', time()-86400, '/');
		}
		// end session and redirect
		session_destroy();
		header("Location: $redirect");
	}
}
?>

<form id="logoutForm" method="post" action="">
<input class="pure-button pure-button-primary button-success" name="logout" type="submit" id="logout" value="log out">
</form>
