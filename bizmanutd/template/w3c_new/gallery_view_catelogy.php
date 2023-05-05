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
?><!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html lang="th">
<head>
<title><?php echo $ewt_mytitle; ?></title>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<meta name="Keywords" content="<?php echo $ewt_mykeyword; ?>" >
<meta name="Description" content="<?php echo $ewt_mydescription; ?>">
<?php include("ewt_script.php");?>
</head>
<body <?php if($F["d_site_bg_c"] != ""){ echo "bgcolor=\"".$F["d_site_bg_c"]."\""; } ?> <?php if($F["d_site_bg_p"] != ""){ echo "background=\"".$F["d_site_bg_p"]."\""; } ?>>
<table <?php if($F["d_site_width"] != ""){ echo "width=\"".$F["d_site_width"]."\""; } ?> border="0" cellpadding="0" cellspacing="0" <?php if($F["d_site_align"] != ""){ echo "align=\"".$F["d_site_align"]."\""; } ?>>
  <tr>
    <td  <?php if($F["d_top_height"] != ""){ echo "height=\"".$F["d_top_height"]."\""; } ?> <?php  if($F["d_top_bg_c"] != ""){ echo "bgcolor=\"".$F["d_top_bg_c"]."\""; } ?>  colspan="3" >
	  <?php
			$mainwidth = $F["d_site_width"];
			?><?php
		  $sql_top = $db->query("SELECT block.BID FROM block INNER JOIN design_block ON design_block.BID = block.BID WHERE design_block.side = '3' AND design_block.d_id = '".$design_id."' ORDER BY design_block.position ASC");
		  while($TB = $db->db_fetch_row($sql_top)){
		  ?>
<DIV ><?php echo show_block($TB[0]); ?></DIV>
		<?php } ?>
	</td>
  </tr>
  <tr>
    <td  valign="top"  <?php if($F["d_site_left"] != ""){ echo "width=\"".$F["d_site_left"]."\""; } ?> <?php  if($F["d_left_bg_c"] != ""){ echo "bgcolor=\"".$F["d_left_bg_c"]."\""; } ?>>
	  <?php
			$mainwidth = $F["d_site_left"];
			?><?php
		  $sql_left = $db->query("SELECT block.BID FROM block INNER JOIN design_block ON design_block.BID = block.BID WHERE design_block.side = '1' AND design_block.d_id = '".$design_id."' ORDER BY design_block.position ASC");
		  while($LB = $db->db_fetch_row($sql_left)){
		  ?>
<DIV><?php echo show_block($LB[0]); ?></DIV>
		<?php } ?>

	
	
	
	</td>
    <td height="160"  valign="top"  <?php if($F["d_site_content"] != ""){ echo "width=\"".$F["d_site_content"]."\""; } ?> <?php  if($F["d_body_bg_c"] != ""){ echo "bgcolor=\"".$F["d_body_bg_c"]."\""; } ?>>
	<?php
			$mainwidth = $F["d_site_content"];
			?>
			
			
			
			
		<table width="96%" border="0" align="center">
		  <tr>
			<td ><br>
			<?php
			function findparent($id){
			 global $db;
			 global $filename;
			  global $lang_shw;
			 $sql = $db->query("select category_name,category_id,parent_id from gallery_category where category_id ='".$id."'");
		
				if($db->db_num_rows($sql)){
					$G = $db->db_fetch_array($sql);
					$txt = " <a href = \"gallery_view_catelogy.php?category_id=".$G["category_id"]."\">".$G["category_name"]."</a> &gt;&gt; ";
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
<span class="text_head"><a href="gallery_view_catelogy.php"><?php echo $text_GenGallery_cat;?></a><?php echo $name;?></span><hr ></td>
		</tr>
		</table>

		<DIV id="group_gallery"></DIV>
		<script type="text/javascript" language="javascript1.2">
function galery_show(offset,category_id) {
	var objDiv = document.getElementById("group_gallery");
	url='gallery_group_list.php?offset='+offset+'&category_id='+category_id;				
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
		 <td width="<?php echo $w ;?>%" align="center" valign="top" >
		<a href="gallery_view_img_comment.php?category_id=<?php echo $_GET[category_id];?>&amp;filename=<?php echo $_GET[filename];?>&amp;img_id=<?php echo $rs_img[img_id]?>" ><img src="<?php echo $img_p?>" width="<?php echo $wi;?>"  height="<?php echo $hi;?>" hspace="0" vspace="0" border="0" align="top"  style="border:1px #C3C3C3 double ; padding:5px;"  alt="<?php echo $rs_img[img_name]?>" ></a>
																					
																					<div class="text_normal"><?php echo $rs_img[img_name]?></div></td>
						<?php  if($i%$cal == ($cal-1)) {?> </tr> <?php }?>
					
						<?php
						$i++;
		}//end while
		$d = $i%$cal;
		for($b=$d;$b<$cal;$b++){
		?><td width="<?php echo $w ;?>%" align="center" valign="top" >&nbsp;
		 </td>
		<?php 
		}
		?>
			</table>
	<?php } ?>
	
	
	</td>
    <td  valign="top"  <?php if($F["d_site_right"] != ""){ echo "width=\"".$F["d_site_right"]."\""; } ?> <?php  if($F["d_right_bg_c"] != ""){ echo "bgcolor=\"".$F["d_right_bg_c"]."\""; } ?>>	 
	 <?php
			$mainwidth =  $F["d_site_right"];
			?><?php
		  $sql_right = $db->query("SELECT block.BID FROM block INNER JOIN design_block ON design_block.BID = block.BID WHERE design_block.side = '2' AND design_block.d_id = '".$design_id."' ORDER BY design_block.position ASC");
		  while($RB = $db->db_fetch_row($sql_right)){
		  ?>
<DIV><?php echo show_block($RB[0]); ?></DIV>
		<?php } ?></td>
  </tr>
  <tr valign="top" > 
          <td  colspan="3"  valign="top"  <?php if($F["d_bottom_height"] != ""){ echo "height=\"".$F["d_bottom_height"]."\""; } ?> <?php  if($F["d_bottom_bg_c"] != ""){ echo "bgcolor=\"".$F["d_bottom_bg_c"]."\""; } ?> <?php if($F["d_bottom_bg_p"] != ""){ echo "background=\"".$F["d_bottom_bg_p"]."\""; } ?>>	 
		  <?php
			$mainwidth = $RR["d_site_width"];
			?><?php
		  $sql_bottom = $db->query("SELECT block.BID FROM block INNER JOIN design_block ON design_block.BID = block.BID WHERE design_block.side = '4' AND design_block.d_id = '".$design_id."' ORDER BY design_block.position ASC");
		  while($BB = $db->db_fetch_row($sql_bottom)){
		  ?>
<DIV><?php echo show_block($BB[0]); ?></DIV>
		<?php } ?></td>
        </tr>
</table>
<a href="http://validator.w3.org/check?uri=referer"><img src="../w3c/checked/images/w3c_gold.bmp" alt="Valid HTML 4.01 Transitional" height="31" width="88" border="0"></a><?php  include("ewt_span.php");?>
</body>
</html>
<?php $db->db_close(); ?>