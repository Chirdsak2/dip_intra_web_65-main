<?php
include("../EWT_ADMIN/comtop.php");
if(!$db->check_permission("Egp","w","")){
	echo '<script>';
	echo 'alert("You can not access this section!!");';
	echo 'window.history.back();';
	echo '</script>	';
}
$db->write_log("view","Egp","เข้าสู่  Module จัดซื้อจัดจ้างภาครัฐ ");
echo '<script>';
echo 'window.location.href = "gprocurement.php";';
echo '</script>';
exit;
include("../EWT_ADMIN/combottom.php");
?>