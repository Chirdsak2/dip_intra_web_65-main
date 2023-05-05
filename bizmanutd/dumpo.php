<?php
session_start();
include("../lib/include_bizadmin.php");
include("../lib/include.php");
include("../lib/function.php");
include("../lib/ewt_config.php");

include("../lib/connect.php");

$db->query("USE ".$EWT_DB_NAME);

 exit;
$sql = $db->query("SELECT * FROM org_tmp ");
while($R=$db->db_fetch_array($sql)){
$db->query("UPDATE `gen_user2` SET `did` = '$R[id]' WHERE `div` = '$R[div]' AND `dep` = '$R[dep]' ");
}
echo "Done!";
$db->db_close();
?>
