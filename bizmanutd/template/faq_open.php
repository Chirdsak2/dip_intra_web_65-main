<?php
session_start();
$filename=$HTTP_GET_VARS['filename'];
include("lib/function.php");
include("lib/user_config.php");
include("lib/connect.php");
$today=date('Y-m-d');
$ip_address=getenv("REMOTE_ADDR");
$db->query("insert into faq_stat (fa_id,faq_stat_date,ip_address)  values ('$fa_id','$today','$ip_address') ");
echo "<script>location='faq_detail.php?fa_id=$_GET[fa_id]';</script>";
?>
