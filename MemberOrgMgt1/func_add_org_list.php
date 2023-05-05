<?php
include("../EWT_ADMIN/comtop_pop.php");
$sso = new sso();

$date = new DateTime();

$a_data = array_merge($_POST, $_FILES);

if ($a_data['proc'] == 'Add_OrgUser') {

	$db->query("USE " . $EWT_DB_USER);

	## >> Check ID Card
	if (trim($a_data['txt_org_list_idcard']) != "") {
		$checkidcard = user::chkIDCard($a_data['txt_org_list_idcard']);
		if ($checkidcard == false) {
			//$a_error['message'] = 'รหัสบัตรประชาชน นี้มีการใช้งานอยู่แล้ว  กรุณากรอกข้อมูลใหม่อีกครั้ง';
			//$a_error['warn'] 	= 'warning';
			//echo json_encode($a_error);
			//exit;	
		}
	}

	## >> Check Email
	if (trim($a_data['txt_org_list_email']) != "") {
		$checkemail = user::chkEmailPerson($a_data['txt_org_list_email']);
		if ($checkemail == false) {
			$a_error['message'] = 'E-mail นี้มีการใช้งานอยู่แล้ว  กรุณากรอกข้อมูลใหม่อีกครั้ง';
			$a_error['warn'] 	= 'warning';
			echo json_encode($a_error);
			exit;
		}
	}

	## >> Check Username
	if (trim($a_data['txt_org_list_gen_user']) != "") {
		$checkuser = user::chkUsername($a_data['txt_org_list_gen_user']);
		if ($checkuser == false) {
			$a_error['message'] = 'Username นี้มีการใช้งานอยู่แล้ว กรุณากรอกข้อมูลใหม่อีกครั้ง';
			$a_error['warn'] 	= 'warning';
			echo json_encode($a_error);
			exit;
		}
	}

	if (!empty($_FILES['txt_org_list_image']['tmp_name'])) {
		$db->query("USE " . $EWT_DB_NAME);
		$MAXIMUM_FILESIZE_IMG = sizeMB2byte(EwtMaxfile('img'));
		$rEFileTypes_IMG = "/^\.(" . ValidfileType('img') . "){1}$/i";

		$Current_Dir = "../ewt/pic_upload/";
		$isFile = is_uploaded_file($_FILES['txt_org_list_image']['tmp_name']);
		if ($isFile) {
			$safe_filename = preg_replace(
				array("/\s+/", "/[^-\.\w]+/"),
				array("_", ""),
				trim($_FILES['txt_org_list_image']['name'])
			);
			$type_file 	=  strrchr(strtolower($safe_filename), '.');
			$newfile 	= 'image_file_' . date("YmdHis") . $type_file;

			if ($_FILES['txt_org_list_image']['size'] <= $MAXIMUM_FILESIZE_IMG && preg_match($rEFileTypes_IMG, strrchr(strtolower($safe_filename), '.'))) {
				$isMove = move_uploaded_file($_FILES['txt_org_list_image']['tmp_name'], $Current_Dir . $newfile);
			}
			$image_file = $newfile;
		} else {
			$image_file = "";
		}
	}

	$db->query("USE " . $EWT_DB_USER);
	$gen_pass = user::encryptPassword($a_data['txt_org_list_gen_pass']);

	$s_data = array();
	$s_data['title_thai']       =  $a_data['txt_org_list_title_thai'];
	$s_data['name_thai']   		=  $a_data['txt_org_list_name_thai'];
	$s_data['surname_thai']   	=  $a_data['txt_org_list_surname_thai'];
	$s_data['name_eng']   		=  $a_data['txt_org_list_name_thai'];
	$s_data['surname_eng']   	=  $a_data['txt_org_list_surname_thai'];
	$s_data['path_image']  		=  $image_file;
	$s_data['emp_id']  			=  $a_data['txt_org_list_idcard'];
	$s_data['org_id']      		=  $a_data['txt_org_list_org_name'];
	$s_data['posittion']    	=  $a_data['txt_org_list_pos_name'];
	$s_data['position_person']  =  $a_data['txt_org_list_pos_person'];
	$s_data['email_person']    	=  $a_data['txt_org_list_email'];
	$s_data['tel_in']    		=  $a_data['txt_org_list_tel_in'];
	$s_data['officeaddress']    =  '';
	$s_data['emp_type_id']    	=  '9';

	## >> Update only if not ldap
	if ($a_data['ldap_use'] == 0) {
		$s_data['gen_user']    		=  $a_data['txt_org_list_gen_user'];
		$s_data['gen_pass']    		=  $gen_pass;
	}
	$s_data['org_type_id']    	=  '';
	$s_data['last_update']    	=  $date->format('Y-m-d H:i:s');
	$s_data['gen_by']    		=  $_SESSION['EWT_SUID'];
	$s_data['status']    		=  $a_data['org_status'];
	$s_data['last_update_by']   =  $_SESSION['EWT_SUID'];
	$s_data['display_order']    =  '';
	$s_data['create_date']    	=  $date->format('Y-m-d H:i:s');
	$s_data['web_use']    		=  $_SESSION['EWT_SUSER'];
	$s_data['ldap_user']    	=  $a_data['ldap_use'];

	## >> User expire
	if ($a_data['expire_use'] == 0) {
		$s_data['expiredate'] = "";
	} else {
		$user_expire = explode("/", $a_data['user_expire']);
		$user_expire = $user_expire[2] . "-" . $user_expire[1] . "-" . $user_expire[0];
		$user_expire = filter_date("-", $user_expire);
		$s_data['expiredate'] = $user_expire;
	}

	insert('gen_user', $s_data);

	$db->query("USE " . $EWT_DB_NAME);
	//$db->write_log("create","org",$txt_org_pos_name_add.' '.$a_data['pos_name']);							   
	sys::save_log('create', 'org', $txt_org_add . ' ' . $a_data['txt_org_list_name_thai'] . ' ' . $a_data['txt_org_list_surname_thai']);

	// ------------------------------------------sso---------------------------------------//
	$USR_PASSWORD = hash('sha1', trim($a_data['txt_org_list_gen_pass']));

	$sso_data = array();
	$sso_data['USR_ID']				=  $sso->maxId('USR_MAIN','USR_ID');
	$sso_data['USR_PREFIX']       	=  $a_data['txt_org_list_title_thai'];
	$sso_data['USR_FNAME']   		=  $a_data['txt_org_list_name_thai'];
	$sso_data['USR_LNAME']   		=  $a_data['txt_org_list_surname_thai'];
	$sso_data['USR_FNAME_EN']   	=  $a_data['txt_org_list_name_thai'];
	$sso_data['USR_LNAME_EN']   	=  $a_data['txt_org_list_surname_thai'];
	$sso_data['USR_CARDNO']			=  $a_data['txt_org_list_idcard'];
	$sso_data['USR_USERNAME']    	=  $a_data['txt_org_list_gen_user'];
	$sso_data['USR_PASSWORD']    	=  $USR_PASSWORD;
	$sso_data['USR_PICTURE']  		=  $image_file;
	$sso_data['USR_DIVISION']      	=  $a_data['txt_org_list_org_name'];
	$sso_data['USR_POSITION']    	=  $a_data['txt_org_list_pos_name'];
	$sso_data['USR_MPOSITION']  	=  $a_data['txt_org_list_pos_person'];
	$sso_data['USR_MEMAIL']    		=  $a_data['txt_org_list_email'];
	$sso_data['USR_TEL']    		=  $a_data['txt_org_list_tel_in'];
	
	$sso->insert('USR_MAIN', $sso_data);

	$a_array['status'] 	= true;
	$a_array['message'] = "success";

	$a_data['url'] = "../MemberOrgMgt/org_list.php";

	//unset($a_data);
	//unset($s_data);
	//unset($sso_data);

	echo json_encode($a_data);
	exit;
}
