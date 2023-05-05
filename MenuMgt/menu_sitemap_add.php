<?php
include("../lib/permission1.php");
include("../lib/include.php");
include("../lib/function.php");
include("../lib/user_config.php");
include("../lib/connect.php");
if($_GET["sid"] != ''){
$label = "แก้ไข";
$flag = 'editdata';
$sql = "select * from menu_setting where s_id = '".$_GET["sid"]."'";
$query = $db->query($sql);
$R = $db->db_fetch_array($query);
$name = $R[s_name];
}else{
$label = "เพิ่ม";
$flag = 'adddata';
}
?>
<html>
<head>
<title><?php echo $EWT_title ?></title>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<link href="../theme/main_theme/css/style.css" rel="stylesheet" type="text/css">
</head>
<body leftmargin="0" topmargin="0">
<?php include("../FavoritesMgt/favorites_include.php");?>
<form name="form1" method="post" action="menu_sitemap_function.php">
<table width="80%" border="0" align="center" cellpadding="5" cellspacing="0">
  <tr> 
    <td><img src="../theme/main_theme/logo.gif" width="32" height="32" align="absmiddle"> 
      <span class="ewtfunction"><?php echo $label;?>ชุด Sitemap</span> </td>
  </tr>
</table>
<table width="94%" border="0" align="center" cellpadding="0" cellspacing="0" class="ewtfunctionmenu">
  <tr>
    <td align="right"><a href="javascript:void(0);" onClick="load_divForm('../FavoritesMgt/favorites_add.php?name=<?php echo urlencode($label."ชุด Sitemap");if($_GET["sid"] != ''){ echo  urlencode(':'.$name);}?>&module=sitemap&url=<?php if($_GET["sid"] != ''){ echo urlencode('menu_sitemap_add.php?sid='.$_GET["sid"]);}else{ echo urlencode("menu_sitemap_add.php");}?>', 'divForm', 300, 80, -1,433, 1);"><img src="../images/star_yellow_add.gif" width="16" height="16" border="0" align="absmiddle">&nbsp;Add to favorites </a>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<a href="menu_sitemap_main.php"><img src="../theme/main_theme/g_back.gif" width="16" height="16" border="0" align="absmiddle">  กลับ
    </a>
    <hr> </td>
  </tr>
</table>
<table width="70%" border="0" align="center" cellpadding="5" cellspacing="1" bgcolor="#CECECE"  class="ewttableuse">
  <tr bgcolor="#E7E7E7" > 
    <td height="30" colspan="2" class="ewttablehead"><?php echo $label;?> ชุด Sitemap</td>
  </tr>
  <tr valign="top" bgcolor="#FFFFFF"> 
    <td width="38%">ชื่อชุด Sitemap</td>
    <td width="62%"><input name="txt_name" type="text" size="40" value="<?php echo $name;?>"></td>
  </tr>
  <tr valign="top" bgcolor="#FFFFFF"> 
    <td width="38%">ชื่อชุด Sitemap</td>
    <td width="62%"><select name="map_type">
    <option value="1" <?php if($R['s_map_type']=='1') { echo 'selected="selected"'; } ?>>Menu</option>
    <option value="2" <?php if($R['s_map_type']=='2') { echo 'selected="selected"'; } ?>>Web page</option>
    </select></td>
  </tr>
  <tr bgcolor="#FFFFFF">
    <td>&nbsp;</td>
    <td><input type="submit" name="Submit2" value="บันทึก">
    <input type="hidden" name="Flag" value="<?php echo $flag;?>">
	<input type="hidden" name="sid" value="<?php echo $_GET["sid"];?>"></td>
  </tr>
</table>
<table width="94%" border="0" align="center" cellpadding="3" cellspacing="0">
  <tr>
    <td>&nbsp;</td>
  </tr>
</table>
</form>
</body>
</html>
<?php
$db->db_close(); ?>