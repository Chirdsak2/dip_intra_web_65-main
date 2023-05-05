<?php
	$path = "";
	session_start();
	$start_time_counter = date("YmdHis");
	include("lib/function.php");
	include("lib/user_config.php");
	include("lib/connect.php");
	include($path."w3c_new/include/ewt_block_function.php");
	include($path."w3c_new/include/ewt_menu_preview.php");
	include($path."w3c_new/include/ewt_article_preview.php");
		if($_GET["filename"] == ''){
		$_GET["filename"] = 'index';
		}
		$sql_index = $db->query("SELECT * FROM temp_index WHERE filename = '".$_GET["filename"]."' ");
		$F = $db->db_fetch_array($sql_index);
		$use_template = $F["template_id"];
		if($use_template != ""){
		$_GET["d_id"] =$use_template;
		}else{
		$sql_index = $db->query("SELECT d_id FROM design_list WHERE d_default = 'W'  ");
		$FF = $db->db_fetch_array($sql_index);
		$d_idtemp = $FF[d_id];
		$_GET["d_id"] =$d_idtemp;
		}
	$temp = "SELECT * FROM design_list WHERE d_id = '".$_GET["d_id"]."'";
	$sql_temp= $db->query($temp);
	$RR = $db->db_fetch_array($sql_temp);

	$global_theme = $RR["d_bottom_content"];
	$mainwidth = "0";
			?>
<html>
<head>
<title>Preview</title>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<?php
include("w3c_new/ewt_script.php");	
?>

</head>
<body   <?php if($RR["d_site_bg_c"] != ""){ echo "bgcolor=\"".$RR["d_site_bg_c"]."\""; } ?> <?php if($RR["d_site_bg_p"] != ""){ echo "background=\"".$RR["d_site_bg_p"]."\""; } ?> >
<table id="ewt_main_structure" width="<?php echo $RR["d_site_width"]; ?>" border="0" cellpadding="0" cellspacing="0" align="<?php echo $RR["d_site_align"]; ?>">
        <tr  valign="top" > 
          <td id="ewt_main_structure_top" style="background:url(<?php echo $RR["d_top_bg_p"]; ?>); background-color:<?php echo $RR["d_top_bg_c"]; ?>; height:<?php echo $RR["d_top_height"]; ?>px;"  colspan="3" >
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
          <td id="ewt_main_structure_left" width="<?php echo $RR["d_site_left"]; ?>"  style="background:url(<?php echo $RR["d_left_bg_p"]; ?>); background-color:<?php echo $RR["d_left_bg_c"]; ?>">
		  <?php
			$mainwidth = $RR["d_site_left"];
			?><?php
		  $sql_left = $db->query("SELECT block.BID FROM block INNER JOIN design_block ON design_block.BID = block.BID WHERE design_block.side = '1' AND design_block.d_id = '".$_GET["d_id"]."' ORDER BY design_block.position ASC");
		  while($LB = $db->db_fetch_row($sql_left)){
		  ?>
<DIV><?php echo show_block($LB[0]); ?></DIV>
		<?php } ?>
		  </td>
          
    <td id="ewt_main_structure_body" width="<?php echo $RR["d_site_content"]; ?>" style="background:url(<?php echo $RR["d_body_bg_p"]; ?>); background-color:<?php echo $RR["d_body_bg_c"]; ?>; height:160px">
	<?php
			$mainwidth = $RR["d_site_content"];
			?><?php
		  $sql_content = $db->query("SELECT block.BID FROM block INNER JOIN design_block ON design_block.BID = block.BID WHERE design_block.side = '5' AND design_block.d_id = '".$_GET["d_id"]."' ORDER BY design_block.position ASC");
		  while($CB = $db->db_fetch_row($sql_content)){
		  ?>
<DIV ><?php echo show_block($CB[0]); ?></DIV>
		<?php } ?>
	</td>
          <td id="ewt_main_structure_right" width="<?php echo $RR["d_site_right"]; ?>" style="background:url(<?php echo $RR["d_right_bg_p"]; ?>); background-color:<?php echo $RR["d_right_bg_c"]; ?>;" >
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
          <td id="ewt_main_structure_bottom"  style="background:url(<?php echo $RR["d_bottom_bg_p"]; ?>); background-color:<?php echo $RR["d_bottom_bg_c"]; ?>; height:<?php echo $RR["d_bottom_height"]; ?>px;" colspan="3">
		  <?php
			$mainwidth = $RR["d_site_width"];
			?><?php
		  $sql_bottom = $db->query("SELECT block.BID FROM block INNER JOIN design_block ON design_block.BID = block.BID WHERE design_block.side = '4' AND design_block.d_id = '".$_GET["d_id"]."' ORDER BY design_block.position ASC");
		  while($BB = $db->db_fetch_row($sql_bottom)){
		  ?>
<DIV><?php echo show_block($BB[0]); ?></DIV>
		<?php } ?></td>
        </tr>
      </table>
</body>
</html>
<?php $db->db_close(); ?>
