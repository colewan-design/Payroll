
<?php 
session_start();
require "connection.php";
//declare database
$mysqli = new mysqli('bsu-info.tech', 'u455679702_cps', 'OpK3RKh]!h9', 'u455679702_cps') or die(mysqli_error($mysqli));     
$result = $mysqli->query("SELECT * FROM data") or die($mysqli->error);
$employee_email = $_SESSION['employee_email'];

$password = $_SESSION['password'];
if($employee_email != false && $password != false){
    $sql = "SELECT * FROM userlogin WHERE employee_email = '$employee_email'";
    $run_Sql = mysqli_query($con, $sql);
    if($run_Sql){
    $fetch_info = mysqli_fetch_assoc($run_Sql);
    $status = $fetch_info['status'];
		$employee_name = $fetch_info['name'];
		$image = $fetch_info['photo'];
    $employee_data_id = $fetch_info['employee_data_id'];
      
    }
}
 else{
         header('Location: user_login.php');
    }

 //if user click login button
 if(isset($_POST['user_login'])){
  $$employee_email = mysqli_real_escape_string($con, $_POST['employee_email']);
  $password = mysqli_real_escape_string($con, $_POST['password']);
  $check_email = "SELECT * FROM userlogin WHERE employee_email = '$employee_email'";
  $res = mysqli_query($con, $check_email);
  if(mysqli_num_rows($res) > 0){
      $fetch = mysqli_fetch_assoc($res);
      $fetch_pass = $fetch['password'];
      if(password_verify($password, $fetch_pass)){
          $_SESSION['employee_email'] = $email;
          $status = $fetch['status'];
          if($status == 'active'){
            $_SESSION['employee_email'] = $email;
            $_SESSION['password'] = $password;
              header('location: user_index.php');
          }else{
              $_SESSION['employee_email'] = $employee_email;
              $_SESSION['password'] = $password;
                header('location: user_index.php');
          }
      }else{
          $errors['employee_email'] = "Incorrect email or password!";
      }
  }else{
      $errors['employee_email'] = "It's look like you're not yet a member! Click on the bottom link to signup.";
  }
}

