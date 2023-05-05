<?php
include("../EWT_ADMIN/comtop_pop.php");

$query = $db->query("SELECT category_parent_id FROM gallery_category ORDER BY category_parent_id DESC");
$max =  $db->db_fetch_array($query);
$pi = $max['category_parent_id']+1;

$date = new DateTime();

$a_data = array_merge($_POST, $_FILES);
	
if($a_data['proc']=='Add_Gallery_cate'){
	
$s_data = array();

$s_data['category_parent_id']   =  sprintf("%'.04d\n", $pi);
$s_data['category_name']       	=  htmlspecialchars($a_data['gal_cat_title'], ENT_QUOTES);
$s_data['category_detail']     	=  $a_data['gal_cat_detail'];
$s_data['col']     				=  $a_data['gal_cat_col'];
$s_data['row']  				=  $a_data['gal_cat_row'];
$s_data['height_s']        		=  $a_data['gal_cat_smh'];
$s_data['width_s']    			=  $a_data['gal_cat_smw'];
$s_data['height_b'] 			=  $a_data['gal_cat_lgh'];
$s_data['width_b']         		=  $a_data['gal_cat_lgw'];
$s_data['category_vote']      	=  $a_data['gal_cat_allow_vote'];
$s_data['category_comment']     =  $a_data['gal_cat_allow_ment'];
$s_data['category_send']    	=  $a_data['gal_cat_allow_send'];
$s_data['cat_timestamp']  		=  $date->format('Y-m-d H:i:s');

//$a_data['page_id_array'];
//for($i=0; $i<count($a_data['page_id_array']); $i++){
	
//$s_data['faq_cate_order']  = $i+1;
	
//update('faq_category',$s_data,array('faq_cate_id'=>$a_data['page_id_array'][$i]));
	
//}

insert('gallery_category',$s_data);

//$_max = countmax('poll_cat','c_id');

//db->write_log("create","poll","เพิ่มแบบสำรวจ ".$a_data['poll_title']);	

//echo json_encode($_max);
echo json_encode($s_data);								   
//print_r($a_data);	
unset($a_data);
unset($s_data);

exit;
}else{ 

	$a_error['message'] = 'กรุณาใส่ให้ถูกต้อง';
	echo json_encode($a_error);
	unset($a_data);
	unset($s_data);
	exit;   
  
	} 
?>