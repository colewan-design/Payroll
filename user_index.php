
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
  <title>CBOO | Employee Dashboard</title>

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
  <link rel="stylesheet" href="dist/css/adminlte - Copy.css"> <!--Styles Here-->
  <!-- overlayScrollbars -->
  <link rel="stylesheet" href="plugins/overlayScrollbars/css/OverlayScrollbars.min.css">
  <!-- Daterange picker -->
  <link rel="stylesheet" href="plugins/daterangepicker/daterangepicker.css">
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
<style>
    td {
        border-top: 1px solid #dee2e6;
        border-right: 1px solid #dee2e6;
        padding: 5px;
    }
    
    .border-left {
        border-left: 3px solid #cfe2f3;
    }
</style>
<style>
.navbar-nav .nav-item .nav-link.active {
  color: blue;
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
            <a href="user_index.php" class="nav-link active">HOME</a>
          </li>
          <li class="nav-item">
            <a href="user_profile_page.php" class="nav-link">MY PROFILE</a>
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
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
            <p class="m-0 h3 text-center">My Current Payslip</p>
    </div>
    <!-- /.content-header -->
    
    <?php
        $mysqli = new mysqli('bsu-info.tech', 'u455679702_cps', 'OpK3RKh]!h9', 'u455679702_cps') or die(mysqli_error($mysqli));      
        $result = $mysqli->query("SELECT * FROM data") or die($mysqli->error);
        ?>
    <!-- Main content -->
    <section class="invoice mb-4 mt-4">
    <!-- info row -->
    <div class="row invoice-info">
  <div class="col-sm-4 invoice-col p-4">
    <address>
      <strong>From: CBOO-BSU</strong><br>
      <strong>Address:</strong> BSU Administration Office<br>
      <strong>Phone:</strong> +63 917 410 8108<br>
      <strong>Email:</strong> cboo@bsu.edu.ph 
    </address>
  </div>
  <!-- /.col -->
  <div class="col-sm-4 invoice-col p-4 border-left">
    <address>
      <strong>To: <?php echo $name;?></strong><br>
      <strong>Address here:</strong><br>
      <strong>Phone:</strong> (555) 539-1037<br>
      <strong>Email:</strong> <?php echo $employee_email;?>
    </address>
  </div>
  <!-- /.col -->
  <div class="col-sm-4 invoice-col p-4 border-left">
    <b>Payslip No: </b>
    <?php 
      $result_payroll = $mysqli->query("SELECT * FROM payroll_list WHERE emp_id=$employee_data_id") or die($mysqli->error());
      $pay_from = $result_payroll->fetch_array();
      $payroll_id = $pay_from['payroll_id'];

      echo $payroll_id;
    ?>
    <br>
    <b>Employee ID Number:</b> <?php echo $employee_data_id;?><br>
    <b>Payroll Date & Time:</b> <?php 
     $get_date = $mysqli->query("SELECT * FROM payroll_list WHERE payroll_id=$payroll_id") or die($mysqli->error());
      $date_row = $get_date->fetch_array();
      $payroll_from = $date_row['payroll_from'];
      $payroll_to = $date_row['payroll_to'];
      echo $payroll_from." to ".$payroll_to;
    ?><br>
  </div>
  <!-- /.col -->
</div>
  </section>
  
  <section class="row mr-0 mb-2">
    
    <?php
$position_result = mysqli_query($mysqli, "SELECT * FROM data where id = '$employee_data_id'");
if($position_res = mysqli_fetch_array($position_result))
{
  $user_salary = $position_res['salary']; 
$user_name = $position_res['name'];   
$user_sg = $position_res['sg'];  
$user_step = $position_res['step'];  
 
}

?>

<div class="col-sm-4">				
<h4 class="border-top border-right border-left  text text-center h4 p-2">ALLOWANCE</h4>
    <!-- Employee Incentive Table -->
    <div class="table-responsive">
      <table id="allowance" class="table border table-sm">
        
        
        <tr>
          <td>Salary</td>
          <td><?php echo "₱ ". number_format($user_salary, 2); ?></td>	  
        </tr>
        
        <tr>
        <td>PERA</td>
        <td><?php 
        $result_allowance = $mysqli->query("SELECT * FROM employeeallowance WHERE employeeId=$employee_data_id") or die($mysqli->$error());
        $row_allowance = $result_allowance->fetch_array();
        $pera = $row_allowance['employeeallowanceAmount'];
            echo "₱ ". number_format($pera,2);
        
        ?></td>				
         </tr>
        <tr>
            <td>
                Gross
            </td>
            <td>
            <?php 
        $result_gross = $mysqli->query("SELECT * FROM payroll_list WHERE emp_id=$employee_data_id") or die($mysqli->$error());
        $row_gross = $result_gross->fetch_array();
        $gross = $row_gross['gross_amount'];
            echo "₱ ". number_format($gross,2);
        
        ?>
            </td>
        </tr>
        <tr>
            <td>Total Deductions</td>
           <td>
                <?php 
                    $result = $mysqli->query("SELECT COALESCE(SUM(employeeDeductionAmount), 0) 
                                                 + COALESCE(SUM(employeeOtherDeductionAmount), 0) 
                                                 as total_deduction_amount 
                                                 FROM (SELECT employeeId, employeeDeductionAmount, 0 as employeeOtherDeductionAmount 
                                                       FROM employeedeductions 
                                                       WHERE employeeId=$employee_data_id 
                                                       UNION ALL 
                                                       SELECT employeeId, 0 as employeeDeductionAmount, employeeOtherDeductionAmount 
                                                       FROM employeeotherdeductions 
                                                       WHERE employeeId=$employee_data_id) 
                                                       as deductions") or die($mysqli->error);
                    while($row = mysqli_fetch_array($result)) {
                        $fetched_deduction = $row['total_deduction_amount'];
                    }
                    echo "₱ " . number_format($fetched_deduction, 2);
                ?>
            </td>

        </tr>
        <tr>
            <td>Net Amount</td>
            <td>
            <?php
                      $net_amount = $gross - $fetched_deduction;
                          echo "₱ ". number_format($net_amount,2);
                          ?>
            </td>
        </tr>
        <tr>
            <td>Half Month</td>
            <td><?php
                      $half_month = $net_amount /2;
                          echo "₱ ". number_format($half_month,2);
                          ?></td>
        </tr>
        
      </table>
    </div>   
    <!-- Table Allowance End -->
  </div>
  <?php
    $result = $mysqli->query("SELECT ed.edName, COALESCE(eod.employeeOtherDeductionAmount, ed.employeeDeductionAmount) AS deductionAmount
    FROM employeedeductions ed
    LEFT JOIN employeeotherdeductions eod ON ed.employeeId = eod.employeeId AND ed.edName = eod.employeeOtherDeductionName
    WHERE ed.employeeId = '$employee_data_id'") or die($mysqli->error);
    ?> 
<div class=" border-top border-right border-left border-bottom col-sm-8">
    <div class="d-flex justify-content-center">
        <h4 class="text text-center h4 p-2">DEDUCTIONS</h4>
    </div>
    <!-- Employee's Deductions Table -->
    <div class="table-responsive">
        <table class="table border-top border-right border-left border-bottom table-sm">
            <?php
            echo "<tr>";
            $pos = 0;
            $results_per_row = 3; #you can change it to a different value
            while($row = mysqli_fetch_array($result)){
                $pos++;
                $col1 = $row['edName'];
                $col2 = $row['deductionAmount'];
                if($col2 == 0 || $col2 == 0.00){
                    $col2 = '';
                } else {
                    $col2 = '₱ '.number_format($col2,2);
                }
                echo "<td> $col1 </td>";
                echo "<td> $col2 </td>";
                if($pos % $results_per_row == 0) 
                    echo "</tr><tr>";
            }
            // fill the last row with empty fields, if it has less than
            // $results_per_row values, to keep the proper table syntax
            while($pos % $results_per_row != 0){
                $pos++;
                echo "<td></td>";
                echo "<td></td>";
            }
            echo "</tr>";
            ?>
            <tr>
                <td rowspan="2" class="d-flex justify-content-center"><b>Remarks</b></td>
                <td class="border" rowspan="2" colspan="4"></td>
            </tr>
        </table>
    </div>         
</div>

</section>
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
  <footer class="main-footer d-flex justify-content-center">
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
<style>
 
</style>
</body>
</html>
