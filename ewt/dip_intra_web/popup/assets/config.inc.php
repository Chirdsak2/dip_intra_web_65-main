<?php
error_reporting (E_ALL & ~E_WARNING & ~E_NOTICE & ~E_DEPRECATED);
//error_reporting (E_ALL);
date_default_timezone_set ('Asia/Bangkok');
ini_set('mbstring.internal_encoding', 'UTF-8');

session_start();


DEFINE('EWT_PATH', '../') ;

include(EWT_PATH."../../config/function.inc.php");

DEFINE('SYS_LANG', get('lang','TH'));

if(SYS_LANG){
	include(EWT_PATH.'language/lang_'.SYS_LANG.'.php');
}

include(EWT_PATH."../../config/ewt_function.inc.php");	
?>