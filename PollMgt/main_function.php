<?php
include("admin.php");
?>
<?php
//include("../../lib/include.php");
//$db = new DB;
if($Flag == "Set"){
$SQL = $db->query("UPDATE `poll_cat` SET c_use = '' ");
$SQL = $db->query("UPDATE `poll_cat` SET c_use = 'Y' WHERE c_id = '$voteuse'");
?>
<script language="javascript">
	window.location.href = "main.php";
</script>
<?php
}
if($_POST[flag] == "resetpoll"){
$SQL = $db->query("UPDATE `poll_ans` SET a_counter = '0' WHERE c_id = '".$_POST[c_id]."'");
$delete = $db->query("delete from poll_log  WHERE c_id = '".$_POST[c_id]."' ");
?>
<script language="javascript">
	alert("ทำการล้างข้อมูลความคิดเห็นเรียบร้อยแล้ว!!");
	window.location.href = "main.php";
</script>
<?php
}

?>

