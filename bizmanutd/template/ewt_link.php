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
if($_GET["filename"] != ""){
$sql_index = $db->query("SELECT template_id,filename FROM temp_index WHERE filename = '".$_GET["filename"]."' ");
$F = $db->db_fetch_array($sql_index);
$d_idtemp = $F["template_id"];
}else{
$sql_index = $db->query("SELECT d_id FROM design_list WHERE d_default = 'Y'  ");
$FF = $db->db_fetch_array($sql_index);
$d_idtemp = $FF[d_id];
}
$lang_sh = explode('___',$F[filename]);
if($lang_sh[1] != ''){$lang_sh = '_'.$lang_sh[1];}else{$lang_sh ='';}
include("language/language".$lang_sh.".php");
$temp = "SELECT * FROM design_list WHERE d_id = '".$d_idtemp."'";
$sql_temp= $db->query($temp);
$F = $db->db_fetch_array($sql_temp);
$design_id = $F["d_id"];
$global_theme = $F["d_bottom_content"];
$mainwidth = "0";

	?>
<html>
<head>
<title>Link...</title>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<?php
include("ewt_script.php");	
?>
</head>
<body  leftmargin="0" topmargin="0" <?php if($F["d_site_bg_c"] != ""){ echo "bgcolor=\"".$F["d_site_bg_c"]."\""; } ?> <?php if($F["d_site_bg_p"] != ""){ echo "background=\"".$F["d_site_bg_p"]."\""; } ?> >
<table width="<?php echo $F["d_site_width"]; ?>" border="0" cellpadding="0" cellspacing="0" align="<?php echo $F["d_site_align"]; ?>">
        <tr  valign="top" > 
          <td height="<?php echo $F["d_top_height"]; ?>" bgcolor="<?php echo $F["d_top_bg_c"]; ?>" background="<?php echo $F["d_top_bg_p"]; ?>" colspan="3" >
		  		 <?php
			$mainwidth = $F["d_site_width"];
			?> <?php
		  $sql_left = $db->query("SELECT block.BID FROM block INNER JOIN design_block ON design_block.BID = block.BID WHERE design_block.side = '3' AND design_block.d_id = '".$design_id ."' ORDER BY design_block.position ASC");
		  while($LB = $db->db_fetch_row($sql_left)){
		  ?>
<DIV><?php echo show_block($LB[0]); ?></DIV>
		<?php } ?>
		  </td>
        </tr>
        <tr valign="top" > 
          <td width="<?php echo $F["d_site_left"]; ?>" bgcolor="<?php echo $F["d_left_bg_c"]; ?>" background="<?php echo $F["d_left_bg_p"]; ?>">
		  		<?php
			$mainwidth = $F["d_site_left"];
			?>  <?php
		  $sql_left = $db->query("SELECT block.BID FROM block INNER JOIN design_block ON design_block.BID = block.BID WHERE design_block.side = '1' AND design_block.d_id = '".$design_id ."' ORDER BY design_block.position ASC");
		  while($LB = $db->db_fetch_row($sql_left)){
		  ?>
<DIV><?php echo show_block($LB[0]); ?></DIV>
		<?php } ?>
		  </td>
          
    <td width="<?php echo $F["d_site_content"]; ?>" bgcolor="<?php echo $F["d_body_bg_c"]; ?>" height="160" background="<?php echo $F["d_body_bg_p"]; ?>">
      		 	<?php
			$mainwidth = $F["d_site_content"];
			?> <?php
		  $sql_left = $db->query("SELECT block.BID FROM block INNER JOIN design_block ON design_block.BID = block.BID WHERE design_block.side = '5' AND design_block.d_id = '".$design_id ."' ORDER BY design_block.position ASC");
		  while($LB = $db->db_fetch_row($sql_left)){
		  ?>
<DIV><?php echo show_block($LB[0]); ?></DIV>
		<?php } ?>
	  <?php
		  $sql_g = $db->query("SELECT * FROM link_group WHERE glink_id = '$glink_id' ");
					$G = $db->db_fetch_array($sql_g);	
		  ?>
		  
		  
<?php
	
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
		@include("themesdesign/".$namefolder."/".$namefolder.".php");
		 //if($themes_type == 'F'){
				$buffer = "";
			if(file_exists($Current_Dir1.$themes_file) && $themes_file!=''){ //block_themes
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
		  
	  <?php echo $design[0]; ?>
      <table width="<?php echo $bg_width;?>" align="center" cellpadding="3" cellspacing="1"  bgcolor="<?php echo $bg_color;?>" background="<?php echo $Current_Dir1.$bg_img;?>">
        <tr>
          <td><font color="<?php echo $head_font_color;?>"  face="<?php echo $head_font_face;?>"><span style="font-size: <?php echo $head_font_size;?>"><strong><?php echo $G[glink_name]; ?></strong></span></font>
            <hr size="1">
          </td>
        </tr>
		<?php  
		$sql_l = $db->query("SELECT * FROM link_list WHERE glink_id = '$glink_id' ORDER BY link_id ASC");
		while($rec = $db->db_fetch_array($sql_l)){
?>
        <tr>
          <td bgcolor="<?php echo $body_color;?>" background="<?php echo $Current_Dir1.$body_bg_img;?>"><li><a href="<?php echo $rec['link_url'] ?>" target="<?php echo $rec['link_target'] ?>"><b>
                          <font color="<?php echo $body_font_color;?>"  face="<?php echo $body_font_face;?>" ><span style="font-size: <?php echo $body_font_size;?>"><?php echo $rec[link_name]?></span></font>
                          </b> </a><br>
                          <font color="<?php echo $body_font_color2;?>"  face="<?php echo $body_font_face2;?>" ><span style="font-size: <?php echo $body_font_size2;?>"><?php echo $rec[link_detail]?></span></font></li></td>
        </tr>
		<?php } ?>
      </table>
	  <?php echo $design[1]; ?>
      </td>
          <td width="<?php echo $F["d_site_right"]; ?>" bgcolor="<?php echo $F["d_right_bg_c"]; ?>" background="<?php echo $F["d_right_bg_p"]; ?>">
		  		 <?php
			$mainwidth = $F["d_site_right"];
			?> <?php
		  $sql_left = $db->query("SELECT block.BID FROM block INNER JOIN design_block ON design_block.BID = block.BID WHERE design_block.side = '2' AND design_block.d_id = '".$design_id ."' ORDER BY design_block.position ASC");
		  while($LB = $db->db_fetch_row($sql_left)){
		  ?>
<DIV><?php echo show_block($LB[0]); ?></DIV>
		<?php } ?>
		  </td>
        </tr>
        <tr valign="top" > 
          <td height="<?php echo $F["d_bottom_height"]; ?>" bgcolor="<?php echo $F["d_bottom_bg_c"]; ?>" background="<?php echo $F["d_bottom_bg_p"]; ?>" colspan="3" >
		  		    <?php
			$mainwidth = $F["d_site_width"];
			?> <?php
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
<?php $db->db_close(); ?>
