<?php 
session_start();
include("include.php");

$_COOKIE[$EWT_USER_TOKEN_BACKEND]     = '';
$_COOKIE[$EWT_USER_LOGINTYPE_BACKEND] = '';

setcookie($EWT_USER_TOKEN_BACKEND, '',
['expires' =>  time()+0,
 'path' => '/',
 'domain' => $EWT_COOKIE_DOMAIN,
 'secure' => $EWT_COOKIE_SECURE,
 'httponly' => $EWT_COOKIE_HTTPONLY,
 'samesite' => $EWT_COOKIE_SAMESITE
]); // 86400 = 1 day
setcookie($EWT_USER_LOGINTYPE_BACKEND, '',
['expires' =>  time()+0,
 'path' => '/',
 'domain' => $EWT_COOKIE_DOMAIN,
 'secure' => $EWT_COOKIE_SECURE,
 'httponly' => $EWT_COOKIE_HTTPONLY,
 'samesite' => $EWT_COOKIE_SAMESITE
]); // 86400 = 1 day
unset($_SESSION['EWT_SUID']);
unset($_SESSION['EWT_SUSER']);
unset($_SESSION['EWT_SDB']);
unset($_SESSION['EWT_SMID']);
unset($_SESSION['EWT_SMUSER']);
unset($_SESSION['EWT_SMTYPE']);

header("location:../".create_seourl("home.php",$language));
exit();
?>