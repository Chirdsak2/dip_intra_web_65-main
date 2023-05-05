<?php
DEFINE('path', '../assets/');
include path . '/config/config.inc.php';
db::setDB(E_DB_NAME);

$c_id = conText($_POST['c_id']);
$n_id = conText($_POST['n_id']);
$page = conText($_POST['page']);

$array_insert = array(
    'news_id' => $n_id,
    'ip_view' => getIP(),
    'date_view' => date('Y-m-d'),
    'time_view' => date('H:i:s'),
    'id_member' => $_SESSION['EWT_MID']
);

$insert = db::insert('news_view', $array_insert);

if ($insert == true) {
    $_sql = "SELECT * FROM news_view WHERE news_id = {$n_id} ";
    $a_row  = db::getRowCount($_sql);

    $array_where = array(
        'n_id' => $n_id,
        'c_id' => $c_id,
    );

    $array_update = array(
        'view_count' => $a_row,
    );

    db::db_update('article_list', $array_update, $array_where);
    $_sql = "SELECT view_count,n_date,n_owner,n_owner_org FROM article_list WHERE n_id = {$n_id} AND c_id = {$c_id}";
    $a_data = db::getFetch($_sql, PDO::FETCH_ASSOC);

    //ได้รับคะแนนอ่านบทความ
    km::postPoint(5, $n_id, "article");

    $txt = '';
    if ($page == 'news_tab_index') {
        $txt .= ' <em class="far fa-eye"></em> ' . $a_data['view_count'];
    } else {
        // $txt .= ' <i class="far fa-calendar-alt"></i> ' . convDateThai($a_data['n_date'])['DateTH'] . '';
        // $txt .= ' <i class="fa fa-eye"></i> ' . $a_data['view_count'] . '';
        // $txt .= ' <a href="#" title="' . $sso->getOrg($a_data['n_owner_org'])['short_name'] . '">';
        // $txt .= ' <i class="fa fa-user"></i> ' . $sso->getOrg($a_data['n_owner_org'])['short_name'] . '';
        // $txt .= '</a>';
        $txt .= $a_data['view_count'];
    }
    $view_count = $txt;
} else {
    $view_count = "Error Insert";
}

$array_list = array(
    "view_count" => $view_count,
    "c_id" => $c_id,
    "n_id" => $n_id,
);

echo json_encode($array_list);
exit;