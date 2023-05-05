<?php
session_start();
$filename=$_GET['filename'];
$path = "../";
	include($path."lib/function.php");
	include($path."lib/user_config.php");
	include($path."lib/connect.php");
$today=date('Y-m-d');
	if(getenv(HTTP_X_FORWARDED_FOR)){
		$ip_address = getenv(HTTP_X_FORWARDED_FOR);
	}else{
		$ip_address = getenv("REMOTE_ADDR");
	}	
$db->query("insert into search_open (filename,date_open,ip_address)  values ('$filename','$today','$ip_address') ");
echo "<script>location='main.php?filename=$filename';</script>";
?>
