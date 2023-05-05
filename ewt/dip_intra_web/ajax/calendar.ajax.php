<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");

DEFINE('path', '../assets/');
include path . '/config/config.inc.php';
date_default_timezone_set('Asia/Bangkok');

$cat_id = conText($_POST["cat_id"]);

db::setDB(E_DB_NAME);
$_sql = "SELECT * FROM cal_event WHERE cat_id = '$cat_id'";
$a_data = db::getFetchAll($_sql, PDO::FETCH_ASSOC);
$a_row = db::getRowCount($_sql);

$_sql_cat = "SELECT cat_color FROM cal_category WHERE cat_id = '$cat_id'";
$cat_data = db::getFetch($_sql_cat, PDO::FETCH_ASSOC);

$data = array();
foreach ($a_data as $row) {
    //$date = $row["event_date_end"];
    //$endDate = date("Y-m-d", strtotime("+1 day", strtotime($date)));
    if ($row["event_time_start"] != "00:00:00") {
        $time_start = "T" . $row["event_time_start"];
        $time_start1 = datetimetool::format($row["event_time_start"], 'H:i น.');
    }

    if ($row["event_time_end"] != "00:00:00") {
        $time_end = "T" . $row["event_time_end"];
        $time_end1 = datetimetool::format($row["event_time_end"], 'H:i น.');
    }

    $data[] = [
        "id" => $row["event_id"],
        "title" => $time_start1 . ' - ' . $time_end1 . ' ' . $row["event_title"],
        "start" => $row["event_date_start"] . $time_start,
        "end" => $row["event_date_end"] . $time_end,
        "url" => "calendar_view.php?event_id=" . $row["event_id"],
        "color" => $cat_data["cat_color"],
        "allDay" => false
    ];
}

echo json_encode($data);
exit();
