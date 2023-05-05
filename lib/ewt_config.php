<?php
error_reporting (E_ALL & ~E_WARNING & ~E_NOTICE & ~E_DEPRECATED);
$EWT_ROOT_HOST = "localhost";
$EWT_ROOT_USER = "biz";
$EWT_ROOT_PASSWORD = 'B!zw#b2022';
$EWT_DB_USER = "ewt_user_bizpotential_web";
$EWT_DB_TYPE = "MYSQLi";

/* BIZPOTEN */
$EWT_GDCC = "N";
$EWT_LDAP_USE        = "N";
$EWT_COOKIE_SECURE   = false; //true or false (Site is not SECURE)
$EWT_COOKIE_HTTPONLY = false; //true or false (Site is not SECURE)
$EWT_COOKIE_SAMESITE = "Strict"; //Strict, Lax, None 
$EWT_COOKIE_DOMAIN   = "";

/* DEMO
$EWT_GDCC = "N";
$EWT_LDAP_USE        = "N";
$EWT_COOKIE_SECURE   = true; //true or false
$EWT_COOKIE_HTTPONLY = true; //true or false
$EWT_COOKIE_SAMESITE = "Lax"; //Strict, Lax, None 
$EWT_COOKIE_DOMAIN   = "";
*/

/* GDCC
$EWT_GDCC = "Y";
$EWT_LDAP_USE        = "Y";
$EWT_COOKIE_SECURE   = true; //true or false
$EWT_COOKIE_HTTPONLY = true; //true or false
$EWT_COOKIE_SAMESITE = "Strict"; //Strict, Lax, None 
$EWT_COOKIE_DOMAIN   = "";
*/
##==================================================================##
$EWT_USER_TOKEN_BACKEND     = "usertoken_backend";
$EWT_USER_LOGINTYPE_BACKEND = "login_type";
$EWT_LDAP_ADDRESS = "@ad-gistda.or.th";
?>