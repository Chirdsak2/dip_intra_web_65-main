<?php
include("authority.php");
?>
<?php 
$d_name = addslashes($d_name);
if($flag == 'Add'){
	$ins = "insert into n_domain (d_name) values ('$d_name')";

	$r = $db->query($ins);
$db->write_log("create","enews","สร้าง domain E-news letter   ".$d_name);
		?>
<script language="javascript">
window.opener.location.href="domain_mod.php?msg=Y";
	window.close();
</script>
		<?php
}
if($flag == 'Edit'){

	$upd = "update n_domain set d_name = '$d_name' where d_id = '$did'";
	$r = $db->query($upd);
	$db->write_log("update","enews","แก้ไข domain E-news letter   ".$d_name);
	?>
<script language="javascript">
window.opener.location.href="domain_mod.php?msg=Y";
	window.close();
</script>
		<?php
}
if($flag == 'Delete'){
for($i=0;$i<$all;$i++){
	$did = 'did'.$i;
	$did = $$did;
if($did <> ''){
	$rec = $db->db_fetch_array($db->query("select * from n_domain where d_id = '$did'"));
	$db->write_log("delete","enews","ลบ domain E-news letter   ".$rec[d_name]);
	$del = "delete from n_domain where d_id = '$did'";
	$r = $db->query($del);
	
}
}
	?>
<script language="javascript">
window.location.href="domain_mod.php?msg=Y";
</script>
		<?php
}
?>
