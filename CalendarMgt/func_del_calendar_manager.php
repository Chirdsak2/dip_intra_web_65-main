<?php
ini_set('display_errors', '1');
ini_set('display_startup_errors', '1');
error_reporting(E_ALL);
include("../EWT_ADMIN/comtop_pop.php");
$a_data = array_merge($_POST, $_FILES);
$s_data = array();
$proc = $a_data['proc'];
   
switch($proc)    
{
	case "DelCalM": 
	
		$m_id     	= 	ready($a_data['id']);  
		$s_sql 		= 	$db->query("SELECT m_name,m_surname FROM cal_manager WHERE m_id = '{$m_id}'"); 
		$a_manage 	= 	$db->db_fetch_array($s_sql);	
		$a_rows  	= 	$db->db_num_rows($s_sql);  	
	
		sys::save_log('delete','calendar','ลบผู้บริหาร  '.$a_manage['m_name'].''.$a_manage['m_surname']);  
		if($a_rows)
		{ 
			$db->query("DELETE FROM cal_manager WHERE m_id = '{$m_id}' "); 

			$c_sql 		= 	$db->query("SELECT cat_id FROM cal_category WHERE cat_manager = '{$m_id}'"); 
			$a_category = 	$db->db_fetch_array($c_sql);	
			$c_rows  	= 	$db->db_num_rows($c_sql); 
			if($c_rows){
				$db->query("DELETE FROM cal_event WHERE cat_id = '{$a_category['cat_id']}' "); 
				$db->query("DELETE FROM cal_category WHERE cat_manager = '{$m_id}' ");
			}
			
		}
	echo json_encode($s_data); 	
	
	unset($a_data);
	unset($s_data);
	
	exit;	
break;	
} 
?>