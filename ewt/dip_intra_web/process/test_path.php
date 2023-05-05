<?php 
include("../lib/function.php");
include("../lib/user_config.php");
include("../lib/connect.php");

$EWT_WEB_SHORTPATH = "/";
$EWT_WEB_FULLPATH  = "/ewtadmin86_gistda/ewt/gistda_web/";

function test_url(){
	global $EWT_WEB_FULLPATH;

	$check_pos = (string)strpos($_SERVER["REQUEST_URI"],$EWT_WEB_FULLPATH);

	if($check_pos=="0"){
		return $EWT_WEB_FULLPATH;
	}
	else{
		return $EWT_WEB_SHORTPATH;
	}
}

echo "PATH:".test_url();

/*echo "<pre>";
print_r($_SERVER);
echo "</pre>";*/

?>