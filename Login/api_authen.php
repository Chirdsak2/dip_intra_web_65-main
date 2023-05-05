<?php 
session_start(); 
// ini_set('display_errors', '1');
// ini_set('display_startup_errors', '1');
// error_reporting(E_ALL);
// print_r($_SESSION['EWT_TOKEN']);
header('Content-type: application/json; charset=utf-8');

$EWT_PATH = '../';	
$IMG_PATH = '';
$MAIN_PATH = '';

include("../lib/include.php");
include("../lib/ewt_config.php");
include("../lib/function.php");
include("../lib/config_path.php");

$db = new PHPDB($EWT_DB_TYPE,$EWT_ROOT_HOST,$EWT_ROOT_USER,$EWT_ROOT_PASSWORD,$EWT_DB_USER);
$connectdb=$db->CONNECT_SERVER();
$db->query("SET NAMES 'utf8' ");
global $db;

$token = $_GET['bfs'];
$curl = curl_init();
curl_setopt_array(
	$curl,
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
			'Authorization: Bearer ' . $token,
			'Content-Type: application/json',
			'Content-Length: 0'
		)
	)
);

$response = curl_exec($curl);
$err = curl_error($curl);
curl_close($curl);
$data = json_decode($response, true);
// echo "<pre>";
// print_r($data);
// echo "</pre>";
// echo $data['statusCode'];

