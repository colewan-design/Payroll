<?php
include 'db.php';
$mysqli = new mysqli('bsu-info.tech', 'u455679702_cps', 'OpK3RKh]!h9', 'u455679702_cps') or die(mysqli_error($mysqli));
$result = $mysqli->query("SELECT * FROM data") or die($mysqli->error);
if(isset($_POST["Import"])){
 
	$admin_id = $_POST['admin_id'];
	$activity_type = "Import employee data";
  
	$time_logged = date("Y-m-d H:i:s",strtotime("now"));
	$mysqli->query("INSERT INTO activity (time_logged, admin_id, activity_type) VALUES ('$time_logged', '$admin_id', '$activity_type')") or
	die($mysqli->error);
	

		echo $filename=$_FILES["file"]["tmp_name"];
 
 
		 if($_FILES["file"]["size"] > 0) {
    $file = fopen($filename, "r");
    $counter = 0;
    while (($emapData = fgetcsv($file, 10000, ",")) !== FALSE) {
        $sql = "INSERT into data (`name`, `id`, `sg`, `step`, `salary`, `position`) 
                values('$emapData[0]','$emapData[1]','$emapData[2]','$emapData[3]','$emapData[4]','$emapData[5]')";
        $result = mysqli_query( $conn, $sql );
        if(! $result ) {
            echo "<script type=\"text/javascript\">
                    alert(\"Invalid File:Please Upload CSV File.\");
                    window.location = \"employees.php\"
                  </script>";
        } else {
            $counter++;
        }
    }
    fclose($file);
    echo "<script type=\"text/javascript\">
            alert(\"$counter records have been successfully imported.\");
            window.location = \"employees.php\"
          </script>";
    mysqli_close($conn);
}
}

?>	