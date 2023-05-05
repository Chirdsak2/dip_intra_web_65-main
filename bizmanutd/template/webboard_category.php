<?php
	session_start();
	include("lib/function.php");
	include("lib/user_config.php");
	include("lib/connect.php");
	include("ewt_script.php");
	if($_GET[type]==''){// list
	}else if($_GET[type]=='1'){//row 3 category
	}else if($_GET[type]=='2'){//box show 5 webboard
	}
?>
<?php $db->db_close(); ?>
