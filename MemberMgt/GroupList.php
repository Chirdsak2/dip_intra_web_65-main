<?php
include("../lib/permission1.php");
include("../lib/include.php");
include("../lib/function.php");
include("../lib/user_config.php");
include("../lib/connect.php");
$db->query("USE ".$EWT_DB_USER);
	if($cmd == "del"){
	$sql_chk = "select * from gen_user where emp_type_id ='$group_id' ";
	$query = $db->query($sql_chk);
	if($db->db_num_rows($query)==0){
			$sql = $db->query("delete from emp_type WHERE emp_type_id LIKE '".$group_id."'");
			echo "<script language=\"javascript\">";
			echo "alert('ลบข้อมูลเรียบร้อยแล้ว');";
			echo "document.location.href='GroupList.php'";
			echo "</script>";
		}else{
			echo "<script language=\"javascript\">";
			echo "alert('กลุ่มนี้ไม่สามารถลบได้เนื่องจากมีคนที่เป็นสมาชิกกลุ่มอยู่!!!!!!!!!!');";
			echo "document.location.href='GroupList.php'";
			echo "</script>";
		}
		$rec = $db->db_fetch_array($query);
		$db->query("USE ".$_SESSION["EWT_SDB"]);
		$db->write_log("delete","member","ลบกลุ่มบุคคลภายนอก : ".$rec['emp_type_name']);
		$db->query("USE ".$EWT_DB_USER);
	}
?>
<html>
<head>
<title><?php echo $EWT_title ?></title>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<link href="../theme/main_theme/css/style.css" rel="stylesheet" type="text/css">
</head>
<body leftmargin="0" topmargin="0">
<?php include("../FavoritesMgt/favorites_include.php");?>
<table width="80%" border="0" align="center" cellpadding="5" cellspacing="0">
  <tr> 
    <td><img src="../theme/main_theme/logo.gif" width="32" height="32" align="absmiddle"> 
      <span class="ewtfunction">ตั้งกลุ่มสมาชิก</span> </td>
  </tr>
</table>
<table width="94%" border="0" align="center" cellpadding="0" cellspacing="0" class="ewtfunctionmenu">
  <tr>
    <td align="right"><a href="javascript:void(0);" onClick="load_divForm('../FavoritesMgt/favorites_add.php?name=<?php echo urlencode("ตั้งกลุ่มสมาชิก");?>&module=member&url=<?php echo urlencode("GroupList.php");?>', 'divForm', 300, 80, -1,433, 1);"><img src="../images/star_yellow_add.gif" width="16" height="16" border="0" align="middle">&nbsp;Add to favorites </a>&nbsp;&nbsp;&nbsp;&nbsp; <a href="GroupAdd.php?cmd=add"><img border="0" src="../theme/main_theme/g_add.gif" width="16" height="16" align="absmiddle"> 
     เพิ่มกลุ่มบุคคลภายนอก</a> 
      <hr>
    </td>
  </tr>
</table>
<table width="94%" border="0" align="center" cellpadding="3" cellspacing="1" class="ewttableuse" style="border-collapse:collapse">
                <tr class="ewttablehead">
				<td width="15%" align="center" >&nbsp;</td>
                  <td height="20" align="left" >&nbsp;ชื่อกลุ่มบุคคลภายนอก</td>
                </tr>
				<?php
				$sql = "select * from emp_type where emp_type_status = '4' order by emp_type_name ASC";
				$query = $db->query($sql);
				while($rec = $db->db_fetch_array($query)){
				?>
                <tr >
				 <td align="center" bgcolor="#FFFFFF" valign="top">
				  <a href="GroupAdd.php?cmd=edit&group_id=<?php echo $rec[emp_type_id];?>"><img src="../theme/main_theme/g_edit.gif" width="16" height="16" border="0" style="cursor:pointer"  title="แก้ไขข้อมูล"/></a>&nbsp;
				 <a href="GroupList.php?cmd=del&group_id=<?php echo $rec[emp_type_id];?>"><img src="../theme/main_theme/g_del.gif" width="16" height="16" border="0" style="cursor:pointer" title="ลบข้อมูล" onClick="return confirm('ต้องการลบข้อมูลหรือไม่');"/></a>&nbsp;
				  </td>
                <td height="20" align="left" bgcolor="#FFFFFF"><?php echo $rec[emp_type_name];?></tr>
             <?php } 
			 if(mysql_num_rows($query) == 0){
			 ?>
                <tr>
                  <td height="50" colspan="2" align="center" bgcolor="#FFFFFF">ไม่มีข้อมูล</td>
                </tr>
				<?php } ?>
</table>
</body>
</html>
<?php

$db->db_close(); ?>