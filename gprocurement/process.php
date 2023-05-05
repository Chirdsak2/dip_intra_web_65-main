<?php
header('Content-Type: text/html; charset=utf-8');
include("../lib/permission1.php");
include("../lib/include.php");
include("../lib/function.php");
include("../lib/user_config.php");
include("../lib/connect.php");
include("../lib/set_lang.php");


switch($proc){	

	case 'AddType' : { 
	$sql_intsert = "INSERT INTO `egp_type` (
										`egp_type_code`,
										`egp_type_name`,
										`egp_type_create`,
										`egp_type_update`,
										`egp_type_status`							
										) 
										VALUES (
												'{$_POST[topic1]}',
												'{$_POST[topic2]}',
												NOW( ),
												NOW( ),
												'Y'												
												)";
$db->query($sql_intsert);	
	
	
echo "<script type=\"text/javascript\">";
echo "alert('บันทึกข้อมูลเรียบร้อยแล้ว ');";
echo "window.history.back() ";
echo "</script>";				
}
	exit;
		break;
		
		
	case 'EditType' : { 
	
	$update = "UPDATE `egp_type` SET  
							`egp_type_code`   = '{$_POST[topic1]}'',
							`egp_type_name`   = '{$_POST[topic2]}',
							`egp_type_update` = NOW()						
							WHERE `egp_type_id` = '{$_POST[id]}' ";
	  	$db->query($update);
	
	
echo "<script type=\"text/javascript\">";
echo "alert('บันทึกข้อมูลเรียบร้อยแล้ว ');";
echo "window.history.back() ";
echo "</script>";				
}
	exit;
		break;
			
	case 'AddProc' : { 
	$sql_intsert = "INSERT INTO `egp_process` (
										`egp_process_code`,
										`egp_process_name`,
										`egp_process_create`,
										`egp_process_update`,
										`egp_process_status`							
										) 
										VALUES (
												'{$_POST[topic1]}',
												'{$_POST[topic2]}',
												NOW( ),
												NOW( ),
												'Y'												
												)";
$db->query($sql_intsert);	
	
	
echo "<script type=\"text/javascript\">";
echo "alert('บันทึกข้อมูลเรียบร้อยแล้ว ');";
echo "window.history.back() ";
echo "</script>";				
}
	exit;
		break;
		
		
	case 'EditProc' : { 
	
	$update = "UPDATE `egp_process` SET  
							`egp_process_code`   = '{$_POST[topic1]}'',
							`egp_process_name`   = '{$_POST[topic2]}',
							`egp_process_update` = NOW()						
							WHERE `egp_process_id` = '{$_POST[id]}' ";
	  	$db->query($update);
	
	
echo "<script type=\"text/javascript\">";
echo "alert('บันทึกข้อมูลเรียบร้อยแล้ว ');";
echo "window.history.back() ";
echo "</script>";				
}
	exit;
		break;
		
		case 'AddDept' : { 
	$sql_intsert = "INSERT INTO `egp_dept` (
										`egp_dept_code`,
										`egp_dept_name`,
										`egp_dept_create`,
										`egp_dept_update`,
										`egp_dept_status`,
										`egp_dept_sub`											
										) 
										VALUES (
												'{$_POST[topic1]}',
												'{$_POST[topic2]}',
												NOW( ),
												NOW( ),
												'Y',
												'0'		
												)";
$db->query($sql_intsert);	
	
	
echo "<script type=\"text/javascript\">";
echo "alert('บันทึกข้อมูลเรียบร้อยแล้ว ');";
echo "window.history.back() ";
echo "</script>";				
}
	exit;
		break;
		
		
	case 'EditDept' : { 
	
	$update = "UPDATE `egp_dept` SET  
							`egp_dept_code`   = '{$_POST[topic1]}'',
							`egp_dept_name`   = '{$_POST[topic2]}',
							`egp_dept_update` = NOW()						
							WHERE `egp_process_id` = '{$_POST[id]}' ";
	  	$db->query($update);
	
	
echo "<script type=\"text/javascript\">";
echo "alert('บันทึกข้อมูลเรียบร้อยแล้ว ');";
echo "window.history.back() ";
echo "</script>";				
}
	exit;
		break;
	

	case 'AddDeptsub' : { 
	
	$sql_intsert = "INSERT INTO `egp_dept` (
										`egp_dept_code`,
										`egp_dept_name`,
										`egp_dept_create`,
										`egp_dept_update`,
										`egp_dept_status`,
										`egp_dept_sub`											
										) 
										VALUES (
												'{$_POST[topic1]}',
												'{$_POST[topic2]}',
												NOW( ),
												NOW( ),
												'Y',
												'1'		
												)";
$db->query($sql_intsert);	
	
	
echo "<script type=\"text/javascript\">";
echo "alert('บันทึกข้อมูลเรียบร้อยแล้ว ');";
echo "window.history.back() ";
echo "</script>";				
}
	exit;
		break;
		
		
	case 'EditDeptsub' : { 
	
	$update = "UPDATE `egp_dept` SET  
							`egp_dept_code`   = '{$_POST[topic1]}'',
							`egp_dept_name`   = '{$_POST[topic2]}',
							`egp_dept_update` = NOW()						
							WHERE `egp_process_id` = '{$_POST[id]}' ";
	  	$db->query($update);
	
	
echo "<script type=\"text/javascript\">";
echo "alert('บันทึกข้อมูลเรียบร้อยแล้ว ');";
echo "window.history.back() ";
echo "</script>";				
}
	exit;
		break;	

	case 'EditProfile' : { 
	
		//  5MB maximum file size 
$MAXIMUM_FILESIZE = 5 * 1024 * 1024; 
//  Valid file extensions (images, word, excel, powerpoint) 
$rEFileTypes = 
  "/^\.(jpg|jpeg|gif|png){1}$/i"; 
$dir_base = "../../pic_upload/"; 

$dir_file_old = "../../pic_upload/".$_POST['file_old']; 

$isFile = is_uploaded_file($_FILES['file_filename']['tmp_name']); 
if ($isFile){    //  do we have a file? 
   //  sanatize file name 
    //     - remove extra spaces/convert to _, 
    //     - remove non 0-9a-Z._- characters, 
    //     - remove leading/trailing spaces 
    //  check if under 5MB, 
    //  check file extension for legal file types 
    $safe_filename = preg_replace( 
                     array("/\s+/", "/[^-\.\w]+/"), 
                     array("_", ""), 
                     trim($_FILES['file_filename']['name']));
					 
	$type_file =  strrchr($safe_filename, '.');				 
	
	$newfile = "image_file_".date("YmdHis").$type_file;
	 
    if ($_FILES['file_filename']['size'] <= $MAXIMUM_FILESIZE && preg_match($rEFileTypes, strrchr($safe_filename, '.'))) {
		
		  $isMove = move_uploaded_file ($_FILES['file_filename']['tmp_name'],$dir_base.$newfile);
		  } 
	$PICTURE = $newfile;
	
			if(file_exists($dir_file_old) && $_POST['file_old'] != '')
				{
				unlink($dir_file_old);
				}
      }else{
		  $PICTURE = $_POST['file_old'];		  	  
	  } 
		$name = $_POST['name_thai']." ".$_POST['surname_thai'];
	  
	  	session_register("EWT_IMAGE");
		session_register("EWT_NAME");
		$_SESSION["EWT_IMAGE"] = $PICTURE;
		$_SESSION["EWT_NAME"] = $name;
		
		$db->query("USE ".$EWT_DB_USER);
		$update_gen_user = "UPDATE gen_user SET  
							emp_id         = '".$_POST['emp_id']."',
							title_thai     = '".$_POST['title_thai']."',
							name_thai      = '".$_POST['name_thai']."',
							surname_thai   = '".$_POST['surname_thai']."',
							path_image     = '".$PICTURE."',
							email_person   = '".$_POST['email_person']."',
							mobile         = '".$_POST['mobile']."',
							last_update    =  NOW(),
							last_update_by = '".$_SESSION['EWT_NAME']."'
							WHERE gen_user_id = '".$_POST['genuser_id']."' ";
	  	$db->query($update_gen_user);
		
echo "<script type=\"text/javascript\">";
echo "alert('บันทึกข้อมูลเรียบร้อยแล้ว ');";
echo "window.history.back() ";
echo "</script>";		
		
}
	exit;
		break;
		
	case 'AddHelpdesk' : {
	
	$MAXIMUM_FILESIZE = 5000000;
//  Valid file extensions (images, word, excel, powerpoint) 
$rEFileTypes = 
  "/^\.(jpg|jpeg|gif|png|pdf|xls|xlsx|txt){1}$/i"; 
$dir_base = "../file_complaint/"; 

$isFile = is_uploaded_file($_FILES['file']['tmp_name']); 

if ($isFile){    //  do we have a file? 
   //  sanatize file name 
    //     - remove extra spaces/convert to _, 
    //     - remove non 0-9a-Z._- characters, 
    //     - remove leading/trailing spaces 
    //  check if under 5MB, 
    //  check file extension for legal file types 
    $safe_filename = preg_replace( 
                     array("/\s+/", "/[^-\.\w]+/"), 
                     array("_", ""), 
                     trim($_FILES['file']['name']));
					 
	$type_file =  strrchr($safe_filename, '.');				 
	
	$newfile = "complaint_fileattack_".date("YmdHis").$type_file;
	
	 
    if ($_FILES['file']['size'] <= $MAXIMUM_FILESIZE && preg_match($rEFileTypes, strrchr($safe_filename, '.'))) {
		
		  $isMove = move_uploaded_file($_FILES['file']['tmp_name'],$dir_base.$newfile);
		  } 
	$fileattack = $newfile;

      }else{
		  $fileattack = "";		  	  
	  } 
	
	$name = $_POST['helpdesk_name']." ".$_POST['helpdesk_surname'];
	$sql_intsert_helpdesk = "INSERT INTO `m_complain` (
										`name`,
										`personalid`,
										`email`,
										`detail`,
										`date`,
										`time`,
										`ip`,
										`flag`,
										`attach_img`,
										`question`
										) 
										VALUES (
												'".$name."',
												'".$_SESSION['EWT_MID']."',
												'".$_POST['helpdesk_mail']."',
												'".$_POST['helpdesk_desc']."',
												NOW( ),
												NOW( ),
												'".$_SERVER['REMOTE_ADDR']."',
												'".$_POST['dep_id']."',
												'".$fileattack."',
												'".$_POST['que_id']."'
												)";
