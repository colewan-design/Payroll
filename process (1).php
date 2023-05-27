<?php


require_once("config.php"); 
DATE_DEFAULT_TIMEZONE_SET('Asia/Manila');
//declare database
$mysqli = new mysqli('bsu-info.tech', 'u455679702_cps', 'OpK3RKh]!h9', 'u455679702_cps') or die(mysqli_error($mysqli));
$result = $mysqli->query("SELECT * FROM data") or die($mysqli->error);

$findresult = mysqli_query($mysqli, "SELECT * FROM salaryData");
if($res = mysqli_fetch_array($findresult))
{
$salaryAmount = $res['salaryAmount']; 
$salaryGrade = $res['salaryGrade'];   
$salaryStep = $res['salaryStep'];  

}
while($row = $findresult->fetch_assoc()){
  $salaryAmount = $row['salaryAmount']; 
}


//create a payroll for all employees
if(isset($_POST['save_payroll'])){
 
  $payroll_from = $_POST['payroll_from'];
  $date1 = new DateTime($payroll_from);
  $payroll_to = $_POST['payroll_to'];
  $date2 = new DateTime($payroll_to);
  //get the days between to and from dates
  $interval = $date1->diff($date2);
  $get_days =  $interval->days;
  if($get_days > 15){
    $payroll_type = 1;
  }
  else if($get_days < 15){
    $payroll_type = 0;
  }
 
//get all data
  $payroll_result = mysqli_query($mysqli, "SELECT * FROM data");

 //create payroll for each employee, the data will be taken from the table 'data'
  while ($trow = mysqli_fetch_array($payroll_result)) {//$payroll_result = select * from data
    $trows[] = $trow;
  }
  foreach ($trows as $trow) {
    $payroll_emp_id = $trow['id']; //employee ID
    $payroll_emp_salary = $trow['salary']; //employee Salary
    
 //getting the gross amount from the employeeallowance table and salary from data table
$gross_results = $mysqli->query("SELECT employeeId, sum(employeeallowanceAmount) AS value_sum FROM employeeallowance where employeeId=$payroll_emp_id") or die($mysqli->error);
while($gross_rows = $gross_results->fetch_assoc()) {
        
    $fetched_sum = $gross_rows['value_sum'];

}

$bad_symbols = array(",");
$current_employee_salary = str_replace($bad_symbols, "", $payroll_emp_salary);
    $gross_amount= $fetched_sum + $current_employee_salary;//gross amount (salary plus total allowance)

    //insert new payroll to payroll list table
   $mysqli->query("INSERT INTO payroll_list (payroll_from, payroll_to, emp_id, payroll_type, gross_amount) VALUES ('$payroll_from', '$payroll_to', '$payroll_emp_id', '$payroll_type' , '$gross_amount')ON DUPLICATE KEY UPDATE payroll_from='$payroll_from', payroll_to='$payroll_to', payroll_type='$payroll_type', gross_amount='$gross_amount';") or
   die($mysqli->error);
    }  

    
  header("location:employees.php");

}
//update payslip of employee
if (isset($_POST['updatePayslip'])){
  $update = true;
  $emp_name =$_POST['name'];
  $fromDate =  date('Y-m-d', strtotime($_POST['fromDate']));
  $toDate = $_POST['toDate'];
  $emp_gross_amount = $_POST['gross_amount'];
  $emp_fetched_difference = $_POST['final_deduction'];
  $emp_net_amount = $_POST['net_amount'];
  $emp_id = $_POST['id'];


 $mysqli->query("UPDATE payslipdata SET emp_id='$emp_id', employee_name='$emp_name', from_date='$fromDate', to_date='$toDate', deduction_emp='$emp_fetched_difference', gross_emp='$emp_gross_amount', nett_emp='$emp_net_amount' WHERE emp_id=$emp_id") or die($mysqli->error());




 header("location:payslip_data.php");
}

//update user profile of employee
if (isset($_POST['save_user_profile'])){
 
  $user_email =$_POST['user_email'];

  $employee_data_id = $_POST['employee_data_id'];


 $mysqli->query("UPDATE userlogin SET employee_email='$user_email' WHERE employee_data_id=$employee_data_id") or die($mysqli->error());




 header("location:user_profile_page.php");
}

