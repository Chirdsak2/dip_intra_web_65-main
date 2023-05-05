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
/*
if($MUIC_StudPayment_Tri){
	$MUIC_Current_Tri=$MUIC_StudPayment_Tri;
	$MUIC_Current_Year=$MUIC_StudPayment_Year;
}*/


$query  = $DB->QUERY("select * From BBA_Payment where pay_id = '$payid'");
$rec_enroll = $DB->FETCH_ARRAY($query);

$sqlStuID = "SELECT * FROM BBA_Student WHERE stu_id = '".$rec_enroll[pay_stuid]."'";
$queryStuID = $DB->QUERY($sqlStuID); 
$rec_stu = $DB->FETCH_ARRAY($queryStuID);
$rec_maj = "MBA";


/*$en = explode("/",$rec_enroll[MUIC_StudPayment_DateExpire]);
$enrollment= date("d F Y", mktime(0, 0, 0, $en[1], $en[0], $en[2]));
*/
$enrollment=$rec_enroll[pay_type];

$pdf->SetXY(10,$position+5);
$pdf->SetFont('ARIAL','I',10);
$pdf->Cell('190','7',"Student Copy",'','0','R','0');
$position+=7;

//Payment Check
//$PayID = $DB->DATA_FETCH_FIELD($queryStuID,0,"MUIC_Student_FinanceID");
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
$next=$BBA_Current_Year+1;
$BBA_Current_Tri1=$BBA_Current_Tri;
if($BBA_Current_Tri=='4'){
	$BBA_Current_Tri1="S";
}
$pdf->Cell('90','7',"Trimester : ".$BBA_Current_Tri1."/".$BBA_Current_Year." - ".$next."",'','0','L','0');
$pdf->Cell('100','7',"Invoice No. ".$rec_enroll[pay_id]."",'','0','R','0');
$pdf->SetXY(10,$position);
$position+=5;
$pdf->Cell('90','7',"STUDENT : ".$rec_stu[stu_id]."       ".$rec_stu[stu_title]." ".$rec_stu[stu_fname]." ".$rec_stu[stu_mname]." ".$rec_stu[stu_lname]."",'','0','L','0');
$pdf->Cell('100','7',"Print Date : ".date("d F Y")."",'','0','R','0');
$pdf->SetXY(10,$position);
$position+=6;

/*if($DB->COUNT_ROW($SQLx)){ $program=$DB->DATA_FETCH_FIELD($SQLx ,0,"MUIC_Course_Record_Name"); }else{ $program= "No Course Record"; }*/
$program="Business Modeling and Analysis";
$pdf->Cell('90','7',"PROGRAM : ".$program,'','0','L','0');
$pdf->SetXY(10,$position);
$position+=7;
$pdf->Cell('60','7','Fee Code','TRB','0','C','0');
$pdf->Cell('60','7','Item','LTRB','0','C','0');
$pdf->Cell('70','7','Amount (Baht)','LTB','0','R','0');

