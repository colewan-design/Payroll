<script>jQuery.noConflict();</script>

<?php 
 require_once "controllerUserData.php";
 $mysqli = new mysqli('bsu-info.tech', 'u455679702_cps', 'OpK3RKh]!h9', 'u455679702_cps') or die(mysqli_error($mysqli));     
 $result = $mysqli->query("SELECT * FROM data") or die($mysqli->error);
 $id = $_GET['edit'];
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

$fres = mysqli_query($mysqli, "SELECT * FROM data WHERE id= '$id'");
if($res = mysqli_fetch_array($fres))
{
$name = $res['name']; 
$position = $res['position']; 
$sg = $res['sg']; 
$step = $res['step']; 
$salary = $res['salary']; 


}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>CBOO | Employee Info</title>

  <!-- Google Font: Source Sans Pro -->
  <link href='https://fonts.googleapis.com/css?family=Inter' rel='stylesheet'>
  <script src="https://kit.fontawesome.com/dd09e290e6.js" crossorigin="anonymous"></script>
  <!-- Font Awesome -->
  <link rel="stylesheet" href="plugins/fontawesome-free/css/all.min.css">
   <!-- Select2 -->
  <link rel="stylesheet" href="plugins/select2/css/select2.min.css">
  <link rel="stylesheet" href="plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css">
  <!-- DataTables -->
  <link rel="stylesheet" href="plugins/datatables-bs4/css/dataTables.bootstrap4.min.css">
  <link rel="stylesheet" href="plugins/datatables-responsive/css/responsive.bootstrap4.min.css">
  <link rel="stylesheet" href="plugins/datatables-buttons/css/buttons.bootstrap4.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="dist/css/adminlte.css">
  <link href="https://unpkg.com/bootstrap-table@1.21.0/dist/bootstrap-table.min.css" rel="stylesheet">
  <script src="https://unpkg.com/bootstrap-table@1.21.0/dist/bootstrap-table.min.js"></script>
  <!-- Selectpicker -->
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-select@1.13.14/dist/css/bootstrap-select.min.css">
  <script src="https://cdn.jsdelivr.net/npm/bootstrap-select@1.13.14/dist/js/bootstrap-select.min.js"></script>
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
        <!-- Sidebar user panel (optional) -->
        <div class="user-panel mt-3 pb-3 mb-3 d-flex">
		<div class="image">
           <?php if($image==NULL)
				{
					echo '<img src = "dist/img/user2-16x160.jpg" class="img-circle elevation-2">';
				} else { echo '<img src="images/'.$image.'" class="img-circle elevation-2">';}?> 
        </div>
          <div class="info">
          <a href="account.php" class="d-block"><?php echo $fetch_info['name']?></a>
        </div>
        </div>
  
        <!-- SidebarSearch Form -->
        <div class="form-inline">
          <div class="input-group" data-widget="sidebar-search">
            <input class="form-control form-control-sidebar" type="search" placeholder="Search" aria-label="Search">
            <div class="input-group-append">
              <button class="btn btn-sidebar">
                <i class="fas fa-search fa-fw"></i>
              </button>
            </div>
          </div>
        </div>
  
        <!-- Sidebar Menu -->
        <nav class="mt-2">
          <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
            <!-- Add icons to the links using the .nav-icon class
                 with font-awesome or any other icon font library -->
            <li class="nav-item">
              <a href="index.php" class="nav-link">
                <i class="nav-icon fas fa-th"></i>
                <p>
                  Dashboard
                </p>
              </a>
            </li>
            <li class="nav-item">
              <a href="employees.php" class="nav-link">
                <i class="nav-icon fas fa-users"></i>
                <p>
                  Employees
                </p>
              </a>
            </li>
			    <li class="nav-item">
            <a href="employee_data.php" class="nav-link active">
              <i class="nav-icon fas fa-database"></i>
              <p>
                Employee Data
              </p>
            </a>
          </li>
            <li class="nav-item">
              <a href="position.php" class="nav-link">
                <i class="nav-icon fas fa-street-view"></i>
                <p>
                  Positions
                </p>
              </a>
            </li>
            <li class="nav-item">
              <a href="salary_matrix.php" class="nav-link">
                <i class="nav-icon fas fa-table"></i>
                <p>
                  Salary Matrix
                </p>
              </a>
            </li>
            <li class="nav-item">
              <a href="#" class="nav-link">
                <i class="nav-icon fas fa-calculator"></i>
                <p>
                  Calculations
                  <i class="right fas fa-angle-left"></i>
                </p>
              </a>
              <ul class="nav nav-treeview">
                <li class="nav-item">
                  <a href="incentives.php" class="nav-link">
                    <i class="far fa-circle nav-icon"></i>
                    <p>Allowance</p>
                  </a>
                </li>
            <li class="nav-item">
              <a href="deductions.php" class="nav-link">
                <i class="far fa-circle nav-icon"></i>
                <p style="font-size: 15px;">Mandatory Deductions</p>
              </a>
            </li>
                <li class="nav-item">
                  <a href="other_deductions.php" class="nav-link">
                    <i class="far fa-circle nav-icon"></i>
                    <p>Other Deductions</p>
                  </a>
                </li>
              </ul>
            </li>
            <li class="nav-item">
              <a href="#" class="nav-link">
                <i class="nav-icon fas fa-file"></i>
                <p>
                  Payslip
                  <i class="fas fa-angle-left right"></i>
                </p>
              </a>
              <ul class="nav nav-treeview">
                <li class="nav-item">
                  <a href="payslips.php" class="nav-link">
                    <i class="far fa-circle nav-icon"></i>
                    <p>Create Payslip</p>
                  </a>
                </li>
                <li class="nav-item">
                  <a href="payslip_data.php" class="nav-link">
                    <i class="far fa-circle nav-icon"></i>
                    <p>Record of Payslips</p>
                  </a>
                </li>
                <li class="nav-item">
                <a href="payroll-history.php" class="nav-link active">
                  <i class="far fa-circle nav-icon"></i>
                  <p>History of Payslips</p>
                </a>
              </li>
              </ul>
            </li>
            <li class="nav-item">
            <a href="#" class="nav-link">
              <i class="nav-icon fas fa-user-secret"></i>
              <p>
                Admin Actions
                <i class="right fas fa-angle-left"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <a href="archive.php" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Archives</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="new_user.php" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>New User</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="change_password.php" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Password</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="user_logs.php" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>User Logs</p>
                </a>
              </li>
            </ul>
          </li>
          </ul>
        </nav>
        <!-- /.sidebar-menu -->
      </div>
      <!-- /.sidebar -->
    </aside>
   
  <!-- Content Wrapper. Contains page content -->
  <div class="card content-wrapper">
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
	      

	?>
    <!-- Main content -->
    <section style="padding:1px;" class="content border">
    <div class="d-flex justify-content-center pb-2" style="padding: 20px; padding-bottom:10px; ;">
                <img src="images/letterhead.png" alt="" width="600" height="150">
            </div>
        <p align="center">Payslip</p>
        <div style="width: 30%; float:left;">
        
        <div class="row">
            <div class="col">
            <?php
        $position_result = mysqli_query($mysqli, "SELECT * FROM data where id = $id");
        if($position_res = mysqli_fetch_array($position_result))
        {
    
        $user_name = $position_res['name'];   
        $user_sg = $position_res['sg'];  
        $user_step = $position_res['step'];  
         
        }
        
        ?>
        <h4 style="padding-left:2rem; white-space: nowrap;">Name: <?php echo $user_name; ?></h4>
            </div>
            <div class="col">
                
            </div>
        </div>
        </div>
        <div style="width: 65%; float:right;">
        <div class="content">
            <div class="row">
               
            </div>
            <div class="row">
            <div class="col">
            <h4>SG: <?php echo $user_sg; ?></h4>
            </div>
            <div class="col">
            <h4>Step: <?php echo $user_step; ?></h4>
            </div>
            </div>
        </div>
        </div>
      <div class=" ml-4" style="width: 30%; float:left;">
			  <div class="d-flex justify-content-center" style="padding-bottom:0px;">
				
        </div>
        
					
         
            <!-- Employee Incentive Table -->
						<div class="table-responsive">
              <table id="allowance" class="table border table-sm table-borderless">
                
                <?php
                $result = $mysqli->query("SELECT * FROM data where id = '$id'") or die($mysqli->error);
                    while($row = $result->fetch_assoc()):
                ?>
                <tr>
                <td>Salary</td>
                <td><?php echo number_format($row['salary'],2); ?></td>				  
                </tr>
                <?php endwhile;  ?>
                <tr>
                <td>PERA</td>
                <td><?php 
                $result_allowance = $mysqli->query("SELECT * FROM employeeallowance WHERE employeeId='$id'") or die($mysqli->error());
                $row_allowance = $result_allowance->fetch_array();
                $pera = $row_allowance['employeeallowanceAmount'];
                    echo number_format($pera,2);
                
                ?></td>				
               	</tr>
               	
                <tr>
                    <td>
                        Gross
                    </td>
                    <td>
                    <?php 
                $result_gross = $mysqli->query("SELECT * FROM payroll_list WHERE emp_id='$id'") or die($mysqli->error());
                $row_gross = $result_gross->fetch_array();
                $gross = $row_gross['gross_amount'];
                    echo number_format($gross,2);
                
                ?>
                    </td>
                </tr>
                <tr>
                    <td>Leave Deduction Amount</td>
                    <td>
                        <?php
                         $result_leave = $mysqli->query("SELECT * from data WHERE id='$id'") or die($mysqli->error);
                       while($leave_rows = mysqli_fetch_array($result_leave)) {
                         $fetched_leave = $leave_rows['leave_deduction'];
                       }
                       echo Number_format($fetched_leave,2);
                        ?>
                        
                    </td>
                </tr>
                <tr>
                    <td>Total Deductions</td>
                    <td>
                    <?php
                    // Get total employeeDeductionAmount from employeedeductions table
