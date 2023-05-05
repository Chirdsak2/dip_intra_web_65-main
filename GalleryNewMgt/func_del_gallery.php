<?php
include("../EWT_ADMIN/comtop_pop.php");

$date = new DateTime();

$a_data = array_merge($_POST, $_FILES);
	
if($a_data['proc']=='Del_gallery'){
	
$s_data = array();

$query = $db->query("SELECT gallery_image.img_path_s,gallery_image.img_path_b FROM gallery_image  WHERE img_id= '".$a_data['id']."' ");
while($pic =  $db->db_fetch_array($query)){
//	del('gallery_image','img_id='.$pic['img_id']);
	if (file_exists( "../ewt/".$_SESSION["EWT_SUSER"]."/images/gallery/".$pic['img_path_s']) ) {
		unlink( "../ewt/".$_SESSION["EWT_SUSER"]."/images/gallery/".$pic['img_path_s']) );
	}
	if (file_exists( "../ewt/".$_SESSION["EWT_SUSER"]."/images/gallery/".$pic['img_path_b']) ) {
		unlink( "../ewt/".$_SESSION["EWT_SUSER"]."/images/gallery/".$pic['img_path_b']) );
	}	
}

del('gallery_image','img_id='.$a_data['id']);
del('gallery_cat_img','img_id='.$a_data['id']);

//$query = $db->query("SELECT gallery_image.img_id FROM gallery_image LEFT JOIN gallery_cat_img ON gallery_cat_img.img_id = gallery_image.img_id WHERE category_id= '".$a_data['id']."' ");
//while($pic =  $db->db_fetch_array($query)){
//	del('gallery_image','img_id='.$pic['img_id']);
//}

//$a_data['page_id_array'];
//for($i=0; $i<count($a_data['page_id_array']); $i++){
	
//$s_data['faq_cate_order']  = $i+1;
	
//update('faq_category',$s_data,array('faq_cate_id'=>$a_data['page_id_array'][$i]));
	
//}


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