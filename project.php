<?php require_once "controllerUserData.php"; ?>
<?php 
//declare database
$mysqli = new mysqli('bsu-info.tech', 'u455679702_cps', 'OpK3RKh]!h9', 'u455679702_cps') or die(mysqli_error($mysqli));

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
// project delete process
if (isset($_GET['projectDelete'])){
  $project_id = $_GET['projectDelete'];
  $mysqli->query("DELETE FROM project WHERE id=$project_id") or die($mysqli->error());

  $_SESSION['message'] = "Record has been deleted!";
  $_SESSION['msg_type'] = "danger";

  header("location:project.php");
}
//insert project
if(isset($_POST['insertProject'])){
  $project_description= $_POST['project_description'];
   $project_name= $_POST['project_name'];
  $mysqli->query("INSERT INTO project (project_name, project_description) VALUES ('$project_name', '$project_description')") or
  die($mysqli->error);

  header("location:project.php");
}
//edit or update project
	if(ISSET($_POST['update'])){
		$id = $_POST['id'];
		$project_name = $_POST['project_name'];
		$project_description = $_POST['project_description'];
		
		
		mysqli_query($mysqli, "UPDATE project SET project_name='$project_name', project_description='$project_description' WHERE id=$id") or die($mysqli_error());
	

		header("location: project.php");
	}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>CBOO | Project</title>

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
      <li class="nav-item ml-4">
			<button type="button" class="btn btn-block btn-default" data-toggle="modal" data-target="#add-Project">Add Project</button>
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
            <h1 class="m-0">Projects</h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="index.php">Home</a></li>
              <li class="breadcrumb-item active">Projects</li>
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
       
      <!-- Add Project Modal -->
      <div class="modal fade" id="add-Project" tabindex="-1" role="dialog" aria-labelledby="modalLabel" aria-hidden="true">
			  <div class="modal-dialog modal-dialog-centered">
				  <div class="modal-content">
					  <div style="background: #98FB98;" class="modal-header">
						  <h4 class="modal-title w-100 text-center" id="modalLabel">
								  Add New Project
								</h4>
								<button type="button" class="close" data-dismiss="modal" aria-hidden="true">
									  ×
								</button>
							</div>
							<form method="POST">
							  <div class="modal-body">
                  <!-- add Project name-->
                  <div class="form-group">
                    <label>Project Name</label>
                    <input name="project_name" class="form-control" type="text" placeholder="Enter New Project">
                  </div>
                   <div class="form-group">
                    <label>Project Description</label>
                    <input name="project_description" class="form-control" type="text" placeholder="Enter Description Here">
                  </div>
                  
                   
								</div>
								<div class="modal-footer d-flex justify-content-center">
								  <button type="button" class="btn btn-secondary" data-dismiss="modal">
										  Close
										</button>
										<button type="submit" name="insertProject" class="btn btn-primary ml-2">
										    Save
											</button>
										</div>
									</form>	
								</div>
							</div>
						</div>
            <!-- Add Project Modal End-->
            <!-- Project Table Start -->
            <div class="table-responsive">
              <table id="matrix" class="table table-bordered table-striped">
                  <thead class="bg-secondary">
				    <tr>
					    <th class="table-plus datatable text-center">NAME</th>
                        <th class="table-plus datatable text-center">DESCRIPTION</th>
                        <th class="text-center">ACTIONS</th>
					</tr>
				</thead>
				<tbody>
                  <?php
                      require 'conn.php';
                      $query = mysqli_query($conn, "SELECT * FROM `project`") or die($mysqli->error);
                      while($fetch = mysqli_fetch_array($query)){
                  ?>
                  <tr>
                    <td class="text-center"><?php echo $fetch['project_name']?></td>
                    <td ><?php echo $fetch['project_description']?></td>
                    <td class="d-flex justify-content-center">
	
											<a href="project.php?projectDelete=<?php echo $fetch['id']; ?>"data-toggle="modal" data-target = "#confirm-delete<?php echo $fetch['id']; ?>">
												<class class="btn btn-default ml-2 deletebtn" style="color:crimson;"><i class="fas fa-light fa-trash-can"></i></class>
											</a>
    												<button class=" btn btn-default editbtn" data-toggle="modal" type="button" data-target="#update_modal<?php echo $fetch['id']?>" style="margin-left:.5rem;color:blue;">
                                                    <i class="fa-solid fa-pencil"></i>
                                                    </button>
                                                    
                                                    
										<!-- Update project Modal -->
											<div class="modal fade" id="update_modal<?php echo $fetch['id']?>" aria-hidden="true">
											<div class="modal-dialog modal-dialog-centered">
												<div class="modal-content">
													<form method="POST">
														<div style="background: #98FB98;" class="modal-header">
															<h3  class="modal-title w-100 text-center">Update Project Group</h3>
														</div>
														<div style="background:#E0FFFF;" class="modal-body">
																<div class="form-group">
																	<label>Project Name</label>
																	<input type="hidden" name="id" value="<?php echo $fetch['id']?>"/>
																	<input type="text" name="project_name" value="<?php echo $fetch['project_name']?>" class="form-control" required="required"/>
																</div>
																<div class="form-group">
																	<label>Project Description</label>
																	<input type="text" name="project_description" value="<?php echo $fetch['project_description']?>" class="form-control" required="required" />
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
								</div>
										</td>
										<!--Delete Project Confirmation-->
										<div class="modal fade" id="confirm-delete<?php echo$fetch['id'] ?>" tabindex="-1" role="dialog" aria-labelledby="myModalLabel"  aria-hidden="true">
											<div class="modal-dialog modal-dialog-centered">
												<div class="modal-content">
													<div class="modal-body text-center font-18">
														<h4 style="padding-top: 30px; margin-bottom:30px; font-weight:bold;">
															Delete this Project (Name: <?php echo $fetch['project_name']; ?>)?
														</h4>
												<div class="padding-bottom-30 row" style="max-width: 170px; margin: 0 auto">
													<div class="col-6">
														<button type="button" class="btn btn-secondary border-radius-100 btn-block confirmation-btn" data-dismiss="modal">
															<i class="fa fa-times"></i>
														</button>
													</div>
													<div class="col-6">
														<a class="btn btn-primary border-radius-100 btn-block confirmation-btn" href = "project.php?projectDelete=<?php echo $fetch['id']; ?>">
															<i class="fa fa-check"></i>
														</a>
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
  <footer class="main-footer d-flex justify-content-center">
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
