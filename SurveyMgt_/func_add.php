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

$gr = $_POST['gr'];
$sel = $_POST['sel'];
$num = $_POST['num'];
$s_id = $_POST['s_id'];

$SQL = $db->query("INSERT INTO p_cate ( c_id,
										s_id,
										c_d,
										c_name,
										c_title,
										c_gp,
										option1,
										option2 ) 
										VALUES (
										'',
										'{$s_id}',
										'{$pa}',
										'{$name}',
										'{$des}',
										'{$gr}',
										'{$sel}',
										'{$num}')
										");

}
?>