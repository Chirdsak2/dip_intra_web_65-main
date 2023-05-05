<?php
include("../../lib/permission2.php");
include("../../lib/include.php");
include("../../lib/function.php");
include("../../lib/user_config.php");
$template = $_GET["template"];
$field_site = explode("#zz#",base64_decode ($template));
$EWT_FOLDER_USER = $field_site[1];
$EWT_DB_NAME = $field_site[0];
include("../../lib/connect.php");
include("../../ewt_block_function.php");
include("../../ewt_menu_preview.php");
include("../../ewt_article_preview.php");

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
include("ewt_script.php");	
?>
</head>
<body  leftmargin="0" topmargin="0" <?php if($RR["d_site_bg_c"] != ""){ echo "bgcolor=\"".$RR["d_site_bg_c"]."\""; } ?> <?php if($RR["d_site_bg_p"] != ""){ echo "background=\"".$RR["d_site_bg_p"]."\""; } ?> >
<table id="ewt_main_structure" width="<?php echo $RR["d_site_width"]; ?>" border="0" cellpadding="0" cellspacing="0" align="<?php echo $RR["d_site_align"]; ?>">
        <tr  valign="top" > 
          <td id="ewt_main_structure_top" height="<?php echo $RR["d_top_height"]; ?>" bgcolor="<?php echo $RR["d_top_bg_c"]; ?>" background="<?php echo $RR["d_top_bg_p"]; ?>" colspan="3" >
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
          <td id="ewt_main_structure_left" width="<?php echo $RR["d_site_left"]; ?>" bgcolor="<?php echo $RR["d_left_bg_c"]; ?>" background="<?php echo $RR["d_left_bg_p"]; ?>">
		  <?php
			$mainwidth = $RR["d_site_left"];
			?><?php
		  $sql_left = $db->query("SELECT block.BID FROM block INNER JOIN design_block ON design_block.BID = block.BID WHERE design_block.side = '1' AND design_block.d_id = '".$_GET["d_id"]."' ORDER BY design_block.position ASC");
		  while($LB = $db->db_fetch_row($sql_left)){
		  ?>
<DIV><?php echo show_block($LB[0]); ?></DIV>
		<?php } ?>
		  </td>
          
    <td id="ewt_main_structure_body" width="<?php echo $RR["d_site_content"]; ?>" bgcolor="<?php echo $RR["d_body_bg_c"]; ?>" height="160" background="<?php echo $RR["d_body_bg_p"]; ?>">
	<?php
			$mainwidth = $RR["d_site_content"];
			?><?php
		  $sql_content = $db->query("SELECT block.BID FROM block INNER JOIN design_block ON design_block.BID = block.BID WHERE design_block.side = '5' AND design_block.d_id = '".$_GET["d_id"]."' ORDER BY design_block.position ASC");
		  while($CB = $db->db_fetch_row($sql_content)){
		  ?>
<DIV ><?php echo show_block($CB[0]); ?></DIV>
		<?php } ?>
	</td>
          <td id="ewt_main_structure_right" width="<?php echo $RR["d_site_right"]; ?>" bgcolor="<?php echo $RR["d_right_bg_c"]; ?>" background="<?php echo $RR["d_right_bg_p"]; ?>">
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
          <td id="ewt_main_structure_bottom" height="<?php echo $RR["d_bottom_height"]; ?>" bgcolor="<?php echo $RR["d_bottom_bg_c"]; ?>" colspan="3" background="<?php echo $RR["d_bottom_bg_p"]; ?>">
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
