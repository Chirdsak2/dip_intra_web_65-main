<?php
session_start();
include("lib/function.php");
include("lib/user_config.php");
include("lib/connect.php");
 
$db->query("USE ".$EWT_DB_USER);
$user_id =$_SESSION["EWT_MID"];
?>
<html>
<head>
<title>My Website</title>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<link href="css/mysite.css" rel="stylesheet" type="text/css">
</head>
<script language="javascript1.2">
function listname(t,u){
self.parent.contact_name.location.href="contact_list.php?groupid=" + t.value + "&user_id=" + u;
self.parent.contact_detail.location.href="contact_detail.php";
}
</script>
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
                      <td bgcolor="#DBDBF2"><strong><font color="#666666" size="4" face="Tahoma">Contact</font></strong>
                  <hr width="100%" size="1"  align="left"  color="#D8D2BD">
                  <span class="mytext_normal"><strong>&nbsp;<a href="contact_main.php" target="contact_body"><img src="mainpic/folder_closed.gif" width="16" height="16" border="0" align="absmiddle">บริหารรายชื่อ</a>&nbsp;&nbsp;&nbsp;<a href="contact_add_group.php" target="contact_body">&nbsp;<img src="mainpic/folder_closed.gif" width="16" height="16" border="0" align="absmiddle">บริหารกลุ่ม</a></strong></span>				  </td>
                    </tr>
                  </table>
                 <table width="100%" height="600" border="0" align="center" cellpadding="0" cellspacing="1" bgcolor="#FFFFFF">
                   <tr> 
                        <td bgcolor="#FFFFFF"><iframe name="contact_body" src="contact_main.php"  frameborder="0"  width="100%" height="500" scrolling="yes"></iframe>
					  </td>
                    </tr>
                  </table>
                  <br></td>
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
