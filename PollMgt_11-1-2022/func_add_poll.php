<?php
include("../EWT_ADMIN/comtop_pop.php");

$date = new DateTime();

$a_data = array_merge($_POST, $_FILES);
	
if($a_data['proc']=='Add_Poll'){

$timeH = $a_data['poll_H']*3600;
$timeM = $a_data['poll_M']*60;
$timeSet = $timeH+$timeM;
	
$s_data = array();

$s_data['c_name']       =  $a_data['poll_title'];
$s_data['c_use']        =  '';
$s_data['c_detail']     =  $a_data['poll_detail'];
$s_data['c_timestamp']  =  $date->format('Y-m-d H:i:s');
$s_data['c_uid']        =  $_SESSION['EWT_SMID'];
$s_data['c_creater']    =  $_SESSION["EWT_SMUSER"];
$s_data['c_lastupdate'] =  $date->format('Y-m-d H:i:s');
$s_data['c_ip']         =  getIP;
$s_data['c_start']      =  $a_data['start_date'];
$s_data['c_stop']       =  $a_data['end_date'];
$s_data['c_approve']    =  $a_data['poll_show'];
$s_data['c_timestart']  =  '';
$s_data['c_timestop']   =  '';
$s_data['c_view']       =  '0';
$s_data['c_set_time']   =  $timeSet;
//$a_data['page_id_array'];
//for($i=0; $i<count($a_data['page_id_array']); $i++){
	
//$s_data['faq_cate_order']  = $i+1;
	
//update('faq_category',$s_data,array('faq_cate_id'=>$a_data['page_id_array'][$i]));
	
//}

insert('poll_cat',$s_data);

$_max = countmax('poll_cat','c_id');

$db->write_log("create","poll","เพิ่มแบบสำรวจ ".$a_data['poll_title']);	

echo json_encode($_max);
//echo json_encode($s_data);								   
//print_r($a_data);	
unset($a_data);
unset($s_data);

exit;
}else{ 

	$a_error['message'] = 'กรุณาใส่ให้ถูกต้อง';
	echo json_encode($a_error);
	unset($a_data);
	unset($s_data);
	exit;   
  
	} 
?>