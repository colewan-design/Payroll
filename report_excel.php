<?php
require 'vendor/autoload.php';

$spreadsheet = new \PhpOffice\PhpSpreadsheet\Spreadsheet();
$worksheet = $spreadsheet->getActiveSheet();

$worksheet->setPrintGridlines(true);
//align all text to center
$spreadsheet->getActiveSheet()->getStyle('A1:Z1000')->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
$spreadsheet->getActiveSheet()->getStyle('A1:Z1000')->getAlignment()->setVertical(\PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER);


$worksheet->getColumnDimension('A')->setAutoSize(true);
$worksheet->getColumnDimension('B')->setAutoSize(true);
$worksheet->getColumnDimension('C')->setAutoSize(true);
$worksheet->getColumnDimension('D')->setAutoSize(true);
$worksheet->getColumnDimension('E')->setAutoSize(true);
$worksheet->getColumnDimension('F')->setAutoSize(true);
$worksheet->getColumnDimension('G')->setAutoSize(true);
$worksheet->getColumnDimension('H')->setAutoSize(true);
$worksheet->getColumnDimension('I')->setAutoSize(true);
$worksheet->getColumnDimension('J')->setAutoSize(true);
$worksheet->getColumnDimension('K')->setAutoSize(true);
$worksheet->getColumnDimension('L')->setAutoSize(true);
$worksheet->getColumnDimension('M')->setAutoSize(true);
$worksheet->getColumnDimension('N')->setAutoSize(true);
$worksheet->getColumnDimension('O')->setAutoSize(true);
$worksheet->getColumnDimension('P')->setAutoSize(true);
$worksheet->getColumnDimension('Q')->setAutoSize(true);
$worksheet->getColumnDimension('R')->setAutoSize(true);
$worksheet->getColumnDimension('S')->setAutoSize(true);
$worksheet->getColumnDimension('T')->setAutoSize(true);
$worksheet->getColumnDimension('U')->setAutoSize(true);
$worksheet->getColumnDimension('V')->setAutoSize(true);
$worksheet->getColumnDimension('W')->setAutoSize(true);
$worksheet->getColumnDimension('X')->setAutoSize(true);
$worksheet->getColumnDimension('Y')->setAutoSize(true);
$worksheet->getColumnDimension('Z')->setAutoSize(true);
$worksheet->getColumnDimension('AA')->setAutoSize(true);
$worksheet->getColumnDimension('AB')->setAutoSize(true);
$worksheet->getColumnDimension('AC')->setAutoSize(true);
$worksheet->getColumnDimension('AD')->setAutoSize(true);
$worksheet->getColumnDimension('AE')->setAutoSize(true);
$worksheet->getColumnDimension('AF')->setAutoSize(true);
$worksheet->getColumnDimension('AG')->setAutoSize(true);
$worksheet->getColumnDimension('AH')->setAutoSize(true);
$worksheet->getColumnDimension('AI')->setAutoSize(true);
$worksheet->getColumnDimension('AJ')->setAutoSize(true);
$worksheet->getColumnDimension('AK')->setAutoSize(true);
$worksheet->getColumnDimension('AL')->setAutoSize(true);
$worksheet->getColumnDimension('AM')->setAutoSize(true);
$worksheet->getColumnDimension('AN')->setAutoSize(true);

$worksheet->getRowDimension(1)->setRowHeight(30);
$mysqli = new mysqli('bsu-info.tech', 'u455679702_cps', 'OpK3RKh]!h9', 'u455679702_cps') or die(mysqli_error($mysqli));   

//chaning text alignment
$cell_C = $worksheet->getCell('C1');
$cell_C->getStyle()->getAlignment()->setTextRotation(90);
$cell_D = $worksheet->getCell('D1');
$cell_D->getStyle()->getAlignment()->setTextRotation(90);
// Set the column headers
$worksheet->mergeCells("A1:A2");
$worksheet->setCellValue("A1", "Name");
$worksheet->mergeCells("B1:B2");
$worksheet->setCellValue("B1", "Position");
$worksheet->mergeCells("C1:C2");
$worksheet->setCellValue("C1", "SG");
$worksheet->mergeCells("D1:D2");
$worksheet->setCellValue("D1", "STEP");

