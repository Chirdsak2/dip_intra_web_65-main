<?php	
session_start(); 
header('Content-Type: text/html; charset=utf-8');

	include("../lib/include.php");
	include("../lib/ewt_config.php");
	include("../lib/function.php");
	
	
	$db = new PHPDB($EWT_DB_TYPE,$EWT_ROOT_HOST,$EWT_ROOT_USER,$EWT_ROOT_PASSWORD,$EWT_DB_USER);
	$connectdb=$db->CONNECT_SERVER();
	$db->query("SET NAMES 'utf8' ");
	


$a_data = array_merge($_POST, $_FILES);

function Login_ewt($EWT_User,$EWT_Password){
	global $db;
	$EWT_Password = addslashes($EWT_Password);
	$s_sql 		= 	"SELECT * FROM gen_user WHERE gen_user = '{$EWT_User}' AND gen_pass = '{$EWT_Password}' AND status = '1' ";
	$s_result 	= 	$db->query($s_sql);
	$a_rows   	= 	$db->db_num_rows($s_result);
	if($a_rows > 0){
		$a_user_info = $db->db_fetch_array($s_result);
		
		$mid 	=	$a_user_info['gen_user_id'];
		$mdiv	=	$a_user_info['org_id'];
		$mpos 	=	$a_user_info['posittion'];
		$mtype 	=	$a_user_info['emp_type_id']; 
		
		$s_sql2 = 	"SELECT DISTINCT(permission.UID) 
					 FROM permission 
					 INNER JOIN user_info ON user_info.UID = permission.UID 
					 WHERE (( p_type = 'U' AND pu_id = '{$mid}') OR (p_type = 'A' AND pu_id = '{$mtype}' )) 
					 AND s_id = '0' AND EWT_Status = 'Y' ";
		$s_result2 = $db->query($s_sql2);
		$a_rows2   = $db->db_num_rows($s_result2);
		
	if($a_rows2 == 0) {
			$a_error['message'] = 'คุณยังไม่มีสิทธิ์การเข้าใช้งานระบบ';
			$a_error['err'] 	= 'error';
			echo json_encode($a_error);
			//header("location: index.php?err=2");
			exit;	

		
	} else if($a_rows2 == 1) {
		
		$a_data2 = $db->db_fetch_array($s_result2);
		
		$s_sql3		= "SELECT * FROM user_info WHERE UID = '{$a_data2[0]}' AND EWT_Status = 'Y' ";
		$s_result3 	= $db->query($s_sql3);
		$a_rows3   	= $db->db_num_rows($s_result3);
		if($a_rows3 > 0) {
			$a_data3 = $db->db_fetch_array($s_result3);

			$_SESSION['EWT_SUID'] 	= 	$a_data3['UID'];
			$_SESSION['EWT_SUSER'] 	= 	$a_data3['EWT_User'];
			$_SESSION['EWT_SDB'] 	= 	$a_data3['db_db'];
			$_SESSION['EWT_SMID'] 	= 	$mid;
			$_SESSION['EWT_SMUSER'] =	$EWT_User;
			$_SESSION['EWT_SESSID'] = 	$_REQUEST['PHPSESSID'];
			
			$s_sql_chk 		= "	SELECT COUNT(permission.p_id) 
								FROM permission  
								WHERE (( p_type = 'U' AND pu_id = '{$mid}' ) OR ( p_type = 'A' AND pu_id = '{$mtype}' )) 
								AND permission.s_type = 'suser' 
								AND permission.UID = '{$a_data2[0]}' ";					  
			$s_result_chk	= $db->query($s_sql_chk);
			$CH = $db->db_fetch_array($s_result_chk);			
			if($CH[0] > 0) {
				$_SESSION['EWT_SMTYPE'] = "Y";
				} else {
					$_SESSION['EWT_SMTYPE'] = "N";
				}
				
			$db->query("USE ".$a_data3['db_db']);
			$db->write_log("login","login","เข้าสู่ระบบ");
			$a_array['url'] = '../EWT_ADMIN/main.php';
			echo json_encode($a_array);
			//header("location: ../EWT_ADMIN/main.php");
			exit;	
			
		} else {
			$a_error['message'] = 'คุณยังไม่มีสิทธิ์การเข้าใช้งานระบบ';
			$a_error['warn'] = 'warning';
			echo json_encode($a_error);
			exit;	
		}
	} else if($a_rows2 > 1) {
		$_SESSION['EWT_SMID'] 	= $mid;
		$_SESSION['EWT_SMUSER'] = $EWT_User;		
		//header("location: select_site.php");
		$a_array['url'] = 'select_site';
		echo json_encode($a_array);
		exit;	
		}
	} else {
			$a_error['message'] = 'กรุณาตรวจสอบ username และ password ใหม่อีกครั้ง ';
			$a_error['warn'] = 'warning';
			echo json_encode($a_error);
			exit;	
	}
}

	//===================================================================
		$EWT_User		=	$db->real_escape_string($a_data['EWT_User']);
		$EWT_Password	=	$db->real_escape_string($a_data['EWT_Password']);
	//===================================================================	

$proc = $a_data['proc'];

