<?php
include("../lib/permission1.php");
include("../lib/include.php");
include("../lib/function.php");
include("../lib/user_config.php");
include("../lib/connect.php");
include("../ewt_block_function.php");
include("lang_config.php"); 


$s_id = $_POST['s_id'];

if($Flag=="1"){
	$topic = addslashes($topic);
	$d = explode("/",$date_start);
	$e = explode("/",$date_last);
	$dd = $d[2]."-".$d[1]."-".$d[0];
	$ee = $e[2]."-".$e[1]."-".$e[0];
$SQL = "INSERT INTO p_survey ( s_id,s_title,s_start,s_end,s_pos,s_approve,start_page,end_page,file_page, s_table, design,mail_data,s_uid,s_creater ) VALUES ('','$topic','$dd','$ee','','N','$error_page','$end_page','$file_page','','$design','$mail_data','".$_SESSION["EWT_SMID"]."','".$_SESSION["EWT_SMUSER"]."')";
$exec = $db->query($SQL);

//$ex = $db->query("SELECT s_id FROM p_survey ORDER BY s_id DESC");
//$R = mysqli_fetch_array($ex);

$_query = "SELECT MAX(s_id) AS s_id FROM p_survey";
$result = $db->query($_query);
$R = $db->db_fetch_array($result);	

$exec1 = $db->query("UPDATE p_survey SET s_pos = '$R[s_id]' WHERE s_id = '$R[s_id]'");
$test = $R[s_id];

$delete1 = $db->query("select * from p_cate where s_id = '$s_id'");
while($rrr = mysqli_fetch_array($delete1)){

$SQL = $db->query("INSERT INTO p_cate ( c_id,s_id,c_d,c_name,c_title,c_gp,option1,option2 ) VALUES ('','$R[s_id]','".addslashes($rrr[c_d])."','".addslashes($rrr[c_name])."','".addslashes($rrr[c_title])."','".addslashes($rrr[c_gp])."','".addslashes($rrr[option1])."','".addslashes($rrr[option2])."')");

$ex1 = $db->query("SELECT c_id FROM p_cate ORDER BY c_id DESC");
$RR = mysqli_fetch_array($ex1);

$delete2 = $db->query("select * from p_question where c_id = '$rrr[c_id]'");
while($rrrr = mysqli_fetch_array($delete2)){

$SQL = $db->query("INSERT INTO `p_question` ( `q_id` , `c_id` , `q_name` , `q_des` , `q_pos` , `q_anstype` , `q_ansnum` , `q_req` ) VALUES ('', '$RR[c_id]', '".addslashes($rrrr[q_name])."', '".addslashes($rrrr[q_des])."', '".addslashes($rrrr[q_pos])."', '".addslashes($rrrr[q_anstype])."', '".addslashes($rrrr[q_ansnum])."', '".addslashes($rrrr[q_req])."')");

$ex2 = $db->query("SELECT q_id FROM p_question ORDER BY q_id DESC");
$S = mysqli_fetch_array($ex2);

$delete3 = $db->query("select * from p_ans where q_id = '$rrrr[q_id]'");
while($xx = mysqli_fetch_array($delete3)){
$WWW = $db->query("INSERT INTO p_ans (a_id,q_id,a_name,a_other,option3,option4) VALUES ('','$S[q_id]','".addslashes($xx[a_name])."','".addslashes($xx[a_other])."','".addslashes($xx[option3])."','".addslashes($xx[option4])."')");

}

}
}
$db->write_log("create","servey","สร้างหัวข้อแบบสำรวจ หัวข้อ เรื่อง".$topic);
?>
<script language="javascript">
window.location.href = "main_survey.php";
	</script>
	<?php
}	
	?>
<?php @$db->db_close(); ?>