<?php
$path = "../";
	session_start();
	include($path."lib/function.php");
	include($path."lib/user_config.php");
	include($path."lib/connect.php");

$sql_insert = "INSERT INTO banner_log (banner_id,ip,date,time) VALUES ('".$_GET[banner_id]."','".$_SERVER['REMOTE_ADDR']."',NOW(),NOW())";
$db->query($sql_insert);

$db->db_close();
?>
