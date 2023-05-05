<?php 
//session_start();
header('Content-type: application/json; charset=utf-8');

include("../lib/function.php");
include("../lib/user_config.php");
include("../lib/connect.php");

$flag  = $_POST["flag"];
$mp_id = ready($_POST["mp_id"]);

if($flag=="load_menupopup"){
	$menu_data = $db->query("SELECT * FROM menu_properties WHERE mp_id = '$mp_id' AND mp_show = 'Y'");
	$menu_info = $db->db_fetch_array($menu_data);
	//echo $menu_info["popup_info"];
	return_data("success",array("target"=>$menu_info["Gtarget"],
								"popup_info"=>$menu_info["popup_info"],
							    "glink"=>$menu_info["Glink"]));
}

?>