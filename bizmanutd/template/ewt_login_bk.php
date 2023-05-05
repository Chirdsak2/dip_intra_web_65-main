<?php
session_start();
//session_destroy();
include("lib/function.php");
include("lib/user_config.php");
include("lib/connect_uncheck.php");

if($_POST["Flag"] == "AcceptLogin"){
	if($_POST["chkpic1"] != $_SESSION["gen_pic_login"]){
			?>
			<script language="JavaScript">
			alert("Picture text not correct!!!");
			self.location.href = "ewt_login.php?fn=<?php echo $_POST[fn]?>";
			</script>
			<?php
			exit;
	}
	if(trim($_POST["ewt_user1"]) != "" AND trim($_POST["ewt_pass1"]) != ""){
		$sql_login = $db->query("SELECT * FROM gen_user WHERE gen_user = '".trim($_POST["ewt_user1"])."' AND  gen_user = '".trim($_POST["ewt_pass1"])."'  ");
		$row = $db->db_num_rows($sql_login);
		if($row > 0){
		$M = $db->db_fetch_array($sql_login);
		session_register("EWT_MID");
		
		$_SESSION["EWT_MID"] = $M["gen_user_id"];
		$_SESSION["EWT_NAME"] = $M["name_thai"]." ".$M["surname_thai"];
		if(!isset($_POST[fn])){
		?>
		<script language="JavaScript">
			self.location.href = "ewt_profile.php";
			</script>
		<?php
		}else{
		?>
				<script language="JavaScript">
			self.location.href = "<?php echo $_POST[fn]?>";
			</script>
		<?php
		}
		exit;
		}else{
		?>
		<script language="JavaScript">
			alert("Username or pasword not correct!!!");
			self.location.href = "ewt_login.php?fn=<?php echo $_POST[fn]?>";
			</script>
		<?php
		exit;
		}
	}


}else{

function random_code($len){
srand((double)microtime()*10000000);
$chars = "ABCDEFGHJKMNPQRSTUVWXYZabcdefghijkmnpqrstuvwxyz123456789";
$ret_str = "";
$num = strlen($chars);
for($i=0;$i<$len;$i++){
$ret_str .= $chars[rand()%$num];
}
return $ret_str;
}

	if(!session_is_registered("gen_pic_login")){
	session_register("gen_pic_login");
	}
	$_SESSION["gen_pic_login"] = random_code(3);
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
<body  leftmargin="0" topmargin="0"><br>
<br>
<br>

<table width="400" border="0" align="center" cellpadding="3" cellspacing="1" bgcolor="#7D87FB">
  <form name="form_loginm" method="post" action="" onSubmit="return chk();">
    <tr bgcolor="#ABB1FC"> 
      <td colspan="2" bgcolor="#ABB1FC"><strong>Please login.</strong></td>
    </tr>
    <tr bgcolor="#FFFFFF"> 
      <td width="137">Username :</td>
      <td width="248"><input name="ewt_user1" type="text" id="ewt_user1" size="10"></td>
    </tr>
    <tr bgcolor="#FFFFFF"> 
      <td>Password :</td>
      <td><input name="ewt_pass1" type="password" id="ewt_pass1" size="10"></td>
    </tr>
    <tr bgcolor="#FFFFFF"> 
      <td>Picture check :</td>
      <td><img src="ewt_pic.php" align="absmiddle"> <input type="button" name="Submit3" value="New pic" onClick="self.location.reload();"></td>
    </tr>
    <tr bgcolor="#FFFFFF"> 
      <td>Type picture :</td>
      <td><input name="chkpic1" type="text" id="chkpic1" size="8" maxlength="8"></td>
    </tr>
    <tr bgcolor="#FFFFFF"> 
      <td>&nbsp;</td>
      <td><input type="submit" name="Submit" value="Submit"> <input type="reset" name="Submit2" value="Reset">
        <input type="button" name="register" value="Register" onClick="location.href = 'frm_gen_user.php';">
        <input name="Flag" type="hidden" id="Flag" value="AcceptLogin">
        <input name="fn" type="hidden" id="Flag2" value="<?php echo ($_GET[fn])?$_GET[fn]:$_POST[fn]?>"></td>
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
</body>
</html>
<?php } ?>
<?php $db->db_close(); ?>
