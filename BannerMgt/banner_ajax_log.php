<?php
session_start();
include("../lib/permission1.php");
include("../lib/include.php");
include("../lib/function.php");
include("../lib/user_config.php");
include("../lib/connect.php");

$sql_insert = "INSERT INTO banner_log (banner_id,ip,date,time) VALUES ('".$_GET[banner_id]."','".$_SERVER['REMOTE_ADDR']."',NOW(),NOW())";
$db->query($sql_insert);

$db->db_close();
?>
