<?php
include("../EWT_ADMIN/comtop_pop.php");

$date = new DateTime();

$a_data = array_merge($_POST, $_FILES);
	

if($a_data['proc']=='Add_Cate'){
	
$s_data = array();

$s_data['faq_cate_title'] =  $a_data['category_title'];
$s_data['faq_cate_detail'] =  $a_data['category_detail'];
$s_data['faq_cate_status'] = 'Y';
$s_data['faq_cate_parent'] = (!isset($a_data['category_parent']) ? '0' : $a_data['category_parent']);
$s_data['faq_cate_order'] = $a_data['category_order'];
$s_data['faq_cate_createdate'] = $date->format('Y-m-d H:i:s');
$s_data['faq_cate_update'] = $date->format('Y-m-d H:i:s');
$s_data['faq_cate_status_parent'] = (!isset($a_data['faq_cate_subcheck']) ? 'N' : $a_data['faq_cate_subcheck']);

insert('faq_category',$s_data);
							   
//print_r($a_data);	

unset($a_data);
unset($s_data);

exit;
} 
?>