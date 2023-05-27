<script>jQuery.noConflict();</script>
<?php 
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
require_once "controllerUserData.php";
if(!isset($_SESSION)) { 
	session_start(); 
  }  ?>
<?php 
$email = $_SESSION['email'];
$mysqli = new mysqli('bsu-info.tech', 'u455679702_cps', 'OpK3RKh]!h9', 'u455679702_cps') or die(mysqli_error($mysqli)); 
$result = $mysqli->query("SELECT * FROM data") or die($mysqli->error);
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
    header('Location: login.php');
}

if(isset($_POST['insertAllowance'])){

  $allowanceName = $_POST['allowanceName'];
  $allowanceDescription = $_POST['allowanceDescription'];
  $allowanceAmount = $_POST['allowanceAmount'];
  $mysqli->query("INSERT INTO allowance (allowanceName, allowanceDescription, allowanceAmount) VALUES ('$allowanceName', '$allowanceDescription', '$allowanceAmount')") or
  die($mysqli->error);

  header("location:incentives.php");
}



//Employees save - employees.php
if(isset($_POST['save'])){
    $name = $_POST['name'];
    $id = $_POST['id'];
    $position_id = $_POST['position_id'];//position_id fetched
     $position_result = mysqli_query($mysqli, "SELECT * FROM position where id = $position_id");
    if($position_res = mysqli_fetch_array($position_result))
    {

    $position_name = $position_res['position_name'];   
      $project_id = $position_res['project_id'];  
      $sg = $position_res['sg'];  
      $step = $position_res['step'];  
     
    }
     $salary_result = mysqli_query($mysqli, "SELECT * FROM salarydata where salaryGrade = '$sg' AND salaryStep = '$step'");
    if($salary_res = mysqli_fetch_array($salary_result))
    {

    $salary_amount = $salary_res['salaryAmount'];   
  
     
    }


    $type = $_POST['employee_type'];
    $project = $_POST['project_name'];
    $admin_id = $_POST['admin_id'];
    $activity_type = "Insert an employee";

    //archive data 
    $time_logged = date("Y-m-d H:i:s",strtotime("now"));
    $mysqli->query("INSERT INTO activity (time_logged, admin_id, activity_type) VALUES ('$time_logged', '$admin_id', '$activity_type')") or
    die($mysqli->error);


    //add new employee
    $mysqli->query("INSERT INTO data (name, position, sg, step, salary, project, type, id) VALUES ('$name', '$position_name', '$sg', '$step', '$salary_amount', '$project_id', '$type', '$id')") or
    die($mysqli->error);


    header("location:employees.php");

}

