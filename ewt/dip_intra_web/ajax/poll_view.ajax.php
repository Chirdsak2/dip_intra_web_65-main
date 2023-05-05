<?php
DEFINE('path', '../assets/');
include path . '/config/config.inc.php';
date_default_timezone_set("Asia/Bangkok");

$c_id = conText($_POST['c_id']);
$a_id = conText($_POST['a_id']);

$data_cat = poll::getPoll($c_id);

if ($data_cat[0]["c_status"] == "Y" && $data_cat[0]['c_set_time'] != 0) {
    $hour = floor($data_cat[0]['c_set_time'] / 3600);
    $time_d = 3600 * $hour;
    $time_m = $data_cat[0]['c_set_time'] - $time_d;
    $minute = $time_m / 60;
    $hour_s = ($hour <= 9 ? '0' . $hour : null);
    $to_time = $hour_s . ":" . $minute;
    $time_check = date('H:i', strtotime('+' . $hour . ' hour +' . $minute . ' minutes'));
    $l_query = poll::getPollLog($c_id, null, $_SESSION['EWT_MID']);
    $time_l_h = (date('H', strtotime($l_query[0]['time'])) == "00" ? "24" : date('H', strtotime($l_query[0]['time'])));
    $time_l_m = date('i', strtotime($l_query[0]['time']));
    $time_l = date('H:i', strtotime($time_l_h . ':' . $time_l_m));
    $date_l = date('Y-m-d H:i', strtotime($l_query[0]['time']));

    $date_current = new DateTime(date('Y-m-d H:i'));
    $date_check = new DateTime($date_l);

    if (empty($l_query) || $date_current > $date_check) {
        poll::getPollVote($c_id, $a_id, $time_check);
        $status = "success";
        $message = "โหวตเรียบร้อย";
    } else {
        $status = "error";
        $message = "เกินระยะเวลาตอบแบบสำรวจ กรุณารอเวลาแบบสำรวจครั้งถัดไป";
    }
} else {
    if($data_cat[0]["c_status"] == "N"){
        
        db::setDB(E_DB_NAME);
        $_sql = "SELECT poll_log_id FROM poll_log WHERE c_id = '$c_id' AND uid = {$_SESSION['EWT_MID']}";
        $a_row = db::getRowCount($_sql);

        if($a_row == 0){
            poll::getPollVote($c_id, $a_id);
            $status = "success";
        }else{
            $status = "error";
            $message = "สามารถโหวตได้แค่ครั้งเดียว";
        }
    }else{
        $status = "error";
        $message = "เกิดข้อผิดพลาดในการเลือกโหวต";
    }
}

$array_list = array(
    "status" => $status,
    "message" => $message,
    "c_id" => $c_id,
    "a_id" => $a_id,
    "date_current" => date('Y-m-d H:i'),
    "date_check" => $date_l,
);

echo json_encode($array_list);
exit();
