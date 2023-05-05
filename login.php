<?php
//web service
	session_start();
	include("lib/include.php");
	include("lib/ewt_config.php");
	include("lib/function.php");
	
	//===================================================================
	$_POST["EWT_User"] = mysql_escape_string($_POST["EWT_User"]);
	$_POST["EWT_Password"] = mysql_escape_string($_POST["EWT_Password"]);
	//===================================================================
	
	$db=new PHPDB($EWT_DB_TYPE,$EWT_ROOT_HOST,$EWT_ROOT_USER,$EWT_ROOT_PASSWORD,$EWT_DB_USER);
	$connectdb=$db->CONNECT_SERVER();
	$db->query("SET NAMES 'utf8' ");
	if($_POST["IDCARD"] != ''){
		$id_ldap = base64_decode ($_POST["IDCARD"]);
		$id_ldap = explode('##zz##',$id_ldap);
		if($id_ldap[1] != ''){
		$sql = "SELECT * FROM gen_user WHERE emp_id = '".$id_ldap[1]."' AND status = '1' ";
		$query = $db->query($sql);
		$R = $db->db_fetch_array($query);
		$_POST["EWT_User"] = $R["gen_user"];
		$_POST["EWT_Password"] = $R["gen_pass"];
		$_POST["Flag"] = 'Login';
		}
	}

function ldap_detail($ip,$user,$pass){
//user for search data of user by CN=prdweb because user not permisstion search
	$ldap_server = $ip;
	$base_dn ="dc=prd,dc=go,dc=th";// "dc=prd,dc=go,dc=th";
	/////////////////////
	$auth_user ='cn=prdweb';
	$auth_pass ='prdweb$y$tem';
	
	if (!($connect=ldap_connect($ldap_server))) {
		die("Could not connect to ldap server");
	}
	ldap_set_option($connect, LDAP_OPT_PROTOCOL_VERSION, 3);
	ldap_set_option($connect, LDAP_OPT_REFERRALS, 0);
	// bind to server
	if (!($bind=@ldap_bind($connect,"$auth_user,$base_dn",$auth_pass))) {
		//die(ldap_error($connect));
	} else {
		$filter = "uid=$user";
		if (!($search=ldap_search($connect,$base_dn, $filter))) {
			//die(ldap_error($connect));
		}
		
		$number_returned = ldap_count_entries($connect,$search);
		$info = ldap_get_entries($connect, $search);
		$arrName=explode(' ',$info[0]["cn"][0]);
		$infoldap = $arrName[0]."||".$arrName[1]."||".$info[0]["mail"][0]."||".$info[0]["homephone"][0]."||".$info[0]["employeenumber"][0];
		return $infoldap;
	}
	ldap_close($connect);
}	
function ldap_login($ip,$user,$pass){
	$ldap_server = $ip;
	$ldap_user ="uid=$user,ou=people,dc=prd,dc=go,dc=th";//uid=prapas_c,ou=people,dc=prd,dc=go,dc=th
	/////////////////////
	$auth_user ='uid=$user';
	$auth_pass = $pass;
	
	if (!($connect=ldap_connect($ldap_server))) {
		die("Could not connect to ldap server");
	}
	ldap_set_option($connect, LDAP_OPT_PROTOCOL_VERSION, 3);
	ldap_set_option($connect, LDAP_OPT_REFERRALS, 0);
	// bind to server
	if (!($bind=@ldap_bind($connect,$ldap_user,$auth_pass))) {
		//die(ldap_error($connect));
		
	} else {
	//case user has permistion LDAP
	//But we want data info for add to database ewt
	$infoldap = ldap_detail($ip,$user,$pass);
		return $infoldap;
	}
	ldap_close($connect);
}

