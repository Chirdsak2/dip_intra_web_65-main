<?php
session_start();
include("../lib/include_bizadmin.php");
include("../lib/include.php");
include("../lib/function.php");
include("../lib/ewt_config.php");

include("../lib/connect.php");

$db->query("USE ".$EWT_DB_NAME);

 exit;
$sql = $db->query("SELECT * FROM gen_user WHERE  org_id != '0' ORDER BY posittion DESC");
while($R=$db->db_fetch_array($sql)){
$sql1 = $db->query("SELECT name_eng,surname_eng FROM gen_user1 WHERE emp_id = '$R[emp_id]' AND gen_user_id = '$R[gen_user_id]'  ");
	if($db->db_num_rows($sql1) == 1){
		$A = $db->db_fetch_array($sql1);
		$db->query("UPDATE gen_user SET name_eng = '$A[name_eng]', surname_eng = '$A[surname_eng]' WHERE gen_user_id = '$R[gen_user_id]' ");
	}
}
echo "Done!";
$db->db_close();
?>
