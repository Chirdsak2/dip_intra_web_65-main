<?php
include("../EWT_ADMIN/comtop_pop.php");

$date = new DateTime();

$a_data = array_merge($_POST, $_FILES);
	

if($a_data['proc']=='Edit_Cate'){
	
$s_data = array();

if(!empty($_FILES['vdog_img']['tmp_name'])){

$MAXIMUM_FILESIZE = sizeMB2byte(EwtMaxfile('img')); 
//  Valid file extensions (images, word, excel, powerpoint) 
$rEFileTypes = "/^\.(".ValidfileType('img')."){1}$/i"; 
$dir_base = "../ewt/".$_SESSION["EWT_SUSER"]."/download/file_vdo/";

$isFile = is_uploaded_file($_FILES['vdog_img']['tmp_name']); 
if ($isFile){    //  do we have a file? 
   //  sanatize file name 
    //     - remove extra spaces/convert to _, 
    //     - remove non 0-9a-Z._- characters, 
    //     - remove leading/trailing spaces 
    //  check if under 5MB, 
    //  check file extension for legal file types 
    $safe_filename = preg_replace( 
                     array("/\s+/", "/[^-\.\w]+/"), 
                     array("_", ""), 
                     trim($_FILES['vdog_img']['name']));
					 
	$type_file =  strrchr($safe_filename, '.');				 
	$newfile = 'vdog_img_'.date("YmdHis").$type_file;
	 
    if ($_FILES['vdog_img']['size'] <= $MAXIMUM_FILESIZE && preg_match($rEFileTypes, strrchr($safe_filename, '.'))) {	
		  $isMove = move_uploaded_file ($_FILES['vdog_img']['tmp_name'],$dir_base.$newfile);
		  } 
	$fileattach = $newfile;
      }else{
		  $fileattach = "";		  	  
	  }

}else{
	
	$fileattach = $a_data['vdog_image_old'];
}



$s_data['vdog_name']         =  $a_data['vdog_name'];
$s_data['vdog_info']         =  $a_data['vdog_info'];
$s_data['vdog_update']       =  $date->format('Y-m-d H:i:s');
$s_data['vdog_image']        =  $fileattach;

update('vdo_group',$s_data,array('vdog_id'=>$a_data['vdog_cid']));
//insert('vdo_group',$s_data);
$db->write_log("update","vdo","แก้ไขหมวด vdo ".$a_data["vdog_name"]);		
					   
echo json_encode($a_data);

unset($a_data);
unset($s_data);

exit;
} 
?>