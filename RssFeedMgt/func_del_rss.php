<?php
include("../EWT_ADMIN/comtop_pop.php");
$a_data = array_merge($_POST, $_FILES);
$s_data = array();
$proc = $a_data['proc'];   
switch($proc)    
{
	case "DelRss": 
	
		$rss_id     = 	ready($a_data['id']); 
		$s_sql 		= 	$db->query("SELECT * FROM rss WHERE rss_id = '{$rss_id}'");
		$a_rss 		= 	$db->db_fetch_array($s_sql);	
		$a_rows  	= 	$db->db_num_rows($s_sql);  	
	
		sys::save_log('delete','rss','ลบ RssFeed '.$a_rss['rss_title']);  
		if($a_rows)
		{ 
			$db->query("DELETE FROM rss WHERE rss_id = '{$rss_id}' "); 
		}
	echo json_encode($s_data); 	
	
	unset($a_data);
	unset($s_data);
	
	exit;	
break;	
}  
?>