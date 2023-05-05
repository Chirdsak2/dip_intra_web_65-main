<?php
require('fpdf.php');
include('../class/class_db.php');
$DB = new  dbase;
include('../system/current_trimester.php');

$nwords = array( "Zero", "One", "Two", "Three", "Four", "Five", "Six", "Seven",
"Eight", "Nine", "Ten", "Eleven", "Twelve", "Thirteen",
"Fourteen", "Fifteen", "Sixteen", "Seventeen", "Eighteen",
"Nineteen", "Twenty", 30 => "Thirty", 40 => "Forty",
50 => "Fifty", 60 => "Sixty", 70 => "Seventy", 80 => "Eighty",
90 => "Ninety" );

function numbertotext($number){
		$number = $number;
		var_dump($number);
}

function int_to_words($x){
  global $nwords;
   if(!is_numeric($x)){
      $w = '#';
   }else if(fmod($x, 1) != 0){
      $w = '#';
   }else{
       if($x < 0){
           $w = 'Minus ';
           $x = -$x;
       }else{
           $w = '';
       }
      if($x < 21){
         $w .= $nwords[$x];
      }else if($x < 100){
         $w .= $nwords[10 * floor($x/10)];
         $r = fmod($x, 10);
         if($r > 0){
            $w .= ' '. $nwords[$r];
         }
     }else if($x < 1000){
         $w .= $nwords[floor($x/100)] .' Hundred';
         $r = fmod($x, 100);
         if($r > 0){
             $w .= ' And '. int_to_words($r);
         }
     }else if($x < 1000000){
        $w .= int_to_words(floor($x/1000)) .' Thousand';
        $r = fmod($x, 1000);
        if($r > 0){
            $w .= ' ';
            if($r < 100){
                $w .= 'And ';
            }
           $w .= int_to_words($r);
       }
    }else{
      $w .= int_to_words(floor($x/1000000)) .' Million';
      $r = fmod($x, 1000000);
      if($r > 0){
          $w .= ' ';
          if($r < 100){
              $word .= 'And ';
         }
         $w .= int_to_words($r);
      }
    }
  }
   return $w;
}

function m_tran($num){
			$num = number_format($num,2,'.','');
			$text = Array('', 'หนึ่ง', 'สอง', 'สาม', 'สี่', 'ห้า', 'หก', 'เจ็ด', 'แปด', 'เก้า');
			$base = Array('', '', 'สิบ', 'ร้อย', 'พัน', 'หมื่น', 'แสน', 'ล้าน');
			$dot = Array('', '', 'สิบ');
			list ($num1, $num2)  = split ("\.", $num);
			if(($num2 == 0 )||($num2 == 00 ))
				$num2="";
			$ii=strlen($num1);
			for ($i=0;$i<=strlen($num1);$i++){	
				if(substr ($num1, $i , 1)!=0){
					if(($ii==2)&&(substr ($num1, $i , 1)==1)){
						$txt .= $base[$ii];
					}elseif(($ii==2)&&(substr ($num1, $i , 1)==2)){
						$txt .= "ยี่".$base[$ii];
					}elseif (($ii==1)&&(substr($num1, $i, 1)==1)){
						$txt .= $base[$ii]."เอ็ด";
					}else{
						$txt .= $text[substr ($num1, $i , 1)].$base[$ii];
					}
				}
				$ii--;
			}
			if($num1>0){$txt .= "บาท";}
				$ii=strlen($num2);
				for ($i=0;$i<=strlen($num2);$i++){	
					if(substr ($num2, $i , 1)!=0){
						if(($ii==2)&&(substr ($num2, $i , 1)==1)){
							$txt .= $dot[$ii];
						}elseif(($ii==2)&&(substr ($num2, $i , 1)==2)){
							$txt .= "ยี่".$dot[$ii];
						}else{
							$txt .= $text[substr ($num2, $i , 1)].$dot[$ii];
						}			
					}	
					$ii--;
				}
			if(($num2=="")&&($num1>0)){$txt.="ถ้วน";}else{if($num1>0){$txt.="สตางค์";}}
			return($txt);
}

$pdf=new FPDF('P','mm','A4');
$pdf->AddPage();
$pdf->AddFont('angsa','','angsa.php');
$pdf->AddFont('angsab','','angsab.php');

