<?php
session_start();
include("../lib/include_bizadmin.php");
include("../lib/include.php");
include("../lib/function.php");
include("../lib/ewt_config.php");

include("../lib/connect.php");

$db->query("USE db_00_template");
 
$sql = $db->query("SELECT * FROM email");
while($R=$db->db_fetch_array($sql)){
$email = explode("@dmr.go.th",trim($R[0]));
$e = $email[0];
$sql1 = $db->query("SELECT gen_user_id  FROM gen_user WHERE name_eng = '$e' ");
if($db->db_num_rows($sql1) == 1){
	$row = $db->db_fetch_row($sql1);
	$db->query("UPDATE gen_user SET email_person = '".trim($R[0])."', gen_by = 'xxx' WHERE gen_user_id = '$row[0]' ");
}
}
echo "Done!";
$db->db_close();
?>
