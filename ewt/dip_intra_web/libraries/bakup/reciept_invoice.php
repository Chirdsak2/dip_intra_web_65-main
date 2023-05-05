<?php
require('../fpdf.php');
include("../../system/lib/student_session.php");
require_once "../../system/lib/db_define.php";
require_once "../../system/class/System_DBConfig.php";
require_once "../../system/lib/connectdb.php";
require_once "../../system/lib/config.php";
require_once "../../students/system/Function.php";
include("../../system/current_year_tri.php");
require_once "../../system/class/System_DateTime.php";
require_once "../../mod_financialmanagement/setup/FUNCTION.php";

//Cell( w ,  h ,  txt ,  border ,  ln ,  align ,  fill ,  link)


$pdf=new FPDF('P','mm','A4');//?????????, ????????, ??????????
$pdf->AddPage();//??????????????????????????
$pdf->AddFont('angsa','','angsa.php');//?????????????

if($MUIC_StudPayment_Tri){
	$MUIC_Current_Tri=$MUIC_StudPayment_Tri;
	$MUIC_Current_Year=$MUIC_StudPayment_Year;
}
$sqlStuID = "SELECT * FROM MUIC_Student WHERE MUIC_Student_ID = '$studentid'";
$queryStuID = $DB->QUERY($sqlStuID); 
$rec_stu = $DB->DATA_FETCH_ARRAY($queryStuID);
$sql_maj = "select * From MUIC_Major Where MUIC_Major_ID='$rec_stu[MUIC_Student_Major_ID]'";
$querymaj = $DB->QUERY($sql_maj); 
$rec_maj = $DB->DATA_FETCH_ARRAY($querymaj);

