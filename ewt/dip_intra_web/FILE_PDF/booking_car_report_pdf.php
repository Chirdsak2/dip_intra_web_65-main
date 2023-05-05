<?php
require_once '../mpdf_autoload/vendor/autoload.php';
$mpdf = new \Mpdf\Mpdf();

function thainumDigit($num) {
	return str_replace(array('0', '1', '2', '3', '4', '5', '6', '7', '8', '9'),
	array("๐",
		  "๑",
		  "๒",
		  "๓",
		  "๔",
		  "๕",
		  "๖",
		  "๗",
		  "๘",
		  "๙"
	), $num);
}
/* format date input 2019-11-01 return ค่าเป็นอาเรย์ */
function convert_ex_date($date,$lang="TH"){
	$thai_date = array('','จันทร์','อังคาร','พุธ','พฤหัสบดี','ศุกร์','เสาร์','อาทิตย์');
	$thai_month = array("", "มกราคม", "กุมภาพันธ์", "มีนาคม", "เมษายน", "พฤษภาคม", "มิถุนายน", "กรกฎาคม", "สิงหาคม", "กันยายน", "ตุลาคม", "พฤศจิกายน", "ธันวาคม");
	$sub_thai_month = array("", "ม.ค.", "ก.พ.", "มี.ค.", "เม.ย.", "พ.ค.", "มิ.ย.", "ก.ค.", "ส.ค.", "ก.ย.", "ต.ค.", "พ.ย.", "ธ.ค.");

	if($date != ''){
		$date_start = new DateTime($date);
		$d_date 	= $date_start->format("d"); //เลขวันที่มีเลข 0 เช่น 01
		$j_date 	= $date_start->format("j"); //เลขวันที่ไม่มีเลข 0
		$t_date 	= $date_start->format("N"); //คืนค่าเป็นเลข นำค่าไปเทียบเลขในอาเรย์ ค่าที่คืน 1 - 7 โดยที่ 1 เริ่มที่ Monday
		$month 		= $date_start->format("m");
		$year 		= $date_start->format("Y")+543;
		if($lang == "TH"){
			$return["d_date"]	=	$d_date;
			$return["j_date"]	=	$j_date;
			$return["t_date"] 	= 	$thai_date[$t_date];
			$return["t_month"]	=	$thai_month[($month*1)];
			$return["s_t_month"]=	$sub_thai_month[($month*1)];
			$return["n_month"]	=	$month;
			$return["year"]		=	$year;
		}else if($lang == "EN"){

		}
		return $return;
	}
}
/* format date input 2019-11-01 return วันที่ 1 เดือนมกราคม พ.ศ.2500 */
function get_TH_D_M_Y($date){
	$txt_date = convert_ex_date($date,$lang="TH");
	$full_txt_date = "วันที่ ".$txt_date["j_date"]." เดือน ".$txt_date["t_month"]." พ.ศ. ".$txt_date["year"];
	return $full_txt_date;
}
function get_TH_D_M_Y2($date){
	$txt_date = convert_ex_date($date,$lang="TH");
	$full_txt_date = $txt_date["j_date"]." เดือน ".$txt_date["t_month"]." พ.ศ. ".$txt_date["year"];
	return $full_txt_date;
}
$std_css=" <style>
		table{
	border-collapse: collapse;
	overflow: wrap;
	width:100%;
}

th{
	 font-size:16pt; 
	 padding:3px;
	 color:#000000;
}
td {
  vertical-align: text-top;
  font-size:16pt; 
  padding:3px;
  color:#000000;
}
div.showborder th{
 vertical-align: text-top;
  border: 1px solid black;
  font-size:16pt; 
  padding:3px;
  color:#000000;
}
div.showborder td{
 vertical-align: text-top;
  border: 1px solid black;
  font-size:16pt; 
  padding:3px;
  color:#000000;
}
		.heading{
		font-size:22pt; 
		font-weight:bold;
		text-align:center;
		}
		.class_number { mso-number-format:Standard; } 
		.class_text_no { mso-number-format:'\@';} 
		</style> ";
		
// $mpdf->WriteHTML('<br><div class="heading">บันทึกภายใน</div>');
ob_start(); 

?>
<!--<div align="center"><img width=110 height=120 src="../images/imgcer2.png" data-filename="image001.png" style="width: 110px; height: 120px;" ></div>-->
<?php
$header = ob_get_contents();
ob_end_clean();

