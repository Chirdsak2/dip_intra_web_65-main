<?php
include("../lib/permission1.php");
include("../lib/include.php");
include("../lib/function.php");
include("../lib/user_config.php");
include("../lib/connect.php");
  //webpage_info check data for w3c
  $db->query("USE ".$EWT_DB_W3C);
if($_GET[flag]=='del'){
	$DELETE = $db->query(" DELETE FROM  value_edit_attr_tag WHERE edit_id = '".$_GET[edit_id]."' ");
?>
									<script type="text/javascript">
									alert('ลบข้อมูลเรียบร้อยแล้ว');					
									self.location.href = 'main_w3c_correct_attribute_list.php';
								</script>
								<?php
								exit;
}
?>
<html>
<head>
<title><?php echo $EWT_title ?></title>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<link href="../theme/main_theme/css/style.css" rel="stylesheet" type="text/css">
<script language="javascript1.1">
	function Preview(c){
				win2 = window.open('view_tag.php?tag_id='+c+'','TagPreview','top=100,left=80,width=640,height=480,resizable=1,status=0,scrollbars=1');
				win2.focus();
	}
</script>
</head>
<body leftmargin="0" topmargin="0">
<table width="80%" border="0" align="center" cellpadding="5" cellspacing="0">
  <tr> 
    <td><img src="../theme/main_theme/logo.gif" width="32" height="32" align="absmiddle"> 
      <span class="ewtfunction">การจัดการข้อมูล Attribute สำหรับแก้ไขหน้าเวบโดยอัตโนมัติ </span> </td>
  </tr>
</table>
<table width="94%" border="0" align="center" cellpadding="0" cellspacing="0" class="ewtfunctionmenu">
  <tr>
    <td align="right">
	  <a href="main_w3c_correct_attribute_add.php"><img src="../theme/main_theme/g_add.gif" width="16" height="16" border="0" align="absmiddle"> เพิ่มข้อมูล Attribute สำหรับแก้ไขหน้าเว็บอัตโนมัติ    </a>
	  <hr>
    </td>
  </tr>
</table>
<table width="94%" border="0" align="center" cellpadding="5" cellspacing="0">
  <tr> 
    <td align="left">&nbsp;<img src="../theme/main_theme/g_view.gif" width="16" height="16" align="absmiddle"> 
      ค้นหา 
        <input type="text" name="textfield">
    <input type="submit" name="Submit" value="Search"></td>
  </tr>
</table>
<table width="94%" border="0" align="center" cellpadding="5" cellspacing="1" bgcolor="#CECECE" class="ewttableuse">
  <tr bgcolor="#E7E7E7"  class="ewttablehead"> 
    <td width="10%" height="30" align="center">&nbsp;</td>
    <td >Tag Name</td>
    <td >Wrong<BR>
    Attribute Name</td>
    <td >Correct<BR>
    Attribute Name/Type</td>
    <td >Wrong<BR>
    Attribute Value</td>
    <td >Correct<BR>
    Attribute Value</td>
    <td >Recommend</td>
  </tr>
  <?php

 $sql_data = "SELECT *  FROM  value_edit_attr_tag  ORDER BY tag_name, attribute_name";
	$exec_data = $db->query($sql_data);
	while($rec_data = $db->db_fetch_array($exec_data)){
  ?>
  <tr bgcolor="#FFFFFF"> 
    <td><nobr>
     <a href="main_w3c_correct_attribute_add.php?flag=edit&edit_id=<?php echo $rec_data[edit_id];?>"> <img src="../theme/main_theme/g_edit.gif" width="16" height="16" border="0"></a>
	  <a href="#del" onClick="if(confirm('ต้องการลบ Tag <?php echo $rec_data[tag_name];?> หรือไม่?')) { window.location = 'main_w3c_correct_attribute_list.php?flag=del&edit_id=<?php echo $rec_data[edit_id];?>' } "><img src="../theme/main_theme/g_del.gif" width="16" height="16" border="0"></a></nobr></td>
    <td><?php echo $rec_data[tag_name];?></td>
    <td><?php echo html_entity_decode($rec_data[wrong_attribute], ENT_QUOTES);?></td>
    <td><?php echo $rec_data[attribute_name]; if($rec_data[attribute_name]) { echo ($rec_data[data_type]=="number")? "/ Number":"/ String"; } ?></td>
    <td><?php echo html_entity_decode($rec_data[wrong_value], ENT_QUOTES);?></td>
    <td><?php echo html_entity_decode($rec_data[correct_value], ENT_QUOTES);?></td>
    <td><?php echo html_entity_decode($rec_data[recommend], ENT_QUOTES);?><?php if($rec_data[notnull]) { echo " ( Not Null )"; } ?></td>
  </tr>
  <?php 
  
  } ?>
  <tr align="right" bgcolor="#FFFFFF"> 
    <td colspan="7" align="center">&nbsp;</td>
  </tr>
</table>
<table width="94%" border="0" align="center" cellpadding="3" cellspacing="0">
  <tr>
    <td>&nbsp;</td>
  </tr>
</table>
</body>
</html>
<?php
 $db->query("USE ".$EWT_DB_NAME);
$db->db_close(); ?>