<?php
include("../lib/include.php");
include("../lib/function.php");
include("../lib/user_config.php");
include("../lib/connect.php");
include("../lib/set_lang.php");
include("../language.php");
include("../language/language_TH.php");
include("../lib/config_path.php");

$a_data = array_merge($_POST, $_FILES);

if($a_data['proc'] == "2"){
	
$s_insert = $db->query("INSERT INTO p_cate (c_id,
											s_id,
											c_d,
											c_name,
											c_title,
											c_gp,
											option1,
											option2 
											)VALUES (
											'',
											'{$a_data['s_id']}',
											'1',
											'{$a_data['name']}',
											'{$a_data['des']}',
											'{$a_data['gr']}',
											'{$a_data['sel']}',
											'{$a_data['num']}'
											)");


if($s_insert){
$db->write_log("create","servey","สร้างแบบสำรวจ ส่วนที่1 เรื่อง ".$a_data['name']);
echo url_encode($a_data['s_id']);	
//print_r($a_data[1]);

}	
	exit;
}
?>
