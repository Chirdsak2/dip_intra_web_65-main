<?php
include("../EWT_ADMIN/comtop_pop.php");

$date = new DateTime();

$a_data = array_merge($_POST, $_FILES);
	
if($a_data['proc']=='Add_Poll_Answer'){
	
$s_data = array();

$_max = countmax_wh('poll_ans','a_position','c_id='.$a_data['c_id']);

$s_data['c_id']       	 =  $a_data['c_id'];
$s_data['a_name']        =  $a_data['poll_ans_title'];
$s_data['a_counter']     =  '0';
$s_data['a_position']    =  $_max + 1;

//$a_data['page_id_array'];
//for($i=0; $i<count($a_data['page_id_array']); $i++){
	
//$s_data['faq_cate_order']  = $i+1;
	
//update('faq_category',$s_data,array('faq_cate_id'=>$a_data['page_id_array'][$i]));
	
//}

insert('poll_ans',$s_data);

//$_max = countmax('poll_cat','c_id');

$db->write_log("create","poll","เพิ่มคำตอบแบบสำรวจ ".$a_data['poll_ans_title']);	

//echo json_encode($_max);
echo json_encode($s_data);								   
//print_r($a_data);	
unset($a_data);
unset($s_data);

exit;
}else{ 

	$a_error['message'] = 'กรุณาใส่ให้ถูกต้อง';
	echo json_encode($a_error);
	unset($a_data);
	unset($s_data);
	exit;   
  
	} 
?>