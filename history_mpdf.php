<?php

require_once __DIR__ . '/vendor/autoload.php';
require_once("connection.php");
$mysqli = new mysqli('bsu-info.tech', 'u455679702_cps', 'OpK3RKh]!h9', 'u455679702_cps') or die(mysqli_error($mysqli));
 $id = $_GET['edit'];//get the id from the url
$mpdf = new \Mpdf\Mpdf();
$f='';
$f = new NumberFormatter("en", NumberFormatter::SPELLOUT);

$link = mysqli_connect("bsu-info.tech","u455679702_cps","OpK3RKh]!h9","u455679702_cps");
$pay_history = $mysqli->query("SELECT * FROM payroll_history where emp_id='$id' ") or die($mysqli->error);
while($history_rows = $pay_history->fetch_assoc()) {
      
  $gross_amount = $history_rows['gross_amount'];
   $net_amount = $history_rows['net_amount'];
    $leave_amount = $history_rows['leave_amount'];
     $total_deduction = $history_rows['total_deduction'];
      $employee_name = $history_rows['name'];
        $employee_sg = $history_rows['sg'];
          $employee_step = $history_rows['step'];
            $employee_position = $history_rows['position'];
              $employee_salary = $history_rows['salary'];
                $total_pera = $history_rows['pera'];
                  
 
}
$net_amount_minus_leave = $net_amount - $leave_amount;
$half_month = $net_amount /2;

$html = '';
$html .= '
<div class="row" style="border: 1px solid black;padding:10px;">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.1/dist/css/bootstrap.min.css">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.1/dist/js/bootstrap.bundle.min.js">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js">

 <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.1/dist/css/bootstrap.min.css">
 <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.1/dist/js/bootstrap.bundle.min.js">
 <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js">
    <div align="center"><img src="images/letterhead.png" width="600" height="150"></div>
 <div class="text-center lh-1 mb-2">
                 <h6 style="margin-top:10px;"class="fw-bold"></h6> <span class="fw-normal"></span>
</div>
             <div style="position:absolute;float: left;width: 40%; padding: 10px;">
             <div class="col-md-10">
            
                     
                     <div class="col-md-6">
                         <div> <span class="fw-bolder">Name: </span> <small class="ms-3"></small>'.$employee_name.' </div>
                     </div>
             </div>
             
                     <div class="col-md-6">
                         <div> <span class="fw-bolder">Pay Period: </span> <small class="ms-3">'.date('F Y').'</small> </div>
                     </div>
                     
        
                     <div class="col-md-6">
                         <div> <span class="fw-bolder">Position: </span> <small class="ms-3">'.$employee_position.'</small> </div>
                     </div>
             </div>

                 <div style="float: right; width: 40%;">
                         <div class="col-md-6">
                             <div> <span class="fw-bolder"></span> <small class="ms-3"></small> </div>
                         </div>
                         <div class="col-md-6">
                             <div> <span class="fw-bolder">Salary Grade: </span> <small class="ms-3">'.$employee_sg.'</small> </div>
                         </div>
                  
                 
                         <div class="col-md-6">
                             <div> <span class="fw-bolder">Step: </span> <small class="ms-3">'.$employee_step.'</small> </div>
                         </div>
                         
                    </div>
<br/>
<br/>
<br/>
<br/>
<div class="column" style="float: right; width: 40%;">
<table style="      
                    font-family: arial, sans-serif;
                    border-collapse: collapse;
                   ">

<tbody>';


   
  

$html .= '      <tr><th>Total Deductions: </th>
                <td style="padding-left:10px;">'.number_format($total_deduction,2).'</td>
    </tr>';


   $html .= '</tbody></table></div>';

   $html .= '
   <!--Allowance-->
   
   <div class="column" style="padding-left:10px;float: left; width: 40%;">
    
   <table style=" font-family: arial, sans-serif;
                  border-collapse: collapse;">
<thead>
    <tr>
    
        <th>Earnings</th>
        <hr>
        <th style="padding-left:10px;">Amount</th>
        <hr>
    </tr>
</thead>
<tbody>';







  


    $html .= '<tr align="center">
    <td></td> 
    <td></td>
    
    ';
   $html .= '   <tr><th>PERA </th>
   <td style="padding-left:10px;">'.number_format(floatval($total_pera), 2).'</td>
</tr>';

$html .= '   <tr><th>Salary </th>

<td style="padding-left:10px;">'.number_format(floatval($employee_salary), 2).'</td>
</tr>';
    $html .= '   <tr><th>Gross Amount </th>

    <td style="padding-left:10px;">'.number_format(floatval($gross_amount), 2).'</td>
    </tr>';
     $html .= '   <tr><th>Half Month </th>

    <td style="padding-left:10px;">'.number_format(floatval($half_month), 2).'</td>
    </tr>';

function cents_to_words($amount) {
    $cents = explode('.', $amount)[1];
    $words = '';

    if ($cents > 0) {
        $ones = array('', 'one', 'two', 'three', 'four', 'five', 'six', 'seven', 'eight', 'nine');
        $tens = array('ten', 'eleven', 'twelve', 'thirteen', 'fourteen', 'fifteen', 'sixteen', 'seventeen', 'eighteen', 'nineteen');
        $twenties = array('', '', 'twenty', 'thirty', 'forty', 'fifty', 'sixty', 'seventy', 'eighty', 'ninety');

        if ($cents < 10) {
            $words = $ones[$cents] . ' centavos';
        } elseif ($cents < 20) {
            $words = $tens[$cents - 10] . ' centavos';
        } else {
            $words = $twenties[substr($cents, 0, 1)] . ' ' . $ones[substr($cents, 1, 1)] . ' centavos';
        }
    }

    return $words;
}
   $html .= '</tbody></table></div>
   </div>
   <br/>
   <br/>
   <div class="row">
   <div style="text-align:center;" class="col-md-4">Net Pay : '.number_format($net_amount_minus_leave,2).'</div>
       <div style="text-align:center;" class="d-flex flex-column">
      '. $f->format($net_amount_minus_leave,2).'</div>
   </div>
</div>
<br/>
<br/>
<br/>
<div class="d-flex justify-content-end" style="text-align:right;">
   <div class="d-flex flex-column mt-2"> <span class="fw-bolder"></span> <span class="mt-4">Authorised Signatory</span> </div>
</div>
<hr>
<div class="d-flex justify-content-end" style="text-align:center;">
   <div class="d-flex flex-column mt-2"> <span class="fw-bolder"></span> <span class="mt-4">This is a system generated payslip</span> </div>
</div>
   <style>.column {
    float: left;
    width: 50%;
  }
  
  /* Clear floats after the columns */
  .row:after {
    content: "";
    display: table;
    clear: both;
  }
  .row {
    display: flex;
  }
  
  .column {
    flex: 50%;
  }
  </style>
  
  ';
  
   
$mpdf->WriteHTML($html);
$mpdf->Output();

?>
