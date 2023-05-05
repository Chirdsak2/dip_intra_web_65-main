<?php
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
<table width="100%" height="100%" border="0" cellpadding="0" cellspacing="0" bgcolor="#333333">
  <tr> 
    <td height="35" bgcolor="#F3F3EE">
      <?php include("../ewt_menu.php"); ?>    </td>
  </tr>
  <tr> 
    <td height="1" bgcolor="#D8D2BD"></td>
  </tr>
  <tr> 
    <td height="1" bgcolor="#FFFFFF"></td>
  </tr>
   <tr> 
    <td height="20" bgcolor="#FFFFFF"><table width="100%" border="0" cellpadding="1" cellspacing="0" bgcolor="#F7F7F7">
        <tr> 
          <td width="98%" height="60"><table width="98%" border="0" align="center" cellpadding="5" cellspacing="0">
  <tr> 
    <td width="72" height="50"><img src="../theme/main_theme/module.jpg" width="72" height="72"> </td>
                <td><span class="ewthead">Module Name</span>
                  <hr width="100%" size="1"  align="left"  color="#D8D2BD">
                  <span class="ewtsubmenu"><img src="../theme/main_theme/bullet.gif" width="16" height="16" align="absmiddle"> Sub-menu1</span>&nbsp;&nbsp;&nbsp;&nbsp;
				  <span class="ewtsubmenu"><img src="../theme/main_theme/bullet.gif" width="16" height="16" align="absmiddle"> Sub-menu2</span>&nbsp;&nbsp;&nbsp;&nbsp;
				  <span class="ewtsubmenu"><img src="../theme/main_theme/bullet.gif" width="16" height="16" align="absmiddle"> Sub-menu3</span>&nbsp;&nbsp;&nbsp;&nbsp;
				  <span class="ewtsubmenu"><img src="../theme/main_theme/bullet.gif" width="16" height="16" align="absmiddle"> Sub-menu4</span>&nbsp;&nbsp;&nbsp;&nbsp;
				  <span class="ewtsubmenu"><img src="../theme/main_theme/bullet.gif" width="16" height="16" align="absmiddle"> Sub-menu5</span>
				  </td>
  </tr>
</table></td>
          <td  align="right" valign="top"><div align="right"><img src="../images/bar_close.gif" width="15" height="13" border="1" style="border-Color:threedface"  title="Close" onClick="top.ewt_main.location.href = '../ewt_main.php';"></div></td>
        </tr>
      </table></td>
  </tr>
  <tr> 
    <td height="2" bgcolor="#FF3300"></td>
  </tr>
  <tr> 
    <td height="1" bgcolor="#000000"></td>
  </tr>
  <tr> 
    <td valign="top" bgcolor="#FFFFFF"><table width="100%" height="100%" border="0" align="center" cellpadding="0" cellspacing="1" bgcolor="#FFFFFF">
                      <tr> 
                        <td bgcolor="#FFFFFF"><iframe name="f_body" src="detail.php"  frameborder="0"  width="100%" height="100%" scrolling="yes"></iframe></td>
                      </tr>
                      
                    </table></td>
  </tr>
</table>
</body>
</html>
<?php
$db->db_close(); ?>