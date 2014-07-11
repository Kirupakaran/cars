<?php
require('connection.inc.php');
$con=dbconnect('root','');
$stmt = $con->stmt_init();
$carbrand = mysqli_real_escape_string($con, trim($_GET['carbrand']));
$sql2="SELECT DISTINCT(carmodel) FROM cardetails WHERE brand = ? ";
$stmt->prepare($sql2);
$stmt->bind_param('s', $carbrand);
$stmt->execute();
$carmodel = $stmt->get_result();?>
<option value=''>Car Model</option>
<?php if (mysqli_num_rows($carmodel) >= 1){
while($row=$carmodel->fetch_assoc()) { ?>
	<option  value="<?php echo $row['carmodel']; ?>" <?php if (isset($_GET['carname_d']) && $_GET['carname_d']==$row['carmodel']) { echo 'selected'; } ?>>
		<?php echo $row['carmodel']; ?>
	</option>
<?php }
}
?>