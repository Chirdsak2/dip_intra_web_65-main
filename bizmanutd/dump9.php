<?php
exit;
session_start();
include("../lib/include_bizadmin.php");
include("../lib/include.php");
include("../lib/function.php");
include("../lib/ewt_config.php");

include("../lib/connect.php");

$db->query("USE ".$EWT_DB_NAME);


$sql = $db->query("SELECT * FROM gen_user2 ORDER BY id");
while($R=$db->db_fetch_array($sql)){
$sql1 = $db->query("SELECT * FROM gen_user WHERE emp_id = '$R[id]' ");
	if($db->db_num_rows($sql1) == 0){
		$db->query("INSERT INTO gen_user (emp_id,title_thai,emp_type_id,org_id,name_thai,surname_thai,name_eng,surname_eng,position_person,status) VALUES ('".trim($R["id"])."','".trim($R["title"])."','".trim($R["ptype"])."','1','".trim($R["name"])."','".trim($R["sur"])."','".trim($R["ename"])."','".trim($R["esur"])."','".trim($R["pos"])."','0')");
		$myid = mysql_insert_id();
		if(trim($R["ename"]) != ""){
			$myuser = strtolower(trim($R["ename"]));
			$mypass = substr(trim($R["id"]), -8);
			$sql2 = $db->query("SELECT gen_user FROM gen_user WHERE gen_user = '$myuser' ");
			if($db->db_num_rows($sql2) == 0){
				$db->query("UPDATE gen_user SET gen_user = '$myuser',gen_pass = '$mypass' WHERE gen_user_id = '$myid' ");
			}else{
				$myuser .= ".".substr(trim($R["ename"]), 0, 1); 
				$sql3 = $db->query("SELECT gen_user FROM gen_user WHERE gen_user = '$myuser' ");
				if($db->db_num_rows($sql3) == 0){
				$db->query("UPDATE gen_user SET gen_user = '$myuser',gen_pass = '$mypass' WHERE gen_user_id = '$myid' ");
				}
			}
		}
	}
}
echo "Done!";
$db->db_close();
?>
