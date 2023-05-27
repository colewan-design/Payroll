
<?php 
require_once "controllerUserData.php";
require 'archive_query.php';
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
    header('Location: login-user.php');
}
//payslip data delete process
if (isset($_GET['payslipDelete'])){
  $payslip_id = $_GET['payslipDelete'];
  $mysqli->query("DELETE FROM payroll_list WHERE payroll_id=$payslip_id") or die($mysqli->error());

  $_SESSION['message'] = "Record has been deleted!";
  $_SESSION['msg_type'] = "danger";

  header("location:payslip_data.php");
}

 ?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>CBOO | Payslip List</title>

  <!-- Google Font: Source Sans Pro -->
  <link href='https://fonts.googleapis.com/css?family=Inter' rel='stylesheet'>
  <!-- Font Awesome -->
  <link rel="stylesheet" href="plugins/fontawesome-free/css/all.min.css">
  <!-- Ionicons -->
  <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
  <!-- Tempusdominus Bootstrap 4 -->
  <link rel="stylesheet" href="plugins/tempusdominus-bootstrap-4/css/tempusdominus-bootstrap-4.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="dist/css/adminlte.css">
  <!-- overlayScrollbars -->
  <link rel="stylesheet" href="plugins/overlayScrollbars/css/OverlayScrollbars.min.css">
  <!-- DataTables -->
  <link rel="stylesheet" href="plugins/datatables-bs4/css/dataTables.bootstrap4.min.css">
  <link rel="stylesheet" href="plugins/datatables-responsive/css/responsive.bootstrap4.min.css">
  <link rel="stylesheet" href="plugins/datatables-buttons/css/buttons.bootstrap4.min.css">
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
      <li class="nav-item">
      <button type="submit" class="btn btn-default ml-4" onclick="location.href='payslips.php'">Create New</button>
      </li>
      <li class="nav-item">
      <button type="submit" class="btn btn-default ml-4" onclick="location.href='export.php'">Export</button>
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
            <h1 class="m-0">Current Payroll Slips</h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="index.php">Home</a></li>
              <li class="breadcrumb-item">Payslip</li>
               <li class="breadcrumb-item"><a href="payslips.php">Add Payslip</a></li>
              <li class="breadcrumb-item active">Payroll List</li>
            </ol>
          </div><!-- /.col -->
        </div><!-- /.row -->
      </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->
    <?php
          
      $result = $mysqli->query("SELECT * FROM data") or die($mysqli->error);
    ?>
    <!-- Main content -->
    <section class="content">
        <div class="card-box mb-30">
            <form>
			    <div style="padding: 20px;">
                    <table id="history" class="table table-bordered table-striped">
                        <thead>
                            <tr>
						        <th>Employee</th>
                                <th>From</th>
                                <th>To</th>
                                <th>Type</th>	
                                <th data-sortable="false">Actions</th>	
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
                              <select name="select"class="selectpicker ass" data-width="fit" id="xyz">
                                <option value="" disabled selected hidden>Actions</option>
                                <option  class="btn-sm" target="_blank"  value="mpdf.php?edit=<?php echo $row['emp_id']; ?>" data-content = "<i class='fas fa-eye pr-2' aria-hidden='true'></i>VIEW">VIEW</option>
                                <option  class="btn-sm"  value="mpdf_download.php?edit=<?php echo $row['emp_id']; ?>" data-content = "<i class='fas fa-sharp fa-solid fa-download pr-2'></i>DOWNLOAD">DOWNLOAD</option>
                                <option  class="btn-sm"  value="payslip_data.php?payslipDelete=<?php echo $row['payroll_id']; ?>" data-content="<i class='fas fa-sharp fa-solid fa-trash pr-2'></i>DELETE">DELETE</option>
                            </select>
                            
                          </td>                      
                        </tr>
                        <?php endwhile;  ?>
                    </table>
				</div>
			</form>
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
</head>
<script>
  $(function () {
    $("#history").DataTable({
        "responsive": true, "lengthChange": false, "autoWidth": false,
        "drawCallback": function() {
            initDropdownMenus();
        }
    });
  });

  function initDropdownMenus() {
    $('.ass').selectpicker({
      size: 4,
      noneSelectedText: 'Actions'
    });

    $('.ass').change(function(){
      var url = $(this).val();
      if (url) {
        window.open(url, '_blank');
      }
    });
  }
</script>
</body>
</html>
