<?php
include("../lib/permission1.php");
include("../lib/include.php");
include("../lib/function.php");
include("../lib/user_config.php");
include("../lib/connect.php");
include("../lib/share_config.php");

if($_POST["Flag"] == "Remove"){

$file_rn = basename(base64_decode($_POST["r_name"]));
	?>
<html>
<head>
<title><?php echo $EWT_title ?></title>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<link href="../css/style_content.css" rel="stylesheet" type="text/css">
</head>
<body leftmargin="0" topmargin="0">
<table width="100%" height="100%" border="0" cellpadding="0" cellspacing="0"><form name="form1" method="post" action="share_function.php">
<tr>
      <td height="30" bgcolor="F3F3EE">&nbsp;&nbsp;&nbsp;<a href="<?php if($_SERVER["HTTP_REFERER"] != ""){ echo $_SERVER["HTTP_REFERER"]; }else{ echo "share_index.php"; } ?>" ><img src="../images/content_back.gif" width="24" height="24" border="0" align="absmiddle"> 
        Back</a> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
  </tr>
    <tr>
    <td height="1" bgcolor="D8D2BD"></td>
  </tr>
  <tr>
    <td height="1" bgcolor="#FFFFFF"></td>
  </tr>
    <tr> 
      <td height="30" align="center" bgcolor="F3F3EE">Rename 
        <input name="nname" type="text" id="nname" value="<?php echo $file_rn; ?>">
        <input type="submit" name="Submit" value="Save">
        <input name="r_name" type="hidden" id="r_name" value="<?php echo $_POST["r_name"]; ?>">
        <input name="direct" type="hidden" id="direct" value="<?php echo $_POST["direct"]; ?>">
        <input name="Flag" type="hidden" id="Flag" value="Rename">
      </td>
  </tr>
    <tr>
    <td height="1" align="center" bgcolor="D8D2BD"></td>
  </tr>
  <tr>
    <td height="1" bgcolor="#FFFFFF"></td>
  </tr>
  <tr>
      <td valign="top">&nbsp;</td>
  </tr></form>
</table>
</body>
<?php } ?>
