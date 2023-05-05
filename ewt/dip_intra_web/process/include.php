<?php 
include("../lib/function.php");
include("../lib/user_config.php");
include("../lib/connect.php");

include("../lib/check_cookie.php");
//include("lib/page_language.php");

//include("page_title.php");

## >> Check langauge [Do not allow unused language]
$language = $_GET["lang"];

if($_GET["lang"]=="EN"){
    $file_language = "_en";
}
else{
    $file_language = "";
	$language      = "TH";
	$_GET["lang"]  = "TH";
}

$redirect_url = "N";
$redirect_404 = "N";

include("../language/sitelang_".$language.".php");


## >> Template
$template_config = $db->query("SELECT * FROM site_management_template WHERE template_use ='Y'");
$template_info   = $db->db_fetch_array($template_config);
$template_id     = $template_info["template_id"];

$template_name = "_template1";

## >> Hotkey template
if(in_array($_GET["set_template"],array(1,2,3))){
	$template_id = $_GET["set_template"];
}

if($template_id!="1"){
	$template_name = "_template".$template_id;
}
else{
	$template_name = "_template1";
}

## >> Base language
if($language=="TH"){
	$s_lang_config = $db->query("SELECT lang_config_id,lang_config_name,lang_config_id,lang_config_suffix,lang_config_img,lang_config_status 
								 FROM   lang_config 
								 WHERE  lang_config_status = 'T'");
	$s_lang_info   = $db->db_fetch_array($s_lang_config);
}
## >> Other language
else{
	$s_lang_config = $db->query("SELECT lang_config_id,lang_config_name,lang_config_id,lang_config_suffix,lang_config_img,lang_config_status 
								 FROM   lang_config 
								 WHERE  lang_config_suffix = '$language'");
	$s_lang_info   = $db->db_fetch_array($s_lang_config);
}

$lang_id            = $s_lang_info["lang_config_id"];
$lang_config_status = $s_lang_info["lang_config_status"];

##================================================================================================##

$EWT_PORTAL_USER = "N";
$current_datetime  = date("Y-m-d H:i:s");

## >> Update expired token
$db->query("UPDATE $EWT_DB_USER.login_history_user 
			SET token_status  = 'N' 
			WHERE expire_date <= '$current_datetime'
			  AND token_status  = 'Y'");

## >> Check cookie's validity
$login_token       = ready($_COOKIE[$EWT_USER_TOKEN_BACKEND]);
$login_type        = ready($_COOKIE[$EWT_USER_LOGINTYPE_BACKEND]);

$token_data = $db->query("SELECT * FROM $EWT_DB_USER.login_history_user 
                          WHERE login_token = '$login_token' COLLATE utf8_bin 
						    AND expire_date > '$current_datetime'
							AND token_status  = 'Y' 
							AND login_through = '$login_type'");


if($db->db_num_rows($token_data)>0){
	$token_info = $db->db_fetch_array($token_data);
	$user_id    = $token_info["user_id"];
	
	if($login_type=="Normal"){
		## >> Check user
		$current_date = date("Y-m-d");

		$user_data = $db->query("SELECT * FROM $EWT_DB_USER.gen_user 
		                         WHERE gen_user_id = '$user_id' AND `status` = '1'");
		if($db->db_num_rows($user_data)>0){
			$portal_userinfo = $db->db_fetch_array($user_data);
			## >> Check expire
			if($portal_userinfo['expiredate']=='0000-00-00'){
				$portal_userinfo['expiredate'] = "";
			}

			if($portal_userinfo['expiredate']!=""){
				if(strtotime($current_date) > strtotime($portal_userinfo['expiredate'])){
					$EWT_PORTAL_USER = "N";
				}
				else{
					$portal_name     = $portal_userinfo["name_thai"]." ".$portal_userinfo["surname_thai"];
					$EWT_PORTAL_USER = "Y";
				}
			}
			else{
				$portal_name     = $portal_userinfo["name_thai"]." ".$portal_userinfo["surname_thai"];
				$EWT_PORTAL_USER = "Y";
			}
			
		}
	}
	else if($login_type=="Site_Admin"){
		## >> Check user
		$user_data = $db->query("SELECT * FROM $EWT_DB_USER.user_info 
		                         WHERE UID = '$user_id' AND EWT_STATUS = 'Y'");
		if($db->db_num_rows($user_data)>0){
			$portal_userinfo = $db->db_fetch_array($user_data);
			$portal_name     = "Admin";
			$EWT_PORTAL_USER = "Y";
		}

	}

}

if($EWT_PORTAL_USER == "N"){
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
	unset($login_token);
	unset($login_type);
	unset($_SESSION['EWT_SUID']);
	unset($_SESSION['EWT_SUSER']);
	unset($_SESSION['EWT_SDB']);
	unset($_SESSION['EWT_SMID']);
	unset($_SESSION['EWT_SMUSER']);
	unset($_SESSION['EWT_SMTYPE']);
}
?>

