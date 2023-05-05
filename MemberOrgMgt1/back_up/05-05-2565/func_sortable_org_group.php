<?php
include("../EWT_ADMIN/comtop_pop.php");

$date = new DateTime();

$a_data = array_merge($_POST, $_FILES);
	

if($a_data['proc']=='Sortable_Edit'){
	
$db->query("USE ".$EWT_DB_USER);	

$s_data		=	array();
//$a_data['page_id_array'];
$s_start	= 	$a_data['start'];
$s_val  	= 	count($a_data['page_id_array'])+$s_start;
	for($i=0; $i<$s_val; $i++){
		$s_data['org_order']  = $i+$a_start+1;		
		update('org_name',$s_data,array('org_id'=>$a_data['page_id_array'][$i]));	
	}					   
//print_r($a_data);	

unset($a_data);
unset($s_data);

$a_array['status'] 	= true;
$a_array['message'] = "success";

echo json_encode($a_array);	
exit;

	} 
?>