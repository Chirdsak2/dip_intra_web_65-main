<?php
include("../lib/include.php");
include("../lib/function.php");
include("../lib/user_config.php");
include("../lib/connect.php");
include("../lib/set_lang.php");

$date = new DateTime();

$a_data = array_merge($_POST, $_FILES);
$s_data = array();

if($a_data['proc'] == "P"){

$s_data['s_id']   	= 	$a_data['s_id'];
$s_data['c_d']   	= 	$a_data['pa'];
$s_data['c_name']   = 	$a_data['name'];
$s_data['c_title']  = 	$a_data['des'];
$s_data['c_gp']   	= 	$a_data['gr'];
$s_data['option1']  = 	$a_data['sel'];
$s_data['option2']  = 	$a_data['num'];
	
/*$name = addslashes($_POST['name']);
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
										*/
insert('p_cate',$s_data);	


///update('p_survey',$s_data,array('s_id'=>$a_data['s_id']));
	
//$db->write_log("create","servey","เพิ่มส่วนที่ ".$ch.".".$name);

print_r($a_data);	

unset($a_data);
unset($s_data);

exit;
	} 
?>