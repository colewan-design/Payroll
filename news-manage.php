<?php 
 require_once "controllerUserData.php"; 
 $mysqli = new mysqli('bsu-info.tech', 'u455679702_cps', 'OpK3RKh]!h9', 'u455679702_cps') or die(mysqli_error($mysqli));    

$email = $_SESSION['email'];

$password = $_SESSION['password'];
if($email != false && $password != false){
    $sql = "SELECT * FROM usertable WHERE email = '$email'";
    $run_Sql = mysqli_query($mysqli, $sql);
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
    header('Location: login-user.php');
}

if(isset($_POST['submit']))
{
$posttitle=$_POST['posttitle'];

$postdetails=$_POST['postdescription'];
$arr = explode(" ",$posttitle);
$url=implode("-",$arr);
$imgfile=$_FILES["postimage"]["name"];
// get the image extension
$extension = substr($imgfile,strlen($imgfile)-4,strlen($imgfile));
// allowed extensions
$allowed_extensions = array(".jpg","jpeg",".png",".gif");
// Validation for allowed extensions .in_array() function searches an array for a specific value.
if(!in_array($extension,$allowed_extensions))
{
echo "<script>alert('Invalid format. Only jpg / jpeg/ png /gif format allowed');</script>";
}
else
{
//rename the image file
$imgnewfile=md5($imgfile).$extension;
// Code for move image into directory
move_uploaded_file($_FILES["postimage"]["tmp_name"],"postimages/".$imgnewfile);

$status=1;
$query=mysqli_query($mysqli,"insert into tblposts(PostTitle,PostDetails,PostUrl,Is_Active,PostImage) values('$posttitle','$postdetails','$url','$status','$imgnewfile')");
if($query)
{
$msg="Post successfully added ";
}
else{
$error="Something went wrong . Please try again.";    
} 

}
}
// post delete process
if (isset($_GET['postDelete'])){
  $post_id = $_GET['postDelete'];
  $mysqli->query("DELETE FROM tblposts WHERE id=$post_id") or die($mysqli->error());

  $_SESSION['message'] = "Record has been deleted!";
  $_SESSION['msg_type'] = "danger";

  header("location:news-manage.php");
}
//edit or update project
if(ISSET($_POST['update'])){
  $id = $_POST['id'];
  $PostTitle = $_POST['PostTitle'];
  $PostDetails = $_POST['PostDetails'];
  
  
  mysqli_query($mysqli, "UPDATE tblposts SET PostTitle='$PostTitle', PostDetails='$PostDetails' WHERE id=$id") or die($mysqli_error());


  header("location: news-manage.php");
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>CBOO | Manage News</title>

  <!-- Google Font: Source Sans Pro -->
  <!--  https://fonts.googleapis.com/css?family=Poppins-->
  <link href='https://fonts.googleapis.com/css?family=Inter' rel='stylesheet'>
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
  <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.9.4/Chart.js"></script>
  <style>
		body {
			background-image: url("https://example.com/background-image.jpg");
			background-size: cover;
			font-family: Arial, sans-serif;
			color: #333;
			margin: 0;
			padding: 0;
		}

		.container-fluid {
			max-width: 1200px;
			margin: 0 auto;
			padding: 1rem;
		}

		h1 {
			font-size: 2.5rem;
			margin-bottom: 1rem;
			text-align: center;
			color: #fff;
			text-shadow: 2px 2px #333;
		}
    .custom-modal {
      width: 90%;
  max-width: 800px;
  height: 80%;
  max-height: 600px;
}
		form {
			background-color: #fff;
			padding: 2rem;
			border-radius: 10px;
			box-shadow: 0 0 10px #333;
		}

		.form-group label {
			font-weight: bold;
			display: block;
			margin-bottom: 0.5rem;
		}

		.form-control {
			width: 100%;
			padding: 0.5rem;
			font-size: 1rem;
			border: 2px solid #ccc;
			border-radius: 5px;
			margin-bottom: 1rem;
		}

		.form-control:focus {
			outline: none;
			border-color: #333;
		}

		.card-box {
			background-color: #f7f7f7;
			padding: 1rem;
			margin-bottom: 1rem;
			border-radius: 5px;
			box-shadow: 0 0 5px #ccc;
		}

		.btn {
			display: inline-block;
			padding: 0.5rem 1rem;
			font-size: 1rem;
			font-weight: bold;
			color: #fff;
			border: none;
			border-radius: 5px;
			box-shadow: 0 0 5px #333;
			cursor: pointer;
			margin-right: 1rem;
		}
				.btn-content{
			display: inline-block;
			padding: 0.5rem 1rem;
			font-size: 1rem;
			font-weight: bold;
			color: #fff;
			background-color:#90EE90;
			border: none;
			border-radius: 5px;
			box-shadow: 0 0 5px #333;
			cursor: pointer;
			margin-right: 1rem;
		}

		.btn:hover {
			background-color: #666;
		}

		.btn-danger {
			background-color: #d9534f;
			box-shadow: 0 0 5px #d9534f;
		}

		.btn-danger:hover {
			background-color: #c9302c;
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
          <button type="button" class="btn btn-primary btn-content" data-toggle="modal" data-target="#myModal">
            Add News Content
          </button>

          <div class="modal fade" id="myModal" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered custom-modal">
        <div class="modal-content">
            <form class="form" name="addpost" method="post" enctype="multipart/form-data">
                <div style="background: #333;" class="modal-header">
                    <h3 class="modal-title w-100 text-center text-light">Manage News Content</h3>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                </div>
                <div style="background:#f7f7f7;" class="modal-body">
                    <div class="form-group">
                        <label class="font-weight-bold">Post Title</label>
                        <input type="text" class="form-control" id="posttitle" name="posttitle" placeholder="Enter title" required>
                    </div>
                    <div class="form-group">
                        <label class="font-weight-bold">Post Details</label>
                        <textarea class="form-control" name="postdescription" required></textarea>
                    </div>
                    <div class="form-group">
                        <label class="font-weight-bold">Feature Image</label>
                        <div class="custom-file">
                            <input type="file" class="custom-file-input" id="customFile">
                            <input type="file" class="form-control" id="postimage" name="postimage"  required>
                        </div>
                    </div>
                </div>
                <div style="clear:both;"></div>
                <div style="background: #333;" class="modal-footer d-flex justify-content-center">
                    <button type="submit" name="submit" class="btn btn-success"><span class="glyphicon glyphicon-save"></span> Save and Post</button>
                    <button class="btn btn-danger ml-2" type="button" data-dismiss="modal"><span class="glyphicon glyphicon-remove"></span> Discard</button>
                </div>
            </form>
        </div>
    </div>
</div>
          </div><!-- /.col -->
         
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Home</a></li>
              <li class="breadcrumb-item">Manage News</li>
            </ol>
          </div><!-- /.col -->
        </div><!-- /.row -->
          <div class="row mb-2">
               <div class="table-responsive">
               <table id="matrix" class="table table-bordered table-striped">
  <thead class="bg-secondary">
    <tr>
      <th class="table-plus datatable text-center">TITLE</th>
      <th class="table-plus datatable text-center">DETAILS</th>
      <th class="text-center">ACTIONS</th>
    </tr>
  </thead>
  <tbody>
    <?php
    require 'conn.php';
    $query = mysqli_query($conn, "SELECT * FROM `tblposts`") or die($mysqli->error);
    while ($fetch = mysqli_fetch_array($query)) {
    ?>
      <tr>
        <td class="text-center"><?php echo $fetch['PostTitle'] ?></td>
        <td><?php echo $fetch['PostDetails'] ?></td>
        <td class="d-flex justify-content-center">
          <a href="news-manage.php?postDelete=<?php echo $fetch['id']; ?>" data-toggle="modal" data-target="#confirm-delete<?php echo $fetch['id']; ?>">
            <class class="btn btn-default ml-2 deletebtn" style="color:crimson;"><i class="fas fa-light fa-trash-can"></i></class>
          </a>
          <button class="btn btn-default editbtn" data-toggle="modal" type="button" data-target="#update_modal<?php echo $fetch['id'] ?>" style="margin-left:.5rem;color:blue;">
            <i class="fa-solid fa-pencil"></i>
          </button>

          <!-- Update project Modal -->
          <div class="modal fade" id="update_modal<?php echo $fetch['id'] ?>" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered custom-modal">
              <div class="modal-content">
                <form method="POST">
                  <div style="background: #333;" class="modal-header">
                    <h3 class="modal-title w-100 text-center text-light">Update News</h3>
                  </div>
                  <div style="background:#f7f7f7;" class="modal-body">
                    <div class="form-group">
                      <label class="font-weight-bold">Title</label>
                      <input type="hidden" name="id" value="<?php echo $fetch['id'] ?>" />
                      <input type="text" name="PostTitle" value="<?php echo $fetch['PostTitle'] ?>" class="form-control" required="required" />
                    </div>
                    <div class="form-group">
                      <label class="font-weight-bold">Details</label>
                      <textarea name="PostDetails" class="form-control" rows="5" required="required"><?php echo $fetch['PostDetails'] ?></textarea>
                    </div>
                  </div>
                  <div style="clear:both;"></div>
                  <div style="background: #333;" class="modal-footer d-flex justify-content-center">
                    <button name="update" class="btn btn-warning"><span class="glyphicon glyphicon-edit"></span> Update</button>
                    <button class="btn btn-danger ml-2" type="button" data-dismiss="modal"><span class="glyphicon glyphicon-remove"></span> Close</button>
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
															Delete this News (Title: <?php echo $fetch['PostTitle']; ?>)?
														</h4>
												<div class="padding-bottom-30 row" style="max-width: 170px; margin: 0 auto">
													<div class="col-6">
														<button type="button" class="btn btn-secondary border-radius-100 btn-block confirmation-btn" data-dismiss="modal">
															<i class="fa fa-times"></i>
														</button>
													</div>
													<div class="col-6">
														<a class="btn btn-primary border-radius-100 btn-block confirmation-btn" href = "news-manage.php?postDelete=<?php echo $fetch['id']; ?>">
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
        
             </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->

    <?php
       $mysqli = new mysqli('bsu-info.tech', 'u455679702_cps', 'OpK3RKh]!h9', 'u455679702_cps') or die(mysqli_error($mysqli));       
        $result = $mysqli->query("SELECT * FROM data") or die($mysqli->error);
        ?>
    <!-- Main content -->
    <section class="content">
      <div class="container-fluid">
        <!-- Small boxes (Stat box) -->
        
     




        <!-- /.row -->
                  <!-- Logout Modal -->
									<div class="modal fade" id="logout" tabindex="-1" role="dialog" aria-labelledby="myModalLabel"  aria-hidden="true">
									<div class="modal-dialog modal-dialog-centered">
										<div class="modal-content">
											<div class="modal-body text-center font-18">
												<h4 style="padding-top: 30px; margin-bottom:30px; font-weight:bold;">
													LOGOUT?
												</h4>
												<div class="padding-bottom-30 row" style="max-width: 170px; margin: 0 auto">
													<div class="col-6">
														<button type="button" class="btn btn-secondary border-radius-100 btn-block confirmation-btn" data-dismiss="modal">
															<i class="fa fa-times"></i>
														</button>
													</div>
													<div class="col-6">
                            <button type="button" class="btn btn-secondary border-radius-100 btn-block confirmation-btn" onclick="location.href='logout-user.php'"> <!--  onclick="location.href='logout.php?logout=true&admin_id=< echo $admin_id; ?>'" -->
															<i class="fa fa-check"></i>
														</button>
													</div>
												</div>
											</div>
										</div>
									</div>
								</div>
      </div><!-- /.container-fluid -->
    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->
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
<script>
  var input = document.getElementById("customFile");
input.addEventListener("change", function(event) {
  var fileName = event.target.files[0].name;
  var label = document.querySelector('.custom-file-label');
  label.textContent = fileName;
});
</script>
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


