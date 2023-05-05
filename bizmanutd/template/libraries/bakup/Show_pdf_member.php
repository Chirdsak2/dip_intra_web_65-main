<?php
		include("class/connect.php");
		include("class/clsMember.php");
		include("class/clsProvince.php");
	
		$objprovince = new  clsProvince();
		$objmem = new  clsMember();

define('FPDF_FONTPATH','font/');
require('fpdf_thai.php');

class PDF extends FPDF_TH
{
	function Header()
	{
		$this->SetFont('AngsanaNew','B',15);
		$this->SetY(10);
		$this->SetX(20);
		$this->Ln(7);
		$this->Ln(7);
		$this->SetX(10);
		$this->SetFontSize(14);
		$this->TCell(0,0,'ระบบสนับสนุนการตัดสินใจกึ่งโครงสร้างของสินค้าคงคลังสหกรณ์บ้านต้นหมัน',0,0,'L');
		$this->SetX(-50);
		$this->SetFontSize(14);
		$this->TCell(0,0,'วันที่พิมพ์ : '.date("d/m/y H:i"),0,0,'L');
		$this->SetLineWidth(0.4);
		$this->Line(10,30,290,30);
	}
	function Footer()
	{
		$this->SetLineWidth(0.4);
		$this->Line(10,196,290,196);
		$this->SetY(-10);
		$this->SetFont('AngsanaNew','',14);
		$this->TCell(0,0,'หน้า '.$this->PageNo().'/{nb}',0,0,'R');
	}
} //End class

//Create new pdf file
$pdf=new PDF('L');

//Set thai font
$pdf->SetThaiFont();

$pdf->AliasNbPages();

//Open file
$pdf->Open();

//Disable automatic page break
$pdf->SetAutoPageBreak(false);

//Add first page
$pdf->AddPage();

//set initial y axis position per page
$y_axis_initial = 60;

//Set Row Height
$row_height = 6;

function getNowDateTh() {
	$yy = date('Y')+543;
	$mm = date('m');
	$dd = date('d');
	return $yy.'-'.$mm.'-'.$dd;
}
$pdf->Ln(7);
$pdf->Ln(7);
$pdf->Ln(7);
$pdf->SetFontSize(20);
$pdf->SetY(35);
$pdf->SetX(20);
$pdf->TCell(0,0,' ',0,0,'C');
$pdf->Ln(7);
$pdf->SetX(20);
$pdf->TCell(0,0,'รายงานข้อมูลสมาชิกสหกรณ์บ้านต้นหมัน จำกัด',0,0,'C');
$pdf->Ln(7);

/*if($date1==$date2){
		$pdf->SetFontSize(16);
		$pdf->SetX(20);
		$pdf->TCell(0,0,'ประจำวันที่   '.$date3,0,0,'C');
}else{
		$pdf->SetFontSize(16);
		$pdf->SetX(20);
		$pdf->TCell(0,0,'ระหว่างวันที่   '.$date3.'  ถึง  '.$date4,0,0,'C');
}*/
//เริ่มฟังค์ชั่นทางด้านเวลา
$date = date("l"); 
switch($date) 
{
case "Monday":
$printdate = "จันทร์";
break;
case "Tuesday":
$printdate = "อังคาร";
break;
case "Wednesday":
$printdate = "พุธ";
break;
case "Thursday":
$printdate = "พฤหัสบดี";
break;
case "Friday":
$printdate = "ศุกร์";
break;
case "Saturday":
$printdate = "เสาร์";
break;
case "Sunday":
$printdate = "อาทิตย์";
break;
}
$month = date("n"); 
switch($month)
{
case "1":
$printmonth = "มกราคม";
break;
case "2":
$printmonth = "กุมภาพันธ์";
break;
case "3":
$printmonth = "มีนาคม";
break;
case "4":
$printmonth = "เมษายน";
break;
case "5":
$printmonth = "พฤษภาคม";
break;
case "6":
$printmonth = "มิถุนายน";
break;
case "7":
$printmonth = "กรกฏาคม";
break;
case "8":
$printmonth = "สิงหาคม";
break;
case "9":
$printmonth = "กันยายน";
break;
case "10":
$printmonth = "ตุลาคม";
break;
case "11":
$printmonth = "พฤศจิกายน";
break;
case "12":
$printmonth = "ธันวาคม";
break;
}
//จบฟังค์ชั่นทางด้านเวลา
//$printdate ".date("d")." $printmonth ".(date("Y")+543)."

