<?php
include("../lib/permission1.php");
include("../lib/include.php");
include("../lib/function.php");
include("../lib/user_config.php");
include("../lib/connect.php");
include("../language/menu_language.php");
function GenPic($data){
$s = explode("_",$data);
	for($i=2;$i<count($s);$i++){
		echo "<img src=\"../images/o.gif\" width=\"20\" height=\"20\" border=\"0\" align=\"absmiddle\">";
	}
}

$sql_menu = $db->query("SELECT m_id,m_name FROM menu_list WHERE m_id = '".$_GET["m_id"]."' ");
$M = $db->db_fetch_array($sql_menu);
$sql_menu_sub = $db->query("SELECT mp_id,m_id,mp_name FROM menu_properties WHERE m_id = '".$_GET["m_id"]."' ORDER BY mp_id ASC");
?>
<html>
<head>
<title><?php echo $EWT_title ?></title>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<link href="../theme/main_theme/css/style.css" rel="stylesheet" type="text/css">
<SCRIPT language=JavaScript>
			function exit(){
				self.top.ewt_main.location.href = "menu_index.php";
			}
			function hlah(c){
				var d = document.form1.num.value;
				for(i=0;i<d;i++){
				if(i == c){
					document.getElementById('ah'+i).style.backgroundColor = "#E6E6E6";
				}else{
					document.getElementById('ah'+i).removeAttribute("style");
				}
				}
			}
</SCRIPT>
</head>
<body leftmargin="0" topmargin="0">
<?php include("../FavoritesMgt/favorites_include.php");?>
<table width="100%" height="100%" border="0" cellpadding="1" cellspacing="1" bgcolor="#333333" class="ewttableuse">
  <form name="form1" method="post" action="">
    <tr> 
      <td height="15" ><img src="../theme/main_theme/menu_structure.gif" width="24" height="24" align="absmiddle"> <?php echo $text_menu_structure; ?></td>
           <td width="40%" valign="bottom"  class="ewtnormal"><a href="javascript:void(0);" onClick="load_divForm('../FavoritesMgt/favorites_add.php?name=<?php echo urlencode('แก้ไขเมนู>>'.$M[m_name]);?>&module=menu&url=<?php echo urlencode("menu_main.php?m_id=".$M[m_id]);?>', 'divForm', 300, 80, -1,433, 1);"><img src="../images/star_yellow_add.gif" width="16" height="16" border="0" align="absmiddle">&nbsp;Add to favorites </a>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
    </tr>
    <tr>
      <td height="15" colspan="2" bgcolor="#FFFFFF" ><a id="ah0" href="menu_properties.php?m_id=<?php echo $_GET["m_id"];  ?>" target="menu_bottom" onClick="hlah('<?php echo $i; ?>')"><img src="../theme/main_theme/menu_list.gif" width="21" height="20" border="0" align="absmiddle">&nbsp;&nbsp;<?php echo $M["m_name"]; ?></a></td>
    </tr>
    <tr> 
      <td colspan="2" valign="top" bgcolor="#FFFFFF"> <table width="100%" border="0" cellspacing="0" cellpadding="0">
          <?php 
	$i = 1;
		while($R = $db->db_fetch_array($sql_menu_sub)){
	 ?>
          <tr> 
            <td valign="top">&nbsp;&nbsp;&nbsp;&nbsp;
              <?php GenPic($R[mp_id]); ?>
              <a id="ah<?php echo $i; ?>" href="menu_detail.php?mp_id=<?php echo $R[mp_id]; ?>" target="menu_bottom" onClick="hlah('<?php echo $i; ?>')" <?php if($_SESSION["EWT_MENU_POSITION"] == $R[mp_id]){ ?>style="background-color:'#DDDDDD'"<?php } ?>><img src="../theme/main_theme/menu_list.gif" width="21" height="20" border="0" align="absmiddle"> 
              <?php echo $R["mp_name"]; ?></a></td>
          </tr>
          <?php $i++; } ?>
        </table>
        <input name="num" type="hidden" id="num" value="<?php echo $i; ?>"> </td>
    </tr>
  </form>
</table>
</body>
</html>
<?php
$db->db_close(); ?>
