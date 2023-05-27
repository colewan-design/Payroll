<?php
	require_once 'conn.php';
	
	if(ISSET($_POST['update'])){
		$id = $_POST['id'];
		$salaryGrade = $_POST['salaryGrade'];
		$salaryAmount = $_POST['salaryAmount'];
		$salaryStep = $_POST['salaryStep'];
		
		mysqli_query($conn, "UPDATE salarydata SET salaryGrade='$salaryGrade', salaryAmount='$salaryAmount', salaryStep='$salaryStep' WHERE id=$id") or die($mysqli_error());
		$query = "SELECT * FROM data WHERE sg='$salaryGrade' && step='$salaryStep'";
        $result = mysqli_query($conn, $query);
        
        while ($row = mysqli_fetch_assoc($result)) {
            $id = $row['id'];
            $updateQuery = "UPDATE data SET salary='$salaryAmount' WHERE id=$id";
            mysqli_query($conn, $updateQuery) or die(mysqli_error($conn));
        }

		header("location: salary_matrix.php");
	}
?>