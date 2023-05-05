<?php
session_start();
include("../lib/permission1.php");
include("../lib/include.php");
include("../lib/function.php");
include("../lib/user_config.php");
include("../lib/connect.php");

$_s_count = "SELECT so_session_id FROM stat_online WHERE so_user_id = '0'  GROUP BY so_session_id ";
$_q_count = $db->query($_s_count);
$_rec = $db->db_fetch_row($_q_count);
$_row = $db->db_num_rows($_q_count);
?>

<input type="hidden" id="so_session" value="<?=number_format($_row,0);?>" />
