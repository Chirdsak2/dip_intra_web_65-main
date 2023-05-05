<?php
session_start();

if(empty($_SESSION['EWT_SMUSER'])){			
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

include("header.php");

?>   
