<?php
session_start();
set_time_limit(30*60);
include("../lib/include.php");
include("../lib/function.php");
include("../lib/ewt_config.php");
include("../lib/connect.php");
$db->query("USE ".$EWT_DB_NAME);

function Utf8ToTis620($string) {
  $str = $string;
  $res = '';
  for ($i = 0; $i < strlen($str); $i++) {
    if (ord($str[$i]) == 224) {
      $unicode = ord($str[$i+2]) & 0x3F;
      $unicode |= (ord($str[$i+1]) & 0x3F) << 6;
      $unicode |= (ord($str[$i]) & 0x0F) << 12;
      $res .= chr($unicode-0x0E00+0xA0);
      $i += 2;
    } else {
      $res .= $str[$i];
    }
  }
  return $res;
}
$a_user_exists=array();
$sql_info = "SELECT login_ldap,login_ldap_ip FROM user_info WHERE EWT_User = '".$_SESSION["EWT_SUSER"]."'";
$query_info = $db->query($sql_info);
$rec = $db->db_fetch_array($query_info);
if($rec['login_ldap'] != 'Y'){
     echo $_SESSION["EWT_SUSER"];
	 echo "<br>ไม่มีการตั้งค่าสำหรับการเชื่อมต่อไปยังระบบ LDAP";
	 exit;
}else{
    echo "รายงานผล<hr>";
	$ldap_host = $rec["login_ldap_ip"];  //172.16.1.101 
	//$base_dn = "OU=OPS,OU=UserAuthen,DC=moc,DC=go,DC=th";
	$base_dn = "dc=prd,dc=go,dc=th";//ou=people,dc=prd,dc=go,dc=th 
	$auth_user = 'cn=prdweb';
	$auth_pass = 'prdweb$y$tem';
    
    $connect = ldap_connect( $ldap_host);
	ldap_set_option($connect, LDAP_OPT_PROTOCOL_VERSION, 3);
	ldap_set_option($connect, LDAP_OPT_REFERRALS, 0);
	//$bind = ldap_bind($connect, 'ewtadministrator', 'p@ssw0rd');
	$bind = ldap_bind($connect,"$auth_user,$base_dn",$auth_pass);
	$filter = "(CN=*)";//"uid=$user";
    $read = ldap_search($connect,"$base_dn",$filter); 
    $info = ldap_get_entries($connect, $read); 
print_r($info[1]);
print_r($info[1]["userpassword"][0]);
echo $info[1]['uid'][0];
    echo "<b>AD-IP : ".$ldap_host.'<br>';
    echo "รายละเอียด : ".$base_dn.'<br>';
    echo "พบผู้ใช้ : ".$info["count"].' ราย<br>';

     $count_new=0;
     $count_old=0;
	$a_dup=array();
	
    echo "รายเก่า : ".$count_old.' ราย<br>';
    echo "รายใหม่ : ".$count_new.' ราย<br></b><font size="2">';
	for ($i=0; $i < sizeof($newlist); $i++){
	     echo ' - '.$newlist[$i].'<br>';
	}
	echo "</font><hr><br>";
	ldap_close($connect);
	exit;
}

?>