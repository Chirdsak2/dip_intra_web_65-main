<?php
include("../EWT_ADMIN/comtop_pop.php");

$a_data = array_merge($_POST, $_FILES);

if($a_data['proc']=='set_lang_org_group'){
	
$db->query("USE ".$EWT_DB_USER);	
	
	for($i=0;$i<$a_data['num'];$i++){
		if($a_data['lang_field'][$i]){
		set_lang_ewt($a_data['c_id'],$a_data['lang_name'],$a_data['lang_field'][$i],$a_data['lang_detail'][$i],$a_data['module']);
		}
	}
	
unset($a_data);
unset($s_data);

$a_array['status'] 	= true;
$a_array['message'] = "success";

echo json_encode($a_array);	
exit;
} 
?>