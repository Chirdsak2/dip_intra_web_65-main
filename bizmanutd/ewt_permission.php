<?php
session_start();
include("../lib/include_bizadmin.php");
include("../lib/include.php");
include("../lib/function.php");
include("../lib/ewt_config.php");
include("../lib/connect.php");
$db->query("USE ".$EWT_DB_NAME);
if($_POST["Flag"] == "SET"){
				$sqlchk = $db->query("DELETE FROM web_group_member WHERE ug_id = '".$_POST["UID"]."' AND ugm_type = '".$_POST["mtype"]."' AND ugm_tid = '".$_POST["mid"]."' ");
				$sqlchk = $db->query("DELETE FROM permission WHERE UID = '".$_POST["UID"]."' AND p_type = '".$_POST["mtype"]."' AND pu_id = '".$_POST["mid"]."' ");
				?>
				<script language="JavaScript">
				window.location.href = "ewt_permission.php?UID=<?php echo $_POST["UID"]; ?>";
				</script>
				<?php
				exit;
}

$sql = $db->query("SELECT * FROM user_info WHERE UID = '".$_GET["UID"]."' ");
$R = $db->db_fetch_array($sql);
?>
<html>
<head>
<title><?php echo $EWT_title ?></title>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<link href="../theme/main_theme/css/style.css" rel="stylesheet" type="text/css">
<script language="JavaScript1.2">
<!--
top.window.moveTo(0,0);
if (document.all) {
top.window.resizeTo(screen.availWidth,screen.availHeight);
}
else if (document.layers||document.getElementById) {
if (top.window.outerHeight<screen.availHeight||top.window.outerWidth<screen.availWidth){
top.window.outerHeight = screen.availHeight;
top.window.outerWidth = screen.availWidth;
}
}
//-->
</script>
</head>
<body leftmargin="0" topmargin="0">
<table width="100%" height="100%" border="0" cellpadding="0" cellspacing="0" bgcolor="#333333">
  <form name="formlink" method="post" action="ewt_permission.php"><tr> 
    <td height="25" bgcolor="F3F3EE"> &nbsp;&nbsp;<img src="../images/arrow_r.gif" width="7" height="7" border="0" align="absmiddle"><img src="../images/arrow_r.gif" width="7" height="7" border="0" align="absmiddle"> 
      <strong>Website : <?php echo $R["WebsiteName"]; ?> (<?php echo $R["EWT_User"]; ?>)</strong>
      
        <input type="hidden" name="mid" value=""><input type="hidden" name="mtype" value=""><input type="hidden" name="muse" value="">
        <input name="Flag" type="hidden" id="Flag" value="SET"><input type="hidden" name="UID" value="<?php echo $_GET["UID"]; ?>"> </td>
  </tr></form>
  <tr> 
    <td height="1" bgcolor="D8D2BD"></td>
  </tr>
  <tr> 
    <td height="1" bgcolor="#FFFFFF"></td>
  </tr>
  <tr> 
    <td align="center" valign="top" bgcolor="F3F3EE"><table width="100%" height="100%" border="0" cellpadding="2" cellspacing="1">
        <tr> 
          <td width="60%" height="250" align="center" valign="top"><table width="100%" height="100%" border="0" cellpadding="2" cellspacing="0">
              <tr>
                <td height="25"><img src="../images/arrow_r.gif" width="7" height="7" border="0" align="absmiddle"> User List</td>
              </tr>
			  <tr> 
    <td height="1" bgcolor="D8D2BD"></td>
  </tr>
  <tr> 
    <td height="1" bgcolor="#FFFFFF"></td>
  </tr>
              <tr>
                <td align="center" valign="top" bgcolor="888888"><table width="100%" height="100%" border="0" cellpadding="2" cellspacing="1" bgcolor="#000000">
                      <tr> 
                        <td bgcolor="#FFFFFF"><iframe name="p_user_list"  frameborder="0"  width="100%" height="100%" scrolling="yes" src="ewt_content.php?UID=<?php echo $_GET["UID"]; ?>"></iframe></td>
                      </tr>
                      
                    </table></td>
              </tr>
            </table></td>
          <td height="40%" rowspan="3" align="center" valign="top"><table width="100%" height="100%" border="0" cellpadding="2" cellspacing="0">
              <tr>
                <td height="25"><img src="../images/arrow_r.gif" width="7" height="7" border="0" align="absmiddle"> Advance Properties</td>
              </tr>
			  <tr> 
    <td height="1" bgcolor="D8D2BD"></td>
  </tr>
  <tr> 
    <td height="1" bgcolor="#FFFFFF"></td>
  </tr>
              <tr>
                <td align="center" valign="top" bgcolor="888888"><table width="100%" height="100%" border="0" cellpadding="2" cellspacing="1" bgcolor="#000000">
                      <tr> 
                        <td bgcolor="#FFFFFF"><iframe name="p_advance"  frameborder="0"  width="100%" height="100%" scrolling="yes"></iframe></td>
                      </tr>
                      
                    </table></td>
              </tr>
            </table></td>
        </tr>
        <tr> 
          <td height="20" align="right"><input type="button" name="Submit2" value="   Add User   " onClick="win4=window.open('ewt_s_member.php?ug=<?php echo $_GET["UID"]; ?>','usersq','width=650,height=400,scrollbars=1,resizable=1');win4.focus();">
            <input name="bt_remove" type="button" disabled id="bt_remove" value="Remove User" onClick="if(confirm('Are you sure to remove this person ?')){ formlink.submit(); }"></td>
        </tr>
        <tr> 
          <td><table width="100%" height="100%" border="0" cellpadding="2" cellspacing="0">
		  <tr> 
    <td height="1" bgcolor="D8D2BD"></td>
  </tr>
  <tr> 
    <td height="1" bgcolor="#FFFFFF"></td>
  </tr>
              <tr>
                <td height="25"><img src="../images/arrow_r.gif" width="7" height="7" border="0" align="absmiddle"> Permission 
                  List</td>
              </tr>
			  <tr> 
    <td height="1" bgcolor="D8D2BD"></td>
  </tr>
  <tr> 
    <td height="1" bgcolor="#FFFFFF"></td>
  </tr>
              <tr>
                <td align="center" valign="top" bgcolor="888888"><table width="100%" height="100%" border="0" cellpadding="2" cellspacing="1" bgcolor="#000000">
                      <tr> 
                        <td bgcolor="#FFFFFF"><iframe name="p_permission"  frameborder="0"  width="100%" height="100%" scrolling="yes"></iframe></td>
                      </tr>
                      
                    </table></td>
              </tr>
            </table></td>
        </tr>
      </table></td>
  </tr>
</table>
</body>
</html>
<?php
$db->db_close(); ?>
