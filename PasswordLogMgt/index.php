<?php
include("../EWT_ADMIN/comtop.php");
if(!$db->check_permission("visitstats","","")){
	echo '<script>';
	echo 'alert("You can not access this section!!");';
	echo 'window.history.back();';
	echo '</script>	';
}
//$db->write_log("view","faq","เข้าสู่   Module จัดการ faq");
echo '<script>';
echo 'window.location.href = "passwordlog_main.php";';
echo '</script>';
exit;
include("../EWT_ADMIN/combottom.php");
?>