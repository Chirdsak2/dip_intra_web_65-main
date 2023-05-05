<?php
include("administrator.php");
include("inc.php");
include("lib/include.php");
if($_POST["flag"] == 'add'){
if($_POST[hdd_uid] == ' '){
$_POST[hdd_uid] = $_POST[name];
}
$sql_ch = $db->query("select * from professor where prof_name = '".$_POST[hdd_uid]."'");
if($db->db_num_rows($sql_ch)>0){
	?>
	<script language="JavaScript">
	alert('ผู้เชี่ยวชาญท่านนี้มีแล้วในระบบ กรุณาตรวจสอบ!');
	window.location.href = "professor_list.php";
	</script>
	<?php
	exit;
}
$db->query("insert into professor (prof_name) values('".$_POST[hdd_uid]."')");
$max_id = $db->db_fetch_array($db->query("select max(prof_id) as id from professor"));
$exp_keyword = explode(' ',$keyword);
	for($i=0;$i<count($exp_keyword);$i++){
		$db->query("insert into professor_keyword (prof_id,key_word) values ('$max_id[id]','$exp_keyword[$i]')");
	}
$db->write_log("create","webboard","สร้างรายชื่อผู้เชี่ยวชาญ   ".$_POST["name"]);
	?>
<script language="JavaScript">
window.location.href = "professor_list.php";
</script>
	<?php
}
if($flag == 'del'){
$db->query("delete from professor where prof_id = '$id'");
$db->query("delete from professor_keyword where prof_id = '$id'");
$db->write_log("delete","webboard","ลบรายชื่อผู้เชี่ยวชาญ   ".$_GET["name"]);
?>
<script language="JavaScript">
window.location.href = "professor_list.php";
</script>
	<?php
}
if($flag == 'edit'){
$sql_ch = $db->query("select * from professor where prof_name = '".$hdd_uid."' and prof_id <> '$id'");
if($db->db_num_rows($sql_ch)>0){
	?>
	<script language="JavaScript">
	alert('ผู้เชี่ยวชาญท่านนี้มีแล้วในระบบ กรุณาตรวจสอบ!');
	window.location.href = "professor_list.php";
	</script>
	<?php
	exit;
}
$db->query("update professor set prof_name='$hdd_uid' where prof_id ='$id'");
$exp_keyword = explode(' ',$keyword);
	$db->query("delete from professor_keyword where prof_id = '$id'");
	for($i=0;$i<count($exp_keyword);$i++){
		if($exp_keyword[$i] != ''){
		$db->query("insert into professor_keyword (prof_id,key_word) values ('$id','$exp_keyword[$i]')");
		}
	}
$db->write_log("update","webboard","แก้ไขรายชื่อผู้เชี่ยวชาญ   ".$_POST["name"]);
	?>
<script language="JavaScript">
window.location.href = "professor_list.php";
</script>
	<?php
}

?>
<?php @$db->db_close(); ?>