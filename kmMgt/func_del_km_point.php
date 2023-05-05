<?php
include("../EWT_ADMIN/comtop_pop.php");
$a_data = array_merge($_POST, $_FILES);
$s_data = array();
$proc = $a_data['proc'];
   
switch($proc)    
{
	case "DelKmPoint":  
		$m_id     	= 	ready($a_data['id']);  
		$s_sql 		= 	$db->query("SELECT * FROM km_point WHERE id = '{$m_id}'"); 
		$a_res 		= 	$db->db_fetch_array($s_sql);	 
		$a_rows  	= 	$db->db_num_rows($s_sql);  	
	
		sys::save_log('delete','km_point','ลบ KM '.$a_res['km_name']);   
		if($a_rows)
		{ 
			$dir_base = "../ewt/".$_SESSION['EWT_SUSER']."/assets/img/icon/";	
			if(file_exists($dir_base.$a_res['km_image']) && $a_res['km_image'] != '')
			{			
				unlink($dir_base.$a_res['km_image']); 			
			}
			$db->query("DELETE FROM km_point WHERE id = '{$m_id}' ");   
		}
	echo json_encode($s_data); 	
	unset($a_data);
	unset($s_data);
	exit;	
break;	
}
