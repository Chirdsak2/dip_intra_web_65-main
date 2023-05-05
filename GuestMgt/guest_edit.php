<?php
include("administrator.php");
include("lib/include.php");
include("inc.php");
include("../language/guest_language.php");
?>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<link href="../theme/main_theme/css/style.css" rel="stylesheet" type="text/css">
<style type="text/css">
<!--
a:link { color: #005CA2; text-decoration: none}
a:visited { color: #005CA2; text-decoration: none}
a:active { color: #0099FF; text-decoration: none}
a:hover { color: #0099FF; text-decoration: none}
-->
</style>
</head>
<body leftmargin="0" topmargin="0" class="normal_font">
<?php include("../FavoritesMgt/favorites_include.php");?>
<div align="center">
<form name="form1" method="post" action="guest_function.php">
<table width="80%" border="0" align="center" cellpadding="5" cellspacing="0">
  <tr> 
    <td><img src="../theme/main_theme/guest_function.gif" width="32" height="32" align="absmiddle"> <span class="ewtfunction"><?php echo $text_genguest_function1;?></span> </td>
  </tr>
</table>			<?php
											$sql = " SELECT * FROM guestbook_list WHERE id_guest = '".$_GET["id_guest"]."'";
											$query= mysql_query($sql);
											$num = mysql_num_rows($query);
											if($num != 0){
													$rec = mysql_fetch_array($query);
											}
									?>
<table width="94%" border="0" align="center" cellpadding="0" cellspacing="0" class="ewtfunctionmenu">
  <tr>
    <td align="right"><a href="javascript:void(0);" onClick="load_divForm('../FavoritesMgt/favorites_add.php?name=<?php echo urlencode($text_genguest_edittext.$rec['detail_guest']);?>&module=guestbook&url=<?php echo urlencode("guest_edit.php?id_guest=".$_GET["id_guest"]);?>', 'divForm', 300, 80, -1,433, 1);"><img src="../images/star_yellow_add.gif" width="16" height="16" border="0" align="middle">&nbsp;Add to favorites </a>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<a href="guest_cate.php" target="_self"><img src="../theme/main_theme/g_edit.gif" width="16" height="16" align="absmiddle" border="0"> 
      <?php echo $text_genguest_manage;?></a><hr>
    </td>
  </tr>
</table>
  <table width="70%" border="0" cellpadding="0" cellspacing="0">
    <tr valign="top">
      <td colspan="2"><?php @include("com_top.php"); ?></td>
    </tr>
    <tr>
      <td valign="top"></td>
      <td width="100%" height="100%" valign="top">
	  
	  <table width="100%" height="100%" border="0" cellpadding="0" cellspacing="0" class="normal_font">
   
          <tr> 
            <td colspan="2" valign="top"> 
									<table  width="100%" border="0" align="center" cellpadding="5" cellspacing="1" bgcolor="#FFCC66" class="ewttableuse" >
						
						<tr  class="ewttablehead"> 
							<td width="72%" height="30" colspan="2"><?php echo $text_genguest_edittext?></td>
					  </tr>
											<tr bgcolor="#FFFFFF" height="30">
											  <td width="38%" valign="top" bgcolor="#FFFFFF" ><?php echo $text_genguest_edittext?> </td>
									          <td width="62%" align="left"> 
								              <textarea name="message" cols="30" rows="5"><?php echo $rec['detail_guest']?></textarea></td>
									  </tr>
									  
  <tr bgcolor="#FFFFFF">
    <td>&nbsp;</td>
    <td><input type="submit" name="Submit" value="<?php echo $text_genguest_formsubmit;?>" class="normaltxt"> 
                                   <input type="button" name="Submit2" value="<?php echo $text_genguest_formreset;?>" class="normaltxt" > 
								<input type="hidden" name="type_page" value="edit" class="normaltxt">  
								<input type="hidden" name="id_guest" value="<?php echo $_GET["id_guest"];?>" class="normaltxt"></td>
  </tr>
							  </table>
			  </td>
		    </tr>
          </table>
      </td>
    </tr>
    <tr valign="top">
      <td colspan="2"><?php @include("com_bottom.php"); ?></td>
    </tr>
  </table>
  </form>
</div>
</body>
</html>
<?php $db->db_close(); ?>
