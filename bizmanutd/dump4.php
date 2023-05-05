<?php
//exit;
session_start();
include("../lib/include_bizadmin.php");
include("../lib/include.php");
include("../lib/function.php");
include("../lib/ewt_config.php");
include("../lib/connect.php");
$db->query("USE ".$EWT_DB_NAME);
/*
$i=0;
$sql = $db->query("SELECT org_id FROM org_name");
while($R=$db->db_fetch_row($sql)){

$sql_l = $db->query("SELECT gen_user.gen_user_id FROM gen_user INNER JOIN position_name ON position_name.pos_id = gen_user.posittion WHERE gen_user.org_id = '$R[0]' ORDER BY position_name.pos_level ASC LIMIT 0,1");
	if($db->db_num_rows($sql_l) > 0){
			$L = $db->db_fetch_row($sql_l);
			$sql_u = $db->query("SELECT gen_user_id FROM gen_user WHERE org_id = '$R[0]' AND gen_user_id != '$L[0]' ");
			while($U = $db->db_fetch_row($sql_u)){
				$db->query("INSERT INTO leader_list (leader_id,under_id) VALUES ('$L[0]','$U[0]')");
			}
	}else{
	echo $R[0]."<br>";
	}
} */

$sql =$db->query("SELECT gen_user_id,name_thai,surname_thai FROM gen_user WHERE emp_id = '0'");
while($R=$db->db_fetch_row($sql)){
	echo $R[1]." ".$R[2]." => SELECT card FROM temp_import3 WHERE name LIKE '".trim($R[1])."%' AND sur LIKE '".trim($R[2])."%'  ";
$sql_l = $db->query("SELECT card FROM temp_import3 WHERE name LIKE '".trim($R[1])."%' AND sur LIKE '".trim($R[2])."%'  ");
	if($db->db_num_rows($sql_l) == 1){
			$L = $db->db_fetch_row($sql_l);
				$db->query("UPDATE gen_user SET emp_id ='$L[0]',name_thai = '".trim($R[1])."',surname_thai = '".trim($R[2])."' WHERE gen_user_id = '$R[0]' ");
				echo "Update<br>";
	}else{
				echo " Found ".$db->db_num_rows($sql_l)."<br>";
				}
}
echo "Done!";
$db->db_close();
?>
