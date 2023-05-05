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
<form name="myForm" method="post" action="vdo_process.php" enctype="multipart/form-data">
<table width="80%" border="0" align="center" cellpadding="5" cellspacing="0">
  <tr> 
      <td><img src="../theme/main_theme/logo.gif" width="32" height="32" align="absmiddle"> 
        <span class="ewtfunction">แก้ไข VIDEO</span> </td>
  </tr>
</table>
<table width="94%" border="0" align="center" cellpadding="0" cellspacing="0" class="ewtfunctionmenu">
  <tr>
    <td align="right"><a href="main_vdo_group.php" ><img src="../theme/main_theme/g_mainpage.gif" width="16" height="16" align="absmiddle" border="0">กลับหน้าหลัก</a>
	<a href="vdo_list.php?gid=<?php echo $_GET[gid]?>" ><img src="../theme/main_theme/g_mainpage.gif" width="16" height="16" align="absmiddle" border="0">ย้อนกลับ</a>
      <hr> </td>
  </tr>
</table>
<?php 
		$sql = "SELECT * FROM vdo_list  WHERE vdo_id='$_GET[vid]'";
		$query=$db->query($sql);
		$data=$db->db_fetch_array($query);
?> 
<table width="70%" border="0" align="center" cellpadding="5" cellspacing="1" bgcolor="#CECECE"  class="ewttableuse">
  <tr bgcolor="#E7E7E7" > 
    <td height="30" colspan="2" class="ewttablehead"> แก้ไข VIDEO</td>
  </tr>
  <tr valign="top" bgcolor="#FFFFFF"> 
    <td width="38%">ชื่อ VIDEO <font color="#FF0000">*</font></td>
    <td width="62%"><input name="vdo_name" type="text" size="40" value="<?php echo $data[vdo_name];?>"></td>
  </tr>
  
  <tr valign="top" bgcolor="#FFFFFF"> 
    <td width="38%">ผู้สร้าง</td>
    <td width="62%"><input name="vdo_creator" type="text" size="40" value="<?php echo $data[vdo_creator];?>"></td>
  </tr>
  <tr valign="top" bgcolor="#FFFFFF"> 
    <td width="38%">URL</td>
    <td width="62%"><input name="vdo_info" type="text" size="40" value="<?php echo $data[vdo_info];?>"></td>
  </tr>
  <tr valign="top" bgcolor="#FFFFFF"> 
    <td width="38%">รายละเอียด</td>
    <td width="62%"><textarea  name="vdo_detail" cols="40"><?php echo $data[vdo_detail];?></textarea></td>
  </tr>
  <tr valign="top" bgcolor="#FFFFFF"> 
    <td width="38%">กลุ่ม <font color="#FF0000">*</font></td>
      <td width="62%">
	  <select name="vdo_group">
	     <option value="0">--เลือกกลุ่ม--</option>  
		 <?php
	      		$sql2 = "SELECT * FROM vdo_group  ORDER BY vdog_id ASC";
				$query2=$db->query($sql2);
		  		while($data2=$db->db_fetch_array($query2)){  ?> 
	     				<option value="<?php echo $data2[vdog_id]; ?>" <?php if($data[vdo_group]==$data2[vdog_id])echo 'selected';?>><?php echo $data2[vdog_name]; ?></option>  
			   <?php	} ?>
	    
	  </select>
	  </td>
  </tr>
  <tr valign="top" bgcolor="#FFFFFF"> 
    <td width="38%">เลือกไฟล์ VIDEO <font color="#FF0000">*</font></td>
    <td width="62%">
	ไฟล์ปัจจุบัน : [<?php echo $data[vdo_filename];?>]<br><br>
	<select name="vdo_filesource" 
	      onChange="if(this.value=='com'){
		                              document.myForm.vdo_file1.style.display='';
									  document.myForm.vdo_file2.style.display='none';
									  document.all.sfile.style.display='none';
									}else{ 
		                              document.myForm.vdo_file1.style.display='none';
									  document.myForm.vdo_file2.style.display='';
									  document.all.sfile.style.display='';
									}
									">
	 <option value="com" <?php if($data[vdo_filesource]=='com')echo 'selected';?>>ไฟล์จากเครื่อง</option> 
	 <option value="web" <?php if($data[vdo_filesource]=='web')echo 'selected';?>>ไฟล์จากระบบ</option>  
	</select>
	<input name="vdo_file1" type="file"  >
	<input name="vdo_file2" type="text"  size="30"  style="display:'none'" value="<?php if($data[vdo_filesource]=='web') echo $data[vdo_filename];  ?>">
	<input  type="hidden" name="vdo_filename" value="<?php echo $data[vdo_filename];?>">
	
	<a href="#browse" onClick="win2 = window.open('../FileMgt/website_main.php?stype=link&Flag=Link&o_value=window.opener.document.myForm.vdo_file2.value','WebsiteLink','top=100,left=100,width=800,height=600,resizable=1,status=0');"><img  id="sfile" src="../images/i_folder_on.jpg" width="16" height="16" border="0" align="absmiddle"  style="display:'none'" ></a>
	 <script language="JavaScript">
           <?php  if($data[vdo_filesource]=='com'){?>
					document.myForm.vdo_file1.style.display='';
					document.myForm.vdo_file2.style.display='none';
					document.all.sfile.style.display='none';
		   <?php }else{?>
					document.myForm.vdo_file1.style.display='none';
					document.myForm.vdo_file2.style.display='';
					document.all.sfile.style.display='';
		   <?php } ?>
	 </script>
	 
	 <br>
	 <span class="style1">* ประเภทไฟล์ที่สามารถใช้ได้คือ jpg,swf,flv และ mp3 เท่านั้น <br>
* ขนาดไฟล์ต้องไม่เกิน <?php echo $sql_chk["site_info_max_file"];?> KB.</span></td>
  </tr>
   <tr valign="top" bgcolor="#FFFFFF"> 
    <td width="38%">รูปภาพ</td>
    <td width="62%"><input name="vdo_imagefile1" type="file" ><input  type="hidden" name="vdo_imagefile" value="<?php echo $data[vdo_image];?>"><br>
	 <span class="style1">* ประเภทไฟล์ที่สามารถใช้ได้คือ jpg,gif,png และ bmp เท่านั้น <br>
* ขนาดไฟล์ต้องไม่เกิน <?php echo $sql_chk["site_info_max_file"];?> KB.</span></td>
  </tr>
  <tr bgcolor="#FFFFFF">
    <td>&nbsp;</td>
    <td><input type="submit" name="Submit2" value="บันทึก" onClick="return ChkInput(document.myForm)">
	<input name="flag" type="hidden"  value="edit"> 
	<input name="gid" type="hidden"  value="<?php echo $data[vdo_group];?>"> 
	<input name="vdo_id" type="hidden"  value="<?php echo $_GET[vid];?>"> 
     <input type="reset" name="Submit3" value="ยกเลิก" onClick="location.href='vdo_list.php?gid=<?php echo $data[vdo_group];?>' "></td>
  </tr>
</table>
</form>
</body>
</html>
<?php
$db->db_close(); ?>