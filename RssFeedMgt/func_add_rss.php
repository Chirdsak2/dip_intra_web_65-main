<?php
include("../EWT_ADMIN/comtop_pop.php");
$a_data = array_merge($_POST, $_FILES);
$s_data = array();
$date = new DateTime();

switch($proc)  
{
	case "Add_Rss":
		$rss_title = stripslashes(htmlspecialchars($a_data['rss_title'],ENT_QUOTES));
		$rss_url = stripslashes(htmlspecialchars($a_data['rss_url'],ENT_QUOTES));
		$s_data['rss_title'] 	= 	$rss_title;
		$s_data['rss_url'] 		= 	$rss_url; 
		$s_data['rss_row'] 		= 	$a_data['rss_row']; 
		$s_data['rss_status'] 	= 	$a_data['rss_status'];
		$s_data['rss_images'] 	= 	$a_data['rss_images']; 
		$s_data['create_date'] 	= 	$date->format('Y-m-d');
		$s_data['update_date'] 	= 	$date->format('Y-m-d');
		$s_data['create_by'] 	= 	$_SESSION['EWT_SMID'];
		$s_data['timestamp'] 	= 	$date->format('Y-m-d H:i:s'); 
		
		insert('rss',$s_data);  
		sys::save_log('create','rss','เพิ่ม RssFeed '.$rss_title); 	
		
	unset($a_data);
	unset($s_data);
	
	exit;	
break;	
} 
?>