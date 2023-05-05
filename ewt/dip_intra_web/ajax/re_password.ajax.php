<?php
DEFINE('path', '../assets/');
include path . '/config/config.inc.php';

$password = conText($_POST["password"]);
$password_confirm = conText($_POST["password_confirm"]);
$get_email = conText($_POST["get_email"]);
$get_idcard = decrypt($get_email);

$get_data = explode('&', $get_idcard);

//เช็คข้อมูล USER จาก SSO ค้นหาจากเลขบัตรประชาชน
$user_forget = $sso->getUser(null,null,$get_data[2])["data"];
if (!preg_match('#^(?=.{0,7}$)[a-z0-9]+(?:_[_a-z0-9]+)*(?:\.[a-z0-9]+(?:_[a-z0-9]+)*)?[/]?$#', $password) && !preg_match('/[^A-Za-z0-9_\\-]/', $password)) {
    $array_list["message"] = "";
    $array_list["status"] = "success";
    $array_list["alretStatus"] = "hide";
    if ($password != $password_confirm) {
        $array_list["message"] = "รหัสผ่านและยืนยันรหัสผ่านไม่ตรงกันกรุณากรอกใหม่อีกครั้ง!";
        $array_list["status"] = "error";
        $array_list["alretStatus"] = "show";
    } elseif ($get_data[0] !== 'forgetPassword' && empty($get_data[2])) {
        $array_list["status"] = "error";
        $array_list["message"] = "ไม่สามารถแก้ไขรหัสผ่านได้ กรุณาติดต่อผู้ดูแลระบบ!";
        $array_list["alretStatus"] = "show";
    }else if(empty($user_forget["USR_USERNAME"])){
        $array_list["status"] = "error";
        $array_list["message"] = "ไม่สามารถแก้ไขรหัสผ่านได้ กรุณาติดต่อผู้ดูแลระบบ!";
        $array_list["alretStatus"] = "show";
    }else if(date('Y-m-d H:i') > $get_data[3]){
        $array_list["status"] = "error_time";
        $array_list["message"] = "เกินระยะเวลาที่ระบบกำหนด ไม่สามารถแก้ไขรหัสผ่านได้!";
        $array_list["alretStatus"] = "show";
    } else {
        db::setDB(E_DB_USER);
        //---------------------------อัพเดตข้อมูลตาราง USR_MAIN--------------------------//
        $array_update1["USR_PASSWORD"] = hashPass($password);
        $array_where1["USR_CARDNO"] = $get_data[2];
        $sso->update("USR_MAIN", $array_update1, $array_where1);
        //---------------------------อัพเดตข้อมูลตาราง gen_user--------------------------//
        $array_update2["gen_pass"] = substr(encryptPassword(trim($password)), 0, 30);
        $array_where2["gen_user"] = $user_forget["USR_USERNAME"];
        db::db_update('gen_user', $array_update2, $array_where2);
        //---------------------------เก็บ Log แก้ไขรหัสผ่าน--------------------------//
        $array_insert = array();
        $array_insert["user_id"] = $_SESSION['EWT_MID'];
        $array_insert["user_name"] = $_SESSION['EWT_USERNAME'];
        $array_insert["user_ip"] = getIP();
        $array_insert["user_type"] = "forget";
        $array_insert["user_date"] = date("Y-m-d");
        $array_insert["user_time"] = date("H:i:s");
        db::insert('user_password_log', $array_insert);
        // ------------------------------------แก้ไขรหัสผ่านผู้ใช้ LDAP------------------------------//
        $sql_api = "SELECT * FROM user_api";
        $q_api = db::getFetch($sql_api);

        $auth_user = $sso->decrypt($q_api["ldap_user"],'PRD_INTRA_WEB_64','$!b$i&z!poten@tial');
        $auth_pass = $sso->decrypt($q_api["ldap_pass"],'PRD_INTRA_WEB_64','$!b$i&z!poten@tial');
        $ldapconfig['host'] = $q_api["ldap_host1"];
        $ldapconfig['port'] = '389';
        $ldapconfig['basedn'] = 'ou=people,dc=prd,dc=go,dc=th';
        $ldapconfig['searchuser'] = 'uid=' . $get_data[4] . ',ou=people,dc=prd,dc=go,dc=th';
        $ldapconfig['usersdn'] = 'uid=' . $auth_user;
        $ldapconn = ldap_connect($ldapconfig['host'], $ldapconfig['port']);
        ldap_set_option($ldapconn, LDAP_OPT_PROTOCOL_VERSION, 3);
        ldap_set_option($ldapconn, LDAP_OPT_REFERRALS, 0);

        if ($ldapconn) {
            $dn = 'uid=' . $auth_user . ',' . $ldapconfig['basedn'];
            $ldapbind = ldap_bind($ldapconn, "{$dn}", $auth_pass);
            if ($ldapbind) {
                $result = ldap_search($ldapconn, $ldapconfig['searchuser'], "(cn=*)");
                if ($result) {
                    $info['userpassword'][] = '{MD5}' . base64_encode(pack('H*',md5(trim($password))));	
                    if($r = ldap_mod_replace($ldapconn, $ldapconfig['searchuser'], $info)==false){
                        $array_list["status"] = "error";
                        $array_list["message"] = "Can't Update data to LDAP server";
                        $array_list["alretStatus"] = "show";
                    }
                    ldap_close($ldapconn);
                }
            } else {
                $array_list["status"] = "error";
                $array_list["message"] = "Unable to connect to LDAP server";
                $array_list["alretStatus"] = "show";
            }
        }
        $array_list["status"] = "success";
        $array_list["message"] = "ระบบเปลี่ยนรหัสผ่านของท่านเรียบร้อยแล้วค่ะ";
        $array_list["alretStatus"] = "hide";
    }
} else {
    $array_list["message"] = "รหัสผ่านต้องประกอบด้วยภาษาอังกฤษมีพิมพ์ใหญ่พิมพ์เล็กหรือตัวเลขและจำนวนไม่น้อยกว่า 8 ตัว";
    $array_list["status"] = "error";
    $array_list["alretStatus"] = "show";
}

$array_list["text"] = "m_re_password";
$array_list["alretText"] = "list_re_password";

echo json_encode($array_list);
exit();
