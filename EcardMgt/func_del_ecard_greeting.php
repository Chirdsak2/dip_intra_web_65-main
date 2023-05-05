<?php
include("../EWT_ADMIN/comtop_pop.php");
$a_data = array_merge($_POST, $_FILES);
$s_data = array();
$proc = $a_data['proc'];
   
switch($proc)    
{
	case "DelEcardGreeting": 
	
		$c_id     	= 	ready($a_data['id']);  
		$s_sql 		= 	$db->query("SELECT * FROM ecard_greeting WHERE c_id = '{$c_id}'"); 
		$a_manage 	= 	$db->db_fetch_array($s_sql);	
		$a_rows  	= 	$db->db_num_rows($s_sql);  	
	
		sys::save_log('delete','ecard','ลบคำอวยพร '.$a_manage['c_detail']);  
		if($a_rows)
		{ 
			$db->query("DELETE FROM ecard_greeting WHERE c_id = '{$c_id}' "); 
		}
	echo json_encode($s_data); 	
	
	unset($a_data);
	unset($s_data);
	
	exit;	
break;	
} 


?>