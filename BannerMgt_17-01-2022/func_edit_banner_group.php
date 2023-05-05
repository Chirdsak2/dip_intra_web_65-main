<?php
/*include("../lib/include.php");
include("../lib/function.php");
include("../lib/user_config.php");
include("../lib/connect.php");
include("../lib/set_lang.php");
include("../language.php");
include("../language/language_TH.php");
include("../lib/config_path.php");*/

include("../EWT_ADMIN/comtop_pop.php");
include("../language/banner_language.php");

$date = new DateTime();


$a_data = array_merge($_POST, $_FILES);

if($a_data['proc']=='Edit_Cate_Banner'){
	
$s_data = array();

$s_data['banner_name']   	=  stripslashes(htmlspecialchars($a_data['banner_name'],ENT_QUOTES)); 
$s_data['banner_detail']	=  stripslashes(htmlspecialchars($a_data['banner_detail'],ENT_QUOTES)); 
$s_data['banner_w'] 	 	=  $a_data['banner_w'];
$s_data['banner_h']      	=  $a_data['banner_h'];
$s_data['banner_update']  	  =  $date->format('Y-m-d H:i:s');
$s_data['banner_cate_order']  =  (!isset($a_data['banner_cate_order']) ? '0' : $a_data['banner_cate_order']);


update('banner_group',$s_data,array('banner_gid'=>$a_data['banner_gid']));	

$db->write_log("update","banner","แก้ไขหมวด banner ".$a_data['banner_name']);	

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