<?php
include("assets/config.inc.php");
include("../lib/function.php");
include("../lib/user_config.php");
include("../lib/connect.php");

$a_data = array_merge($_POST, $_FILES);

if($a_data['proc'] == 'album_cate_comment'){
	
	if($a_data['chkpic'] == $a_data['capt']){ 	
	
		unset($fields);
		$fields['category_id'] = $a_data['category_id'];
		$fields['img_id'] = $a_data['img_id'];
		//$fields['choice'] = $choice;
		$fields['name'] = $a_data['name'];
		$fields['comment'] = $a_data['comment'];
		//$fields['vote'] = $vote;
		$fields['com_date'] = date('Y-m-d H:i:s');
		$fields['ip'] = $_SERVER['REMOTE_ADDR'];
		//$fields['email'] = $email;
		
		insert("gallery_comment", $fields);

		echo json_encode($s_data);	
		exit;
	}
}
?>