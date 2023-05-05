<?php
include("../EWT_ADMIN/comtop_pop.php");

$date = new DateTime();
$s_data = array();
$a_data = array_merge($_POST, $_FILES);
	
if($a_data['proc']=='Add_Org_Title'){	
$db->query("USE ".$EWT_DB_USER);		
$s_data['title_thai']       	=  $a_data['org_title_name'];
$s_data['title_uid']   			=  $_SESSION['EWT_SUID'];
$s_data['title_createdate']  	=  $date->format('Y-m-d H:i:s');
$s_data['title_update']      	=  $date->format('Y-m-d H:i:s');
$s_data['title_status']      	=  $a_data['org_title_use'];

insert('title',$s_data);

$db->query("USE ".$EWT_DB_NAME);	
$db->write_log("create","org",$txt_org_title_add.' '.$a_data['org_title_name']);							   

unset($a_data);
unset($s_data);

$a_array['status'] 	= true;
$a_array['message'] = "success";

echo json_encode($a_array);	
exit;
} 
?>