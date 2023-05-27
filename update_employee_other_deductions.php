<?php
	require_once 'conn.php';
	
	if(ISSET($_POST['update'])){
        $id = $_POST['id'];
		$odid = $_POST['odid'];//odid
		$other_deduction_amount = $_POST['other_deduction_amount'];
		mysqli_query($conn, "UPDATE employeeotherdeductions SET employeeOtherDeductionAmount='$other_deduction_amount' WHERE odId=$odid") or die($mysqli_error());

		header("location: employee-details.php?id=$id");
	}
?>