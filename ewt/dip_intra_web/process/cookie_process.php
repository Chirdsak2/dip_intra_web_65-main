<?php 
//header('Content-type: application/json; charset=utf-8');

include("../lib/function.php");
include("../lib/user_config.php");
include("../lib/connect.php");

$flag = $_POST["flag"];

if($flag == "accept_cookie"){
	session_start();
	$_SESSION["accept_cookie"] = "Y";
	## >> Gen CSRF Token
	function getCookieToken() {
		global $db;
		$charset = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789-_';
		$randStringLen = 100;

		$randString = "";
		for ($i = 0; $i < $randStringLen; $i++) {
			$randString .= $charset[mt_rand(0, strlen($charset) - 1)];
		}
		
		$csrf_token = $randString;
		return $csrf_token;
	}
	## >> Reset if the token is already in use
	function checkdup_token($accept_token){		

		global $db;
		$accept_token     = ready($accept_token);
		$current_datetime = date("Y-m-d H:i:s");
		
		$find_accept = $db->query("SELECT COUNT(accept_id) AS total FROM accept_cookie_history 
		                           WHERE  accept_token = '$accept_token' COLLATE utf8_bin
                                     AND  accept_expire > '$current_datetime'");
		$find_data   = $db->db_fetch_array($find_accept);
		
		if($find_data["total"]>0){
			$accept_token = getCookieToken();
			checkdup_token($accept_token);
		}
		else{
			return $accept_token;
		}
	}
	
	## >> Set cookie token
	$accept_token = getCookieToken();
	$accept_token = checkdup_token($accept_token);

	setcookie("acceptcookie_token", $accept_token,
				['expires' => time() + (60*60*24*365*5),
				 'path' => '/',
				 'domain' => $EWT_COOKIE_DOMAIN,
				 'secure' => $EWT_COOKIE_SECURE,
				 'httponly' => $EWT_COOKIE_HTTPONLY,
				 'samesite' => $EWT_COOKIE_SAMESITE
				]
			); //expire in 5 years
	$_COOKIE["acceptcookie_token"]     = $accept_token;
	
	if($_SERVER["REMOTE_ADDR"]){
		$ip_view = $_SERVER["REMOTE_ADDR"];
	}
	else{
		$ip_view = $_SERVER["REMOTE_HOST"];
	}
	$ip_view          = ready($ip_view);
	$current_datetime = date("Y-m-d H:i:s"); 
	$expire           = date('Y-m-d H:i:s', strtotime($current_datetime. ' + 5 year'));

	## >> Check
	$db->query("INSERT INTO accept_cookie_history (accept_token,accept_ipaddress,accept_datetime,accept_expire,accept_status)
				VALUES ('$accept_token','$ip_view','$current_datetime','$expire','Y')");

}
else if($flag == "reject_cookie"){
	$current_datetime          = date("Y-m-d H:i:s"); 
	$reask = date("Y-m-d H:i:s",strtotime("+1 hour"));
	
	if($_SERVER["REMOTE_ADDR"]){
		$ip_view = ready($_SERVER["REMOTE_ADDR"]);
	}
	else{
		$ip_view = ready($_SERVER["REMOTE_HOST"]);
	}

	## >> Check
	$db->query("INSERT INTO accept_cookie_history (accept_token,accept_ipaddress,reject_datetime,reask_datetime,accept_status)
				VALUES ('','$ip_view','$current_datetime','$reask','N')");
}

$db->db_close();
exit();
?>