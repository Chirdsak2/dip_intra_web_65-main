<?php
include("../EWT_ADMIN/comtop_pop.php");

$a_data = array_merge($_POST, $_FILES);
$s_data = array();

$date = new DateTime();

switch($proc)  
{
	case "Edit_EbookCate":

	$c_id     	= 	ready($a_data['c_id']);
	$s_sql 		= 	$db->query("SELECT * FROM ebook_group WHERE g_ebook_id = '{$c_id}'");
	$a_group 	= 	$db->db_fetch_array($s_sql);	
	$a_rows  	= 	$db->db_num_rows($s_sql);  	
	
	if($a_rows) 
	{ 
		$s_data['g_ebook_name'] = $a_data['e_cate_name'];
		$s_data['g_ebook_status'] = $a_data['e_cate_status'];
		
		
		$db->write_log("update","Ebook","แก้ไขหมวด e-book ".$a_group['g_ebook_name']); 
		
		update('ebook_group',$s_data,array('g_ebook_id'=>$c_id));  
	
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