$query  = $DB->QUERY("select * From BBA_Payment where pay_id = '$PaymentId'");
$rec_inpay = $DB->FETCH_ARRAY($query);

$sqlStuID = "SELECT * FROM BBA_Student WHERE stu_id = '".$rec_inpay[pay_stuid]."'";
$queryStuID = $DB->QUERY($sqlStuID); 
$rec_stu = $DB->FETCH_ARRAY($queryStuID);


$MissingFee=0;
$rec_maj = "Business Modeling and Analysis (MBA)";

/*
if($regis_status=='Approve'){
	$type = '1';
}else{
	$type = '2';
}
*/
$pdf->Image('krut.png',10,10,20,20,png);
$pdf->SetFont('angsab','',14);
//$pdf->SetXY(10,20);
$height=6;
$pdf->Cell('25',$height,'','',0,'L',0);
$pdf->Cell('140',$height,'วิทยาลัยนานาชาติ มหาวิทยาลัยมหิดล','',0,'L',0);
$pdf->SetFont('angsab','',12);
$pdf->Cell('25',$height,'                     ต้นฉบับ','',1,'L',0);
$pdf->SetFont('ARIAL','B',10);

$pdf->Cell('25',$height-2,'','',0,'L',0);
$pdf->Cell('140',$height-2,'MAHIDOL UNIVERSITY INTERNATIONAL COLLEGE','',0,'L',0);
$pdf->SetFont('angsa','',12);
$pdf->Cell('25',$height-2,"เลขที่",'',1,'L',0);
$pdf->SetFont('angsa','',10);

$pdf->Cell('25',$height-2,'','',0,'L',0);
$pdf->Cell('140',$height-2,'999 ตำบลศาลายา อำเภอพุทธมณฑล จ.นครปฐม 73170 โทรศัพท์ 02-4410594-6, 02-4410648-9 โทรสาร 02-4419145','',0,'L',0);
$pdf->Cell('25',$height-2,'Number','',1,'L',0);

$pdf->Cell('25',$height-2,'','',0,'L',0);
$pdf->Cell('140',$height-2,'999 SALAYA CAMPUS, NAKORNPATHOM 73170, THAILAND TEL.(662) 02-4410594, 02-4410648-9 FAX 02-4419145','',0,'L',0);
$pdf->SetFont('angsa','',12);
$pdf->Cell('25',$height-2,'วันที่','',1,'L',0);

$pdf->Cell('25',$height-2,'','',0,'L',0);
$pdf->Cell('140',$height-2,'','',0,'L',0);
$pdf->SetFont('angsa','',10);
$pdf->Cell('25',$height-2,'Date','',1,'L',0);

$pdf->SetFont('angsab','',20);
$pdf->Cell('190',$height-1,'ใบเสร็จรับเงิน','',1,'C',0);
$pdf->SetFont('angsab','',18);
$pdf->Cell('190',$height-2,'RECEIPT','',1,'C',0);


$pdf->SetFont('ARIAL','B',8);
$pdf->SetXY(185,18);
$pdf->Cell('25',$height-2,$rec_inpay["pay_id"],'',0,'L',0);

$en=substr($rec_inpay[pay_date],6,2).'/'.substr($rec_inpay[pay_date],4,2).'/'.substr($rec_inpay[pay_date],0,4);
$date=date("d/m/Y");
$pdf->SetXY(185,26);
$pdf->Cell('25',$height-2,$en,'',0,'L',0);


$pdf->SetFont('ARIAL','',10);

$position=40;
$pdf->SetXY(10,$position);
$position+=5;
$pdf->SetXY(10,$position);
$position+=5;

$next=$BBA_Current_Year+1;
$BBA_Current_Tri1=$BBA_Current_Tri;
if($BBA_Current_Tri=='4'){
	$BBA_Current_Tri1="S";
}

$en = explode("/",$en);
$enrollment= date("d F Y", mktime(0, 0, 0, $en[1], $en[0], $en[2]));
$pdf->SetFont('angsa','',14);
$pdf->Cell('140','7',"     ได้รับเงินจาก  ",'LT','0','L','0');
$pdf->Cell('50','7',"",'TLR','1','L','0');

