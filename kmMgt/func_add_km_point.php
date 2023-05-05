<?php
include("../EWT_ADMIN/comtop_pop.php");
$a_data = array_merge($_POST, $_FILES);
$proc = $a_data['proc'];

switch ($proc) {
	case "Add_Km_Point":
		if (is_array($a_data)) {
			$s_data = array();
			$MAXIMUM_FILESIZE = sizeMB2byte(EwtMaxfile('img'));
			$rEFileTypes = "/^\.(" . ValidfileType('img') . "){1}$/i";
			$dir_base = "../ewt/" . $_SESSION['EWT_SUSER'] . "/assets/img/icon/";
			$dir_base1 = "";

			$isFile = is_uploaded_file($_FILES['km_image']['km_image']);
			if ($isFile) {    //  do we have a file? 
				$safe_filename = preg_replace(
					array("/\s+/", "/[^-\.\w]+/"),
					array("_", ""),
					trim($_FILES['km_image']['name'])
				);

				$type_file =  strrchr($safe_filename, '.');
				$newfile   = "km_image_" . date("YmdHis") . $type_file;
				if ($_FILES['km_image']['size'] <= $MAXIMUM_FILESIZE && preg_match($rEFileTypes, strrchr($safe_filename, '.'))) {
					$isMove = move_uploaded_file($_FILES['km_image']['tmp_name'], $dir_base . $newfile);
				}
				$a_images = $dir_base1 . $newfile;
			} else {
				$a_images = '';
			}

			$s_data['km_name']		=  $a_data['km_name'];
			$s_data['km_point']		=  $a_data['km_point'];
			$s_data['km_image']		=  $a_images;
			$s_data['create_date'] 	=  date('Y-m-d H:i:s');

			$result = insert('km_point', $s_data);
			sys::save_log('create', 'km_point', 'เพิ่ม KM  ' . $s_data['km_name']);

			echo json_encode($s_data);
			unset($a_data);
			unset($s_data);
			exit;
		} else {
			$a_error['message'] = 'กรุณาใส่ให้ถูกต้อง';
			echo json_encode($a_error);
			unset($a_data);
			unset($s_data);
			exit;
		}
		exit;
		break;
}
