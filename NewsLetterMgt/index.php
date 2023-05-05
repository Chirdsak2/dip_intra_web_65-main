<?php
session_start();

include("../lib/permission1.php");
include("../lib/include.php");
include("../lib/function.php");
include("../lib/user_config.php");
include("../lib/connect.php");

if(!$db->check_permission("enews","w","")){
				?>
				<script >
				alert("You can not access this section!!");
				window.history.back();
				</script>
				<?php
}
$db->write_log("view","enews","เข้าสู่ Module การจัดการจดหมายข่าว ");

?>
	<script>
			window.location.href = "member_mod.php";
			</script>
			<?php
			exit;
			?>
