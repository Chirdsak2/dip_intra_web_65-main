<?php
session_start();
include("lib/function.php");
include("lib/user_config.php");
include("lib/connect.php");

$path_cal = "";
$ip_data = getenv("REMOTE_ADDR");
$date_data = date('Y-m-d');
$name_guest=$_REQUEST['name_guest'];
$comment_guest=$_REQUEST['comment_guest'];

/*$get_old_ip = " SELECT * FROM guestbook_list WHERE ip_guest LIKE '$ip_data' and date_guest = '".$date_data."' ";
$query_old_ip = $db->query($get_old_ip);
$num = mysql_num_rows($query_old_ip);
if($num > 0){
print " <script>
		 				alert('        ไม่สามารถบันทึกได้เนื่องจาก\\n ท่านได้ร่วมแสดงความคิดเห็นแล้ว'); 
		 				self.location.href='main.php?filename=index';
		 			</script>";
exit;
}*/
if( !empty($name_guest) && !empty($comment_guest)){
/* recipients */
		$query_mail = mysql_query("SELECT guest_config_email,guest_config_apply_auto FROM guest_config");
		$to_rec  = mysql_fetch_array($query_mail);// note the comma
		
		
		$name_guest = stripslashes(htmlspecialchars($name_guest,ENT_QUOTES));
		$comment_guest = stripslashes(htmlspecialchars($comment_guest ,ENT_QUOTES));
		$add_sql = "INSERT INTO guestbook_list(name_guest,detail_guest,date_guest,ip_guest,time_guest,status_guest,country_province,unit_guest,title_message) VALUES ('$name_guest','$comment_guest','$date_data','$ip_data',NOW(),'".$to_rec[guest_config_apply_auto]."','$email','$unit','$_POST[gc_id]')";
		 mysql_query($add_sql);
		 
		
		$to = $to_rec['guest_config_email'];
		$mail_user = array($to);
		$sql_module ="select * from email_config where module ='gusebook'";
		$query_module = $db->query($sql_module); 
		while($rec_module = $db->db_fetch_array($query_module)){
		array_push($mail_user,$rec_module[email]);
		}
		
		$sql_guest_config ="select * from guest_config ";
		$query_guest_config = $db->query($sql_guest_config); 
		$rec_guest_config = $db->db_fetch_array($query_guest_config);
		$main_mail = $rec_module[guest_config_email];
		
		/* subject */
		$subject = "ข้อมูลการบันทึกสมุดเยี่ยมชม   วันที่ ".$date_data;
		
		/* message */
		$message = '
		<html>
		<head>
		<title>'.$subject.' </title>
		</head>
		<body>
		<table>
		<tr>
		  <td>วันที่&nbsp;&nbsp; :&nbsp;</td>
		  <td>&nbsp;&nbsp;'.$date_data.'</td>
		</tr>
		<tr>
		  <td>ข้อความที่ส่ง&nbsp;&nbsp; :&nbsp;</td>
		  <td>&nbsp;&nbsp;'.$comment_guest.'</td>
		</tr>
		<tr>
		  <td>ชื่อผู้ส่งสมุดเยี่ยมชม&nbsp;&nbsp; :&nbsp;</td>
		  <td>&nbsp;&nbsp;'.$name_guest.'&nbsp;&nbsp;email &nbsp;&nbsp;:&nbsp;&nbsp;'.$provice_ctry.'&nbsp;&nbsp;หน่วยงาน/สังกัด &nbsp;&nbsp;:&nbsp;&nbsp;'.$unit.'&nbsp;&nbsp;IP &nbsp;&nbsp;:&nbsp;&nbsp;'.$ip_data.'</td>
		</tr>
		</table>
		</body>
		</html>
		';
		
		/* To send HTML mail, you can set the Content-type header. */
		$headers  = "MIME-Version: 1.0\r\n";
		$headers .= "Content-type: text/html; charset=UTF-8\r\n";
		
		/* additional headers */
		$headers2 = $headers."To: ".$main_mail." \r\n";
		$headers2 .= "From: ระบบแจ้งเตือนสมุดเยี่ยมชม \r\n";
		
		$headers .= "To: ".implode(",", $mail_user)." \r\n";
		$headers .= "From: ระบบแจ้งเตือนสมุดเยี่ยมชม \r\n";
		
		/* and now mail it */
	     @mail(implode(";", $mail_user), $subject, $message, $headers);
		  @mail($main_mail, $subject, $message, $headers2);
		 /*print " <script>
		 				
		 				self.location.href='main.php?filename=index';
						window.opener.location.reload();
		 			</script>";*/
					if($to_rec["guest_config_apply_auto"]=='N'){
					print " <script>
					alert('ข้อความของท่านถูกส่งมายังเราเพื่อพิจารณานำขึ้นแสดงบนเว็บเพจเรียบร้อยแล้ว\\n ขอขอบพระคุณ'); 
					window.close();
		 			</script>";
				}else{
					print " <script>
					alert('ส่งข้อมูลของท่านเรียบร้อยแล้ว\\n ขอขอบพระคุณ'); 
					window.close();
		 			</script>";
				}
}else{
		 print " <script>
		 				alert('        ไม่สามารถบันทึกได้เนื่องจาก\\nไม่มีข้อความ หรือ ชื่อผู้แสดงความคิดเห็น'); 
		 				self.location.href='guestbook.php';
		 			</script>";
}
$db->db_close(); 
?>
