<?php require_once "controllerUserData.php"; 
// Define a list of approved IP addresses
$allowed_ips = array('192.168.1.1', '10.0.0.1', '192.168.0.106', '112.206.152.98');


// Get the IP address of the user
$user_ip = $_SERVER['REMOTE_ADDR'];


// Check if the user's IP address is in the list of approved IPs
if (!in_array($user_ip, $allowed_ips)) {
    // If the user's IP address is not in the list, deny access
    http_response_code(403);
    die("Access denied. Please Contact CBOO Admin.");
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Admin | Sign Up</title>

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
    .login-card-body{
        background-color: rgba(255, 255, 255, 0.8);
        border-radius:10px;
}
    body {
    background: url(src/images/background.jpg) no-repeat center center fixed; 
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
function showHideCpwd() {
    var input = document.getElementById("cpassword");
    if (input.type === "password") {
        input.type = "text";
        document.getElementById("eye2").className = "fa fa-eye";
    } else {
        input.type = "password";
        document.getElementById("eye2").className = "fa fa-eye-slash";
    }
}    
  </script>
</head>
<body class="hold-transition login-page">
<div class="login-box">
  <!-- /.login-logo -->
  <div class="card">
    <div class="card-body login-card-body">
        <div class="profile-photo d-flex justify-content-center">
            <img src="src/images/bsu.jpg" alt="bsu.jpg">
            <img src="src/images/cboo.jpg" alt="cboo.jpg"/>
        </div>
      <form action="signup-user.php" method="post" aria-autocomplete="">
      <?php
                    if(count($errors) == 1){
                        ?>
                        <div class="alert alert-danger text-center">
                            <?php
                            foreach($errors as $showerror){
                                echo $showerror;
                            }
                            ?>
                        </div>
                        <?php
                    }elseif(count($errors) > 1){
                        ?>
                        <div class="alert alert-danger">
                            <?php
                            foreach($errors as $showerror){
                                ?>
                                <li><?php echo $showerror; ?></li>
                                <?php
                            }
                            ?>
                        </div>
                        <?php
                    }
                    ?>
        <div class="form-group mt-1">
            <div class="input-group mb-3">
                <input type="text" name = "name" class="form-control" placeholder="Full Name" required value="<?php echo $name ?>">
                <div class="input-group-append">
                    <div class="input-group-text">
                        <span class="fas fa-user"></span>
                    </div>
                </div>
            </div>
            <div class="input-group mb-3">
                <input type="email" name = "email" class="form-control" placeholder="Email Address" required value="<?php echo $email ?>">
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
            <div class="input-group mb-3" style="margin-bottom: 15px;">
                <input type="password" name="cpassword" id="cpassword" class="form-control" placeholder="Confirm Password" required>
                <div class="input-group-append">
                    <div class="input-group-text">
                        <i id="eye2" class="fa fa-eye-slash" onclick="showHideCpwd();"></i>
                </div>
                </div>
            </div>
            <div class="row d-flex justify-content-center">
                <button type="submit" name = "signup" class="btn btn-block btn-primary" value="Signup">SIGNUP</button>
            </div>
        </div>
      </form>

      <div class="link login-link text-center">Have an Account? <a href="login.php">Login here</a></div>
    </div>
    <!-- /.login-card-body -->
  </div>
</div>
<!-- /.login-box -->

<!-- jQuery -->
<script src="../../plugins/jquery/jquery.min.js"></script>
<!-- Bootstrap 4 -->
<script src="../../plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<!-- AdminLTE App -->
<script src="../../dist/js/adminlte.min.js"></script>
</body>
</html>
