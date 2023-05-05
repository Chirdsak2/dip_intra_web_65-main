<?php
session_start();
include("lib/function.php");
include("lib/user_config.php");
include("lib/connect.php");

	print "<script>";
	//print "location.href = 'gallery_view_img_comment.php?category_id=".$_GET[category_id]."&img_id=".$_GET[img_id]."&filename=".$_GET[filename]."&page_cat=".$_GET[page_cat]."'; ";
	print "history.go(-2)";
	//print "history.go(1)";
	print "</script>";
$db->db_close(); 
?>
