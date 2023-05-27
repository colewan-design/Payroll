<?php require_once("config.php"); 
require_once("process.php"); 
//employee logout activity
if (isset($_GET['logout'])){
	
	$admin_id = $_GET['admin_id'];
	$activity_type = "Sign out";
  
	$time_logged = date("Y-m-d H:i:s",strtotime("now"));
	$mysqli->query("INSERT INTO activity (time_logged, admin_id, activity_type) VALUES ('$time_logged', '$admin_id', '$activity_type')") or
	die($mysqli->error);
  
	
	session_start();
	unset($_SESSION['email']);
    header("location:login.php"); 
  }

?>