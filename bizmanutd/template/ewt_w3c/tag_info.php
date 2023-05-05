<?php 
	session_start();
	$start_time_counter = date("YmdHis");
	include("../lib/function.php");
	include("../lib/user_config.php");
	include("../lib/connect.php");

	
	$main_db = $EWT_DB_NAME; //"db_163_ictweb";  อาจไม่ต้องใช้ ฐานข้อมูลลูกค้าเลย  เพราะเราอ่านข้อมูลจากหน้าเวบ url โดยตรง
	
	
	if(!$main_db) { // ถ้าไม่รู้ว่า จะดึงข้อมูลหน้าเว็บจาก db_name อันไหน  ให้ดีดออก
		echo "UnKnown Client Database";
		exit;
	}
	
	
	////////////////////////   connection สำหรับ W3C //////////////////////
    $path = "./";
	include ($path.'include/config.inc.php');
	include ($path.'include/class_db.php');
	include ($path.'include/class_display.php');	
	include ($path.'include/class_application.php');	
	$CLASS['db']   = new db2();
    $CLASS['db']->connect ();   
	$CLASS['disp'] = new display();
    $CLASS['app'] = new application();   
		   
	$db2   = $CLASS['db'];
    $disp = $CLASS['disp'];
	$app = $CLASS['app'];		
	
	$charac1 = $disp->convert_qoute_to_db("'");
	$charac2 = $disp->convert_qoute_to_db('"');
		
	$invalid = false;
	
	
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html lang="th">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<title>Tag Information</title>
<script type="text/javascript" language="javascript1.2" src="js/AjaxRequest.js"></script>
<script type="text/javascript" language="javascript1.2" src="js/functions.js"></script>
<script type="text/javascript" language="javascript1.2">
function MM_openBrWindow(theURL,winName,features) { //v2.0
  return window.open(theURL,winName,features);
}

function chkInput() {
		if(frm.tag_name.value=='') {
			alert('กรุณากรอก Tag Name');
			frm.tag_name.focus();
			return false;
		} 
		if(frm.section_id.value=='') {
			alert('กรุณาเลือก Tag Section');
			frm.section_id.focus();
			return false;
		}
		if(frm.tag_grand.value=='') {
			alert('กรุณาเลือก Tag แม่');
			frm.tag_grand.focus();
			return false;
		} 
	//if(confirm('ยืนยันการบันทึกหรือไม่')) {
		frm.accept.value = 'save';
		frm.submit();
	//}
}

</script>
</head>
<body bgcolor="#F3F3F3">
<table   border="0" cellspacing="0" cellpadding="0" >
   <tr valign="top">
	<td width="200"><?php include("w3c_menu.php");?></td>
	<td width="800">
<?php $sql_tag = " SELECT *  FROM tag_info  WHERE tag_id = '$tag_id' ";
					  $exec_tag = $db2->query($sql_tag);
					  $rec_tag = $db2->fetch_array($exec_tag);
	?>
<form name="frm" method="post" action="data_tag_info.php" enctype="multipart/form-data" target="dataFrame">
<table width="100%" border="1" cellspacing="0" cellpadding="3" align="center" bordercolor="99ccff">
    <tr> 
      <td colspan="10" height="40" bgcolor="6699ff"> <table width="100%" border="0" cellspacing="0" cellpadding="0">
          <tr> 
            <td width="46%"><font face="Arial, Helvetica, sans-serif" size="2"><font face="Arial, Helvetica, sans-serif" size="2"><b><font color="#000066" face="ms sans serif" size="3">
			<font color="#FFFFFF">ฐานข้อมูล Tag</font></font></b></font></font> 
            </td>
            <td width="54%"><div align="right"><b><font size="1" face="MS Sans Serif"> 
                </font></b>&nbsp;&nbsp;</div></td>
          </tr>
        </table></td>
    </tr>
	<tr><td><input name="tag_id" type="hidden" value="<?php echo $tag_id;?>" >
