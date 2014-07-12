<!DOCTYPE HTML>
<html>
	<head>
		<title>Petrol Vs Diesel Cars</title>
		<!--<link rel="stylesheet" href="css/style.css" />
		<link rel="stylesheet" href="css/style2.css" />
		<link href="css/dsstyle.css" rel="stylesheet" type="text/css" media="all" /> -->
	<!--	<link rel="stylesheet" href="css/bootstrap.min.css" /> -->
		<link rel="stylesheet" href="css/style.css" />
		<script src="js/jquery.min.js"></script>
		<script src="js/script.js"></script>
		<script src="js/jquery.fittext.js"></script>
	</head>
	<body>
	<div id="container">
		<!-- start of main page -->
		<div class="maindiv">
			<div id="dealerloginbutton"><buttonx id="dealerlogin"><a href="dealerlog.php">Dealer?</a></button></div>
			<div id="main">
				<h1 id="heading1">Petrol vs Diesel Cars</h1>
				<p id="mainp">A site to compare petrol and diesel cars and find which one is right for you</p>
				<button class="button" id="go">Go!</button>
			</div>
		</div>
		<!-- end of main -->
		<!-- form -->
		<div id="form">
			<?php require('./includes/form.inc.php'); ?>
		</div>
		<!-- end of form -->
		<!-- cars comparison section -->

		<div id="cars"></div>

		<!-- end of comparison -->
		<!-- dealer search section -->

		<div id="dealers"></div>

		<!-- end of dealer search -->
		<!-- feedback section -->

		<div id="feedbackdiv">
			<header>
				<h2>FEEDBACK</h2>
				<p> We accept any suggestions,comments and queries that you may have.</p>
			</header>
			<?php require('./includes/feedback.php'); ?>
		</div>

		<!-- feedback end -->
		<!-- footer -->

		<footer id="copyright">
			<span>&copy; Cars. All rights reserved.</span>
		</footer>

		<!-- end of footer -->
	</div>
	</body>
</html>
