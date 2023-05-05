<?php
include("../EWT_ADMIN/comtop_pop.php");

$date = new DateTime();

$a_data = array_merge($_POST, $_FILES);
	

if($a_data['proc']=='Edit_Pdpa'){
	
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
		  $isMove = move_uploaded_file ($_FILES['pdpa_file']['tmp_name'],$dir_base.$newfile);		  
	} 
			$a_attach = $newfile;	
			if(file_exists($dir_base.$a_data['pdpa_file_old']) && $a_data['pdpa_file_old'] != '')
			{			
				unlink($dir_base.$a_data['pdpa_file_old']); 			
			}	
	}
	else
	{					
		$a_attach = $a_data['pdpa_file_old'];
	}
	
$s_data['pdpa_detail']  = $a_data['pdpa_detail'];
$s_data['pdpa_status']  = $a_data['pdpa_status'];
$s_data['pdpa_checkbox']  = $a_data['pdpa_checkbox'];
$s_data['pdpa_file']  	= $a_attach;

update('m_complain_pdpa',$s_data,array('pdpa_id'=>$a_data['pdpa_id']));
//insert('m_complain_info',$s_data);
							   
print_r($a_data);	

unset($a_data);
unset($s_data);

exit;
	} 
?>