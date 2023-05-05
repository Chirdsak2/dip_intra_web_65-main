<?php
session_start();
header('Content-Type: text/html; charset=utf-8');
	if($_SESSION['EWT_SESSID']){
		header("location: EWT_ADMIN/main.php");
		exit();		
	}else{
		header("location: Login/login.php");
		exit();		
}
?>