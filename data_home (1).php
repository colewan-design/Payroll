<?php require_once "controllerUserData.php"; 
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
    require_once "timeout.php";
?>
<?php 
//declare database
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
//delete employee record
if (isset($_GET['delete'])){
    $id = $_GET['delete'];
    $mysqli->query("DELETE FROM data WHERE id=$id") or die($mysqli->error());
    $mysqli->query("DELETE FROM employeedeductions WHERE employeeId=$id") or die($mysqli->error());
    $mysqli->query("DELETE FROM employeeallowance WHERE employeeId=$id") or die($mysqli->error());
    $mysqli->query("DELETE FROM payroll_list WHERE emp_id=$id") or die($mysqli->error());
    $admin_id = $_GET['admin_id'];
    $activity_type = "Delete an employee";

    $time_logged = date("Y-m-d H:i:s",strtotime("now"));
    $mysqli->query("INSERT INTO activity (time_logged, admin_id, activity_type) VALUES ('$time_logged', '$admin_id', '$activity_type')") or
    die($mysqli->error);

    

    header("location:employee_data.php");
}
if (isset($_POST['multipleDelete'])) {
  


  // Loop through the POST array
  foreach ($_POST['delete'] as $employee_id) {
    // Delete the item from the database
    $query = "DELETE FROM data WHERE id = $employee_id";
    mysqli_query($mysqli, $query);
  }

  // Redirect to the page
  header('Location: data_home.php');
  exit;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>CBOO | Employee List</title>

  <!-- Google Font: Source Sans Pro -->
  <link href='https://fonts.googleapis.com/css?family=Inter' rel='stylesheet'>
  <!-- Font Awesome -->
  <link rel="stylesheet" href="plugins/fontawesome-free/css/all.min.css">

  <!-- Theme style -->
  <link rel="stylesheet" href="dist/css/adminlte.css">
  
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
 <!-- Preloader -->
   <div class="preloader flex-column justify-content-center align-items-center">
    <img class="animation__wobble img-circle" src="src/images/bsu.jpg" alt="CBOOlogo" height="90" width="90">
  </div>
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
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-6">
            <h1>List of Employees</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="index.php">Home</a></li>
              <li class="breadcrumb-item"><a href="employees.php">Employees</a></li>
              <li class="breadcrumb-item active">Employee Data</li>
            </ol>
          </div><!-- /.col -->
        </div>
      </div><!-- /.container-fluid -->
    </section>

    <!-- Main content -->
    <section class="content">
        <div style="min-height: 200px;">
		    <div class="card-box">
			   <div class="table-responsive">
  <form method="post" action="">
    <button type="button" class="btn btn-danger multiple-delete" data-toggle="modal" data-target="#confirmDeleteModal">
  Delete Selected
</button>

    <table data-toggle="table"
           data-search="true"
           data-show-columns="false"
           data-show-search-clear-button="true"
           data-search-highlight="true"
           data-show-search-button="true"
           data-show-pagination-switch="true"
           data-show-columns-search="true"
           data-pagination="true">
      <thead>
        <tr class="tr-class-1 text-center">
          <th data-field="selectAll_checkbox" rowspan="2" data-valign="middle">
  <label for="select_all">Select/Select All</label><br>
  <input type="checkbox" name="select_all" id="select_all" onchange="selectAllCheckboxes(this)" style="padding-right: 5px;">
</th>

         
          <th colspan="2">ACTIONS</th>
        </tr>
        <tr class="tr-class-2 text-center">
          <th data-field="info">INFO</th>

          <th data-field="delete">DELETE</th>
        </tr>
      </thead>
      <tbody>
        <?php
        $result = $mysqli->query("SELECT * FROM data") or die($mysqli->error);
        while($row = $result->fetch_assoc()):
        ?>
        <tr>
          <td>
              <label class="checkbox-container">
                <input type="checkbox" name="delete[]" value="<?php echo $row['id']; ?>">
                <span class="checkmark"></span>
              </label>
              
               <a href="employee-pay.php?edit=<?php echo $row['id']; ?>"><?php echo $row['name']; ?></a>
            </td>
         
          <td>
            <div class="d-flex justify-content-center">
              <a href="employee-details.php?id=<?php echo $row['id']; ?>"><i class='fas fa-info-circle' aria-hidden='true'></i></a>
            </div>
          </td>
          
          <td>
            <div class="d-flex justify-content-center">
              <a href="data_home.php?delete=<?php echo $row['id']; ?>" data-toggle="modal" data-target="#confirm-delete<?php echo $row['id'] ?>"><i class='fas fa-trash' aria-hidden='true'></i></a>
            </div>
                                  <!--The modal -->
                                  <div class="modal fade" id="confirm-delete<?php echo $row['id'] ?>" tabindex="-1" role="dialog" aria-labelledby="myModalLabel"  aria-hidden="true">
                                  <div class="modal-dialog modal-dialog-centered">
                                    <div class="modal-content">
                                      <div class="modal-body text-center font-18">
                                        <h4 style="padding-top: 30px; margin-bottom:30px; font-weight:bold;">
                                          Delete this Employee: <?php echo $row['name']; ?>?
                                        </h4>
                                        <div class="padding-bottom-30 row" style="max-width: 170px; margin: 0 auto">
                                          <div class="col-6">
                                            <button type="button" class="btn btn-secondary border-radius-100 btn-block confirmation-btn" data-dismiss="modal">
                                              <i class="fa fa-times"></i>
                                            </button>
                                          </div>
                                          <div class="col-6">
                                            <a class="btn btn-primary border-radius-100 btn-block confirmation-btn" href = "data_home.php?delete=<?php echo $row['id']; ?>">
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
                            <div class="modal fade" id="confirmDeleteModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                          <div class="modal-dialog modal-dialog-centered" role="document">
                            <div class="modal-content">
                              <div class="modal-header">
                                <h5 class="modal-title w-100 text-center" id="exampleModalLabel">Confirm Delete</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                  <span aria-hidden="true">&times;</span>
                                </button>
                              </div>
                              <div class="modal-body text-center">
                                Are you sure you want to delete the selected items?
                              </div>
                              <div class="modal-footer d-flex justify-content-center">
                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                                <form method="post">
                                  <button type="submit" class="btn btn-danger" name="multipleDelete">Delete</button>
                                </form>
                              </div>
                            </div>
                          </div>
                        </div>
                        </tbody>
                    </table>
                      
                    </form>
			</div>
		</div>
	</div>
</section>
  </div>
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
<!-- Page specific script -->


<link href="https://unpkg.com/bootstrap-table@1.21.0/dist/bootstrap-table.min.css" rel="stylesheet">

<script src="https://unpkg.com/bootstrap-table@1.21.0/dist/bootstrap-table.min.js"></script>
<script>
function selectAllCheckboxes(source) {
  checkboxes = document.getElementsByName('delete[]');
  for(var i=0, n=checkboxes.length;i<n;i++) {
    checkboxes[i].checked = source.checked;
  }
}
</script>

	<style>

  
  .checkbox-container {
  display: inline-block;
  position: relative;
  padding-left: 25px;
  margin-right: 10px;
  margin-bottom: 5px;
  cursor: pointer;
  font-size: 16px;
  user-select: none;
}

.checkbox-container input {
  position: absolute;
  opacity: 0;
  cursor: pointer;
}

.checkmark {
  position: absolute;
  top: 0;
  left: 0;
  height: 18px;
  width: 18px;
  background-color: #fff;
  border: 1px solid #ccc;
  border-radius: 2px;
}

.checkbox-container:hover input ~ .checkmark {
  background-color: #f5f5f5;
}

.checkbox-container input:checked ~ .checkmark {
  background-color: #2196f3;
  border: none;
}

.checkmark:after {
  content: "";
  position: absolute;
  display: none;
}

.checkbox-container input:checked ~ .checkmark:after {
  display: block;
}

.checkbox-container .checkmark:after {
  left: 6px;
  top: 2px;
  width: 5px;
  height: 10px;
  border: solid #fff;
  border-width: 0 3px 3px 0;
  transform: rotate(45deg);
}


	</style>
</body>
</html>
