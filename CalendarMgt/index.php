<?php
include("../EWT_ADMIN/comtop.php");
if(!$db->check_permission("calendar","w","")){
	echo '<script>';
	echo 'alert("You can not access this section!!");';
	echo 'window.history.back();';
	echo '</script>	';
}
$db->write_log("view","calendar","เข้าใช้งาน-Module-Calendar");
echo '<script>';
echo 'window.location.href = "calendar_list.php";';
echo '</script>';
exit;
include("../EWT_ADMIN/combottom.php");
?>
