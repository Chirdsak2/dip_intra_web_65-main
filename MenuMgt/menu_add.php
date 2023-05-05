<?php
include("../lib/permission1.php");
include("../lib/include.php");
include("../lib/function.php");
include("../lib/user_config.php");
include("../lib/connect.php");
include("../language/menu_language.php");
if(!session_is_registered("EWT_MENU_POSITION")){
session_register("EWT_MENU_POSITION");
}
$_SESSION["EWT_MENU_POSITION"] = "";
$sql_menu = $db->query("SELECT m_id,m_name FROM menu_list ORDER BY m_name ASC ");
?>
<html>
<head>
<title><?php echo $EWT_title ?></title>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<link href="../theme/main_theme/css/style.css" rel="stylesheet" type="text/css">
<script language="JavaScript">
function chk(){
	if(document.form1.menu_name.value == ""){
		alert("<?php echo $text_menu_alertadd; ?>");
		document.form1.menu_name.focus();
		return false;
	}
}
</script>
</head>
<body leftmargin="0" topmargin="0">
<?php include("../FavoritesMgt/favorites_include.php");?>
<table width="80%" border="0" align="center" cellpadding="5" cellspacing="0">
  <tr> 
    <td><img src="../theme/main_theme/menu_logo.gif" width="32" height="32" align="absmiddle"> 
      <span class="ewtfunction"><?php echo $text_menu_mname; ?></span> </td>
  </tr>
</table>
<table width="90%" border="0" align="center" cellpadding="5" cellspacing="0" class="ewtfunctionmenu">
  <tr>
    <td align="right"><a href="javascript:void(0);" onClick="load_divForm('../FavoritesMgt/favorites_add.php?name=<?php echo urlencode('เพิ่มเมนูชุดใหม่');?>&module=menu&url=<?php echo urlencode("menu_add.php");?>', 'divForm', 300, 80, -1,433, 1);"><img src="../images/star_yellow_add.gif" width="16" height="16" border="0" align="middle">&nbsp;Add to favorites </a>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<a href="menu_list.php"><img src="../theme/main_theme/g_mainpage.gif" width="16" height="16" border="0" align="absmiddle"> <?php echo $text_menu_mainpage; ?></a> 
      <hr>
    </td>
  </tr>
</table>
<form name="form1" method="post" action="menu_function.php" onSubmit="return chk();" target="iframe_data">
<table width="90%" border="0" align="center" class="table table-bordered">

  <tr bgcolor="#E7E7E7" > 
    <td height="30" colspan="2" class="ewttablehead"> <?php echo $text_menu_menuadd; ?></td>
  </tr>
  <tr valign="top" bgcolor="#FFFFFF"> 
    <td width="38%"><?php echo $text_menu_menuname; ?></td>
    <td width="62%"><input name="menu_name" type="text" size="40" class="form-control" style="width:40%" ></td>
  </tr>
  <tr bgcolor="#FFFFFF"> 
    <td>&nbsp;</td>
    <td> 
	<input type="submit" name="Submit" value="<?php echo $text_menu_menuadd; ?>" class="btn btn-success" />
	<input name="Flag" type="hidden" id="Flag" value="Add">
      </td>
  </tr>
 
</table> 
</form>
</body>
</html>
<?php
$db->db_close(); ?>
