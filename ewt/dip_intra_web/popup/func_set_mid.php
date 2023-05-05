<?php
session_start();;
 
$_SESSION['SYS_MP_ID'] = $_GET['mp_id'];
$_SESSION['SYS_M_ID'] = $_GET['m_id'];
$_SESSION['SYS_ACTIVE'] = $_GET['mactive'];

?>