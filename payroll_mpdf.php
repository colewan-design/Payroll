<?php

require_once __DIR__ . '/vendor/autoload.php';
require_once("connection.php");
$mysqli = new mysqli('bsu-info.tech', 'u455679702_cps', 'OpK3RKh]!h9', 'u455679702_cps') or die(mysqli_error($mysqli));

$mpdf = new \Mpdf\Mpdf(['mode' => 'utf-8', 'format' => 'A3-L', 'useOddEven' => true]);

$mpdf->SetFont('Arial', '', 14);
$mpdf->shrink_tables_to_fit = 1;
$f='';
$f = new NumberFormatter("en", NumberFormatter::SPELLOUT);
$first_half_date = date('Y-m-15');
$second_half_date = date('Y-m-t', strtotime('+15 days'));

// Add a placeholder for the page number
$mpdf->AliasNbPages();

$html = '';
$html2 = '';
$html .= '<htmlpageheader name="header">
            <div style="padding: 10px; border: 1px solid #ddd;">
            <img src="https://bsu.edu.ph/wp-content/uploads/2019/11/logo.png" height="100" width="100" style="float:left;">
            <img src="https://bsu.edu.ph/wp-content/uploads/2019/11/logo.png" height="100" width="100" style="float:right;">
            <h4 style="margin-top:20px;">Republic of the Philippines</h4>
            <h4>Benguet State University</h4>
            <h4>La Trinidad, Benguet</h4>
            <h4 style="margin-bottom:20px;">Payroll for the Second Half of '.$f->format(date('m', strtotime($second_half_date))).' '.$f->format(date('Y', strtotime($second_half_date))).'</h4>
            </div>
        </htmlpageheader>';
$html .= '<htmlpagefooter name="footer">
            <div style="padding: 10px; border: 1px solid #ddd;">
            <hr>
            <p>Page {PAGENO} of {nbpg}</p>
            </div>
        </htmlpagefooter>';
        $html2 .= '<htmlpageheader name="header">
            <div style="padding: 10px; border: 1px solid #ddd;">
            <img src="https://bsu.edu.ph/wp-content/uploads/2019/11/logo.png" height="100" width="100" style="float:left;">
            <img src="https://bsu.edu.ph/wp-content/uploads/2019/11/logo.png" height="100" width="100" style="float:right;">
            <h4 style="margin-top:20px;">Republic of the Philippines</h4>
            <h4>Benguet State University</h4>
            <h4>La Trinidad, Benguet</h4>
            <h4 style="margin-bottom:20px;">Payroll for the Second Half of '.$f->format(date('m', strtotime($second_half_date))).' '.$f->format(date('Y', strtotime($second_half_date))).'</h4>
            </div>
        </htmlpageheader>';
$html2 .= '<htmlpagefooter name="footer">
            <div style="padding: 10px; border: 1px solid #ddd;">
            <hr>
            <p>Page {PAGENO} of {nbpg}</p>
            </div>
        </htmlpagefooter>';
$html .= '

<div class="row" style="border: 1px solid black;padding:10px;">

<div style="">
<table style="  
font-family: Arial, sans-serif;
            border-collapse: collapse;
            width: 100%;
            margin-bottom: 20px;
            text-align: center;
            border: 1px solid #ddd;
