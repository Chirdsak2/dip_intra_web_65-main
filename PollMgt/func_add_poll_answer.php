<?php
include("../EWT_ADMIN/comtop_pop.php");
$date = new DateTime();
$a_data = array_merge($_POST, $_FILES);
	
if($a_data['proc']=='Add_Poll_Answer'){
	
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
		$isMove = move_uploaded_file($_FILES['poll_images']['tmp_name'],$dir_base.$newfile);		  
	} 
		$a_images = $newfile;	
			///if(file_exists($dir_base.$a_data['lang_attach_old'][$n]) && $a_data['lang_attach_old'][$n] != ''){			
				//unlink($dir_base.$dir_file_old);			
				//}	
	}
	else
	{					
		$a_images = '';
				
	}
if($a_data['poll_ans_color'])
{
	$color = "#".$a_data['poll_ans_color'];
} 

$_max = countmax_wh('poll_ans','a_position','c_id='.$a_data['c_id']);

$s_data['c_id']       	=  	$a_data['c_id'];
$s_data['a_name']       =  	$a_data['poll_ans_title'];
$s_data['a_counter']    =  	'0';
$s_data['a_position']   =  	$_max + 1;
$s_data['a_images']    	= 	$a_images;
$s_data['a_color']    	= 	$color;

$result =  insert('poll_ans',$s_data);
//$_max = countmax('poll_cat','c_id');
$db->write_log("create","poll","เพิ่มคำตอบแบบสำรวจ ".$a_data['poll_ans_title']);	

//echo json_encode($_max);
echo json_encode($s_data);								   
//print_r($a_data);	
unset($a_data);
unset($s_data);

exit;
}else{ 

	$a_error['message'] = 'กรุณาใส่ให้ถูกต้อง';
	echo json_encode($a_error);
	unset($a_data);
	unset($s_data);
	exit;   
  
	} 
?>