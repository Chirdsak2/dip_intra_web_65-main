<?php
include("../EWT_ADMIN/comtop_pop.php");
$sso = new sso();
$date = new DateTime();

$a_data = array_merge($_POST, $_FILES);
	

if($a_data['proc']=='Add_Pos'){
$s_data = array();
$s_data['POS_NAME']       	=  $a_data['pos_name'];
$s_data['POS_ORDER']   	    =  $sso->maxId("USR_POSITION","POS_ORDER");
$s_data['POS_SHORT_NAME']   =  $a_data['pos_name_short'];
$s_data['POS_STATUS']      	=  $a_data['pos_name_use'];
$s_data['POS_CREATE_DATE']  =  date('Y-m-d H:i:s');
$s_data['POS_UID']          =  $_SESSION['EWT_SUID'];

$sso->insert('USR_POSITION',$s_data);

$db->query("USE ".$EWT_DB_NAME);						   
sys::save_log('create','org',$txt_org_pos_name_add.' '.$a_data['pos_name']);

unset($a_data);
unset($s_data);

$a_array['status'] 	= true;
$a_array['message'] = "success";

echo json_encode($a_array);	
exit;
} 
?>