<?php
	session_start();
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
<script src="js/AjaxRequest.js"></script>
<script src="js/excute.js"></script>
<?php
	if($_POST[page_cat]) $page_cat = $_POST[page_cat];
	else $page_cat = $_GET[page_cat];
	if($_POST[category_id]) $category_id = $_POST[category_id];
	else $category_id = $_GET[category_id];
	if($_POST[img_id]) $img_id = $_POST[img_id];
	else $img_id = $_GET[img_id];
	$Globals_Dir = "../ewt/".$_SESSION["EWT_SUSER"]."/";
	$sql_category = "SELECT * FROM gallery_category WHERE category_id = '".$_GET[category_id]."' ";
	$query_category = $db->query($sql_category);
	$rs_category = $db->db_fetch_array($query_category);
	$hi = $rs_category[height_b];
	$wi = $rs_category[width_b];
	$sql_img = "SELECT * FROM gallery_image WHERE img_id = '".$_GET[img_id]."' ";
	$query_img = $db->query($sql_img);
	$rs_img = $db->db_fetch_array($query_img);
?>
	<table width="80%" border="0" align="center" cellpadding="5" cellspacing="0">
		<tr><td><img src="../theme/main_theme/logo.gif" width="32" height="32" align="absmiddle"> <span class="ewtfunction">กำหนด Splash Page</span> </td></tr>
	</table>
	<table width="94%" border="0" align="center" cellpadding="0" cellspacing="0" class="ewtfunctionmenu">
		<tr>
			<td align="right">
				<span style="cursor:hand" onClick="location.href = 'gallery_view_category.php?category_id=<?php echo $_GET[category_id]?>&page=<?php echo $page_cat?>'; "><img src="../theme/main_theme/g_back.png" width="16" height="16" align="absmiddle" > กลับหน้าก่อนหน้า</span>
				<hr>
			</td>
		</tr>
	</table>
	<table width="600"  border="0" align="center" cellpadding="0" cellspacing="0">
		<tr><td valign="top">&nbsp;</td></tr>
		<tr>
			<td valign="top">
				<table width="100%" border="0" cellpadding="3" cellspacing="1">
					<tr>
						<td align="center" valign="middle" bgcolor="#FFFFFF"  style="color:#FFFFFF">
							<table  border="0" cellpadding="1" cellspacing="1" bgcolor="#999999" width="<?php echo $wi;?>" height="<?php echo $hi;?>">
								<tr><td bgcolor="#FFFFFF" align="center"><img src="phpThumb.php?src=<?php echo $Globals_Dir.$rs_img[img_path_b]?>&h=<?php echo $wi;?>&w=<?php echo $hi;?>" hspace="0" vspace="0" align="middle" ></td></tr>
							</table>
							<br><strong style="color:#000000"><?php echo " ชื่อรูป : ".$rs_img[img_name]?></strong>
						</td>
					</tr>
				</table>
			</td>
		</tr>
		<!--
		<tr>
		<td colspan="2" align="center">vote : &nbsp;&nbsp;&nbsp;            
		<input name="vote" type="radio" value="5"> 
		5
		<input name="vote" type="radio" value="4"> 
		4
		<input name="vote" type="radio" value="3" checked="checked"> 
		3
		<input name="vote" type="radio" value="2"> 
		2
		<input name="vote" type="radio" value="1"> 
		1                </td>
		</tr>-->
	</table>
	<br>
	<div id="div_comment">
	<table width="600" border="0" align="center" cellpadding="0" cellspacing="1">
		<tr><th scope="col"><div align="right">&nbsp;&nbsp;</div></th></tr>
	</table>
	
</div>
<br>
<form name="frm" action="gallery_process_comment.php" method="post">
	<input type="hidden" name="category_id" value="<?php echo $category_id?>">
	<input type="hidden" name="page_cat" value="<?php echo $page_cat?>">
	<input type="hidden" name="img_id" value="<?php echo $img_id?>">
	<!--<table width="600"  border="0" align="center" cellpadding="0" cellspacing="1">
	<tr>
	<td valign="top"><table width="100%" border="0" cellspacing="0" cellpadding="0">
	<tr>
	<td height="6" width="7">&nbsp;</td>
	<td></td>
	<td height="6" width="7">&nbsp;</td>
	</tr>
	<tr>
	<td width="7" height="21" class="ewthead"></td>
	<td height="44" valign="top"  class="ewthead"><strong> &bull; กรุณาแสดงความคิดเห็น</strong></td>
	<td height="21" width="7" valign="top"></td>
	</tr>
	</table></td>
	</tr>
	<tr>
	<td valign="top"><table width="100%" border="0" cellpadding="3" cellspacing="1">
	<tr>
	<td align="center" valign="top" bgcolor="#FFFFFF"  style="color:#FFFFFF">
	<table width="100%" border="0">
	<tr>
	<th width="15%" scope="col"><div align="right">ชื่อ : &nbsp;&nbsp;&nbsp;</div></th>
	<th width="85%" scope="col"><div align="left">&nbsp;&nbsp;
	<label>
	<input name="name" type="text" size="50">
	</label>
	</div></th>
	</tr>
	<tr>
	<td valign="top"><div align="right"><strong>รายละเอียด : &nbsp;&nbsp;&nbsp;</strong></div></td>
	<td><div align="left">&nbsp;&nbsp;
	<label>
	<textarea name="comment" cols="75" rows="5" onKeyUp="if(this.value.length%50 == 0){}"></textarea>
	</label>
	</div></td>
	</tr>
	
	<!--<tr>
	<td><div align="right"><strong>ส่ง E-mail :&nbsp;&nbsp;&nbsp;&nbsp; </strong></div></td>
	<td>&nbsp;&nbsp;
	<input name="email" type="text" size="50"></td></tr>
	<tr>-->
	<!--<td>&nbsp;</td>
	<td>&nbsp;&nbsp;
	<input type="submit" name="Submit" value="ส่งความคิดเห็น" onClick="return chk_name(this.form)">
	<input type="hidden" name="flag" value="add">
	<input type="hidden" name="fn" value="gallery_view_img_comment2.php">
	&nbsp;&nbsp;
	<label>
	<input type="reset" name="Submit2" value="ล้างข้อมูล">
	</label></td>
	</tr>
	</table></td>
	</tr>
	</table></td>
	</tr>
	</table>-->
<script>
function chk_name(me) {
	if(me.name.value == ""){
		alert('กรุณากรอกชื่อ');
		me.name.focus();
		return false;
	}
	return true;
}
</script>
</form>
</body>
</html>
<?php $db->db_close(); ?>
