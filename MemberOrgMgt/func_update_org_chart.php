<?php
include("../EWT_ADMIN/comtop_pop.php");

$date = new DateTime();

$a_data = array_merge($_POST, $_FILES);
	
if($a_data['proc']=='Chart_Edit'){


$s_data		=	array();

//unset($a_data);
//unset($s_data);

$a_array['status'] 	= true;
$a_array['message'] = "success";

echo json_encode($a_data['page']['id']);	
exit;

	}else{
		$a_array['status'] 	= false;
		$a_array['message'] = "error";

		echo json_encode($a_array);	
		exit;		
	} 
?>