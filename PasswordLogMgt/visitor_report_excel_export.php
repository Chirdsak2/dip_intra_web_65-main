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
if (!empty($_GET['proc'])) {
	if ($_GET['proc'] == 'TO') {
		$con = " AND (sv_date = '" . $date->format('Y-m-d') . "') ";
	} else if ($_GET['proc'] == 'YE') {
		$clone->modify('-1 day');
		$con = " AND (sv_date = '" . $clone->format('Y-m-d') . "') ";
	} else if ($_GET['proc'] == 'L7') {
		$clone->modify('-7 day');
		$con = " AND (sv_date BETWEEN '" . $clone->format('Y-m-d') . "' AND '" . $date->format('Y-m-d') . "')";
	} else if ($_GET['proc'] == 'L3') {
		$clone->modify('-30 day');
		$con = " AND (sv_date BETWEEN '" . $clone->format('Y-m-d') . "' AND '" . $date->format('Y-m-d') . "')";
	} else if ($_GET['proc'] == 'TM') {
		$clone->modify('-30 day');
		$con = " AND (sv_date BETWEEN '" . $clone->format('Y-m-d') . "' AND '" . $date->format('Y-m-d') . "')";
	} else if ($_GET['proc'] == 'LM') {
		$clone->modify('-1 month');
		$clone2->modify('-2 month');
		$con = " AND (sv_date BETWEEN '" . $clone2->format('Y-m-d') . "' AND '" . $clone->format('Y-m-d') . "')";
	} else if ($_GET['proc'] == 'CU') {
		$s = explode("/", $_GET['startdate']);
		$n = explode("/", $_GET['enddate']);
		$con = " AND (sv_date BETWEEN '" . $s[2] . "-" . $s[1] . "-" . $s[0] . "' AND '" . $n[2] . "-" . $n[1] . "-" . $n[0] . "')";
	}
} else {
	$con = " AND (sv_date = '" . $date->format('Y-m-d') . "') ";
}

$intRejectTime = 10; // Minute
$s_delonline 	= 	"DELETE FROM stat_online WHERE DATE_ADD(so_onlinelasttime, INTERVAL {$intRejectTime} MINUTE) <= NOW() ";
$_q_delonline = $db->query($s_delonline);

//ผู้เข้าชมเว็บไซต์ที่ใช้งานอยู่
$s_count_rt = "SELECT so_session_id FROM stat_online GROUP BY so_session_id ";
$_q_count_rt = $db->query($s_count_rt);
$_rec_rt = $db->db_fetch_row($_q_count_rt);
$_row_rt = $db->db_num_rows($_q_count_rt);

