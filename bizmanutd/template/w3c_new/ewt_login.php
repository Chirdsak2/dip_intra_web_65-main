<?php
$path = "../";
	session_start();
	include($path."lib/function.php");
	include($path."lib/user_config.php");
	include($path."lib/connect.php");
	include($path."lib/connect_uncheck.php");
if($_POST["Flag"] == "forgot"){
	$sql_chk="select * from gen_user where email_person='$member_email' AND status = '1'";
	$query_chk=mysql_query($sql_chk);
	$num_rows=mysql_num_rows($query_chk);
	if($num_rows>0){

$R = $db->db_fetch_array($query_chk);
$body = "<div align=\"center\"><font color=\"#005CA2\" size=\"3\" face=\"Tahoma\"><strong>ข้อมูล Username & Password</strong></font>
</div>
<table width=\"400\" border=\"0\" align=\"center\" cellpadding=\"5\" cellspacing=\"1\" bgcolor=\"#005CA2\">
  <tr bgcolor=\"#005CA2\">
    <td colspan=\"2\"><font color=\"#FFFFFF\" size=\"2\" face=\"MS Sans Serif, Tahoma, sans-serif\"><strong>ข้อมูลส่วนตัว</strong></font></td>
  </tr>
  <tr bgcolor=\"#FFFFFF\">
    <td><strong><font color=\"#FF6600\" size=\"1\" face=\"MS Sans Serif, Tahoma, sans-serif\">ชื่อ-นามสกุล</font></strong></td>
    <td><font size=\"1\" face=\"MS Sans Serif, Tahoma, sans-serif\">คุณ".$R[name_thai]." ".$R[surname_thai]."</font></td>
  </tr>
  <tr bgcolor=\"#FFFFFF\">
    <td><strong><font color=\"#FF6600\" size=\"1\" face=\"MS Sans Serif, Tahoma, sans-serif\">อีเมล์</font></strong></td>
    <td><font size=\"1\" face=\"MS Sans Serif, Tahoma, sans-serif\">".$R[email_person]."</font></td>
  </tr>
  <tr bgcolor=\"#FFFFFF\">
    <td><strong><font color=\"#FF6600\" size=\"1\" face=\"MS Sans Serif, Tahoma, sans-serif\">ชื่อล็อกอิน</font></strong></td>
    <td><font size=\"1\" face=\"MS Sans Serif, Tahoma, sans-serif\">".$R[gen_user]."</font></td>
  </tr>
  <tr bgcolor=\"#FFFFFF\">
    <td><strong><font color=\"#FF6600\" size=\"1\" face=\"MS Sans Serif, Tahoma, sans-serif\">รหัสผ่าน</font></strong></td>
    <td><font size=\"1\" face=\"MS Sans Serif, Tahoma, sans-serif\">".$R[gen_pass]."</font></td>
  </tr>
</table>
";

	include($path."lib/libmail.php");
$m = new Mail();
$m->From("EWT Administrator<support@bizpotential.com>");
$m->Subject("ข้อมูล Username-Password");
$m->Body($body,"text/html");
$m->To(trim($R[email_person]));
$m->Send();
?>
<script language="JavaScript">
	alert("ระบบส่งข้อมูลของท่านไปทาง <?php echo $R[email_person]; ?> แล้ว");
	self.location.href = "main.php?filename=index";
</script>
	<?php
		exit;
	}else{
		print "<script>alert('Emailนี้ไม่มีในฐานข้อมูล กรุณากรอกใหม่'); window.location.href='member_forgot.php';</script>";
exit;
	}

}elseif($_POST["Flag"] == "AcceptLogin"){

	if(trim($_POST["ewt_user1"]) != "" AND trim($_POST["ewt_pass1"]) != ""){
		$sql_login = $db->query("SELECT * FROM gen_user WHERE gen_user = '".trim($_POST["ewt_user1"])."' AND  gen_pass = '".trim($_POST["ewt_pass1"])."'  ");
		$row = $db->db_num_rows($sql_login);
		if($row > 0){
		$M = $db->db_fetch_array($sql_login);
		if($M[status] != "1"){
				?>
		<script language="JavaScript">
			alert("คุณยังไม่ได้ยืนยันการลงทะเบียน!!!");
			//self.location.href = "ewt_login.php?fn=<?php//=$_POST[fn]?>";
			<?php if($_POST[fn] == ''){?>
			self.location.href = "ewt_login.php?fn=main.php?filename=index";
			<?php } else {?>
			self.location.href = "<?php echo $_POST[fn]?>";
			<?php } ?>
			</script>
		<?php
		exit;
		}else{
		session_register("EWT_MID");
		session_register("EWT_ORG");
		session_register("EWT_NAME");
		session_register("EWT_LEVEL");
		session_register("EWT_IMG");
		session_register("EWT_MAIL");
		session_register("EWT_USERNAME");
		$_SESSION["EWT_MID"] = $M["gen_user_id"];
		$_SESSION["EWT_ORG"] = $M["org_id"];
		$_SESSION["EWT_NAME"] = $M["name_thai"]." ".$M["surname_thai"];
		$_SESSION["EWT_LEVEL"] = $M["level_id"];
		$_SESSION["EWT_TYPE_ID"] = $M["emp_type_id"];
		$_SESSION["EWT_IMG"] = $M["path_image"];
		$_SESSION["EWT_MAIL"] = $M["email_person"];
		$_SESSION["EWT_FIGN"] = $M["fign"];
		$_SESSION["EWT_USERNAME"] = $M["gen_user"];
		if($_POST[fn] == ""){
		?>
		<script language="JavaScript">
		//	self.location.href = "ewt_mysite.php";
				self.location.href = "index.php";
				//self.location.href = "main.php?filename=index";
			</script>
		<?php
		}else{
		?>
				<script language="JavaScript">
		//	self.location.href = "<?php echo $_POST[fn]?>";
				self.location.href = "index.php";
				//self.location.href = "main.php?filename=index";
			</script>
		<?php
		}
		exit;
		}
		}else{
		?>
		<script language="JavaScript">
			alert("Username or pasword not correct!!!");
			<?php if($_POST[fn] == ''){?>
			self.location.href = "ewt_login.php?fn=main.php?filename=index";
			<?php } else {?>
			self.location.href = "<?php echo $_POST[fn]?>";
			<?php } ?>
			</script>
		<?php
		exit;
		}
	}


}else{

	?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html lang="th">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<title>Login</title>
<style type="text/css">
<!--
BODY {
	FONT-SIZE: 11px; MARGIN: 0px; COLOR: #000000; FONT-FAMILY: "Tahoma"
}
.copyright {
	COLOR: #e1e1e1
}
A:link {
	COLOR: #000000; TEXT-DECORATION: none
}
A:visited {
	COLOR: #000000; TEXT-DECORATION: none
}
A:active {
	COLOR: #000000; TEXT-DECORATION: none
}
A:hover {
	COLOR: #000000; TEXT-DECORATION: none
}
.mytext_normal {
	FONT: 11px "Tahoma"
}
.myhead {
	FONT: 23px "Tahoma"
}
INPUT {
	FONT-WEIGHT: normal; FONT-SIZE: 11px; COLOR: #000000; FONT-FAMILY: "Tahoma"
}
TEXTAREA {
	FONT-WEIGHT: normal; FONT-SIZE: 11px; COLOR: #000000; FONT-FAMILY: "Tahoma"
}
TABLE {
	FONT: 11px "Tahoma"
}
SELECT {
	FONT: 11px "Tahoma"
}
-->
</style>
</head>
<body >
<table width="100%" border="0" cellpadding="0" cellspacing="0">
  <tr> 
    <td  align="center" valign="top"><table width="800"  border="0" cellpadding="0" cellspacing="0">
        <tr> 
          <td width="5" ></td>
          <td align="center" valign="top" bgcolor="E3E6EB"><table width="770"  border="0" align="center" cellpadding="2" cellspacing="1" bgcolor="B4BDC7">
              <tr> 
                <td valign="top" bgcolor="#FFFFFF"><br>
                  <table width="90%" border="0" align="center" cellpadding="10" cellspacing="1" bgcolor="#A9A9E0">
                    <tr>
                      <td bgcolor="#DBDBF2"><font size="4" face="Tahoma"><strong><font color="#666666"><a href="main.php?filename=index">กลับหน้าหลัก</a> &gt;&gt; เข้าสู่ระบบ</font></strong></font></td>
                    </tr>
                  </table><br>
<br>
  <form name="form_loginm" method="post" action="" onSubmit="return chk();">
  <table width="400" border="0" align="center" cellpadding="3" cellspacing="1" bgcolor="#7D87FB">

    <tr bgcolor="#ABB1FC"> 
                        <td colspan="2" bgcolor="#ABB1FC"><strong>เข้าสู่ระบบ</strong></td>
    </tr>
    <tr bgcolor="#FFFFFF"> 
      <td width="137">ชื่อผู้ใช้ :</td>
      <td width="248"><input name="ewt_user1" type="text" id="ewt_user1" size="10"></td>
    </tr>
    <tr bgcolor="#FFFFFF"> 
      <td>รหัสผ่าน :</td>
      <td><input name="ewt_pass1" type="password" id="ewt_pass1" size="10"></td>
    </tr>
    <tr bgcolor="#FFFFFF"> 
      <td>&nbsp;</td>
      <td><input type="submit" name="Submit" value="ตกลง"> <input type="reset" name="Submit2" value="ตั่งค่าใหม่">
       <?php if($intra[0] == "Y"){ ?> 
	   	<input type="button" name="register" value="ลงทะเบียน" onClick="location.href = 'frm_gen_user.php';">
		<input type="button" name="register" value="ลืมรหัสผ่าน" onClick="window.open('member_forgot.php','','width=350,height=120');">
		<?php } ?>
        <input name="Flag" type="hidden" id="Flag" value="AcceptLogin">
        <input name="fn" type="hidden" id="Flag2" value="<?php echo ($_GET[fn])?$_GET[fn]:$_POST[fn]?>">
		</td>
    </tr>

</table>
  </form>
  <a href="http://validator.w3.org/check?uri=referer"><img src="../w3c/checked/images/w3c_gold.bmp" alt="Valid HTML 4.01 Transitional" height="31" width="88" border="0"></a><?php  include("ewt_span.php");?>
<script language="JavaScript" type="text/javascript">
function chk(){
	if(document.form_loginm.ewt_user1.value == ""){
			alert("Please input username");
			document.form_loginm.ewt_user1.focus();
			return false;
	}
		if(document.form_loginm.ewt_pass1.value == ""){
			alert("Please input password");
			document.form_loginm.ewt_pass1.focus();
			return false;
	}
		
}
</script>
                  
                </td>
              </tr>
            </table></td>
          <td width="5" ></td>
        </tr>
      </table></td>
  </tr>
</table>
</body>
</html>
<?php } ?>
<?php $db->db_close(); ?>
