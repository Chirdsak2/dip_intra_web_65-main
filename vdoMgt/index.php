<?php
session_start();

include("../lib/permission1.php");
include("../lib/include.php");
include("../lib/function.php");
include("../lib/user_config.php");
include("../lib/connect.php");

if(!$db->check_permission("vdo","w","")){
				?>
				<script >
				alert("You can not access this section!!");
				window.history.back();
				</script>
				<?php
}
$db->write_log("view","vdo","เข้าสู่ Module การจัดการวิดีโอ");

?>
	<script>
			window.location.href = "vdo_group.php";
			</script>
			<?php
			exit;
			?>
