<?php require_once "controllerUserData.php"; ?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Admin | Log in</title>

  <!-- Google Font: Source Sans Pro -->

  <link href='https://fonts.googleapis.com/css?family=Inter' rel='stylesheet'>
  <!-- Font Awesome -->
  <link rel="stylesheet" href="plugins/fontawesome-free/css/all.min.css">
  <!-- icheck bootstrap -->
  <link rel="stylesheet" href="plugins/icheck-bootstrap/icheck-bootstrap.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="dist/css/adminlte - Copy.css">
  <link rel="stylesheet" href="login-style.css">
  <style>
   /* Modal styles */
	  .modal {
	    display: none;
	    position: fixed;
	    z-index: 1;
	    left: 0;
	    top: 0;
	    width: 100%;
	    height: 100%;
	    overflow: auto;
	    background-color: rgba(0,0,0,0.4);
	  }

	  .modal-content {
	    background-color: #fefefe;
	    margin: 15% auto;
	    padding: 20px;
	    border: 1px solid #888;
	    width: 30%;
	    text-align: center;
	  }

	  .close {
	    color: brown;
	    float: right;
	    font-size: 28px;
	    font-weight: bold;
	    margin-left:auto;
	  }

	  .close:hover,
	  .close:focus {
	    color: black;
	    text-decoration: none;
	    cursor: pointer;
	  }
      .login-card-body1{
      background-color: rgba(0, 0, 0, 0.7);
      border-radius: 10px;
}
    body {
    background: url(src/images/loginbg2.png) no-repeat center center fixed; 
    -webkit-background-size: cover;
    -moz-background-size: cover;
    -o-background-size: cover;
    background-size: cover;
    }
       .profile-photo img {
        width: 110px;
        height: 110px;
        margin: 10px;
        border-radius: 50%;
    }
  </style>
      <script>
      function showHidePwd() {
  var input = document.getElementById("password");
  if (input.type === "password") {
      input.type = "text";
      document.getElementById("eye").className = "fa fa-eye";
  } else {
      input.type = "password";
      document.getElementById("eye").className = "fa fa-eye-slash";
  }
}
  </script>
</head>
<body class="hold-transition login-page">
<div class="login-box">
    <?php
		// Check if account has been logged out
		if (isset($_GET['logout']) && $_GET['logout'] == 'true') {
			echo '<div id="myModal" class="modal" style="display:block">';
		} else {
			echo '<div id="myModal" class="modal">';
		}
	?>
	 <div class="modal-content">
	    <span class="close">&times;</span>
	    <p>Your Account has been Automatically Logged Out Due to Prolonged Inactivity.</p>
	  </div>
	</div>
  <!-- /.login-logo -->
  <div class="card">
    <div class="card-body login-card-body1">
        <div class="profile-photo d-flex justify-content-center">
            <img src="src/images/bsu.jpg" alt="bsu.jpg">
            <img src="src/images/cboo.jpg" alt="cboo.jpg"/>
        </div>
      <form action="login.php" method="post">
        <?php
            if(count($errors) > 0){
                ?>
                <div class="alert alert-danger text-center">
                    <?php
                    foreach($errors as $showerror){
                        echo $showerror;
                    }
                    ?>
                </div>
                <?php
            }
            ?>
        <div class="form-group mt-1">
            <div class="input-group mb-3">
            <input type="email" name = "email" class="form-control" placeholder="Email" required value="<?php echo $email ?>">
            <div class="input-group-append">
                <div class="input-group-text">
                <span class="fas fa-envelope"></span>
                </div>
            </div>
            </div>
            <div class="input-group mb-3">
            <input type="password" name="password" id="password" class="form-control" placeholder="Password" required>
            <div class="input-group-append">
                <div class="input-group-text">
                    <i id="eye" class="fa fa-eye-slash" onclick="showHidePwd();"></i>
                </div>
            </div>
            </div>
                <button type="submit" name = "login" class="btn btn-block btn-primary">LOGIN</button>
        </div>
      </form>

   <!-- <div class="social-auth-links text-center">
      <hr style="border-color: white;">
      <a href="signup-user.php" class="btn btn-block btn-danger"> SIGN UP </a>
    </div> -->
      <!-- /.social-auth-links -->
      <p class="d-flex justify-content-center">
        <a href="forgot-password.php">I forgot my password</a>
      </p>
    </div>
    <!-- /.login-card-body -->
  </div>
</div>
<!-- /.login-box -->

<!-- jQuery -->
<script src="plugins/jquery/jquery.min.js"></script>
<!-- Bootstrap 4 -->
<script src="plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<!-- AdminLTE App -->
<script src="dist/js/adminlte.min.js"></script>
<script>
		// Close the modal when the user clicks the close button
		document.getElementsByClassName("close")[0].addEventListener("click", function(){
		    document.getElementById("myModal").style.display = "none";
		});
	</script>
</body>
</html>
