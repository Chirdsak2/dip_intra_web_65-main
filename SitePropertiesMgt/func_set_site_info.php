<?php
header('Content-type: application/json; charset=utf-8');
include("../EWT_ADMIN/comtop_pop.php");

$date = new DateTime();

$a_data = array_merge($_POST, $_FILES);
	

if($a_data['proc']=='Set_Site_Info'){
		
	$s_data = array();
	$error_array = array();

	$s_data['site_info_title']        = trim($a_data['txt_title']);
	$s_data['site_info_keyword']      = trim($a_data['txt_keyword']);
	$s_data['site_info_description']  = trim($a_data['txt_desc']);
	$s_data['site_info_max_img']      = trim($a_data['txt_max_Img']);
	$s_data['site_type_img_file']     = trim($a_data['type_img_file']);
	$s_data['site_info_max_file']     = trim($a_data['txt_max_file']);
	$s_data['site_type_file']         = trim($a_data['type_file']);
	$s_data['site_info_max_vdo']      = trim($a_data['txt_max_vdo']);
	$s_data['site_type_vdo_file']     = trim($a_data['type_vdo_file']);
	
	## >> Check max image size
	if($s_data['site_info_max_img']==""){
		$s_data['site_info_max_img'] = 0;
	}
	
	if(filter_number($s_data['site_info_max_img'])==""){
		array_push($error_array,array("title"=>"ขนาดภาพไม่ถูกต้อง","content"=>"กรุณาใส่เฉพาะเลขจำนวนเต็มเท่านั้น","focus"=>"txt_max_image"));
	}
	else{
		$s_data['site_info_max_img'] = (int)$s_data['site_info_max_img'];
	}
	
	## >> Check image type
	$typefile_array = explode(",",$s_data['site_type_img_file']);
	$typefile_error = "N";

	foreach($typefile_array AS $typefile){
		if(!preg_match('/^[a-z0-9]*$/',$typefile)){
			$typefile_error = "Y";
		}
	}

	if($typefile_error == "Y"){
		array_push($error_array,array("title"=>"นามสกุลภาพไม่ถูกต้อง","content"=>"นามสกุลไฟล์ต้องประกอบด้วย a-z และ 0-9 เท่านั้น","focus"=>"type_img_file"));
	}

	## >> Check max file size
	if($s_data['site_info_max_file']==""){
		$s_data['site_info_max_file'] = 0;
	}
	if(filter_number($s_data['site_info_max_file'])==""){
		array_push($error_array,array("title"=>"ขนาดไฟล์ไม่ถูกต้อง","content"=>"กรุณาใส่เฉพาะเลขจำนวนเต็มเท่านั้น","focus"=>"txt_max_file"));
	}
	else{
		$s_data['site_info_max_file'] = (int)$s_data['site_info_max_file'];
	}

	## >> Check file type
	$typefile_array = explode(",",$s_data['site_type_file']);
	$typefile_error = "N";

	foreach($typefile_array AS $typefile){
		if(!preg_match('/^[a-z0-9]*$/',$typefile)){
			$typefile_error = "Y";
		}
	}

	if($typefile_error == "Y"){
		array_push($error_array,array("title"=>"นามสกุลไฟล์ไม่ถูกต้อง","content"=>"นามสกุลไฟล์ต้องประกอบด้วย a-z และ 0-9 เท่านั้น","focus"=>"type_file"));
	}
	

	## >> Check max vdo size
	if($s_data['site_info_max_vdo']==""){
		$s_data['site_info_max_vdo'] = 0;
	}
	if(filter_number($s_data['site_info_max_vdo'])==""){
		array_push($error_array,array("title"=>"ขนาดวิดีโอไม่ถูกต้อง","content"=>"กรุณาใส่เฉพาะเลขจำนวนเต็มเท่านั้น","focus"=>"txt_max_vdo"));
	}
	else{
		$s_data['site_info_max_vdo'] = (int)$s_data['site_info_max_vdo'];
	}

	## >> Check video file type
	$typefile_array = explode(",",$s_data['site_type_vdo_file']);
	$typefile_error = "N";

	foreach($typefile_array AS $typefile){
		if(!preg_match('/^[a-z0-9]*$/',$typefile)){
			$typefile_error = "Y";
		}
	}

	if($typefile_error == "Y"){
		array_push($error_array,array("title"=>"นามสกุลวิดีโอไม่ถูกต้อง","content"=>"นามสกุลไฟล์ต้องประกอบด้วย a-z และ 0-9 เท่านั้น","focus"=>"type_file"));
	}

	##===========================================================================================================##
	if(count($error_array)>0){
		return_data("error",$error_array[0]);
		exit();
	}
	##===========================================================================================================##

	update('site_info',$s_data,array('site_info_id'=>$a_data['site_info_id']));
	
	unset($a_data);
	unset($s_data);

	return_data("success",array());

exit;
	} 
?>