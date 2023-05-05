<?php
	$path = "";
	session_start();
	$start_time_counter = date("YmdHis");
	include("../lib/function.php");
	include("../lib/user_config.php");
	include("../lib/connect.php");
	include($path."include/ewt_block_function.php");
	include($path."include/ewt_menu_preview.php");
	include($path."include/ewt_article_preview.php");
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
		$ewt_mykeyword = addslashes($F["cms_keyword"]);
	}else{
		$ewt_mykeyword = addslashes($SF["site_info_keyword"]);
	}
	if($F["cms_description"] != ""){
		$ewt_mydescription = addslashes($F["cms_description"]);
	}else{
		$ewt_mydescription = addslashes($SF["site_info_description"]);
	}
	$ewt_mykeyword = eregi_replace(chr(13)," ",$ewt_mykeyword);
	$ewt_mykeyword = eregi_replace("  "," ",$ewt_mykeyword);
	$ewt_mydescription = eregi_replace(chr(13)," ",$ewt_mydescription);
	$ewt_mydescription = eregi_replace("  "," ",$ewt_mydescription);
		if($_GET["filename"] == '' && $_GET["d_id"] == ''){
		$_GET["filename"] = 'index';
		}
			$lang_sh = explode('___',$_GET["filename"]);
		if($lang_sh[1] != ''){$lang_sh = '_'.$lang_sh[1];}else{$lang_sh ='';}
		$sql_index = $db->query("SELECT * FROM design_list WHERE d_name = '".$_GET["filename"]."' ");
		$F = $db->db_fetch_array($sql_index);
		$use_template = $F["d_id"];
		if($use_template != "" && $_GET["d_id"] == ''){
		$_GET["d_id"] =$use_template;
		}else{
			if($_GET["d_id"] == ''){
			$sql_index = $db->query("SELECT d_id FROM design_list WHERE d_default = 'W'  ");
			$FF = $db->db_fetch_array($sql_index);
			$d_idtemp = $FF[d_id];
			$_GET["d_id"] =$d_idtemp;
			}else{
			$_GET["d_id"] =$_GET["d_id"];
			}
		}
	$temp = "SELECT * FROM design_list WHERE d_id = '".$_GET["d_id"]."'";
	$sql_temp= $db->query($temp);
	$RR = $db->db_fetch_array($sql_temp);

	$global_theme = $RR["d_bottom_content"];
	$mainwidth = "0";
			?>
<html lang="th">
<HEAD>
<title><?php echo $ewt_mytitle; ?></title>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<meta name="Keywords" content="<?php echo $ewt_mykeyword; ?>" >
<meta name="Description" content="<?php echo $ewt_mydescription; ?>">

<?php
include("ewt_script.php");	
?>

