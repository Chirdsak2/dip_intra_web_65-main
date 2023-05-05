<?php
include("../EWT_ADMIN/comtop_pop.php");


//$date = new DateTime();

$a_data = array_merge($_POST, $_FILES);
$s_data = array();	


if($a_data['proc']=='DelBanCate'){
	
del('banner_group','banner_gid='.$a_data['id']);

		   
//print_r($s_data);	
echo json_encode($s_data);	
unset($a_data);
unset($s_data);

exit;
	}
	
?>