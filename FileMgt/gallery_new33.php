<?php
include("../lib/permission1.php");
include("../lib/include.php");
include("../lib/function.php");
include("../lib/user_config.php");
include("../lib/connect.php");
$Globals_Dir1 = "ewt/".$_SESSION["EWT_SUSER"]."/images/article/";

$sql = "select * from site_info";
$query = $db->query($sql);
$rec = $db->db_fetch_array($query);
	?>
<html>
<head>
<title><?php echo $EWT_title ?></title>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<script language="javascript" type="text/javascript" src="../js/function.js"></script>
<script language="JavaScript">
function changePic(c){
if(c.value != ""){
self.parent.gallery_left.gallery_preview.document.all.imgpreview.src = c.value;
}
}
	function CHK(t){
	if(t.filesize_more.checked == true){
		var ftp = document.getElementById('ftp');
		ftp.Logon();
		if (ftp.Connected)
		{
		alert(document.getElementById('file').value.length);
		
			ftp.RemoteFile = "<?php echo $Globals_Dir1; ?>news1001/xxx.gif";
			ftp.LocalFile = document.getElementById('file').value;
			ftp.Upload();
		}
	alert(23232);
	alert("บันทึกเรียบร้อย");
	return false;
	}
	return false;
	}
</script>
<link href="../css/style_content.css" rel="stylesheet" type="text/css">
</head>
<body leftmargin="0" topmargin="0">
<object name="ftp" id="ftp" classid="CLSID:63337170-F789-11CE-86F8-0020AFD8C6DB">
	<param name="RemoteHost" value="58.137.128.181">
	<param name="User" value="<?php echo $rec[site_info_user]; ?>">
	<param name="Password" value="<?php echo $rec[site_info_pass]; ?>">
	<table width="100%" border="0" cellpadding="3" cellspacing="0" bgcolor="#FF0000">
  <tr>
    <td align="center"><font color="#FFFFFF">เครื่องของคุณยังไม่ลงโปรแกรม FTP 
      ภาพ<br>
      กรุณา<a href="saraban_setup.exe" target="_blank"><font color="#FFFF00"> คลิ๊กที่นี่ </font></a>เพื่อ 
      Download โปรแกรม</font></td>
  </tr>
</table>
</object>
<table width="100%" height="100%" border="0" cellpadding="0" cellspacing="0"><form name="form1" enctype="multipart/form-data" method="post">
    <tr>
    <td height="1" bgcolor="D8D2BD"></td>
  </tr>
  <tr>
    <td height="1" bgcolor="#FFFFFF"></td>
  </tr>
  <tr>
    <td valign="top"><table width="100%" height="100%" border="0" cellpadding="3" cellspacing="0" id="myTable">
  <tr>
          <td width="35%" height="30" bgcolor="F7F7F7"  >Upload File:</td>
    <td width="23%">
<input name="file" type="file" >            </td>
    <td><img src="../images/error1.gif" width="16" height="16"></td>
  </tr>
  <tr>
    <td width="35%" bgcolor="F7F7F7"></td>
          <td width="23%" valign="top">
		  <input name="Replace" type="checkbox" id="Replace" value="Y">
              Replace all if exists.<br>
			   <input type="checkbox" name="filesize_more" value="checkbox"></font></a><font color="#FF0000">File 
        Size must  exceed <?php echo $rec[site_info_max_img];?> KB
				<br>
              <input type="button" name="Button" value="Upload..." onClick="CHK(this.form);">             </td>      
          <td valign="top"></td>
  </tr>
</table></td>
  </tr></form>
</table>
</body>

<?php
$db->db_close(); 
 ?>
