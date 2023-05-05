<?php
include("../lib/permission1.php");
include("../lib/include.php");
include("../lib/function.php");
include("../lib/user_config.php");
include("../lib/connect.php");
  $db->query("USE ".$EWT_DB_W3C);
  if($_POST[flag]=='add'){
  						if($_POST["new_attribute"]) { // ถ้ากรอก attribute ใหม่ เข้ามา
							
									$sql_chk = " SELECT  * FROM  attribute  WHERE attribute_name = '".$_POST["new_attribute"]."' ";
									$exec_chk = $db->query($sql_chk);
									$num_chk = $db->db_num_rows($exec_chk);
									
									if($num_chk==0) {
												$ins1 = " INSERT INTO attribute ( attribute_name  ) 
												VALUES (  '".$_POST["new_attribute"]."' )";
												$db->query($ins1);
									}
									
									$_POST["attribute_name"] = $_POST["new_attribute"];
							}
							if(!$_POST["possible_value"]){$_POST["possible_value"] = "***";}
  						$sql_chk = " SELECT  * FROM  value_attrbute_tag  WHERE tag_name = '".$_POST["tag_name"]."' AND attribute_name = '".$_POST["attribute_name"]."' AND possible_value = '".$_POST["possible_value"]."' ";
						$exec_chk = $db->query($sql_chk);
						$num_chk = $db->db_num_rows($exec_chk);
						if($num_chk > 0){
								?>
								<script type="text/javascript">
									alert('ท่านกรอกข้อมูล Attribute ที่ถูกต้องของ Tag ซ้ำทั้งสามช่อง');					
									self.location.href = 'main_w3c_attribute_list.php';
								</script>
								<?php
								exit;
						}
					$INSERT = $db->query("  INSERT INTO value_attrbute_tag (tag_name, attribute_name, possible_value ) 
												VALUES ('".$_POST["tag_name"]."', '".$_POST["attribute_name"]."','".$_POST["possible_value"]."' )");
												?>
								<script type="text/javascript">
									alert('บันทึกข้อมูลเรียบร้อยแล้ว');					
									self.location.href = 'main_w3c_attribute_list.php';
								</script>
								<?php
								exit;
  }
    if($_POST[flag]=='edit'){
		$UPDATE = $db->query(" UPDATE value_attrbute_tag  SET  tag_name = '".$_POST["tag_name"]."',  attribute_name = '".$_POST["attribute_name"]."', possible_value = '".$_POST["possible_value"]."' WHERE  v_id = '".$_POST["v_id"]."' ");
			?>
								<script type="text/javascript">
									alert('บันทึกข้อมูลเรียบร้อยแล้ว');					
									self.location.href = 'main_w3c_attribute_list.php';
								</script>
								<?php
								exit;
	}
  
  
  
  //
  if($_GET[flag]=='edit'){
  $flag = 'edit';
 					 $sql_tag = " SELECT *  FROM value_attrbute_tag  WHERE v_id = '".$_GET[v_id]."'";
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
			alert('Please choose Tag Name');
			return false;
		} 
		if(frm.attribute_name.value=='' &&  frm.new_attribute.value=='') {
			alert('Please enter Attribute Name');
			return false;
		} 

}
</script>
</head>
<body leftmargin="0" topmargin="0">
<table width="80%" border="0" align="center" cellpadding="5" cellspacing="0">
  <tr> 
    <td><img src="../theme/main_theme/logo.gif" width="32" height="32" align="absmiddle"> 
      <span class="ewtfunction">การจัดการ Tag </span> </td>
  </tr>
</table>
<table width="94%" border="0" align="center" cellpadding="0" cellspacing="0" class="ewtfunctionmenu">
  <tr>
    <td align="right"><a href="main_w3c_attribute_list.php"><img src="../theme/main_theme/g_back.gif" width="16" height="16" border="0" align="absmiddle"> 
      การจัดการ </a><a href="main_w3c_attribute_add.php">Attribute</a><a href="main_w3c_attribute_list.php"> </a>&nbsp;&nbsp;&nbsp;
    <hr> </td>
  </tr>
</table>
<form name="frm" method="post" action="main_w3c_attribute_add.php" onSubmit="return chkInput();" >
  <table width="94%" border="0" align="center" cellpadding="5" cellspacing="1" bgcolor="#CECECE"  class="ewttableuse">
    <tr bgcolor="#E7E7E7" >
      <td height="30" colspan="2" class="ewttablehead">เพิ่ม Tag </td>
    </tr>
    <tr valign="top" bgcolor="#FFFFFF">
      <td width="38%">Tag Name</td>
      <td width="62%"><select name="tag_name" >
			<option value="">==Please Select==</option>
			<?php
			$sql_options = "SELECT DISTINCT tag_name AS tag_name FROM tag_info  ORDER BY  tag_name  ";
			$exec_options = $db->query($sql_options);
			while($rec_options= $db->db_fetch_array($exec_options)) {
				 ?><option value="<?php echo $rec_options[tag_name];?>" <?php if($rec_options[tag_name]==$rec_edit[tag_name]) echo "selected"; ?>><?php echo $rec_options[tag_name];?></option><?php
			}
			?>
			</select></td>
    </tr>
    <tr valign="top" bgcolor="#FFFFFF">
      <td>Attribute Name</td>
      <td><select name="attribute_name" >
			<option value="">==Please Select==</option>
			<?php
			$sql_options = "SELECT DISTINCT attribute_name AS attribute_name FROM attribute  ORDER BY  attribute_name  ";
			$exec_options = $db->query($sql_options);
			while($rec_options= $db->db_fetch_array($exec_options)) {
				 ?><option value="<?php echo $rec_options[attribute_name];?>" <?php if($rec_options[attribute_name]==$rec_edit[attribute_name]) echo "selected"; ?>><?php echo $rec_options[attribute_name];?></option><?php
			}
			?>
			</select>
       <?php if(!$_GET[v_id]) { ?> New =><input name="new_attribute" type="text" size="15" maxlength="60" ><?php } ?></td>
    </tr>
    <tr valign="top" bgcolor="#FFFFFF">
      <td>Attribute Value</td>
      <td><input name="possible_value" type="text" size="20" maxlength="100" value="<?php echo $rec_edit[possible_value];?>"></td>
    </tr>
    <tr bgcolor="#FFFFFF">
      <td>&nbsp;</td>
      <td><input type="submit" name="Submit2" value="Submit">
          <input type="reset" name="Submit3" value="Reset">
      <input type="hidden" name="flag" value="<?php echo $flag;?>">
	  <input name="v_id" type="hidden" value="<?php echo $_GET[v_id];?>" ></td>
    </tr>
  </table>
</form>
<?php $db->query("USE ".$EWT_DB_NAME);?>
</body>
</html>
<?php
$db->db_close(); ?>