function Login_ewt($EWT_User,$EWT_Password){
global $db;
$EWT_Password=addslashes($EWT_Password);
$sql = "SELECT * FROM gen_user WHERE gen_user = '".$EWT_User."' AND gen_pass = '".$EWT_Password."' AND status = '1' ";
$query = $db->query($sql);
if($db->db_num_rows($query) > 0){
	$R = $db->db_fetch_array($query);
	$mid = $R["gen_user_id"];
	$mdiv = $R["org_id"];
	$mpos = $R["posittion"];
	$mtype = $R["emp_type_id"]; 
	$sql2 = "SELECT DISTINCT(permission.UID) FROM permission inner join user_info on user_info.UID = permission.UID WHERE  (( p_type = 'U' AND pu_id = '$mid') OR (p_type = 'A' AND pu_id = '$mtype' )) AND s_id = '0' and EWT_Status = 'Y' ";
	$query2 = $db->query($sql2);
	$N = $db->db_num_rows($query2);

	if($N == 0) {
	?>
	<script>
	window.location.href="index.php?err=2";	
	</script>
	<?php
	} elseif($N == 1) {
		$U = $db->db_fetch_array($query2);
		$sql3 = "SELECT * FROM user_info WHERE UID = '".$U[0]."' AND EWT_Status = 'Y' ";
		$query3 = $db->query($sql3);
		if($db->db_num_rows($query3) > 0) {
			$RR = $db->db_fetch_array($query3);
			session_register("EWT_SMTYPE");
			session_register("EWT_SMID");
			session_register("EWT_SMUSER");
			session_register("EWT_SDB");
			session_register("EWT_SUSER");
			session_register("EWT_SUID");
			$_SESSION["EWT_SUID"] = $RR["UID"];
			$_SESSION["EWT_SUSER"] = $RR["EWT_User"];
			$_SESSION["EWT_SDB"] = $RR["db_db"];
			$_SESSION["EWT_SMID"] = $mid;
			$_SESSION["EWT_SMUSER"] =$EWT_User;
			//		$sqlchk = "SELECT COUNT(permission.p_id) FROM user_group_member INNER JOIN permission ON permission.p_type = user_group_member.ugm_type AND permission.pu_id = user_group_member.ugm_tid  WHERE (( user_group_member.ugm_type = 'D' AND user_group_member.ugm_tid = '$mdiv' ) OR ( user_group_member.ugm_type = 'P' AND user_group_member.ugm_tid = '$mpos' ) OR ( user_group_member.ugm_type = 'U' AND user_group_member.ugm_tid = '$mid' )) AND permission.s_type = 'suser' AND permission.UID = '".$U[0]."' ";
			$sqlchk = "SELECT COUNT(permission.p_id) FROM permission  WHERE  (( p_type = 'U' AND pu_id = '$mid' ) OR ( p_type = 'A' AND pu_id = '$mtype' )) AND permission.s_type = 'suser' AND permission.UID = '".$U[0]."' ";
			$querychk = $db->query($sqlchk);
			$CH = $db->db_fetch_array($querychk);
			if($CH[0] > 0) {
				$_SESSION["EWT_SMTYPE"] = "Y";
			} else {
				$_SESSION["EWT_SMTYPE"] = "N";
			}
			$db->query("USE ".$RR["db_db"]);
			$db->write_log("login","login","เข้าสู่ระบบ");
			?>
			<script >
			window.location.href="EWT_ADMIN/main.php";	
			</script>
			<?php
		} else {
		?>
		<script>
		window.location.href="index.php?err=2";	
		</script>
		<?php
		}
	} else if($N > 1) {
		session_register("EWT_SMID");
		session_register("EWT_SMUSER");
		$_SESSION["EWT_SMID"] = $mid;
		$_SESSION["EWT_SMUSER"] = $EWT_User;
		?>
		<script language="javascript">
		window.location.href="select_site.php";	
		</script>
		<?php
	}
	}else{
		?>
		<script language="javascript">
		window.location.href="index.php?err=1";	
		</script>
		<?php
	}
}

if($_POST["Flag"] == "Login") {
	if($_POST["EWT_User"] != "" AND $_POST["EWT_Password"] != "") {
		$sql = "SELECT * FROM user_info WHERE EWT_User = '".$_POST["EWT_User"]."' AND EWT_Pass = '".md5((string)$_POST["EWT_Password"])."' AND EWT_Status = 'Y'  ";
		$query = $db->query($sql);
		if($db->db_num_rows($query) > 0){
			$R = $db->db_fetch_array($query);
			session_register("EWT_SMTYPE");
			session_register("EWT_SMID");
			session_register("EWT_SMUSER");
			session_register("EWT_SDB");
			session_register("EWT_SUSER");
			session_register("EWT_SUID");
			$_SESSION["EWT_SUID"] = $R["UID"];
			$_SESSION["EWT_SUSER"] = $_POST["EWT_User"];
			$_SESSION["EWT_SDB"] = $R["db_db"];
			$_SESSION["EWT_SMID"] = "";
			$_SESSION["EWT_SMUSER"] = $_POST["EWT_User"];
			$_SESSION["EWT_SMTYPE"] = "Y";
			//	setcookie ("EWT_SUSER1",$_POST["EWT_User"],time()+3600);
			//	setcookie ("EWT_SDB1",$R["db_db"],time()+3600);
			$db->query("USE ".$R["db_db"]);
			$db->write_log("login","login","เข้าสู่ระบบ");

			?>
			<script>
			window.location.href="EWT_ADMIN/main.php";	
			</script>
			<?php
		}else{
			//Find to LDAP
			$sql_info = "SELECT login_ldap,login_ldap_ip FROM user_info WHERE EWT_User = 'prd_web'";
			$query_info = $db->query($sql_info);
			$rec = $db->db_fetch_array($query_info);

			if($rec['login_ldap'] == 'Y'){
				$chk_ldap = ldap_login($rec["login_ldap_ip"],trim($_POST["EWT_User"]),$_POST["EWT_Password"]);
				
				if($chk_ldap == '' || $chk_ldap == '||||||||'){//not find
					Login_ewt($_POST["EWT_User"],$_POST["EWT_Password"]);
				}else if($chk_ldap != ''){ //find data
					//update data find
						$infoldap = explode('||',$chk_ldap);
						$user_name = $_POST["EWT_User"];
						$pass_word = $_POST["EWT_Password"];
						$org_code = $_POST["ewt_org_code1"];
						$emp_id = $infoldap[4];
						$telephone = $infoldap[3];
						$email = $infoldap[2];
						$name = $infoldap[0];
						$surname = $infoldap[1];
						$org_id = '101';
						//echo "SELECT * FROM gen_user WHERE gen_user = '".trim($_POST["EWT_User"])."'  and emp_id ='".$emp_id."'";
								$sql_login = $db->query("SELECT * FROM gen_user WHERE gen_user = '".trim($_POST["EWT_User"])."'  and emp_id ='".$emp_id."'");
								$row = $db->db_num_rows($sql_login);
								if($row > 0){
									$strUpdLD='UPDATE gen_user SET org_id=\''.$org_id.'\' '.
									',name_thai=\''.$name.'\' '.
									',surname_thai=\''.$surname.'\' '.
									',email_person=\''.$email.'\' '.
									',tel_in=\''.$telephone.'\' '.
									',status=1 '.
									',emp_id=\''.$emp_id.'\' '.
									',gen_pass=\''.trim($_POST['EWT_Password']).'\' '.
									',gen_user=\''.trim($_POST['EWT_User']).'\' '.
									'WHERE gen_user=\''.trim($_POST['EWT_User']).'\' AND emp_id=\''.trim($emp_id).'\'';
									$db->query($strUpdLD);
									
								} else {
									$emp_type_id = '1';
									$db->query("INSERT INTO gen_user (emp_type_id,org_id,name_thai,surname_thai,email_person,tel_in,gen_user,gen_pass,status,emp_id) VALUES ('".$emp_type_id."','".$org_id."','".$name."','".$surname."','".$email."','".$telephone."','".$_POST["EWT_User"]."','".$_POST["EWT_Password"]."','1','$emp_id')");

								}// end chk ldap
						Login_ewt($_POST["EWT_User"],$_POST["EWT_Password"]);
				}
			}else{
			Login_ewt($_POST["EWT_User"],$_POST["EWT_Password"]);
			}
		}
	}
}