/*	$date=date(dmY);
	$d = substr("$date", 0, 2);
	$m = substr("$date", 2, 2);
	$y = substr("$date", 4, 4);
	$date= "$y-$m-$d";*/
	//include("../ch_datethai_pdf.php");
		$pdf->SetFontSize(14);
		$pdf->TCell(0,0,'ประจำวัน   '."$printdate ".'ที่   '.date("j")." $printmonth ".(date("Y")+543)."",0,0,'C');

//print column titles for the actual page

$pdf->SetFillColor(232,232,232);
$pdf->SetFontSize(16);
$pdf->SetY($y_axis_initial);
$pdf->SetX(10);

			$pdf->TCell(15,6,'ลำดับที่',1,0,'C',1);
			$pdf->TCell(25,6,'รหัสสมาชิก',1,0,'C',1);
			$pdf->TCell(45,6,'ชื่อ-นามสกุล',1,0,'C',1);
			$pdf->TCell(120,6,'ที่อยู่',1,0,'C',1);
			$pdf->TCell(30,6,'อาชีพ',1,0,'C',1);
			$pdf->TCell(30,6,'จำนวนการถือหุ้น',1,0,'C',1);

$y_axis = $y_axis_initial + $row_height;
//initialize counter
$i = 0;
$r=1;
$count = 0;
//$totalPrice=0;
//Set maximum rows per page
$max = 20;
	if ($txtsearch == ""){
	$objmem->RSmember();
			while($objmem->GetRecord()){
	 			$i=$i+1;

		if ($i == $max){
			//Set $i variable to 0 (first row)
			$i = 0;

			$pdf->AddPage();
			$pdf->SetFontSize(16);
			$pdf->SetY(35);
			$pdf->SetX(20);
			//$pdf->TCell(0,0,'วันที่ '.$sellpro_date ,0,0,'L');
			$pdf->Ln(7);
			$pdf->Ln(7);
			$pdf->SetFontSize(20);
			$pdf->SetY(35);
			$pdf->SetX(20);
			$pdf->TCell(0,0,' ',0,0,'C');
			$pdf->Ln(7);
			$pdf->SetX(20);
			$pdf->TCell(0,0,'รายงานข้อมูลสมาชิกสหกรณ์บ้านต้นหมัน จำกัด',0,0,'C');
			$pdf->Ln(7);

			/*	$date=date(dmY);
				$d = substr("$date", 0, 2);
				$m = substr("$date", 2, 2);
				$y = substr("$date", 4, 4);
				$date= "$y-$m-$d";*/
				//include("../ch_datethai_pdf.php");
				$pdf->SetFontSize(14);
				$pdf->TCell(0,0,'ประจำวัน   '."$printdate ".'ที่   '.date("j")." $printmonth ".(date("Y")+543)."",0,0,'C');

			//print column titles for the actual page

			$pdf->SetFillColor(232,232,232);
			$pdf->SetFontSize(16);
			$pdf->SetY($y_axis_initial);
			$pdf->SetX(10);
			$pdf->TCell(15,6,'ลำดับที่',1,0,'C',1);
			$pdf->TCell(25,6,'รหัสสมาชิก',1,0,'C',1);
			$pdf->TCell(45,6,'ชื่อ-นามสกุล',1,0,'C',1);
			$pdf->TCell(120,6,'ที่อยู่',1,0,'C',1);
			$pdf->TCell(30,6,'อาชีพ',1,0,'C',1);
			$pdf->TCell(30,6,'จำนวนการถือหุ้น',1,0,'C',1);


			//Go to next row
			$y_axis = $y_axis_initial + $row_height;
			
			//Set $i variable to 0 (first row)
			$i = 0;
		}

		$pdf->SetFontSize(14);
		$pdf->SetY($y_axis);
		$pdf->SetX(10);
		$pdf->TCell(15,6,$r,1,0,'C');
		$pdf->TCell(25,6,$objmem->mem_id,1,0,'C');
		$pdf->TCell(45,6,$objmem->mem_fname.'      '.$objmem->mem_sname,1,0,'L');

		$objprovince->SProvince($objmem->province_id);  
		$objprovince->GetRecord();
		//echo $objprovince->province_name;
		$address=$objmem->mem_add.'  ตำบล  '.$objmem->mem_destrict.'  อำเภอ  '.$objmem->mem_amphur.'  จังหวัด  '.$objprovince->province_name.$objmem->mem_post;

		$pdf->TCell(120,6,$address,1,0,'L');
		$pdf->TCell(30,6,$objmem->mem_trade,1,0,'L');
		$pdf->TCell(30,6,$objmem->mem_share,1,0,'C');

		//Go to next row
		$y_axis = $y_axis + $row_height;
		$i = $i + 1;
		$r = $r + 1;
		$count = $count + 1;
		//$totalPrice=$totalPrice+$price;
			}
	} //End while

