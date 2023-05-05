<?php
session_start();
include("lib/function.php");
include("lib/user_config.php");
include("lib/connect.php");

if($_GET["mid"] == "menu"){
$sql_art = $db->query("SELECT n_id,source FROM article_list WHERE source != '' ");
	while($N = $db->db_fetch_row($sql_art)){
		$link = "main.php?filename=".$N[1];
		$nlink = "ewt_news.php?nid=".$N[0];
		$db->query("UPDATE menu_properties SET Glink = '$nlink' WHERE Glink = '$link' ");

	}
}
echo "Level 3 => Finish.";
$db->db_close();
?>