">
<thead>
    <tr style="background-color: #f2f2f2;">
    
    <th rowspan="2" width="200" height="100" style="padding: 10px; border: 1px solid #ddd;">EMPLOYEE NAME</th>
       <th rowspan="2" width="100" height="100" style="padding: 10px; border: 1px solid #ddd;">Position</th>
          <th rowspan="2" width="100" height="100" style="padding: 10px; border: 1px solid #ddd;">SG</th>
             <th rowspan="2" width="100" height="100" style="padding: 10px; border: 1px solid #ddd;">Step</th>
    <th colspan="3" width="100" height="100" style="padding: 10px; border: 1px solid #ddd;">Compensations</th>
    <th colspan="28" width="100" height="100" style="padding: 10px; border: 1px solid #ddd;">Deduction</th>
    

       
    </tr>
    <tr>
    <th style="padding: 10px; border: 1px solid #ddd;" data-field="salary">Basic Salary</th><!--1-->
    <th style="padding: 10px; border: 1px solid #ddd;" data-field="pera">Pera</th><!--2-->
    <th style="padding: 10px; border: 1px solid #ddd;" data-field="gross">Gross Amount</th><!--3-->
    <th style="padding: 10px; border: 1px solid #ddd;" data-field="Withholding">Withholding Tax</th><!--1-->
    <th style="padding: 10px; border: 1px solid #ddd;" data-field="GSIS">GSIS Premium</th><!--2-->
    <th style="padding: 10px; border: 1px solid #ddd;" data-field="gcl">GSIS Conso Loan</th><!--3-->
    <th style="padding: 10px; border: 1px solid #ddd;" data-field="gpl">GSIS Policy Loan</th><!--4-->
    <th style="padding: 10px; border: 1px solid #ddd;" data-field="eal">GSIS EAL</th><!--5-->
    <th style="padding: 10px; border: 1px solid #ddd;" data-field="gel">GSIS Emergency Loan</th><!--6-->
    <th style="padding: 10px; border: 1px solid #ddd;" data-field="gre">GSIS Real Estate</th><!--7-->
    <th style="padding: 10px; border: 1px solid #ddd;" data-field="gol">GSIS Opt Loan</th><!--8-->
    <th style="padding: 10px; border: 1px solid #ddd;" data-field="ouli">GSIS OULI</th><!--9-->
    <th style="padding: 10px; border: 1px solid #ddd;" data-field="gsismpl">GSIS MPL</th><!--10-->
    <th style="padding: 10px; border: 1px solid #ddd;" data-field="cpl">GSIS CPL</th><!--11-->
    <th style="padding: 10px; border: 1px solid #ddd;" data-field="gfallii">GSIS GFAL II</th><!--12-->
    <th style="padding: 10px; border: 1px solid #ddd;" data-field="Philhealth">Philhealth</th><!--13-->
    <th style="padding: 10px; border: 1px solid #ddd;" data-field="HDMF">HDMF Premium</th><!--14-->
   
    </tr>
</thead>
<tbody>';

 $result_data = $mysqli->query("SELECT * FROM data") or die($mysqli_error());
while($row_data = $result_data->fetch_assoc()) :
    $employee_id = $row_data['id']; //id
     $html .= '<tr>
    <td style="page-break-inside: avoid;">'.$row_data['name'].'</td>
     <td style="page-break-inside: avoid;">'.$row_data['position'].'</td>
      <td style="page-break-inside: avoid;">'.$row_data['sg'].'</td>
       <td style="page-break-inside: avoid;">'.$row_data['step'].'</td>
        <td style="page-break-inside: avoid;">'.$row_data['salary'].'</td>';
  $result_pera = $mysqli->query("SELECT * FROM employeeallowance WHERE employeeId=$employee_id") or die($mysqli->error);

  // get pera
  while($row_pera = $result_pera->fetch_array()) {
    $pera = $row_pera['employeeallowanceAmount'];
    $html .= '<td>'.$pera.' </td>';
  }
  //get gross_amount
   $result_allowance = $mysqli->query("SELECT * FROM payroll_list WHERE emp_id=$employee_id") or die(mysqli_error());
    $row_allowance = $result_allowance->fetch_array();
     $gross = $row_allowance['gross_amount'];
