<?php
include("../EWT_ADMIN/comtop_pop.php");
$sso = new sso();
$date = new DateTime();
$s_data = array();
$a_data = array_merge($_POST, $_FILES);
	
if($a_data['proc']=='Add_Org_Title'){		
$s_data['PREFIX_TH']       	    =  $a_data['org_title_name'];
$s_data['PREFIX_ORDER']   	    =  $sso->maxId("USR_PREFIX","PREFIX_ORDER");
$s_data['PREFIX_UID']   		=  $_SESSION['EWT_SUID'];
$s_data['PREFIX_CREATE_DATE']  	=  date('Y-m-d H:i:s');
$s_data['PREFIX_STATUS']      	=  $a_data['org_title_use'];

$sso->insert('USR_PREFIX',$s_data);

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