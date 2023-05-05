<?php
include("../lib/permission1.php");
include("../lib/include.php");
include("../lib/function.php");
include("../lib/user_config.php");
include("../lib/connect.php");
$db->query("USE ".$EWT_DB_USER);
if($_GET[del]){
    $share_file_name="../share_content/".$_SESSION["EWT_SUSER"]."_ewt_".$_GET[del].".inc";
    @unlink($share_file_name);
    $db->query("DELETE FROM share_content WHERE s_id = '".$_GET[sdel]."'");
}
$sql_group = $db->query("SELECT * FROM share_content WHERE s_user = '".$_SESSION["EWT_SUSER"]."' ORDER BY s_user ASC");
	?>
<html>
<head>
<title><?php echo $EWT_title ?></title>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<link href="../theme/main_theme/css/style.css" rel="stylesheet" type="text/css">
<script language="JavaScript">
	function preview(c){
		window.open('../ewt/<?php echo $_SESSION["EWT_SUSER"]; ?>/ewt_share.php?inc='+c);
	}
	function choose(c){
		document.form1.inc.value = c;
		form1.submit();
		top.close();
	}
</script>
</head>
<body leftmargin="0" topmargin="0">
<table width="80%" border="0" align="center" cellpadding="5" cellspacing="0">
  <tr> 
    <td><img src="../theme/main_theme/fag_function.gif" width="32" height="32" align="absmiddle"> <span class="ewtfunction"> <?php echo $text_gensharecon_category;?></span> </td>
  </tr>
</table>
<table width="94%" border="0" align="center" cellpadding="0" cellspacing="0" class="ewtfunctionmenu">
  <tr>
    <td align="right"><!--a href="faq_add.php?type=category&flag=add"><img src="../theme/main_theme/g_add.gif" width="16" height="16" align="absmiddle" border="0" alt="<?php echo $text_general_add;?>"> 
      <?php echo $text_general_add;?> </a--> 
      <hr>
    </td>
  </tr>
</table>
<table width="94%" border="0" cellpadding="3" cellspacing="1" class="ewttableuse" align="center">
<form name="form1" method="post" action="content_function.php" target="save_function">
<input type="hidden" name="Flag" value="SetShare">
<input type="hidden" name = "filename" value = "<?php echo $_GET["filename"]; ?>">
<input type="hidden" name = "inc" >
</form>
  <tr align="center"   class="ewttablehead"> 
    <td width="10%"></td>
    <td width="50%" height="25"><strong><?php echo $text_gensharecon_blockname?></strong></td>
    <td width="30%"><strong><?php echo $text_gensharecon_lastupdate?></strong></td>
  </tr>
  <?php 
    	while($R = $db->db_fetch_array($sql_group)){
   ?>
  <tr>  
  <td align="center" valign="middle" bgcolor="#FFFFFF">
  <a href="#preview" onClick="preview('<?php echo $R["s_user"]; ?>_ewt_<?php echo $R["s_bid"]; ?>')"><img src="../theme/main_theme/g_view.gif" width="16" height="16" border="0" alt="<?php echo $text_gensharecon_view_alt;?>"></a>
  <a href="sharecon_main.php?del=<?php echo $R["s_bid"]; ?>&sdel=<?php echo $R["s_id"]; ?>" onClick="if(confirm('<?php echo $text_gensharecon_delete_confirm;?>')){}else{return false;}"><img src="../theme/main_theme/g_del.gif" width="16" height="16" border="0" alt="<?php echo $text_gensharecon_delete_alt;?>"></a>
  </td>
    <td valign="top" bgcolor="#FFFFFF"><?php echo $R["s_html"]; ?></td>
    <td valign="top" bgcolor="#FFFFFF" align="center"><?php echo $R["s_update"]; ?></td>
     </tr>
  <?php } ?>
</table>
</body>
</html>
<?php $db->db_close(); ?>