//create a payroll for all employees
if(isset($_POST['save_payroll'])){
 
  $payroll_from = $_POST['payroll_from'];
  $date1 = new DateTime($payroll_from);
  $payroll_to = $_POST['payroll_to'];
  $date2 = new DateTime($payroll_to);
  //get the days between to and from dates
  $interval = $date1->diff($date2);
  $get_days =  $interval->days;
  if($get_days > 15){
    $payroll_type = 1;
  }
  else if($get_days < 15){
    $payroll_type = 0;
  }
 
//get all data
  $payroll_result = mysqli_query($mysqli, "SELECT * FROM data");

 //create payroll for each employee, the data will be taken from the table 'data'
  while ($trow = mysqli_fetch_array($payroll_result)) {//$payroll_result = select * from data
    $trows[] = $trow;
  }
  foreach ($trows as $trow) {
    $payroll_emp_id = $trow['id']; //employee ID
    $payroll_emp_salary = $trow['salary']; //employee Salary
    $leave_deduction_amount = $trow['leave_deduction'];
    $employee_sg = $trow['sg'];
    $employee_step = $trow['step'];
    $employee_position = $trow['position'];
    $employee_name = $trow['name'];
    
 //getting the gross amount from the employeeallowance table and salary from data table
$gross_results = $mysqli->query("SELECT employeeId, sum(employeeallowanceAmount) AS value_sum FROM employeeallowance where employeeId=$payroll_emp_id") or die($mysqli->error);
while($gross_rows = $gross_results->fetch_assoc()) {
        
    $fetched_sum = $gross_rows['value_sum'];

}

$bad_symbols = array(",");
$current_employee_salary = str_replace($bad_symbols, "", $payroll_emp_salary);
    $gross_amount= $fetched_sum + $current_employee_salary;//gross amount (salary plus total allowance)

   
   
   //get net amount and total deduction
      //mandataroy deductions
    $deduction_results = $mysqli->query("SELECT employeeId, sum(employeeDeductionAmount) AS value_difference FROM employeedeductions where employeeId='$payroll_emp_id'") or die($mysqli->error);
    while($deduction_rows = $deduction_results->fetch_assoc()) {
        
    $fetched_difference = $deduction_rows['value_difference']; 
    $total_deductions = number_format($fetched_difference,2);

    }
     //other deductions
    $other_deduction_results = $mysqli->query("SELECT employeeId, sum(employeeOtherDeductionAmount) AS other_value_difference FROM employeeotherdeductions where employeeId='$payroll_emp_id'") or die($mysqli->error);
   while($other_deduction_rows = $other_deduction_results->fetch_assoc()) {
    $fetched_other_difference = $other_deduction_rows['other_value_difference']; 
    $other_total_deductions = ($fetched_other_difference !== null) ? number_format($fetched_other_difference, 2) : 'N/A';
}

      //get total amount of deduction from employee deductions table
    $final_deduction = $fetched_difference + $fetched_other_difference;
    $net_amount = $gross_amount - $final_deduction;
 
     //insert new payroll to payroll list table
   $mysqli->query("INSERT INTO payroll_list (payroll_from, payroll_to, emp_id, payroll_type, gross_amount) VALUES ('$payroll_from', '$payroll_to', '$payroll_emp_id', '$payroll_type' , '$gross_amount')ON DUPLICATE KEY UPDATE payroll_from='$payroll_from', payroll_to='$payroll_to', payroll_type='$payroll_type', gross_amount='$gross_amount';") or
   die($mysqli->error);
   //insert to history report for payrolls table
   
   $mysqli->query("INSERT INTO payroll_history (payroll_from, payroll_to, emp_id, payroll_type, gross_amount, net_amount, total_deduction, salary, pera, leave_amount, sg, step, name, position) VALUES ('$payroll_from', '$payroll_to', '$payroll_emp_id', '$payroll_type' , '$gross_amount', '$net_amount', '$final_deduction', '$payroll_emp_salary', '$fetched_sum', '$leave_deduction_amount', '$employee_sg', '$employee_step', '$employee_name', '$employee_position')") or
   die($mysqli->error);
    
     
    }  

    
  header("location:employees.php");

}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>CBOO | Employee</title>

  <!-- Google Font: Source Sans Pro -->
  <link href='https://fonts.googleapis.com/css?family=Inter' rel='stylesheet'>
  <!-- Font Awesome -->
  <link rel="stylesheet" href="plugins/fontawesome-free/css/all.min.css">
  <script src="https://kit.fontawesome.com/dd09e290e6.js" crossorigin="anonymous"></script>
		
   <!-- Select2 -->
   <link rel="stylesheet" href="plugins/select2/css/select2.min.css">
   <link rel="stylesheet" href="plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css">
  <!-- jsGrid -->
  <link rel="stylesheet" href="plugins/jsgrid/jsgrid.min.css">
  <link rel="stylesheet" href="plugins/jsgrid/jsgrid-theme.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="dist/css/adminlte.css">
   <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.25/css/jquery.dataTables.min.css">
    <link href="https://unpkg.com/frappe-datatable@0.0.5/dist/frappe-datatable.min.css" rel="stylesheet">
    <script type="text/javascript" src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script type="text/javascript" src="https://cdn.datatables.net/1.10.25/js/jquery.dataTables.min.js"></script>
    <script src="https://unpkg.com/sortablejs@1.7.0/Sortable.min.js"></script>
    <script src="https://unpkg.com/clusterize.js@0.18.0/clusterize.min.js"></script>
    <script src="https://unpkg.com/frappe-datatable@0.0.5/dist/frappe-datatable.min.js"></script>
  <style>
			.hide
			{
				display:none;
			}
  </style>
  <style>
.modal-custom {
  max-width: 500px;
}

</style>
<style>
    #datatable table {
        width: 79%;

    }
    
    .table-responsive {
        overflow: auto;
    }
</style>
<script>
  $(document).ready(function() {
    // Bind the close button to the modal
    $('#successModal .close').click(function() {
      $('#successModal').modal('hide');
      window.location = "employees.php";
    });
  });
