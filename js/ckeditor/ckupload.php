<?php 
session_start();

include ("../../lib/function.php");
include ("../../lib/user_config.php");
include ("../../lib/connect.php");

$siteinfo_data = $db->query("SELECT * FROM site_info WHERE site_info_id = '1'");
$siteinfo_info = $db->db_fetch_array($siteinfo_data);

$valid_file = explode(",",$siteinfo_info["site_type_file"]);
$valid_img  = explode(",",$siteinfo_info["site_type_img_file"]);

##==============================================================================================================##
$_host      = $_SERVER['HTTP_HOST'];	
$_name      = $_SERVER['SCRIPT_NAME'];
$_url       = $_SERVER['REQUEST_URI'];	
$_protocal  = 'http';
##==============================================================================================================##

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
##==============================================================================================================##
$file_extension = explode(".",$_FILES['upload']['name']);
$file_extension = $file_extension[count($file_extension)-1];


if(in_array($file_extension,$valid_img)){
    $flag = "image";
    $new_name = "articleimg_".date("YmdHis").rand(10000,99999).".".$file_extension;

    $url  = "../../ewt/".$_SESSION["EWT_SUSER"]."/images/".$new_name;
    $url1 = $_protocal."://".$_host.$_directory."ewt/".$_SESSION["EWT_SUSER"]."/images/".$new_name;
    $url2 = $_protocal."://".$_host.$_directory."ewt/".$_SESSION["EWT_SUSER"]."/images/".$new_name;
}
else if(in_array($file_extension,$valid_file)){
    $flag = "file";
    $new_name = "articlefile_".date("YmdHis").rand(10000,99999).".".$file_extension;

    $url  = "../../ewt/".$_SESSION["EWT_SUSER"]."/article_attach/".$new_name;
    $url1 = $_protocal."://".$_host.$_directory."ewt/".$_SESSION["EWT_SUSER"]."/article_attach/".$new_name;
    $url2 = $_protocal."://".$_host.$_directory."ewt/".$_SESSION["EWT_SUSER"]."/article_attach/".$new_name;
}
else{
    $flag    = "invalid";
    $message = "Incorrect file extension";
}
##==============================================================================================================##
## >>extensive suitability check before doing anything with the file...
if (($_FILES['upload'] == "none") OR (empty($_FILES['upload']['name'])) ){
    $message = "No file uploaded.";
}
else if ($_FILES['upload']["size"] == 0){
    $message = "The file is of zero length.";
}
else if($flag == "invalid"){
    $message = "The image must be in either [".implode(",",$valid_file).",".implode(",",$valid_img)."] format. Please upload file with stated extension(s) instead.";
}
else if (!is_uploaded_file($_FILES['upload']["tmp_name"])){
    $message = "You may be attempting to hack our server. We're on to you; expect a knock on the door sometime soon.";
}
else{
    ## >> Try to upload file

    $message = "";
    $move =  move_uploaded_file($_FILES['upload']['tmp_name'], $url);

    if(!$move){
        $message = "Error moving uploaded file. Check the script is granted Read/Write/Modify permissions.";
    }
    //$url = "../" . $url;
}

	
if($message != ""){
    $url = "";
}

$funcNum = $_GET['CKEditorFuncNum'] ;
echo "<script type='text/javascript'>window.parent.CKEDITOR.tools.callFunction($funcNum, '$url2', '$message');</script>";

?>