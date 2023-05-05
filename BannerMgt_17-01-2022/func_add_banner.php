<?php
include("../EWT_ADMIN/comtop_pop.php");

$date = new DateTime();

$a_data = array_merge($_POST, $_FILES);

if($a_data['proc']=='Add_Banner'){
	
$s_data = array();

$MAXIMUM_FILESIZE = sizeMB2byte(EwtMaxfile('img')); 
$rEFileTypes = "/^\.(".ValidfileType('img')."){1}$/i"; 
$dir_base = "../ewt/".$_SESSION['EWT_SUSER']."/images/banner/";
$dir_base1 = "images/banner/";	

	$isFile = is_uploaded_file($_FILES['banner_pic']['tmp_name']); 	
	if($isFile){    //  do we have a file? 
    $safe_filename = preg_replace( 
                     array("/\s+/", "/[^-\.\w]+/"), 
                     array("_", ""), 
                     trim($_FILES['banner_pic']['name']));
					 
	$type_file =  strrchr($safe_filename, '.');				 
	$newfile   = "banner_image_".date("YmdHis").$type_file;	 
    if ($_FILES['banner_pic']['size'] <= $MAXIMUM_FILESIZE && preg_match($rEFileTypes, strrchr($safe_filename , '.'))) {		
		  $isMove = move_uploaded_file ($_FILES['banner_pic']['tmp_name'],$dir_base.$newfile);		  
		  } 
			$a_attach = $dir_base1.$newfile;	
			///if(file_exists($dir_base.$a_data['lang_attach_old'][$n]) && $a_data['lang_attach_old'][$n] != ''){			
				//unlink($dir_base.$dir_file_old);			
				//}	
				}else{					
					$a_attach = '';
				}
				

$s_data['banner_name']   =  stripslashes(htmlspecialchars($a_data['banner_name'],ENT_QUOTES)); 
$s_data['banner_detail'] =  stripslashes(htmlspecialchars($a_data['banner_detail'],ENT_QUOTES));  
$s_data['banner_pic']    =  $a_attach;
$s_data['banner_link']   =  $a_data['banner_link'];
$s_data['banner_show']   =  'no';
$s_data['banner_update'] =  $date->format('Y-m-d H:i:s');
$s_data['banner_create'] =  $date->format('Y-m-d H:i:s');
$s_data['banner_traget'] =  $a_data['banner_traget'];
$s_data['banner_alt']    =  $a_data['banner_alt'];
$s_data['banner_gid']    =  $a_data['banner_category'];
$s_data['banner_uid']    =  $_SESSION["EWT_SUID"];
$s_data['banner_uname']  =  $_SESSION["EWT_SUSER"];
$s_data['banner_ip']     =  getIP();
$s_data['banner_show_start'] = $a_data['start_date'];
$s_data['banner_show_end']   = $a_data['end_date'];


insert('banner',$s_data);

$db->write_log("create","banner","เพิ่ม  banner ".$a_data['banner_name']);	
						   
//print_r($a_data);	
echo json_encode($s_data);	
unset($a_data);
unset($s_data);

exit;
} 
?>