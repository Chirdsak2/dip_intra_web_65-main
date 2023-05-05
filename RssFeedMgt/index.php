<?php
include("../EWT_ADMIN/comtop.php");
if(!$db->check_permission("rss","w","")){
	echo '<script>';
	echo 'alert("You can not access this section!!");';
	echo 'window.history.back();';
	echo '</script>	';
	exit;
}
$db->write_log("view","rss","เข้าสู่  Module บริหาร Rss Feed");
echo '<script>';
echo 'window.location.href = "rss_main.php";';
echo '</script>';
exit;
include("../EWT_ADMIN/combottom.php");
?>