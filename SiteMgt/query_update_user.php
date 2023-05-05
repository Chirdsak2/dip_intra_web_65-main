<?php

include("../lib/include.php");
include("../lib/function.php");
include("../lib/ewt_config.php");
include("../lib/connect.php");
$db->query("USE ".$EWT_DB_NAME);

/*$sql = "SELECT * FROM gen_user";
$query = $db->query($sql);
while($R = $db->db_fetch_array($query)){
	if($R["name_thai"]==''){
	$name = addslashes(htmlspecialchars($R["gen_user"],ENT_QUOTES));
	}else{
	$name = $R["name_thai"];
	}
	if($R["org_id"]=='0'){
	$org_id = '101';
	}else{
	$org_id = $R["org_id"];
	}
	echo "UPDATE gen_user SET name_thai ='".$name."',org_id='".$org_id."' where gen_user_id='".$R["gen_user_id"]."'";
	$db->query("UPDATE gen_user SET name_thai ='".$name."',org_id='".$org_id."' where gen_user_id='".$R["gen_user_id"]."'");
}
echo "OK";*/

$sql ="select * from gen_user where status='2'";
$query = $db->query($sql);
while($R = $db->db_fetch_array($query)){
	$sql_permission = "select * from permission where pu_id ='".$R["gen_user_id"]."'";
	$query_permission = $db->query($sql_permission);
	if($db->db_num_rows($query_permission) == 0){
		//$db->query("UPDATE gen_user SET org_id ='0' where gen_user_id ='".$R["gen_user_id"]."'");
		$db->query("delete from gen_user where status='2' ");
	}else{
		
	}
}
echo 'OK';
?>