<?php
include("../EWT_ADMIN/comtop_pop.php"); 
$a_data = array_merge($_POST, $_FILES); 
$proc = $a_data['proc']; 

switch($proc)    
{
	case "Edit_Greeting": 

	if(is_array($a_data))
	{	
	$s_data = array();
	$s_data['c_detail']		=  $a_data['c_detail'];
	$s_data['c_status']		=  $a_data['c_status']; 
	$s_data['c_update'] 	=  datetimetool::getnow(); 
	
	$result = update('ecard_greeting',$s_data,array('c_id'=>$a_data['c_id'])); 
	sys::save_log('create','ecard','แก้ไขคำอวยพร  '.$s_data['c_detail']); 	 
	 								   
	echo json_encode($s_data);		
	unset($a_data);
	unset($s_data);	
	exit; 	
	}  
	else
	{ 
		$a_error['message'] = 'กรุณาใส่ให้ถูกต้อง';
		echo json_encode($a_error);
		unset($a_data);
		unset($s_data);
		exit;   
	}  
	exit;	
break;	


} 
?>