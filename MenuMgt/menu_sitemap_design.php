<?php
include("../lib/permission1.php");
include("../lib/include.php");
include("../lib/function.php");
include("../lib/user_config.php");
include("../lib/connect.php");
//main data
$sid = $_GET["sid"];
$sql = "select s_name from menu_setting where s_id='".$sid."'";
$query = $db->query($sql);
$R = $db->db_fetch_array($query);
$Sname = $R["s_name"];
	?>
<html>
<head>
<title><?php echo $EWT_title ?></title>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<link href="../theme/main_theme/css/style.css" rel="stylesheet" type="text/css">
</head>
<body leftmargin="0" topmargin="0" >
<?php include("../FavoritesMgt/favorites_include.php");?>
<table width="100%" height="100%" border="0" cellpadding="5" cellspacing="0" bgcolor="E0DFE3">
  <tr>
    <td><table width="100%" height="100%" border="0" cellpadding="3" cellspacing="1" bgcolor="919B9C">
        <tr>
          <td bgcolor="F7F7F7"><table width="100%" height="100%" border="0" cellpadding="3" cellspacing="0">
              <tr>
                <td height="20"> <img src="../images/arrow_r.gif" width="7" height="7" border="0" align="absmiddle"> 
                    <strong><?php echo $text_gensmap_module;?> : <?php echo $Sname; ?></strong></td>
                <td width="25%"><a href="javascript:void(0);" onClick="load_divForm('../FavoritesMgt/favorites_add.php?name=<?php echo $text_gensmap_module;?>(Design) : <?php echo $Sname; ?>&module=sitemap&type=popup&url=menu_sitemap_design.php?sid=<?php echo $sid;?>', 'divForm', 300, 80, -1,433, 1);"><img src="../images/star_yellow_add.gif" width="16" height="16" border="0" align="absmiddle">&nbsp;Add to favorites </a>&nbsp;</td>
              </tr>
              <tr>
                  <td colspan="2" valign="top"><table width="100%" height="100%" border="0" cellpadding="0" cellspacing="0">
                    <tr height="25"> 
                      <td ><table width="100%" height="100%" border="0" cellpadding="0" cellspacing="0">
                    <tr height="25"> 
                      <td width="100" align="center" background="../images/bg1_off.gif"><a href="menu_sitemap_list.php?sid=<?php echo $_GET["sid"]; ?>">Manage 
                        Position</a> </td>
                      <td width="100" align="center" background="../images/bg1_on.gif">Design </td>
                      <td background="../images/bg2_off.gif">&nbsp;</td>
                    </tr>
					</table>					</td>
                    </tr>
                    <tr> 
                      <td><table width="100%" height="100%" border="0" cellpadding="0" cellspacing="1" bgcolor="919B9C">
                          <tr> 
                            <td bgcolor="#FFFFFF"><iframe name="sitemap_design" src="menu_sitemap_config.php?sid=<?php echo $_GET["sid"]; ?>"  frameborder="0"  width="100%" height="100%" scrolling="yes" ></iframe></td>
                          </tr>
                        </table></td>
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
<?php $db->db_close(); ?>
