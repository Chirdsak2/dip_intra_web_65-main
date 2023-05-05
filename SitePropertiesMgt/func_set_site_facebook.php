<?php
include("../EWT_ADMIN/comtop_pop.php");

$date = new DateTime();

$a_data = array_merge($_POST, $_FILES);
	

if($a_data['proc']=='Set_Site_Info'){
	
$s_data = array();

$s_data['site_embed_code']      = htmlentities($a_data['code'], ENT_QUOTES, "UTF-8");
$s_data['site_embed_status']    = $a_data['use_status'];



//$a_data['page_id_array'];
//for($i=0; $i<count($a_data['page_id_array']); $i++){
	
//$s_data['faq_cate_order']  = $i+1;
	
//update('faq_category',$s_data,array('faq_cate_id'=>$a_data['page_id_array'][$i]));
	
//}

update('site_info_embed',$s_data,array('site_embed_id'=>$a_data['embed_id']));
//insert('m_complain_info',$s_data);
							   
print_r($a_data);	

unset($a_data);
unset($s_data);

exit;
	} 
?>