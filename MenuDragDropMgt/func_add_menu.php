<?php
include("../EWT_ADMIN/comtop_pop.php"); 

$date = new DateTime();

$a_data = array_merge($_POST, $_FILES);
	

if($a_data['proc']=='Add_Menu'){
	
$s_data = array();

$s_data['m_name']	=	$a_data['menu_title'];
$s_data['m_show']	=	$a_data['menu_show'];


//$a_data['page_id_array'];
//for($i=0; $i<count($a_data['page_id_array']); $i++){
	
//$s_data['faq_cate_order']  = $i+1;
	
//update('faq_category',$s_data,array('faq_cate_id'=>$a_data['page_id_array'][$i]));
	
//}

insert('menu_list',$s_data);

$db->write_log("create","menu","เพิ่มเมนู ".$a_data['m_name']); 
	
$_max = countmax('menu_list','m_id');	
						   
echo($_max);	

unset($a_data);
unset($s_data);

exit;
	} 
?>