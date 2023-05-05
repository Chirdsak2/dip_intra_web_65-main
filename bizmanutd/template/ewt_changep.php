<?php
include("lib/function.php");
include("lib/user_config.php");
include("lib/connect.php");
if($_SESSION["EWT_MID"] != ""){

if($_POST["Flag"] == "ChangeP"){

$db->query("USE ".$EWT_DB_NAME);

$passW = stripslashes(htmlspecialchars($_POST["pass_new"],ENT_QUOTES));

$sql = "SELECT gen_user_id FROM gen_user WHERE gen_pass = '".$passW."' AND gen_user_id = '".$_SESSION["EWT_MID"]."' ";
$query = $db->query($sql);
	if($db->db_num_rows($query) > 0){
		
		?>
		<script language="javascript">
		alert("คุณใช้รหัสผ่านชุดเดิม กรุณาเปลี่ยนใหม่!!!");
			top.location.href = "ewt_changep.php";
		</script>
		<?php
			exit;
	}

$sql2 = "UPDATE gen_user SET gen_pass = '".$passW."' WHERE gen_user_id = '".$_SESSION["EWT_MID"]."' ";
$query2 = $db->query($sql2);
		
		?>
		<script language="javascript">
		alert("เปลี่ยนรหัสผ่านเรียบร้อยแล้ว");
			top.location.href = "main.php?filename=index";
		</script>
		<?php
			exit;

}

	?>
<html>
<head>
<title><?php echo $EWT_title ?></title>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<link href="css/style.css" rel="stylesheet" type="text/css">
<script type="text/javascript" language="JavaScript">
function chked(){
	if(document.form1.pass_new.value == ""){
		alert("กรุณาใส่รหัสผ่านให้ครบถ้วน");
		document.form1.pass_new.focus();
		return false;
	}
		if(document.form1.cpass_new.value == ""){
		alert("กรุณายืนยันรหัสผ่าน");
		document.form1.cpass_new.focus();
		return false;
	}
	if(document.form1.cpass_new.value != document.form1.pass_new.value){
		alert("รหัสผ่านไม่ตรงกัน");
		document.form1.cpass_new.select();
		return false;
	}
}
</script>
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
    <td height="30" bgcolor="#FFCCFF"><strong><img src="mainpic/arrow_r.gif" width="7" height="7" align="absmiddle"> เปลี่ยนรหัสผ่าน
      </strong></td>
  </tr>
  <tr> 
    <td align="center" valign="top" bgcolor="#FFFFFF"><p>&nbsp;</p>
      <p><font color="#FF0000" size="4"><strong>เนื่องจากชื่อล็อกอินและรหัสผ่านของท่านตรงกัน<br>
เพื่อป้องกันบุคคลอื่นนำ Account ของท่านมาใช้งาน ท่านจะต้องทำการเปลี่ยนรหัสผ่านก่อนเข้าสู่ระบบ</strong></font><br>
      </p>
      <form name="form1" method="post" action="ewt_changep.php" onSubmit="return chked();">
        <table width="80%" border="0" align="center" cellpadding="3" cellspacing="1" bgcolor="BEBEC2">
          <tr bgcolor="#FFFFFF"> 
            <td width="46%" bgcolor="#F5F5F5">ชื่อล็อกอิน</td>
            <td width="54%"><?php echo $_SESSION["EWT_UNAME"]; ?> </td>
          </tr>
          <tr bgcolor="#FFFFFF"> 
            <td bgcolor="#F5F5F5">รหัสผ่าน</td>
            <td><input name="pass_new" type="password" id="pass_new" size="30"></td>
          </tr>
          <tr bgcolor="#FFFFFF"> 
            <td bgcolor="#F5F5F5">ยืนยันรหัสผ่าน</td>
            <td><input name="cpass_new" type="password" id="cpass_new" size="30"></td>
          </tr>
          <tr bgcolor="#FFFFFF"> 
            <td bgcolor="#F5F5F5">&nbsp;</td>
            <td><input type="submit" name="Submit" value="Submit"> <input type="reset" name="Submit2" value="Reset">
              <input name="Flag" type="hidden" id="Flag" value="ChangeP"></td>
          </tr>
        </table>
      </form> <br>
    </td>
  </tr>
</table>
</body>
</html>
<?php } $db->db_close(); ?>