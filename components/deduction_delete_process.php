<?php 
if (isset($_GET['deductionDelete'])){
  $deductionId = $_GET['deductionDelete'];
  $mysqli->query("DELETE FROM deductions WHERE deductionId=$deductionId") or die($mysqli->error());

  $_SESSION['message'] = "Record has been deleted!";
  $_SESSION['msg_type'] = "danger";

  header("location:deductions.php");
}
?>