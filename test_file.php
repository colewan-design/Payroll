
<?php 
require_once "controllerUserData.php"; 
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
    header('Location: login.php');
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>CBOO | Dashboard</title>

  <!-- Google Font: Source Sans Pro -->
  <!--  https://fonts.googleapis.com/css?family=Poppins-->
  <link href='https://fonts.googleapis.com/css?family=Roboto' rel='stylesheet'>
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
  </nav>
  <!-- /.navbar -->

  <!-- Main Sidebar Container -->
  <aside class="main-sidebar sidebar-dark-primary elevation-4">
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
            <a href="index.php" class="nav-link active">
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
            <a href="employee_data.php" class="nav-link">
              <i class="nav-icon fas fa-database"></i>
              <p>
                Employee Data
              </p>
            </a>
          </li>
          <li class="nav-item">
            <a href="project.php" class="nav-link">
              <i class="nav-icon fas fa-project-diagram"></i>
              <p>
                Project
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
            <a href="report.php" class="nav-link">
              <i class="nav-icon fas fa-file-alt"></i>
              <p>
                Report
              </p>
            </a>
          </li>
           <li class="nav-item">
            <a href="employee_leave.php" class="nav-link active">
              <i class="nav-icon fas fa-calendar-alt"></i>
              <p>
                Leave
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
                  <p>Incentives</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="deductions.php" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Mandatory Deductions</p>
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
              <i class="nav-icon fas fa-file-invoice"></i>
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
                  <p>Payroll Slips</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="payroll-history.php" class="nav-link active">
                  <i class="far fa-circle nav-icon"></i>
                  <p>History</p>
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
               <li class="nav-item">
                <a href="employee-account.php" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Employee Accounts</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="news-manage.php" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Manage News</p>
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
  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0">Employee Leave Deductions</h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="index.php">Home</a></li>
              <li class="breadcrumb-item active">Employee Leave</li>
            </ol>
          </div><!-- /.col -->
        </div><!-- /.row -->
      </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->

    <?php
       $mysqli = new mysqli('bsu-info.tech', 'u455679702_cps', 'OpK3RKh]!h9', 'u455679702_cps') or die(mysqli_error($mysqli));     
        $result = $mysqli->query("SELECT * FROM data") or die($mysqli->error);
        ?>
    <!-- Main content -->
    <section class="content">
      	<!-- Add New Salary Modal -->
        <div class="modal fade" id="form_modal" tabindex="-1" role="dialog" aria-labelledby="modalLabel" aria-hidden="true">
				  <div class="modal-dialog modal-dialog-centered">
					  <div class="modal-content">
						  <form method="POST" action="save_salary.php">

							  <div style="background: #98FB98;"class="modal-header">
								  <h3 class="modal-title w-100 text-center">Add New Salary</h3>
								</div>
								<div class="modal-body">
										  <div class="form-group">
											  <label>Employee Name</label>
												<input type="text" name="salaryGrade" class="form-control" required="required"/>
											</div>
											
											<div class="form-group">
											  <label>Deduction Amount</label>
												<input type="text" name="salaryAmount" class="form-control" required="required"/>
											</div>
									</div>
									<div style="clear:both;"></div>
									<div class="modal-footer d-flex justify-content-center">
									  <button name="save" class="btn btn-primary"><span class="glyphicon glyphicon-save"></span> Save</button>
										<button class="btn btn-danger ml-2" type="button" data-dismiss="modal"><span class="glyphicon glyphicon-remove"></span> Close</button>
									</div>
								</div>
							</form>
						</div>
					</div>
          <!-- Add New Salary Modal End-->
          <!-- Salary Matrix Table-->
          <div class="table-responsive">
          <table id="matrix" class="table table-bordered table-striped"
     
              
            data-toggle="table"
            data-search="true"
            

  data-pagination="true">
					  <thead>
						  <tr class="tr-class-1 text-center">
							  <th>Employee</th>
                    <th>From</th>
                    <th>To</th>
                    <th>Type</th>	
                    <th>Actions</th>	
								</tr>
								</thead>
							 <?php
                                
                            $result = $mysqli->query("SELECT * FROM payroll_list") or die($mysqli->error);
                            while($row = $result->fetch_assoc()):
                        ?>
                        <tr><!--get employee name using employee id saved in payroll_list table -->
                            <td>
                                <?php $employee_id = $row['emp_id'];
                                    $employee_search_result = $mysqli->query("SELECT * FROM data where id = $employee_id") or die($mysqli->error);
                                    if($employee_res = mysqli_fetch_array($employee_search_result))
                                    {
                                        echo $employee_name = $employee_res['name'];   
                                    }
                                ?>
                            </td>
                            <td><?php echo $row['payroll_from']; ?></td>
                            <td><?php echo $row['payroll_to']; ?></td>
                            <!--print  monthly for 1 print semi for 0-->
                            <td>
                                <?php $payroll_type = $row['payroll_type'];
                                    if ($payroll_type == 1) {
                                        echo 'Monthly';
                                    }
                                    else if ($payroll_type == 0){
                                        echo 'Semi-Monthly';
                                    }
                                ?>
                            </td>
                            <td>
                              <select class="selectpicker ass" data-width="fit" id="xyz">
                                <option value="" disabled selected hidden>Actions</option>
                                <option  class="btn-sm" target="_blank"  value="mpdf.php?edit=<?php echo $row['emp_id']; ?>" data-content = "<i class='fas fa-eye pr-2' aria-hidden='true'></i>VIEW">VIEW</option>
                                <option  class="btn-sm"  value="payslip_download.php?edit=<?php echo $row['emp_id']; ?>" data-content = "<i class='fas fa-sharp fa-solid fa-download pr-2'></i>DOWNLOAD">DOWNLOAD</option>
                                <option  class="btn-sm"  value="payslip_data.php?payslipDelete=<?php echo $row['payroll_id']; ?>" data-content="<i class='fas fa-sharp fa-solid fa-trash pr-2'></i>DELETE">DELETE</option>
                            </select>
                            
                          </td>                      
                        </tr>
                        <?php endwhile;  ?>
							</tbody>
						</table>
         
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
