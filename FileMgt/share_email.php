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
<table width="100%" height="100%" border="0" cellpadding="0" cellspacing="0"><form action="share_function.php" method="post" enctype="multipart/form-data" name="form1">
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
      <td height="30" align="center" bgcolor="F3F3EE"><table width="80%" border="0" cellspacing="1" cellpadding="3">
          <tr> 
            <td width="35%" align="right">From name</td>
            <td width="65%"><input name="sname" type="text" id="sname" size="40"></td>
          </tr>
          <tr> 
            <td align="right">From email</td>
            <td><input name="semail" type="text" id="semail" size="40"></td>
          </tr>
          <tr> 
            <td align="right">To name</td>
            <td><input name="tname" type="text" id="tname" size="40"></td>
          </tr>
          <tr> 
            <td align="right">To email</td>
            <td><input name="temail" type="text" id="temail" size="40"></td>
          </tr>
          <tr> 
            <td align="right">Subject</td>
            <td><input name="subject" type="text" id="subject" size="40"></td>
          </tr>
          <tr> 
            <td align="right">Body</td>
            <td><textarea name="body" cols="40" rows="5" id="body"></textarea></td>
          </tr>
          <tr> 
            <td align="right">File attach</td>
            <td><?php echo $file_rn; ?></td>
          </tr>
          <tr>
            <td>&nbsp;</td>
            <td><input type="submit" name="Submit" value=" Send ">
              <input type="reset" name="Submit2" value="Reset"></td>
          </tr>
        </table> 
        <input name="r_name" type="hidden" id="r_name" value="<?php echo $_POST["r_name"]; ?>">
        <input name="direct" type="hidden" id="direct" value="<?php echo $_POST["direct"]; ?>">
        <input name="Flag" type="hidden" id="Flag" value="Email">
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
