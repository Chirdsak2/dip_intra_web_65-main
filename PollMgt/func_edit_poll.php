<?php
include("../EWT_ADMIN/comtop_pop.php");
$a_data = array_merge($_POST, $_FILES);

$proc = $a_data['proc'];

switch ($proc) {
	case "Edit_Poll":

		if (is_array($a_data)) {

			$timeH = $a_data['poll_H'] * 3600;
			$timeM = $a_data['poll_M'] * 60;
			$timeSet = $timeH + $timeM;

			$s_data = array();

			$s_data['c_name']       =  	$a_data['poll_title'];
			$s_data['c_detail']     =  	$a_data['poll_detail'];
			$s_data['c_lastupdate'] = 	datetimetool::getnow();
			$s_data['c_start']      =  	datetimetool::format(str_replace('/', '-', $a_data['start_date']), 'Y-m-d');
			$s_data['c_stop']       =  	datetimetool::format(str_replace('/', '-', $a_data['end_date']), 'Y-m-d');
			$s_data['c_approve']    =  	$a_data['poll_show'];
			$s_data['c_set_time']   =  	$timeSet;
			$s_data['c_status']     =   $a_data['c_status'];

			update('poll_cat', $s_data, array('c_id' => $a_data['c_id']));

			$db->write_log("update", "poll", "แก้ไขแบบสำรวจ " . $a_data['poll_title']);

			echo json_encode($a_data['c_id']);
			//echo json_encode($s_data);								   
			//print_r($a_data);	
			unset($a_data);
			unset($s_data);
			exit;
		} else {
			$a_error['message'] = 'กรุณาใส่ให้ถูกต้อง';
			echo json_encode($a_error);
			unset($a_data);
			unset($s_data);
			exit;
		}
		exit;
		break;
}
