<?php 
ini_set('display_errors', 1);
error_reporting(E_ALL);
require_once "controllerUserData.php";
require_once("config.php"); 
if(!isset($_SESSION)) { 
	session_start(); 
  }  
$mysqli = new mysqli('bsu-info.tech', 'u455679702_cps', 'OpK3RKh]!h9', 'u455679702_cps') or die(mysqli_error($mysqli));
$result = $mysqli->query("SELECT * FROM data") or die($mysqli->error);
$email = $_SESSION['email'];

$password = $_SESSION['password'];

if($email != false && $password != false){
    $sql = "SELECT * FROM usertable WHERE email = '$email'";
    $run_Sql = mysqli_query($con, $sql);
    if($run_Sql){
        $fetch_info = mysqli_fetch_assoc($run_Sql);
        $status = $fetch_info['status'];
        $code = $fetch_info['code'];
		$image = $fetch_info['image'];
		$name = $fetch_info['name'];
        if($status == "verified"){
            if($code != 0){
                header('Location: reset-code.php');
            }
        }else{
           
        }
    }
}else{
    header('Location: login.php');
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>CBOO | New Account</title>
 <!-- Selectpicker -->
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-select@1.13.14/dist/css/bootstrap-select.min.css">
  <script src="https://cdn.jsdelivr.net/npm/bootstrap-select@1.13.14/dist/js/bootstrap-select.min.js"></script>
  <!-- Google Font: Source Sans Pro -->
  <link href='https://fonts.googleapis.com/css?family=Inter' rel='stylesheet'>
  <!-- Font Awesome -->
  <link rel="stylesheet" href="plugins/fontawesome-free/css/all.min.css">
  <!-- Ionicons -->
  <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
  <!-- Tempusdominus Bootstrap 4 -->
  <link rel="stylesheet" href="plugins/tempusdominus-bootstrap-4/css/tempusdominus-bootstrap-4.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="dist/css/adminlte.css">
  <!-- Select2 -->
  <link rel="stylesheet" href="plugins/select2/css/select2.min.css">
  <link rel="stylesheet" href="plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css">
  <!-- overlayScrollbars -->
  <link rel="stylesheet" href="plugins/overlayScrollbars/css/OverlayScrollbars.min.css">
  <!-- Daterange picker -->
  <link rel="stylesheet" href="plugins/daterangepicker/daterangepicker.css">
	<link rel="stylesheet" type="text/css" href="dist/css/login/icon-font.min.css"/>
  <script src="plugins/sweetalert2/sweetalert2.all.js"></script>
  <script>
    		 //Success Message
		 function succ() {
            new swal(
                {
                    title: 'Registration Successful!',
                    type: 'success',
					          confirmButtonText: 'OK',
                    confirmButtonClass: 'btn btn-success',
                }
            ).then(function(){
					window.location = "new_user.php";
			})
			}
			//Wrong password Message
		 function wrongpass() {
            new swal(
                {
                    title: 'Passwords do not match!',
                    type: 'success',
					          confirmButtonText: 'OK',
                    confirmButtonClass: 'btn btn-success',
                }
            ).then(function(){
					window.location = "new_user.php";
			})
			}
  </script>
</head>
<body class="hold-transition sidebar-mini layout-fixed">
<div class="wrapper">


  <!-- Navbar -->
  <nav class="main-header navbar navbar-expand navbar-white navbar-light">
    <!-- Left navbar links -->
    <ul class="navbar-nav">
      <li class="nav-item">
        <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
      </li>
    </ul>

    <!-- Right navbar links -->
  </nav>
  <!-- /.navbar -->

  <!-- Main Sidebar Container -->
  <aside class="main-sidebar sidebar-dark-olive elevation-4">
    <!-- Brand Logo -->
    <a href="#" class="brand-link">
      <img src="src/images/cboo.jpg" alt="AdminLTE Logo" class="brand-image img-circle elevation-3" style="opacity: .8">
      <span class="brand-text font-weight-light">BSU-CBOO</span>
    </a>

     <!-- Sidebar -->
    <div class="sidebar">
      <!-- user avatar component -->
      <?php  require 'components/user_avatar.php'; ?>
      

    <!-- Sidebar Menu -->
     <?php  require 'components/nav-bar.php'; ?>
      <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
  </aside>

  <!-- Content Wrapper. Contains page content -->
  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0">New Account</h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="index.php">Home</a></li>
              <li class="breadcrumb-item">Admin Actions</li>
              <li class="breadcrumb-item active">Create Employee Account</li>
            </ol>
          </div><!-- /.col -->
        </div><!-- /.row -->
      </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->

    <!-- Main content -->
    <section class="content">
        <div class="card m-auto" style="padding: 20px; width:70%;">
          <?php 
                          function generateRandomPassword($length = 8) {
                    $chars = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789';
                    $chars_length = strlen($chars);
                    $password = '';
                    for ($i = 0; $i < $length; $i++) {
                        $password .= $chars[rand(0, $chars_length - 1)];
                    }
                    return $password;
                }
				if(isset($_POST['create_employee_account'])){
				    $user_email =  $_POST['user_email'];
                        $employee_id =  $_POST['user_name'];
                        
                        $email_check = "SELECT * FROM userlogin WHERE employee_email = '$user_email'";
                        $res = mysqli_query($con, $email_check);
                        if(mysqli_num_rows($res) > 0){
                            $errors['user_email'] = "Email that you have entered is already exist!";
                        }
                        else{
                            $data_result = mysqli_query($mysqli, "SELECT * FROM data where id = $employee_id");
                            if($data_res = mysqli_fetch_array($data_result))
                            {
                                $employee_name = $data_res['name'];   
                            }
                            
                            // Generate a random password
                            $password = generateRandomPassword();
                            $text_password = $password;
                            $confirm_password = $password;
                            
                            $role = 'active';
                            $date = date('Y-m-d');
                            $options = array("cost"=>4);
                            $password = password_hash($password,PASSWORD_BCRYPT,$options);
                        
                            //Insert to DB
                            $result = mysqli_query($dbc,"INSERT INTO userlogin(name,employee_email,password,date,role, status, employee_data_id, designation, first_log) VALUES('$employee_name','$user_email','$password','$date','user', 'verified', '$employee_id', '1', '0')");
                        
                            $subject = "Account setup complete - CBOO";
                            $message = "Your password in CBOO Payroll Website is $text_password. You can use this link to login: https://cps.bsu-info.tech/home.php";
                            $sender = "From: cts.colewan@gmail.com";
                            $email = $user_email;
                            $user_password = $password;
                        
                            if(mail($email, $subject, $message, $sender)){
                                $_SESSION['employee_email'] = $email;
                                $_SESSION['password'] = $user_password;
                            }
                        
                            echo "<script type = 'text/javascript'>
                                    succ();
                                </script>";
                        }
                        
                       
			}
							?>
            <div class="col-sm">
							<?php 
								if(isset($error)){
									foreach($error as $error){
										echo '<p class="errmsg" style = "color:#fff;">&#x26A0;'.$error.' </p>'; 
									}
								}
							?>
							</div>
						
							 <div class="message-container">
                                 
                                </div>

                            <form method="POST" action="#">
                                <div class="row m-3">
                                    <div class="col-md-6 col-sm-12">
                                            <label>Employee Name</label>
                                            <div class="input-group "  >
                                                
                                            <select class="form-control form-control-md selectpicker" data-live-search="true" name="user_name">
                                            
                                                <?php
                                                  $resultsss = $mysqli->query("SELECT * FROM data") or die($mysqli->error);
                                                  while ($trowt = mysqli_fetch_array($resultsss)) {
                                                    $trowst[] = $trowt;
                                                  }
                                                  foreach ($trowst as $trowt) {
                                                    print "<option value='" . $trowt['id'] . "'>" . $trowt['name'] . "</option>";
                                                  }
                                                ?>
                                            </select>

                                                <div class="input-group-append custom">
                                                    <span class="input-group-text"
                                                        ><i class="icon-copy dw dw-user1"></i
                                                    ></span>
                                                </div>
                                            </div>
                                    </div>
                                    <div class="col-md-6 col-sm-12">
                                            <label>Email Address</label>
                                            <div class="input-group custom">
                                                <input
                                                    name="user_email"
                                                    type="email"
                                                    class="form-control form-control-md"
                                                    placeholder="Email address"
                                                  
                                                  autocomplete="new-email"
                                                    required
                                                  />
                                                <div class="input-group-append custom">
                                                    <span class="input-group-text"
                                                        ><i class="icon-copy dw dw-email1"></i></span>
                                                </div>
                                            </div>
                                    </div>
                                </div>
                                
                                
                            <div class="row m-3">
                               
                                <div class="col-md-6 col-sm-12">
                                  <div class="input-group mb-0 d-flex justify-content-center">
                                    <button type="submit" name="create_employee_account" class="btn btn-primary btn-md" type="submit" style="width: 60%;">Create Account</button>
                                  </div>
                                </div>
							</div>
                            </form>
						
                    </div>
    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->
  <footer class="main-footer d-flex justify-content-center">
    <strong>CBOO-CPMS@BSU</strong>
    <div class="float-right d-none d-sm-inline-block">
    </div>
  </footer>
</div>
<!-- ./wrapper -->
<!-- jQuery -->
<script src="plugins/jquery/jquery.min.js"></script>
<!-- jQuery UI 1.11.4 -->
<script src="plugins/jquery-ui/jquery-ui.min.js"></script>
<!-- Resolve conflict in jQuery UI tooltip with Bootstrap tooltip -->
<script>
  $.widget.bridge('uibutton', $.ui.button)
</script>
<!-- Bootstrap 4 -->
<script src="plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<!-- daterangepicker -->
<script src="plugins/moment/moment.min.js"></script>
<script src="plugins/daterangepicker/daterangepicker.js"></script>
<!-- Tempusdominus Bootstrap 4 -->
<script src="plugins/tempusdominus-bootstrap-4/js/tempusdominus-bootstrap-4.min.js"></script>
<!-- overlayScrollbars -->
<script src="plugins/overlayScrollbars/js/jquery.overlayScrollbars.min.js"></script>
<!-- Select2 -->
<script src="plugins/select2/js/select2.full.min.js"></script>
<!-- AdminLTE App -->
<script src="dist/js/adminlte.js"></script>
<!-- AdminLTE for demo purposes -->
<script src="dist/js/demo.js"></script>
 <!-- Selectpicker -->
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-select@1.13.14/dist/css/bootstrap-select.min.css">
  <script src="https://cdn.jsdelivr.net/npm/bootstrap-select@1.13.14/dist/js/bootstrap-select.min.js"></script>
<!-- AdminLTE dashboard demo (This is only for demo purposes) -->
<script src="dist/js/pages/dashboard.js"></script>
		<!-- js -->
		<script src="dist/css/login/core.js"></script>
		<script src="dist/css/login/layout-settings.js"></script>
<!-- Page specific script -->
<script>
  $(function () {
    //Initialize Select2 Elements
    $('.select2').select2()

    //Initialize Select2 Elements
    $('.select2bs4').select2({
      theme: 'bootstrap4'
    })
  }) 
  </script>

</body>
</html>
