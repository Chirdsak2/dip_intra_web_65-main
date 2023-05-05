<?php
DEFINE('path', 'assets/');
include(path.'config/config.inc.php');

$sql = "SELECT * FROM " . E_DB_NAME . ".s000006";
$test = db::getColumnCount($sql);
var_dump($test);
print_r($test);
?>