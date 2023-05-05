<?php 
session_start();
error_reporting (E_ALL & ~E_WARNING & ~E_NOTICE & ~E_DEPRECATED);
header('Content-type: application/json; charset=utf-8');


include("../../../lib/include.php");
include("../../../class/sys/user.class.php");
include("include.php");

$flag        = $_POST["flag"];
$error_array = array();

##====================================================================================================##
function Login_ewt($EWT_User,$EWT_Password){
	global $db;
	global $EWT_DB_USER,$EWT_DB_NAME;
	global $text_portallogin_usernotfound;
	
	## >> Check LDAP/Normal user on site
	$s_sql 		= 	"SELECT * 
	                 FROM   $EWT_DB_USER.gen_user 
					 WHERE  gen_user = '$EWT_User'  COLLATE utf8_bin AND gen_pass = '$EWT_Password' COLLATE utf8_bin  
					   AND  status = '1' ";
	$s_result 	= 	$db->query($s_sql);
	$a_rows   	= 	$db->db_num_rows($s_result);
	
	if($a_rows > 0){
		$a_user_info = $db->db_fetch_array($s_result);
		
		## >> Check expire
		$current_date = date("Y-m-d");
		if($a_user_info['expiredate']=='0000-00-00'){
			$a_user_info['expiredate'] = "";
		}

		if($a_user_info['expiredate']!=""){
			if(strtotime($current_date) > strtotime($a_user_info['expiredate'])){
				return_data("normal_error",array("text"=>'<span style="color:#ffffff;font-size: 15px;">'.$text_portallogin_usernotfound.'</span>'));
			}
		}

		create_logincookie($a_user_info['gen_user_id'],"Normal");

		## >> Collect login history
		$db->query("USE ".$EWT_DB_NAME);
		$db->write_log("login","login","เข้าสู่ระบบ");
		
	} 
	else {
		return_data("normal_error",array("text"=>'<span style="color:#ffffff;font-size: 15px;">'.$text_portallogin_usernotfound.'</span>'));
	}
}
function create_logincookie($user_id,$login_type){
	global $db;
	global $EWT_USER_TOKEN_BACKEND;
	global $EWT_USER_LOGINTYPE_BACKEND;
	global $EWT_DB_USER;

	$token			= strtolower(makerandomletter(100));
	$expiredatetime = date("Y-m-d H:i:s", strtotime("+1 day"));

	setcookie($EWT_USER_TOKEN_BACKEND, $token,
	['expires' =>  time()+(86400),
	 'path' => '/',
	 'domain' => $EWT_COOKIE_DOMAIN,
	 'secure' => $EWT_COOKIE_SECURE,
	 'httponly' => $EWT_COOKIE_HTTPONLY,
	 'samesite' => $EWT_COOKIE_SAMESITE
	]); // 86400 = 1 day
	setcookie($EWT_USER_LOGINTYPE_BACKEND, $login_type,
	['expires' =>  time()+(86400),
	 'path' => '/',
	 'domain' => $EWT_COOKIE_DOMAIN,
	 'secure' => $EWT_COOKIE_SECURE,
	 'httponly' => $EWT_COOKIE_HTTPONLY,
	 'samesite' => $EWT_COOKIE_SAMESITE
	]); // 86400 = 1 day

	$_COOKIE[$EWT_USER_TOKEN_BACKEND]     = $token;
	$_COOKIE[$EWT_USER_LOGINTYPE_BACKEND] = $login_type;

	$db->query("INSERT INTO $EWT_DB_USER.login_history_user (user_id,login_token,create_date,
	                                            expire_date,token_status,login_through) 
	            VALUES ('$user_id','$token',NOW(),'$expiredatetime','Y','$login_type')");
}

