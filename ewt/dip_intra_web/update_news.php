<?php
DEFINE('path', 'assets/');
include path . '/config/config.inc.php';

$user_ewt = user::chkUser(array("gen_user_id" => $_SESSION["EWT_MID"]))[0]; //ข้อมูล EWT

$email_person = $user_ewt["email_person"]; //อีเมล์
$n_id = $_GET['id'];
$m_id = $_SESSION['EWT_MID'];
$username = $_SESSION['EWT_USERNAME'];

$array_insert = array(
    'n_id' => $n_id,
    'fav_userid' => $m_id,
    'fav_username' => $username,
    'fav_email' => $email_person,
    'fav_datetime' => date('Y-m-d H:i:s'),
    'fav_ipaddress' => getIP(),

);
$_sql = "SELECT fav_id FROM ".E_DB_NAME.".article_favorite_log WHERE n_id = {$n_id} AND fav_userid = {$m_id}";
$check = db::getRowCount($_sql);

if ($check > 0) {
    echo "<script>alert('ท่านได้ทำการเพิ่มรายการโปรดซ้ำ'); history.back();</script>";
} else {
    $insert = db::insert(E_DB_NAME . '.article_favorite_log', $array_insert);
    echo '<script> alert("เพิ่มรายการโปรดสำเร็จ")</script>'; 
    header('Refresh:0; url=index.php');
}
exit;

