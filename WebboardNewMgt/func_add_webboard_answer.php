<?php
include("../EWT_ADMIN/comtop_pop.php");

$a_data = array_merge($_POST, $_FILES); 
$proc = $a_data['proc']; 
//echo $c_num = count($a_data['calendar_invite']); 
//print_r($a_data); 
//exit();	  
switch($proc)    
{
	case "Add_Manager": 

	if(is_array($a_data))
	{	
	$s_data = array();

	$MAXIMUM_FILESIZE = sizeMB2byte(EwtMaxfile('img'));  
	$rEFileTypes = "/^\.(".ValidfileType('img')."){1}$/i"; 
	$dir_base = "../ewt/".$_SESSION['EWT_SUSER']."/assets/images/calendar/";
	$dir_base1 = "";	

	$isFile = is_uploaded_file($_FILES['m_images']['tmp_name']); 	
	if($isFile)
	{    //  do we have a file? 
    $safe_filename = preg_replace( 
                     array("/\s+/", "/[^-\.\w]+/"), 
                     array("_", ""), 
                     trim($_FILES['m_images']['name']));
					 
	$type_file =  strrchr($safe_filename, '.');				 
	$newfile   = "calendar_m_images_".date("YmdHis").$type_file;	 
    if($_FILES['m_images']['size'] <= $MAXIMUM_FILESIZE && preg_match($rEFileTypes, strrchr($safe_filename , '.'))) 
	{		
		$isMove = move_uploaded_file ($_FILES['m_images']['tmp_name'],$dir_base.$newfile);		  
	} 
		$a_images = $dir_base1.$newfile;	
			///if(file_exists($dir_base.$a_data['lang_attach_old'][$n]) && $a_data['lang_attach_old'][$n] != ''){			
				//unlink($dir_base.$dir_file_old);			
				//}	
	}
	else
	{					
		$a_images = '';   
	} 
		
	$s_data['m_name']   	=  $a_data['m_name'];
	$s_data['m_surname']   	=  $a_data['m_surname'];
	$s_data['m_pos']   	   	=  $a_data['m_pos'];
	$s_data['m_images']   	=  $a_images;
	$s_data['m_status']		=  $a_data['m_status'];
	$s_data['m_createdate'] =  datetimetool::getnow();
	$s_data['m_uid']       	=  $_SESSION['EWT_SMID'];
	$s_data['m_creater']   	=  $_SESSION["EWT_SMUSER"]; 
	$s_data['m_timestamp'] 	=  datetimetool::getnow();
	
	$result = insert('cal_manager',$s_data);
	sys::save_log('create','calendar','เพิ่มผู้บริหาร  '.$s_data['m_name'].' '.$s_data['m_surname']); 	
	 								   
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

	case "Add_Answer": 

	if(is_array($a_data))
	{	
	$s_data = array();

	$s_data['t_id']   =  	$a_data['tid'];
	$s_data['a_detail'] =  	$a_data['a_name'];
	$s_data['a_date']   =	datetimetool::getnow();
	$s_data['a_time']	=  	datetimetool::getnow();
	$s_data['a_ip']		=  	getIP();
	$s_data['a_picture']	=  	'';	
	$s_data['s_id']		=  	$a_data['a_status'];	
	$s_data['a_name']		=  	$_SESSION["EWT_SMUSER"];
	$s_data['a_email']		=  	'';
	$s_data['a_attact']		=  	'';	
	
	//$s_data['c_createdate'] =  	datetimetool::getnow();
	//$s_data['c_uid']       	=  	$_SESSION['EWT_SMID'];
	//$s_data['c_creater']   	=  	$_SESSION["EWT_SMUSER"]; 
	//$s_data['c_timestamp'] 	=  	datetimetool::getnow();   
	
	$result = insert('w_answer',$s_data);
	sys::save_log('create','webboard','เพิ่มความคิดเห็น '.$a_data['a_name']); 	
	
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