$db->query($sql_intsert_helpdesk);	

$sql_question = $db->query("SELECT * FROM m_complain_question WHERE com_question_id = '".$_POST['que_id']."'");
$rec_question = $db->db_fetch_array($sql_question);
$question = $rec_question['com_question_name'];

$sql_complaint_admin = $db->query("SELECT * FROM m_complain_info WHERE Complain_lead_ID = '".$_POST['dep_id']."'");
$rec_admin = $db->db_fetch_array($sql_complaint_admin);

$txtmailsender = $rec_admin['Complain_lead_email'];
$orgname = $rec_admin['Complain_lead_name'];

if($_POST['helpdesk_mail']!= ""){
$to = $_POST['helpdesk_mail'];
$to2 = $txtmailsender;
$subject = "=?UTF-8?B?".base64_encode("แจ้งตอบรับเรื่องร้องเรียน")."?=";
$subject2 = "=?UTF-8?B?".base64_encode("แจ้งเรื่องร้องเรียน ผู้ดูแลระบบ")."?=";	
	
$message = '
		<html>
		<head>
		<title>'.$subject.'</title>
		</head>
		<body>
		<table bgcolor = "#EEEEEE" border = "0" width = "100%">
			<tr><td bgcolor = "#EEEEEE">แจ้งส่งเรื่องร้องเรียน </td></tr>
			<tr>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<td bgcolor = "#EEEEEE">คำถาม&nbsp;:&nbsp;&nbsp;'.$question .'</td></tr>
			<tr>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<td bgcolor = "#EEEEEE">ช่วยเหลือจากหน่วยงาน&nbsp;:&nbsp;&nbsp;'.$orgname.'</td></tr>
			<tr>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<td bgcolor = "#EEEEEE">ชี่อ-นามสกุล&nbsp;:&nbsp;&nbsp;'.$name.'</td></tr>
			<tr>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<td bgcolor = "#EEEEEE">รายละเอียด&nbsp;:&nbsp;&nbsp;'.$_POST['helpdesk_desc'].'</td></tr>
			<tr>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<td bgcolor = "#EEEEEE">อีเมล์ &nbsp;:&nbsp;&nbsp;'.$_POST['helpdesk_mail'].'</td></tr>

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
			<tr><td bgcolor = "#EEEEEE">แจ้งตอบรับเรื่องร้องเรียน</td></tr>
			<tr>&nbsp;&nbsp;<td bgcolor = "#EEEEEE">เรื่องเรียนของท่านจัดเก็บเข้าสู่ระบบเรียบร้อบแล้ว</td></tr>
			<tr>&nbsp;&nbsp;&nbsp;&nbsp;<td bgcolor = "#EEEEEE"></td></tr>
		</table><br><br><br>
		<table bgcolor = "#EEEEEE" border = "0" width = "100%">
			<tr><td bgcolor = "#EEEEEE">รายละเอียดเรื่องร้องเรียนของท่าน </td></tr>
			<tr>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<td bgcolor = "#EEEEEE">คำถาม&nbsp;:&nbsp;&nbsp;'.$question .'</td></tr>
			<tr>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<td bgcolor = "#EEEEEE">ช่วยเหลือจากหน่วยงาน&nbsp;:&nbsp;&nbsp;'.$orgname.'</td></tr>
			<tr>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<td bgcolor = "#EEEEEE">ชี่อ-นามสกุล&nbsp;:&nbsp;&nbsp;'.$name.'</td></tr>
			<tr>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<td bgcolor = "#EEEEEE">รายละเอียด&nbsp;:&nbsp;&nbsp;'.$_POST['helpdesk_desc'].'</td></tr>
			<tr>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<td bgcolor = "#EEEEEE">อีเมล์ &nbsp;:&nbsp;&nbsp;'.$_POST['helpdesk_mail'].'</td></tr>
		</table><br><br>

		</body>
		</html>';
$from ="<".$txtmailsender.">";
$from2 ="<info@bizpotential.com>";

$headers  = "MIME-Version: 1.0\r\n";
$headers .= "Content-type: text/html; charset=UTF-8\r\n";
$headers .= "To: ".$to." \r\n";
$headers .= "From: ".$from."  \r\n";
@mail($to, $subject, $message, $headers);

$headers2  = "MIME-Version: 1.0\r\n";
$headers2 .= "Content-type: text/html; charset=UTF-8\r\n";
$headers2 .= "To: ".$to2." \r\n";
$headers2 .= "From: ".$from2."  \r\n";
@mail($to2, $subject2, $message2, $headers2);
}		
		
