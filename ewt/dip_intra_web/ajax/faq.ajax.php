<?php
DEFINE('path', '../assets/');
include path . '/config/config.inc.php';
db::setDB(E_DB_NAME);

$fa_id = conText($_POST['fa_id']);

$setSQL = "UPDATE faq SET fa_count = fa_count + 1 WHERE fa_id = {$fa_id}";

$faq_count = '';
$faq_count_txt = '';
if (db::execute($setSQL)) {
    $_sql = "SELECT fa_count FROM faq WHERE fa_id = {$fa_id} ";
    $a_data = db::getFetch($_sql, PDO::FETCH_ASSOC);
    $faq_count .= '<small class="mb-3">';
    $faq_count .= '<em class="fa fa-eye"></em> ' . $a_data['fa_count'] . '';
    $faq_count .= '</small>';
    $faq_count_txt .= $a_data['fa_count'] . ' วิว';
}

$array_list = array(
    "faq_count" => $faq_count,
    "faq_count_txt" => $faq_count_txt,
    "fa_id" => $fa_id
);

echo json_encode($array_list);
exit();
