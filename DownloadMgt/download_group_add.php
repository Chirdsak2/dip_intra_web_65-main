<?php
include("../lib/permission1.php");
include("../lib/include.php");
include("../lib/function.php");
include("../lib/user_config.php");
include("../lib/connect.php");
?>
<html>
<head>
<title><?php echo $EWT_title ?></title>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<link href="../theme/main_theme/css/style.css" rel="stylesheet" type="text/css">
</head>
<script language="JavaScript">
function ChkInput(c){
   if(c.dlg_name.value==""){
       alert('กรุณากรอกชื่อกลุ่ม');
       return false;
   }
}
</script>
<body leftmargin="0" topmargin="0">
<form name="myForm" method="post" action="downloadg_process.php">
<table width="80%" border="0" align="center" cellpadding="5" cellspacing="0">
  <tr> 
    <td><img src="../theme/main_theme/logo.gif" width="32" height="32" align="absmiddle"> 
      <span class="ewtfunction">เพิ่มกลุ่ม Download</span> </td>
  </tr>
</table>
<table width="94%" border="0" align="center" cellpadding="0" cellspacing="0" class="ewtfunctionmenu">
  <tr>
    <td align="right"><a href="main_download_group.php" ><img src="../theme/main_theme/g_mainpage.gif" width="16" height="16" align="absmiddle" border="0">กลับหน้าหลัก</a>
      <hr> </td>
  </tr>
</table>
<table width="70%" border="0" align="center" cellpadding="5" cellspacing="1" bgcolor="#CECECE"  class="ewttableuse">
  <tr bgcolor="#E7E7E7" > 
    <td height="30" colspan="2" class="ewttablehead">เพิ่มกลุ่ม Download</td>
  </tr>
  <tr valign="top" bgcolor="#FFFFFF"> 
    <td width="38%">ชื่อกลุ่ม <font color="#FF0000">*</font></td>
    <td width="62%"><input name="dlg_name" type="text" size="40"></td>
  </tr>
  <tr valign="top" bgcolor="#FFFFFF"> 
    <td width="38%">รายละเอียด</td>
    <td width="62%"><textarea name="dlg_detail" cols="50" rows="4"></textarea></td>
  </tr>
  <tr valign="top" bgcolor="#FFFFFF"> 
    <td width="38%">ประเภท</td>
    <td width="62%">
	<input name="dlg_type" type="radio" value="M" checked> ดาวน์โหลดได้เฉพาะสมาชิก<br>
	<input name="dlg_type" type="radio" value="A" >บุคคลทั่วไปและสมาชิกสามารถดาวน์โหลดได้
	</td>
  </tr>
  
  <tr bgcolor="#FFFFFF">
    <td>&nbsp;</td>
    <td><input type="submit" name="Submit2" value="บันทึก" onClick="return ChkInput(document.myForm)">
	<input name="flag" type="hidden"  value="add"> 
      <input type="reset" name="Submit3" value="ยกเลิก"></td>
  </tr>
</table>
</form>
</body>
</html>
<?php
$db->db_close(); ?>