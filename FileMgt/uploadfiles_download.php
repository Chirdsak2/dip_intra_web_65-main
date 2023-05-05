<?php
// In PHP versions earlier than 4.1.0, $HTTP_POST_FILES should be used instead
// of $_FILES.

//trying restore browser cookie
if(isset($_POST['MultiPowUpload_browserCookie']))
{
	$cookies = split(";", $_POST['MultiPowUpload_browserCookie']);
	foreach($cookies as $value)
	{
		$namevalcookies = split("=", $value);	
		$browsercookie[trim($namevalcookies[0])] =  trim($namevalcookies[1]);
	}
	$_COOKIE = $browsercookie;
}

//restore session if possible
if(isset($browsercookie) && isset($browsercookie['PHPSESSID']))
{	
	session_id($browsercookie['PHPSESSID']);
	@session_start();
}
//@session_start();

include("../lib/permission1.php");
include("../lib/include.php");
include("../lib/function.php");
include("../lib/user_config.php");
include("../lib/connect.php");



//if($_POST["Flag"] == "UploadFile007"){
	$Globals_Dir = "../ewt/".$_SESSION["EWT_SUSER"]."/download/";
//}
if($_SESSION["SS_DIRECTORY"] == "BizPotential"){
		$Current_Dir = $Globals_Dir;		
}else{
		$folder = base64_decode($_SESSION["SS_DIRECTORY"]);
		if($folder) $folder .= "/";
		
		$Current_Dir = $Globals_Dir.$folder;
}

echo ' Upload result:<br>'; // At least one symbol should be sent to response!!!

$uploaddir = $Current_Dir; //dirname($_SERVER['SCRIPT_FILENAME'])."/UploadedFiles/";


$target_encoding = "UTF-8";//"ISO-8859-1";
echo '<pre>';
if(count($_FILES) > 0)
{
	$arrfile = pos($_FILES);
	$uploadfile = $uploaddir.iconv("UTF-8", $target_encoding,basename($arrfile['name'])) ; // basename($arrfile['name']) 

	if (move_uploaded_file($arrfile['tmp_name'], $uploadfile))
	   echo "File is valid, and was successfully uploaded.\n";
}
else
	echo 'No files sent. Script is OK!'; //Say to Flash that script exists and can receive files
echo 'Here is some more debugging info:';
print_r($_FILES);
print_r($_POST);

?>