$pdf->Cell('140','7',"     Received From:",'L','0','L','0');
$pdf->Cell('50','7',"",'LR','1','L','0');

$pdf->Cell('140','7',"     หลักสูตร   ",'L','0','L','0');
$pdf->Cell('50','7',"  Issued By  สุพรรณี   สามงามทอง",'LR','1','L','0');

$pdf->Cell('140','7',"     Program:",'LBR','0','L','0');
$pdf->Cell('50','7',"",'LBR','1','LR','0');
$pdf->SetFont('angsab','',12);
$pdf->Cell('140','4','รายการ','L','0','C','0');
$pdf->Cell('50','4','จำนวนเงิน(บาท)','LR','1','C','0');

$pdf->Cell('140','4','DESCRIPTION','LB','0','C','0');
$pdf->Cell('50','4','Amount','LRB','1','C','0');
$pdf->SetFont('angsa','',14);
$position+=27;
$total_price = "0"; 
$x = 0;
$start=$position;







$pay_year=$BBA_Current_Year+543;
$pdf->Cell('140','6',"การลงทะเบียนภาคการศึกษาที่ ".$BBA_Current_Tri1." ปีการศึกษา ".$pay_year."",'LR','0','L','0');
$pdf->Cell('50','6',"",'LR','1','R','0');
$eng_year=$pay_year-543;
$pdf->Cell('140','6',"Registration for Trimester ".$BBA_Current_Tri1."/".$eng_year."",'LR','0','L','0');
$pdf->Cell('50','6',"",'LR','1','R','0');
$start+=5;
$sql_fee=$DB->QUERY(" SELECT * FROM BBA_Payment_Detail  WHERE  payd_payid='$PaymentId'  ORDER BY payd_sort ");
$otherfee=0;
$countminus = 0;
$count_detail = 5;
while($rec_major_fee = $DB->FETCH_ARRAY($sql_fee)){
    $x++;
	switch(trim($rec_major_fee[payd_item])){
       case "Tution Fee": $payname="ค่าหน่วยกิต (Tuition fee)"; break;
	   default :  $payname="ค่าบำรุงและค่าธรรมเนียม (College and Other fee)";         
							 $otherfee+=$rec_major_fee[payd_cost];break;
    }

	if(trim($rec_major_fee[payd_item])=="Tution Fee"){
		$pdf->Cell('10','6','','L','0','L','0');
		$pdf->Cell('130','6'," - ".$payname."",'R','0','L','0');
		$pdf->Cell('35','6',number_format($rec_major_fee[payd_cost],2,'.',','),'L','0','R','0');
		$pdf->Cell('15','6','','R','1','R','0');
	}
    $total_price = $total_price + $rec_major_fee[payd_cost];
	$start+=5;
}

if($otherfee>0){
				$pdf->Cell('10','5.5','','L','0','L','0');
				$pdf->Cell('130','5.5'," - ".$payname."",'R','0','L','0');
				$pdf->Cell('35','5.5',number_format($otherfee+$MissingFee,2,'.',','),'L','0','R','0');
				$pdf->Cell('15','5.5','','R','1','R','0');
				$count_detail=3;
}





/*
$sql_feedue = $DB->QUERY("SELECT sum(MUIC_StudPayment_Cost) as cost_money FROM MUIC_StudPayment WHERE MUIC_StudPayment_Link='$PaymentId' and
MUIC_StudPayment_TypeID='3'");
$rec_feedue = $DB->DATA_FETCH_ARRAY($sql_feedue);
		
if($rec_feedue[cost_money]>0 OR $countminus == "1"){
				$pdf->Cell('10','6','','L','0','L','0');
				$pdf->Cell('130','6'," - ค่าปรับล่าช้า (Late Registration fee)",'R','0','L','0');
				$pdf->Cell('35','6',number_format(($rec_feedue[cost_money]+$Course_cost),2,'.',','),'L','0','R','0');
				$pdf->Cell('15','6','','R','1','R','0');
				$total_price = $total_price+$rec_feedue[cost_money];
				$count_detail=4;
}
*/
$forloop = (4-$count_detail);
for($g=1;$g<=$forloop;$g++){
	$pdf->Cell('10','5.5',"",'L','0','L','0');
	$pdf->Cell('130','5.5',"",'R','0','L','0');
	$pdf->Cell('35','5.5',"",'L','0','R','0');
	$pdf->Cell('15','5.5','','R','1','R','0');
	}

