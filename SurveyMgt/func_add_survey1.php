<?php
include("../lib/include.php");
include("../lib/function.php");
include("../lib/user_config.php");
include("../lib/connect.php");
include("../lib/set_lang.php");
include("../language.php");
include("../language/language_TH.php");
include("../lib/config_path.php");

$a_data = array_merge($_POST, $_FILES);
$Path_true = "../ewt/" . $_SESSION["EWT_SUSER"] . "/file_attach";

if (!file_exists($Path_true)) {
	mkdir($Path_true, 0777);
}

if ($a_data['proc'] == "1") {
	$a_file_array = array();
	for ($i = 1; $i <= $a_data['temp_num1']; $i++) {
		$a_file_array[] = $a_data['file_page' . $i];
	}
	$data_file 	= implode(";", $a_file_array);
	$a_filename_array = array();
	for ($ii = 1; $ii <= $a_data['temp_num1']; $ii++) {
		if ($a_data['file_name' . $ii]) {
			$a_filename_array[] = $a_data['file_name' . $ii];
		}
	}
	$data_file_name	=	implode(";", $a_filename_array);

	$topic 			=	addslashes($_POST['topic']);
	$date_start		=  	$_POST['date_start'];
	$date_last 		=  	$_POST['date_last'];
	$error_page 	=  	$_POST['error_page'];
	$end_page 		=  	$_POST['end_page'];
	$file_page 		=  	$data_file;
	$mail_data 		=  	$_POST['mail_data'];
	$s_detail		=  	$_POST['s_detail'];
	$s_file_name	=  	$data_file_name;

	$d 		=	explode("/", $date_start);
	$e 		= 	explode("/", $date_last);
	$std 	= 	$d[2] . $d[1] . $d[0];
	$end 	= 	$e[2] . $e[1] . $e[0];
	$dd 	= 	($d[2] - 543) . "-" . $d[1] . "-" . $d[0];
	$ee 	= 	($e[2] - 543) . "-" . $e[1] . "-" . $e[0];

	if (getenv("HTTP_X_FORWARDED_FOR")) {
		$IPn = getenv("HTTP_X_FORWARDED_FOR");
	} else {
		$IPn = getenv("REMOTE_ADDR");
	}

	$SQL = "INSERT INTO p_survey (s_id,
							   s_title,
							   s_start,
							   s_end,
							   s_pos,
							   s_approve,
							   start_page,
							   end_page,
							   file_page, 
							   s_table, 
							   design,
							   mail_data , 
							   s_timestamp,
							   s_uid,
							   s_creater,
							   s_ip,
							   s_detail,
							   s_file_name) 
							   VALUES (
							   '',
							   '{$topic}',
							   '{$dd}',
							   '{$ee}',
							   '',
							   'N',
							   '{$error_page}',
							   '{$end_page}',
							   '{$file_page}',
							   '',
							   'survey_default',
							   '{$mail_data}',
							   '" . date('YmdHis') . "',
							   '{$_SESSION['EWT_SMID']}',
							   '{$_SESSION['EWT_SMUSER']}',
							   '{$IPn}',
							   '{$s_detail}',
							   '{$s_file_name}')";
	$exec = $db->query($SQL);

	if ($exec) {

		$ex = $db->query("SELECT s_id FROM p_survey ORDER BY s_id DESC");
		$R =  $db->db_fetch_array($ex);

		$exec1 = $db->query("UPDATE p_survey SET s_pos = '{$R['s_id']}' WHERE s_id = '{$R['s_id']}'");
		$test = $R['s_id'];

		$fw1 = @fopen($Path_true . "/form_topic_" . $R['s_id'] . ".html", "w");
		//if(!$fw1){ die("Cannot write form_topic_".$R['s_id'].".html"); }
		$FlagW1 = fwrite($fw1, stripslashes($topic));
		@fclose($fw1);

		$fw2 = @fopen($Path_true . "/form_det_" . $R['s_id'] . ".html", "w");
		//if(!$fw2){ die("Cannot write form_det_".$R['s_id'].".html"); }
		$FlagW2 = fwrite($fw2, stripslashes($s_detail));
		@fclose($fw2);

		//session_register("test");

		$db->write_log("create", "servey", "สร้างหัวข้อแบบสำรวจ หัวข้อ เรื่อง" . $topic);

		echo url_encode($test);
	}

	//print_r($a_data);
	exit;
}
