<?php
include("../lib/permission1.php");
include("../lib/include.php");
include("../lib/function.php");
include("../lib/user_config.php");
include("../lib/connect.php");
$db->query("USE ".$EWT_DB_USER);
?>
<html>
<head>
<title><?php echo $EWT_title ?></title>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<link href="../theme/main_theme/css/style.css" rel="stylesheet" type="text/css">
<style type="text/css">
<!--
.head_table { 
	border-bottom:"buttonshadow solid 1px";
	border-left:"buttonhighlight solid 1px";
	border-right:"buttonshadow solid 1px";
	border-top:"buttonhighlight solid 1px";
	}
-->
</style>
</head>
<body leftmargin="0" topmargin="0">
<table width="100%" height="100%" border="0" cellpadding="3" cellspacing="1" bgcolor="919B9C">
        <tr>
          <td bgcolor="F7F7F7"><table width="100%" height="100%" border="0" cellpadding="3" cellspacing="0">
        <tr> 
          <td height="20"> <img src="../images/arrow_r.gif" width="7" height="7" border="0" align="absmiddle"> 
            <strong>Security Setting</strong></td>
        </tr>
        <tr> 
          <td height="160" valign="top"><table width="100%" height="100%" border="0" cellpadding="0" cellspacing="1" bgcolor="919B9C">
              <tr> 
                <td valign="top" bgcolor="#FFFFFF"><iframe name="m_data11" src="setting_member1.php?s_type=<?php echo $_GET["s_type"]; ?>&s_id=<?php echo $_GET["s_id"]; ?>&s_name=<?php echo $_GET["s_name"]; ?>"  frameborder="0"  width="100%" height="100%" scrolling="yes" ></iframe></td>
              </tr>
            </table></td>
        </tr>
        <tr> 
          <td valign="top"><table width="100%" height="100%" border="0" cellpadding="0" cellspacing="1" bgcolor="919B9C">
              <tr> 
                <td bgcolor="#FFFFFF"><iframe name="m_data12"  frameborder="0"  width="100%" height="100%" scrolling="yes" ></iframe></td>
              </tr>
            </table></td>
        </tr>
        <tr>
          <td height="20" align="right" valign="top"><input name="Buttonxo" type="button" id="Buttonxo" onClick="m_data12.document.form1.submit();" value="        OK        " disabled> <input type="button" name="Button" value="     Cancel     " onClick="self.close();"> <input name="Buttonxa" type="button" id="Buttonxa"  onClick="m_data12.document.form1.plan.value='go';m_data12.document.form1.submit();" value="     Apply     " disabled></td>
        </tr>
      </table></td>
        </tr>
      </table>
</body>
</html>
<?php $db->db_close(); ?>
