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
$pa = addslashes($_POST['pa']);
$path = $_POST['path'];

$s_upload = $db->query("UPDATE p_cate SET 
										c_name = '{$name}', 
										c_title = '{$des}',
										c_d = '{$pa}' 
										WHERE c_id = '{$path}'
										");
										
$db->write_log("update","servey","แก้ไขคำถาม ".$name);

}

?>