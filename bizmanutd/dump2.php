<?php 
exit;
session_start();
include("../lib/include_bizadmin.php");
include("../lib/include.php");
include("../lib/function.php");
include("../lib/ewt_config.php");

include("../lib/connect.php");

$db->query("USE ".$EWT_DB_NAME);

/*
$sql = $db->query("SELECT * FROM temp_import ");
while($R=$db->db_fetch_array($sql)){
	$t = explode(" ",$R[t_name]);
		if($t[0] == "นาย"){
		$titlen = "6";
		}
		if($t[0] == "นาง"){
		$titlen = "2";
		}
		if($t[0] == "นางสาว"){
		$titlen = "3";
		}
		$emp_type_id = "1";
		$position_person = trim($R["t_pos"]);
		$level = "3";

		$org = trim($R["t_dep"])."---".trim($R["t_div"]);

$orgid = "0";
$sql_check = $db->query("SELECT org_id FROM org_name WHERE name_org = '$org' ");
if($db->db_num_rows($sql_check) == 1){
$O = $db->db_fetch_row($sql_check);
$orgid = $O[0];
}else{
$db->query("INSERT INTO org_name (name_org) VALUES ('$org') ");
$orgid = mysql_insert_id();
$db->query("UPDATE org_name SET parent_org_id = '0001_00".($orgid - 1)."' WHERE org_id = '$orgid' ");
}
$db->query("INSERT INTO gen_user (title_thai,emp_type_id,org_id,name_thai,surname_thai,position_person,email_kh,status) VALUES ('$titlen','$emp_type_id','$orgid','$t[1]','$t[2]','$position_person','".trim($R[t_head])."','1')");
}


$sql = $db->query("SELECT * FROM temp_import2 ORDER BY t_id");
while($R=$db->db_fetch_array($sql)){
	$t = explode(" ",$R[t_name]);
		if($t[0] == "นาย"){
		$titlen = "6";
		}
		if($t[0] == "นาง"){
		$titlen = "2";
		}
		if($t[0] == "นางสาว"){
		$titlen = "3";
		}

		$position_person = trim($R["t_pos"]);

$sql_check = $db->query("SELECT org_id FROM org_name WHERE name_org = '".$R["t_dep"]."' ");
if($db->db_num_rows($sql_check) == 1){
$O = $db->db_fetch_row($sql_check);
$orgid = $O[0];
$db->query("UPDATE temp_import2 SET t_dep = '$orgid' WHERE t_id = '$R[t_id]' ");
}
	if($t[0] != "" AND $t[1] != "" AND  $t[2] != "" ){
		$db->query("UPDATE temp_import2 SET t_title = '$titlen',t_name = '$t[1]',t_sur = '$t[2]',t_pos = '$position_person'  WHERE t_id = '$R[t_id]' ");
	}
}*/
$sql = $db->query("SELECT * FROM temp_import2 ORDER BY t_id");
while($R=$db->db_fetch_array($sql)){
		$emp_type_id = "2";
		$position_person = trim($R["t_pos"]);
		$level = "3";
$db->query("INSERT INTO gen_user (emp_id,title_thai,emp_type_id,org_id,name_thai,surname_thai,position_person,status) VALUES ('$R[t_id]','$R[t_title]','$emp_type_id','$R[t_dep]','$R[t_name]','$R[t_sur]','$position_person','1')");
}
echo "Done!";
$db->db_close();
?>