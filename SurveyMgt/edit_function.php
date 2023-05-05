<?php
include("../lib/include.php");
include("../lib/function.php");
include("../lib/user_config.php");
include("../lib/connect.php");
include("../lib/set_lang.php");
include("../language.php");
include("../language/language_TH.php");
include("../lib/config_path.php");

include("lang_config.php"); 

if($Flag == "2"){
	$d = explode("/",$std);
	$e = explode("/",$ed);
	$dd = $d[2]."-".$d[1]."-".$d[0];
	$ee = $e[2]."-".$e[1]."-".$e[0];
	//$sql = $db->query("UPDATE `p_survey` SET `s_start` = '$dd',`s_end` = '$ee' ,`start_page` = '$error_page',`end_page` = '$end_page' ,`file_page` = '$file_page' ,design='$selectDesign',mail_data='$mail_data',s_lastupdate='".date('YmdHis')."'  WHERE `s_id` = '$s_id' ");
	$sql = $db->query("UPDATE `p_survey` SET  s_lastupdate='".date('YmdHis')."'  WHERE `s_id` = '$s_id' ");
		?>
		<script >
		window.location.href="edit_survey.php?s_id=<?php echo $s_id; ?>";
		</script>
		<?php
}elseif($Flag == "3"){
	
	$date_start = $_POST['date_start'];
	$date_last = $_POST['date_last'];
	
	$d = explode("/",$date_start);
	$e = explode("/",$date_last);
	$dd = $d[2]."-".$d[1]."-".$d[0];
	$ee = $e[2]."-".$e[1]."-".$e[0];
	
		//$sql = $db->query("UPDATE `p_survey` SET `s_start` = '$dd',`s_end` = '$ee' ,`start_page` = '$error_page',`end_page` = '$end_page',`file_page` = '$file_page' ,design='$selectDesign',mail_data='$mail_data',s_lastupdate='".date('YmdHis')."' WHERE `s_id` = '$s_id' "); 
		$sql = $db->query("UPDATE `p_survey` SET s_lastupdate='".date('YmdHis')."' WHERE `s_id` = '$s_id' "); 
		for($i=0;$i<$aal;$i++){
			$Submit = "Submit".$i;
			$Submit = $$Submit;
			$ppp = "ppp".$i;
			$ppp = $$ppp;
			$dell = "dell".$i;
			$dell = $$dell;

			if($dell != ""){
				$sql0 = $db->query("SELECT q_id FROM p_question WHERE c_id = '$dell'");
				while($R = $db->db_num_rows($sql0)){
						//	echo "delete ".$R[0]."<br>";
						$sql = $db->query("DELETE FROM p_ans WHERE q_id = '$R[0]' ");
						$sql1 = $db->query("DELETE FROM p_question WHERE q_id = '$R[0]' ");
				}
				$sql2 = $db->query("DELETE FROM p_cate WHERE c_id = '$dell' ");
			}else{
				for($y=0;$y<$ppp;$y++){
					$pos = "pos".$i.$y;
					$pos = $$pos;
					$qid = "qid".$i.$y;
					$qid = $$qid;
					$del = "del".$i.$y;
					$del = $$del;

					if($del !=""){
						$sql = $db->query("DELETE FROM p_ans WHERE q_id = '$del' ");
						$sql1 = $db->query("DELETE FROM p_question WHERE q_id = '$del' ");
						$db->write_log("delete","servey","ลบ ข้อมูลแบบสำรวจ");
					}else{
						$sql = $db->query("UPDATE `p_question` SET `q_pos` = '$pos' WHERE `q_id` = '$qid' ");
						$db->write_log("update","servey","แก้ไขข้อมูลแบบสำรวจ");
					}
			}
		}
}

if($SubmitY=="Finish"){
?>
<script language="javascript">
window.location.href="main_survey.php";
	</script>
	<?php
}else{
	?>
<script language="javascript">
window.location.href="edit_survey.php?s_id=<?=url_encode($s_id); ?>";
	</script>
	<?php
	}
	}
?>

<?php @$db->db_close(); ?>