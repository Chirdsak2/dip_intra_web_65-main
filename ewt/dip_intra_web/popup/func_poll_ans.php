<?php
include("assets/config.inc.php");
include("../lib/function.php");
include("../lib/user_config.php");
include("../lib/connect.php");

$a_data = array_merge($_POST, $_FILES);

if($a_data['proc'] == 'poll_ans'){
	
	if($a_data['chkpic'] == $a_data['capt']){ 
	
		unset($fields);
		$fields['c_id'] = $a_data['c_id'];
		$fields['a_id'] = $a_data['a_id'];
		$fields['ip'] = $_SERVER['REMOTE_ADDR'];
		$fields['date'] = date('Y-m-d');
		$fields['time'] = date('H:i:s');
		insert("poll_log", $fields);
		
		$db->query("update poll_ans set a_counter = (a_counter+1) where a_id = '".$a_data['a_id']."'");
		
		if($a_data['c_set_time'] > 0){
			$cookie_name = "POLL_".$a_data['c_id'];
			$cookie_value = "Y";
			setcookie($cookie_name, $cookie_value, time() + $a_data['c_set_time'], "/");
		}

		echo json_encode($s_data);	
		exit;
	}
}
?>