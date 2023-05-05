<?php
DEFINE('path', 'assets/');
include(path . 'config/config.inc.php');
$a_data = array_merge($_POST, $_FILES);
// global $db;
ini_set('display_errors', '1');
ini_set('display_startup_errors', '1');
error_reporting(E_ALL);
dbdpis::ConnectDB(SSO_DB_NAME, SSO_DB_TYPE, SSO_ROOT_HOST, SSO_ROOT_USER, SSO_ROOT_PASSWORD, SSO_DB_NAME, SSO_CHAR_SET);

$s_data = array();
if ($_POST["Flag"] == "EditPro") {

        $path_image = $_FILES["path_image"]['name'];
        $tmp_name = $_FILES["path_image"]['tmp_name'];
        $path_image_size = $_FILES["path_image"]['size'];
        $path_image_sso = SSO_PATH . "profile/";

        if ($path_image_size > 0) {
                // $result = uploadFile($path_image_sso, $_FILES["path_image"], "image_file_");
                // if (!empty($result["filename"])) {
                //         $s_data['USR_PICTRUE'] = $result["filename"];
                //         $s_data['USR_PICTRUE'] = $result["filename"];
                // }
                $cfile = curl_file_create($_FILES['path_image']['tmp_name'], $_FILES['path_image']['type'], $_FILES['path_image']['name']);
                $post_data = array(
                        "file" => $cfile,
                        'USR_ID' => $a_data['USR_ID']
                );

                $curl = curl_init();
                curl_setopt($curl, CURLOPT_URL, SSO_PATH."api/public/upload_img2sso.php"); // แก้ไข URL ของเว็บไซต์ที่รับไฟล์
                curl_setopt($curl, CURLOPT_POST, true);
                curl_setopt($curl, CURLOPT_POSTFIELDS, $post_data);
                curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
				curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
				curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, false);

                $response = curl_exec($curl);
                $http_status = curl_getinfo($curl, CURLINFO_HTTP_CODE);

                $result = json_decode($response, true);

                // echo "<pre>";
                // print_r($result);
                // echo "</pre>";
                if ($response === false) {
                        $error_msg = curl_error($curl);
                        $error_code = curl_errno($curl);
                        echo "Error $error_code: $error_msg";
                }

                curl_close($curl);

                if ($http_status == 200) {
                        $result = json_decode($response, true);
                        if ($result["status"] == "success") {
                                $s_data['USR_PICTURE'] = $result["file_name"];
                        }
                }
        }

        $s_data['USR_NICKNAME'] = trim($a_data['nickname_thai']);
        $s_data['USR_FNAME_EN'] = trim($a_data['name_eng']);
        $s_data['USR_LNAME_EN'] = trim($a_data['surname_eng']);
        $s_data['USR_EMAIL'] = trim($a_data['email_person']);
        $s_data['USR_TEL'] = trim($a_data['tel_in']);
        $s_data['USR_TEL_FAX'] = trim($a_data['tel_convenient']);
        $s_data['USR_TEL_PHONE'] = trim($a_data['mobile']);
        $s_data['USR_LINE_ID'] = trim($a_data['line_id']);
        $s_data['USR_ADDRESS'] = trim($a_data['officeaddress']);

        $db_up = dbdpis::db_update('USR_MAIN', $s_data, array('USR_ID' => $a_data['USR_ID']));
        
        if ($db_up) {
                $message = "แก้ไขข้อมูลส่วนตัวสำเร็จ";
                $status = "success";
        } else {
                $message = 'ไม่สามารถแก้ไขข้อมูลส่วนตัวได้';
                $status = "error";
        }
        echo json_encode([
                "message" => $message,
                "status" => $status,
        ]);
        exit();
}
