<?php
include("../EWT_ADMIN/comtop_pop.php");
$a_data = array_merge($_POST, $_FILES);
$s_data = array();
$proc = $a_data['proc'];
   
switch($proc)    
{
	case "DelEcardList":  
	
		$m_id     	= 	ready($a_data['id']);  
		$s_sql 		= 	$db->query("SELECT * FROM ecard_list WHERE ec_id = '{$m_id}'"); 
		$a_res 		= 	$db->db_fetch_array($s_sql);	 
		$a_rows  	= 	$db->db_num_rows($s_sql);  	
	
		sys::save_log('delete','ecard','ลบการ์ดอวยพร  '.$a_res['ec_name']);   
		if($a_rows)
		{ 
			$dir_base = "../ewt/".$_SESSION['EWT_SUSER']."/assets/images/ecard/";	
			if(file_exists($dir_base.$a_res['ec_filename']) && $a_res['ec_filename'] != '')
			{			
				unlink($dir_base.$a_res['ec_filename']); 			
			}
			$db->query("DELETE FROM ecard_list WHERE ec_id = '{$m_id}' ");   
		}
	echo json_encode($s_data); 	
	
	unset($a_data);
	unset($s_data);
	
	exit;	
break;	
} 


?>