$position=$start+2;
$position+=7;
$pdf->Cell('100','8',"			(".m_tran($total_price,2).")",'T','0','L','0');
$pdf->SetFont('angsab','',15);
$pdf->Cell('40','8','รวม TOTAL     ','T','0','R','0');
$pdf->Cell('35','6',number_format($total_price,2),'LTB','0','R','0');
$pdf->Cell('15','6','','TBR','1','R','0');
$pdf->SetFont('angsa','',14);
$pdf->Cell('140','7','			('.strtoupper(int_to_words($total_price)).' BAHT ONLY)','0','0','L','0');
$pdf->Cell('50','10','___________________','0','1','C','0');
$pdf->Cell('140','7','','0','0','L','0');
$pdf->SetFont('angsa','',12);
$pdf->Cell('50','0','(สุพรรณี   สามงามทอง)','0','1','C','0');
$pdf->Cell('140','9','','0','0','C','0');
$pdf->Cell('50','8','ผู้รับเงิน Receiver','0','1','C','0');
$pdf->Cell('50','5','','0','1','C','0');
$pdf->SetXY('10','147'); 
$pdf->Cell('50','1','______________________________________________________________________________________________________________________________________________________________________________________________________________________________________________________________','','1','C','0');
$pdf->SetFont('angsab','',14);
$pdf->SetXY('30','63');
$pdf->Cell('','',$rec_maj,'','0','L','0');

$pdf->SetXY('35','47');
$pdf->Cell('140','6',"".$rec_stu[stu_id]."  ".$rec_stu[stu_title]." ".$rec_stu[stu_fname]." ".$rec_stu[stu_mame]." ".$rec_stu[stu_lname]."",'','0','L','0');

$pdf->SetFont('angsa','',14);
$pdf->SetXY('100','57');
$pdf->Cell('100','4',"อ้างถึง ");
$pdf->SetXY('100','63');
$pdf->Cell('100','4',"Invoice No.");
$pdf->SetFont('angsab','',14);
$pdf->SetXY('117','59');
$pdf->Cell('100','4',$rec_inpay["pay_id"]);
/////////////////////////////สำเนา/////////////////////////////สำเนา/////////////////////////////สำเนา/////////////////////////////สำเนา
/////////////////////////////สำเนา/////////////////////////////สำเนา/////////////////////////////สำเนา/////////////////////////////สำเนา
/////////////////////////////สำเนา/////////////////////////////สำเนา/////////////////////////////สำเนา/////////////////////////////สำเนา
/////////////////////////////สำเนา/////////////////////////////สำเนา/////////////////////////////สำเนา/////////////////////////////สำเนา
$pdf->Image('krut.png',10,155,20,20,png);
$pdf->SetFont('angsab','',14);
$pdf->SetXY(10,155);
$height=6;
$pdf->Cell('25',$height,'','',0,'L',0);
$pdf->Cell('140',$height,'วิทยาลัยนานาชาติ มหาวิทยาลัยมหิดล','',0,'L',0);
$pdf->SetFont('angsab','',12);
$pdf->Cell('25',$height,'                        สำเนา','',1,'L',0);
$pdf->SetFont('ARIAL','B',10);

$pdf->Cell('25',$height-2,'','',0,'L',0);
$pdf->Cell('140',$height-2,'MAHIDOL UNIVERSITY INTERNATIONAL COLLEGE','',0,'L',0);
$pdf->SetFont('angsa','',12);
$pdf->Cell('25',$height-2,"เลขที่",'',1,'L',0);
$pdf->SetFont('angsa','',10);

$pdf->Cell('25',$height-2,'','',0,'L',0);
$pdf->Cell('140',$height-2,'999 ตำบลศาลายา อำเภอพุทธมณฑล จ.นครปฐม 73170 โทรศัพท์ 02-4410594-6, 02-4410648-9 โทรสาร 02-4419145','',0,'L',0);
$pdf->Cell('25',$height-2,'Number','',1,'L',0);

