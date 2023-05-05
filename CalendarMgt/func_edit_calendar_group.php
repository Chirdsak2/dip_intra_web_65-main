<?php
include("../EWT_ADMIN/comtop_pop.php");
$date = new DateTime();
$a_data = array_merge($_POST, $_FILES);
$s_data = array();
$proc = $a_data['proc'];	

switch($proc)    
{
	case "Edit_Cate": 

	if($a_data['category_color']){
	
	$category_color = "#".$a_data['category_color'];
	}

	$s_data['cat_name']   	    =	$a_data['category_title'];
	$s_data['cat_color']	    =  	$category_color;
	$s_data['parent_cat_id'] 	=  	'';


	update('cal_category',$s_data,array('cat_id'=>$a_data['cat_id']));
	sys::save_log('update','calendar','แก้ไขหมวดปฏิทินกิจกรรม  '.$a_data['category_title']); 

	echo json_encode($s_data);	 	
	//print_r($s_data);
	unset($a_data);
	unset($s_data);	
		exit;	
	break;	  

	case "": 
	
	$a_error['message'] = 'กรุณาใส่ให้ถูกต้อง';
	echo json_encode($a_error);
	unset($a_data);
	unset($s_data);
		exit;	
	break;	   
} 
?>