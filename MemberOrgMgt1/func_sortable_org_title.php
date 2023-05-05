<?php
include("../EWT_ADMIN/comtop_pop.php");
$sso = new sso();
$date = new DateTime();

$a_data = array_merge($_POST, $_FILES);
	
if($a_data['proc']=='Sortable_Edit'){
$s_data		=	array();
$s_start	= 	$a_data['start'];
$s_val  	= 	sizeof($a_data['page_id_array']);
	for($i=0; $i<$s_val; $i++){
		$s_data['PREFIX_ORDER']  = ($i+$start)+1;		
		$sso->update('USR_PREFIX',$s_data,array('PREFIX_ID'=>$a_data['page_id_array'][$i]));	
	}					   

unset($a_data);
unset($s_data);

$a_array['status'] 	= true;
$a_array['message'] = "success";

echo json_encode($a_array);	
exit;

	} 
?>