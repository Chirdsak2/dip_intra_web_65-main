<?php
include("../EWT_ADMIN/comtop_pop.php"); 
$a_data = array_merge($_POST, $_FILES); 
$proc = $a_data['proc']; 

switch($proc)    
{
	case "Add_Ecard": 

	if(is_array($a_data))
	{	
	$s_data = array();
	
	$MAXIMUM_FILESIZE = sizeMB2byte(EwtMaxfile('img'));  
	$rEFileTypes = "/^\.(".ValidfileType('img')."){1}$/i"; 
	$dir_base = "../ewt/".$_SESSION['EWT_SUSER']."/assets/images/ecard/";
	$dir_base1 = "";	

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
		$isMove = move_uploaded_file ($_FILES['ec_images']['tmp_name'],$dir_base.$newfile);		  
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
	
	
	$s_data['ec_name']		=  $a_data['ec_name']; 
	$s_data['ec_filename']	=  $a_images;
	$s_data['ec_filesize']	=  $_FILES['ec_images']['size'];
	$s_data['ec_filetype']	=  ''; 
	$s_data['ec_fileext']	=  '';
	$s_data['ec_detail']	=  $a_data['ec_detail'];
	$s_data['ec_status']	=  $a_data['ec_status'];
	$s_data['ec_createdate']=  datetimetool::getnow();
	$s_data['ec_uid']       =  $_SESSION['EWT_SMID'];
	$s_data['ec_creater']   =  $_SESSION["EWT_SMUSER"]; 
	$s_data['ec_timestamp'] =  datetimetool::getnow(); 
	
	$result = insert('ecard_list',$s_data);
	sys::save_log('create','ecard','เพิ่มการ์ดอวยพร  '.$s_data['ec_name']); 	 
	 								   
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