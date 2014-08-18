<?php
	require('./includes/connection.inc.php');
		$con=dbconnect('root','');
		$stmt = $con->stmt_init();
		$sql2="SELECT brand,carmodel,variant FROM cardetails LIMIT 2, 3";
		$stmt->prepare($sql2);
		$stmt->execute();
		$list= $stmt->get_result();?>
		<?php if (mysqli_num_rows($list) >= 1){
		while($row=$list->fetch_assoc()) { ?>
		<li><?php echo "$row[brand] $row[carmodel] $row[variant]" ?> </li>
		<?php }
	}
?>
