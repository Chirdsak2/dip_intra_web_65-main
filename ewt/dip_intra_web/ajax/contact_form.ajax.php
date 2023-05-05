<?php
DEFINE('path', '../assets/');
include path . '/config/config.inc.php';

$Flag = conText($_REQUEST["Flag"]);
$a_data = $_REQUEST;
unset($a_data["Flag"]);
unset($a_data["Complain_lead_ID"]);

switch ($Flag) {
    case 'AddComplain':
        $array_insert = array();
        $array_insert_set = array();

        foreach ($a_data as $key => $value) {
            $array_insert_set[$key] = conText($value);
        }

        if (isset($_FILES["attach_img"])) {
            $attach_img = uploadFile("../file_attach/", $_FILES["attach_img"], "file_attach_complain_");
        } else {
            $attach_img = "";
        }

        $array_insert =  array_merge($array_insert_set, [
            "date" => date("Y-m-d"),
            "time" => date("H:i:s"),
            "ip" => getIP(),
            "flag" => (int)$_REQUEST["Complain_lead_ID"],
            "attach_img" =>  $attach_img["filename"]
        ]);

        $insert = db::insert("" . E_DB_NAME . ".m_complain", $array_insert);

        if ($insert) {
            $array_list = array(
                "status" => "success",
                "message" => "เพิ่มข้อมูลสำเร็จ"
            );
        } else {
            $array_list = array(
                "status" => "error",
                "message" => "ไม่สามารถเพิ่มข้อมูลได้!!"
            );
        }
        break;
    default:
        $array_list = array(
            "status" => "warning",
            "message" => "ไม่ได้ส่งข้อมูล Flag"
        );
        break;
}

echo json_encode($array_list);
exit();
