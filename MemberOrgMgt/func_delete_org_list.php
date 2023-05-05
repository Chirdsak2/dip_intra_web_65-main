<?php
include("../EWT_ADMIN/comtop_pop.php");
$a_data = array_merge($_GET, $_FILES);
$proc = $a_data['proc'];
//print_r($a_data);
//exit;
switch($proc)  
{ 
	case "DelOrgList":
	
	$db->query("USE ".$EWT_DB_USER);
	$s_sql = $db->query("SELECT * FROM `gen_user` WHERE `gen_user_id` = '{$a_data['id']}' ");
	$a_rows		= $db->db_num_rows($s_sql);	
	if($a_rows)
	{
	$a_data_u = $db->db_fetch_array($s_sql);
	$name_thai 		= $a_data_u['name_thai'];	
	$surname_thai 	= $a_data_u['surname_thai'];

	del('gen_user','gen_user_id='.$a_data['id']);

	$db->query("USE ".$EWT_DB_NAME);	
	sys::save_log('delete','org',$txt_org_delete.' '.$name_thai.' '.$surname_thai);							   
	//print_r($s_data);	
	}
	unset($a_data);
	unset($s_data);

$a_array['status'] 	= true;
$a_array['message'] = "success";

echo json_encode($a_array);	
	exit;	
break;
}		
?>