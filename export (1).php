<?php 
// Load the database connection
require_once('db_connect.php');

//CSV Filename
$fname = 'payroll_list.csv';

// Header Row Data: Array
$header = ["ID", "Payroll From", "Payroll To", "Gross Amount", "Net Amount", "Total Deduction"];

// Selecting all records from payroll_list table query
$qry = $conn->query("SELECT payroll_id, payroll_from, payroll_to, gross_amount, net_amount, total_deduction FROM `payroll_history` ORDER BY `payroll_id` ASC");

if($qry->num_rows <= 0){
    echo "<script> alert('No data has been fetched.'); location.href = './'; </script>";
    exit;
}

//Open a File
$file = fopen("php://memory","w");

// Attach Header
fputcsv($file, $header,',');

// Loop the records and put them into the CSV file
while($row = $qry->fetch_assoc()){
    fputcsv($file, [$row['payroll_id'], $row['payroll_from'], $row['payroll_to'], $row['gross_amount'], $row['net_amount'], $row['total_deduction']],',');
}

fseek($file, 0);

// Add headers to download the file
header('Content-Type: text/csv');
header('Content-Disposition: attachment; filename="'.$fname.'";');

// Output the file to the browser
fpassthru($file);
exit;

?>