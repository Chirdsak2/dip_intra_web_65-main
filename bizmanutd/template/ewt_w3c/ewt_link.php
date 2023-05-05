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
	include("ewt_template.php");
	$db->access=200;
?>
<?php echo $template_design[0];?>
	<?php
			$mainwidth = $F["d_site_content"];
			?>
	
	 <?php
		  $sql_g = $db->query("SELECT * FROM link_group WHERE glink_id = '$glink_id' ");
					$G = $db->db_fetch_array($sql_g);	
		  ?>
		  
		  
<?
	
$sql = $db->query("select * from block where BID = '".$_GET[BID]."' ");
$rec = $db->db_fetch_array($sql);
$s_id=$rec[block_link];
			if($rec[block_themes] !=0){
				$themes = $rec[block_themes];
			}else{
				$themes = $global_theme;
			}
if($themes != '0'  && $themes  != ''){
		$namefolder = "themes".($themes  );
		//@include("themesdesign/configthemes.php");
		@include("../themesdesign/".$namefolder."/".$namefolder.".php");
		 if($themes_type == 'F'){
				$buffer = "";
				$fd = @fopen ($Current_Dir1.$themes_file, "r");
				 while (!@feof ($fd)) {
					$buffer .= @fgets($fd, 4096);
				 }
				@fclose ($fd);
				$exp = "<"."?#htmlshow#?".">";
				$design = explode($exp,$buffer);
		 }
		
}else{
	$head_font_color='#666666';
	$bg_color='#6A2B00';
	$Current_Dir1='mainpic/';
	$bg_img='';
	$head_img='toolbars.gif';
	$head_height=30;
	$body_color='#FFFFFF';
	$body_font_color='#000099';
}
?>
	<h1><? echo $G[glink_name]; ?></h1>
            <hr size="1">
    <ul>
		<?php  
		$sql_l = $db->query("SELECT * FROM link_list WHERE glink_id = '$glink_id' ORDER BY link_id ASC");
		while($rec = $db->db_fetch_array($sql_l)){
?>
    <li> <a href="<?=$rec['link_url'] ?>" target="<?=$rec['link_target'] ?>" accesskey=<?php echo $db->genaccesskey();?>><?=$rec[link_name]?> </a><?php if($rec[link_detail] != ""){ echo ":".$rec[link_detail];}?></li>
		<?php } ?>
	
	</ul>
	
<?php include("include_logo_w3c_template.php");?>
<?php $db->db_close(); ?>