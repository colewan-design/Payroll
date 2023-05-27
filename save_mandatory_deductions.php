<?php
ini_set('display_errors', 1);
error_reporting(E_ALL);
	require_once 'conn.php';
	
	if(ISSET($_POST['save'])){
		$deductionName = $_POST['deductionName'];
		$description = $_POST['description'];
		$amount = $_POST['amount'];
        $deductionType = $_POST['deductionType'];
        $minDeductionLimit = $_POST['minDeductionLimit'];
          $maxDeductionLimit = $_POST['maxDeductionLimit'];

		

	mysqli_query($conn, "INSERT INTO deductions (deductionName, description, amount, deductionType, minDeductionLimit, maxDeductionLimit) VALUES ('$deductionName', '$description', '$amount', '$deductionType', '$minDeductionLimit', '$maxDeductionLimit')") or die(mysqli_error($conn));

		
        


        
		header("location: deductions.php");
	}
?>

