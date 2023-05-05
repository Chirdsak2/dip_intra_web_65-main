<?php
session_start();
//session_destroy();
include("lib/function.php");
include("lib/user_config.php");
include("lib/connect_uncheck.php");
	
	//============================================================
	$filename=checkPttVar($filename);
	$_GET["filename"]=checkPttVar($_GET["filename"]);
	$_POST["filename"]=checkPttVar($_POST["filename"]);
	$_REQUEST["filename"]=checkPttVar($_REQUEST["filename"]);
	
	$ewt_user1=checkPttVar($ewt_user1);
	$_GET["ewt_user1"]=checkPttVar($_GET["ewt_user1"]);
	$_POST["ewt_user1"]=checkPttVar($_POST["ewt_user1"]);
	
	if($fn){
		$fn=checkPttVar($fn);
	}
	if($_GET[fn]){
		$_GET[fn]=checkPttVar($_GET[fn]);
	}
	if($_POST[fn]){
		$_POST[fn]=checkPttVar($_POST[fn]);
	}
	
	if($member_email){ $member_email=checkMails($member_email);}
	if($_GET["member_email"]){ $_GET["member_email"]=checkMails($_GET["member_email"]); }
	if($_POST["member_email"]){ $_POST["member_email"]=checkMails($_POST["member_email"]); }
	
	$EWT_User = mysql_escape_string($EWT_User);
	$EWT_Password = mysql_escape_string($EWT_Password);
	//============================================================
