<?php 
session_start();

	$_host = $_SERVER['HTTP_HOST'];	
	$_name = $_SERVER['SCRIPT_NAME'];
	$_url = $_SERVER['REQUEST_URI'];	
    $_protocal = 'http';
	
	function getEwt($_url){
	
   $s_method = strtok($_url, '?');
    if($s_method)
    {
      $a_method = explode('/', $s_method);

		$chk_site = "/".$a_method[1]."/";
		
		return  $chk_site;
	}
}
$_directory = getEwt($_url);

	$url = "../../ewt/".$_SESSION["EWT_SUSER"]."/images/".$_FILES['upload']['name'];
	//$url2 = "images/".$_FILES['upload']['name'];
	$url2 = $_protocal."://".$_host.$_directory."ewt/".$_SESSION["EWT_SUSER"]."/images/".$_FILES['upload']['name'];
	$url1 = $_protocal."://".$_host.$_directory."ewt/".$_SESSION["EWT_SUSER"]."/images/".$_FILES['upload']['name'];
		
//exit;	
	//$url = 'upload/files/'.time()."_".$_FILES['upload']['name'];

 //extensive suitability check before doing anything with the file...
    if (($_FILES['upload'] == "none") OR (empty($_FILES['upload']['name'])) )
    {
       $message = "No file uploaded.";
    }
    else if ($_FILES['upload']["size"] == 0)
    {
       $message = "The file is of zero length.";
    }
    else if (($_FILES['upload']["type"] != "image/pjpeg") AND ($_FILES['upload']["type"] != "image/jpeg") AND ($_FILES['upload']["type"] != "image/png") AND ($_FILES['upload']["type"] != "image/gif"))
    {
       $message = "The image must be in either GIF , JPG or PNG format. Please upload a JPG or PNG instead.";
    }
    
	else if (!is_uploaded_file($_FILES['upload']["tmp_name"]))
    {
       $message = "You may be attempting to hack our server. We're on to you; expect a knock on the door sometime soon.";
    }
    else {
      $message = "";
	
      $move =  move_uploaded_file($_FILES['upload']['tmp_name'], $url);
      if(!$move)
      {
         $message = "Error moving uploaded file. Check the script is granted Read/Write/Modify permissions.";
      }
      //$url = "../" . $url;
    }

	
	if($message != "")
	{
		$url = "";
	}

	$funcNum = $_GET['CKEditorFuncNum'] ;
	echo "<script type='text/javascript'>window.parent.CKEDITOR.tools.callFunction($funcNum, '$url2', '$message');</script>";

?>