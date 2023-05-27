<?php
 include_once 'config_dropdown.php';
 
 if($_POST['tag']=='projectList')
 {
   $query = "select * from project";

   $result = mysqli_query($con,$query);

   $arr =[];
   $i=0;

   while($row = mysqli_fetch_assoc($result))
   {
     $arr[$i] = $row;
     $i++;
   }

   echo json_encode($arr);
 }

 // Getting position list on the basis of project_id
 if($_POST['tag']=='positionList')
 {
   $project_id = $_POST['project_id'];

   $query = "select * from position where project_id ='".$project_id."'" ;

   $result = mysqli_query($con,$query);

   $arr =[];
   $i=0;

   while($row = mysqli_fetch_assoc($result))
   {
     $arr[$i] = $row;
     $i++;
   }

   echo json_encode($arr);
 }

 

  
?>