function ldap_detail($ip,$user,$pass){
//user for search data of user by CN=prdweb because user not permisstion search
	$ldap_server = $ip;
	$base_dn ="dc=prd,dc=go,dc=th";// "dc=prd,dc=go,dc=th";
	/////////////////////
	$auth_user ='cn=prdweb';
	$auth_pass ='prdweb$y$tem';
	
	if (!($connect=ldap_connect($ldap_server))) {
		die("Could not connect to ldap server");
	}
	ldap_set_option($connect, LDAP_OPT_PROTOCOL_VERSION, 3);
	ldap_set_option($connect, LDAP_OPT_REFERRALS, 0);
	// bind to server
	if (!($bind=@ldap_bind($connect,"$auth_user,$base_dn",$auth_pass))) {
		//die(ldap_error($connect));
	} else {
		$filter = "uid=$user";
		if (!($search=ldap_search($connect,$base_dn, $filter))) {
			//die(ldap_error($connect));
		}
		
		$number_returned = ldap_count_entries($connect,$search);
		$info = ldap_get_entries($connect, $search);
		$arrName=explode(' ',$info[0]["cn"][0]);
		$infoldap = $arrName[0]."||".$arrName[1]."||".$info[0]["mail"][0]."||".$info[0]["homephone"][0]."||".$info[0]["employeenumber"][0];
		return $infoldap;
	}
	ldap_close($connect);
}	
function ldap_login($ip,$user,$pass){
	$ldap_server = $ip;
	$ldap_user ="uid=$user,ou=people,dc=prd,dc=go,dc=th";//uid=prapas_c,ou=people,dc=prd,dc=go,dc=th
	/////////////////////
	$auth_user ='uid=$user';
	$auth_pass = $pass;
	
	if (!($connect=ldap_connect($ldap_server))) {
		die("Could not connect to ldap server");
	}
	ldap_set_option($connect, LDAP_OPT_PROTOCOL_VERSION, 3);
	ldap_set_option($connect, LDAP_OPT_REFERRALS, 0);
	// bind to server
	if (!($bind=@ldap_bind($connect,$ldap_user,$auth_pass))) {
		//case user not has permistion LDAP
		$infoldap = '';
		return $infoldap;
	} else {
	//case user has permistion LDAP
		$infoldap = ldap_detail($ip,$user,$pass);
		return $infoldap;
	}
	ldap_close($connect);
}
function Login_ewt($EWT_User,$EWT_Password,$fn){
global $db;
//echo "SELECT * FROM gen_user WHERE gen_user = '".trim($EWT_User)."' AND  gen_pass = '".trim($EWT_Password)."'  ";
	$sql_login = $db->query("SELECT * FROM gen_user WHERE gen_user = '".trim($EWT_User)."' AND  gen_pass = '".trim($EWT_Password)."'  ");
			$row = $db->db_num_rows($sql_login);
			if($row > 0){
			$M = $db->db_fetch_array($sql_login);
						if($M[status] != "1"){
								?>
						<script language="JavaScript">
							alert("คุณยังไม่ได้ยืนยันการลงทะเบียน!!!");
							<?php if($fn == ''){?>
							self.location.href = "ewt_login.php?fn=main.php?filename=index";
							<?php } else {?>
							self.location.href = "<?php echo $fn;?>";
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
								if($fn == ""){
								?>
								<script language="JavaScript">
										self.location.href = "index.php";
									</script>
								<?php
								}else{
								?>
										<script language="JavaScript">
										self.location.href = "<?php echo $fn;?>";
									</script>
								<?php
								}
						exit;
						}
			}else{
			?>
			<script language="JavaScript">
				alert("Username or pasword not correct!!!");
				<?php if($fn == ''){?>
				self.location.href = "ewt_login.php?fn=main.php?filename=index";
				<?php } else {?>
				self.location.href = "<?php echo $fn?>";
				<?php } ?>
				</script>
			<?php
			exit;
			}
}
if($_POST["Flag"] == "forgot"){
	$sql_chk="select * from gen_user where email_person='$member_email' AND status = '1'";
	$query_chk=mysql_query($sql_chk);
	$num_rows=mysql_num_rows($query_chk);
	if($num_rows>0){

				$R = mysql_fetch_array($query_chk);
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

include("lib/libmail.php");
$m = new Mail();
$m->From("webmaster<webmaster@prd.go.th>");
$m->Subject("ข้อมูล Username-Password");
$m->Body($body,"text/html");
$m->To(trim($R[email_person]));
$m->Send();
?>
<script language="JavaScript">
	alert("ระบบส่งข้อมูลของท่านไปทาง <?php echo $R[email_person]; ?> แล้ว");
self.close();
</script>
	<?php
		exit;
	}else{
		print "<script>alert('Emailนี้ไม่มีในฐานข้อมูล กรุณากรอกใหม่'); window.location.href='member_forgot.php';</script>";
exit;
	}

}else if($_POST["Flag"] == "AcceptLogin"){
 $chkpic = "chkpic1".$_POST["BID"];
	if($_POST[$chkpic] != $_SESSION["gen_pic_login"]){
			?>
			<script language="JavaScript">
			alert("Picture text not correct!!!");
			<?php if($_POST[fn] == ''){?>
			self.location.href = "ewt_login.php?fn=main.php?filename=index";
			<?php } else {?>
			self.location.href = "<?php echo $_POST[fn]?>";
			<?php } ?>
			</script>
			<?php
			exit;
	}
	if(trim($_POST["ewt_user1"]) != "" AND trim($_POST["ewt_pass1"]) != ""){
	//check ldap first
		$sql_info = "SELECT login_ldap,login_ldap_ip FROM user_info WHERE EWT_User = 'prd_web'";
		$query_info = $db->query($sql_info);
		$rec = $db->db_fetch_array($query_info);
		
	if($rec['login_ldap'] == 'Y'){
		$chk_ldap = ldap_login($rec["login_ldap_ip"],trim($_POST["ewt_user1"]),$_POST["ewt_pass1"]);
		if($chk_ldap != '||||||||' && $chk_ldap != '' ){
		//case user have permission LDAP
						$infoldap = explode('||',$chk_ldap);
						$user_name = $_POST["EWT_User"];
						$pass_word = $_POST["EWT_Password"];
						$org_code = $_POST["ewt_org_code1"];
						$emp_id = $infoldap[4];
						$telephone = $infoldap[3];
						$email = $infoldap[2];
						$name = $infoldap[0];
						$surname = $infoldap[1];
						$org_id = '101';
				$sql_login = $db->query("SELECT * FROM gen_user WHERE emp_id = '".trim($emp_id)."'  ");
				$row = $db->db_num_rows($sql_login);
				$M = $db->db_fetch_array($sql_login);
				session_register("EWT_MID");
				session_register("EWT_ORG");
				session_register("EWT_NAME");
				session_register("EWT_LEVEL");
				session_register("EWT_IMG");
				session_register("EWT_MAIL");
				session_register("EWT_USERNAME");
				$_SESSION["EWT_MID"] = $M["gen_user_id"];
				$_SESSION["EWT_ORG"] = $M["org_id"];
				$_SESSION["EWT_NAME"] =$M["name_thai"].'  '.$M["surname_thai"];
				$_SESSION["EWT_LEVEL"] = $M["level_id"];
				$_SESSION["EWT_TYPE_ID"] = $M["emp_type_id"];
				$_SESSION["EWT_IMG"] = '';
				$_SESSION["EWT_MAIL"] = $M["email_person"];
				$_SESSION["EWT_FIGN"] = '';
				$_SESSION["EWT_USERNAME"] = $M["gen_user"];
				?>
					<script language="JavaScript">
				<?php
									if($_POST[fn] == ''){
				?>
									self.location.href = "ewt_login.php?fn=main.php?filename=index";
				<?php
									} else {
				?>
									self.location.href = "<?php echo $_POST[fn]?>";
				<?php
									}
				?>
									</script>
				<?php
				exit;
		}else{
		//case user not have permission LDAP
		Login_ewt($_POST["ewt_user1"],$_POST["ewt_pass1"],$_POST[fn]);

		}
	}else {
	Login_ewt($_POST["ewt_user1"],$_POST["ewt_pass1"],$_POST[fn]);
	}
	} 

}else{

	?>
<html>
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
<body  leftmargin="0" topmargin="0"><table width="100%" height="100%" border="0" cellpadding="0" cellspacing="0">
  <tr> 
    <td  align="center" valign="top"><table width="800" height="100%" border="0" cellpadding="0" cellspacing="0">
        <tr> 
          <td width="5" height="100%" background="mainpic/bg_l.gif"></td>
          <td align="center" valign="top" bgcolor="E3E6EB"><table width="770" height="100%" border="0" align="center" cellpadding="2" cellspacing="1" bgcolor="B4BDC7">
              <tr> 
                <td valign="top" bgcolor="#FFFFFF"><br>
                  <table width="90%" border="0" align="center" cellpadding="10" cellspacing="1" bgcolor="#A9A9E0">
                    <tr>
                      <td bgcolor="#DBDBF2"><font size="4" face="Tahoma"><strong><font color="#666666"><a href="main.php?filename=index">กลับหน้าหลัก</a> &gt;&gt; เข้าสู่ระบบ</font></strong></font></td>
                    </tr>
                  </table><br>
<br>
<table width="400" border="0" align="center" cellpadding="3" cellspacing="1" bgcolor="#7D87FB">
  <form name="form_loginm" method="post" action="" onSubmit="return chk();">
    <tr bgcolor="#ABB1FC"> 
                        <td colspan="2" bgcolor="#ABB1FC"><strong>เข้าสู่ระบบ</strong></td>
    </tr>
    <tr bgcolor="#FFFFFF"> 
      <td width="137">ชื่อผู้ใช้ :</td>
      <td width="248"><input name="ewt_user1" type="text" id="ewt_user1" size="10" autocomplete="off"></td>
    </tr>
    <tr bgcolor="#FFFFFF"> 
      <td>รหัสผ่าน :</td>
      <td><input name="ewt_pass1" type="password" id="ewt_pass1" size="10" autocomplete="off"></td>
    </tr>
    <tr bgcolor="#FFFFFF"> 
      <td>ภาพ :</td>
      <td><span id="logpic"><img src="ewt_pic.php" align="absmiddle"></span> <input type="button" name="Submit3" value="เลือกภาพใหม่" onClick="document.all.logpic.innerHTML = '<img src=ewt_pic.php align=absmiddle>';"></td>
    </tr>
    <tr bgcolor="#FFFFFF"> 
      <td>พิมพ์ตัวอักษรที่อยู่ในภาพ :</td>
      <td><input name="chkpic1" type="text" id="chkpic1" size="8" maxlength="8"></td>
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
  </form>
</table>
<script language="JavaScript">
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
		if(document.form_loginm.chkpic1.value == ""){
			alert("Please input picture text");
			document.form_loginm.chkpic1.focus();
			return false;
	}
}
</script>
                  
                </td>
              </tr>
            </table></td>
          <td width="5" height="100%" background="mainpic/bg_r.gif"></td>
        </tr>
      </table></td>
  </tr>
</table>
</body>
</html>
<?php } ?>
<?php $db->db_close(); ?>
