<?php
error_reporting (E_ALL & ~E_WARNING & ~E_NOTICE & ~E_DEPRECATED);
//error_reporting (E_ALL);
date_default_timezone_set ('Asia/Bangkok');
ini_set('mbstring.internal_encoding', 'UTF-8');
//
//session_start();

$s_get = array();
if($_GET['lang'] == ""){ $_GET['lang'] = "TH"; }
if($_GET)
{
	foreach($_GET as $_key=>$_item)
	{
		$_GET[$_key] = htmlspecialchars(strip_tags($_item));
		$s_get[$_key] = $_GET[$_key];
	}
	
$s_key = array_keys($s_get);
$s_val = array_values($s_get);	
}


DEFINE('SYS_MODULE', str_replace(".php", "", basename($_SERVER["SCRIPT_NAME"])));
DEFINE('EWT_PATH', '') ;

include("../../config/function.inc.php");

DEFINE('SYS_LANG', get('lang','TH'));

if(SYS_LANG){
	include('language/lang_'.SYS_LANG.'.php');
}

include("../../config/ewt_function.inc.php");	
?>