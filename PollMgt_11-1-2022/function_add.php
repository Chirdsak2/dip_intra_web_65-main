<?php
include("admin.php");

if($c_use == "Y"){
$udp1 = $db->query("UPDATE `poll_cat` SET `c_use` = '' ");
}
//$topic = addslashes($topic);
//$add1 = $db->query("INSERT INTO `poll_cat` ( `c_id` , `c_name` , `c_use` ) VALUES ('', '$topic', '$c_use')");
//$sql = $db->query("SELECT * FROM poll_cat ORDER BY c_id DESC");
//$R = mysql_fetch_array($sql);
/*
for($i=0;$i<$num;$i++){
$ans_name = "ans_name".$i;
$ans_name = $$ans_name;
$ans_name = addslashes($ans_name);
$sql_ans = $db->query("INSERT INTO `poll_ans` ( `a_id` , `c_id` , `a_name` , `a_counter` ) VALUES ('', '$c_id', '$ans_name', '')");
}*/
//$db->write_log("create","poll","สร้างแบบสำรวจความคิดเห็น(poll)   ".$topic);
?>
<script language = "javascript">
//window.opener.location.reload();
//window.close();
</script>
