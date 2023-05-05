<?php
DEFINE('path', '../assets/');
include path . '/config/config.inc.php';

$Flag = conText($_REQUEST["Flag"]);
$a_data = $_REQUEST;
unset($a_data["Flag"]);
unset($a_data["policy_check_reqister"]);

switch ($Flag) {
    case 'AddUser':
        $array_insert = array();
        $array_insert_set = array();

        foreach ($a_data as $key => $value) {
            $array_insert_set[$key] = conText($value);
        }

        if (isset($_FILES["file_attach"])) {
            $file_attach = uploadFile("../profile/", $_FILES["file_attach"], "profile_");
        } else {
            $file_attach = "";
        }

        $array_insert =  array_merge($array_insert_set, [
            "create_date" => date("Y-m-d"),
            "status" => 0,
            "file_attach" =>  $file_attach["filename"]
        ]);

        $insert = db::insert("" . E_DB_USER . ".gen_user", $array_insert);

        if ($insert) {
            $array_list = array(
                "status" => "success",
                "message" => "ลงทะเบียนเรียบร้อย"
            );
        } else {
            $array_list = array(
                "status" => "error",
                "message" => "ไม่สามารถลงทะเบียนได้ กรุณาติดต่อผู้ดูแลระบบ!!"
            );
        }
        break;
}

echo json_encode($array_list);
exit();
