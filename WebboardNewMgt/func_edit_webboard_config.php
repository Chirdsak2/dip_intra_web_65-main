<?php
include("../EWT_ADMIN/comtop_pop.php"); 
$a_data = array_merge($_POST, $_FILES); 
$proc = $a_data['proc']; 
//echo $c_num = count($a_data['calendar_invite']); 
//print_r($a_data); 
//exit();	  

switch($proc)    
{
	case "Edit_Config": 

	if(is_array($a_data))    
	{
		
	$s_data = array(); 

	$s_data['c_approve']   		=  $a_data['c_approve']; 
	$s_data['c_showip']   		=  $a_data['c_showip'];
	$s_data['c_show_question']  =  $a_data['c_show_question'];
	$s_data['c_show_answer']   	=  $a_data['c_show_answer'];
	$s_data['c_show_webb_name'] =  $a_data['c_show_webb_name'];
	
	$result = update('w_config',$s_data,array('c_config'=>'1'));
	sys::save_log('update','webboard','แก้ไข ตั้งค่าเว็บบอร์ด ');  	
	 								   
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