$total_price = "0"; 
$x = 0;
$start=$position;
$sql_chkreg="SELECT * From BBA_Payment Where pay_id='$payid'";
$query_chkreg=$DB->QUERY($sql_chkreg);
$data_chkreg=$DB->FETCH_ARRAY($query_chkreg);
if($data_chkreg[pay_type]=='RE'){
   $regis_status=1;
}
if($regis_status=='1'){
	$sql_fee=$DB->QUERY("SELECT * FROM BBA_Payment_Detail 
													WHERE payd_payid = '$payid' 
													Order By payd_sort");
	while($rec_major_fee = $DB->FETCH_ARRAY($sql_fee)){
		$x++;
		
		$pdf->SetXY(10,$start);
		$pdf->Cell('60','7','','','0','R','0');
		$name=$rec_major_fee[payd_item];
		  
		$pdf->Cell('60','7',$name,'','0','L','0');
		$pdf->Cell('70','7',number_format($rec_major_fee[payd_cost],2,'.',','),'','0','R','0');

		$total_price = $total_price + $rec_major_fee[payd_cost];
		$start+=4;
	}
}else{
		$sql_fee=$DB->QUERY("SELECT * FROM BBA_Payment WHERE pay_id = '$payid'");
	    $rec_major_fee = $DB->FETCH_ARRAY($sql_fee);

		$sql_pc=$DB->QUERY("SELECT app_precourse  
		                                       FROM BBA_Student inner join BBA_Application on stu_appid=app_id
		                                       WHERE stu_id = '$rec_stu[stu_id]' ");
	    $rec_pc = $DB->FETCH_ARRAY($sql_pc);
		if($rec_pc[app_precourse] !=''){
			  $countPC=0;
			  $ArrayPC = explode('/',$rec_pc[app_precourse] );
			  for($i=0;$i<sizeof($ArrayPC);$i++){
				 if($ArrayPC[$i]>0){
					$countPC++;
					 if($countPC==1){
						$pc_show=$ArrayPC[$i];
					 }else{
						$pc_show.=','.$ArrayPC[$i];
					}
				 }
			  }
		}
/*
		$pdf->SetXY(10,$start);
		$pdf->Cell('60','7','','','0','R','0');
		$pdf->Cell('60','7',"Pre Crouse $pc_show",'','0','L','0');
	    $pdf->Cell('70','7',number_format($rec_major_fee[pay_cost],2,'.',','),'','0','R','0');
		$total_price =  $rec_major_fee[pay_cost];
		$start+=7;
*/
		$pdf->SetXY(10,$start);
		$pdf->Cell('60','7','','','0','R','0');
		$pdf->Cell('60','7',"Add-DropFee",'','0','L','0');
	    $pdf->Cell('70','7',number_format($rec_major_fee[pay_cost],2,'.',','),'','0','R','0');
		$total_price =  $rec_major_fee[pay_cost];
		$start+=4;
}

/*$sql_feedue = $DB->QUERY("SELECT sum(MUIC_StudPayment_Cost) as cost_money FROM MUIC_StudPayment WHERE MUIC_StudPayment_Link='$PaymentId' and
MUIC_StudPayment_TypeID='3'");
$rec_feedue = $DB->FETCH_ARRAY($sql_feedue);*/
$rec_feedue =24000;
if($rec_feedue[cost_money]>0){
	$pdf->SetXY(10,$start);
	$pdf->Cell('60','7','','','0','R','0');
	$pdf->Cell('60','7',"Late Payment Fee",'','0','L','0');
	$pdf->Cell('70','7',number_format($rec_feedue[cost_money],2,'.',','),'','0','R','0');
	$total_price = $total_price+$rec_feedue[cost_money];
}
$position=$start+5;

$pdf->SetXY(10,$position);
$position+=7;
$pdf->Cell('60','7','Total Payment of','T','0','C','0');
$pdf->Cell('130','7',number_format($total_price,2),'T','0','R','0');
$temp=10;
$pdf->SetXY(20,$position+$temp);
$position+=5;
$pdf->Cell('80','7','                     MUIC Finance Officer                  ','LTR','0','C','0');
$pdf->Cell('10','7','','LR','0','C','0');
$pdf->Cell('80','7','            MUIC Academic Services Officer        ','LTR','0','C','0');
$pdf->SetXY(20,$position+$temp);
$position+=5;
$pdf->Cell('80','7','Signature.......................................................','LR','0','C','0');
$pdf->Cell('10','7','','LR','0','C','0');
$pdf->Cell('80','7','Signature.......................................................','LR','0','C','0');
$pdf->SetXY(20,$position+$temp);
$position+=7;
$pdf->Cell('80','7','Date............/.................../....................','LBR','0','C','0');
$pdf->Cell('10','7','','LR','0','C','0');
$pdf->Cell('80','7','Date............/.................../....................','LBR','0','C','0');

$pdf->SetXY(20,$position);
$position+=5;
//$pdf->SetFont('ARIAL','BI',10);
//$pdf->Cell('175','7',"** The lastest payment for normal enrollment is ".$enrollment."",'','0','R','0');

$pdf->SetXY(20,$position+$temp);
$position+=7;
$pdf->SetFont('ARIAL','I',10);
$pdf->Cell('175','7','Note : This receipt is valid only if the college has cleared the payment','','0','C','0');




//$plusTOP=130;
$position=149;
$pdf->SetXY(10,$position);
$pdf->SetFont('ARIAL','I',10);
$pdf->Cell('190','7',"Financial Copy ",'T','0','R','0');
$position+=7;
$pdf->Image('logo.png',10,$position,png);
$pdf->SetFont('ARIAL','B',18);
$position+=10;
$pdf->SetXY(10,$position);
$pdf->Cell('','','MAHIDOL UNIVERSITY',0,0,'C',0);
$position+=7;
$pdf->SetXY(10,$position);
$pdf->Cell('','','INTERNATIONAL COLLEGE',0,1,'C',0);

$position+=11;
$pdf->SetFont('ARIAL','',10);
$pdf->SetXY(10,$position);
$position+=5;
$pdf->Cell('190','7','Registration Invoice','','0','R','0');
$pdf->SetXY(10,$position);
$position+=5;

$pdf->Cell('90','7',"Trimester : ".$BBA_Current_Tri1."/".$BBA_Current_Year." - ".$next."",'','0','L','0');
$pdf->Cell('100','7',"Invoice No. ".$rec_enroll[pay_id]."",'','0','R','0');
$pdf->SetXY(10,$position);
$position+=5;
$pdf->Cell('90','7',"STUDENT : ".$rec_stu[stu_id]."       ".$rec_stu[stu_title]." ".$rec_stu[stu_fname]." ".$rec_stu[stu_mname]." ".$rec_stu[stu_lname]."",'','0','L','0');
$pdf->Cell('100','7',"Print Date : ".date("d F Y")."",'','0','R','0');
$pdf->SetXY(10,$position);
$position+=6;

/*if($DB->COUNT_ROW($SQLx)){ $program=$DB->DATA_FETCH_FIELD($SQLx ,0,"MUIC_Course_Record_Name"); }else{ $program= "No Course Record"; }*/
$pdf->Cell('90','7',"PROGRAM : ".$program,'','0','L','0');
$pdf->SetXY(10,$position);
$position+=7;
$pdf->Cell('60','7','Fee Code','TRB','0','C','0');
$pdf->Cell('60','7','Item','LTRB','0','C','0');
$pdf->Cell('70','7','Amount (Baht)','LTB','0','R','0');

$total_price = "0"; 
$x = 0;
$start=$position;
if($regis_status=='1'){
	$sql_fee=$DB->QUERY("SELECT * FROM BBA_Payment_Detail 
													WHERE payd_payid = '$payid' 
													Order By payd_sort");
	while($rec_major_fee = $DB->FETCH_ARRAY($sql_fee)){
		$x++;

		$pdf->SetXY(10,$start);
		$pdf->Cell('60','7','','','0','R','0');
		$name=$rec_major_fee[payd_item];

		$pdf->Cell('60','7',$name,'','0','L','0');
		$pdf->Cell('70','7',number_format($rec_major_fee[payd_cost],2,'.',','),'','0','R','0');

		$total_price = $total_price + $rec_major_fee[payd_cost];
		$start+=4;
	}
}else{
		$sql_fee=$DB->QUERY("SELECT * FROM BBA_Payment WHERE pay_id = '$payid'");
	    $rec_major_fee = $DB->FETCH_ARRAY($sql_fee);
/*
		$pdf->SetXY(10,$start);
		$pdf->Cell('60','7','','','0','R','0');
		$pdf->Cell('60','7',"Pre Crouse $pc_show",'','0','L','0');
	    $pdf->Cell('70','7',number_format($rec_major_fee[pay_cost],2,'.',','),'','0','R','0');
		$total_price =  $rec_major_fee[pay_cost];
		$start+=7;
*/
		$pdf->SetXY(10,$start);
		$pdf->Cell('60','7','','','0','R','0');
		$pdf->Cell('60','7',"Add-DropFee",'','0','L','0');
	    $pdf->Cell('70','7',number_format($rec_major_fee[pay_cost],2,'.',','),'','0','R','0');
		$total_price =  $rec_major_fee[pay_cost];
		$start+=4;
}

/*$sql_feedue = $DB->QUERY("SELECT sum(MUIC_StudPayment_Cost) as cost_money FROM MUIC_StudPayment WHERE MUIC_StudPayment_Link='$PaymentId' and
MUIC_StudPayment_TypeID='3'");
$rec_feedue = $DB->FETCH_ARRAY($sql_feedue);*/
$rec_feedue =24000;
if($rec_feedue[cost_money]>0){
	$pdf->SetXY(10,$start);
	$pdf->Cell('60','7','','','0','R','0');
	$pdf->Cell('60','7',"Late Payment Fee",'','0','L','0');
	$pdf->Cell('70','7',number_format($rec_feedue[cost_money],2,'.',','),'','0','R','0');
	$total_price = $total_price+$rec_feedue[cost_money];
}
$position=$start+5;

$pdf->SetXY(10,$position);
$position+=7;
$pdf->Cell('60','7','Total Payment of','T','0','C','0');
$pdf->Cell('130','7',number_format($total_price,2),'T','0','R','0');

$pdf->SetXY(20,$position+$temp);
$position+=5;
$pdf->Cell('80','7','                     MUIC Finance Officer                  ','LTR','0','C','0');
$pdf->Cell('10','7','','LR','0','C','0');
$pdf->Cell('80','7','            MUIC Academic Services Officer        ','LTR','0','C','0');
$pdf->SetXY(20,$position+$temp);
$position+=5;
$pdf->Cell('80','7','Signature.......................................................','LR','0','C','0');
$pdf->Cell('10','7','','LR','0','C','0');
$pdf->Cell('80','7','Signature.......................................................','LR','0','C','0');
$pdf->SetXY(20,$position+$temp);
$position+=7;
$pdf->Cell('80','7','Date............/.................../....................','LBR','0','C','0');
$pdf->Cell('10','7','','LR','0','C','0');
$pdf->Cell('80','7','Date............/.................../....................','LBR','0','C','0');

$pdf->SetXY(20,$position);
$position+=5;
//$pdf->SetFont('ARIAL','BI',10);
//$pdf->Cell('175','7',"** The lastest payment for normal enrollment is ".$enrollment."",'','0','R','0');

$pdf->SetXY(20,$position+$temp);
$position+=7;
$pdf->SetFont('ARIAL','I',10);
$pdf->Cell('175','7','Note : This receipt is valid only if the college has cleared the payment','','0','C','0');






$pdf->Output('receipt','I');

?>