<?php
include("../EWT_ADMIN/comtop.php");
if(!$db->check_permission("ebook","w","")){
	echo '<script>';
	echo 'alert("You can not access this section!!");';
	echo 'window.history.back();';
	echo '</script>	';
}
$db->write_log("view","ebook","เข้าสู่  Module e-Book");
echo '<script>';
echo 'window.location.href = "ebook_cate.php";';
echo '</script>';
exit;
include("../EWT_ADMIN/combottom.php");
?>