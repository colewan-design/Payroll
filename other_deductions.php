<?php require_once "controllerUserData.php"; ?>
<?php 
$mysqli = new mysqli('bsu-info.tech', 'u455679702_cps', 'OpK3RKh]!h9', 'u455679702_cps') or die(mysqli_error($mysqli));      
$result = $mysqli->query("SELECT * FROM allowance") or die($mysqli->error);
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
//otherdeduction delete process
if (isset($_GET['otherDeductionDelete'])){
  $otherDeductionId = $_GET['otherDeductionDelete'];
  $mysqli->query("DELETE FROM otherdeductions WHERE otherDeductionId=$otherDeductionId") or die($mysqli->error());

  $_SESSION['message'] = "Record has been deleted!";
  $_SESSION['msg_type'] = "danger";

  header("location:other_deductions.php");
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>CBOO | Other Deductions</title>

  <!-- Google Font: Source Sans Pro -->
  <link href='https://fonts.googleapis.com/css?family=Inter' rel='stylesheet'>
  <script src="https://kit.fontawesome.com/dd09e290e6.js" crossorigin="anonymous"></script>
  <!-- Font Awesome -->
  <link rel="stylesheet" href="plugins/fontawesome-free/css/all.min.css">
  <!-- Ionicons -->
  <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
  <!-- Tempusdominus Bootstrap 4 -->
  <!-- DataTables -->
  <link rel="stylesheet" href="plugins/datatables-bs4/css/dataTables.bootstrap4.min.css">
  <link rel="stylesheet" href="plugins/datatables-responsive/css/responsive.bootstrap4.min.css">
  <link rel="stylesheet" href="plugins/datatables-buttons/css/buttons.bootstrap4.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="dist/css/adminlte.css">
  <!-- overlayScrollbars -->
  <link rel="stylesheet" href="plugins/overlayScrollbars/css/OverlayScrollbars.min.css">
  <!-- Daterange picker -->
  <link rel="stylesheet" href="plugins/daterangepicker/daterangepicker.css">
  <!-- summernote -->
  <link rel="stylesheet" href="plugins/summernote/summernote-bs4.min.css">
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
      <li class="nav-item ml-4">
        <button type="button" class="btn btn-block btn-default" data-toggle="modal" data-target="#form_modal"><span class="glyphicon glyphicon-plus"></span>New Other Deduction</button>
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
  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0">Other Deductions</h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="index.php">Home</a></li>
              <li class="breadcrumb-item">Calculations</li>
                <li class="breadcrumb-item"><a href="incentives.php">Incentives</a></li>
                  <li class="breadcrumb-item"><a href="deductions.php">Deductions</a></li>
                    <li class="breadcrumb-item active">Other Deductions</li>
            </ol>
          </div><!-- /.col -->
        </div><!-- /.row -->
      </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->

    <!-- Main content -->
    <section class="content ml-4 mr-4">
			<!-- New Other Deduction Modal -->
			<div class="modal fade" id="form_modal" tabindex="-1" role="dialog" aria-labelledby="modalLabel" aria-hidden="true">
				<div class="modal-dialog modal-dialog-centered">
					<div class="modal-content">
						<form method="POST" action="save_otherdeductions.php">
							<div style="background: #98FB98;"class="modal-header">
								<h3 class="modal-title w-100 text-center">New Other Deduction</h3>
							</div>
							<div class="modal-body">
								<div class="col-md-2"></div>
									<div class="form-group">
										<label>Deduction Name</label>
											<input type="text" name="otherDeductionName" class="form-control" required="required"/>
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
        <!-- New Other Deduction Modal End -->
        <!-- Other Deduction Table Start -->
        <div style="padding-bottom: 20px;">
					<table id="other-deductions" class="table table-bordered table-striped">
						<thead class="bg-secondary">
							<tr>
								<th class="table-plus datatable text-center">DEDUCTION NAME</th>
                <th data-sortable="false" class="text-center">ACTIONS</th>
							</tr>
						</thead>
						<tbody>
              <?php
                require 'conn.php';
                $query = mysqli_query($conn, "SELECT * FROM `otherdeductions`") or die($mysqli_error());
                while($fetch = mysqli_fetch_array($query)){
              ?>
            <tr>
              <td><?php echo $fetch['otherDeductionName']?></td>
              <td class="d-flex justify-content-center">
							
								<!-- Update Other Deductions Modal -->
								
								<a href="other_deductions.php?otherDeductionDelete=<?php echo $fetch['otherDeductionId']; ?>" data-toggle="modal" data-target = "#confirm-delete<?php echo $fetch['otherDeductionId']; ?>">
									<class style="color:crimson;" class="btn btn-default ml-2 deletebtn"><i class="fas fa-light fa-trash-can"></i></class>
								</a>
							</td>
              <!-- Other Deduction Delete Modal -->
								<div class="modal fade" id="confirm-delete<?php echo$fetch['otherDeductionId'] ?>" tabindex="-1" role="dialog" aria-labelledby="myModalLabel"  aria-hidden="true">
									<div class="modal-dialog modal-dialog-centered">
										<div class="modal-content">
											<div class="modal-body text-center font-18">
												<h4 style="padding-top: 30px; margin-bottom:30px; font-weight:bold;">
													Delete this Deduction: <?php echo $fetch['otherDeductionName'];?>?
												</h4>
												<div class="padding-bottom-30 row" style="max-width: 170px; margin: 0 auto">
													<div class="col-6">
														<button type="button" class="btn btn-secondary border-radius-100 btn-block confirmation-btn" data-dismiss="modal">
															<i class="fa fa-times"></i>
														</button>
													</div>
													<div class="col-6">
														<a class="btn btn-primary border-radius-100 btn-block confirmation-btn" href = "other_deductions.php?otherDeductionDelete=<?php echo $fetch['otherDeductionId']; ?>">
															<i class="fa fa-check"></i>
														</a>
													</div>
												</div>
											</div>
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
    $("#other-deductions").DataTable({
      "responsive": true, "lengthChange": false, "autoWidth": false,"paging":false,
    }).buttons().container().appendTo('#example1_wrapper .col-md-6:eq(0)');
    $('#positions').DataTable({
      "paging": false,
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