$html .= '<td>'.$gross.' </td>';
//get wht
  $result_wht = $mysqli->query("SELECT * FROM employeedeductions WHERE employeeId=$employee_id AND edName='Withholding Tax';") or die(mysqli_error());
     $row_wht = $result_wht->fetch_array();
     $wht = $row_wht['employeeDeductionAmount'];
     $html .= '<td>'.$wht.' </td>';
     //get gsis
       $result_gsis = $mysqli->query("SELECT * FROM employeedeductions WHERE employeeId=$employee_id AND edName='GSIS';") or die(mysqli_error());
     $row_gsis = $result_gsis->fetch_array();
     $gsis = $row_gsis['employeeDeductionAmount'];
          $html .= '<td>'.$gsis.' </td>';
          //get gcl
      $result_gcl = $mysqli->query("SELECT * FROM employeedeductions WHERE employeeId=$employee_id AND edName='GSIS Conso Loan';") or die(mysqli_error());
     $row_gcl = $result_gcl->fetch_array();
     $gcl = $row_gcl['employeeDeductionAmount'];
      $html .= '<td>'.$gcl.' </td>';
      //get gpl
      $result_gpl = $mysqli->query("SELECT * FROM employeedeductions WHERE employeeId=$employee_id AND edName='GSIS Policy Loan';") or die(mysqli_error());
     $row_gpl = $result_gpl->fetch_array();
     $gpl = $row_gpl['employeeDeductionAmount'];
     $html .= '<td>'.$gpl.' </td>';
     //get eal
     $result_eal = $mysqli->query("SELECT * FROM employeedeductions WHERE employeeId=$employee_id AND edName='GSIS EAL';") or die(mysqli_error());
     $row_eal = $result_eal->fetch_array();
     $eal = $row_eal['employeeDeductionAmount'];
      $html .= '<td>'.$eal.' </td>';
      //get gel
        $result_gel = $mysqli->query("SELECT * FROM employeedeductions WHERE employeeId=$employee_id AND edName='GSIS Emergency Loan';") or die(mysqli_error());
     $row_gel = $result_gel->fetch_array();
     $gel = $row_gel['employeeDeductionAmount'];
     $html .= '<td>'.$gel.' </td>';
     //get gre
      $result_gre = $mysqli->query("SELECT * FROM employeedeductions WHERE employeeId=$employee_id AND edName='GSIS Real Estate';") or die(mysqli_error());
     $row_gre = $result_gre->fetch_array();
     $gre = $row_gre['employeeDeductionAmount'];
     $html .= '<td>'.$gre.' </td>';
     //get gol
      $result_gol = $mysqli->query("SELECT * FROM employeedeductions WHERE employeeId=$employee_id AND edName='GSIS Opt Loan';") or die(mysqli_error());
     $row_gol = $result_gol->fetch_array();
     $gol = $row_gol['employeeDeductionAmount'];
     $html .= '<td>'.$gol.' </td>';
     //get ouli
     $result_ouli = $mysqli->query("SELECT * FROM employeedeductions WHERE employeeId=$employee_id AND edName='GSIS OULI';") or die(mysqli_error());
    $row_ouli = $result_ouli->fetch_array();
    $ouli = $row_ouli['employeeDeductionAmount'];
    $html .= '<td>'.$ouli.' </td>';
    //get mpl
    $result_mpl = $mysqli->query("SELECT * FROM employeedeductions WHERE employeeId=$employee_id AND edName='GSIS MPL';") or die(mysqli_error());
    $row_mpl = $result_mpl->fetch_array();
    $mpl = $row_mpl['employeeDeductionAmount'];
    $html .= '<td>'.$mpl.' </td>';
    //get cpl
    $result_cpl = $mysqli->query("SELECT * FROM employeedeductions WHERE employeeId=$employee_id AND edName='GSIS CPL';") or die(mysqli_error());
    $row_cpl = $result_cpl->fetch_array();
    $cpl = $row_cpl['employeeDeductionAmount'];
     $html .= '<td>'.$cpl.' </td>';
     //get gfallii
     $result_gfallii = $mysqli->query("SELECT * FROM employeedeductions WHERE employeeId=$employee_id AND edName='GSIS GFAL II';") or die(mysqli_error());
    $row_gfallii = $result_gfallii->fetch_array();
    $gfallii = $row_gfallii['employeeDeductionAmount'];
      $html .= '<td>'.$gfallii.' </td>';
      //get Philhealth
      $result_Philhealth = $mysqli->query("SELECT * FROM employeedeductions WHERE employeeId=$employee_id AND edName='Philhealth';") or die(mysqli_error());
     $row_Philhealth = $result_Philhealth->fetch_array();
     $Philhealth = $row_Philhealth['employeeDeductionAmount'];
       $html .= '<td>'.$Philhealth.' </td>';
       //get HDMF
         $result_HDMF = $mysqli->query("SELECT * FROM employeedeductions WHERE employeeId=$employee_id AND edName='HDMF Premium';") or die(mysqli_error());
     $row_HDMF = $result_HDMF->fetch_array();
     $HDMF = $row_HDMF['employeeDeductionAmount'];
     $html .= '<td>'.$HDMF.' </td>';
  $html .= '</tr>';

    
  endwhile;
   $html .= '</tbody></table></div>';

   $html .= '
   
   
   </div>
  
  ';
  
