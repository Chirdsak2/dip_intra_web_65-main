<?php
include("../EWT_ADMIN/comtop_pop.php");

$date = new DateTime();

$a_data = array_merge($_POST, $_FILES);
	
if($a_data['proc']=='Sortable_Edit'){
	
$db->query("USE ".$EWT_DB_USER);	
	
$s_data = array();

for($i=0; $i<count($a_data['page_id_array']); $i++){
	//$s_data['omc_leval']  	 =	$i;
	$s_count[] =	$a_data['page_id_array'][$i]['value'];
	$s_data['omc_name_sub']	=	$a_data['page_id_array'][$i]['parentId'];
	/*if($a_data['page_id_array'][$i]['order'] == 0){
	$s_data['omc_order'] 	= 	$a_data['page_id_array'][$i]['order'];	
	}else{
		$s_data['omc_order']	= 	$a_data['page_id_array'][$i]['order'];	
		}*/
	$s_data['omc_order']	= 	$i;	
	
	//if(empty($a_data['page_id_array'][$i]['parentId'])){
	//$s_data['omc_leval']	= 	1;
	//}else{
		$s_data['omc_leval']	= 	$a_data['page_id_array'][$i]['leval'];
		//}
	
	update('org_map_chart',$s_data,array('omc_name'=>$a_data['page_id_array'][$i]['id'],'omc_uid'=>$a_data['omc_uid'],'omc_org_id'=>$a_data['org_id']));				
	}

print_r($s_count);	
				   
unset($a_data);
unset($s_data);

$a_array['status'] 	= true;
$a_array['message'] = "success";

echo json_encode($a_array);	
exit;

	}else{
		$a_array['status'] 	= false;
		$a_array['message'] = "error";

		echo json_encode($a_array);	
		exit;		
	} 
?>