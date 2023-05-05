<?php 
include("../lib/include.php");
include("../lib/function.php");
include("../lib/user_config.php");
include("../lib/connect.php");
include("../lib/set_lang.php");
include("../language.php");
include("../language/language_TH.php");
include("../lib/config_path.php");

	$m_id = $_GET['m_id'];
	$rec = $db->db_fetch_array($db->query("select * from n_member where m_id = '$m_id'"));
	if($m_id != ''){
		$del = "delete from n_member where m_id = '$m_id'";
		$r = $db->query($del);
		$del1 = "delete from n_group_member where m_id = '$m_id'";
		$r1 = $db->query($del1);
		$db->write_log("delete","enews","ลบข้อมูลสมาชิก E-news letter  : ".$rec["m_email"]);
	}
	
$db->db_close();
?>
