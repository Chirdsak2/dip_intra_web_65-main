<?php
include("../EWT_ADMIN/comtop_pop.php");

$a_data = array_merge($_POST, $_FILES);

if($a_data['proc']=='Edit_Webboard_Main'){
	$c_id = $a_data['c_id'];
	$c_name = $a_data['c_name'];
	$c_detail = $a_data['c_detail'];
	$c_use = empty($a_data['c_use']) ? "N" : "Y";
	$db->query("UPDATE w_cate SET c_name='$c_name', c_detail='$c_detail', c_use='$c_use' WHERE c_id='$c_id'");
	sys::save_log('update', 'webboard', 'แก้ไขหมวดกระทู้' . $c_name);
	echo json_encode($a_data);								   
	//print_r($a_data);	
	unset($a_data);
	//unset($s_data);

	exit;
}
else{ 
	$a_error['message'] = 'กรุณาใส่ให้ถูกต้อง';
	echo json_encode($a_error);
	unset($a_data);
	//unset($s_data);
	exit;   
  
	} 
?>