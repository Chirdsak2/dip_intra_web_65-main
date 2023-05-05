<?php
session_start();
include("../lib/include_bizadmin.php");
include("../lib/include.php");
include("../lib/function.php");
include("../lib/ewt_config.php");
include("../lib/connect.php");
$db->query("USE db_56_dmr_web");

$sql = $db->query("SELECT * FROM user_temp1 ORDER BY id");
while($R=$db->db_fetch_array($sql)){

$sql_p = $db->query("SELECT * FROM user_temp WHERE id = '".$R[id]."' ");
if($db->db_num_rows($sql_p) == 1){
	$M =  $db->db_fetch_array($sql_p);
	if($M[tname] == "นาย"){
	$titlen = "6";
	}
		if($M[tname] == "นาง"){
	$titlen = "2";
	}
		if($M[tname] == "นางสาว"){
	$titlen = "3";
	}
$db->query("UPDATE user_temp1 SET ttitle = '$titlen' WHERE id = '$R[id]' ");
}
}
echo "Done!";
$db->db_close();
?>
