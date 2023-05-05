<?php
	session_start();
	include("lib/function.php");
	include("lib/user_config.php");
	include("lib/connect.php");
	include("../../ewt_block_function.php");
	include("../../ewt_menu_preview.php");
	include("../../ewt_article_preview.php");
	
		$sql_index = $db->query("SELECT * FROM temp_index WHERE filename = '".$_GET["filename"]."' ");
		$F = $db->db_fetch_array($sql_index);
$mainwidth = $F["d_site_content"];
$sql_content = $db->query("SELECT block.BID,block.block_type,block.block_html FROM block INNER JOIN block_function ON block_function.BID = block.BID WHERE block_function.side = '5' AND block_function.filename = '".$_GET["filename"]."' ORDER BY block_function.position ASC");

while($B = $db->db_fetch_row($sql_content)){
?>
<DIV><?php
if($B[1] == "text" OR $B[1] == "code"  OR $B[1] == "images" OR $B[1] == "flash" OR $B[1] == "media" OR $B[1] == "menu" ){ echo stripslashes($B[2]); }else{ echo show_block($B[0]); } ?></DIV>
<?php } 
$db->db_close(); ?>
