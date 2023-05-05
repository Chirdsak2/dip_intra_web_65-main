<?php
include("../EWT_ADMIN/comtop_pop.php");

$date = new DateTime();

$a_data = array_merge($_POST, $_FILES);


if ($a_data['proc'] == 'Edit_Vdo') {

	$s_data = array();

	$vdo_name   = stripslashes(htmlspecialchars($a_data['vdo_name'], ENT_QUOTES));
	$vdo_detail = stripslashes(htmlspecialchars($a_data['vdo_detail'], ENT_QUOTES));
	$vdo_creator = stripslashes(htmlspecialchars($a_data['vdo_creator'], ENT_QUOTES));
	$vdo_info   = stripslashes(htmlspecialchars($a_data['vdo_info'], ENT_QUOTES));

	$Current_Dir = "../ewt/" . $_SESSION['EWT_SUSER'] . "/download/file_vdo/";
	$Current_Dir3 = "../ewt/" . $_SESSION['EWT_SUSER'] . "/download";
	$Current_Dir2 = "file_vdo";

	if (!empty($_FILES['vdo_file']['tmp_name'])) {
		$MAXIMUM_FILESIZE_VDO = sizeMB2byte(EwtMaxfile('vdo'));
		//  Valid file extensions (images, word, excel, powerpoint) 
		$rEFileTypes_VDO = "/^\.(" . ValidfileType('vdo') . "){1}$/i";
		//$dir_base = "../ewt/".$_SESSION["EWT_SUSER"]."/download/file_vdo/";

		$isFile = is_uploaded_file($_FILES['vdo_file']['tmp_name']);
		if ($isFile) {    //  do we have a file? 
			$safe_filename = preg_replace(
				array("/\s+/", "/[^-\.\w]+/"),
				array("_", ""),
				trim($_FILES['vdo_file']['name'])
			);

			$type_file =  strrchr($safe_filename, '.');
			$newfile = 'vdo_file_' . date("YmdHis") . $type_file;

			if ($_FILES['vdo_file']['size'] <= $MAXIMUM_FILESIZE_VDO && preg_match($rEFileTypes_VDO, strrchr($safe_filename, '.'))) {
				$isMove = move_uploaded_file($_FILES['vdo_file']['tmp_name'], $Current_Dir . $newfile);
			}
			$vdo_filename = $newfile;
		} else {
			$vdo_filename = "";
		}
	} else {
		$vdo_filename = $a_data['vdo_file_old'];
	}

	if (!empty($_FILES['vdo_imagefile']['tmp_name'])) {

		$MAXIMUM_FILESIZE_IMG = sizeMB2byte(EwtMaxfile('img'));
		//  Valid file extensions (images, word, excel, powerpoint) 
		$rEFileTypes_IMG = "/^\.(" . ValidfileType('img') . "){1}$/i";
		//$dir_base = "../ewt/".$_SESSION["EWT_SUSER"]."/file_vdo/";

		$isFile = is_uploaded_file($_FILES['vdo_imagefile']['tmp_name']);
		if ($isFile) {
			$safe_filename = preg_replace(
				array("/\s+/", "/[^-\.\w]+/"),
				array("_", ""),
				trim($_FILES['vdo_imagefile']['name'])
			);

			$type_file =  strrchr($safe_filename, '.');

			$newfile = 'vdo_img_' . date("YmdHis") . $type_file;

			if ($_FILES['vdo_imagefile']['size'] <= $MAXIMUM_FILESIZE_IMG && preg_match($rEFileTypes_IMG, strrchr($safe_filename, '.'))) {
				$isMove = move_uploaded_file($_FILES['vdo_imagefile']['tmp_name'], $Current_Dir . $newfile);
			}
			$vdo_image = $newfile;
		} else {
			$vdo_image = "";
		}
	} else {

		$vdo_image = $a_data['vdo_imagefile_old'];
	}




	$s_data['vdo_name']        =  $vdo_name;
	$s_data['vdo_detail']      =  $vdo_detail;
	$s_data['vdo_filesource']  =  $a_data['vdo_filesource'];
	$s_data['vdo_filename']    =  $vdo_filename;
	$s_data['vdo_group']       =  $a_data['vdo_group'];
	$s_data['vdo_creator']     =  $vdo_creator;
	$s_data['vdo_info']        =  $vdo_info;
	$s_data['vdo_image']       =  $vdo_image;
	$s_data['vdo_show_vdo']    =  $a_data['vdo_format'];
	$s_data['vdo_fileyoutube'] =  $a_data['vdo_youtube'];
	$s_data['vdo_update']      =  $date->format('Y-m-d H:i:s');

	//insert('vdo_list',$s_data);
	update('vdo_list', $s_data, array('vdo_id' => $a_data['vdo_id']));
	//insert('vdo_group',$s_data);
	$db->write_log("update", "vdo", "แก้ไข vdo" . $vdo_name);
	//$db->write_log("create","vdo","เพิ่มวีดีโอ ".$vdo_name);							   
	echo json_encode($a_data);

	unset($a_data);
	unset($s_data);

	exit;
}
