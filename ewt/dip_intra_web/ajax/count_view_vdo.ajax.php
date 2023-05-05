<?php
DEFINE('path', '../assets/');
include path . '/config/config.inc.php';

$vdo_id = conText($_REQUEST["id"]);

if ($_REQUEST['proc'] == 'CountVdo') {

    $_query = "UPDATE ".E_DB_NAME.".vdo_list SET vdo_count = vdo_count+1 WHERE vdo_id = '{$vdo_id}'";
    db::execute($_query);

    echo json_encode($s_data);
    unset($a_data);
    unset($s_data);
    exit;
}
