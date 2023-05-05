<?php
include("../EWT_ADMIN/comtop_pop.php");

$date = new DateTime();

$a_data = array_merge($_POST, $_FILES);
	

if($a_data['proc']=='Set_Banner_Popup'){
	
$s_data = array();

$s_data['site_popup_name']      	=  $a_data['popup_name'];
$s_data['site_popup_code']      	=  $a_data['banner_pic'];
$s_data['site_popup_status']    	=  $a_data['use_status'];
$s_data['site_popup_createdate']    =  $date->format('Y-m-d H:i:s');
$s_data['site_popup_update']    	=  $date->format('Y-m-d H:i:s');

//$a_data['page_id_array'];
//for($i=0; $i<count($a_data['page_id_array']); $i++){	
//$s_data['faq_cate_order']  = $i+1;	
//update('faq_category',$s_data,array('faq_cate_id'=>$a_data['page_id_array'][$i]));	
//}

$_sql = $db->query("SELECT * FROM site_info_popup WHERE site_popup_name = '{$a_data['popup_name']}' ");
$a_rows = $db->db_num_rows($_sql);		

if($a_rows > 0){
update('site_info_popup',$s_data,array('site_popup_name'=>$a_data['popup_name']));
}else{
insert('site_info_popup',$s_data);
}						   
print_r($a_data);	

unset($a_data);
unset($s_data);

exit;
	} 
?>