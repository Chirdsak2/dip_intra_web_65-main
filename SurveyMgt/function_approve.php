<?php
include("../lib/permission1.php");
include("../lib/include.php");
include("../lib/function.php");
include("../lib/user_config.php");
include("../lib/connect.php");
include("../ewt_block_function.php");
include("lang_config.php");
$s_id = $_POST['id'];
$AllData = "";
$SQL = $db->query("SELECT DISTINCT(p_cate.c_id),p_cate.c_d,p_cate.c_name,p_cate.c_title,p_cate.c_gp,p_cate.option1,p_cate.option2 FROM p_cate,p_question WHERE p_cate.s_id = '$s_id' AND p_cate.c_id = p_question.c_id ORDER BY p_cate.c_d ASC");
 while($R=mysql_fetch_array($SQL)){  

	if($R[c_gp] =="Y" ){
	 $SSS = $db->query("SELECT * FROM p_question WHERE c_id = '$R[c_id]' ORDER BY q_pos ASC"); 
	while($X = mysql_fetch_array($SSS)){

$SQL2 = $db->query("SELECT DISTINCT(p_ans.a_name) FROM p_ans,p_question WHERE p_question.q_id = '$X[q_id]' AND p_question.q_id = p_ans.q_id ORDER BY p_ans.option3");	
		$a=0;
		 if($R[option1]=="A"){ 
		 $AllData .= $X[q_id].",";
		 }
		 while($Q = mysql_fetch_array($SQL2)){  if($R[option1]=="A"){
		 }else{ 
		  $SQL3 = $db->query("SELECT a_id FROM p_ans WHERE q_id='$X[q_id]' AND a_name = '$Q[a_name]'");
		  $AA = mysql_fetch_row($SQL3);

		  $AllData .= $X[q_id]."_".$AA[0].",";
		  } 
$a++;
 }  } 
	}else{
 $SSS = $db->query("SELECT * FROM p_question WHERE c_id = '$R[c_id]' ORDER BY q_pos ASC"); 
	while($X = mysql_fetch_array($SSS)){

			if($X[q_anstype]=="D"){ 
			$AllData .= $X[q_id].",";
		}else{
			$SSS1 = $db->query("SELECT * FROM p_ans WHERE q_id = '$X[q_id]' ORDER BY option3 ASC"); 
			if($X[q_anstype]=="A"){
			$AllData .= $X[q_id].",";
			$p=0;
	while($Z = mysql_fetch_array($SSS1)){
 if($Z[a_other]=="Y"){  }  $p++; }
		}elseif($X[q_anstype]=="B"){
		$p = 0;
while($Z = mysql_fetch_array($SSS1)){
//$SQL4 = $db->query("SELECT a_id FROM p_ans WHERE q_id='$X[q_id]' AND a_name = '$Z[a_name]'");
//		  $AA = mysql_fetch_row($SQL4);
$AllData .= $X[q_id]."_".$Z[a_id].",";
 if($Z[a_other]=="Y"){  }  $p++;  }		
		}elseif($X[q_anstype]=="C"){ 
		$AllData .= $X[q_id].",";	
		}elseif($X[q_anstype]=="E"){ 
		$AllData .= $X[q_id].",";	
		}elseif($X[q_anstype]=="F"){ 
		$AllData .= $X[q_id].",";	
		}elseif($X[q_anstype]=="G"){ 
		$AllData .= $X[q_id]."_1,";	//จังหวัด
		$AllData .= $X[q_id]."_2,";	//อำเภอ
		$AllData .= $X[q_id]."_3,";	//ตำบล
		}
		
		}  }  }  } 
$AllData = substr($AllData,0,-1);
$arr = explode(",",$AllData);
// echo $AllData; 

 $sell = $db->query("SELECT * FROM p_survey WHERE s_table like 's%' ORDER BY s_table DESC");
 if($xxx = mysql_num_rows($sell)){
 $R= mysql_fetch_array($sell);
 $idtable = $R[s_table];
 $idtable++;
 }else{
 $idtable = "s000001";
 }
 $k=0;
 $sql0 = "CREATE TABLE ".$idtable." (
  survey_id int(6) NOT NULL auto_increment, 
  person_answer int(6) NOT NULL default '0', 
  time_stamp datetime NOT NULL default '0000-00-00 00:00:00',";
 while($arr[$k]){
  $sql0 .= " B".$arr[$k]."  varchar(255) default NULL, ";
$k++;
}
  $sql0 .= " PRIMARY KEY (survey_id)
) ENGINE=MyISAM"; // mysql 5.5
// ) TYPE=MyISAM"; // mysql 4
$db->query("DROP TABLE IF EXISTS ".$idtable);
$pp = $db->query($sql0);
if($pp){
 $sell1 = $db->query("UPDATE p_survey SET s_approve='Y', s_table = '$idtable' WHERE s_id = '$s_id'");
 $db->write_log("approve","servey","อนุมัติแบบสำรวจ");
 ?>
 <script language="javascript">
alert("<?php echo $langsurvey_surveyfinishgen; ?>");
window.location.href="main_survey.php";
	</script>
 <?php
}else{
echo "can not gen table ".$idtable;
}
 ?>
<?php @$db->db_close(); ?>