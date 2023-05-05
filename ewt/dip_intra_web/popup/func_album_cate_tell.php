<?php
include("assets/config.inc.php");
include("../lib/function.php");
include("../lib/user_config.php");
include("../lib/connect.php");

$a_data = array_merge($_POST, $_FILES);

if($a_data['proc'] == 'album_cate_tell'){
	
	if($a_data['chkpic'] == $a_data['capt']){ 	
	
		$s_gal_cate = "SELECT * FROM gallery_category WHERE category_id = '".$a_data['category_id']."' ";
		$q_gal_cate = $db->query($s_gal_cate);
		$a_gal_cate = $db->db_fetch_array($q_gal_cate);
				
		$to = trim($a_data['email-recipient']);

		$subject = "=?UTF-8?B?".base64_encode("Tell a friend")."?=";		
		$message = '
				<html>
					<head>
						<title>'.$subject.'</title>
					</head>
					<body>
						<table bgcolor = "#EEEEEE" border = "0" width = "100%">
							<tr><td bgcolor = "#EEEEEE">Link '.$a_gal_cate['category_name'].' : <a href='.$_SERVER['SERVER_NAME'].'/ewtadmin86_otcc/ewt/otcc_web/album.php?category_id='.$a_data['category_id'].'>คลิกที่นี่</a></td></tr>
						</table><br><br>
						<table bgcolor = "#FFFFFF" border = "0" width = "100%">
							<tr>
								<td width="10%">ผู้ส่ง : </td>
								<td width="90%">'.$a_data['name-sender'].'</td>
							</tr>
							<tr>
								<td >ความคิดเห็น : </td>
								<td >'.$a_data['detail-sender'].'</td>
							</tr>
						</table><br><br>
					</body>
				</html>';
		$from = "<info@otcc.or.th>";
		$headers  = "MIME-Version: 1.0\r\n";
		$headers .= "Content-type: text/html; charset=UTF-8\r\n";
		$headers .= "To: ".$to." \r\n";
		$headers .= "From: OTCC Webmaster".$from."  \r\n";
		// Send
		@mail($to, $subject, $message, $headers);	
		echo json_encode($s_data);	
		unset($a_data);
		unset($s_data);
		exit;
	}
}
?>