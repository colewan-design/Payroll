<?php require_once "controllerUserData.php";
if(!isset($_SESSION)) { 
	session_start(); 
  }  ?>
<?php 
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
    header('Location: login.php');
}

?>
 <?php
 $mysqli = new mysqli('bsu-info.tech', 'u455679702_cps', 'OpK3RKh]!h9', 'u455679702_cps') or die(mysqli_error($mysqli));     
        $result = $mysqli->query("SELECT * FROM data") or die($mysqli->error);
        
        //employee salary delete process
if (isset($_GET['salaryDelete'])){
  $salaryId = $_GET['salaryDelete'];
  $mysqli->query("DELETE FROM salarydata WHERE id=$salaryId") or die($mysqli->error());

  $_SESSION['message'] = "Record has been deleted!";
  $_SESSION['msg_type'] = "danger";

  header("location:salary_matrix.php");
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>CBOO | Salary Matrix</title>

  <!-- Google Font: Source Sans Pro -->
  <link href='https://fonts.googleapis.com/css?family=Inter' rel='stylesheet'>
  <!-- Font Awesome -->
  <link rel="stylesheet" href="plugins/fontawesome-free/css/all.min.css">
  <script src="https://kit.fontawesome.com/dd09e290e6.js" crossorigin="anonymous"></script>
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
  <!-- DataTables -->
  <link rel="stylesheet" href="plugins/datatables-bs4/css/dataTables.bootstrap4.min.css">
  <link rel="stylesheet" href="plugins/datatables-responsive/css/responsive.bootstrap4.min.css">
  <link rel="stylesheet" href="plugins/datatables-buttons/css/buttons.bootstrap4.min.css">
  <style>
  table.dataTable .sorting:before, 
  table.dataTable .sorting_asc:before {
    content: "▲";
    font-size: 20px;
    color: #3d3d3d;
  }
  
  table.dataTable .sorting_desc:before {
    content: "▼";
    font-size: 20px;
    color: #3d3d3d;
  }
</style>
</head>
<body class="hold-transition sidebar-mini layout-fixed">
<div class="wrapper">

  <!-- Preloader -->
 

  <!-- Navbar -->
  <nav class="main-header navbar navbar-expand navbar-white navbar-light">
    <!-- Left navbar links -->
    <ul class="navbar-nav">
      <li class="nav-item">
        <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
      </li>
      <li class="nav-item ml-4">
			<button type="button" class="btn btn-block btn-default"  data-toggle="modal" data-target="#form_modal">Add New Salary</button>
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
            <a href="account.php" class="d-block"><?php echo $fetch_info['name'] ?></a>
          </div>
      </div>
<?php include 'nav-bar.php'; ?>
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
            <h1 class="m-0">Salary Matrix</h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="index.html">Home</a></li>
              <li class="breadcrumb-item active">Salary Matrix</li>
            </ol>
          </div><!-- /.col -->
        </div><!-- /.row -->
      </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->

    <!-- Main content -->
    <section class="content ml-4 mr-4">
      	<!-- Add New Salary Modal -->
        <div class="modal fade" id="form_modal" tabindex="-1" role="dialog" aria-labelledby="form-modal-label" aria-hidden="true">
          <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
              <form method="POST" action="save_salary.php">
                <div class="modal-header bg-success">
                  <h5 class="modal-title text-white" id="form-modal-label">Add New Salary</h5>
                  <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                  </button>
                </div>
                <div class="modal-body">
                  <div class="form-group">
                    <label for="salaryGrade">Salary Grade</label>
                    <input type="text" name="salaryGrade" id="salaryGrade" class="form-control" required>
                  </div>
                  <div class="form-group">
                    <label for="salaryStep">Step</label>
                    <input type="text" name="salaryStep" id="salaryStep" class="form-control" required>
                  </div>
                  <div class="form-group">
                    <label for="salaryAmount">Salary Amount</label>
                    <input type="text" name="salaryAmount" id="salaryAmount" class="form-control" required>
                  </div>
                </div>
                <div class="modal-footer">
                  <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                  <button type="submit" name="save" class="btn btn-success">Save</button>
                </div>
              </form>
            </div>
          </div>
        </div>

          <!-- Add New Salary Modal End-->
          <!-- Salary Matrix Table-->
          <div class="table-responsive">
          <table id="matrix" class="table table-bordered table-striped">
					  <thead class="bg-secondary">
						  <tr class="tr-class-1 text-center">
							  <th class="table-plus datatable">SALARY GRADE</th>
								  <th>STEP</th>
                  <th>Salary Amount</th>
                    <th data-sortable="false">ACTIONS</th>
								</tr>
								</thead>
								<tbody>
                  <?php
                      require 'conn.php';
                      $query = mysqli_query($conn, "SELECT * FROM `salarydata`") or die($mysqli->error);
                      while($fetch = mysqli_fetch_array($query)){
                  ?>
                  <tr class="tr-class-2 text-center">
                    <td ><?php echo $fetch['salaryGrade']?></td>
                    <td><?php echo $fetch['salaryStep']?></td>
                    <td><?php echo number_format($fetch['salaryAmount'],2)?></td>
                    <td class="d-flex justify-content-center">
										
										<button class=" btn btn-default editbtn" data-toggle="modal" type="button" data-target="#update_modal<?php echo $fetch['id']?>" style="color:blue;">
                    <i class="fa-solid fa-pencil"></i>
                    </button>

										<!-- Update Salary Modal -->
											<div class="modal fade" id="update_modal<?php echo $fetch['id'] ?>" aria-hidden="true">
                                              <div class="modal-dialog modal-dialog-centered">
                                                <div class="modal-content">
                                                  <form method="POST" action="update_query.php">
                                                    <div class="modal-header bg-success">
                                                      <h4 class="modal-title text-center text-white">Update Employee Salary</h4>
                                                      <button type="button" class="close" data-dismiss="modal">&times;</button>
                                                    </div>
                                                    <div class="modal-body bg-light">
                                                      <div class="form-group">
                                                        <label>Salary Grade</label>
                                                        <input type="hidden" name="id" value="<?php echo $fetch['id'] ?>" />
                                                        <input type="text" name="salaryGrade" value="<?php echo $fetch['salaryGrade'] ?>" class="form-control" required="required" />
                                                      </div>
                                                      <div class="form-group">
                                                        <label>Step</label>
                                                        <input type="text" name="salaryStep" value="<?php echo $fetch['salaryStep'] ?>" class="form-control" required="required" />
                                                      </div>
                                                      <div class="form-group">
                                                        <label>Salary Amount</label>
                                                        <input type="text" name="salaryAmount" value="<?php echo $fetch['salaryAmount'] ?>" class="form-control" required="required" />
                                                      </div>
                                                    </div>
                                                    <div class="modal-footer justify-content-center">
                                                      <button name="update" class="btn btn-warning" type="submit"><i class="fas fa-edit"></i> Update</button>
                                                      <button class="btn btn-danger ml-2" type="button" data-dismiss="modal"><i class="fas fa-times"></i> Close</button>
                                                    </div>
                                                  </form>
                                                </div>
                                              </div>
                                            </div>


											<a href="salary_matrix.php?salaryDelete=<?php echo $fetch['id']; ?>"data-toggle="modal" data-target = "#confirm-delete<?php echo $fetch['id']; ?>">
												<class class="btn btn-default ml-2 deletebtn" style="color:crimson;"><i class="fas fa-light fa-trash-can"></i></class>
											</a>
								</div>
										</td>
										<!--Delete Salary Confirmation-->
										<div class="modal fade" id="confirm-delete<?php echo$fetch['id'] ?>" tabindex="-1" role="dialog" aria-labelledby="myModalLabel"  aria-hidden="true">
											<div class="modal-dialog modal-dialog-centered">
												<div class="modal-content">
                                                  <div class="modal-header">
                                                    <h5 class="modal-title w-100 text-center" id="confirm-delete-label">Confirm Deletion</h5>
                                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                      <span aria-hidden="true">&times;</span>
                                                    </button>
                                                  </div>
                                                  <div class="modal-body d-flex justify-content-center">
                                                    <p class="font-weight-bold">
                                                      Are you sure you want to delete this salary (SG: <?php echo $fetch['salaryGrade']; ?>, Step: <?php echo $fetch['salaryStep']; ?>)?
                                                    </p>
                                                  </div>
                                                  <div class="modal-footer d-flex justify-content-center">
                                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                                                    <a class="btn btn-primary" href="salary_matrix.php?salaryDelete=<?php echo $fetch['id']; ?>">Delete</a>
                                                  </div>
                                                </div>
    									    </div>
                                            </tr>
                                             <?php
                                                 }
                                              ?>
                            							</tbody>
                            						</table>
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
<!-- DataTables  & Plugins -->
<script src="plugins/datatables/jquery.dataTables.min.js"></script>
<script src="plugins/datatables-bs4/js/dataTables.bootstrap4.min.js"></script>
<script src="plugins/datatables-responsive/js/dataTables.responsive.min.js"></script>
<script src="plugins/datatables-responsive/js/responsive.bootstrap4.min.js"></script>
<script src="plugins/datatables-buttons/js/dataTables.buttons.min.js"></script>
<script src="plugins/datatables-buttons/js/buttons.bootstrap4.min.js"></script>
<script src="plugins/jszip/jszip.min.js"></script>
<script src="plugins/pdfmake/pdfmake.min.js"></script>
<script src="plugins/pdfmake/vfs_fonts.js"></script>
<script src="plugins/datatables-buttons/js/buttons.html5.min.js"></script>
<script src="plugins/datatables-buttons/js/buttons.print.min.js"></script>
<script src="plugins/datatables-buttons/js/buttons.colVis.min.js"></script>
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
<!-- Page specific script -->
<script>
  $(function () {
    $("#matrix").DataTable({
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
 const salaryGradeInput = document.querySelector('input[name="salaryGrade"]');

salaryGradeInput.addEventListener("blur", function() {
  if (this.value > 33) {
    this.value = 33;
    alert("The maximum value is 33");
  } else if (this.value < 1) {
    this.value = 1;
    alert("The minimum value is 1");
  }
});

const salaryStepInput = document.querySelector('input[name="salaryStep"]');

salaryStepInput.addEventListener("blur", function() {
  if (this.value > 8) {
    this.value = 8;
    alert("The maximum value is 8");
  } else if (this.value < 1) {
    this.value = 1;
    alert("The minimum value is 1");
  }
});
</script>
</body>
</html>
