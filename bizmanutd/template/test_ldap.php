<?php
session_start();
//session_destroy();
include("lib/function.php");
include("lib/user_config.php");
include("lib/connect_uncheck.php");

if($_GET['passKey']!='8f27678eebfdc11efa530607cf944d48') {
	exit;
}
function emp_type(){
					global $db;
					$sql = "select emp_type_id from emp_type where emp_type_status ='2'";
					$query = $db->query($sql);
					$R = $db->db_fetch_array($query);
					return $R[emp_type_id];
					}
					function org(){
					global $db;
					$sql = "select org_id from org_name where parent_org_id ='0001'";
					$query = $db->query($sql);
					$R = $db->db_fetch_array($query);
					return $R[org_id];
					}
					function gen_user_id($user,$pass){
					global $db;
					$sql = "select gen_user_id from gen_user where gen_user ='$user' and gen_pass = '$pass'";
					$query = $db->query($sql);
					$R = $db->db_fetch_array($query);
					return $R[gen_user_id];
					}
					
function ldap_login($ip,$user,$pass){
	$ldap_server = $ip;
	//$base_dn = "ou=people,dc=prd,dc=go,dc=th";
	$base_dn = "dc=prd,dc=go,dc=th";
	/////////////////////
	$auth_user = 'cn=prdweb';
	$auth_pass = 'prdweb$y$tem';
	
	if (!($connect=ldap_connect($ldap_server))) {
			 die("Could not connect to ldap server");
	}
	ldap_set_option($connect, LDAP_OPT_PROTOCOL_VERSION, 3);
	ldap_set_option($connect, LDAP_OPT_REFERRALS, 0);
	echo 'bind : '."$auth_user,$base_dn / pass : ".$auth_pass.'<br/>';
	// bind to server
	if (!($bind=@ldap_bind($connect,"$auth_user,$base_dn",$auth_pass))) {
		//die(ldap_error($connect));
		echo '<font style="color:red;">case 1 '.ldap_error($connect).'</font><br/>';
	} else {
		//$filter = "dc=prd";
		echo '<font style="color:red;">case 2</font><br/>';
		$filter = "uid=$user";
		if (!($search=ldap_search($connect,$base_dn, $filter))) {
			//die(ldap_error($connect));
			echo '<font style="color:red;">'.ldap_error($connect).'</font><br/>';
		}
		
		$number_returned = ldap_count_entries($connect,$search);
		$info = ldap_get_entries($connect, $search);
		$arrName=explode(' ',$info[0]["cn"][0]);
		$infoldap = $info[0]['cn'][0]."||".$info[0]['cn'][0]."||".$info[0]["mail"][0]."||".$info[0]["homephone"][0]."||".$info[0]["employeenumber"][0];
		return $infoldap;
	}
	ldap_close($connect);
}

$sql_info = "SELECT login_ldap,login_ldap_ip FROM user_info WHERE EWT_User = '".$EWT_FOLDER_USER."'";
$query_info = $db->query($sql_info);
$rec = $db->db_fetch_array($query_info);
if($rec['login_ldap'] == 'Y'){
//echo $rec["login_ldap_ip"].'<br/>';
	//$chk_ldap = ldap_login($rec["login_ldap_ip"],trim($_POST["ewt_user1"]),$_POST["ewt_pass1"]);
	echo '1. username: prdweb / password : prdweb$y$tem / basedn : dc=prd,dc=go,dc=th / ip : '.$rec["login_ldap_ip"].'<hr>';
	$chk_ldap = ldap_login($rec["login_ldap_ip"],'prdweb','prdweb$y$tem');
	echo '<hr>result : '.$chk_ldap.'<hr>';
	
	echo '2. username: sirikarn_b / password : bluebowna / basedn : dc=prd,dc=go,dc=th / ip : '.$rec["login_ldap_ip"].'<hr>';
	$chk_ldap = ldap_login($rec["login_ldap_ip"],'sirikarn_b','bluebowna');
	echo '<hr>result : '.$chk_ldap.'<hr>';
	if($chk_ldap != ''){
		//cese return true
		$infoldap = explode('||',$chk_ldap);
		$user_name = 'sirikarn_b';
		$pass_word = 'bluebowna';
		$org_code = $_POST["ewt_org_code1"];
		$emp_id = $infoldap[4];
		$telephone = $infoldap[3];
		$email = $infoldap[2];
		$name = $infoldap[0];
		$surname = $infoldap[1];
		
		$emp_type_id = emp_type();
		$org_id = '0';
		$sql_login = $db->query("SELECT * FROM gen_user WHERE gen_user = '".trim($_POST["ewt_user1"])."' AND  gen_pass = '".trim($_POST["ewt_pass1"])."'  ");
		$row = $db->db_num_rows($sql_login);
		if($row > 0){
			$strUpdLD='UPDATE gen_user SET emp_type_id=\''.$emp_type_id.'\' '.
			',org_id=\''.$org_id.'\' '.
			',name_thai=\''.$name.'\' '.
			',surname_thai=\''.$surname.'\' '.
			',email_person=\''.$email.'\' '.
			',tel_in=\''.$telephone.'\' '.
			',status=1 '.
			',emp_id=\''.$emp_id.'\' '.
			'WHERE gen_user=\''.trim($_POST['ewt_user1']).'\' AND gen_pass=\''.trim($_POST['ewt_pass1']).'\'';
			//echo $strUpdLD;
			//$db->query($strUpdLD);
		} else {
			//$db->query("INSERT INTO gen_user (emp_type_id,org_id,name_thai,surname_thai,email_person,tel_in,gen_user,gen_pass,status,emp_id) VALUES ('".$emp_type_id."','".$org_id."','".$name."','".$surname."','".$email."','".$telephone."','".$_POST["ewt_user1"]."','".$_POST["ewt_pass1"]."','1','$emp_id')");
			//echo "INSERT INTO gen_user (emp_type_id,org_id,name_thai,surname_thai,email_person,tel_in,gen_user,gen_pass,status,emp_id) VALUES ('".$emp_type_id."','".$org_id."','".$name."','".$surname."','".$email."','".$telephone."','".$_POST["ewt_user1"]."','".$_POST["ewt_pass1"]."','1','$emp_id')";
			
			$qSelPer=$db->query("SELECT gen_user_id FROM gen_user WHERE ldap_user='1' AND ldap_org='$org_code'");
			$numSelPer=$db->db_num_rows($qSelPer);
			if($numSelPer>0) {
				$rSelPer=$db->db_fetch_array($qSelPer);
				$qPer=$db->query("SELECT * FROM permission WHERE UID='$rSelPer[0]'");
				while($rPer=$db->db_fetch_array($qPer)) {
					$db->query("INSERT INTO permission(p_type,pu_id,UID,s_type,s_id,s_name,s_permission) VALUES('$rPer[p_type]','$rPer[UID]','$rPer[s_type]','$rPer[s_id]','$rPer[s_name]','$rPer[s_permission]')");
					//echo print_r($rPer).'<hr>';
				}
			}
		}
		$gen_user_id = gen_user_id($_POST["ewt_user1"],$_POST["ewt_pass1"]);
		echo $gen_user_id;
		exit;
	}
}

?>