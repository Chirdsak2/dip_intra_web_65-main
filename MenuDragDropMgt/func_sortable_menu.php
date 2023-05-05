<?php
include("../lib/include.php");
include("../lib/function.php");
include("../lib/user_config.php");
include("../lib/connect.php");
include("../lib/set_lang.php");

function GenLen($data,$op){
$s = explode($op,$data);
return count($s);
}

$date = new DateTime();

$a_data = array_merge($_POST, $_FILES);
	

if($a_data['proc']=='Sortable_Edit'){
	
$s_data = array();

for($i=0; $i<count($a_data['page_id_array']); $i++){	

	
	
	
	/*if($a_data['page_id_array'][$i]['parentId'])
	{
	//$mp_id = $a_data['m_id']."_".sprintf("%04d",$a_data['page_id_array'][$i]['parentId'])."_".sprintf("%04d",($a_data['page_id_array'][$i]['order']+1));
	}else{
		//$mp_id = $a_data['m_id']."_".sprintf("%04d",($a_data['page_id_array'][$i]['order']+1));
		
	}
	
	$len = GenLen($a_data['page_id_array'][$i]['value'],"_");
	$len--;
	$numr = strlen($mp_id);
	$rest = substr($mp_id, 0, -4);
	
	$data = explode("_",$mp_id);

	$num_array = count($data);
	$field_change = $data[$len]+1;
	$field_change = sprintf("%04d",$field_change);
	
	$total = '';
	for($ii=0; $ii < $num_array; $ii++){
		if($ii == $len){
		$total .= $field_change."_";
			}else{
				$total .= $data[$ii]."_";
			}
	 }
	$total = substr($total, 0, -1);*/
	
	
	
	//$s_data['m_id']  = $total;
	//$s_data['mp_id']  = $mp_id;
	$s_data['mp_sub'] = $a_data['page_id_array'][$i]['parentId'];
	$s_data['mp_pos'] = $a_data['page_id_array'][$i]['order']+1;	
		
	update('menu_properties',$s_data,array('mp_pid'=>$a_data['page_id_array'][$i]['id'],'m_id'=>$a_data['m_id']));			


	}

print_r($s_data);	
					   
unset($a_data);
unset($s_data);

	exit;

} 
?>