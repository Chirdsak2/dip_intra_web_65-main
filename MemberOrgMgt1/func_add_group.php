<?php
include("../EWT_ADMIN/comtop_pop.php");

$date = new DateTime();
$sso = new sso();

$a_data = array_merge($_POST, $_FILES);
	
if($a_data['proc']=='Add_Org_Group'){		
$s_data = array();
$s_data['DEP_NAME'] 	        =  $a_data['org_group_name'];
$s_data['DEP_ORDER']   	        =  $sso->maxId("USR_DEPARTMENT","DEP_ORDER");
$s_data['DEP_TEL']   			=  $a_data['org_group_tel'];
$s_data['DEP_EMAIL']   			=  $a_data['org_group_email'];
$s_data['DEP_FAX']   			=  $a_data['org_group_fax'];
$s_data['DEP_SHORT_NAME']   	=  $a_data['org_group_name_short'];
$s_data['DEP_STATUS']           =  $a_data['org_group_use'];
$s_data['DEP_CREATE_DATE']  	=  date('Y-m-d H:i:s');
$s_data['DEP_UID']              =  $_SESSION['EWT_SUID'];

$sso->insert('USR_DEPARTMENT',$s_data);

$db->query("USE ".$EWT_DB_NAME);	
$db->write_log("create","org",$txt_org_add_group.' '.$a_data['org_group_name']);							   

unset($a_data);
unset($s_data);

$a_array['status'] 	= true;
$a_array['message'] = "success";

echo json_encode($a_array);	
exit;
}
