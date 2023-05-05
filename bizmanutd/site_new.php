<?php
session_start();
include("../lib/include_bizadmin.php");
include("../lib/include.php");
include("../lib/function.php");
include("../lib/ewt_config.php");
include("../lib/connect.php");
$db->query("USE ".$EWT_DB_USER);
?>
<html>
<head>
<title><?php echo $EWT_title ?></title>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<link href="../theme/main_theme/css/style.css" rel="stylesheet" type="text/css">
<script language="JavaScript">
	function chk(){
	var c = document.form1;
		if(c.w_name.value == ""){
			alert("Please input your website name!!!");
			c.w_name.focus();
			return false;
		}
		if(c.u_name.value == ""){
			alert("Please input your username!!!");
			c.u_name.focus();
			return false;
		}
		if (c.u_name.value.search("^[A-Za-z0-9_]+$")){
					alert("Username is limited to English character  (upper and lower case), number, and underscore only!");
					c.u_name.select();
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

<body>
<table width="100%" height="100%" border="0" cellpadding="0" cellspacing="0">
  <tr valign="top"> 
    <td height="1" colspan="3"> 
      <?php include("com_top.php"); ?>
    </td>
  </tr>
  <tr valign="top"> 
    <td width="1"><?php include("com_left.php"); ?></td>
    <td align="center"><br>
      <table width="400" border="0" cellpadding="3" cellspacing="1" bgcolor="#CCCCCC">
        <form name="form1" method="post" action="site_install.php" onSubmit="return chk();">
          <tr bgcolor="#E7E7E7"> 
            <td height="25" colspan="2"><strong>สร้างเว็บไซต์ใหม่</strong></td>
          </tr>
          <tr bgcolor="#FFFFFF"> 
            <td width="135" bgcolor="#F7F7F7">ชื่อเว็บไซต์</td>
            <td width="250"> <input name="w_name" type="text" id="w_name"> </td>
          </tr>
          <tr bgcolor="#FFFFFF"> 
            <td bgcolor="#F7F7F7">Username</td>
            <td><input name="u_name" type="text" id="u_name"></td>
          </tr>
          <tr bgcolor="#FFFFFF"> 
            <td bgcolor="#F7F7F7">Password</td>
            <td><input name="u_pass" type="password" id="u_pass"></td>
          </tr>
          <tr bgcolor="#FFFFFF"> 
            <td bgcolor="#F7F7F7">Comfirm password</td>
            <td><input name="c_pass" type="password" id="c_pass"></td>
          </tr>
          <tr bgcolor="#FFFFFF"> 
            <td bgcolor="#F7F7F7">&nbsp;</td>
            <td><input type="submit" name="Submit" value="Submit"> <input type="reset" name="Submit2" value="Reset"> 
              <input name="Flag" type="hidden" id="Flag" value="NewSite"></td>
          </tr>
        </form>
      </table> </td>
    <td width="1"><?php include("com_right.php"); ?></td>
  </tr>
  <tr valign="top"> 
    <td height="1" colspan="3"> 
      <?php include("com_bottom.php"); ?>
    </td>
  </tr>
</table>
</body>
</html>
<?php
$db->db_close();
?>
