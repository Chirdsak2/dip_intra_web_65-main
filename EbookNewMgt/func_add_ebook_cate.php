<?php
include("../EWT_ADMIN/comtop_pop.php");

$a_data = array_merge($_POST, $_FILES);
$s_data = array();

$date = new DateTime();

switch($proc)  
{
	case "Add_EbookCate":
	
		$s_data['g_ebook_name'] 	= $a_data['e_cate_name'];
		$s_data['g_ebook_status'] 	= $a_data['e_cate_status'];
		$s_data['g_ebook_timestamp'] 	= $date->format('Y-m-d H:i:s');
		sys::save_log('create','Ebook',$txt_ebook_cate_add.' '.$a_data['e_cate_name']);
		//$db->write_log("create","Ebook","แก้ไขหมวด e-book".$a_group['g_ebook_name']); 
		insert('ebook_group',$s_data); 
		
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