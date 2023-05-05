<?php
include("administrator.php");
include("lib/include.php");
include("inc.php");
$db->write_log("view","webboard","เข้าสู่ Module Webboard กำหนดชื่อห้ามใช้ ");
?>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<link href="../theme/main_theme/css/style.css" rel="stylesheet" type="text/css">
<style type="text/css">
<!--
a:link { color: #005CA2; text-decoration: none}
a:visited { color: #005CA2; text-decoration: none}
a:active { color: #0099FF; text-decoration: none}
a:hover { color: #0099FF; text-decoration: none}
.style2 {
	color: #005CA2;
	font-weight: bold;
}
.style3 {color: #FF0000}
-->
</style>
</head>

<body leftmargin="0" topmargin="0">
<?php include("../FavoritesMgt/favorites_include.php");?>
<table width="80%" border="0" align="center" cellpadding="5" cellspacing="0">
  <tr>
    <td><img src="../theme/main_theme/logo.gif" width="32" height="32" align="absmiddle"> <span class="ewtfunction">กำหนดชื่อที่ห้ามใช้ </span> </td>
  </tr>
</table>
<table width="94%" border="0" align="center" cellpadding="0" cellspacing="0" class="ewtfunctionmenu">
  <tr>
    <td align="right"><a href="javascript:void(0);" onClick="load_divForm('../FavoritesMgt/favorites_add.php?name=<?php echo urlencode("กำหนดชื่อที่ห้ามใช้");?>&module=webboard&url=<?php echo urlencode("user_noused.php");?>', 'divForm', 300, 80, -1,433, 1);"><img src="../images/star_yellow_add.gif" width="16" height="16" border="0" align="middle">&nbsp;Add to favorites </a>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<img src="../theme/main_theme/g_add.gif" width="16" height="16" border="0" align="absmiddle"> <a href="w_name_add.php?flag=add" >เพิ่ม รายชื่อ </a> &nbsp;&nbsp;<!--<a href="index_cate.php">&nbsp;&nbsp;&nbsp;<img src="../theme/main_theme/b.gif" width="16" height="16" border="0" align="absmiddle"> Manage function</a>-->
        <hr>
    </td>
  </tr>
</table>
<table width="94%" border="0" align="center" cellpadding="5" cellspacing="1" class="ewttableuse">
  <tr class="ewttablehead">
    <td width="10%" align="center" class="MemberHead">&nbsp;</td>
    <td class="MemberHead">ชื่อ</td>
  </tr>
  <?php
  $i=1;
  $sql="select * from w_name";
  $query = $db->query($sql);
  $num = mysql_num_rows($query);
  while($rec = $db->db_fetch_array($query)){
  
  ?>
  <tr>
    <td align="left" bgcolor="#FFFFFF"><a href="w_name_add.php?flag=edit&id=<?php echo $rec[w_name_id];?>"><img src="../images/content_edit.gif" alt="แก้ไข" width="16" height="16" border="0"></a>&nbsp;&nbsp;&nbsp;&nbsp;<a href="w_name_add.php?flag=del&id=<?php echo $rec[w_name_id];?>"><img src="../images/b_delete.gif" alt="ลบ" width="14" height="14" border="0"></a></td>
    <td bgcolor="#FFFFFF"><?php echo $rec[w_name];?></td>
  </tr>
  <?php $i++; } 
  if($num==0){
  ?>
  <tr>
    <td colspan="2" align="center" bgcolor="#FFFFFF" class="MemberNormalRed">-----ไม่พบรายการ-----</td>
  </tr>
  <tr>
    <?php } ?>
    <td colspan="2" bgcolor="#FFFFFF">&nbsp;</td>
  </tr>
</table>
</body>
</html>
<?php $db->db_close(); ?>