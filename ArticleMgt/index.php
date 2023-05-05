<?php
include("../EWT_ADMIN/comtop.php");
if(!$db->check_permission("art","w","")){
	echo '<script>';
	echo 'alert("You can not access this section!!");';
	echo 'window.history.back();';
	echo '</script>	';
}
$db->write_log("view","article","เข้าใช้งาน-module-article");
echo '<script>';
echo 'window.location.href = "article_group.php";';
echo '</script>';
exit;
include("../EWT_ADMIN/combottom.php");
?>