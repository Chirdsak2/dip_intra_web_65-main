<?php
session_start();
exit;
include("../lib/include_bizadmin.php");
include("../lib/include.php");
include("../lib/function.php");
include("../lib/ewt_config.php");

include("../lib/connect.php");

$db->query("USE ".$EWT_DB_USER);

$sql = $db->query("SELECT * FROM gen_user WHERE  org_id != '0' ORDER BY posittion DESC");
while($R=$db->db_fetch_array($sql)){
$sql1 = $db->query("SELECT * FROM gen_user2 WHERE id = '$R[emp_id]' ");
	if($db->db_num_rows($sql1) == 1){
		$A = $db->db_fetch_array($sql1);
		$db->query("UPDATE gen_user SET emp_type_id = '$A[ptype]', org_id = '$A[did]' WHERE gen_user_id = '$R[gen_user_id]' ");
	}
}
echo "Done!";
$db->db_close();
?>
