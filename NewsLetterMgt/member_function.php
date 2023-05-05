<?php
include("authority.php");
?>
<?php 


for($i=0;$i<$_POST["all"];$i++){
	$mid = 'mid'.$i;
	$mid = $_POST[$mid];
	$act = 'act'.$i;
	$act = $_POST[$act];
	$m_id = 'm_id'.$i;
	$m_id = $_POST[$m_id];
	$rec = $db->db_fetch_array($db->query("select * from n_member where m_id = '$mid'"));
	if($mid <> ''){
		$del = "delete from n_member where m_id = '$mid'";
		$r = $db->query($del);
		$del1 = "delete from n_group_member where m_id = '$mid'";
		$r1 = $db->query($del1);
		$db->write_log("delete","enews","ลบข้อมูลสมาชิก E-news letter  : ".$rec[m_email]);
	}else{
	$rec = $db->db_fetch_array($db->query("select * from n_member where m_id = '$m_id'"));
	$r2 = $db->query("UPDATE n_member SET m_active = '$act' WHERE m_id = '$m_id'");
		if($_POST["act"] == 'Y'){
		$db->write_log("approve","enews","อนุมัติให้สมาชิกใช้งาน E-news letter  : ".$rec[m_email]);
		}
	}
}
?>
<script language="javascript">
window.location.href="member_mod.php?msg=Y";
</script>
