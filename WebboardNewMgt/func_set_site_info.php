<?php
include("../EWT_ADMIN/comtop_pop.php");

$date = new DateTime();

$a_data = array_merge($_POST, $_FILES);
	

if($a_data['proc']=='Set_Site_Info'){
	
$s_data = array();


$s_data['site_info_title']        = $a_data['txt_title'];
$s_data['site_info_keyword']      = $a_data['txt_keyword'];
$s_data['site_info_description']  = $a_data['txt_desc'];
$s_data['site_info_max_img']      = $a_data['txt_max_Img'];
$s_data['site_type_img_file']     = $a_data['type_img_file'];
$s_data['site_info_max_file']     = $a_data['txt_max_file'];
$s_data['site_type_file']         = $a_data['type_file'];
$s_data['site_info_max_vdo']      = $a_data['txt_max_vdo'];
$s_data['site_type_vdo_file']     = $a_data['type_vdo_file'];
//$a_data['page_id_array'];
//for($i=0; $i<count($a_data['page_id_array']); $i++){
	
//$s_data['faq_cate_order']  = $i+1;
	
//update('faq_category',$s_data,array('faq_cate_id'=>$a_data['page_id_array'][$i]));
	
//}

update('site_info',$s_data,array('site_info_id'=>$a_data['site_info_id']));
//insert('m_complain_info',$s_data);
							   
print_r($a_data);	

unset($a_data);
unset($s_data);

exit;
	} 
?>