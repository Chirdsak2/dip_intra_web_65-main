<?php
DEFINE('path', '../assets/');
include path . '/config/config.inc.php';
include '../phpmailer/phpmailer.class.php';
$mail = new PHPMailer();
$mail->CharSet = "utf-8";

$type = conText($_POST["type"]);
$fg_id_card = conText($_POST["fg_id_card"]); //เลขบัตรประชาน
$fg_email = conText($_POST["fg_email"]); //อีเมลส่วนตัว //อีเมลหน่วยงาน
// $fg_personal_email = conText($_POST["fg_personal_email"]); 
$fg_answer = conText($_POST["fg_answer"]); //คำตอบความปลอดภัย

// if (!empty($fg_email) && !empty($fg_personal_email)) {
// 	$send_mail = $fg_email . "," . $fg_personal_email;
// } elseif (!empty($fg_email) && empty($fg_personal_email)) {
// 	$send_mail = $fg_email;
// } elseif (empty($fg_email) && !empty($fg_personal_email)) {
// 	$send_mail = $fg_personal_email;
// }


//เช็คข้อมูล USER จาก SSO ค้นหาจากเลขบัตรประชาชน
$user_forget = $sso->getUser(null, null, $fg_id_card)["data"];
$user_seque = $sso->getUserQuest($user_forget["USR_SEQUE"])["data"];
$chk_user = user::chkUser(array("gen_user" => $user_forget["USR_USERNAME"]));

$encrypt_get_email = encrypt('forgetPassword' . '&' . $fg_email . '&' . $fg_id_card . '&' . date("Y-m-d H:i", strtotime("+5 minutes")). '&'. $user_forget["USR_USERNAME"]);

