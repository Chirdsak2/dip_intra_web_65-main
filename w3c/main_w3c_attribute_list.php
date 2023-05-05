<?php
include("../lib/permission1.php");
include("../lib/include.php");
include("../lib/function.php");
include("../lib/user_config.php");
include("../lib/connect.php");
  //webpage_info check data for w3c
  $db->query("USE ".$EWT_DB_W3C);
if($_GET[flag]=='del'){
	$DELETE = $db->query(" DELETE FROM  value_attrbute_tag WHERE v_id = '".$_GET[v_id]."' ");
?>
									<script type="text/javascript">
									alert('ลบข้อมูลเรียบร้อยแล้ว');					
									self.location.href = 'main_w3c_attribute_list.php';
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
      <span class="ewtfunction">การจัดการข้อมูล Attribute</span> </td>
  </tr>
</table>
<table width="94%" border="0" align="center" cellpadding="0" cellspacing="0" class="ewtfunctionmenu">
  <tr>
    <td align="right">
	  <a href="main_w3c_attribute_add.php"><img src="../theme/main_theme/g_add.gif" width="16" height="16" border="0" align="absmiddle"> เพิ่ม Attribute</a>
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
    <td >Attribute Name</td>
    <td >Attribute Value</td>
  </tr>
  <?php

 $sql_data = "SELECT v_id,tag_name, attribute_name,possible_value  FROM  value_attrbute_tag  ORDER BY tag_name, attribute_name";
	$exec_data = $db->query($sql_data);
	while($rec_data = $db->db_fetch_array($exec_data)){
  ?>
  <tr bgcolor="#FFFFFF"> 
    <td><nobr>
     <a href="main_w3c_attribute_add.php?flag=edit&v_id=<?php echo $rec_data[v_id];?>"> <img src="../theme/main_theme/g_edit.gif" width="16" height="16" border="0"></a>
	  <a href="#del" onClick="if(confirm('ต้องการลบ Tag <?php echo $rec_data[tag_name];?> หรือไม่?')) { window.location = 'main_w3c_attribute_list.php?flag=del&v_id=<?php echo $rec_data[v_id];?>' } "><img src="../theme/main_theme/g_del.gif" width="16" height="16" border="0"></a></nobr></td>
    <td><?php echo $rec_data[tag_name];?></td>
    <td><?php echo $rec_data[attribute_name];?></td>
    <td><?php echo $rec_data[possible_value];?></td>
  </tr>
  <?php 
  
  } ?>
  <tr align="right" bgcolor="#FFFFFF"> 
    <td colspan="4" align="center">&nbsp;</td>
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