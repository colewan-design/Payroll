<?php
	require_once 'conn.php';
	
	if(ISSET($_POST['update'])){
		$id = $_POST['otherDeductionId'];
		$otherDeductionName = $_POST['otherDeductionName'];
		
		mysqli_query($conn, "UPDATE otherdeductions SET otherDeductionName='$otherDeductionName' WHERE otherDeductionId=$id") or die($mysqli_error());

		header("location: other_deductions.php");
	}
?>