$worksheet->setCellValue("E2", "BASIC SALARY");
$worksheet->setCellValue("F2", "PERA");
$worksheet->mergeCells("E1:G1");
$worksheet->setCellValue("E1", "COMPENSATION");
$worksheet->setCellValue("G2", "GROSS AMOUNT");
$worksheet->mergeCells("H1:AI1");
$worksheet->setCellValue("H1", "DEDUCTIONS");
$worksheet->setCellValue("H2", "WITHHOLDING TAX");
$worksheet->setCellValue("I2", "GSIS PREMIUM");
$worksheet->setCellValue("J2", "GSIS CONSO LOAN");
$worksheet->setCellValue("K2", "GSIS EMERGENCY LOAN");
$worksheet->setCellValue("L2", "GSIS EAL");
$worksheet->setCellValue("M2", "GSIS Policy Loan");
$worksheet->setCellValue("N2", "GSIS Opt Loan");
$worksheet->setCellValue("O2", "GSIS Real Estate");
$worksheet->setCellValue("P2", "GSIS OULI");
$worksheet->setCellValue("Q2", "GSIS GFAL II");
$worksheet->setCellValue("R2", "GSIS MPL");
$worksheet->setCellValue("S2", "GSIS CPL");
$worksheet->setCellValue("T2", "Phil Health");
$worksheet->setCellValue("U2", "HDMF Premium");
$worksheet->setCellValue("V2", "HDMF MPL");
$worksheet->setCellValue("W2", "HDMF CL");
$worksheet->setCellValue("X2", "BSUCMPC");
$worksheet->setCellValue("Y2", "Landbank Loan");
$worksheet->setCellValue("Z2", "China Bank Savings");
$worksheet->setCellValue("AA2", "Phil Life (All Asia)");
$worksheet->setCellValue("AB2", "Coco Premium");
$worksheet->setCellValue("AC2", "AIA Phil Life and GIC,Inc. (Phil Am)");
$worksheet->setCellValue("AD2", "PPSTA");
$worksheet->setCellValue("AE2", "Water");
$worksheet->setCellValue("AF2", "Electric");
$worksheet->setCellValue("AG2", "COA-ND");
$worksheet->setCellValue("AH2", "UCPBS");
$worksheet->setCellValue("AI2", "BSU Housing Occupancy Fee");
$worksheet->setCellValue("M2", "GSIS Policy Loan");
$worksheet->setCellValue("N2", " GSIS Opt Loan");
$worksheet->setCellValue("O2", "GSIS Real Estate");
$worksheet->setCellValue("P2", "GSIS OULI");
$worksheet->setCellValue("Q2", "GSIS GFAL II");
$worksheet->setCellValue("R2", "GSIS MPL");
$worksheet->setCellValue("S2", "GSIS CPL");
$worksheet->setCellValue("T2", "Phil Health");
$worksheet->setCellValue("U2", "HDMF Premium");
$worksheet->setCellValue("V2", "HDMF MPL");
$worksheet->setCellValue("W2", "HDMF CL");
$worksheet->setCellValue("X2", "BSUCMPC");
$worksheet->setCellValue("Y2", "Landbank Loan");
$worksheet->setCellValue("Z2", "China Bank Savings");
$worksheet->setCellValue("AA2", "Phil Life (All Asia)");
$worksheet->setCellValue("AB2", "Coco Premium");
$worksheet->setCellValue("AC2", "AIA Phil Life and GIC,Inc. (Phil Am)");
$worksheet->setCellValue("AD2", "PPSTA");
$worksheet->setCellValue("AE2", "Water");
$worksheet->setCellValue("AF2", "Electric");
$worksheet->setCellValue("AG2", "COA-ND");
$worksheet->setCellValue("AH2", "UCPBS");
$worksheet->setCellValue("AI2", "BSU Housing Occupancy Fee");
$worksheet->mergeCells("AJ1:AJ2");
$worksheet->setCellValue("AJ1", "TOTAL DEDUCTIONS");
$worksheet->mergeCells("AK1:AK2");
$worksheet->setCellValue("AK1", "NET AMOUNT DUE");
$worksheet->mergeCells("AL1:AL2");
$date = new DateTime();
$first_half_date = date('Y-m-15');
$second_half_date = date('Y-m-t', strtotime('+15 days'));
$worksheet->setCellValue("AL1", "NET AMOUNT For ". $first_half_date);
$worksheet->mergeCells("AM1:AM2");
$worksheet->setCellValue("AM1", "NET AMOUNT For ".$second_half_date);
$worksheet->mergeCells("AN1:AN2");
$worksheet->setCellValue("AN1", "REMARKS");