<table  border="0" cellspacing="1" cellpadding="2">
  <tr align="center" style="font-weight:bold" bgcolor="#99CCFF">
    <td width="100">Tag Name</td>   
    <td width="100">Tag Section</td>    
	<td width="100">ต้องมี Tag นี้</td>	
	<td width="100">ต้องมี Tag ปิด</td>	
	<td width="100">Tag แม่</td>
  </tr>  
  <tr><td><input name="tag_name" type="text" size="15" maxlength="50" value="<?php echo $rec_tag[tag_name];?>"> </td>  
		<td><select name="section_id" >
			<option value="">========</option>
			<?php
			$sql_options = "SELECT  section_id, section_name FROM  tag_section  ORDER BY  section_id  ";
			$exec_options = $db2->query($sql_options);
			while($rec_options= $db2->fetch_array($exec_options)) {
				 ?><option value="<?php echo $rec_options[section_id];?>" <?php if($rec_options[section_id]==$rec_tag[section_id]) echo "selected"; ?>><?php echo $rec_options[section_name];?></option><?php
			}
			?>
			</select></td>  
		<td align="center"><input name="need_status" type="checkbox"  value="1" <?php if($rec_tag[need_status]) echo "checked"; ?>></td> 
		<td align="center"><input name="need_close" type="checkbox"  value="1" <?php if($rec_tag[need_close]) echo "checked"; ?>></td>
		<td><select name="tag_grand" >
			<option value="">========</option>
			<?php
			$sql_options = "SELECT DISTINCT tag_name AS tag_name FROM tag_info  ORDER BY  tag_name  ";
			$exec_options = $db2->query($sql_options);
			while($rec_options= $db2->fetch_array($exec_options)) {
				 ?><option value="<?php echo $rec_options[tag_name];?>" <?php if($rec_options[tag_name]==$rec_tag[tag_grand]) echo "selected"; ?>><?php echo $rec_options[tag_name];?></option><?php
			}
			?>
			</select></td>  
	</tr>
<tr align="center" style="font-weight:bold" bgcolor="#99CCFF">
    <td width="100">Tag นำหน้า 1</td>   
    <td width="100">Tag นำหน้า 2</td>    
	<td width="100">Tag นำหน้า 3</td>	
	<td  colspan="2" align="left"> W3C ไม่อนุญาต </td>	
  </tr>  
  <tr>
  <td><select name="tag_parent" >
			<option value="">========</option>
			<?php
			$sql_options = "SELECT DISTINCT tag_name AS tag_name FROM tag_info  ORDER BY  tag_name  ";
			$exec_options = $db2->query($sql_options);
			while($rec_options= $db2->fetch_array($exec_options)) {
				 ?><option value="<?php echo $rec_options[tag_name];?>" <?php if($rec_options[tag_name]==$rec_tag[tag_parent]) echo "selected"; ?>><?php echo $rec_options[tag_name];?></option><?php
			}
			?>
			</select></td>  
  <td><select name="tag_parent2" >
			<option value="">========</option>
			<?php
			$sql_options = "SELECT DISTINCT tag_name AS tag_name FROM tag_info  ORDER BY  tag_name  ";
			$exec_options = $db2->query($sql_options);
			while($rec_options= $db2->fetch_array($exec_options)) {
				 ?><option value="<?php echo $rec_options[tag_name];?>" <?php if($rec_options[tag_name]==$rec_tag[tag_parent2]) echo "selected"; ?>><?php echo $rec_options[tag_name];?></option><?php
			}
			?>
			</select></td>
   <td><select name="tag_parent3" >
			<option value="">========</option>
			<?php
			$sql_options = "SELECT DISTINCT tag_name AS tag_name FROM tag_info  ORDER BY  tag_name  ";
			$exec_options = $db2->query($sql_options);
			while($rec_options= $db2->fetch_array($exec_options)) {
				 ?><option value="<?php echo $rec_options[tag_name];?>" <?php if($rec_options[tag_name]==$rec_tag[tag_parent3]) echo "selected"; ?>><?php echo $rec_options[tag_name];?></option><?php
			}
			?>
			</select></td>  
  <td align="center"><!--input name="need_parent" type="checkbox"  value="1" <?php //if($rec_tag[need_parent]) echo "checked"; ?>--><input name="w3c_notallow" type="checkbox"  value="N" <?php if($rec_tag[w3c_notallow]) echo "checked"; ?>></td>
  <td align="right"><input name="bt_accept" type="button" value=" Save " onClick="return chkInput()"><input name="accept" type="hidden"></td>
  </tr>
</table>	
</td></tr></table>
</form>
<iframe src="data_tag_info.php" name="dataFrame" width="800" height="350" scrolling="auto"></iframe>
</td></tr></table>
</body>
</html>
