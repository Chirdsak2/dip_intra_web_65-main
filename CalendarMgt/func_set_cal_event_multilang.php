<?php
include("../EWT_ADMIN/comtop_pop.php");


$a_data = array_merge($_POST, $_FILES);


if($a_data['proc']=='set_lang_cal_event'){
	
	for($i=0;$i<$a_data['num'];$i++){
		if($a_data['lang_field'][$i]){
		set_lang($a_data['c_id'],$a_data['lang_name'],$a_data['lang_field'][$i],$a_data['lang_detail'][$i],$a_data['module']);
		}
	}
	
print_r($a_data); 
	exit;
} 
?>