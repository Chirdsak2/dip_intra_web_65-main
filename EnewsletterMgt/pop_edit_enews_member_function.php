<?php
include("../lib/include.php");
include("../lib/function.php");
include("../lib/user_config.php");
include("../lib/connect.php");
include("../lib/set_lang.php");
include("../language.php");
include("../language/language_TH.php");
include("../lib/config_path.php");
$m_id = $_POST["m_id"];

for($i=0;$i<$_POST["all"];$i++){
	$rec = $db->db_fetch_array($db->query("select * from n_group_member where m_id = '$m_id' AND g_id = '".$_POST["g_id".$i]."'"));
	
	if($_POST["chk".$i] == 'Y'){

		if($rec["m_id"] == ''){//ยังไม่มีรายการ
			$insert = "INSERT INTO n_group_member ( m_id , g_id ) VALUES ('".$m_id."', '".$_POST["g_id".$i]."')";
			$db->query($insert);
			$db->write_log("insert","enews","เพิ่มการรับข้อมูลข่าวสาร E-news letter  : ".$rec["m_email"]);
			
		}
		
	}else{
		if($rec["m_id"] != ''){
			$del = "delete from n_group_member where m_id = '$m_id' AND g_id = '".$_POST["g_id".$i]."'";
			$db->query($del);
			$db->write_log("delete","enews","ลบการรับข้อมูลข่าวสาร E-news letter  : ".$rec["m_email"]);
			
		}
		
	}
}
//echo 'Y';
//echo json_encode($s_data);
$db->db_close(); 	
?>