if($flag == "login_portal"){

	## >> Check username/password
	$portal_username = trim($_POST["portal_username"]);
	$portal_password = trim($_POST["portal_password"]); 
	
	if($portal_username==""||$portal_password==""){
		return_data("normal_error", array("text"=>'<span style="color:#ffffff;font-size: 15px;">'.$text_portallogin_nouserpass.'</span>'));
	}

	##========================================================================================##
	## >> Check user
	$EWT_User     = ready($portal_username);
	$EWT_Password = ready(md5($portal_password));
	$is_siteadmin = "N";
	$is_ldap      = "N";
	$login_type   = "";
	$this_userinfo= "";

	## Case 1: Site Admin
	$siteadmin_sql = "SELECT * 
	                  FROM   $EWT_DB_USER.user_info 
				      WHERE  EWT_User = '$EWT_User' COLLATE utf8_bin AND EWT_Pass = '$EWT_Password' COLLATE utf8_bin AND EWT_Status = 'Y'  ";
	$siteadmin_data = $db->query($siteadmin_sql);
	
	if($db->db_num_rows($siteadmin_data)>0){
		$siteadmin_info = $db->db_fetch_array($siteadmin_data);
		$is_siteadmin  = "Y";
		$this_userinfo = $siteadmin_info;
	}	
	
	if($is_siteadmin == "Y"){
		create_logincookie($this_userinfo['UID'],"Site_Admin");
	
		## >> Collect login history
		$db->query("USE ".$EWT_DB_NAME);
		$db->write_log("login","login","เข้าสู่ระบบ");
		
	}
	else{
		## Case 2: Ldap User [set at lib/user_config.php]
		if($EWT_LDAP_USE=="Y"){
			$ldap_username     = trim($_POST["portal_username"]).$EWT_LDAP_ADDRESS;
			$ldap_password     = trim($_POST["portal_password"]);

			$ldapconfig['host']    = '103.156.151.10';//CHANGE THIS TO THE CORRECT LDAP SERVER
			$ldapconfig['port']    = '389';
			$ldapconfig['basedn']  = 'dc=ad-gistda,dc=or,dc=th';//CHANGE THIS TO THE CORRECT BASE DN
			$ldapconfig['usersdn'] = 'cn=users';//CHANGE THIS TO THE CORRECT USER OU/CN
			$ldapconn              = ldap_connect($ldapconfig['host'],$ldapconfig['port']);
			
			$ldaptree = $ldapconfig['basedn'];
			
			ldap_set_option($ldapconn, LDAP_OPT_PROTOCOL_VERSION, 3);
			ldap_set_option($ldapconn, LDAP_OPT_REFERRALS, 0);
			ldap_set_option($ldapconn, LDAP_OPT_NETWORK_TIMEOUT, 10);
			
			$total_user = 0;
			
			if($ldapconn){
				$ldapbind = ldap_bind($ldapconn, $ldap_username, $ldap_password);
				
				if ($ldapbind) {
					$result = ldap_search($ldapconn,$ldaptree, "(&(cn=*)(userprincipalname=$ldap_username))");
					$data   = ldap_get_entries($ldapconn, $result);
			
					$ldap_member = $data[0];
					if(in_array("user",$ldap_member["objectclass"])){
						//$this_member["samaccountname"] = $ldap_member["samaccountname"][0];
						$total_user++;
					}
				}
			}

			if($total_user>0){
				$is_ldap = "Y";
			}

			if($is_ldap == "Y"){
				$EWT_User     = ready($ldap_member["samaccountname"][0]);
				$EWT_Password = ready(substr(user::encryptPassword(trim($ldap_member["samaccountname"][0])),0,30));
				Login_ewt($EWT_User,$EWT_Password);
			}	

			## Case 3: Normal User
			else if($is_ldap == "N"){
				$EWT_User     = ready($_POST["portal_username"]);
				$EWT_Password = ready(substr(user::encryptPassword(trim($_POST["portal_password"])),0,30));
				//$EWT_Password = ready($_POST["login_password"]);
				Login_ewt($EWT_User,$EWT_Password);
			}	
		}
		else{
			$EWT_User     = ready($_POST["portal_username"]);
			$EWT_Password = ready(substr(user::encryptPassword(trim($_POST["portal_password"])),0,30));
			//$EWT_Password = ready($_POST["login_password"]);
			Login_ewt($EWT_User,$EWT_Password);
		}	
	}

	
	##============================================================================================================##
	return_data("success",array("text"=>'<span style="color:#ffffff;font-size: 15px;">'.$text_portallogin_success.'</span>',
	                            "redirect"=>create_seourl("webportal.php",$language)));
}

$db->db_close();
exit();
?>