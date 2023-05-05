<?php
include("../lib/permission1.php");
include("../lib/include.php");
include("../lib/function.php");
include("../lib/user_config.php");
include("../lib/connect.php");
$db->query("USE ".$EWT_DB_USER);

if($_GET['flag']=='del') {
	$db->query('DELETE FROM gen_user WHERE gen_user_id=\''.$_GET['mid'].'\' AND ldap_user=\'1\'');
	$db->query('DELETE FROM web_group_member WHERE ugm_tid=\''.$_GET['mid'].'\' ');
	$db->query('DELETE FROM permission WHERE UID=\''.$_GET['mid'].'\' ');
	echo '<script type="text/javascript"> self.location.href="ewt_permission_ldap.php"; </script>';
	exit;
}
	$sql = $db->query("SELECT * FROM gen_user WHERE ldap_user='1' ORDER BY name_thai ASC");
	
?>
<html>
<head>
<title><?php echo $EWT_title ?></title>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<link href="../theme/main_theme/css/style.css" rel="stylesheet" type="text/css">
</head>
<body leftmargin="0" topmargin="0">
<table width="80%" border="0" align="center" cellpadding="5" cellspacing="0">
  <tr> 
    <td><img src="../theme/main_theme/logo.gif" width="32" height="32" align="absmiddle"> 
      <span class="ewtfunction">รายชื่อกลุ่ม</span> </td>
  </tr>
</table>
<table width="90%" border="0" align="center" cellpadding="0" cellspacing="0" class="ewtfunctionmenu">
  <tr>
    <td align="right">
	<?php if($_SESSION["EWT_SMTYPE"] == "Y" && $_SESSION["EWT_SMID"] == ''){ ?><a href="ewt_add_ldap.php"><img src="../theme/main_theme/g_add.gif" border="0" align="middle"> เพิ่มผู้ใช้งาน </a><?php } ?>
<hr>
    </td>
  </tr>
</table>
<table width="90%" border="0" align="center" class="table table-bordered">
  <tr bgcolor="#E7E7E7"  class="ewttablehead"> 
    <td width="5%" height="30" align="center">&nbsp;</td>
    <td width="49%" >ชื่อกลุ่ม</td>
  </tr>
  <?php
 $i=0;
 if($db->db_num_rows($sql) > 0){
  while($U = $db->db_fetch_array($sql)){
 if($_SESSION["EWT_SMID"] != ""){
  $U["ugm_tid"] = $U["under_id"];
  $U["ugm_type"] = "U";
  $U["ugm_id"] = "";
  }
  ?>
  <tr bgcolor="#FFFFFF"> 
    <td align="center" valign="top"><nobr><a href="ewt_add_ldap.php?mid=<?php echo $U["gen_user_id"]; ?>"><img src="../theme/main_theme/g_edit.gif" width="16" height="16" border="0" title="กำหนดสิทธิ์"></a>&nbsp;
	<a href="#" onClick="if(confirm('ยืนยันการลบ?')) { window.location.href='ewt_permission_ldap.php?mid=<?php echo $U["gen_user_id"]; ?>&flag=del'; }"><img src="../theme/main_theme/g_garbage.png" width="16" height="16" border="0" title="ลบ"></a></nobr></td>
    <td valign="top"> 
      <?php //level_name($U["ugm_type"],$U["ugm_tid"]);
	echo $U['name_thai'];
	  ?>
    </td>
  </tr>
  <?php }}else{ ?>
  <tr bgcolor="#FFFFFF"> 
    <td height="30" colspan="2" align="center"><font color="#FF0000">ไม่มีข้อมูล</font></td>
  </tr>
  <?php } ?>
</table>
<br>
</body>
</html>
<?php
$db->db_close(); ?>