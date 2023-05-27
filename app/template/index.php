<?php 

ini_set('display_errors', 1);
error_reporting(E_ALL);
session_start();
require_once "controllerUserData.php"; 
$con = new mysqli('bsu-info.tech', 'u455679702_cps', 'OpK3RKh]!h9', 'u455679702_cps') or die(mysqli_error($mysqli));
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


<?php 
  $mysqli = new mysqli('bsu-info.tech', 'u455679702_cps', 'OpK3RKh]!h9', 'u455679702_cps') or die(mysqli_error($mysqli));  

?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    
  <!-- Font Awesome -->
  <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.13.0/css/all.css">

    <!-- Twitter -->
    <meta name="twitter:site" content="@themepixels">
    <meta name="twitter:creator" content="@themepixels">
    <meta name="twitter:card" content="summary_large_image">
    <meta name="twitter:title" content="Slim">
    <meta name="twitter:description" content="Premium Quality and Responsive UI for Dashboard.">
    <meta name="twitter:image" content="http://themepixels.me/slim/img/slim-social.png">

    <!-- Facebook -->
    <meta property="og:url" content="http://themepixels.me/slim">
    <meta property="og:title" content="Slim">
    <meta property="og:description" content="Premium Quality and Responsive UI for Dashboard.">

    <meta property="og:image" content="http://themepixels.me/slim/img/slim-social.png">
    <meta property="og:image:secure_url" content="http://themepixels.me/slim/img/slim-social.png">
    <meta property="og:image:type" content="image/png">
    <meta property="og:image:width" content="1200">
    <meta property="og:image:height" content="600">

    <!-- Meta -->
    <meta name="description" content="Premium Quality and Responsive UI for Dashboard.">
    <meta name="author" content="ThemePixels">

    <title>CBOO | Dashboard</title>

    <!-- vendor css -->
    <link href="lib/font-awesome/css/font-awesome.css" rel="stylesheet">
    <link href="lib/Ionicons/css/ionicons.css" rel="stylesheet">
    <link href="lib/chartist/css/chartist.css" rel="stylesheet">
    <link href="lib/rickshaw/css/rickshaw.min.css" rel="stylesheet">
    <link href="lib/fullcalendar/css/fullcalendar.css" rel="stylesheet">
    <!-- Slim CSS -->
    <link rel="stylesheet" href="../css/slim.css">
<style>
 .ticker {
    overflow: hidden;
  }
  .ticker h3 {
    white-space: nowrap;
    animation: ticker 20s linear infinite;
  }
  @keyframes ticker {
    0% {
      transform: translateX(100%);
    }
    100% {
      transform: translateX(-100%);
    }
  }
</style>
  </head>
  <body class="slim-full-width">
    <div class="slim-header">
      <div class="container">
        <div class="slim-header-left">
          <div class="logged-user">
            <img src="img/bsu.jpg" alt="bsu logo" style="height:45px;width:45px;" class="mr-1"><span><img src="img/cboo.jpg" alt="cboo logo" style="height:45px; width:45px;"></span>
          </div>
        </div><!-- slim-header-left -->
        <!--Header Center-->
        <div class="ticker ml-auto mr-auto">
        <h3 class="h3" id="news-ticker">
  Compensation, Benefits and Other Obligations Office
