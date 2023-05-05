<?php
include("assets/config.inc.php");
include("../lib/function.php");
include("../lib/user_config.php");
include("../lib/connect.php");
 
$date = new DateTime();
$a_data = array_merge($_POST, $_FILES);
$s_data = array();

if($a_data['proc']=='Cal_Add_Registor'){

if($a_data['chkpic'] == $a_data['capt']){ 

	
$s_data['cal_event_id']            = 	$a_data['event_id'];
$s_data['cal_registor_name']      = 	$a_data['Name-Surname-calendar'];
$s_data['cal_registor_idcard']     = 	str_replace("-","",$a_data['ID-calendar']);
$s_data['cal_registor_tel']        = 	str_replace("-","",$a_data['tel-calendar']);
$s_data['cal_registor_email']      = 	$a_data['email-calendar'];	
$s_data['cal_registor_createdate'] = 	$date->format('Y-m-d H:i:s');


insert('cal_registor_event',$s_data);
	
	
echo json_encode($s_data);	
unset($a_data);
unset($s_data);

exit;
}	
}
?>