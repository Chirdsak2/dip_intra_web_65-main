<?php
include("../lib/include.php");
include("../lib/function.php");
include("../lib/user_config.php");
include("../lib/connect.php");
include("../lib/set_lang.php");

$date = new DateTime();

$a_data = array_merge($_POST, $_FILES);
	

if($a_data['proc']=='Add_Set_Page'){
	
$s_data = array();


$s_data['m_page_form']  = $a_data['com_form_id'];

//$a_data['page_id_array'];
//for($i=0; $i<count($a_data['page_id_array']); $i++){
	
//$s_data['faq_cate_order']  = $i+1;
	
update('m_complain_page',$s_data,array('m_page_id'=>$a_data['m_page_id']));
	
//}

//insert('m_complain_form_info',$s_data);
	
unset($a_data);
unset($s_data);

exit;
	} 
?>