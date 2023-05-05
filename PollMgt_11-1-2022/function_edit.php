<?php
include("admin.php");

$topic = addslashes($topic);
$udp1 = $db->query("UPDATE `poll_cat` SET `c_name` = '$topic' WHERE `c_id` = '$cad_id' ");
for($i=0;$i<$all;$i++){
$ans_id = "ans_id".$i;
$ans_id = $$ans_id;
$ans_name = "ans_name".$i;
$ans_name = $$ans_name;
$ans_name = addslashes($ans_name);
$udp = $db->query("UPDATE `poll_ans` SET `a_name` = '$ans_name' WHERE `a_id` = '$ans_id' ");
}
$db->write_log("updaet","poll","แก้ไขแบบสำรวจความคิดเห็น(poll)   ".$topic);
?>
<script language = "javascript">
window.opener.location.reload();
window.close();
</script>
