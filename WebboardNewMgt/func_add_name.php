<?php
include("../EWT_ADMIN/comtop_pop.php");

$a_data = array_merge($_POST, $_FILES);

if($a_data['proc']=='Add_Name'){
	
	$db->query("INSERT INTO w_name (w_name,w_status) VALUES ('$a_data[no_name]','0')");

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