$stylesheet = file_get_contents('css/dist/css/bootstrap.min.css');
$mpdf->SetDisplayMode('fullpage');
$mpdf->SetWatermarkText("CBOO Payroll");
$mpdf->SetAuthor("BSU-CBOO");
$mpdf->showWatermarkText = true;
$mpdf->watermark_font = 'DejaVuSansCondensed';
$mpdf->watermarkTextAlpha = 0.1;
$mpdf->SetProtection(array('print'));
$mpdf->SetTitle("CBOO - Payroll Report");
$mpdf->WriteHTML($stylesheet, 1); // CSS Script goes here.
$mpdf->WriteHTML($html, 2);


$mpdf->AddPage();


$html2 .= "
<div style='border: 1px solid black; padding: 10px;'>
    <div style=''>
        <table style='
            font-family: Arial, sans-serif;
            border-collapse: collapse;
            width: 100%;
            margin-bottom: 20px;
            text-align: center;
            border: 1px solid #ddd;
        '>
            <thead>
                <tr style='background-color: #f2f2f2;'>
                    <th colspan='14' height='100' style='padding: 10px; border: 1px solid #ddd;'>
                        Deduction
                    </th>
                    <th rowspan='2' width='200' style='padding: 10px; border: 1px solid #ddd;'>
                        Total Deductions
                    </th>
                    <th rowspan='2' width='200' style='padding: 10px; border: 1px solid #ddd;'>
                        Net Amount Due
                    </th>
                    <th rowspan='2' width='200' style='padding: 10px; border: 1px solid #ddd;'>
                        Net Amount For $first_half_date
                    </th>
                    <th rowspan='2' width='200' style='padding: 10px; border: 1px solid #ddd;'>
                        Net Amount For $second_half_date
                    </th>
                    <th rowspan='2' width='200' style='padding: 10px; border: 1px solid #ddd;'>
                        Remarks
                    </th>
                </tr>
                <tr>
                    <th style='padding: 10px; border: 1px solid #ddd;' data-field='HDMFMPL'>HDMF MPL</th><!--15-->
                    <th style='padding: 10px; border: 1px solid #ddd;' data-field='HDMFCPL'>HDMF CL</th><!--16-->
                    <th style='padding: 10px; border: 1px solid #ddd;' data-field='BSUCMPC'>BSUCMPC</th><!--17-->
                    <th width='200' style='padding: 10px; border: 1px solid #ddd;' data-field='cbs'>
                        China Bank Savings
                    </th><!--18-->
                    <th style='padding: 10px; border: 1px solid #ddd;' data-field='Landbank'>Landbank</th><!--19-->
                    <th style='padding: 10px; border: 1px solid #ddd;' data-field='pl'>Phil life</th><!--22-->
                    <th style='padding: 10px; border: 1px solid #ddd;' data-field='coco'>Coco</th><!--23-->
                    <th style='padding: 10px; border: 1px solid #ddd;' data-field='pa'>Phil Am</th><!--24-->
                    <th style='padding: 10px; border: 1px solid #ddd;' data-field='PPSTA'>PPSTA</th><!--25-->
                    <th style='padding: 10px; border: 1px solid #ddd;' data-field='Water'>Water</th><!--26-->
                    <th style='padding: 10px; border: 1px solid #ddd;' data-field='Electric'>Electric</th><!--27-->
                <th style='padding: 10px; border: 1px solid #ddd;' data-field='COA'>COA-ND</th><!--28-->
                   <th style='padding: 10px; border: 1px solid #ddd;' data-field='UCPBS'>UCPBS</th><!--21-->
                    <th style='padding: 10px; border: 1px solid #ddd;' data-field='bhr'>BSU Housing Occupancy Fee</th><!--20-->
               
                   
                </tr>
     
