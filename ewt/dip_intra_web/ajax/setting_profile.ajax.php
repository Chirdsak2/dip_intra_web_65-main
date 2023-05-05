<?php
DEFINE('path', '../assets/');
include path . '/config/config.inc.php';
db::setDB(E_DB_USER);

$webb_image = $_FILES["webb_image"]['name'];
$tmp_name = $_FILES["webb_image"]['tmp_name'];
$webb_image_size = $_FILES["webb_image"]['size'];
$webb_name = conText($_POST["webb_name"]);
$title_thai = conText($_POST['title_thai']);
$name_thai = conText($_POST['name_thai']);
$surname_thai = conText($_POST['surname_thai']);
$name_eng = conText($_POST['name_eng']);
$surname_eng = conText($_POST['surname_eng']);
$org_id = conText($_POST['org_id']);
$name_org = conText($_POST['name_org']);
$email_person = conText($_POST['email_person']);
$tel_in = conText($_POST['tel_in']);
$birth_date = conText($_POST['birth_date'],"date");
// $date = explode('/',$birth_date);
// $year = $date[2] - 543;
// $birth_day = $year.'-'.$date[1].'-'.$date[0];
$birth_status = conText($_POST['birth_status']);
$chkpic1_edit_profile = conText($_POST['chkpic1_edit_profile']);
$captcha = $_SESSION['gen_pic_edit_profile'];

if (checkEmail($email_person) != 1 && !empty($email_person)) {
	echo json_encode(["status" => "emailFailed"]);
	exit();
}

if (checkMobile($tel_in) == 0 && !empty($tel_in)) {
	echo json_encode(["status" => "phoneFailed"]);
	exit();
}

$array_where = array(
	"USR_USERNAME" => $_SESSION['EWT_USERNAME'],
);

$array_where2 = array(
	"gen_user_id" => $_SESSION['EWT_MID'],
);

// if (($chkpic1_edit_profile == $captcha) == 1) {
	$array_update = array(
		"USR_PREFIX" => $title_thai,
		"USR_FNAME" => $name_thai,
		"USR_LNAME" => $surname_thai,
		"USR_FNAME_EN" => $name_eng,
		"USR_LNAME_EN" => $surname_eng,
		// "DEP_ID" => $org_id,
		"USR_EMAIL" => $email_person,
		"USR_TEL" => $tel_in,
		"USR_WEBB_NAME" => $webb_name,
		"USR_BIRTH_DATE" => $birth_date,
		"USR_BIRTH_DATE_STATUS" => $birth_status,
		"DEP_ORG_ID" => $sso->getDepartment($org_id)["data"]["DEP_ORGANIZE_ID"],
		"USR_DIVISION" => $name_org
	);

	$array_update2 = array(
		"name_thai" => $name_thai,
		"surname_thai" => $surname_thai,
		"name_eng" => $name_eng,
		"surname_eng" => $surname_eng,
		"email_person" => $email_person,
		"tel_in" => $tel_in,
		"webb_name" => $webb_name,
		"birth_date" => $birth_date,
		"birth_status" => $birth_status,
	);

	if($webb_image_size > 0){
		$result = uploadFile("../profile/", $_FILES["webb_image"]);
		if(!empty($result["filename"])){
			$array_data = array_merge($array_update, [
				"USR_PICTURE" => $result["filename"]
			]);

			$array_data2 = array_merge($array_update2, [
				"webb_pic" => $result["filename"], 
				"path_image" => "profile/".$result["filename"]
			]);
		}
	}else{
		$array_data = $array_update;
		$array_data2 = $array_update2;
	}

	$sso->update('USR_MAIN', $array_data, $array_where);
	db::db_update('gen_user', $array_data2, $array_where2);
	$message = "แก้ไขข้อมูลส่วนตัวสำเร็จ!";
	$status = "success";
// } else {
// 	$message = "Captcha ไม่ถูกต้อง กรุณากรอกใหม่!";
// 	$status = "captchaFailed";
// }

echo json_encode([
	"message" => $message,
	"status" => $status,
]);
exit();