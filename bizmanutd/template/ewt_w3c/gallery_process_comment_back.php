<?php
$path = '../';
session_start();
include($path."lib/function.php");
include($path."lib/user_config.php");
include($path."lib/connect.php");

	print "<script language=\"javascript\" type=\"text/javascript\">";
	print "history.go(-2)";
	print "</script>";
$db->db_close(); 
?>
