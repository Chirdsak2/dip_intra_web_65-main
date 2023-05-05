<?php
header ("Content-Type:text/plain;charset=UTF-8");
include("../lib/permission1.php");
include("../lib/include.php");
include("../lib/function.php");
include("../lib/user_config.php");
include("../lib/connect.php");
include("../lib/set_lang.php");
if($_GET[Fid] != ''){
$title = 'Edit';
$sql = 'SELECT * FROM favoristes WHERE favoristes_id =\''.$_GET[Fid].'\'';
$query = $db->query($sql);
$F = $db->db_fetch_array($query);
$name = $F[favoristes_name];
$url = $F[favoristes_url];
$module = $F[favoristes_module];
$FL = 'Favorites_edit';
}else{
$name = urldecode ( ($_GET[name]));
$url = $_GET[url];
$module = $_GET[module];
$title = 'Add';
$FL = 'Favorites_add';
}
	?>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<link href="../theme/main_theme/css/style.css" rel="stylesheet" type="text/css">
</head>
<body leftmargin="0" topmargin="0">
<form name="form1" method="post" action="../FavoritesMgt/favorites_function.php">
  <table width="100%" border="0">
    <tr>
      <td width="15%" align="right" valign="top"><img src="../images/star_yellow_preferences.gif" width="24" height="24"></td>
      <td width="75%"><span  class="ewtfunction"><?php echo $title;?> a Favorite</span><br>
      <span class="ewtsubmenu"><?php echo $title;?> this webpage as a favorite. To access your favorites, visit to Favorites Center</span></td>
      <td width="5%" align="left" valign="top"><!--<a href="javascript:void(0);" onClick="close_div('divForm');"><img src="../images/error.gif" width="16" height="16" border="0" align="absmiddle"></a>--></td>
    </tr>
    <tr>
      <td width="15%" align="right">&nbsp;</td>
      <td class="ewtfunction">&nbsp;</td>
      <td width="5%">&nbsp;</td>
    </tr>
    <tr>
      <td align="right">Name : </td>
      <td><input name="favorites_name" type="text" size="30" value="<?php echo $name;?>"></td>
      <td>&nbsp;</td>
    </tr>
    <tr>
      <td>&nbsp;</td>
      <td><input type="submit" name="Submit" value="<?php echo $title;?>">
      <input type="hidden" name="module" value="<?php echo $module;?>">
      <input type="hidden" name="url" value="<?php echo $url;?>">
      <input type="hidden" name="Flag" value="<?php echo $FL;?>">
	  <input type="hidden" name="favoristes_id" value="<?php echo $_GET[Fid];?>">
	  <input type="hidden" name="type" value="<?php echo $_GET[type];?>"></td>
      <td>&nbsp;</td>
    </tr>
  </table>
</form>
</body>
</html>
<?php $db->db_close(); ?>