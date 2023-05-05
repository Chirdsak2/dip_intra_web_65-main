<?php
include("../lib/include.php");
include("../lib/function.php");
include("../lib/user_config.php");
include("../lib/connect.php");
include("../lib/set_lang.php");

$date = new DateTime();

$a_data = array_merge($_POST, $_FILES);
	

if($a_data['proc']=='Add_Cate'){
	
$s_data = array();


$s_data['Complain_lead_name']  = $a_data['category_title'];
$s_data['Complain_lead_email']  = $a_data['category_email'];
$s_data['Complain_lead_status']  = '';
//$a_data['page_id_array'];
//for($i=0; $i<count($a_data['page_id_array']); $i++){
	
//$s_data['faq_cate_order']  = $i+1;
	
//update('faq_category',$s_data,array('faq_cate_id'=>$a_data['page_id_array'][$i]));
	
//}

insert('m_complain_info',$s_data);
							   
print_r($a_data);	

unset($a_data);
unset($s_data);

exit;
	} 
?>