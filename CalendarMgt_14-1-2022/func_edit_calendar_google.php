<?php
include("../EWT_ADMIN/comtop_pop.php");

$date = new DateTime();

$a_data = array_merge($_POST, $_FILES);
	

if($a_data['proc']=='Edit_Cal_Google'){
	
$s_data = array();
if($a_data['use_status'] == 'Y'){
	update('cal_google',array('cal_google_status'=>''),array('cal_google_status'=>'Y'));	
}
$s_data['cal_google_name']       = 	$a_data['google_title'];
$s_data['cal_google_embed']      = 	htmlentities($a_data['code'], ENT_QUOTES, "UTF-8");
$s_data['cal_google_status']     = 	$a_data['use_status'];



//$a_data['page_id_array'];
//for($i=0; $i<count($a_data['page_id_array']); $i++){
	
//$s_data['faq_cate_order']  = $i+1;
	
//update('faq_category',$s_data,array('faq_cate_id'=>$a_data['page_id_array'][$i]));
	
//}

update('cal_google',$s_data,array('cal_google_id'=>$a_data['cal_google_id']));
///insert('cal_google',$s_data);
							   
echo json_encode($s_data);	
unset($a_data);
unset($s_data);

exit;
	} 
?>