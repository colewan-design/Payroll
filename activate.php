<?php

	// Connect to database
  $con = new mysqli('bsu-info.tech', 'u455679702_cps', 'OpK3RKh]!h9', 'u455679702_cps') or die(mysqli_error($mysqli));     
     

	// Check if id is set or not if true toggle,
	// else simply go back to the page
	if (isset($_GET['id'])){

		// Store the value from get to a
		// local variable "course_id"
		$employee_id=$_GET['id'];

		// SQL query that sets the status
		// to 1 to indicate activation.
		$sql="UPDATE `userlogin` SET
			`designation`= 1 WHERE employee_data_id='$employee_id'";

		// Execute the query
		mysqli_query($con,$sql);
	}

	// Go back to course-page.php
	header('location: employee-account.php');
?>