</script>
<script>
  $(document).ready(function() {
    // bind close button to Restore Success modal
    $("#restoreSuccessModal .close").click(function() {
      $("#restoreSuccessModal").modal('hide');
      window.location = "employees.php";
    });
  });
</script>

</head>
<body class="hold-transition sidebar-mini">
<div class="wrapper">

   <!-- Preloader -->
   <div class="preloader flex-column justify-content-center align-items-center">
    <img class="animation__wobble" src="src/images/bsu.jpg" alt="AdminLTELogo" height="90" width="90" style="border-radius:50%;">
  </div>

<!-- Navbar -->
<nav class="main-header navbar navbar-expand navbar-white navbar-light">
  <!-- Left navbar links -->
  <ul class="navbar-nav">
    <li class="nav-item">
      <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
    </li>
  </ul>

  <!-- Center Buttons -->
  <ul class="navbar-nav ml-auto mr-auto">
    <li class="nav-item ml-3">
      <button type="button" class="btn btn-block btn-default" data-toggle="modal" data-placement="top" data-target="#add-Employee">
        <i class="fas fa-plus"></i> <span class="ml-1">Add Employee</span>
      </button>
    </li>
    <li class="nav-item ml-3">
      <button type="button" class="btn btn-block btn-default" data-toggle="modal" data-target="#import-data">
        <i class="fas fa-file-import"></i> <span class="ml-1">Import CSV</span>
      </button>
    </li>
    <li class="nav-item ml-3">
      <button type="button" class="btn btn-block btn-default" onclick="location.href='employee_data.php';">
        <i class="fas fa-users"></i> <span class="ml-1">Employee Data</span>
      </button>
    </li>
    <li class="nav-item ml-3">
      <button type="button" class="btn btn-block btn-default" data-toggle="modal" data-target="#backupModal">
        <i class="fas fa-hdd"></i> <span class="ml-1">Backup</span>
      </button>
    </li>
    <li class="nav-item ml-3">
      <button type="button" class="btn btn-block btn-default" data-toggle="modal" data-target="#restoreModal">
        <i class="fas fa-undo"></i> <span class="ml-1">Restore</span>
      </button>
    </li>
    <li class="nav-item ml-3">
      <button type="button" class="btn btn-block btn-default" data-toggle="modal" data-target="#generate-payroll">
        <i class="fas fa-file-invoice-dollar"></i> <span class="ml-1">Generate Payroll</span>
      </button>
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
        <!-- Sidebar user panel (optional) -->
        <div class="user-panel mt-3 pb-3 mb-3 d-flex">
		<div class="image">
           <?php if($image==NULL)
				{
					echo '<img src = "dist/img/user2-16x160.jpg" class="img-circle elevation-2">';
				} else { echo '<img src="images/'.$image.'" class="img-circle elevation-2">';}?> 
        </div>
          <div class="info">
            <a href="account.php" class="d-block"><?php echo $fetch_info['name']; ?></a>
          </div>
        </div>
  
       
        <!-- Sidebar Menu -->
          <?php include 'nav-bar.php'; ?>
        <!-- /.sidebar-menu -->
      </div>
      <!-- /.sidebar -->
    </aside>

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
      </div><!-- /.container-fluid -->
    </section>

    <!-- Main content -->
    <section class="content">
   <!--Add Employee Modal -->
   <!-- Add Employee Modal -->
<div class="modal fade" id="add-Employee" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title text-center" id="exampleModalLabel">Add New Employee</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form action="employees_home.php" method="POST">
          <input type="hidden" name="admin_id" value="<?php echo $admin_id; ?>">
          <div class="container-fluid">
            <div class="row">
              <div class="col-12 col-md-6 form-group">
                <label for="name">Name</label>
                <input name="name" class="form-control" type="text" placeholder="Enter Employee Name" required>
              </div>
              <div class="col-12 col-md-6 form-group">
                <label for="id">ID Number</label>
                <input name="id" class="form-control" type="number" placeholder="Enter Employee Number" required>
              </div>
            </div>
            <div class="row">
              <div class="col-12 col-md-6 form-group">
                <label for="project_name">Project</label>
                <select name="project_name" onchange="getPositionList(this.value)" id="project_list" class="custom-select">
                  <option selected>Select Project</option>
                </select>
              </div>
              <div class="col-12 col-md-6 form-group">
                <label for="position_id">Position</label>
                <select name="position_id" onchange="getModelList(this.value)" id="position_list" class="custom-select">
                  <option selected>Select Position</option>
                </select>
              </div>
            </div>
            <div class="row">
              <div class="col-12 form-group">
                <label for="employee_type">Type</label>
                <div class="form-check">
                  <input class="form-check-input" type="radio" name="employee_type" value="T" id="radio_teaching">
                  <label class="form-check-label" for="radio_teaching">
                    Teaching Staff
                  </label>
                </div>
                <div class="form-check">
                  <input class="form-check-input" type="radio" name="employee_type" id="radio_non_teaching" value="NT" checked>
                  <label class="form-check-label" for="radio_non_teaching">
                    Non-Teaching Staff
                  </label>
                </div>
              </div>
            </div>
            <div class="row justify-content-center">
              <div class="col-12 col-md-6 form-group">
                <button type="submit" name="save" id="save" class="btn btn-primary btn-block">
                  Save Changes
                </button>
              </div>
            </div>
          </div>
        </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">
          Close
        </button>
      </div>
    </div>
  </div>
