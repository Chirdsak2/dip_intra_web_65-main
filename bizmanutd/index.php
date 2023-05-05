<?php
session_start();
include("../lib/include_bizadmin.php");
include("../lib/include.php");
include("../lib/function.php");
include("../lib/ewt_config.php");
include("../lib/connect.php");
$db->query("USE ".$EWT_DB_NAME);
?>
<html>
<head>
<title><?php echo $EWT_title ?></title>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<link href="../theme/main_theme/css/style.css" rel="stylesheet" type="text/css">
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
    <td>&nbsp;</td>
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
