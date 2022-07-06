<?php



//declare database
$mysqli = new mysqli('localhost', 'root', '', 'crud') or die(mysqli_error($mysqli));  
 
$id = 0;  
$update = false;
$name = '';
$position = '';
$sg = '';
$step = '';
$username = '';
//save
if(isset($_POST['save'])){
    $name = $_POST['name'];
    $position = $_POST['position'];
    $sg = $_POST['sg'];
    $step = $_POST['step'];
    $mysqli->query("INSERT INTO dataa (name, position, sg, step) VALUES ('$name', '$position', '$sg', '$step')") or
            die($mysqli->error);

            
    $_SESSION['message'] = "Record has been saved!";
    $_SESSION['msg_type'] = "success";

    header("location:employees.php");
}
//dete
if (isset($_GET['delete'])){
    $id = $_GET['delete'];
    $mysqli->query("DELETE FROM dataa WHERE id=$id") or die($mysqli->error());

    $_SESSION['message'] = "Record has been deleted!";
    $_SESSION['msg_type'] = "danger";

    header("location:employees.php");
}

//edit
if (isset($_GET['edit'])){
    $id = $_GET['edit'];
    $update = true;
    $result = $mysqli->query("SELECT * FROM dataa WHERE id=$id") or die($mysqli->error());

    if (is_countable($result) && count($result) == 1){
        $row = $result->fetch_array();
        $name = $row['name'];
        $position = $row['position'];
        $sg = $row['sg'];
        $step = $row['step'];
    
    }
}
//update
if (isset($_POST['update'])){
    $id = $_POST['id'];
    $name =$_POST['name'];
    $position =$_POST['position'];
    $sg =$_POST['sg'];
    $step =$_POST['step'];

   $mysqli->query("UPDATE dataa SET name='$name', position='$position', sg='$sg', step='$step' WHERE id=$id") or die($mysqli->error());

   $_SESSION['message'] = "Record has been updated!";
   $_SESSION['msg_type'] = "warning";

   header("location:employees.php");
}


//show user name
    

?>