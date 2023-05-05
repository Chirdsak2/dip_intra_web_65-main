<?php
include("../EWT_ADMIN/comtop_pop.php");
$sso = new sso();
$a_data = array_merge($_GET);
$s_data = array();	

if($a_data['proc']=='DelOrgGroup'){
$s_sql = "SELECT DEP_NAME FROM USR_DEPARTMENT WHERE DEP_ID = '{$a_data['id']}'";
$a_data_org = $sso->getFetch($s_sql);
$name_org 	= $a_data_org['DEP_NAME'];
	
$sso->del('USR_DEPARTMENT',array("DEP_ID" => $a_data['id']));

$db->query("USE ".$EWT_DB_NAME);	
$db->write_log("delete","org",$txt_org_delete_group.' '.$name_org);							   
unset($a_data);
unset($s_data);

$a_array['status'] 	= true;
$a_array['message'] = "success";

echo json_encode($a_array);	
exit;
} 
	
?>