<?php
include("../EWT_ADMIN/comtop.php");
if(!$db->check_permission("complain","w","")){
	echo '<script>';
	echo 'alert("You can not access this section!!");';
	echo 'window.history.back();';
	echo '</script>	';
}
$db->write_log("view","complain","เข้าใช้งาน-Module-Complain");
echo '<script>';
echo 'window.location.href = "complain_main.php";';
echo '</script>';
exit;
include("../EWT_ADMIN/combottom.php");
?>