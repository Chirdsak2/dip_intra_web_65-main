<?php
include("../EWT_ADMIN/comtop_pop.php");
if(!$db->check_permission("webboard","w","")){
	echo '<script>';
	echo 'alert("You can not access this section!!");';
	echo 'window.history.back();';
	echo '</script>	';
}
//$db->write_log("view","webboard","เข้าใช้งาน โมดูล Webboard");
echo '<script>';
echo 'window.location.href = "webboard_main.php";';
echo '</script>';
exit;
include("../EWT_ADMIN/combottom.php");
?>