<?php
include("../EWT_ADMIN/comtop_pop.php"); 
$a_data = array_merge($_POST, $_FILES); 
$proc = $a_data['proc']; 
//echo $c_num = count($a_data['calendar_invite']); 
//print_r($a_data); 
//exit();	  
switch($proc)    
{
	case "Edit_Manager": 

	if(is_array($a_data)) 
	{	
	$s_data = array();

	$MAXIMUM_FILESIZE = sizeMB2byte(EwtMaxfile('img'));  
	$rEFileTypes = "/^\.(".ValidfileType('img')."){1}$/i";  
	$dir_base = "../ewt/".$_SESSION['EWT_SUSER']."/assets/images/calendar/";
	$dir_base1 = "../ewt/".$_SESSION['EWT_SUSER']."/assets/images/calendar";	
	
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
		@chmod($dir_base1, 0777);
		$isMove = move_uploaded_file($_FILES['m_images']['tmp_name'],$dir_base.$newfile);		  
		if($isMove)
		{
			$a_images = $newfile;	
			if(file_exists($dir_base.$a_data['m_images_old']) && $a_data['m_images_old'] != '')
			{			
				unlink($dir_base.$a_data['m_images_old']);			
			}
		}
	}
	else
	{
			$a_images = '';	
		}		
	}
	else
	{					
		$a_images = $a_data['m_images_old'];    
	} 
		
	$s_data['m_name']   	=  $a_data['m_name']; 
	$s_data['m_surname']   	=  $a_data['m_surname'];
	$s_data['m_pos']   	   	=  $a_data['m_pos'];
	$s_data['m_images']   	=  $a_images;
	$s_data['m_status']		=  $a_data['m_status'];
	$s_data['m_lastupdate'] =  datetimetool::getnow();
	
	$result = update('cal_manager',$s_data,array('m_id'=>$a_data['m_id']));
	sys::save_log('update','calendar','แก้ไขข้อมูลผู้บริหาร  '.$s_data['m_name'].' '.$s_data['m_surname']); 	
	 								   
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