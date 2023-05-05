<?php
include("../EWT_ADMIN/comtop_pop.php");

$date = new DateTime();

$a_data = array_merge($_POST, $_FILES);
	

if($a_data['proc']=='edit_calendar_visit'){
	
	$reg_id      = ready($a_data['reg_id']);
	$reg_approve = ready($a_data['reg_approve']);
	$reg_date    = ready($a_data['reg_date']);
	$reg_time    = ready($a_data['reg_time']);

	if($reg_approve!="Y"){
		$reg_approve = "N";
	}

	$visit_data = $db->query("SELECT * FROM cal_register_visit WHERE reg_id = '$reg_id'");
	$visit_info = $db->db_fetch_array($visit_data);	

	$db->query("UPDATE cal_register_visit SET reg_approve = '$reg_approve',
											  reg_date    = '$reg_date',
											  reg_time    = '$reg_time'
										  WHERE reg_id    = '$reg_id'");

	$db->write_log("create","calendar","แก้ไขการขอเข้าเยี่ยมชมของ ".$visit_info['reg_from']);				


	echo json_encode($s_data);		
	//print_r($s_data);
	unset($a_data);
	unset($s_data);	
	//echo $a_data['lang_detail'][9];
	exit;   
}
if($a_data['proc']=='del_calendar_visit'){
	
	$reg_id      = ready($a_data['reg_id']);
	
	$visit_data = $db->query("SELECT * FROM cal_register_visit WHERE reg_id = '$reg_id'");
	$visit_info = $db->db_fetch_array($visit_data);	

	##===============##
	$db->query("DELETE FROM cal_register_visit WHERE reg_id    = '$reg_id'");

	$db->write_log("create","calendar","ลบการขอเข้าเยี่ยมชมของ ".$visit_info['reg_from']);				


	echo json_encode($s_data);		
	//print_r($s_data);
	unset($a_data);
	unset($s_data);	
	//echo $a_data['lang_detail'][9];
	exit;   
} 
?>