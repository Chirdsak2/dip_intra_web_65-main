<?php
session_start();
include("lib/function.php");
include("lib/user_config.php");
include("lib/connect.php");
 
$db->query("USE ".$EWT_DB_USER);
?>
<html>
<head>
<title>My Website</title>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<link href="css/mysite.css" rel="stylesheet" type="text/css">
</head>

<body leftmargin="0" topmargin="0">
<table width="100%" height="100%" border="0" cellpadding="0" cellspacing="0">
  <tr> 
    <td  align="center" valign="top"><table width="800" height="100%" border="0" cellpadding="0" cellspacing="0">
        <tr> 
          <td width="5" height="100%" background="mainpic/bg_l.gif"></td>
          <td align="center" valign="top" bgcolor="E3E6EB"><table width="770" height="100%" border="0" align="center" cellpadding="2" cellspacing="1" bgcolor="B4BDC7">
              <tr> 
                <td valign="top" bgcolor="#FFFFFF"><br>
                  <table width="90%" border="0" align="center" cellpadding="10" cellspacing="1" bgcolor="#A9A9E0">
                    <tr>
                      <td bgcolor="#DBDBF2"><font size="4" face="Tahoma"><strong><font color="#666666">sss</font></strong></font></td>
                    </tr>
                  </table>
                  
                </td>
              </tr>
            </table></td>
          <td width="5" height="100%" background="mainpic/bg_r.gif"></td>
        </tr>
      </table></td>
  </tr>
</table>
</body>
</html>
<?php  $db->db_close(); ?>