</thead>
<tbody>";
$employee_result = $mysqli->query("SELECT * FROM data") or die($mysqli->error);
while($row = $employee_result->fetch_assoc()):
    $html2 .= '<tr>
   ';

$employee_id = $row['id']; //id
   //get hdmf mpl
$result_HDMFMPL = $mysqli->query("SELECT * FROM employeeotherdeductions WHERE employeeId=$employee_id AND employeeOtherDeductionName='HDMF MPL';") or die($mysqli->error());
$row_HDMFMPL = $result_HDMFMPL->fetch_array();
$HDMFMPL = $row_HDMFMPL['employeeOtherDeductionAmount'];
$html2 .= '<td>'.$HDMFMPL.'</td>';

//get hdmf mcl
$result_HDMFCL = $mysqli->query("SELECT * FROM employeeotherdeductions WHERE employeeId=$employee_id AND employeeOtherDeductionName='HDMF CL';") or die($mysqli->error());
$row_HDMFCL = $result_HDMFCL->fetch_array();
$HDMFCL = $row_HDMFCL['employeeOtherDeductionAmount'];
$html2 .= '<td>'.$HDMFCL.'</td>';

$result_BSUCMPC = $mysqli->query("SELECT * FROM employeeotherdeductions WHERE employeeId=$employee_id AND employeeOtherDeductionName='BSUCMPC';") or die($mysqli->error());
$row_BSUCMPC = $result_BSUCMPC->fetch_array();
$BSUCMPC = $row_BSUCMPC['employeeOtherDeductionAmount'];
$html2 .= '<td>'.$BSUCMPC.'</td>';

$result_CBS = $mysqli->query("SELECT * FROM employeeotherdeductions WHERE employeeId=$employee_id AND employeeOtherDeductionName='China Bank Savings';") or die($mysqli->error());
$row_CBS = $result_CBS->fetch_array();
$CBS = $row_CBS['employeeOtherDeductionAmount'];
$html2 .= '<td>'.$CBS.'</td>';

$result_Landbank = $mysqli->query("SELECT * FROM employeeotherdeductions WHERE employeeId=$employee_id AND employeeOtherDeductionName='Landbank';") or die($mysqli->error());
$row_Landbank = $result_Landbank->fetch_array();
$Landbank = $row_Landbank['employeeOtherDeductionAmount'];
$html2 .= '<td>'.$Landbank.'</td>';





$result_pl = $mysqli->query("SELECT * FROM employeeotherdeductions WHERE employeeId=$employee_id AND employeeOtherDeductionName='Phil life';") or die($mysqli->error());
$row_pl = $result_pl->fetch_array();
$pl = $row_pl['employeeOtherDeductionAmount'];
$html2 .= '<td>'.$pl.'</td>';

$result_Coco = $mysqli->query("SELECT * FROM employeeotherdeductions WHERE employeeId=$employee_id AND employeeOtherDeductionName='Coco';") or die($mysqli->error());
$row_Coco = $result_Coco->fetch_array();
$Coco = $row_Coco['employeeOtherDeductionAmount'];
$html2 .= '<td>'.$Coco.'</td>';

$result_pa = $mysqli->query("SELECT * FROM employeeotherdeductions WHERE employeeId=$employee_id AND employeeOtherDeductionName='Phil Am';") or die($mysqli->error());
$row_pa = $result_pa->fetch_array();
$pa = $row_pa['employeeOtherDeductionAmount'];
$html2 .= '<td>'.$pa.'</td>';

$result_PPSTA = $mysqli->query("SELECT * FROM employeeotherdeductions WHERE employeeId=$employee_id AND employeeOtherDeductionName='PPSTA';") or die($mysqli->error());
$row_PPSTA = $result_PPSTA->fetch_array();
$PPSTA = $row_PPSTA['employeeOtherDeductionAmount'];
$html2 .= '<td>'.$PPSTA.'</td>';

