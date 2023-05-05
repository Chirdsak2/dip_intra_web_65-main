<?php
session_start();
include("inc.php");
$ewt_course_id = "";
$ewt_course_page = "";
$ewt_course_page_id = "";
$ewt_course_path = "";
$ewt_lms_id = "";
$ewt_lms_name = "";
$ewt_lms_email = "";
?>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<link href="../theme/main_theme/css/style.css" rel="stylesheet" type="text/css">
<title>Learning Management System</title></head>

<body leftmargin="0" topmargin="0" class="normal_font">
<div align="center">
  <table width="100%" height="100%" border="0" cellpadding="0" cellspacing="0">
    <tr valign="top">
      <td colspan="2"><?php @include("com_top.php"); ?></td>
    </tr>
    <tr>
      <td valign="top"></td>
      <td width="100%" height="100%" valign="top">
	  <div align="center"><br>        
          <br>
          <br>
          <br>
          <strong><font size="6" face="Tahoma">Webboard Administrator Tool</font></strong><br>
          <br>
          <br>        
          <table width="400" border="0" cellpadding="5" cellspacing="1" bgcolor="#000099" class="normal_font">
            <form name="form1" method="post" action="function_login.php">
            <tr>
              <td width="43%" align="right"><font color="#FFFFFF"><strong>Username</strong></font></td>
              <td width="57%">
                <input name="user" type="text" id="user">
              </td>
            </tr>
            <tr>
              <td align="right"><font color="#FFFFFF"><strong>Password&nbsp;</strong></font></td>
              <td><input name="pass" type="password" id="pass"></td>
            </tr>
            <tr>
              <td>&nbsp;</td>
              <td><input type="submit" name="Submit" value="Submit">
                <input type="reset" name="Submit2" value="Reset">
                <input name="Flag" type="hidden" id="Flag" value="Login"></td>
            </tr></form>
          </table>
          <br>
      </div></td>
    </tr>
    <tr valign="top">
      <td colspan="2"><?php @include("com_bottom.php"); ?></td>
    </tr>
  </table>
</div>
</body>
</html>
<?php @$db->db_close(); ?>