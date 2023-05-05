<?php
exit;
session_start();
include("../lib/include_bizadmin.php");
include("../lib/include.php");
include("../lib/function.php");
include("../lib/ewt_config.php");
include("../lib/connect.php");
$db->query("USE ".$EWT_DB_NAME);
$sql = $db->query("SELECT DISTINCT(email_kh) FROM gen_user WHERE email_kh != ''");
while($R=$db->db_fetch_row($sql)){

$db->query("INSERT INTO position_name (pos_name) VALUES ('$R[0]')");
$pid = mysql_insert_id();
$db->query("UPDATE gen_user SET posittion = '$pid' WHERE email_kh = '$R[0]'");
}
echo "Done!";
$db->db_close();
?>
