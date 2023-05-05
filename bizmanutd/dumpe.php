<?php
session_start();
include("../lib/include_bizadmin.php");
include("../lib/include.php");
include("../lib/function.php");
include("../lib/ewt_config.php");

include("../lib/connect.php");

$db->query("USE ".$EWT_DB_USER);


$sql = $db->query("SELECT * FROM gen_user WHERE name_eng IS NULL AND  org_id != '0' AND gen_user = ''  ORDER BY posittion DESC");
while($R=$db->db_fetch_array($sql)){
$sql1 = $db->query("SELECT temp_fname_en,temp_lname_en FROM temp_eng WHERE temp_fname_th = '$R[name_thai]' AND temp_lname_th = '$R[surname_thai]' ");
echo $db->db_num_rows($sql1);
	if($db->db_num_rows($sql1) == 1){
		$A = $db->db_fetch_array($sql1);
		$db->query("UPDATE gen_user SET name_eng = '$A[temp_fname_en]', surname_eng = '$A[temp_lname_en]' WHERE gen_user_id = '$R[gen_user_id]' ");
		echo "<font color=blue>".$R[name_thai]." ".$R[surname_thai]."</font><br>";
	}else{
	echo "<font color=red>".$R[name_thai]." ".$R[surname_thai]."</font><br>";
	}
}
echo "Done!";
$db->db_close();
?>
