<?php
DEFINE('path', 'assets/');
include path . '/config/config.inc.php';

ini_set('display_errors', '1');
ini_set('display_startup_errors', '1');
error_reporting(E_ALL);

$sql_api = "SELECT * FROM user_api";
$q_api = db::getFetch($sql_api);

$auth_user = $sso->decrypt($q_api["ldap_user"], 'PRD_INTRA_WEB_64', '$!b$i&z!poten@tial');
$auth_pass = $sso->decrypt($q_api["ldap_pass"], 'PRD_INTRA_WEB_64', '$!b$i&z!poten@tial');
$ldapconfig['host'] = $q_api["ldap_host1"];
$ldapconfig['port'] = '389';
$ldapconfig['basedn'] = 'ou=people,dc=prd,dc=go,dc=th';
$ldapconfig['searchuser'] = 'uid=phlii,ou=people,dc=prd,dc=go,dc=th';
$ldapconfig['usersdn'] = 'uid=' . $auth_user;
$ldapconn = ldap_connect($ldapconfig['host'], $ldapconfig['port']);
ldap_set_option($ldapconn, LDAP_OPT_PROTOCOL_VERSION, 3);
ldap_set_option($ldapconn, LDAP_OPT_REFERRALS, 0);

if ($ldapconn) {
    $dn = 'uid=' . $auth_user . ',' . $ldapconfig['basedn'];
    //$dn = 'cn=' . $auth_user . ',' . $ldapconfig['basedn'];
    $ldapbind = ldap_bind($ldapconn, "{$dn}", $auth_pass);
    
    if ($ldapbind) {
        $result = ldap_search($ldapconn, $ldapconfig['searchuser'], "(cn=*)");
        if ($result) {
            echo "true";
            //ldap_close($ldapconn);
        }
    } else {
        echo "Unable to connect to LDAP server";
    }
}

// $sql = "SELECT * FROM USR_MAIN WHERE USR_ID != 1 
// AND USR_MOVEMENT NOT IN('ถึงแก่ความตาย','ถึงแก่กรรม','ประเภทถึงแก่กรรม','ไล่ออก',
// 'ลาออก', 'ไล่ออกจากราชการ','ประเภทลาออก','ประเภทไล่ออกจากราชการ','ให้ออกจากราชการเหตุวินัย',
// 'ให้ออกจากราชการเนื่องจากเหตุเสียชีวิต') AND USR_USERNAME = ''";
// $query = $sso->getFetchAll($sql);

// $chk_user = array(
//     "phlii",
//     "natsiri_j",
//     "TV11",
//     "prd_user",
//     "phuttharat_s",
//     "pinya_s",
//     "sarocha_c",
//     "kamonwan_y"
// );
// $chk_user_id = array(
//     6887,
//     7420,
//     6860,
//     6145,
//     7299,
//     7185,
//     6827,
//     5445,
//     7154,
//     5605
// );

//|| in_array($val["gen_user_id"],$chk_user_id)
// $n = "";
// $insert = "";
// $insert2 = "";
// $USR_USERNAME = "";
//$i = 12311;
// $j = 452;
// $s_id = 220;
// $n .= "<table style='width:100%;' border='1'>";
// $n .= "<thead>";
// $n .= "<tr>";
// $n .= "<td>p_id</td>";
// $n .= "<td>p_type</td>";
// $n .= "<td>pu_id</td>";
// $n .= "<td>UID</td>";
// $n .= "<td>s_type</td>";
// $n .= "<td>s_id</td>";
// $n .= "<td>s_permission</td>";
// $n .= "</tr>";
// $n .= "</thead>";
// $n .= "<tbody>";
// foreach ($query as $value) {
//     if (!empty($value["USR_USERNAME"])) {
//         $USR_USERNAME = $value["USR_USERNAME"];
//$sql2 = "SELECT gen_user_id,gen_user FROM ewt_user_prd_intra_web.gen_user WHERE gen_user = 'natsiri_j'";
//$query2 = db::getFetchAll($sql2);
//foreach ($query2 as $val) {
//if (in_array($val["gen_user"], $chk_user)) {
//} else {
// $gen_user_id = $val["gen_user_id"];
// $insert .= "INSERT INTO permission (p_id, p_type, pu_id, UID, s_type, s_id, s_name, s_permission) VALUES ('".$i."','U', '$gen_user_id', '1', 'Ag', '".$s_id."', '', 'W');"."\n";
// $insert2 .= "INSERT INTO web_group_member (ugm_id, ug_id, ugm_type, ugm_tid) VALUES ('".$j."', '1', 'U','$gen_user_id')";
// $n .= "<tr>";
// $n .= "<td>".$i."</td>";
// $n .= "<td>U</td>";
// $n .= "<td>" . $gen_user_id . "</td>";
// $n .= "<td>1</td>";
// $n .= "<td>Ag</td>";
// $n .= "<td>" . $s_id . "</td>";
// $n .= "<td>w</td>";
// $n .= "</tr>";
// $j++;
// $i++;
//}
//}
//     }
// }

$n .= "</tbody>";
$n .= "</table>";

// echo $n;
