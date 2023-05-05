<?php
include("../lib/permission1.php");
include("../lib/include.php");
include("../lib/function.php");
include("../lib/user_config.php");
include("../lib/connect.php");
include("../lib/set_lang.php");


if($_POST['proc'] == "P"){	
$name = addslashes($_POST['name']);
$des = addslashes($_POST['des']);
$sid = $_POST['s_id'];

$s_upload = $db->query("UPDATE p_survey SET 
										s_title = '{$name}' , 
										s_pos = '{$des}' 
										WHERE s_id = '{$sid}'
										");

$db->write_log("update","servey","แก้ไขหัวข้อแบบสำรวจ หัวข้อ เรื่อง".$name);
}
?>