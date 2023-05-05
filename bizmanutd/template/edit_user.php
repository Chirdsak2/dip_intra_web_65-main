<?php
session_start();
include("lib/function.php");
include("lib/user_config.php");
include("lib/connect_uncheck.php");

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
      <td bgcolor="#ABB1FC"><strong>แก้ไขข้อมูล</strong></td>
    </tr>
    <tr bgcolor="#FFFFFF"> 
      <td bgcolor="#FFFFFF"><span onMouseOver="this.style.color = '#FF0000';"  onMouseOut="this.style.color = '#000000';" style="cursor:hand" onClick="location.href='frm_gen_user.php?gen_user_id=<?php echo $_SESSION["EWT_MID"]?>';">แก้ไขข้อมูล</span></td>
    </tr>
    <tr bgcolor="#FFFFFF"> 
      <td bgcolor="#FFFFFF"><span onMouseOver="this.style.color = '#FF0000';" onMouseOut="this.style.color = '#000000';" style="cursor:hand"  onClick="location.href='ewt_login.php';">ออกจากระบบ</span></td>
    </tr>
  </form>
</table>
</body>
</html>
<?php $db->db_close(); ?>
