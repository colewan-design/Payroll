<?php 
require_once "controllerUserData.php"; 
$mysqli = new mysqli('bsu-info.tech', 'u455679702_cps', 'OpK3RKh]!h9', 'u455679702_cps') or die(mysqli_error($mysqli));
 
   $id = isset($_GET['id']) ? $_GET['id'] : "";
   $emp_id = isset($_GET['id']) ? $_GET['id'] : "";
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

//insert payslip of individual employee 
if(isset($_POST['savePayroll'])){
  $emp_id = $_GET['id'];//get the id from the url

 $payroll_from = $_POST['payroll_from'];
  $date1 = new DateTime($payroll_from);
  $formatted_payroll_from = $date1->format('Y-m-d H:i:s');

  $payroll_to = $_POST['payroll_to'];
  $date2 = new DateTime($payroll_to);
  $formatted_payroll_to = $date2->format('Y-m-d H:i:s');

  // Get the current date and time
  $current_date_time = date('Y-m-d H:i:s');
  
  //get the days between to and from dates
  $interval = $date1->diff($date2);
  $get_days =  $interval->days;
  if ( $get_days  >= 1  &&  $get_days  <= 15 ) {
        $payroll_type = 0;
     }
  else if(16 <= $get_days && $get_days <= 30){
    $payroll_type = 1;
  }
  

$get_allowance = $mysqli->query("SELECT sum(employeeallowanceAmount) AS value_sum FROM employeeallowance where employeeId='$emp_id'") or die($mysqli->error);
    while($get_allowance_rows = $get_allowance->fetch_assoc()) {  
      $total_allowance = $get_allowance_rows['value_sum'];
    }
    $get_employee_info = $mysqli->query("SELECT * FROM data WHERE id='$emp_id'") or die($mysqli->error);
if($employee_info = mysqli_fetch_array($get_employee_info)) {
    $employee_name = $employee_info['name'];
    $employee_position = $employee_info['position'];
    $employee_sg = $employee_info['sg'];
    $employee_step = $employee_info['step'];
        $employee_leave = $employee_info['leave_deduction'];
}

    $get_salary = $mysqli->query("SELECT salary FROM data where id='$emp_id'") or die($mysqli->error);  
				  
        if($salary_fetchs = mysqli_fetch_array($get_salary))
            {
        
            $emp_salary = $salary_fetchs['salary'];   
           $payroll_emp_id = $salary_fetchs['id']; //employee ID
            $payroll_emp_salary = $salary_fetchs['salary']; //employee Salary
             
            }
            
            $gross_amount = $total_allowance + $payroll_emp_salary;
 
    //mandataroy deductions
    $deduction_results = $mysqli->query("SELECT employeeId, sum(employeeDeductionAmount) AS value_difference FROM employeedeductions where employeeId='$emp_id'") or die($mysqli->error);
    while($deduction_rows = $deduction_results->fetch_assoc()) {
        
    $fetched_difference = $deduction_rows['value_difference']; 
    $total_deductions = number_format($fetched_difference,2);
    }
         //other deductions
    $other_deduction_results = $mysqli->query("SELECT employeeId, sum(employeeOtherDeductionAmount) AS other_value_difference FROM employeeotherdeductions where employeeId='$emp_id'") or die($mysqli->error);
    while($other_deduction_rows = $other_deduction_results->fetch_assoc()) {
        
    $fetched_other_difference = $other_deduction_rows['other_value_difference']; 
    $other_total_deductions = number_format($fetched_other_difference,2);
    
    }
      //get total amount of deduction from employee deductions table
    $final_deduction = $fetched_difference + $fetched_other_difference;
    $net_amount = $gross_amount - $final_deduction;
    
  
  $mysqli->query("INSERT INTO payroll_list (payroll_from, payroll_to, emp_id, payroll_type, gross_amount, total_deduction, net_amount, createdAt) VALUES ('$formatted_payroll_from', '$formatted_payroll_to', '$emp_id', '$payroll_type' , '$gross_amount', '$final_deduction', '$net_amount', '$current_date_time')ON DUPLICATE KEY UPDATE payroll_from='$formatted_payroll_from', payroll_to='$formatted_payroll_to', payroll_type='$payroll_type', gross_amount='$gross_amount';") or
   die($mysqli->error);
   
   //insert to history report for payrolls table
   
   $mysqli->query("INSERT INTO payroll_history (payroll_from, payroll_to, emp_id, payroll_type, gross_amount, net_amount, total_deduction, salary, pera, leave_amount, sg, step, name, position) VALUES ('$formatted_payroll_from', '$formatted_payroll_to', '$emp_id', '$payroll_type' , '$gross_amount', '$net_amount', '$final_deduction', '$payroll_emp_salary', '$total_allowance', '$employee_leave', '$employee_sg', '$employee_step', '$employee_name', '$employee_position')") or
   die($mysqli->error);

  header("location:payslip_data.php");
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>CBOO | New Payslip</title>

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
  <!-- Selectpicker -->
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-select@1.13.14/dist/css/bootstrap-select.min.css">
  <script src="https://cdn.jsdelivr.net/npm/bootstrap-select@1.13.14/dist/js/bootstrap-select.min.js"></script>
  <style>
.card {
  margin: 2rem auto;
  padding: 2rem;
  max-width: 800px;
  background-color: #fff;
  box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
}

.row {
  display: flex;
  flex-wrap: wrap;
  margin-right: -15px;
  margin-left: -15px;
}

.col {
  flex-basis: 0;
  flex-grow: 1;
  max-width: 100%;
  padding-right: 15px;
  padding-left: 15px;
}

.font-weight-bold {
  font-weight: bold;
}

select {
  width: 100%;
  padding: 0.5rem 1rem;
  font-size: 1rem;
  line-height: 1.5;
  color: #495057;
  background-color: #fff;
  background-image: none;
  border: 1px solid #ced4da;
  border-radius: 0.25rem;
  appearance: none;
}

input[type="date"] {
  width: 100%;
  padding: 0.5rem 1rem;
  font-size: 1rem;
  line-height: 1.5;
  color: #495057;
  background-color: #fff;
  background-image: none;
  border: 1px solid #ced4da;
  border-radius: 0.25rem;
}

.btn {
  display: inline-block;
  font-weight: 400;
  text-align: center;
  white-space: nowrap;
  vertical-align: middle;
  -webkit-user-select: none;
  -moz-user-select: none;
  -ms-user-select: none;
  user-select: none;
  border: 1px solid transparent;
  padding: 0.5rem 1rem;
  font-size: 1rem;
  line-height: 1.5;
  border-radius: 0.25rem;
  transition: all 0.15s ease-in-out;
}

.btn-primary {
  color: #fff;
  background-color: #007bff;
  border-color: #007bff;
}

.btn-primary:hover {
  color: #fff;
  background-color: #0069d9;
  border-color: #0062cc;
}

.col-form {
  display: flex;
  align-items: center;
  justify-content: center;
}

@media (max-width: 576px) {
  .card {
    margin: 1rem auto;
    padding: 1rem;
  }

  .row {
    margin-right: -5px;
    margin-left: -5px;
  }

  .col {
    padding-right: 5px;
    padding-left: 5px;
  }
}
  </style>
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
      <img src="src/images/cboo.jpg" alt="CBOO Logo" class="brand-image img-circle elevation-3" style="opacity: .8">
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
            <h1 class="m-0">New Payslip</h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="index.php">Home</a></li>
              <li class="breadcrumb-item">Payslip</li>
              <li class="breadcrumb-item active">Add Payslip</li>
            </ol>
          </div><!-- /.col -->
        </div><!-- /.row -->
      </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->

    <!-- Main content -->
    <section class="content">
      <div class="card">
      
		<div class="row m-3">	
			  <!--form to get the employee ID and return data -->
        <form method="GET">
  <div class="col" style="padding-top:1rem;">
    <label for="" class="font-weight-bold">Select Employee:</label>
    <select  name="id" class="selectpicker"data-live-search="true" data-size="10" title="Choose Employee" required>
      <?php									
        $data_result = $mysqli->query("SELECT * FROM data") or die($mysqli->error);
        while ($trow = mysqli_fetch_array($data_result)) {
          $trows[] = $trow;
        }
        foreach ($trows as $trow) {
          print "<option value='" . $trow['id'] . "'>" . $trow['name'] . "</option>";
        }
      ?>
    </select>
  </div>
</form>
	
	
		
		     	<!--form to be submitted to payslips.php -->
				<!-- form -->
		<form method="POST">
		    <input type="hidden" name="id" value="<?php $id; ?>">	
            <div class="col">
                <label class="font-weight-bold">Select Payroll Range</label>
                <div class="form-row">
                    <div class="col">
                        <label for="payroll_from">From:</label>
                        <div class="input-group date" id="payroll_from_picker" data-target-input="nearest">
                            <input type="text" class="form-control datetimepicker-input" data-target="#payroll_from_picker" name="payroll_from" required/>
                            <div class="input-group-append" data-target="#payroll_from_picker" data-toggle="datetimepicker">
                                <div class="input-group-text"><i class="far fa-calendar-alt"></i></div>
                            </div>
                        </div>
                    </div>
                    <div class="col">
                        <label for="payroll_to">To:</label>
                        <div class="input-group date" id="payroll_to_picker" data-target-input="nearest">
                            <input type="text" class="form-control datetimepicker-input" data-target="#payroll_to_picker" name="payroll_to" required/>
                            <div class="input-group-append" data-target="#payroll_to_picker" data-toggle="datetimepicker">
                                <div class="input-group-text"><i class="far fa-calendar-alt"></i></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

              	</div>
             <div class="row m-3">
		  <div class="p-3 col-sm-12"><b>Employee Name:</b> <?php
		           $data_result = $mysqli->query("SELECT * FROM data WHERE id = '$id' ") or die($mysqli->error);
		             if($get_name = mysqli_fetch_array($data_result))
                        {
                        
                        $emp_name = $get_name['name'];   
                        
                        
                        }

		            echo $emp_name;
		            ?></div>
          <div class="p-3 col-sm-12"><b>Gross Pay:</b>
		      <?php
 $allowance_results = $mysqli->query("SELECT sum(employeeallowanceAmount) AS value_sum FROM employeeallowance where employeeId='$emp_id'") or die($mysqli->error);
    while($allowance_rows = $allowance_results->fetch_assoc()) {  
      $total_incentives = $allowance_rows['value_sum'];
    }
    $current_employee_salary = $mysqli->query("SELECT salary FROM data where id='$emp_id'") or die($mysqli->error);  
				  
        if($salary_res = mysqli_fetch_array($current_employee_salary))
            {
        
            $salary = $salary_res['salary'];   
          
             
            }
            $gross_amount = $total_incentives + $salary;
           echo '₱' . number_format($gross_amount, 2);
            
		      ?>
		 
		  </div>   
        
           
							
       
         <div class="col col-sm-12 col-md-1 col-form">
        <button type="submit" name="savePayroll" class="btn btn-primary">SAVE</button>
	    </div> 
          <!-- /card -->
         
		</div> 	
      </form>
     
      <!-- /form -->
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
  <!-- Selectpicker -->
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-select@1.13.14/dist/css/bootstrap-select.min.css">
  <script src="https://cdn.jsdelivr.net/npm/bootstrap-select@1.13.14/dist/js/bootstrap-select.min.js"></script>
<script>
			$('select').change(function (){
				$(this).closest('form').submit();
			});
	  </script>

<script>
const search = document.getElementById("search");
const selectBox = document.getElementById("selectBox");

search.addEventListener("keyup", function() {
  const searchValue = this.value.toLowerCase();
  for (let i = 0; i < selectBox.options.length; i++) {
    if (selectBox.options[i].text.toLowerCase().indexOf(searchValue) !== -1) {
      selectBox.options[i].style.display = "block";
    } else {
      selectBox.options[i].style.display = "none";
    }
  }
});
  $(function() {
        $('#payroll_from_picker, #payroll_to_picker').datetimepicker({
            format: 'YYYY-MM-DD',
            useCurrent: true
        });
    });
</script>
<style>
  #selectBox {
  background-color: #f2f2f2;
  color: grey;
}
#selectBox {
  font-size: 18px;
  font-weight: light;
}
#selectBox {
  border: 1px solid #ccc;
  padding: .19rem;
}
#selectBox:hover {
  background-color: #ccc;
  cursor: pointer;
}
#selectBox option {
  color: black;
  font-size: 18px;
}
</style>
</body>
</html>
