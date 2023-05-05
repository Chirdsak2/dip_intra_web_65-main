<?php
$path = "../";
	session_start();
	$start_time_counter = date("YmdHis");
	include($path."lib/function.php");
	include($path."lib/user_config.php");
	include($path."lib/connect.php");
	include("include/ewt_block_function.php");
	include("include/ewt_menu_preview.php");
	include("include/ewt_article_preview.php");

			if(file_exists("checked/".$_GET["filename"].".php")) {  
				//อ่านค่า
				$fp = fopen ("checked/".$_GET["filename"].".php", 'rb');
				$ata = fread( $fp, filesize("checked/".$_GET["filename"].".php"));
				$explo = explode('<body>',$ata);
				echo	$dtd_html_head_charset_top = "
	<!DOCTYPE HTML PUBLIC \"-//W3C//DTD HTML 4.01 Transitional//EN\" \"http://www.w3.org/TR/html4/loose.dtd\">
	<HTML lang=\"th\">
	<HEAD>
	<meta http-equiv=\"Content-Type\" content=\"text/html; charset=UTF-8\"><title></title>".$explo[0]."</HEAD><body>		
	";
				//include("checked/".$_GET["filename"].".php");//กรณีมีการแปลง page ไว้
				echo $explo[1];
				echo	$dtd_html_head_charset_bottom ="</body>"; 
				echo $END_PAGE = "</HTML>";
			}
			
			
			$db->db_close(); ?>