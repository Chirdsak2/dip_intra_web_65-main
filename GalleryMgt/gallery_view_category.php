<?php
	session_start();
	include("../lib/permission1.php");
	include("../lib/include.php");
	include("../lib/function.php");
	include("../lib/user_config.php");
	include("../lib/connect.php");
	include("../lib/set_lang.php");
?>
<html>
<head>
<title><?php echo $EWT_title ?></title>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<link href="../theme/main_theme/css/style.css" rel="stylesheet" type="text/css">
<script language="javascript" src="js/jquery/jquery-1.2.2.min.js"></script>
<script src="../js/AjaxRequest.js"></script>
<script language="javascript">
$(document).ready(function() {
	$('.splash').click( function() {
		if($(this).attr('checked')) {
			$.get("gallery_process_img.php?flag=add_splash&img_id="+$(this).val());
		} else {
			$.get("gallery_process_img.php?flag=del_splash&img_id="+$(this).val());
		}
	});
});
</script>
</head>
<body leftmargin="0" topmargin="0">
<?php include("../FavoritesMgt/favorites_include.php");?>
<div id="nav" style="position:absolute;width:400px;  z-index:1;display:none" ></div>
<form name="frm1" action="" method="post">
<?php
	$sql_category = "SELECT * FROM gallery_category WHERE category_id = '".$_GET[category_id]."' ";
	$query_category = $db->query($sql_category);
	$rs_category = $db->db_fetch_array($query_category);
	$limit = $rs_category[col]*$rs_category[row];
	$hi = $rs_category[height_s];
	$wi = $rs_category[width_s];
	if($_POST[page]) $page = $_POST[page];
	else $page = $_GET[page];
	if(!$limit) $limit = 5;
	if($page == '' || $page < 1)$page =1;
	$page1=$page-1;
	if($page1 == '' || $page1 < 0)$page1 =0;
	$db->write_log("view","Gallery","เข้าสู่ Module การจัดการห้องแสดงภาพ  หมวด  ".$rs_category["category_name"]);
	$sql_img = "SELECT * FROM gallery_cat_img INNER JOIN gallery_image ON gallery_cat_img.img_id = gallery_image.img_id WHERE gallery_cat_img.category_id = '".$_GET[category_id]."' ORDER BY cat_img_id";
	$query_img = $db->query($sql_img);
	$num_img = $num_all = $db->db_num_rows($query_img);
	if($num_all%$limit==0) { @$page_all = $num_all/$limit; } else { @$page_all = (int)($num_all/$limit)+1; }
	if($page_all==0) $page_all = 1;
	if($page>=$page_all){$page1 = $page_all-1;$page=$page_all;}
	$sql_2 = $sql_img."  limit ".$page1*$limit.",$limit";
	$query = $db->query($sql_2);
	$num_rows_2 = $db->db_num_rows($query);
	$Globals_Dir = "../ewt/".$_SESSION["EWT_SUSER"]."/";