echo "<script type=\"text/javascript\">";
echo "alert('บันทึกข้อมูลเรียบร้อยแล้ว ');";
echo "window.location.href = 'index.php'; ";
echo "</script>";		
		
}
	exit;
		break;		
		
	case 'Addvote' : {

$c_id = $_POST['cad_id'];

$sql_num = $db->query("SELECT log_work_uid FROM log_work WHERE  log_work_uid = '".$_SESSION["EWT_MID"]."' AND log_work_mdid = '".$c_id ."' AND log_work_module = 'poll'");
$rec_num = $db->db_fetch_array($sql_num);
$row_num = $db->db_num_rows($sql_num);
if($row_num > 0){
	
echo "<script type=\"text/javascript\">";
echo "alert('".$text_genpoll_message3."');";
echo "window.location.href = 'poll.php'; ";
echo "</script>";
	exit;	
}
	
	
$recValue = $db->db_fetch_array($db->query("SELECT * FROM site_info")); 

if($recValue['set_poll'] != 0 AND $recValue['set_poll'] != ""){
   $cookieTimes=$recValue['set_poll'];
   $skip = "0";
}else{
	$cookieTimes=30*24*3600;
	$skip = "1";
}
			
if($_POST['vote'] != "" AND  $_POST['flag']<>'1' ){
	
	
		$oldTime = $_COOKIE["votevote".$_POST["cad_id"]];
		$date_now = explode("-",date("Y-m-d"));
		$time_now = explode(":",date("H:i:s"));
		$newTime = mktime($time_now[0], $time_now[1], $time_now[2], $date_now[1], $date_now[2], $date_now[0]);
		$diff= ($oldTime+$cookieTimes)-$newTime;
		
		if(!isset($_COOKIE["votevote".$_POST['cad_id']]) OR $diff < 0 OR $skip == "1"){
		        $date_now = explode("-",date("Y-m-d"));
				$time_now = explode(":",date("H:i:s"));
				$d1 = mktime($time_now[0], $time_now[1], $time_now[2], $date_now[1], $date_now[2], $date_now[0]);
				setcookie("votevote".$_POST["cad_id"], $d1,time()+2678400);
				//setcookie("votevote".$_POST["cad_id"], md5(uniqid(rand())),time()+$cookieTimes);
				$udp = $db->query("UPDATE poll_ans SET a_counter = a_counter+1 WHERE a_id = '".$_POST['vote']."'");
				$sql_insert = "INSERT INTO poll_log (
				c_id,
				a_id,
				ip,
				date,
				time,
				u_id) 
				VALUES (
				'".$_POST['cad_id']."',
				'".$_POST['vote']."',
				'".$_SERVER['REMOTE_ADDR']."',
				NOW(),
				NOW(),
				'".$_SESSION["EWT_MID"]."'
				)";
				
				$db->query($sql_insert);
				$insert_log_work = "INSERT INTO log_work (
				log_work_uid,
				log_work_module,
				log_work_mdid,
				log_work_datetime) 
				VALUES (
				'".$_SESSION["EWT_MID"]."',
				'poll',
				'".$_POST['cad_id']."',
				NOW()
				)";		
				$db->query($insert_log_work);
				
				
echo "<script type=\"text/javascript\">";
echo "alert('".$text_genpoll_message1."');";
echo "window.location.href = 'poll.php'; ";
echo "</script>";	
		exit;
		
		}else{
				$err = "1";
				$news = DiffToText_new($diff);
				$text = $text_genpoll_message2.$news;
				
echo "<script type=\"text/javascript\">";
echo "alert('".$text."');";
echo "window.location.href = 'poll_info.php?c_id=".$cad_id."'; ";
echo "</script>";

	      exit;
		}
	}
	}exit;
		break;
		
	case 'Login' : {		
	if($_POST["EWT_User"] != "" AND $_POST["EWT_Password"] != "") {
		$db->query("USE ".$EWT_DB_USER);
		$sql = "SELECT * FROM user_info 
		WHERE EWT_User = '".$_POST['EWT_User']."' AND EWT_Pass = '".md5((string)$_POST['EWT_Password'])."' AND EWT_Status = 'Y'  ";
		$query = $db->query($sql);
		$num_sql = $db->db_num_rows($query);
		if($num_sql > 0){
			$R = $db->db_fetch_array($query);
			session_register("EWT_SMTYPE");
			session_register("EWT_SMID");
			session_register("EWT_SMUSER");
			session_register("EWT_SDB");
			session_register("EWT_SUSER");
			session_register("EWT_SUID");
			session_register("EWT_MID");
			$_SESSION["EWT_SUID"] = $R["UID"];
			$_SESSION["EWT_SUSER"] = $_POST["EWT_User"];
			$_SESSION["EWT_SDB"] = $R["db_db"];
			$_SESSION["EWT_SMID"] = "";
			$_SESSION["EWT_SMUSER"] = $_POST["EWT_User"];
			$_SESSION["EWT_SMTYPE"] = "Y";
			$_SESSION["EWT_MID"] = "0";
			//	setcookie ("EWT_SUSER1",$_POST["EWT_User"],time()+3600);
			//	setcookie ("EWT_SDB1",$R["db_db"],time()+3600);
			$db->query("USE ".$R["db_db"]);
			$db->write_log("login","login","เข้าสู่ระบบ");
			
echo "<script type=\"text/javascript\">";
echo "window.location.href = '../../../EWT_ADMIN/ewt_main.php'; ";
echo "</script>";
		
	}else{
			//Find to LDAP
			
			$sql_info = "SELECT login_ldap,login_ldap_ip FROM user_info WHERE EWT_User = 'LRCT_WEB'";
			$query_info = $db->query($sql_info);
			$rec = $db->db_fetch_array($query_info);

			if($rec['login_ldap'] == 'Y'){
				
				$chk_ldap = ldap_login($rec["login_ldap_ip"],trim($_POST["EWT_User"]),$_POST["EWT_Password"]);
				//echo $chk_ldap;
				//exit;
				if($chk_ldap == '' || $chk_ldap == '||||||||'){//not find
					Login_ewt($_POST["EWT_User"],$_POST["EWT_Password"]);
				}else if($chk_ldap != ''){ //find data
					//update data find
						$infoldap = explode('||',$chk_ldap);
						$user_name = $_POST["EWT_User"];
						$pass_word = $_POST["EWT_Password"];
						$org_code = $_POST["ewt_org_code1"];
						$emp_id = $infoldap[4];
						$telephone = $infoldap[3];
						$email = $infoldap[2];
						$name = $infoldap[0];
						$surname = $infoldap[1];
						$org_id = '101';
						//echo "SELECT * FROM gen_user WHERE gen_user = '".trim($_POST["EWT_User"])."'  and emp_id ='".$emp_id."'";
						$User = $_POST["EWT_User"]."@ditp.go.th";
						
								$sql_login = $db->query("SELECT * FROM gen_user WHERE email_person = '".$User."'");
								$row = $db->db_num_rows($sql_login);
								if($row > 0){
									/*$strUpdLD='UPDATE gen_user SET org_id=\''.$org_id.'\' '.
									',name_thai=\''.$name.'\' '.
									',surname_thai=\''.$surname.'\' '.
									',email_person=\''.$email.'\' '.
									',tel_in=\''.$telephone.'\' '.
									',status=1 '.
									',emp_id=\''.$emp_id.'\' '.
									',gen_pass=\''.trim($_POST['EWT_Password']).'\' '.
									',gen_user=\''.trim($_POST['EWT_User']).'\' '.
									'WHERE gen_user=\''.trim($_POST['EWT_User']).'\' AND emp_id=\''.trim($emp_id).'\'';
									$db->query($strUpdLD);*/
									
									$strUpdLD='UPDATE gen_user SET 
									gen_pass=\''.trim($_POST['EWT_Password']).'\' '.',
									gen_user=\''.trim($_POST['EWT_User']).'\' '.
									'WHERE email_person=\''.$User.'\'';
									$db->query($strUpdLD);
									
								} else {
									$emp_type_id = '11';
									$db->query("INSERT INTO gen_user (emp_type_id,name_thai,surname_thai,email_person,gen_user,gen_pass,status) VALUES ('".$emp_type_id."','".$name."','".$surname."','".$User."','".$_POST["EWT_User"]."','".$_POST["EWT_Password"]."','1')");

								}// end chk ldap
						Login_ewt($_POST["EWT_User"],$_POST["EWT_Password"]);
				}
			}else{
			Login_ewt($_POST["EWT_User"],$_POST["EWT_Password"]);
			}
		}
	}				
	}exit;
		break;
		
	case 'Addquestion' : {	
	
$wc	     = $_POST['wc'];
$topic	 = addslashes(htmlspecialchars($_POST['q_title']));
$comment = addslashes(htmlspecialchars($_POST['q_detail']));
$comment = eregi_replace(chr(13)," <br> ", $comment );
$name	 = $_POST['q_name'];
$mail	 = $_POST['q_email'];

$MAXIMUM_FILESIZE = 50000000;
//  Valid file extensions (images, word, excel, powerpoint) 
$rEFileTypes = 
  "/^\.(jpg|jpeg|gif|png|doc|docx|xls|xlsx|pdf){1}$/i"; 
$dir_base = "../userpic/"; 

$isFile = is_uploaded_file($_FILES['q_file']['tmp_name']); 
if ($isFile){    //  do we have a file? 
   //  sanatize file name 
    //     - remove extra spaces/convert to _, 
    //     - remove non 0-9a-Z._- characters, 
    //     - remove leading/trailing spaces 
    //  check if under 5MB, 
    //  check file extension for legal file types 
    $safe_filename = preg_replace( 
                     array("/\s+/", "/[^-\.\w]+/"), 
                     array("_", ""), 
                     trim($_FILES['q_file']['name']));
					 
	$type_file =  strrchr($safe_filename, '.');				 
	
	$newfile = "webboard_fileattack_".date("YmdHis").$type_file;
	
	 
    if ($_FILES['q_file']['size'] <= $MAXIMUM_FILESIZE && preg_match($rEFileTypes, strrchr($safe_filename, '.'))) {
		
		  $isMove = move_uploaded_file($_FILES['q_file']['tmp_name'],$dir_base.$newfile);
		  } 
	$fileattack = $newfile;

      }else{
		  $fileattack = "";		  	  
	  } 


		$sql_intsert_question = "INSERT INTO `w_question` (
										`c_id`,
										`t_name`,
										`t_detail`,
										`t_date`,
										`t_time`,
										`t_picture`,
										`t_count`,
										`t_ip`,
										`s_id`,
										`q_name`,
										`q_email`,
										`user_id`,
										`keyword`,
										`t_fign`
										) 
										VALUES ('".$wc."',
										'".$topic."',
										'".$comment."',
										NOW( ),
										NOW( ),
										'',
										'0',
										'".$IPn."',
										'".$CONF['c_approve']."',
										'".$name."',
										'".$mail."',
										'".$_SESSION['EWT_MID']."',
										'".$fileattack."',
										'".$fign."')";
										
																			
