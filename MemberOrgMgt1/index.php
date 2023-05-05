<?php
include("../EWT_ADMIN/comtop.php");
	if(!$db->check_permission("org","w","")){
		echo '<script>';
		echo 'alert("You can not access this section!!");';
		echo 'window.history.back();';
		echo '</script>	';
	}
$db->write_log("view","org","เข้าใช้งาน-Module-Organization");

echo '<script>';
echo 'window.location.href = "org_dashboard.php";';
echo '</script>';
exit;
include("../EWT_ADMIN/combottom.php");
?>