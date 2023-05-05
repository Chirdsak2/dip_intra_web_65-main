<?php
include("../lib/include.php");
include("../lib/function.php");
include("../lib/user_config.php");
include("../lib/connect.php");
include("../lib/set_lang.php");

$date = new DateTime();

$a_data = array_merge($_POST, $_FILES);
	

if($a_data['proc']=='Sortable_Edit'){
	
del('m_complain_form_element','com_ele_fid='.$a_data['com_fid']);	

$s_data = array();

//$a_data['page_id_array'];
for($i=0; $i<count($a_data['page_id_array_form']); $i++){
	
$s_data['com_ele_fid']  = $a_data['com_fid'];
$s_data['com_ele_id']  = $a_data['page_id_array_form'][$i];
$s_data['com_ele_order']  = $i+1;
	
//update('faq_category',$s_data,array('faq_cate_id'=>$a_data['page_id_array'][$i]));

insert('m_complain_form_element',$s_data);	
}
							   
//print_r($s_data);	
echo json_encode($s_data);	
unset($a_data);
unset($s_data);

exit;
	} 
?>