?>
	<table width="80%" border="0" align="center" cellpadding="5" cellspacing="0">
		<tr><td><img src="../theme/main_theme/logo.gif" width="32" height="32" align="absmiddle"> <span class="ewtfunction">หมวด <?php echo $rs_category["category_name"]?></span></td></tr>
	</table>
	<table width="94%" border="0" align="center" cellpadding="0" cellspacing="0" class="ewtfunctionmenu">
		<tr><td align="right"><a href="javascript:void(0);" onClick="load_divForm('../FavoritesMgt/favorites_add.php?name=<?php echo urlencode("การจัดการห้องแสดงภาพ หมวด ".$rs_category["category_name"]);?>&module=gallery&url=<?php echo urlencode("gallery_view_category.php?category_id=".$_GET["category_id"]);?>', 'divForm', 300, 80, -1,433, 1);"><img src="../images/star_yellow_add.gif" width="16" height="16" border="0" align="absmiddle">&nbsp;Add to favorites </a>&nbsp;&nbsp;&nbsp;&nbsp;<a href="main_gallery.php"><img src="../theme/main_theme/g_mainpage.gif" width="16" height="16" align="absmiddle" border="0"> หน้าหลัก</a><?php if($db->check_permission("Gallery","p","")){?>
		&nbsp;&nbsp;&nbsp;&nbsp;<span style="cursor:hand" onClick="location.href ='gallery_add_img.php?flag=add&category_id=<?php echo $_GET[category_id]?>&page=<?php echo $page?>';"><img src="../theme/main_theme/g_add.gif" width="16" height="16" align="absmiddle" alt="เพิ่มรูปภาพ"> เพิ่มรูปภาพ</span><?php }?><hr></td></tr>
	</table>
	<table width="94%"  border="0" cellpadding="0" cellspacing="1" align="center">
		<tr>
			<td valign="top">
				<table width="100%" border="0" cellpadding="3" cellspacing="1" bgcolor="#006699" class="ewttableuse">
					<tr>
						<td bgcolor="#FFFFFF" style="color:#FFFFFF">
							<table width="100%" height="100%" border="0" cellpadding="0" cellspacing="0">
								<tr>
									<th scope="col">
										<table width="100%" border="0" cellpadding="0" cellspacing="0">
											<tr>
												<td width="70%" scope="col"> </td>
												<th width="30%" align="right" scope="col"><!--<img src="images/close.gif" alt="ปิด" align="absmiddle" onClick="window.close();" style="cursor:hand">--></th>
											</tr>
										</table>
									</th>
								</tr>
							</table>
							<table border="0" cellpadding="5" cellspacing="1" align="center">
								<tr>
									<td>
										<div align="center">
											<table width="100%" border="0" align="center" cellpadding="5" cellspacing="1">
												<?php 
													if($num_rows_2 > 0){
														for($i=1;$i<=$num_rows_2;$i++){
															$rs_img = $db->db_fetch_array($query);
															$sql_splash = "select * from splash_img where splash_img_id = '".$rs_img[img_id]."'";
															$query_splash = $db->query($sql_splash);
															if($i%$rs_category[col] == 0 && $i==1) {
												?>
												<tr align=\"center\">
												<?php 
															}
												?>
													<td width=\"250\" align=\"center\">
														<table border="0" cellpadding="1" cellspacing="1" bgcolor="#FFFFFF" align="center">
															<?php if($db->check_permission("Gallery","s","")){?>
															<tr><td colspan="2" align="left" bgcolor="#FFFFFF">
															<span><input name="splash<?php echo $rs_img[img_id]?>" id="splash<?php echo $rs_img[img_id]?>" class="splash" type="checkbox" value="<?php echo $rs_img[img_id]?>" <?php if($db->db_num_rows($query_splash) > 0) { echo "checked"; }?>>กำหนดเป็น Splash Page</span></td></tr>
															<?php }?>
															<?php if($db->check_permission("Gallery","p","")){?>
															<tr >
															  <td width="59" bgcolor="#FFFFFF"><a href="#" onClick="location.href ='gallery_edit_img.php?img_id=<?php echo $rs_img[img_id]?>&flag=edit&category_id=<?php echo $_GET[category_id]?>&page_cat=<?php echo $page_cat?>';"><img src="../theme/main_theme/g_edit.gif" alt="แก้ไขรูป" width="16" height="16" border="0" align="absmiddle"></a> <span style="cursor:hand" onClick="if(confirm('ยืนยันการลบ')){location.href = 'gallery_process_img.php?flag=del&img_id=<?php echo $rs_img[img_id]?>&category_id=<?php echo $_GET[category_id]?>'; }"><img src="../theme/main_theme/g_garbage.png" alt="ลบรูป" width="16" height="16" border="0" align="absmiddle" >&nbsp;</span> <a href="#G" onClick="txt_data('<?php echo $rs_img[img_id]; ?>','<?php echo $_GET[category_id];?>')"><img id="lang<?php echo $rs_img[img_id]; ?>" src="../images/b_fonts.gif" alt="สร้างภาษาอื่น" width="16" height="16" align="absmiddle" border="0"></a></td>
													          <td width="69"  align="right" bgcolor="#FFFFFF"><?php echo show_icon_lang($rs_img[img_id],'gallery_image');?></td>
														  </tr>
														  <?php }?>
															<tr style="cursor:hand" onMouseOver="document.getElementById('name_<?php echo $rs_img[img_id]?>').style.color = '#FF0000'; " onMouseOut="document.getElementById('name_<?php echo $rs_img[img_id]?>').style.color = '#000000'; " onClick="location.href='gallery_view_img_comment2.php?category_id=<?php echo $_GET[category_id]?>&img_id=<?php echo $rs_img[img_id]?>&page_cat=<?php echo $page?>';">
																<td colspan="2"  align="center" bgcolor="#FFFFFF">
																	<table border="0" cellpadding="1" cellspacing="1" bgcolor="#999999" align="center" width="<?php echo $wi;?>"  height="<?php echo $hi;?>">
																		<tr>
																			<th bgcolor="#FFFFFF" scope="col" align="center">
																			<?php
																			//chk img or swf
																			$filetypename = explode('.',$rs_img[img_path_s]);
																			
																			if($filetypename[1] == 'swf'){
																			echo '<object classid="clsid:D27CDB6E-AE6D-11cf-96B8-444553540000" codebase="http://download.macromedia.com/pub/shockwave/cabs/flash/swflash.cab#version=7,0,0,0" width="'.$wi.'" height="'.$hi.'">
										  <param name="flash_component" value="ImageViewer.swc" />
										  <param name="movie" value="'.$Globals_Dir.$rs_img[img_path_s].'" />
										  <param name="quality" value="high" />
										  <param name="FlashVars" value="flashlet={imageLinkTarget:\'_blank\',captionFont:\'Verdana\',titleFont:\'Verdana\',showControls:true,frameShow:false,slideDelay:5,captionSize:10,captionColor:#333333,titleSize:10,transitionsType:\'Random\',titleColor:#333333,slideAutoPlay:false,imageURLs:[\'img1.jpg\',\'img2.jpg\',\'img3.jpg\'],slideLoop:false,frameThickness:2,imageLinks:[\'http://macromedia.com/\',\'http://macromedia.com/\',\'http://macromedia.com/\'],frameColor:#333333,bgColor:#FFFFFF,imageCaptions:[]}" />
										  <embed src="'.$Globals_Dir.$rs_img[img_path_s].'"  quality="high" flashvars="flashlet={imageLinkTarget:\'_blank\',captionFont:\'Verdana\',titleFont:\'Verdana\',showControls:true,frameShow:false,slideDelay:5,captionSize:10,captionColor:#333333,titleSize:10,transitionsType:\'Random\',titleColor:#333333,slideAutoPlay:false,imageURLs:[\'img1.jpg\',\'img2.jpg\',\'img3.jpg\'],slideLoop:false,frameThickness:2,imageLinks:[\'http://macromedia.com/\',\'http://macromedia.com/\',\'http://macromedia.com/\'],frameColor:#333333,bgColor:#FFFFFF,imageCaptions:[]}" pluginspage="http://www.macromedia.com/shockwave/download/index.cgi?P1_Prod_Version=ShockwaveFlash" type="application/x-shockwave-flash" width="'.$wi.'" height="'.$hi.'"> </embed>
										</object><br><br>';
																			}else{
																			?>
																			<img src="<?php echo $Globals_Dir.$rs_img[img_path_s];?>" hspace="0" vspace="0" width="<?php echo $wi;?>" height="<?php echo $hi;?>">
																			<?php } ?>
																			</th>
																		</tr>
																	</table>																</td>
															</tr>
															<tr style="cursor:hand" onMouseOver="document.getElementById('name_<?php echo $rs_img[img_id]?>').style.color = '#FF0000'; " onMouseOut="document.getElementById('name_<?php echo $rs_img[img_id]?>').style.color = '#000000'; " onClick="location.href='gallery_view_img_comment2.php?category_id=<?php echo $_GET[category_id]?>&img_id=<?php echo $rs_img[img_id]?>&page_cat=<?php echo $page?>';"><td colspan="2"  align="center" bgcolor="#FFFFFF"><span id="name_<?php echo $rs_img[img_id]?>"><?php echo $rs_img[img_name]?></span></td></tr>
														</table>	
													</td>
												<?php
															if($i%$rs_category[col] == 0 ) {
												?>
												</tr>
												<?php 
															}
														}// end for
													}else{//end if num_rows_2
												?>
												<tr><td align="center" style="color:#FF0000"><strong>ไม่มีรูปภาพ</strong></td></tr>
												<?php 
													}
												?>
											</table>
										</div>
									</td>
								</tr>
							</table><br>
						</td>
					</tr>
				</table>
				<table width="100%" border="0" align="left">
					<tr>
						<th scope="col"><div align="right">หน้าที่
							<select name="page" onChange="document.frm1.submit();">
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
							หน้า</div>
						</th>
					</tr>
				</table>
			</td>
		</tr>
	</table>
