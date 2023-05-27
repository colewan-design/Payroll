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
  <title>Code Verification</title>

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
</head>
<body class="hold-transition login-page">
<div class="login-box">
  <div class="login-logo">
    <h2 class="text-center text-white">CODE VERIFICATION</h2>
  </div>
  <!-- /.login-logo -->
  <div class="card">
    <div class="card-body login-card-body">
        <div class="profile-photo d-flex justify-content-center">
            <img src="src/images/bsu.jpg" alt="bsu.jpg">
            <img src="src/images/cboo.jpg" alt="cboo.jpg"/>
        </div>
      <form action="reset-code.php" method="post">
      <?php 
                    if(isset($_SESSION['info'])){
                        ?>
                        <div class="alert alert-success text-center" style="padding: 0.4rem 0.4rem">
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
                <input type="number" name = "otp" class="form-control" placeholder="Enter Verification Code" required>
            </div>
            <div class="row d-flex justify-content-center">
                <button type="submit" name = "check-reset-otp" value="Submit" class="btn btn-block btn-primary">Submit</button>
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
