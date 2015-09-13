<?php
require('includes/connection.inc.php');
session_start();
// This page is for posting customer details
// if session variable not set, redirect to login page
if (!isset($_SESSION['authenticated'])) {
  header('Location: http://localhost/pdc/dealerlog.php');
  exit;
}
$dealerid = $_SESSION['dealerid'];

$choice = 2;
if($_POST && isset($_POST['choice'])) {
	if(is_numeric($_POST['choice'])) {
		$choice = $_POST['choice'];
	}
}
$conn = dbconnect('root', '');
$customersQuery = "SELECT * FROM customerdetails WHERE dealerid = '$dealerid' ";
if($choice == 2) { //inbox. last 30 days customers
	$customersQuery = $customersQuery . "AND (TO_DAYS(NOW()) - TO_DAYS(dateAdded)) <= 31 ";
}
else if($choice == 3) { //old customers
	$customersQuery = $customersQuery . "AND (TO_DAYS(NOW()) - TO_DAYS(dateAdded)) > 31 ";
}
$customers = $conn->query($customersQuery) or die(mysqli_error($conn));
$customerDetails = array();
if($customers != null) {
	while($customer = $customers->fetch_assoc()) {
		$carid = $customer['car_id'];
		$car = $conn->query("SELECT CONCAT(brand,' ',carmodel, ' ', variant) as car FROM cardetails WHERE car_id=$carid");
		$customerDetails[] = array(
								"Name" => $customer['cust_name'],
								"Mail" => $customer['cust_mailid'],
								"Phone" => $customer['cust_phno'],
								"Car" => $car->fetch_assoc()['car']);
	}
}

if(empty($customerDetails)) {
	echo "<p id='empty'>Sorry, Nothing here.</p>";
}
else {?>
	<table class="pure-table pure-table-striped" id="customers">
    <tbody>
  		<?php
  		foreach ($customerDetails as $customer) {?>
  			<tr>
  				<td>
            <div class="pure-g">
              <div class="pure-u-1 pure-u-md-1-2 pure-u-lg-1-4">
                <p class="custName"><?php echo $customer['Name']; ?></p>
              </div>
              <div class="pure-u-1 pure-u-md-1-2 pure-u-lg-1-4">
  				      <p><?php echo $customer['Mail']; ?></p>
              </div>
              <div class="pure-u-1 pure-u-md-1-2 pure-u-lg-1-4">
  				      <p><?php echo $customer['Phone']; ?></p>
              </div>
              <div class="pure-u-1 pure-u-md-1-2 pure-u-lg-1-4">
  				      <p><?php echo $customer['Car']; ?></p>
              </div>
            </div>
          </td>
  			</tr>
  		<?php } ?>
    </tbody>
	</table>
<?php } ?>
