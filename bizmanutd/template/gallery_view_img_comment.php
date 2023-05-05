<?php
	session_start();
	include("lib/function.php");
	include("lib/user_config.php");
	include("lib/connect.php");
	//include("language/language.php");
	include("../../ewt_block_function.php");
	include("../../ewt_menu_preview.php");
	include("../../ewt_article_preview.php");
	
	$mainwidth  = 0;
	if($_GET["filename"] != "") {
		$sql_index = $db->query("SELECT template_id,filename FROM temp_index WHERE filename = '".$_GET["filename"]."' ");
		$F = $db->db_fetch_array($sql_index);
		$d_idtemp = $F["template_id"];
	} else {
		$sql_index = $db->query("SELECT d_id FROM design_list WHERE d_default = 'Y'  ");
		$FF = $db->db_fetch_array($sql_index);
		$d_idtemp = $FF[d_id];
	}
	$lang_sh1 = explode('___',$F[filename]);
			if($lang_sh1[1] != ''){
				$lang_shw = $lang_sh1[1];
				$lang_sh = '_'.$lang_sh1[1];
				
			}else{
				$lang_sh ='';
				$lang_shw='';
			}
	include("language/language".$lang_sh.".php");
	$temp = "SELECT * FROM design_list WHERE d_id = '".$d_idtemp."'";
	$sql_temp= $db->query($temp);
	$F = $db->db_fetch_array($sql_temp);
	$design_id = $F["d_id"];

	$global_theme = $F["d_bottom_content"];
	$mainwidth = "0";

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
<html>
<head>
<title>Gallery</title>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<?php include("ewt_script.php");	?>
</head>
<body  leftmargin="0" topmargin="0" <?php if($F["d_site_bg_c"] != ""){ echo "bgcolor=\"".$F["d_site_bg_c"]."\""; } ?> <?php if($F["d_site_bg_p"] != ""){ echo "background=\"".$F["d_site_bg_p"]."\""; } ?> >
<table id="ewt_main_structure" width="<?php echo $F["d_site_width"]; ?>" border="0" cellpadding="0" cellspacing="0" align="<?php echo $F["d_site_align"]; ?>">
	<tr  valign="top" > 
		<td id="ewt_main_structure_top" height="<?php echo $F["d_top_height"]; ?>" bgcolor="<?php echo $F["d_top_bg_c"]; ?>" background="<?php echo $F["d_top_bg_p"]; ?>" colspan="3" >
		<?php $mainwidth = $F["d_site_width"]; ?>
		<?php
			$sql_left = $db->query("SELECT block.BID FROM block INNER JOIN design_block ON design_block.BID = block.BID WHERE design_block.side = '3' AND design_block.d_id = '".$design_id ."' ORDER BY design_block.position ASC");
			while($LB = $db->db_fetch_row($sql_left)) {
		?>
			<DIV><?php echo show_block($LB[0]); ?></DIV>
		<?php } ?>
		</td>
	</tr>
	<tr valign="top" > 
		<td id="ewt_main_structure_left" width="<?php echo $F["d_site_left"]; ?>" bgcolor="<?php echo $F["d_left_bg_c"]; ?>" background="<?php echo $F["d_left_bg_p"]; ?>">
		<?php $mainwidth = $F["d_site_left"]; ?>
		<?php
			$sql_left = $db->query("SELECT block.BID FROM block INNER JOIN design_block ON design_block.BID = block.BID WHERE design_block.side = '1' AND design_block.d_id = '".$design_id ."' ORDER BY design_block.position ASC");
			while($LB = $db->db_fetch_row($sql_left)) {
		?>
			<DIV><?php echo show_block($LB[0]); ?></DIV>
		<?php } ?>
		</td>
		<td id="ewt_main_structure_body" width="<?php echo $F["d_site_content"]; ?>" bgcolor="<?php echo $F["d_body_bg_c"]; ?>" height="160" background="<?php echo $F["d_body_bg_p"]; ?>"> 
		<?php $mainwidth = $F["d_site_content"]; ?>
		<?php
			$sql_left = $db->query("SELECT block.BID FROM block INNER JOIN design_block ON design_block.BID = block.BID WHERE design_block.side = '5' AND design_block.d_id = '".$design_id ."' ORDER BY design_block.position ASC");
			while($LB = $db->db_fetch_row($sql_left)) {
		?>
			<DIV><?php echo show_block($LB[0]); ?></DIV>
		<?php } ?>
		<?php
			if($_POST[page_cat]) $page_cat = $_POST[page_cat];
			else $page_cat = $_GET[page_cat];
			
			if($_POST[category_id]) $category_id = $_POST[category_id];
			else $category_id = $_GET[category_id];
			
			if($_POST[img_id]) $img_id = $_POST[img_id];
			else $img_id = $_GET[img_id];
			if($lang_sh != ''){
			$sql_category = "SELECT * FROM gallery_category 
							INNER JOIN lang_gallery_category ON gallery_category.category_id = lang_gallery_category.c_id
							INNER JOIN lang_config ON lang_config.lang_config_id = lang_gallery_category.lang_name
							WHERE lang_config.lang_config_suffix = '$lang_shw'  AND lang_field ='category_name' AND category_id = '".$_GET[category_id]."'";
			}else{
			$sql_category = "SELECT * FROM gallery_category WHERE category_id = '".$_GET[category_id]."' ";
			}
			$query_category = $db->query($sql_category);
			$rs_category = $db->db_fetch_array($query_category);
			if($lang_sh != ''){
			$rs_category[category_name] = $rs_category[lang_detail];
			}
			$hi = $rs_category[height_b];
			$wi = $rs_category[width_b];
			if($lang_sh != ''){
			$sql_img = "SELECT * FROM gallery_cat_img 
						INNER JOIN gallery_image ON gallery_cat_img.img_id = gallery_image.img_id 
						INNER JOIN lang_gallery_image ON gallery_image.img_id = lang_gallery_image.c_id
						INNER JOIN lang_config ON lang_config.lang_config_id = lang_gallery_image.lang_name
						WHERE gallery_cat_img.img_id = '".$_GET[img_id]."' and lang_config.lang_config_suffix = '$lang_shw' and lang_field ='img_name' ORDER BY cat_img_id,gallery_image.img_id";
			}else{
			$sql_img = "SELECT * FROM gallery_image WHERE img_id = '".$_GET[img_id]."' ";
			}
			$query_img = $db->query($sql_img);
			$rs_img = $db->db_fetch_array($query_img);
			if($lang_sh != ''){$rs_img[img_name] = $rs_img[lang_detail];}
		?>
		<?php
			//$mainwidth = 0;
			//echo "select * from block where BID = '".$_GET[BID]."' ";
			$sql = $db->query("select * from block where BID = '".$_GET[BID]."' ");
			$rec = $db->db_fetch_array($sql);
			//$s_id=$rec[block_link];
			
			//echo  $rec[block_themes];
			if($rec[block_themes] !=0) { $themes = $rec[block_themes]; } else { $themes = $global_theme; }
			if($themes!= '0' && $themes != ''){
				$namefolder = "themes".($themes);
				@include("themesdesign/".$namefolder."/".$namefolder.".php");
				//if($themes_type == 'F') {
					$buffer = "";
				if(file_exists($Current_Dir1.$themes_file) && $themes_file!=''){ //block_themes
					$fd = @fopen ($Current_Dir1.$themes_file, "r");
					while (!@feof ($fd)) { $buffer .= @fgets($fd, 4096); }
					@fclose ($fd);
					$exp = "<"."?#htmlshow#?".">";
					$design = explode($exp,$buffer);
				}
			}else{
				$bg_color='#F6F6F6';
				$Current_Dir1='mainpic/';
				$bg_img='';
				
				$head_img='';
				$head_height='';
				$head_font_color='#FF6600';
				
				$body_color='#FFFFFF';
				$body_font_color='';
				
				$bottom_color='#FFFFFF';
				$bg_width = "100%";
			}
		?>
		<?php echo $design[0];?>
			<table width="<?php echo $bg_width;?>" border="0" cellspacing="0" cellpadding="1" align="center">
				<tr>
					<td></td>
					<?php
						if($lang_sh != ''){
							$sql_imgb = "SELECT gallery_image.img_id,gallery_image.img_name,gallery_image.img_path_s FROM gallery_cat_img INNER JOIN gallery_image ON gallery_cat_img.img_id = gallery_image.img_id
										INNER JOIN lang_gallery_image ON gallery_image.img_id = lang_gallery_image.c_id
										INNER JOIN lang_config ON lang_config.lang_config_id = lang_gallery_image.lang_name
										WHERE  lang_config.lang_config_suffix = '$lang_shw' and lang_field ='img_name' AND gallery_image.img_id < '".$img_id."' AND gallery_cat_img.category_id = '".$category_id."' ORDER BY gallery_image.img_id DESC LIMIT 0,1";
							}else{
							$sql_imgb = "SELECT gallery_image.img_id,gallery_image.img_name,gallery_image.img_path_s FROM gallery_cat_img INNER JOIN gallery_image ON gallery_cat_img.img_id = gallery_image.img_id WHERE gallery_image.img_id < '".$img_id."' AND gallery_cat_img.category_id = '".$category_id."' ORDER BY gallery_image.img_id DESC LIMIT 0,1";
						}
						$query_imgb = $db->query($sql_imgb);
						if($db->db_num_rows($query_imgb) > 0) {
							$B = $db->db_fetch_row($query_imgb);
					?>
					<td width="70" align="center" valign="top" title="<?php echo $B[1]; ?>" style="cursor:hand" onClick="self.location.href='gallery_view_img_comment.php?category_id=<?php echo $category_id; ?>&filename=<?php echo $filename; ?>&img_id=<?php echo $B[0] ?>&page_cat=<?php echo $page_cat; ?>&BID=<?php echo $_GET['BID']; ?>';">
						<table  border="0" cellpadding="5" cellspacing="1" bgcolor="#999999" width="60" height="60">
							<tr>
								<td bgcolor="#FFFFFF" align="center"><div align="center"><img src="phpThumb.php?src=<?php echo $B[2]; ?>&h=50&w=50" hspace="0" vspace="0" border="0" align="middle" ></div></td>
							</tr>
						</table>&lt; Previous
					</td>
					<?php } ?>
					<?php
						if($lang_sh != ''){
							$sql_imga = "SELECT gallery_image.img_id,gallery_image.img_name,gallery_image.img_path_s FROM gallery_cat_img INNER JOIN gallery_image ON gallery_cat_img.img_id = gallery_image.img_id
										INNER JOIN lang_gallery_image ON gallery_image.img_id = lang_gallery_image.c_id
										INNER JOIN lang_config ON lang_config.lang_config_id = lang_gallery_image.lang_name
										WHERE  lang_config.lang_config_suffix = '$lang_shw' and lang_field ='img_name' AND gallery_image.img_id> '".$img_id."' AND gallery_cat_img.category_id = '".$category_id."' ORDER BY gallery_image.img_id DESC LIMIT 0,1";
							}else{
						$sql_imga = "SELECT gallery_image.img_id,gallery_image.img_name,gallery_image.img_path_s FROM gallery_cat_img INNER JOIN gallery_image ON gallery_cat_img.img_id = gallery_image.img_id WHERE gallery_image.img_id > '".$img_id."' AND gallery_cat_img.category_id = '".$category_id."' ORDER BY gallery_image.img_id ASC LIMIT 0,1";
						}
						$query_imga = $db->query($sql_imga);
						if($db->db_num_rows($query_imga) > 0) {
							$A = $db->db_fetch_row($query_imga);
					?>
					<td width="70" align="center" valign="top"  title="<?php echo $A[1]; ?>" style="cursor:hand" onClick="self.location.href='gallery_view_img_comment.php?category_id=<?php echo $category_id; ?>&filename=<?php echo $filename; ?>&img_id=<?php echo $A[0] ?>&page_cat=<?php echo $page_cat; ?>&BID=<?php echo $_GET['BID']; ?>';">
						<table  border="0" cellpadding="5" cellspacing="1" bgcolor="#999999" width="60" height="60">
							<tr>
								<td bgcolor="#FFFFFF" align="center"><div align="center"><img src="phpThumb.php?src=<?php echo $A[2]; ?>&h=50&w=50" hspace="0" vspace="0" border="0" align="middle" ></div></td>
							</tr>
						</table>Next &gt;
					</td>
					<?php } ?>
				</tr>
			</table>
			<table width="<?php echo $bg_width;?>" align="center" cellpadding="3" cellspacing="1"  bgcolor="<?php echo $bg_color;?>" background="<?php echo $Current_Dir1.$bg_img;?>">
				<tr>
					<td align="center" valign="top" height="<?php echo $head_height;?>" bgcolor="<?php echo $head_color;?>" background="<?php echo $Current_Dir1.$head_img;?>">
						<table width="100%" border="0" cellspacing="0" cellpadding="1">
							<tr><td ><a href="gallery_view_catelogy_all.php?flag=all&filename=<?php echo $_REQUEST[filename];?>&BID=<?php echo $_REQUEST[BID];?>"><font color="<?php echo $head_font_color;?>"  face="<?php echo $head_font_face;?>"><span style="font-size: <?php echo $head_font_size;?>"><strong><?php echo $text_GenGallery_cat ;?></strong></span></font></a><font color="<?php echo $head_font_color;?>"  face="<?php echo $head_font_face;?>"><span style="font-size: <?php echo $head_font_size;?>"><strong> >><?php echo $rs_category[category_name]; ?></strong></span></font></td></tr>
						</table>
					</td>
				</tr>
				<tr>
					<td valign="top">
						<table width="100%" border="0" cellpadding="3" cellspacing="1">
							<tr>
								<td align="center" valign="middle" bgcolor="<?php echo $body_color;?>" background="<?php echo $Current_Dir1.$body_bg_img;?>">
									<table  border="0" cellpadding="1" cellspacing="1" bgcolor="<?php echo $body_color;?>" width="<?php echo $wi;?>" height="<?php echo $hi;?>">
										<tr><td bgcolor="#FFFFFF" background="<?php echo $Current_Dir1.$body_bg_img;?>" align="center"><table  border="0" cellspacing="0" cellpadding="0">
                      <tr>
                        <td width="30" height="30"><img src="mainpic/gallery/bor_01.gif" width="30" height="30" ></td>
                        <td height="30" background="mainpic/gallery/bor_03.gif"><img src="mainpic/gallery/bor_02.gif" width="40" height="30" ></td>
                        <td width="30" height="30"><img src="mainpic/gallery/bor_05.gif" width="30" height="30" ></td>
                      </tr>
                      <tr>
                        <td width="30" valign="top" background="mainpic/gallery/bor_11.gif"><img src="mainpic/gallery/bor_06.gif" width="30" height="100" ></td>
                        <td align="center">  
                         <img src="phpThumb.php?src=<?php echo $rs_img[img_path_b]?>&h=<?php echo $wi;?>&w=<?php echo $hi;?>" hspace="0" vspace="0" align="middle" >
						 <div align="left"><strong ><?php echo $rs_img[img_name]?></strong><hr size="1"><?php echo $rs_img[img_detail];?></div>
									<br><br>
									<?php if($rs_category[category_vote] == 1) { ?>
									<a href="gallery_process_comment.php?flag=vote&category_id=<?php echo $category_id;?>&img_id=<?php echo $img_id;?>&filename=<?php echo $filename;?>"><font color="<?php echo $body_font_color;?>"  face="<?php echo $body_font_face;?>" ><span style="font-size: <?php echo $body_font_size;?>"><?php echo $text_GenGallery_vote;?></span></font></a>
									<font color="<?php echo $body_font_color;?>"  face="<?php echo $body_font_face;?>" ><span style="font-size: <?php echo $body_font_size;?>">&nbsp;&nbsp;|&nbsp;&nbsp;</span></font>
									<?php } ?>
									<?php if($rs_category[category_send] == 1) { ?>
									<a href="#&2" onClick="window.open('gallery_send.php?filename=<?php echo $filename;?>','mail','width=500,height=300,scrollbars=1,resizable = 1');"><font color="<?php echo $body_font_color;?>"  face="<?php echo $body_font_face;?>" ><span style="font-size: <?php echo $body_font_size;?>"><?php echo $text_GenGallery_sandtofriend;?></span></font></a><?php } ?>
									<?php if($rs_category[category_vote] == 1) { ?><br><br><font color="<?php echo $body_font_color2;?>"  face="<?php echo $body_font_face2;?>" ><span style="font-size: <?php echo $body_font_size2;?>"><?php echo $text_GenGallery_flavor;?><?php if($rs_img[img_vote] != '0'){ echo $rs_img[img_vote];}else{ echo '0';}?><?php echo $text_GenGallery_point;?></span></font><br><br>
									<?php } ?>
									<?php
									/*$sql_vote = "SELECT SUM(vote) as vote_all,count(*) as count_vote FROM gallery_comment WHERE category_id = '".$category_id."' AND img_id = '".$img_id."' Group BY img_id,category_id ";
									$query_vote = $db->query($sql_vote);
									$rs_vote = $db->db_fetch_array($query_vote);
									if($rs_vote[count_vote]>0){
									$rs_vote[vote_all];
									$vote_full = $rs_vote[count_vote]*5;
									@$rate_vote = $rs_vote[vote_all]*100/$vote_full;
									if($rate_vote>=100){
									$round = 5;
									$herf = false;
									}else if($rate_vote>=90 && $rate_vote<100){
									$round = 5;
									$herf = false;
									}else if($rate_vote>=80 && $rate_vote<90){
									$round = 4;
									$herf = true;
									}else if($rate_vote>=70 && $rate_vote<80){
									$round = 4;
									$herf = false;
									}else if($rate_vote>=60 && $rate_vote<70){
									$round = 3;
									$herf = true;
									}else if($rate_vote>=50 && $rate_vote<60){
									$round = 3;
									$herf = false;
									}else if($rate_vote>=40 && $rate_vote<50){
									$round = 2;
									$herf = true;
									}else if($rate_vote>=30 && $rate_vote<40){
									$round = 2;
									$herf = false;
									}else if($rate_vote>=20 && $rate_vote<30){
									$round = 1;
									$herf = true;
									}else if($rate_vote>=0 && $rate_vote<20){
									$round = 1;
									$herf = false;
									}*/
									/*if($rate_vote<100 ){
									if($rate_vote<90){
									if($rate_vote<80){
									if($rate_vote<70){
									if($rate_vote<60){
									if($rate_vote<50){
									if($rate_vote<40){
									if($rate_vote<30){
									if($rate_vote<20){
									if($rate_vote<10){ 
									$round = 1;
									$herf = false;
									}else{
									$round = 1;
									$herf = true;
									}
									}else{
									$round = 2;
									$herf = false;
									}
									}else{
									$round = 2;
									$herf = true;
									}
									}else{
									$round = 3;
									$herf = false;
									}
									}else{
									$round = 3;
									$herf = true;
									}
									}else{
									$round = 4;
									$herf = false;
									}
									}else{
									$round = 4;
									$herf = true;
									}
									}else{
									$round = 5;
									$herf = false;
									}
									}else{
									$round = 5;
									$herf = true;
									}
									}
									print $round;*/
									?>
									<!--คะแนน Vote (<?php echo $rate_vote."%";?>) :   -->
									<?php
									/*for($i=1;$i<=$round;$i++){*/
									?>
									<!--<img src="images/star_yellow.GIF" height="16" width="16" align="absmiddle"> -->
									<?php	
									/*}
									if($herf){
									print '<img src="images/half_star_yellow.gif" height="16" width="8" align="absmiddle">';
									}
									}*/
									?>
									<!--</strong> -->
                          </td>
                            <td width="30" valign="bottom" background="mainpic/gallery/bor_09.gif"><img src="mainpic/gallery/bor_10.gif" width="30" height="100" ></td>
                          </tr>
                          <tr>
                            <td width="30" height="29"><img src="mainpic/gallery/bor_13.gif" width="30" height="29" ></td>
                            <td height="29" background="mainpic/gallery/bor_15.gif"><div align="right"><img src="mainpic/gallery/bor_16.gif" width="40" height="29" ></div></td>
                            <td width="30" height="29"><img src="mainpic/gallery/bor_17.gif" width="30" height="29" ></td>
                          </tr>
                        </table></td></tr>
									</table>
									
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
			<?php if($rs_category[category_comment] == 1) { ?>
			<br>
			<div id="div_comment">
				<table width="<?php echo $bg_width;?>" border="0" align="center" cellpadding="0" cellspacing="1">
					<tr><th scope="col"><div align="right">&nbsp;&nbsp;</div></th></tr>
				</table>
				<table width="<?php echo $bg_width;?>" border="0" align="center" cellpadding="1" cellspacing="1">
				<?php
					$sql_comment = "SELECT count(*) as count_com FROM gallery_comment WHERE category_id = '".$_GET[category_id]."' and img_id = '".$rs_img[img_id]."' ";
					$query_comment = $db->query($sql_comment);
					$rs_comment = $db->db_fetch_array($query_comment);
				?>
					<tr>
						<td  colspan="2" height="<?php echo $head_height;?>" bgcolor="<?php echo $head_color;?>" background="<?php echo $Current_Dir1.$head_img;?>"><font color="<?php echo $head_font_color;?>"  face="<?php echo $head_font_face;?>"><span style="font-size: <?php echo $head_font_size;?>"><strong> &bull;   <?php echo $text_GenGallery_opinion;?> (<?php echo $rs_comment[count_com]?>)</strong> </span></font></td>
					</tr>
					<tr>
						<td colspan="2" bgcolor="<?php echo $body_color;?>" background="<?php echo $Current_Dir1.$body_bg_img;?>">
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
									<td width="20%" valign="top" ><nobr><font color="<?php echo $body_font_color;?>"  face="<?php echo $body_font_face;?>" ><span style="font-size: <?php echo $body_font_size;?>">&nbsp;<?php echo $text_GenGallery_opinion1;?> <?php echo $rs_comment[choice]?>  : </span></font></nobr></td>
									<td width="80%" ><font color="<?php echo $body_font_color2;?>"  face="<?php echo $body_font_face2;?>" ><span style="font-size: <?php echo $body_font_size2;?>"><?php echo $text_GenGallery_titlename;?><?php echo cencer_rude($rs_comment[name])?>&nbsp;&nbsp;&nbsp;<br><?php echo $date_time_full?> </span></font></td>
								</tr>
								<tr>
									<td >&nbsp;</td>
									<td ><font color="<?php echo $body_font_color3;?>"  face="<?php echo $body_font_face3;?>" ><span style="font-size: <?php echo $body_font_size3;?>"><?php echo str_replace("\n","<br>",cencer_rude($rs_comment[comment])); ?></span></font></td>
								</tr>
								<tr><td colspan="2"><hr size="1" color="#EFECF0"></td></tr>
							</table>
						<?php 
								}
						?>
							<table width="100%" border="0" bgcolor="<?php echo $body_color;?>" background="<?php echo $Current_Dir1.$body_bg_img;?>">
								<tr>
									<td align="right"><?php echo $text_general_page;?>
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
										<?php echo $text_general_page;?>
										<!--<img src="images/close.gif" alt="ลบความคิดเห็นทั้งหมด" style="cursor:hand" align="absmiddle"  onClick="if(confirm('ยืนยันการลบ')){location.href = 'gallery_process_comment.php?category_id=<?php//=$category_id?>&img_id=<?php//=$img_id?>&flag=del&type=all';}">ลบความคิดเห็นทั้งหมด-->
									</td>
								</tr>
							</table>
						<?php
							} else {
						?>
							<table width="100%" border="0" align="center" class="text_normal">
								<tr><th><hr size="1" color="#EFECF0"></th></tr>
								<tr><th><strong style="color:#FF0000"><?php echo $text_GenGallery_nocomment;?> </strong></th></tr>
								<tr><th><hr size="1" color="#EFECF0"></th></tr>
							</table>
						<?php }?>
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
				<input type="hidden" name="filename" value="<?php echo $filename?>">
				<table width="<?php echo $bg_width;?>"  border="0" align="center" cellpadding="0" cellspacing="1">
					<tr>
						<td  valign="top">
							<table width="100%" border="0" cellspacing="0" cellpadding="0">
								<tr>
									<td height="6" colspan="3" >&nbsp;</td>
								</tr>
								<tr>
									<td valign="top" height="<?php echo $head_height;?>" bgcolor="<?php echo $head_color;?>" background="<?php echo $Current_Dir1.$head_img;?>"><font color="<?php echo $head_font_color;?>"  face="<?php echo $head_font_face;?>"><span style="font-size: <?php echo $head_font_size;?>"> <strong>&bull; <?php echo $text_GenGallery_opinion2 ;?></strong></span></font></td>
								</tr>
							</table>
						</td>
					</tr>
					<tr>
						<td valign="top">
							<table width="100%" border="0" cellpadding="3" cellspacing="1">
								<tr>
									<td align="center" valign="top" bgcolor="<?php echo $body_color;?>" background="<?php echo $Current_Dir1.$body_bg_img;?>">
										<table width="100%" border="0" class="text_normal">
											<tr>
												<td width="15%" align="right" scope="col"><font color="<?php echo $body_font_color;?>"  face="<?php echo $body_font_face;?>" ><span style="font-size: <?php echo $body_font_size;?>"><?php echo $text_GenGallery_name;?></span></font></td>
												<td width="85%" scope="col"><input name="name" type="text" size="50" value="<?php echo $_SESSION["EWT_NAME"];?>"></td>
											</tr>
											<tr>
												<td align="right" valign="top"><font color="<?php echo $body_font_color;?>"  face="<?php echo $body_font_face;?>" ><span style="font-size: <?php echo $body_font_size;?>"><?php echo $text_GenGallery_detail;?></span></font></td>
												<td><textarea name="comment" cols="50" rows="5" onKeyUp="if(this.value.length%50 == 0){}"></textarea></td>
											</tr>
											<!--<tr>
											<td><div align="right"><strong>ส่ง E-mail :&nbsp;&nbsp;&nbsp;&nbsp; </strong></div></td>
											<td>&nbsp;&nbsp;
											<input name="email" type="text" size="50"></td></tr>-->
											<tr>
												<td>&nbsp;</td>
												<td>&nbsp;&nbsp;
													<input type="submit" name="Submit" value="<?php echo $text_GenGallery_sentcomment;?>" onClick="return chk_name(this.form)">
													<input type="hidden" name="flag" value="add">
													<input type="hidden" name="filename" value="<?php echo $filename;?>">
													<input type="hidden" name="fn" value="gallery_view_img_comment.php">
													&nbsp;&nbsp;
													<label><input type="reset" name="Submit2" value="<?php echo $text_general_reset;?>"></label>
												</td>
											</tr>
										</table>
									</td>
								</tr>
							</table>
						</td>
					</tr>
				</table>
				<?php echo $design[1];?>
				<script>
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
			</td>
			<td id="ewt_main_structure_right" width="<?php echo $F["d_site_right"]; ?>" bgcolor="<?php echo $F["d_right_bg_c"]; ?>" background="<?php echo $F["d_right_bg_p"]; ?>">
				<?php
				$mainwidth = $F["d_site_right"];
				?><?php
				$sql_left = $db->query("SELECT block.BID FROM block INNER JOIN design_block ON design_block.BID = block.BID WHERE design_block.side = '2' AND design_block.d_id = '".$design_id ."' ORDER BY design_block.position ASC");
				while($LB = $db->db_fetch_row($sql_left)){
				?>
				<DIV><?php echo show_block($LB[0]); ?></DIV>
				<?php } ?>
			</td>
		</tr>
<tr valign="top" > 
<td id="ewt_main_structure_bottom" height="<?php echo $F["d_bottom_height"]; ?>" bgcolor="<?php echo $F["d_bottom_bg_c"]; ?>" background="<?php echo $F["d_bottom_bg_p"]; ?>" colspan="3" >
<?php
$mainwidth = $F["d_site_width"];
?><?php
$sql_left = $db->query("SELECT block.BID FROM block INNER JOIN design_block ON design_block.BID = block.BID WHERE design_block.side = '4' AND design_block.d_id = '".$design_id ."' ORDER BY design_block.position ASC");
while($LB = $db->db_fetch_row($sql_left)){
?>
<DIV><?php echo show_block($LB[0]); ?></DIV>
<?php } ?>
</td>
</tr>
</table>
</body>
</html>
<?php 
if(!empty($img_id)){
$sql_insert = "insert into gallery_log (img_id,ip,date,time) VALUES ('".$img_id."','".getenv("REMOTE_ADDR")."','".date('Y-m-d')."','".date('H:i:s')."')";
$db->query($sql_insert);
}




$db->db_close(); ?>