$result_deduction = $mysqli->query("SELECT SUM(employeeDeductionAmount) AS total_deduction FROM employeedeductions WHERE employeeId = $id") or die($mysqli->error);
$row_deduction = $result_deduction->fetch_assoc();
$mandatory_total_deduction = $row_deduction['total_deduction'];

// Get total employeeOtherDeductionAmount from employeeotherdeductions table
$result_other_deduction = $mysqli->query("SELECT SUM(employeeOtherDeductionAmount) AS total_other_deduction FROM employeeotherdeductions WHERE employeeId = $id") or die($mysqli->error);
$row_other_deduction = $result_other_deduction->fetch_assoc();
$total_other_deduction = $row_other_deduction['total_other_deduction'];
$total_deduction = ($mandatory_total_deduction + $total_other_deduction);
               ?>
               <?php echo number_format($total_deduction,2);
                ?>
                    </td>
                  
                </tr>
                <tr>
                    <td>Net Amount</td>
                    <td>
                      
                    <?php
                     
                    
                              $net_amount = $gross - $total_deduction;
                              $net_amount_minus_leave = $net_amount - $fetched_leave;
                                  echo number_format($net_amount_minus_leave,2);
                                  ?>
                    </td>
                </tr>
                <tr>
                    <td>Half Month</td>
                    <td><?php
                              $half_month = $net_amount_minus_leave /2;
                                  echo number_format($half_month,2);
                                  ?></td>
                </tr>
                
              </table>
            </div>   
            <!-- Table End -->
					</div>


