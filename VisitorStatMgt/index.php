<?php
include("../EWT_ADMIN/comtop.php");
if(!$db->check_permission("visitstats","","")){
	echo '<script>';
	echo 'alert("You can not access this section!!");';
	echo 'window.history.back();';
	echo '</script>	';
}
//$db->write_log("view","survey","เข้าสู่   Module จัดการ Form Generator");
?>
<script>
window.location.href = "stat_index.php";
</script>
<?php
exit;
?>
