<?php
include("../EWT_ADMIN/comtop_pop.php");

$a_data = array_merge($_POST, $_FILES);
$s_data = array();

$date = new DateTime();

switch($proc)  
{
	case "EditPageSize":

	$pre_id     = 	ready($a_data['pre_id']);
	$s_sql 		= 	$db->query("SELECT * FROM ebook_preset WHERE ebook_preset_id = '{$pre_id}'");
	$a_preset 	= 	$db->db_fetch_array($s_sql);	
	$a_rows  	= 	$db->db_num_rows($s_sql);  	
	 
	if($a_rows) 
	{ 
		
		$s_data['ebook_preset_status'] 	= 	$a_data['e_page_size_show']; 
		$s_data['ebook_preset_name'] 	= 	$a_data['e_page_size_title'];
		$s_data['ebook_preset_w'] 		= 	$a_data['e_page_size_width'];
		$s_data['ebook_preset_h'] 		= 	$a_data['e_page_size_height'];
		
		//$db->write_log("update","Ebook",$txt_ebook_page_size_edit.' '.$a_preset['ebook_preset_name']);  
		sys::save_log('update','Ebook',$txt_ebook_page_size_edit.' '.$a_preset['ebook_preset_name']); 
		
		update('ebook_preset',$s_data,array('ebook_preset_id'=>$pre_id));    	 
	}
	
	unset($a_data);
	unset($s_data);
	
	exit;	
break;

	case "DelItem":
	
	$m_id     	= 	ready($a_data['m_id']);	
	$mp_pid 	= 	ready($a_data['mp_pid']);	 
	
	$s_sql 		= 	$db->query("SELECT mp_name FROM menu_properties WHERE m_id = '{$m_id}' AND  mp_pid = '{$mp_pid}' ");
	$a_menu 	= 	$db->db_fetch_array($s_sql);	
	$a_rows  	= 	$db->db_num_rows($s_sql);  	
	if($a_rows) 
	{ 
		$db->write_log("delete","menu","ลบเมนูย่อย".$a_menu['m_name']); 
	
		$db->query("DELETE FROM menu_properties WHERE m_id = '{$m_id}' AND  mp_pid = '{$mp_pid}' "); 	
	}	
	unset($a_data);
	unset($s_data);	 		

	exit;	
break;
	
} 
?>