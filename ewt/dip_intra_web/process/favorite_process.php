<?php 
//session_start();
header('Content-type: application/json; charset=utf-8');

include("../lib/function.php");
include("../lib/user_config.php");
include("../lib/connect.php");

$flag = $_POST["flag"];

if($flag=="favorite_vote"){
	$n_id = ready(filter_number($_POST['n_id']));
	
	if($_SERVER["REMOTE_ADDR"]){
		$ip_view = ready($_SERVER["REMOTE_ADDR"]);
	}else{
		$ip_view = ready($_SERVER["REMOTE_HOST"]);
	}	

	##========================================================================================##
	## >> Check if exists
	$q_img=$db->query("SELECT n_id FROM article_list WHERE n_id='$n_id'");
	
	if($db->db_num_rows($q_img)==0){
		exit();
	}
	else{
		$vote='Y';
	}
	##========================================================================================##
	
	if(trim($ip_view)!=""){
		$current_datetime = date("Y-m-d H:i:s"); 
		
		$revote_data = $db->query(" SELECT   fav_datetime 
									FROM     article_favorite_log 
									WHERE    fav_ipaddress = '$ip_view' 
									ORDER BY fav_datetime DESC 
									LIMIT 1");
		if($db->db_num_rows($revote_data)>0){
			$revote_info = $db->db_fetch_array($revote_data);
			if(strtotime($current_datetime)<(strtotime($revote_info["fav_datetime"])+(24*60*60))){
				$message = 'ท่านได้โหวตให้คะแนนรูปภาพนี้ไปแล้ว';
			}
			else{
				## >> Favorite history
				$db->query("INSERT INTO article_favorite_log (n_id,fav_ipaddress,fav_datetime)
							VALUES ('$n_id','$ip_view',NOW())");
				
				$db->query("UPDATE article_list SET favorite_count=favorite_count+1 WHERE n_id='$n_id'");
				$message = 'ขอบคุณสำหรับการโหวต';

			}
		}
		else{
			## >> Favorite history
			$db->query("INSERT INTO article_favorite_log (n_id,fav_ipaddress,fav_datetime)
						VALUES ('$n_id','$ip_view',NOW())");
			
			$db->query("UPDATE article_list SET favorite_count=favorite_count+1 WHERE n_id='$n_id'");
			$message = 'ขอบคุณสำหรับการโหวต';

		}

	
	}
	else{
		$message = 'ท่านได้โหวตให้คะแนนรูปภาพนี้ไปแล้ว';
	}
	

	/*	
	if($db->db_num_rows($reask_data)>0){
	$reask_info = $db->db_fetch_array($reask_data);
	if(strtotime($current_datetime) < strtotime($reask_info["reask_datetime"])){
	$reask_cookie = "N";
	}
	}
	*/


	## >> Return success
	return_data("success","$message");
}
?>