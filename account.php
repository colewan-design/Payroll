
<?php 
require_once "controllerUserData.php";
//declare database
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
    header('Location: login-user.php');
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>CBOO | Profile</title>

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
  <link rel="stylesheet" type="text/css" href="dist/css/login/core.css" />
<link rel="stylesheet" type="text/css" href="dist/css/login/icon-font.min.css"/>
	<link rel="stylesheet" type="text/css" href="dist/css/login/style.css" />
  <script src="plugins/sweetalert2/sweetalert2.all.js"></script>
</head>
<body class="hold-transition sidebar-mini layout-fixed">
<div class="wrapper">

  <!-- Preloader -->
  <div class="preloader flex-column justify-content-center align-items-center">
    <img class="animation__wobble img-circle" src="src/images/bsu.jpg" alt="AdminLTELogo" height="90" width="90">
  </div>

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
  <aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Brand Logo -->
    <a href="#" class="brand-link">
      <img src="src/images/cboo.jpg" alt="AdminLTE Logo" class="brand-image img-circle elevation-3" style="opacity: .8">
      <span class="brand-text font-weight-light">BSU-CBOO</span>
    </a>

    <!-- Sidebar -->
    <div class="sidebar">
      <!-- Sidebar user panel (optional) -->
      <div class="user-panel mt-3 pb-3 mb-3 d-flex">
        <div class="image">
           <?php if($image==NULL)
									{
									echo '<img src = "dist/img/user2-16x160.jpg" class="img-circle elevation-2">';
									} else { echo '<img src="images/'.$image.'" class="img-circle elevation-2">';}?> 
        </div>
        <div class="info active">
          <a href="#" class="d-block"><?php echo $name; ?></a>
        </div>
      </div>
        <?php include 'nav-bar.php'; ?>
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
            <h1 class="m-0">My Account</h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="index.php">Home</a></li>
              <li class="breadcrumb-item">Admin Actions</li>
              <li class="breadcrumb-item active">Profile</li>
            </ol>
          </div><!-- /.col -->
        </div><!-- /.row -->
      </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->

    <!-- Main content -->
    <section class="content">
        <div class="card ml-auto mr-auto mt-4 mb-4" style="width: 80%;">
		    <form style=" width:100%;" action="" method="POST" enctype='multipart/form-data'>
					<div class="login_form">

					<?php 
					if(isset($_POST['update_profile'])){
					
				
					$folder='images/';
					$file = $_FILES['image']['tmp_name'];  
					$file_name = $_FILES['image']['name']; 
					$file_name_array = explode(".", $file_name); 
					$extension = end($file_name_array);
					$new_image_name ='profile_'.rand() . '.' . $extension;
					if ($_FILES["image"]["size"] >10000000) {
					$error[] = 'Sorry, your image is too large. Upload less than 10 MB in size .';

					}
					if($file != "")
					{
					if($extension!= "jpg" && $extension!= "png" && $extension!= "jpeg"
					&& $extension!= "gif" && $extension!= "PNG" && $extension!= "JPG" && $extension!= "GIF" && $extension!= "JPEG") {
					
					$error[] = 'Sorry, only JPG, JPEG, PNG & GIF files are allowed';   
					}
					}

					 // Update name if set and not empty
            if(isset($_POST['name']) && !empty($_POST['name'])){
              $name = $_POST['name'];
              $result = mysqli_query($con,"UPDATE usertable SET name='$name' WHERE email='$email'");
              if($result){
                  // Success message or redirect
              } else {
                  $error[]='Something went wrong';
              }
          }
				if(!isset($error)){ 
						if($file!= "")
						{
						$stmt = mysqli_query($con,"SELECT image FROM  usertable WHERE email='$email'");
						$row = mysqli_fetch_array($stmt); 
						$deleteimage=$row['image'];
					unlink($folder.$deleteimage);
					move_uploaded_file($file, $folder . $new_image_name); 
					mysqli_query($con,"UPDATE usertable SET image='$new_image_name' WHERE email='$email'");
							}
							$result = mysqli_query($con,"UPDATE usertable SET name='$name' WHERE email='$email'");
							if($result)
							{
						
							}
							else 
							{
							$error[]='Something went wrong';
							}

   					}


						}    
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
				$res = mysqli_query($con,$sql);
					$res=mysqli_query($con,$sql);
						$row = mysqli_fetch_assoc($res);
					if(password_verify($currentPassword,$row['password'])){
				if($passwordConfirm ==''){
							$error[] = 'Please confirm the password.';
						}
						if($password != $passwordConfirm){
							$error[] = 'Passwords do not match.';
						}
						if(strlen($password)<5){ // min 
							$error[] = 'The password is 6 characters long.';
						}
						
						if(strlen($password)>20){ // Max 
							$error[] = 'Password: Max length 20 Characters Not allowed';
						}
				if(!isset($error))
				{
					$options = array("cost"=>4);
					$password = password_hash($password,PASSWORD_BCRYPT,$options);

					$result = mysqli_query($con,"UPDATE usertable SET password='$password' WHERE email='$email'");
						if($result)
						{
							echo "<p style='color:green;border:solid;'>" . "Your password has been successfully updated!" . "</p>";
						}
						else 
						{
							$error[]='Something went wrong';
						}
				}

						} 
						else 
						{
							$error[]='Current password does not match!'; 
						}   
					}
						if(isset($error)){ 

				foreach($error as $error){ 
				echo '<p class="errmsg">'.$error.'</p>'; 
				}
				}
				ob_end_flush();
						?> 
					<form method="post" enctype='multipart/form-data' action="">
						<div >
						<div></div>
						<div > 
						<center>
						<?php if($image==NULL)
							{
							echo '<img src="https://technosmarter.com/assets/icon/user.png">';
							} else { echo '<img src="images/'.$image.'" style="height:150px;width:150px;border-radius:50%;">';}?> 
							<div class="form-group">
							<label>Change Profile Picture &#8595;</label>
							<div class="col-sm-12 col-md-4 col-form-label" >
							<input class="form-control" type="file" name="image" style="width:100%;" >
							</div>
						</div>

						</center>
						
						</div>
						
						</div>
						</div>


						<div  class="form-group">
						<label class="col-sm-12 col-md-4 col-form-label">Name</label>
						<div class="col-sm-12 col-md-12">
						<input  type="text" name="name" value="<?php echo $name;?>" class="form-control" required>
						</div>
						</div>
                                                   


						
					


						<div class="form-group">
						<label class="col-sm-12 col-md-4 col-form-label">Email</label>
						<div class="col-sm-12 col-md-12">
						<input type="text" name="email" value="<?php echo $email;?>" class="form-control" required>
						</div>
						</div>

				

					
						
						<div class="col-sm-12 d-flex justify-content-center" style="">
						<button class="btn btn-success mb-4" name="update_profile">Save Profile</button>

						</div>
						
						<!--The Modal -->
						
						
						
						</form>
										
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
		<!-- js -->
		<script src="dist/css/login/core.js"></script>
		<script src="dist/css/login/layout-settings.js"></script>
<!-- Page specific script -->

</body>
</html>
