<?php
include("../EWT_ADMIN/comtop_pop.php"); 
$a_data = array_merge($_POST, $_FILES); 
$proc = $a_data['proc']; 
//echo $c_num = count($a_data['calendar_invite']); 
//print_r($a_data); 
//exit();	  
 
switch($proc)     
{
	case "Edit_Vul": 

	if(is_array($a_data))   
	{	
	$s_data = array(); 
	
	$s_data['vulgar_text']   	=  $a_data['vulgar_text']; 
	$s_data['vulgar_status']   	=  $a_data['vulgar_status'];
	$s_data['ip_add']			=  $a_data['ip_add'];

	
	$result = update('w_vulgar',$s_data,array('vulgar_id'=>$a_data['vul_id']));
	sys::save_log('update','webboard','แก้ไข คำที่ไม่สุภาพ/โฆษณา '.$a_data['vulgar_text']);  	
	 								   
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