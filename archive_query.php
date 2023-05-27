<?php
	date_default_timezone_set("Etc/GMT+8");
	
	require_once 'conn.php';
	
	$query = mysqli_query($conn, "SELECT * FROM `payroll_list`");
    

	$date = date("Y-m-d");
	while($fetch = mysqli_fetch_array($query)){
		if(strtotime($fetch['payroll_to']) < strtotime($date)){
			mysqli_query($conn, "INSERT INTO archive VALUES('$fetch[payroll_from]', '$fetch[payroll_to]', '$fetch[gross_amount]', NULL,  '$fetch[emp_id]', '$fetch[payroll_type]', '$fetch[payroll_id]')") or die(mysqli_error($conn));
            mysqli_query($conn, "DELETE FROM payroll_list WHERE payroll_id = '$fetch[payroll_id]'") or die(mysqli_error($conn));
		}
	}
	
?>