ob_start(); 
?>
<!--<h1 align="center">หนังสือรับรองเงินเดือนและระยะเวลาทำงาน</h1>-->
<div style="A_CSS_ATTRIBUTE:all;position: absolute;bottom: 20px; right: 50px; left: 100px; top: 80px;  ">
<table width="100%" border="0">
	<!--<tr>
		<td align="center"  colspan="10" style="font-size:18pt;">
			<img src="<?php echo $WF_URL.'/assets/images/otcc.png' ?>" width="90" height="70">
		</td>
	</tr>-->
	<tr>
		<!--<td align="left"  colspan="2" style="font-size:18pt;">
			<img src="<?php echo $WF_URL.'/assets/images/otcc.png' ?>" width="90" height="70">
			<img src="<?php echo $WF_URL.'/assets/images/favicon_dip.png' ?>" width="50" height="50">
		</td>-->
		<td align="center"  colspan="10" style="font-size:18pt;">
			<strong>ใบขออนุญาตใช้รถยนต์ส่วนกลาง<strong>
		</td>
	</tr>
	<tr>
		<td align="right" colspan="10" style="font-size:15pt;">
			<!--<strong><?php echo get_TH_D_M_Y($_GET['CB_RECORD']);?></strong>-->
			<strong><?php echo get_TH_D_M_Y(date('Y-m-d'));?></strong>
		</td>
	</tr>
	<tr>
		<td align="right" colspan="10"></td>
	</tr>
	<tr>
		<td align="left" colspan="10" style="font-size:14pt;">
			<strong>เรียน</strong> &nbsp;<?php echo "ลสล.กสอ.";//$_GET['APP_2'] (ชื่อ)?> &nbsp;
			<strong>ผ่าน</strong> &nbsp;<?php echo $_GET['APP_1_NAME']; //$_GET['APP_2'] (ชื่อ)?>
		</td>
	</tr>
	<tr>
		<td align="left" colspan="10" style="font-size:14pt;">
			&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<strong>ข้าพเจ้า</strong>&nbsp;<?php echo $_GET['CB_PER_ID'] ; ?>&nbsp;
			<strong>ตำแหน่ง</strong>&nbsp;<?php echo $_GET['POS_NAME']; ?>
			<strong>สังกัด</strong>&nbsp;<?php echo $_GET['DEP_NAME1'] ; ?>
		</td>
	</tr>
	<!--<tr>
		<td align="left" colspan="10" style="font-size:14pt;">
			<strong>สำนัก/ฝ่าย</strong><?php echo ($data_show['CB_DEP_NAME_BOOK']) ? "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;".$data_show['CB_DEP_NAME_BOOK']."&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;" : "................................................................................................................"; ?> 
			<strong>โทร</strong><?php echo ($data_show['CB_PHONE_BOOK']) ? "&nbsp;".$data_show['CB_PHONE_BOOK']."&nbsp;" : "............................................."; ?>
		</td>
	</tr>-->
	<tr>
		<td align="left" colspan="10" style="font-size:14pt;">
			<strong>ขออนุญาตใช้รถยนต์ส่วนกลาง เดินทางไปที่</strong> &nbsp;<?php echo $_GET['CB_AREA']; ?>
		</td>
	</tr>
	<tr>
		<td align="left" colspan="10" style="font-size:14pt;">
			<strong>จำนวนผู้ร่วมเดินทาง</strong> <?php echo $_GET['CB_MEMBER']; ?> <strong>คน</strong>
			<strong>เพื่อ</strong> <?php echo $_GET['CB_OBJ']; ?>
		</td>
	</tr>
	<tr>
		<td align="left" colspan="10" style="font-size:14pt;">
			<strong>ในวันที่</strong> <?php echo get_TH_D_M_Y2($_GET['MEETING_DATE']); ?>
			<strong>เวลา</strong> <?php echo $_GET['STIME']; ?> น.<br>
			<strong>ถึงวันที่</strong> <?php echo get_TH_D_M_Y2($_GET['MEETING_EDATE']); ?>
			<strong>เวลา</strong> <?php echo $_GET['ETIME']; ?> น.
		</td>
	</tr>
	<tr>
		<td align="right" colspan="10" style="font-size:14pt;">
			ผู้ขออนุญาต&nbsp;&nbsp;………..................................
		</td>
	</tr>
	<tr>
		<td align="right" colspan="7" style="width:64%"></td><!-- &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; -->
		<td align="right" colspan="3" style="font-size:14pt;width:36%">
			<?php //echo ($data_show['CB_PER_ID']) ? "(&nbsp;".bsf_show_text('7043',$data_show,"##CB_PER_ID!!",'W')."&nbsp; )" : "(…………..…….....……………………..)"; ?>
			( <?php echo $_GET['CB_PER_ID']; ?> )
		</td>
	</tr>
	<tr>
		<td align="right" colspan="10" style="font-size:14pt;">
			ตำแหน่ง <?php echo $_GET['POS_NAME'] ; ?>
		</td>
	</tr>
	<tr>
		<td align="right" colspan="10" style="font-size:14pt;">
			เบอร์ติดต่อ <?php echo $_GET['REQ_TEL']; ?>
		</td>
	</tr>
	<br>
	<tr>
		<td align="right" colspan="10" style="font-size:14pt;">
			ลสล.กสอ./หรือผู้แทน&nbsp;&nbsp;………..................................
		</td>
	</tr>
	<tr>
		<td align="left" colspan="7" ></td>
		<td align="right" colspan="3" style="font-size:14pt;">
			<?php //echo ($data_show2['CS_APPROVE_PER_ID']) ? "(&nbsp;".bsf_show_text('7047',$data_show2,"##CS_APPROVE_PER_ID!!",'W')."&nbsp;)" : "(…………..…….....……………………..)"; ?>
			( <?php echo "…………..…….....……………………..";//$_GET['CS_PER_NAME']; ?> )
		</td>
	</tr>
	<tr>
		<td align="left" colspan="7"></td>
		<td align="right" colspan="3" style="font-size:14pt;"><?php echo ($data_show2['CS_APPROVE_DATE']) ? "วันที่ ".get_TH_D_M_Y3($data_show2['CS_APPROVE_DATE'])."&nbsp;" : "................................................."; ?></td>
	</tr>
	<tr>
		<td align="right" colspan="10">
			<hr>
		</td>
	</tr>
	<tr>
		<td align="left" colspan="10" style="font-size:14pt;">
			รถหมายเลขทะเบียน <?php echo $_GET['CAR_REGISTER']; ?>
		</td>
	</tr>
	<tr>
		<td align="right" colspan="10">
			&nbsp;
		</td>
	</tr>
	<tr>
		<td align="right" colspan="10" style="font-size:14pt;">
			ผู้มีอำนาจจ่ายรถ ………..................................
		</td>
	</tr>
	<tr>
		<td align="right" colspan="7" style="width:64%"></td>
		<td align="right" colspan="3" style="font-size:14pt;width:36%">
			<?php //echo ($data_show2['CS_APPROVE_PER_ID2']) ? "(&nbsp;".bsf_show_text('7047',$data_show2,"##CS_APPROVE_PER_ID2!!",'W')."&nbsp;)" : "(…………..…….....……………………..)"; ?>
			( <?php echo ($_GET['CS_PER_NAME'] ? $_GET['CS_PER_NAME'] : "……….................................."); ?> )
		</td>
	</tr>
	<tr>
		<td align="left" colspan="7"></td>
		<td align="right" colspan="3" style="font-size:14pt;">
			<?php echo ($data_show2['CS_APPROVE_DATE2']) ? "วันที่ ".get_TH_D_M_Y3($data_show2['CS_APPROVE_DATE2'])."&nbsp;" : "................................................."; ?>
		</td>
	</tr>
	<tr>
		<td align="right" colspan="10">
			&nbsp;
		</td>
	</tr>
	<tr>
		<td align="center" width="50%" colspan="5" style="font-size:14pt;">
			<?php echo ($_GET['W_CAR_MILEAGE'] ? $_GET['W_CAR_MILEAGE']." กม." : "……….................................."); ?><br>
			ระยะ กม./ไมล์<br>
			(เมื่อรถออกเดินทาง)
		</td>
		<td align="center" width="50%" colspan="5" style="font-size:14pt;">
			<?php echo ($_GET['R_CAR_MILEAGE'] ? $_GET['R_CAR_MILEAGE']." กม." : "……….................................."); ?><br>
			ระยะ กม./ไมล์<br>
			(เมื่อรถถึงที่ทำงาน)
		</td>
	</tr>
	<tr>
		<td align="right" colspan="10">
			&nbsp;
		</td>
	</tr>
	<tr>
		<td align="right" colspan="10">
			&nbsp;
		</td>
	</tr>
	<tr>
		<td align="left" colspan="10" style="font-size:14pt;">
			<strong>หมายเหตุ</strong>
		</td>
	</tr>
	<tr>
		<td align="left" colspan="10" style="font-size:14pt;">
			&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
			1. เพื่อความสะดวกในการใช้รถราชการ กรุณาจองล่วงหน้า 1 วัน<br>
			&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
			2. การแจ้งเลื่อน - ยกเลิกการใช้รถก่อนเดินทาง 1 ชม.<br>
			&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
			3. การยกเลิกการเดินทางไปต่างจังหวัด ต้องยกเลิกก่อน 1 วัน<br>
			&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
			4. การเดินทางไปต่างจังหวัดต้องแนบสำเนาอนุมัติเดินทาง มิฉะนั้นทางหมวดยานยนต์จะไม่อนุญาตให้รถออกเดินทาง<br>
		</td>
	</tr>
</table>
</div>
<?php
$body = ob_get_contents();
ob_end_clean();

/* $mpdf->SetHTMLFooter('
<table border="0" >
	<tr>
		<td style="">หนังสือฉบับนี้ให้ใช้ได้ ๓ เดือน นับแต่วันที่ออกหนังสือ (โทร. ๐ ๒๔๓๐ ๖๘๖๕-๖๖ ต่อ ๑๐๒๐)</td>
	</tr>
	<tr>
		<td style=""><br></td>
	</tr>
</table>
'); */

/* if($_GET["AP_STATUS"] != 1){
$mpdf->SetWatermarkText('ตัวอย่างหนังสือรับรอง');
$mpdf->showWatermarkText = true;
} */

$mpdf->WriteHTML($std_css.$header.$body);
$mpdf->Output();
?>