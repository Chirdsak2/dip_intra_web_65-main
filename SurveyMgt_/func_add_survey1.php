<?php
include("../lib/permission1.php");
include("../lib/include.php");
include("../lib/function.php");
include("../lib/user_config.php");
include("../lib/connect.php");
include("../lib/set_lang.php");


if($_POST['proc'] == "1"){
	$topic = addslashes($_POST['topic']);
	$date_start =  $_POST['date_start'];
	$date_last =  $_POST['date_last'];
	$error_page =  $_POST['error_page'];
	$end_page =  $_POST['end_page'];
	$file_page =  $_POST['file_page'];
	$mail_data =  $_POST['mail_data'];
	
	$d = explode("/",$date_start);
	$e = explode("/",$date_last);
	$std = $d[2].$d[1].$d[0];
	$end = $e[2].$e[1].$e[0];
	$dd = $d[2]."-".$d[1]."-".$d[0];
	$ee = $e[2]."-".$e[1]."-".$e[0];
	
 if(getenv("HTTP_X_FORWARDED_FOR")) {
		$IPn = getenv("HTTP_X_FORWARDED_FOR");
	}else{
		$IPn = getenv("REMOTE_ADDR");
	}
	
$SQL = "INSERT INTO p_survey ( s_id,
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
							   s_ip ) 
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
							   '".date('YmdHis')."',
							   '{$_SESSION['EWT_SMID']}',
							   '{$_SESSION['EWT_SMUSER']}',
							   '{$IPn}')";
$exec = $db->query($SQL);

if($exec){
$part = $part1;
$choice = $choice1;
session_register("part");
$startd = $date_start;
$endd = $date_last;
session_register("startd");
session_register("endd");

$ex = $db->query("SELECT s_id FROM p_survey ORDER BY s_id DESC");
$R =  $db->db_fetch_array($ex);

$exec1 = $db->query("UPDATE p_survey SET s_pos = '{$R[s_id]}' WHERE s_id = '{$R[s_id]}'");
$test = $R['s_id'];

session_register("test");

$db->write_log("create","servey","สร้างหัวข้อแบบสำรวจ หัวข้อ เรื่อง".$topic);

echo $test;

}

}
?>
