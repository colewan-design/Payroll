<?php 
require_once('db_connect.php');
// extracting POST Variables
extract($_POST);
    $error = [];
    $check = $conn->query("SELECT * FROM `data` where name = '{$name}'". (isset($id) && $id > 0 ? " and id != '{$id}' " : "" ));
    if($check->num_rows > 0){
        $error['field_name'] = 'name';
        $error['msg']=" Employee Name already exists";
    }
    echo json_encode($error);
?>