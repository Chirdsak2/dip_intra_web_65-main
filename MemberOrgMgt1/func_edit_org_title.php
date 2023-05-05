<?php
include("../EWT_ADMIN/comtop_pop.php");
$sso = new sso();
$date = new DateTime();

$a_data = array_merge($_POST, $_FILES);
	
if($a_data['proc']=='Edit_Org_Title'){		
$s_data = array();
$s_data['PREFIX_TH']            =  $a_data['org_title_name'];
$s_data['PREFIX_UPDATE_DATE']   =  date('Y-m-d H:i:s');
$s_data['PREFIX_STATUS']        =  $a_data['org_title_use'];

$sso->update('USR_PREFIX',$s_data,array('PREFIX_ID'=>$a_data['PREFIX_ID']));

$db->query("USE ".$EWT_DB_NAME);	
$db->write_log("update","org",$txt_org_title_edit.' '.$a_data['org_title_name']);							   

unset($a_data);
unset($s_data);

$a_array['status'] 	= true;
$a_array['message'] = "success";

echo json_encode($a_array);	
exit;
} 
?>