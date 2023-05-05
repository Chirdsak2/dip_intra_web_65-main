<?php
// ini_set('display_errors', 1);
// error_reporting(E_ALL);
include('../callservice.php');
$data_request1_2 = array(
							"wfr_id" =>  $_GET['WFR_ID']
						);
$getMeetingToolAdd = callAPI('getMeetingToolAdd', $data_request1_2);

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
			<strong>แบบฟอร์มจองห้องประชุม<strong>
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
			<strong>เรียน</strong> &nbsp;<?php echo $_GET['APP_2_NAME'];//$_GET['APP_2'] (ชื่อ)?> &nbsp;
			<strong>ผ่าน</strong> &nbsp;<?php echo $_GET['APP_1_NAME']; //$_GET['APP_2'] (ชื่อ)?>
		</td>
	</tr>
	<tr>
		<td align="left" colspan="10" style="font-size:14pt;">
			&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
			<strong>ชื่อหน่วยงาน</strong>&nbsp;&nbsp;<?php echo $_GET['DEP_NAME1'] ; ?>
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
			<strong>มีความประสงค์ขอใช้ห้องประชุม</strong> &nbsp;<?php echo $_GET['CB_AREA']; ?>
		</td>
	</tr>
	<tr>
		<td align="left" colspan="10" style="font-size:14pt;">
			<strong>หัวข้อประชุม</strong> <?php echo $_GET['CB_OBJ']; ?>
		</td>
	</tr>
	<tr>
		<td align="left" colspan="10" style="font-size:14pt;">
			<strong>ระหว่างวันที่</strong> <?php echo get_TH_D_M_Y2($_GET['MEETING_DATE']); ?>
			<strong>ถึงวันที่</strong> <?php echo get_TH_D_M_Y2($_GET['MEETING_EDATE']); ?>
			<strong>เวลา</strong> <?php echo $_GET['STIME']." <strong>ถึง เวลา </strong>".$_GET['ETIME']; ?> น.
		</td>
	</tr>
	<tr>
		<td align="left" colspan="10" style="font-size:14pt;">
			<strong>มีผู้เข้าร่วมประชุม จำนวน</strong> &nbsp;<?php echo $_GET['CB_MEMBER']; ?>&nbsp; <strong>คน</strong>
			<strong> &nbsp; ประธานที่ประชุม</strong> &nbsp;<?php echo $_GET['MEETINH_CHAIRMAN']; ?>
		</td>
	</tr>
	<tr>
		<td align="left" colspan="10" style="font-size:14pt;">
			<strong>ผู้ประสานงาน</strong> &nbsp;<?php echo $_GET['CB_PER_ID'] ; ?> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
			<strong> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp; &nbsp;&nbsp;&nbsp;&nbsp;&nbsp; หมายเลขโทรศัพท์</strong> &nbsp;<?php echo $_GET['REQ_TEL']; ?>
		</td>
	</tr>
	<tr>
		<td align="left" colspan="10" style="font-size:14pt;">
			<strong>โดยขอใช้อุปกรณ์โสตฯ ดังนี้</strong> &nbsp;<?php //echo $_GET['CB_PER_ID'] ; ?> 
		</td>
	</tr>
	<tr>
		<td align="left" colspan="10" style="font-size:14pt;">
			<?php foreach($getMeetingToolAdd['Data'] as $key => $value2){ ?>
			&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
			&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
			<?php echo $value2['TOOL_NAME']." จำนวน ".$value2['TOOL_AMOUNT'];?><br>
			<?php }?>
		</td>
	</tr>
	<tr>
		<td align="center" colspan="10" style="font-size:14pt;">
			&nbsp;
		</td>
	<tr>
	<tr>
		<td align="center" colspan="10" style="font-size:14pt;">
			จึงเรียนมาเพื่อทราบ
		</td>
	</tr>
	<tr>
		<td align="center" colspan="10" style="font-size:14pt;">
			&nbsp;
		</td>
	<tr>
	<tr>
		<td align="center" colspan="10" style="font-size:14pt;">
			&nbsp;
		</td>
	<tr>
		<td align="center" colspan="10" style="font-size:14pt;">
			.......................................................................
		</td>
	</tr>
	<tr>
		<td align="center" colspan="10" style="font-size:14pt;">
			(<?php echo $_GET['CB_PER_ID'] ; ?>)
		</td>
	</tr>
	<tr>
		<td align="center" colspan="10" style="font-size:14pt;">
			<?php echo get_TH_D_M_Y(date('Y-m-d')); ?>
		</td>
	</tr>
	<tr>
		<td align="center" colspan="10" style="font-size:14pt;">
			&nbsp;
		</td>
	<tr>
	<tr>
		<td align="right" colspan="2" style="font-size:14pt;">
			อนุมัติ
		</td>
	</tr>
	<tr>
		<td align="center" colspan="10" style="font-size:14pt;">
			&nbsp;
		</td>
	<tr>
	<tr>
		<td align="center" colspan="10" style="font-size:14pt;">
			&nbsp;
		</td>
	<tr>
	<tr>
		<td align="center" colspan="3" style="font-size:14pt;">
			<?php echo $_GET['APP_2']; ?>
		</td>
	</tr>
	<tr>
		<td align="left" colspan="10" style="font-size:14pt;">
			&nbsp;&nbsp;เลขานุการกรม กรมส่งเสริมอุตสาหกรรม
		</td>
	</tr>
	<tr>
		<td align="center" colspan="10" style="font-size:14pt;">
			&nbsp;
		</td>
	<tr>
	<tr>
		<td align="right" colspan="10">
			<hr>
		</td>
	</tr>
	<tr>
		<td align="center" colspan="10" style="font-size:14pt;">
			&nbsp;
		</td>
	<tr>
	<tr>
		<td align="left" colspan="10" style="font-size:14pt;">
			หมายเหตุ :
		</td>
	<tr>
	
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