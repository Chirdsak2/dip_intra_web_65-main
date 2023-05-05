<?php
include("../lib/permission1.php");
include("../lib/include.php");
include("../lib/function.php");
include("../lib/user_config.php");
include("../lib/connect.php");
$db->query("USE ".$EWT_DB_USER);

$num = $_POST["numrow"];
if($num > 0){
for($i=0;$i< $num;$i++){
$gen_user_id = $_POST["gen_user_id_app_".$i];
$approve_all = $_POST["approve_all_".$gen_user_id];
	if($approve_all == 'Y'){
	$sql_update = "update gen_user set  status = '1'  where gen_user_id = '".$gen_user_id."'";
	$db->query($sql_update);
	}
}
		echo "<script language=\"javascript\">";
		echo "alert('อนุมัติเรียบร้อยแล้ว');";
		echo "document.location.href='MemberList_outside.php';" ;
		echo "</script>";
}
?>