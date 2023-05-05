<?php
include("../EWT_ADMIN/comtop_pop.php");

$a_data = array_merge($_POST, $_FILES);
$s_data = array();

$date = new DateTime();

switch($proc) 
{
	case "DelMenu":

	$m_id     	= 	ready($a_data['m_id']);
	$s_sql 		= 	$db->query("SELECT m_name FROM menu_list WHERE m_id = '{$m_id}'");
	$a_menu 	= 	$db->db_fetch_array($s_sql);	
	$a_rows  	= 	$db->db_num_rows($s_sql);  	
	
	if($a_rows)
	{ 
		$s_data['m_show'] = '';
		
		$db->write_log("delete","menu","ลบเมนู".$a_menu['m_name']); 
		
		update('menu_list',$s_data,array('m_id'=>$m_id));  
		//$db->query("DELETE FROM menu_list WHERE m_id = '$m_id'");
		//$db->query("DELETE FROM menu_properties WHERE m_id = '$m_id'");
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