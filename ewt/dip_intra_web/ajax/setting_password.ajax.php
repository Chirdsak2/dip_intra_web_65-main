<?php
DEFINE('path', '../assets/');
include path . '/config/config.inc.php';
$password_old = conText($_POST["password_old"]);
$password_new = conText($_POST["password_new"]);
$password_confirm = conText($_POST["password_confirm"]);
$chkpic1_set_password = conText($_POST['chkpic1_set_password']);
$captcha = $_SESSION['gen_pic_set_password'];

$user = user::chkUser(array("gen_user_id" => $_SESSION['EWT_MID']));

if (($chkpic1_set_password == $captcha) == 1) {
    if (!preg_match('#^(?=.{0,7}$)[a-z0-9]+(?:_[_a-z0-9]+)*(?:\.[a-z0-9]+(?:_[a-z0-9]+)*)?[/]?$#', $password_new) && !preg_match('/[^A-Za-z0-9_\\-]/', $password_new)) {
        if ($user[0]['gen_pass'] != substr(encryptPassword(trim($password_old)), 0, 30)) {
            $array_list["message"] = "ไม่พบรหัสผ่านของท่านกรุณาป้อนใหม่อีกครั้ง!";
            $array_list["status"] = "passOldFailed";
        } else if ($password_new != $password_confirm) {
            $array_list["message"] = "รหัสผ่านใหม่และยืนยันรหัสผ่านไม่ตรงกันกรุณาป้อนใหม่อีกครั้ง";
            $array_list["status"] = "passconfirmFailed";
        } else {
            //---------------------------อัพเดตข้อมูลตาราง gen_user--------------------------//
            db::setDB(E_DB_USER);
            $array_where1["gen_user_id"] = $_SESSION['EWT_MID'];
            $array_update1["gen_pass"] = substr(encryptPassword(trim($password_new)), 0, 30);
            $update1 = db::db_update('gen_user', $array_update1, $array_where1);
            //---------------------------อัพเดตข้อมูลตาราง USR_MAIN--------------------------//
            $array_where2["USR_USERNAME"] = $_SESSION['EWT_USERNAME'];
            $array_update2["USR_PASSWORD"] = hashPass($password_new);
            $update2 = $sso->update('USR_MAIN', $array_update2, $array_where2);
            //---------------------------เก็บ Log แก้ไขรหัสผ่าน--------------------------//
            $array_insert = array();
            $array_insert["user_id"] = $_SESSION['EWT_MID'];
            $array_insert["user_name"] = $_SESSION['EWT_USERNAME'];
            $array_insert["user_ip"] = getIP();
            $array_insert["user_type"] = "re";
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
            $ldapconfig['searchuser'] = 'uid=' . $_SESSION['EWT_USERNAME'] . ',ou=people,dc=prd,dc=go,dc=th';
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
                        $info['userpassword'][] = '{MD5}' . base64_encode(pack('H*', md5(trim($password))));
                        if ($r = ldap_mod_replace($ldapconn, $ldapconfig['searchuser'], $info) == false) {
                            $array_list["status"] = "error";
                            $array_list["message"] = "Can't Update data to LDAP server";
                        }
                        ldap_close($ldapconn);
                    }
                } else {
                    $array_list["status"] = "error";
                    $array_list["message"] = "Unable to connect to LDAP server";
                }
            }

            $array_list["message"] = "แก้ไขรหัสผ่านสำเร็จ";
            $array_list["status"] = "success";
        }
    } else {
        $array_list["message"] = "รหัสผ่านต้องประกอบด้วยภาษาอังกฤษมีพิมพ์ใหญ่พิมพ์เล็กหรือตัวเลขและจำนวนไม่น้อยกว่า 8 ตัว";
        $array_list["status"] = "passFailed";
    }
} else {
    $array_list["message"] = "Captcha ไม่ถูกต้อง กรุณากรอกใหม่!";
    $array_list["status"] = "captchaFailed";
}

echo json_encode($array_list);
exit();