$pdf->Cell('25',$height-2,'','',0,'L',0);
$pdf->Cell('140',$height-2,'999 SALAYA CAMPUS, NAKORNPATHOM 73170, THAILAND TEL.(662) 02-4410594, 02-4410648-9 FAX 02-4419145','',0,'L',0);
$pdf->SetFont('angsa','',12);
$pdf->Cell('25',$height-2,'วันที่','',1,'L',0);

$pdf->Cell('25',$height-2,'','',0,'L',0);
$pdf->Cell('140',$height-2,'','',0,'L',0);
$pdf->SetFont('angsa','',10);
$pdf->Cell('25',$height-2,'Date','',1,'L',0);

$pdf->SetFont('angsab','',20);
$pdf->Cell('190',$height-2,'ใบเสร็จรับเงิน','',1,'C',0);
$pdf->SetFont('angsab','',18);
$pdf->Cell('190',$height-2,'RECEIPT','',1,'C',0);

$pdf->SetFont('ARIAL','B',8);
$pdf->SetXY(185,162);
$pdf->Cell('25',$height-2,$rec_inpay[pay_id],'',0,'L',0);

$en=substr($rec_inpay[pay_date],6,2).'/'.substr($rec_inpay[pay_date],4,2).'/'.substr($rec_inpay[pay_date],0,4);
$date=date("d/m/Y");
$pdf->SetXY(185,171);
$pdf->Cell('25',$height-2,$en,'',0,'L',0);

$pdf->SetFont('ARIAL','',10);

$position=182;
$pdf->SetXY(10,$position);
$position+=5;
$pdf->SetXY(10,$position);
$position+=5;

$next=$BBA_Current_Year+1;
$BBA_Current_Tri1=$BBA_Current_Tri;
if($BBA_Current_Tri=='4'){
	$BBA_Current_Tri1="S";
}

$en = explode("/",$en);
$enrollment= date("d F Y", mktime(0, 0, 0, $en[1], $en[0], $en[2]));

$pdf->SetFont('angsa','',13);
$pdf->Cell('140','6',"     ได้รับเงินจาก  ",'LT','0','L','0');
$pdf->Cell('50','6',"",'TLR','1','L','0');

$pdf->Cell('140','6',"     Received From:",'L','0','L','0');
$pdf->Cell('50','6',"",'LR','1','L','0');

$pdf->Cell('140','6',"     หลักสูตร   ",'L','0','L','0');
$pdf->Cell('50','6',"   Issued By  สุพรรณี   สามงามทอง",'LR','1','L','0');

$pdf->Cell('140','6',"     Program:",'LBR','0','L','0');
$pdf->Cell('50','6',"",'LBR','1','LR','0');
$pdf->SetFont('angsab','',12);
$pdf->Cell('140','4','รายการ','L','0','C','0');
$pdf->Cell('50','4','จำนวนเงิน(บาท)','LR','1','C','0');

$pdf->Cell('140','4','DESCRIPTION','LB','0','C','0');
$pdf->Cell('50','4','Amount','LRB','1','C','0');
$pdf->SetFont('angsa','',13.5);
$position+=27;
$total_price = "0"; 
$x = 0;
$start=$position;

$pay_year=$BBA_Current_Year+543;
$pdf->Cell('140','5.5',"การลงทะเบียนภาคการศึกษาที่ ".$BBA_Current_Tri1." ปีการศึกษา ".$pay_year."",'LR','0','L','0');
$pdf->Cell('50','5.5',"",'LR','1','R','0');
$eng_year=$pay_year-543;
$pdf->Cell('140','5',"Registration for Trimester ".$BBA_Current_Tri1."/".$eng_year."",'LR','0','L','0');
$pdf->Cell('50','5',"",'LR','1','R','0');					
$start+=5;
$sql_fee=$DB->QUERY(" SELECT * FROM BBA_Payment_Detail  WHERE  payd_payid='$PaymentId'  ORDER BY payd_sort ");
$otherfee=0;
$countminus = 0;

