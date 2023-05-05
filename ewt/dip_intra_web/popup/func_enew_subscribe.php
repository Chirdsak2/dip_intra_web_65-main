<?php
include("assets/config.inc.php");
include("../lib/function.php");
include("../lib/user_config.php");
include("../lib/connect.php");

$all = stripslashes(htmlspecialchars($_POST["all"],ENT_QUOTES));
$email = stripslashes(htmlspecialchars($_POST["email"],ENT_QUOTES));

//Update list รายการที่เลือก
if($_POST["mid"] != ""){
	
	$delete_list = "DELETE FROM n_group_member WHERE m_id = '".$_POST['mid']."'";
	$db->query($delete_list);
	for($i=0;$i<$all;$i++){
		if($_POST["chk".$i] == 'Y'){
			$insert_list = "INSERT INTO n_group_member (m_id,g_id) VALUES ('".$_POST['mid']."','".stripslashes(htmlspecialchars($_POST["c_id".$i],ENT_QUOTES))."')";
			$db->query($insert_list);
			$db->write_log("update","enews","อัพเดทการสมัครรับข้อมูลข่าวสารของ ".$email);
			//exit;
		}
	}
	
}else if($email != ''){
	$insert = "INSERT INTO n_member ( m_email,m_active,m_date) VALUES ('".$email."','Y','".date('Y-m-d H:i:s')."')";
	$db->query($insert);

	$sql_member = $db->query("select max(m_id) as m_id from n_member");
	$member = $db->db_fetch_array($sql_member);
	for($i=0;$i<$all;$i++){
		$query_m = $db->query("select m_id,g_id from n_group_member where m_id = '".$member["m_id"]."' and g_id='".stripslashes(htmlspecialchars($_POST["c_id".$i],ENT_QUOTES))."'");
		$rec = $db->db_fetch_array($query_m);
		$num = $db->db_num_rows($query_m);
		if(stripslashes(htmlspecialchars($_POST["chk".$i],ENT_QUOTES)) == 'Y'){

			if($num == 0){//ยังไม่มีรายการ
				$insert = "INSERT INTO n_group_member ( m_id,g_id ) VALUES ('".$member["m_id"]."','".stripslashes(htmlspecialchars($_POST["c_id".$i],ENT_QUOTES))."')";
				$db->query($insert);
				$db->write_log("insert","enews","เพิ่มหมวดการสมัครรับข้อมูลข่าวสารของ ".$email);
				
			}
			
		}else{
			
			if($num > 0){
				$del = "delete from n_group_member where g_name = '".stripslashes(htmlspecialchars($_POST["c_id".$i],ENT_QUOTES))."'";
				$db->query($del);
				$db->write_log("delete","enews","ลบหมวดการสมัครรับข้อมูลข่าวสารของ ".$email);
			}
			
		}
	}
}
$db->db_close(); 	
?>
