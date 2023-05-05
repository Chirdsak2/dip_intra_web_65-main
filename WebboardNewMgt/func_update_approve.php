<?php
include("../EWT_ADMIN/comtop_pop.php");

$date = new DateTime();
$a_data = array_merge($_POST, $_FILES);

if ($a_data['proc'] == 'Edit_approve') {
    $s_data = array();
    $s_data['s_id'] = $a_data['s_id']; 

    $result = update('w_answer', $s_data, array('a_id' => $a_data['a_id']));
    sys::save_log('update','webboard', $a_data['s_id'] == 1 ? 'อนุมัติความคิดเห็น' : 'ยกเลิกอนุมัติความคิดเห็น');  
    //echo json_encode($s_data);		
    //print_r($a_data);
    unset($a_data);
    unset($s_data);
    exit;
}