if ($data['statusCode'] == 200) {
    $error_array = array();
	function Login_ewt($EWT_User){
        global $db;
        $current_date = date("Y-m-d");
        
        ## >> Check LDAP/Normal user on site
        $s_sql = "SELECT * FROM gen_user WHERE  gen_user = '$EWT_User'  COLLATE utf8_bin AND  status = '1'";
        $s_result 	= 	$db->query($s_sql);
        $a_rows   	= 	$db->db_num_rows($s_result);
        
        if($a_rows > 0){
            $a_user_info = $db->db_fetch_array($s_result);
    
            ## >> Check expire
            if($a_user_info['expiredate']=='0000-00-00'){
                $a_user_info['expiredate'] = "";
            }
    
            if($a_user_info['expiredate']!=""){
                if(strtotime($current_date) > strtotime($a_user_info['expiredate'])){
                    //return_data("general_error",array("text"=>'<span style="color:#ffffff;">ขออภัย ผู้ใช้ดังกล่าวได้สิ้นสุดความเป็นสมาชิกแล้ว</span>'));
                // return_data("general_error",array("text"=>'<span style="color:#ffffff;">ไม่พบผู้ใช้งานตามที่ระบุ โปรดตรวจสอบ username/password อีกครั้ง</span>'));
                echo '<script> alert("ไม่พบผู้ใช้งานตามที่ระบุ โปรดตรวจสอบ username/password อีกครั้ง")</script>'; 
                header('Refresh:0; url=https://portal.diprom.go.th/index.php'); 
                exit();    
            }
            }
    
            $mid 	=	ready($a_user_info['gen_user_id']);
            $mdiv	=	ready($a_user_info['org_id']);
            $mpos 	=	ready($a_user_info['posittion']);
            $mtype 	=	ready($a_user_info['emp_type_id']); 
            
            ## >> Check user's permission
            ## U is for user type permission
            ## A is for group type permission
            $s_sql2 = "SELECT DISTINCT(permission.UID) FROM permission 
            INNER JOIN user_info ON user_info.UID = permission.UID 
            WHERE (( p_type = 'U' AND pu_id = '$mid') 
            OR (p_type = 'A' AND pu_id = '$mtype' ) 
            OR (p_type = 'D' AND pu_id = '$mdiv' )) 
            AND s_id = '0' AND EWT_Status = 'Y' ";
            $s_result2 = $db->query($s_sql2);
            $a_rows2   = $db->db_num_rows($s_result2);
            
            ## Case: No permission
            if($a_rows2 == 0) {
                // return_data("general_error",array("text"=>'<span style="color:#ffffff;">คุณไม่มีสิทธ์เข้าใช้งานระบบโปรดติดต่อแอดมินระบบ Portal</span>'));
                echo '<script> alert("คุณไม่มีสิทธ์เข้าใช้งานระบบโปรดติดต่อแอดมินระบบ Portal")</script>'; 
                header('Refresh:0; url=https://portal.diprom.go.th/index.php');
                exit();   
            } 
            ## Case: Has one site permission
            else if($a_rows2 == 1) {
                
                $a_data2 = $db->db_fetch_array($s_result2);
                
                $s_sql3		= "SELECT * FROM user_info WHERE UID = '{$a_data2[0]}' AND EWT_Status = 'Y' ";
                $s_result3 	= $db->query($s_sql3);
                $a_rows3   	= $db->db_num_rows($s_result3);
                if($a_rows3 > 0) {
                    $a_data3 = $db->db_fetch_array($s_result3);
    
                    create_logincookie($a_user_info['gen_user_id'],"Normal");
                    $_SESSION['EWT_SUID'] 	= 	$a_data3['UID'];
                    $_SESSION['EWT_SUSER'] 	= 	'dip_intra_web'; //$a_data3['EWT_User'];
                    $_SESSION['EWT_SDB'] 	= 	$a_data3['db_db'];
                    $_SESSION['EWT_SMID'] 	= 	$mid;
                    $_SESSION['EWT_SMUSER'] =	$EWT_User;
                    $_SESSION['EWT_SMDIV']  =   $mdiv;
                    #$_SESSION['EWT_SESSID'] = 	$_REQUEST['PHPSESSID'];
                    
                    $s_sql_chk = "SELECT COUNT(permission.p_id) FROM permission  
                    WHERE (( p_type = 'U' AND pu_id = '{$mid}') 
                    OR (p_type = 'A' AND pu_id = '{$mtype}') 
                    OR (p_type = 'D' AND pu_id = '{$mdiv}' )) 
                    AND permission.s_type = 'suser' 
                    AND permission.UID = '{$a_data2[0]}' ";	
    
                    $s_result_chk = $db->query($s_sql_chk);
                    $CH = $db->db_fetch_array($s_result_chk);
    
                    if($CH[0] > 0) {
                        $_SESSION['EWT_SMTYPE'] = "Y";
                    } else {
                        $_SESSION['EWT_SMTYPE'] = "N";
                    }
                        
                    $db->query("USE ".$a_data3['db_db']);
                    $db->write_log("login","login","เข้าสู่ระบบ");
                    header('location: ../EWT_ADMIN/main.php');
                    // return_data("success",array("text"=>'<span style="color:#ffffff;">Login สำเร็จแล้ว กำลังทำการเข้าสู่ระบบ</span>',
                    // "redirect"=>"../EWT_ADMIN/main.php"));
                } else {
            echo '<script> alert("คุณไม่มีสิทธ์เข้าใช้งานระบบโปรดติดต่อแอดมินระบบ Portal")</script>'; 

                    header('location: https://portal.diprom.go.th/index.php');
                    exit();
                    // return_data("general_error",array("text"=>'<span style="color:#ffffff;">คุณไม่มีสิทธ์เข้าใช้งานระบบโปรดติดต่อแอดมินระบบ Portal</span>'));
                }
            } 
            ## Case: Have multiple sites' permissions
            else if($a_rows2 > 1) {
                $_SESSION['EWT_SMID'] 	= $mid;	
                $_SESSION['EWT_SMDIV']  = $mdiv;
                $_SESSION['EWT_SMUSER'] = $EWT_User;	
                //header("location: select_site.php");
                $a_array['url'] = 'select_site';
                echo json_encode($a_array);
                exit;	
            }
        } 
        else {
            // return_data("general_error",array("text"=>'<span style="color:#ffffff;">ไม่พบผู้ใช้งานตามที่ระบุ โปรดตรวจสอบ username/password อีกครั้ง</span>'));
            echo '<script> alert("ไม่พบผู้ใช้งานตามที่ระบุ โปรดตรวจสอบ username/password อีกครั้ง")</script>'; 
                header('Refresh:0; url=https://portal.diprom.go.th/index.php'); 
                exit();  
        }
    }
    function create_logincookie($user_id,$login_type){
        global $db;
        global $EWT_USER_TOKEN_BACKEND;
        global $EWT_USER_LOGINTYPE_BACKEND;

        $token			= strtolower(makerandomletter(100));
        $expiredatetime = date("Y-m-d H:i:s", strtotime("+1 day"));

        setcookie($EWT_USER_TOKEN_BACKEND, $token,
        ['expires' =>  time()+(86400),
        'path' => '/',
        'domain' => $EWT_COOKIE_DOMAIN,
        'secure' => $EWT_COOKIE_SECURE,
        'httponly' => $EWT_COOKIE_HTTPONLY,
        'samesite' => $EWT_COOKIE_SAMESITE
        ]); // 86400 = 1 day
        setcookie($EWT_USER_LOGINTYPE_BACKEND, $login_type,
        ['expires' =>  time()+(86400),
        'path' => '/',
        'domain' => $EWT_COOKIE_DOMAIN,
        'secure' => $EWT_COOKIE_SECURE,
        'httponly' => $EWT_COOKIE_HTTPONLY,
        'samesite' => $EWT_COOKIE_SAMESITE
        ]); // 86400 = 1 day
        
        $_COOKIE[$EWT_USER_TOKEN_BACKEND]     = $token;
        $_COOKIE[$EWT_USER_LOGINTYPE_BACKEND] = $login_type;

        $db->query("INSERT INTO login_history_user (user_id,login_token,create_date,
        expire_date,token_status,login_through) 
        VALUES ('$user_id','$token',NOW(),'$expiredatetime','Y','$login_type')");
    }

    $EWT_User = $data['data']['data']['userName'];
    $is_siteadmin = "N";
	$is_ldap      = "N";
	$login_type   = "";
	$this_userinfo= "";
	
	## Case 1: Site Admin
	$siteadmin_sql = "SELECT * FROM user_info WHERE EWT_User = '".$data['data']['data']['userName']."' COLLATE utf8_bin AND EWT_Status = 'Y'  ";
	$siteadmin_data = $db->query($siteadmin_sql);
	
	if($db->db_num_rows($siteadmin_data)>0){
		$siteadmin_info = $db->db_fetch_array($siteadmin_data);
		$is_siteadmin  = "Y";
		$this_userinfo = $siteadmin_info;
	}	

	if($is_siteadmin == "Y"){
		create_logincookie($this_userinfo['UID'],"Site_Admin");
		$mid = ready($this_userinfo['gen_user_id']);
		$mdiv =	ready($this_userinfo['org_id']);
		$mpos =	ready($this_userinfo['posittion']);
		$mtype = ready($this_userinfo['emp_type_id']); 

		$_SESSION['EWT_SUID'] 	= $this_userinfo['UID'];
		$_SESSION['EWT_SUSER'] 	= 'dip_intra_web'; //$EWT_User;
		$_SESSION['EWT_SDB'] 	= $this_userinfo['db_db'];
		$_SESSION['EWT_SMID'] 	= '';
		$_SESSION['EWT_SMUSER'] = $EWT_User;
		$_SESSION['EWT_SMTYPE'] = "Y";
		$_SESSION['EWT_SMDIV']  = $mdiv;
		//$_SESSION['EWT_SESSID'] = $_REQUEST['PHPSESSID'];
	
		## >> Collect login history
		$db->query("USE ".$this_userinfo['db_db']);
		$db->write_log("login","login","เข้าสู่ระบบ");
	}else{
		## Case 2: Ldap User [set at lib/user_config.php]
		if($EWT_LDAP_USE=="Y"){
			$ldap_username     = trim($_POST["login_username"]).$EWT_LDAP_ADDRESS;
			$ldap_password     = trim($_POST["login_password"]);

			$ldapconfig['host']    = LDAP_HOST;//CHANGE THIS TO THE CORRECT LDAP SERVER
			$ldapconfig['port']    = LDAP_PORT;
			$ldapconfig['basedn']  = LDAP_BASEDN;//CHANGE THIS TO THE CORRECT BASE DN
			//$ldapconfig['usersdn'] = 'cn=users';//CHANGE THIS TO THE CORRECT USER OU/CN
			$ldapconn              = ldap_connect($ldapconfig['host'],$ldapconfig['port']);
			
			$ldaptree = $ldapconfig['basedn'];
			
			ldap_set_option($ldapconn, LDAP_OPT_PROTOCOL_VERSION, 3);
			ldap_set_option($ldapconn, LDAP_OPT_REFERRALS, 0);
			ldap_set_option($ldapconn, LDAP_OPT_NETWORK_TIMEOUT, 10);
			
			$total_user = 0;
			
			if($ldapconn){
				$ldapbind = ldap_bind($ldapconn, $ldap_username, $ldap_password);
				
				if ($ldapbind) {
					$result = ldap_search($ldapconn,$ldaptree, "(&(cn=*)(userprincipalname=$ldap_username))");
					$data   = ldap_get_entries($ldapconn, $result);
			
					$ldap_member = $data[0];
					if(in_array("user",$ldap_member["objectclass"])){
						//$this_member["samaccountname"] = $ldap_member["samaccountname"][0];
						$total_user++;
					}
				}
			}

			if($total_user>0){
				$is_ldap = "Y";
			}

			if($is_ldap == "Y"){
				$EWT_User     = ready($data['data']['data']['userName']);
				// $EWT_User     = ready($ldap_member["samaccountname"][0]);
				$EWT_Password = ready(substr(user::encryptPassword(trim($ldap_member["samaccountname"][0])),0,30));
				Login_ewt($EWT_User);
			}	

			## Case 3: Normal User
			else if($is_ldap == "N"){
				$EWT_User     = ready($data['data']['data']['userName']);
				$EWT_Password = ready(substr(user::encryptPassword(trim($_POST["login_password"])),0,30));
				//$EWT_Password = ready($_POST["login_password"]);
				Login_ewt($EWT_User);
			}	
		}else{
			$EWT_User     = ready($data['data']['data']['userName']);
			$EWT_Password = ready(substr(user::encryptPassword(trim($_POST["login_password"])),0,30));
			//$EWT_Password = ready($_POST["login_password"]);
			Login_ewt($EWT_User);
		}
	}

	##============================================================================================================##
	## >> Unset session
	unset($_SESSION["gen_pic_".$captcha_id]);
	unset($_SESSION["login_form_".$csrf_id]);

    header('location: ../EWT_ADMIN/main.php');
	// return_data("success",array("text"=>'<span style="color:#ffffff;">Login สำเร็จแล้ว กำลังทำการเข้าสู่ระบบ</span>',
	//                             "redirect"=>"../EWT_ADMIN/main.php"));
}else{
    header('location: https://portal.diprom.go.th/index.php');
	exit();
}