//เริ่มฟังค์ชั่น SearchByName
if ($txtsearch != ""){
	$objmem->SearchByName($txtsearch);
			while($objmem->GetRecord()){
	 			$i=$i+1;

		if ($i == $max){
			//Set $i variable to 0 (first row)
			$i = 0;

			$pdf->AddPage();
			$pdf->SetFontSize(16);
			$pdf->SetY(35);
			$pdf->SetX(20);
			//$pdf->TCell(0,0,'วันที่ '.$sellpro_date ,0,0,'L');
			$pdf->Ln(7);
			$pdf->Ln(7);
			$pdf->SetFontSize(20);
			$pdf->SetY(35);
			$pdf->SetX(20);
			$pdf->TCell(0,0,' ',0,0,'C');
			$pdf->Ln(7);
			$pdf->SetX(20);
			$pdf->TCell(0,0,'รายงานข้อมูลสมาชิกสหกรณ์บ้านต้นหมัน จำกัด',0,0,'C');
			$pdf->Ln(7);

				$pdf->SetFontSize(14);
				$pdf->TCell(0,0,'ประจำวัน   '."$printdate ".'ที่   '.date("j")." $printmonth ".(date("Y")+543)."",0,0,'C');

			//print column titles for the actual page

			$pdf->SetFillColor(232,232,232);
			$pdf->SetFontSize(16);
			$pdf->SetY($y_axis_initial);
			$pdf->SetX(10);
			$pdf->TCell(15,6,'ลำดับที่',1,0,'C',1);
			$pdf->TCell(25,6,'รหัสสมาชิก',1,0,'C',1);
			$pdf->TCell(45,6,'ชื่อ-นามสกุล',1,0,'C',1);
			$pdf->TCell(120,6,'ที่อยู่',1,0,'C',1);
			$pdf->TCell(30,6,'อาชีพ',1,0,'C',1);
			$pdf->TCell(30,6,'จำนวนการถือหุ้น',1,0,'C',1);


			//Go to next row
			$y_axis = $y_axis_initial + $row_height;
			
			//Set $i variable to 0 (first row)
			$i = 0;
		}

		$pdf->SetFontSize(14);
		$pdf->SetY($y_axis);
		$pdf->SetX(10);
		$pdf->TCell(15,6,$r,1,0,'C');
		$pdf->TCell(25,6,$objmem->mem_id,1,0,'C');
		$pdf->TCell(45,6,$objmem->mem_fname.'      '.$objmem->mem_sname,1,0,'L');

		$objprovince->SProvince($objmem->province_id);  
		$objprovince->GetRecord();
		//echo $objprovince->province_name;
		$address=$objmem->mem_add.'  ตำบล  '.$objmem->mem_destrict.'  อำเภอ  '.$objmem->mem_amphur.'  จังหวัด  '.$objprovince->province_name.$objmem->mem_post;

		$pdf->TCell(120,6,$address,1,0,'L');
		$pdf->TCell(30,6,$objmem->mem_trade,1,0,'L');
		$pdf->TCell(30,6,$objmem->mem_share,1,0,'C');

		//Go to next row
		$y_axis = $y_axis + $row_height;
		$i = $i + 1;
		$r = $r + 1;
		$count = $count + 1;
		//$totalPrice=$totalPrice+$price;
			}
	} //End while
