<?php
$path = "../";
	session_start();
	$start_time_counter = date("YmdHis");
	include($path."lib/function.php");
	include($path."lib/user_config.php");
	include($path."lib/connect.php");
	include("include/ewt_block_function.php");
	include("include/ewt_menu_preview.php");
	include("include/ewt_article_preview.php");
	include($path."language/language".$lang_sh.".php");
	include("ewt_template.php");
	$db->access=200;
	$sql_rude="SELECT * FROM vulgar_table ";
	$query_rude=$db->query($sql_rude);
	while($data = $db->db_fetch_array($query_rude)) { 
		$array_rude[]=$data[vulgar_text];
	}
	
	function cencer_rude($str) {
		global  $array_rude;
		for($i=0; $i<sizeof($array_rude); $i++) {
			$str=ereg_replace($array_rude[$i],'***',$str);
			//str_replace($array_rude[$i],$str
		}
		return  $str;
	}
	
	
	
?>
<?php echo $template_design[0];?>
	<?php
			$mainwidth = $F["d_site_content"];
			?>
			
			<?php
			if($_POST[page_cat]) $page_cat = $_POST[page_cat];
			else $page_cat = $_GET[page_cat];
			
			if($_POST[category_id]) $category_id = $_POST[category_id];
			else $category_id = $_GET[category_id];
			
			if($_POST[img_id]) $img_id = $_POST[img_id];
			else $img_id = $_GET[img_id];
			$sql_category = "SELECT * FROM gallery_category WHERE category_id = '".$_GET[category_id]."' ";
			$query_category = $db->query($sql_category);
			$rs_category = $db->db_fetch_array($query_category);
			$hi = $rs_category[height_b];
			$wi = $rs_category[width_b];
			$sql_img = "SELECT * FROM gallery_image WHERE img_id = '".$_GET[img_id]."' ";
			$query_img = $db->query($sql_img);
			$rs_img = $db->db_fetch_array($query_img);
			
			?>
			<table width="<?php echo $bg_width;?>" border="0" cellspacing="0" cellpadding="1">
				<tr>
					<td></td>
					<?php
					
							$sql_imgb = "SELECT gallery_image.img_id,gallery_image.img_name,gallery_image.img_path_s FROM gallery_cat_img INNER JOIN gallery_image ON gallery_cat_img.img_id = gallery_image.img_id WHERE gallery_image.img_id < '".$img_id."' AND gallery_cat_img.category_id = '".$category_id."' ORDER BY gallery_image.img_id DESC LIMIT 0,1";
						
						$query_imgb = $db->query($sql_imgb);
						if($db->db_num_rows($query_imgb) > 0) {
							$B = $db->db_fetch_row($query_imgb);
					?>
					<td width="70" align="center" valign="top" title="<?php echo $B[1]; ?>" style="cursor:pointer" onClick="self.location.href='gallery_view_img_comment.php?category_id=<?php echo $category_id; ?>&amp;filename=<?php echo $filename; ?>&amp;img_id=<?php echo $B[0] ?>&amp;page_cat=<?php echo $page_cat; ?>&amp;BID=<?php echo $_GET['BID']; ?>';">
						<table  border="0" cellpadding="5" cellspacing="1" bgcolor="#999999" width="60" >
							<tr>
								<td bgcolor="#FFFFFF" align="center"><div align="center"> <?php
										
			//chk img or swf
																			$filetypename = explode('.',$B[2]);
																			//print_r($filetypename);
																			if($filetypename[1] == 'swf'){
																			echo '<object classid="clsid:D27CDB6E-AE6D-11cf-96B8-444553540000" codebase="http://download.macromedia.com/pub/shockwave/cabs/flash/swflash.cab#version=7,0,0,0" width="50" height="50">
										  <param name="flash_component" value="ImageViewer.swc">
										  <param name="movie" value="../'.$B[2].'">
										  <param name="quality" value="high">
										  <param name="FlashVars" value="flashlet={imageLinkTarget:\'_blank\',captionFont:\'Verdana\',titleFont:\'Verdana\',showControls:true,frameShow:false,slideDelay:5,captionSize:10,captionColor:#333333,titleSize:10,transitionsType:\'Random\',titleColor:#333333,slideAutoPlay:false,imageURLs:[\'img1.jpg\',\'img2.jpg\',\'img3.jpg\'],slideLoop:false,frameThickness:2,imageLinks:[\'http://macromedia.com/\',\'http://macromedia.com/\',\'http://macromedia.com/\'],frameColor:#333333,bgColor:#FFFFFF,imageCaptions:[]}">
										  <embed src="../'.$B[2].'"  quality="high" flashvars="flashlet={imageLinkTarget:\'_blank\',captionFont:\'Verdana\',titleFont:\'Verdana\',showControls:true,frameShow:false,slideDelay:5,captionSize:10,captionColor:#333333,titleSize:10,transitionsType:\'Random\',titleColor:#333333,slideAutoPlay:false,imageURLs:[\'img1.jpg\',\'img2.jpg\',\'img3.jpg\'],slideLoop:false,frameThickness:2,imageLinks:[\'http://macromedia.com/\',\'http://macromedia.com/\',\'http://macromedia.com/\'],frameColor:#333333,bgColor:#FFFFFF,imageCaptions:[]}" pluginspage="http://www.macromedia.com/shockwave/download/index.cgi?P1_Prod_Version=ShockwaveFlash" type="application/x-shockwave-flash" width="50" height="50"> </embed>
										</object>';
																			}else{
		?><img src="../phpThumb.php?src=<?php echo $B[2]; ?>&amp;h=50&amp;w=50" hspace="0" vspace="0" border="0"   alt="Previous"><?php } ?></div></td>
							</tr>
						</table>&lt; Previous
					</td>
					<?php } ?>
					<?php
						$sql_imga = "SELECT gallery_image.img_id,gallery_image.img_name,gallery_image.img_path_s FROM gallery_cat_img INNER JOIN gallery_image ON gallery_cat_img.img_id = gallery_image.img_id WHERE gallery_image.img_id > '".$img_id."' AND gallery_cat_img.category_id = '".$category_id."' ORDER BY gallery_image.img_id ASC LIMIT 0,1";
						$query_imga = $db->query($sql_imga);
						if($db->db_num_rows($query_imga) > 0) {
							$A = $db->db_fetch_row($query_imga);
					?>
					<td width="70" align="center" valign="top"  title="<?php echo $A[1]; ?>" style="cursor:pointer" onClick="self.location.href='gallery_view_img_comment.php?category_id=<?php echo $category_id; ?>&amp;filename=<?php echo $filename; ?>&amp;img_id=<?php echo $A[0] ?>&amp;page_cat=<?php echo $page_cat; ?>&amp;BID=<?php echo $_GET['BID']; ?>';">
						<table  border="0" cellpadding="5" cellspacing="1" bgcolor="#999999" width="60" >
							<tr>
								<td bgcolor="#FFFFFF" align="center"><div align="center"> <?php
										
			//chk img or swf
																			$filetypename = explode('.',$A[2]);
																		//	print_r($filetypename);
																			if($filetypename[1] == 'swf'){
																			echo '<object classid="clsid:D27CDB6E-AE6D-11cf-96B8-444553540000" codebase="http://download.macromedia.com/pub/shockwave/cabs/flash/swflash.cab#version=7,0,0,0" width="50" height="50">
										  <param name="flash_component" value="ImageViewer.swc">
										  <param name="movie" value="../'.$A[2].'">
										  <param name="quality" value="high">
										  <param name="FlashVars" value="flashlet={imageLinkTarget:\'_blank\',captionFont:\'Verdana\',titleFont:\'Verdana\',showControls:true,frameShow:false,slideDelay:5,captionSize:10,captionColor:#333333,titleSize:10,transitionsType:\'Random\',titleColor:#333333,slideAutoPlay:false,imageURLs:[\'img1.jpg\',\'img2.jpg\',\'img3.jpg\'],slideLoop:false,frameThickness:2,imageLinks:[\'http://macromedia.com/\',\'http://macromedia.com/\',\'http://macromedia.com/\'],frameColor:#333333,bgColor:#FFFFFF,imageCaptions:[]}">
										  <embed src="../'.$A[2].'"  quality="high" flashvars="flashlet={imageLinkTarget:\'_blank\',captionFont:\'Verdana\',titleFont:\'Verdana\',showControls:true,frameShow:false,slideDelay:5,captionSize:10,captionColor:#333333,titleSize:10,transitionsType:\'Random\',titleColor:#333333,slideAutoPlay:false,imageURLs:[\'img1.jpg\',\'img2.jpg\',\'img3.jpg\'],slideLoop:false,frameThickness:2,imageLinks:[\'http://macromedia.com/\',\'http://macromedia.com/\',\'http://macromedia.com/\'],frameColor:#333333,bgColor:#FFFFFF,imageCaptions:[]}" pluginspage="http://www.macromedia.com/shockwave/download/index.cgi?P1_Prod_Version=ShockwaveFlash" type="application/x-shockwave-flash" width="50" height="50"> </embed>
										</object>';
																			}else{
		?><img src="../phpThumb.php?src=<?php echo $A[2]; ?>&amp;h=50&amp;w=50" hspace="0" vspace="0" border="0"  alt="Next"><?php } ?></div></td>
							</tr>
						</table>Next &gt;
					</td>
					<?php } ?>
				</tr>
	  </table>
			<table width="100%" align="center" cellpadding="3" cellspacing="1"  >
				<tr>
					<td align="center" valign="top" >
						<table width="100%" border="0" cellspacing="0" cellpadding="1">
							<tr><td align="left" ><h3><a href="gallery_view_catelogy_all.php?flag=all&amp;filename=<?php echo $_REQUEST[filename];?>&amp;BID=<?php echo $_REQUEST[BID];?>" accesskey=<?php echo $db->genaccesskey();?>><?php echo $text_GenGallery_cat ;?></a> &gt;&gt;<?php echo $rs_category[category_name]; ?></h3></td>
							</tr>
						</table>
					</td>
				</tr>
				<tr>
					<td valign="top">
						<table width="100%" border="0" cellpadding="3" cellspacing="1">
							<tr>
								<td align="center" valign="middle">
									<table  border="0" cellpadding="1" cellspacing="1"  width="<?php echo $wi;?>" >
										<tr><td bgcolor="#FFFFFF" > <?php
										if($rs_img[img_path_b] != ''){
							$img_p = '../'.$rs_img[img_path_b];
							}
							if (!file_exists($img_p) ) {
									$img_p = "../mainpic/no-download.gif";
							}
			//chk img or swf
																			$filetypename = explode('.',$img_p);
																			//print_r($filetypename);
																			if($filetypename[3] == 'swf'){
																			echo '<object classid="clsid:D27CDB6E-AE6D-11cf-96B8-444553540000" codebase="http://download.macromedia.com/pub/shockwave/cabs/flash/swflash.cab#version=7,0,0,0" width="'.$wi.'" height="'.$hi.'" >
										  <param name="flash_component" value="ImageViewer.swc">
										  <param name="movie" value="'.$img_p.'">
										  <param name="quality" value="high">
										  <param name="FlashVars" value="flashlet={imageLinkTarget:\'_blank\',captionFont:\'Verdana\',titleFont:\'Verdana\',showControls:true,frameShow:false,slideDelay:5,captionSize:10,captionColor:#333333,titleSize:10,transitionsType:\'Random\',titleColor:#333333,slideAutoPlay:false,imageURLs:[\'img1.jpg\',\'img2.jpg\',\'img3.jpg\'],slideLoop:false,frameThickness:2,imageLinks:[\'http://macromedia.com/\',\'http://macromedia.com/\',\'http://macromedia.com/\'],frameColor:#333333,bgColor:#FFFFFF,imageCaptions:[]}">
										  <embed src="'.$img_p.'"  quality="high" flashvars="flashlet={imageLinkTarget:\'_blank\',captionFont:\'Verdana\',titleFont:\'Verdana\',showControls:true,frameShow:false,slideDelay:5,captionSize:10,captionColor:#333333,titleSize:10,transitionsType:\'Random\',titleColor:#333333,slideAutoPlay:false,imageURLs:[\'img1.jpg\',\'img2.jpg\',\'img3.jpg\'],slideLoop:false,frameThickness:2,imageLinks:[\'http://macromedia.com/\',\'http://macromedia.com/\',\'http://macromedia.com/\'],frameColor:#333333,bgColor:#FFFFFF,imageCaptions:[]}" pluginspage="http://www.macromedia.com/shockwave/download/index.cgi?P1_Prod_Version=ShockwaveFlash" type="application/x-shockwave-flash" width="'.$wi.'" height="'.$hi.'" > </embed>
										</object>';
																			}else{
		?><img src="../phpThumb.php?src=<?php echo $rs_img[img_path_b]?>&amp;h=<?php echo $wi;?>&amp;w=<?php echo $hi;?>" hspace="0" vspace="0"  alt="<?php echo $rs_img[img_name]?>"><?php } ?></td></tr>
									</table>
									<br>
									<div align="center"><strong ><?php echo $rs_img[img_name]?></strong><hr size="1"><?php echo $rs_img[img_detail];?></div>
									<br><br>
									<?php if($rs_category[category_vote] == 1) { ?>
									<a href="gallery_process_comment.php?flag=vote&amp;category_id=<?php echo $category_id;?>&amp;img_id=<?php echo $img_id;?>&amp;filename=<?php echo $filename;?>" accesskey=<?php echo $db->genaccesskey();?>><?php echo $text_GenGallery_vote;?></a>
									<?php } ?>
									<?php if($rs_category[category_send] == 1) { ?>
									<a href="#&2" onClick="window.open('gallery_send.php?filename=<?php echo $filename;?>','mail','width=500,height=300,scrollbars=1,resizable = 1');" accesskey=<?php echo $db->genaccesskey();?>>|<?php echo $text_GenGallery_sandtofriend;?></a><?php } ?>
									<?php if($rs_category[category_vote] == 1) { ?><br><br><?php echo $text_GenGallery_flavor;?><?php if($rs_img[img_vote] != '0'){ echo $rs_img[img_vote];}else{ echo '0';}?><?php echo $text_GenGallery_point;?><br><br>
									<?php } ?>
								</td>
							</tr>
						</table>
					</td>
				</tr>
			</table>
			<?php if($rs_category[category_comment] == 1) { ?>
			<div id="div_comment">
				<table width="100%" border="0" align="center" cellpadding="0" cellspacing="1">
					<tr><th scope="col"><div align="right">&nbsp;&nbsp;</div></th></tr>
				</table>
				<table width="100%" border="0" align="center" cellpadding="1" cellspacing="1">
				<?php
					$sql_comment = "SELECT count(*) as count_com FROM gallery_comment WHERE category_id = '".$_GET[category_id]."' and img_id = '".$rs_img[img_id]."' ";
					$query_comment = $db->query($sql_comment);
					$rs_comment = $db->db_fetch_array($query_comment);
				?>
					<tr>
						<td  colspan="2" > &bull;  <h3> <?php echo $text_GenGallery_opinion;?> (<?=$rs_comment[count_com]?>)</h3> </td>
					</tr>
					<tr>
						<td colspan="2">
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
							if($num_all%$limit==0) { @$page_all = $num_all/$limit; } else { @$page_all = (int)($num_all/$limit)+1; }
							if($page_all==0) $page_all = 1;
							if($page>=$page_all){$page1 = $page_all-1;$page=$page_all;}
							$sql_2 = $sql_comment."  limit ".$page1*$limit.",$limit";
							$query = $db->query($sql_2);
							$num_rows_2 = $db->db_num_rows($query);
							
							if($num_rows_2 > 0) {
								for($i=1;$i<=$num_rows_2;$i++) {
									$rs_comment = $db->db_fetch_array($query);
									$date_time = explode(" ",$rs_comment[com_date]);
									$date =  explode("-",$date_time[0]);
									$date = $date[2]."/".$date[1]."/".($date[0]+543);
									$date_time_full = $text_GenGallery_date.$date.$text_GenGallery_time.$date_time[1];
						?>
							<table width="100%"  border="0" align="center" cellpadding="3" cellspacing="1" >
								<tr>
									<td width="20%" valign="top" >&nbsp;<?php echo $text_GenGallery_opinion1;?> <?=$rs_comment[choice]?>  : </td>
									<td width="80%" ><?php echo $text_GenGallery_titlename;?><?php echo cencer_rude($rs_comment[name])?>&nbsp;&nbsp;&nbsp;<br><?=$date_time_full?> </td>
								</tr>
								<tr>
									<td >&nbsp;</td>
									<td ><? echo str_replace("\n","<br>",cencer_rude($rs_comment[comment])); ?></td>
								</tr>
								<tr><td colspan="2"><hr></td></tr>
							</table>
						<? 
								}
						?>
							<table width="100%" border="0" >
								<tr>
									<td align="right"><?php echo $text_general_page;?>
										<select name="page" onChange="var url = 'gallery_ajax_comment2.php?page='+this.value+'&amp;category_id=<?=$category_id?>&amp;img_id=<?=$img_id?>&amp;limit=<?=$limit?>'; load_divForm(url,'div_comment','');">
										<?php
										for($i=1;$i<=$page_all;$i++){
										if($i == $page) $selected = "selected";
										else $selected = "";
										print "<option value=\"$i\" $selected>$i</option>";
										}
										?>
										</select>
										/
										<?=$page_all?>
										<?php echo $text_general_page;?>
									</td>
								</tr>
							</table>
						<?
							} else {
						?>
							<table width="100%" border="0" align="center" class="text_normal">
								
								<tr><td><strong style="color:#FF0000"><?php echo $text_GenGallery_nocomment;?> </strong></td></tr>
							
							</table>
						<? }?>
							<br>
							<table width="100%" border="0" cellspacing="0" cellpadding="0">
								<tr><td align="right"></td></tr>
							</table>
						</td>
					</tr>
				</table>
			</div>
			<form name="frm" action="gallery_process_comment.php" method="post">
				<input type="hidden" name="category_id" value="<?=$category_id?>">
				<input type="hidden" name="page_cat" value="<?=$page_cat?>">
				<input type="hidden" name="img_id" value="<?=$img_id?>">
				<input type="hidden" name="filename" value="<?=$filename?>">
				<table width="<?php echo $bg_width;?>"  border="0" align="center" cellpadding="0" cellspacing="1">
					<tr>
						<td  valign="top">
							<table width="100%" border="0" cellspacing="0" cellpadding="0">
								<tr>
									<td height="6" colspan="3" >&nbsp;</td>
								</tr>
								<tr>
									<td valign="top" >&bull; <?php echo $text_GenGallery_opinion2 ;?></td>
								</tr>
							</table>
						</td>
					</tr>
					<tr>
						<td valign="top">
							<table width="100%" border="0" cellpadding="3" cellspacing="1">
								<tr>
									<td align="center" valign="top" >
										<table width="100%" border="0" class="text_normal">
											<tr>
												<td width="15%" align="right" scope="col"><?php echo $text_GenGallery_name;?></td>
												<td width="85%" scope="col"><input name="name" type="text" size="50" value="<?php echo $_SESSION["EWT_NAME"];?>" alt="<?php echo $text_GenGallery_name;?>"></td>
											</tr>
											<tr>
												<td align="right" valign="top"><?php echo $text_GenGallery_detail;?></td>
												<td><textarea name="comment" cols="50" rows="5" onKeyUp="if(this.value.length%50 == 0){}" title="<?php echo $text_GenGallery_detail;?>"></textarea></td>
											</tr>
											<tr>
												<td>&nbsp;</td>
												<td>&nbsp;&nbsp;
													<input type="submit" name="Submit" value="<?php echo $text_GenGallery_sentcomment;?>" alt="Submit" onClick="return chk_name(this.form)">
													<input type="hidden" name="flag" value="add" alt="hidden">
													<input type="hidden" name="filename" value="<?php echo $filename;?>" alt="hidden">
													<input type="hidden" name="fn" value="gallery_view_img_comment.php" alt="hidden">
													&nbsp;&nbsp;
													<label><input type="reset" name="Submit2" value="<?php echo $text_general_reset;?>"  alt="reset"></label>
												</td>
											</tr>
										</table>
									</td>
								</tr>
							</table>
						</td>
					</tr>
				</table>
				<script language="javascript" type="text/javascript">
					function chk_name(me){
						if(me.name.value == ""){
							alert('<?php echo $text_GenGallery_alertname;?>');
							me.name.focus();
							return false;
						}
						return true;
					}
				</script>
	  </form>
			<?php } ?>
<?php include("include_logo_w3c_template.php");?>
<?php $db->db_close(); ?>