<?php
include("../EWT_ADMIN/comtop_pop.php");
$a_data = array_merge($_POST, $_FILES);
$proc = $a_data['proc'];
switch ($proc) {
	case "Edit_Km_Point":
		if (is_array($a_data)) {
			$s_data = array();

			$MAXIMUM_FILESIZE = sizeMB2byte(EwtMaxfile('img'));
			$rEFileTypes = "/^\.(" . ValidfileType('img') . "){1}$/i";
			$dir_base = "../ewt/" . $_SESSION['EWT_SUSER'] . "/assets/img/icon/";
			$dir_base1 = "../ewt/" . $_SESSION['EWT_SUSER'] . "/assets/img/icon/";

			$isFile = is_uploaded_file($_FILES['km_image']['tmp_name']);
			if ($isFile) {    
				$safe_filename = preg_replace(
					array("/\s+/", "/[^-\.\w]+/"),
					array("_", ""),
					trim($_FILES['km_image']['name'])
				);

				$type_file =  strrchr($safe_filename, '.');
				$newfile   = "km_image_" . date("YmdHis") . $type_file;
				if ($_FILES['km_image']['size'] <= $MAXIMUM_FILESIZE && preg_match($rEFileTypes, strrchr($safe_filename, '.'))) {
					@chmod($dir_base1, 0777);
					$isMove = move_uploaded_file($_FILES['km_image']['tmp_name'], $dir_base . $newfile);
					if ($isMove) {
						$a_images = $newfile;
						if (file_exists($dir_base . $a_data['km_image_old']) && $a_data['km_image_old'] != '') {
							unlink($dir_base . $a_data['km_image_old']);
						}
						$a_size = $_FILES['km_image']['size'];
					}
				}
			} else {
				$a_images = $a_data['km_image_old'];
			}

			$s_data['km_name']		=  $a_data['km_name'];
			$s_data['km_point']		=  $a_data['km_point'];
			$s_data['km_image']		=  $a_images;
			$s_data['km_category']  =  $a_data['km_category'];
			$s_data['km_status']	=  empty($a_data['km_status']) ? "N" : "Y";
			$s_data['update_date']	=  date('Y-m-d H:i:s');

			$result = update('km_point', $s_data, array('id' => $a_data['id']));
			sys::save_log('updaste', 'km_point', 'แก้ไข KM ' . $s_data['km_name']);

			echo json_encode($a_data);
			unset($a_data);
			unset($s_data);
			exit;
		exit;
		break;
		}
}
