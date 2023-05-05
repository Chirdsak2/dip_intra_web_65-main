<?php
session_start();

include("../lib/permission1.php");
include("../lib/include.php");
include("../lib/function.php");
include("../lib/user_config.php");
include("../lib/connect.php");

if(!$db->check_permission("suser","","")){
				?>
				<script >
				alert("You can not access this section!!");
				window.history.back();
				</script>
				<?php
}
//$db->write_log("view","survey","เข้าสู่   Module จัดการ Form Generator");
?>
<script>
window.location.href = "stat_index.php";
</script>
<?php
exit;
?>