</div>

				<!-- Add Employee Modal End-->
        <!-- Import Modal Start -->
				<div class="modal fade" id="import-data" tabindex="-1" role="dialog" aria-labelledby="modalLabel" aria-hidden="true">
					<div class="modal-dialog modal-dialog-centered">
											<div class="modal-content">
												<div class="modal-header" style="background: #98FB98;">
													<h4 class="modal-title w-100 text-center" id="modalLabel">
														Import CSV file
													</h4>
													<button type="button" class="close" data-dismiss="modal" aria-hidden="true">
														×
													</button>
												</div>
												<div class="modal-body">
													<div id="wrap">
														<div class="container">
															<div class="row">
																<div class="span3 hidden-phone"></div>
																<div class="span6" id="form-login">
																	<form class="form-horizontal well" action="import.php" method="post" name="upload_excel" enctype="multipart/form-data">
																		<input type="hidden" name="admin_id" value="<?php echo $admin_id; ?>">
																		<fieldset>
																			<div class="control-group">
																				<div class="control-label">
																					<label>CSV:</label>
																				</div>
																				<div class="controls">
																					<input type="file" name="file" id="file" class="input-large">
																				</div>
																			</div>
																			<div class="control-group">
																				<div class="controls">
																					<button type="submit" id="submit" name="Import" class="btn btn-primary button-loading mt-2" data-loading-text="Loading...">Import</button>
																				</div>
																			</div>
																		</fieldset>
																	</form>
																</div>
																<div class="span3 hidden-phone"></div>
															</div>
														</div>
													</div>
												</div>
											</div>
					</div>
				</div>
				<!-- Import Modal End -->
        <!--Backup Modal-->
        <div class="modal fade" id="backupModal" tabindex="-1" role="dialog" aria-labelledby="confirmationModalLabel" aria-hidden="true">
          <div class="modal-dialog" role="document">
            <div class="modal-content">
              <div class="modal-header">
                <h5 class="modal-title w-100 text-center" id="confirmationModalLabel">Confirm Backup</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
                </button>
              </div>
              <div class="modal-body w-100 text-center">
                Are you sure you want to proceed with the backup?
              </div>
              <div class="modal-footer d-flex justify-content-center">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                <button type="button" class="btn btn-primary" onclick="location.href='backup.php';">Proceed</button>
              </div>
            </div>
          </div>
        </div>
        <!--Backup modal end-->
        <!--Restore Modal-->
       
        <div class="modal fade" id="restoreModal" tabindex="-1" role="dialog" aria-labelledby="confirmationModalLabel" aria-hidden="true">
          <div class="modal-dialog" role="document">
            <div class="modal-content">
             <form id="restoreForm" enctype="multipart/form-data">
                      <div class="modal-header bg-primary text-white">
                        <h5 class="modal-title w-100 text-center" id="confirmationModalLabel">Select Backup File</h5>
                        <button type="button" class="btn-close" data-dismiss="modal" aria-label="Close"></button>
                      </div>
                      <div class="modal-body">
                        <div class="form-group mb-3">
                          <label for="sql-file" class="form-label">Choose SQL file:</label>
                          <input type="file" class="form-control" id="sql-file" name="sql-file" accept=".sql, application/sql">
                        </div>
                      </div>
                      <div class="modal-footer d-flex justify-content-center">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                        <button type="submit" id="restoreBtn" class="btn btn-primary">Proceed</button>
                      </div>
                    </form>
            </div>
          </div>
        </div>
        <!--Restore Modal End-->
