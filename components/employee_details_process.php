<?php 

$fetch_employee_data = $mysqli->query("SELECT * FROM data WHERE id = $id") or die($mysqli->error);
if($employee_data_result = mysqli_fetch_array($fetch_employee_data))
{
$employee_name = $employee_data_result['name']; 
$position = $employee_data_result['position']; 
$sg = $employee_data_result['sg']; 
$step = $employee_data_result['step']; 
$salary = $employee_data_result['salary']; 
$project = $employee_data_result['project']; 
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
        
        //check if the deduction amount is within the limit
        if ($deduction_limit > 0) {
          if ($final_employeeDeductionAmount > $deduction_limit) {
            $final_employeeDeductionAmount = $deduction_limit;
          }
          else if ($final_employeeDeductionAmount < 0) {
            $final_employeeDeductionAmount = 0;
          }
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
//employeeotherdeductionDelete
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
//insert remark
if(isset($_POST['addRemark'])){
  $employeeId = $_POST['id'];
  $get_other_deduction = $_POST['get_other_deduction'];
  $remark_text = $_POST['remark_text'];

  $admin_id = $_POST['admin_id'];
  $activity_type = "Insert new remark";

  $time_logged = date("Y-m-d H:i:s",strtotime("now"));
  $mysqli->query("INSERT INTO activity (time_logged, admin_id, activity_type) VALUES ('$time_logged', '$admin_id', '$activity_type')") or
  die($mysqli->error);

        $other_deduction_result = $mysqli->query("SELECT * FROM otherdeductions WHERE otherDeductionId=$get_other_deduction") or die($mysqli->error());
        $row = $other_deduction_result->fetch_array();

        
        $employeeOtherDeductionName = $row['otherDeductionName'];
       
        
    $mysqli->query("INSERT INTO remarks( remark_text, emp_id, other_deduction_name) VALUES ('$remark_text', '$employeeId', '$employeeOtherDeductionName')") or
    die($mysqli->error);

  header("location:".$_SERVER['HTTP_REFERER']);
}
//Remark Delete
if (isset($_GET['employeeremarkDelete'])){
  $remark_id = $_GET['employeeremarkDelete'];
  $mysqli->query("DELETE FROM remarks WHERE id=$remark_id") or die($mysqli->error());

  $admin_id = $_GET['admin_id'];
  $activity_type = "Delete employee secondary deduction remarks";

  $time_logged = date("Y-m-d H:i:s",strtotime("now"));
  $mysqli->query("INSERT INTO activity (time_logged, admin_id, activity_type) VALUES ('$time_logged', '$admin_id', '$activity_type')") or
  die($mysqli->error);

  $_SESSION['message'] = "Record has been deleted!";
  $_SESSION['msg_type'] = "danger";

  header("location:".$_SERVER['HTTP_REFERER']);
}
?>