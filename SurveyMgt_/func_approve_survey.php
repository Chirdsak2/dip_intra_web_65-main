<?php
include("../lib/permission1.php");
include("../lib/include.php");
include("../lib/function.php");
include("../lib/user_config.php");
include("../lib/connect.php");
include("../lib/set_lang.php");


if($_POST['proc'] == 'ApproveSurvey' ){
	
$id = $_POST['id'];

$AllData = "";

$s_survey = $db->query("SELECT DISTINCT(p_cate.c_id),p_cate.c_d,p_cate.c_name,p_cate.c_title,p_cate.c_gp,p_cate.option1,p_cate.option2 
FROM p_cate,p_question 
WHERE p_cate.s_id = '{$id}' AND p_cate.c_id = p_question.c_id 
ORDER BY p_cate.c_d ASC ");
while($a_survey = $db->db_fetch_array($s_survey)){  

	if($a_survey['c_gp'] =="Y" ){
		$s_question = $db->query("SELECT * FROM p_question WHERE c_id = '{$a_survey['c_id']}' ORDER BY q_pos ASC"); 
		while($a_question = $db->db_fetch_array($s_question)){ 
		
			$s_ans = $db->query("SELECT DISTINCT(p_ans.a_name) 
			FROM p_ans,p_question 
			WHERE p_question.q_id = '{$a_question['q_id']}' AND p_question.q_id = p_ans.q_id 
			ORDER BY p_ans.option3 ");				
			$a = 0;
			if($a_survey['option1'] == "A"){
				
				$AllData .= $a_question['q_id'].",";
				
				}
				while($a_ans = $db->db_fetch_array($s_ans)){   
				
				if($a_survey['option1'] == "A"){
					
					}else{ 					
					$p_ans = $db->query("SELECT a_id FROM p_ans WHERE q_id = '{$a_question['q_id']}' AND a_name = '{$a_ans['a_name']}' ");
					$r_ans = $db->db_fetch_row($p_ans);
					$AllData .= $a_question['q_id']."_".$r_ans[0].",";
						} 					
						$a++;
					}  
				} 
			}else{
				
			$s_question = $db->query("SELECT * FROM p_question WHERE c_id = '{$a_survey['c_id']}' ORDER BY q_pos ASC"); 
			while($a_question =  $db->db_fetch_array(s_question)){

				if($a_question['q_anstype'] == "D"){ 
				$AllData .= $a_question['q_id'].",";
				}else{
					$s_ans = $db->query("SELECT * FROM p_ans WHERE q_id = '{$a_question['q_id']}' ORDER BY option3 ASC"); 
					if($a_question['q_anstype'] == "A"){
					$AllData .= $a_question['q_id'].",";
					$p=0;
					while($a_ans = $db->db_fetch_array($s_ans)){   
					if($a_ans['a_other'] == "Y"){  
				
					}  
					$p++; 
					}
				}elseif($a_question['q_anstype'] == "B"){
					$p = 0;
					while($a_ans = $db->db_fetch_array($s_ans)){   
//$SQL4 = $db->query("SELECT a_id FROM p_ans WHERE q_id='$X[q_id]' AND a_name = '$Z[a_name]'");
//$AA = mysql_fetch_row($SQL4);
					$AllData .= $a_question['q_id']."_".$a_ans['a_id'].",";
					if($a_ans['a_other']=="Y"){  
					}  
					$p++;  
					}		
				}elseif($a_question['q_anstype']=="C"){ 
					$AllData .= $a_question['q_id'].",";	
				}elseif($a_question['q_anstype']=="E"){ 
					$AllData .= $a_question['q_id'].",";	
				}elseif($a_question['q_anstype']=="F"){ 
					$AllData .= $a_question['q_id'].",";	
				}elseif($a_question['q_anstype']=="G"){ 
					$AllData .= $a_question['q_id']."_1,";	//จังหวัด
					$AllData .= $a_question['q_id']."_2,";	//อำเภอ
					$AllData .= $a_question['q_id']."_3,";	//ตำบล
				}
		
			}  
		}  
	}  
} 

$AllData = substr($AllData,0,-1);
$arr = explode(",",$AllData);
//echo $AllData; 

$s_survey1 = $db->query("SELECT * FROM p_survey WHERE s_table LIKE 's%' ORDER BY s_table DESC");
$a_row = $db->db_num_rows($s_survey1);
if($a_row){
	$a_survey1 = $db->db_fetch_array($s_survey1);
	$idtable = $a_survey1['s_table'];
	$idtable++;
	}else{
		$idtable = "s000001";
	}
$k=0;
$sql0 = "CREATE TABLE ".$idtable." (
survey_id int(6) NOT NULL AUTO_INCREMENT, 
person_answer int(6) NOT NULL DEFAULT '0', 
time_stamp datetime NOT NULL DEFAULT '0000-00-00 00:00:00',";
while($arr[$k]){
$sql0 .= " B".$arr[$k]."  varchar(255) DEFAULT NULL, ";
		$k++;
}
$sql0 .= " PRIMARY KEY (survey_id) 
) ENGINE=MyISAM AUTO_INCREMENT=0 CHARSET=utf8"; 
$db->query("DROP TABLE IF EXISTS ".$idtable);
		$s_create = $db->query($sql0);
		if($s_create){
			$s_update = $db->query("UPDATE p_survey SET s_approve = 'Y', s_table = '{$idtable}' WHERE s_id = '{$id}' ");
			$db->write_log("approve","servey","อนุมัติแบบสำรวจ");

		}else{			
echo "can not gen table ".$idtable;
}
}
$db->db_close();
?>