switch ($type) {
	case 'forget':
		if (strlen($fg_id_card) != 13) {
			$array_list["alretStatus"] = "show";
			$array_list["status"] = "error";
			$array_list["message"] = "กรุณากรอกเลขบัตรประชาชนของท่านให้ครบ 13 หลัก";
		} elseif (!empty($user_forget)) { //หากพบข้อมูลเลขบัตรประชาชนในระบบ user มีสิทธิ์ใช้งานระบบ
			if ($sso->checkMovement($user_forget["USR_MOVEMENT"])) {
				$array_list["alretStatus"] = "show";
				$array_list["status"] = "error";
				$array_list["message"] = "ไม่สามารถดำเนินการได้เนื่องจากสถานะผู้ใช้เสียชีวิตหรือถูกไล่ออก";
			} else {
				$array_list["alretStatus"] = "hide";
				$array_list["status"] = "success";
				if (empty($user_forget["USR_USERNAME"]) || empty($chk_user[0]["gen_pass"])) {
					$array_list["message"] = "ท่านยังไม่ได้ลงทะเบียน กรุณาลงทะเบียน!";
					$array_list["alretStatus"] = "show";
					$array_list["status"] = "error";
					// }elseif (empty($user_seque)) {
					// 	$array_list["alretStatus"] = "show";
					// 	$array_list["status"] = "error";
					// 	$array_list["message"] = "ไม่พบข้อมูลคำถามของท่าน กรุณาตรวจสอบการลงทะเบียน!";
				} else {
					//---------------อีเมลส่วนตัว-----------//
					$m_email = $user_forget["USR_MEMAIL"];
					$user_m_email = explode("@", $m_email);
					$text_m_cut = substr(trim($user_m_email[0]), 0, 3) . "***@" . $user_m_email[1];
					//---------------อีเมลหน่วยงาน-----------//
					$u_email = $user_forget["USR_EMAIL"];
					$user_u_email = explode("@", $u_email);
					$text_u_cut = substr(trim($user_u_email[0]), 0, 3) . "***@" . $user_u_email[1];

					$array_list["btn_chk"] = "show";
					$array_list["textCheck"] = "show";
					$array_list["text_m_mail"] = $m_email;
					$array_list["text_m_cut"] = $text_m_cut;
					$array_list["text_u_mail"] = $u_email;
					$array_list["text_u_cut"] = $text_u_cut;
					$array_list["alretStatus"] = "hide";
					$array_list["status"] = "success";
					//$array_list["messagePut"] = $u_email;
					//$array_list["messagePut"] = $user_seque["SEQ_NAME"];
				}
			}
		} elseif (empty($user_forget)) { //หากไม่พบข้อมูลเลขบัตรประชานในระบบ user ไม่มีสิทธิ์ใช้งานระบบ
			$array_list["alretStatus"] = "show";
			$array_list["status"] = "error";
			$array_list["message"] = "กรุณาตรวจสอบเลขบัตรประชาชนที่ถูกต้องของท่านค่ะ!";
		}
		$array_list["text"] = "m_fg_danger";
		$array_list["alretText"] = "list_ck_fg_danger";
		break;
	case 'question':
		if ($user_forget["USR_ANSWER"] != $fg_answer) {
			$array_list["alretStatus"] = "show";
			$array_list["status"] = "error";
			$array_list["message"] = "ท่านตอบคำถามความปลอดภัยไม่ถูกต้องกรุณาตอบใหม่อีกคร้ัง!";
			$array_list["text"] = "m_fg_danger";
			$array_list["alretText"] = "list_ck_fg_danger";
		} else {
			$array_list["btn_chk"] = "show";
			$array_list["alretStatus"] = "hide";
			$array_list["status"] = "success";
			$array_list["messagePut"] = $user_forget["USR_EMAIL"];
			$array_list["text"] = "m_fg_success";
			$array_list["alretText"] = "list_ck_fg_success";
		}
		break;
	case 'saveForm':
		if (empty($fg_email)) {
			$array_list["alretText"] = "list_ck_fg_danger";
			$array_list["alretStatus"] = "show";
			$array_list["status"] = "error";
			$array_list["message"] = "กรุณากรอกอีเมลส่วนตัว หรือ เลือกอีเมลหน่วยงานของท่าน!";
			$array_list["text"] = "m_fg_danger";
		} else {
			$last_data = date("d/m/Y");
			$last_time = date("H:i", strtotime("+5 minutes"));
			$mail->IsSMTP();
			$mail->Mailer = "smtp";
			$mail->SMTPAuth = true;
			//$mail->SMTPSecure = 'ssl';
			$mail->Host = SMTP_HOST;
			$mail->Port = SMTP_PORT;
			$mail->Username = SMTP_USERNAME;
			$mail->Password = SMTP_PASSWORD;
			$mail->From = E_EMAIL;
			$mail->FromName = 'PRD_INTRA_WEB';
			$mail->AddAddress($fg_email);
			// if($fg_personal_email){
			// 	$mail->AddAddress($fg_personal_email);
			// }
			$mail->Subject = "แจ้งลืมรหัสผ่านโดยผู้ดูแลระบบกรมประชาสัมพันธ์";
			$text_body .= "กรุณาเปลี่ยนรหัสผ่านภายใน เวลา 5 นาที \n\n";
			$text_body .= "วันเวลาที่จะหมดอายุของลิงก์ \n";
			$text_body .= $last_data . " " . $last_time . " น. \n\n";
			$text_body .= "คลิกลิงก์ด้านล่างเพื่อเปลี่ยนรหัสผ่านของท่าน \n\n";
			$text_body .= HOST . "re_password.php?data=" . $encrypt_get_email . "";
			$mail->Body = $text_body;
			$mail->WordWrap = 50;

			if (!$mail->Send()) {
				$array_list["alretText"] = "list_ck_fg_danger";
				$array_list["alretStatus"] = "show";
				$array_list["status"] = "error";
				$array_list["message"] = "ไม่พบอีเมลของท่าน กรุณาติดต่อแอดมินหรือผู้ดูแลระบบ";
				$array_list["text"] = "m_fg_danger";
			} else {
				$array_insert["user_id"] = $chk_user[0]["gen_user_id"];
				$array_insert["user_name"] = $chk_user[0]["gen_user"];
				$array_insert["user_ip"] = getIP();
				$array_insert["user_type"] = "forget";
				$array_insert["user_date"] = date("Y-m-d");
				$array_insert["user_time"] = date("H:i:s");
				$insert = db::insert(E_DB_USER . ".user_password_log", $array_insert);
				if ($insert == true) {
					$array_list["alretText"] = "list_ck_fg_success";
					$array_list["alretStatus"] = "show";
					$array_list["status"] = "success";
					$array_list["message"] = "ระบบส่งลิงก์เปลี่ยนรหัสผ่านไปที่อีเมลของท่านแล้ว กรุณาตรวจสอบอีเมลของท่านค่ะ";
					$array_list["text"] = "m_fg_success";
				} else {
					$array_list["alretText"] = "list_ck_fg_danger";
					$array_list["alretStatus"] = "show";
					$array_list["status"] = "error";
					$array_list["message"] = "เก็บ Log ผิดพลาด";
					$array_list["text"] = "m_fg_danger";
				}
			}
		}
		break;
}
$array_list["type"] = $type;
echo json_encode($array_list);
exit();
