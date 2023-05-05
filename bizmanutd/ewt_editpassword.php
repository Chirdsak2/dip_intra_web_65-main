<?php
session_start();
include("../lib/include_bizadmin.php");
include("../lib/include.php");
include("../lib/function.php");
include("../lib/ewt_config.php");
include("../lib/connect.php");
$db->query("USE ".$EWT_DB_NAME);
if($_POST[hdd_flag]=='edit'){
	$sql="select * from user_info where UID = '".$_POST[UID]."' and EWT_Pass ='".md5($_POST["pass_old"])."'";
	$query = $db->query($sql);
	if($db->db_num_rows($query)==0){
	?>
	<script language="JavaScript">
	alert("ท่านกรอกรหัสผ่านเดิมไม่ถูกต้องกรุณาตรวจสอบ!!!");
	</script>
	<?php
	exit;
	}
	$update = "update user_info set EWT_Pass = '".md5($_POST["u_pass"])."'  where UID = '".$_POST[UID]."'";
	$db->query($update);
	?>
	<script language="JavaScript">
	alert("เปลี่ยนรหัสผ่านเรียบร้อยแล้ว");
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
</head>
<body leftmargin="0" topmargin="0">
<table width="94%" border="0" align="center" cellpadding="5" cellspacing="0">
  <tr> 
    <td><span class="ewtfunction">Edit Password </span></td>
  </tr>
</table>
<table width="94%" border="0" align="center" cellpadding="0" cellspacing="0" class="ewtfunctionmenu">
  <tr>
    <td align="right">
<hr>
    </td>
  </tr>
</table>
 <form action="ewt_editpassword.php" method="post" name="form1" id="form1" onSubmit="return chk();" target="save_function_form1">
          <input name="hdd_flag" type="hidden" value="edit" /> <input name="UID" type="hidden" value="<?php echo $_GET[UID];?>" />
          <table width="94%" border="0" align="center" cellpadding="5" cellspacing="1" bgcolor="BEBEC2" class="ewttableuse">
            <tr bgcolor="#FFFFFF">
              <td bgcolor="#F5F5F5">Username</td>
              <td><?php echo $rec[EWT_User];?></td>
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
        </form> <iframe name="save_function_form1" src=""  frameborder="0"  width="1" height="1" scrolling="no" ></iframe>


<br>
</body>
</html>
<?php
$db->db_close(); ?>