$db->query($sql_intsert_question);

$txtmailsender = $CONF['c_mail'];

if($mail!= ""){
$to = $mail;
$to2 = $txtmailsender;
$subject = "=?UTF-8?B?".base64_encode("แจ้งตอบรับการตั้งกระทู้")."?=";
$subject2 = "=?UTF-8?B?".base64_encode("แจ้งตั้งกระทู้กระดานถาม - ตอบ ผู้ดูแลระบบ")."?=";	
	
$message = '<html>
		<head>
		<title>'.$subject.'</title>
		</head>
		<body>
		<table bgcolor = "#EEEEEE" border = "0" width = "100%">
			<tr><td bgcolor = "#EEEEEE">แจ้งตอบรับการตั้งกระทู้</td></tr>
			<tr>&nbsp;&nbsp;<td bgcolor = "#EEEEEE">กระทู้ของท่านจัดเก็บเข้าสู่ระบบเรียบร้อบแล้ว</td></tr>
			<tr>&nbsp;&nbsp;<td bgcolor = "#EEEEEE">รอการอนุมัติจากผู้ดูแลระบบกระดานถาม-ตอบ</td></tr>
		</table><br><br><br>
		<table bgcolor = "#EEEEEE" border = "0" width = "100%">
			<tr><td bgcolor = "#EEEEEE">รายละเอียดกระทู้ของท่าน </td></tr>
			<tr>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<td bgcolor = "#EEEEEE">หัวข้อกระทู้ &nbsp;:&nbsp;&nbsp;'.$topic.'</td></tr>
			<tr>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<td bgcolor = "#EEEEEE">ชี่อ-นามสกุล &nbsp;:&nbsp;&nbsp;'.$name.'</td></tr>
			<tr>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<td bgcolor = "#EEEEEE">รายละเอียด  &nbsp;:&nbsp;&nbsp;'.$comment.'</td></tr>
			<tr>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<td bgcolor = "#EEEEEE">อีเมล์ &nbsp;:&nbsp;&nbsp;'.$mail.'</td></tr>

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
			<tr>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<td bgcolor = "#EEEEEE">หัวข้อกระทู้ &nbsp;:&nbsp;&nbsp;'.$topic.'</td></tr>
			<tr>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<td bgcolor = "#EEEEEE">ชี่อ-นามสกุล &nbsp;:&nbsp;&nbsp;'.$name.'</td></tr>
			<tr>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<td bgcolor = "#EEEEEE">รายละเอียด  &nbsp;:&nbsp;&nbsp;'.$comment.'</td></tr>
			<tr>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<td bgcolor = "#EEEEEE">อีเมล์ &nbsp;:&nbsp;&nbsp;'.$mail.'</td></tr>

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
echo "alert('บันทึกข้อมูลเรียบร้อยแล้ว  รอการพิจารณาเพื่อนำขึ้นแสดงบนเว็บไซต์\ ');";
echo "window.location.href = 'webboard_info.php?wc_id=".$wc."'; ";
echo "</script>";

	}exit;
		break;
		
	case 'Addanswer' : {
//print_r($_POST);
//exit;			
$tid 	 = $_POST['tid']; 
$wc	     = $_POST['wc'];
$comment = addslashes(htmlspecialchars($_POST['a_comment']));
//$comment = $_POST['a_comment'];
$name 	 = addslashes(htmlspecialchars($_POST['a_name']));
$mail	 = $_POST['a_email'];
if($_POST['prof_reply'] == 'yes') {
	$prof_reply='1';
} else {
	$prof_reply='0';
}

$MAXIMUM_FILESIZE = 50000000;
//  Valid file extensions (images, word, excel, powerpoint) 
$rEFileTypes = 
  "/^\.(jpg|jpeg|gif|png|doc|docx|xls|xlsx|pdf){1}$/i"; 
$dir_base = "../userpic/"; 

$isFile = is_uploaded_file($_FILES['q_file']['tmp_name']); 
if ($isFile){    //  do we have a file? 
   //  sanatize file name 
    //     - remove extra spaces/convert to _, 
    //     - remove non 0-9a-Z._- characters, 
    //     - remove leading/trailing spaces 
    //  check if under 5MB, 
    //  check file extension for legal file types 
    $safe_filename = preg_replace( 
                     array("/\s+/", "/[^-\.\w]+/"), 
                     array("_", ""), 
                     trim($_FILES['q_file']['name']));
					 
	$type_file =  strrchr($safe_filename, '.');				 
	
	$newfile = "webboard_fileattack_".date("YmdHis").$type_file;
	
	 
    if ($_FILES['q_file']['size'] <= $MAXIMUM_FILESIZE && preg_match($rEFileTypes, strrchr($safe_filename, '.'))) {
		
		  $isMove = move_uploaded_file($_FILES['q_file']['tmp_name'],$dir_base.$newfile);
		  } 
	$fileattack = $newfile;

      }else{
		  $fileattack = "";		  	  
	  } 


$sql_intsert_question = "INSERT INTO `w_answer` (
										`t_id`,
										`a_detail`,
										`a_date`,
										`a_time`,
										`a_ip`,
										`a_picture`,
										`s_id`,
										`a_name`,
										`a_email`,
										`user_id`,
										`a_attact`,
										`a_fign`,
										`a_prof_reply`
										) 
										VALUES ('".$tid."',
										'".$comment."',
										NOW( ),
										NOW( ),
										'".$IPn."',
										'',
										'".$CONF['c_approve']."',
										'".$name."',
										'".$mail."',
										'".$_SESSION['EWT_MID']."',
										'".$fileattack."',
										'".$fign."',
										'".$prof_reply."'
										)";
										
																			
$db->query($sql_intsert_question);

