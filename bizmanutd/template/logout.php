<?php
	session_start();
	include("lib/function.php");
	include("lib/user_config.php");
	include("lib/connect.php");
	//include("lib/log_visitor.php");
	//write_log_visitor("logout","","logout ออกจากระบบ");
	session_destroy();
?>
<script language="javascript">window.location.href = 'main.php?filename=index'</script>
