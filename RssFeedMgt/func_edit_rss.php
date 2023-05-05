<?php
include("../EWT_ADMIN/comtop_pop.php");
$a_data = array_merge($_POST, $_FILES);
$s_data = array();
$date = new DateTime();

switch($proc)   
{
	case "Edit_Rss": 
	
		$rss_title = stripslashes(htmlspecialchars($a_data['rss_title'],ENT_QUOTES));
		$rss_url = stripslashes(htmlspecialchars($a_data['rss_url'],ENT_QUOTES));
		$s_data['rss_title'] 	= 	$rss_title;
		$s_data['rss_url'] 		= 	$rss_url; 
		$s_data['rss_row'] 		= 	$a_data['rss_row'];  
		$s_data['rss_status'] 	= 	$a_data['rss_status'];
		$s_data['rss_images'] 	= 	$a_data['rss_images']; 
		$s_data['update_date'] 	= 	$date->format('Y-m-d');
			
		update('rss',$s_data,array('rss_id'=>$a_data['rss_id']));  	
		sys::save_log('update','rss','แก้ไข RssFeed '.$rss_title); 
	
	echo json_encode($s_data); 	
	
	unset($a_data);
	unset($s_data);
	
	exit;	
break;	
} 
?>