<?php
include("../assets/config.inc.php");
include("../../lib/function.php");
include("../../lib/user_config.php");
include("../../lib/connect.php");

$a_data = array_merge($_POST, $_FILES);
$s_data = array();

if($a_data['proc'] == 'CountAll'){
	
log_view($a_data['s_module'],$a_data['s_module_table'],$a_data['s_id'],$a_data['s_module_detail'],$_SESSTION['EWT_MID']);

echo json_encode($a_data);	
unset($a_data);
unset($s_data);

exit;
}	
?>
