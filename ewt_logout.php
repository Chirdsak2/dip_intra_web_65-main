<?php
session_start();
header('Content-Type: text/html; charset=utf-8');
include("lib/function.php");
include("lib/user_config.php");
include("lib/connect.php");
//$db->query("DELETE FROM user_session WHERE user_name = '".$_SESSION["EWT_SMUSER"]."'");

//$db->write_log("logout","logout","Logout ออกจากระบบ");
## >> Unset cookie and session
$_COOKIE[$EWT_USER_TOKEN_BACKEND]     = '';
$_COOKIE[$EWT_USER_LOGINTYPE_BACKEND] = '';

setcookie($EWT_USER_TOKEN_BACKEND, '',
['expires' =>  time()+(0),
 'path' => '/',
 'domain' => $EWT_COOKIE_DOMAIN,
 'secure' => $EWT_COOKIE_SECURE,
 'httponly' => $EWT_COOKIE_HTTPONLY,
 'samesite' => $EWT_COOKIE_SAMESITE
]); // 86400 = 1 day
setcookie($EWT_USER_LOGINTYPE_BACKEND, '',
['expires' =>  time()+(0),
 'path' => '/',
 'domain' => $EWT_COOKIE_DOMAIN,
 'secure' => $EWT_COOKIE_SECURE,
 'httponly' => $EWT_COOKIE_HTTPONLY,
 'samesite' => $EWT_COOKIE_SAMESITE
]); // 86400 = 1 day



unset($login_token);
unset($login_type);
unset($_SESSION['EWT_SESSID']);
unset($_SESSION['EWT_SUID']);
unset($_SESSION['EWT_SUSER']);
unset($_SESSION['EWT_SDB']);
unset($_SESSION['EWT_SMID']);
unset($_SESSION['EWT_SMUSER']);
unset($_SESSION['EWT_SMTYPE']);
unset($_SESSION['EWT_MID']);        
unset($_SESSION['EWT_USERNAME']);
unset($_SESSION['EWT_NAME']);
unset($_SESSION['EWT_SURNAME']);

$db->db_close();
//session_destroy();
header("location: https://portal.diprom.go.th/login.php");
exit();	
?>