//insert payslip of employee 
if(isset($_POST['savePayslip'])){
  $emp_name = $_POST['name'];
  $fromDate = date('Y-m-d', strtotime($_POST['fromDate']));
  $toDate = $_POST['toDate'];
  $emp_gross_amount = $_POST['gross_amount'];
  $emp_fetched_difference = $_POST['final_deduction'];
  $emp_net_amount = $_POST['net_amount'];
  $emp_id = $_POST['id'];

  
  $mysqli->query("INSERT INTO payslipdata (emp_id, employee_name, from_date, to_date, gross_emp, deduction_emp, nett_emp) VALUES ('$emp_id', '$emp_name', '$fromDate', '$toDate', '$emp_gross_amount', '$emp_fetched_difference', '$emp_net_amount')") or
  die($mysqli->error);

  header("location:payslip_data.php");
}
//insert payslip of individual employee 
if(isset($_POST['savePayroll'])){
  
  $gross_amount = $_POST['gross_amount'];
  $payroll_from = $_POST['payroll_from'];
  $date1 = new DateTime($payroll_from);
  $payroll_to = $_POST['payroll_to'];
  $date2 = new DateTime($payroll_to);
  //get the days between to and from dates
  $interval = $date1->diff($date2);
  $get_days =  $interval->days;
  if($get_days > 15){
    $payroll_type = 1;
  }
  else if($get_days < 15){
    $payroll_type = 0;
  }
  $emp_id = $_POST['id'];
  
  $mysqli->query("INSERT INTO payroll_list (emp_id, payroll_from, payroll_to, payroll_type, gross_amount) VALUES ('$emp_id', '$payroll_from', '$payroll_to', '$payroll_type' , '$gross_amount') ON DUPLICATE KEY UPDATE `payroll_from` = '$payroll_from', `payroll_to` = '$payroll_to', `emp_id` = '$emp_id', `payroll_type` = '$payroll_type', `gross_amount` = '$gross_amount';") or
  die($mysqli->error);

  header("location:payslip_data.php");
}
//insert new salary
if(isset($_POST['saveNewSalary'])){
  $salaryGrade = $_POST['salaryGrade'];
  $salaryAmount = $_POST['salaryAmount'];
  $salaryStep = $_POST['salaryStep'];
  
  $mysqli->query("INSERT INTO salaryData (salaryGrade, salaryAmount, salaryStep, position) VALUES ('$salaryGrade','$salaryAmount','$salaryStep')") or
  die($mysqli->error);

  header("location:salary.php");
//insert employee allowance
}
if(isset($_POST['addEmployeeAllowance'])){
  $employeeId = $_POST['id'];
  $employeeAllowanceId = $_POST['employeeAllowanceId'];
  $admin_id = $_POST['admin_id'];
	$activity_type = "Insert employee incentive";
  
	$time_logged = date("Y-m-d H:i:s",strtotime("now"));
	$mysqli->query("INSERT INTO activity (time_logged, admin_id, activity_type) VALUES ('$time_logged', '$admin_id', '$activity_type')") or
	die($mysqli->error);
  
  $allowance_result = $mysqli->query("SELECT * FROM allowance WHERE allowanceId=$employeeAllowanceId") or die($mysqli->error());
        $row = $allowance_result->fetch_array();
        $employeeAllowanceName = $row['allowanceName'];
        $employeeallowanceAmount = $row['allowanceAmount'];
        $allowanceType = $row['allowanceType'];
       
        $data_result = $mysqli->query("SELECT * FROM data WHERE id=$employeeId") or die($mysqli->error());
        $data_row = $data_result->fetch_array();
        $employee_salary = $data_row['salary'];
		    if($allowanceType == 'percentage'){
        $get_percentage = $employeeallowanceAmount / 100;
        $employeeallowanceAmount = $get_percentage * $employee_salary;
        }
       
   
    $mysqli->query("UPDATE employeeallowance SET employeeallowanceAmount='$employeeallowanceAmount', employeeId='$employeeId', eaName='$employeeAllowanceName', allowanceId='$employeeAllowanceId' WHERE eaName='$employeeAllowanceName' AND employeeId=$employeeId") or die($mysqli->error());


  header("location:".$_SERVER['HTTP_REFERER']);
}
//insert employee deduction
if(isset($_POST['addEmployeeDeduction'])){
  $employeeId = $_POST['id'];
  $employeeDeductionId = $_POST['employeeDeductionId'];

  $admin_id = $_POST['admin_id'];
  $activity_type = "Insert employee Mandatory deduction";

  $time_logged = date("Y-m-d H:i:s",strtotime("now"));
  $mysqli->query("INSERT INTO activity (time_logged, admin_id, activity_type) VALUES ('$time_logged', '$admin_id', '$activity_type')") or
  die($mysqli->error);
  //get the data of the deduction from deduction table using ID 
        $deduction_result = $mysqli->query("SELECT * FROM deductions WHERE deductionId=$employeeDeductionId") or die($mysqli->error());
        $row = $deduction_result->fetch_array();
        //get the data of the employee to have access on the employee salary
        $employee_salary = $mysqli->query("SELECT * FROM data WHERE id=$employeeId") or die($mysqli->error());
        $employee_salary_row = $employee_salary->fetch_array();
        $current_employee_salary = $employee_salary_row['salary'];
        $a = $current_employee_salary;
        $current_employee_salary = preg_replace('/[,]/', '', $a);
        
        $employeeDeductionName = $row['deductionName'];
        $employeeDeductionAmount = $row['amount'];
        $percentage_employeeDeductionAmount = $employeeDeductionAmount/100;//decimal value of the deduction
        $deduction_type = $row['deductionType'];
        $deduction_limit = $row['deductionLimit'];
      //multiply the deduction amount in its decimal form to the employee's salary
        if($deduction_type == 'percentage'){
          $final_employeeDeductionAmount = $percentage_employeeDeductionAmount * $current_employee_salary;
        }
        else{
          //else retain the value and set it as the final deduction amount
          $final_employeeDeductionAmount = $employeeDeductionAmount;
        }
        //deduction amount being checked if it is greater than the limit
       if ($final_employeeDeductionAmount > $deduction_limit){
        $final_employeeDeductionAmount = $deduction_limit;
       }
//if deduction limit is 0 check if the deduction type is percentage or real value and assign the value to decimal or whole number
       if ($final_employeeDeductionAmount == 0){
        if ($deduction_type == 'percentage'){
          $final_employeeDeductionAmount = $percentage_employeeDeductionAmount * $current_employee_salary;
         }
         else if ($deduction_type == 'real_value'){
          $final_employeeDeductionAmount = $employeeDeductionAmount;
         }
       }
       else{
        $final_employeeDeductionAmount = $final_employeeDeductionAmount;
       }
  

    $mysqli->query("UPDATE employeedeductions SET employeeDeductionAmount='$final_employeeDeductionAmount', employeeId='$employeeId', edName='$employeeDeductionName', deductionId='$employeeDeductionId' WHERE edName='$employeeDeductionName' AND employeeId=$employeeId") or die($mysqli->error());

  header("location:".$_SERVER['HTTP_REFERER']);
}

