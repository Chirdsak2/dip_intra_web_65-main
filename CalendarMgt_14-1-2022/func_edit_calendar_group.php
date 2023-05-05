<?php
include("../lib/include.php");
include("../lib/function.php");
include("../lib/user_config.php");
include("../lib/connect.php");
include("../lib/set_lang.php");
include("../language.php");
include("../language/language_TH.php");
include("../lib/config_path.php");


$date = new DateTime();

$a_data = array_merge($_POST, $_FILES);
	

if($a_data['proc']=='Edit_Cate'){
	
$s_data = array();

if($a_data['category_color']){
	
	$category_color = "#".$a_data['category_color'];
}

$s_data['cat_name']   	        =  $a_data['category_title'];
$s_data['cat_color']	        =  $category_color;
$s_data['parent_cat_id'] 	 	=  '';

update('cal_category',$s_data,array('cat_id'=>$a_data['cat_id']));


$db->write_log("update","calendar","แก้ไขหมวดปฏิทินกิจกรรม ".$a_data['category_title']);	
//insert('cal_category',$s_data);
//$db->write_log("create","banner","เพิ่มหมวด banner".$a_data['banner_name']);							   
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