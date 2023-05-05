<?php
include("assets/config.inc.php");
include("../lib/function.php");
include("../lib/user_config.php");
include("../lib/connect.php"
 
$date = new DateTime();
$a_data = array_merge($_POST, $_FILES);
$s_data = array();

if($a_data['proc']=='Faq_Add_Q'){
if($a_data['chkpic'] == $a_data['capt']){ 
	
$s_data['f_sub_id']     = $a_data['faq_cid'];
$s_data['f_id']         = '0';
$s_data['faq_use']      = 'A';
$s_data['fa_name']      = $a_data['question-ask'];
$s_data['fa_detail']    = $a_data['detail-ask'];	
$s_data['fa_user_ask']  = $a_data['name-ask'];
$s_data['faq_date']     = $date->format('Y-m-d H:i:s');

insert('faq',$s_data);
	
echo json_encode($s_data);	
unset($a_data);
unset($s_data);

exit;
}	
}
?>