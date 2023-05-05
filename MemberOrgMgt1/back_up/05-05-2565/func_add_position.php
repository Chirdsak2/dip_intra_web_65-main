<?php
include("../EWT_ADMIN/comtop_pop.php");

$date = new DateTime();

$a_data = array_merge($_POST, $_FILES);
	

if($a_data['proc']=='Add_Pos'){
	
$db->query("USE ".$EWT_DB_USER);		
$s_data = array();
$s_data['pos_name']       	=  $a_data['pos_name'];
$s_data['pos_short_name']   =  $a_data['pos_name_short'];
$s_data['pos_uid']   		=  $_SESSION['EWT_SUID'];
$s_data['pos_createdate']  	=  $date->format('Y-m-d H:i:s');
$s_data['pos_update']      	=  $date->format('Y-m-d H:i:s');
$s_data['pos_status']      	=  $a_data['pos_name_use'];

insert('position_name',$s_data);

$db->query("USE ".$EWT_DB_NAME);	
//$db->write_log("create","org",$txt_org_pos_name_add.' '.$a_data['pos_name']);							   
sys::save_log('create','org',$txt_org_pos_name_add.' '.$a_data['pos_name']);

unset($a_data);
unset($s_data);

$a_array['status'] 	= true;
$a_array['message'] = "success";

echo json_encode($a_array);	
exit;
} 
?>