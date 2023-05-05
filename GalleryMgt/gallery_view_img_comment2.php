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
		<tr><td><img src="../theme/main_theme/logo.gif" width="32" height="32" align="absmiddle"> <span class="ewtfunction">หมวด<?php echo $rs_category[category_name]?></span> </td></tr>
	</table>
	<table width="94%" border="0" align="center" cellpadding="0" cellspacing="0" class="ewtfunctionmenu">
		<tr>
			<td align="right">
				<!--<a href="#" onClick="location.href ='gallery_set_splash.php?img_id=<?php echo $rs_img[img_id]?>&flag=edit&category_id=<?php echo $_GET[category_id]?>&page_cat=<?php echo $page_cat?>';"><img src="../theme/main_theme/photo_scenery.jpg" width="16" height="16" border="0" align="absmiddle">&nbsp;กำหนดให้เป็น Splash Page</a>&nbsp;&nbsp;-->
				<?php if($db->check_permission("Gallery","p","")){?>
				<a href="#" onClick="location.href ='gallery_edit_img.php?img_id=<?php echo $rs_img[img_id]?>&flag=edit&category_id=<?php echo $_GET[category_id]?>&page_cat=<?php echo $page_cat?>';"><img src="../theme/main_theme/g_edit.gif" width="16" height="16" border="0" align="absmiddle">&nbsp;แก้ไขรูป&nbsp;&nbsp;</a>&nbsp;&nbsp;
				<span style="cursor:hand" onClick="if(confirm('ยืนยันการลบ')){location.href = 'gallery_process_img.php?flag=del&img_id=<?php echo $_GET[img_id]?>&category_id=<?php echo $_GET[category_id]?>'; }"><img src="../theme/main_theme/g_garbage.png" height="16" width="16" border="0" align="absmiddle" >&nbsp;ลบรูป</span>
				<?php } ?>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
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
								<tr><td bgcolor="#FFFFFF" align="center">
								<?php
																			//chk img or swf
																			$filetypename = explode('.',$rs_img[img_path_b]);
																			
																			if($filetypename[1] == 'swf'){
																			echo '<object classid="clsid:D27CDB6E-AE6D-11cf-96B8-444553540000" codebase="http://download.macromedia.com/pub/shockwave/cabs/flash/swflash.cab#version=7,0,0,0" width="'.$wi.'" height="'.$hi.'">
										  <param name="flash_component" value="ImageViewer.swc" />
										  <param name="movie" value="'.$Globals_Dir.$rs_img[img_path_b].'" />
										  <param name="quality" value="high" />
										  <param name="FlashVars" value="flashlet={imageLinkTarget:\'_blank\',captionFont:\'Verdana\',titleFont:\'Verdana\',showControls:true,frameShow:false,slideDelay:5,captionSize:10,captionColor:#333333,titleSize:10,transitionsType:\'Random\',titleColor:#333333,slideAutoPlay:false,imageURLs:[\'img1.jpg\',\'img2.jpg\',\'img3.jpg\'],slideLoop:false,frameThickness:2,imageLinks:[\'http://macromedia.com/\',\'http://macromedia.com/\',\'http://macromedia.com/\'],frameColor:#333333,bgColor:#FFFFFF,imageCaptions:[]}" />
										  <embed src="'.$Globals_Dir.$rs_img[img_path_b].'"  quality="high" flashvars="flashlet={imageLinkTarget:\'_blank\',captionFont:\'Verdana\',titleFont:\'Verdana\',showControls:true,frameShow:false,slideDelay:5,captionSize:10,captionColor:#333333,titleSize:10,transitionsType:\'Random\',titleColor:#333333,slideAutoPlay:false,imageURLs:[\'img1.jpg\',\'img2.jpg\',\'img3.jpg\'],slideLoop:false,frameThickness:2,imageLinks:[\'http://macromedia.com/\',\'http://macromedia.com/\',\'http://macromedia.com/\'],frameColor:#333333,bgColor:#FFFFFF,imageCaptions:[]}" pluginspage="http://www.macromedia.com/shockwave/download/index.cgi?P1_Prod_Version=ShockwaveFlash" type="application/x-shockwave-flash" width="'.$wi.'" height="'.$hi.'"> </embed>
										</object><br><br>';
																			}else{
																			?>
																			<img src="phpThumb.php?src=<?php echo $Globals_Dir.$rs_img[img_path_b]?>&h=<?php echo $wi;?>&w=<?php echo $hi;?>" hspace="0" vspace="0" align="middle" >
																			<?php } ?></td></tr>
							</table>
							<br><strong style="color:#000000"><?php echo " ชื่อรูป : ".$rs_img[img_name]?></strong><br><br>
							<!--<a href="gallery_process_comment.php?flag=vote&category_id=<?php//php echo $category_id;?>&img_id=<?php//php echo $img_id;?>"><font color="#6699FF"><strong>โหวตให้รูปนี้</strong></font></a>-->
							<br><br><font color="#003399">ความนิยม : <?php if($rs_img[img_vote] != '0'){ echo $rs_img[img_vote];}else{ echo '0';}?> คะแนน</font><br>
							
	</table>
	<br>
	<div id="div_comment">
	<table width="600" border="0" align="center" cellpadding="0" cellspacing="1">
		<tr><th scope="col"><div align="right">&nbsp;&nbsp;</div></th></tr>
	</table>
	<table width="600" border="0" align="center" cellpadding="1" cellspacing="1">
		<?php
			$sql_comment = "SELECT count(*) as count_com FROM gallery_comment WHERE category_id = '".$_GET[category_id]."' and img_id = '".$rs_img[img_id]."' ";
			$query_comment = $db->query($sql_comment);
			$rs_comment = $db->db_fetch_array($query_comment);
		?>
		<tr><th height="44" colspan="2" align="left" valign="top" class="ewthead" ><strong> &bull;   ความคิดเห็น(<?php echo $rs_comment[count_com]?>)</strong></th></tr>
		<tr>
			<td colspan="2" bgcolor="#FFFFFF">
			<?php
				if($_POST[page]) $page = $_POST[page];
				else $page = $_GET[page];
				if(!$limit) $limit = 10;
				if($page == '' || $page < 1)$page =1;
				$page1=$page-1;
				if($page1 == '' || $page1 < 0)$page1 =0;
				$sql_comment = "SELECT * FROM gallery_comment WHERE category_id = '".$category_id."' AND img_id = '".$img_id."' order by choice desc";
				$query_comment = $db->query($sql_comment);
				$num_comment = $num_all = $db->db_num_rows($query_comment);
				if($num_all%$limit==0){
					@$page_all = $num_all/$limit;
				}else{
					@$page_all = (int)($num_all/$limit)+1;
				}
				if($page_all==0) $page_all = 1;
				if($page>=$page_all){$page1 = $page_all-1;$page=$page_all;}
				$sql_2 = $sql_comment."  limit ".$page1*$limit.",$limit";
				$query = $db->query($sql_2);
				$num_rows_2 = $db->db_num_rows($query);
				if($num_rows_2 > 0){
					for($i=1;$i<=$num_rows_2;$i++){
						$rs_comment = $db->db_fetch_array($query);
						$date_time = explode(" ",$rs_comment[com_date]);
						$date =  explode("-",$date_time[0]);
						$date = $date[2]."/".$date[1]."/".($date[0]+543);
						$date_time_full = " วันที่ ".$date." เวลา ".$date_time[1];
			?>
				<table width="580" border="0" align="center" cellpadding="3" cellspacing="1">
					<tr>
						<td width="106" valign="top"><span class="ewtfunctionmenu"><strong>&nbsp;ความคิดเห็นที่<?php echo $rs_comment[choice]?>:</strong></span></td>
						<td width="459"><font color="#333333" ><strong>คุณ<?php echo $rs_comment[name]?></strong></font>&nbsp;&nbsp;&nbsp;<br><font color="#CC6600" ><?php echo $date_time_full?></font></td>
					</tr>
					<tr>
						<td>&nbsp;</td>
						<td><?php echo str_replace("\n","<br>",$rs_comment[comment])?></td>
					</tr>
					<tr><td colspan="2" align="right"><img src="images/cal_del.gif" alt="ลบความคิดเห็น" style="cursor:hand" onClick=" if(confirm('ยืนยันการลบ')){location.href = 'gallery_process_comment.php?comment_id=<?php echo $rs_comment[comment_id]?>&category_id=<?php echo $category_id?>&img_id=<?php echo $img_id?>&flag=del&type=not_all';}"></td></tr>
					<tr><td colspan="2"><hr size="1" color="#EFECF0"></td></tr>
				</table>
			<?php 
					}
			?>
				<table width="100%" border="0" bgcolor="#FFFFFF">
					<tr>
						<td align="right">หน้าที่
							<select name="page" onChange="var url = 'gallery_ajax_comment2.php?page='+this.value+'&category_id=<?php echo $category_id?>&img_id=<?php echo $img_id?>&limit=<?php echo $limit?>'; load_divForm(url,'div_comment','');">
							<?php
								for($i=1;$i<=$page_all;$i++){
									if($i == $page) $selected = "selected";
									else $selected = "";
									print "<option value=\"$i\" $selected>$i</option>";
								}
							?>
							</select>
							/
							<?php echo $page_all?>
							หน้า
							<!--<img src="images/close.gif" alt="ลบความคิดเห็นทั้งหมด" style="cursor:hand" align="absmiddle"  onClick="if(confirm('ยืนยันการลบ')){location.href = 'gallery_process_comment.php?category_id=<?php//=$category_id?>&img_id=<?php//=$img_id?>&flag=del&type=all';}">ลบความคิดเห็นทั้งหมด-->
						</td>
					</tr>
				</table>
			<?php
				} else {
			?>
				<br>
				<table width="580" border="0" align="center">
					<tr><th width="580"><hr size="1" color="#EFECF0"></th></tr>
					<tr><th><strong style="color:#FF0000">ไม่มีความคิดเห็น </strong></th></tr>
					<tr><th><hr size="1" color="#EFECF0"></th></tr>
				</table>
			<?php 
				}
			?>
				<br>
				<table width="100%" border="0" cellspacing="0" cellpadding="0">
					<tr><td align="right"></td></tr>
				</table>
			</td>
		</tr>
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
