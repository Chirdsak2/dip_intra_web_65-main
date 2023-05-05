<?php
session_start();
$filename=$_GET['filename'];
include("lib/function.php");
include("lib/user_config.php");
include("lib/connect.php");
$today=date('Y-m-d');
	if(getenv(HTTP_X_FORWARDED_FOR)){
		$ip_address = getenv(HTTP_X_FORWARDED_FOR);
	}else{
		$ip_address = getenv("REMOTE_ADDR");
	}	
$db->query("insert into search_open (filename,date_open,ip_address)  values ('$filename','$today','$ip_address') ");
echo "<script>location='main.php?filename=$filename';</script>";
?>
