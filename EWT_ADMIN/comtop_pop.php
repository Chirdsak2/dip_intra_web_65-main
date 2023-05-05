<?php
session_start();
if(empty($_SESSION['EWT_SMUSER'])){		
		
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
	unset($_SESSION['EWT_SUID']);
	unset($_SESSION['EWT_SUSER']);
	unset($_SESSION['EWT_SDB']);
	unset($_SESSION['EWT_SMID']);
	unset($_SESSION['EWT_SMUSER']);
	unset($_SESSION['EWT_SMTYPE']);
		
				echo '<script>';
				echo 'self.location.href = "../index.php";';	
				echo '</script>';
			exit();
		}
$EWT_PATH = '../';	
$IMG_PATH = '';
$MAIN_PATH = '';
include("../lib/include.php");
include("../lib/function.php");
include("../lib/user_config.php");
include("../lib/connect.php");
include("../lib/set_lang.php");
include("../language.php");
include("../language/language_TH.php");
include("../lib/config_path.php");
?>