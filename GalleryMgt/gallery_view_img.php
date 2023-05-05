<?php
session_start();
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
</head>
<body leftmargin="0" topmargin="0">
<?php
	$Globals_Dir = "../ewt/".$_SESSION["EWT_SUSER"]."/";
?>
<table  border="0" cellpadding="1" cellspacing="1" bgcolor="#999999" align="center">
  <tr>
    <td bgcolor="#FFFFFF"><img src="<?php echo $Globals_Dir.$_GET[img_name]?>"></td>
  </tr>
</table>
</body>
</html>
<?php
$db->db_close(); ?>
