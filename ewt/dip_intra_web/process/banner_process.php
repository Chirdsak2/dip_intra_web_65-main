<?php 
//session_start();
header('Content-type: application/json; charset=utf-8');

include("../lib/function.php");
include("../lib/user_config.php");
include("../lib/connect.php");
//include("check_cookie.php");

$flag = $_POST["flag"];

if($_SERVER["REMOTE_ADDR"]){
	$ip_view = $_SERVER["REMOTE_ADDR"];
}else{
	$ip_view = $_SERVER["REMOTE_HOST"];
}

if($flag=="banner_click"){
	$bannerid = trim($_POST['bannerid']);
	$bannerid = ready(filter_number($bannerid));

	//if(!isset($_SESSION["banner_log".$bannerid.'_'.$ip_view])){

		## >> Check if banner exists
		$check_banner = $db->query("SELECT banner_id FROM banner WHERE banner_id = '$bannerid'");

		if($db->db_num_rows($check_banner)>0){
				
			//$_SESSION["banner_log".$bannerid.'_'.$ip_view] = "Y";
			$ip_view = ready($ip_view);

			$db->query("INSERT INTO banner_log (`banner_id`,`ip`,`date`,`time`) 
						VALUE ('$bannerid','$ip_view',NOW(),NOW())");
		}
	//}
}
?>