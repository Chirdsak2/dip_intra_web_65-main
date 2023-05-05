<?php
DEFINE('path', 'assets/');
include(path . 'config/config.inc.php');

//ini_set('display_errors', '1');
//ini_set('display_startup_errors', '1');
//error_reporting(E_ALL);

$a_data = array_merge($_POST, $_FILES);
$proc = $a_data['proc'];

if (intro::getIntro()["count"] > 0) {
	$page_header = "intro_page.php";
} else {
	$page_header = "index.php";
}

switch ($proc) {
	case "Login":
		if (is_array($a_data)) {
			// if ($a_data['policy_check'] != '1') {
			// 	$a_error['message'] = 'กรุณาติ๊กยอมรับนโยบายการเก็บข้อมูล';
			// 	$a_error['warn'] = 'warning';
			// 	echo json_encode($a_error);
			// 	exit;
			// }

			if (!empty($a_data['username']) && !empty($a_data['password'])) {
				$s_info  =  "SELECT login_ldap FROM " . E_DB_USER . ".user_info WHERE EWT_User = '" . E_FOLDER_USER . "' AND EWT_Status = 'Y' ";
				$a_info  =  db::getFetch($s_info);

				$auth_user = trim($a_data['username']);
				$auth_pass = trim($a_data['password']);

				if ($a_info['login_ldap'] == 'Y') {
					$ldapconfig['host'] = LDAP_HOST;
					$ldapconfig['port'] = LDAP_PORT;
					$ldapconfig['basedn'] = LDAP_AUTHEN;

					$ldapconn  = ldap_connect($ldapconfig['host'], $ldapconfig['port']);
					ldap_set_option($ldapconn, LDAP_OPT_PROTOCOL_VERSION, 3);
					ldap_set_option($ldapconn, LDAP_OPT_REFERRALS, 0);

					if ($ldapconn) {
						$dn = $ldapconfig['basedn'];
						$ldapbind = ldap_bind($ldapconn, $auth_user . '@' . LDAP_DOMAIN, $auth_pass);

						if ($ldapbind) {
							$result_search = ldap_search($ldapconn, $ldapconfig['searchuser'], "(cn=*)");
							$data_search = ldap_get_entries($ldapconn, $result_search);
							$a_uppass = substr(user::encryptPassword(trim($auth_pass)), 0, 30);
							$s_uppass = hashPass(trim($auth_pass));

							//------------------------------อัพเดตข้อมูล EWT-----------------------------------//
							$array_update_ewt = array(
								'gen_pass' => $a_uppass,
								'last_update' => date("Y-m-d")
							);

							$array_where_ewt = array('gen_user' => $auth_user);
							$s_exec = db::db_update("" . E_DB_USER . ".gen_user", $array_update_ewt, $array_where_ewt);
							//------------------------------------------------------------------------------//

							$array_where = array(
								"gen_user" => $auth_user,
								"gen_pass" => $a_uppass,
								"status" => 1
							);

							$s_sql  = "SELECT * FROM " . E_DB_USER . ".gen_user WHERE gen_user = :gen_user AND gen_pass = :gen_pass AND status = :status";
							$a_user = db::getFetch($s_sql, $array_where);

							if (!$a_user['gen_user_id']) {
								$a_error['message'] = 'ชื่อผู้ใช้งานหรือรหัสผ่านไม่ถูกต้อง';
								$a_error['warn'] = 'warning';
								echo json_encode($a_error);
								exit;
							} else {

								$_SESSION["EWT_ARTICLE_TAP_ACTIVE"] = 0;
								$_SESSION['EWT_TIMEOUT'] = time();
								$_SESSION['EWT_MID'] = $a_user['gen_user_id'];
								$_SESSION['EWT_USERNAME'] = $a_user['gen_user'];
								$_SESSION['EWT_NAME'] = $a_user['name_thai'];
								$_SESSION['EWT_SURNAME'] = $a_user['surname_thai'];

								//authentication
								$_SESSION['EWT_SESSID'] = "Y";

								chk_authent(
									$a_user['gen_user_id'],
									$a_user['gen_user'],
									$a_user['org_id'],
									$a_user['posittion'],
									$a_user['emp_type_id']
								);

								write_log();

								$a_array['status'] = true;
								$a_array['message'] = "success";
								$a_array['url'] = $page_header;
								echo json_encode($a_array);
							}
						} else {

							$array_where = array(
								"gen_user" => $auth_user,
								"gen_pass" => substr(user::encryptPassword($auth_pass), 0, 30),
								"status" => 1
							);

							$s_sql  =  	"SELECT * FROM " . E_DB_USER . ".gen_user WHERE gen_user = :gen_user AND gen_pass = :gen_pass AND status = :status";
							$a_user =  	db::getFetch($s_sql, $array_where);

							if (!$a_user['gen_user_id']) {
								$a_error['message'] = 'ชื่อผู้ใช้งานหรือรหัสผ่านไม่ถูกต้อง';
								$a_error['warn'] = 'warning';
								echo json_encode($a_error);
								exit;
							} else {
								$_SESSION["EWT_ARTICLE_TAP_ACTIVE"] = 0;
								$_SESSION['EWT_TIMEOUT'] = time();
								$_SESSION['EWT_MID'] = $a_user['gen_user_id'];
								$_SESSION['EWT_USERNAME'] = $a_user['gen_user'];
								$_SESSION['EWT_NAME'] = $a_user['name_thai'];
								$_SESSION['EWT_SURNAME'] = $a_user['surname_thai'];
								//authentication
								$_SESSION['EWT_SESSID'] = "Y";

								chk_authent(
									$a_user['gen_user_id'],
									$a_user['gen_user'],
									$a_user['org_id'],
									$a_user['posittion'],
									$a_user['emp_type_id']
								);

								write_log();

								$a_array['status'] = true;
								//$a_array['alert'] = true; 
								$a_array['message'] = "success";
								$a_array['url'] = $page_header;
								echo json_encode($a_array);
							}
						}
					} else {
						$a_error['message'] = 'Unable to connect to LDAP server';
						$a_error['warn'] = 'warning';
						echo json_encode($a_error);
						exit;
					}
				} else {
					// "gen_pass" => $auth_pass,
					$array_where = array(
						"gen_user" => $auth_user,
						
						"status" => 1
					);
					$fields_curl['userName']    = $auth_user;
					$fields_curl['password']   = $auth_pass;
					$data_string = json_encode($fields_curl);
					
					$curl = curl_init();
					curl_setopt_array(
						$curl,
						array(
							CURLOPT_URL => "https://portal.diprom.go.th/DIP_SSO/api/public/Login",
							CURLOPT_RETURNTRANSFER => true,
							CURLOPT_SSL_VERIFYPEER => false,
							CURLOPT_ENCODING => "",
							CURLOPT_MAXREDIRS => 10,
							CURLOPT_TIMEOUT => 30,
							CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
							CURLOPT_CUSTOMREQUEST => "POST",
							CURLOPT_POSTFIELDS => $data_string,
							CURLOPT_HTTPHEADER => array(
								"accept: application/json",
								"cache-control: no-cache",
								"content-type: application/json",
								"user-agent: Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/77.0.3865.90 Safari/537.36"
							)
						)
					);

					$response = curl_exec($curl);
					$err = curl_error($curl);
					curl_close($curl);
					$data = json_decode($response, true);
					
					if($data['data']['statusCode'] === '000'){
						$a_pass = substr(user::encryptPassword($auth_pass), 0, 30);
						$s_sql  = "SELECT * FROM " . E_DB_USER . ".gen_user WHERE gen_user = :gen_user AND status = :status";
						$a_user = db::getFetch($s_sql, $array_where);
						
							if (!$a_user['gen_user_id']) {

								$curl2 = curl_init();
								curl_setopt_array(
									$curl2,
									array(
										CURLOPT_URL => 'https://portal.diprom.go.th/DIP_SSO/api/public/Authen',
										CURLOPT_RETURNTRANSFER => true,
										CURLOPT_SSL_VERIFYPEER => false,
										CURLOPT_ENCODING => '',
										CURLOPT_MAXREDIRS => 10,
										CURLOPT_TIMEOUT => 0,
										CURLOPT_FOLLOWLOCATION => true,
										CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
										CURLOPT_CUSTOMREQUEST => 'POST',
										CURLOPT_HTTPHEADER => array(
											'Authorization: Bearer ' . $data['data']['authorization']['Token'],
											'Content-Type: application/json',
											'Content-Length: 0'
										)
									)
								);

								$response2 = curl_exec($curl2);
								$err2 = curl_error($curl2);
								curl_close($curl2);
								$data2 = json_decode($response2, true);
								
								if($data2['data']['data']['posTypeName'] == 'ข้าราชการ'){
									$emp_type_id = '1';
								}elseif($data2['data']['data']['posTypeName'] == 'พนักงานราชการ'){
									$emp_type_id = '2';
								}elseif($data2['data']['data']['posTypeName'] == 'ลูกจ้างประจำ'){
									$emp_type_id = '3';
								}elseif($data2['data']['data']['posTypeName'] == 'ลูกจ้างเหมา'){
									$emp_type_id = '4';
								}elseif($data2['data']['data']['posTypeName'] == 'ลูกจ้างโครงการ'){
									$emp_type_id = '5';
								}elseif($data2['data']['data']['posTypeName'] == 'ลูกจ้างชั่วคราว'){
									$emp_type_id = '6';
								}elseif($data2['data']['data']['posTypeName'] == 'ไม่ระบุ'){
									$emp_type_id = '7';
								}
							
								$data_int = array();
								$data_int['gen_user'] = $data2['data']['data']['userName'];
								$data_int['name_thai'] = $data2['data']['data']['usrFname'];
								$data_int['surname_thai'] = $data2['data']['data']['usrLname'];
								$data_int['emp_type_id'] = $emp_type_id;
								$data_int['status'] = "1";
								
								if ($data2['statusCode'] == '200') {
									$insert = db::insert(E_DB_USER . ".gen_user", $data_int);
									if ($insert == true) {
										$sso_sql  = "SELECT * FROM " . E_DB_USER . ".gen_user WHERE gen_user = '{$auth_user}' AND status = '1'";
										$sso_user = db::getFetch($sso_sql);
										
										$_SESSION["EWT_ARTICLE_TAP_ACTIVE"] = 0;
										$_SESSION['EWT_TIMEOUT'] = time();
										$_SESSION['EWT_MID'] = $sso_user['gen_user_id'];
										$_SESSION['EWT_USERNAME'] = $sso_user['gen_user'];
										$_SESSION['EWT_NAME'] = $sso_user['name_thai'];
										$_SESSION['EWT_SURNAME'] = $sso_user['surname_thai'];
										$_SESSION['EWT_USRID'] = $data2['data']['data']['usrId'];
										$_SESSION['EWT_Idcard'] = $data2['data']['data']['idCard'];
										$_SESSION['EWT_TOKEN'] = $data['data']['authorization']['Token'];
										//authentication
										$_SESSION['EWT_SESSID'] = "Y";

										chk_authent(
											$sso_user['gen_user_id'],
											$sso_user['gen_user'],
											$sso_user['org_id'],
											$sso_user['posittion'],
											$sso_user['emp_type_id']
										);

										write_log();

										$a_array['status'] = true;
										$a_array['message'] = "success";
										$a_array['url'] = $page_header;
										$a_array['che'] = $_SESSION;
										echo json_encode($a_array);
									} else {
										$a_error['message'] = 'ไม่สามารถเพิ่มข้อมูลUSERได้';
										$a_error['warn'] = 'warning';
										echo json_encode($a_error);
										exit;
									}
								} else {
									$a_error['message'] = 'ไม่สามารถเชื่อมต่อ api ได้';
									$a_error['warn'] = 'warning';
									echo json_encode($a_error);
									exit;
								}

							} else {
								$curl2 = curl_init();
								curl_setopt_array(
									$curl2,
									array(
										CURLOPT_URL => 'https://portal.diprom.go.th/DIP_SSO/api/public/Authen',
										CURLOPT_RETURNTRANSFER => true,
										CURLOPT_SSL_VERIFYPEER => false,
										CURLOPT_ENCODING => '',
										CURLOPT_MAXREDIRS => 10,
										CURLOPT_TIMEOUT => 0,
										CURLOPT_FOLLOWLOCATION => true,
										CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
										CURLOPT_CUSTOMREQUEST => 'POST',
										CURLOPT_HTTPHEADER => array(
											'Authorization: Bearer ' . $data['data']['authorization']['Token'],
											'Content-Type: application/json',
											'Content-Length: 0'
										)
									)
								);

								$response2 = curl_exec($curl2);
								$err2 = curl_error($curl2);
								curl_close($curl2);
								$data2 = json_decode($response2, true);

								$_SESSION["EWT_ARTICLE_TAP_ACTIVE"] = 0;
								$_SESSION['EWT_TIMEOUT'] = time();
								$_SESSION['EWT_MID'] = $a_user['gen_user_id'];
								$_SESSION['EWT_USERNAME'] = $a_user['gen_user'];
								$_SESSION['EWT_NAME'] = $a_user['name_thai'];
								$_SESSION['EWT_SURNAME'] = $a_user['surname_thai'];
								$_SESSION['EWT_USRID'] = $data2['data']['data']['usrId'];
								$_SESSION['EWT_Idcard'] = $data2['data']['data']['idCard'];
								$_SESSION['EWT_TOKEN'] = $data['data']['authorization']['Token'];
								//authentication
								$_SESSION['EWT_SESSID'] = "Y";

								chk_authent(
									$a_user['gen_user_id'],
									$a_user['gen_user'],
									$a_user['org_id'],
									$a_user['posittion'],
									$a_user['emp_type_id']
								);

								write_log();

								$a_array['status'] = true;
								$a_array['message'] = "success";
								$a_array['url'] = $page_header;
								$a_array['che'] = $_SESSION;
								echo json_encode($a_array);
							}
					}else{
						$a_error['message'] = 'ชื่อผู้ใช้งานหรือรหัสผ่านไม่ถูกต้อง';
						$a_error['warn'] = 'warning';
						echo json_encode($a_error);
						exit;
					}
				}
			}
		}
		exit;
		break;
}

if (empty($proc)) {
	$a_error['message'] = 'การส่งข้อมูลไม่ถูกต้อง';
	$a_error['warn'] 	= 'warning';
	echo json_encode($a_error);
}
db::closeDB();
exit;