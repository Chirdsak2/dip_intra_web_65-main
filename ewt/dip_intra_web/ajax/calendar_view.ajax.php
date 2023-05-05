<?php
DEFINE('path', '../assets/');
include path . '/config/config.inc.php';

$cal_event_id = conText($_POST["cal_event_id"]);
$cal_registor_name = conText($_POST["cal_registor_name"]);
$cal_registor_tel = conText($_POST['cal_registor_tel']);
$cal_registor_email = conText($_POST['cal_registor_email']);

$array_insert = array(
	'cal_event_id' => $cal_event_id,
	'cal_registor_name' => $cal_registor_name,
	'cal_registor_tel' => $cal_registor_tel,
	'cal_registor_email' => $cal_registor_email,
	'cal_registor_createdate' => date('Y-m-d H:i'),
);

if (checkEmail($cal_registor_email) != 1) {
	$email = "emailFailed";
}

if (checkMobile($cal_registor_tel) == 0) {
	$phone = "phoneFailed";
}

if (checkEmail($cal_registor_email) == 1) {
	if (db::insert('cal_registor_event', $array_insert) == true) {
		$status = "success";
	} else {
		$status = "error";
	}
}

$array_list = array(
	"status" => $status,
	"email" => $email,
	"phone" => $phone,
	"cal_event_id" => $cal_event_id
);

echo json_encode($array_list);
exit();
