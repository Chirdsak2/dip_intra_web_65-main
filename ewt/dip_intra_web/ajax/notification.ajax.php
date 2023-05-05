<?php
DEFINE('path', '../assets/');
include path . '/config/config.inc.php';
db::setDB(E_DB_NAME);

//ชนิดข้อมูลแจ้งเตือน
$type = conText($_POST["type"]);
//ID ข้อมูลแจ้งเตือน
$id = conText($_POST["id"]);
//URL ข้อมูลแจ้งเตือน
$url = conText($_POST["url"]);
//--------------------------//
$array_list["type"] = $type;
$array_list["url"] = $url;
//--------------------------//
switch ($type) {
    case 'ecard':
        $current_date = date("Y-m-d");
        $array_update["ech_status"] = "Y";
        $array_where["ech_gen_userid"] = $_SESSION['EWT_MID'];
        $array_where["DATE(ech_datetime)"] = $current_date;
        db::db_update("ecard_history", $array_update, $array_where);
        $array_list["message"] = "เช็คข้อมูลการ์ดวันเกิดเรียบร้อย";
        $array_list["status"] = "success";
        break;
    case 'profile':
        $array_list["message"] = "เช็คข้อมูลโปรไฟล์เรียบร้อย";
        $array_list["status"] = "success";
        break;
    case 'register':
        $array_list["message"] = "เช็คข้อมูลลงทะเบียนใหม่เรียบร้อย";
        $array_list["status"] = "success";
        break;
    case 'article':
        $rows = array();
        $data = array();
        $totalNotification = 0;
        $notification = notification::article()["data"];
        foreach ($notification as $value) {
            $article_group = article::getArticleFirstGroup($value['c_id']);
            $n_approvedate = date('Y-m-d H:i', strtotime('+30 seconds', strtotime($value["n_approvedate"])));

            if ($article_group["c_show_document"] == "Y" && date('Y-m-d H:i') <= $n_approvedate) {
                if (!empty($value["picture"])) {
                    $icon = 'images/article/news' . $value['n_id'] . '/' . $value['picture'] . '';
                } else {
                    $icon = HOST . '/assets/img/favicon.png';
                }
                $data['title'] = $value['n_topic'];
                $data['message'] = ($value['news_use'] == 1 ? $value['link_html'] : "news_view.php?n_id=" . $value['n_id'] . "");
                $data['icon'] = $icon;
                $data['url'] = ($value['news_use'] == 1 ? $value['link_html'] : "news_view.php?n_id=" . $value['n_id'] . "");
                $data['time'] = $n_approvedate;
                $rows[] = $data;
                $totalNotification++;
            }
        }
        $array_list['notif'] = $rows;
        $array_list['count'] = $totalNotification;
        $array_list['result'] = true;
        break;
    case 'watched':
        $array_list["message"] = "เช็คข้อมูลเรียบร้อย";
        $array_list["status"] = "success";
        break;
}

echo json_encode($array_list);
exit();
