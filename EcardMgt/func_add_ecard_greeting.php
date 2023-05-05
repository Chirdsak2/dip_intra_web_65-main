<?php
include("../EWT_ADMIN/comtop_pop.php"); 
$a_data = array_merge($_POST, $_FILES); 
$proc = $a_data['proc']; 

switch($proc)    
{
	case "Add_Greeting": 

	if(is_array($a_data))
	{	
	$s_data = array();
	$s_data['c_detail']		=  $a_data['c_detail'];
	$s_data['c_status']		=  $a_data['c_status'];
	$s_data['c_createdate'] =  datetimetool::getnow();
	$s_data['c_uid']       	=  $_SESSION['EWT_SMID'];
	$s_data['c_creater']   	=  $_SESSION["EWT_SMUSER"]; 
	$s_data['c_timestamp'] 	=  datetimetool::getnow(); 
	
	$result = insert('ecard_greeting',$s_data);
	sys::save_log('create','ecard','เพิ่มคำอวยพร  '.$s_data['c_detail']); 	 
	 								   
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