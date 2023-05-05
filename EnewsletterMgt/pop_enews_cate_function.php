<?php
include("../lib/include.php");
include("../lib/function.php");
include("../lib/user_config.php");
include("../lib/connect.php");
include("../lib/set_lang.php");
include("../language.php");
include("../language/language_TH.php");
include("../lib/config_path.php");

$all = stripslashes(htmlspecialchars($_POST["all"],ENT_QUOTES));

for($i=0;$i<$all;$i++){
	$rec = $db->db_fetch_array($db->query("select g_id from n_group where g_name='".stripslashes(htmlspecialchars($_POST["c_id".$i],ENT_QUOTES))."'"));
	
	if(stripslashes(htmlspecialchars($_POST["chk".$i],ENT_QUOTES)) == 'Y'){

		if($rec["g_id"] == ''){//ยังไม่มีรายการ
			$insert = "INSERT INTO n_group ( g_name ) VALUES ('".stripslashes(htmlspecialchars($_POST["c_id".$i],ENT_QUOTES))."')";
			$db->query($insert);
			$db->write_log("insert","enews","เพิ่มหมวดข่าว E-news letter");
			
		}
		
	}else{
		
		if($rec["g_id"] != ''){
			$del = "delete from n_group where g_name = '".stripslashes(htmlspecialchars($_POST["c_id".$i],ENT_QUOTES))."'";
			$db->query($del);
			//$db->write_log("delete","enews","ลบการรับข้อมูลข่าวสาร E-news letter  : ".$rec["m_email"]);
			$db->write_log("delete","enews","ลบหมวดข่าว E-news letter");
		}
		
	}
}
//echo 'Y';
//echo json_encode($s_data);
$db->db_close(); 	
?>
