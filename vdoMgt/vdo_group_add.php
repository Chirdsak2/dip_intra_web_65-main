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
<meta http-equiv="Content-Type" content="text/html; charset=windows-874">
<link href="../theme/main_theme/css/style.css" rel="stylesheet" type="text/css">
</head>
<script language="JavaScript">
function ChkInput(c){
   if(c.vdog_name.value==""){
       alert('กรุณากรอกชื่อกลุ่ม');
       return false;
   }
}
</script>
<body leftmargin="0" topmargin="0">
<?php include("../FavoritesMgt/favorites_include.php");?>
<form name="myForm" method="post" action="vdog_process.php">
<table width="80%" border="0" align="center" cellpadding="5" cellspacing="0">
  <tr> 
    <td><img src="../theme/main_theme/logo.gif" width="32" height="32" align="absmiddle"> 
      <span class="ewtfunction">เพิ่มกลุ่ม VDO</span> </td>
  </tr>
</table>
<table width="94%" border="0" align="center" cellpadding="0" cellspacing="0" class="ewtfunctionmenu">
  <tr>
    <td align="right"><a href="javascript:void(0);" onClick="load_divForm('../FavoritesMgt/favorites_add.php?name=<?php echo urlencode("เพิ่มกลุ่ม VDO");?>&module=video&url=<?php echo urlencode("vdo_group_add.php");?>', 'divForm', 300, 80, -1,433, 1);"><img src="../images/star_yellow_add.gif" width="16" height="16" border="0" align="absmiddle">&nbsp;Add to favorites </a>&nbsp;&nbsp;&nbsp;&nbsp;<a href="main_vdo_group.php" ><img src="../theme/main_theme/g_mainpage.gif" width="16" height="16" align="absmiddle" border="0">กลับหน้าหลัก</a>
      <hr> </td>
  </tr>
</table>
<table width="70%" border="0" align="center" class="table table-bordered">
  <tr bgcolor="#E7E7E7" > 
    <td height="30" colspan="2" class="ewttablehead"> เพิ่มกลุ่ม VDO</td>
  </tr>
  <tr valign="top" bgcolor="#FFFFFF"> 
    <td width="38%">ชื่อกลุ่ม <font color="#FF0000">*</font></td>
    <td width="62%"><input name="vdog_name" type="text" size="40"></td>
  </tr>
  <tr valign="top" bgcolor="#FFFFFF"> 
    <td width="38%">ชื่อผู้สร้าง</td>
    <td width="62%"><input name="vdog_creator" type="text" size="40"  ></td>
  </tr>
  <tr valign="top" bgcolor="#FFFFFF"> 
    <td width="38%">URLของแหล่งที่มา </td>
    <td width="62%"><input name="vdog_info" type="text" size="40"  ></td>
  </tr>
  <tr valign="top" bgcolor="#FFFFFF"> 
    <td width="38%">&nbsp;</td>
    <td width="62%"><input name="vdog_downloadable" type="checkbox" value="1">&nbsp;สามารถ Download ได้</td>
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