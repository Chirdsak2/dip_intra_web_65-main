<?php
include("../lib/permission1.php");
include("../lib/include.php");
include("../lib/function.php");
include("../lib/user_config.php");
include("../lib/connect.php");

$_s_count = "SELECT so_session_id FROM stat_online group by so_session_id ";
$_q_count = $db->query($_s_count);
$_rec = $db->db_fetch_row($_q_count);
$_row = $db->db_num_rows($_q_count);
?>
<span  style="font-size:20px;" >
<?php echo number_format($_row,0)?>
</span>