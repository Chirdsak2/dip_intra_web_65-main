<?php
include("../EWT_ADMIN/comtop.php");
if(!$db->check_permission("poll","w","")){
	echo '<script>';
	echo 'alert("You can not access this section!!");';
	echo 'window.history.back();';
	echo '</script>	';
}
$db->write_log("view","poll","เข้าใช้งาน-Module-Poll");
echo '<script>';
echo 'window.location.href = "poll_list.php";';
echo '</script>';
exit;
include("../EWT_ADMIN/combottom.php");
?>