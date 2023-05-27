<?php
	require_once 'conn.php';
	if(ISSET($_POST['save'])){
		$otherDeductionName = $_POST['otherDeductionName'];
		mysqli_query($conn, "INSERT INTO otherdeductions (otherDeductionName)  VALUES('$otherDeductionName')") or die($mysqli_error());
		header("location: other_deductions.php");
	}
?>

