<?php
include("../EWT_ADMIN/comtop_pop.php");

$date = new DateTime();

$a_data = array_merge($_POST, $_FILES);


if($a_data['proc']=='Edit_Banner'){
	
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
	// && preg_match($rEFileTypes, strrchr($safe_filename , '.'))
    if ($_FILES['banner_pic']['size'] <= $MAXIMUM_FILESIZE) {		
		  $isMove = move_uploaded_file ($_FILES['banner_pic']['tmp_name'],$dir_base.$newfile);		  
		  } 
			$a_attach = $dir_base1.$newfile;	
			if(file_exists($dir_base.$a_data['banner_pic_old']) && $a_data['banner_pic_old'] != ''){			
				unlink($dir_base.$a_data['banner_pic_old']);			
				}	
				}else{					
					$a_attach = $a_data['banner_pic_old'];
				}
				

$s_data['banner_name']   =  $a_data['banner_name'];
$s_data['banner_detail'] =  $a_data['banner_detail'];
$s_data['banner_pic']    =  $a_attach;
$s_data['banner_link']   =  $a_data['banner_link'];
$s_data['banner_update'] =  $date->format('Y-m-d H:i:s');
$s_data['banner_traget'] =  $a_data['banner_traget'];
$s_data['banner_alt']    =  $a_data['banner_alt'];
$s_data['banner_uid']    =  $_SESSION["EWT_SUID"];
$s_data['banner_uname']  =  $_SESSION["EWT_SUSER"];
$s_data['banner_ip']     =  getIP();
$s_data['banner_show_start'] = $a_data['start_date'];
$s_data['banner_show_end']   = $a_data['end_date'];

update('banner',$s_data,array('banner_id'=>$a_data['banner_id']));	

$db->write_log("update","banner","แก้ไข  banner ".$a_data["banner_name"]);	
	
/*$MAXIMUM_FILESIZE = 10 * 1024 * 1024; 
//  Valid file extensions (images, word, excel, powerpoint) 
$rEFileTypes = "/^\.(mp4){1}$/i"; 
$dir_base = "files/"; 
$isFile = is_uploaded_file($_FILES['filebrowse']['tmp_name']); 
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
                     trim($_FILES['filebrowse']['name']));
					 
	$type_file =  strrchr($safe_filename, '.');				 
	$newfile = "article_".date("YmdHis")."_".$a_data['lang_name'].$type_file;	 
    if ($_FILES['filebrowse']['size'] <= $MAXIMUM_FILESIZE ) {		
		  $isMove = move_uploaded_file ($_FILES['filebrowse']['tmp_name'],$Current_Dir2.$newfile);		  
		  } 
	$a_data['lang_detail'][9] = $Current_Dir3.$newfile;
    }	
	
	$a_data['lang_detail'][10] = $a_data['browsefile'];	
		
			}
		}*/	
echo json_encode($s_data);		
//print_r($s_data);
unset($a_data);
unset($s_data);	
//echo $a_data['lang_detail'][9];
	exit;   
}else{ 
  $a_error['message'] = 'กรุณาใส่ให้ถูกต้อง';
  echo json_encode($a_error);
	unset($a_data);
	unset($s_data);
  exit;   
  }
?>