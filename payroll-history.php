<?php require_once "controllerUserData.php"; ?>
<?php 
$email = $_SESSION['email'];

$password = $_SESSION['password'];
if($email != false && $password != false){
    $sql = "SELECT * FROM usertable WHERE email = '$email'";
    $run_Sql = mysqli_query($con, $sql);
    if($run_Sql){
        $fetch_info = mysqli_fetch_assoc($run_Sql);
        $status = $fetch_info['status'];
		$name = $fetch_info['name'];
		$image = $fetch_info['image'];
        $code = $fetch_info['code'];
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
  <title>CBOO | Payslip History</title>

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
    <ul class="navbar-nav ml-auto">
      <li class="nav-item">
        <a class="nav-link" href="#" role="button" data-toggle="modal" data-target = "#logout">
        <i class="fas fa-regular fa-right-from-bracket"></i>
        </a>
      </li>
    </ul>
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
            <h1 class="m-0">Payslip records</h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="index.php">Home</a></li>
              <li class="breadcrumb-item active">History</li>
            </ol>
          </div><!-- /.col -->
        </div><!-- /.row -->
      </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->

    <?php
        $mysqli = new mysqli('bsu-info.tech', 'u455679702_cps', 'OpK3RKh]!h9', 'u455679702_cps') or die(mysqli_error($mysqli));     
        $result = $mysqli->query("SELECT * FROM payroll_history") or die($mysqli->error);
        ?>
    <!-- Main content -->
    <section class="content">
      <div class="container-fluid">
        <!-- Small boxes (Stat box) -->
        
        <div>
        <table
    
    data-toggle="table"
    data-search="true"
    data-search-highlight="true"
    data-show-search-button="true"
    data-pagination="true" 
     class="table table-bordered table-striped">
                  <thead class="bg-secondary">
                  <tr>
                    <th class="text-center">MONTH</th>
                    <th class="text-center">PAYSLIPS</th>
                    <th class="text-center">GROSS SALARY</th>
                    <th class="text-center">NET PAY</th>
                  </tr>
                  </thead>
                  <tbody>
                            <?php
                          
                             $employee_result = $mysqli->query("SELECT * FROM payroll_history") or die($mysqli->error);
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
                                 $emp_id = $row['emp_id'];
                                $mix = $payroll_from."_". $payroll_to."_".$emp_id ; ?>
                                <a href="history_mpdf.php?edit=<?php echo $emp_id; ?>"><?php echo $mix; ?></a>
                                </td>
                                <td>
                                <?php echo number_format($row['gross_amount'],2); ?>
                                </td>
                                <td>
                                <?php echo number_format($row['net_amount'],2); ?>
                                </td>
                            </tr>
                            <?php endwhile;  ?>
                        </tbody>
                  <tfoot>
                  </tfoot>
                </table>
        </div>
        <!-- /.row -->
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
                            <button type="button" class="btn btn-secondary border-radius-100 btn-block confirmation-btn" onclick="location.href='logout-user.php'"> <!--  onclick="location.href='logout.php?logout=true&admin_id=< echo $admin_id; ?>'" -->
															<i class="fa fa-check"></i>
														</button>
													</div>
												</div>
											</div>
										</div>
									</div>
								</div>
      </div><!-- /.container-fluid -->
    </section>
    <!-- /.content -->
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