</HEAD><body   <?php if($RR["d_site_bg_c"] != ""){ echo "bgcolor=\"".$RR["d_site_bg_c"]."\""; } ?> <?php if($RR["d_site_bg_p"] != ""){ echo "background=\"".$RR["d_site_bg_p"]."\""; } ?> >
<table id="ewt_main_structure" <?php if($RR["d_site_width"] != ''){?>width="<?php echo $RR["d_site_width"]; ?>"<?php } ?> border="0" cellpadding="0" cellspacing="0"  <?php if($RR["d_site_align"] != ''){ ?>align="<?php echo $RR["d_site_align"]; ?>"<?php }?> >
        <tr  valign="top" > 
          <td id="ewt_main_structure_top" <?php if($RR["d_top_bg_p"] != '' || $RR["d_top_bg_c"] != '' || $RR["d_top_height"] != ''){ ?>style=" <?php if($RR["d_top_bg_p"] != ''){ ?>background:url(<?php echo $RR["d_top_bg_p"]; ?>);<?php } ?> <?php if($RR["d_top_bg_c"] != ''){ ?>background-color:<?php echo $RR["d_top_bg_c"]; ?>; <?php } ?> <?php if($RR["d_top_height"] != ''){ ?>height:<?php echo $RR["d_top_height"]; ?>px;<?php } ?> " <?php } ?> colspan="3" >
		  <?php
			$mainwidth = $RR["d_site_width"];
			?><?php
		  $sql_top = $db->query("SELECT block.BID FROM block INNER JOIN design_block ON design_block.BID = block.BID WHERE design_block.side = '3' AND design_block.d_id = '".$_GET["d_id"]."' ORDER BY design_block.position ASC");
		  while($TB = $db->db_fetch_row($sql_top)){
		  ?>
<DIV ><?php echo show_block($TB[0]); ?></DIV>
		<?php } ?>
		  </td>
        </tr>
        <tr valign="top" > 
          <td id="ewt_main_structure_left"  <?php if($RR["d_site_left"] != ''){ ?>width="<?php echo $RR["d_site_left"]; ?>" <?php }?> <?php if($RR["d_left_bg_p"] != '' || $RR["d_left_bg_c"] != ''){?> style=" <?php if($RR["d_left_bg_p"] != ''){ ?>background:url(<?php echo $RR["d_left_bg_p"]; ?>);<?php } ?><?php if($RR["d_left_bg_c"] != ''){?> background-color:<?php echo $RR["d_left_bg_c"]; ?><?php } ?>" <?php } ?>>
		  <?php
			$mainwidth = $RR["d_site_left"];
			?><?php
		  $sql_left = $db->query("SELECT block.BID FROM block INNER JOIN design_block ON design_block.BID = block.BID WHERE design_block.side = '1' AND design_block.d_id = '".$_GET["d_id"]."' ORDER BY design_block.position ASC");
		  while($LB = $db->db_fetch_row($sql_left)){
		  ?>
<DIV><?php echo show_block($LB[0]); ?></DIV>
		<?php } ?>
		  </td>
          
    <td id="ewt_main_structure_body" <?php if($RR["d_site_content"] != ''){ ?> width="<?php echo $RR["d_site_content"]; ?>" <?php } ?> style=" <?php if($RR["d_body_bg_p"] != ''){?>background:url(<?php echo $RR["d_body_bg_p"]; ?>);<?php } ?><?php if($RR["d_body_bg_c"] != ''){?> background-color:<?php echo $RR["d_body_bg_c"]; ?>;<?php }?> height:160px;"><?#w3c_spliter#?>
	<?php
			$mainwidth = $RR["d_site_content"];
			?><?php
		  $sql_content = $db->query("SELECT block.BID FROM block INNER JOIN design_block ON design_block.BID = block.BID WHERE design_block.side = '5' AND design_block.d_id = '".$_GET["d_id"]."' ORDER BY design_block.position ASC");
		  while($CB = $db->db_fetch_row($sql_content)){
		  ?>
<DIV ><?php echo show_block($CB[0]); ?></DIV>
		<?php } ?>
        
	</td>
          <td id="ewt_main_structure_right"  <?php if($RR["d_site_right"] != ''){ ?>width="<?php echo $RR["d_site_right"]; ?>"<?php } ?><?php if($RR["d_right_bg_p"] != '' || $RR["d_right_bg_c"] != ''){ ?>style="<?php if($RR["d_right_bg_p"] != ''){ ?>background:url(<?php echo $RR["d_right_bg_p"]; ?>);<?php } ?><?php if($RR["d_right_bg_c"] != ''){ ?> background-color:<?php echo $RR["d_right_bg_c"]; ?>;<?php } ?>" <?php } ?> >
		  <?php
			$mainwidth = $RR["d_site_right"];
			?><?php
		  $sql_right = $db->query("SELECT block.BID FROM block INNER JOIN design_block ON design_block.BID = block.BID WHERE design_block.side = '2' AND design_block.d_id = '".$_GET["d_id"]."' ORDER BY design_block.position ASC");
		  while($RRB = $db->db_fetch_row($sql_right)){
		  ?>
<DIV ><?php echo show_block($RRB[0]); ?></DIV>
		<?php } ?>
		  </td>
        </tr>
        <tr valign="top" > 
          <td id="ewt_main_structure_bottom"  <?php if($RR["d_bottom_bg_p"] != '' || $RR["d_bottom_bg_c"] != '' || $RR["d_bottom_height"] != ''){?>style=" <?php if($RR["d_bottom_bg_p"] != ''){ ?>background:url(<?php echo $RR["d_bottom_bg_p"]; ?>);<?php } ?><?php if($RR["d_bottom_bg_c"] != ''){?> background-color:<?php echo $RR["d_bottom_bg_c"]; ?>;<?php } ?><?php if($RR["d_bottom_height"] != ''){?> height:<?php echo $RR["d_bottom_height"]; ?>px;<?php } ?>" <?php }?> colspan="3">
		  <?php
			$mainwidth = $RR["d_site_width"];
			?><?php
		  $sql_bottom = $db->query("SELECT block.BID FROM block INNER JOIN design_block ON design_block.BID = block.BID WHERE design_block.side = '4' AND design_block.d_id = '".$_GET["d_id"]."' ORDER BY design_block.position ASC");
		  while($BB = $db->db_fetch_row($sql_bottom)){
		  ?>
<DIV><?php echo show_block($BB[0]); ?></DIV>
		<?php } ?></td>
        </tr>
		<tr><td colspan="3" align="center"><?php  include("ewt_span.php");?></td></tr></table></body>
</html>
<?php $db->db_close(); ?>
