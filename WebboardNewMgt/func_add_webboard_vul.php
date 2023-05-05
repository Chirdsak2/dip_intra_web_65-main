<?php
include("../EWT_ADMIN/comtop_pop.php");

$a_data = array_merge($_POST, $_FILES); 
$proc = $a_data['proc']; 
//echo $c_num = count($a_data['calendar_invite']); 
//print_r($a_data); 
//exit();
  
switch($proc)    
{
	case "Add_Emo": 

	if(is_array($a_data))
	{	
	$s_data = array();

	$MAXIMUM_FILESIZE = sizeMB2byte(EwtMaxfile('img'));  
	$rEFileTypes = "/^\.(".ValidfileType('img')."){1}$/i"; 
	$dir_base = "../ewt/".$_SESSION['EWT_SUSER']."/pic/";
	$dir_base1 = "pic/";	
	$picname 	= 	random_code(20);

	$isFile = is_uploaded_file($_FILES['emotion_img']['tmp_name']); 	
	if($isFile)
	{    //  do we have a file? 
    $safe_filename = preg_replace( 
                     array("/\s+/", "/[^-\.\w]+/"), 
                     array("_", ""), 
                     trim($_FILES['emotion_img']['name']));
					 
	$type_file =  strrchr($safe_filename, '.');				 
	$newfile   = "wb".$picname.date("YmdHis").$type_file;	 
    if($_FILES['emotion_img']['size'] <= $MAXIMUM_FILESIZE && preg_match($rEFileTypes, strrchr($safe_filename , '.'))) 
	{		
		$isMove = move_uploaded_file($_FILES['emotion_img']['tmp_name'],$dir_base.$newfile);	 	  
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
		
	$s_data['emotion_name']   		=  $a_data['emotion_name'];
	$s_data['emotion_character']   	=  $a_data['emotion_character'];
	$s_data['emotion_img']   		=  $a_images;
	$s_data['emotion_status']		=  $a_data['emotion_status']; 
	
	$result = insert('emotion',$s_data);
	sys::save_log('create','webboard','เพิ่ม emotion '.$a_data['emotion_character']); 	
	 								   
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

	case "Add_Vul": 

	if(is_array($a_data))
	{	
	$s_data = array();

	$s_data['vulgar_text']   	=  	$a_data['vulgar_text'];
	$s_data['vulgar_status']   	=  	$a_data['vulgar_status'];
	$s_data['ip_add']   		=  	$a_data['ip_add'];  

	$result = insert('w_vulgar',$s_data);
	sys::save_log('create','webboard','เพิ่มคำที่ไม่สุภาพ/โฆษณา  '.$a_data['vulgar_text']); 	 
	
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