<?php
session_start();

include("../lib/permission1.php");
include("../lib/include.php");
include("../lib/function.php");
include("../lib/user_config.php");
include("../lib/connect.php");

if(!$db->check_permission("member","w","")){
				?>
				<script >
				alert("You can not access this section!!");
				window.history.back();
				</script>
				<?php
}
$db->write_log("view","member","เข้าสู่ Module การจัดการสมาชิก ");

?>
	<script>
			window.location.href = "MemberList.php";
			</script>
			<?php
			exit;
			?>
