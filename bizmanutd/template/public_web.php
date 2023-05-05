<?php
session_start();
header ("Content-Type:text/plain;charset=UTF-8");
include("lib/function.php");
include("lib/user_config.php");
include("lib/connect.php");
include("../../ewt_block_function.php");
include("../../ewt_menu_preview.php");
include("../../ewt_article_preview.php");
include("../../ewt_public_function.php");

if($filename != ""){
$filename_approve = $filename;
$sql_approve = "select * from setting_approve where filename = '".$filename_approve."'  
									and ((set_approve_date = '".date('Y-m-d')."' and set_approve_time <= '".date('H:i:s')."') or (set_approve_date < '".date('Y-m-d')."')) and active = 'Y'";
	$query_approve = $db->query($sql_approve);
	if($db->db_num_rows($query_approve)>0){
		?>
<iframe  src="ewt_reload.php"  frameborder="0"  width="1" height="1" scrolling="no" ></iframe>
		<?php
		genpublic($filename_approve,"../",$EWT_FOLDER_USER);
		$sql_update = "DELETE FROM setting_approve WHERE filename = '".$filename_approve."'";
		$db->query($sql_update);

	}else{
		echo date("H:i:s");
		}
	}
$db->db_close(); ?>
