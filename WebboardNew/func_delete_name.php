<?php
include("../EWT_ADMIN/comtop_pop.php");

$a_data = array_merge($_POST, $_FILES);

if($a_data['proc']=='Delete_Name'){
	
	$db->query("DELETE FROM w_name WHERE w_name_id='$a_data[w_name_id]'");

	exit;
}
else{ 

	exit;   
  
	} 
?>