<?php
include("../lib/include.php");
include("../lib/function.php");
include("../lib/user_config.php");
include("../lib/connect.php");
include("../lib/set_lang.php");

$date = new DateTime();

$a_data = array_merge($_POST, $_FILES);
	

if($a_data['proc']=='Add_Faq'){
	
$s_data = array();
$s_data['f_id']         =  '0';
$s_data['fa_name']      =  $a_data['faq_title'];
$s_data['fa_detail']    =  $a_data['faq_detail'];
$s_data['fa_ans']       =  $a_data['faq_answer'];
$s_data['f_sub_id']     =  $a_data['faq_category'];
$s_data['fa_user_ask']  =  $_SESSION['EWT_SMUSER'];
$s_data['fa_user_ans']  =  $_SESSION['EWT_SMUSER'];
$s_data['faq_top'] 		=  $a_data['faq_interesting'];
$s_data['faq_use']		=  $a_data['faq_show'];
$s_data['faq_date']     =  $date->format('Y-m-d H:i:s');
$s_data['faq_dateans']  =  $date->format('Y-m-d H:i:s');


insert('faq',$s_data);
							   
//print_r($a_data);	

unset($a_data);
unset($s_data);

exit;
} 
?>