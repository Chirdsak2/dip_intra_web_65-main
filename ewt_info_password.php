<?php
include("lib/permission.php");
include("lib/include.php");
include("lib/function.php");
include("lib/user_config.php");
include("lib/connect.php");

$db->query("USE ".$EWT_DB_USER);
if($_POST[hdd_flag]=='edit'){
	$sql="select * from user_info where UID = '".$_SESSION["EWT_SUID"]."' and EWT_Pass ='".md5($_POST["pass_old"])."'";
	$query = $db->query($sql);
	if($db->db_num_rows($query)==0){
	?>
	<script language="JavaScript">
	alert("ท่านกรอกรหัสผ่านเดิมไม่ถูกต้องกรุณาตรวจสอบ!!!");
	</script>
	<?php
	exit;
	}
	$update = "update user_info set EWT_Pass = '".md5($_POST["u_pass"])."'  where UID = '".$_SESSION["EWT_SUID"]."'";
	$db->query($update);
	?>
	<script language="JavaScript">
	alert("เปลี่ยนรหัสผ่านเรียบร้อยแล้ว");
	self.parent.location.href= "ewt_info_password.php";
	</script>
	<?php
	exit;
}
$db->query("USE ".$EWT_DB_NAME);
	?>
<html>
<head>
<title><?php echo $EWT_title ?></title>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<link href="theme/main_theme/css/style.css" rel="stylesheet" type="text/css">
<script language="javascript" src="js/functions.js"></script>
<script language="JavaScript">
	function chk(){
		var c = document.form1;
		if(c.pass_old.value == ""){
			alert("Please input your password old !!!");
			c.pass_old.focus();
			return false;
		}
		if(c.u_pass.value == ""){
			alert("Please input your password!!!");
			c.u_pass.focus();
			return false;
		}
		if(c.c_pass.value == ""){
			alert("Please confirm your password!!!");
			c.c_pass.focus();
			return false;
		}
		if(c.c_pass.value != c.u_pass.value){
			alert("Confirm  password not correct!!!");
			c.c_pass.select();
			return false;
		}
	}
</script>
<style type="text/css">
<!--
.style1 {
	color: #FF0000;
	font-size: 9px;
}
-->
</style>
</head>
<body leftmargin="0" topmargin="0">
<table width="100%" height="100%" border="0" cellpadding="0" cellspacing="0" bgcolor="BEBEC2">
  <tr>
    <td height="1" bgcolor="AAAAAA"></td>
  </tr>
  <tr>
    <td height="1" bgcolor="716F64"></td>
  </tr>
  <tr>
    <td height="10" bgcolor="#FFFFFF"></td>
  </tr>
  <tr>
    <td height="30" bgcolor="#FFFFFF"><table width="80%" border="0" align="center" cellpadding="5" cellspacing="0">
      <tr>
        <td><img src="theme/main_theme/site_function_property.gif" width="32" height="32" align="absmiddle" /><span class="ewtfunction">Edit password </span> </td>
      </tr>
    </table>
        <table width="94%" border="0" align="center" cellpadding="0" cellspacing="0" class="ewtfunctionmenu">
          <tr>
            <td align="right">&nbsp;
                <hr />            </td>
          </tr>
      </table></td>
  </tr>
  <tr>
    <td valign="top" bgcolor="#FFFFFF"><br />
        <form action="ewt_info_password.php" method="post" name="form1" id="form1" onSubmit="return chk();" target="save_function_form1">
          <input name="hdd_flag" type="hidden" value="edit" />
          <table width="94%" border="0" align="center" cellpadding="5" cellspacing="1" bgcolor="BEBEC2" class="ewttableuse">
            <tr bgcolor="#FFFFFF">
              <td bgcolor="#F5F5F5">Username</td>
              <td><?php echo $_SESSION["EWT_SUSER"]; ?></td>
            <!--</tr>
            <tr bgcolor="#FFFFFF">
              <td bgcolor="#F5F5F5">E-mail</td>
              <td><input name="txt_email" type="text" id="txt_email" size="30" value="<?php//php echo $rec_user[email];?>" /> 
                &nbsp;<span class="style1">*</span>ตั้งค่าำหรับผู้ดูแลเว็บไซต์</td>
            </tr>-->
            <tr bgcolor="#FFFFFF">
              <td width="46%" bgcolor="#F5F5F5">Password old </td>
              <td width="54%"><input name="pass_old" type="password" id="pass_old" size="30" />              </td>
            </tr>
            <tr bgcolor="#FFFFFF">
              <td bgcolor="#F5F5F5">Password new </td>
              <td><input name="u_pass" type="password" id="u_pass" size="30" /></td>
            </tr>
            <tr bgcolor="#FFFFFF">
              <td bgcolor="#F5F5F5">Comfirm password new </td>
              <td><input name="c_pass" type="password" id="c_pass" size="30" /></td>
            </tr>
            <tr bgcolor="#FFFFFF">
              <td bgcolor="#F5F5F5">&nbsp;</td>
              <td><input type="submit" name="Submit" value="Submit" /></td>
            </tr>
          </table>
        </form> <iframe name="save_function_form1" src=""  frameborder="0"  width="1" height="1" scrolling="no" ></iframe></td>
  </tr>
  <!--<tr> 
    <td height="30" background="images/i_bg.gif" bgcolor="#FFFFFF"><strong><img src="images/arrow_r.gif" width="7" height="7" align="absmiddle"> Ftp Setting</strong></td>
  </tr>
  <tr>
    <td valign="top" bgcolor="#FFFFFF"><form name="form2" method="post" action="ewt_info_function.php"><br>
	<input name="hdd_site_info_id" type="hidden" value="<?php//php echo $rec[site_info_id]?>">
	  <input name="hdd_flag" type="hidden" value="ftp_setting">
        <table width="90%" border="0" align="center" cellpadding="3" cellspacing="1" bgcolor="BEBEC2">
          <tr bgcolor="#FFFFFF">
            <td width="46%" bgcolor="#F5F5F5">Host</td>
            <td width="54%"><input name="txt_host" type="text" id="txt_host" value="<?php//php echo $rec[site_info_host]?>"></td>
          </tr>
          <tr bgcolor="#FFFFFF">
            <td bgcolor="#F5F5F5">Username</td>
            <td><input name="txt_user" type="text" id="txt_user" value="<?php//php echo $rec[site_info_user]?>"></td>
          </tr>
          <tr bgcolor="#FFFFFF">
            <td bgcolor="#F5F5F5">Password</td>
            <td><input name="txt_pass" type="password" id="txt_pass" value="<?php//php echo $rec[site_info_pass]?>"></td>
          </tr>
          <tr bgcolor="#FFFFFF">
            <td bgcolor="#F5F5F5">Path</td>
            <td><input name="txt_path" type="text" id="txt_path" value="<?php//php echo $rec[site_info_path]?>" size="30"></td>
          </tr>
          <tr bgcolor="#FFFFFF">
            <td bgcolor="#F5F5F5">&nbsp;</td>
            <td><input type="submit" name="Submit2" value="Submit">
                <input type="reset" name="Submit2" value="Reset"></td>
          </tr>
        </table>
      </form>   </td>
  </tr>-->
</table>
</body>
</html>
<?php
$db->db_close(); ?>
