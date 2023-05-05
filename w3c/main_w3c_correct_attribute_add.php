<?php
include("../lib/permission1.php");
include("../lib/include.php");
include("../lib/function.php");
include("../lib/user_config.php");
include("../lib/connect.php");
  $db->query("USE ".$EWT_DB_W3C);
  if($_POST[flag]=='add'){
  						
  						$sql_chk = "SELECT  * FROM  value_edit_attr_tag  WHERE tag_name = '".$_POST["tag_name"]."' AND 
					attribute_name = '".$_POST["attribute_name"]."' AND wrong_value = '".$_POST["wrong_value"]."' AND 
					correct_value = '".$_POST["correct_value"]."' AND wrong_attribute = '".$_POST["wrong_attribute"]."'  ";
						$exec_chk = $db->query($sql_chk);
						$num_chk = $db->db_num_rows($exec_chk);
						if($num_chk > 0){
								?>
								<script type="text/javascript">
									alert('ท่านกรอกรายการแก้ไขหน้าเวบซ้ำ');			
									self.location.href = 'main_w3c_correct_attribute_list.php';
								</script>
								<?php
								exit;
						}
						//  htmlspecialchars($str, ENT_QUOTES);  แปลง ' ให้เป็น &#039;
					$INSERT = $db->query(" INSERT INTO value_edit_attr_tag (tag_name, attribute_name, wrong_value, correct_value, wrong_attribute, recommend, notnull, data_type ) 
											VALUES ('".$_POST["tag_name"]."', '".$_POST["attribute_name"]."','".htmlspecialchars($_POST["wrong_value"], ENT_QUOTES)."','".htmlspecialchars($_POST["correct_value"], ENT_QUOTES)."' ,'".htmlspecialchars($_POST["wrong_attribute"], ENT_QUOTES)."' ,'".htmlspecialchars($_POST["recommend"], ENT_QUOTES)."', '".$_POST["notnull"]."',  '".$_POST["data_type"]."'   )");
												?>
								<script type="text/javascript">
									alert('บันทึกข้อมูลเรียบร้อยแล้ว');					
									self.location.href = 'main_w3c_correct_attribute_list.php';
								</script>
								<?php
								exit;
  }
    if($_POST[flag]=='edit'){
		$UPDATE = $db->query(" UPDATE value_edit_attr_tag  SET  tag_name = '".$_POST["tag_name"]."',  attribute_name = '".$_POST["attribute_name"]."', 
					wrong_value = '".htmlspecialchars($_POST["wrong_value"], ENT_QUOTES)."', correct_value = '".htmlspecialchars($_POST["correct_value"], ENT_QUOTES)."' , 
					wrong_attribute = '".htmlspecialchars($_POST["wrong_attribute"], ENT_QUOTES)."' , recommend = '".htmlspecialchars($_POST["recommend"], ENT_QUOTES)."', notnull =  '".$_POST["notnull"]."'   WHERE  edit_id = '".$_POST["edit_id"]."' ");
			?>
								<script type="text/javascript">
									alert('บันทึกข้อมูลเรียบร้อยแล้ว');					
									self.location.href = 'main_w3c_correct_attribute_list.php';
								</script>
								<?php
								exit;
	}
  
  
  
  //
  if($_GET[flag]=='edit'){
  $flag = 'edit';
 					 $sql_tag = " SELECT *  FROM value_edit_attr_tag  WHERE edit_id = '".$_GET[edit_id]."'";
					  $exec_tag = $db->query($sql_tag);
					  $rec_edit = $db->db_fetch_array($exec_tag);
  }else{
  $flag = 'add';
  }
?>
<html>
<head>
<title><?php echo $EWT_title ?></title>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<link href="../theme/main_theme/css/style.css" rel="stylesheet" type="text/css">
<script language="javascript1.2">
function chkInput() {
		if(frm.tag_name.value=='') {
			alert('Please Choose Tag Name');
			return false;
		} 

}
</script>
</head>
<body leftmargin="0" topmargin="0">
<table width="80%" border="0" align="center" cellpadding="5" cellspacing="0">
  <tr> 
    <td><img src="../theme/main_theme/logo.gif" width="32" height="32" align="absmiddle"><span class="ewtfunction">การจัดการข้อมูล Attribute สำหรับแก้ไขหน้าเวบโดยอัตโนมัติ </span></td>
  </tr>
</table>
<table width="94%" border="0" align="center" cellpadding="0" cellspacing="0" class="ewtfunctionmenu">
  <tr>
    <td align="right"><a href="main_w3c_attribute_list.php"><img src="../theme/main_theme/g_back.gif" width="16" height="16" border="0" align="absmiddle"></a><A href="main_w3c_correct_attribute_list.php" target="w3c_body">การจัดการข้อมูล Attribute แก้ไขหน้าเว็บอัตโนมัติ</A>   &nbsp;&nbsp;&nbsp;
    <hr> </td>
  </tr>
</table>
<form name="frm" method="post" action="main_w3c_correct_attribute_add.php" onSubmit="return chkInput();" >
  <table width="94%" border="0" align="center" cellpadding="5" cellspacing="1" bgcolor="#CECECE"  class="ewttableuse">
    <tr bgcolor="#E7E7E7" >
      <td height="30" colspan="2" class="ewttablehead">เพิ่ม การจัดการข้อมูล Attribute แก้ไขหน้าเว็บอัตโนมัติ     </td>
    </tr>
    <tr valign="top" bgcolor="#FFFFFF">
      <td width="38%">Tag Name</td>
      <td width="62%"><select name="tag_name" >
			<option value="">==Please Select==</option>
			<?php 
			$sql_options = "SELECT DISTINCT tag_name AS tag_name FROM tag_info  ORDER BY  tag_name  ";
			$exec_options = $db->query($sql_options);
			while($rec_options= $db->db_fetch_array($exec_options)) {
				 ?><option value="<?php echo $rec_options[tag_name];?>" <?php  if($rec_options[tag_name]==$rec_edit[tag_name]) echo "selected"; ?>><?php echo $rec_options[tag_name];?></option><?php 
			}
			?>
			</select></td>
    </tr>
    <tr valign="top" bgcolor="#FFFFFF">
      <td>Wrong
      Attribute Name</td>
      <td><input name="wrong_attribute" type="text" size="15" maxlength="100" value="<?php echo $rec_edit[wrong_attribute];?>"></td>
    </tr>
    <tr valign="top" bgcolor="#FFFFFF">
      <td>Correct
      Attribute Name</td>
      <td><select name="attribute_name" >
        <option value="">==Please Select==</option>
        <?php 
			$sql_options = "SELECT DISTINCT attribute_name AS attribute_name FROM attribute  ORDER BY  attribute_name  ";
			$exec_options = $db->query($sql_options);
			while($rec_options= $db->db_fetch_array($exec_options)) {
				 ?>
        <option value="<?php echo $rec_options[attribute_name];?>" <?php  if($rec_options[attribute_name]==$rec_edit[attribute_name]) echo "selected"; ?>>
          <?php echo $rec_options[attribute_name];?>
          </option>
        <?php 
			}
			?>
      </select> <input name="notnull" type="checkbox"  value="1" <?php  if($rec_edit[notnull]) echo "checked"; ?>> Required<br> <fieldset style="padding:5px; border-style:ridge; border:1px"><legend>Options</legend> Data Type <select name="data_type" size="1"  <?php if($rec_edit[data_type]=="string") echo "selected";?> ><option value="string">String</option><option value="number" <?php if($rec_edit[data_type]=="number") echo "selected";?>>Number</option></select></fieldset></td>
    </tr>
    <tr valign="top" bgcolor="#FFFFFF">
      <td>Wrong
      Attribute Value</td>
      <td><input name="wrong_value" type="text" size="15" maxlength="100" value="<?php echo $rec_edit[wrong_value];?>"></td>
    </tr>
    <tr valign="top" bgcolor="#FFFFFF">
      <td>Correct
      Attribute Value</td>
      <td><input name="correct_value" type="text" size="15" maxlength="100" value="<?php echo $rec_edit[correct_value];?>"></td>
    </tr>
    <tr valign="top" bgcolor="#FFFFFF">
      <td>Recommend</td>
      <td><textarea name="recommend" rows="2" cols="40"><?php echo $rec_edit[recommend];?>
      </textarea>   </td>
    </tr>
    <tr bgcolor="#FFFFFF">
      <td>&nbsp;</td>
      <td><input type="submit" name="Submit2" value="Submit">
          <input type="reset" name="Submit3" value="Reset">
      <input type="hidden" name="flag" value="<?php echo $flag;?>">
	  <input name="edit_id" type="hidden" value="<?php echo $_GET[edit_id];?>" ></td>
    </tr>
  </table>
</form>
<?php $db->query("USE ".$EWT_DB_NAME);?>
</body>
</html>
<?php
$db->db_close(); ?>