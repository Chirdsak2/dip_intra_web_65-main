<?php
include("../EWT_ADMIN/comtop_pop.php");
$a_data = array_merge($_POST, $_FILES);
$s_data = array();
$proc = $a_data['proc'];
   
switch($proc)    
{
	case "DelEmo": 
	
		$emo_id     = 	ready($a_data['id']);  
		$s_sql 		= 	$db->query("SELECT * FROM emotion WHERE emotion_id = '{$emo_id}'"); 
		$a_emo 		= 	$db->db_fetch_array($s_sql);	
		$a_rows  	= 	$db->db_num_rows($s_sql);  	
		$dir_base2 	= 	"../ewt/".$_SESSION['EWT_SUSER']."/";	
		sys::save_log('delete','webboard','ลบ emotion  '.$a_emo['emotion_character']);  
		if($a_rows)
		{ 
			$db->query("DELETE FROM emotion WHERE emotion_id = '{$emo_id}' "); 
			
			if(file_exists($dir_base2.$a_emo['emotion_img']) && $a_emo['emotion_img'] != '') 
			{			
				@unlink($dir_base2.$a_emo['emotion_img']);   			
			}
		}
	echo json_encode($s_data); 	 
	
	unset($a_data);
	unset($s_data);
	
	exit;	
break;	
} 
?>