<!-- Generate Payroll Modal -->
<div class="modal fade" id="generate-payroll" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
	<div class="modal-dialog modal-custom" role="document">
		<div class="modal-content">
			<div class="modal-header" style="background: #98FB98;">
				<h5 class="modal-title w-100 text-center" id="exampleModalLabel">New Payroll</h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<div class="modal-body">
				<form class="form-horizontal well" method="post">
					<div class="form-group"> <!-- from date picker-->                                              
						<label>From Date</label>
						<input class="form-control" name="payroll_from" type="date" required>
					</div>
					<div class="form-group">  <!-- to date picker-->    
						<label>To Date</label>
						<input class="form-control" name="payroll_to" type="date" required>
					</div>
					
					<div class="d-flex justify-content-center">
						<button type="submit" name="save_payroll" id="save_payroll" class="btn btn-primary">
							Save
						</button>
						<button type="button" class="btn btn-secondary ml-2" data-dismiss="modal">
							Close
						</button>
					</div>
				</form>
			</div>
			<div class="modal-footer">
			</div>
		</div>
	</div>
</div>
<!--Backup Success modal -->
<div class="modal fade" id="successModal" tabindex="-1" role="dialog" aria-labelledby="successModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content text-center" style="background-color: #fff; border-radius: 10px; box-shadow: 0px 0px 20px rgba(0, 0, 0, 0.2);">
      <div class="modal-header" style="border-bottom: none;">
        <div class="text-center w-100">
          <h5 class="modal-title" id="successModalLabel" style="color: #28a745; font-weight: bold;">Success!</h5>
        </div>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close" onclick="closeSuccessModal()">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body" style="color: #6c757d;">
        Backup has been successfully created.
      </div>
    </div>
  </div>
</div>

<!-- Restore Success modal -->
<div class="modal fade" id="restoreSuccessModal" tabindex="-1" role="dialog" aria-labelledby="restoreSuccessModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content text-center" style="background-color: #fff; border-radius: 10px; box-shadow: 0px 0px 20px rgba(0, 0, 0, 0.2);">
      <div class="modal-header" style="border-bottom: none;">
        <div class="text-center w-100">
          <h5 class="modal-title" id="restoreSuccessModalLabel" style="color: #28a745; font-weight: bold;">Success!</h5>
        </div>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body" style="color: #6c757d;">
        Database has been successfully restored.
      </div>
    </div>
  </div>
</div>
				<link type="text/css" rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jsgrid/1.5.3/jsgrid.min.css" />
				<link type="text/css" rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jsgrid/1.5.3/jsgrid-theme.min.css" />
				<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jsgrid/1.5.3/jsgrid.min.js"></script>
				<!-- Table -->
				<div class="table-responsive mt-1">
				    <div id="datatable"></div>
				</div>
      
    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->
</div>
<!-- ./wrapper -->

<!-- jQuery -->
<script src="plugins/jquery/jquery.min.js"></script>
<!-- Bootstrap 4 -->
<script src="plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<!-- Select2 -->
<script src="plugins/select2/js/select2.full.min.js"></script>
<!-- jsGrid -->
<script src="plugins/jsgrid/demos/db.js"></script>
<script src="plugins/jsgrid/jsgrid.min.js"></script>
<!-- AdminLTE App -->
<script src="dist/js/adminlte.min.js"></script>
<!-- AdminLTE for demo purposes -->
<script src="dist/js/demo.js"></script>
<!-- Page specific script -->
<script>
	//function for getting the position which are covered under a selected project
	$(document).ready(function(){
       
       let tag ="projectList"; 
       let select_menu=$('#project_list')[0]; // this expression is same as document.getElementById('dynamic_menu')
       $.ajax({
            url:"ajax.php",
            dataType:"json",
            method:"post",
            data:{tag:tag},
            success:function(response){
                //alert(response.length);
                console.log($.isArray(response)); // if response is an array, this function will return true

                response.forEach((position,index)=>{
                    console.log(index,position);
                    var option = document.createElement("option");
                    option.value = position['id'];
                    option.text = position['project_name'];
                    select_menu.appendChild(option);
                })
            }
        })
	});
    
  //Getting position List on the basis of project_id
