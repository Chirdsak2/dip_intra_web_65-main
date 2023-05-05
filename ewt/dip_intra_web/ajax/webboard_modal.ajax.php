<?php
DEFINE('path', '../assets/');
include path . '/config/config.inc.php';

//ประเภทข้อมูลกระทู้ => หมวด, กระทู้, ความคิดเห็น
$type = conText($_POST["type"]);
//ค่าที่ต้องการให้คืนค่ากลับ
$list = conText($_POST["list"]);
//ไอดี หมวด, กระทู้, ความคิดเห็น, ลำดับความคิดเห็น
$c_id = conText($_POST["c_id"]);
$t_id = conText($_POST["t_id"]);
$a_id = conText($_POST["a_id"]);
$a_id_number = conText($_POST["a_id_number"]);
$output = '';

switch ($type) {
    case 'cate':
        break;
    case 'question':
        break;
    case 'answer':
        $webboard_a = webboard::getWAnswer($a_id, $t_id)["data"];
        if ($webboard_a) {
            $output .= '<div class="font18px">';
            $output .= 'ความคิดเห็นที่ ' . $a_id_number;
            $output .= '</div>';
            $output .= '<div class="d-flex">';
            $output .=  $webboard_a[0]["a_detail"];
            $output .= '</div>';
            $output .= '<input type="hidden" name="s_id" id="s_id" value="'.$webboard_a[0]["s_id"].'">';
            $output .= '<input type="hidden" name="a_id" id="a_id" value="'.$a_id.'">';
            $status = "success";
        }
        break;
}

$array_list = array(
    "status" => $status,
    "type" => $type,
    "list" => $list,
    "output" => $output
);

echo json_encode($array_list);
exit();