while($rec_major_fee = $DB->FETCH_ARRAY($sql_fee)){
    $x++;
	switch(trim($rec_major_fee[payd_item])){
       case "Tution Fee": $payname="ค่าหน่วยกิต (Tuition fee)"; break;
	   default :  $payname="ค่าบำรุงและค่าธรรมเนียม (College and Other fee)";         
							 $otherfee+=$rec_major_fee[payd_cost];break;
    }

	if(trim($rec_major_fee[payd_item])=="Tution Fee"){
		$pdf->Cell('10','5.5','','L','0','L','0');
		$pdf->Cell('130','5.5'," - ".$payname."",'R','0','L','0');
		$pdf->Cell('35','5.5',number_format($rec_major_fee[payd_cost],2,'.',','),'L','0','R','0');
		$pdf->Cell('15','5.5','','R','1','R','0');
	}
    $total_price = $total_price + $rec_major_fee[payd_cost];
	$start+=5;
}

if($otherfee>0){
				$pdf->Cell('10','5.5','','L','0','L','0');
				$pdf->Cell('130','5.5'," - ".$payname."",'R','0','L','0');
				$pdf->Cell('35','5.5',number_format($otherfee+$MissingFee,2,'.',','),'L','0','R','0');
				$pdf->Cell('15','5.5','','R','1','R','0');
				$count_detail=3;
}

/*
$sql_feedue = $DB->QUERY("SELECT sum(MUIC_StudPayment_Cost) as cost_money FROM MUIC_StudPayment WHERE MUIC_StudPayment_Link='$PaymentId' and
MUIC_StudPayment_TypeID='3'");
$rec_feedue = $DB->DATA_FETCH_ARRAY($sql_feedue);
		
if($rec_feedue[cost_money]>0 OR $countminus == "1"){
				$pdf->Cell('10','5.5','','L','0','L','0');
				$pdf->Cell('130','5.5'," - ค่าปรับล่าช้า (Late Registration fee)",'R','0','L','0');
				$pdf->Cell('35','5.5',number_format(($rec_feedue[cost_money]+$Course_cost),2,'.',','),'L','0','R','0');
				$pdf->Cell('15','5.5','','R','1','R','0');
				$total_price = $total_price+$rec_feedue[cost_money];
				$count_detail=4;
}
*/

//	$count_detail += $countminus;
for($g=1;$g<=(4-$count_detail);$g++){
		$pdf->Cell('10','5','','L','0','L','0');
		$pdf->Cell('130','5',"",'R','0','L','0');
		$pdf->Cell('35','5',"",'L','0','R','0');
		$pdf->Cell('15','5','','R','1','R','0');
}
$position=$start+2;

$position+=7;
$pdf->Cell('100','7',"			(".m_tran($total_price,2).")",'T','0','L','0');
$pdf->SetFont('angsab','',15);
$pdf->Cell('40','6','รวม TOTAL     ','T','0','R','0');
$pdf->Cell('35','6',number_format($total_price,2),'LTB','0','R','0');
$pdf->Cell('15','6','','TBR','1','R','0');
$pdf->SetFont('angsa','',14);
$pdf->Cell('140','7','			('.strtoupper(int_to_words($total_price)).' BAHT ONLY)','0','0','L','0');
$pdf->Cell('50','10','___________________','0','1','C','0');
$pdf->Cell('140','7','','0','0','L','0');
$pdf->SetFont('angsa','',12);
$pdf->Cell('50','0','(สุพรรณี   สามงามทอง)','0','1','C','0');
$pdf->Cell('140','0','','0','0','C','0');
$pdf->Cell('50','8','ผู้รับเงิน Receiver','0','1','C','0');
$pdf->SetFont('angsab','',14);
$pdf->SetXY('30','204');
$pdf->Cell('','',$rec_maj,'','0','L','0');

$pdf->SetXY('35','188');
$pdf->Cell('140','6',"".$rec_stu[stu_id]."  ".$rec_stu[stu_title]." ".$rec_stu[stu_fname]." ".$rec_stu[stu_mame]." ".$rec_stu[stu_lname]."",'','0','L','0');

$pdf->SetFont('angsa','',14);
$pdf->SetXY('100','198');
$pdf->Cell('100','4',"อ้างถึง ");
$pdf->SetXY('100','204');
$pdf->Cell('100','4',"Invoice No.");
$pdf->SetFont('ARIAL','B',9);
$pdf->SetXY('117','201');
$pdf->Cell('100','4',$rec_inpay["pay_id"]);


$pdf->Output('receipt','I');

?>