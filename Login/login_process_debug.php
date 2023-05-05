<?php	
session_start(); 

//header('Content-type: application/json; charset=utf-8');

$EWT_PATH = '../';	
$IMG_PATH = '';
$MAIN_PATH = '';
$lala = 123;

include("../lib/include.php");
include("../lib/ewt_config.php");
include("../lib/function.php");
include("../lib/config_path.php");

$db = new PHPDB($EWT_DB_TYPE,$EWT_ROOT_HOST,$EWT_ROOT_USER,$EWT_ROOT_PASSWORD,$EWT_DB_USER);
$connectdb=$db->CONNECT_SERVER();
$db->query("SET NAMES 'utf8' ");

## >> Filter input
$EWT_Password = "natty";
$flag        = $_POST["flag"];
$error_array = array();
$EWT_Password = user::encryptPassword($EWT_Password);

echo "PASS:".$EWT_Password."<br/>";
echo substr($EWT_Password,0,30)."<br/>";
?>