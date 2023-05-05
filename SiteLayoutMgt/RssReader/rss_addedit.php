<?php
include("../lib/permission1.php");
include("../lib/include.php");
include("../lib/function.php");
include("../lib/user_config.php");
include("../lib/connect.php");
include("../language/rss_language.php");
if(!$db->check_permission("rss","w","")){
				?>
				<script language="JavaScript">
				alert("You can not access this section!!");
				window.history.back();
				</script>
				<?php
}
$cid=$_GET[cid];

	?>
<html>
<head>
<title>Article Management</title>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<link href="../theme/main_theme/css/style.css" rel="stylesheet" type="text/css">
</head>
<body leftmargin="0" topmargin="0" >
  
  <?php include("../FavoritesMgt/favorites_include.php");?>
<?php
if($cid){
	$text_genrss_function2=$text_genrss_function22;
}else{
	$text_genrss_function2=$text_genrss_function21;
}
?>
<?php
								
								if($cid){
								   $query=$db->query("SELECT * FROM rss WHERE rss_id = '$cid' "); 
								   $G = $db->db_fetch_array($query);
								   $button ="<input type=\"submit\" name=\"savenew\"  value=\" $text_genrss_formupdate \" onClick=\"document.rssForm.Flag.value='EditRSS'; \">";
								}else{
								    $button ="<input type=\"submit\" name=\"savenew\"  value=\" $text_genrss_formsubmit \" onClick=\"document.rssForm.Flag.value='AddNew'; \">";
								}
								?>
<table width="80%" border="0" align="center" cellpadding="5" cellspacing="0">
  <tr> 
    <td><img src="../theme/main_theme/rss_function.gif" width="32" height="32" align="absmiddle"> <span class="ewtfunction"><?php echo $text_genrss_function1;?></span> </td>
  </tr>
</table>
<table width="94%" border="0" align="center" cellpadding="0" cellspacing="0" class="ewtfunctionmenu">
  <tr>
    <td align="right"><a href="javascript:void(0);" onClick="load_divForm('../FavoritesMgt/favorites_add.php?name=<?php echo urlencode ($text_genrss_function2.'รายชื่อ RSS '.$G[rss_title]); ?>&module=rss&url=<?php if($cid !=''){echo urlencode ('rss_addedit.php?cid='.$cid); }else{ echo urlencode ("rss_addedit.php");}?>', 'divForm', 300, 80, -1,433, 1);"><img src="../images/star_yellow_add.gif" width="16" height="16" border="0" align="middle">&nbsp;Add to favorites </a>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<a href="rss.php" target="_self"><img src="../theme/main_theme/g_mainpage.gif" width="16" height="16" align="absmiddle" border="0"> 
      <?php echo $text_genrss_manage;?></a>
      <hr>
    </td>
  </tr>
</table>

<table width="94%"  border="0" cellpadding="0" cellspacing="0" bgcolor="E0DFE3" align="center">
  <tr>
    <td> 
								<table width="100%"  border="0" cellpadding="5" cellspacing="1" class="ewttableuse">
								
								<form name="rssForm"  method="post" action="rss_function.php">
								<input type="hidden" name="Flag" value="">
								<input type="hidden" name="cid" value="<?php echo $cid?>">
								 <tr class="ewttablehead"> 
									<td  colspan="2"> <?php echo $text_genrss_function2;?></td> 
								  </tr>
								  <tr bgcolor="#FFFFFF"> 
									<td width="27%"><?php echo $text_genrss_formname;?> </td>
									<td  width="93%" align="left"><input type="text" name="rss_title" size="60" value="<?php echo $G[rss_title] ?>"></td>
								  </tr>
								  <tr bgcolor="#FFFFFF"> 
									<td width="27%"><?php echo $text_genrss_formurl;?> </td>
									<td  align="left"><input type="text" name="rss_url" size="60"  value="<?php echo $G[rss_url] ?>"></td>
								  </tr>
								  <tr bgcolor="#FFFFFF"> 
									<td width="27%"><?php echo $text_genrss_formrow;?> </td>
									<td  align="left"><input type="text" name="rss_row" size="5"  value="<?php echo $G[rss_row] ?>"></td>
								  </tr>
                  <tr bgcolor="#FFFFFF"> 
									<td width="27%"><?php echo $text_genrss_formcontain;?> </td>
									<td  align="left"><textarea name="rss_contain" cols="60" rows="10"><?php echo $G['rss_contain']; ?></textarea></td>
								  </tr>
								  <tr bgcolor="#FFFFFF"> 
									<td width="27%"></td>
									
            <td  align="left"><?php echo $button?></td>
								  </tr>
								  </form >
								</table>
    </td>
  </tr>
</table>
</body>
</html>
<?php $db->db_close(); ?>
