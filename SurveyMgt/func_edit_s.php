<?php
include("../lib/include.php");
include("../lib/function.php");
include("../lib/user_config.php");
include("../lib/connect.php");
include("../lib/set_lang.php");

$date = new DateTime();

$a_data = array_merge($_POST, $_FILES);
$s_data = array();


$Path_true = "../ewt/".$_SESSION["EWT_SUSER"]."/file_attach";
	if (!file_exists( $Path_true)) {
					mkdir ($Path_true, 0777);
	}


if($a_data['proc'] == "P"){

	$a_file_array = array();
	for($i=0;$i <= $a_data['temp_num1'];$i++){  
		if($a_data['file_page'.$i]){
		$a_file_array[] = $a_data['file_page'.$i];
		}
	}	
	$data_file	=	implode(";", $a_file_array);
	$a_filename_array = array();
	for($ii=0;$ii <= $a_data['temp_num1'];$ii++){  
		if($a_data['file_name'.$ii]){
		$a_filename_array[] = $a_data['file_name'.$ii];
		}
	}	
	$data_file_name	=	implode(";", $a_filename_array);

	$fw1 = @fopen($Path_true."/form_topic_".$a_data['s_id'].".html", "w");
	//if(!$fw1){ die("Cannot write form_topic_".$a_data['s_id'].".html"); }
	$FlagW1 = fwrite($fw1,stripslashes($a_data['name']));
	@fclose($fw1);

	$fw2 = @fopen($Path_true."/form_det_".$a_data['s_id'].".html", "w");
	//if(!$fw2){ die("Cannot write form_det_".$a_data['s_id'].".html"); }
	$FlagW2 = fwrite($fw2,stripslashes($a_data['s_detail']));
	@fclose($fw2);

	$date_start = $_POST['date_start'];
	$date_last = $_POST['date_last'];
	
	$d = explode("/",$date_start);
	$e = explode("/",$date_last);
	$dd = $d[2]."-".$d[1]."-".$d[0];
	$ee = $e[2]."-".$e[1]."-".$e[0];

$s_data['s_title']		= 	$a_data['name'];
$s_data['s_pos']   		= 	$a_data['des'];
$s_data['s_start']   	= 	$dd;
$s_data['s_end']   		= 	$ee;
$s_data['end_page']   	= 	$a_data['end_page'];
$s_data['file_page'] 	=  	$data_file;
$s_data['s_detail']   	= 	$a_data['s_detail'];
$s_data['s_file_name']  = 	$data_file_name;

update('p_survey',$s_data,array('s_id'=>$a_data['s_id']));


$db->write_log("update","servey","แก้ไขหัวข้อแบบสำรวจ หัวข้อ เรื่อง".$a_data['name']);
print_r($a_data);	

unset($a_data);
unset($s_data);

exit;
	} 
?>