<?php 
//session_start();
//header('Content-type: application/json; charset=utf-8');

include("../lib/function.php");
include("../lib/user_config.php");
include("../lib/connect.php");

$flag     = $_POST["flag"];

if($flag=="update_view_ebook"){
	$ebook_id = ready($_POST["ebook_id"]);

    $db->query("UPDATE ebook_info 
				SET ebook_count = ebook_count+1 
				WHERE ebook_id = '$ebook_id'");
}
?>