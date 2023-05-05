<?php
include("../lib/permission1.php");
include("../lib/include.php");
include("../lib/function.php");
include("../lib/user_config.php");
include("../lib/connect.php");
$db->query("USE ".$EWT_DB_USER);

if($_POST['flag']=='add') {
	$numChk=$db->db_num_rows($db->query('SELECT gen_user_id FROM gen_user WHERE ldap_org=\''.$_POST['org_code'].'\''));
	if($numChk>0) {
		echo '<script type="text/javascript"> alert("รหัสองค์กรนี้มีการใช้งานแล้ว"); window.location.href="'.$_SERVER['HTTP_REFERER'].'"; </script>';
		exit;
	}
	$db->query("INSERT INTO gen_user(name_thai, ldap_user, ldap_org,org_id) VALUES('$_POST[name]','1','$_POST[org_code]','101')");
	$rID=$db->db_fetch_array($db->query('SELECT MAX(gen_user_id) AS mID FROM gen_user'));
	
	//$db->query("INSERT INTO web_group_member(ug_id,ugm_type,ugm_tid) VALUES('$_SESSION[EWT_SUID]','U','$rID[0]')");
	echo '<script type="text/javascript"> alert("เพิ่มข้อมูลเรียบร้อย"); self.location.href="ewt_permission_ldap.php"; </script>';
	exit;
} else if($_POST['flag']=='edit') {
	$db->query("UPDATE gen_user SET name_thai='$_POST[name]', ldap_org='$_POST[org_code]',org_id ='101' WHERE gen_user_id='$_POST[mid]'");
	echo '<script type="text/javascript"> alert("แก้ไขข้อมูลเรียบร้อย"); self.location.href="ewt_permission_ldap.php"; </script>';
	exit;
}

if($_GET['mid']=='') {
	$flag='add';
	$sm='เพิ่ม';
} else {
	$flag='edit';
	$sm='แก้ไข';
	$sql = $db->query("SELECT * FROM gen_user WHERE gen_user_id='$_GET[mid]'");
	if($db->db_num_rows($sql) > 0){
		$U = $db->db_fetch_array($sql);
	}
}
	
?>
<html>
<head>
<title><?php echo $EWT_title ?></title>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<link href="../theme/main_theme/css/style.css" rel="stylesheet" type="text/css">
<script type="text/javascript">
function frmchk() {
	if(document.getElementById('name').value=='') {
		alert("กรุณากรอกชื่อ");
		return false;
	}
	return true;
}
</script>
</head>
<body leftmargin="0" topmargin="0">
<table width="80%" border="0" align="center" cellpadding="5" cellspacing="0">
  <tr> 
    <td><img src="../theme/main_theme/logo.gif" width="32" height="32" align="absmiddle"> 
      <span class="ewtfunction"><?php echo $sm; ?>ข้อมูล</span> </td>
  </tr>
</table>
<!--table width="94%" border="0" align="center" cellpadding="0" cellspacing="0" class="ewtfunctionmenu">
  <tr>
    <td align="right">
	<?php //if($_SESSION["EWT_SMTYPE"] == "Y" && $_SESSION["EWT_SMID"] == ''){ ?><a href="#g" onClick="win4=window.open('ewt_adds_member.php?ug=<?php //echo $_GET["UID"]; ?>','usersq','width=650,height=400,scrollbars=1,resizable=1');win4.focus();"><img src="../theme/main_theme/g_add.gif" border="0" align="middle"> เพิ่มผู้ใช้งาน </a><?php //} ?>
<hr>
    </td>
  </tr>
</table-->
<form method="post" action="" onSubmit="javascript:return frmchk();">
<input type="hidden" name="flag" value="<?php echo $flag; ?>">
<input type="hidden" name="mid" value="<?php echo $_GET[mid]; ?>">
<table width="90%" border="0" align="center" class="table table-bordered">
  <tr bgcolor="#E7E7E7"  class="ewttablehead">
    <td colspan="2" align="center" >รายละเอียด</td>
  </tr>
  <tr bgcolor="#FFFFFF"> 
    <td valign="top">ชื่อ : <span style="color:#FF0000">*</span></td>
    <td valign="top"><input type="text" name="name" value="<?php echo $U['name_thai']; ?>" class="form-control" style="width:30%;"></td>
  </tr>
  <tr bgcolor="#FFFFFF"> 
    <td valign="top">รหัสองค์กร :</td>
    <td valign="top"><input type="text" name="org_code" value="<?php echo $U['ldap_org']; ?>" class="form-control" style="width:30%;"></td>
  </tr>
  <tr bgcolor="#FFFFFF"> 
    <td valign="top">&nbsp;</td>
    <td valign="top"><input type="submit" name="submit" value="<?php echo $sm; ?>"  class="btn btn-success" ></td>
  </tr>
</table>
</form>
<br>
</body>
</html>
<?php
$db->db_close(); ?>