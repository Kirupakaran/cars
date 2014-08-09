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
	<link rel="stylesheet" href="css/pure/pure-min.css">
  <link rel="stylesheet" href="css/pure/grids-responsive-min.css">
  <style>
    .home-menu {
      padding: 0.1em;
      text-align: center;
      box-shadow: 0 1px 1px rgba(0,0,0, 0.10);
    }

    .home-menu.pure-menu-open {
      background: rgba(15, 53, 161, 0.8);
    }

    .home-menu .pure-menu-heading {
      color: white;
      font-size: 1.1em;
      font-weight: 400;
      float:left;
    }

    .home-menu .pure-menu-selected a {
      color: white;
    }

    .home-menu a {
      color: #fff;
      font-weight: 400;
    }

    .home-menu ul {
      float:right;
      padding-right: 5px;
    }

    .home-menu li a:hover,
    .home-menu li a:focus {
      background: rgba(15, 53, 111, 0.7);
    }

    .home-menu li:first-child {
      border-right: 1px solid rgba(15, 0, 161, 0.5);
      padding-right: 1em;
    }

    .button-success {
      background: rgb(28, 184, 65);
    }

    #customers {
      margin: 0 auto;
      width: 80%;
    }

    .custName {
      font-weight: bold;
    }
    #wrapper {
      margin-top: 5em;
    }

    #menu {
      font-size: 1.1em;
      margin: 0 auto;
      width: 90%;
    }

    #menu ul li {
      color: #bbb;
      display: inline;
      padding: 5px;
    }

    #menu ul li:hover {
      background: #ddd;
    }

    @media (max-width: 48em) {
      p {
        margin: 4px;
      }

      .home-menu {
        font-size: 0.7em;
      }
    }
  </style>
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
      $("#inbox").css('color', 'black');
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
        $("#inbox").css('color', 'black');
        $("#old").css('color', '#265778');
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
        $("#inbox").css('color', '#265778');
        $("#old").css('color', 'black');
			}
		});
	});
});
</script>
<header>
  <div class="home-menu pure-menu pure-menu-open pure-menu-horizontal pure-menu-fixed">
      <a class="pure-menu-heading" href="http://localhost/pdc/index.php">Home</a>
      <ul>
        <li><a href="dealerlog1.php">Change Password</a>
        <li>
          <?php
            include('./includes/logout.inc.php');
            logout("http://localhost/pdc/dealerlog.php");
          ?>
      </ul>
  </div>
</header>
<div id="wrapper">
<?php
if (!empty($message)) {
	echo "<p>$message</p>";
}
else {?>
<div id="menu">
		<ul>
			<li id="inbox">Inbox
			<li id="old">Old
		</ul>
</div>
<div id="main">
</div>
<?php } ?>
</div>
</body>
</html>
