<?php
include("../EWT_ADMIN/comtop_pop.php"); 
if(!$db->check_permission("ecard","w",""))
{
	echo '<script>';
	echo 'alert("You can not access this section!!");';
	echo 'window.history.back();';
	echo '</script>	';
}
	$db->write_log("view","ecard","เข้าระบบบริหาร e-Card");
	echo '<script>';
	echo 'window.location.href = "ecard_dashboard.php";';  
	echo '</script>';
	exit;
include("../EWT_ADMIN/combottom.php");
?>