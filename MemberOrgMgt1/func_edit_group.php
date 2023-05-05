<?php
include("../EWT_ADMIN/comtop_pop.php");
$sso = new sso();
$date = new DateTime();

$a_data = array_merge($_POST, $_FILES);
	
if($a_data['proc']=='Edit_Org_Group'){	
$s_data = array();
$s_data['DEP_NAME']       	    =  $a_data['org_group_name'];
$s_data['DEP_TEL']   			=  $a_data['org_group_tel'];
$s_data['DEP_EMAIL']   			=  $a_data['org_group_email'];
$s_data['DEP_FAX']   			=  $a_data['org_group_fax'];
$s_data['DEP_SHORT_NAME']   	=  $a_data['org_group_name_short'];
$s_data['DEP_STATUS']      	    =  $a_data['org_group_use'];
$s_data['DEP_UPDATE_DATE']      =  date('Y-m-d H:i:s');

$sso->update('USR_DEPARTMENT',$s_data,array('DEP_ID'=>$a_data['DEP_ID']));

$db->query("USE ".$EWT_DB_NAME);	
$db->write_log("update","org",$txt_org_edit_group.' '.$a_data['org_group_name']);							   

unset($a_data);
unset($s_data);
$a_array['status'] 	= true;
$a_array['message'] = "success";

echo json_encode($a_array);	
exit;
} 
?>