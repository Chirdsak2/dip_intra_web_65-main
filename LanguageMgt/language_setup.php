<?php
include("../lib/permission1.php");
include("../lib/include.php");
include("../lib/function.php");
include("../lib/user_config.php");
include("../lib/connect.php");
?>
<html>
<head>
<title><?php echo $EWT_title ?></title>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<link href="../theme/main_theme/css/style.css" rel="stylesheet" type="text/css">
<style type="text/css">
<!--
.style1 {color: #FF0000}
-->
</style>
</head>
<body leftmargin="0" topmargin="0">
<table width="100%" height="100%" border="0" cellpadding="0" cellspacing="0" bgcolor="FFFFFF">
  <tr> 
    <td align="center" valign="top">
	<br>
	  <table width="60%" border="0" cellpadding="0" cellspacing="0">
        <tr>
          <td align="center"><a href="language_setup_db.php"><img src="images/font.gif" width="16" height="16" border="0">ตั้งค่าภาษา</a></td>
          <td width="160" align="center"><a href="language_setup_page.php"><img src="images/form_red.gif" width="16" height="16" border="0">บริหารหน้า</a></td>
        </tr>
        <tr>
          <td colspan="2"></td>
        </tr>
        <tr>
          <td>&nbsp;</td>
          <td>&nbsp;</td>
        </tr>
      </table>   </td>
  </tr>
</table>
</body>
</html>
<?php
$db->db_close(); ?>
