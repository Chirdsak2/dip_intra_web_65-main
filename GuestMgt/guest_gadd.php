<?php
include("administrator.php");
include("lib/include.php");
include("inc.php");
include("../language/guest_language.php");

if($_POST["flag"] == "add"){
	$sql = "
		INSERT INTO guest_cate(
			gc_name
		)VALUES(
			'".$_POST["gc_name"]."'
		)
	";
	$db->query($sql);
	echo "
		<script>alert('Insert guestbook group success.');window.location.assign('guest_group.php');</script>
	";
	exit;
}elseif($_POST["flag"] == "edit"){
	$sql = "
		UPDATE guest_cate
		SET
			gc_name = '".$_POST["gc_name"]."'
		WHERE
			gc_id = '".$_POST["gc_id"]."'
	";
	$db->query($sql);
	echo "
		<script>alert('Update guestbook group success.');window.location.assign('guest_group.php');</script>
	";
	exit;
}elseif($_GET["flag"] == "del"){
	$sql = "DELETE FROM guest_cate WHERE gc_id = '".$_GET["gc_id"]."' ";
	$db->query($sql);
	echo "
		<script>alert('Delete guestbook group success.');window.location.assign('guest_group.php');</script>
	";
	exit;
}

if($_GET["gc_id"]){
	$sql= "SELECT * FROM guest_cate WHERE gc_id = '".$_GET["gc_id"]."' ";
	$rec_gc = $db->db_fetch_array($db->query($sql));
}
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
<form name="form1" method="post" action="">
<table width="80%" border="0" align="center" cellpadding="5" cellspacing="0">
  <tr> 
    <td><img src="../theme/main_theme/guest_function_config.gif" width="32" height="32" align="absmiddle"> <span class="ewtfunction"><?php echo $text_genguest_function2;?></span> </td>
  </tr>
</table>
<table width="94%" border="0" align="center" cellpadding="0" cellspacing="0" class="ewtfunctionmenu">
  <tr>
    <td align="right"><a href="javascript:void(0);" onClick="load_divForm('../FavoritesMgt/favorites_add.php?name=<?php echo urlencode($text_genguest_function2);?>&module=guestbook&url=<?php echo urlencode("guest_config.php");?>', 'divForm', 300, 80, -1,433, 1);"><img src="../images/star_yellow_add.gif" width="16" height="16" border="0" align="middle">&nbsp;Add to favorites </a>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<!--<a href="guest_cate.php" target="_self"><img src="../theme/main_theme/g_edit.gif" width="16" height="16" align="absmiddle" border="0"> 
      <?php//php echo $text_genguest_manage;?></a>--><hr>
    </td>
  </tr>
</table>
  <table width="94%" border="0" cellpadding="0" cellspacing="0">
    <tr valign="top">
      <td colspan="2"><?php @include("com_top.php"); ?></td>
    </tr>
    <tr>
      <td valign="top"></td>
      <td width="100%" height="100%" valign="top">
	  
	  <table width="100%" height="100%" border="0" cellpadding="0" cellspacing="0" class="normal_font">
   
          <tr> 
            <td colspan="2" valign="top"> 
									<table  width="70%" border="0" align="center" cellpadding="5" cellspacing="1" bgcolor="#FFCC66" class="ewttableuse" >
									<?php
											$sql = " SELECT * FROM guest_config ";
											$query= mysql_query($sql);
											$num = mysql_num_rows($query);
											if($num != 0){
													$rec = mysql_fetch_array($query);
											}
									?>
						<tr  class="ewttablehead"> 
							<td width="72%" height="30" colspan="2">เพิ่ม/แก้ไข หัวข้อ </td>
					  </tr>
											<tr bgcolor="#FFFFFF" height="30">
													<td width="72%" >หัวข้อ</td>
													<td width="76%" align="left">
														<input name="gc_name" type="text" id="gc_name" value="<?php echo $rec_gc['gc_name']; ?>">
														<input name="flag" type="hidden" id="flag" value="<?php echo $_GET["flag"]; ?>">
														<input name="gc_id" type="hidden" id="gc_id" value="<?php echo $_GET["gc_id"]; ?>"></td>
											</tr>
											<!--<tr bgcolor="#FFFFFF" height="30">
													<td width="24%" align="left" ><?php///php echo $text_genguest_formdate?>												</td>
													<td width="76%" align="left">
														<input name="date_data" type="text" size="10" maxlength="10" value="<?php//=$rec['guest_config_date']?>">
														<?php///php echo $text_genguest_formdates?></td>
											</tr>-->
									  
  <tr bgcolor="#FFFFFF">
    <td>&nbsp;</td>
    <td><input type="submit" name="Submit" value="<?php echo $text_genguest_formsubmit;?>" class="normaltxt"> 
                                   <input type="button" name="Submit2" value="<?php echo $text_genguest_formreset;?>" class="normaltxt" ></td>
  </tr>
			    </table>
			  </td>
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
