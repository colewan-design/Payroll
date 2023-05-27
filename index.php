
<?php 

ini_set('display_errors', 1);
error_reporting(E_ALL);
session_start();
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
 
<!-- Auto logout script -->
	<script>
	    var mouseTimer;
	    function resetMouseTimer() {
	        clearTimeout(mouseTimer);
	        mouseTimer = setTimeout(function() {
	            document.cookie = "PHPSESSID=; expires=Thu, 01 Jan 1970 00:00:00 UTC; path=/;";
	            window.location.href = "https://cps.bsu-info.tech/login.php?logout=true";
	        }, 150000); // 15 seconds
	    }
	    resetMouseTimer();
	    window.addEventListener('mousemove', resetMouseTimer);
	</script>

  <title>CBOO | Dashboard</title>

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
    <!-- chart js -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.9.4/Chart.js"></script>
    <style>
.logout-icon {
  color: #fff; /* set the initial color */
  animation: blink 5s infinite; /* use the "blink" animation */
}

.logout-text {
  color: #fff; /* set the initial color */
  animation: blink 4s infinite; /* use the "blink" animation */
}

@keyframes blink {
  0% {
    color: #fff; /* set the color to white */
  }
  50% {
    color: #f00; /* set the color to red */
  }
  100% {
    color: #fff; /* set the color back to white */
  }
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
   <!-- Preloader -->
 <div class="preloader flex-column justify-content-center align-items-center">
  <img class="animation__wobble img-circle" src="src/images/bsu.jpg" alt="CBOOlogo" height="90" width="90" style="border-radius:50%;">
</div>

  <!-- Right navbar links -->
  <ul class="navbar-nav ml-auto">
      <li class="nav-item">
  <a class="nav-link" href="#" role="button" data-toggle="modal" data-target="#pdfViewerModal">
    <i class="fas fa-file-pdf"></i>
    <span style="font-size: 16px; font-weight: bold;">User Guide</span>
  </a>
</li>
    <li class="nav-item">
      <a class="nav-link" href="#" role="button" data-toggle="modal" data-target = "#logout">
        <i class="fas fa-regular fa-right-from-bracket logou-icon"></i>
        <span style="font-size: 16px; font-weight: bold;" class="logout-text">LOGOUT</span>
      </a>
    </li>
    
  </ul>
</nav>
<!-- /.navbar -->
  <!-- Navbar -->
  <!-- PDF Viewer Modal -->
  <div class="modal fade" id="pdfViewerModal" tabindex="-1" role="dialog" aria-labelledby="pdfViewerModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="pdfViewerModalLabel">PDF Viewer</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <iframe src="/Users-Guide.pdf" width="100%" height="600px"></iframe>
        </div>
      </div>
    </div>
  </div>

<!-- Main Sidebar Container -->
<aside class="main-sidebar sidebar-dark-olive elevation-4">
  <!-- Brand Logo -->
  <a href="home.php?email=<?php echo $email; ?>" class="brand-link">
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
             <!-- Pay period information -->
<div class="pay-period d-flex justify-content-center">
  <h4 class="font-weight-bold mb-0">Payroll Period: </h4>
  <h4 class="font-weight-bold mb-0 ml-1"><?php 
  // Get the current date and time
$currentDateTime = new DateTime();

// Create a new DateTime object for the first date of the month
$firstDateOfMonth = new DateTime($currentDateTime->format('Y-m-1'));

// Create a new DateTime object for the last date of the month
$lastDateOfMonth = new DateTime($currentDateTime->format('Y-m-t'));

// Format the dates in the desired format (e.g. YYYY-MM-DD)
$payPeriodStartDate = $firstDateOfMonth->format('Y-m-d');
$payPeriodEndDate = $lastDateOfMonth->format('Y-m-d');

  echo " ". $payPeriodStartDate ?> to <?php echo $payPeriodEndDate ?></h4>
</div>
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
        <div class="row">
          <div class="col-lg-3 col-6">
            <!-- small box -->
            <div class="small-box bg-info">
              <div class="inner">
                <h4><?php echo mysqli_num_rows($result); ?></h4>
                <p>Total Employees</p>
              </div>
              <div class="icon">
                <i class="fas fa-solid fa-users"></i>
              </div>
            </div>
          </div>
          <!-- ./col -->
          <div class="col-lg-3 col-6">
            <!-- small box -->
            <div class="small-box bg-success">
              <div class="inner">
                <h4>
                <?php
						//loans and tax
					$loansAndTax_result = $mysqli->query("SELECT sum(employeeDeductionAmount) as mandatory_sum from employeedeductions") or die($mysqli->error);
				while($loansAndTax_rows = mysqli_fetch_array($loansAndTax_result)) {
					$loansAndTax = $loansAndTax_rows['mandatory_sum'];
				}
				//other deductions
			    	$other_result = $mysqli->query("SELECT sum(employeeOtherDeductionAmount) as other_sum from employeeotherdeductions") or die($mysqli->error);
				while($other_rows = mysqli_fetch_array($other_result)) {
					$other = $other_rows['other_sum'];
				}
				
				
				$result_deduction = $mysqli->query("SELECT sum(employeeDeductionAmount) as value_difference from employeedeductions") or die($mysqli->error);
				while($deduction_rows = mysqli_fetch_array($result_deduction)) {
					$fetched_deduction = $deduction_rows['value_difference'];
				}
					$leave_deduction = $mysqli->query("SELECT sum(leave_deduction) as leave_sum from data") or die($mysqli->error);
				while($leave_rows = mysqli_fetch_array($leave_deduction)) {
					$fetched_leave = $leave_rows['leave_sum'];
				}
				?>
					<?php 
						 $fetched_deduction = $fetched_deduction + $fetched_leave + $other;
					echo "₱ ".number_format($fetched_deduction,2); ?>
                </h4>

                <p>Total Deductions</p>
              </div>
              <div class="icon">
                <i class="fas fa-solid fa-user-minus"></i>
              </div>
            </div>
          </div>
          <!-- ./col -->
          <div class="col-lg-3 col-6">
            <!-- small box -->
            <div class="small-box bg-warning">
             <div class="inner">
                    <h4>
                        <?php 
                        $result = $mysqli->query("SELECT sum(gross_amount) as value_sum from payroll_list") or die($mysqli->error);
                        while($gross_rows = mysqli_fetch_array($result)) {
                            $gross_sum = $gross_rows['value_sum'];  
                        }
                        ?>
                        <?php echo $gross_sum ? "₱ " . number_format($gross_sum, 2) : "N/A"; ?>
                    </h4>
                    <p>Total Gross Amount</p>
                </div>

              <div class="icon">
                <i class="fas fa-solid fa-user-plus"></i>
              </div>
            </div>
          </div>
          <!-- ./col -->
          <div class="col-lg-3 col-6">
            <!-- small box -->
            <div class="small-box bg-secondary">
              <div class="inner">
                <h4>
                <?php
                $net_amount = $gross_sum - $fetched_deduction;
						echo "₱ ".number_format($net_amount,2);
						 $yValues = array($gross_sum, $net_amount, $fetched_deduction);
						?>
                </h4>

                <p>Total Net Amount</p>
              </div>
              <div class="icon">
                <i class="fas fa-solid fa-equals"></i>
              </div>
            </div>
          </div>
          <!-- ./col -->
        <!--Charts-->
       <div class="container">
  <div class="row">
    <div class="col-md-6">
      <div class="card">
        <div class="card-body">
          <canvas id="myChart"></canvas>
        </div>
      </div>
    </div>

    <div class="col-md-6">
      <div class="card">
        <div class="card-body">
          <canvas id="myChart2"></canvas>
        </div>
      </div>
    </div>
  </div>
</div>

<script>
  // Data for the first chart
  const chartData1 = {
    labels: ["Total Gross Amount", "Net Amount", "Total Deduction"],
    datasets: [{
      backgroundColor: ["#b91d47", "#00aba9", "#2b5797"],
      data: <?php echo json_encode($yValues) ?>
    }]
  };

  // Options for the first chart
  const chartOptions1 = {
    title: {
      display: true,
      text: "Payroll Pie chart"
    }
  };

  // Create the first chart
  const ctx1 = document.getElementById('myChart').getContext('2d');
  const myChart1 = new Chart(ctx1, {
    type: 'pie',
    data: chartData1,
    options: chartOptions1
  });

  // Data for the second chart
  const chartData2 = {
    labels: ["Mandatory Deductions", "Leave", "Other"],
    datasets: [{
      label: "Deductions",
      data: [<?php echo $loansAndTax; ?>, <?php echo $fetched_leave; ?>, <?php echo $other; ?>],
      backgroundColor: ["#f7464a", "#46bfbd", "#fdb45c"]
    }]
  };

  // Options for the second chart
  const chartOptions2 = {
    scales: {
      yAxes: [{
        stacked: true
      }]
    }
  };

  // Create the second chart
  const ctx2 = document.getElementById('myChart2').getContext('2d');
  const myChart2 = new Chart(ctx2, {
    type: 'bar',
    data: chartData2,
    options: chartOptions2
  });
</script>
        </div>

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
<style>
  .pay-period {
  background-color: #f8f9fa;
  border: 1px solid #dee2e6;
  border-radius: 0.25rem;
  padding: 0.75rem 1.25rem;
}

.pay-period h3 {
  margin: 0;
  color: #343a40;
}


</style>
<script>
    // Get the URL of the current page
    var url = window.location.href;

    // Get all the links in the navbar
    var links = document.querySelectorAll('.nav-link');

    // Loop through the links and set the active class for the current page's link
    for(var i = 0; i < links.length; i++) {
        var link = links[i];
        var linkUrl = link.href;

        // Compare the link URL with the current page's URL
        if(url.indexOf(linkUrl) !== -1) {
            link.classList.add('active');
        }
    }
</script>

</body>
</html>
