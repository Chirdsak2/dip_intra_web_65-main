<?php
session_start();
if(!$_SESSION['UserLogin'] and !$_SESSION['userid']){exit;}

require('fpdf.php');
include('../class/class_db.php');
$DB = new  dbase;
include('../system/current_trimester.php');


$payid=base64_decode($payid);

//Cell( w ,  h ,  txt ,  border ,  ln ,  align ,  fill ,  link)
$pdf=new FPDF('P','mm','A4');//?????????, ????????, ??????????
$pdf->AddPage();//??????????????????????????
$pdf->AddFont('angsa','','angsa.php');//?????????????

$query  = $DB->QUERY("select * From BBA_Payment where pay_id = '$payid'");
$rec_enroll = $DB->FETCH_ARRAY($query);

$sqlStuID = "SELECT * FROM BBA_Student WHERE stu_id = '".$rec_enroll[pay_stuid]."'";
$queryStuID = $DB->QUERY($sqlStuID); 
$rec_stu = $DB->FETCH_ARRAY($queryStuID);
$rec_maj = "MBA";

$enrollment=$rec_enroll[pay_type];

$pdf->SetXY(10,$position+5);
$pdf->SetFont('ARIAL','I',10);
$pdf->Cell('190','7',"Student Copy",'','0','R','0');
$position+=7;

$pdf->Image('logo.png',10,10,png);
$pdf->SetFont('ARIAL','',8);
$pdf->SetXY(100,15);
$pdf->Cell('100','0',"Print Date : ".date("j F Y")."",'','0','R','0');
$pdf->SetFont('ARIAL','B',18);
$pdf->SetXY(10,20);

$pdf->Cell('','','MAHIDOL UNIVERSITY',0,0,'C',0);
$pdf->SetXY(10,27);
$pdf->Cell('','','INTERNATIONAL COLLEGE',0,1,'C',0);

$pdf->SetFont('ARIAL','',10);
/*$pdf->SetXY(10,33);
$pdf->Cell('190','7','Vol. 378   No. 008','','0','R','0');*/
$position=38;
$pdf->SetXY(10,$position);
$position+=5;
$pdf->Cell('190','7','Registration Invoice','','0','R','0');
$pdf->SetXY(10,$position);
$position+=5;
$next=$MUIC_Current_Year+1;
$MUIC_Current_Tri1=$MUIC_Current_Tri;
if($MUIC_Current_Tri=='4'){
	$MUIC_Current_Tri1="S";
}
$pdf->Cell('90','7',"Trimester : ".$MUIC_Current_Tri1."/".$MUIC_Current_Year." - ".$next."",'','0','L','0');
$pdf->Cell('100','7',"Invoice No. ".$rec_inpay[MUIC_StudPayment_InvNo]."",'','0','R','0');
$pdf->SetXY(10,$position);
$position+=5;
$pdf->Cell('90','7',"STUDENT : ".$rec_stu[MUIC_Student_Code]."       ".$rec_stu[MUIC_Student_Title]." ".$rec_stu[MUIC_Student_FNameEN]." ".$rec_stu[MUIC_Student_MidNameEN]." ".$rec_stu[MUIC_Student_SNameEN]."",'','0','L','0');
if($rec_inpay[MUIC_StudPayment_TypeID]=='1'){
$date_txt = "REG.";
}else{
$date_txt = "Add/Drop";
}
$pdf->Cell('100','7',$date_txt." Approved Date : ".$appdate."",'','0','R','0');
$pdf->SetXY(10,$position);
$position+=6;

if(mssql_num_rows($SQLx)){ $program=$DB->DATA_FETCH_FIELD($SQLx ,0,"MUIC_Course_Record_Name"); }else{ $program= "No Course Record"; }

$pdf->Cell('90','7',"PROGRAM : ".$program." (".$rec_maj[MUIC_Major_Code].")",'','0','L','0');
$pdf->SetXY(10,$position);
$position+=7;
$pdf->Cell('60','7','Fee Code','TRB','0','C','0');
$pdf->Cell('60','7','Item','LTRB','0','C','0');
$pdf->Cell('65','7','Amount (Baht)','LTB','0','R','0');

