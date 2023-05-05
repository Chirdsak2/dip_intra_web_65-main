<?php
include("../EWT_ADMIN/comtop_pop.php");

$date = new DateTime();
$a_data = array_merge($_POST, $_FILES);

if ($a_data['proc'] == 'Edit_Top') {
    $s_data = array();
    $s_data['t_top'] = $a_data['t_top']; 

    $result = update('w_question', $s_data, array('t_id' => $a_data['t_id']));
    sys::save_log('update','webboard', $a_data['t_top'] == 1 ? 'ปักหมุดกระทู้' : 'ยกเลิกปักหมุดกระทู้');  
    //echo json_encode($s_data);		
    //print_r($a_data);
    unset($a_data);
    unset($s_data);
    exit;
}
