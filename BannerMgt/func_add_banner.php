<?php
include("../EWT_ADMIN/comtop_pop.php");
// ini_set('display_errors', '1');
// ini_set('display_startup_errors', '1');
// error_reporting(E_ALL);
$date = new DateTime();

$a_data = array_merge($_POST, $_FILES);

if ($a_data['proc'] == 'Add_Banner') {

	$s_data = array();

	$MAXIMUM_FILESIZE = sizeMB2byte(EwtMaxfile('img'));
	$rEFileTypes = "/^\.(" . ValidfileType('img') . "){1}$/i";
	$dir_base = "../ewt/" . $_SESSION['EWT_SUSER'] . "/images/banner/";
	$dir_base1 = "images/banner/";

	$isFile = is_uploaded_file($a_data['banner_pic']['tmp_name']); 	
	if($isFile){  
		$safe_filename = preg_replace( 
						array("/\s+/", "/[^-\.\w]+/"), 
						array("_", ""), 
						trim($a_data['banner_pic']['name']));

		$type_file =  strrchr($safe_filename, '.');				 
		$newfile   = "banner_image_".date("YmdHis").$type_file;	 
		//&& preg_match($rEFileTypes, strrchr($safe_filename , '.'))
		if ($a_data['banner_pic']['size'] <= $MAXIMUM_FILESIZE) {		
			$isMove = move_uploaded_file ($a_data['banner_pic']['tmp_name'],$dir_base.$newfile);		  
			if($isMove){
				$a_attach = $dir_base1.$newfile;
			}else{
				$a_attach = "";
			} 
		} 
	}



	$s_data['banner_name']   =  $a_data['banner_name'];
	$s_data['banner_detail'] =  $a_data['banner_detail'];
	$s_data['banner_pic']    =  $a_attach;
	$s_data['banner_link']   =  $a_data['banner_link'];
	$s_data['banner_show']   =  'no';
	$s_data['banner_update'] =  $date->format('Y-m-d H:i:s');
	$s_data['banner_create'] =  $date->format('Y-m-d H:i:s');
	$s_data['banner_traget'] =  $a_data['banner_traget'];
	$s_data['banner_alt']    =  $a_data['banner_alt'];
	$s_data['banner_gid']    =  $a_data['banner_category'];
	$s_data['banner_uid']    =  $_SESSION["EWT_SUID"];
	$s_data['banner_uname']  =  $_SESSION["EWT_SUSER"];
	$s_data['banner_ip']     =  getIP();
	$s_data['banner_show_start'] = $a_data['start_date'];
	$s_data['banner_show_end']   = $a_data['end_date'];

	insert('banner', $s_data);
	$db->write_log("create", "banner", "เพิ่ม  banner " . $a_data['banner_name']);
	// print_r($a_data);	
	echo json_encode($s_data);
	unset($a_data);
	unset($s_data);
	exit;
}