<div class=" border-top border-right border-left mr-4" style="width: 65%; float:right;">
    <div class="d-flex justify-content-center" >
        <h4 class="text h4">Deductions</h4>
    </div>
    <!-- Employee's Deductions Table -->
    <div class="table-responsive">
      <table class="table border-top border-right border-left table-sm table-borderless">
    <?php
        echo "<tr>";
        $pos = 0;
        $results_per_row = 3; #you can change it to a different value
        $query = "SELECT deductionName FROM deductions UNION SELECT otherDeductionName FROM otherdeductions";
        $result = mysqli_query($conn, $query);
        while($row = mysqli_fetch_array($result)){
            $pos++;
            $col1 = $row['deductionName'];
            echo "<td> $col1 </td>";
            $edname = $col1;
            $employeeId = $id;
            $query2 = "SELECT employeeDeductionAmount FROM employeedeductions
                       WHERE employeeId = $employeeId AND edname = '$edname'";
            $result2 = mysqli_query($conn, $query2);
            if ($row2 = mysqli_fetch_array($result2)) {
                $employeeDeductionAmount = $row2['employeeDeductionAmount'];
               
                if ($employeeDeductionAmount != 0) {
                     echo "<td>$employeeDeductionAmount</td>";
                }
                else{
                    echo "<td></td>";
                }
            } else {
                echo "<td></td>";
            }
            // check for employeeotherdeductions data
            $query3 = "SELECT employeeOtherDeductionAmount FROM employeeotherdeductions
                       WHERE employeeId = $employeeId AND employeeOtherDeductionName = '$edname'";
            $result3 = mysqli_query($conn, $query3);
            if ($row3 = mysqli_fetch_array($result3)) {
                $employeeOtherDeductionAmount = $row3['employeeOtherDeductionAmount'];
             
                if ($employeeOtherDeductionAmount != 0) {
                     echo "<td>$employeeOtherDeductionAmount</td>";
                }
                else{
                    echo "<td></td>";
                }
            } else {
                echo "<td></td>";
            }
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
        <td rowspan="2"><b>Remarks</b></td>
        <td class="border" rowspan="2" colspan="4"></td>
    </tr>
</table>


    </div>         
</div>




    </section>
  </div>
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
<!-- Bootstrap 4 -->
<script src="plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<!-- Select2 -->
<script src="plugins/select2/js/select2.full.min.js"></script>
<!-- AdminLTE App -->
<script src="dist/js/adminlte.min.js"></script>
<!-- AdminLTE for demo purposes -->
<script src="dist/js/demo.js"></script>
<!-- Selectpicker -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-select@1.13.14/dist/css/bootstrap-select.min.css">
  <script src="https://cdn.jsdelivr.net/npm/bootstrap-select@1.13.14/dist/js/bootstrap-select.min.js"></script>
<!-- Page specific script -->
<script>
  $(function () {
    //Initialize Select2 Elements
    $('.select2').select2()

    //Initialize Select2 Elements
    $('.select2bs4').select2({
      theme: 'bootstrap4'
    })
  })  
</script>
<script>
  $(function () {
    $("#allowance").DataTable({
      "responsive": true, "lengthChange": false, "autoWidth": false,
    }).buttons().container().appendTo('#example1_wrapper .col-md-6:eq(0)');
    $('#').DataTable({
      "paging": true,
      "lengthChange": false,
      "searching": false,
      "ordering": true,
      "info": true,
      "autoWidth": false,
      "responsive": true,
    });
  });
</script>
<script>
  $(function () {
    $("#deductions").DataTable({
      "responsive": true, "lengthChange": false, "autoWidth": false,
    }).buttons().container().appendTo('#example1_wrapper .col-md-6:eq(0)');
    $('#example2').DataTable({
      "paging": true,
      "lengthChange": false,
      "searching": false,
      "ordering": true,
      "info": true,
      "autoWidth": false,
      "responsive": true,
    });
  });
</script>
</body>
</html>