switch($proc) {

case "login": 

$token = SHA1(session_id());

if(!isset($a_data[$token])){
	$a_error['message'] = 'กรุณาตรวจสอบการเข้าสู่ระบบ';
	$a_error['err'] 	= 'error';
	echo json_encode($a_error);
	exit;	
}
else{
	if($a_data[$token] == $token){
		$a_error['message'] = 'กรุณาตรวจสอบการเข้าสู่ระบบ';
		$a_error['err'] 	= 'error';
		echo json_encode($a_error);
		exit;	
	}
	else{ 
		if(!isset($a_data['chkpic'])){
			$a_error['message'] = 'กรุณากรอกข้อมูลตัวเลขตามภาพใหม่อีกครั้ง';
			$a_error['warn'] 	= 'warning';
			echo json_encode($a_error);
			exit;
		}
		else{
			if($a_data['chkpic'] != $_SESSION['captchacode']){
				$a_error['message'] = 'กรุณากรอกข้อมูลตัวเลขตามภาพใหม่อีกครั้ง';
				$a_error['warn'] 	= 'warning';
				echo json_encode($a_error);
				exit;
			}
			else{
							
				$client_id 		= $_SESSION['EWT_CLIENT_ID'];
				$client_secret 	= $_REQUEST['PHPSESSID'];
				$Auth_Key = base64_encode($client_id).":".base64_encode($client_secret);

if(!empty($a_data['requesttoken']) AND $a_data['requesttoken'] == $Auth_Key ){	
	if(!empty($EWT_User) AND !empty($EWT_Password)){
		$s_sql 	  = "SELECT * FROM user_info WHERE EWT_User = '{$EWT_User}' AND EWT_Pass = '".md5((string)$EWT_Password)."' AND EWT_Status = 'Y'  ";
		$s_result = $db->query($s_sql);
		$a_rows   = $db->db_num_rows($s_result);		
		if($a_rows > 0){			
			$a_user_info = $db->db_fetch_array($s_result);
			
			$_SESSION['EWT_SUID'] 	= $a_user_info['UID'];
			$_SESSION['EWT_SUSER'] 	= $EWT_User;
			$_SESSION['EWT_SDB'] 	= $a_user_info['db_db'];
			$_SESSION['EWT_SMID'] 	= '';
			$_SESSION['EWT_SMUSER'] = $EWT_User;
			$_SESSION['EWT_SMTYPE'] = "Y";
			$_SESSION['EWT_SESSID'] = $_REQUEST['PHPSESSID'];
			
			$db->query("USE ".$a_user_info['db_db']);
			$db->write_log("login","login","เข้าสู่ระบบ");
			//header("location: ../EWT_ADMIN/main.php");
			$a_array['url'] = '../EWT_ADMIN/main.php';
			echo json_encode($a_array);
			exit;
	
		}else{
			//Find to LDAP
			$s_sql_info    = "SELECT login_ldap,login_ldap_ip FROM user_info WHERE login_ldap = 'Y' ";
			$s_result_info = $db->query($s_sql_info);
			$a_data_info   = $db->db_fetch_array($s_result_info);

			if($a_data_info['login_ldap'] == 'Y'){
				$chk_ldap = ldap_login($a_data_info['login_ldap_ip'],trim($EWT_User),$EWT_Password);
				
				if($chk_ldap == '' || $chk_ldap == '||||||||'){//not find
					Login_ewt($EWT_User,$EWT_Password);
				}else if($chk_ldap != ''){ //find data
					//update data find
						$infoldap 	= explode('||',$chk_ldap);
						$user_name 	= $EWT_User;
						$pass_word 	= $EWT_Password;
						$org_code 	= $_POST['ewt_org_code1'];
						$emp_id 	= $infoldap[4];
						$telephone 	= $infoldap[3];
						$email 		= $infoldap[2];
						$name 		= $infoldap[0];
						$surname 	= $infoldap[1];
						$org_id 	= '101';
						
								$sql_login = $db->query("SELECT * FROM gen_user WHERE gen_user = '".$EWT_User."' AND emp_id = '".$emp_id."'");
								$row = $db->db_num_rows($sql_login);
								if($row > 0){
									$strUpdLD='UPDATE gen_user SET org_id=\''.$org_id.'\' '.
									',name_thai=\''.$name.'\' '.
									',surname_thai=\''.$surname.'\' '.
									',email_person=\''.$email.'\' '.
									',tel_in=\''.$telephone.'\' '.
									',status=1 '.
									',emp_id=\''.$emp_id.'\' '.
									',gen_pass=\''.$EWT_Password.'\' '.
									',gen_user=\''.$EWT_User.'\' '.
									'WHERE gen_user=\''.$EWT_User.'\' AND emp_id=\''.trim($emp_id).'\'';
									$db->query($strUpdLD);
									
								} else {
									$emp_type_id = '1';
									$db->query("INSERT INTO gen_user (emp_type_id,org_id,name_thai,surname_thai,email_person,tel_in,gen_user,gen_pass,status,emp_id) VALUES ('".$emp_type_id."','".$org_id."','".$name."','".$surname."','".$email."','".$telephone."','".$EWT_User."','".$EWT_Password."','1','".$emp_id."')");

								}// end chk ldap
						Login_ewt($EWT_User,$EWT_Password);
				}
			}else{
			Login_ewt($EWT_User,$EWT_Password);
				}
			}
		}
		}else{	
		$a_error['message'] = 'กรุณาตรวจสอบการเข้าสู่ระบบ';
		$a_error['err'] 	= 'error';
		echo json_encode($a_error);
		exit;	
		}
		  }
		}
	  }
	}
	exit;	
break;
		case "forgot": 
		
		$s_gen_user = $db->query("SELECT * FROM gen_user WHERE email_person='{$_POST['email']}' AND status = '1'  ");
		
		$a_row = $db->db_num_rows($s_gen_user);
		
		if($a_row > 0){
			$a_data = $db->db_fetch_array($s_gen_user);
			
		}else{
			echo '<script>';
			echo 'alert(" Email นี้ไม่มีอยู่ในระบบ !!!");';
			echo 'self.location.href = "forgot.php"';
			echo '</script>';
			
		}
		
	exit;	
break;
	}
?>