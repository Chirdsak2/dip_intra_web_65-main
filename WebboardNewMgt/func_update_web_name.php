<?php
include("../EWT_ADMIN/comtop_pop.php");

$date = new DateTime();
$a_data = array_merge($_POST, $_FILES);

if ($a_data['proc'] == 'Edit_Web_Name') {
    $s_data = array();
    $s_data['t_web_name'] = $a_data['t_web_name']; 

    $result = update('w_question', $s_data, array('t_id' => $a_data['t_id']));
    sys::save_log('update','webboard', $a_data['t_web_name'] == 1 ? 'แสดงชื่อนามสมมุติ' : 'ไม่แสดงชื่อนามสมมุติ');  
    //echo json_encode($s_data);		
    //print_r($a_data);
    unset($a_data);
    unset($s_data);
    exit;
}
