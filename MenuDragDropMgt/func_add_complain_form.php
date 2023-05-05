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

$s_data['com_form_type']  = $a_data['com_form_type'];
$s_data['com_form_title']  = $a_data['com_form_title'];
$s_data['com_form_createdate']  = $date->format('Y-m-d H:i:s');
$s_data['com_form_update']  = $date->format('Y-m-d H:i:s');
$s_data['com_form_status']  = 'Y';
$s_data['com_form_comid']  = $a_data['complain_category'];


//$a_data['page_id_array'];
//for($i=0; $i<count($a_data['page_id_array']); $i++){
	
//$s_data['faq_cate_order']  = $i+1;
	
//update('faq_category',$s_data,array('faq_cate_id'=>$a_data['page_id_array'][$i]));
	
//}

insert('m_complain_form',$s_data);
	
$_max = countmax('m_complain_form','com_form_id');	
						   
echo($_max);	

unset($a_data);
unset($s_data);

exit;
	} 
?>