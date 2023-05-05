<?php
session_start();
include("lib/function.php");
include("lib/user_config.php");
include("lib/connect_uncheck.php");

$sql_m = $db->query("SELECT * FROM gen_user WHERE gen_user_id = '".$_SESSION["EWT_MID"]."'");
$M = $db->db_fetch_array($sql_m);
	?>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<title>Welcome</title>
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

<table width="401" border="0" align="center" cellpadding="3" cellspacing="1" bgcolor="#7D87FB">
  <tr bgcolor="#ABB1FC"> 
    <td colspan="2"><strong>Welcome.</strong></td>
  </tr>
  <tr bgcolor="#FFFFFF"> 
    <td width="137">ชื่อ :</td>
    <td width="249"><?php echo $M["name_thai"]; ?> </td>
  </tr>
  <tr bgcolor="#FFFFFF"> 
    <td>นามสกุล :</td>
    <td><?php echo $M["surname_thai"]; ?></td>
  </tr>
  <tr bgcolor="#FFFFFF"> 
    <td>ตำแหน่ง :</td>
    <td><?php echo $M["posittion"]; ?></td>
  </tr>
  <tr bgcolor="#FFFFFF">
    <td>&nbsp;</td>
    <td><input type="submit" name="Submit" value="เข้าสู่ Website &gt;&gt;" onClick="self.location.href = 'main.php?filename=index';"></td>
  </tr>
</table>
</body>
</html>
<?php $db->db_close(); ?>
