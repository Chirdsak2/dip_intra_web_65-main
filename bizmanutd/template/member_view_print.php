<?php
	session_start();
	include("lib/function.php");
	include("lib/user_config.php");
	include("lib/connect.php");
	include("../../ewt_block_function.php");
	include("../../ewt_menu_preview.php");
	include("../../ewt_article_preview.php");
	//include("language/language.php");
	$monthname = array('','ม.ค.','ก.พ.','มี.ค.','เม.ย.','พ.ค.','มิ.ย.','ก.ค.','ส.ค.','ก.ย.','ต.ค.','พ.ย.','ธ.ค.');
	if($_GET["filename"] != "") {
		$sql_index = $db->query("SELECT template_id,filename FROM temp_index WHERE filename = '".$_GET["filename"]."' ");
		$F = $db->db_fetch_array($sql_index);
		$_GET["d_id"] = $F["template_id"];
	} else {
		$_GET["filename"] = "index";
		$sql_index = $db->query("SELECT d_id FROM design_list WHERE d_default = 'Y'  ");
		$FF = $db->db_fetch_array($sql_index);
		$_GET["d_id"] = $FF[d_id];
	}

			$lang_sh1 = explode('___',$F[filename]);
			if($lang_sh1[1] != ''){
				$lang_shw = $lang_sh1[1];
				$lang_sh = '_'.$lang_sh1[1];
				
			}else{
				$lang_sh ='';
				$lang_shw='';
			}
			@include("language/language".$lang_sh.".php");
	$temp = "SELECT * FROM design_list WHERE d_id = '".$_GET["d_id"]."'";
	$sql_temp= $db->query($temp);
	$RR = $db->db_fetch_array($sql_temp);

	$global_theme = $RR["d_bottom_content"];
	$mainwidth = "0";