$total_price = "0"; 
$x = 0;
$start=$position;
if($rec_inpay[MUIC_StudPayment_TypeID]=='1'){
		$sql_fee=$DB->QUERY("SELECT * FROM MUIC_StudPayDetail 
												WHERE MUIC_StudPayDetail_StuID = '$studentid' AND MUIC_StudPayDetail_Type = '1' 
																AND MUIC_StudPayDetail_Tri = '$MUIC_Current_Tri' 
																AND MUIC_StudPayDetail_Year = '$MUIC_Current_Year'
																ORDER BY MUIC_StudPayDetail_SubID DESC,MUIC_StudPayDetail_ID ASC");
		while($rec_major_fee = mssql_fetch_array($sql_fee)){
				$x++;
				
					$pdf->SetXY(10,$start);
					$pdf->Cell('60','7','','','0','R','0');
					$pdf->Cell('60','7',ereg_replace("Registration Fee","Tution Fee",$rec_major_fee[MUIC_StudPayDetail_Name]),'','0','L','0');
					$pdf->Cell('65','7',number_format($rec_major_fee[MUIC_StudPayDetail_Cost],2,'.',','),'','0','R','0');

					$total_price = $total_price + $rec_major_fee[MUIC_StudPayDetail_Cost];
					$start+=5;
		}
}elseif($rec_inpay[MUIC_StudPayment_TypeID]=='2'){
		$sql_fee=$DB->QUERY("SELECT * FROM MUIC_StudPayment
												WHERE MUIC_StudPayment_ID= '$finid'
																ORDER BY MUIC_StudPayment_ID DESC");
	    $rec_major_fee = mssql_fetch_array($sql_fee);

						$query_professfee = $DB->QUERY("select sum(MUIC_StudPayment_Cost) as professfee From MUIC_StudPayment where MUIC_StudPayment_TypeID='4' And MUIC_StudPayment_Link='$finid'");
	    $rec_profess_fee = mssql_fetch_array($query_professfee);
$tution = $rec_major_fee[MUIC_StudPayment_Cost] - $rec_profess_fee[professfee] - 20;
		$pdf->SetXY(10,$start);
		$pdf->Cell('60','7','','','0','R','0');
		$pdf->Cell('60','7',"Tution Fee",'','0','L','0');
	    $pdf->Cell('65','7',number_format($tution,2,'.',','),'','0','R','0');
		$total_price =  $rec_major_fee[MUIC_StudPayment_Cost];
		$start+=7;
if($rec_profess_fee[professfee] > 0){
				$pdf->SetXY(10,$start);
		$pdf->Cell('60','7','','','0','R','0');
		$pdf->Cell('60','7',"Add/Drop Processing Fee",'','0','L','0');
	    $pdf->Cell('65','7',number_format($rec_profess_fee[professfee],2,'.',','),'','0','R','0');
		$total_price =  $rec_major_fee[MUIC_StudPayment_Cost];
		$start+=7;
}
				$pdf->SetXY(10,$start);
		$pdf->Cell('60','7','','','0','R','0');
		$pdf->Cell('60','7',"Bank Fee",'','0','L','0');
	    $pdf->Cell('65','7','20.00','','0','R','0');
		$total_price =  $rec_major_fee[MUIC_StudPayment_Cost];
		$start+=7;
}

if($paid>0){

	$pdf->SetXY(10,$start);
	$pdf->Cell('60','7','','','0','R','0');
	$pdf->Cell('60','7',"Late Payment Fee",'','0','L','0');
	$pdf->Cell('65','7',number_format($paid,2,'.',','),'','0','R','0');
	$total_price = $total_price+$paid;
}
$position=$start+5;

$pdf->SetXY(10,$position);
$position+=7;
$pdf->Cell('60','7','Total Payment of','T','0','C','0');
$pdf->Cell('125','7',number_format($total_price,2),'T','0','R','0');

$pdf->SetXY(20,$position);
$position+=5;
$pdf->Cell('80','7','.....................MUIC Finance Officer.................','LTR','0','C','0');
$pdf->Cell('10','7','','LR','0','C','0');
$pdf->Cell('80','7','............MUIC Acedemic Services Officer.........','LTR','0','C','0');
$pdf->SetXY(20,$position);
$position+=5;
$pdf->Cell('80','7','Signature.......................................................','LR','0','C','0');
$pdf->Cell('10','7','','LR','0','C','0');
$pdf->Cell('80','7','Signature.......................................................','LR','0','C','0');
$pdf->SetXY(20,$position);
$position+=7;
$pdf->Cell('80','7','Date............/.................../....................','LBR','0','C','0');
$pdf->Cell('10','7','','LR','0','C','0');
$pdf->Cell('80','7','Date............/.................../....................','LBR','0','C','0');

$pdf->SetXY(20,$position);
$position+=5;
$pdf->SetFont('ARIAL','BI',10);
$pdf->Cell('175','7',"** The lastest payment for normal enrollment is ".$enrollment."",'','0','R','0');

$pdf->SetXY(20,$position);
$position+=7;
$pdf->SetFont('ARIAL','I',10);
$pdf->Cell('175','7','Note : This receipt is valid only if the college has cleared the payment','','0','C','0');

$pdf->SetXY(10,$position);
$position+=7;
$pdf->SetFont('ARIAL','',10);
$pdf->Cell('65','7','MAHIDOL UNIVERSITY','','0','L','0');
$pdf->Cell('65','7','DEPOSIT SLIP','','0','C','0');
$pdf->SetFont('ARIAL','I',10);
$pdf->Cell('59','7','For Bank','','0','R','0');

$pdf->SetXY(10,$position);
$position+=7;
$pdf->SetFont('ARIAL','',10);
$pdf->Cell('65','7','INTERNATIONAL COLLEGE','','0','L','0');
//$pdf->Cell('130','14','Vol. 378   No.008','','0','R','0');

$pdf->SetXY(10,$position);
$position+=7;
$pdf->Cell('195','7','Pay in slip at counter of any branch of Siam Commercial Bank','','0','L','0');

$pdf->SetXY(10,$position);
$position+=6;
$pdf->SetFont('angsa','',10);
$pdf->Cell('195','6','เพื่อเข้าบัญชีวิทยาลัยนานาชาติ มหาวิทยาลัยมหิดล','','0','L','0');

//Image(string file, float x, float y [, float w [, float h [, string type [, mixed link]]]]) 

$size_page=10;
$table_right=98;

$pdf->SetXY($size_page,$position);
//$pdf->SetXY(15,$position);
$position+=6;
$pdf->Cell('90','6','         บมจ. ธนาคารไทยพาณิชย์ เลขที่บัญชี 333-3-00119-7','','0','L','0');
$pdf->Image('../images/unchecked.png',11,$position-7,png);
$pdf->SetFont('ARIAL','',10);
$pdf->Cell($table_right,'6',"Student Name :          ".$rec_stu[MUIC_Student_Title]." ".$rec_stu[MUIC_Student_FNameEN]." ".$rec_stu[MUIC_Student_MidNameEN]." ".$rec_stu[MUIC_Student_SNameEN]." ",'LTR','0','L','0');

$pdf->SetXY($size_page,$position);
$position+=6;
$pdf->SetFont('angsa','',10);
$pdf->Cell('90','6','','','0','L','0');
//$pdf->Image('../images/unchecked.png',11,$position-7,png);
$pdf->SetFont('ARIAL','',10);
$pdf->Cell($table_right,'6',"Indentification No. :    $rec_stu[MUIC_Student_Code]  ".$System_Session_User_Code." ",'LR','0','L','0');
$pdf->SetXY($size_page,$position);
$position+=10;
$pdf->Cell('90','6','Service Code : MUIC','','0','L','0');
$pdf->Cell($table_right,'6',"Debit Invoice No. :     ".$rec_inpay[MUIC_StudPayment_InvNo]."   Date :  ",'LBR','0','L','0');

$table_right2=28;
$pdf->SetXY($size_page,$position);
$position+=6;
$pdf->SetFont('angsa','',10);
$pdf->Image('../images/unchecked.png',14,$position-7,png);
$pdf->Image('../images/unchecked.png',27,$position-7,png);
$pdf->Cell('35','6','เงินสด           เช็ค','LTR','0','C','0');
$pdf->Cell('35','6','เลขที่เช็ค','LTR','0','C','0');
$pdf->Cell('90','6','ชื่อธนาคาร/สาขา','LTR','0','C','0');
$pdf->Cell($table_right2,'6','จำนวนเงิน','LTR','0','C','0');
$pdf->SetXY($size_page,$position);
$position+=6;
$pdf->Cell('35','6',' ','LBR','0','C','0');
$pdf->Cell('35','6','','LTBR','0','C','0');
$pdf->Cell('90','6','','LTBR','0','C','0');
$pdf->Cell($table_right2,'6',number_format($total_price,2),'LTBR','0','R','0');
$pdf->SetXY($size_page,$position);
$position+=7;
$pdf->Cell('188','6','In Figures :','LTBR','0','L','0');


$pdf->SetFont('angsa','',13);
$pdf->SetXY(9,$position);
$position+=6;
$pdf->Cell('195','6','เพื่อความสะดวกกรุณานำเอกสารการลงทะเบียนฉบับนี้ไปชำระเงินได้ที่ธนาคารไทยพาณิชย์ทุกสาขาทั่วประเทศและนำใบ Invoice มาคืนที่งานการเงินทุกครั้ง ','','0','L','0');

$pdf->SetXY(9,$position);
$position+=6;
$pdf->Cell('195','6','จึงถือว่าการจ่ายเงินนี้สมบูรณ์','','0','L','0');

$pdf->SetFont('ARIAL','',10);
$pdf->SetXY(9,$position);
$position+=6;
$pdf->Cell('195','7','Please return your invoice slip to the MUIC Finance Office after finished your payment at the bank.  ','','0','L','0');

$pdf->SetXY(9,$position);
$position+=6;
$pdf->Cell('195','7','Failure to return invoice slip will result incomplete registration.','','0','L','0');

$pdf->Output('receipt','I');

?>