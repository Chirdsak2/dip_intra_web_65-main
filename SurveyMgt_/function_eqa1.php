<?php
include("../lib/permission1.php");
include("../lib/include.php");
include("../lib/function.php");
include("../lib/user_config.php");
include("../lib/connect.php");
include("../ewt_block_function.php");
include("lang_config.php"); 

if($Flag=="Q"){
$ch = addslashes($ch);
$name = addslashes($name);
$SQL = $db->query("update p_question set q_name = '$ch',q_des = '$name',q_pos = '$pos' ,q_req = '$just' where q_id = '$qid'");

?>
<script language="javascript">
window.opener.location.reload();
window.close();
	</script>
	<?php
		   }elseif($Flag=="P"){
	$sqltb = $db->query("SELECT * FROM p_survey WHERE s_id = '$s_id'");	
	$RS = mysql_fetch_array($sqltb);

$SQL2 = $db->query("SELECT q_id FROM p_question WHERE p_question.c_id = '$path' ORDER BY q_pos ASC");
while($R=mysql_fetch_row($SQL2)){
for($i=0;$i<$all;$i++){
$an = "an".$i;
$an = $$an;
$pos = "pos".$i;
$pos = $$pos;
$oan = "oan".$i;
$oan = $$oan;
$weight = "weight".$i;
$weight = $$weight;

$X1 = $db->query("UPDATE p_ans SET a_name = '$an',a_weight = '$weight' WHERE q_id='$R[0]' AND option3 = '$pos'");
if($typeofpath=="A"){
$tbn = "B".$R[0];
}elseif($typeofpath=="B"){
$sqltb1 = $db->query("SELECT a_id FROM p_ans WHERE q_id='$R[0]' AND option3 = '$pos'");	
	$RS1 = mysql_fetch_array($sqltb1);
$tbn = "B".$R[0]."_".$RS1[a_id];
}
$WWW2 = $db->query("UPDATE $RS[s_table] SET $tbn = '$an' WHERE $tbn = '$oan'");	
}
}

?>
<script language="javascript">
window.close();
	</script>
<?php

		   }elseif($Flag == "A"){

			   if($sel == "D"){

if($de == "S"){
$WWW = $db->query("UPDATE p_ans SET a_name = '$def',a_other = '$de',option3 = '$wor',option4 = '$wid2' WHERE a_id = '$ANSID'");		   
}elseif($de == "M"){
$WWW = $db->query("UPDATE p_ans SET a_name = '$def',a_other = '$de',option3 = '$line',option4 = '$wid1' WHERE a_id = '$ANSID'");		   
}
	   ?>
<script language="javascript">
window.close();
	</script>
<?php
			   }elseif($sel == "E"){

$WWW = $db->query("UPDATE p_ans SET a_name = '$stype',a_other = '$sdef'  WHERE a_id = '$ANSID'");	
	   ?>
<script language="javascript">
window.close();
	</script>
<?php
			   }else{
	$sqltb = $db->query("SELECT * FROM p_survey WHERE s_id = '$s_id'");	
	$RS = mysql_fetch_array($sqltb);
			$Current_Dir = "../ewt/".$_SESSION["EWT_SUSER"]."/images/form_pic";
		if (!(file_exists($Current_Dir))) {
		mkdir ($Current_Dir, 0777);
		@chmod ($Current_Dir, 0777);
		}	
for($i=0;$i<$all;$i++){
$an = "an".$i;
$an = $$an;
$ch = "ch".$i;
$ch = $$ch;
$oan = "oan".$i;
$oan = $$oan;
$pic = "pic".$i;
$pic = $$pic;
$weight = "weight".$i;
$weight = $$weight;
	if($_FILES["file".$i]["size"] > 0){
		copy($_FILES["file".$i]["tmp_name"],$Current_Dir."/".$_FILES["file".$i]["name"]);
		@chmod ($Current_Dir."/".$_FILES["file".$i]["name"], 0777);
		$an = $an."#@form#img@#"."images/form_pic/".$_FILES["file".$i]["name"];
	}else{
		$an = $an."#@form#img@#".$pic;
	}
$WWW = $db->query("UPDATE p_ans SET a_name = '$an',a_weight = '$weight' WHERE a_id = '$ch'");		
	if($sel=="B"){
	$tbn = "B".$qid."_".$ch;
	}else{
	$tbn = "B".$qid;
	}
$WWW2 = $db->query("UPDATE $RS[s_table] SET $tbn = '$an' WHERE $tbn = '$oan'");	
}
?>
<script language="javascript">
window.close();
	</script>
<?php
			   }   }
?>
<?php @$db->db_close(); ?>