$worksheet->getStyle('E3:AZ1000')->getNumberFormat()->setFormatCode('#,##0.00');
// Write the data from table1
$row = 3;
// Query to get data from table1
$result_data = $mysqli->query("SELECT * FROM data") or die($mysqli_error());
while($row_data = $result_data->fetch_assoc()) :
    $employee_id = $row_data['id']; //id
    $worksheet->setCellValue("A" . $row, $row_data['name']);
    $worksheet->setCellValue("B" . $row, $row_data['position']);
    $worksheet->setCellValue("C" . $row, $row_data['sg']);
    $worksheet->setCellValue("D" . $row, $row_data['step']);
    $worksheet->setCellValue("E" . $row, $row_data['salary']);
    
    // Query to get data from table2
    $result_pera = $mysqli->query("SELECT * FROM employeeallowance WHERE employeeId=$employee_id") or die($mysqli_error());

    // Write the data from table2
    
    $row_pera = $result_pera->fetch_array();
    $pera = $row_pera['employeeallowanceAmount'];
    $worksheet->setCellValue("F" . $row, $pera);//pera
    $result_allowance = $mysqli->query("SELECT * FROM payroll_list WHERE emp_id=$employee_id") or die(mysqli_error());
    $row_allowance = $result_allowance->fetch_array();
     $gross = $row_allowance['gross_amount'];
     $worksheet->setCellValue("G" . $row, $gross);//gross
     $result_wht = $mysqli->query("SELECT * FROM employeedeductions WHERE employeeId=$employee_id AND edName='Withholding Tax';") or die(mysqli_error());
     $row_wht = $result_wht->fetch_array();
     $wht = $row_wht['employeeDeductionAmount'];
     $worksheet->setCellValue("H" . $row, $wht);//wht
     $result_gsis = $mysqli->query("SELECT * FROM employeedeductions WHERE employeeId=$employee_id AND edName='GSIS';") or die(mysqli_error());
     $row_gsis = $result_gsis->fetch_array();
     $gsis = $row_gsis['employeeDeductionAmount'];
     $worksheet->setCellValue("I" . $row, $gsis);//gsis
     $result_gcl = $mysqli->query("SELECT * FROM employeedeductions WHERE employeeId=$employee_id AND edName='GSIS Conso Loan';") or die(mysqli_error());
     $row_gcl = $result_gcl->fetch_array();
     $gcl = $row_gcl['employeeDeductionAmount'];
     $worksheet->setCellValue("J" . $row, $gcl);//gcl
     $result_gpl = $mysqli->query("SELECT * FROM employeedeductions WHERE employeeId=$employee_id AND edName='GSIS Policy Loan';") or die(mysqli_error());
     $row_gpl = $result_gpl->fetch_array();
     $gpl = $row_gpl['employeeDeductionAmount'];
     $worksheet->setCellValue("K" . $row, $gpl);//gpl
     $result_eal = $mysqli->query("SELECT * FROM employeedeductions WHERE employeeId=$employee_id AND edName='GSIS EAL';") or die(mysqli_error());
     $row_eal = $result_eal->fetch_array();
     $eal = $row_eal['employeeDeductionAmount'];
     $worksheet->setCellValue("L" . $row, $eal);//eal
     $result_gel = $mysqli->query("SELECT * FROM employeedeductions WHERE employeeId=$employee_id AND edName='GSIS Emergency Loan';") or die(mysqli_error());
     $row_gel = $result_gel->fetch_array();
     $gel = $row_gel['employeeDeductionAmount'];
     $worksheet->setCellValue("M" . $row, $gel);//gel
     $result_gre = $mysqli->query("SELECT * FROM employeedeductions WHERE employeeId=$employee_id AND edName='GSIS Real Estate';") or die(mysqli_error());
     $row_gre = $result_gre->fetch_array();
     $gre = $row_gre['employeeDeductionAmount'];
     $worksheet->setCellValue("N" . $row, $gre);//gre
     $result_gol = $mysqli->query("SELECT * FROM employeedeductions WHERE employeeId=$employee_id AND edName='GSIS Opt Loan';") or die(mysqli_error());
     $row_gol = $result_gol->fetch_array();
     $gol = $row_gol['employeeDeductionAmount'];
     $worksheet->setCellValue("O" . $row, $gol);//gol
     $result_ouli = $mysqli->query("SELECT * FROM employeedeductions WHERE employeeId=$employee_id AND edName='GSIS OULI';") or die(mysqli_error());
    $row_ouli = $result_ouli->fetch_array();
    $ouli = $row_ouli['employeeDeductionAmount'];
    $worksheet->setCellValue("P" . $row, $ouli);//ouli
    $result_mpl = $mysqli->query("SELECT * FROM employeedeductions WHERE employeeId=$employee_id AND edName='GSIS MPL';") or die(mysqli_error());
    $row_mpl = $result_mpl->fetch_array();
    $mpl = $row_mpl['employeeDeductionAmount'];
    $worksheet->setCellValue("Q" . $row, $mpl);//mpl
    $result_cpl = $mysqli->query("SELECT * FROM employeedeductions WHERE employeeId=$employee_id AND edName='GSIS CPL';") or die(mysqli_error());
    $row_cpl = $result_cpl->fetch_array();
    $cpl = $row_cpl['employeeDeductionAmount'];
    $worksheet->setCellValue("R" . $row, $cpl);//cpl
    $result_gfallii = $mysqli->query("SELECT * FROM employeedeductions WHERE employeeId=$employee_id AND edName='GSIS GFAL II';") or die(mysqli_error());
    $row_gfallii = $result_gfallii->fetch_array();
    $gfallii = $row_gfallii['employeeDeductionAmount'];
    $worksheet->setCellValue("S" . $row, $gfallii);//gfallii
    $result_Philhealth = $mysqli->query("SELECT * FROM employeedeductions WHERE employeeId=$employee_id AND edName='Philhealth';") or die(mysqli_error());
     $row_Philhealth = $result_Philhealth->fetch_array();
     $Philhealth = $row_Philhealth['employeeDeductionAmount'];
     $worksheet->setCellValue("T" . $row, $Philhealth);//Philhealth
     $result_HDMF = $mysqli->query("SELECT * FROM employeedeductions WHERE employeeId=$employee_id AND edName='HDMF Premium';") or die(mysqli_error());
     $row_HDMF = $result_HDMF->fetch_array();
     $HDMF = $row_HDMF['employeeDeductionAmount'];
     $worksheet->setCellValue("U" . $row, $HDMF);//HDMF
     $result_HDMFMPL = $mysqli->query("SELECT * FROM employeedeductions WHERE employeeId=$employee_id AND edName='HDMF MPL';") or die(mysqli_error());
     $row_HDMFMPL = $result_HDMFMPL->fetch_array();
     $HDMFMPL = $row_HDMFMPL['employeeDeductionAmount'];
     $worksheet->setCellValue("V" . $row, $HDMFMPL);//HDMFMPL
     $result_HDMFCL = $mysqli->query("SELECT * FROM employeedeductions WHERE employeeId=$employee_id AND edName='HDMF CL';") or die(mysqli_error());
     $row_HDMFCL = $result_HDMFCL->fetch_array();
     $HDMFCL = $row_HDMFCL['employeeDeductionAmount'];
     $worksheet->setCellValue("W" . $row, $HDMFCL);//HDMFCL
     $result_BSUCMPC = $mysqli->query("SELECT * FROM employeedeductions WHERE employeeId=$employee_id AND edName='BSUCMPC';") or die(mysqli_error());
     $row_BSUCMPC = $result_BSUCMPC->fetch_array();
     $BSUCMPC = $row_BSUCMPC['employeeDeductionAmount'];
     $worksheet->setCellValue("X" . $row, $BSUCMPC);//BSUCMPC
     $result_CBS = $mysqli->query("SELECT * FROM employeedeductions WHERE employeeId=$employee_id AND edName='China Bank Savings';") or die(mysqli_error());
     $row_CBS = $result_CBS->fetch_array();
     $CBS = $row_CBS['employeeDeductionAmount'];
     $worksheet->setCellValue("Y" . $row, $CBS);//CBS
     $result_Landbank = $mysqli->query("SELECT * FROM employeedeductions WHERE employeeId=$employee_id AND edName='Landbank';") or die(mysqli_error());
     $row_Landbank = $result_Landbank->fetch_array();
     $Landbank = $row_Landbank['employeeDeductionAmount'];
     $worksheet->setCellValue("Z" . $row, $Landbank);//Landbank
     $result_bhr = $mysqli->query("SELECT * FROM employeedeductions WHERE employeeId=$employee_id AND edName='BSU Housing Rent';") or die(mysqli_error());
    $row_bhr = $result_bhr->fetch_array();
    $bhr = $row_bhr['employeeDeductionAmount'];
    $worksheet->setCellValue("AA" . $row, $bhr);//bhr
    $result_UCPBS = $mysqli->query("SELECT * FROM employeedeductions WHERE employeeId=$employee_id AND edName='UCPBS';") or die(mysqli_error());
    $row_UCPBS = $result_UCPBS->fetch_array();
    $UCPBS = $row_UCPBS['employeeDeductionAmount'];
    $worksheet->setCellValue("AB" . $row, $UCPBS);//UCPBS
    $result_pl = $mysqli->query("SELECT * FROM employeedeductions WHERE employeeId=$employee_id AND edName='Phil life';") or die(mysqli_error());
    $row_pl = $result_pl->fetch_array();
    $pl = $row_pl['employeeDeductionAmount'];
    $worksheet->setCellValue("AC" . $row, $pl);//pl
    $result_Coco = $mysqli->query("SELECT * FROM employeedeductions WHERE employeeId=$employee_id AND edName='Coco';") or die(mysqli_error());
    $row_Coco = $result_Coco->fetch_array();
    $Coco = $row_Coco['employeeDeductionAmount'];
    $worksheet->setCellValue("AD" . $row, $Coco);//Coco
    $result_pa = $mysqli->query("SELECT * FROM employeedeductions WHERE employeeId=$employee_id AND edName='Phil Am';") or die(mysqli_error());
    $row_pa = $result_pa->fetch_array();
    $pa = $row_pa['employeeDeductionAmount'];
    $worksheet->setCellValue("AE" . $row, $pa);//pa
    $result_PPSTA = $mysqli->query("SELECT * FROM employeedeductions WHERE employeeId=$employee_id AND edName='PPSTA';") or die(mysqli_error());
    $row_PPSTA = $result_PPSTA->fetch_array();
    $PPSTA = $row_PPSTA['employeeDeductionAmount'];
    $worksheet->setCellValue("AF" . $row, $PPSTA);//PPSTA
    $result_Water = $mysqli->query("SELECT * FROM employeedeductions WHERE employeeId=$employee_id AND edName='Water';") or die(mysqli_error());
    $row_Water = $result_Water->fetch_array();
    $Water = $row_Water['employeeDeductionAmount'];
    $worksheet->setCellValue("AG" . $row, $Water);//Water
    $result_Electric = $mysqli->query("SELECT * FROM employeedeductions WHERE employeeId=$employee_id AND edName='Electric';") or die(mysqli_error());
    $row_Electric = $result_Electric->fetch_array();
    $Electric = $row_Electric['employeeDeductionAmount'];
    $worksheet->setCellValue("AH" . $row, $Electric);//Electric
    $result_COAND = $mysqli->query("SELECT * FROM employeedeductions WHERE employeeId=$employee_id AND edName='COA-ND';") or die(mysqli_error());
    $row_COAND = $result_COAND->fetch_array();
    $COAND = $row_COAND['employeeDeductionAmount'];
    $worksheet->setCellValue("AI" . $row, $COAND);//COAND
    $result_deduction = $mysqli->query("SELECT sum(employeeDeductionAmount) as value_difference from employeedeductions WHERE employeeId=$employee_id") or die($mysqli_error());
    while($deduction_rows = mysqli_fetch_array($result_deduction)) {
      $fetched_deduction = $deduction_rows['value_difference'];
    }
    $worksheet->setCellValue("AJ" . $row, $fetched_deduction);//fetched_deduction
    $net_amount = $gross - $fetched_deduction;
    $worksheet->setCellValue("AK" . $row, $net_amount);//fetched_deduction
    $half_month = $net_amount /2;

   
    $worksheet->setCellValue("AL" . $row, $half_month);//half_month
    $worksheet->setCellValue("AM" . $row, $half_month);//half_month
   $employee_remarks = '';
$result_remarks = $mysqli->query("SELECT * FROM remarks WHERE emp_id=$employee_id") or die($mysqli->error());
while ($row_remarks = mysqli_fetch_array($result_remarks)) {
    $employee_remarks .= $row_remarks['other_deduction_name'] . ' - ' . $row_remarks['remark_text'] . ', ';
}
$worksheet->setCellValue("AN" . $row, rtrim($employee_remarks, ', '));//remark
    $row++;
  endwhile; 
 
  // Rename worksheet
  $worksheet->setTitle('CBOO Payroll Report');
  $spreadsheet->setActiveSheetIndex(0);

  header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
  header('Content-Disposition: attachment;filename="Payroll Report.xlsx"');
  header('Cache-Control: max-age=0');
  
  $writer = \PhpOffice\PhpSpreadsheet\IOFactory::createWriter($spreadsheet, 'Xlsx');
  $writer->save('php://output');
    ?>