//จบฟังค์ชั่นSearchByName

//เริ่มฟังค์ชั่น SearchByID
if ($txtsearch != ""){
	$objmem->SearchByID($txtsearch);
			while($objmem->GetRecord()){
	 			$i=$i+1;

		if ($i == $max){
			//Set $i variable to 0 (first row)
			$i = 0;

			$pdf->AddPage();
			$pdf->SetFontSize(16);
			$pdf->SetY(35);
			$pdf->SetX(20);
			//$pdf->TCell(0,0,'วันที่ '.$sellpro_date ,0,0,'L');
			$pdf->Ln(7);
			$pdf->Ln(7);
			$pdf->SetFontSize(20);
			$pdf->SetY(35);
			$pdf->SetX(20);
			$pdf->TCell(0,0,' ',0,0,'C');
			$pdf->Ln(7);
			$pdf->SetX(20);
			$pdf->TCell(0,0,'รายงานข้อมูลสมาชิกสหกรณ์บ้านต้นหมัน จำกัด',0,0,'C');
			$pdf->Ln(7);

				$pdf->SetFontSize(14);
				$pdf->TCell(0,0,'ประจำวัน   '."$printdate ".'ที่   '.date("j")." $printmonth ".(date("Y")+543)."",0,0,'C');

			//print column titles for the actual page

			$pdf->SetFillColor(232,232,232);
			$pdf->SetFontSize(16);
			$pdf->SetY($y_axis_initial);
			$pdf->SetX(10);
			$pdf->TCell(15,6,'ลำดับที่',1,0,'C',1);
			$pdf->TCell(25,6,'รหัสสมาชิก',1,0,'C',1);
			$pdf->TCell(45,6,'ชื่อ-นามสกุล',1,0,'C',1);
			$pdf->TCell(120,6,'ที่อยู่',1,0,'C',1);
			$pdf->TCell(30,6,'อาชีพ',1,0,'C',1);
			$pdf->TCell(30,6,'จำนวนการถือหุ้น',1,0,'C',1);


			//Go to next row
			$y_axis = $y_axis_initial + $row_height;
			
			//Set $i variable to 0 (first row)
			$i = 0;
		}

		$pdf->SetFontSize(14);
		$pdf->SetY($y_axis);
		$pdf->SetX(10);
		$pdf->TCell(15,6,$r,1,0,'C');
		$pdf->TCell(25,6,$objmem->mem_id,1,0,'C');
		$pdf->TCell(45,6,$objmem->mem_fname.'      '.$objmem->mem_sname,1,0,'L');

		$objprovince->SProvince($objmem->province_id);  
		$objprovince->GetRecord();
		//echo $objprovince->province_name;
		$address=$objmem->mem_add.'  ตำบล  '.$objmem->mem_destrict.'  อำเภอ  '.$objmem->mem_amphur.'  จังหวัด  '.$objprovince->province_name.$objmem->mem_post;

		$pdf->TCell(120,6,$address,1,0,'L');
		$pdf->TCell(30,6,$objmem->mem_trade,1,0,'L');
		$pdf->TCell(30,6,$objmem->mem_share,1,0,'C');

		//Go to next row
		$y_axis = $y_axis + $row_height;
		$i = $i + 1;
		$r = $r + 1;
		$count = $count + 1;
		//$totalPrice=$totalPrice+$price;
			}
	} //End while
//จบฟังค์ชั่นSearchByID

	$pdf->SetFontSize(16);
	$pdf->SetY($y_axis);
	$pdf->TCell(265,6,'รวมสมาชิกทั้งหมด  '.$count.'  คน',1,0,'R',1);
//Create file
$pdf->Output();
?>