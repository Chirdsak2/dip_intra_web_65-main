<?php
include("../EWT_ADMIN/comtop_pop.php");

$date = new DateTime();

$a_data = array_merge($_POST, $_FILES);
	

if($a_data['proc']=='Sortable_Edit'){
	
$s_data = array();

//$a_data['page_id_array'];
for($i=0; $i<count($a_data['page_id_array']); $i++){
	
$s_data['pdpa_pos']  = $i+1;
	
update('m_complain_pdpa',$s_data,array('pdpa_id'=>$a_data['page_id_array'][$i]));
	
}
							   
//print_r($a_data['page_id_array']);	

unset($a_data);
unset($s_data);

exit;
	} 
?>