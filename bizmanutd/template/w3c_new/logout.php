<?php
$path = "../";
	session_start();
	include($path."lib/function.php");
	include($path."lib/user_config.php");
	include($path."lib/connect.php");
	//include("lib/log_visitor.php");
	//write_log_visitor("logout","","logout ออกจากระบบ");
	session_destroy();
?>
<script language="javascript">window.location.href = 'main.php?filename=index'</script>
