<?php
session_start();
include("../lib/include_bizadmin.php");
include("../lib/include.php");
include("../lib/function.php");
include("../lib/ewt_config.php");

include("../lib/connect.php");

$db->query("USE ".$EWT_DB_NAME);

 
$sql = $db->query("SELECT * FROM gen_user WHERE gen_user  = '' AND org_id != '0' AND name_eng != '' ORDER BY posittion DESC");
while($R=$db->db_fetch_array($sql)){
	if($R[name_eng] != ""){
		$nameeng = strtolower(trim($R[name_eng]));
		$sql_chk = $db->query("SELECT gen_user FROM gen_user WHERE gen_user = '$nameeng' ");
		if($db->db_num_rows($sql_chk) == 0){
			$pass = substr($R[emp_id], -8);    
			$db->query("UPDATE gen_user SET gen_user = '$nameeng',gen_pass = '$pass' WHERE gen_user_id = '$R[gen_user_id]' ");
		}else{
		$surn = strtolower(trim($R[surname_eng]));
		$surnn = substr($surn, 0, 1);
		$nameeng = $nameeng.".".$surnn;
				$sql_chk = $db->query("SELECT gen_user FROM gen_user WHERE gen_user = '$nameeng' ");
				if($db->db_num_rows($sql_chk) == 0){
					$pass = substr($R[emp_id], -8);    
					$db->query("UPDATE gen_user SET gen_user = '$nameeng',gen_pass = '$pass' WHERE gen_user_id = '$R[gen_user_id]' ");
				}
		}
	}else{
		if($R[emp_id] != "" AND $R[emp_id] != "0" ){
			$nameeng = "u".substr($R[emp_id], -8);
			$sql_chk = $db->query("SELECT gen_user FROM gen_user WHERE gen_user = '$nameeng' ");
			if($db->db_num_rows($sql_chk) == 0){
				$pass = substr($R[emp_id], -8);    
				$db->query("UPDATE gen_user SET gen_user = '$nameeng',gen_pass = '$pass' WHERE gen_user_id = '$R[gen_user_id]' ");
			}
		}
	}
}
echo "Done!";
$db->db_close();
?>
