<?php
include("../lib/permission1.php");
include("../lib/include.php");
include("../lib/function.php");
include("../lib/user_config.php");
include("../lib/connect.php");
include('../assets/configs/function.inc.php');

global $objPHPExcel;
global $db;
/** PHPExcel */
require_once('Classes/PHPExcel.php');

$date = new DateTime();
$clone = clone $date;
$clone2 = clone $date;
// Create new PHPExcel object
$objPHPExcel = new PHPExcel();

// Set properties
$objPHPExcel->getProperties()->setCreator("Maarten Balliauw")
	->setLastModifiedBy("Maarten Balliauw")
	->setTitle("Office 2007 XLSX Test Document")
	->setSubject("Office 2007 XLSX Test Document")
	->setDescription("Test document for Office 2007 XLSX, generated using PHP classes.")
	->setKeywords("office 2007 openxml php")
	->setCategory("Test result file");

$objReader = PHPExcel_IOFactory::createReader('Excel5');
$objPHPExcel = $objReader->load("Template/report_visitor.xls");

//Set borders in Excel	
$border_setting = array(
	'borders' => array(
		'allborders' => array(
			'style' => PHPExcel_Style_Border::BORDER_THIN
		)
	)
);

$style_color = array(
	'font'  => array(
		'bold'  => true,
		'color' => array('rgb' => '000000'),
		'size'  => 14,
		'name'  => 'Arial'
	)
);

$styleArray2 = [
	'alignment' => [ // จัดตำแหน่ง
	'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
	],
	
];

$a_funame = $_POST["fullname"];
$a_username = $_POST["username"];
$a_ip = $_POST["IP"];
$a_datetime = $_POST["datetime"];
$a_dateday = $_POST["dateday"];
$a_detail = $_POST["detail"];
if($startdate != ''){
	$startdate = $_GET['startdate'];
}
else{
	$startdate = "01/07/2565";
}
$a_detail = $_POST["detail"];
if($enddate != ''){
	$enddate = $_GET['enddate'];
}
else{
	$enddate = date("d/m/Y");
}

$i = 0;
//======================
//	Header Bar
//======================

$objPHPExcel->setActiveSheetIndex(0)->mergeCells('A1:E1');
$objPHPExcel->getActiveSheet()->setCellValue('A1', "รายงาน Password log");
$objPHPExcel->getActiveSheet()->getStyle('A1:E1')->applyFromArray($border_setting);
$objPHPExcel->getActiveSheet()->getStyle('A1:E1')->applyFromArray($style_color);
$objPHPExcel->getActiveSheet()->getStyle('A1:E1')->applyFromArray($styleArray2);
$objPHPExcel->getActiveSheet()->getStyle('A1:E1')->getFill()
	->setFillType(PHPExcel_Style_Fill::FILL_SOLID)
	->getStartColor()->setRGB('FFFFFF');

$objPHPExcel->setActiveSheetIndex(0)->mergeCells('A2:E2');
$objPHPExcel->getActiveSheet()->setCellValue('A2', "วันที่".  $startdate." - วันที่". $enddate);
$objPHPExcel->getActiveSheet()->getStyle('A2:E2')->applyFromArray($border_setting);
$objPHPExcel->getActiveSheet()->getStyle('A2:E2')->applyFromArray($style_color);
$objPHPExcel->getActiveSheet()->getStyle('A2:E2')->applyFromArray($styleArray2);
$objPHPExcel->getActiveSheet()->getStyle('A2:E2')->getFill()
	->setFillType(PHPExcel_Style_Fill::FILL_SOLID)
	->getStartColor()->setRGB('FFFFFF');

$objPHPExcel->getActiveSheet()->setCellValue('A4',  "ชื่อ - นามสกุล");
$objPHPExcel->getActiveSheet()->setCellValue('B4', "Username");
$objPHPExcel->getActiveSheet()->setCellValue('C4', "IP Address");
$objPHPExcel->getActiveSheet()->setCellValue('D4', "วันที่เวลา");
$objPHPExcel->getActiveSheet()->setCellValue('E4', "รายละเอียด");
$objPHPExcel->getActiveSheet()->getStyle('A4:E4')->applyFromArray($border_setting);

while($i < sizeof($a_detail) ){
	$objPHPExcel->getActiveSheet()->setCellValue('A'.strval($i+5), $a_funame[$i]);
	$objPHPExcel->getActiveSheet()->setCellValue('B'.strval($i+5), $a_username[$i]);
	$objPHPExcel->getActiveSheet()->setCellValue('C'.strval($i+5), $a_ip[$i]);
	$objPHPExcel->getActiveSheet()->setCellValue('D'.strval($i+5), $a_dateday[$i].' '.$a_datetime [$i]);
	$objPHPExcel->getActiveSheet()->setCellValue('E'.strval($i+5), $a_detail[$i]);
	$objPHPExcel->getActiveSheet()->getStyle('A'.strval($i+5).':E'.strval($i+5))->applyFromArray($border_setting);
	$i++;
}



$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
header('Content-Disposition: attachment;filename="passwordlog Webboard Reader Stat.xls"');
header('Cache-Control: max-age=0');
$objWriter->save('php://output');
