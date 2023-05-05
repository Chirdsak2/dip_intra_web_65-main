<?php
include("../EWT_ADMIN/comtop_pop.php");
//$date = new DateTime();

$a_data = array_merge($_GET, $_FILES);
$s_data = array();	

if($a_data['proc']=='DelFaq'){
	
$s_data['faq_use']  = '';

//update('faq',$s_data,array('fa_id'=>$a_data['id']));	

del('faq','fa_id='.$a_data['id']);
						   
//print_r($s_data);	
echo json_encode($s_data);	
unset($a_data);
unset($s_data);

exit;
	}
?>