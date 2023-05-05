<?php
session_start();
include("../lib/include_bizadmin.php");
include("../lib/include.php");
include("../lib/function.php");
include("../lib/ewt_config.php");
include("../lib/connect.php");
$db->query("USE ".$EWT_DB_NAME);
if($_POST[hdd_flag]=='setting'){
	
	$update = "update user_info set login_ldap = '".$_POST["chk_ldap"]."' ,login_ldap_ip='".$_POST["txt_ldap"]."',login_openid='".$_POST["chk_operid"]."' where UID = '".$_POST[UID]."'";
	$db->query($update);
	?>
	<script language="JavaScript">
	alert("บันทึกเรียบร้อยแล้ว");
	self.parent.close();
	</script>
	<?php
	exit;
}
$sql = "select * from user_info where UID = '".$_GET[UID]."'";
$query = $db->query($sql);
$rec = $db->db_fetch_array($query);
?>
<html>
<head>
<title><?php echo $EWT_title ?></title>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<link href="../theme/main_theme/css/style.css" rel="stylesheet" type="text/css">
<script language="JavaScript">
	function chk(){
		var c = document.form1;
		if(c.chk_ldap.checked == true){
			if(c.txt_ldap.value ==''){
			alert("Please input your ตั้งค่า IP LDAP !!!");
			c.txt_ldap.focus();
			return false;
			}
		}
	
	}
</script>
</head>
<body leftmargin="0" topmargin="0">
<table width="94%" border="0" align="center" cellpadding="5" cellspacing="0">
  <tr> 
    <td><span class="ewtfunction">Config Login</span></td>
  </tr>
</table>
<table width="94%" border="0" align="center" cellpadding="0" cellspacing="0" class="ewtfunctionmenu">
  <tr>
    <td align="right">
<hr>
    </td>
  </tr>
</table>
 <form action="ewt_configlogin.php" method="post" name="form1" id="form1" onSubmit="return chk();" target="save_function_form1">
          <input name="hdd_flag" type="hidden" value="setting" /> <input name="UID" type="hidden" value="<?php echo $_GET[UID];?>" />
          <table width="66%" border="0" align="center" cellpadding="0" cellspacing="0">
  <tr>
    <td width="6%" align="right"><input name="chk_ldap" type="checkbox" id="chk_ldap" value="Y" <?php if($rec["login_ldap"]=='Y'){ echo 'checked';}?>></td>
    <td width="94%">&nbsp;Use LDAP </td>
  </tr>
  <tr>
    <td width="6%" align="right">&nbsp;</td>
    <td>ตั้งค่า IP LDAP :
      <input name="txt_ldap" type="text" id="txt_ldap" value="<?php echo $rec["login_ldap_ip"];?>">
      &nbsp;ex. 192.168.0.255 </td>
  </tr>
  <tr>
    <td colspan="2" align="right"><hr></td>
    </tr>
  <tr>
    <td align="right"><input name="chk_operid" type="checkbox" id="chk_operid" value="Y" <?php if($rec["login_openid"]=='Y'){ echo 'checked';}?>></td>
    <td>๊&nbsp;Use OpenID </td>
  </tr>
  <tr>
    <td align="right">&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td><input type="submit" name="Submit" value="บันทึก"></td>
  </tr>
</table>

</form> <iframe name="save_function_form1" src=""  frameborder="0"  width="1" height="1" scrolling="no" ></iframe>


<br>
</body>
</html>
<?php
$db->db_close(); ?>