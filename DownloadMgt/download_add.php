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
   if(c.dl_name.value==""){
       alert('กรุณากรอกชื่อ File');
	   c.dl_name.focus();
       return false;
   }else if(c.dl_group.value=="0"){
   		alert('กรุณาเลือกกลุ่ม');
	   c.dl_group.focus();
       return false;
   }else if(document.myForm.dl_file.value==""){  
   		alert('กรุณาเลือกไฟล์'); 
       return false;
   }
}
</script>
<body leftmargin="0" topmargin="0">
<form name="myForm" method="post" action="download_process.php" enctype="multipart/form-data">
<table width="80%" border="0" align="center" cellpadding="5" cellspacing="0">
  <tr> 
      <td><img src="../theme/main_theme/logo.gif" width="32" height="32" align="absmiddle"> 
        <span class="ewtfunction">เพิ่ม File</span> </td>
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
    <td height="30" colspan="2" class="ewttablehead"> เพิ่ม File</td>
  </tr>
  <tr valign="top" bgcolor="#FFFFFF"> 
    <td width="38%">ชื่อ File<font color="#FF0000">*</font></td>
    <td width="62%"><input name="dl_name" type="text" size="40"></td>
  </tr>
  <tr valign="top" bgcolor="#FFFFFF"> 
    <td width="38%">รายละเอียด</td>
    <td width="62%"><textarea name="dl_detail" cols="50" rows="4"></textarea></td>
  </tr>
  <tr valign="top" bgcolor="#FFFFFF"> 
    <td width="38%">วันที่สร้าง</td>
    <td width="62%"><input name="dl_date" type="text" id="dl_date" value="<?php echo date("d")."/".date("m")."/".(date("Y")+543); ?>" size="10" readonly="true"> 
              <a href="#date" onClick="return show_calendar('myForm.dl_date');" onMouseOver="window.status='Date Picker';return true;" onMouseOut="window.status='';return true;"><img src="../images/calendar.gif" width="20" height="20" border="0" align="absmiddle"></a> </td>
  </tr>
  <tr valign="top" bgcolor="#FFFFFF"> 
    <td width="38%">กลุ่ม <font color="#FF0000">*</font></td>
      <td width="62%">
	  <select name="dl_group">
	     <option value="0">--เลือกกลุ่ม--</option>  
		 <?php
	      		$sql = "SELECT * FROM download_group  ORDER BY dlg_id ASC";
				$query=$db->query($sql);
		  		while($data=$db->db_fetch_array($query)){  ?> 
	     				<option value="<?php echo $data[dlg_id]; ?>" <?php if($_GET[gid]==$data[dlg_id])echo 'selected';?>><?php echo $data[dlg_name]; ?></option>  
			   <?php	} ?>
	    
	  </select>
	  </td>
  </tr>
  <tr valign="top" bgcolor="#FFFFFF"> 
    <td width="38%">เลือกไฟล์ <font color="#FF0000">*</font></td>
    <td width="62%"><input name="dl_file" type="file"  >  </td>
  </tr>

  <tr bgcolor="#FFFFFF">
    <td>&nbsp;</td>
    <td><input type="submit" name="Submit2" value="บันทึก" onClick="return ChkInput(document.myForm)">
	<input name="flag" type="hidden"  value="add"> 
	<input name="gid" type="hidden"  value="<?php echo $_GET[gid];?>"> 
      <input type="reset" name="Submit3" value="ยกเลิก"></td>
  </tr>
</table>
</form>
</body>
</html>
<?php
$db->db_close(); ?>