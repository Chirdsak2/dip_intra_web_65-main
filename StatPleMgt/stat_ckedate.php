<?php
	session_start();
	include("../lib/include.php");
	include("../lib/function.php");
	include("../lib/user_config.php");
	include("../lib/connect.php");
	$db->query("USE ".$_SESSION["EWT_SDB"]);
	
	//$date_s = explode('/',$_GET['date']);
	//$start_date = ($date_s[2]-543).'-'.$date_s[1].'-'.$date_s[0];
	$start_date = $_GET['dates'];
	$wh = "";
	if($_GET['pid']!=""){
		$wh = " and p_id != '".$_GET['pid']."'";
	}
	
	$sql ="SELECT * FROM stat_population WHERE p_date = '".$start_date."'".$wh;
	$query_user = $db->query($sql); 
	$num_user = $db->db_num_rows($query_user);	
	if($num_user >0){
		echo "aa";
	}
	
?>