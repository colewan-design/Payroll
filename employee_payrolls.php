
<?php 
session_start();
require "connection.php";
$employee_email = $_SESSION['employee_email'];

$password = $_SESSION['password'];
if($employee_email != false && $password != false){
    $sql = "SELECT * FROM userlogin WHERE employee_email = '$employee_email'";
    $run_Sql = mysqli_query($con, $sql);
    if($run_Sql){
    $fetch_info = mysqli_fetch_assoc($run_Sql);
    $status = $fetch_info['status'];
		$name = $fetch_info['name'];
		$image = $fetch_info['image'];
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
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>CBOO | Payslips</title>

  <!-- Google Font: Source Sans Pro -->
  <!--  https://fonts.googleapis.com/css?family=Poppins-->
  <link href='https://fonts.googleapis.com/css?family=Inter' rel='stylesheet'>
  <!-- Font Awesome -->
  <link rel="stylesheet" href="plugins/fontawesome-free/css/all.min.css">
  <script src="https://kit.fontawesome.com/dd09e290e6.js" crossorigin="anonymous"></script>
  <!-- Ionicons -->
  <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
  <!-- Tempusdominus Bootstrap 4 -->
  <link rel="stylesheet" href="plugins/tempusdominus-bootstrap-4/css/tempusdominus-bootstrap-4.min.css">
  <!-- iCheck -->
  <link rel="stylesheet" href="plugins/icheck-bootstrap/icheck-bootstrap.min.css">
  <!-- JQVMap -->
  <link rel="stylesheet" href="plugins/jqvmap/jqvmap.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="dist/css/adminlte.css"> <!--Styles Here-->
  <!-- overlayScrollbars -->
  <link rel="stylesheet" href="plugins/overlayScrollbars/css/OverlayScrollbars.min.css">
  <!-- Daterange picker -->
  <link rel="stylesheet" href="plugins/daterangepicker/daterangepicker.css">
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
            <a href="user_profile_page.php" class="nav-link">MY PROFILE</a>
          </li>
          <li class="nav-item">
            <a href="employee_payrolls.php" class="nav-link active">MY PAYSLIPS</a>
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
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-12">
            <h3 class="m-0 text-center">My Previous Payslips</h3>
          </div><!-- /.col -->
        </div><!-- /.row -->
      </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->

    <!-- Main content -->
    <table
    
    data-toggle="table"
            data-search="true"
            data-show-columns="true"
            data-show-search-clear-button="true"
  data-search-highlight="true"
  data-show-search-button="true"
  data-show-pagination-switch="true"
  data-show-columns-search="true"
 

  data-pagination="true" 
     class="table table-bordered table-striped">
                  <thead>
                  <tr>
                    <th class="text-center">MONTH</th>
                    <th class="text-center">PAYSLIPS</th>
                    <th class="text-center">GROSS SALARY</th>
                    <th class="text-center">NET PAY</th>
                  </tr>
                  </thead>
                  <tbody>
                            <?php
                                $mysqli = new mysqli('bsu-info.tech', 'u455679702_cps', 'OpK3RKh]!h9', 'u455679702_cps') or die(mysqli_error($mysqli));     
                                $employee_result = $mysqli->query("SELECT * FROM payroll_history WHERE emp_id ='$employee_data_id'") or die($mysqli->error);
                                while($row = $employee_result->fetch_assoc()):
                            ?>
                            <tr>
                                <td ><?php $payroll_from = $row['payroll_from']; 
                                $time=strtotime($payroll_from);
                                $month=date("F",$time);
                                $year=date("Y",$time);
                                echo $month;
                                ?></td>
                                <td>
                                <?php $payroll_to = $row['payroll_to'];
                                $mix = $payroll_from."_". $payroll_to; ?>
                                <a href="history_mpdf.php?edit=<?php echo $employee_data_id; ?>" class="mpdf-link"> <?php echo $mix; ?></a>
                                </td>
                                <td>
                                <?php echo "₱". number_format($row['gross_amount'],2); ?>
                                </td>
                                <td>
                                <?php echo "₱". number_format($row['net_amount'],2); ?>
                                </td>
                            </tr>
                            <?php endwhile;  ?>
                        </tbody>
                  <tfoot>
                  <tr>
                    <th>Months</th>
                    <th>Payslips</th>
                    <th>Gross Salary</th>
                    <th>Net Pay</th>
                  </tr>
                  </tfoot>
                </table>
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
<link href="https://unpkg.com/bootstrap-table@1.21.0/dist/bootstrap-table.min.css" rel="stylesheet">

<script src="https://unpkg.com/bootstrap-table@1.21.0/dist/bootstrap-table.min.js"></script>
</body>
</html>
