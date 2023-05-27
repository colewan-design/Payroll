<?php require_once "controllerUserData.php"; ?>
<?php 
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

?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>CBOO | Payroll Report</title>

  <!-- Google Font: Source Sans Pro -->
  <link href='https://fonts.googleapis.com/css?family=Inter' rel='stylesheet'>
  <!-- Font Awesome -->
  <link rel="stylesheet" href="plugins/fontawesome-free/css/all.min.css">

  <!-- Theme style -->
  <link rel="stylesheet" href="dist/css/adminlte.css">
  <style>
      .preloader {
  position: fixed;
  left: 0;
  top: 0;
  width: 100%;
  height: 100%;
  z-index: 9999;
  background-color: #ffffff;
}

.loader {
  border: 5px solid #f3f3f3;
  border-top: 5px solid #3498db;
  border-radius: 50%;
  width: 50px;
  height: 50px;
  animation: spin 2s linear infinite;
  position: absolute;
  top: 50%;
  left: 50%;
  margin-top: -25px;
  margin-left: -25px;
}

@keyframes spin {
  0% { transform: rotate(0deg); }
  100% { transform: rotate(360deg); }
}
  </style>
</head> 
<body class="hold-transition sidebar-mini">
<div class="wrapper">
<div class="preloader">
  <div class="loader"></div>
