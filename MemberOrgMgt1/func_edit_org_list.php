<?php
include("../EWT_ADMIN/comtop_pop.php");
$sso = new sso();
$date = new DateTime();
DEFINE('HOST_SSO','http://203.151.166.132/PRD_INTRA_SSO/');

$a_data = array_merge($_POST, $_FILES);
	
if($a_data['proc']=='Edit_OrgUser'){

## >> Encrypt password
$gen_pass = user::encryptPassword($a_data['txt_org_list_gen_pass']);	
$gen_pass_sso = $sso->hashPass($a_data['txt_org_list_gen_pass']);
	
$db->query("USE ".$EWT_DB_USER);		
$s_data = array();
// $s_data['title_thai']       =  $a_data['txt_org_list_title_thai'];
$s_data['name_thai']   		=  $a_data['txt_org_list_name_thai'];
$s_data['surname_thai']   	=  $a_data['txt_org_list_surname_thai'];
// $s_data['emp_id']  			=  $a_data['txt_org_list_idcard'];
// $s_data['org_id']      		=  $a_data['txt_org_list_org_name'];
// $s_data['posittion']    	=  $a_data['txt_org_list_pos_name'];
// $s_data['position_person']  =  $a_data['txt_org_list_pos_person'];
$s_data['email_person']    	=  $a_data['txt_org_list_email'];
$s_data['tel_in']    		=  $a_data['txt_org_list_tel_in'];
// $s_data['officeaddress']    =  '';

$s_data_sso = array();
$s_data_sso['USR_PREFIX']       =  $a_data['txt_org_list_title_thai'];
$s_data_sso['USR_FNAME']   		=  $a_data['txt_org_list_name_thai'];
$s_data_sso['USR_LNAME']   	    =  $a_data['txt_org_list_surname_thai'];
$s_data_sso['DEP_ID']      		=  $a_data['txt_org_list_org_name'];
$s_data_sso['POS_ID']    	    =  $a_data['txt_org_list_pos_name'];
$s_data_sso['USR_EMAIL']    	=  $a_data['txt_org_list_email'];
$s_data_sso['USR_TEL']    		=  $a_data['txt_org_list_tel_in'];

## >> Update only if not ldap
if($a_data['ldap_use']==0){
    if(trim($a_data['txt_org_list_gen_user'])!=""){
        $s_data['gen_user']    	=  $a_data['txt_org_list_gen_user'];
        $s_data_sso['USR_USERNAME'] =  $a_data['txt_org_list_gen_user'];
    }
    if(trim($a_data['txt_org_list_gen_pass'])!=""){
        $s_data['gen_pass']    	=  $gen_pass;
        $s_data_sso['USR_PASSWORD'] =  $gen_pass_sso;
    }
}

$s_data['last_update']    	=  $date->format('Y-m-d H:i:s');
$s_data['status']    		=  $a_data['org_status'];
$s_data['last_update_by']   =  $_SESSION['EWT_SUID'];
$s_data['ldap_user']    	=  $a_data['ldap_use'];

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

update('gen_user',$s_data,array('gen_user_id'=>$a_data['gen_user_id']));
$sso->update('USR_MAIN', $s_data_sso, array('USR_ID'=>$a_data['u_id']));

$db->query("USE ".$EWT_DB_NAME);	
//$db->write_log("update","org",$txt_org_edit_group.' '.$a_data['org_group_name']);							   
sys::save_log('update','org',$txt_org_edit.' '.$a_data['txt_org_list_name_thai'].' '.$a_data['txt_org_list_surname_thai']);

unset($a_data);
unset($s_data);

$a_array['status'] 	= true;
$a_array['message'] = "success";

$a_data['url'] = "../MemberOrgMgt/org_list.php";

echo json_encode($a_array);	
exit;
} 
?>