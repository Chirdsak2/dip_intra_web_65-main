<?php
include("../EWT_ADMIN/comtop.php");
if(!$db->check_permission("Gallery","w","")){
	echo '<script>';
	echo 'alert("You can not access this section!!");';
	echo 'window.history.back();';
	echo '</script>	';
}
//$db->write_log("view","permis","เข้าใช้งาน-Module-Permission");
echo '<script>';
echo 'window.location.href = "gallery_main.php";';
echo '</script>';
exit;
include("../EWT_ADMIN/combottom.php");
?>