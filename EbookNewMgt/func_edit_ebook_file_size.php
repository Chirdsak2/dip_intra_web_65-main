<?php
include("../EWT_ADMIN/comtop_pop.php");

$a_data = array_merge($_POST, $_FILES);
$s_data = array();

$date = new DateTime();

switch($proc)  
{
	case "Edit_FileSize":

	for($i = 1; $i <= $a_data['all']; $i++)
	{	
 
		$s_data['ebook_value']  = $a_data['ebook_value_'.$i]; 
			
		  
	update('ebook_value',$s_data,array('ebook_value_id'=>$i));   	
		
	}
			
	$db->write_log("update","Ebook","แก้ไขจัดการขนาดไฟล์");   
	
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