<?php
include("../EWT_ADMIN/comtop_pop.php"); 
$a_data = array_merge($_POST, $_FILES);   
$proc = $a_data['proc']; 
//echo $c_num = count($a_data['calendar_invite']); 
//print_r($a_data); 
//exit();	  
switch($proc)    
{
	case "Edit_Ecard": 

	if(is_array($a_data)) 
	{	
	$s_data = array();

	$MAXIMUM_FILESIZE = sizeMB2byte(EwtMaxfile('img'));  
	$rEFileTypes = "/^\.(".ValidfileType('img')."){1}$/i";  
	$dir_base = "../ewt/".$_SESSION['EWT_SUSER']."/assets/images/ecard/";
	$dir_base1 = "../ewt/".$_SESSION['EWT_SUSER']."/assets/images/ecard";	
	
	$isFile = is_uploaded_file($_FILES['ec_images']['tmp_name']);  	
	if($isFile)
	{    //  do we have a file? 
    $safe_filename = preg_replace( 
                     array("/\s+/", "/[^-\.\w]+/"), 
                     array("_", ""), 
                     trim($_FILES['ec_images']['name']));
					 
	$type_file =  strrchr($safe_filename, '.');				 
	$newfile   = "ecard_ec_images_".date("YmdHis").$type_file;	 
    if($_FILES['ec_images']['size'] <= $MAXIMUM_FILESIZE && preg_match($rEFileTypes, strrchr($safe_filename , '.'))) 
	{	
		@chmod($dir_base1, 0777);
		$isMove = move_uploaded_file($_FILES['ec_images']['tmp_name'],$dir_base.$newfile);		  
		if($isMove)
		{
			$a_images = $newfile;	
			if(file_exists($dir_base.$a_data['ec_images_old']) && $a_data['ec_images_old'] != '')
			{			
				unlink($dir_base.$a_data['ec_images_old']);			
			}
			$a_size = $_FILES['ec_images']['size'];
		}
	}
	else
	{
			$a_images = '';	
			$a_size   = $a_data['ec_filesize'];	
		}		
	}
	else
	{					
		$a_images = $a_data['ec_images_old'];  
		$a_size   = $a_data['ec_filesize'];	
	} 
		
	$s_data['ec_name']		=  $a_data['ec_name']; 
	$s_data['ec_filename']	=  $a_images;
	$s_data['ec_filesize']	=  $a_size;
	$s_data['ec_filetype']	=  ''; 
	$s_data['ec_fileext']	=  '';
	$s_data['ec_detail']	=  $a_data['ec_detail'];
	$s_data['ec_status']	=  $a_data['ec_status'];
	$s_data['ec_update']	=  datetimetool::getnow(); 
	
	$result = update('ecard_list',$s_data,array('ec_id'=>$a_data['ec_id']));
	sys::save_log('update','ecard','แก้ไขการ์ดอวยพร  '.$s_data['ec_name']); 	
	 								   
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