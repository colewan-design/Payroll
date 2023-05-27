<script>jQuery.noConflict();</script>
<?php 
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
 require_once "controllerUserData.php";
$mysqli = new mysqli('bsu-info.tech', 'u455679702_cps', 'OpK3RKh]!h9', 'u455679702_cps') or die(mysqli_error($mysqli));      


$email = $_SESSION['email'];

$password = $_SESSION['password'];
$id = (int)$_GET['id'];
if($email != false && $password != false){
    $sql = "SELECT * FROM usertable WHERE email = '$email'";
    $run_Sql = mysqli_query($con, $sql);
    if($run_Sql){
        $fetch_info = mysqli_fetch_assoc($run_Sql);
        $status = $fetch_info['status'];
        $code = $fetch_info['code'];
		$image = $fetch_info['image'];
		$name = $fetch_info['name'];
		$admin_id = $fetch_info['id'];
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


$fetch_employee_data = $mysqli->query("SELECT * FROM data WHERE id = $id") or die($mysqli->error);
if($employee_data_result = mysqli_fetch_array($fetch_employee_data))
{
$employee_name = $employee_data_result['name']; 
$position = $employee_data_result['position']; 
$sg = $employee_data_result['sg']; 
$step = $employee_data_result['step']; 
$salary = $employee_data_result['salary']; 
$project = $employee_data_result['project']; 
}

if(isset($_POST['addEmployeeAllowance'])){
  $employeeId = $_POST['id'];
  $employeeAllowanceId = $_POST['employeeAllowanceId'];
  $admin_id = $_POST['admin_id'];
	$activity_type = "Insert employee incentive";
  
	$time_logged = date("Y-m-d H:i:s",strtotime("now"));
	$mysqli->query("INSERT INTO activity (time_logged, admin_id, activity_type) VALUES ('$time_logged', '$admin_id', '$activity_type')") or
	die($mysqli->error);
  
  $allowance_result = $mysqli->query("SELECT * FROM allowance WHERE allowanceId=$employeeAllowanceId") or die($mysqli->error());
        $row = $allowance_result->fetch_array();
        $employeeAllowanceName = $row['allowanceName'];
        $employeeallowanceAmount = $row['allowanceAmount'];
        $allowanceType = $row['allowanceType'];
       
        $data_result = $mysqli->query("SELECT * FROM data WHERE id=$employeeId") or die($mysqli->error());
        $data_row = $data_result->fetch_array();
        $employee_salary = $data_row['salary'];
		    if($allowanceType == 'percentage'){
        $get_percentage = $employeeallowanceAmount / 100;
        $employeeallowanceAmount = $get_percentage * $employee_salary;
        }
       
   
  // Check if the record exists
$result = $mysqli->query("SELECT * FROM employeeallowance WHERE eaName='$employeeAllowanceName' AND employeeId=$employeeId");

if ($result->num_rows > 0) {
  // Update the record
  $mysqli->query("UPDATE employeeallowance SET employeeallowanceAmount='$employeeallowanceAmount', allowanceId='$employeeAllowanceId' WHERE eaName='$employeeAllowanceName' AND employeeId=$employeeId") or die($mysqli->error());
} else {
  // Insert a new record
  $mysqli->query("INSERT INTO employeeallowance (employeeId, eaName, allowanceId, employeeallowanceAmount) VALUES ('$employeeId', '$employeeAllowanceName', '$employeeAllowanceId', '$employeeallowanceAmount')") or die($mysqli->error());
}


  header("location:".$_SERVER['HTTP_REFERER']);
}

//insert employee mandatory deduction
if(isset($_POST['addEmployeeDeduction'])){
  $employeeId = $_POST['id'];
  $employeeDeductionId = $_POST['employeeDeductionId'];
  $additionalDeductionValue = $_POST['additionalDeductionValue'];
  $admin_id = $_POST['admin_id'];
  $activity_type = "Insert employee Mandatory deduction";

  $time_logged = date("Y-m-d H:i:s",strtotime("now"));
  $mysqli->query("INSERT INTO activity (time_logged, admin_id, activity_type) VALUES ('$time_logged', '$admin_id', '$activity_type')") or
  die($mysqli->error);
  //get the data of the deduction from deduction table using ID 
        $deduction_result = $mysqli->query("SELECT * FROM deductions WHERE deductionId=$employeeDeductionId") or die($mysqli->error());
        $row = $deduction_result->fetch_array();
        //get the data of the employee to have access on the employee salary
        $employee_salary = $mysqli->query("SELECT * FROM data WHERE id=$employeeId") or die($mysqli->error());
        $employee_salary_row = $employee_salary->fetch_array();
        $current_employee_salary = $employee_salary_row['salary'];
        $a = $current_employee_salary;
        $current_employee_salary = preg_replace('/[,]/', '', $a);
        
      $employeeDeductionName = $row['deductionName'];
$employeeDeductionAmount = $row['amount'];
if (!empty($additionalDeductionValue)) {
  $employeeDeductionAmount += $additionalDeductionValue;
}
$percentage_employeeDeductionAmount = $employeeDeductionAmount/100;//decimal value of the deduction
$deduction_type = $row['deductionType'];
$minDeductionLimit = $row['minDeductionLimit'];
$maxDeductionLimit = $row['maxDeductionLimit'];

//multiply the deduction amount in its decimal form to the employee's salary
if($deduction_type == 'percentage'){
  $final_employeeDeductionAmount = $percentage_employeeDeductionAmount * $current_employee_salary;
}
else{
  //else retain the value and set it as the final deduction amount
  $final_employeeDeductionAmount = $employeeDeductionAmount;
}

//check if the final deduction amount is greater than the max deduction limit
if ($final_employeeDeductionAmount > $maxDeductionLimit) {
  $final_employeeDeductionAmount = $maxDeductionLimit;
}

//check if the final deduction amount is less than the min deduction limit
if ($final_employeeDeductionAmount < $minDeductionLimit) {
  $final_employeeDeductionAmount = $minDeductionLimit;
}

//if deduction limit is 0 check if the deduction type is percentage or real value and assign the value to decimal or whole number
if ($final_employeeDeductionAmount == 0){
  if ($deduction_type == 'percentage'){
    $final_employeeDeductionAmount = $percentage_employeeDeductionAmount * $current_employee_salary;
  }
  else if ($deduction_type == 'real_value'){
    $final_employeeDeductionAmount = $employeeDeductionAmount;
  }
}

  

    $result = $mysqli->query("SELECT * FROM employeedeductions WHERE edName='$employeeDeductionName' AND employeeId=$employeeId");

if ($result->num_rows > 0) {
  $mysqli->query("UPDATE employeedeductions SET employeeDeductionAmount='$final_employeeDeductionAmount', employeeId='$employeeId', edName='$employeeDeductionName', deductionId='$employeeDeductionId' WHERE edName='$employeeDeductionName' AND employeeId=$employeeId") or die($mysqli->error());
} else {
  $mysqli->query("INSERT INTO employeedeductions (employeeDeductionAmount, employeeId, edName, deductionId) VALUES ('$final_employeeDeductionAmount', '$employeeId', '$employeeDeductionName', '$employeeDeductionId')") or die($mysqli->error());
}

  header("location:".$_SERVER['HTTP_REFERER']);
}
//employee deduction delete process
if (isset($_GET['employeeDeductionDelete'])){
  $edID = $_GET['employeeDeductionDelete'];
  $edName = $_GET['employeeDeductionName'];
  $mysqli->query("UPDATE employeedeductions SET employeeDeductionAmount='0' WHERE edID=$edID AND edName='$edName'") or die($mysqli->error());

  
  $admin_id = $_GET['admin_id'];
  $activity_type = "Delete employee mandatory deduction";

  $time_logged = date("Y-m-d H:i:s",strtotime("now"));
  $mysqli->query("INSERT INTO activity (time_logged, admin_id, activity_type) VALUES ('$time_logged', '$admin_id', '$activity_type')") or
  die($mysqli->error);

  $_SESSION['message'] = "Record has been deleted!";
  $_SESSION['msg_type'] = "danger";

  header("location:".$_SERVER['HTTP_REFERER']);
}

//employee allowance delete process
if (isset($_GET['employeeallowanceDelete'])){
  $eaID = $_GET['employeeallowanceDelete'];
 
  $mysqli->query("UPDATE employeeallowance SET employeeallowanceAmount='0' WHERE eaID=$eaID AND eaName='PERA'") or die($mysqli->error());

  $admin_id = $_GET['admin_id'];
  $activity_type = "Delete employee incentive";

  $time_logged = date("Y-m-d H:i:s",strtotime("now"));
  $mysqli->query("INSERT INTO activity (time_logged, admin_id, activity_type) VALUES ('$time_logged', '$admin_id', '$activity_type')") or
  die($mysqli->error);

  $_SESSION['message'] = "Record has been deleted!";
  $_SESSION['msg_type'] = "danger";

  header("location:".$_SERVER['HTTP_REFERER']);
}

//insert other deductions
if(isset($_POST['addEmployeeOtherDeduction'])){
  $employeeId = $_POST['id'];
  $otherDeductionId = $_POST['otherDeductionId'];
  $employeeOtherDeductionAmount = $_POST['employeeOtherDeductionAmount'];

  $admin_id = $_POST['admin_id'];
  $activity_type = "Insert Employee Secondary Deduction";

  $time_logged = date("Y-m-d H:i:s",strtotime("now"));
  $mysqli->query("INSERT INTO activity (time_logged, admin_id, activity_type) VALUES ('$time_logged', '$admin_id', '$activity_type')") or
  die($mysqli->error);

        $other_deduction_result = $mysqli->query("SELECT * FROM otherdeductions WHERE otherDeductionId=$otherDeductionId") or die($mysqli->error());
        $row = $other_deduction_result->fetch_array();

        
        $employeeOtherDeductionName = $row['otherDeductionName'];
       
        
    $mysqli->query("INSERT INTO employeeotherdeductions( employeeOtherDeductionAmount, employeeId, employeeOtherDeductionName, otherDeductionId) VALUES ('$employeeOtherDeductionAmount', '$employeeId', '$employeeOtherDeductionName', '$otherDeductionId')") or
    die($mysqli->error);

  header("location:".$_SERVER['HTTP_REFERER']);
}
//employeeotherdeductionDelete
if (isset($_GET['employeeotherdeductionDelete'])){
  $odId = $_GET['employeeotherdeductionDelete'];
  $mysqli->query("DELETE FROM employeeotherdeductions WHERE odId=$odId") or die($mysqli->error());

  $admin_id = $_GET['admin_id'];
  $activity_type = "Delete employee secondary deduction";

  $time_logged = date("Y-m-d H:i:s",strtotime("now"));
  $mysqli->query("INSERT INTO activity (time_logged, admin_id, activity_type) VALUES ('$time_logged', '$admin_id', '$activity_type')") or
  die($mysqli->error);

  $_SESSION['message'] = "Record has been deleted!";
  $_SESSION['msg_type'] = "danger";

  header("location:".$_SERVER['HTTP_REFERER']);
}
//insert remark
if(isset($_POST['addRemark'])){
  $employeeId = $_POST['id'];
  $get_other_deduction = $_POST['get_other_deduction'];
  $remark_text = $_POST['remark_text'];

  $admin_id = $_POST['admin_id'];
  $activity_type = "Insert new remark";

  $time_logged = date("Y-m-d H:i:s",strtotime("now"));
  $mysqli->query("INSERT INTO activity (time_logged, admin_id, activity_type) VALUES ('$time_logged', '$admin_id', '$activity_type')") or
  die($mysqli->error);

        $other_deduction_result = $mysqli->query("SELECT * FROM otherdeductions WHERE otherDeductionId=$get_other_deduction") or die($mysqli->error());
        $row = $other_deduction_result->fetch_array();

        
        $employeeOtherDeductionName = $row['otherDeductionName'];
       
        
    $mysqli->query("INSERT INTO remarks( remark_text, emp_id, other_deduction_name) VALUES ('$remark_text', '$employeeId', '$employeeOtherDeductionName')") or
    die($mysqli->error);

  header("location:".$_SERVER['HTTP_REFERER']);
}
//Remark Delete
if (isset($_GET['employeeremarkDelete'])){
  $remark_id = $_GET['employeeremarkDelete'];
  $mysqli->query("DELETE FROM remarks WHERE id=$remark_id") or die($mysqli->error());

  $admin_id = $_GET['admin_id'];
  $activity_type = "Delete employee secondary deduction remarks";

  $time_logged = date("Y-m-d H:i:s",strtotime("now"));
  $mysqli->query("INSERT INTO activity (time_logged, admin_id, activity_type) VALUES ('$time_logged', '$admin_id', '$activity_type')") or
  die($mysqli->error);

  $_SESSION['message'] = "Record has been deleted!";
  $_SESSION['msg_type'] = "danger";

  header("location:".$_SERVER['HTTP_REFERER']);
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>CBOO | Employee Info</title>
  <!--script component -->
  <!-- jQuery -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<?php  require_once "components/js/employee_details_pre_content_script.php"; ?>

</head>
<body class="hold-transition sidebar-mini">
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
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-6">
            <!-- Title Here -->
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="index.php">Home</a></li>
              <li class="breadcrumb-item"><a href="employees.php">Employees</a></li>
              <li class="breadcrumb-item"><a href="employee_data.php">Employee Data</a></li>
              <li class="breadcrumb-item active">Employee's Info</li>
            </ol>
          </div><!-- /.col -->
        </div>
      </div><!-- /.container-fluid -->
    </section>
    <?php
		$fetch_employee_allowance = $mysqli->query("SELECT * FROM employeeallowance where employeeId='$id' AND employeeallowanceAmount > 0") or die($mysqli->error);
			$fetch_employee_remark = $mysqli->query("SELECT * FROM remarks where emp_id='$id'") or die($mysqli->error);
	?>
    <!-- Main content -->
    <section class="content">
    <div class="card ml-4" style="width: 95.5%;">
    <div class="employee-info row">
        <!--<div>Employee Name: <span class="employee-name"><?php echo $employee_name; ?></span></div>
        <div>SG: <span class="sg"><?php echo $sg; ?></span>  |  Step: <span class="step"><?php echo $step; ?></span>  |  Salary: <span class="salary"><?php echo $salary; ?></span>  |  Project: <span class="project"><?php echo $project; ?></span></div>-->
        <div class="col-sm-6">
      <!-- First Column Content -->
      <h6><b>Employee Name:</b> <span class="employee-name"><?php echo $employee_name; ?></span></h6>
      <h6><b>Project:</b> <span class="project"><?php echo $project; ?></span></h6>
      <h6><b>Salary Grade:</b> <span class="sg"><?php echo $sg; ?></span></h6>
      <h6><b>Basic Salary:</b> <span class="salary"><?php echo number_format($salary,2); ?></span></h6>
        </div>
        <div class="col-sm-6">
          <!-- Second Column Content -->
          <div></div>
          <h6><b>Position:</b> <span class="position"><?php echo $position; ?></span></h6>
          <h6><b>Step:</b> <span class="step"><?php echo $step; ?></span></h6>
        </div>
    </div>
</div>
      <div class="card ml-4" style="width: 45%; float:left;">
			        <div class="d-flex justify-content-between align-items-center px-4 py-3" style="background-color: #343a40;">
                        <h4 class="text-light mb-0">Allowances</h4>
                        <button type="button" class="btn btn-primary addbtn" data-toggle="modal" data-target="#add-Employee-allowance">Add New Allowance</button>
                    </div>
					<div class="d-flex justify-content-md-end">
					  <!-- The Employee's Incentive Modal -->
					 <?php  require_once "modals/employee_incentive_modal.php"; ?>
					 <!-- End Employee's Incentive Modal -->
					</div>
           
            <!-- Employee Incentive Table -->
						<div class="table-responsive">
						    <table id="allowance" class="table table-striped table-bordered">
                            	<thead class="table-success">
                            		<tr>
                            			<th class="text-center">Allowance Name</th>
                            			<th class="text-center">Amount</th>
                            			<th class="text-center">Actions</th>
                            		</tr>
                            	</thead>
                            	<tbody>
                            		<?php
                            			while($employee_allowance_row = $fetch_employee_allowance->fetch_assoc()):
                            		?>
                            		<tr>
                            			<td><?php echo $employee_allowance_row['eaName']; ?></td>
                            			<td><?php echo number_format($employee_allowance_row['employeeallowanceAmount'],2); ?></td>
                            			<td class="text-center">
                            				<a href="employee-details.php?admin_id=<?php echo $admin_id;?>&employeeallowanceDelete=<?php echo $employee_allowance_row['eaID']; ?>" data-toggle="modal" data-target="#confirm-delete<?php echo $employee_allowance_row['eaID'] ?>">
                            					<button type="button" class="btn btn-danger btn-sm">
                            						<i class="fas fa-trash"></i> Delete
                            					</button>
                            				</a>
                            				<!--Delete Employee's Allowance Modal-->
                            				<div class="modal fade" id="confirm-delete<?php echo $employee_allowance_row['eaID'] ?>" tabindex="-1" role="dialog" aria-labelledby="myModalLabel"  aria-hidden="true">
                            					<div class="modal-dialog modal-dialog-centered">
                            						<div class="modal-content">
                            							<div class="modal-body text-center font-18">
                            								<h4 style="padding-top: 30px; margin-bottom:30px; font-weight:bold;">
                            									Delete this Employee's Allowance: <?php echo $employee_allowance_row['eaName']; ?>?
                            								</h4>
                            								<div class="padding-bottom-30 row" style="max-width: 170px; margin: 0 auto">
                            									<div class="col-6">
                            										<button type="button" class="btn btn-secondary border-radius-100 btn-block confirmation-btn" data-dismiss="modal">
                            											<i class="fa fa-times"></i>
                            										</button>
                            									</div>
                            									<div class="col-6">
                            										<a class="btn btn-primary border-radius-100 btn-block confirmation-btn" href="employee-details.php?admin_id=<?php echo $admin_id;?>&employeeallowanceDelete=<?php echo $employee_allowance_row['eaID']; ?>">
                            											<i class="fa fa-check"></i>
                            										</a>
                            									</div>
                            								</div>
                            							</div>
                            						</div>
                            					</div>
                            				</div>  
                            			</td>
                            		</tr>
                            		<?php endwhile; ?>
                            	</tbody>
                            </table>
              
                        </div>   
            <!-- Table End -->
					</div>
					 
				
					<div class="card mr-4" style="width: 45%; float:right;">
				<div class="d-flex justify-content-between align-items-center px-4 py-3" style="background-color: #343a40;">
                  <h4 class="text-light mb-0 mr-3">Deductions</h4>
                  <div class="mr-3">
                    <button type="button" class="btn btn-primary mr-2" data-toggle="modal" data-target="#add-employee-deduction" style="margin-bottom:1rem;">Add Mandatory Deduction</button>
                    <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#add-other-deduction">Add Other Deduction</button>
                  </div>
                </div>
						<div class="d-flex justify-content-md-end">
							<!-- Employee's Deduction Modal -->
						      <div class="modal fade" id="add-employee-deduction" tabindex="-1" role="dialog" aria-labelledby="modalLabel" aria-hidden="true">
                                  <div class="modal-dialog modal-dialog-centered">
                                    <div class="modal-content">
                                      <div class="modal-header" style="background-color: #98FB98;">
                                        <h4 class="modal-title text-center w-100" id="modalLabel">
                                          Add Mandatory Deduction
                                        </h4>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                          <span aria-hidden="true">&times;</span>
                                        </button>
                                      </div>
                                      <div class="modal-body">
                                        <form method="POST">
                                            <input type="hidden" name="id" value="<?php echo $id; ?>">
                                             <input type="hidden" name="admin_id" value="<?php echo $admin_id; ?>">
                                          <div class="form-group">
                                            <label for="deduction-list">Deduction List</label>
                                            <select class="form-control" name="employeeDeductionId" id="employeeDeductionId">
                                              <option value="">Select</option>
                                              <?php
                                                $result = $mysqli->query("SELECT * FROM deductions") or die($mysqli->error);
                                                while ($trow = mysqli_fetch_array($result)) {
                                                  $trows[] = $trow;
                                                }
                                                foreach ($trows as $trow) {
                                                  print "<option value='" . $trow['deductionId'] . "'>" . $trow['deductionName'] . "</option>";
                                                }
                                              ?>
                                            </select>
                                          </div>
                                          <div class="form-group" id="additionalDeduction" style="display:none;">
                                            <label for="additional-deduction-value">Additional Deduction</label>
                                            <input type="text" class="form-control" name="additionalDeductionValue" id="additionalDeductionValue" placeholder="Enter additional deduction amount">
                                          </div>
                                          <div class="modal-footer d-flex justify-content-center">
                                            <button type="submit" name="addEmployeeDeduction" value="employee-details.php?addEmployeeDeduction" class="btn btn-success">
                                              Save
                                            </button>
                                            <button type="button" class="btn btn-secondary" data-dismiss="modal">
                                              Close
                                            </button>
                                          </div>
                                        </form>
                                      </div>
                                    </div>
                                  </div>
                                </div>


                            <!-- Employee Deduction Modal End -->
                            
							<!--Other Deductions Modal -->
							 <div class="modal fade" id="add-other-deduction" tabindex="-1" role="dialog" aria-labelledby="modalLabel" aria-hidden="true">
                              <div class="modal-dialog modal-dialog-centered">
                                <div class="modal-content">
                                  <div class="modal-header bg-success text-white">
                                    <h4 class="modal-title w-100 text-center" id="modalLabel">
                                      Add Other Deduction
                                    </h4>
                                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">
                                      &times;
                                    </button>
                                  </div>
                                  <div class="modal-body">
                                    <form method="POST">
                                      <input type="hidden" name="admin_id" value="<?php echo $admin_id; ?>">
                                      <input type="hidden" name="id" value="<?php echo $id; ?>">
                                      <div class="form-group row">
                                        <label class="col-sm-4 col-form-label font-weight-bold">Deduction List</label>
                                        <div class="col-sm-8">
                                       <div style="position: relative; width: 100%;">
                                          <select class="selectpicker form-control" name="otherDeductionId" id="otherDeductionId" style="position: relative; width: 100%; z-index: 1;">
                                            <option value="">Select</option>
                                            <?php
                                              $result = $mysqli->query("SELECT * FROM otherdeductions") or die($mysqli->error);
                                              while ($row_otherdeductions = mysqli_fetch_array($result)) {
                                                $row_otherdeductions_s[] = $row_otherdeductions;
                                              }
                                              foreach ($row_otherdeductions_s as $row_otherdeductions) {
                                                print "<option value='" . $row_otherdeductions['otherDeductionId'] . "'>" . $row_otherdeductions['otherDeductionName'] . "</option>";
                                              }
                                            ?>
                                          </select>
                                         
                                        </div>
                            
                            
                                        </div>
                                      </div>
                                      <div class="form-group row">
                                        <label class="col-sm-4 col-form-label font-weight-bold">Deduction Amount</label>
                                        <div class="col-sm-8">
                                          <input name="employeeOtherDeductionAmount" step="0.01" class="form-control" type="number" placeholder="Enter Amount" required>
                                        </div>
                                      </div>
                                      <div class="form-group row justify-content-center">
                                        <button type="submit" name="addEmployeeOtherDeduction" value="employee-details.php?addEmployeeOtherDeduction" class="btn btn-success mr-2">
                                          Save
                                        </button>
                                        <button type="button" class="btn btn-secondary" data-dismiss="modal">
                                          Close
                                        </button>
                                      </div>
                                    </form>
                                  </div>
                                  <div class="modal-footer"></div>
                                </div>
                              </div>
                            </div>

							 <!--end Other Deductions Modal -->
						</div>
						<?php
            
              $fetch_employee_deductions = $mysqli->query("SELECT * FROM employeedeductions where employeeId='$id' AND employeeDeductionAmount > 0") or die($mysqli->error);
              $fetch_employee_other_deductions = $mysqli->query("SELECT * FROM employeeotherdeductions where employeeId='$id'") or die($mysqli->error);
            ?>
            <!-- Employee's Deductions Table -->
					<div class="table-responsive">
					   <table id="deductions" class="table table-striped table-bordered">
                          <caption>Employee Deductions and Other Deductions</caption>
                          <thead>
                            <tr>
                              <th>Deduction Type</th>
                              <th>Amount</th>
                              <th>Actions</th>
                            </tr>
                          </thead>
                          <tbody>
                            <?php while($employee_deduction_row = $fetch_employee_deductions->fetch_assoc()): ?>
                              <tr class="deduction-type-employee">
                                <td><?php echo $employee_deduction_row['edName']; ?></td>
                                <td class="deduction-amount">
                                  <?php
                                    $employeeDeductionAmount = $employee_deduction_row['employeeDeductionAmount'];
                                    if ($employeeDeductionAmount == 0 || $employeeDeductionAmount == 0.00){
                                      echo '';
                                    } else {
                                      echo number_format($employeeDeductionAmount,2);
                                    }
                                  ?>
                                </td>
                                <td class="actions">
                                  <a href="employee-details.php?id=<?php echo $id;?>&admin_id=<?php echo $admin_id;?>&employeeDeductionDelete=<?php echo $employee_deduction_row['edID']; ?>" data-toggle="modal" data-target="#confirm-delete<?php echo $employee_deduction_row['edID'] ?>">
                                    <i class="fas fa-light fa-trash-can deletebtn"></i>
                                  </a> 
                                  <!-- Delete Employee Mandatory Deduction -->
                                 <div class="modal fade" id="confirm-delete<?php echo $employee_deduction_row['edID'] ?>" tabindex="-1" role="dialog" aria-labelledby="myModalLabel"  aria-hidden="true">
                                    <div class="modal-dialog modal-dialog-centered">
                                      <div class="modal-content">
                                        <div class="modal-body text-center font-18">
                                          <h4 style="padding-top: 30px; margin-bottom:30px; font-weight:bold;">
                                            Delete this Employee's Deduction: <?php echo $employee_deduction_row['edName']; ?>?
                                          </h4>
                                          <div class="padding-bottom-30 row" style="max-width: 170px; margin: 0 auto">
                                            <div class="col-6">
                                              <button type="button" class="btn btn-secondary border-radius-100 btn-block confirmation-btn" data-dismiss="modal">
                                                <i class="fa fa-times"></i>
                                              </button>
                                            </div>
                                            <div class="col-6">
                                              <a class="btn btn-primary border-radius-100 btn-block confirmation-btn" href = "employee-details.php?admin_id=<?php echo $admin_id;?>&employeeDeductionDelete=<?php echo $employee_deduction_row['edID']; ?>&employeeDeductionName=<?php echo $employee_deduction_row['edName']; ?>">
                                                <i class="fa fa-check"></i>
                                              </a>
                                            </div>
                                          </div>
                                        </div>
                                      </div>
                                    </div>
                                  </div> 
                                  
                                </td>
                              </tr>
                            <?php endwhile;  ?>
                            <?php while($employee_other_deductions_row = $fetch_employee_other_deductions->fetch_assoc()): ?>
                              <tr class="deduction-type-other">
                                <td><?php echo $employee_other_deductions_row['employeeOtherDeductionName']; ?></td>
                                <td class="deduction-amount">
                                  <?php
                                    $employeeOtherDeductionAmount = $employee_other_deductions_row['employeeOtherDeductionAmount'];
                                    if ($employeeOtherDeductionAmount == 0 || $employeeOtherDeductionAmount == 0.00){
                                      echo '';
                                    } else {
                                      echo number_format($employeeOtherDeductionAmount,2);
                                    }
                                  ?>
                                </td>
                                    </td>
                                    <td align="center" class="actions">
                                        <button class="btn btn-default editbtn" data-toggle="modal" type="button" data-target="#update_modal<?php echo $employee_other_deductions_row['odId']?>" >
                                        <i class="fa-solid fa-pencil" style="color: blue;"></i>
                                      </button>
                                      <a href="employee-details.php?admin_id=<?php echo $admin_id;?>&employeeotherdeductionDelete=<?php echo $employee_other_deductions_row['odId']; ?>" data-toggle="modal" data-target="#confirm-delete<?php echo $employee_other_deductions_row['odId'] ?>">
                                        <i class="fas fa-light fa-trash-can deletebtn"></i>
                                      </a>
                                      <!-- update other deduction modal -->
                                       	<div class="modal fade" id="update_modal<?php echo $employee_other_deductions_row['odId']?>" aria-hidden="true">
                                          <div class="modal-dialog modal-dialog-centered">
                                            <div class="modal-content p-3">
                                              <form method="POST" action="update_employee_other_deductions.php">
                                                <input type="hidden" name="odid" value="<?php echo $employee_other_deductions_row['odId']?>"/>
                                                <input type="hidden" name="id" value="<?php echo $id; ?>"/>
                                                <div class="modal-header bg-primary text-white">
                                                  <h3 class="modal-title text-center m-0">
                                                    Update <?php echo $employee_other_deductions_row['employeeOtherDeductionName']?>
                                                  </h3>
                                                </div>
                                                <div class="modal-body">
                                                  <div class="form-group">
                                                    <label>Enter Amount</label>
                                                    <input type="text" name="other_deduction_amount" value="<?php echo $employee_other_deductions_row['employeeOtherDeductionAmount']?>" class="form-control" required="required"/>
                                                  </div>
                                                </div>
                                                <div class="modal-footer">
                                                  <button name="update" class="btn btn-primary"><span class="glyphicon glyphicon-edit"></span> Update</button>
                                                  <button class="btn btn-secondary ml-2" type="button" data-dismiss="modal"><span class="glyphicon glyphicon-remove"></span> Close</button>
                                                </div>
                                              </form>
                                            </div>
                                          </div>
                                        </div>

                                        	     <!-- delete other deduction modal -->
                                        	<div class="modal fade" id="confirm-delete<?php echo $employee_other_deductions_row['odId'] ?>" tabindex="-1" role="dialog" aria-labelledby="myModalLabel"  aria-hidden="true">
                                                <div class="modal-dialog modal-dialog-centered">
                                                  <div class="modal-content">
                                                    <div class="modal-body text-center font-18">
                                                      <h4 style="padding-top: 30px; margin-bottom:30px; font-weight:bold;">
                                                        Delete this Employee's Other Deduction: <?php echo $employee_other_deductions_row['employeeOtherDeductionName']; ?>?
                                                      </h4>
                                                      <div class="padding-bottom-30 row" style="max-width: 170px; margin: 0 auto">
                                                        <div class="col-6">
                                                          <button type="button" class="btn btn-secondary border-radius-100 btn-block confirmation-btn" data-dismiss="modal">
                                                            <i class="fa fa-times"></i>
                                                          </button>
                                                        </div>
                                                        <div class="col-6">
                                                          <a class="btn btn-primary border-radius-100 btn-block confirmation-btn" href = "employee-details.php?admin_id=<?php echo $admin_id;?>&employeeotherdeductionDelete=<?php echo $employee_other_deductions_row['odId']; ?>">
                                                            <i class="fa fa-check"></i>
                                                          </a>
                                                        </div>
                                                      </div>
                                                    </div>
                                                  </div>
                                                </div>
                                              </div>  
                                        
                                    </td>
                                </tr>
                            <?php endwhile;  ?>
                        </table>

             
                    </div>         
				</div>    
				<div class="card ml-4" style="width: 45%; float:left;">
				     
                    <div class="d-flex justify-content-between align-items-center px-4 py-3" style="background-color: #343a40;">
                        <h4 class="text-light mb-0">Remarks</h4>
                        <button type="button" class="btn btn-primary addbtn" data-toggle="modal" data-target="#add-new-remark">Add New Remark</button>
                    </div>
                     <!-- Employee Remarks Table -->
					<div class="table-responsive">
                      <table id="allowance" class="table table-hover table-bordered">
                      <thead class="table-success">
                        <tr>
                          <th scope="col">Other Deduction Name</th>
                          <th scope="col">Remark</th>
                          <th scope="col" width="250px">Actions</th>
                        </tr>
                      </thead>
                      <?php while($employee_remark_row = $fetch_employee_remark->fetch_assoc()): ?>
                        <tr>
                          <td><?php echo $employee_remark_row['other_deduction_name']; ?></td>
                          <td><?php echo $employee_remark_row['remark_text']; ?></td>
                          <td class="text-center">
                            <!-- Delete button -->
                            <a href="employee-details.php?admin_id=<?php echo $admin_id;?>&employeearemarkDelete=<?php echo $employee_remark_row['id']; ?>" data-toggle="modal" data-target="#confirm-delete<?php echo $employee_remark_row['id'] ?>">
                              <button class="btn btn-danger btn-sm deletebtn" style="font-size:16px;"><i class="fas fa-trash"></i> Delete</button>
                            </a>
                               <!-- Delete Employee's Remark Modal -->
                         
                            <div class="modal fade" id="confirm-delete<?php echo $employee_remark_row['id'] ?>" tabindex="-1" role="dialog" aria-labelledby="myModalLabel"  aria-hidden="true">
                        	<div class="modal-dialog modal-dialog-centered">
                        		<div class="modal-content">
                        			<div class="modal-body text-center font-18">
                        				<h4 style="padding-top: 30px; margin-bottom:30px; font-weight:bold;">
                        					Delete this Employee remark: <?php echo $employee_remark_row['remark_text']; ?>?
                        				</h4>
                        		    <div class="padding-bottom-30 row" style="max-width: 170px; margin: 0 auto">
                        			    <div class="col-6">
                        				    <button type="button" class="btn btn-secondary border-radius-100 btn-block confirmation-btn" data-dismiss="modal">
                        					    <i class="fa fa-times"></i>
                        				    </button>
                        			    </div>
                        			    <div class="col-6">
                        				    <a class="btn btn-primary border-radius-100 btn-block confirmation-btn" href = "employee-details.php?admin_id=<?php echo $admin_id;?>&employeeremarkDelete=<?php echo $employee_remark_row['id']; ?>">
                        					    <i class="fa fa-check"></i>
                        				    </a>
                        			    </div>
                        		    </div>
                        	    </div>
                            </div>
                        </div>
                        </div>  
                          <!-- End Delete Employee's Remark Modal -->   
                            <!-- Edit button -->
                            <button class="btn btn-primary btn-sm editbtn" data-toggle="modal" type="button" data-target="#update_modal<?php echo $employee_remark_row['id'];?>">
                              <i class="fas fa-pencil-alt"></i> Edit
                            </button>
                            <!-- Update Remark Modal -->
                             <div class="modal fade" id="update_modal<?php echo $employee_remark_row['id']?>" aria-hidden="true">
                                <div class="modal-dialog modal-dialog-centered">
                                	<div class="modal-content">
                                		<form method="POST" action="update_remarks.php">
                                          <input type="hidden" name="id" value="<?php echo $employee_remark_row['id']?>"/>
                                          <input type="hidden" name="emp_id" value="<?php echo $employee_remark_row['emp_id']?>"/>
                                			<div style="background: #98FB98;" class="modal-header">
                                				<h3  class="modal-title w-100 text-center">Update Remarks</h3>
                                			</div>
                                			<div style="background:#E0FFFF;" class="modal-body">
                                					
                                					
                                					<div class="form-group">
                                						<label>Remark</label>
                                						<input type="text" name="remark_text" value="<?php echo $employee_remark_row['remark_text']?>" class="form-control" required="required"/>
                                					</div>
                                			</div>
                                			<div style="clear:both;"></div>
                                			<div style="background: #40E0D0;"class="modal-footer d-flex justify-content-center">
                                				<button name="update" class="btn btn-warning"><span class="glyphicon glyphicon-edit"></span> Update</button>
                                				<button class="btn btn-danger ml-2" type="button" data-dismiss="modal"><span class="glyphicon glyphicon-remove"></span> Close</button>
                                			</div>
                                			</div>
                                		</form>
                                	</div>
                                </div>
                          </td>
                          <!-- End Update Remark Modal -->
                                      
                        </tr>
                      <?php endwhile; ?>
                    </table>
                    </div>

                    <!-- Table End -->
                       <!--add remark modal -->
                       	<?php  require_once "modals/add_employee_remark.php"; ?>
                       	 <!--end add remark modal -->
        				</div>
    </section>
  </div>

  <!-- Control Sidebar -->
  <aside class="control-sidebar control-sidebar-dark">
    <!-- Control sidebar content goes here -->
  </aside>
  <!-- /.control-sidebar -->
</div>
<!-- ./wrapper -->
<!-- script component -->
<?php  require_once "components/js/employee_details_script.php"; ?>
<script>
  // get the dropdown element
  var dropdown = document.getElementById("employeeDeductionId");

  // add an event listener to the dropdown
  dropdown.addEventListener("change", function() {
    // check if the selected option is "HDMF Premium"
    if (dropdown.selectedOptions[0].text === "HDMF Premium") {
      // display the additional input box
      document.getElementById("additionalDeduction").style.display = "block";
    } else {
      // hide the additional input box
      document.getElementById("additionalDeduction").style.display = "none";
    }
  });
</script>

<style>
  .employee-info {
    display: flex;
    flex-wrap: nowrap;
    align-items: center;
    justify-content: space-between;
    margin-top: 10px;
    padding: 1rem;
}

.employee-info div{
    text-align: left;
}
</style>
</body>
</html>