if($_POST["Flag"] == "Select"){
	if($_SESSION["EWT_SMID"] != "" AND $_POST["UID"] != ""){
		$sql = "SELECT * FROM gen_user WHERE gen_user_id = '".$_SESSION["EWT_SMID"]."' AND status = '1' ";
		$query = $db->query($sql);
		
		$R = $db->db_fetch_array($query);
		$mid = $R["gen_user_id"];
		$mdiv = $R["org_id"];
		$mpos = $R["posittion"];
		$mtype = $R["emp_type_id"]; 
		$sql3 = "SELECT * FROM user_info WHERE UID = '".$_POST["UID"]."' AND EWT_Status = 'Y' ";
		$query3 = $db->query($sql3);
			if($db->db_num_rows($query3) > 0){
			$RR = $db->db_fetch_array($query3);
			session_register("EWT_SMTYPE");
			session_register("EWT_SDB");
			session_register("EWT_SUSER");
			session_register("EWT_SUID");
			$_SESSION["EWT_SUID"] = $RR["UID"];
			$_SESSION["EWT_SUSER"] = $RR["EWT_User"];
			$_SESSION["EWT_SDB"] = $RR["db_db"];
			//$sqlchk = "SELECT COUNT(permission.p_id) FROM user_group_member INNER JOIN permission ON permission.p_type = user_group_member.ugm_type AND permission.pu_id = user_group_member.ugm_tid  WHERE (( user_group_member.ugm_type = 'D' AND user_group_member.ugm_tid = '$mdiv' ) OR ( user_group_member.ugm_type = 'P' AND user_group_member.ugm_tid = '$mpos' ) OR ( user_group_member.ugm_type = 'U' AND user_group_member.ugm_tid = '$mid' )) AND permission.s_type = 'suser' AND permission.UID = '".$_POST["UID"]."' ";
			$sqlchk = "SELECT COUNT(permission.p_id) FROM permission  WHERE  (( p_type = 'U' AND pu_id = '".$_SESSION["EWT_SMID"]."' )  OR (p_type = 'A' AND pu_id = '$mtype' )) AND permission.s_type = 'suser' AND permission.UID = '".$_POST["UID"]."' ";
			//echo $sqlchk; exit;
			$querychk = $db->query($sqlchk);
			$CH = $db->db_fetch_array($querychk);
				if($CH[0] > 0){
				$_SESSION["EWT_SMTYPE"] = "Y";
				}else{
				$_SESSION["EWT_SMTYPE"] = "N";
				}
			$db->query("USE ".$RR["db_db"]);
			$db->write_log("login","login","เข้าสู่ระบบ");
			
			?>
			<script >
				window.location.href="EWT_ADMIN/main.php";	
			</script>
			<?php
			}
	}
}

$db->db_close();
?>