</form>
</body>
</html>
<?php $db->db_close(); ?>
<script language="javascript1.2">
function findPosX(obj)
{
 var curleft = 0;
 if (document.getElementById || document.all)
 {
  while (obj.offsetParent)
  {
   curleft += obj.offsetLeft
   obj = obj.offsetParent;
  }
 }
 else if (document.layers)
  curleft += obj.x;
 return curleft;
}
function findPosY(obj)
{
 var curtop = 0;
 if (document.getElementById || document.all)
 {
  while (obj.offsetParent)
  {
   curtop += obj.offsetTop
   obj = obj.offsetParent;
  }
 }
 else if (document.layers)
  curtop += obj.y;
 return curtop;
}
		function txt_data(w,g) {
	
	var mytop = findPosY(document.getElementById("lang"+w)) +document.getElementById("lang"+w).offsetHeight;
	var myleft = findPosX(document.getElementById("lang"+w));	
	var objDiv = document.getElementById("nav");
	objDiv.style.top = mytop;
	objDiv.style.left = myleft;
	objDiv.style.display = '';
	url='../language_set.php?gid='+g+'&id='+ w;
	AjaxRequest.get(
		{
			'url':url
			,'onLoading':function() { }
			,'onLoaded':function() { }
			,'onInteractive':function() { }
			,'onComplete':function() { }
			,'onSuccess':function(req) { 
					objDiv.innerHTML = req.responseText; 
					
			}
		}
	);
	
}
function txt_data1(w,g,lang) {

	 window.location.href='../multilangMgt/gallery_img.php?langid='+g+'&lang='+lang+'&id='+ w;
}


</script>
