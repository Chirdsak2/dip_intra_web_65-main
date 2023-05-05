<?php
	include("../lib/permission1.php");
	include("../lib/include.php");
	include("../lib/function.php");
	include("../lib/user_config.php");
	include("../lib/connect.php");

	$depth = 0;

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
	$objPHPExcel = $objReader->load("Template/report_webboard_usage.xls");

	//Set borders in Excel	
	$border_setting = array(	'borders' => array(
									'outline'     => array(
										'style' => PHPExcel_Style_Border::BORDER_THIN
									)
								)
							);




							
	$Globals_Dir = "../ewt/".$_SESSION["EWT_SUSER"]."/";
	function DiffToText_new($diff)
				{
					global $a;
			/*  if (floor($diff/31536000))
							{
							$x = floor($diff / 31536000);
							echo " $x ปี ";
							$diff = $diff - ($x * 31536000);
							return DiffToText_new($diff);
							}
				elseif (floor($diff/2678400))
							{
							$x = floor($diff / 2678400);
							echo " $x เดือน ";
							$diff = $diff - ($x * 2678400);
							return DiffToText_new($diff);
							}
				else*/if ($diff>=86400)
							{
							$x = floor($diff / 86400);
							//if($x  > 0){
							$a .= " $x วัน";
							$diff = $diff - ($x * 86400);
							return DiffToText_new($diff);
							//}
							}
				elseif ($diff>=3600)
							{
							$x = floor($diff / 3600);
							$a .= " $x ชั่วโมง";
							$diff = $diff - ($x * 3600);
							return DiffToText_new($diff);
							}

				elseif ($diff>=60)
							{
							$x = floor($diff / 60);
							$a .= " $x นาที ";
							$diff = $diff - ($x * 60);
							return DiffToText_new($diff);
							}
				else if ($diff)
							if($diff > 0){
							$a .= " $diff วินาที ";

							}
				}
	if(empty($start_date) && $Flag ==''){
	$start_date = date("d/m/").(date("Y")+543);
	}
	if(empty($end_date) && $Flag ==''){
	$end_date = date("d/m/").(date("Y")+543);
	}
	if (empty($offset) || $offset < 0) { 
			$offset=0; 
		} 
	//    Set $limit,  $limit = Max number of results per 'page' 

	$limit = $CO[c_number];
	if(empty($limit)){
	$limit =10;
	}
		$begin =($offset+1); 
		$end = ($begin+($limit-1)); 
		if ($end > $totalrows) { 
			$end = $totalrows; 
		}


	$start_date = str_replace("-","/",$start_date);
	$end_date   = str_replace("-","/",$end_date);

	if($start_date == "" AND $end_date == ""){
		$date = date("m");
		$con = "AND MONTH(t_date) = {$date}";
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

	$objPHPExcel->setActiveSheetIndex(0)->mergeCells('A1:L1');
	//$objPHPExcel->setActiveSheetIndex(0)->mergeCells('A2:C2');
	//$objPHPExcel->setActiveSheetIndex(0)->mergeCells('D2:E2');


	$objPHPExcel->getActiveSheet()->setCellValue('A1', "สถิติการใช้งานเว็บบอร์ด ".$start_date." - ".$end_date);
	
	$objPHPExcel->getActiveSheet()->getStyle('A1:L1')->applyFromArray($border_setting);

	$objPHPExcel->getActiveSheet()->setCellValue('A2', "ลำดับ");
	$objPHPExcel->getActiveSheet()->setCellValue('B2', "ข้อมูลที่โพส");
	$objPHPExcel->getActiveSheet()->setCellValue('C2', "หมวด");
	$objPHPExcel->getActiveSheet()->setCellValue('D2', "ชื่อผู้โพสข้อมูล");
	$objPHPExcel->getActiveSheet()->setCellValue('E2', "e-mail address");
	$objPHPExcel->getActiveSheet()->setCellValue('F2', "เลขที่");
	$objPHPExcel->getActiveSheet()->setCellValue('G2', "วัน/เดือน/ปี ที่ติดต่อ");
	$objPHPExcel->getActiveSheet()->setCellValue('H2', "เวลาติดต่อ");
	$objPHPExcel->getActiveSheet()->setCellValue('I2', "วัน/เดือน/ปี ที่ตอบกลับ");
	$objPHPExcel->getActiveSheet()->setCellValue('J2', "เวลาตอบกลับ");
	$objPHPExcel->getActiveSheet()->setCellValue('K2', "หน่วยงาน");
	$objPHPExcel->getActiveSheet()->setCellValue('L2', "ระยะเวลาการให้บริการ(นาที)");

	$objPHPExcel->getActiveSheet()->getStyle('A2')->applyFromArray($border_setting);
	$objPHPExcel->getActiveSheet()->getStyle('B2')->applyFromArray($border_setting);
	$objPHPExcel->getActiveSheet()->getStyle('C2')->applyFromArray($border_setting);
	$objPHPExcel->getActiveSheet()->getStyle('D2')->applyFromArray($border_setting);
	$objPHPExcel->getActiveSheet()->getStyle('E2')->applyFromArray($border_setting);
	$objPHPExcel->getActiveSheet()->getStyle('F2')->applyFromArray($border_setting);
	$objPHPExcel->getActiveSheet()->getStyle('G2')->applyFromArray($border_setting);
	$objPHPExcel->getActiveSheet()->getStyle('H2')->applyFromArray($border_setting);
	$objPHPExcel->getActiveSheet()->getStyle('I2')->applyFromArray($border_setting);
	$objPHPExcel->getActiveSheet()->getStyle('J2')->applyFromArray($border_setting);
	$objPHPExcel->getActiveSheet()->getStyle('K2')->applyFromArray($border_setting);
	$objPHPExcel->getActiveSheet()->getStyle('L2')->applyFromArray($border_setting);

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


	if($query_show == ''){
		$sql = $db->query("select w_question.*,w_cate.c_name from  w_question,w_cate where 1=1 and  w_question.c_id =w_cate.c_id ".$con."  order by t_date DESC,t_time DESC  ");
	}else{
		$sql = $db->query("select w_question.*,w_cate.c_name from  w_question,w_cate where 1=1 and  w_question.c_id =w_cate.c_id  ".$con." order by t_date DESC,t_time DESC ");
	}

	
	while($R=$db->db_fetch_array($sql)){
		$date = explode("-",$R[t_date]);
		$time = explode(":",$R[t_time]);
		$d2 = mktime($time[0], $time[1], $time[2], $date[1], $date[2], $date[0]);
		$d_df = mktime(0, 0, 0, date(m), date(d), date(Y));
		
		if($R[user_id] != '0'){
					$db->query("USE ".$EWT_DB_USER);
					$sql_img = "SELECT * from gen_user,emp_type where gen_user.emp_type_id = emp_type.emp_type_id and gen_user_id = '".$R[user_id]."'";
					$query = $db->query($sql_img);
					$rec_img = $db->db_fetch_array($query);
					$db->query("USE ".$EWT_DB_NAME);
						$name_a = stripslashes($rec_img[name_thai].'   '.$rec_img[surname_thai]); 
						$mail = $rec_img[email_person];
						$emp_type  = $rec_img[emp_type_name];
						$user_id = $rec_img[emp_id];
		}else{
						$name_a = $R[q_name]; 
						$mail = $R[q_email];
						$emp_type  = 'ประชาชนทั่วไป';
						$user_id = $R[t_id];
		}
		
		$sql_an = "SELECT * from w_answer where t_id = '".$R[t_id]."' order by a_id ASC";
		$query_an = $db->query($sql_an);
		$rec = $db->db_fetch_array($query_an);
		$date_an = explode("-",$rec[a_date]);
		$time_an = explode(":",$rec[a_time]);

		if($db->db_num_rows($query_an)>0){
		$d1 = mktime($time_an[0], $time_an[1], $time_an[2], $date_an[1], $date_an[2], $date_an[0]);
		$color = "ffffff";
		}else{
		$d1 = 0;
		
			if(($d_df-$d2 ) >86400){
				$color = "ec4848";
			}else if(($d_df-$d2 ) < 86400){
				$color = "20e658";
			}
		}
		$diff = $d1-$d2;
			
		$a = "";

		//echo $color."<br>";

		if($query_show == '1'){
			if($db->db_num_rows($query_an)>0){

				$objPHPExcel->getActiveSheet()->getStyle('A'.$i.':L'.$i)->getFill()
				->setFillType(PHPExcel_Style_Fill::FILL_SOLID)
				->getStartColor()->setRGB($color);
				$objPHPExcel->getActiveSheet()->getStyle('A'.$i.':L'.$i)->applyFromArray($border_setting);
			
				$objPHPExcel->getActiveSheet()->setCellValue('A'.$i, $i-2);
				$objPHPExcel->getActiveSheet()->setCellValue('B'.$i, $R[t_name]);
				$objPHPExcel->getActiveSheet()->setCellValue('C'.$i, $R[c_name]);
				$objPHPExcel->getActiveSheet()->setCellValue('D'.$i, $name_a);
				$objPHPExcel->getActiveSheet()->setCellValue('E'.$i, $mail);
				$objPHPExcel->getActiveSheet()->setCellValue('F'.$i, $user_id);
				$objPHPExcel->getActiveSheet()->setCellValue('G'.$i, $R[t_date]);
				$objPHPExcel->getActiveSheet()->setCellValue('H'.$i, $R[t_time]);
				$objPHPExcel->getActiveSheet()->setCellValue('I'.$i, $rec[a_date]);
				$objPHPExcel->getActiveSheet()->setCellValue('J'.$i, $rec[a_time]);
				$objPHPExcel->getActiveSheet()->setCellValue('K'.$i, $emp_type);
				
				if($diff>0){
					DiffToText_new($diff);
				$objPHPExcel->getActiveSheet()->setCellValue('L'.$i, $a);
				}
			
				$i++;
			}
		}else if($query_show == '2'){
			if($db->db_num_rows($query_an)==0){
				
				$objPHPExcel->getActiveSheet()->getStyle('A'.$i.':L'.$i)->getFill()
				->setFillType(PHPExcel_Style_Fill::FILL_SOLID)
				->getStartColor()->setRGB($color);
				$objPHPExcel->getActiveSheet()->getStyle('A'.$i.':L'.$i)->applyFromArray($border_setting);
				
				$objPHPExcel->getActiveSheet()->setCellValue('A'.$i, $i-2);
				$objPHPExcel->getActiveSheet()->setCellValue('B'.$i, $R[t_name]);
				$objPHPExcel->getActiveSheet()->setCellValue('C'.$i, $R[c_name]);
				$objPHPExcel->getActiveSheet()->setCellValue('D'.$i, $name_a);
				$objPHPExcel->getActiveSheet()->setCellValue('E'.$i, $mail);
				$objPHPExcel->getActiveSheet()->setCellValue('F'.$i, $user_id);
				$objPHPExcel->getActiveSheet()->setCellValue('G'.$i, $R[t_date]);
				$objPHPExcel->getActiveSheet()->setCellValue('H'.$i, $R[t_time]);
				$objPHPExcel->getActiveSheet()->setCellValue('I'.$i, $rec[a_date]);
				$objPHPExcel->getActiveSheet()->setCellValue('J'.$i, $rec[a_time]);
				$objPHPExcel->getActiveSheet()->setCellValue('K'.$i, $emp_type);
				
				if($diff>0){
					DiffToText_new($diff);
				$objPHPExcel->getActiveSheet()->setCellValue('L'.$i, $a);
				}
				
				$i++;
			
			}
		}else{
			
			$objPHPExcel->getActiveSheet()->getStyle('A'.$i.':L'.$i)->getFill()
			->setFillType(PHPExcel_Style_Fill::FILL_SOLID)
			->getStartColor()->setRGB($color);
			$objPHPExcel->getActiveSheet()->getStyle('A'.$i.':L'.$i)->applyFromArray($border_setting);
		
			
			$objPHPExcel->getActiveSheet()->setCellValue('A'.$i, $i-2);
			$objPHPExcel->getActiveSheet()->setCellValue('B'.$i, $R[t_name]);
			$objPHPExcel->getActiveSheet()->setCellValue('C'.$i, $R[c_name]);
			$objPHPExcel->getActiveSheet()->setCellValue('D'.$i, $name_a);
			$objPHPExcel->getActiveSheet()->setCellValue('E'.$i, $mail);
			$objPHPExcel->getActiveSheet()->setCellValue('F'.$i, $user_id);
			$objPHPExcel->getActiveSheet()->setCellValue('G'.$i, $R[t_date]);
			$objPHPExcel->getActiveSheet()->setCellValue('H'.$i, $R[t_time]);
			$objPHPExcel->getActiveSheet()->setCellValue('I'.$i, $rec[a_date]);
			$objPHPExcel->getActiveSheet()->setCellValue('J'.$i, $rec[a_time]);
			$objPHPExcel->getActiveSheet()->setCellValue('K'.$i, $emp_type);
			
			if($diff>0){
				DiffToText_new($diff);
			$objPHPExcel->getActiveSheet()->setCellValue('L'.$i, $a);
			}
		
			$i++;
		}
			
	} 

	

	$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
	
	header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
	header('Content-Disposition: attachment;filename="Report Webboard Usage.xls"');
	header('Cache-Control: max-age=0');
	
	$objWriter->save('php://output');

?>