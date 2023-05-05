<?php
//include("../assets/config.inc.php");
include("../../lib/function.php");
include("../../lib/user_config.php");
include("../../lib/connect.php");

$a_data = array_merge($_POST, $_FILES);
$s_data = array();

if($a_data['proc']=='ViewFaq'){
	
//$s_data['event_count'] = 'event_count' + 1;

//update('cal_event',$s_data,array('event_id'=>$a_data['id']));
$fa_id = ready(filter_number($a_data['id']));

$_query = "UPDATE faq SET fa_count = fa_count+1 WHERE fa_id = '{$fa_id}'";
$db->query($_query);

echo json_encode($s_data);	
unset($a_data);
unset($s_data);

exit;
	
}
?>
