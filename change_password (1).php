<?php require_once "controllerUserData.php";
require_once("config.php"); 
if(!isset($_SESSION)) { 
	session_start(); 
  }  ?>
<?php 
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
            header('Location: user-otp.php');
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
  <title>CBOO | Change Password</title>

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
  <!-- overlayScrollbars -->
  <link rel="stylesheet" href="plugins/overlayScrollbars/css/OverlayScrollbars.min.css">
  <!-- Daterange picker -->
  <link rel="stylesheet" href="plugins/daterangepicker/daterangepicker.css">
<link rel="stylesheet" type="text/css" href="dist/css/login/icon-font.min.css"/>

  <script src="plugins/sweetalert2/sweetalert2.all.js"></script>
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
            <h1 class="m-0">Admin Password</h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="index.php">Home</a></li>
              <li class="breadcrumb-item">Admin Actions</li>
              <li class="breadcrumb-item active">Change Password</li>
            </ol>
          </div><!-- /.col -->
        </div><!-- /.row -->
      </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->

    <!-- Main content -->
    <section class="content">
    <div class="card ml-auto mr-auto" style="width: 70%;">
		<div class="d-flex justify-content-center" style="padding:20px; padding-bottom:10px;">
            <div class="container">
    			<div>
        			<div > 
						<form method="POST" enctype='multipart/form-data'>
							<div class="login_form">
                                <?php 
                                        if(isset($error)){ 
                                             foreach($error as $error){ 
                                                echo '<p class="errmsg">'.$error.'</p>'; 
                                             }
                                        }
                                    ?> 
                                        <?php 
                                            ob_start();
                                    if(isset($_POST['change_password'])){
                                    $currentPassword=$_POST['currentPassword']; 
                                    $password=$_POST['password'];  
                                    $passwordConfirm=$_POST['passwordConfirm']; 
                                    $sql="SELECT password from usertable where email='$email'";
                                    $res = mysqli_query($dbc,$sql);
                                        $res=mysqli_query($dbc,$sql);
                                            $row = mysqli_fetch_assoc($res);
                                        if(password_verify($currentPassword,$row['password'])){
                                    if($passwordConfirm ==''){
                                                $error[] = 'Please confirm the password.';
                                            }
                                            if($password != $passwordConfirm){
                                                $error[] = 'Passwords do not match.';
                                            }
                                            // Validate password strength
                                            $uppercase = preg_match('@[A-Z]@', $password);
                                            $lowercase = preg_match('@[a-z]@', $password);
                                            $number    = preg_match('@[0-9]@', $password);
                                            $specialChars = preg_match('@[^\w]@', $password);
                                            if(!$uppercase || !$lowercase || !$number || !$specialChars || strlen($password) < 8) {
                                                $error[] = 'Password should be at least 8 characters in length, at least one upper case letter, one number, and one special character.';
                                            }
                                    if(!isset($error))
                                    {
                                        $options = array("cost"=>4);
                                        $password = password_hash($password,PASSWORD_BCRYPT,$options);

                                        $result = mysqli_query($dbc,"UPDATE usertable SET password='$password' WHERE email='$email'");
                                            if($result)
                                            {
                                               $error[] = 'Password Has Been Successfully Updated!';
                                            }
                                            else 
                                            {
                                                $error[]='Something went wrong';
                                            }
                                    }

                                            } 
                                            else 
                                            {
                                                $error[] = 'Current Password Does not match!'; 
                                            }   
                                        }
                                            if(isset($error)){ 

                                    foreach($error as $error){ 
                                    echo '<p class="errmsg">'.$error.'</p>'; 
                                    }
                                    }
                                    ob_end_flush();
                                            ?> 
     <form method="post" enctype='multipart/form-data' >
	 	<div class="input-group custom pb-2">
			<input
				name="currentPassword"
				type="password"
				id="password"
				class="form-control form-control-lg"
				placeholder="Current Password"
				required
			/>
			<div class="input-group-append custom">
				<span class="input-group-text">
					<i class="icon-copy bi bi-eye-fill" id="togglePassword"></i>
				</span>
				<script>
					const togglePassword = document.querySelector('#togglePassword');
					const password = document.querySelector('#password');
					togglePassword.addEventListener('click', () => {
						const type = password.getAttribute('type') === 'password' ? 'text' : 'password';
						password.setAttribute('type', type);
						// Toggle the eye and bi-eye icon
						$("#togglePassword").toggleClass('icon-copy bi bi-eye-slash-fill');
					});
				</script>
			</div>
			<div class="input-group-append custom">
				<span class="input-group-text">
					<i class="dw dw-padlock1"></i>
				</span>
			</div>
		</div>
		<div class="input-group custom pb-2">
			<input
				name="password"
				type="password"
				id="newPassword"
				class="form-control form-control-lg"
				placeholder="New Password"
				required
			/>
			<div class="input-group-append custom">
				<span class="input-group-text">
					<i class="icon-copy bi bi-eye-fill" id="toggleNew"></i>
				</span>
				<script>
					const toggleNew = document.querySelector('#toggleNew');
					const passwordNew = document.querySelector('#newPassword');
					toggleNew.addEventListener('click', () => {
						const type = passwordNew.getAttribute('type') === 'password' ? 'text' : 'password';
						passwordNew.setAttribute('type', type);
						// Toggle the eye and bi-eye icon
						$("#toggleNew").toggleClass('icon-copy bi bi-eye-slash-fill');
					});
				</script>
			</div>
			<div class="input-group-append custom">
				<span class="input-group-text">
					<i class="dw dw-padlock1"></i>
				</span>
			</div>
		</div>
		<div class="input-group custom pb-2">
			<input
				name="passwordConfirm"
				type="password"
				id="confirmPassword"
				class="form-control form-control-lg"
				placeholder="Confirm Password"
				required
			/>
			<div class="input-group-append custom">
				<span class="input-group-text">
					<i class="icon-copy bi bi-eye-fill" id="toggleConfirm"></i>
				</span>
				<script>
					const toggleConfirm = document.querySelector('#toggleConfirm');
					const passwordConfirm = document.querySelector('#confirmPassword');
					toggleConfirm.addEventListener('click', () => {
						const typeConfirm = passwordConfirm.getAttribute('type') === 'password' ? 'text' : 'password';
						passwordConfirm.setAttribute('type', typeConfirm);
						// Toggle the eye and bi-eye icon
						$("#toggleConfirm").toggleClass('icon-copy bi bi-eye-slash-fill');
					});
				</script>
			</div>
			<div class="input-group-append custom">
				<span class="input-group-text">
					<i class="dw dw-padlock1"></i>
				</span>
			</div>
		</div>
           <div class="row">
            <div class="col-sm-6">
            </div>
            <div class="col-sm-6" style="right:5rem;">
        <button  class="btn btn-success" name="change_password">Change Password</button>
            </div>
           </div>
       </form>
        </div>
        <div class="col-sm-3">
        </div>
    </div>
</div> 
        </main>
    </div>
                        </div>		
						</div>
    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->
  <footer class="main-footer">
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
<!-- AdminLTE App -->
<script src="dist/js/adminlte.js"></script>
<!-- AdminLTE for demo purposes -->
<script src="dist/js/demo.js"></script>
<!-- AdminLTE dashboard demo (This is only for demo purposes) -->
<script src="dist/js/pages/dashboard.js"></script>
<!-- Page specific script -->

</body>
</html>
