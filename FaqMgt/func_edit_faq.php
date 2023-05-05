<?php
include("../EWT_ADMIN/comtop_pop.php");

$date = new DateTime();

$a_data = array_merge($_POST, $_FILES);

print_r($a_data);

if($a_data['proc']=='Edit_Faq'){
	
$s_data = array();

$s_data['fa_name']        =  $a_data['faq_title'];
$s_data['fa_detail']      =  $a_data['faq_detail'];
$s_data['fa_ans']         =  $a_data['faq_answer'];
$s_data['f_sub_id']       =  $a_data['faq_category'];
$s_data['faq_top'] 		  =  $a_data['faq_interesting'];
$s_data['faq_use']		  =  $a_data['faq_show'];

update('faq',$s_data,array('fa_id'=>$a_data['fa_id']));		
	
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
//echo json_encode($s_data);		
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