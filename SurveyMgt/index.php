<?php
include("../EWT_ADMIN/comtop.php");
if(!$db->check_permission("survey","w","")){
	echo '<script>';
	echo 'alert("You can not access this section!!");';
	echo 'window.history.back();';
	echo '</script>	';
}
$db->write_log("view","survey","เข้าใช้งาน-module-Form-Generator");
echo '<script>';
echo 'window.location.href = "main_survey.php";';
echo '</script>';
exit;
include("../EWT_ADMIN/combottom.php");
?>			