</h3>

        </div>
        <div class="slim-header-right">
          <div class="dropdown dropdown-c">
            <a href="#" class="logged-user" data-toggle="dropdown">
              <img src="http://via.placeholder.com/500x500" alt="">
              <span><?php echo $fetch_info['name']?></span>
              <i class="fa fa-angle-down"></i>
            </a>
            <div class="dropdown-menu dropdown-menu-right">
              <nav class="nav">
                <a href="#" class="nav-link"><i class="icon ion-person"></i> View Profile</a>
                <a href="#" class="nav-link"><i class="icon ion-forward"></i> Sign Out</a>
              </nav>
            </div><!-- dropdown-menu -->
          </div><!-- dropdown -->
        </div><!-- header-right -->
      </div><!-- container -->
    </div><!-- slim-header -->

    <div class="slim-navbar">
      <div class="container">
        <ul class="nav">
          <li class="nav-item active">
            <a class="nav-link" href="#">
              <i class="icon ion-ios-home-outline"></i>
              <span>Dashboard</span>
            </a>
          </li>
          <li class="nav-item with-sub">
            <a class="nav-link" href="#">
              <i class="icon ion-ios-people"></i>
              <span>Employee</span>
            </a>
            <div class="sub-item">
              <ul>
                <li><a href="#">Employee Table</a></li>
                <li><a href="#">Employee Data</a></li>
              </ul>
            </div><!-- dropdown-menu -->
          </li>
          <li class="nav-item">
            <a class="nav-link" href="#">
              <i class="icon fas fa-regular fa-project-diagram"></i>
              <span>Projects</span>
            </a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="#">
              <i class="icon ion-ios-home-outline"></i>
              <span>Positions</span>
            </a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="#">
              <i class="icon ion-ios-home-outline"></i>
              <span>Matrix</span>
            </a>
          </li>
          <li class="nav-item with-sub">
            <a class="nav-link" href="#">
              <i class="icon ion-ios-book-outline"></i>
              <span>Calculations</span>
            </a>
            <div class="sub-item">
              <ul>
                <li><a href="">Allowance</a></li>
                <li><a href="">Leave Deductions</a></li>
                <li><a href="">Mandatory Deductions</a></li>
                <li><a href="">Other Deductions</a></li>
              </ul>
            </div><!-- dropdown-menu -->
          </li>
          <li class="nav-item with-sub">
            <a class="nav-link" href="#">
              <i class="icon ion-ios-book-outline"></i>
              <span>Slips</span>
            </a>
            <div class="sub-item">
              <ul>
                <li><a href="">Create Slip</a></li>
                <li><a href="">Payslip Records</a></li>
                <li><a href="">Payslip History</a></li>
              </ul>
            </div><!-- dropdown-menu -->
          </li>
          <li class="nav-item">
            <a class="nav-link" href="#">
              <i class="icon ion-ios-home-outline"></i>
              <span>Report</span>
            </a>
          </li>
          <li class="nav-item with-sub">
            <a class="nav-link" href="#">
              <i class="icon ion-ios-book-outline"></i>
              <span>Admin</span>
            </a>
            <div class="sub-item">
              <ul>
                <li><a href="">Archives</a></li>
                <li><a href="">Employee Accounts</a></li>
                <li><a href="">Manage News</a></li>
                <li><a href="">New User</a></li>
                <li><a href="">Password</a></li>
                <li><a href="">User Logs</a></li>
                <li><a href="superadmin/admin_accounts.php">Admin Accounts</a></li>
              </ul>
            </div><!-- dropdown-menu -->
          </li>
        </ul>
      </div><!-- container -->
    </div><!-- slim-navbar -->

    <?php
            
        $result = $mysqli->query("SELECT * FROM data") or die($mysqli->error);
    ?>
    <div class="slim-mainpanel">
      <div class="container">
        <div class="slim-pageheader">
          <ol class="breadcrumb slim-breadcrumb">
            <li class="breadcrumb-item"><a href="#">Home</a></li>
            <li class="breadcrumb-item active" aria-current="page">Dashboard</li>
          </ol>
          <h6 class="slim-pagetitle">Welcome back, <?php echo $fetch_info['name']?></h6>
        </div><!-- slim-pageheader -->

        <div class="card card-dash-one mg-t-20">
          <div class="row no-gutters">
            <div class="col-lg-3">
              <i class="icon ion-ios-analytics-outline"></i>
              <div class="dash-content">
                <label class="tx-primary">Total Employees</label>
                <h2><?php echo mysqli_num_rows($result); ?></h2>
              </div><!-- dash-content -->
            </div><!-- col-3 -->
            <div class="col-lg-3">
              <i class="icon ion-ios-pie-outline"></i>
              <div class="dash-content">
                <label class="tx-success">Total Gross Amount</label>
                <h2>
                  <?php 
						
										 $result = $mysqli->query("SELECT sum(gross_amount) as value_sum from payroll_list") or die($mysqli->error);
										 while($gross_rows = mysqli_fetch_array($result)) {
											$gross_sum = $gross_rows['value_sum'];  
										}
										?>
										<?php echo "₱ ".number_format($gross_sum,2); ?></h2>
              </div><!-- dash-content -->
            </div><!-- col-3 -->
            <div class="col-lg-3">
              <i class="icon ion-ios-stopwatch-outline"></i>
              <div class="dash-content">
                <label class="tx-purple">Total Deductions</label>
                <h2>                
                  <?php
							    
										$result_deduction = $mysqli->query("SELECT sum(employeeDeductionAmount) as value_difference from employeedeductions") or die($mysqli->error);
										while($deduction_rows = mysqli_fetch_array($result_deduction)) {
											$fetched_deduction = $deduction_rows['value_difference'];
										}
										?>
										<?php echo "₱ ".number_format($fetched_deduction,2); ?></h2>
              </div><!-- dash-content -->
            </div><!-- col-3 -->
            <div class="col-lg-3">
              <i class="icon ion-ios-world-outline"></i>
              <div class="dash-content">
                <label class="tx-danger">Total Net Amount</label>
                <h2>                
                  <?php
                    $net_amount = $gross_sum - $fetched_deduction;
										echo "₱ ".number_format($net_amount,2);
										?></h2>
              </div><!-- dash-content -->
            </div><!-- col-3 -->
          </div><!-- row -->
        </div><!-- card -->

        <div class="row">
          <div class="col-md-3">
            <div class="card card-body pd-20 mg-t-10">
                <h6 class="slim-card-title mg-b-20">Most Visited</h6>
                <div class="mg-b-25">
                  <span class="peity-donut" data-peity="{ &quot;fill&quot;: [&quot;#663090&quot;,&quot;#EC1778&quot;,&quot;#5B93D3&quot;], &quot;height&quot;: 200, &quot;width&quot;: &quot;100%&quot; }" style="display: none;">10,5,4</span><svg class="peity" height="200" width="100%"><path d="M 114 0 A 100 100 0 1 1 97.54054097192662 198.63613034027225 L 105.77027048596331 149.31806517013612 A 50 50 0 1 0 114 50" data-value="10" fill="#663090"></path><path d="M 97.54054097192662 198.63613034027225 A 100 100 0 0 1 17.059973406066945 75.45145128592011 L 65.52998670303347 87.72572564296006 A 50 50 0 0 0 105.77027048596331 149.31806517013612" data-value="5" fill="#EC1778"></path><path d="M 17.059973406066945 75.45145128592011 A 100 100 0 0 1 113.99999999999999 0 L 113.99999999999999 50 A 50 50 0 0 0 65.52998670303347 87.72572564296006" data-value="4" fill="#5B93D3"></path></svg>
                </div>
                <div class="d-flex align-items-center">
                  <span class="square-10 bg-purple rounded-circle"></span>
                  <span class="mg-l-10">San Francisco</span>
                  <span class="mg-l-auto tx-lato tx-right">9,212</span>
                </div>
                <div class="d-flex align-items-center mg-t-5">
                  <span class="square-10 bg-pink rounded-circle"></span>
                  <span class="mg-l-10">Los Angeles</span>
                  <span class="mg-l-auto tx-lato tx-right">8,768</span>
                </div>
                <div class="d-flex align-items-center mg-t-5">
                  <span class="square-10 bg-info rounded-circle"></span>
                  <span class="mg-l-10">San Diego</span>
                  <span class="mg-l-auto tx-lato tx-right">8,355</span>
                </div>
              </div>
          </div>
          <div class="col-md-9 pd-10">
            <div class="card pd-25 mr-1">
              <div id="fullCalendar"></div>
            </div>
          </div>
        </div>
      </div><!-- container -->
    </div><!-- slim-mainpanel -->

    <div class="slim-footer">
      <div class="container d-flex justify-content-center">
        <p>CBOO@BSU 2023</p>
      </div><!-- container -->
    </div><!-- slim-footer -->

    <script src="lib/jquery/js/jquery.js"></script>
    <script src="lib/popper.js/js/popper.js"></script>
    <script src="lib/bootstrap/js/bootstrap.js"></script>
    <script src="lib/jquery.cookie/js/jquery.cookie.js"></script>
    <script src="lib/chartist/js/chartist.js"></script>
    <script src="lib/d3/js/d3.js"></script>
    <script src="lib/rickshaw/js/rickshaw.min.js"></script>
    <script src="lib/jquery.sparkline.bower/js/jquery.sparkline.min.js"></script>

    <script src="js/ResizeSensor.js"></script>
    <script src="js/dashboard.js"></script>
    <script src="lib/moment/js/moment.js"></script>
    <script src="lib/fullcalendar/js/fullcalendar.js"></script>
    <script src="js/slim.js"></script>
    <script>
      $(function() {
        'use strict';

        $('#fullCalendar').fullCalendar({
          header: {
            left:   'prev',
            center: 'title',
            right:  'today next'
          }
        });
      });
    </script>

  </body>
</html>