//insert other deductions
if(isset($_POST['addEmployeeOtherDeduction'])){
  $employeeId = $_POST['id'];
  $otherDeductionId = $_POST['otherDeductionId'];
  $employeeOtherDeductionAmount = $_POST['employeeOtherDeductionAmount'];

  $admin_id = $_POST['admin_id'];
  $activity_type = "Insert Employee Secondary Deduction";

  $time_logged = date("Y-m-d H:i:s",strtotime("now"));
  $mysqli->query("INSERT INTO activity (time_logged, admin_id, activity_type) VALUES ('$time_logged', '$admin_id', '$activity_type')") or
  die($mysqli->error);

        $other_deduction_result = $mysqli->query("SELECT * FROM otherdeductions WHERE otherDeductionId=$otherDeductionId") or die($mysqli->error());
        $row = $other_deduction_result->fetch_array();

        
        $employeeOtherDeductionName = $row['otherDeductionName'];
       
        
    $mysqli->query("INSERT INTO employeeotherdeductions( employeeOtherDeductionAmount, employeeId, employeeOtherDeductionName, otherDeductionId) VALUES ('$employeeOtherDeductionAmount', '$employeeId', '$employeeOtherDeductionName', '$otherDeductionId')") or
    die($mysqli->error);

  header("location:".$_SERVER['HTTP_REFERER']);
}
//insert deductions
if(isset($_POST['insertDeductions'])){
  $deductionName = $_POST['deductionName'];
  $description = $_POST['description'];
  $amount = $_POST['amount'];
  $deduction_type = $_POST['deductionType'];
  $deduction_limit = $_POST['deductionLimit'];
 //getting the amount of deduction if the limit is set to 0
  
  //getting the amount of deduction
  if ($amount >$deduction_limit){
    $amount = $deduction_limit;
  }
  if ($amount <=0){
    $amount = $amount;
  }
  else{
    $amount = $amount;
  }
  
  $mysqli->query("INSERT INTO deductions (deductionName, description, amount, deductionType, deductionLimit) VALUES ('$deductionName', '$description', '$amount', '$deduction_type', '$deduction_limit')") or
  die($mysqli->error);

  header("location:deductions.php");
}


//insert position
if(isset($_POST['insertPosition'])){
  $position_name= $_POST['position_name'];
  $project_id= $_POST['project_id'];
  $mysqli->query("INSERT INTO position (position_name, project_id) VALUES ('$position_name', '$project_id')") or
  die($mysqli->error);

  header("location:position.php");
}
//insert project
if(isset($_POST['insertProject'])){
  $project_name= $_POST['project_name'];
  
  $mysqli->query("INSERT INTO project (project_name) VALUES ('$project_name')") or
  die($mysqli->error);

  header("location:project.php");
}
if(isset($_POST['insert_project'])){
  $project_name= $_POST['project_name'];
  $mysqli->query("INSERT INTO project (project_name) VALUES ('$project_name')") or
  die($mysqli->error);

  header("location:project.php");
}
//insert allowance
if(isset($_POST['insertAllowance'])){
  $allowanceName = $_POST['allowanceName'];
  $allowanceDescription = $_POST['allowanceDescription'];
  $allowanceAmount = $_POST['allowanceAmount'];
  $mysqli->query("INSERT INTO allowance (allowanceName, allowanceDescription, allowanceAmount) VALUES ('$allowanceName', '$allowanceDescription', '$allowanceAmount')") or
  die($mysqli->error);

  header("location:incentives.php");
}



