<?php
session_start();
include("../lib/permission1.php");
include("../lib/include.php");
include("../lib/function.php");
include("../lib/user_config.php");
include("../lib/connect.php");
$today=date('Y-m-d');
$ip_address=getenv("REMOTE_ADDR");
$db->query("insert into search_open (filename,date_open,ip_address)  values ('$filename','$today','$ip_address') ");
echo "<script>location='../ewt/thailand/main.php?filename=$filename';</script>";
?>
