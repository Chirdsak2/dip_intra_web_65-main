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
	
	  $sql_edit = " SELECT *  FROM value_edit_attr_tag  WHERE edit_id = '$edit_id' ";
	  $exec_edit = $db2->query($sql_edit);
	  $rec_edit = $db2->fetch_array($exec_edit);
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html lang="th">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<title>Correct Attribute</title>
<script type="text/javascript" language="javascript1.2" src="js/AjaxRequest.js"></script>
<script type="text/javascript" language="javascript1.2" src="js/functions.js"></script>
<script type="text/javascript" language="javascript1.2">
function MM_openBrWindow(theURL,winName,features) { //v2.0
  return window.open(theURL,winName,features);
}

function chkInput() {
		if(frm.tag_name.value=='') {
			alert('Please Choose Tag Name');
			return false;
		} 
		//if(frm.attribute_name.value=='') {
		//	alert('Please Choose Attribute Name');
		//	return false;
		//} 
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
<form name="frm" method="post" action="data_correct_attribute.php" enctype="multipart/form-data" target="dataFrame">
<table width="100%" border="1" cellspacing="0" cellpadding="3" align="center" bordercolor="99ccff">
    <tr> 
      <td colspan="10" height="40" bgcolor="6699ff"> <table width="100%" border="0" cellspacing="0" cellpadding="0">
          <tr> 
            <td width="46%"><font face="Arial, Helvetica, sans-serif" size="2"><font face="Arial, Helvetica, sans-serif" size="2"><b><font color="#000066" face="ms sans serif" size="3">
              <font color="#FFFFFF">ฐานข้อมูลสำหรับแก้ไขหน้าเวบโดยอัตโนมัติ</font></font></b></font></font> 
            </td>
            <td width="54%"><div align="right"><b><font size="1" face="MS Sans Serif"> 
                </font></b>&nbsp;&nbsp;</div></td>
          </tr>
        </table></td>
    </tr>
	<tr><td><input name="edit_id" type="hidden" value="<?php echo $edit_id;?>" >
<table width="800" border="0" cellspacing="1" cellpadding="2">
  <tr style="font-weight:bold" bgcolor="#99CCFF" valign="top">
    <td width="100">Tag Name</td>   	
    <td width="150">Wrong<br>Attribute Name</td>    
	<td width="150">Correct<br>Attribute Name</td>    
	<td width="150">Wrong<br>Attribute Value</td>    
	<td width="250">Correct<br>Attribute Value</td> 
  </tr>  
  <tr> <td><select name="tag_name" >
			<option value="">==Please Select==</option>
			<?php
			$sql_options = "SELECT DISTINCT tag_name AS tag_name FROM tag_info  ORDER BY  tag_name  ";
			$exec_options = $db2->query($sql_options);
			while($rec_options= $db2->fetch_array($exec_options)) {
				 ?><option value="<?php echo $rec_options[tag_name];?>" <?php if($rec_options[tag_name]==$rec_edit[tag_name]) echo "selected"; ?>><?php echo $rec_options[tag_name];?></option><?php
			}
			?>
			</select></td>  
		<td><input name="wrong_attribute" type="text" size="15" maxlength="100" value="<?php echo $rec_edit[wrong_attribute];?>"></td>
		<td><select name="attribute_name" >
			<option value="">==Please Select==</option>
			<?php
			$sql_options = "SELECT DISTINCT attribute_name AS attribute_name FROM attribute  ORDER BY  attribute_name  ";
			$exec_options = $db2->query($sql_options);
			while($rec_options= $db2->fetch_array($exec_options)) {
				 ?><option value="<?php echo $rec_options[attribute_name];?>" <?php if($rec_options[attribute_name]==$rec_edit[attribute_name]) echo "selected"; ?>><?php echo $rec_options[attribute_name];?></option><?php
			}
			?>
			</select></td>  
		<td><input name="wrong_value" type="text" size="15" maxlength="100" value="<?php echo $rec_edit[wrong_value];?>"></td>
		<td><input name="correct_value" type="text" size="15" maxlength="100" value="<?php echo $rec_edit[correct_value];?>"></td>			 
	</tr>
	<tr valign="top" style="font-weight:bold" bgcolor="#99CCFF">
		<td colspan="4">Recommend<br><textarea name="recommend" rows="2" cols="40"><?php echo $disp->convert_qoute_to_show($rec_edit[recommend]);?></textarea>&nbsp;<input name="notnull" type="checkbox"  value="1" <?php if($rec_edit[notnull]) echo "checked"; ?>> Attribute Not Null &nbsp;<input name="bt_accept" type="button" value=" Save " onClick="return chkInput()"><input name="accept" type="hidden"></td>
		<td valign="middle">Data Type<br><select name="data_type" size="1"  <?php if($rec_edit[data_type]=="string") echo "selected";?> ><option value="string">String</option><option value="number" <?php if($rec_edit[data_type]=="number") echo "selected";?>>Number</option></select></td>
	</tr>
</table>	
</td></tr></table>
</form>
<iframe src="data_correct_attribute.php" name="dataFrame" width="800" height="350" scrolling="auto"></iframe>
</td></tr></table>
</body>
</html>