$db->query("USE ".$EWT_DB_USER);
?>
<html>
<head>
<title>สมัครสมาชิก</title>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<?php include("ewt_script.php");	 ?>
<script language="javascript" src="js/functions.js"></script>
<script language="JavaScript1.2">
<!--
top.window.moveTo(0,0);
if (document.all) {
top.window.resizeTo(screen.availWidth,screen.availHeight);
}
else if (document.layers||document.getElementById) {
if (top.window.outerHeight<screen.availHeight||top.window.outerWidth<screen.availWidth){
top.window.outerHeight = screen.availHeight;
top.window.outerWidth = screen.availWidth;
}
}
//-->
</script>
<style type="text/css">
<!--
.style10 {color: #FF0000}
-->
</style>
<link href="css/mysite.css" rel="stylesheet" type="text/css">
</head>
<body  leftmargin="0" topmargin="0"  >
<div id="nav" style="position:absolute;width:262px; height:280px; z-index:1;display:none" ></div>
<!--<table width="90%" border="0" align="center" cellpadding="2" cellspacing="0" bgcolor="B4BDC7">
							<tr><td valign="top"><font color="#666666" size="4" face="Tahoma"><strong>&nbsp;&nbsp;&nbsp;&nbsp;สิทธิที่สมาชิกจะได้รับ</strong></font><br>
							  <br>
						
							<table width="85%" border="0" align="center" cellpadding="0" cellspacing="1">
										<tr>
										  <td ><font color="#666666" size="2" face="Tahoma">-</font></td>
										</tr>
										<tr>
										  <td ><font color="#666666" size="2" face="Tahoma">-</font></td>
							  </tr>
							  </table>
						</td>
							</tr>
							<tr> 
								<td valign="middle" ><font color="#666666" size="4" face="Tahoma"><strong>&nbsp;&nbsp;&nbsp;&nbsp;ท่านจำเป็นต้องส่งสำเนาบัตรประชาชนเพื่อยืนยันการสมัครสมาชิก!</strong></font><br><br>
									<table width="85%" border="0" align="center" cellpadding="10" cellspacing="1">
										<tr><td ><font color="#666666" size="2" face="Tahoma">เพื่อความปลอดภัยในกรณีที่มีบุคคลแอบอ้างชื่อของท่านในการสมัครเข้ามาเป็นสมาชิกเว็บไซต์ของ<?php echo $txt_website_of_name2;?>  ทางผู้ดูแลระบบขอให้ท่านส่งสำเนาบัตรประชาชนมายัง<?php echo $txt_website_of_name2;?> ที่หมายเลข<?php echo $txt_website_of_name3;?>  หรือส่งทาง e-mail : webmast@dmr.go.th<br><br>
										            </font><font size="2" face="Tahoma" color="#FF0000"><strong>หมายเหตุ:&nbsp;</strong></font><font color="#666666" size="2" face="Tahoma">กรุณาระบุด้วยว่า </font><font size="2" face="Tahoma"><strong>"สมัครสมาชิกเว็บไซต์"</strong></font><font color="#666666" size="2" face="Tahoma"> ผู้ดูแลระบบจะให้สิทธิ์การเป็นสมาชิกให้แก่ท่านภายใน 2 วันทำการ </font>
												<br>
												</td></tr>
									</table>
									<br />
								</td>
							</tr>
						</table>--><br><br><br>
		<table width="90%" border="0" align="center" cellpadding="10" cellspacing="1" bgcolor="#A9A9E0">
		<tr>
		<td bgcolor="#DBDBF2"><font color="#666666" size="4" face="Tahoma"><strong>สมัครสมาชิก</strong></font></td>
		</tr>
		</table>
	<table width="80%" border="0" align="center" cellpadding="3" cellspacing="1">
	  <td width="31%" height="30">&nbsp;รหัสบัตรประชาชน :</td>
	    <td align="left"><?php echo $cardW0;?>-<?php echo $cardW1;?>-<?php echo $cardW2;?>-<?php echo $cardW3;?>-<?php echo $cardW4;?></tr>
	<tr id="t1">
	<td height="30">&nbsp;คำนำหน้า : <span class="style10">*</span></td>
	<td align="left"> <div id="div_title_thai">
	<?php 
	
	$sql_title = "SELECT title_thai,title_id FROM title group by title_thai";
	$query_title = $db->query($sql_title);
	while($rs_title = $db->db_fetch_array($query_title)){
	if($rs_title[title_id] == $title_thai) echo $selected_title = $rs_title[title_thai];
	else $selected_title = "";
	}
	?>
	</div></td>
	</tr>
	<tr>
	<td height="30">&nbsp;ชื่อ : <span class="style10">*</span></td>
	<td align="left"><?php echo $name_thai;?></td>
	</tr>
	<tr>
	<td height="30">&nbsp;นามสกุล : <span class="style10">*</span></td>
	<td align="left"><?php echo $surname_thai;?></td>
	</tr>
	<tr id="t2" style="display:none">
	<td height="30">&nbsp;Title:</td>
	<td align="left">
	<?php 
	$sql_title = "SELECT title_eng,title_id FROM title group by title_eng";
	$query_title = $db->query($sql_title);
	while($rs_title = $db->db_fetch_array($query_title)){
	if($rs_title[title_id] == $title_eng) echo $selected_title = $rs_title[title_eng];
	else $selected_title = "";
	}
	?></td>
	</tr>
	<tr>
	<td height="30">&nbsp;ชื่อภาษาอังกฤษ :</td>
	<td align="left"><?php echo $name_eng;?></td>
	</tr>
	<tr>
	<td height="30">&nbsp;นามสกุลภาษาอังกฤษ :</td>
	<td align="left"><?php echo $surname_eng;?></td>
	</tr>
	<tr>
	<td height="30">&nbsp;Email :</td>
	<td align="left"><?php echo $email_person;?></td>
	</tr>
	<tr>
	<td height="30">&nbsp;เบอร์มือถือ :</td>
	<td align="left"><?php echo $mobile;?></td>
	</tr>
	<tr>
	<td height="30">&nbsp;สถานที่ทำงาน :</td>
	<td align="left"><?php echo $officeaddress;?></td>
	</tr>
	<tr id="t3">
	<td height="30">&nbsp;สถานะ :</td>
	<td align="left">
	<?php 
	$sql_title = "SELECT * FROM emp_type where emp_type_status ='4'";
	$query_title = $db->query($sql_title);
	while($rs_title = $db->db_fetch_array($query_title)){
	if($rs_title[emp_type_id] == $emp_type_id){ print $rs_title[emp_type_name];}
	
	}
	?></td>
	</tr>
	<tr>
	<td height="30">&nbsp;Username :<span class="style10">**</span></td>
	<td align="left"><?php echo $gen_user;?></td>
	</tr>
	<tr>
	<td height="30">&nbsp;Password : <span class="style10">**</span></td>
	<td align="left"><?php echo $gen_pass;?></td>
	</tr>
	<tr>
	<td height="30">&nbsp;Re Password : <span class="style10">**</span></td>
	<td align="left"><?php echo $gen_pass;?></td>
	</tr>
	<!--<tr bgcolor="#DBDBF2">
	<td height="25" colspan="2" align="center" id="show_status" ><input name="save" type="submit" class="submit" id="save" value="บันทึก" onClick="return chkinput(); " />
	<input name="Submit2" type="button" class="submit" value="ยกเลิก" style="width:80"  onclick="window.location.href='main.php?filename=index';"/>
	</td>
	</tr>-->
<tr>
	<td height="30" colspan="2">
	<div id="previewDiv" style="position:absolute; display:none" align="center">
	  <table width="90%"  border="0" align="center" cellpadding="10" cellspacing="1" bgcolor="#CCCCCC" >
        <tr>
          <td align="center" bgcolor="#FFFFFF"><img src="mainpic/loading.gif" /></td>
        </tr>
      </table></div></td>
	</tr>
	</table>
	<table width="90%" border="0" align="center" cellpadding="10" cellspacing="1" bgcolor="#A9A9E0">
		<tr>
		<td  align="center"  bgcolor="#DBDBF2" id="show_status" ><font color="#666666" size="4" face="Tahoma"><strong>
		<input name="save" type="submit" class="submit" id="save" value="ยืนยันการสมัครสมาชิก" onClick="window.opener.document.frm.setflag.value = '1';window.opener.frm.target = '_self';window.opener.frm.action = 'frm_gen_user.php';window.opener.frm.submit();self.close();"/>
	<input name="Submit2" type="button" class="submit" value="กลับไปแก้ไขข้อมูล"  onClick="self.close();">
	<input name="setflag" type="hidden" id="setflag" value="0"></strong></font></td>
		</tr>
		</table>
</body>
</html>
<?php 
$db->query("USE ".$EWT_DB_NAME);
$db->db_close(); ?>
