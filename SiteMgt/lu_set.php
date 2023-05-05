<?php
session_start();
include("../lib/permission1.php");
include("../lib/include.php");
include("../lib/function.php");
include("../lib/user_config.php");
include("../lib/connect.php");
$db->query("USE ".$EWT_DB_USER);

	$sql = $db->query("SELECT * FROM gen_user WHERE gen_user_id = '".$_GET["G"]."' ");
	$C = $db->db_fetch_array($sql);
?>
<html>
<head>
<title><?php echo $EWT_title ?></title>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<link href="../theme/main_theme/css/style.css" rel="stylesheet" type="text/css">
</head>

<body><br>

<table width="94%" border="0" align="center" cellpadding="0" cellspacing="1" bgcolor="#AAAAAA">
  <form name="form_g" method="post" action="site_group.php" onSubmit="return chk();">
    <tr bgcolor="#F7F7F7"> 
      <td height="30" colspan="2">&nbsp;<strong>Manage underling</strong></td>
    </tr>
    <tr bgcolor="#FFFFFF"> 
      <td width="25%" height="30">&nbsp;Leader name :</td>
      <td width="75%">&nbsp;<?php echo $C["name_thai"]; ?> <?php echo $C["surname_thai"]; ?></td>
    </tr>
    <tr bgcolor="#FFFFFF"> 
      <td height="30">&nbsp;</td>
      <td>&nbsp; <input type="button" name="Submit3" value="Add user" onClick="win3=window.open('ul_s_member.php?G=<?php echo $_GET["G"]; ?>','users','width=600,height=400,scrollbars=1,resizable=1');win3.focus();"></td>
    </tr>
    <tr bgcolor="#FFFFFF"> 
      <td height="30">&nbsp;</td>
      <td valign="top"><iframe name="member_list" src="ul_member.php?G=<?php echo $_GET["G"]; ?>" frameborder="0"  width="100%" height="350" scrolling="yes"></iframe></td>
    </tr>
  </form>
</table>
</body>
</html>
<?php
$db->db_close();
?>
