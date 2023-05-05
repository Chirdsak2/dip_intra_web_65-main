<?php
include("../EWT_ADMIN/comtop_pop.php");
$sso = new sso();
$date = new DateTime();

$a_data = array_merge($_POST, $_FILES);
	
if($a_data['proc']=='Edit_Pos'){
$s_data = array();
$s_data['POS_NAME']       	=  $a_data['pos_name'];
$s_data['POS_SHORT_NAME']   =  $a_data['pos_short_name'];
$s_data['POS_UPDATE_DATE']  =  date('Y-m-d H:i:s');
$s_data['POS_STATUS']      	=  $a_data['pos_name_use'];

$sso->update('USR_POSITION',$s_data,array('pos_id'=>$a_data['POS_ID']));

$db->query("USE ".$EWT_DB_NAME);							   
sys::save_log('update','org',$txt_org_pos_name_edit.' '.$a_data['pos_name']);

unset($a_data);
unset($s_data);

$a_array['status'] 	= true;
$a_array['message'] = "success";

echo json_encode($a_array);	
exit;

} 
?>