<?php
error_reporting (E_ALL & ~E_WARNING & ~E_NOTICE & ~E_DEPRECATED);
session_start();
DEFINE('path', 'assets/');
include(path.'config/config.inc.php');

$_SESSION['EWT_MID'] = '';
session_destroy(); 
if(!user::chkLogin()) redirect('index.php');  
?>