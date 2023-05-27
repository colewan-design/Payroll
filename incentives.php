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

//salary data delete process
if (isset($_GET['allowanceDelete'])){
  $allowanceId = $_GET['allowanceDelete'];
  $mysqli->query("DELETE FROM allowance WHERE allowanceId = '$allowanceId'") or die($mysqli->error());

  header("location:incentives.php");
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>CBOO | Allowance</title>

  <!-- Google Font: Source Sans Pro -->
  <link href='https://fonts.googleapis.com/css?family=Inter' rel='stylesheet'>
  <script src="https://kit.fontawesome.com/dd09e290e6.js" crossorigin="anonymous"></script>
  <!-- Font Awesome -->
  <link rel="stylesheet" href="plugins/fontawesome-free/css/all.min.css">
  <!-- Ionicons -->
  <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
  <!-- Tempusdominus Bootstrap 4 -->
  <link rel="stylesheet" href="plugins/tempusdominus-bootstrap-4/css/tempusdominus-bootstrap-4.min.css">
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
  <!-- Selectpicker -->
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-select@1.13.14/dist/css/bootstrap-select.min.css">
  <script src="https://cdn.jsdelivr.net/npm/bootstrap-select@1.13.14/dist/js/bootstrap-select.min.js"></script>
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
        <button type="button" class="btn btn-block btn-default" data-toggle="modal" data-target="#form_modal"> New Allowance</button>
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
            <h1 class="m-0">Allowance</h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="index.php">Home</a></li>
              <li class="breadcrumb-item">Calculations</li>
              <li class="breadcrumb-item active">Allowance</li>
            </ol>
          </div><!-- /.col -->
        </div><!-- /.row -->
      </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->

    <!-- Main content -->
    <section class="content ml-4 mr-4">
		  <!-- New Incentive Modal -->
			  <div class="modal fade" id="form_modal" tabindex="-1" role="dialog" aria-labelledby="modalLabel" aria-hidden="true">
				  <div class="modal-dialog modal-dialog-centered">
						<div class="modal-content">
							<form method="POST" action="save_incentive.php">
								<div style="background: #98FB98;"class="modal-header">
									<h3 class="modal-title w-100 text-center">Add New Allowance</h3>
								</div>
								<div class="modal-body">
                                      <div class="row">
                                        <div class="col-md-12">
                                          <div class="form-group">
                                            <label>Allowance Name</label>
                                            <input type="text" name="allowanceName" class="form-control" required="required" />
                                          </div>
                                          <div class="form-group">
                                            <label>Description</label>
                                            <input type="text" name="allowanceDescription" class="form-control" required="required" />
                                          </div>
                                          <div class="form-group">
                                            <label>Type</label>
                                            <select class="selectpicker form-control" name="deductionType" id="" style="width: 250px;">
                                              <option value="percentage">Percentage</option>
                                              <option value="real_value">Real Value</option>
                                            </select>
                                          </div>
                                          <div class="form-group">
                                            <label>Amount</label>
                                            <input type="number" name="allowanceAmount" class="form-control" required="required" />
                                          </div>
                                        </div>
                                      </div>
                                    </div>
								
										<div class="modal-footer">
                                          <button type="submit" name="save" class="btn btn-success"><i class="fas fa-save"></i> Save</button>
                                          <button type="button" class="btn btn-secondary" data-dismiss="modal"><i class="fas fa-times"></i> Close</button>
                                        </div>
									</div>
								</form>
							</div>
						</div>
            <!-- New Incentive Modal End -->
            <!-- Incentive Table Start -->
            <div class="table-responsive" style="padding-bottom: 20px;">
							<table id="incentives" class="table table-bordered table-striped">
								<thead class="bg-secondary">
									<tr>
										<th class="table-plus datatable text-center">ALLOWANCE NAME</th>
                    <th class="text-center">DESCRIPTION</th>
										<th class="text-center">AMOUNT</th>
                    <th data-sortable="false" class="text-center">ACTIONS</th>
									</tr>
								</thead>
								<tbody>
                  <?php
                    require 'conn.php';
                    $query = mysqli_query($conn, "SELECT * FROM `allowance`") or die($mysqli_error());
                    while($fetch = mysqli_fetch_array($query)){
                  ?>
                  <tr>
                    <td ><?php echo $fetch['allowanceName']?></td>
                    <td><?php echo $fetch['allowanceDescription']?></td>
                    <td><?php echo number_format($fetch['allowanceAmount'],2)?></td>
                    <td	class="d-flex justify-content-center">
                      <button class=" btn btn-default editbtn" data-toggle="modal" type="button" data-target="#update_modal<?php echo $fetch['allowanceId']?>"style="color:blue;">
                      <i class="fa-solid fa-pencil"></i>
                      </button>
										<!-- Update Incentive Modal -->
											<div class="modal fade" id="update_modal<?php echo $fetch['allowanceId']?>" aria-hidden="true">
                                              <div class="modal-dialog">
                                                <div class="modal-content">
                                                  <form method="POST" action="update_incentive.php">
                                                    <div class="modal-header" style="background-color: #007bff; color: #fff;">
                                                      <h3 class="modal-title w-100 text-center">Update Allowance</h3>
                                                    </div>
                                                    <div class="modal-body">
                                                      <div class="form-group">
                                                        <label for="allowanceName">Allowance Name</label>
                                                        <input type="hidden" name="allowanceId" value="<?php echo $fetch['allowanceId']?>"/>
                                                        <input type="text" name="allowanceName" value="<?php echo $fetch['allowanceName']?>" class="form-control" required="required"/>
                                                      </div>
                                                      <div class="form-group">
                                                        <label for="allowanceDescription">Description</label>
                                                        <input type="text" name="allowanceDescription" value="<?php echo $fetch['allowanceDescription']?>" class="form-control" required="required"/>
                                                      </div>
                                                      <div class="form-group">
                                                        <label for="deductionType">Type</label>
                                                        <select class="form-control" name="deductionType" id="">
                                                          <option value="percentage">Percentage</option>
                                                          <option value="real_value">Real Value</option>
                                                        </select>
                                                      </div> 
                                                      <div class="form-group">
                                                        <label for="allowanceAmount">Amount</label>
                                                        <input type="text" name="allowanceAmount" value="<?php echo $fetch['allowanceAmount']?>" class="form-control" required="required"/>
                                                      </div>
                                                    </div>
                                                    <div class="modal-footer d-flex justify-content-center">
                                                      <button type="submit" name="update" class="btn btn-primary">
                                                        <span class="glyphicon glyphicon-edit"></span> Update
                                                      </button>
                                                      <button type="button" class="btn btn-secondary ml-2" data-dismiss="modal">
                                                        <span class="glyphicon glyphicon-remove"></span> Close
                                                      </button>
                                                    </div>
                                                  </form>
                                                </div>
                                              </div>
                                            </div>

											<a href="incentives.php?allowanceDelete=<?php echo $fetch['allowanceId']; ?>" data-toggle="modal" data-target = "#confirm-delete<?php echo $fetch['allowanceId']; ?>">
												<class style="color:crimson;" class="btn btn-default ml-2 deletebtn"><i class="fas fa-light fa-trash-can"></i></class>
											</a>
										</td>
										<!-- Delete Incentive Modal-->
										<div class="modal fade" id="confirm-delete<?php echo $fetch['allowanceId'] ?>" tabindex="-1" role="dialog" aria-labelledby="myModalLabel"  aria-hidden="true">
											<div class="modal-dialog modal-dialog-centered">
												<div class="modal-content">
													<div class="modal-body text-center font-18">
														<h4 style="padding-top: 30px; margin-bottom:30px; font-weight:bold;">
															Delete this Allowance: <?php echo $fetch['allowanceName'];?>?
														</h4>
														<div class="padding-bottom-30 row" style="max-width: 170px; margin: 0 auto">
														  <div class="col-6">
															  <button type="button" class="btn btn-secondary border-radius-100 btn-block confirmation-btn" data-dismiss="modal">
																  <i class="fa fa-times"></i>
																</button>
															</div>
															<div class="col-6">
																<a class="btn btn-primary border-radius-100 btn-block confirmation-btn" href = "incentives.php?allowanceDelete=<?php echo $fetch['allowanceId']; ?>">
																	<i class="fa fa-check"></i>
																</a>
															</div>
														</div>
													</div>
												</div>
											</div>
										</div>
                    <!-- Delete Modal End -->
                  </tr>
                <?php
                  }
                  ?>
							</tbody>
						</table>
            <!-- Incentives Table End -->
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
<!-- Page specific script -->
<script>
  $(function () {
    $("#incentives").DataTable({
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
