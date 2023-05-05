<?php
include("../EWT_ADMIN/comtop_pop.php");

$date = new DateTime();

$a_data = array_merge($_POST, $_FILES);
	
if($a_data['proc']=='Add_Org_Group'){
	
$db->query("USE ".$EWT_DB_USER);		
$s_data = array();

$s_data['name_org']       	=  $a_data['org_group_name'];
$s_data['parent_org_id']   	=  '0001_';
$s_data['tel']   			=  $a_data['org_group_tel'];
$s_data['email']   			=  $a_data['org_group_email'];
$s_data['fax']   			=  $a_data['org_group_fax'];
$s_data['short_name']   	=  $a_data['org_group_name_short'];
$s_data['org_uid']   		=  $_SESSION['EWT_SUID'];
$s_data['org_createdate']  	=  $date->format('Y-m-d H:i:s');
$s_data['org_update']      	=  $date->format('Y-m-d H:i:s');
$s_data['org_status']      	=  $a_data['org_group_use'];

insert('org_name',$s_data);

$db->query("USE ".$EWT_DB_NAME);	
$db->write_log("create","org",$txt_org_add_group.' '.$a_data['org_group_name']);							   

unset($a_data);
unset($s_data);

$a_array['status'] 	= true;
$a_array['message'] = "success";

echo json_encode($a_array);	
exit;
} 
?>