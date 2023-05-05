<?php
include("../EWT_ADMIN/comtop_pop.php");

$a_data = array_merge($_POST, $_FILES);

if($a_data['proc']=='Edit_Name'){
	
	$db->query("UPDATE w_name SET w_name='$a_data[no_name]' WHERE w_name_id='$a_data[w_name_id]'");

	//echo json_encode($a_data);								   
	//print_r($a_data);	
	//unset($a_data);
	//unset($s_data);

	exit;
}
else{ 

	//$a_error['message'] = 'กรุณาใส่ให้ถูกต้อง';
	//echo json_encode($a_error);
	//unset($a_data);
	//unset($s_data);
	exit;   
  
	} 
?>