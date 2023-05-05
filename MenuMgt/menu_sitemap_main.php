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
<?php include("../FavoritesMgt/favorites_include.php");?>
<table width="80%" border="0" align="center" cellpadding="5" cellspacing="0">
  <tr> 
    <td><img src="../theme/main_theme/sitemap_function.gif" width="32" height="32" align="absmiddle"> <span class="ewtfunction"><?php echo $text_gensmap_module;?></span></td>
  </tr>
</table>
<table width="94%" border="0" align="center" cellpadding="0" cellspacing="0" class="ewtfunctionmenu">
  <tr>
    <td align="right"><a href="javascript:void(0);" onClick="load_divForm('../FavoritesMgt/favorites_add.php?name=<?php echo urlencode($text_gensmap_module);?>&module=sitemap&url=<?php echo urlencode("menu_sitemap_main.php");?>', 'divForm', 300, 80, -1,433, 1);"><img src="../images/star_yellow_add.gif" width="16" height="16" border="0" align="absmiddle">&nbsp;Add to favorites </a>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<a href="menu_sitemap_add.php"><img src="../theme/main_theme/g_add.gif" width="16" height="16" border="0" align="absmiddle"> 
     <?php echo $text_gensmap_sitemapadd;?> </a>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
      <hr>
    </td>
  </tr>
</table>
<table width="94%" border="0" align="center" cellpadding="5" cellspacing="1" bgcolor="#CECECE" class="ewttableuse">
  <tr bgcolor="#E7E7E7"  class="ewttablehead"> 
    <td width="5%" height="30" align="center">&nbsp;</td>
    <td >Sitemap Name</td>
  </tr>
  <?php
  $sql = "select * from menu_setting"; 
  $query = $db->query($sql);
  while($R = $db->db_fetch_array($query)){
		switch($R['s_map_type']) {
			case '1':
				$url='menu_sitemap_list.php';
				break;
			case '2':
				$url='menu_sitemap_page_list.php';
				break;
			default:
				$url='menu_sitemap_list.php';
				break;
		}
  ?>
  <tr bgcolor="#FFFFFF"> 
    <td align="center"><nobr><a href="menu_sitemap_add.php?sid=<?php echo $R[s_id]; ?>&type=edit"><img src="../theme/main_theme/g_edit.gif" alt="แก้ไข" width="16" height="16" border="0"></a> 
      <a href="menu_sitemap_function.php?sid=<?php echo $R[s_id]; ?>&Flag=delete"><img src="../theme/main_theme/g_del.gif" alt="ลบข้อมูล" width="16" height="16" border="0" onClick="return confirm('ต้องการลบข้อมูลหรือไม่');" onMouseOver="this.style.cursor='hand';" ></a> 
	  <a href="#sview" onClick="window.open('<?php echo $url; ?>?sid=<?php echo $R[s_id]; ?>', 'sitemapMgt', 'status=yes, menubar=no, scrollbars=yes, resizable=yes, height=500, width=700, left=150,top=100');"><img src="../theme/main_theme/g_folder_add.gif" alt="<?php echo $text_gensmap_sitemapadd_sub;?>" width="16" height="16" border="0"></a>
	  </nobr></td>
    <td><?php echo $R[s_name];?></td>
  </tr>

  <?php } ?>
  <?php if($db->db_num_rows($query) == '0'){ ?>
    <tr bgcolor="#FFFFFF">
    <td colspan="2" align="center">ไม่พบข้อมูล</td>
  </tr>
  <?php }?>
</table>
<table width="94%" border="0" align="center" cellpadding="3" cellspacing="0">
  <tr>
    <td>&nbsp;</td>
  </tr>
</table>
</body>
</html>
<?php
$db->db_close(); ?>