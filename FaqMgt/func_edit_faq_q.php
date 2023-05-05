<?php
include("../EWT_ADMIN/comtop_pop.php");

$date = new DateTime();
$a_data = array_merge($_POST, $_FILES);

if($a_data['proc']=='Edit_Faq_Q'){
	
$s_data = array();
$s_data['fa_ans']       =  $a_data['faq_answer'];
$s_data['fa_user_ans']  =  $_SESSION['EWT_SMUSER'];
$s_data['faq_top'] 		=  $a_data['faq_interesting'];
$s_data['faq_use']		=  $a_data['faq_show'];
$s_data['faq_dateans']  =  $date->format('Y-m-d H:i:s');

update('faq',$s_data,array('fa_id'=>$a_data['fa_id']));	
	
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