<?php
include("../EWT_ADMIN/comtop_pop.php");
$sso = new sso();
$a_data = array_merge($_GET);
$s_data = array();	

if($a_data['proc']=='DelOrgPos'){
	
$db->query("USE ".$EWT_DB_USER);
$s_sql = "SELECT POS_NAME FROM USR_POSITION WHERE POS_ID = '{$a_data['id']}'";
$a_data_pos = $sso->getFetch($s_sql);
$pos_name 	= $a_data_pos['POS_NAME'];
	
$sso->del('USR_POSITION',array("POS_ID" => $a_data['id']));

$db->query("USE ".$EWT_DB_NAME);	
$db->write_log("delete","org",$txt_org_pos_name_delete.' '.$pos_name);							   
unset($a_data);
unset($s_data);

$a_array['status'] 	= true;
$a_array['message'] = "success";

echo json_encode($a_array);	
exit;
} 
	
?>