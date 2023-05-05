<?php
	session_start();
	$start_time_counter = date("YmdHis");
	include("lib/function.php");
	include("lib/user_config.php");
	include("lib/connect.php");
	include("../../ewt_block_function.php");
	include("../../ewt_menu_preview.php");
	include("../../ewt_article_preview.php");

		$sql_index = $db->query("SELECT * FROM temp_index WHERE filename = '".$_GET["filename"]."' ");
		$F = $db->db_fetch_array($sql_index);

		$mainwidth = "0";
		$lang_sh = explode('___',$F[filename]);
		if($lang_sh[1] != ''){$lang_sh = '_'.$lang_sh[1];}else{$lang_sh ='';}
		$private_b = "";

	$use_template = "";

		$sql_theme= $db->query("SELECT d_bottom_content FROM design_list WHERE d_id = '".$F["template_id"]."'");
		$X = $db->db_fetch_row($sql_theme);
		$global_theme = $X[0];

	$ewt_mytitle = "";
	$ewt_mykeyword = "";
	$ewt_mydescription = "";
	$sql_website = $db->query("SELECT site_info_title,site_info_keyword,site_info_description FROM site_info  ");
	$SF = $db->db_fetch_array($sql_website);
	if($F["title"] != ""){
		$ewt_mytitle = addslashes($F["title"]);
	}else{
		$ewt_mytitle = addslashes($SF["site_info_title"]);
	}
	if($F["cms_keyword"] != ""){
		$ewt_mykeyword = addslashes(htmlspecialchars($F["cms_keyword"], ENT_QUOTES));
	}else{
		$ewt_mykeyword = addslashes(htmlspecialchars($SF["site_info_keyword"], ENT_QUOTES));
	}
	if($F["cms_description"] != ""){
		$ewt_mydescription = addslashes(htmlspecialchars($F["cms_description"], ENT_QUOTES));
	}else{
		$ewt_mydescription = addslashes(htmlspecialchars($SF["site_info_description"], ENT_QUOTES));
	}
	$ewt_mykeyword = eregi_replace(chr(13)," ",$ewt_mykeyword);
	$ewt_mykeyword = eregi_replace("  "," ",$ewt_mykeyword);
	$ewt_mydescription = eregi_replace(chr(13)," ",$ewt_mydescription);
	$ewt_mydescription = eregi_replace("  "," ",$ewt_mydescription);
	$filenames = $_GET["filename"];
	 function GenArticleCodeText($bid,$mainwidth){
	 	global $lang_sh,$global_theme,$filenames;
		 $txt = "<div id=\"artc".$bid."\"></div>\n";
		 $txt .= "<script language=\"javascript\">\n";
		 $txt .= "url='news_ajax.php?bid=".$bid."&filename=".$filenames."&mainwidth=".$mainwidth."&global_theme=".$global_theme."&lang_sh=".$lang_sh."';\n";
		 $txt .= "AjaxRequest.get(\n";
		 $txt .= "{\n";
		 $txt .= "'url':url\n";
		 $txt .= ",'onLoading':function() { }\n";
		 $txt .= ",'onLoaded':function() { }\n";
		 $txt .= ",'onInteractive':function() { }\n";
		 $txt .= ",'onComplete':function() { }\n";
		 $txt .= ",'onSuccess':function(req) {\n";
		 $txt .= "document.all.artc".$bid.".innerHTML = req.responseText; \n";
		 $txt .= "}\n";
		 $txt .= "}\n";
		 $txt .= ");\n";
		 $txt .= "</script>\n";
return $txt;
	 }
			?>
<html>
<head>
<title><?php echo $ewt_mytitle; ?></title>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<meta name="Keywords" content="<?php echo $ewt_mykeyword; ?>" />
<meta name="Description" content="<?php echo $ewt_mydescription; ?>"/>
<?php
include("ewt_script.php");	
?>
</head>
<body   leftmargin="0" topmargin="0" <?php if($F["d_site_bg_c"] != ""){ echo "bgcolor=\"".$F["d_site_bg_c"]."\""; } ?> <?php if($F["d_site_bg_p"] != ""){ echo "background=\"".$F["d_site_bg_p"]."\""; } ?> >

<table id="ewt_main_structure" width="<?php echo $F["d_site_width"]; ?>" border="0" cellpadding="0" cellspacing="0" align="<?php echo $F["d_site_align"]; ?>">
	<tr  valign="top" > 
		<td id="ewt_main_structure_top" height="<?php echo $F["d_top_height"]; ?>" bgcolor="<?php echo $F["d_top_bg_c"]; ?>" background="<?php echo $F["d_top_bg_p"]; ?>" colspan="3" >
		<?php
			$mainwidth = $F["d_site_width"];
				$sql_top = $db->query("SELECT block.BID,block.block_type,block.block_html FROM block INNER JOIN block_function ON block_function.BID = block.BID WHERE block_function.side = '3' AND block_function.filename = '".$_GET["filename"]."' ORDER BY block_function.position ASC");
			while($B = $db->db_fetch_row($sql_top)){
		?>
		<DIV >
		<?php 
				if($B[1] == "text" OR $B[1] == "code"  OR $B[1] == "images" OR $B[1] == "flash" OR $B[1] == "media" OR $B[1] == "menu" ){ 
					echo stripslashes($B[2]); 
				}elseif($B[1] == "article"){
					echo GenArticleCodeText($B[0],$mainwidth);
				}else{ 
					echo show_block($B[0]); 
				}
		?>
		</DIV>
		<?php } ?>
