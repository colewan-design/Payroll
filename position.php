<?php 
 require_once "controllerUserData.php";
$mysqli = new mysqli('bsu-info.tech', 'u455679702_cps', 'OpK3RKh]!h9', 'u455679702_cps') or die(mysqli_error($mysqli));      
$result = $mysqli->query("SELECT * FROM data") or die($mysqli->error);
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
//insert position
if(isset($_POST['insertPosition'])){
  $position_name= $_POST['position_name'];
  $project_id= $_POST['project_id'];
  $sg= $_POST['sg'];
  $step= $_POST['step'];
  $mysqli->query("INSERT INTO position (position_name, project_id, sg, step) VALUES ('$position_name', '$project_id', '$sg', '$step')") or
  die($mysqli->error);

  header("location:position.php");
}
//position delete process
if (isset($_GET['positionDelete'])){
  $position_id = $_GET['positionDelete'];
  $mysqli->query("DELETE FROM position WHERE id=$position_id") or die($mysqli->error());

  $_SESSION['message'] = "Record has been deleted!";
  $_SESSION['msg_type'] = "danger";

  header("location:position.php");
}
//edit or update position
	if(ISSET($_POST['update'])){
		$id = $_POST['id'];
		$position_name = $_POST['position_name'];
		$project_id = $_POST['project_id'];
			$sg = $_POST['sg'];
				$step = $_POST['step'];
		
		
		mysqli_query($mysqli, "UPDATE position SET position_name='$position_name', project_id='$project_id', sg='$sg', step='$step' WHERE id=$id") or die($mysqli_error());
	

		header("location: position.php");
	}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>CBOO | Position</title>

  <!-- Google Font: Source Sans Pro -->
  <link href='https://fonts.googleapis.com/css?family=Inter' rel='stylesheet'>
  <script src="https://kit.fontawesome.com/dd09e290e6.js" crossorigin="anonymous"></script>
  <!-- Font Awesome -->
  <link rel="stylesheet" href="plugins/fontawesome-free/css/all.min.css">
  <!-- Ionicons -->
  <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
  <!-- Tempusdominus Bootstrap 4 -->
  <link rel="stylesheet" href="plugins/tempusdominus-bootstrap-4/css/tempusdominus-bootstrap-4.min.css">
  <!-- iCheck -->
  <link rel="stylesheet" href="plugins/icheck-bootstrap/icheck-bootstrap.min.css">
  <!-- JQVMap -->
  <link rel="stylesheet" href="plugins/jqvmap/jqvmap.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="dist/css/adminlte.css">
  <!-- overlayScrollbars -->
  <link rel="stylesheet" href="plugins/overlayScrollbars/css/OverlayScrollbars.min.css">
  <!-- Daterange picker -->
  <link rel="stylesheet" href="plugins/daterangepicker/daterangepicker.css">
  <!-- summernote -->
  <link rel="stylesheet" href="plugins/summernote/summernote-bs4.min.css">
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
			<button type="button" class="btn btn-block btn-default" data-toggle="modal" data-target="#add-Position">Add Position</button>
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
            <h1 class="m-0">Positions</h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="index.php">Home</a></li>
              <li class="breadcrumb-item active">Positions</li>
            </ol>
          </div><!-- /.col -->
        </div><!-- /.row -->
      </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->

    <!-- Main content -->
    <section class="content ml-4 mr-4">
 
      <?php 
				  function pre_r($array){
					  echo '<pre>';
						print_r($array);
						echo '</pre>';
					}
				?>
        <?php 
				  $mysqli = new mysqli('bsu-info.tech', 'u455679702_cps', 'OpK3RKh]!h9', 'u455679702_cps') or die(mysqli_error($mysqli));     
					$result = $mysqli->query("SELECT * FROM position") or die($mysqli->error);
				?>
      <!-- Add Position Modal -->
      <div class="modal fade" id="add-Position" tabindex="-1" role="dialog" aria-labelledby="modalLabel" aria-hidden="true">
			  <div class="modal-dialog modal-dialog-centered">
				  <div class="modal-content">
					  <div style="background: #98FB98;" class="modal-header">
						  <h4 class="modal-title w-100 text-center" id="modalLabel">
								  Add New Position
								</h4>
								<button type="button" class="close" data-dismiss="modal" aria-hidden="true">
									  ×
								</button>
							</div>
							<form method="POST">
							  <div class="modal-body">
                  <!-- add position name-->
                  <div class="form-group">
                    <label>Position Name</label>
                    <input name="position_name" class="form-control" type="text" placeholder="Enter New Position">
                  </div>
                   <!-- add position project-->
                   <div class="form-group">
													
                    <label>Select Project</label>
                    <select name="project_id" class="custom-select" required>
                    <option>Select</option>
                    <?php
                  
                    $resultss = $mysqli->query("SELECT * FROM project") or die($mysqli->error());
                    while ($trow = mysqli_fetch_array($resultss)) {
                      $trows[] = $trow;
                    }
                    foreach ($trows as $trow) {
                      print "<option value='" . $trow['id'] . "'>" . $trow['project_name'] . "</option>";
                    }
                    ?>
                  </select>
                      
                    </div>
                    
                     <div class="form-group">
                            <label>SG</label>
                            <input name="sg" class="form-control" type="text" placeholder="Enter Corresponding SG">
                          </div>
                          
                           <div class="form-group">
                            <label>Step</label>
                            <input name="step" class="form-control" type="text" placeholder="Enter Corresponding STEP">
                          </div>
						</div>
						<div class="modal-footer d-flex justify-content-center">
						  <button type="button" class="btn btn-secondary" data-dismiss="modal">
								  Close
								</button>
								<button type="submit" name="insertPosition" class="btn btn-primary ml-2">
								    Save
									</button>
								</div>
							</form>	
						</div>
					</div>
				</div>
            <!-- Add Position Modal End-->
            
            <!-- Position Table Start -->
            <div class="table-responsive">
            <table id="positions" class="table table-bordered table-striped">
                <thead class="bg-secondary">
                    <tr>
                        <th class="table-plus datatable text-center">NAME</th>
                        <th class="text-center">PROJECT</th>
                         <th class="text-center">SG</th>
                          <th class="text-center">STEP</th>
                        <th data-sortable="false" class="text-center">ACTIONS</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    require 'conn.php';
                    $query = mysqli_query($conn, "SELECT * FROM `position`") or die($mysqli->error);
                    while ($fetch = mysqli_fetch_array($query)) {
                    ?>
                        <tr>
                            <td class="text-center"><?php echo $fetch['position_name'] ?></td>
                            <td class="text-center">
                                <?php
                                $position_project = $fetch['project_id'];
                                $position_project_result = $mysqli->query("SELECT * FROM project where id = $position_project") or die($mysqli->error);
                                $project_res = mysqli_fetch_array($position_project_result);
                                echo $project_res['project_name'];
                                ?>
                            </td>
                            <td class="text-center"><?php echo $fetch['sg'] ?></td>
                            <td class="text-center"><?php echo $fetch['step'] ?></td>
                            <!--actions -->
                            <td class="d-flex justify-content-center">
                                <a href="position.php?positionDelete=<?php echo $fetch['id']; ?>" data-toggle="modal" data-target="#confirm-delete<?php echo $fetch['id']; ?>">
                                    <class class="btn btn-default ml-2 deletebtn" style="color:crimson;"><i class="fas fa-light fa-trash-can"></i></class>
                                </a>
                                <button class=" btn btn-default editbtn ml-2" data-toggle="modal" type="button" data-target="#update_modal<?php echo $fetch['id'] ?>" style="color:blue;">
                                    <i class="fa-solid fa-pencil"></i>
                                </button>
                                <!-- Delete Modal -->
                                    <div class="modal fade" id="confirm-delete<?php echo $fetch['id']; ?>" tabindex="-1" role="dialog" aria-labelledby="confirm-delete-label" aria-hidden="true">
                                      <div class="modal-dialog modal-dialog-centered" role="document">
                                        <div class="modal-content">
                                          <div class="modal-header">
                                            <h5 class="modal-title w-100 text-center" id="confirm-delete-label">Delete Position</h5>
                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                              <span aria-hidden="true">&times;</span>
                                            </button>
                                          </div>
                                          <div class="modal-body d-flex justify-content-center">
                                            Are you sure you want to delete this position?
                                          </div>
                                          <div class="modal-footer d-flex justify-content-center">
                                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                                            <a href="position.php?positionDelete=<?php echo $fetch['id']; ?>" class="btn btn-danger">Delete</a>
                                          </div>
                                        </div>
                                      </div>
                                    </div>
            
                                <!-- Update position Modal -->
                                <div class="modal fade" id="update_modal<?php echo $fetch['id'] ?>" aria-hidden="true">
                                    <div class="modal-dialog modal-dialog-centered">
                                        <div class="modal-content">
                                            <form method="POST">
                                                <div style="background: #98FB98;" class="modal-header">
                                                    <h3 class="modal-title w-100 text-center">Update Project Group</h3>
                                                </div>
                                                <div style="background:#E0FFFF;" class="modal-body">
                                                    <div class="form-group">
                                                        <label>Position Name</label>
                                                        <input type="hidden" name="id" value="<?php echo $fetch['id'] ?>" />
                                                        <input type="text" name="position_name" value="<?php echo $fetch['position_name'] ?>" class="form-control" required="required" />
                                                    </div>
                                                    <div class="form-group">
                                                        <label>Project</label>
                                                        <input type="text" name="project_id" value="<?php echo $fetch['project_id'] ?>" class="form-control" required="required" />
                                                    </div>
                                                     <div class="form-group">
                                                        <label>SG</label>
                                                        <input type="text" name="sg" value="<?php echo $fetch['sg'] ?>" class="form-control" required="required" />
                                                    </div>
                                                     <div class="form-group">
                                                        <label>STEP</label>
                                                        <input type="text" name="step" value="<?php echo $fetch['step'] ?>" class="form-control" required="required" />
                                                    </div>
                                                </div>
                                                <div style="clear:both;"></div>
                                                <div style="background: #40E0D0;" class="modal-footer d-flex justify-content-center">
                                                    <button name="update" class="btn btn-warning"><span class="glyphicon glyphicon-edit"></span> Update</button>
                                                    <button class="btn btn-danger ml-2" type="button" data-dismiss="modal"><span class="glyphicon glyphicon-remove"></span> Close</button>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
            
                            </td>
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
    $("#positions").DataTable({
      "responsive": true, "lengthChange": false, "autoWidth": false,
    }).buttons().container().appendTo('#example1_wrapper .col-md-6:eq(0)');
    $('#').DataTable({
      "paging": true,
      "lengthChange": false,
      "searching":true,
      "ordering": true,
      "info": true,
      "autoWidth": false,
      "responsive": true,
    });
  });
</script>
</body>
</html>
