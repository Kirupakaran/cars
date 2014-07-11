<?php
require('connection.inc.php');
$con=dbconnect('root','');
$stmt = $con->stmt_init();
$carbrand = mysqli_real_escape_string($con, trim($_GET['carbrand']));
$carmodel=mysqli_real_escape_string($con, trim($_GET['carmodel']));
$sql1="SELECT DISTINCT(variant),car_id FROM cardetails WHERE brand = ? AND carmodel = ? AND cartype = 2";
$stmt->prepare($sql1);
$stmt->bind_param('ss', $carbrand, $carmodel);
$stmt->execute();
$carvariant = $stmt->get_result(); ?>
<option value=''>Petrol variant</option>
<?php if (mysqli_num_rows($carvariant) >= 1) { 
	while($row=$carvariant->fetch_assoc()) { ?>
	<option  value="<?php echo $row['car_id']; ?>" <?php if (isset($_GET['petrolvariant']) && $_GET['petrolvariant']==$row['variant']) { echo 'selected'; } ?>>
	<?php echo $row['variant']; ?>
</option>
<?php }
}
			
?>