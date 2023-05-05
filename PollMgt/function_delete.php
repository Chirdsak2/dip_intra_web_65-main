<?php
include("admin.php");
$rec = $db->db_fetch_array($db->query("select * from poll_cat WHERE c_id = '$c_id'"));
$db->write_log("delete","poll","ลบแบบสำรวจความคิดเห็น(poll)   ".$rec[c_name]);
$udp1 = $db->query("DELETE FROM `poll_cat` WHERE c_id = '$c_id'");
$udp2 = $db->query("DELETE FROM `poll_ans` WHERE c_id = '$c_id'");
?>
<script language = "javascript">
window.location.href = "main.php";
</script>
