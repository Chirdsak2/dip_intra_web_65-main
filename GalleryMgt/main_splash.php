<?php
	session_start();
	include("../lib/permission1.php");
	include("../lib/include.php");
	include("../lib/function.php");
	include("../lib/user_config.php");
	include("../lib/connect.php");
	
	if($db->check_permission("Gallery","s","")){
	$Globals_Dir = "../ewt/".$_SESSION["EWT_SUSER"]."/";
	$sql_splash = "SELECT * FROM splash_img, gallery_image where splash_img_id = img_id order by splash_start_date";
	$result_splash = $db->query($sql_splash);
	

?>
<html>
<head>
<title><?php echo $EWT_title ?></title>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<link href="../theme/main_theme/css/style.css" rel="stylesheet" type="text/css">
<link href="style_calendar.css" rel="stylesheet" type="text/css">
<script src="../js/AjaxRequest.js"></script>
<script language="JavaScript"  type="text/javascript" src="js/calendar.js"></script>
<script language="JavaScript"  type="text/javascript" src="js/loadcalendar.js"></script>
<script language="JavaScript"  type="text/javascript" src="js/calendar-th.js"></script>
<script language="javascript1.2">
function selColor(c,d,e){
	Win2=window.open('../ewt_color.php?c_value='+ c +'&c_block=' + d + '&c_preview='+ e +'','sel', 'height=175,width=245, status=0, menubar=0,resizable=no, location=0, scrollbars=no, left=400, top=300');
}
function CreColor(va,bg,pre,flag){
	bg.style.backgroundColor= va;
	if(flag == 'color'){
		pre.style.color = va;
	}else{
		pre.style.backgroundColor = va;
	}
}
</script>
</head>
<body leftmargin="0" topmargin="0">
<?php include("../FavoritesMgt/favorites_include.php");?>
<div id="nav" style="position:absolute;width:400px;  z-index:1;display:none" ></div>
	<form name="form1" action="gallery_process_img.php" method="post" enctype="multipart/form-data">
	<input type="hidden" name="flag" value="edit_splash">
	<table width="80%" border="0" align="center" cellpadding="5" cellspacing="0">
		<tr> 
			<td><img src="../theme/main_theme/gallery_function_cat.gif" width="32" height="32" align="absmiddle"><span class="ewtfunction"><?php echo $text_genGallery_modulesub_splash;?></span> </td>
		</tr>
		<tr>
		  <td align="right"><a href="javascript:void(0);" onClick="load_divForm('../FavoritesMgt/favorites_add.php?name=<?php echo urlencode("จัดการ Splash Page");?> &module=gallery&url=<?php echo urlencode("main_splash.php");?>', 'divForm', 300, 80, -1,433, 1);"><img src="../images/star_yellow_add.gif" width="16" height="16" border="0" align="absmiddle">&nbsp;Add to favorites </a>&nbsp;</td>
	  </tr>
	</table>
	<table width="94%" border="0" align="center" cellpadding="0" cellspacing="0" class="ewtfunctionmenu">
		<tr><td align="right"><hr></td></tr>
	</table>
	<table width="94%" border="0" align="center" cellpadding="5" cellspacing="1" bgcolor="#CECECE" class="ewttableuse">
		<tr bgcolor="#E7E7E7"  class="ewttablehead"> 
			<td width="60" height="30" align="center">&nbsp;</td>
			<td>รูปภาพ</td>
			<td align="center">รายละเอียด</td>
			<td align="center">วันเริ่มต้น-สิ้นสุด</td>
			<td>ข้อความ</td>
			<td width="100" align="center">สถานะการแสดง</td>
		</tr>
		<?php
			$num = $db->db_num_rows($result_splash);
			if($num > 0){
				$i = 0;
				$LenChk =0;
				while($row_splash = $db->db_fetch_array($result_splash)){
		?>
		<tr bgcolor="#FFFFFF"> 
			<td align="center" valign="top">
				<nobr>
				<span style="cursor:hand" onClick=" if(confirm('ยืนยันการลบ')){location.href = 'gallery_process_img.php?flag=del_splash&process=1&img_id=<?php echo $row_splash['img_id']?>';}"><img src="../theme/main_theme/g_garbage.png" width="16" height="16" align="absmiddle" alt="ลบ"></span>				</nobr>			</td>
			<td valign="top">
				<input type="hidden" name="img_id[]" value="<?php echo $row_splash['img_id']?>">
				<img src="phpThumb.php?src=<?php echo $Globals_Dir?><?php echo $row_splash['img_path_b']; ?>&h=100&w=150" border=1>
		  </td>
		  <td valign="top"><table width="100%" border="0">
                  <tr>
                    <td>สีพื้นหลัง :</td>
                    <td><a id="CPreview<?php echo $row_splash['img_id']?>" style="background-color: <?php echo $row_splash['splash_bgcolor']?>" onClick="selColor('window.opener.document.form1.splash_bgcolor<?php echo $row_splash['img_id']?>.value','window.opener.document.all.CPreview<?php echo $row_splash['img_id']?>.style.backgroundColor');"><img src="../images/box_color.gif" width="21" height="23" align="absmiddle"></a>
                      <input name="splash_bgcolor<?php echo $row_splash['img_id']?>" type="text" value="<?php echo $row_splash['splash_bgcolor']?>" size=6 maxlength="7" ></td>
                  </tr>
                  <tr>
                    <td>รูปพื้นหลัง : </td>
                    <td><input name="file<?php echo $row_splash['img_id']?>" type="file" id="file<?php echo $row_splash['img_id']?>">
                    <input type="hidden" name="hdd_splash_bg_img<?php echo $row_splash['img_id']?>" value="<?php echo $row_splash['splash_bg_img']?>"></td>
                  </tr>
                  <tr>
                    <td>ข้อความ link :</td>
                    <td><input name="splash_text_link<?php echo $row_splash['img_id']?>" type="text" id="splash_text_link<?php echo $row_splash['img_id']?>"  value="<?php echo $row_splash['splash_text_link']?>"></td>
                  </tr>
                  <tr>
                    <td>สี link  : </td>
                    <td><a id="CPreview2<?php echo $row_splash['img_id']?>" style="background-color: <?php echo $row_splash['splash_text_color']?>" onClick="selColor('window.opener.document.form1.splash_bgcolor_link<?php echo $row_splash['img_id']?>.value','window.opener.document.all.CPreview2<?php echo $row_splash['img_id']?>.style.backgroundColor');"><img src="../images/box_color.gif" width="21" height="23" align="absmiddle"></a>
                      <input name="splash_bgcolor_link<?php echo $row_splash['img_id']?>" type="text" id="splash_bgcolor_link<?php echo $row_splash['img_id']?>" value="<?php echo $row_splash['splash_text_color']?>" size=6 maxlength="7" ></td>
                  </tr>
                </table></td>
			<td align="center" valign="top">
			<?php
				if(($row_splash['splash_start_date'] == '0000-00-00' || is_null($row_splash['splash_start_date']))) {
					$start_date = '';//date('d/m/').(date('Y')+543);
				} else {
					$date1 = explode('-', $row_splash['splash_start_date']);
					$start_date = $date1[2]."/".$date1[1]."/".($date1[0]+543);
				}
				if(($row_splash['splash_end_date'] == '0000-00-00' || is_null($row_splash['splash_end_date']))) {
					$end_date = '';//date('d/m/').(date('Y')+543);
				} else {
					$date1 = explode('-', $row_splash['splash_end_date']);
					$end_date = $date1[2]."/".$date1[1]."/".($date1[0]+543);
				}
			?>
			<input name="splash_start_date<?php echo $row_splash['img_id']?>" type="text" size="10" maxlength="10" id="splash_start_date" value="<?php echo $start_date; ?>">
			<img src="<?php echo $path_cal;?>images/b_calendar.gif" alt=".เลือกวันเริ่มต้น." width="22" height="23" border="0" align="absmiddle" onClick="return showCalendar('splash_start_date<?php echo $row_splash['img_id']?>', 'dd-mm-y');" onMouseOver="this.style.cursor='hand';">
			<br><br>
			<input name="splash_end_date<?php echo $row_splash['img_id']?>" type="text" size="10" maxlength="10" id="splash_end_date" value="<?php echo $end_date; ?>">
			<img src="<?php echo $path_cal;?>images/b_calendar.gif" alt=".เลือกวันสิ้นสุด." width="22" height="23" border="0" align="absmiddle" onClick="return showCalendar('splash_end_date<?php echo $row_splash['img_id']?>', 'dd-mm-y');" onMouseOver="this.style.cursor='hand';">
			</td>
		  <td valign="top"><textarea name="splash_text<?php echo $row_splash['img_id']?>" cols="30" rows="5" ><?php echo stripslashes($row_splash['splash_text']); ?></textarea>
		    <br>
			
		    <a href="#view" onClick="window.open('../ewt/<?php echo $_SESSION["EWT_SUSER"]; ?>/gallery_ewt_editor.php?img_id=<?php echo $row_splash['img_id']?>', 'select_gallery', 'status=yes, menubar=no, scrollbars=yes, resizable=yes, height=450, width=600, left=150,top=100');">[<img src="../theme/main_theme/g_edit.gif" width="16" height="16" border="0"> used editor]</a></td>
			<td align="center" valign="top"><input name="splash_status<?php echo $row_splash['img_id']?>" id="splash_status" class="splash" type="checkbox" value="1" <?php if($row_splash['splash_status'] == 'Y') { echo "checked"; }?>></td>
		</tr>
		<?php 
					$i++; 
				} 
		?>
		<tr align="right" bgcolor="#FFFFFF"><td colspan="5">&nbsp;</td><td align="center"><input name="submit" type="submit" value="บันทึก"></td></tr>
		<?php 
			}
		?>
	</table>
	</form>
	<br>
	<br>
</body>
</html>
<?php 
}
$db->db_close(); ?>
<script language="javascript1.2">
</script>