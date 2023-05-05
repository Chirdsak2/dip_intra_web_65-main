<?php
	session_start();
	include("lib/function.php");
	include("lib/user_config.php");
	include("lib/connect.php");
	@include("language/language.php");
	$db->query("USE ".$EWT_DB_USER);
?>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<title>สมัครสมาชิก</title>
<script language="javascript" src="js/functions.js"></script>
<script src="js/AjaxRequest.js"></script>
<script src="js/excute.js"></script>
<script language="javascript">
</script>
<link href="css/mysite.css" rel="stylesheet" type="text/css">
<style type="text/css">
<!--
.style11 {
	color: #FF0000;
	font-weight: bold;
}
-->
</style>
</head>

<body>
<div align="center">
<table width="100%" height="100%" border="0" cellpadding="0" cellspacing="0">
	<tr> 
		<td  align="center" valign="middle">
			<table width="100%" height="100%" border="0" cellpadding="0" cellspacing="0">
				<tr> 
					<!--<td width="5" height="100%" background="mainpic/bg_l.gif"></td> -->
					<td align="center" valign="middle" bgcolor="FFFFFF"><br><br>
						<table width="770" height="80%" border="0" align="center" cellpadding="2" cellspacing="0" bgcolor="B4BDC7">
							<tr> 
								<td valign="middle" bgcolor="#FFFFFF"><font color="#666666" size="4" face="Tahoma"><strong>&nbsp;&nbsp;&nbsp;&nbsp;ท่านจำเป็นต้องส่งเอกสารเพื่อยืนยันการสมัครสมาชิก!</strong></font><br><br>
									<table width="90%" border="0" align="center" cellpadding="10" cellspacing="1" bgcolor="#A9A9E0">
										<tr><td bgcolor="#DBDBF2"><font color="#666666" size="2" face="Tahoma">เพื่อความปลอดภัยในกรณีที่มีบุคคลแอบอ้างชื่อของท่านในการสมัครเข้ามาเป็นสมาชิกเว็บไซต์ของ<?php echo $txt_website_of_name2;?><br>ทางผู้ดูแลระบบใคร่ขอรบกวนท่านในการส่งเอกสารบัตรประชาชนเพื่อยืนยันตัวท่านเองมายัง<?php echo $txt_website_of_name2;?> ที่หมายเลข<?php echo $txt_website_of_name3;?><br><br>
										            </font><font size="2" face="Tahoma" color="#FF0000"><strong>หมายเหตุ:&nbsp;</strong></font><font color="#666666" size="2" face="Tahoma">กรุณาระบุด้วยว่า </font><font size="2" face="Tahoma"><strong>"สมัครสมาชิกเว็บไซต์"</strong></font><font color="#666666" size="2" face="Tahoma"> ผู้ดูแลระบบจะทำการเปิดบัญชีการใช้งานให้แก่ท่านภายใน 2 วันทำการ ขออภัยในความไม่สะดวก และขอขอบพระคุณในความร่วมมือของท่าน</font>
<br>
<br>
<font color="#666666" size="4" face="Tahoma"><strong><?php echo $txt_website_of_name4;?>
</strong></font><br>
<br>
<br><a href="main.php?filename=index">&lt;&lt;&nbsp;กลับหน้าหลัก</a></td></tr>
									</table>
									<br />
								</td>
							</tr>
						</table>
					</td>
					<!--<td width="5" height="100%" background="mainpic/bg_r.gif"></td> -->
				</tr>
			</table>
		</td>
	</tr>
</table>
</div>
</body>
</html>
<?php $db->db_close(); ?>
