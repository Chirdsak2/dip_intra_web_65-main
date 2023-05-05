<?php
include("../EWT_ADMIN/comtop_pop.php");

$date = new DateTime();

$a_data = array_merge($_POST, $_FILES);
	
if($a_data['proc']=='Edit_OrgUser'){

## >> Encrypt password
$gen_pass = user::encryptPassword($a_data['txt_org_list_gen_pass']);	
	
$db->query("USE ".$EWT_DB_USER);		
$s_data = array();
$s_data['title_thai']       =  $a_data['txt_org_list_title_thai'];
$s_data['name_thai']   		=  $a_data['txt_org_list_name_thai'];
$s_data['surname_thai']   	=  $a_data['txt_org_list_surname_thai'];
$s_data['path_image']  		=  $image_file;
$s_data['emp_id']  			=  $a_data['txt_org_list_idcard'];
$s_data['org_id']      		=  $a_data['txt_org_list_org_name'];
$s_data['posittion']    	=  $a_data['txt_org_list_pos_name'];
$s_data['position_person']  =  $a_data['txt_org_list_pos_person'];
$s_data['email_person']    	=  $a_data['txt_org_list_email'];
$s_data['tel_in']    		=  $a_data['txt_org_list_tel_in'];
$s_data['officeaddress']    =  '';
$s_data['gen_user']    		=  $a_data['txt_org_list_gen_user'];
$s_data['gen_pass']    		=  $gen_pass;
$s_data['last_update']    	=  $date->format('Y-m-d H:i:s');
$s_data['status']    		=  $a_data['org_status'];
$s_data['last_update_by']   =  $_SESSION['EWT_SUID'];

update('gen_user',$s_data,array('gen_user_id'=>$a_data['u_id']));

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