<?php
include("../EWT_ADMIN/comtop_pop.php");
$dest = "../ewt/" . $_SESSION["EWT_SUSER"] . "/";
DEFINE('mailer', $dest . 'phpmailer/');
include($dest . "phpmailer/phpmailer.class.php");

$a_data = array_merge($_POST, $_FILES);
$proc = $a_data['proc'];
  
switch ($proc) {
	case "Add_calendar":
		if (is_array($a_data)) {
			$s_data = array();
			$MAXIMUM_FILESIZE = sizeMB2byte(EwtMaxfile('file'));
			$rEFileTypes = "/^\.(" . ValidfileType('file') . "){1}$/i";
			$dir_base = "../ewt/" . $_SESSION['EWT_SUSER'] . "/download/";
			$dir_base1 = "download/";

			$isFile = is_uploaded_file($_FILES['event_link']['tmp_name']);
			if ($isFile) {
				$safe_filename = preg_replace(
					array("/\s+/", "/[^-\.\w]+/"),
					array("_", ""),
					trim($_FILES['event_link']['name'])
				);

				$type_file =  strrchr($safe_filename, '.');
				$newfile   = "calendar_attach_" . date("YmdHis") . $type_file;
				if ($_FILES['event_link']['size'] <= $MAXIMUM_FILESIZE && preg_match($rEFileTypes, strrchr($safe_filename, '.'))) {
					$isMove = move_uploaded_file($_FILES['event_link']['tmp_name'], $dir_base . $newfile);
				}
				$a_attach = $dir_base1 . $newfile;
				//if(file_exists($dir_base.$a_data['lang_attach_old'][$n]) && $a_data['lang_attach_old'][$n] != ''){			
				//unlink($dir_base.$dir_file_old);			
				//}	
			} else {
				$a_attach = '';
			}

			if ($a_data['event_date_start'] and $a_data['event_date_end']) {
				$s = explode("/", $a_data['event_date_start']);
				$e = explode("/", $a_data['event_date_end']);

				$event_date_start  = $s[2] . '-' . $s[1] . '-' . $s[0];
				$event_date_end    = $e[2] . '-' . $e[1] . '-' . $e[0];
				//$event_date_start  = $a_data['event_date_start'];
				//$event_date_end    = $a_data['event_date_end'];
			}

			if ($a_data['start_date'] and $a_data['end_date']) {
				$start = explode("/", $a_data['start_date']);
				$end   = explode("/", $a_data['end_date']);

				$event_show_start  = $start[2] . '-' . $start[1] . '-' . $start[0];
				$event_show_end    = $end[2] . '-' . $end[1] . '-' . $end[0];
				//$event_show_start  = $a_data['start_date'];
				//$event_show_end    = $a_data['end_date']; 
			}

			$s_data['event_title']   	    =  $a_data['calendar_title'];
			$s_data['cat_id']	        	=  $a_data['calendar_category'];
			// $s_data['event_count'] 	 		=  0;
			$s_data['event_detail']      	=  $a_data['calendar_detail'];
			// $s_data['event_all_day']      	=  0;
			$s_data['event_date_start']     =  !empty($event_date_start) ? $event_date_start : "0000-00-00";
			$s_data['event_time_start']     =  !empty($a_data['event_time_start']) ? $a_data['event_time_start'] : "00:00:00";
			$s_data['event_date_end']      	=  !empty($event_date_end) ? $event_date_end : "0000-00-00";
			$s_data['event_time_end']      	=  !empty($a_data['event_time_end']) ? $a_data['event_time_end'] : "00:00:00";
			$s_data['event_user_id']      	=  $_SESSION['EWT_SMID'];
			// $s_data['event_repeat']      =  '';
			// $s_data['event_repeat_time']	=  0; 
			$s_data['event_show_start']     =  !empty($event_show_start) ? $event_show_start : "0000-00-00";
			$s_data['event_show_end']      	=  !empty($event_show_end) ? $event_show_end : "0000-00-00";
			// $s_data['main_event_id_repeat'] =  0; 
			// $s_data['event_private']     =  0; 
			$s_data['event_link']      		=  $a_attach;
			$s_data['event_registor']      	=  $a_data['calendar_setregis'];
			$s_data['event_registor_num']   =  !empty($a_data['calendar_num']) ? $a_data['calendar_num'] : 0;
			$s_data['event_webname']      	=  $_SESSION['EWT_SUSER'];
			$s_data['event_location']      	=  $a_data['calendar_location'];
			$s_data['event_link_registor']  =  $a_data['calendar_link_to'];
			$s_data['event_relatelink']     =  $a_data['event_relatelink'];
			insert('cal_event', $s_data);

			$sql_event_id = "SELECT MAX(event_id) AS max_event_id FROM cal_event";
			$sql_event_id = $db->query($sql_event_id);
			$event_id_max = $db->db_fetch_array($sql_event_id);

			$sql_repeat = "INSERT INTO cal_show_event (event_id,event_date_start,event_date_end,event_show_start,event_show_end,main_event_id_repeat) VALUES ('" . $event_id_max[max_event_id] . "','{$event_date_start}','{$event_date_end}','{$event_show_start}','{$event_show_end}',0)";
			$db->query($sql_repeat);

			if ($a_data['gen_user_id']) {
				$sql_insert_invite = "INSERT INTO cal_invite (event_id,person_id,phone,department) VALUES ('" . $event_id_max['max_event_id'] . "','" . $a_data['gen_user_id'] . "','" . $a_data['phone'] . "','" . $a_data['department'] . "')";
				$db->query($sql_insert_invite);
			}
			//$c_num = count($a_data['calendar_invite']);   
			//for($n = 0;$n <= $c_num; $n++) 
			//{
			foreach ((array)$a_data['calendar_invite'] as $_item) {
				$s_title = 'ปฏิทินกิจกรรม ' . $a_data['calendar_title'];
				sys::save_Noti('Y', $s_title, 'calendar', $_item, '');

				$org_email_person = org::getUserEmail($_item);
				$sentto   = $org_email_person;
				$db->query("USE " . $EWT_DB_NAME);
				if (!empty($sentto)) {
					$s_message 	= '<div>' . $a_data['calendar_title'] . '</div>';
					$s_message .= '<div>' . $a_data['calendar_detail'] . '</div>';
					$s_message .= '<div>วันที่เริ่มต้นกิจกรรม : ' . $event_date_start . '</div>';
					$s_message .= '<div>วันที่สิ้นสุดกิจกรรม : ' . $event_date_end . '</div>';
					$s_subject 	= 'ปฏิทินกิจกรรม';
					$s_fromname = 'กรมประชาสัมพันธ์';
					$s_sendfrom	= E_EMAIL;
					$s_sendto 	= $sentto;
					$mailsent = sendmail::sendmailSMTP($s_sendto, $s_sendfrom, $s_fromname, $s_subject, $s_message);
					if ($mailsent) {
						$status = 'Y';
					} else {
						$status = 'N';
					}
					sys::save_LogSendMail($event_id_max, 'calendar', 'create-calendar', $s_sendto, $s_message, $s_fromname, $s_subject, $status, $_item);
				}
			}

			$db->write_log("create", "calendar", "เพิ่มปฏิทินกิจกรรม " . $a_data['calendar_title']);

			//$s_data['sql'] = $insert;
			echo json_encode($s_data);
			unset($a_data);
			unset($s_data);
			exit;
		} else {
			//$a_error['sql'] = $insert;
			$a_error['message'] = 'กรุณาใส่ให้ถูกต้อง';
			echo json_encode($a_error);
			unset($a_data);
			unset($s_data);
			exit;
		}
		exit;
		break;
}
