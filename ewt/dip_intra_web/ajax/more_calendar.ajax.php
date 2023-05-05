<?php
DEFINE('path', '../assets/');
include path . '/config/config.inc.php';
db::setDB(E_DB_NAME);

$event_id = conText($_POST['event_id']);
$setSQL = "UPDATE cal_event SET event_count = event_count + 1 WHERE event_id = {$event_id}";

if (db::execute($setSQL)) {
    $_sql = "SELECT * FROM cal_event WHERE event_id = {$event_id} ";
    $a_data = db::getFetch($_sql, PDO::FETCH_ASSOC);

    $txt = '';
    $txt .= '<i class="fa fa-eye"></i> ' . $a_data['event_count'] . '';
    $calendar_count = $txt;
} else {
    $calendar_count = null;
}

$array_list = array(
    "calendar_count" => $calendar_count,
    "event_id" => $event_id
);

echo json_encode($array_list);
exit();