if(ISSET($_POST['update_employee_account'])){
  $image_name = $_FILES['photo']['name'];
  $image_temp = $_FILES['photo']['tmp_name'];
  
  $user_email = $_POST['employee_email'];
  $employee_data_id =  $_POST['employee_data_id'];
  $employee_name =  $_POST['employee_name'];
  $date = date('Y-m-d');
  
  
  $exp = explode(".", $image_name);
  $end = end($exp);
  $name = time().".".$end;
  $path = "user_profile/".$name;
  $allowed_ext = array("gif", "jpg", "jpeg", "png");
  if(in_array($end, $allowed_ext)){
    if(move_uploaded_file($image_temp, $path)){
      mysqli_query($mysqli, "UPDATE `userlogin` set `name` = '$employee_name', `employee_email` = '$user_email', `photo` = '$path' WHERE `employee_data_id` = '$employee_data_id'") or die(mysqli_error());
					
      
      
      $error[] = 'User account saved.';
     
    }	
  }else{
    echo "<script>alert('Image only')</script>";
  }
  header("location:user_profile_page.php");
}
//change password
if(ISSET($_POST['change_password'])){

  $sql = "SELECT * FROM userlogin WHERE employee_data_id= '$employee_data_id'";

  if (! empty($row)) {
      $hashedPassword = $row["password"];
      $password = PASSWORD_HASH($_POST["newPassword"], PASSWORD_DEFAULT);
      if (password_verify($_POST["currentPassword"], $hashedPassword)) {
          $sql = "UPDATE userlogin set password=? WHERE employee_data_id=?";
          $statement = $conn->prepare($sql);
          $statement->bind_param('si', $password, $_SESSION["employee_data_id"]);
          $statement->execute();
          $message = "Password Changed";
      } else
          $message = "Current Password is not correct";
  }
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>CBOO | Profile</title>

  <!-- Google Font: Source Sans Pro -->
  <!--  https://fonts.googleapis.com/css?family=Poppins-->
  <link href='https://fonts.googleapis.com/css?family=Inter' rel='stylesheet'>
  <!-- Font Awesome -->
  <link rel="stylesheet" href="plugins/fontawesome-free/css/all.min.css">
  <script src="https://kit.fontawesome.com/dd09e290e6.js" crossorigin="anonymous"></script>
  <!-- Theme style -->
  <link rel="stylesheet" href="dist/css/adminlte.css"> <!--Styles Here-->
  <!-- overlayScrollbars -->
  <link rel="stylesheet" href="plugins/overlayScrollbars/css/OverlayScrollbars.min.css">
  <style>
      /* Form wrapper */
.form-wrapper {
  max-width: 500px;
  margin: 0 auto;
}

/* Form fields */
.form-field {
  margin-bottom: 1rem;
}

.form-field label {
  display: block;
  margin-bottom: 0.5rem;
  font-size: 1rem;
  font-weight: bold;
}

.form-field input {
  display: block;
  width: 100%;
  padding: 0.5rem;
  border: 1px solid #ccc;
  border-radius: 4px;
  font-size: 1rem;
}

/* Error message */
.error-message {
  margin-top: 0.5rem;
  color: red;
  font-size: 0.875rem;
}

/* Submit button */
.submit-button {
  display: block;
  width: 100%;
  padding: 0.5rem;
  background-color: #007bff;
  color: #fff;
  border: none;
  border-radius: 4px;
  font-size: 1rem;
  font-weight: bold;
  cursor: pointer;
}

.submit-button:hover {
  background-color: #0069d9;
}
  </style>

<style>
.navbar-nav .nav-item .nav-link.active {
  color: blue;
}
</style>

<style>
    @keyframes sparkling {
  from {
    opacity: 1;
  }
  to {
    opacity: 0.5;
  }
}

.sparkling-btn {
  animation: sparkling 1s linear infinite;
}
  </style>
  <script>
      function showCrrntPwd() {
  var input = document.getElementById("password");
  if (input.type === "password") {
      input.type = "text";
      document.getElementById("eye").className = "fa fa-eye";
  } else {
      input.type = "password";
      document.getElementById("eye").className = "fa fa-eye-slash";
  }
}

      function showNwPwd() {
  var input = document.getElementById("newPassword");
  if (input.type === "password") {
      input.type = "text";
      document.getElementById("eye2").className = "fa fa-eye";
  } else {
      input.type = "password";
      document.getElementById("eye2").className = "fa fa-eye-slash";
  }
}

function showCnfrmPwd() {
  var input = document.getElementById("confirmPassword");
  if (input.type === "password") {
      input.type = "text";
      document.getElementById("eye3").className = "fa fa-eye";
  } else {
      input.type = "password";
      document.getElementById("eye3").className = "fa fa-eye-slash";
  }
}
  </script>
</head>
<body style="padding:1rem;"class="hold-transition layout-top-nav">
<div class="wrapper">

  

  <!-- Navbar -->
  <nav class="main-header navbar navbar-expand navbar-white navbar-light">
    <!-- Left navbar links -->
    
       <ul class="navbar-nav mr-auto ml-auto">
          <li class="nav-item">
            <a href="user_index.php" class="nav-link">HOME</a>
          </li>
          <li class="nav-item">
            <a href="user_profile_page.php" class="nav-link active">MY PROFILE</a>
          </li>
          <li class="nav-item">
            <a href="employee_payrolls.php" class="nav-link">MY PAYSLIPS</a>
          </li>
          <li class="nav-item">
          <a class="nav-link sparkling-btn" href="#" role="button" data-toggle="modal" data-target = "#logout">
        <i class="fas fa-sign-out-alt"></i>
        </a>
      </li>
  </ul>
  </nav>
  <!-- /.navbar -->

  <!-- Logout Modal -->
  
<!-- End of Modal -->
  <!-- Content Wrapper. Contains page content -->
  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper mt-2">
    <!-- Main content -->
    <div class="container light-style flex-grow-1 container-p-y">
    <h4>
      Account Setting
    </h4>

    <div class="content overflow-hidden">
      <div class="row no-gutters row-bordered row-border-light">
        <div class="col-md-3 pt-0">
          <div class="list-group list-group-flush account-settings-links">
            <a class="list-group-item list-group-item-action active" data-toggle="list" href="#account-general">General</a>
           <a class="list-group-item list-group-item-action" data-toggle="list" href="#account-change-password" id="change-password-link">Change password</a>
            <a class="list-group-item list-group-item-action" data-toggle="list" href="#account-info">Info</a>
             </div>
        </div>
        <div class="col-md-9">
          <div class="tab-content">
            <div class="tab-pane fade active show" id="account-general">

              <div class="card-body media align-items-center">
                <img src="<?php echo $image?>" alt="" height="80" width="100" class="d-block ui-w-80"><br>
                
              </div>
              <hr class="border-light m-0">

              <div class="card-body">
                
                <div class="form-group">
                  <label class="form-label">Name: <?php echo $employee_name ;?></label>
                  
                </div>
                <div class="form-group">
                  <label class="form-label">E-Mail: <?php echo $employee_email ;?></label>
                  
                </div>
                
                <div class="form-group">
                  
                  <button type="button" class="btn btn-warning" data-toggle="modal" data-target="#edit"><span class="glyphicon glyphicon-edit"></span> Edit</button>
    
                  
                </div>
              </div>

            </div>
            <div class="tab-pane fade" id="account-change-password">
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
                                    $sql="SELECT password from userlogin where employee_email='$employee_email'";
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

                                        $result = mysqli_query($con,"UPDATE userlogin SET password='$password' WHERE employee_email='$employee_email'");
                                            if($result)
                                            {
                                                $error[] = 'Your password has been successfully updated.';
                                            }
                                            else 
                                            {
                                                $error[]='Something went wrong';
                                            }
                                    }

                                            } 
                                            else 
                                            {
                                                $error[] = 'Current Password does not match.'; 
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
					<i class="fa fa-eye-slash" id="eye" onclick="showCrrntPwd();"></i>
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
					<i class="fa fa-eye-slash" id="eye2" onclick="showNwPwd();"></i>
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
					<i class="fa fa-eye-slash" id="eye3" onclick="showCnfrmPwd();"></i>
				</span>
			</div>
		</div>
           <div class="row">
            <div class="col-sm-6">
            </div>
            <div class="col-sm-6" style="right:5rem;">
         <button  class="btn btn-warning" name="change_password" id="change-password-btn">Change Password</button>
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
            </div>
            <div class="tab-pane fade" id="account-info">
              <div class="card-body pb-2">

                <div class="form-group">
                  <label class="form-label">Bio</label>
                  <textarea class="form-control" rows="5">Lorem ipsum dolor sit amet, consectetur adipiscing elit. Mauris nunc arcu, dignissim sit amet sollicitudin iaculis, vehicula id urna. Sed luctus urna nunc. Donec fermentum, magna sit amet rutrum pretium, turpis dolor molestie diam, ut lacinia diam risus eleifend sapien. Curabitur ac nibh nulla. Maecenas nec augue placerat, viverra tellus non, pulvinar risus.</textarea>
                </div>
                <div class="form-group">
                  <label class="form-label">Birthday</label>
                  <input type="text" class="form-control" value="May 3, 1995">
                </div>
               


              </div>
              <hr class="border-light m-0">
              <div class="card-body pb-2">

                <h6 class="mb-4">Contacts</h6>
                <div class="form-group">
                  <label class="form-label">Phone</label>
                  <input type="text" class="form-control" value="+0 (123) 456 7891">
                </div>
                <div class="form-group">
                  <label class="form-label">Website</label>
                  <input type="text" class="form-control" value="">
                </div>

              </div>
      
            </div>
            
            
            
          </div>
        </div>
      </div>
    </div>

    <!-- Modal-->
    <div class="modal fade" id="edit" aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content">
			<form method="POST" enctype="multipart/form-data">
				<div class="modal-header">
					<h3 class="modal-title w-100 text-center">Edit User</h3>
				</div>
        <div class="modal-body d-flex justify-content-center">
    <div class="col-md-8">
        <div class="form-group">
            <h4 class="text-center">Current Photo</h4>
            <div class="text-center"> <!-- added text-center class here -->
                <img src="<?php echo $image?>" height="120" width="150"/>
            </div>
            <input type="hidden" name="previous" value="<?php echo $image?>"/>
            <input type="file" class="form-control mt-1" name="photo" value="<?php echo $image?>"/>
        </div>
        <div class="form-group">
            <label>Name</label>
            <input type="hidden" value="<?php echo $employee_data_id?>" name="employee_data_id"/>
            <input type="text" class="form-control" value="<?php echo $employee_name?>" name="employee_name"/>
        </div>
        <div class="form-group">
            <label>E-mail</label>
            <input type="text" class="form-control" value="<?php echo $employee_email?>" name="employee_email"/>
        </div>
    </div>
</div>

				<br style="clear:both;"/>
				<div class="modal-footer d-flex justify-content-center">
					<button class="btn btn-danger" data-dismiss="modal"><span class="glyphicon glyphicon-remove"></span> Close</button>
					<button class="btn btn-warning" name="update_employee_account"><span class="glyphicon glyphicon-save"></span> Update</button>
				</div>
			</form>
		</div>
	</div>
</div>			

  </div>
    <!-- /.content -->
  </div>
   <!-- Logout Modal -->
   <div class="modal fade" id="logout" tabindex="-1" role="dialog" aria-labelledby="myModalLabel"  aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-body text-center font-18">
                        <h4 style="padding-top: 30px; margin-bottom:30px; font-weight:bold;">
                            LOGOUT?
                        </h4>
                        <div class="padding-bottom-30 row" style="max-width: 170px; margin: 0 auto">
                            <div class="col-6">
                                <button type="button" class="btn btn-secondary border-radius-100 btn-block confirmation-btn" data-dismiss="modal">
                                    <i class="fa fa-times"></i>
                                </button>
                            </div>
                            <div class="col-6">
    <button type="button" class="btn btn-secondary border-radius-100 btn-block confirmation-btn" onclick="location.href='employee_logout.php'"> <!--  onclick="location.href='logout.php?logout=true&admin_id=< echo $admin_id; ?>'" -->
                                    <i class="fa fa-check"></i>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
  <!-- /.content-wrapper -->
  <footer class="main-footer">
    <strong>CBOO-CPMS@BSU</strong>
    <div class="float-right d-none d-sm-inline-block">
    </div>
  </footer>

  <!-- Control Sidebar -->
  <aside class="control-sidebar control-sidebar-dark">
    <!-- Control sidebar content goes here -->
  </aside>
  <!-- /.control-sidebar -->
</div>
<!-- ./wrapper -->
<script>
  function validatePassword() {
	var currentPassword, newPassword, confirmPassword, output = true;

	currentPassword = document.frmChange.currentPassword;
	newPassword = document.frmChange.newPassword;
	confirmPassword = document.frmChange.confirmPassword;

	if (!currentPassword.value) {
		currentPassword.focus();
		document.getElementById("currentPassword").innerHTML = "required";
		output = false;
	}
	else if (!newPassword.value) {
		newPassword.focus();
		document.getElementById("newPassword").innerHTML = "required";
		output = false;
	}
	else if (!confirmPassword.value) {
		confirmPassword.focus();
		document.getElementById("confirmPassword").innerHTML = "required";
		output = false;
	}
	if (newPassword.value != confirmPassword.value) {
		newPassword.value = "";
		confirmPassword.value = "";
		newPassword.focus();
		document.getElementById("confirmPassword").innerHTML = "not same";
		output = false;
	}
	return output;
}
</script>
<script>
  const changePasswordLink = document.querySelector('#change-password-link');
  const changePasswordBtn = document.querySelector('#change-password-btn');
  
  // Prevent the click event from propagating to the parent element
  changePasswordBtn.addEventListener('click', function(event) {
    event.stopPropagation();
  });
  
  // Trigger the click event on the change password link when the button is clicked
  changePasswordBtn.addEventListener('click', function() {
    changePasswordLink.click();
  });
</script>
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
<!-- ChartJS -->
<script src="plugins/chart.js/Chart.min.js"></script>
<!-- Sparkline -->
<script src="plugins/sparklines/sparkline.js"></script>
<!-- JQVMap -->
<script src="plugins/jqvmap/jquery.vmap.min.js"></script>
<script src="plugins/jqvmap/maps/jquery.vmap.usa.js"></script>
<!-- jQuery Knob Chart -->
<script src="plugins/jquery-knob/jquery.knob.min.js"></script>
<!-- daterangepicker -->
<script src="plugins/moment/moment.min.js"></script>
<script src="plugins/daterangepicker/daterangepicker.js"></script>
<!-- Tempusdominus Bootstrap 4 -->
<script src="plugins/tempusdominus-bootstrap-4/js/tempusdominus-bootstrap-4.min.js"></script>
<!-- Summernote -->
<script src="plugins/summernote/summernote-bs4.min.js"></script>
<!-- overlayScrollbars -->
<script src="plugins/overlayScrollbars/js/jquery.overlayScrollbars.min.js"></script>
<!-- AdminLTE App -->
<script src="dist/js/adminlte.js"></script>
<!-- AdminLTE for demo purposes -->
<script src="dist/js/demo.js"></script>
<!-- AdminLTE dashboard demo (This is only for demo purposes) -->
<script src="dist/js/pages/dashboard.js"></script>
<script src="dist/js/jquery-3.2.1.min.js"></script>	
</body>
</html>
