<?php
	require_once 'conn.php';
	
	if(ISSET($_POST['save'])){
		$allowanceName = $_POST['allowanceName'];
		$allowanceDescription = $_POST['allowanceDescription'];
		$allowanceAmount = $_POST['allowanceAmount'];
		
		mysqli_query($conn, "INSERT INTO allowance (allowanceName, allowanceDescription, allowanceAmount)  VALUES('$allowanceName', '$allowanceDescription', '$allowanceAmount')") or die($mysqli_error());
		
	
		header("location: incentives.php");
	}
?>

