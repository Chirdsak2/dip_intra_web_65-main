<?php
session_start();
include("lib/function.php");
include("lib/user_config.php");
include("lib/connect.php");

	//=======================================================
	if($banner_id){
		$banner_id = checkNumeric($banner_id);
	}
	if($_GET["banner_id"]){
		$_GET["banner_id"] = checkNumeric($_GET["banner_id"]);
	}
	if($_POST["banner_id"]){
		$_POST["banner_id"] = checkNumeric($_POST["banner_id"]);
	}
	//=======================================================

if($_SESSION['UNIQUE_BANNER'][$_GET['banner_id']]=='') {
	$sql_insert = "INSERT INTO banner_log (banner_id,ip,date,time) VALUES ('".$_GET['banner_id']."','".$_SERVER['REMOTE_ADDR']."',NOW(),NOW())";
	$db->query($sql_insert);
	$_SESSION['UNIQUE_BANNER'][$_GET['banner_id']]='1';
}
$db->db_close();
?>
