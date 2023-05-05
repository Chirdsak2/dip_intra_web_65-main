<?php
include("../lib/permission1.php");
include("../lib/include.php");
include("../lib/function.php");
include("../lib/user_config.php");
include("../lib/connect.php");
include("../lib/set_lang.php");



if($_POST['proc'] == "Q"){

if($_POST['just'] == 'Y'){ 

if($_POST['email_data'] == 'Y'){
	$just .= '#zz#Y';
}else if($_POST['email_data'] == 'N'){
	$just .= '#zz#N';
}else{
	$just .= '#zz#';
}

if($_POST['no_replate'] == 'QNR'){
	$just .= '#zz#QNR';
}else{
	$just .= '#zz#';
}

}else{
	
if($_POST['email_data'] == 'Y'){
	$just .= '#zz#Y';
}else if($_POST['email_data'] == 'N'){
	$just .= '#zz#N';
}else{
	$just .= '';
}

if($_POST['no_replate'] == 'QNR'){
	$just .= '#zz#QNR';
}else{
	$just .= '#zz#';
}

}
	
$ch = addslashes($_POST['ch']);
$name = addslashes($_POST['name']);
$qid  = $_POST['qid'];
$pos = $_POST['pos'];

$s_update = $db->query("UPDATE p_question SET 
										q_name = '{$ch}',
										q_des = '{$name}',
										q_pos = '{$pos}' ,
										q_req = '{$just}' 
										WHERE q_id = '{$qid}'
										");


$db->write_log("update","servey","แก้ไขคำถาม ".$ch.".".$name);

}
?>