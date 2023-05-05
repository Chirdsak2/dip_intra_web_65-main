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
?>
<?php echo $template_design[0];?>
	<?php
			$mainwidth = $F["d_site_content"];
			?>
		<table width="96%" border="0" align="center">
		  <tr>
			<td ><h1><br>
			<?
			function findparent($id){
			 global $db;
			 global $filename;
			  global $lang_shw;
			 $sql = $db->query("select category_name,category_id,parent_id from gallery_category where category_id ='".$id."'");
		
				if($db->db_num_rows($sql)){
					$G = $db->db_fetch_array($sql);
					$txt = " <a href = \"gallery_view_catelogy.php?filename=".$_GET[filename]."&amp;category_id=".$G["category_id"]."\">".$G["category_name"]."</a> &gt;&gt; ";
					if($G[parent_id] != "0" AND $G[parent_id] != ""){
						$txt = findparent($G[parent_id]).$txt;
					}		
				}
				return $txt;
			 }
			if(($_GET[category_id]!= '') && ($_GET[category_id] != '0')){
			$sql =$db->query("select category_name,parent_id,col,row,height_s,width_s,category_vote,category_comment,category_send from gallery_category where category_id ='".$_GET[category_id]."'");
			$num_row = $db->db_num_rows($sql);
			$sql_gname =  $db->db_fetch_array($sql);
			$name = ' &gt;&gt; '.findparent($sql_gname[parent_id]).$sql_gname[category_name];
			$col = $sql_gname[col];
			$row = $sql_gname[row];
			$hi = $sql_gname[height_s];
			$wi = $sql_gname[width_s];
			}
			?>
<a href="gallery_view_catelogy.php?filename=<?php echo $_GET[filename];?>" accesskey=<?php echo $db->genaccesskey();?>><?php echo $text_GenGallery_cat;?></a><?php echo $name;?></h1><hr ></td>
		</tr>
		</table>

		<DIV id="group_gallery"></DIV>
		<script type="text/javascript" language="javascript1.2">
function galery_show(offset,category_id) {
	var objDiv = document.getElementById("group_gallery");
	url='gallery_group_list.php?offset='+offset+'&category_id='+category_id+'&filename=<?php echo $_GET[filename];?>';				
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
galery_show('0','<?php echo $_GET[category_id];?>');
</script>
<?php
			$hi = $hi;
			$wi = $hi;
$sql = "SELECT * FROM gallery_cat_img INNER JOIN gallery_image ON gallery_cat_img.img_id = gallery_image.img_id WHERE gallery_cat_img.category_id = '".$category_id."' ORDER BY cat_img_id,gallery_image.img_id";
		$rows  = $db->db_num_rows($db->query($sql));
		if($rows > 0){
		$cal = $col;
		$w = number_format((100/$cal),0,'','');
		$sql_category =  $sql; //." LIMIT $offset,$limit ";
		$query_category = $db->query($sql_category);
?>
		 <table width="100%" border="0"  cellpadding="5" cellspacing="1" >
		<?php
		while($rs_img = $db->db_fetch_array($query_category)){

							$img_p = '../'.$rs_img[img_path_s];
							if (!file_exists('../'.$rs_img[img_path_s]) ) {
									$img_p = "../mainpic/no-download.gif";
							}
		if($i%$cal == 0 ) {?> <tr ><?php }?>
		 <td width="<?php echo $w ;?>%" align="center" ><?php
			//chk img or swf
																			$filetypename = explode('.',$img_p);
																			//print_r($filetypename);
																			if($filetypename[3] == 'swf'){
																			echo '<object classid="clsid:D27CDB6E-AE6D-11cf-96B8-444553540000" codebase="http://download.macromedia.com/pub/shockwave/cabs/flash/swflash.cab#version=7,0,0,0" width="100" height="100">
										  <param name="flash_component" value="ImageViewer.swc" />
										  <param name="movie" value="'.$img_p.'" />
										  <param name="quality" value="high" />
										  <param name="FlashVars" value="flashlet={imageLinkTarget:\'_blank\',captionFont:\'Verdana\',titleFont:\'Verdana\',showControls:true,frameShow:false,slideDelay:5,captionSize:10,captionColor:#333333,titleSize:10,transitionsType:\'Random\',titleColor:#333333,slideAutoPlay:false,imageURLs:[\'img1.jpg\',\'img2.jpg\',\'img3.jpg\'],slideLoop:false,frameThickness:2,imageLinks:[\'http://macromedia.com/\',\'http://macromedia.com/\',\'http://macromedia.com/\'],frameColor:#333333,bgColor:#FFFFFF,imageCaptions:[]}" />
										  <embed src="'.$img_p.'"  quality="high" flashvars="flashlet={imageLinkTarget:\'_blank\',captionFont:\'Verdana\',titleFont:\'Verdana\',showControls:true,frameShow:false,slideDelay:5,captionSize:10,captionColor:#333333,titleSize:10,transitionsType:\'Random\',titleColor:#333333,slideAutoPlay:false,imageURLs:[\'img1.jpg\',\'img2.jpg\',\'img3.jpg\'],slideLoop:false,frameThickness:2,imageLinks:[\'http://macromedia.com/\',\'http://macromedia.com/\',\'http://macromedia.com/\'],frameColor:#333333,bgColor:#FFFFFF,imageCaptions:[]}" pluginspage="http://www.macromedia.com/shockwave/download/index.cgi?P1_Prod_Version=ShockwaveFlash" type="application/x-shockwave-flash" width="100" height="100"> </embed>
										</object>';
																			}else{
		?>
		<a href="gallery_view_img_comment.php?category_id=<?php echo $_GET[category_id];?>&amp;filename=<?php echo $_GET[filename];?>&amp;img_id=<?=$rs_img[img_id]?>" accesskey=<?php echo $db->genaccesskey();?>><img src="<?php echo $img_p?>" width="<?php echo $wi;?>"  height="<?php echo $hi;?>" hspace="0" vspace="0" border="0" align="top"  style="border:1px #C3C3C3 double ; padding:5px;"  alt="<?=$rs_img[img_name]?>" ></a><?php } ?>  
																					
																					<div class="text_normal"><?=$rs_img[img_name]?></div></td>
						<?php  if($i%$cal == ($cal-1)) {?> </tr> <?php }?>
					
						<?
						$i++;
		}//end while
		$d = $i%$cal;
		
		?>
			</table>
	<?php } ?>
<?php include("include_logo_w3c_template.php");?>
<?php $db->db_close(); ?>