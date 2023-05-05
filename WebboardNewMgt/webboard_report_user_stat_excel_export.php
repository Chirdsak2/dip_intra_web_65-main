<?php
	include("../lib/permission1.php");
	include("../lib/include.php");
	include("../lib/function.php");
	include("../lib/user_config.php");
	include("../lib/connect.php");

	$depth = 0;

	function list_room($c_id,$depth,$con_a){
		
		global $db;
		global $depth;
		global $i;
		global $border_setting;
		global $objPHPExcel;
		
	  
	   	$sql_subcate = "SELECT * FROM w_cate 
						WHERE c_parentid = '$c_id' AND c_use = 'Y'";
		
		$result_subcate = $db->query($sql_subcate);
	  
		$order_subcate = 1;
	  
		while($subcate = $db->db_fetch_array($result_subcate)){
		
			$level_indicator = "";

			for($e=0;$e<($depth+1);$e++){ $level_indicator.=">"; } 
			
			$objPHPExcel->setActiveSheetIndex(0)->mergeCells('A'.$i.':D'.$i);
			$objPHPExcel->getActiveSheet()->setCellValue('A'.$i, $level_indicator." ".$subcate[c_name]);

			$objPHPExcel->getActiveSheet()->getStyle('A'.$i)->getFill()
			->setFillType(PHPExcel_Style_Fill::FILL_SOLID)
			->getStartColor()->setRGB('ffc153');

			$objPHPExcel->getActiveSheet()->getStyle('A'.$i.':D'.$i)->applyFromArray($border_setting);
			

			$i++;

			$sql_q = $db->query("  SELECT * 
									from  w_question 
									where 1=1 AND s_id='1' and c_id = '".$subcate[c_id]."'  ");
			$num_q = $db->db_num_rows($sql_q);

			$list_q = 1;

			while($rec_q = $db->db_fetch_array($sql_q)){
				
				$objPHPExcel->setActiveSheetIndex(0)->mergeCells('A'.$i.':C'.$i);
	
				$objPHPExcel->getActiveSheet()->setCellValue('A'.$i,  $list_q.". ".$rec_q[t_name]);

				$sql_a = $db->query("SELECT count(*) as num 
									 from w_answer 
									 where 1=1 and t_id = '".$rec_q[t_id]."' ".$con_a." ");
				$rec_a = $db->db_fetch_array($sql_a);
	
				$objPHPExcel->getActiveSheet()->setCellValue('D'.$i, $rec_a["num"]);
	
				$objPHPExcel->getActiveSheet()->getStyle('A'.$i.':D'.$i)->applyFromArray($border_setting);
				$objPHPExcel->getActiveSheet()->getStyle('D'.$i)->applyFromArray($border_setting);
	
				$i++;
				$list_q++;
			
			}
		
			if($num_q == 0){
	
				$objPHPExcel->setActiveSheetIndex(0)->mergeCells('A'.$i.':C'.$i);
				$objPHPExcel->getActiveSheet()->setCellValue('A'.$i, "ไม่พบหัวข้อกระทู้");
				
				$objPHPExcel->getActiveSheet()->getStyle('A'.$i.':D'.$i)->applyFromArray($border_setting);
	
				$i++;
				
			}

		
			$sql_subcate1 = "SELECT * FROM w_cate 
							WHERE c_parentid = '$subcate[c_id]' AND c_use = 'Y'";
	
			$result_subcate1 = $db->query($sql_subcate1);
			$subcate1_row    = $db->db_num_rows($result_subcate1);
	
			
			if($subcate1_row>0){
				$depth++;
				list_room($subcate[c_id],$depth,$con_a);
				
			}
			else{
			
			}
			
			$order_subcate++;
		} 
		$depth--;
	}
	

	/** PHPExcel */
	require_once ('Classes/PHPExcel.php');
	
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
	$objPHPExcel = $objReader->load("Template/report_webboard.xls");

	//Set borders in Excel	
	$border_setting = array(	'borders' => array(
									'outline'     => array(
										'style' => PHPExcel_Style_Border::BORDER_THIN
									)
								)
							);


	/*
	$sql_excel = "SELECT * 
				FROM n_member 
				ORDER BY m_id ASC";

	$result_excel = $db->query($sql_excel);
	*/

	$start_date = str_replace("-","/",$start_date);
	$end_date   = str_replace("-","/",$end_date);

	if($start_date == "" AND $end_date == ""){
		$con = "";
		$con_a = "";
		$date_name = "";
		}elseif($start_date != "" AND $end_date == ""){
		$st = explode("/",$start_date);
		$con = " AND (t_date = '".($st[2] -543)."-".$st[1]."-".$st[0]."') ";
		$con_a = " AND (a_date = '".($st[2] -543)."-".$st[1]."-".$st[0]."') ";
		$date_name = "วันที่".$start_date;
		}elseif($start_date == "" AND $end_date != ""){
		$st = explode("/",$end_date);
		$con = " AND (t_date = '".($st[2] -543)."-".$st[1]."-".$st[0]."') ";
		$con_a = " AND (a_date = '".($st[2] -543)."-".$st[1]."-".$st[0]."') ";
		$date_name = "วันที่".$end_date;
		}else{
		$st = explode("/",$start_date);
		$en = explode("/",$end_date);
		$con = " AND (t_date BETWEEN '".($st[2] -543)."-".$st[1]."-".$st[0]."' AND '".($en[2] - 543)."-".$en[1]."-".$en[0]."') ";
		$con_a = " AND (a_date BETWEEN '".($st[2] -543)."-".$st[1]."-".$st[0]."' AND '".($en[2] - 543)."-".$en[1]."-".$en[0]."') ";
		$date_name = "วันที่".$start_date."ถึง วันที่".$end_date;
		}

	//======================
	//	Header Bar
	//======================

	$objPHPExcel->setActiveSheetIndex(0)->mergeCells('A1:D1');
	$objPHPExcel->setActiveSheetIndex(0)->mergeCells('A2:C2');
	//$objPHPExcel->setActiveSheetIndex(0)->mergeCells('D2:E2');


	$objPHPExcel->getActiveSheet()->setCellValue('A1', "สถิติการตอบคำถาม ".$start_date." - ".$end_date);
	
	$objPHPExcel->getActiveSheet()->getStyle('A1:D1')->applyFromArray($border_setting);

	$objPHPExcel->getActiveSheet()->setCellValue('A2', "รายการ");
	$objPHPExcel->getActiveSheet()->setCellValue('D2', "จำนวนผู้ตอบคำถาม");

	$objPHPExcel->getActiveSheet()->getStyle('A2:D2')->applyFromArray($border_setting);
	$objPHPExcel->getActiveSheet()->getStyle('D2')->applyFromArray($border_setting);

	//===================
	//   Color
	//===================

	$objPHPExcel->getActiveSheet()->getStyle('A1:B1')->getFill()
	->setFillType(PHPExcel_Style_Fill::FILL_SOLID)
	->getStartColor()->setRGB('9399ea');

	$border_setting = array(	'borders' => array(
		'outline'     => array(
			'style' => PHPExcel_Style_Border::BORDER_THIN
			)
		)
	);
	
	//===================
	//   SQL
	//===================

	$i = 3;

	list_room(0, 1,$con_a); 

	

	$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
	
	header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
	header('Content-Disposition: attachment;filename="Report Webboard User Stat.xls"');
	header('Cache-Control: max-age=0');
	
	$objWriter->save('php://output');

?>