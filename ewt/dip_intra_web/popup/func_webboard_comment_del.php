<?php
include("assets/config.inc.php");
include("../lib/function.php");
include("../lib/user_config.php");
include("../lib/connect.php");

$chk_config = $db->query("SELECT * FROM w_config WHERE c_config = '1'");
$CONF = $db->db_fetch_array($chk_config);
if(isset($_POST["proc"]) && $_POST["proc"] == "Delanswer")
{

	
		$Request_type='A';
		//$wtid=$_POST['wtid'];
		$waid=$_POST['waid'];	
		$amsg=$_POST['del_comment'];
		//$aemail=$_POST['mail'];
		//$name=$_POST['name'];
		//$wc = $_POST['wc'];
		$tid = $_POST['tid'];
		$aid = $_POST['aid'];
		
		$sql_intsert_delanswer = "INSERT INTO `w_question_sts_request` (
											`t_id`,
											`a_id`,
											`request_createdate`,
											`request_lastdate`,
											`requestor_ip`,
											`request_reason`,
											`request_type`,
											`request_wid`,
											`request_email`
											) 
											VALUES ('".$tid."',
											'".$aid."',
											NOW( ),
											NOW( ),
											'".getIP()."',
											'".$amsg."',
											'".$Request_type."',
											'".$_SESSION['EWT_SMID']."',
											'".$aemail."'
											)";									
																				
	$db->query($sql_intsert_delanswer);

	
    //====================
    // ส่งอีเมล์แจ้งการลบ
	//====================
	
	$sql_question = "SELECT *
		             FROM w_question 
		             WHERE t_id='$tid'";

	$chk_question = $db->query($sql_question);
	$question     = $db->db_fetch_array($chk_question);   		

	//==========================

	if($_SESSION[EWT_SMID]){
		$db->query("USE ewt_user_otcc");

		$sql_deleter = "SELECT * FROM gen_user WHERE gen_user_id ='$_SESSION[EWT_SMID]'";
		$chk_deleter = $db->query($sql_deleter);
		$deleter     = $db->db_fetch_array($chk_deleter);

		$db->query("USE db_76_phetchabun2");
	}
	//==========================

	$room_id = $question["c_id"];

    $sql_tid = "SELECT DISTINCT(t_id) 
                FROM w_permission 
                WHERE c_id='$room_id'";

    $chk_tid = $db->query($sql_tid);
    $tid_rows = $db->db_num_rows($chk_tid);	

    $sql_thisroom = "SELECT c_name 
                     FROM w_cate
                     WHERE c_id='$room_id'";
    $chk_thisroom = $db->query($sql_thisroom);
    $thisroom     = $db->db_fetch_array($chk_thisroom);   	


	$db->query("USE ewt_user_otcc");

    if($tid_rows>0){

        while($admin = $db->db_fetch_array($chk_tid)){

            $sql_email = "SELECT email_person FROM gen_user WHERE gen_user_id ='$admin[t_id]'";
            $chk_email = $db->query($sql_email);
            $user      = $db->db_fetch_array($chk_email);

            if($user["email_person"]){            

				if((!$deleter[name_thai])&&(!$deleter[surname_thai])){
					$deleter[name_thai] = "Anonymous";
					$deleter[surname_thai] = "";
				}

                $subject    = "<b>หัวข้อ</b>: การแจ้งลบความคิดเห็น";
                $mailmaster = "OTCC WEB System";
                $body       = "มีการแจ้งลบความคิดเห็นกระทู้ภายใต้หมวด ".$thisroom["c_name"]." กระทู้ ".$question["t_name"]." โดยคุณ ".$deleter[name_thai]." ".$deleter[surname_thai];
                
                $strTo2     = $user["email_person"];

                $strSubject2 = "=?UTF-8?B?".base64_encode("แจ้งลบความคิดเห็น")."?=";
                $strHeader2  = "MIME-Version: 1.0' . \r\n";
                $strHeader2 .= "Content-type: text/html; charset=utf-8\r\n"; 
                
                $strHeader2 .= "From: ".$mailmaster."\r\n";
                
                $strMessage .= $subject."<br>";
                $strMessage .= $body."<br>";

                $flgSends = @mail($strTo2,$strSubject2,$strMessage,$strHeader2);

            }

        }

        

	}
	
	$strMessage="";

	$sql_email = "SELECT * FROM gen_user WHERE gen_user_id ='$question[user_id]'";
	$chk_email = $db->query($sql_email);
	$user      = $db->db_fetch_array($chk_email);

	if($user["email_person"]){            

		$subject    = "<b>หัวข้อ</b>: การแจ้งลบความคิดเห็น";
		$mailmaster = "OTCC WEB System";
		$body       = "เรียนคุณ ".$user["name_thai"]." ".$user["surname_thai"]."<br>";
		$body       .= "มีการแจ้งลบความคิดเห็นกระทู้ภายใต้หมวด ".$thisroom["c_name"]." กระทู้ ".$question["t_name"]." โดยคุณ ".$deleter[name_thai]." ".$deleter[surname_thai];
		
		$strTo2     = $user["email_person"];

		$strSubject2 = "=?UTF-8?B?".base64_encode("แจ้งลบความคิดเห็น")."?=";
		$strHeader2  = "MIME-Version: 1.0' . \r\n";
		$strHeader2 .= "Content-type: text/html; charset=utf-8\r\n"; 
		
		$strHeader2 .= "From: ".$mailmaster."\r\n";
		
		$strMessage .= $subject."<br>";
		$strMessage .= $body."<br>";

		$flgSends = @mail($strTo2,$strSubject2,$strMessage,$strHeader2);

	}
    //====================   
    
    $db->query("USE db_76_phetchabun2");



	/*unset($fields);
	$fields['t_id'] = $tid;
	$fields['a_id'] = $aid;
	$fields['request_createdate'] = date('Y-m-d H:i:s');
	$fields['request_lastdate'] = date('Y-m-d H:i:s');
	$fields['requestor_ip'] = getIP();
	$fields['request_reason'] = $amsg;
	$fields['request_type'] = $Request_type;
	$fields['request_wid'] = $_SESSION['EWT_MID'];
	$fields['request_email'] = $aemail;

	insert("w_question_sts_request", $fields);*/
	/*
	$txtmailsender = $CONF['c_mail'];

	if($mail!= ""){
	$to = $mail;
	$to2 = $txtmailsender;
	$subject = "=?UTF-8?B?".base64_encode("แจ้งตอบรับการแจ้งลบความคิดเห็น")."?=";
	$subject2 = "=?UTF-8?B?".base64_encode("แจ้งลบความคิดเห็น ผู้ดูแลระบบ")."?=";	
		
	$message = '<html>
			<head>
			<title>'.$subject.'</title>
			</head>
			<body>
			<table bgcolor = "#EEEEEE" border = "0" width = "100%">
				<tr><td bgcolor = "#EEEEEE">แจ้งลบความคิดเห็น</td></tr>
				<tr>&nbsp;&nbsp;<td bgcolor = "#EEEEEE">แจ้งลบความคิดเห็นของท่านจัดเก็บเข้าสู่ระบบเรียบร้อบแล้ว</td></tr>
				<tr>&nbsp;&nbsp;<td bgcolor = "#EEEEEE">รอการพิจารณาจากผู้ดูแลระบบ</td></tr>
			</table><br><br><br>
			<table bgcolor = "#EEEEEE" border = "0" width = "100%">
				<tr><td bgcolor = "#EEEEEE">รายละเอียดแจ้งลบความคิดเห็นของท่าน </td></tr>
				<tr>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<td bgcolor = "#EEEEEE">ความคิดเห็น&nbsp;:&nbsp;&nbsp;'.$amsg.'</td></tr>
				<tr>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<td bgcolor = "#EEEEEE">ชี่อ-นามสกุล &nbsp;:&nbsp;&nbsp;'.$name.'</td></tr>
				<tr>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<td bgcolor = "#EEEEEE">อีเมล์ &nbsp;:&nbsp;&nbsp;'.$aemail.'</td></tr>

			</table><br><br>

			</body>
			</html>';
	$message2 = '
			<html>
			<head>
			<title>'.$subject2.'</title>
			</head>
			<body>
			<table bgcolor = "#EEEEEE" border = "0" width = "100%">
				<tr>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<td bgcolor = "#EEEEEE">ความคิดเห็น&nbsp;:&nbsp;&nbsp;'.$amsg.'</td></tr>
				<tr>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<td bgcolor = "#EEEEEE">ชี่อ-นามสกุล &nbsp;:&nbsp;&nbsp;'.$name.'</td></tr>
				<tr>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<td bgcolor = "#EEEEEE">อีเมล์ &nbsp;:&nbsp;&nbsp;'.$aemail.'</td></tr>
			</table><br><br>
			</body>
			</html>';
			
	$from ="<".$txtmailsender.">";
	$from2 ="<info@bizpotential.com>";

	$headers  = "MIME-Version: 1.0\r\n";
	$headers .= "Content-type: text/html; charset=UTF-8\r\n";
	$headers .= "To: ".$to." \r\n";
	$headers .= "From: ".$from."  \r\n";
	//@mail($to, $subject, $message, $headers);

	$headers2  = "MIME-Version: 1.0\r\n";
	$headers2 .= "Content-type: text/html; charset=UTF-8\r\n";
	$headers2 .= "To: ".$to2." \r\n";
	$headers2 .= "From: ".$from2."  \r\n";
	//@mail($to2, $subject2, $message2, $headers2);
	}				
	echo "<script type=\"text/javascript\">";
	echo "alert('บันทึกข้อมูลเรียบร้อยแล้ว  รอการพิจารณา');";
	echo "window.location.href = 'webboard_detail.php?wc=".$wc."&tid=".$tid."'; ";
	echo "</script>";
	 */
		   
	//echo json_encode($s_data);	
	exit;
            
}else if(isset($_POST["proc"]) && $_POST["proc"] == "Delquestion"){
		$Request_type='T';
		//$wtid=$_POST['wtid'];
		//$waid=$_POST['waid'];
		$amsg=$_POST['del_comment'];
		$aemail=$_POST['mail'];
		//$name=$_POST['name'];
		//$wc = $_POST['wc'];
		$tid = $_POST['tid'];
		$aid = $_POST['aid'];
		
		
		$sql_intsert_delquestion = "INSERT INTO `w_question_sts_request` (
										`t_id`,
										`a_id`,
										`request_createdate`,
										`request_lastdate`,
										`requestor_ip`,
										`request_reason`,
										`request_type`,
										`request_wid`,
										`request_email`
										) 
										VALUES ('".$tid."',
										'".$aid."',
										NOW( ),
										NOW( ),
										'".getIP()."',
										'".$amsg."',
										'".$Request_type."',
										'".$_SESSION['EWT_SMID']."',
										'".$aemail."'
										)";
										
																			
	$db->query($sql_intsert_delquestion);

	
    //====================
    // ส่งอีเมล์แจ้งการลบ
	//====================
	
	$sql_question = "SELECT *
		             FROM w_question 
		             WHERE t_id='$tid'";

	$chk_question = $db->query($sql_question);
	$question     = $db->db_fetch_array($chk_question);  		
	
	//==========================
	if($_SESSION[EWT_SMID]){
		$db->query("USE ewt_user_otcc");

		$sql_deleter = "SELECT * FROM gen_user WHERE gen_user_id ='$_SESSION[EWT_SMID]'";
		$chk_deleter = $db->query($sql_deleter);
		$deleter     = $db->db_fetch_array($chk_deleter);

		$db->query("USE db_76_phetchabun2");
	}
	//========================== 		

	$room_id = $question["c_id"];

    $sql_tid = "SELECT DISTINCT(t_id) 
                FROM w_permission 
                WHERE c_id='$room_id'";

    $chk_tid = $db->query($sql_tid);
    $tid_rows = $db->db_num_rows($chk_tid);	

    $sql_thisroom = "SELECT c_name 
                     FROM w_cate
                     WHERE c_id='$room_id'";
    $chk_thisroom = $db->query($sql_thisroom);
    $thisroom     = $db->db_fetch_array($chk_thisroom);   	
	
	$db->query("USE ewt_user_otcc");


    if($tid_rows>0){

        while($admin = $db->db_fetch_array($chk_tid)){

            $sql_email = "SELECT email_person FROM gen_user WHERE gen_user_id ='$admin[t_id]'";
            $chk_email = $db->query($sql_email);
            $user      = $db->db_fetch_array($chk_email);

            if($user["email_person"]){          

				if((!$deleter[name_thai])&&(!$deleter[surname_thai])){
					$deleter[name_thai] = "Anonymous";
					$deleter[surname_thai] = "";
				}

                $subject    = "<b>หัวข้อ</b>: การแจ้งลบกระทู้";
                $mailmaster = "OTCC WEB System";
                $body       = "มีการแจ้งลบกระทู้ภายใต้หมวด ".$thisroom["c_name"]." ชื่อกระทู้ ".$question["t_name"]." โดยคุณ ".$deleter[name_thai]." ".$deleter[surname_thai];
                
                $strTo2     = $user["email_person"];;

                $strSubject2 = "=?UTF-8?B?".base64_encode("แจ้งลบกระทู้")."?=";
                $strHeader2  = "MIME-Version: 1.0' . \r\n";
                $strHeader2 .= "Content-type: text/html; charset=utf-8\r\n"; 
                
                $strHeader2 .= "From: ".$mailmaster."\r\n";
                
                $strMessage .= $subject."<br>";
                $strMessage .= $body."<br>";

                $flgSends = @mail($strTo2,$strSubject2,$strMessage,$strHeader2);

            }

        }

        

	}
	
	$strMessage="";

	$sql_email = "SELECT email_person FROM gen_user WHERE gen_user_id ='$question[user_id]'";
	$chk_email = $db->query($sql_email);
	$user      = $db->db_fetch_array($chk_email);

	if($user["email_person"]){          

		$subject    = "<b>หัวข้อ</b>: การแจ้งลบกระทู้";
		$mailmaster = "OTCC WEB System";
		$body       = "เรียนคุณ ".$user["name_thai"]." ".$user["surname_thai"]."<br>";
		$body       .= "มีการแจ้งลบกระทู้ภายใต้หมวด ".$thisroom["c_name"]." ชื่อกระทู้ ".$question["t_name"]." โดยคุณ ".$deleter[name_thai]." ".$deleter[surname_thai];
		
		$strTo2     = $user["email_person"];

		$strSubject2 = "=?UTF-8?B?".base64_encode("แจ้งลบกระทู้")."?=";
		$strHeader2  = "MIME-Version: 1.0' . \r\n";
		$strHeader2 .= "Content-type: text/html; charset=utf-8\r\n"; 
		
		$strHeader2 .= "From: ".$mailmaster."\r\n";
		
		$strMessage .= $subject."<br>";
		$strMessage .= $body."<br>";

		$flgSends = @mail($strTo2,$strSubject2,$strMessage,$strHeader2);

	}
    //====================   
    
    $db->query("USE db_76_phetchabun2");
