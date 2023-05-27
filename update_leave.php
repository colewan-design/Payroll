<?php
	require_once 'conn.php';
	
	if(ISSET($_POST['update'])){
		$id = $_POST['id'];
		$leave_deduction = $_POST['leave_deduction'];
		mysqli_query($conn, "UPDATE data SET leave_deduction='$leave_deduction' WHERE id=$id") or die($mysqli_error());

		header("location: employee_leave.php");
	}
?>