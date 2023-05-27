<?php 
require_once("config.php"); 
DATE_DEFAULT_TIMEZONE_SET('Asia/Manila');
$mysqli = new mysqli('bsu-info.tech', 'u455679702_cps', 'OpK3RKh]!h9', 'u455679702_cps') or die(mysqli_error($mysqli)); 

if(isset($_POST['sublogin'])){ 
$login = $_POST['login_var'];
$password = $_POST['password'];
$role = $_POST['role'];

//saving activity history
$activity_type = "Sign in";
$query = "select * from users where ( username='$login' OR email = '$login')";
$findresult = mysqli_query($dbc, "SELECT * FROM users WHERE ( username='$login' OR email = '$login')");
if($res = mysqli_fetch_array($findresult))
{
$admin_id = $res['id']; 
}
$time_logged = date("Y-m-d H:i:s",strtotime("now"));
$mysqli->query("INSERT INTO activity (time_logged, admin_id, activity_type) VALUES ('$time_logged', '$admin_id', '$activity_type')") or die($mysqli->error);
$res = mysqli_query($dbc,$query);
$numRows = mysqli_num_rows($res);
if ($role == 'admin') {
  if($numRows  == 1){
          $row = mysqli_fetch_assoc($res);
          if(password_verify($password,$row['password'])){
            $_SESSION["login_sess"]="1"; 
              $_SESSION["login_email"]= $row['email'];
              $_SESSION["role"]= 'admin';
                  header("location:index.php");
          }
          else{ 
              header("location:login.php?loginerror=".$login);
          }
      }
      else{
    header("location:login.php?loginerror=".$login);
      }  
  }
else{
if($numRows  == 1){
        $row = mysqli_fetch_assoc($res);
        if(password_verify($password,$row['password'])){
           $_SESSION["login_sess"]="1"; 
             $_SESSION["login_email"]= $row['email'];
  header("location:index.php");
        }
        else{ 
     header("location:login.php?loginerror=".$login);
        }
    }
    else{
  header("location:login.php?loginerror=".$login);
    }
}  
}
?>