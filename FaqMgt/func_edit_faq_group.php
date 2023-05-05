<?php
include("../lib/permission1.php");
include("../lib/include.php");
include("../lib/function.php");
include("../lib/user_config.php");
include("../lib/connect.php");
include("../lib/set_lang.php");
$date = new DateTime();
$_host = $_SERVER['HTTP_HOST'];	
$_name = $_SERVER['SCRIPT_NAME'];
$_url = $_SERVER['REQUEST_URI'];	
$_protocal = (isset($_SERVER['HTTPS']))?'https':'http';
	
	function getEwt1($_url){
	
   $s_method = strtok($_url, '?');
    if($s_method)
    {
      $a_method = explode('/', $s_method);

		$chk_site = "/".$a_method[1]."/";
		
		return  $chk_site;
	}
}
$_directory = getEwt1($_url);


$a_data = array_merge($_POST, $_FILES);


if($a_data['proc']=='Edit_Cate'){
	
$s_data = array();
$s_data['faq_cate_title']  =  $a_data['category_title'];
$s_data['faq_cate_detail'] =  $a_data['category_detail'];
$s_data['faq_cate_status'] = 'Y';
if(!isset($a_data['faq_cate_subcheck'])){
	$s_data['faq_cate_parent'] = '0';
}else{
	$s_data['faq_cate_parent'] = (!isset($a_data['category_parent']) ? '0' : $a_data['category_parent']);
}
$s_data['faq_cate_order']  = $a_data['category_order'];
$s_data['faq_cate_update'] = $date->format('Y-m-d H:i:s');
$s_data['faq_cate_status_parent'] = (!isset($a_data['faq_cate_subcheck']) ? 'N' : $a_data['faq_cate_subcheck']);

update('faq_category',$s_data,array('faq_cate_id'=>$a_data['category_id']));	
	
	
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