//alert user
//$sql = "SELECT a.user_id as user,b.a_id FROM w_question a left join w_answer b on a.t_id = b.t_id WHERE a.t_id = '".$tid."' order by b.a_id desc";
$sql = "SELECT user_id as user FROM w_question WHERE t_id = '".$tid."'";
$query = $db->query($sql);
$Q = $db->db_fetch_array($query);

//send add board
if($Q['user']!=$_SESSION["EWT_MID"]){
	$sql_intsert_alert = "INSERT INTO `trb_alert` (`id`,`date`,`gen_user_id`,`user_comment`,`type`) 
													VALUES ('".$tid."','".date("Y-m-d H:i:s")."','".$Q['user']."','".$_SESSION["EWT_MID"]."','W')";																							
	$db->query($sql_intsert_alert);
	
	$sqls = "SELECT DISTINCT user_id FROM w_answer WHERE t_id = '".$tid."' and user_id != '".$_SESSION["EWT_MID"]."'  and user_id != '".$Q['user']."'";
	$query_sqls =  $db->query($sqls);
	while($rec=$db->db_fetch_array($query_sqls)){
		$sql_intsert_alert = "INSERT INTO `trb_alert` (`id`,`date`,`gen_user_id`,`user_comment`,`type`) 
													VALUES ('".$tid."','".date("Y-m-d H:i:s")."','".$rec['user_id']."','".$_SESSION["EWT_MID"]."','W')";																							
		$db->query($sql_intsert_alert);
	}
}else{
	$sqls = "SELECT DISTINCT user_id FROM w_answer WHERE t_id = '".$tid."' and user_id != '".$_SESSION["EWT_MID"]."'";
	$query_sqls =  $db->query($sqls);
	while($rec=$db->db_fetch_array($query_sqls)){
		$sql_intsert_alert = "INSERT INTO `trb_alert` (`id`,`date`,`gen_user_id`,`user_comment`,`type`,`user_status`) 
													VALUES ('".$tid."','".date("Y-m-d H:i:s")."','".$rec['user_id']."','".$_SESSION["EWT_MID"]."','W','Y')";																							
		$db->query($sql_intsert_alert);
	}
}

$txtmailsender = $CONF['c_mail'];


if($mail!= ""){
$to = $mail;
$to2 = $txtmailsender;
$subject = "=?UTF-8?B?".base64_encode("แจ้งตอบรับการแสดงความคิดเห็น")."?=";
$subject2 = "=?UTF-8?B?".base64_encode("แจ้งแสดงความคิดเห็นกระดานถาม - ตอบ ผู้ดูแลระบบ")."?=";	
	
$message = '<html>
		<head>
		<title>'.$subject.'</title>
		</head>
		<body>
		<table bgcolor = "#EEEEEE" border = "0" width = "100%">
			<tr><td bgcolor = "#EEEEEE">แจ้งตอบรับการแสดงความคิดเห็น</td></tr>
			<tr>&nbsp;&nbsp;<td bgcolor = "#EEEEEE">กระทู้ของท่านจัดเก็บเข้าสู่ระบบเรียบร้อบแล้ว</td></tr>
			<tr>&nbsp;&nbsp;<td bgcolor = "#EEEEEE">รอการอนุมัติจากผู้ดูแลระบบกระดานถาม-ตอบ</td></tr>
		</table><br><br><br>
		<table bgcolor = "#EEEEEE" border = "0" width = "100%">
			<tr><td bgcolor = "#EEEEEE">รายละเอียดแสดงความคิดเห็นของท่าน </td></tr>
			<tr>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<td bgcolor = "#EEEEEE">ความคิดเห็น&nbsp;:&nbsp;&nbsp;'.$comment.'</td></tr>
			<tr>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<td bgcolor = "#EEEEEE">ชี่อ-นามสกุล &nbsp;:&nbsp;&nbsp;'.$name.'</td></tr>
			<tr>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<td bgcolor = "#EEEEEE">อีเมล์ &nbsp;:&nbsp;&nbsp;'.$mail.'</td></tr>

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
			<tr>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<td bgcolor = "#EEEEEE">ความคิดเห็น&nbsp;:&nbsp;&nbsp;'.$comment.'</td></tr>
			<tr>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<td bgcolor = "#EEEEEE">ชี่อ-นามสกุล &nbsp;:&nbsp;&nbsp;'.$name.'</td></tr>
			<tr>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<td bgcolor = "#EEEEEE">อีเมล์ &nbsp;:&nbsp;&nbsp;'.$mail.'</td></tr>
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
echo "alert('บันทึกข้อมูลเรียบร้อยแล้ว  รอการพิจารณาเพื่อนำขึ้นแสดงบนเว็บไซต์\ ');";
echo "window.location.href = 'webboard_detail.php?wc_id=".$wc."&qt_id=".$tid."'; ";
echo "</script>";

	}exit;
		break;
	case 'Delquestion' : {	
	
		$Request_type='T';
		$wtid=$_POST['wtid'];
		$waid=$_POST['waid'];
		$amsg=$_POST['comment'];
		$aemail=$_POST['mail'];
		$name=$_POST['name'];
		$wc = $_POST['wc'];
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
										'".$IPn."',
										'".$amsg."',
										'".$Request_type."',
										'".$_SESSION['EWT_MID']."',
										'".$aemail."'
										)";
										
																			
$db->query($sql_intsert_delquestion);

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

	}exit;
		break;
		case 'Delanswer' : {
	$Request_type='A';
	$wtid=$_POST['wtid'];
	$waid=$_POST['waid'];	
	$amsg=$_POST['comment'];
	$aemail=$_POST['mail'];
	$name=$_POST['name'];
	$wc = $_POST['wc'];
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
										'".$IPn."',
										'".$amsg."',
										'".$Request_type."',
										'".$_SESSION['EWT_MID']."',
										'".$aemail."'
										)";
										
																			
$db->query($sql_intsert_delanswer);

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

	}exit;
		break;
	case 'Addquestiontrb' : {	
	
$wc	     = $_POST['wc'];
$topic	 = addslashes(htmlspecialchars($_POST['q_title']));
$comment = addslashes(htmlspecialchars($_POST['q_detail']));
$comment = eregi_replace(chr(13)," <br> ", $comment );
$name	 = $_POST['q_name'];
$mail	 = $_POST['q_email'];

$MAXIMUM_FILESIZE = 500000;
//  Valid file extensions (images, word, excel, powerpoint) 
$rEFileTypes = 
  "/^\.(jpg|jpeg|gif|png|doc|docx|xls|xlsx|pdf){1}$/i"; 
$dir_base = "../userpic/"; 

$isFile = is_uploaded_file($_FILES['q_file']['tmp_name']); 
if ($isFile){    //  do we have a file? 
   //  sanatize file name 
    //     - remove extra spaces/convert to _, 
    //     - remove non 0-9a-Z._- characters, 
    //     - remove leading/trailing spaces 
    //  check if under 5MB, 
    //  check file extension for legal file types 
    $safe_filename = preg_replace( 
                     array("/\s+/", "/[^-\.\w]+/"), 
                     array("_", ""), 
                     trim($_FILES['q_file']['name']));
					 
	$type_file =  strrchr($safe_filename, '.');				 
	
	$newfile = "tradeboard_fileattack_".date("YmdHis").$type_file;
	
    if ($_FILES['q_file']['size'] <= $MAXIMUM_FILESIZE && preg_match($rEFileTypes, strrchr($safe_filename, '.'))) {
		
		  $isMove = move_uploaded_file($_FILES['q_file']['tmp_name'],$dir_base.$newfile);
		  } 
	$fileattack = $newfile;

      }else{
		  $fileattack = "";		  	  
	  } 


		$sql_intsert_question = "INSERT INTO `trb_question` (
										`c_id`,
										`t_name`,
										`t_detail`,
										`t_date`,
										`t_time`,
										`t_picture`,
										`t_count`,
										`t_ip`,
										`s_id`,
										`q_name`,
										`q_email`,
										`user_id`,
										`keyword`,
										`t_fign`
										) 
										VALUES ('".$wc."',
										'".$topic."',
										'".$comment."',
										NOW( ),
										NOW( ),
										'',
										'0',
										'".$IPn."',
										'".$CONF['c_approve']."',
										'".$name."',
										'".$mail."',
										'".$_SESSION['EWT_MID']."',
										'".$fileattack."',
										'".$fign."')";
										
																			
