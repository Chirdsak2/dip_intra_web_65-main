<?php
DEFINE('path', '../assets/');
include path . '/config/config.inc.php';
db::setDB(E_DB_NAME);

//DATA SET 
$to_date_time = date('Y-m-d H:i:s');
$to_date = date("Y-m-d");
$to_time = date("H:i:s");
$to_ip = getIP();
//เงื่นไขชนิดข้อมูล
$type_post = conText($_POST["type_post"]);
//POST c_id = cate || t_id = question || a_id = answer || s_id = Approve 
$c_id = conText($_POST["c_id"]);
$t_id = conText($_POST["t_id"]);
$a_id = conText($_POST["a_id"]);
$s_id = conText($_POST["s_id"]);
//POST ตั้งกระทู้
$t_name = conText($_POST["t_name"]);
$_txt1 = str_replace("<p>", "", $_POST["t_detail"]);
$txt1 = str_replace("</p>", "", $_txt1);
$t_detail = $txt1;
$q_name = conText($_POST["q_name"]);
$q_email = conText($_POST['q_email']);
//POST ความคิดเห็น
// $_txt2 = str_replace("<p>", "", $_POST["a_detail"]);
// $txt2 = str_replace("</p>", "", $_txt2);
$a_detail = $_POST["a_detail"];
$a_picture = conText($_POST['a_picture']);
$a_name = conText($_POST['a_name']);
$a_email = conText($_POST['a_email']);
$user_id = $_SESSION['EWT_MID'];
//POST แจ้งลบกระทู้ || แจ้งลบความคิดเห็น
$_txt3 = str_replace("<p>", "", $_POST["request_reason"]);
$txt3 = str_replace("</p>", "", $_txt3);
$request_reason = $txt3;
$request_type = conText($_POST["request_type"]);
$request_email = conText($_POST["request_email"]);
//captcha ตั้งกระทู้
$chkpic1_more_webboard = conText($_POST['chkpic1_more_webboard']);
$captcha0 = $_SESSION['gen_pic_more_webboard'];
//captcha ความคิดเห็น
$chkpic1_webboard_answer = conText($_POST['chkpic1_webboard_answer']);
$captcha1 = $_SESSION['gen_pic_webboard_answer'];
//captcha แจ้งลบกระทู้
$chkpic1_webboard_answer_q = conText($_POST['chkpic1_webboard_answer_q']);
$captcha2 = $_SESSION['gen_pic_webboard_answer_q'];
//captcha แจ้งลบความคิดเห็น
$chkpic1_webboard_answer_a = conText($_POST['chkpic1_webboard_answer_a']);
$captcha3 = $_SESSION['gen_pic_webboard_answer_a'];
$output = '';

switch ($type_post) {
	case 'weboard_question': //ตั้งกระทู้
		// if (($chkpic1_more_webboard == $captcha0) == 1) {
			$array_insert = array(
				'c_id' => $c_id,
				't_name' => $t_name,
				't_detail' => $t_detail,
				't_date' => $to_date,
				't_time' => $to_time,
				't_ip' => $to_ip,
				's_id' => 1,
				't_sts' => 1,
				'q_name' => $q_name,
				'q_email' => $q_email,
				'user_id' => $user_id,
			);

			if (db::insert('w_question', $array_insert) == true) {
				//ได้รับคะแนนตั้งกระทู้
				$_sql = "SELECT COALESCE(max(t_id),0) AS t_id FROM w_question";
				$a_data = db::getFetch($_sql, PDO::FETCH_ASSOC);
				km::postPoint(2, $a_data["t_id"], "webboard");
				$status = "success";
			} else {
				$status = "error";
			}
		// } else {
		// 	$status = "captchaFailed";
		// }
		$type_text = "บันทึกเรียบร้อย";
		//$type_text = "บันทึกเรียบร้อย โปรดรออนุมัติจากแอดมิน";
		break;
	case 'weboard_answer': //ความคิดเห็น
		// if (($chkpic1_webboard_answer == $captcha1) == 1) {
			if(!empty($a_detail)){
				$array_insert = array(
					't_id' => $t_id,
					'a_detail' => $a_detail,
					'a_date' => $to_date,
					'a_time' => $to_time,
					'a_ip' => $to_ip,
					'a_picture' => $a_picture,
					's_id' => 1,
					'a_name' => $a_name,
					'a_email' => $a_email,
					'user_id' => $user_id,
				);
	
				if (db::insert('w_answer', $array_insert) == true) {
					//ได้รับคะแนนแสดงความคิดเห็นกระทู้
					// $_sql = "SELECT COALESCE(max(a_id),0) AS a_id FROM w_answer";
					// $a_data = db::getFetch($_sql, PDO::FETCH_ASSOC);
					km::postPoint(3, $t_id, "webboard");

					$status = "success";
					$type_text = "บันทึกเรียบร้อย";
				} else {
					$status = "error";
				}	
			}else{
				$status = "success";
				$type_text = "กรุณาพิมพ์ข้อความของท่าน!";
			}
		// } else {
		// 	$status = "captchaFailed";
		// }
		break;
	case 'weboard_answer_q': //แจ้งลบกระทู้
		// if (($chkpic1_webboard_answer_q == $captcha2) == 1) {
			$array_insert = array(
				't_id' => $t_id,
				'approve_sts' => $s_id,
				'request_createdate' => $to_date_time,
				'requestor_ip' => $to_ip,
				'request_reason' => $request_reason,
				'request_type' => $request_type,
				'request_email' => $request_email
			);

			if (db::insert('w_question_sts_request', $array_insert) == true) {
				$status = "success";
			} else {
				$status = "error";
			}
		// } else {
		// 	$status = "captchaFailed";
		// }
		$type_text = "แจ้งลบกระทู้สำเร็จ โปรดรออนุมัติจากแอดมิน";
		break;
	case 'weboard_answer_a': //แจ้งลบความคิดเห็น
		// if (($chkpic1_webboard_answer_a == $captcha3) == 1) {
			$array_insert = array(
				't_id' => $t_id,
				'approve_sts' => $s_id,
				'request_createdate' => $to_date_time,
				'requestor_ip' => $to_ip,
				'request_reason' => $request_reason,
				'request_type' => $request_type,
				'request_email' => $request_email,
				'a_id' => $a_id
			);

			if (db::insert('w_question_sts_request', $array_insert) == true) {
				$status = "success";
			} else {
				$status = "error";
			}
		// } else {
		// 	$status = "captchaFailed";
		// }
		$type_text = "แจ้งลบความคิดสำเร็จ โปรดรออนุมัติจากแอดมิน";
		break;
	case 'weboard_count': //นับจำนวนคนอ่านกระทู้
		$setSQL = "UPDATE w_question SET t_count = t_count + 1 WHERE t_id = {$t_id}";
		if (db::execute($setSQL)) {
			$_sql = "SELECT t_count FROM w_question WHERE t_id = {$t_id} ";
			$a_data = db::getFetch($_sql, PDO::FETCH_ASSOC);
			$output .= '<em class="fa fa-eye"></em> ' . number_format($a_data['t_count']) . '';
			$status = "success";
		} else {
			$status = "error";
		}
		break;
}

$array_list = array(
	"status" => $status,
	"type_text" => $type_text,
	"output" => $output,
	"c_id" => $c_id,
	"t_id" => $t_id,
	"a_id" => $a_id,
);

echo json_encode($array_list);
exit();
