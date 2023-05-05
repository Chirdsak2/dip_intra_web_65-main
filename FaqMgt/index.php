<?php
include("../EWT_ADMIN/comtop.php");
if(!$db->check_permission("faq","","")){
	echo '<script>';
	echo 'alert("You can not access this section!!");';
	echo 'window.history.back();';
	echo '</script>	';
}
$db->write_log("view","faq","เข้าใช้งาน-module-faq");
echo '<script>';
echo 'window.location.href = "faq_dashboard.php";';
echo '</script>';
exit;
include("../EWT_ADMIN/combottom.php");
?>