$db->query($sql_intsert_question);

$txtmailsender = $CONF['c_mail'];

if($mail!= ""){
$to = $mail;
$to2 = $txtmailsender;
$subject = "=?UTF-8?B?".base64_encode("แจ้งตอบรับการตั้งกระทู้")."?=";
$subject2 = "=?UTF-8?B?".base64_encode("แจ้งตั้งกระทู้กระดานถาม - ตอบ ผู้ดูแลระบบ")."?=";	
	
$message = '<html>
		<head>
		<title>'.$subject.'</title>
		</head>
		<body>
		<table bgcolor = "#EEEEEE" border = "0" width = "100%">
			<tr><td bgcolor = "#EEEEEE">แจ้งตอบรับการตั้งกระทู้</td></tr>
			<tr>&nbsp;&nbsp;<td bgcolor = "#EEEEEE">กระทู้ของท่านจัดเก็บเข้าสู่ระบบเรียบร้อบแล้ว</td></tr>
			<tr>&nbsp;&nbsp;<td bgcolor = "#EEEEEE">รอการอนุมัติจากผู้ดูแลระบบกระดานถาม-ตอบ</td></tr>
		</table><br><br><br>
		<table bgcolor = "#EEEEEE" border = "0" width = "100%">
			<tr><td bgcolor = "#EEEEEE">รายละเอียดกระทู้ของท่าน </td></tr>
			<tr>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<td bgcolor = "#EEEEEE">หัวข้อกระทู้ &nbsp;:&nbsp;&nbsp;'.$topic.'</td></tr>
			<tr>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<td bgcolor = "#EEEEEE">ชี่อ-นามสกุล &nbsp;:&nbsp;&nbsp;'.$name.'</td></tr>
			<tr>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<td bgcolor = "#EEEEEE">รายละเอียด  &nbsp;:&nbsp;&nbsp;'.$comment.'</td></tr>
			<tr>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<td bgcolor = "#EEEEEE">อีเมล์ &nbsp;:&nbsp;&nbsp;'.$mail.'</td></tr>

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
			<tr>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<td bgcolor = "#EEEEEE">หัวข้อกระทู้ &nbsp;:&nbsp;&nbsp;'.$topic.'</td></tr>
			<tr>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<td bgcolor = "#EEEEEE">ชี่อ-นามสกุล &nbsp;:&nbsp;&nbsp;'.$name.'</td></tr>
			<tr>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<td bgcolor = "#EEEEEE">รายละเอียด  &nbsp;:&nbsp;&nbsp;'.$comment.'</td></tr>
			<tr>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<td bgcolor = "#EEEEEE">อีเมล์ &nbsp;:&nbsp;&nbsp;'.$mail.'</td></tr>

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
echo "alert('บันทึกข้อมูลเรียบร้อยแล้ว  รอการพิจารณาเพื่อนำขึ้นแสดงบนเว็บไซต์\ ');";
echo "window.location.href = 'tradeboard_info.php?wc_id=".$wc."'; ";
echo "</script>";

	}exit;
		break;	
		
case 'Addanswertrb' : {
//print_r($_POST);
//exit;			
$tid 	 = $_POST['tid']; 
$wc	     = $_POST['wc'];
$comment = addslashes(htmlspecialchars($_POST['a_comment']));
//$comment = $_POST['a_comment'];
$name 	 = addslashes(htmlspecialchars($_POST['a_name']));
$mail	 = $_POST['a_email'];
if($_POST['prof_reply'] == 'yes') {
	$prof_reply='1';
} else {
	$prof_reply='0';
}

$MAXIMUM_FILESIZE = 500000;
//  Valid file extensions (images, word, excel, powerpoint) 
$rEFileTypes = 
  "/^\.(jpg|jpeg|gif|png|doc|docx|xls|xlsx|pdf){1}$/i"; 
$dir_base = "../userpic/"; 

$isFile = is_uploaded_file($_FILES['q_file']['tmp_name']); 
if ($isFile){    //  do we have a file? 
   //  sanatize file name 
    //     - remove extra spaces/convert to _, 
    //     - remove non 0-9a-Z._- characters, 
    //     - remove leading/trailing spaces 
    //  check if under 5MB, 
    //  check file extension for legal file types 
    $safe_filename = preg_replace( 
                     array("/\s+/", "/[^-\.\w]+/"), 
                     array("_", ""), 
                     trim($_FILES['q_file']['name']));
					 
	$type_file =  strrchr($safe_filename, '.');				 
	
	$newfile = "tradeboard_fileattack_".date("YmdHis").$type_file;
	
	 
    if ($_FILES['q_file']['size'] <= $MAXIMUM_FILESIZE && preg_match($rEFileTypes, strrchr($safe_filename, '.'))) {
		
		  $isMove = move_uploaded_file($_FILES['q_file']['tmp_name'],$dir_base.$newfile);
		  } 
	$fileattack = $newfile;

      }else{
		  $fileattack = "";		  	  
	  } 


$sql_intsert_question = "INSERT INTO `trb_answer` (
										`t_id`,
										`a_detail`,
										`a_date`,
										`a_time`,
										`a_ip`,
										`a_picture`,
										`s_id`,
										`a_name`,
										`a_email`,
										`user_id`,
										`a_attact`,
										`a_fign`,
										`a_prof_reply`
										) 
										VALUES ('".$tid."',
										'".$comment."',
										NOW( ),
										NOW( ),
										'".$IPn."',
										'',
										'".$CONF['c_approve']."',
										'".$name."',
										'".$mail."',
										'".$_SESSION['EWT_MID']."',
										'".$fileattack."',
										'".$fign."',
										'".$prof_reply."'
										)";
										
																			
$db->query($sql_intsert_question);



//alert user
$sql = "SELECT user_id as user FROM trb_question WHERE t_id = '".$tid."'";
$query = $db->query($sql);
$Q = $db->db_fetch_array($query);

//send add board
if($Q['user']!=$_SESSION["EWT_MID"]){
	$sql_intsert_alert = "INSERT INTO `trb_alert` (`id`,`date`,`gen_user_id`,`user_comment`,`type`) 
													VALUES ('".$tid."','".date("Y-m-d H:i:s")."','".$Q['user']."','".$_SESSION["EWT_MID"]."','T')";																							
	$db->query($sql_intsert_alert);
	
	$sqls = "SELECT DISTINCT user_id FROM trb_answer WHERE t_id = '".$tid."' and user_id != '".$_SESSION["EWT_MID"]."'  and user_id != '".$Q['user']."'";
	$query_sqls =  $db->query($sqls);
	while($rec=$db->db_fetch_array($query_sqls)){
		$sql_intsert_alert = "INSERT INTO `trb_alert` (`id`,`date`,`gen_user_id`,`user_comment`,`type`) 
													VALUES ('".$tid."','".date("Y-m-d H:i:s")."','".$rec['user_id']."','".$_SESSION["EWT_MID"]."','T')";																							
		$db->query($sql_intsert_alert);
	}
}else{
	$sqls = "SELECT DISTINCT user_id FROM trb_answer WHERE t_id = '".$tid."' and user_id != '".$_SESSION["EWT_MID"]."'";
	$query_sqls =  $db->query($sqls);
	while($rec=$db->db_fetch_array($query_sqls)){
		$sql_intsert_alert = "INSERT INTO `trb_alert` (`id`,`date`,`gen_user_id`,`user_comment`,`type`,`user_status`) 
													VALUES ('".$tid."','".date("Y-m-d H:i:s")."','".$rec['user_id']."','".$_SESSION["EWT_MID"]."','T','Y')";																							
		$db->query($sql_intsert_alert);
	}
}



$txtmailsender = $CONF['c_mail'];

