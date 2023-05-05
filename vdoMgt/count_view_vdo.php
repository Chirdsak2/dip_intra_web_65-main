<?php
include("../EWT_ADMIN/comtop.php");

$a_data = array_merge($_POST, $_FILES);
$s_data = array();

if($a_data['proc']=='CountVdo'){
	
//$s_data['event_count'] = 'event_count' + 1;

//update('cal_event',$s_data,array('event_id'=>$a_data['id']));

$_query = "UPDATE vdo_list SET vdo_count = vdo_count+1 WHERE vdo_id = '{$a_data['id']}'";
$db->query($_query);

echo json_encode($s_data);	
unset($a_data);
unset($s_data);

exit;
	
}
?>