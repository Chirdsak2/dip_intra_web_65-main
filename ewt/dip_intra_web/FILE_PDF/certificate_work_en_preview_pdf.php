<?php
require_once '../mpdf_autoload/vendor/autoload.php';

$mpdf = new \Mpdf\Mpdf();

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
		<td style="" width="60%">No.&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;/ ๒๕๖๕</td>
		<td width="40%">Department of Industrial Promotion <br>Rama 6 Road, Thung Phaya Thai<br>Rajathewi Bangkok 10400<br>Tel: 0 2430 6865-66 : 1020</td>
	</tr>
</table>
<br>
<table border="0" >
	
	<tr>
		<td align="center"><b><u>Letter of Certification</u></b></td>
	</tr>
	<br>
	<tr>
		<td style="">To Whom It May Concern:</td>
	</tr>
	<tr> 
		<td style=""><p style="">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;This is to certify that <?php echo $_GET['FULL_NAME_EN'];?>, presently the Indus trial Technical Officer, Practitioner Level, has been working at the Information and Communication Technology Center, Department of Industrial Promotion, Ministry of Industry since May 30,2018 to the present.</p></td>
	</tr>
	<!--<tr>
		<td style="">เริ่มรับราชการตั้งแต่วันที่ ๑ มกราคม พ.ศ. ๒๕๖๒ จนถึงปัจจุบัน</td>
	</tr>-->
	
</table>
<br>
<table border="0" >
	<tr>
		<td width="50%">&nbsp;</td>
		<!--<td width="50%" align="center">Give on 19 January B.E. 2566 (2023)</td>-->
		<td width="50%" align="center">Give on <?php echo $_GET['DATE_NOW_EN'];?></td>
	</tr>
</table>
<br><br>
<table border="0" >
	<tr>
		<td width="50%">&nbsp;</td>
		<td width="50%" align="center">(Miss Pratuang Pruksaphithaskul)<br>Secretary Office of the secretary<br>For Director General</td>
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

// if($_GET["AP_STATUS"] != 1){
$mpdf->SetWatermarkText('ตัวอย่างหนังสือรับรอง');
$mpdf->showWatermarkText = true;
// }

$mpdf->WriteHTML($std_css.$header.$body);
$mpdf->Output();
?>