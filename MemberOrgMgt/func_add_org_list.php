<?php
include("../EWT_ADMIN/comtop_pop.php");
$a_data = array_merge($_POST, $_FILES);
$proc = $a_data['proc'];
//print_r($a_data);
//exit;
switch($proc) 
{ 
	case "Add_OrgUser":		

	
$db->query("USE ".$EWT_DB_USER);

	## >> Check ID Card
	/*if(trim($a_data['txt_org_list_idcard'])!=""){
		$checkidcard = user::chkIDCard($a_data['txt_org_list_idcard']);	
		if($checkidcard == false)
		{
			$a_error['message'] = 'รหัสบัตรประชาชน นี้มีการใช้งานอยู่แล้ว  กรุณากรอกข้อมูลใหม่อีกครั้ง';
			$a_error['warn'] 	= 'warning';
			echo json_encode($a_error);
			exit;	
		}
	}*/
		
	## >> Check Email
	if(trim($a_data['txt_org_list_email'])!=""){
		$checkemail = user::chkEmailPerson($a_data['txt_org_list_email']);	
		if($checkemail == false)
		{
			$a_error['message'] = 'E-mail นี้มีการใช้งานอยู่แล้ว  กรุณากรอกข้อมูลใหม่อีกครั้ง';
			$a_error['warn'] 	= 'warning';
			echo json_encode($a_error);
			exit;		
		}		
	}	
	
	## >> Check Username
	if(trim($a_data['txt_org_list_gen_user'])!=""){
		$checkuser = user::chkUsername($a_data['txt_org_list_gen_user']);
		if($checkuser == false)
		{
			$a_error['message'] = 'Username นี้มีการใช้งานอยู่แล้ว กรุณากรอกข้อมูลใหม่อีกครั้ง';
			$a_error['warn'] 	= 'warning';
			echo json_encode($a_error);
			exit;		
		}	
	}	
		
if(!empty($_FILES['txt_org_list_image']['tmp_name']))
{	
$db->query("USE ".$EWT_DB_NAME);	
$MAXIMUM_FILESIZE_IMG = sizeMB2byte(EwtMaxfile('img')); 
$rEFileTypes_IMG = "/^\.(".ValidfileType('img')."){1}$/i"; 

$Current_Dir = "../ewt/pic_upload/";
$isFile = is_uploaded_file($_FILES['txt_org_list_image']['tmp_name']); 
if($isFile)
{   
	$safe_filename = preg_replace( 
                     array("/\s+/", "/[^-\.\w]+/"), 
                     array("_", ""), 
                     trim($_FILES['txt_org_list_image']['name']));					 
	$type_file 	=  strrchr(strtolower($safe_filename), '.');				 
	$newfile 	= 'image_file_'.date("YmdHis").$type_file;
	 
    if ($_FILES['txt_org_list_image']['size'] <= $MAXIMUM_FILESIZE_IMG && preg_match($rEFileTypes_IMG, strrchr(strtolower($safe_filename), '.'))) 
	{	
		$isMove = move_uploaded_file($_FILES['txt_org_list_image']['tmp_name'],$Current_Dir.$newfile);		  
	} 
		$image_file = $newfile;
}
else
	{
		$image_file = "";		  	  
	}
}

$db->query("USE ".$EWT_DB_USER);
$gen_pass = substr(user::encryptPassword($a_data['txt_org_list_gen_pass']), 0, 30);	
	
$s_data = array();
$s_data['title_thai']       =  $a_data['txt_org_list_title_thai'];
$s_data['name_thai']   		=  $a_data['txt_org_list_name_thai'];
$s_data['surname_thai']   	=  $a_data['txt_org_list_surname_thai'];
$s_data['name_eng'] 		=  $a_data['txt_org_list_name_eng'];
$s_data['surname_eng'] 		=  $a_data['txt_org_list_surname_eng'];
$s_data['nickname_thai'] 	=  $a_data['txt_org_list_nickname_thai'];
$s_data['path_image']  		=  $image_file;
$s_data['emp_id']  			=  $a_data['txt_org_list_idcard'];
$s_data['org_id']      		=  $a_data['txt_org_list_org_name'];
$s_data['afft_name'] 		=  $a_data['txt_org_list_afft_name'];
$s_data['posittion']    	=  $a_data['txt_org_list_pos_name'];
$s_data['position_person']  =  $a_data['txt_org_list_pos_person'];
$s_data['level_id'] 		=  $a_data['txt_org_pos_level_name'];
$s_data['email_person']    	=  $a_data['txt_org_list_email'];
$s_data['tel_in']    		=  $a_data['txt_org_list_tel_in'];
$s_data['mobile']			=  $a_data['txt_org_list_mobile'];
$s_data['line_id']			=  $a_data['txt_org_list_line_id'];
$s_data['officeaddress']    =  $a_data['txt_org_list_address'];
$s_data['emp_type_id']    	=  '9';
$s_data['gen_user']    		=  $a_data['txt_org_list_gen_user'];
$s_data['gen_pass']    		=  $gen_pass;
$s_data['org_type_id']    	=  '';
$s_data['last_update']    	=  datetimetool::getnow(); 
$s_data['gen_by']    		=  $_SESSION['EWT_SUID'];
$s_data['status']    		=  $a_data['org_status'];
$s_data['last_update_by']   =  $_SESSION['EWT_SUID'];
$s_data['display_order']    =  '';
$s_data['create_date']    	=  datetimetool::getnow(); 
$s_data['web_use']    		=  $_SESSION['EWT_SUSER'];

## >> User expire
if($a_data['expire_use']==0){
	$s_data['expiredate'] = "";
}
else{
	$user_expire = explode("/",$a_data['user_expire']);
	$user_expire = $user_expire[2]."-".$user_expire[1]."-".$user_expire[0];
	$user_expire = filter_date("-",$user_expire);
	$s_data['expiredate'] = $user_expire;
}

insert('gen_user',$s_data);

$db->query("USE ".$EWT_DB_NAME);	
					   
sys::save_log('create','org',$txt_org_add.' '.$a_data['txt_org_list_name_thai'].' '.$a_data['txt_org_list_surname_thai']);

//unset($a_data);
//unset($s_data);
			
$a_array['status'] 	= true;
$a_array['message'] = "success";

$a_data['url'] = "../MemberOrgMgt/org_list.php";

	echo json_encode($a_data);	
	exit;	
break;
}