if($mail!= ""){
$to = $mail;
$to2 = $txtmailsender;
$subject = "=?UTF-8?B?".base64_encode("แจ้งตอบรับการแสดงความคิดเห็น")."?=";
$subject2 = "=?UTF-8?B?".base64_encode("แจ้งแสดงความคิดเห็นกระดานถาม - ตอบ ผู้ดูแลระบบ")."?=";	
	
$message = '<html>
		<head>
		<title>'.$subject.'</title>
		</head>
		<body>
		<table bgcolor = "#EEEEEE" border = "0" width = "100%">
			<tr><td bgcolor = "#EEEEEE">แจ้งตอบรับการแสดงความคิดเห็น</td></tr>
			<tr>&nbsp;&nbsp;<td bgcolor = "#EEEEEE">กระทู้ของท่านจัดเก็บเข้าสู่ระบบเรียบร้อบแล้ว</td></tr>
			<tr>&nbsp;&nbsp;<td bgcolor = "#EEEEEE">รอการอนุมัติจากผู้ดูแลระบบกระดานถาม-ตอบ</td></tr>
		</table><br><br><br>
		<table bgcolor = "#EEEEEE" border = "0" width = "100%">
			<tr><td bgcolor = "#EEEEEE">รายละเอียดแสดงความคิดเห็นของท่าน </td></tr>
			<tr>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<td bgcolor = "#EEEEEE">ความคิดเห็น&nbsp;:&nbsp;&nbsp;'.$comment.'</td></tr>
			<tr>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<td bgcolor = "#EEEEEE">ชี่อ-นามสกุล &nbsp;:&nbsp;&nbsp;'.$name.'</td></tr>
			<tr>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<td bgcolor = "#EEEEEE">อีเมล์ &nbsp;:&nbsp;&nbsp;'.$mail.'</td></tr>

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
			<tr>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<td bgcolor = "#EEEEEE">ความคิดเห็น&nbsp;:&nbsp;&nbsp;'.$comment.'</td></tr>
			<tr>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<td bgcolor = "#EEEEEE">ชี่อ-นามสกุล &nbsp;:&nbsp;&nbsp;'.$name.'</td></tr>
			<tr>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<td bgcolor = "#EEEEEE">อีเมล์ &nbsp;:&nbsp;&nbsp;'.$mail.'</td></tr>
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
echo "alert('บันทึกข้อมูลเรียบร้อยแล้ว  รอการพิจารณาเพื่อนำขึ้นแสดงบนเว็บไซต์\ ');";
echo "window.location.href = 'tradeboard_detail.php?wc_id=".$wc."&qt_id=".$tid."'; ";
echo "</script>";

	}exit;
		break;		
		
	case 'Delquestiontrb' : {	
	
		$Request_type='T';
		$wtid=$_POST['wtid'];
		$waid=$_POST['waid'];
		$amsg=$_POST['comment'];
		$aemail=$_POST['mail'];
		$name=$_POST['name'];
		$wc = $_POST['wc'];
		$tid = $_POST['tid'];
		$aid = $_POST['aid'];
		
		
		$sql_intsert_delquestion = "INSERT INTO `trb_question_sts_request` (
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
										'".$IPn."',
										'".$amsg."',
										'".$Request_type."',
										'".$_SESSION['EWT_MID']."',
										'".$aemail."'
										)";
										
																			
$db->query($sql_intsert_delquestion);

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
echo "window.location.href = 'tradeboard_detail.php?wc_id=".$wc."&qt_id=".$tid."'; ";
echo "</script>";

	}exit;
		break;
case 'Delanswertrb' : {
	$Request_type='A';
	$wtid=$_POST['wtid'];
	$waid=$_POST['waid'];	
	$amsg=$_POST['comment'];
	$aemail=$_POST['mail'];
	$name=$_POST['name'];
	$wc = $_POST['wc'];
	$tid = $_POST['tid'];
	$aid = $_POST['aid'];
	
		$sql_intsert_delanswer = "INSERT INTO `trb_question_sts_request` (
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
										'".$IPn."',
										'".$amsg."',
										'".$Request_type."',
										'".$_SESSION['EWT_MID']."',
										'".$aemail."'
										)";
																											
$db->query($sql_intsert_delanswer);

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
echo "window.location.href = 'tradeboard_detail.php?wc=".$wc."&qt_id=".$tid."'; ";
echo "</script>";

	}exit;
		break;
		
		case 'Deletequestiontrb' : {
	
	$wc = $_POST['wc'];
	$tid = $_POST['tid'];
	$aid = $_POST['aid'];
	
		$sql_delete = "DELETE FROM trb_question WHERE t_id = '".$tid."'";						
		$db->query($sql_delete);
		$sql_delete_answer = "DELETE FROM trb_answer WHERE a_id = '".$aid."'";						
		$db->query($sql_delete_answer);
		$sql_delete2 = "DELETE FROM trb_alert WHERE al_id = '".$aid."'";						
		$db->query($sql_delete2);
		
		//$sql_delete2 = "DELETE FROM trb_alert WHERE id = '".$aid."' and type = 'G'";						
		//$db->query($sql_delete2);


echo "<script type=\"text/javascript\">";
echo "alert('ลบข้อมูลเรียบร้อยแล้ว ');";
echo "window.location.href = 'tradeboard_detail.php?wc_id=".$wc."&qt_id=".$tid."'; ";
echo "</script>";

	}exit;
		break;	
		
	case 'Deleteanswertrb' : {

	$wc = $_POST['wc'];
	$tid = $_POST['tid'];
	$aid = $_POST['aid'];
		
		$sql_delete = "DELETE FROM trb_answer WHERE a_id = '".$aid."'";						
		$db->query($sql_delete);
		
		//$sql_delete2 = "DELETE FROM trb_alert WHERE id = '".$aid."' and type = 'G'";						
		//$db->query($sql_delete2);
		
		
echo "<script type=\"text/javascript\">";
echo "alert('ลบข้อมูลเรียบร้อยแล้ว ');";
echo "window.location.href = 'tradeboard_detail.php?wc_id=".$wc."&qt_id=".$tid."'; ";
echo "</script>";

	}exit;
		break;	

case 'Editquestiontrb' : {
		
		//  5MB maximum file size 
$MAXIMUM_FILESIZE = 500000;
//  Valid file extensions (images, word, excel, powerpoint) 
$rEFileTypes = 
  "/^\.(jpg|jpeg|gif|png|doc|docx|xls|xlsx|pdf){1}$/i"; 
$dir_base = "../userpic/"; 

$dir_file_old = "../userpic/".$_POST['file_old']; 

$isFile = is_uploaded_file($_FILES['q_file']['tmp_name']); 
if ($isFile){    //  do we have a file? 
   //  sanatize file name 
    //     - remove extra spaces/convert to _, 
    //     - remove non 0-9a-Z._- characters, 
    //     - remove leading/trailing spaces 
    //  check if under 5MB, 
    //  check file extension for legal file types 
    $safe_filename = preg_replace( 
                     array("/\s+/", "/[^-\.\w]+/"), 
                     array("_", ""), 
                     trim($_FILES['q_file']['name']));
					 
	$type_file =  strrchr($safe_filename, '.');				 
	
	$newfile = "tradeboard_fileattack_".date("YmdHis").$type_file;
	 
    if ($_FILES['q_file']['size'] <= $MAXIMUM_FILESIZE && preg_match($rEFileTypes, strrchr($safe_filename, '.'))) {
		
		  $isMove = move_uploaded_file ($_FILES['q_file']['tmp_name'],$dir_base.$newfile);
		  } 
	$PICTURE = $newfile;
	
			if(file_exists($dir_file_old) && $_POST['file_old'] != '')
				{
				unlink($dir_file_old);
				}
      }else{
		  $PICTURE = $_POST['file_old'];		  	  
	  } 
			

$wc	     = $_POST['wc'];
$tid = $_POST['tid'];
$topic	 = addslashes(htmlspecialchars($_POST['q_title']));
$comment = addslashes(htmlspecialchars($_POST['q_detail']));
$comment = eregi_replace(chr(13)," <br> ", $comment );
$name	 = $_POST['q_name'];
$mail	 = $_POST['q_email'];

		
		$sql_update_question = "UPDATE `trb_question` SET 	`c_id`   	= 	'".$wc."',
															`t_name` 	=	'".$topic."',
															`t_detail`	=	'".$comment."',
															`t_ip`		= 	'".$IPn."',
															`q_name`	=	'".$name."',
															`q_email`	=	'".$mail."',
															`keyword`	= 	'".$PICTURE."'				
								WHERE t_id = '".$tid ."'";
		$db->query($sql_update_question);
	  
	  
	  
echo "<script type=\"text/javascript\">";
echo "alert('บันทึกข้อมูลเรียบร้อยแล้ว ');";
echo "window.location.href = 'tradeboard_detail.php?wc_id=".$wc."&qt_id=".$tid."'; ";
echo "</script>";

	  
		}exit;
			break;	

