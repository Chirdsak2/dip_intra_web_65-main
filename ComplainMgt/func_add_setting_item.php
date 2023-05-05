<?php
include("../lib/include.php");
include("../lib/function.php");
include("../lib/user_config.php");
include("../lib/connect.php");
include("../lib/set_lang.php");

$date = new DateTime();

$a_data = array_merge($_POST, $_FILES);
	

if($a_data['proc']=='Add_Set_Item'){
	
$s_data = array();

del('m_complain_form_info','com_ele_fid='.$a_data['com_fid'].' AND com_ele_id='.$a_data['com_eid'].'');	

$s_data['com_ele_fid']  = $a_data['com_fid'];
$s_data['com_ele_id']  = $a_data['com_eid'];
$s_data['com_info_label']  = $a_data['complain_label'];
$s_data['com_info_help']  = $a_data['complain_help'];
$s_data['com_info_required']  = $a_data['complain_required'];


//$a_data['page_id_array'];
//for($i=0; $i<count($a_data['page_id_array']); $i++){
	
//$s_data['faq_cate_order']  = $i+1;
	
//update('faq_category',$s_data,array('faq_cate_id'=>$a_data['page_id_array'][$i]));
	
//}

insert('m_complain_form_info',$s_data);
	
unset($a_data);
unset($s_data);

exit;
	} 
?>