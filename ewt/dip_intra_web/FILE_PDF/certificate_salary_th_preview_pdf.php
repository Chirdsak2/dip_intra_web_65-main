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
<div align="center"><img width=110 height=120 src="../images/imgcer2.png" data-filename="image001.png" style="width: 110px; height: 120px;" ></div>
<?php
$header = ob_get_contents();
ob_end_clean();

ob_start(); 
?>
<!--<h1 align="center">หนังสือรับรองเงินเดือนและระยะเวลาทำงาน</h1>-->
<div style="A_CSS_ATTRIBUTE:all;position: absolute;bottom: 20px; right: 50px; left: 100px; top: 180px;  ">
<table border="0" >
	<tr>
		<td style="" width="70%">ที่&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;/ ๒๕๖๖</td>
		<td width="35%">กรมส่งเสริมอุตสาหกรรม <br>ถนนพระรามที่ ๖ แขวงทุ่งพญาไทย <br>เขตราชเทวี กรุงเทพฯ ๑๐๔๐๐</td>
	</tr>
</table>

<table border="0" >
	<tr>
		<td><br><br><br></td>
	</tr>
	<tr>
		<td style="">
		<p style="">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;หนังสือฉบับนี้ให้ไว้เพื่อรับรองว่า <?php echo $_GET['FULL_NAME'];?> ปัจจุบันเป็น<?php echo $_GET['PER_TYPE_NAME'];?> ปัจจุบันดำรงตำแหน่ง<?php echo $_GET["POS_NAME"].$_GET["POS_LEVEL_NAME"];?> <?php echo $_GET["DEP_NAME"]." ".$_GET["DEP_NAME2"];?> รับเงินเดือนเดือนละ <?php echo thainumDigit(number_format($_GET["INCOME_MONEY"]));?> บาท </p>
		</td>
	</tr>
	<!--<tr>
		<td style="">เริ่มรับราชการตั้งแต่วันที่ ๑ มกราคม พ.ศ. ๒๕๖๒ จนถึงปัจจุบัน</td>
	</tr>-->
	
</table>
<br>
<table border="0" >
	<tr>
		<td width="50%">&nbsp;</td>
		<td width="50%">ให้ไว้ ณ <?php echo $_GET['DATE_NOW_TH'];?></td>
	</tr>
</table>

<!--<table border="0" >
	<tr>
		<td><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br></td>
	</tr>
	<tr>
		<td style="">หนังสือฉบับนี้ให้ใช้ได้ ๓ เดือน นับแต่วันที่ออกหนังสือ (โทร. ๐ ๒๔๓๐ ๖๘๖๕-๖๖ ต่อ ๑๐๒๐)</td>
	</tr>
</table>-->
</div>
<?php
$body = ob_get_contents();
ob_end_clean();

$mpdf->SetHTMLFooter('
<table border="0" >
	<tr>
		<td style="">หนังสือฉบับนี้ให้ใช้ได้ ๓ เดือน นับแต่วันที่ออกหนังสือ (โทร. ๐ ๒๔๓๐ ๖๘๖๕-๖๖ ต่อ ๑๐๒๐)</td>
	</tr>
	<tr>
		<td style=""><br></td>
	</tr>
</table>
');

// if($_GET["AP_STATUS"] != 1){
$mpdf->SetWatermarkText('ตัวอย่างหนังสือรับรอง');
$mpdf->showWatermarkText = true;
// }

$mpdf->WriteHTML($std_css.$header.$body);
$mpdf->Output();
?>