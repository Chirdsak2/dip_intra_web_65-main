<?php
include("../EWT_ADMIN/comtop.php");
if(!$db->check_permission("suser","","")){
				?>
				<script >
				alert("You can not access this section!!");
				window.history.back();
				</script>
				<?php
}
//$db->write_log("view","survey","เข้าสู่   Module จัดการ Form Generator");
echo '<script>';
//echo 'window.location.href = "template_dashboard.php";';
echo 'window.location.href = "template_index.php";';
echo '</script>';
exit;
include("../EWT_ADMIN/combottom.php");
?>

