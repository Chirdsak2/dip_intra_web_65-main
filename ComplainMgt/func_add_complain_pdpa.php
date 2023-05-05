<?php
include("../EWT_ADMIN/comtop_pop.php");

$date = new DateTime();

$a_data = array_merge($_POST, $_FILES);
	

if($a_data['proc']=='Add_Pdpa'){
	
$s_data = array();

$MAXIMUM_FILESIZE = sizeMB2byte(EwtMaxfile('file')); 
$rEFileTypes = "/^\.(".ValidfileType('file')."){1}$/i"; 
$dir_base = "../ewt/".$_SESSION['EWT_SUSER']."/download/";	

	$isFile = is_uploaded_file($_FILES['pdpa_file']['tmp_name']); 	
	if($isFile)
	{    //  do we have a file? 
    $safe_filename = preg_replace( 
                     array("/\s+/", "/[^-\.\w]+/"), 
                     array("_", ""), 
                     trim($_FILES['pdpa_file']['name']));
					 
	$type_file =  strrchr($safe_filename, '.');				 
	$newfile   = "pdpa_file_".date("YmdHis").$type_file;	 
    if($_FILES['pdpa_file']['size'] <= $MAXIMUM_FILESIZE && preg_match($rEFileTypes, strrchr($safe_filename , '.'))) 
	{		
		$isMove = move_uploaded_file($_FILES['pdpa_file']['tmp_name'],$dir_base.$newfile);		  
	} 
		$a_attach = $newfile;	
			///if(file_exists($dir_base.$a_data['lang_attach_old'][$n]) && $a_data['lang_attach_old'][$n] != ''){			
				//unlink($dir_base.$dir_file_old);			
				//}	
	}
	else
	{					
		$a_attach = '';
				
	}



$s_data['pdpa_detail']  = $a_data['pdpa_detail'];
$s_data['pdpa_status']  = $a_data['pdpa_status'];
$s_data['pdpa_checkbox']  = $a_data['pdpa_checkbox'];
$s_data['pdpa_file']  	= $a_attach;



$result = insert('m_complain_pdpa',$s_data); 
//$db->write_log("create","calendar","เพิ่มปฏิทินกิจกรรม ".$a_data['calendar_title']);			
						   
print_r($result);	

unset($a_data);
unset($s_data);

exit;
	} 
?>