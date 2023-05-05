<?php
include("../EWT_ADMIN/comtop_pop.php");

$sql_de = $db->query("SELECT gallery_image.* FROM gallery_image LEFT JOIN gallery_cat_img ON gallery_cat_img.img_id = gallery_image.img_id WHERE gallery_image.img_id = '".$_POST['id']."'");
$num_de = $db->db_num_rows($sql_de);
$DE = $db->db_fetch_array($sql_de);

include("../ewt_thumbnail.php");
		$Path_true = "../ewt/".$_SESSION["EWT_SUSER"]."/images/gallery/";
		$Path_db = "images/gallery/";
		if (!file_exists( "../ewt/".$_SESSION["EWT_SUSER"]."/images/gallery")) {
			mkdir ("../ewt/".$_SESSION["EWT_SUSER"]."/images/gallery", 0777);
		}
		$gfile = "g".date("YmdHis")."_g";
		$tfile = "t".date("YmdHis")."_t";
		$F = explode(".",$_FILES["pic_com"]["name"]);
		$C = count($F);
		$CT = $C-1;
		$dir = strtolower($F[$CT]);
		if($dir == "jpeg"){ $dir = "jpg"; }
		$picname = $gfile.".".$dir;
		if($dir == "jpg" OR $dir == "png" OR $dir == "gif"){
			copy($_FILES["pic_com"]["tmp_name"],$Path_true.$picname);
			@chmod ($Path_true.$picname, 0777);
			$hi = 150;
			$wi = 150;
			$tpicname = $tfile.".".$dir;
			if($dir == "jpg"){
				thumb_jpg($Path_true.$picname,$Path_true.$tpicname, $wi, $hi);
			}
			if($dir == "gif"){
				thumb_gif($Path_true.$picname,$Path_true.$tpicname, $wi, $hi);
			}
			if($dir == "png"){
				thumb_png($Path_true.$picname,$Path_true.$tpicname, $wi, $hi);
			}
		}
$date = new DateTime();

$a_data = array_merge($_POST, $_FILES);
	
if($a_data['proc']=='Edit_Gallery'){
	
$s_data = array();

if(!empty($_FILES['pic_com']['name']) OR !empty($a_data['pic_sys']) ){
if($_POST['gal_src']=="com" AND $_POST['pic_com']!==""){
$s_data['img_name']       	=  $a_data['gal_title'];
$s_data['img_detail']     	=  $a_data['gal_detail'];
$s_data['img_path_s']     	=  $Path_db.$tpicname;
$s_data['img_path_b']  		=  $Path_db.$picname;
$s_data['img_create']       =  $date->format('Y-m-d H:i:s');
}else if($_POST['gal_src']=="sys" AND $_POST['pic_sys']!==""){
$s_data['img_name']       	=  $a_data['gal_title'];
$s_data['img_detail']     	=  $a_data['gal_detail'];
$s_data['img_path_s']     	=  $a_data['pic_sys'];
$s_data['img_path_b']  		=  $a_data['pic_sys'];
$s_data['img_create']       =  $date->format('Y-m-d H:i:s');	
}else{
$s_data['img_name']       	=  $a_data['gal_title'];
$s_data['img_detail']     	=  $a_data['gal_detail'];
$s_data['img_create']       =  $date->format('Y-m-d H:i:s');	
}
}else{
$s_data['img_name']       	=  $a_data['gal_title'];
$s_data['img_detail']     	=  $a_data['gal_detail'];
$s_data['img_create']       =  $date->format('Y-m-d H:i:s');		
}
//$a_data['page_id_array'];
//for($i=0; $i<count($a_data['page_id_array']); $i++){
	
//$s_data['faq_cate_order']  = $i+1;
	
//update('faq_category',$s_data,array('faq_cate_id'=>$a_data['page_id_array'][$i]));
	
//}

update('gallery_image',$s_data,array('img_id' => $a_data['id']));

//$_max = countmax('poll_cat','c_id');

//db->write_log("create","poll","เพิ่มแบบสำรวจ ".$a_data['poll_title']);	

//echo json_encode($_max);
echo json_encode($a_data);								   
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