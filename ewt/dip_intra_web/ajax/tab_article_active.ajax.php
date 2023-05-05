<?php 
DEFINE('path', '../assets/');
include path . '/config/config.inc.php';

$_SESSION["EWT_ARTICLE_TAP_ACTIVE"] = conText($_REQUEST["key"]);
$_SESSION["EWT_CID_MORE_NEWS"] = conText($_REQUEST["c_id"]);
// unset($_SESSION["EWT_ARTICLE_TAP_ACTIVE"]);
// echo $_SESSION["EWT_ARTICLE_TAP_ACTIVE"];
