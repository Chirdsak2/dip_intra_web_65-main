<?php
include("../EWT_ADMIN/comtop_pop.php");
$date = new DateTime();
$a_data = array_merge($_POST, $_FILES);
$s_data = array();
$proc = $a_data['proc'];
 
switch($proc)    
{
	case "Add_Cate": 
	
	if($a_data['category_color'])
	{	
		$category_color = "#".$a_data['category_color'];
	}

	$s_data['cat_name']   	    =	$a_data['category_title'];
	$s_data['cat_color']	    =  	$category_color;
	$s_data['parent_cat_id'] 	=  	'';
	$s_data['webname_site']     =  	$_SESSION['EWT_SUSER'];
	$s_data['cat_type']      	=  	$a_data['category_type']; 
	$s_data['cat_manager']	    =   $a_data['calendar_manager'] == 0 ? null : $a_data['calendar_manager']; 

	insert('cal_category',$s_data);
	sys::save_log('create','calendar','เพิ่มหมวดปฏิทินกิจกรรม  '.$a_data['category_title']);  
						   
	//print_r($a_data);	

	echo json_encode($s_data);		
	//print_r($s_data);
	unset($a_data);
	unset($s_data);	
	//echo $a_data['lang_detail'][9];
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