<?php 
require_once 'conn.php';

if(ISSET($_POST['update'])){
    $id = $_POST['id'];
    $emp_id = $_POST['emp_id'];
    $remark_text = $_POST['remark_text'];

    mysqli_query($conn, "UPDATE remarks SET remark_text='$remark_text' WHERE id=$id") or die(mysqli_error($mysqli_error));

    header("location: employee-details.php?id=$emp_id");
}
?>