</td>
</tr>
<tr valign="top" > 
<td id="ewt_main_structure_left" width="<?php echo $F["d_site_left"]; ?>" bgcolor="<?php echo $F["d_left_bg_c"]; ?>" background="<?php echo $F["d_left_bg_p"]; ?>">
<?php
			$mainwidth = $F["d_site_left"];
$sql_left = $db->query("SELECT block.BID,block.block_type,block.block_html FROM block INNER JOIN block_function ON block_function.BID = block.BID WHERE block_function.side = '1' AND block_function.filename = '".$_GET["filename"]."' ORDER BY block_function.position ASC");
while($B = $db->db_fetch_row($sql_left)){
?>
<DIV><?php
				if($B[1] == "text" OR $B[1] == "code" OR $B[1] == "images" OR $B[1] == "flash" OR $B[1] == "media" OR $B[1] == "menu" ){
 					echo stripslashes($B[2]); 
 				}elseif($B[1] == "article"){
					echo GenArticleCodeText($B[0],$mainwidth);
				}else{ echo show_block($B[0]); } ?></DIV>
<?php } ?>
</td>

<td id="ewt_main_structure_body" width="<?php echo $F["d_site_content"]; ?>" bgcolor="<?php echo $F["d_body_bg_c"]; ?>" height="160" background="<?php echo $F["d_body_bg_p"]; ?>"><?php
			$mainwidth = $F["d_site_content"];
$sql_content = $db->query("SELECT block.BID,block.block_type,block.block_html FROM block INNER JOIN block_function ON block_function.BID = block.BID WHERE block_function.side = '5' AND block_function.filename = '".$_GET["filename"]."' ORDER BY block_function.position ASC");
while($B = $db->db_fetch_row($sql_content)){
?>
<DIV><?php
if($B[1] == "text" OR $B[1] == "code"  OR $B[1] == "images" OR $B[1] == "flash" OR $B[1] == "media" OR $B[1] == "menu" ){ echo stripslashes($B[2]); }elseif($B[1] == "article"){
					echo GenArticleCodeText($B[0],$mainwidth);
				}else{ echo show_block($B[0]); } ?></DIV>
<?php } ?></td>
<td id="ewt_main_structure_right" width="<?php echo $F["d_site_right"]; ?>" bgcolor="<?php echo $F["d_right_bg_c"]; ?>" background="<?php echo $F["d_right_bg_p"]; ?>">
<?php
			$mainwidth =  $F["d_site_right"];
$sql_right = $db->query("SELECT block.BID,block.block_type,block.block_html FROM block INNER JOIN block_function ON block_function.BID = block.BID WHERE block_function.side = '2' AND block_function.filename = '".$_GET["filename"]."' ORDER BY block_function.position ASC");

while($B = $db->db_fetch_row($sql_right)){
?>
<DIV ><?php
if($B[1] == "text" OR $B[1] == "code"  OR $B[1] == "images" OR $B[1] == "flash" OR $B[1] == "media" OR $B[1] == "menu" ){ echo stripslashes($B[2]); }elseif($B[1] == "article"){
					echo GenArticleCodeText($B[0],$mainwidth);
				}else{ echo show_block($B[0]); } ?></DIV>
<?php } ?>
</td>
</tr>
<tr valign="top" > 
<td id="ewt_main_structure_bottom" height="<?php echo $F["d_bottom_height"]; ?>" bgcolor="<?php echo $F["d_bottom_bg_c"]; ?>" background="<?php echo $F["d_bottom_bg_p"]; ?>" colspan="3" >
<?php
$mainwidth = $F["d_site_width"];
$sql_bottom = $db->query("SELECT block.BID,block.block_type,block.block_html FROM block INNER JOIN block_function ON block_function.BID = block.BID WHERE block_function.side = '4' AND block_function.filename = '".$_GET["filename"]."' ORDER BY block_function.position ASC");
while($B = $db->db_fetch_row($sql_bottom)){
?>
<DIV><?php
if($B[1] == "text" OR $B[1] == "code"  OR $B[1] == "images" OR $B[1] == "flash" OR $B[1] == "media" OR $B[1] == "menu" ){ echo stripslashes($B[2]); }elseif($B[1] == "article"){
					echo GenArticleCodeText($B[0],$mainwidth);
				}else{ echo show_block($B[0]); } ?></DIV>
<?php } ?>
</td>
</tr>
</table>
</body>
</html>
<?php
$db->db_close(); ?>
