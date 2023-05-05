<?php
include("../EWT_ADMIN/comtop_pop.php");
$date = new DateTime();
$a_data = array_merge($_POST, $_FILES);
	
if($a_data['proc']=='Edit_Poll_Answer'){
	
$s_data = array();

$MAXIMUM_FILESIZE = sizeMB2byte(EwtMaxfile('img')); 
$rEFileTypes = "/^\.(".ValidfileType('img')."){1}$/i"; 

$dir_base = "../ewt/".$_SESSION['EWT_SUSER']."/download/poll/";	 


	$isFile = is_uploaded_file($_FILES['poll_images']['tmp_name']); 	
	if($isFile)
	{    //  do we have a file? 
    $safe_filename = preg_replace( 
                     array("/\s+/", "/[^-\.\w]+/"), 
                     array("_", ""), 
                     trim($_FILES['poll_images']['name']));
					 
	$type_file =  strrchr($safe_filename, '.');				 
	$newfile   = "poll_images_".date("YmdHis").$type_file;	 
    if($_FILES['poll_images']['size'] <= $MAXIMUM_FILESIZE && preg_match($rEFileTypes, strrchr($safe_filename , '.'))) 
	{		
		  $isMove = move_uploaded_file ($_FILES['poll_images']['tmp_name'],$dir_base.$newfile);		  
	} 
			$a_images = $newfile;	
			if(file_exists($dir_base.$a_data['a_images_old']) && $a_data['a_images_old'] != '')
			{			
				unlink($dir_base.$a_data['a_images_old']); 			
			}	
	}
	else
	{					
		$a_images = $a_data['a_images_old'];
	}
	
if($a_data['poll_ans_color'])
{
	$color = "#".$a_data['poll_ans_color'];
}
	$s_data['a_name']       =	$a_data['poll_ans_title'];
	$s_data['a_images']    	= 	$a_images;
	$s_data['a_color']    	= 	$color;
	
	$result =  update('poll_ans',$s_data,array('a_id'=>$a_data['a_id']));

	$db->write_log("upadte","poll","แก้ไขคำตอบแบบสำรวจ ".$a_data['poll_ans_title']);	

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
?>