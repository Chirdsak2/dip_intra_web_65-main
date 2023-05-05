<?php
include("../EWT_ADMIN/comtop_pop.php");
$sso = new sso();
$a_data = array_merge($_GET);
$s_data = array();	

if($a_data['proc']=='DelOrgTitle'){
$s_sql = "SELECT PREFIX_TH FROM USR_PREFIX WHERE PREFIX_ID = '{$a_data['id']}'";
$a_data_org = $sso->getFetch($s_sql);
$name_thai 	= $a_data_org['PREFIX_TH'];
	
$sso->del('USR_PREFIX',array("PREFIX_ID" => $a_data['id']));

$db->query("USE ".$EWT_DB_NAME);	
$db->write_log("delete","org",$txt_org_title_delete.' '.$name_thai);							   

unset($a_data);
unset($s_data);

$a_array['status'] 	= true;
$a_array['message'] = "success";

echo json_encode($a_array);	
exit;
} 
	
?>