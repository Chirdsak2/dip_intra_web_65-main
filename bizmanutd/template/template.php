<?php
session_start();
include("lib/function.php");
include("lib/user_config.php");
include("lib/connect.php");
include("../../ewt_block_function.php");
include("../../ewt_menu_preview.php");
include("../../ewt_article_preview.php");
$filename_temp = "research_flame";

$sql_index = $db->query("SELECT * FROM temp_index WHERE filename = '".$filename_temp."'  ");
$F = $db->db_fetch_array($sql_index);
	?>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<script type="text/javascript" language="JavaScript1.2" src="js/stm31.js"></script>
<title>Template</title></head>
<body  leftmargin="0" topmargin="0" <?php if($F["d_site_bg_c"] != ""){ echo "bgcolor=\"".$F["d_site_bg_c"]."\""; } ?> <?php if($F["d_site_bg_p"] != ""){ echo "background=\"".$F["d_site_bg_p"]."\""; } ?> >
<table width="<?php echo $F["d_site_width"]; ?>" border="0" cellpadding="0" cellspacing="0" align="<?php echo $F["d_site_align"]; ?>">
        <tr  valign="top" > 
          <td height="<?php echo $F["d_top_height"]; ?>" bgcolor="<?php echo $F["d_top_bg_c"]; ?>" background="<?php echo $F["d_top_bg_p"]; ?>" colspan="3" >
		  <?php
		  $sql_top = $db->query("SELECT block.BID,block.block_type,block.block_html FROM block INNER JOIN block_function ON block_function.BID = block.BID WHERE block_function.side = '3' AND block_function.filename = '".$filename_temp."' ORDER BY block_function.position ASC");
		  while($B = $db->db_fetch_row($sql_top)){
		  ?>
<DIV ><?php if($B[1] == "text" OR $B[1] == "code" OR $B[1] == "graph" OR $B[1] == "images" OR $B[1] == "flash" OR $B[1] == "media" OR $B[1] == "menu"){ echo stripslashes($B[2]); }else{ echo show_block($B[0]); } ?></DIV>
		<?php } ?>
		  </td>
        </tr>
        <tr valign="top" > 
          <td width="<?php echo $F["d_site_left"]; ?>" bgcolor="<?php echo $F["d_left_bg_c"]; ?>" background="<?php echo $F["d_left_bg_p"]; ?>">
		  <?php
		  $sql_left = $db->query("SELECT block.BID,block.block_type,block.block_html FROM block INNER JOIN block_function ON block_function.BID = block.BID WHERE block_function.side = '1' AND block_function.filename = '".$filename_temp."' ORDER BY block_function.position ASC");
		  while($B = $db->db_fetch_row($sql_left)){
		  ?>
<DIV><?php if($B[1] == "text" OR $B[1] == "code" OR $B[1] == "graph" OR $B[1] == "images" OR $B[1] == "flash" OR $B[1] == "media" OR $B[1] == "menu"){ echo stripslashes($B[2]); }else{ echo show_block($B[0]); } ?></DIV>
		<?php } ?>
		  </td>
          
    <td width="<?php echo $F["d_site_content"]; ?>" bgcolor="<?php echo $F["d_body_bg_c"]; ?>" height="160" background="<?php echo $F["d_body_bg_p"]; ?>"> 
     <table width="100%" border="0" cellpadding="4" cellspacing="0" >
        <tr> 
          <td height="10">sssss</td>
        </tr>
      </table>
</td>
          <td width="<?php echo $F["d_site_right"]; ?>" bgcolor="<?php echo $F["d_right_bg_c"]; ?>" background="<?php echo $F["d_right_bg_p"]; ?>">
		  <?php
	      $db->query("USE ".$EWT_DB_NAME);
		  $sql_right = $db->query("SELECT block.BID,block.block_type,block.block_html FROM block INNER JOIN block_function ON block_function.BID = block.BID WHERE block_function.side = '2' AND block_function.filename = '".$filename_temp."' ORDER BY block_function.position ASC");
		  while($B = $db->db_fetch_row($sql_right)){
		  ?>
<DIV ><?php if($B[1] == "text" OR $B[1] == "code" OR $B[1] == "graph" OR $B[1] == "images" OR $B[1] == "flash" OR $B[1] == "media" OR $B[1] == "menu"){ echo stripslashes($B[2]); }else{ echo show_block($B[0]); } ?></DIV>
		<?php } ?>
		  </td>
        </tr>
        <tr valign="top" > 
          <td height="<?php echo $F["d_bottom_height"]; ?>" bgcolor="<?php echo $F["d_bottom_bg_c"]; ?>" background="<?php echo $F["d_bottom_bg_p"]; ?>" colspan="3" >
		  <?php
		  $sql_bottom = $db->query("SELECT block.BID,block.block_type,block.block_html FROM block INNER JOIN block_function ON block_function.BID = block.BID WHERE block_function.side = '4' AND block_function.filename = '".$filename_temp."' ORDER BY block_function.position ASC");
		  while($B = $db->db_fetch_row($sql_bottom)){
		  ?>
<DIV><?php if($B[1] == "text" OR $B[1] == "code" OR $B[1] == "graph" OR $B[1] == "images" OR $B[1] == "flash" OR $B[1] == "media" OR $B[1] == "menu"){ echo stripslashes($B[2]); }else{ echo show_block($B[0]); } ?></DIV>
		<?php } ?>
</td>
        </tr>
      </table>
</body>
</html>
<?php $db->db_close(); ?>
