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
	$base_dn = "dc=prd,dc=go,dc=th";
	$auth_user = 'cn=prdweb';
	$auth_pass = 'prdweb$y$tem';
    
    $connect = ldap_connect( $ldap_host);
	ldap_set_option($connect, LDAP_OPT_PROTOCOL_VERSION, 3);
	ldap_set_option($connect, LDAP_OPT_REFERRALS, 0);
	//$bind = ldap_bind($connect, 'ewtadministrator', 'p@ssw0rd');
	$bind = ldap_bind($connect,"$auth_user,$base_dn",$auth_pass);
    $read = ldap_search($connect,"$base_dn","(CN=*)"); 
    $info = ldap_get_entries($connect, $read); 

    echo "<b>AD-IP : ".$ldap_host.'<br>';
    echo "รายละเอียด : ".$base_dn.'<br>';
    echo "พบผู้ใช้ : ".$info["count"].' ราย<br>';

     $count_new=0;
     $count_old=0;
	$a_dup=array();
	 for ($i=0; $i < $info["count"]; $i++){
		 $a_gen_user=explode(',',$info[$i]['dn']);
		$a_gen_user0=explode('=',$a_gen_user[0]);
		$gen_user=$a_gen_user0[1];
		$emp_id=$info[$i]['employeenumber'][0];
		 $sql="SELECT gen_user FROM gen_user WHERE emp_id='$emp_id' ";
		 $query = $db->query($sql);
		 
		 $emp_type_id="1";
		$org_id="101";
		$posittion="0"; 
		if($info[$i]['initials'][0]=='Miss.'){  $title_thai='3'; }
		if($info[$i]['initials'][0]=='Mrs.'){  $title_thai='2'; }
		if($info[$i]['initials'][0]=='Mr.'){  $title_thai='6'; }
		$a_name=explode(' ', $info[$i]['cn'][0]);
		$name_thai=$a_name[0];
		$surname_thai=$a_name[1];
		$name_eng=$a_name[0];
		$surname_eng=$a_name[1];
		if(in_array($gen_user, $a_dup)) {
			$gen_user=strtolower($a_gen_user[0].'_'.substr($a_gen_user[1],0,2));
			array_push($a_dup, $gen_user);
		} else {
			array_push($a_dup, $gen_user);
		}
		$gen_pass='';
		$status=1;
		$last_update=date('Y-m-d');
		$create_date=date('Y-m-d');
		$position_person=$info[$i]['description'][0];
		$email_person=$info[$i]['mail'][0];
		$officeaddress=$info[$i]['physicaldeliveryofficename'][0];
		$emp_id=$info[$i]['employeenumber'][0];
		
         if($db->db_num_rows($query)==0){// not have in database
				$sql ="INSERT INTO  gen_user(  emp_type_id ,  org_id,  posittion,position_person,  title_thai,  name_thai , surname_thai , name_eng , surname_eng , gen_user , gen_pass , status ,last_update , create_date , email_person , officeaddress, emp_id) VALUES('$emp_type_id' ,  '$org_id',  '$posittion', '$position_person', '$title_thai',  '$name_thai' , '$surname_thai' , '$name_eng' , '$surname_eng' , '$gen_user' , '$gen_user' , '$status'  , '$last_update' , '$create_date', '$email_person','$officeaddress','$emp_id')  ";
				
				//echo $sql.'<hr>';
				//echo print_r($info[$i]).'<hr>';
				//array_push($a_user_exists, $gen_user);
				$db->query($sql);

		    $newlist[]=$info[$i]['cn'][0].' ('.($info[$i]['initials'][0]).($info[$i]['givenname'][0]).' '.($info[$i]['sn'][0]).')';
		    $count_new++;
		 }else{
		    $count_old++;
			/*$gen_user=$info[$i]['cn'][0];
			$name_eng=$info[$i]['givenname'][0];
			$surname_eng=$info[$i]['sn'][0];
			$position_person=$info[$i]['description'][0];
			$email_person=$info[$i]['mail'][0];
			$officeaddress=$info[$i]['physicaldeliveryofficename'][0];*/

			$sql="UPDATE gen_user 
			           SET  
						   emp_type_id = '$emp_type_id', 
						   position_person='$position_person',
						   title_thai = '$title_thai',
						   name_thai = '$name_thai',
						   surname_thai = '$surname_thai',
						   name_eng = '$name_eng',
						   surname_eng = '$surname_eng',
						   email_person = '$email_person',
						   officeaddress = '$officeaddress',
						   email_person='".$email_person."',
						   emp_id = '$emp_id'
					  WHERE
						   emp_id = '$emp_id'
						";
			//echo print_r($info[$i]).'<hr>';
			//echo $sql.'<hr>';
			//echo $info[$i]['dn'].'<hr>';
			$db->query($sql);
		 }
		  //print_r($info[$i]);
		  //exit;
		  //echo '<br><font color="#FF0000">';
		  //echo 'Org  : '.($info[$i]['physicaldeliveryofficename'][0]).'<br>';
		  //echo 'Org office : '.(Utf8ToTis620($info[$i]['description'][0])).'<br>';
		  //echo 'Department : '.(Utf8ToTis620($info[$i]['department'][0])).'<br>';
		  //echo 'Company : '.(Utf8ToTis620($info[$i]['company'][0])).'<br>';
		  //echo 'User : '.($info[$i]['cn'][0]).'<br>';
		  //echo 'Email : '.($info[$i]['mail'][0]).'<br>';
		  //echo 'Title : '.($info[$i]['initials'][0]).'<br>';
		  //echo 'Name : '.($info[$i]['givenname'][0]).'<br>';
		  //echo 'SName : '.($info[$i]['sn'][0]).'<hr /></font><br>';
	  }
	//echo '-->'.print_r(array_count_values($a_dup)).'<hr>';
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