<!DOCTYPE HTML>
<html>
	<head>
		<title>Petrol Vs Diesel Cars</title>
		<!--<link rel="stylesheet" href="css/style.css" />
		<link href="css/dsstyle.css" rel="stylesheet" type="text/css" media="all" />
		<link rel="stylesheet" href="css/bootstrap.min.css" />
		<link rel="stylesheet" href="css/style.css" />
		<link rel="stylesheet" href="css/style2.css" /> -->
		<link rel="stylesheet" href="http://yui.yahooapis.com/pure/0.5.0/pure-min.css">
		<script src="js/jquery.min.js"></script>
		<script src="js/script.js"></script>
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
		<section id="form-section">
			<div id="form">
				<?php require('./includes/form.inc.php'); ?>
			</div>
		</section>
		<!-- end of form -->
		<!-- cars comparison section -->
		<section id="cars-section">
			<div id="cars"></div>
		</section>

		<!-- end of comparison -->
		<!-- dealer search section -->
		<section id="dealers-section">
		<div id="dealers"></div>
		</section>
		<!-- end of dealer search -->
		<!-- feedback section -->
		<section id="feedback-section">
			<div id="feedbackdiv">
				<h2>FEEDBACK</h2>
				<p> We accept any suggestions,comments and queries that you may have.</p>
				<?php require('./includes/feedback.php'); ?>
			</div>
		</section>
		<!-- feedback end -->
		<!-- footer -->

		<footer id="copyright">
			<span>&copy; Cars. All rights reserved.</span>
		</footer>

		<!-- end of footer -->
	</div>
	</body>
</html>
