<!DOCTYPE HTML>
<html>
	<head>
		<title>Petrol Vs Diesel Cars</title>
		<!--<link rel="stylesheet" href="css/style.css" />
		<link rel="stylesheet" href="css/style2.css" />
		<link href="css/dsstyle.css" rel="stylesheet" type="text/css" media="all" /> -->
		<link rel="stylesheet" href="css/bootstrap.min.css" />
		<link rel="stylesheet" href="css/altstyle.css" />
		<script src="js/jquery.min.js"></script>
		<script src="js/script.js"></script>
		<script src="js/jquery.fittext.js"></script>
	</head>
	<body>
	<div class="container-fluid">
		<div class="row main">
			<div class="column">
				<div id="loginpopup"></div>
				<div id="dealerloginbutton"><buttonx id="dealerlogin"><a href="dealerlog.php">Dealer?</a></button></div>
				<div id="main" align="center">
					<h1 id="heading1">Petrol vs Diesel Cars</h1>
					<p id="mainp">A site to compare petrol and diesel cars and find which one is right for you</p>
					<button class="button" id="go">Go!</button>
				</div>
			</div>
		</div>
		<div id="form">
				<?php require('./includes/form.inc.php'); ?> 
		</div>
		<div id="cars"></div>
		<div id="dealers"></div>
		<div id="feedbackdiv">
			<header>
				<h2>FEEDBACK</h2>
				<p> We accept any suggestions,comments and queries that you may have.</p>
			</header>
			<?php require('./includes/feedback.php'); ?> 
		</div>
		<footer id="copyright">
			<span>&copy; Cars. All rights reserved.</span>
		</footer>
	</div>
	</body>
</html>