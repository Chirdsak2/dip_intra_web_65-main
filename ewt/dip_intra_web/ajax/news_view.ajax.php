<?php
DEFINE('path', '../assets/');
include path . '/config/config.inc.php';
db::setDB(E_DB_NAME);

$c_id = conText($_POST["c_id"]);
$n_id = conText($_POST["n_id"]);
$comment = conText($_POST['comment']);
$name_comment = conText($_POST['name_comment']);
$id_member = conText($_POST['id_member']);

$array_insert = array(
	'news_id' => $n_id,
	'ip_comment' => getIP(),
	'comment' => $comment,
	'name_comment' => $name_comment,
	'status_comment' => 1,
	'id_ans' => 0,
	'timestamp' => date('Y-m-d H:i'),
	'id_member' => $_SESSION['EWT_MID']
);

if (db::insert('news_comment', $array_insert) == true) {
	//ได้รับคะแนนแสดงความคิดเห็นบทความ
	km::postPoint(4, $n_id, "article");
	
	$status = "success";
} else {
	$status = "error";
}

$array_list = array(
	"status" => $status,
	"c_id" => $c_id,
	"n_id" => $n_id,
);

echo json_encode($array_list);
exit();