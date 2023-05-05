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
	
  $sql_edit = " SELECT *  FROM value_attrbute_tag  WHERE v_id = '$v_id' ";
  $exec_edit = $db2->query($sql_edit);
  $rec_edit = $db2->fetch_array($exec_edit);
	
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html lang="th">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<title>Possible Attribute</title>
<script type="text/javascript" language="javascript1.2" src="js/AjaxRequest.js"></script>
<script type="text/javascript" language="javascript1.2" src="js/functions.js"></script>
<script type="text/javascript" language="javascript1.2">
function MM_openBrWindow(theURL,winName,features) { //v2.0
  return window.open(theURL,winName,features);
}

function chkInput() {
		if(frm.tag_name.value=='') {
			alert('Please choose Tag Name');
			return false;
		} 
		if(frm.attribute_name.value=='' &&  frm.new_attribute.value=='') {
			alert('Please enter Attribute Name');
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
<form name="frm" method="post" action="data_attribute_tag.php" enctype="multipart/form-data" target="dataFrame">
<table width="100%" border="1" cellspacing="0" cellpadding="3" align="center" bordercolor="99ccff">
    <tr> 
      <td colspan="10" height="40" bgcolor="6699ff"> <table width="100%" border="0" cellspacing="0" cellpadding="0">
          <tr> 
            <td width="46%"><font face="Arial, Helvetica, sans-serif" size="2"><font face="Arial, Helvetica, sans-serif" size="2"><b><font color="#000066" face="ms sans serif" size="3">
              <font color="#FFFFFF">ข้อมูล Attribute ที่ถูกต้องของ Tag นั้นๆ</font></font></b></font></font> 
            </td>
            <td width="54%"><div align="right"><b><font size="1" face="MS Sans Serif"> 
                </font></b>&nbsp;&nbsp;</div></td>
          </tr>
        </table></td>
    </tr>
	<tr><td><input name="v_id" type="hidden" value="<?php echo $v_id;?>" >
<table  border="0" cellspacing="1" cellpadding="2">
  <tr style="font-weight:bold; color:#CCCC66"  bgcolor="#0099FF">
    <td width="150">Tag Name</td>   
    <td width="300" >Attribute Name</td>    
	<td width="200" >Attribute Value</td>	
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
		<td><select name="attribute_name" >
			<option value="">==Please Select==</option>
			<?php
			$sql_options = "SELECT DISTINCT attribute_name AS attribute_name FROM attribute  ORDER BY  attribute_name  ";
			$exec_options = $db2->query($sql_options);
			while($rec_options= $db2->fetch_array($exec_options)) {
				 ?><option value="<?php echo $rec_options[attribute_name];?>" <?php if($rec_options[attribute_name]==$rec_edit[attribute_name]) echo "selected"; ?>><?php echo $rec_options[attribute_name];?></option><?php
			}
			?>
			</select><?php if(!$v_id) { ?> New =&gt; <input name="new_attribute" type="text" size="15" maxlength="60" ><?php } ?></td>  
		<td><input name="possible_value" type="text" size="20" maxlength="100" value="<?php echo $rec_edit[possible_value];?>"> <input name="bt_accept" type="button" value=" Save " onClick="return chkInput()"><input name="accept" type="hidden"></td>
	</tr>
</table>
</td></tr></table>
</form>
<iframe src="data_attribute_tag.php" name="dataFrame" width="800" height="400" scrolling="auto"></iframe>
</td></tr></table>
</body>
</html>