case 'Editanswertrb' : {
		
		//  5MB maximum file size 
$MAXIMUM_FILESIZE = 500000;
//  Valid file extensions (images, word, excel, powerpoint) 
$rEFileTypes = 
  "/^\.(jpg|jpeg|gif|png|doc|docx|xls|xlsx|pdf){1}$/i"; 
$dir_base = "../userpic/"; 

$dir_file_old = "../userpic/".$_POST['file_old']; 

$isFile = is_uploaded_file($_FILES['q_file']['tmp_name']); 
if ($isFile){    //  do we have a file? 
   //  sanatize file name 
    //     - remove extra spaces/convert to _, 
    //     - remove non 0-9a-Z._- characters, 
    //     - remove leading/trailing spaces 
    //  check if under 5MB, 
    //  check file extension for legal file types 
    $safe_filename = preg_replace( 
                     array("/\s+/", "/[^-\.\w]+/"), 
                     array("_", ""), 
                     trim($_FILES['q_file']['name']));
					 
	$type_file =  strrchr($safe_filename, '.');				 
	
	$newfile = "tradeboard_fileattack_".date("YmdHis").$type_file;
	 
    if ($_FILES['q_file']['size'] <= $MAXIMUM_FILESIZE && preg_match($rEFileTypes, strrchr($safe_filename, '.'))) {
		
		  $isMove = move_uploaded_file ($_FILES['q_file']['tmp_name'],$dir_base.$newfile);
		  } 
	$PICTURE = $newfile;
	
			if(file_exists($dir_file_old) && $_POST['file_old'] != '')
				{
				unlink($dir_file_old);
				}
      }else{
		  $PICTURE = $_POST['file_old'];		  	  
	  } 

$tid 	 = $_POST['tid']; 
$wc	     = $_POST['wc'];
$aid	 = $_POST['aid'];
$comment = addslashes(htmlspecialchars($_POST['q_detail']));
$name 	 = addslashes(htmlspecialchars($_POST['q_name']));
$mail	 = $_POST['q_email'];	  
	  
	  $sql_update_answer = "UPDATE `trb_answer` SET 		`t_id`   	= 	'".$tid."',
															`a_detail` 	=	'".$comment."',
															`a_ip`		=	'".$IPn."',
															`a_name`	= 	'".$name."',
															`a_email`	=	'".$mail."',
															`a_attact`	= 	'".$PICTURE."'				
								WHERE a_id = '".$aid ."'";
		$db->query($sql_update_answer);
		
	  
echo "<script type=\"text/javascript\">";
echo "alert('บันทึกข้อมูลเรียบร้อยแล้ว');";
echo "window.location.href = 'tradeboard_detail.php?wc_id=".$wc."&qt_id=".$tid."'; ";
echo "</script>";

	  
		}exit;
			break;	
			
case 'AddGalleryVote' : {
		
$img_id = $_POST['img_id']; 		
$c_id 	= $_POST['c_id']; 	
$value 	= $_POST['dpoll_value']; 



				$sql_intsert_vote = "INSERT INTO `gallery_vote` (
										`gallery_vote_img`,
										`gallery_vote_cid`,
										`gallery_vote_value`,
										`gallery_vote_date`,
										`gallery_vote_ip`,
										`gallery_vote_by`
										
										) 
										VALUES ('".$img_id."',
										'".$c_id."',
										'".$value."',
										NOW( ),
										'".$IPn."',
										'".$_SESSION['EWT_MID']."'
										)";
										
																			
$db->query($sql_intsert_vote);
  
echo "<script type=\"text/javascript\">";
echo "alert('บันทึกข้อมูลเรียบร้อยแล้ว');";
echo "window.location.href = 'gallery_info.php?category_id=".$c_id."'; ";
echo "</script>";

	  
		}exit;
			break;	
			
case 'AddGalleryComment' : {
		
$img_id = $_POST['img_id']; 		
$c_id = $_POST['c_id'];
$comment = $_POST['comment_desc'];

$sql_intsert_comment = "INSERT INTO `gallery_comment` (
										`category_id`,
										`img_id`,
										`comment`,
										`com_date`,
										`ip`,
										`user_id`										
										) 
										VALUES ('".$c_id."',
										'".$img_id."',
										'".$comment."',
										NOW( ),
										'".$IPn."',
										'".$_SESSION['EWT_MID']."'
										)";
										
																			
$db->query($sql_intsert_comment);

//alert user
$sql = "SELECT a.img_id as img,b.img_create_uid FROM gallery_comment a left join gallery_image b on a.img_id = b.img_id order by a.comment_id desc";
$query = $db->query($sql);
$Q = $db->db_fetch_array($query);

if($Q['img_create_uid']!=$_SESSION["EWT_MID"] && $Q['img_create_uid']!=""){
	$sql_intsert_alert = "INSERT INTO `trb_alert` (`id`,`date`,`gen_user_id`,`user_comment`,`type`) 
													VALUES ('".$Q['img']."','".date("Y-m-d H:i:s")."','".$Q['img_create_uid']."','".$_SESSION["EWT_MID"]."','G')";																							
	$db->query($sql_intsert_alert);
	
	$sqls = "SELECT DISTINCT user_id FROM gallery_comment WHERE img_id = '".$Q['img']."' and user_id != '".$_SESSION["EWT_MID"]."'  and user_id != '".$Q['user']."'";
	$query_sqls =  $db->query($sqls);
	while($rec=$db->db_fetch_array($query_sqls)){
		$sql_intsert_alert = "INSERT INTO `trb_alert` (`id`,`date`,`gen_user_id`,`user_comment`,`type`) 
													VALUES ('".$Q['img']."','".date("Y-m-d H:i:s")."','".$rec['user_id']."','".$_SESSION["EWT_MID"]."','G')";																							
		$db->query($sql_intsert_alert);
	}
	
}else{
	$sqls = "SELECT DISTINCT user_id FROM gallery_comment WHERE img_id = '".$Q['img']."' and user_id != '".$_SESSION["EWT_MID"]."'";
	$query_sqls =  $db->query($sqls);
	while($rec=$db->db_fetch_array($query_sqls)){
		$sql_intsert_alert = "INSERT INTO `trb_alert` (`id`,`date`,`gen_user_id`,`user_comment`,`type`,`user_status`) 
													VALUES ('".$Q['img']."','".date("Y-m-d H:i:s")."','".$rec['user_id']."','".$_SESSION["EWT_MID"]."','G','Y')";																							
		$db->query($sql_intsert_alert);
	}
}
   
echo "<script type=\"text/javascript\">";
//echo "alert('บันทึกข้อมูลเรียบร้อยแล้ว');";
//echo "window.location.href = 'pop_gallery_commemt.php?img_id=".$img_id."'; ";
//echo "boxPopup('http://".$_SERVER['SERVER_NAME']."".dirname($_SERVER['PHP_SELF'])."/pop_gallery_comment.php?img_id=".$img_id."&c_id=".$c_id." ')";
echo "window.history.back() ";
echo "</script>";
	  
		}exit;
			break;	
						
}

$db->db_close(); ?>