/*
$txtmailsender = $CONF['c_mail'];

if($mail!= ""){
$to = $mail;
$to2 = $txtmailsender;
$subject = "=?UTF-8?B?".base64_encode("แจ้งตอบรับการแจ้งลบกระทู้")."?=";
$subject2 = "=?UTF-8?B?".base64_encode("แจ้งลบกระทู้ ผู้ดูแลระบบ")."?=";	
	
$message = '<html>
		<head>
		<title>'.$subject.'</title>
		</head>
		<body>
		<table bgcolor = "#EEEEEE" border = "0" width = "100%">
			<tr><td bgcolor = "#EEEEEE">แจ้งตอบรับการแจ้งลบกระทู้</td></tr>
			<tr>&nbsp;&nbsp;<td bgcolor = "#EEEEEE">แจ้งลบกระทู้ของท่านจัดเก็บเข้าสู่ระบบเรียบร้อบแล้ว</td></tr>
			<tr>&nbsp;&nbsp;<td bgcolor = "#EEEEEE">รอการพิจารณาจากผู้ดูแลระบบ</td></tr>
		</table><br><br><br>
		<table bgcolor = "#EEEEEE" border = "0" width = "100%">
			<tr><td bgcolor = "#EEEEEE">รายละเอียดแจ้งลบกระทู้ของท่าน </td></tr>
			<tr>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<td bgcolor = "#EEEEEE">ความคิดเห็น&nbsp;:&nbsp;&nbsp;'.$amsg.'</td></tr>
			<tr>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<td bgcolor = "#EEEEEE">ชี่อ-นามสกุล &nbsp;:&nbsp;&nbsp;'.$name.'</td></tr>
			<tr>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<td bgcolor = "#EEEEEE">อีเมล์ &nbsp;:&nbsp;&nbsp;'.$aemail.'</td></tr>

		</table><br><br>

		</body>
		</html>';
$message2 = '
		<html>
		<head>
		<title>'.$subject2.'</title>
		</head>
		<body>
		<table bgcolor = "#EEEEEE" border = "0" width = "100%">
			<tr>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<td bgcolor = "#EEEEEE">ความคิดเห็น&nbsp;:&nbsp;&nbsp;'.$amsg.'</td></tr>
			<tr>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<td bgcolor = "#EEEEEE">ชี่อ-นามสกุล &nbsp;:&nbsp;&nbsp;'.$name.'</td></tr>
			<tr>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<td bgcolor = "#EEEEEE">อีเมล์ &nbsp;:&nbsp;&nbsp;'.$aemail.'</td></tr>
		</table><br><br>
		</body>
		</html>';
		
$from ="<".$txtmailsender.">";
$from2 ="<info@bizpotential.com>";

$headers  = "MIME-Version: 1.0\r\n";
$headers .= "Content-type: text/html; charset=UTF-8\r\n";
$headers .= "To: ".$to." \r\n";
$headers .= "From: ".$from."  \r\n";
//@mail($to, $subject, $message, $headers);

$headers2  = "MIME-Version: 1.0\r\n";
$headers2 .= "Content-type: text/html; charset=UTF-8\r\n";
$headers2 .= "To: ".$to2." \r\n";
$headers2 .= "From: ".$from2."  \r\n";
//@mail($to2, $subject2, $message2, $headers2);
}	

			
echo "<script type=\"text/javascript\">";
echo "alert('บันทึกข้อมูลเรียบร้อยแล้ว  รอการพิจารณา ');";
echo "window.location.href = 'webboard_detail.php?wc=".$wc."&tid=".$tid."'; ";
echo "</script>";
*/

exit;
	
}

?>