//ผู้เข้าชมเว็บไซต์ในหน้าใด
$s_url = $db->query("SELECT sv_menu,sv_fullurl,count(sv_id) AS ct FROM stat_visitor WHERE sv_url = 'page' 
AND (sv_menu != '' ) {$con} GROUP BY sv_menu ORDER BY ct DESC LIMIT 0,5");

//IP (Internet Protocal Address)
$s_isp = $db->query("SELECT sv_ip,count(sv_id) AS ct 
FROM stat_visitor WHERE sv_url = 'page' AND  sv_visitor = 'Y' AND sv_ip != '' {$con} 
GROUP BY sv_ip 
ORDER BY ct DESC LIMIT 0,5");

//ระบบปฏิบัติการ (Operating System)
$s_os = $db->query("SELECT sv_os,count(sv_id) AS ct 
FROM stat_visitor WHERE sv_url = 'page' AND  sv_visitor = 'Y' AND sv_os != '' {$con} 
GROUP BY sv_os 
ORDER BY ct DESC LIMIT 0,5");

//เว็บบราวเซอร์ (Web Browser)
$s_wb = $db->query("SELECT sv_browser,count(sv_id) AS browser 
FROM stat_visitor WHERE sv_url = 'page' AND  sv_visitor = 'Y' AND sv_browser != '' {$con} 
GROUP BY sv_browser 
ORDER BY browser DESC LIMIT 0,5");

//ความละเอียดหน้าจอ (Resolution)
$s_res = $db->query("SELECT sv_resolution,count(sv_id) AS ct 
FROM stat_visitor WHERE sv_url = 'page' AND  sv_visitor = 'Y' AND sv_resolution != ''{$con} 
GROUP BY sv_resolution 
ORDER BY ct DESC LIMIT 0,5");

//ภาษาที่ใช้ (Accept Language)
$s_lan = $db->query("SELECT sv_language,count(sv_id) AS ct 
FROM stat_visitor WHERE sv_url = 'page' AND  sv_visitor = 'Y' AND sv_language != '' {$con} 
GROUP BY sv_language 
ORDER BY ct DESC LIMIT 0,5");

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
		'outline' => array(
			'style' => PHPExcel_Style_Border::BORDER_THIN
		)
	)
);

$style_color = array(
	'font'  => array(
		'bold'  => true,
		'color' => array('rgb' => 'FFFFFF'),
		'size'  => 14,
		'name'  => 'Arial'
	)
);

//======================
//	Header Bar
//======================

$objPHPExcel->setActiveSheetIndex(0)->mergeCells('A1:D1');
$objPHPExcel->getActiveSheet()->setCellValue('A1', "รายงานการเข้าชมเว็บไซต์");
$objPHPExcel->getActiveSheet()->getStyle('A1:D1')->applyFromArray($border_setting);
$objPHPExcel->getActiveSheet()->getStyle('A1:D1')->applyFromArray($style_color);
$objPHPExcel->getActiveSheet()->getStyle('A1:D1')->getFill()
	->setFillType(PHPExcel_Style_Fill::FILL_SOLID)
	->getStartColor()->setRGB('39c3da');

$objPHPExcel->setActiveSheetIndex(0)->mergeCells('A2:C2');
$objPHPExcel->getActiveSheet()->setCellValue('A2', "ผู้เข้าชมเว็บไซต์อย่างน้อย 1 เซซชันในช่วงวันที่ที่กำหนด");
$objPHPExcel->getActiveSheet()->setCellValue('D2', count_users($con) . ' Users');

$objPHPExcel->setActiveSheetIndex(0)->mergeCells('A3:C3');
$objPHPExcel->getActiveSheet()->setCellValue('A3', "จำนวนผู้เข้าชมเว็บไซต์ครั้งแรกระหว่างช่วงวันที่ที่เลือก");
$objPHPExcel->getActiveSheet()->setCellValue('D3', count_new_users($con) . ' New Users');

$objPHPExcel->setActiveSheetIndex(0)->mergeCells('A4:C4');
$objPHPExcel->getActiveSheet()->setCellValue('A4', "จำนวนรวมของเซสชันภายในช่วงวันที่");
$objPHPExcel->getActiveSheet()->setCellValue('D4', count_session($con) . ' Sessions');

$objPHPExcel->getActiveSheet()->getStyle('A2:D4')->applyFromArray($border_setting);

//------------------------------------------------------------------------------------//
$objPHPExcel->setActiveSheetIndex(0)->mergeCells('A6:C6');
$objPHPExcel->getActiveSheet()->setCellValue('A6', "ผู้เข้าชมเว็บไซต์ที่ใช้งานอยู่");
$objPHPExcel->getActiveSheet()->getStyle('A6:D6')->applyFromArray($border_setting);
$objPHPExcel->getActiveSheet()->getStyle('A6:D6')->applyFromArray($style_color);
$objPHPExcel->getActiveSheet()->getStyle('A6:D6')->getFill()
	->setFillType(PHPExcel_Style_Fill::FILL_SOLID)
	->getStartColor()->setRGB('39c3da');

$objPHPExcel->setActiveSheetIndex(0)->mergeCells('A7:C7');
$objPHPExcel->getActiveSheet()->setCellValue('A7', "จำนวน");
$objPHPExcel->getActiveSheet()->setCellValue('D7', number_format($_row_rt, 0) . ' Users');

$objPHPExcel->getActiveSheet()->getStyle('A6:D7')->applyFromArray($border_setting);

//------------------------------------------------------------------------------------//
$objPHPExcel->setActiveSheetIndex(0)->mergeCells('A9:C9');
$objPHPExcel->getActiveSheet()->setCellValue('A9', "การเข้าชมตามอุปกรณ์");
$objPHPExcel->getActiveSheet()->getStyle('A9:D9')->applyFromArray($border_setting);
$objPHPExcel->getActiveSheet()->getStyle('A9:D9')->applyFromArray($style_color);
$objPHPExcel->getActiveSheet()->getStyle('A9:D9')->getFill()
	->setFillType(PHPExcel_Style_Fill::FILL_SOLID)
	->getStartColor()->setRGB('39c3da');

$objPHPExcel->getActiveSheet()->setCellValue('A10', "Desktop");
$objPHPExcel->getActiveSheet()->setCellValue('D10', count_device('1', $con) . ' เครื่อง');

$objPHPExcel->getActiveSheet()->setCellValue('A11', "Tablet");
$objPHPExcel->getActiveSheet()->setCellValue('D11', count_device('2', $con) . ' เครื่อง');

$objPHPExcel->getActiveSheet()->setCellValue('A12', "Mobile");
$objPHPExcel->getActiveSheet()->setCellValue('D12', count_device('3', $con) . ' เครื่อง');

$objPHPExcel->getActiveSheet()->getStyle('A10:D12')->applyFromArray($border_setting);

//------------------------------------------------------------------------------------//
$objPHPExcel->setActiveSheetIndex(0)->mergeCells('A14:D14');
$objPHPExcel->getActiveSheet()->setCellValue('A14', "ผู้เข้าชมเว็บไซต์หน้าใด #Top 5");
$objPHPExcel->getActiveSheet()->getStyle('A14:D14')->applyFromArray($style_color);
$i1 = 15;
while ($a_url = $db->db_fetch_row($s_url)) {
	$objPHPExcel->setActiveSheetIndex(0)->mergeCells('A' . $i1 . ':C' . $i1 . '');
	$objPHPExcel->getActiveSheet()->setCellValue('A' . $i1 . '', $a_url[0]);
	$objPHPExcel->getActiveSheet()->setCellValue('D' . $i1 . '', $a_url[2]);
	$objPHPExcel->getActiveSheet()->getStyle('A' . $i1 . ':D' . $i1 . '')->applyFromArray($border_setting);
	$i1++;
}

$objPHPExcel->getActiveSheet()->getStyle('A14:D14')->getFill()
	->setFillType(PHPExcel_Style_Fill::FILL_SOLID)
	->getStartColor()->setRGB('39c3da');

//------------------------------------------------------------------------------------//
$objPHPExcel->setActiveSheetIndex(0)->mergeCells('A21:D21');
$objPHPExcel->getActiveSheet()->setCellValue('A21', "IP (Internet Protocal Address) #Top 5");
$objPHPExcel->getActiveSheet()->getStyle('A21:D21')->applyFromArray($style_color);
$i2 = 22;
while ($a_isp = $db->db_fetch_row($s_isp)) {
	$objPHPExcel->setActiveSheetIndex(0)->mergeCells('A' . $i2 . ':C' . $i2 . '');
	$objPHPExcel->getActiveSheet()->setCellValue('A' . $i2 . '', $a_isp[0]);
	$objPHPExcel->getActiveSheet()->setCellValue('D' . $i2 . '', $a_isp[1]);
	$objPHPExcel->getActiveSheet()->getStyle('A' . $i2 . ':D' . $i2 . '')->applyFromArray($border_setting);
	$i2++;
}

$objPHPExcel->getActiveSheet()->getStyle('A21:D21')->getFill()
	->setFillType(PHPExcel_Style_Fill::FILL_SOLID)
	->getStartColor()->setRGB('39c3da');

//------------------------------------------------------------------------------------//
$irow3 = $i2 + 1;
$objPHPExcel->setActiveSheetIndex(0)->mergeCells('A'.$irow3.':D'.$irow3.'');
$objPHPExcel->getActiveSheet()->setCellValue('A'.$irow3.'', "ระบบปฏิบัติการ (Operating System) #Top 5");
$objPHPExcel->getActiveSheet()->getStyle('A'.$irow3.':D'.$irow3.'')->applyFromArray($style_color);
$i3 = $irow3 + 1;
while ($a_os = $db->db_fetch_row($s_os)) {
	$objPHPExcel->setActiveSheetIndex(0)->mergeCells('A' . $i3 . ':C' . $i3 . '');
	$objPHPExcel->getActiveSheet()->setCellValue('A' . $i3 . '', $a_os[0]);
	$objPHPExcel->getActiveSheet()->setCellValue('D' . $i3 . '', $a_os[1]);
	$objPHPExcel->getActiveSheet()->getStyle('A' . $i3 . ':D' . $i3 . '')->applyFromArray($border_setting);
	$i3++;
}

$objPHPExcel->getActiveSheet()->getStyle('A'.$irow3.':D'.$irow3.'')->getFill()
	->setFillType(PHPExcel_Style_Fill::FILL_SOLID)
	->getStartColor()->setRGB('39c3da');

//------------------------------------------------------------------------------------//
$irow4 = $i3 + 1;
$objPHPExcel->setActiveSheetIndex(0)->mergeCells('A'.$irow4.':D'.$irow4.'');
$objPHPExcel->getActiveSheet()->setCellValue('A'.$irow4.'', "เว็บบราวเซอร์ (Web Browser) #Top 5");
$objPHPExcel->getActiveSheet()->getStyle('A'.$irow4.':D'.$irow4.'')->applyFromArray($style_color);
$i4 = $irow4 + 1;
while ($a_wb = $db->db_fetch_row($s_wb)) {
	$objPHPExcel->setActiveSheetIndex(0)->mergeCells('A' . $i4 . ':C' . $i4 . '');
	$objPHPExcel->getActiveSheet()->setCellValue('A' . $i4 . '', $a_wb[0]);
	$objPHPExcel->getActiveSheet()->setCellValue('D' . $i4 . '', $a_wb[1]);
	$objPHPExcel->getActiveSheet()->getStyle('A' . $i4 . ':D' . $i4 . '')->applyFromArray($border_setting);
	$i4++;
}

$objPHPExcel->getActiveSheet()->getStyle('A'.$irow4.':D'.$irow4.'')->getFill()
	->setFillType(PHPExcel_Style_Fill::FILL_SOLID)
	->getStartColor()->setRGB('39c3da');

//------------------------------------------------------------------------------------//
$irow5 = $i4 + 1;
$objPHPExcel->setActiveSheetIndex(0)->mergeCells('A'.$irow5.':D'.$irow5.'');
$objPHPExcel->getActiveSheet()->setCellValue('A'.$irow5.'', "ความละเอียดหน้าจอ (Resolution) #Top 5");
$objPHPExcel->getActiveSheet()->getStyle('A'.$irow5.':D'.$irow5.'')->applyFromArray($style_color);
$i5 = $irow5 + 1;
while ($a_res = $db->db_fetch_row($s_res)) {
	$objPHPExcel->setActiveSheetIndex(0)->mergeCells('A' . $i5 . ':C' . $i5 . '');
	$objPHPExcel->getActiveSheet()->setCellValue('A' . $i5 . '', $a_res[0]);
	$objPHPExcel->getActiveSheet()->setCellValue('D' . $i5 . '', $a_res[1]);
	$objPHPExcel->getActiveSheet()->getStyle('A' . $i5 . ':D' . $i5 . '')->applyFromArray($border_setting);
	$i5++;
}

$objPHPExcel->getActiveSheet()->getStyle('A'.$irow5.':D'.$irow5.'')->getFill()
	->setFillType(PHPExcel_Style_Fill::FILL_SOLID)
	->getStartColor()->setRGB('39c3da');

//------------------------------------------------------------------------------------//
$irow6 = $i5 + 1;
$objPHPExcel->setActiveSheetIndex(0)->mergeCells('A'.$irow6.':D'.$irow6.'');
$objPHPExcel->getActiveSheet()->setCellValue('A'.$irow6.'', "ภาษาที่ใช้ (Accept Language) #Top 5");
$objPHPExcel->getActiveSheet()->getStyle('A'.$irow6.':D'.$irow6.'')->applyFromArray($style_color);
$i6 = $irow6 + 1;
while ($a_lan = $db->db_fetch_row($s_lan)) {
	$objPHPExcel->setActiveSheetIndex(0)->mergeCells('A' . $i6 . ':C' . $i6 . '');
	$objPHPExcel->getActiveSheet()->setCellValue('A' . $i6 . '', $a_lan[0]);
	$objPHPExcel->getActiveSheet()->setCellValue('D' . $i6 . '', $a_lan[1]);
	$objPHPExcel->getActiveSheet()->getStyle('A' . $i6 . ':D' . $i6 . '')->applyFromArray($border_setting);
	$i6++;
}

$objPHPExcel->getActiveSheet()->getStyle('A'.$irow6.':D'.$irow6.'')->getFill()
	->setFillType(PHPExcel_Style_Fill::FILL_SOLID)
	->getStartColor()->setRGB('39c3da');

$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
header('Content-Disposition: attachment;filename="Report Webboard Reader Stat.xls"');
header('Cache-Control: max-age=0');
$objWriter->save('php://output');
