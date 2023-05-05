<?php
session_start();

include("../lib/permission1.php");
include("../lib/include.php");
include("../lib/function.php");
include("../lib/user_config.php");
include("../lib/connect.php");

if(!$db->check_permission("graph","w","")){
				?>
				<script >
				alert("You can not access this section!!");
				window.history.back();
				</script>
				<?php
}
$db->write_log("view","graph","เข้าสู่ Module การจัดการกราฟ");

?>
	<script>
			window.location.href = "graph_list.php";
			</script>
			<?php
			exit;
			?>
