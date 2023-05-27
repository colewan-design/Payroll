<?php 
ini_set('display_errors', 1);
error_reporting(E_ALL);
//imports
require_once "controllerUserData.php"; 
require 'components/authenticate_user.php';//verify user account
require 'components/deduction_delete_process.php';//deduction delete process
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>CBOO | Mandatory Deductions</title>
    <?php  require 'components/js/deductions_pre_content_script.php'; ?>
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

   <!-- pre-loader component-->
    <?php  require 'components/pre-loader.php'; ?>
<!-- end pre-loader component-->
  <!-- Navbar -->
  <nav class="main-header navbar navbar-expand navbar-white navbar-light">
    <!-- Left navbar links -->
    <ul class="navbar-nav">
      <li class="nav-item">
        <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
      </li>
      <li class="nav-item ml-4">
        <button type="button" class="btn btn-block btn-default" data-toggle="modal" data-target="#form_modal"><span class="glyphicon glyphicon-plus"></span>New Deduction</button>
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
            <h1 class="m-0">Mandatory Deductions</h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="index.php">Home</a></li>
              <li class="breadcrumb-item">Calculations</li>
                <li class="breadcrumb-item active">Mandatory Deductions</li>
            </ol>
          </div><!-- /.col -->
        </div><!-- /.row -->
      </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->

    <!-- Main content -->
    <section class="content ml-4 mr-4">
      <!-- Add Deduction Modal -->
      <?php  require 'modals/add_deduction_modal.php'; ?>
      <!-- New Deduction Modal End -->
      
      <!-- Mandatory Deduction Table Start -->
      <div style="padding-bottom: 20px;">
				<table id="deductions" class="table table-bordered table-striped">
					<thead class="bg-secondary">
						<tr>
							<th class="table-plus datatable text-center">DEDUCTION NAME</th>
                            <th scope="col" class="text-center">AMOUNT</th>
                            <th scope="col" class="text-center">TYPE</th>
                            <th scope="col" class="text-center">DESCRIPTION</th>
                            <th scope="col" class="text-center">Min LIMIT</th>
                             <th scope="col" class="text-center">Max LIMIT</th>
                            <th scope="col" data-sortable="false" class="text-center">ACTIONS</th>
						</tr>
					</thead>
					<tbody>
            <?php
              require 'conn.php';
              $query = mysqli_query($conn, "SELECT * FROM `deductions`") or die($mysqli_error());
              while($fetch = mysqli_fetch_array($query)){
            ?>
            <tr>
              <td >
                <?php
                  //if statement(percentage type will print a value that has a percentage sign.)
                  echo $fetch['deductionName']?>
              </td>
              <td>
                <?php 
                  $deduction_type = $fetch['deductionType'];
                  $deductionAmount = $fetch['amount'];
                  if($deduction_type == 'percentage') {
                    echo $deductionAmount . '%';
                  } else{
                       echo number_format($deductionAmount,2);    
                    }
                ?>
              </td>
              <td><?php echo $fetch['deductionType']?></td>										
              <td>
                <?php echo $fetch['description']?></td>
                <td>
                <?php $minDeductionLimit = $fetch['minDeductionLimit'];
                if($minDeductionLimit <= 0){
                    echo 'none';
                    
                }
                else{
                    echo number_format($minDeductionLimit,2);
                }
                ?></td>
                
                <td>
                <?php $maxDeductionLimit = $fetch['maxDeductionLimit'];
                if($maxDeductionLimit <= 0){
                    echo 'none';
                    
                }
                else{
                    echo number_format($maxDeductionLimit,2);
                }
                ?></td>
                
              <td class="d-flex justify-content-center">
								<button class="btn btn-default editbtn" data-toggle="modal" type="button" data-target="#update_modal<?php echo $fetch['deductionId']?>" style="color:blue;">
                <i class="fa-solid fa-pencil"></i>
                </button>
					<!-- Update Mandatory Deduction Modal -->
					 <?php  require 'modals/update_mandatory_deduction_modal.php'; ?>
					<!-- end Update Mandatory Deduction Modal -->
					

					<a href="deductions.php?deductionDelete=<?php echo $fetch['deductionId']; ?>" data-toggle="modal" data-target = "#confirm-delete<?php echo $fetch['deductionId']; ?>">
							<class style="color:crimson;" class="btn btn-default deletebtn ml-2"><i class="fas fa-light fa-trash-can"></i></class>
					</a>

				</td>
              <!-- Delete Mandatory Deduction Modal -->
               <?php  require 'modals/delete_mandatory_deduction_modal.php'; ?>
               <!-- end Delete Mandatory Deduction Modal -->
							
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

<!-- Script -->
<?php  require 'components/js/deductions_script.php'; ?>
<!--end script -->
</body>
</html>
