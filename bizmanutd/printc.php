<?php
session_start();
include("../lib/include_bizadmin.php");
include("../lib/include.php");
include("../lib/function.php");
include("../lib/ewt_config.php");
include("../lib/connect.php");
$db->query("USE ".$EWT_DB_NAME);
$typep = array("","ข้าราชการ","พนักงานราชการ","ลูกจ้างประจำ");
$sql = $db->query("SELECT  gen_user.emp_id,
title.title_thai,
gen_user.name_thai,
gen_user.surname_thai,
gen_user.emp_type_id,
gen_user.position_no,
gen_user.position_person,
gen_user.gen_user,
gen_user.gen_pass,
org_name.name_org,
org_name.parent_org_id FROM gen_user INNER JOIN title ON title.title_id = gen_user.title_thai INNER JOIN org_name ON org_name.org_id = gen_user.org_id WHERE gen_user.gen_user != '' ORDER BY org_name.parent_org_id ASC ");
$i=0;
echo "<table><tr><td>รหัสบัตรประชาชน</td><td>คำนำหน้า</td><td>ชื่อ</td><td>นามสกุล</td><td>ประเภท</td><td>เลขที่ตำแหน่ง</td><td>ตำแหน่ง</td><td>Username</td><td>Password</td><td>กอง/สำนัก/ศูนย์</td><td>กลุ่ม/ฝ่าย</td></tr>";
while($R = mysql_fetch_row($sql)){

echo "<tr><td>".$R[0]."&nbsp;</td><td>".$R[1]."</td><td>".$R[2]."</td><td>".$R[3]."</td><td>".$typep[$R[4]]."</td><td>".$R[5]."</td><td>".$R[6]."</td><td>".$R[7]."</td><td>".$R[8]."&nbsp;</td><td>";

if(strlen($R[10]) != 9){
	$plen = substr($R[10], 0, 9);
		$sql_org = $db->query("SELECT name_org FROM org_name WHERE parent_org_id = '$plen' ");
		if($db->db_num_rows($sql_org) == 0){
			echo $R[9]."</td><td>";
		}else{
			$Or = $db->db_fetch_row($sql_org);
			echo $Or[0]."</td><td>".$R[9];
		}
}else{
echo $R[9]."</td><td>";
}
echo "</td></tr>";
}
echo "</table>";
$db->db_close();
?>
