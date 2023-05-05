<?php
include("../lib/permission1.php");
include("../lib/include.php");
include("../lib/function.php");
include("../lib/user_config.php");
include("../lib/connect.php");
include("../lib/utilities_function.php");
$sql_chk = $db->db_fetch_array($db->query("select site_info_max_file from site_info"));
include("lib_doc.php");
?>
<html>
<head>
<title><?php echo $EWT_title ?></title>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<link href="../theme/main_theme/css/style.css" rel="stylesheet" type="text/css">
<style type="text/css">
<!--
.style1 {color: #FF0000}
-->
</style>
</head>

<SCRIPT language=JavaScript src="../js/date-picker.js" type=text/javascript></SCRIPT>
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
        <span class="ewtfunction">แก้ไข File</span> </td>
  </tr>
</table>
<?php 
		$sql = "SELECT * FROM docload_list  WHERE dl_id='$_GET[fid]'";
		$query=$db->query($sql);
		$data=$db->db_fetch_array($query);
?> 
<table width="94%" border="0" align="center" cellpadding="0" cellspacing="0" class="ewtfunctionmenu">
  <tr>
    <td align="right"><a href="javascript:void(0);" onClick="load_divForm('../FavoritesMgt/favorites_add.php?name=<?php echo urlencode ("แก้ไข File ".$data[dl_name]."  ภายใต้กลุ่ม :"); ?><?php if($_GET["gid"] != ''){ echo current_group_level2($_GET["gid"]);}?>&module=document&url=<?php if($_GET["gid"] != ''){ echo urlencode  ( "download_add.php?gid=".$_GET["gid"]);}else{ echo urlencode  ( "download_add.php");}?>', 'divForm', 300, 80, -1,433, 1);"><img src="../images/star_yellow_add.gif" width="16" height="16" border="0" align="middle">&nbsp;Add to favorites </a>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<a href="main_download_group.php" ><img src="../theme/main_theme/g_mainpage.gif" width="16" height="16" align="absmiddle" border="0">กลับหน้าหลัก</a>
	<a href="download_list.php?gid=<?php echo $_GET[gid]?>" ><img src="../theme/main_theme/g_mainpage.gif" width="16" height="16" align="absmiddle" border="0">ย้อนกลับ</a>
      <hr> </td>
  </tr>
</table>

<table width="70%" border="0" align="center" cellpadding="5" cellspacing="1" bgcolor="#CECECE"  class="ewttableuse">
  <tr bgcolor="#E7E7E7" > 
    <td height="30" colspan="2" class="ewttablehead"> แก้ไขFile</td>
  </tr>
<tr valign="top" bgcolor="#FFFFFF"> 
    <td width="38%">ชื่อ File<font color="#FF0000">*</font></td>
    <td width="62%"><?php echo $data[dl_name];?></td>
  </tr>
  <tr valign="top" bgcolor="#FFFFFF"> 
    <td width="38%">รายละเอียด</td>
    <td width="62%"><textarea name="dl_detail" cols="50" rows="4"><?php echo $data[dl_detail];?></textarea></td>
  </tr>
  <tr valign="top" bgcolor="#FFFFFF"> 
    <td width="38%">วันที่สร้าง</td>
	<?php 
	//$y=substr($data[dl_createdate],0,4)+543;
	//$m=substr($data[dl_createdate],4,2);
	//$d=substr($data[dl_createdate],6,2);
	?>
    <td width="62%"><?php echo date_display($data[dl_createdate],'YmdHis','DT1Th');?></td>
  </tr>
  <tr valign="top" bgcolor="#FFFFFF"> 
    <td width="38%">กลุ่ม <font color="#FF0000">*</font></td>
      <td width="62%">
	  <select name="dl_group">
		 <?php
	      		$sql = "SELECT * FROM docload_group  ORDER BY dlg_id ASC";
				$query=$db->query($sql);
		  		while($data2=$db->db_fetch_array($query)){  ?> 
	     				<option value="<?php echo $data2[dlg_id]; ?>" <?php if($data2[dlg_id]==$data[dl_dlgid])echo 'selected';?>><?php echo $data2[dlg_name]; ?></option>  
			   <?php	} ?>
	    
	  </select>
	  </td>
  </tr>
  <tr valign="top" bgcolor="#FFFFFF"> 
    <td width="38%">เลือกไฟล์ <font color="#FF0000">* <br/><?php
$rSizeLimit=$db->db_fetch_array($db->query('SELECT * FROM docload_setting LIMIT 1'));
echo '(จำกัดขนาดที่ '.($rSizeLimit['dls_filesize']/1024).' kb.)<br/>';
echo '(ประเภทไฟล์ที่อัพโหลดได้ '.$rSizeLimit['dls_ext'].'.)';
?></font></td>
    <td width="62%"><input name="dl_file" type="file"  ><br><input name="Replace" type="checkbox" id="Replace" value="Y"> <font color="#FF0000">อนุญาตให้ทับไฟล์เดิม</font></td>
  </tr>
  <tr valign="top" bgcolor="#FFFFFF"> 
    <td width="38%">สถานะ</td>
	<?php 
	$y=substr($data[dl_createdate],0,4)+543;
	$m=substr($data[dl_createdate],4,2);
	$d=substr($data[dl_createdate],6,2);
	?>
    <td width="62%">
	<input type="radio" value="Y"  name="dl_open" <?php if($data[dl_open]=='Y') echo 'checked'; ?>> เปิดการโหลด 
	<input type="radio" value="N"  name="dl_open" <?php if($data[dl_open]=='N') echo 'checked'; ?>> ปิดการโหลด </td>
  </tr>
  <tr bgcolor="#FFFFFF">
    <td>&nbsp;</td>
    <td><input type="submit" name="Submit2" value="บันทึก" >
	<input name="flag" type="hidden"  value="edit"> 
	<input name="gid" type="hidden"  value="<?php echo $data[dl_dlgid];?>"> 
	<input name="dl_id" type="hidden"  value="<?php echo $_GET[fid];?>"> 
     <input type="reset" name="Submit3" value="ยกเลิก" onClick="location.href='download_list.php?gid=<?php echo $data[dl_dlgid];?>' "></td>
  </tr>
</table>
</form>
</body>
</html>
<?php
$db->db_close(); ?>