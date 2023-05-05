<?php
include("../EWT_ADMIN/comtop_pop.php"); 
$a_data = array_merge($_POST, $_FILES); 
$proc = $a_data['proc']; 
//echo $c_num = count($a_data['calendar_invite']); 
//print_r($a_data); 
//exit();	  
function random_code($len)
{
	srand((double)microtime()*10000000);
	$chars = "ABCDEFGHJKMNPQRSTUVWXYZabcdefghijkmnpqrstuvwxyz123456789";
	$ret_str = "";
	$num = strlen($chars);
	for($i=0;$i<$len;$i++)
	{
		$ret_str .= $chars[rand()%$num]; 
	}
	return $ret_str;
}
	
switch($proc)    
{
	case "Edit_Emo": 

	if(is_array($a_data))   
	{	
	$s_data = array(); 

	$MAXIMUM_FILESIZE = sizeMB2byte(EwtMaxfile('img'));  
	$rEFileTypes = "/^\.(".ValidfileType('img')."){1}$/i";  
	$dir_base 	= "../ewt/".$_SESSION['EWT_SUSER']."/pic/";
	$dir_base1 	= "pic/";
	$dir_base2 	= "../ewt/".$_SESSION['EWT_SUSER']."/";	
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
		@chmod($dir_base1, 0777);
		$isMove = move_uploaded_file($_FILES['emotion_img']['tmp_name'],$dir_base.$newfile);		  
		if($isMove)
		{
			$a_images = $dir_base1.$newfile;
			if(file_exists($dir_base2.$a_data['emotion_img_old']) && $a_data['emotion_img_old'] != '') 
			{			
				unlink($dir_base2.$a_data['emotion_img_old']);			
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
		$a_images = $a_data['emotion_img_old'];    
	} 
		
	$s_data['emotion_name']   		=  $a_data['emotion_name']; 
	$s_data['emotion_character']   	=  $a_data['emotion_character'];
	$s_data['emotion_img']   		=  $a_images;
	$s_data['emotion_status']		=  $a_data['emotion_status'];

	
	$result = update('emotion',$s_data,array('emotion_id'=>$a_data['emo_id']));
	sys::save_log('update','webboard','แก้ไข emotion '.$a_data['emotion_character']);  	
	 								   
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