<?php
DEFINE('path', '../assets/');
include path . '/config/config.inc.php';

$c_id = conText($_POST['c_id']);
$data_cat = poll::getPoll($c_id);
$data_ans = poll::getPollAswer($c_id);
$total_score = poll::getPollAswerSum($c_id, 'a_counter');

$list_c_name = '';
$list_c_name .= '<em class="fas fa-poll-h pr-1 pl-2 pt-2 font35px"></em> ' . $data_cat[0]['c_name'] . '';

$total = 0;
$list_a_name = '';
foreach ($data_ans as $key => $value) {
    $total += $value['a_counter'];
    $percen = round(($value['a_counter'] / $total_score) * 100);
    $list_a_name .= '<div class="col-sm-3 text-right font20px"> ' . $value['a_name'] . ' </div>';
    $list_a_name .= '<div class="col-sm-9">';
    $list_a_name .= '<div class="progress mt-2">';
    $list_a_name .= '<div class="progress-bar font15px" role="progressbar" style="width: ' . $percen . '%" aria-valuenow="' . $percen . '" aria-valuemin="0" aria-valuemax="100">' . $percen . '% (' . $value['a_counter'] . ')</div>';
    $list_a_name .= '</div>';
    $list_a_name .= '</div>';
}

$array_list = array(
    "list_vote" => 'ผลโหวตให้คะแนนแบบสำรวจออนไลน์ จาก ' . $total . ' ครั้ง',
    "list_c_name" => $list_c_name,
    "list_a_name" => (empty($list_a_name) ? "<div class='col-sm-12 text-center font20px' style='color:red;'>ไม่พบคะแนนโหวตหัวข้อนี้</div>" : $list_a_name)
);

echo json_encode($array_list);
exit();