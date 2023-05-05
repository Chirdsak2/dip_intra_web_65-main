<?php
include("../EWT_ADMIN/comtop.php");
if(!$db->check_permission("permission","w","")){
	echo '<script>';
	echo 'alert("You can not access this section!!");';
	echo 'window.history.back();';
	echo '</script>	';
}
//$db->write_log("view","permission","เข้าใช้งาน module Permission");
echo '<script>';
echo 'window.location.href = "site_main.php";';
echo '</script>';
exit;
include("../EWT_ADMIN/combottom.php");
?>