</div>
  <!-- Navbar -->
  <nav class="main-header navbar navbar-expand navbar-white navbar-light">
    <!-- Left navbar links -->
    <ul class="navbar-nav">
      <li class="nav-item">
        <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
      </li>
      
      <li class="nav-item">
      <button type="submit" class="btn btn-default ml-4" onclick="location.href='payroll_mpdf.php'">Print</button>
      <button type="submit" class="btn btn-default ml-4" onclick="location.href='report_excel.php'">Generate Excel</button>
     
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
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-6">
            <h1>Payroll Report</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="index.php">Home</a></li>
              <li class="breadcrumb-item"><a href="employees.php">Employees</a></li>
              <li class="breadcrumb-item active">Report</li>
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
				    <table
            id="table"
  data-toggle="table"
  data-search="true"
  data-show-search-clear-button="true"
  data-search-highlight="true"
  data-show-search-button="true"

  data-show-columns-search="true"
  data-multiple-select-row="true"
  data-click-to-select="true"
  data-pagination="true"
  data-show-columns="true"
  data-show-columns-toggle-all="true"
  data-visible-search="true">
                        <thead>
                            <tr class="tr-class-1 text-center">
                                <th data-field="name" rowspan="2" data-valign="middle">EMPLOYEE NAME</th>
                                 <th data-field="position" rowspan="2" data-valign="middle">Position</th>
                                  <th data-field="sg" rowspan="2" data-valign="middle">SG</th>
                                   <th data-field="step" rowspan="2" data-valign="middle">STEP</th>
                                         <th data-field="leave" rowspan="2" data-valign="middle">Leave Deduction</th>
                                <th colspan="3">Compensations</th>
                                <th colspan="28">Deduction</th>
                                
                                <th data-field="total_deduction" rowspan="2" data-valign="middle">Total Deductions</th>
                                <th data-field="net_amount" rowspan="2" data-valign="middle">Net Amount Due</th>
                                <?php
                                  $current_month = date('F'); 
                                $current_year = date('Y');
                                $days_in_month = date('t');
                                $first_half = $current_month . " 1-" . (int)($days_in_month/2) . " " . $current_year;
                                $second_half = $current_month . " " . ((int)($days_in_month/2)+1) . "-" . $days_in_month . " " . $current_year;
                                ?>

                               <th data-field="first_half_date" rowspan="2" data-valign="middle">NET AMOUNT FOR <?php echo $first_half; ?></th>
                                <th data-field="second_half_date" rowspan="2" data-valign="middle">NET AMOUNT FOR <?php echo $second_half; ?></th>
                                <th data-field="net_date" rowspan="2" data-valign="middle">Remarks</th>
                           
                            </tr>
                            <tr class="tr-class-2 text-center">
                                <th data-field="salary">Basic Salary</th><!--1-->
                                <th data-field="pera">Pera</th><!--2-->
                                <th data-field="gross">Gross Amount</th><!--3-->
                                <th data-field="Withholding">Withholding Tax</th><!--1-->
                                <th data-field="GSIS">GSIS Premium</th><!--2-->
                                <th data-field="gcl">GSIS Conso Loan</th><!--3-->
                                <th data-field="gpl">GSIS Policy Loan</th><!--4-->
                                <th data-field="eal">GSIS EAL</th><!--5-->
                                <th data-field="gel">GSIS Emergency Loan</th><!--6-->
                                <th data-field="gre">GSIS Real Estate</th><!--7-->
                                <th data-field="gol">GSIS Opt Loan</th><!--8-->
                                <th data-field="ouli">GSIS OULI</th><!--9-->
                                <th data-field="gsismpl">GSIS MPL</th><!--10-->
                                <th data-field="cpl">GSIS CPL</th><!--11-->
                                <th data-field="gfallii">GSIS GFAL II</th><!--12-->
                                <th data-field="Philhealth">Philhealth</th><!--13-->
                                <th data-field="HDMF">HDMF Premium</th><!--14-->
                                <th data-field="HDMFMPL">HDMF MPL</th><!--15-->
                                <th data-field="HDMFCPL">HDMF CL</th><!--16-->
                                <th data-field="BSUCMPC">BSUCMPC</th><!--17-->
                                <th data-field="cbs">China Bank Savings</th><!--18-->
                                <th data-field="Landbank">Landbank</th><!--19-->
                                <th data-field="bhr">BSU Housing Rent</th><!--20-->
                                <th data-field="UCPBS">UCPBS</th><!--21-->
                                <th data-field="pl">Phil life</th><!--22-->
                                <th data-field="coco">Coco</th><!--23-->
                                <th data-field="pa">Phil Am</th><!--24-->
                                <th data-field="PPSTA">PPSTA</th><!--25-->
                                <th data-field="Water">Water</th><!--26-->
                                <th data-field="Electric">Electric</th><!--27-->
                                <th data-field="COA">COA-ND</th><!--28-->
                            </tr>
                           
                        </thead>
                        <tbody>
                            <?php
                            //employee other deductions
                               function get_employee_other_deduction($mysqli, $employee_id, $deduction_name) {
                                    $deduction_name = trim($deduction_name);
                                    $query = "SELECT * FROM employeeotherdeductions WHERE employeeId=$employee_id AND employeeOtherDeductionName='$deduction_name';";
                                    //echo $query; // debug statement
                                    $result = $mysqli->query($query) or die($mysqli->error());
                                    $row = $result->fetch_array();
                                    return isset($row['employeeOtherDeductionAmount']) ? $row['employeeOtherDeductionAmount'] : 0;
                                }
                                //employee deductions
                                function getEmployeeDeduction($mysqli, $employee_id, $deduction_name) {
                                $result = $mysqli->query("SELECT * FROM employeedeductions WHERE employeeId=$employee_id AND edName='$deduction_name';") or die($mysqli->error());
                                $row = $result->fetch_array();
                                if (isset($row['employeeDeductionAmount'])) {
                                    return number_format($row['employeeDeductionAmount'], 2);
                                } else {
                                    return "0.00";
                                }
                                 }
                                ?>
                                
                            <?php
                                while($row = $result->fetch_assoc()):
                            ?>
                            <tr>
                                <td ><?php echo $row['name']; ?></td><!--name-->
                                 <td ><?php echo $row['position']; ?></td><!--position-->
                                  <td ><?php echo $row['sg']; ?></td><!--sg-->
                                   <td ><?php echo $row['step']; ?></td><!--step-->
                                    <td ><?php $leave_deduction = $row['leave_deduction'];
                                            echo $leave_deduction;
                                    ?></td><!--step-->
                                <td ><?php echo number_format($row['salary'],2); ?></td><!--salary-->
                                <td >
                                    <!--get PERA amount of employee-->
                                <?php $employee_id = $row['id']; //id
                                $result_allowance = $mysqli->query("SELECT * FROM employeeallowance WHERE employeeId=$employee_id") or die($mysqli->error());
                                $row_allowance = $result_allowance->fetch_array();
                                $pera = $row_allowance['employeeallowanceAmount'];
                                    echo number_format($pera,2);
                                ?>
                                </td>
                                <td> <!--get GROSS amount of employee-->
                                <?php $employee_id = $row['id']; //id
                                $result_allowance = $mysqli->query("SELECT * FROM payroll_list WHERE emp_id=$employee_id") or die($mysqli->error());
                                $row_allowance = $result_allowance->fetch_array();
                                 $gross = $row_allowance['gross_amount'];
                                 echo number_format($gross,2) ;
                                 
                                ?></td>
                                <!--Deductions-->
                              <td>
                                    <!--Getting Withholding Tax Premium-->
                                    <?php 
                                        $employee_id = $row['id']; //id
                                        $result_wht = $mysqli->query("SELECT * FROM employeeotherdeductions WHERE employeeId=$employee_id AND employeeOtherDeductionName='Withholding Tax';") or die($mysqli->error());
                                        $row_wht = $result_wht->fetch_array();
                                        if(isset($row_wht['employeeOtherDeductionAmount'])){
                                            echo $wht = number_format($row_wht['employeeOtherDeductionAmount'],2);
                                        }else{
                                            echo "0.00"; // or any message you want to display when the element is not found
                                        }
                                    ?>
                                </td>
                              <td>
                                 <!--Getting GSIS Premium-->
                                 <?php echo getEmployeeDeduction($mysqli, $row['id'], 'GSIS'); ?>
                              </td>
                                                         <td>
                                <!--Getting GSIS Conso Loan-->
                                <?php
                                $employee_id = $row['id'];
                                $gpl = number_format(get_employee_other_deduction($mysqli, $employee_id, 'GSIS Conso Loan'), 2);
                                echo $gpl;
                                ?>
                            </td>

                              <td>
                                 <!--Getting GSIS Policy Loan-->
                              <?php
                                $employee_id = $row['id'];
                                $conso_loan = number_format(get_employee_other_deduction($mysqli, $employee_id, 'GSIS Policy Loan'), 2);
                                echo $conso_loan;
                                ?>
                              </td>
                              
                              <td>
                                <!--Getting GSIS EAL-->
                              <?php
                                $employee_id = $row['id'];
                                $eal = number_format(get_employee_other_deduction($mysqli, $employee_id, 'GSIS EAL'), 2);
                                echo $eal;
                                ?>
                              </td>
                              <td>
                                 <!--Getting GSIS Emergency Loan-->
                              <?php
                                $employee_id = $row['id'];
                                $gel = number_format(get_employee_other_deduction($mysqli, $employee_id, 'GSIS Emergency Loan'), 2);
                                echo $gel;
                                ?>
                              </td>
                              <td>
                                <!--Getting GSIS Real Estate-->
                               <?php
                                $employee_id = $row['id'];
                                $gre = number_format(get_employee_other_deduction($mysqli, $employee_id, 'GSIS Real Estate'), 2);
                                echo $gre;
                                ?>
                              </td>
                              <td>
                                <!--Getting GSIS Opt Loan-->
                              <?php
                                $employee_id = $row['id'];
                                $gol = number_format(get_employee_other_deduction($mysqli, $employee_id, 'GSIS Opt Loan'), 2);
                                echo $gol;
                                ?>
                              </td>
                              <td>
                                 <!--Getting GSIS OULI-->
                              <?php
                                $employee_id = $row['id'];
                                $ouli = number_format(get_employee_other_deduction($mysqli, $employee_id, 'GSIS Conso OULI'), 2);
                                echo $ouli;
                                ?>
                              </td>
                              <td>
                                <!--Getting GSIS MPL-->
                                <?php
                                $employee_id = $row['id'];
                                $gsis_mpl = number_format(get_employee_other_deduction($mysqli, $employee_id, 'GSIS MPL'), 2);
                                echo $gsis_mpl;
                                ?>
                              </td>
                              <td>
                                 <!--Getting GSIS CPL-->
                                <?php
                                $employee_id = $row['id'];
                                $gsis_cpl = number_format(get_employee_other_deduction($mysqli, $employee_id, 'GSIS CPL'), 2);
                                echo $gsis_cpl;
                                ?>
                              </td>
                              <td>
                                 <!--Getting GSIS GFAL II-->
                               <?php
                                $employee_id = $row['id'];
                                $gsis_gfallii = number_format(get_employee_other_deduction($mysqli, $employee_id, 'GSIS GFAL II'), 2);
                                echo $gsis_gfallii;
                                ?>
                              </td>
                              <td>
                                 <!--Getting Philhealth-->
                             <?php echo getEmployeeDeduction($mysqli, $row['id'], 'Philhealth'); ?>
                              </td>
                              <td>
                                  <!--Getting HDMF Premium-->
                               <?php echo getEmployeeDeduction($mysqli, $row['id'], 'HDMF Premium'); ?>
                              </td>
                              <td>
                                 <!--Getting HDMF MPL-->
                              <?php
                                $employee_id = $row['id'];
                                $hdmf_mpl = number_format(get_employee_other_deduction($mysqli, $employee_id, 'HDMF MPL'), 2);
                                echo $hdmf_mpl;
                                ?>
                              </td>
                              <td>
                                 <!--Getting HDMF CL-->
                             <?php
                                $employee_id = $row['id'];
                                $hdmf_cl = number_format(get_employee_other_deduction($mysqli, $employee_id, 'HDMF CL'), 2);
                                echo $hdmf_cl;
                                ?>
                              </td>
                              <td>
                                 <!--Getting BSUCMPC -->
                             <?php
                                $employee_id = $row['id'];
                                $BSUCMPC = number_format(get_employee_other_deduction($mysqli, $employee_id, 'BSUCMPC'), 2);
                                echo $BSUCMPC;
                                ?>
                              </td>
                              <td>
                                  <!--Getting China Bank Savings -->
                               <?php
                                $employee_id = $row['id'];
                                $cbs = number_format(get_employee_other_deduction($mysqli, $employee_id, 'China Bank Savings'), 2);
                                echo $cbs;
                                ?>
                              </td>
                              <td>
                                <!--Getting Landbank -->
                             <?php
                                $employee_id = $row['id'];
                                $landbank = number_format(get_employee_other_deduction($mysqli, $employee_id, 'Landbank'), 2);
                                echo $landbank;
                                ?>
                              </td>
                              <td>
                                <!--Getting BSU Housing Rent -->
                             <?php
                                $employee_id = $row['id'];
                                $bsu_hr = number_format(get_employee_other_deduction($mysqli, $employee_id, 'BSU Housing Rent'), 2);
                                echo $bsu_hr;
                                ?>
                              </td>
                              <td>
                                 <!--Getting UCPBS -->
                              <?php
                                $employee_id = $row['id'];
                                $UCPBS = number_format(get_employee_other_deduction($mysqli, $employee_id, 'UCPBS'), 2);
                                echo $UCPBS;
                                ?>
                              </td>
                              <td>
                                <!--Getting Phil life -->
                               <?php
                                $employee_id = $row['id'];
                                $pl = number_format(get_employee_other_deduction($mysqli, $employee_id, 'Phil life'), 2);
                                echo $pl;
                                ?>
                              </td>
                              <td>
                                 <!--Getting Coco -->
                               <?php
                                $employee_id = $row['id'];
                                $coco = number_format(get_employee_other_deduction($mysqli, $employee_id, 'Coco'), 2);
                                echo $coco;
                                ?>
                              </td>
                              <td>
                                  <!--Getting Phil Am -->
                              <?php
                                $employee_id = $row['id'];
                                $pa = number_format(get_employee_other_deduction($mysqli, $employee_id, 'Phil-Am'), 2);
                                echo $pa;
                                ?>
                              </td>
                              <td>
                                 <!--Getting PPSTA -->
                              <?php
                                $employee_id = $row['id'];
                                $PPSTA = number_format(get_employee_other_deduction($mysqli, $employee_id, 'PPSTA'), 2);
                                echo $PPSTA;
                                ?>
                              </td>
                              <td>
                                 <!--Getting Water -->
                               <?php
                                $employee_id = $row['id'];
                                $water = number_format(get_employee_other_deduction($mysqli, $employee_id, 'Water'), 2);
                                echo $water;
                                ?>
                              </td>
                              <td>
                                <!--Getting Electric -->
                               <?php
                                $employee_id = $row['id'];
                                $electric = number_format(get_employee_other_deduction($mysqli, $employee_id, 'Electric'), 2);
                                echo $electric;
                                ?>
                              </td>
                              <td>
                                 <!--Getting COA-ND -->
                               <?php
                                $employee_id = $row['id'];
                                $COA_ND = number_format(get_employee_other_deduction($mysqli, $employee_id, 'COA-ND'), 2);
                                echo $COA_ND;
                                ?>
                              </td>
                              <td>
                                 <!--Getting total deductions -->
                               <?php 
                 
                       //get mandatory
               $result_deduction = $mysqli->query("SELECT sum(employeeDeductionAmount) as value_difference from employeedeductions WHERE employeeId='$employee_id'") or die($mysqli->error);
               while($deduction_rows = mysqli_fetch_array($result_deduction)) {
                 $fetched_deduction = $deduction_rows['value_difference'];
                 
               }
               //get other
                $result_other_deduction = $mysqli->query("SELECT sum(employeeOtherDeductionAmount) as value_other_difference from employeeotherdeductions WHERE employeeId='$employee_id'") or die($mysqli->error);
               while($other_deduction_rows = mysqli_fetch_array($result_other_deduction)) {
                 $fetched_other_deduction = $other_deduction_rows['value_other_difference'];
                 $total_deduction = $fetched_deduction+$fetched_other_deduction;
               }
               ?>
               <?php echo number_format($total_deduction,2);
                ?>
                              </td>
                              <td>
                                 <!--Getting net amount -->
                              <?php
                              $net_amount = $gross - $total_deduction - $leave_deduction;
                                  echo number_format($net_amount,2);
                                  ?>
                              </td>
                              <td>
                                 <!--Getting cutoff amount -->
                                 <?php
                              $half_month_pay = $net_amount/2;
                              echo number_format($half_month_pay,2);
                                  ?>
                              </td>
                              <td>
                                   <?php
                                 echo number_format($half_month_pay,2);
                                 ?>
                              </td>
                             
                              <td>
                                   <!--Getting  employee deduction remarks -->
                              <?php 
                               $employee_id = $row['id']; 
                                $result_remarks = $mysqli->query("SELECT * FROM remarks WHERE emp_id=$employee_id") or die($mysqli->error());
                                while($row_remarks = $result_remarks->fetch_array()){
                                  echo $row_remarks['other_deduction_name'].': '.$row_remarks['remark_text']."<br>";
                                }
                              ?>
      
                              </td>
                             
                             
                            </tr>
                            <tr>
                                
                            </tr>
                            <?php endwhile;  ?>
                        </tbody>
                    </table>
			</div>
		</div>
	</div>
</section>
  </div>
  <footer class="main-footer">
    <strong>CBOO-CPMS@BSU</strong>
    <div class="float-right d-none d-sm-inline-block">
    </div>
  </footer>
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
<script>
  
</script>
<link href="https://unpkg.com/bootstrap-table@1.21.0/dist/bootstrap-table.min.css" rel="stylesheet">

<script src="https://unpkg.com/bootstrap-table@1.21.0/dist/bootstrap-table.min.js"></script>
</body>
</html>