$SQLx = $DB->QUERY("SELECT * FROM MUIC_Course_Record 
WHERE MUIC_Course_Record_ID = '".$DB->DATA_FETCH_FIELD($queryStuID,0,"MUIC_Student_CourseRecord_ID")."'");

	$query  = $DB->QUERY("select MUIC_StudPayment_DateExpire,MUIC_StudPayment_InvNo From MUIC_StudPayment where MUIC_StudPayment_ID = '$PaymentId'");
		$rec_enroll = $DB->DATA_FETCH_ARRAY($query);
	$en = explode("/",$rec_enroll[MUIC_StudPayment_DateExpire]);
	$enrollment= date("d F Y", mktime(0, 0, 0, $en[1], $en[0], $en[2]));
/*if($regis_status=='1'){
	$type = '1';
	$query  = $DB->QUERY("select MUIC_Register_TPay From MUIC_Register_TempDate where MUIC_Register_TTri='$MUIC_Current_Tri'
	and MUIC_Register_TYear='$MUIC_Current_Year'");
	$rec_enroll = $DB->DATA_FETCH_ARRAY($query);
	$en = explode("/",$rec_enroll[MUIC_Register_TPay]);
	$enrollment= date("d F Y", mktime(0, 0, 0, $en[1], $en[0], $en[2]));
}else{
	$type = '2';
	$query  = $DB->QUERY("select MUIC_AddDrop_Date_Payment From MUIC_AddDrop_Date");
	$rec_enroll = $DB->DATA_FETCH_ARRAY($query);
	$en = explode("/",$rec_enroll[MUIC_AddDrop_Date_Payment]);
	$enrollment= date("d F Y", mktime(0, 0, 0, $en[1], $en[0], $en[2]));
}
$inpay=$DB->QUERY("SELECT MUIC_StudPayment_InvNo FROM MUIC_StudPayment
												WHERE MUIC_StudPayment_StuID = '$studentid' AND MUIC_StudPayment_TypeID = '$type' 
																AND MUIC_StudPayment_Tri = '$MUIC_Current_Tri' 
																AND MUIC_StudPayment_Year = '$MUIC_Current_Year'
																ORDER BY MUIC_StudPayment_ID DESC");
$rec_inpay = mssql_fetch_array($inpay); */
//Payment Check
$PayID = $DB->DATA_FETCH_FIELD($queryStuID,0,"MUIC_Student_FinanceID");
$pdf->Image('logo.png',10,10,png);
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
$pdf->Cell('100','7',"Invoice No. ".$rec_enroll[MUIC_StudPayment_InvNo]."",'','0','R','0');
$pdf->SetXY(10,$position);
$position+=5;
$pdf->Cell('90','7',"STUDENT : ".$rec_stu[MUIC_Student_Code]."       ".$rec_stu[MUIC_Student_Title]." ".$rec_stu[MUIC_Student_FNameEN]." ".$rec_stu[MUIC_Student_MidNameEN]." ".$rec_stu[MUIC_Student_SNameEN]."",'','0','L','0');
$pdf->Cell('100','7',"Print Date : ".date("d F Y")."",'','0','R','0');
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
if($regis_status=='1'){
		$sql_fee=$DB->QUERY("SELECT * FROM MUIC_StudPayDetail 
												WHERE MUIC_StudPayDetail_StuID = '$studentid' AND MUIC_StudPayDetail_Type = '1' 
																AND MUIC_StudPayDetail_Tri = '$MUIC_Current_Tri' 
																AND MUIC_StudPayDetail_Year = '$MUIC_Current_Year'
																ORDER BY MUIC_StudPayDetail_SubID DESC,MUIC_StudPayDetail_ID ASC");
		while($rec_major_fee = mssql_fetch_array($sql_fee)){
				$x++;
				
					$pdf->SetXY(10,$start);
					$pdf->Cell('60','7','','','0','R','0');
					 if($rec_major_fee[MUIC_StudPayDetail_Name]=="Registration Fee"){
				   $name="Tuition Fee";
				   }else{
				   	$name=$rec_major_fee[MUIC_StudPayDetail_Name];
				   }
				  
					$pdf->Cell('60','7',$name,'','0','L','0');
					$pdf->Cell('65','7',number_format($rec_major_fee[MUIC_StudPayDetail_Cost],2,'.',','),'','0','R','0');

					$total_price = $total_price + $rec_major_fee[MUIC_StudPayDetail_Cost];
					$start+=5;
		}
}else{
		$sql_fee=$DB->QUERY("SELECT * FROM MUIC_StudPayment
												WHERE MUIC_StudPayment_ID = '$PaymentId'");
	    $rec_major_fee = mssql_fetch_array($sql_fee);
		$pdf->SetXY(10,$start);
		$pdf->Cell('60','7','','','0','R','0');
		$pdf->Cell('60','7',"Add Drop Fee",'','0','L','0');
	    $pdf->Cell('65','7',number_format($rec_major_fee[MUIC_StudPayment_Cost],2,'.',','),'','0','R','0');
		$total_price =  $rec_major_fee[MUIC_StudPayment_Cost];
		$start+=7;
}

$sql_feedue = $DB->QUERY("SELECT sum(MUIC_StudPayment_Cost) as cost_money FROM MUIC_StudPayment WHERE MUIC_StudPayment_Link='$PaymentId' and
MUIC_StudPayment_TypeID='3'");
$rec_feedue = $DB->DATA_FETCH_ARRAY($sql_feedue);

if($rec_feedue[cost_money]>0){
	$pdf->SetXY(10,$start);
	$pdf->Cell('60','7','','','0','R','0');
	$pdf->Cell('60','7',"Late Payment Fee",'','0','L','0');
	$pdf->Cell('65','7',number_format($rec_feedue[cost_money],2,'.',','),'','0','R','0');
	$total_price = $total_price+$rec_feedue[cost_money];
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
$pdf->Cell('80','7','............MUIC Academic Services Officer.........','LTR','0','C','0');
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
$pdf->Cell($table_right,'6',"Indentification No. :    $rec_stu[MUIC_Student_Code] ".$System_Session_User_Code." ",'LR','0','L','0');
$pdf->SetXY($size_page,$position);
$position+=10;
$pdf->Cell('90','6','Service Code : MUIC','','0','L','0');
$pdf->Cell($table_right,'6',"Debit Invoice No. :      ".$rec_enroll[MUIC_StudPayment_InvNo]."   Date :  ",'LBR','0','L','0');


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