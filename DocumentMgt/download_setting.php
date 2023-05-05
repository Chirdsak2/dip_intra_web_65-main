<?php
include("../lib/permission1.php");
include("../lib/include.php");
include("../lib/function.php");
include("../lib/user_config.php");
include("../lib/connect.php");
$sql_chk = $db->db_fetch_array($db->query("select site_info_max_file from site_info"));
?>
<html>
<head>
<title><?php echo $EWT_title ?></title>

<SCRIPT language=JavaScript src="../js/date-picker.js" type=text/javascript></SCRIPT>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<link href="../theme/main_theme/css/style.css" rel="stylesheet" type="text/css">
<style type="text/css">
<!--
.style1 {color: #FF0000}
-->
</style>
</head>
<script language="JavaScript">
function ChkInput(c){
   if(c.vdo_name.value==""){
       alert('กรุณากรอกชื่อ VIDEO');
	   c.vdo_name.focus();
       return false;
   }else if(c.vdo_group.value=="0"){
   		alert('กรุณาเลือกกลุ่ม');
	   c.vdo_group.focus();
       return false;
   }else if((c.vdo_filesource.value=="com" && (c.vdo_file1.value=="" && c.vdo_filename.value=="" )  ) || (c.vdo_filesource.value=="web" && c.vdo_file2.value=="")){
   		alert('กรุณาเลือกไฟล์'); 
       return false;
   }
}
</script>
<body leftmargin="0" topmargin="0">
<?php include("../FavoritesMgt/favorites_include.php");?>
<form name="myForm" method="post" action="download_process.php" enctype="multipart/form-data">
<table width="80%" border="0" align="center" cellpadding="5" cellspacing="0">
  <tr> 
      <td><img src="../theme/main_theme/logo.gif" width="32" height="32" align="absmiddle"> 
        <span class="ewtfunction">ตั้งค่าการอัพโหลด</span> </td>
  </tr>
</table>
<table width="94%" border="0" align="center" cellpadding="0" cellspacing="0" class="ewtfunctionmenu">
  <tr>
    <td align="right"><a href="javascript:void(0);" onClick="load_divForm('../FavoritesMgt/favorites_add.php?name=<?php echo urlencode ("ตั้งค่าการอัพโหลด"); ?>&module=document&url=<?php echo urlencode  ("download_setting.php");?>', 'divForm', 300, 80, -1,433, 1);"><img src="../images/star_yellow_add.gif" width="16" height="16" border="0" align="middle">&nbsp;Add to favorites </a>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<a href="main_download_group.php" ><img src="../theme/main_theme/g_mainpage.gif" width="16" height="16" align="absmiddle" border="0">กลับหน้าหลัก</a>
	<a href="download_list.php?gid=<?php echo $_GET[gid]?>" ><img src="../theme/main_theme/g_mainpage.gif" width="16" height="16" align="absmiddle" border="0">ย้อนกลับ</a>
      <hr> </td>
  </tr>
</table>
<?php 
		$sql = "SELECT * FROM docload_setting ";
		$query=$db->query($sql);
		$data=$db->db_fetch_array($query);
?> 
<table width="70%" border="0" align="center" cellpadding="5" cellspacing="1" bgcolor="#CECECE"  class="ewttableuse">
  <tr bgcolor="#E7E7E7" > 
    <td height="30" colspan="2" class="ewttablehead"> การตั้งค่า</td>
  </tr>
<tr valign="top" bgcolor="#FFFFFF"> 
    <td width="38%">กำหนดขนาดไฟล์ที่อนุญาติให้อัพโหลด<font color="#FF0000">*</font></td>
    <td width="62%"><input name="dls_filesize" type="text" size="10" value="<?php echo $data[dls_filesize]/1024;?>"> Kb (ไม่สามารถกำหนดได้เกินกว่าคุณสมบัติเว็บไซต์กำหนด)</td>
  </tr>
  <tr valign="top" bgcolor="#FFFFFF"> 
    <td width="38%">นามสกุลไฟล์ที่อนุญาติ</td>
    <td width="62%"><textarea name="dls_ext" cols="50" rows="4"><?php echo $data[dls_ext];?></textarea></td>
  </tr>

  <tr bgcolor="#FFFFFF">
    <td>&nbsp;</td>
    <td><input type="submit" name="Submit2" value="บันทึก" >
	<input name="flag" type="hidden"  value="setting"> 
	<input name="gid" type="hidden"  value="<?php echo $data[dl_gid];?>"> 
	<input name="dl_id" type="hidden"  value="<?php echo $_GET[fid];?>"> 
     <input type="reset" name="Submit3" value="ยกเลิก" onClick="location.href='download_list.php?gid=<?php echo $data[dl_gid];?>' "></td>
  </tr>
</table>
</form>
</body>
</html>
<?php
$db->db_close(); ?>