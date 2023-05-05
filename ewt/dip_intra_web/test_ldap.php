<?php
DEFINE('path', 'assets/');
include path . '/config/config.inc.php';

ini_set("memory_limit", "-1");
set_time_limit(0);

// ini_set('display_errors', '1');
// ini_set('display_startup_errors', '1');
// error_reporting(E_ALL);
// $domain = 'diprom';
// $username = 'biz_admin';
// $password = 'P@$$w0rds$#@!';
$ldapconfig['host'] = LDAP_HOST;
$ldapconfig['port'] = LDAP_PORT;
$ldapconfig['basedn'] = LDAP_AUTHEN;

$ldapconn = ldap_connect($ldapconfig['host'], $ldapconfig['port']);
ldap_set_option($ldapconn, LDAP_OPT_PROTOCOL_VERSION, 3);
ldap_set_option($ldapconn, LDAP_OPT_REFERRALS, 0);

$dn = $ldapconfig['basedn'];
$bind = ldap_bind($ldapconn, LDAP_USER . '@' . LDAP_DOMAIN, LDAP_PASS);
//$ldap_search = ldap_search($ldapconn, $dn, "(|(sn=*))");
$ldap_search = ldap_search($ldapconn, $dn, "(cn=*)");

if ($ldap_search) {
	$data = ldap_get_entries($ldapconn, $ldap_search);
	//echo ("Success");
	echo "<pre>";
	var_dump($data); exit;
	echo "</pre>";
} else {
	echo "<br>";
	echo "LDAP-Errno: " . ldap_errno($ldapconn) . "<br />\n";
	echo "LDAP-Error: " . ldap_error($ldapconn) . "<br />\n";
}