//Employees save - employees.php
if(isset($_POST['save'])){
    $name = $_POST['name'];
    $id = $_POST['id'];
    $sg = $_POST['sg'];
    $step = $_POST['step'];
    $position = $_POST['position_name'];//position_id fetched
    $position_result = mysqli_query($mysqli, "SELECT * FROM position where project_id = $position");
    if($position_res = mysqli_fetch_array($position_result))
    {

    $position_name = $position_res['position_name'];   
  
     
    }

    $type = $_POST['employee_type'];
    $project = $_POST['project_name'];
    $admin_id = $_POST['admin_id'];
    $activity_type = "Insert an employee";

    //archive data 
    $time_logged = date("Y-m-d H:i:s",strtotime("now"));
    $mysqli->query("INSERT INTO activity (time_logged, admin_id, activity_type) VALUES ('$time_logged', '$admin_id', '$activity_type')") or
    die($mysqli->error);

    //add new employee
    $mysqli->query("INSERT INTO data (name, position, sg, step, salary, project, type, id) VALUES ('$name', '$position_name', '$sg', '$step', '$salaryAmount', '$project', '$type', '$id')") or
    die($mysqli->error);

    $salaryAmount=0;

    //get GSIS ID from deductions table
    $gsis_result = mysqli_query($mysqli, "SELECT * FROM deductions WHERE deductionName='GSIS';");
    if($gsis_res = mysqli_fetch_array($gsis_result))
    {
    $GSIS_id = $gsis_res['deductionId'];   
    }
     //get Withholding Tax ID from deductions table
     $WHT_result = mysqli_query($mysqli, "SELECT * FROM deductions WHERE deductionName='Withholding Tax';");
     if($WHT_res = mysqli_fetch_array($WHT_result))
     {
     $WHT_id = $WHT_res['deductionId'];   
     }
     //get GSIS Conso Loan ID from deductions table
     $GCL_result = mysqli_query($mysqli, "SELECT * FROM deductions WHERE deductionName='GSIS Conso Loan';");
     if($GCL_res = mysqli_fetch_array($GCL_result))
     {
     $GCL_id = $GCL_res['deductionId'];   
     }
     //get GSIS Policy Loan ID from deductions table
     $GPL_result = mysqli_query($mysqli, "SELECT * FROM deductions WHERE deductionName='GSIS Conso Loan';");
     if($GPL_res = mysqli_fetch_array($GPL_result))
     {
     $GPL_id = $GPL_res['deductionId'];   
     }
    //get GSIS EAL ID from deductions table
    $EAL_result = mysqli_query($mysqli, "SELECT * FROM deductions WHERE deductionName='GSIS EAL';");
    if($EAL_res = mysqli_fetch_array($EAL_result))
    {
    $EAL_id = $EAL_res['deductionId'];   
    }
    //get GSIS Emergency Loan ID from deductions table
    $GEL_result = mysqli_query($mysqli, "SELECT * FROM deductions WHERE deductionName='GSIS Emergency Loan';");
    if($GEL_res = mysqli_fetch_array($GEL_result))
    {
    $GEL_id = $GEL_res['deductionId'];   
    }
    //get GSIS Real Estate ID from deductions table
    $GRE_result = mysqli_query($mysqli, "SELECT * FROM deductions WHERE deductionName='GSIS Real Estate';");
    if($GRE_res = mysqli_fetch_array($GRE_result))
    {
    $GRE_id = $GRE_res['deductionId'];   
    }
     //get GSIS Opt Loan ID from deductions table
     $GOL_result = mysqli_query($mysqli, "SELECT * FROM deductions WHERE deductionName='GSIS Opt Loan';");
     if($GOL_res = mysqli_fetch_array($GOL_result))
     {
     $GOL_id = $GOL_res['deductionId'];   
     }
      //get GSIS OULI ID from deductions table
      $OULI_result = mysqli_query($mysqli, "SELECT * FROM deductions WHERE deductionName='GSIS OULI';");
      if($OULI_res = mysqli_fetch_array($OULI_result))
      {
      $OULI_id = $OULI_res['deductionId'];   
      }
      //get GSIS MPL ID from deductions table
      $MPL_result = mysqli_query($mysqli, "SELECT * FROM deductions WHERE deductionName='GSIS MPL';");
      if($MPL_res = mysqli_fetch_array($MPL_result))
      {
      $MPL_id = $MPL_res['deductionId'];   
      }
      //get GSIS CPL ID from deductions table
      $CPL_result = mysqli_query($mysqli, "SELECT * FROM deductions WHERE deductionName='GSIS CPL';");
      if($CPL_res = mysqli_fetch_array($CPL_result))
      {
      $CPL_id = $CPL_res['deductionId'];   
      }
       //get GSIS GFAL II ID from deductions table
       $GFALII_result = mysqli_query($mysqli, "SELECT * FROM deductions WHERE deductionName='GSIS GFAL II';");
       if($GFALII_res = mysqli_fetch_array($GFALII_result))
       {
       $GFALII_id = $GFALII_res['deductionId'];   
       }
       //get Philhealth ID from deductions table
       $Philhealth_result = mysqli_query($mysqli, "SELECT * FROM deductions WHERE deductionName='Philhealth';");
       if($Philhealth_res = mysqli_fetch_array($Philhealth_result))
       {
       $Philhealth_id = $Philhealth_res['deductionId'];   
       }
        //get HDMF Premium ID from deductions table
        $HDMF_result = mysqli_query($mysqli, "SELECT * FROM deductions WHERE deductionName='HDMF Premium';");
        if($HDMF_res = mysqli_fetch_array($HDMF_result))
        {
        $HDMF_id = $HDMF_res['deductionId'];   
        }
          //get HDMF MPL ID from deductions table
          $HDMFMPL_result = mysqli_query($mysqli, "SELECT * FROM deductions WHERE deductionName='HDMF MPL';");
          if($HDMFMPL_res = mysqli_fetch_array($HDMFMPL_result))
          {
          $HDMFMPL_id = $HDMFMPL_res['deductionId'];   
          }
           //get HDMF CL ID from deductions table
           $HDMFCL_result = mysqli_query($mysqli, "SELECT * FROM deductions WHERE deductionName='HDMF CL';");
           if($HDMFCL_res = mysqli_fetch_array($HDMFCL_result))
           {
           $HDMFCL_id = $HDMFCL_res['deductionId'];   
           }
           //get BSUCMPC ID from deductions table
           $BSUCMPC_result = mysqli_query($mysqli, "SELECT * FROM deductions WHERE deductionName='BSUCMPC';");
           if($BSUCMPC_res = mysqli_fetch_array($BSUCMPC_result))
           {
           $BSUCMPC_id = $BSUCMPC_res['deductionId'];   
           }
            //get China Bank Savings ID from deductions table
            $CBS_result = mysqli_query($mysqli, "SELECT * FROM deductions WHERE deductionName='China Bank Savings';");
            if($CBS_res = mysqli_fetch_array($CBS_result))
            {
            $CBS_id = $CBS_res['deductionId'];   
            }
             //get Landbank ID from deductions table
             $Landbank_result = mysqli_query($mysqli, "SELECT * FROM deductions WHERE deductionName='Landbank';");
             if($Landbank_res = mysqli_fetch_array($Landbank_result))
             {
             $Landbank_id = $CBS_res['deductionId'];   
             }
              //get BSU Housing Rent ID from deductions table
              $BHR_result = mysqli_query($mysqli, "SELECT * FROM deductions WHERE deductionName='BSU Housing Rent';");
              if($BHR_res = mysqli_fetch_array($BHR_result))
              {
              $BHR_id = $BHR_res['deductionId'];   
              }
               //get UCPBS ID from deductions table
               $UCPBS_result = mysqli_query($mysqli, "SELECT * FROM deductions WHERE deductionName='UCPBS';");
               if($UCPBS_res = mysqli_fetch_array($UCPBS_result))
               {
               $UCPBS_id = $UCPBS_res['deductionId'];   
               }
               //get Phil life ID from deductions table
               $PL_result = mysqli_query($mysqli, "SELECT * FROM deductions WHERE deductionName='Phil life';");
               if($PL_res = mysqli_fetch_array($PL_result))
               {
               $PL_id = $PL_res['deductionId'];   
               }
               //get Coco ID from deductions table
               $Coco_result = mysqli_query($mysqli, "SELECT * FROM deductions WHERE deductionName='Coco';");
               if($Coco_res = mysqli_fetch_array($Coco_result))
               {
               $Coco_id = $Coco_res['deductionId'];   
               }
               //get Phil Am ID from deductions table
               $PA_result = mysqli_query($mysqli, "SELECT * FROM deductions WHERE deductionName='Phil Am';");
               if($PA_res = mysqli_fetch_array($PA_result))
               {
               $PA_id = $PA_res['deductionId'];   
               }
                //get PPSTA ID from deductions table
                $PPSTA_result = mysqli_query($mysqli, "SELECT * FROM deductions WHERE deductionName='PPSTA';");
                if($PPSTA_res = mysqli_fetch_array($PPSTA_result))
                {
                $PPSTA_id = $PPSTA_res['deductionId'];   
                }
                 //get Water ID from deductions table
                 $Water_result = mysqli_query($mysqli, "SELECT * FROM deductions WHERE deductionName='Water';");
                 if($Water_res = mysqli_fetch_array($Water_result))
                 {
                 $Water_id = $Water_res['deductionId'];   
                 }
                   //get Electric ID from deductions table
                   $Electric_result = mysqli_query($mysqli, "SELECT * FROM deductions WHERE deductionName='Electric';");
                   if($Electric_res = mysqli_fetch_array($Electric_result))
                   {
                   $Electric_id = $Electric_res['deductionId'];   
                   }
                   //get COA-ND ID from deductions table
                   $COAND_result = mysqli_query($mysqli, "SELECT * FROM deductions WHERE deductionName='COA-ND';");
                   if($COAND_res = mysqli_fetch_array($COAND_result))
                   {
                   $COAND_id = $COAND_res['deductionId'];   
                   }


    //get PERA ID from deductions table
    $PERA_result = mysqli_query($mysqli, "SELECT * FROM allowance WHERE allowanceName='PERA';");
    if($pera_res = mysqli_fetch_array($PERA_result))
    {
    $PERA_id = $pera_res['allowanceId'];   
    }

 //create GSIS record for the employee and set the amount to 0
 $mysqli->query("INSERT INTO employeedeductions (employeeDeductionAmount, employeeId, edName, deductionId) VALUES ('0', '$id', 'GSIS', '$GSIS_id')") or
 die($mysqli->error);
 //create Withholding Tax record for the employee and set the amount to 0
 $mysqli->query("INSERT INTO employeedeductions (employeeDeductionAmount, employeeId, edName, deductionId) VALUES ('0', '$id', 'Withholding Tax', '$WHT_id')") or
 die($mysqli->error);
  //create GSIS Conso Loan record for the employee and set the amount to 0
  $mysqli->query("INSERT INTO employeedeductions (employeeDeductionAmount, employeeId, edName, deductionId) VALUES ('0', '$id', 'GSIS Conso Loan', '$WHT_id')") or
  die($mysqli->error);
    //create GSIS EAL record for the employee and set the amount to 0
    $mysqli->query("INSERT INTO employeedeductions (employeeDeductionAmount, employeeId, edName, deductionId) VALUES ('0', '$id', 'GSIS EAL', '$EAL_id')") or
    die($mysqli->error);
    //create GSIS Emergency Loan record for the employee and set the amount to 0
    $mysqli->query("INSERT INTO employeedeductions (employeeDeductionAmount, employeeId, edName, deductionId) VALUES ('0', '$id', 'GSIS Emergency Loan', '$GEL_id')") or
    die($mysqli->error);
    //create GSIS Real Estate record for the employee and set the amount to 0
    $mysqli->query("INSERT INTO employeedeductions (employeeDeductionAmount, employeeId, edName, deductionId) VALUES ('0', '$id', 'GSIS Real Estate', '$GRE_id')") or
    die($mysqli->error);
     //create GSIS Opt Loan record for the employee and set the amount to 0
     $mysqli->query("INSERT INTO employeedeductions (employeeDeductionAmount, employeeId, edName, deductionId) VALUES ('0', '$id', 'GSIS Opt Loan', '$GOL_id')") or
     die($mysqli->error);
      //create GSIS OULI record for the employee and set the amount to 0
      $mysqli->query("INSERT INTO employeedeductions (employeeDeductionAmount, employeeId, edName, deductionId) VALUES ('0', '$id', 'GSIS OULI', '$OULI_id')") or
      die($mysqli->error);
        //create GSIS MPL record for the employee and set the amount to 0
        $mysqli->query("INSERT INTO employeedeductions (employeeDeductionAmount, employeeId, edName, deductionId) VALUES ('0', '$id', 'GSIS MPL', '$MPL_id')") or
        die($mysqli->error);
        //create GSIS CPL record for the employee and set the amount to 0
        $mysqli->query("INSERT INTO employeedeductions (employeeDeductionAmount, employeeId, edName, deductionId) VALUES ('0', '$id', 'GSIS CPL', '$CPL_id')") or
        die($mysqli->error);
        //create GSIS GFAL II record for the employee and set the amount to 0
        $mysqli->query("INSERT INTO employeedeductions (employeeDeductionAmount, employeeId, edName, deductionId) VALUES ('0', '$id', 'GSIS GFAL II', '$GFALII_id')") or
        die($mysqli->error);
        //create Philhealth record for the employee and set the amount to 0
        $mysqli->query("INSERT INTO employeedeductions (employeeDeductionAmount, employeeId, edName, deductionId) VALUES ('0', '$id', 'Philhealth', '$Philhealth_id')") or
        die($mysqli->error);
         //create HDMF Premium record for the employee and set the amount to 0
         $mysqli->query("INSERT INTO employeedeductions (employeeDeductionAmount, employeeId, edName, deductionId) VALUES ('0', '$id', 'HDMF Premium', '$HDMF_id')") or
         die($mysqli->error);
          //create HDMF CL record for the employee and set the amount to 0
          $mysqli->query("INSERT INTO employeedeductions (employeeDeductionAmount, employeeId, edName, deductionId) VALUES ('0', '$id', 'HDMF CL', '$HDMFCL_id')") or
          die($mysqli->error);
             //create HDMF MPL record for the employee and set the amount to 0
             $mysqli->query("INSERT INTO employeedeductions (employeeDeductionAmount, employeeId, edName, deductionId) VALUES ('0', '$id', 'HDMF MPL', '$HDMFMPL_id')") or
             die($mysqli->error);
             //create BSUCMPC record for the employee and set the amount to 0
             $mysqli->query("INSERT INTO employeedeductions (employeeDeductionAmount, employeeId, edName, deductionId) VALUES ('0', '$id', 'BSUCMPC', '$BSUCMPC_id')") or
             die($mysqli->error);
             //create China Bank Savings record for the employee and set the amount to 0
             $mysqli->query("INSERT INTO employeedeductions (employeeDeductionAmount, employeeId, edName, deductionId) VALUES ('0', '$id', 'China Bank Savings', '$CBS_id')") or
             die($mysqli->error);
              //create Landbank record for the employee and set the amount to 0
              $mysqli->query("INSERT INTO employeedeductions (employeeDeductionAmount, employeeId, edName, deductionId) VALUES ('0', '$id', 'Landbank', '$Landbank_id')") or
              die($mysqli->error);
              //create BSU Housing Rent record for the employee and set the amount to 0
              $mysqli->query("INSERT INTO employeedeductions (employeeDeductionAmount, employeeId, edName, deductionId) VALUES ('0', '$id', 'BSU Housing Rent', '$BHR_id')") or
              die($mysqli->error);
               //create UCPBS record for the employee and set the amount to 0
               $mysqli->query("INSERT INTO employeedeductions (employeeDeductionAmount, employeeId, edName, deductionId) VALUES ('0', '$id', 'UCPBS', '$UCPBS_id')") or
               die($mysqli->error);
                //create Phil life record for the employee and set the amount to 0
                $mysqli->query("INSERT INTO employeedeductions (employeeDeductionAmount, employeeId, edName, deductionId) VALUES ('0', '$id', 'Phil life', '$PL_id')") or
                die($mysqli->error);
                //create Phil Am record for the employee and set the amount to 0
                $mysqli->query("INSERT INTO employeedeductions (employeeDeductionAmount, employeeId, edName, deductionId) VALUES ('0', '$id', 'Phil Am', '$PA_id')") or
                die($mysqli->error);
                //create Coco record for the employee and set the amount to 0
                $mysqli->query("INSERT INTO employeedeductions (employeeDeductionAmount, employeeId, edName, deductionId) VALUES ('0', '$id', 'Coco', '$Coco_id')") or
                die($mysqli->error);
                 //create PPSTA record for the employee and set the amount to 0
                 $mysqli->query("INSERT INTO employeedeductions (employeeDeductionAmount, employeeId, edName, deductionId) VALUES ('0', '$id', 'PPSTA', '$PPSTA_id')") or
                 die($mysqli->error);
                 //create Electric record for the employee and set the amount to 0
                 $mysqli->query("INSERT INTO employeedeductions (employeeDeductionAmount, employeeId, edName, deductionId) VALUES ('0', '$id', 'Electric', '$Electric_id')") or
                 die($mysqli->error);//create Water record for the employee and set the amount to 0
                  //create COA-ND record for the employee and set the amount to 0
                  $mysqli->query("INSERT INTO employeedeductions (employeeDeductionAmount, employeeId, edName, deductionId) VALUES ('0', '$id', 'COA-ND', '$COAND_id')") or
                  die($mysqli->error);//create Water record for the employee and set the amount to 0
                 $mysqli->query("INSERT INTO employeedeductions (employeeDeductionAmount, employeeId, edName, deductionId) VALUES ('0', '$id', 'Water', '$Water_id')") or
                 die($mysqli->error);
    //create GSIS Policy Loan record for the employee and set the amount to 0
    $mysqli->query("INSERT INTO employeedeductions (employeeDeductionAmount, employeeId, edName, deductionId) VALUES ('0', '$id', 'GSIS Policy Loan', '$GPL_id')") or
    die($mysqli->error);
 //create PERA record for the employee and set the amount to 0
 $mysqli->query("INSERT INTO employeeallowance (employeeallowanceAmount, employeeId, eaName, allowanceId) VALUES ('0', '$id', 'PERA', '$PERA_id')") or
 die($mysqli->error);


    header("location:employees.php");

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
//payslip data delete process
if (isset($_GET['payslipDelete'])){
  $payslip_id = $_GET['payslipDelete'];
  $mysqli->query("DELETE FROM payroll_list WHERE payroll_id=$payslip_id") or die($mysqli->error());

  $_SESSION['message'] = "Record has been deleted!";
  $_SESSION['msg_type'] = "danger";

  header("location:payslip_data.php");
}

//employee salary delete process
if (isset($_GET['salaryDelete'])){
  $salaryId = $_GET['salaryDelete'];
  $mysqli->query("DELETE FROM salarydata WHERE id=$salaryId") or die($mysqli->error());

  $_SESSION['message'] = "Record has been deleted!";
  $_SESSION['msg_type'] = "danger";

  header("location:salary_matrix.php");
}

//employee allowance delete process
if (isset($_GET['employeeallowanceDelete'])){
  $eaID = $_GET['employeeallowanceDelete'];
 
  $mysqli->query("UPDATE employeeallowance SET employeeallowanceAmount='0' WHERE eaID=$eaID AND eaName='PERA'") or die($mysqli->error());

  $admin_id = $_GET['admin_id'];
  $activity_type = "Delete employee incentive";

  $time_logged = date("Y-m-d H:i:s",strtotime("now"));
  $mysqli->query("INSERT INTO activity (time_logged, admin_id, activity_type) VALUES ('$time_logged', '$admin_id', '$activity_type')") or
  die($mysqli->error);

  $_SESSION['message'] = "Record has been deleted!";
  $_SESSION['msg_type'] = "danger";

  header("location:".$_SERVER['HTTP_REFERER']);
}

//employee allowance delete process
if (isset($_GET['employeeotherdeductionDelete'])){
  $odId = $_GET['employeeotherdeductionDelete'];
  $mysqli->query("DELETE FROM employeeotherdeductions WHERE odId=$odId") or die($mysqli->error());

  $admin_id = $_GET['admin_id'];
  $activity_type = "Delete employee secondary deduction";

  $time_logged = date("Y-m-d H:i:s",strtotime("now"));
  $mysqli->query("INSERT INTO activity (time_logged, admin_id, activity_type) VALUES ('$time_logged', '$admin_id', '$activity_type')") or
  die($mysqli->error);

  $_SESSION['message'] = "Record has been deleted!";
  $_SESSION['msg_type'] = "danger";

  header("location:".$_SERVER['HTTP_REFERER']);
}
//employee deduction delete process
if (isset($_GET['employeeDeductionDelete'])){
  $edID = $_GET['employeeDeductionDelete'];
  $edName = $_GET['employeeDeductionName'];
  $mysqli->query("UPDATE employeedeductions SET employeeDeductionAmount='0' WHERE edID=$edID AND edName='$edName'") or die($mysqli->error());

  
  $admin_id = $_GET['admin_id'];
  $activity_type = "Delete employee mandatory deduction";

  $time_logged = date("Y-m-d H:i:s",strtotime("now"));
  $mysqli->query("INSERT INTO activity (time_logged, admin_id, activity_type) VALUES ('$time_logged', '$admin_id', '$activity_type')") or
  die($mysqli->error);

  $_SESSION['message'] = "Record has been deleted!";
  $_SESSION['msg_type'] = "danger";

  header("location:".$_SERVER['HTTP_REFERER']);
}

//deduction delete process
if (isset($_GET['deductionDelete'])){
  $deductionId = $_GET['deductionDelete'];
  $mysqli->query("DELETE FROM deductions WHERE deductionId=$deductionId") or die($mysqli->error());

  $_SESSION['message'] = "Record has been deleted!";
  $_SESSION['msg_type'] = "danger";

  header("location:deductions.php");
}
//otherdeduction delete process
if (isset($_GET['otherDeductionDelete'])){
  $otherDeductionId = $_GET['otherDeductionDelete'];
  $mysqli->query("DELETE FROM otherdeductions WHERE otherDeductionId=$otherDeductionId") or die($mysqli->error());

  $_SESSION['message'] = "Record has been deleted!";
  $_SESSION['msg_type'] = "danger";

  header("location:other_deductions.php");
}
//allowance delete process
if (isset($_GET['allowanceDelete'])){
  $allowanceId = $_GET['allowanceDelete'];
  $mysqli->query("DELETE FROM allowance WHERE allowanceId=$allowanceId") or die($mysqli->error());

  $_SESSION['message'] = "Record has been deleted!";
  $_SESSION['msg_type'] = "danger";

  header("location:incentives.php");
}
//department delete process
if (isset($_GET['departmentDelete'])){
  $departmentId = $_GET['departmentDelete'];
  $mysqli->query("DELETE FROM department WHERE departmentId=$departmentId") or die($mysqli->error());

  $_SESSION['message'] = "Record has been deleted!";
  $_SESSION['msg_type'] = "danger";

  header("location:department.php");
}

//position delete process
if (isset($_GET['positionDelete'])){
  $position_id = $_GET['positionDelete'];
  $mysqli->query("DELETE FROM position WHERE id=$position_id") or die($mysqli->error());

  $_SESSION['message'] = "Record has been deleted!";
  $_SESSION['msg_type'] = "danger";

  header("location:position.php");
}
// project delete process
if (isset($_GET['projectDelete'])){
  $project_id = $_GET['projectDelete'];
  $mysqli->query("DELETE FROM project WHERE id=$project_id") or die($mysqli->error());

  $_SESSION['message'] = "Record has been deleted!";
  $_SESSION['msg_type'] = "danger";

  header("location:project.php");
}
//position delete process
if (isset($_GET['project_delete'])){
  $project_id = $_GET['project_delete'];
  $mysqli->query("DELETE FROM project WHERE id=$project_id") or die($mysqli->error());

  $_SESSION['message'] = "Record has been deleted!";
  $_SESSION['msg_type'] = "danger";

  header("location:project.php");
}

//salary delete process
if (isset($_GET['salaryDelete'])){
  $id = $_GET['salaryDelete'];
  $mysqli->query("DELETE FROM allowance WHERE id=$id") or die($mysqli->error());

  $_SESSION['message'] = "Record has been deleted!";
  $_SESSION['msg_type'] = "danger";

  header("location:incentives.php");
}
//edit
if (isset($_GET['edit'])){
    $id = $_GET['edit'];
    $update = true;

    $data_id_result = $mysqli->query("SELECT * FROM data WHERE id=$id") or die($mysqli->error());

   

    if (is_countable($data_id_result) && count($data_id_result) == 1){
        $row = $data_id_result->fetch_array();
        $name = $row['name'];
        $position = $row['position'];
        $sg = $row['sg'];
        $step = $row['step'];
    
    }

   
}
//update
if (isset($_POST['update'])){
    $id = $_POST['id'];
    $name =$_POST['name'];
    $sg =$_POST['sg'];
    $step =$_POST['step'];

    $admin_id = $_POST['admin_id'];
    $activity_type = "update employee record";

    $time_logged = date("Y-m-d H:i:s",strtotime("now"));
    $mysqli->query("INSERT INTO activity (time_logged, admin_id, activity_type) VALUES ('$time_logged', '$admin_id', '$activity_type')") or
    die($mysqli->error);

    $findresults_data= mysqli_query($mysqli, "SELECT * FROM salaryData where salaryStep= '$step' and salaryGrade= '$sg'");
      if($res_data = mysqli_fetch_array($findresults_data))
      {
      $salary = $res_data['salaryAmount']; 
      $position= $res_data['position']; 

      }

   $mysqli->query("UPDATE data SET salary='$salary', name='$name', position='$position', sg='$sg', step='$step' WHERE id=$id") or die($mysqli->error());


   $_SESSION['message'] = "Record has been updated!";
   $_SESSION['msg_type'] = "warning";

   header("location:employees.php");
}


?>




    