$result_Water = $mysqli->query("SELECT * FROM employeeotherdeductions WHERE employeeId=$employee_id AND employeeOtherDeductionName='Water';") or die($mysqli->error());
$row_Water = $result_Water->fetch_array();
$Water = $row_Water['employeeOtherDeductionAmount'];
$html2 .= '<td>'.$Water.'</td>';

$result_Electric = $mysqli->query("SELECT * FROM employeeotherdeductions WHERE employeeId=$employee_id AND employeeOtherDeductionName='Electric';") or die($mysqli->error());
$row_Electric = $result_Electric->fetch_array();
$Electric = $row_Electric['employeeOtherDeductionAmount'];
$html2 .= '<td>'.$Electric.'</td>';

$result_COAND = $mysqli->query("SELECT * FROM employeeotherdeductions WHERE employeeId=$employee_id AND employeeOtherDeductionName='COA-ND';") or die($mysqli->error());
$row_COAND = $result_COAND->fetch_array();
$COAND = $row_COAND['employeeOtherDeductionAmount'];
$html2 .= '<td>'.$COAND.'</td>';

$result_UCPBS = $mysqli->query("SELECT * FROM employeeotherdeductions WHERE employeeId=$employee_id AND employeeOtherDeductionName='UCPBS';") or die($mysqli->error());
$row_UCPBS = $result_UCPBS->fetch_array();
$UCPBS = $row_UCPBS['employeeOtherDeductionAmount'];
$html2 .= '<td>'.$UCPBS.'</td>';

$result_BHOF = $mysqli->query("SELECT * FROM employeeotherdeductions WHERE employeeId=$employee_id AND employeeOtherDeductionName='BSU Housing Occupancy Fee';") or die($mysqli->error());
$row_BHOF = $result_BHOF->fetch_array();
$BHOF = $row_BHOF['employeeOtherDeductionAmount'];
$html2 .= '<td>'.$BHOF.'</td>';






// Get total employeeDeductionAmount from employeedeductions table
$result_deduction = $mysqli->query("SELECT SUM(employeeDeductionAmount) AS total_deduction FROM employeedeductions WHERE employeeId = $employee_id") or die($mysqli->error);
$row_deduction = $result_deduction->fetch_assoc();
$mandatory_total_deduction = $row_deduction['total_deduction'];

// Get total employeeOtherDeductionAmount from employeeotherdeductions table
$result_other_deduction = $mysqli->query("SELECT SUM(employeeOtherDeductionAmount) AS total_other_deduction FROM employeeotherdeductions WHERE employeeId = $employee_id") or die($mysqli->error);
$row_other_deduction = $result_other_deduction->fetch_assoc();
$total_other_deduction = $row_other_deduction['total_other_deduction'];
$total_deduction = ($mandatory_total_deduction + $total_other_deduction);
$html2 .= '<td>'.$total_deduction.'</td>';


$net_amount = $gross - $total_deduction;
$html2 .= '<td>'.$net_amount.'</td>';
$half_month = ($net_amount/2);
$html2 .= '<td>'.$half_month.'</td>';
$html2 .= '<td>'.$half_month.'</td>';
$employee_remarks = '';
$result_remarks = $mysqli->query("SELECT * FROM remarks WHERE emp_id=$employee_id") or die($mysqli->error());
while ($row_remarks = mysqli_fetch_array($result_remarks)) {
    $employee_remarks .= $row_remarks['other_deduction_name'] . ' - ' . $row_remarks['remark_text'] . ', ';
}
$html2 .= '<td>'.$employee_remarks.'</td>';
    endwhile; 
   $html2 .= '</tr></tbody></table></div>';

   $html2 .= '
   
   
   </div>
  
  ';
  

$mpdf->WriteHTML($stylesheet, 1); // CSS Script goes here.
$mpdf->WriteHTML($html2, 2);



$mpdf->Output();

?>