function getPositionList(project_id) {
  let tag = "positionList";
  let positionMenu = $('#position_list')[0];

  //Removing all the old options from position list and model list and adding only one option in one go
  $('#position_list').empty().append('<option>Select position</option>');

  $.ajax({
    url: "ajax.php",
    dataType: "json",
    method: "post",
    data: {tag: tag, project_id: project_id},
    success: function(response) {
      response.forEach((position, index) => {
        console.log(index, position);
        // Concatenate SG and Step to position name
       let positionName = `${position['position_name']} | SG: ${position['sg']} | STEP: ${position['step']}`;

        var option = document.createElement("option");
        option.value = position['id'];
        option.text = positionName;
        positionMenu.appendChild(option);
      });
    }
  });
}

	//fucntion for employee name validation
 $(function(){
        var validation_el = $('<div>')
            validation_el.addClass('validation-err alert alert-danger my-2')
            validation_el.hide()
        $('input[name="name"]').on('input',function(){
            var name = $(this).val()
                $(this).removeClass("border-danger border-success")
                $(this).siblings(".validation-err").remove();
            var err_el = validation_el.clone()

                if(name == '')
                return false;

                $.ajax({
                    url:"validate.php",
                    method:'POST',
                    data:{name:name},
                    dataType:'json',
                    error:err=>{
                        console.error(err)
                        alert("An error occured while validating the data")
                    },
                    success:function(resp){
                        if(Object.keys(resp).length > 0 && resp.field_name == 'name'){
                            err_el.text(resp.msg)
                            $('input[name="name"]').addClass('border-danger')
                            $('input[name="name"]').after(err_el)
                            err_el.show('slideDown')
                            $('#save').attr('disabled',true)
                        }else{
                            $('input[name="name"]').addClass('border-success')
                            $('#save').attr('disabled',false)
                        }
                    }
                })
        })

    })
   
	//check from data table if employee name already exist, go to validate.php
	function checkName() {
    
    jQuery.ajax({
    url: "process.php",
    data:'name='+$("#name").val(),
    type: "POST",
    success:function(data){
        $("#check-name").html(data);
    },
    error:function (){}
    });
}


</script>

<?php

// Query database for data
$result = $mysqli->query("SELECT name, position, sg, step, salary FROM data");

// Check for errors
if (!$result) {
    die('Error retrieving data: ' . $mysqli->error);
}

// Format data for DataTable
$data = array();
while ($row = $result->fetch_assoc()) {
    $data[] = array(
        $row['name'],
        $row['position'],
        $row['sg'],
        $row['step'],
        $row['salary']
    );
}
// Close database connection
$mysqli->close();
?>
<script type="text/javascript">
    const datatable = new DataTable('#datatable', {
        columns: [
            { name: 'Name', editable: false },
            { name: 'Position', editable: false},
            { name: 'SG', editable: false },
            { name: 'Step', editable: false },
            { name: 'Salary', editable: false},
            
        ],
        data: <?php echo json_encode($data); ?>,
        resizableColumns: true,
        columnSorting: true,
        	checkboxColumn: true,
			serialNoColumn: true,
			inlineFilters: true,
			dynamicRowHeight: true,
			showTotalRow: true,
			dynamicRowHeight: true,
			pasteFromClipboard: true,
    });
    
  
    
</script>
<script>
  $(document).ready(function() {
    // Check if URL has successModal anchor
    if(window.location.hash == "#successModal") {
      // Show success modal
      $('#successModal').modal('show');
    }
  });
  $(document).ready(function() {
    // Check if URL has restoreSuccessModal anchor
    if(window.location.hash == "#restoreSuccessModal") {
      // Show success modal
      $('#restoreSuccessModal').modal('show');
    }
  });

</script>
<script>
    $(function() {
  // Listen for the form submission event
  $('#restoreForm').submit(function(e) {
    e.preventDefault();

    // Disable the submit button to prevent multiple submissions
    $('#restoreBtn').prop('disabled', true);

    // Send the AJAX request
    var formData = new FormData(this);
    $.ajax({
      url: 'restore.php',
      type: 'POST',
      data: formData,
      success: function(response) {
        // Show the success message and close the modal
        $('#restoreModal').modal('hide');
        $('#restoreSuccessModal').modal('show');
      },
      error: function(jqXHR, textStatus, errorMessage) {
        // Show the error message and enable the submit button
        alert('Error: ' + errorMessage);
        $('#restoreBtn').prop('disabled', false);
      },
      cache: false,
      contentType: false,
      processData: false
    });
  });
});

</script>
</body>
</html>
