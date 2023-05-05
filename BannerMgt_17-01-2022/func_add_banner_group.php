<?php
/*
include("../lib/include.php");
include("../lib/function.php");
include("../lib/user_config.php");
include("../lib/connect.php");
include("../lib/set_lang.php");
include("../language.php");
include("../language/language_TH.php");
include("../lib/config_path.php");
*/

include("../EWT_ADMIN/comtop_pop.php");
include("../language/banner_language.php");

$date = new DateTime();

$a_data = array_merge($_POST, $_FILES);
	

if($a_data['proc']=='Add_Cate_Banner'){
	
$s_data = array();

$s_data['banner_parentgid']	=  '0';
$s_data['banner_name']   	=  stripslashes(htmlspecialchars($a_data['banner_name'],ENT_QUOTES)); 
$s_data['banner_timestamp']	=  $date->format('Y-m-d H:i:s');
$s_data['banner_uid']		=  $_SESSION['EWT_MID'];
$s_data['banner_uname']		=  $_SESSION['EWT_SMUSER'];
$s_data['banner_ip']		=  '';
$s_data['banner_detail']	=  stripslashes(htmlspecialchars($a_data['banner_detail'],ENT_QUOTES)); 
$s_data['banner_w'] 	 	=  $a_data['banner_w'];
$s_data['banner_h']      	=  $a_data['banner_h'];
$s_data['banner_createdate']  =  $date->format('Y-m-d H:i:s');
$s_data['banner_update']  	  =  $date->format('Y-m-d H:i:s');
$s_data['banner_cate_order']  =  (!isset($a_data['banner_cate_order']) ? '0' : $a_data['banner_cate_order']);

insert('banner_group',$s_data);
$db->write_log("create","banner","เพิ่มหมวด banner".$a_data['banner_name']);							   
//print_r($a_data);	

echo json_encode($s_data);		
//print_r($s_data);
unset($a_data);
unset($s_data);	
//echo $a_data['lang_detail'][9];
	exit;   
}else{ 
  $a_error['message'] = 'กรุณาใส่ให้ถูกต้อง';
  echo json_encode($a_error);
	unset($a_data);
	unset($s_data);
  exit;   
  } 
?>