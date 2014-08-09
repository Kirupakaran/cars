<!DOCTYPE HTML>
<html>
	<head>
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<title>Petrol Vs Diesel Cars</title>
		<link rel="stylesheet" href="css/pure/pure-min.css">
		<link rel="stylesheet" href="css/pure/grids-responsive-min.css">
		<link rel="stylesheet" href="css/altstyle.css" />
		<link rel="stylesheet" href="css/magnific-popup.css">
		<script src="js/jquery.min.js"></script>
		<script src="js/script.js"></script>
		<script src="js/jquery.magnific-popup.min.js"></script>
	</head>
	<body>
	<div class="header">
    <div class="home-menu pure-menu pure-menu-open pure-menu-horizontal pure-menu-fixed">
        <a class="pure-menu-heading" href="">Home</a>
        <ul>
						<li><a href="#nav1">Compare</a></li>
            <li><a href="dealerlog.php">Dealer</a></li>
            <li><a href="#">Admin</a></li>
        </ul>
    </div>
	</div>

		<!-- start of splash page -->
		<div class="splash-container">
			<div class="splash">
					<h1 class="splash-head">Petrol vs Diesel Cars</h1>
					<p class="splash-subhead">A site to compare petrol and diesel cars and find which one is right for you</p>
			</div>
		</div>
		<!-- end of splash -->
	<div id="nav1" class="content-wrapper">
		<!-- form -->
		<div class="content">
			<div class="pure-g">
				<div class="pure-u-1">
					<h2 class="content-head">Let's compare cars, Shall We?</h2>
					<?php require('./includes/form.inc.php'); ?>
				</div>
			</div>
		</div>
		<!-- end of form -->
		<!-- cars comparison section -->
		<div class="content compare">
			<div id="cars"></div>
		</div>

		<!-- end of comparison -->
		<!-- dealer search section -->
		<div class="content">
			<div id="dealers"></div>
		</div>
		<!-- end of dealer search -->
		<!-- feedback section -->
		<div class="content feedback">
			<div class="pure-g">
				<div class="l-box-lrg pure-u-1" id="feedbackdiv">
					<h2>FEEDBACK</h2>
					<?php require('./includes/feedback.php'); ?>
				</div>
			</div>
		</div>
		<!-- feedback end -->
		<!-- footer -->
		<footer class="footer">
			<div class="pure-g">
				<div class="pure-u-1 footer-content">
					<span>&copy; Cars. All rights reserved.</span>
				</div>
			</div>
		</footer>
		<!-- end of footer -->
	</div>
	</body>
</html>
