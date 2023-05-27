<?php require_once "controllerUserData.php"; ?>
<?php 
$email = $_SESSION['email'];
if($email == false){
  header('Location: login.php');
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Admin | New Password</title>
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
        background-color: rgba(255, 255, 255, 0.85);
        border-radius:10px;
}
    body {
    background: url(src/images/loginbg2.png) no-repeat center center fixed; 
    -webkit-background-size: cover;
    -moz-background-size: cover;
    -o-background-size: cover;
    background-size: cover;
    }
       .profile-photo img {
        width: 100px;
        height: 100px;
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
  <div class="login-logo">
    <h2 class="text-center text-white">NEW PASSWORD</h2>
  </div>
  <!-- /.login-logo -->
  <div class="card">
    <div class="card-body login-card-body">
        <div class="profile-photo d-flex justify-content-center">
            <img src="src/images/bsu.jpg" alt="bsu.jpg">
            <img src="src/images/cboo.jpg" alt="cboo.jpg"/>
        </div>
        <form action="new-password.php" method="post">
        <?php 
                    if(isset($_SESSION['info'])){
                        ?>
                        <div class="alert alert-success text-center">
                            <?php echo $_SESSION['info']; ?>
                        </div>
                        <?php
                    }
                    ?>
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
                <button type="submit" name = "change-password" class="btn btn-block btn-primary">Change</button>
            </div>
        </div>
      </form>
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
