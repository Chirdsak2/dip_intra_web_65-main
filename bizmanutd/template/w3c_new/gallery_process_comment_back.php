<?php
session_start();
	print "<script language=\"javascript\" type=\"text/javascript\">";
	print "history.go(-2)";
	print "</script>";
$db->db_close(); 
?>
