<?php
	require_once 'conn.php';
	
	if(ISSET($_POST['update'])){
		$id = $_POST['positionId'];
		$positionName = $_POST['positionName'];
		
		mysqli_query($conn, "UPDATE position SET positionName='$positionName' WHERE positionId=$id") or die($mysqli_error());

		header("location: position.php");
	}
?>