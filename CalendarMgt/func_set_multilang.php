<?php
include("../lib/permission1.php");
include("../lib/include.php");
include("../lib/function.php");
include("../lib/user_config.php");
include("../lib/connect.php");
include("../lib/set_lang.php");

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

if($a_data['proc']=='set_lang'){
	/*for($i=0;$i<$a_data['num'];$i++){
		if($a_data['lang_detail'][$i] != ''){
			$a_data['lang_detail'][4] .= $a_data['lang_detail'][$i];
		}
	}*/
	if($a_data['news_use'] == '1'){		
		if($a_data['browsefile']=='1'){			
			$a_data['lang_detail'][9] = $a_data['link'];
			$a_data['lang_detail'][10] = $a_data['browsefile'];			
			}else{
			$Current_Dir2 = "../ewt/".$_SESSION["EWT_SUSER"]."/download/article/";				
			$Current_Dir3 = "download/article/";
			
			
			/*@mkdir ($Current_Dir2, 0777);
				if($_FILES["filebrowse"]['size'] > 0 ){
				$F = explode(".",$_FILES["filebrowse"]["name"]);
				$C = count($F);
				$CT = $C-1;
				$dir = strtolower($F[$CT]);
				$nfile = "article_".date("YmdHis");
				$picname = $nfile.".".$dir;
				//copy($_FILES['filebrowse']['tmp_name'],$Current_Dir2."/".$picname);
				move_uploaded_file ($_FILES['filebrowse']['tmp_name'],$Current_Dir2."/".$picname);
				@chmod ($Current_Dir2."/".$picname, 0777);
				$a_data['lang_detail'][9] = $Current_Dir3."/".$picname;
				$a_data['lang_detail'][10] = $a_data['browsefile'];	*/
				

$MAXIMUM_FILESIZE = 10 * 1024 * 1024; 
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
		}
	
	

	for($i=0;$i<$a_data['num'];$i++){
		if($a_data['lang_field'][$i]){
			if($a_data['lang_datack'][$i]){				
			$newContent = str_replace($_protocal."://".$_host.$_directory."js/","../js/",$a_data['lang_datack'][$i]);			
			$a_data['lang_detail'][$i] =  $newContent;			
			}			
		set_lang($a_data['c_id'],$a_data['lang_name'],$a_data['lang_field'][$i],$a_data['lang_detail'][$i],$a_data['module']);
		}
	}	

print_r($a_data);	
//echo $a_data['lang_detail'][9];
	exit;
   
}else if($a_data['proc']=='set_lang_group'){
	
	for($i=0;$i<$a_data['num'];$i++){
		if($a_data['lang_field'][$i]){
		set_lang($a_data['c_id'],$a_data['lang_name'],$a_data['lang_field'][$i],$a_data['lang_detail'][$i],$a_data['module']);
		}
	}
	
print_r($a_data); 
	exit;
} 

?>