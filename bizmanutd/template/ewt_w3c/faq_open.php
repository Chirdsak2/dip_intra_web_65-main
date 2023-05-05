<?php
session_start();
$filename=$_GET['filename'];
$path = "../";
	include($path."lib/function.php");
	include($path."lib/user_config.php");
	include($path."lib/connect.php");
$today=date('Y-m-d');
$ip_address=getenv("REMOTE_ADDR");
$db->query("insert into faq_stat (fa_id,faq_stat_date,ip_address)  values ('$fa_id','$today','$ip_address') ");
echo "<script>location='faq_detail.php?fa_id=$fa_id';</script>";
?>
