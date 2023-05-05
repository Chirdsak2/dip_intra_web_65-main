<?php
include("../lib/permission1.php");
include("../lib/include.php");
include("../lib/function.php");
include("../lib/user_config.php");
include("../lib/connect.php");
include("../ewt_block_function.php");
include("lang_config.php"); 

if($email_data == 'Y'){
	$just .= '#zz#Y';
}else if($email_data == 'N'){
	$just .= '#zz#N';
}else{
$just .= '#zz#';
}
if($no_replate == 'QNR'){
$just .= '#zz#QNR';
}else{
$just .= '#zz#';
}
if($Flag=="Q"){

$SQL = $db->query("INSERT INTO `p_question` ( `q_id` , `c_id` , `q_name` , `q_des` , `q_pos` , `q_anstype` , `q_ansnum` , `q_req` ) VALUES (
'', '$path', '$ch', '$name', '$pos', '$sel', '$num', '$just')");
$db->write_log("create","servey","สร้างคำถาม ".$ch.".".$name);
$ex = $db->query("SELECT q_id FROM p_question ORDER BY q_id DESC");
$R = mysqli_fetch_array($ex);
if($sel == "D"){

?>
<script language="javascript">
//window.opener.location.reload();
//window.close();
window.location.href = "add_ans1.php?q_id=<?php echo $R[q_id]; ?>";
	</script>
	<?php
}else if($sel == "F"){
?>
<script language="javascript">
window.opener.location.reload();
window.close();
	</script>
	<?php
}else if($sel == "G"){
?>
<script language="javascript">
window.opener.location.reload();
window.close();
	</script>
	<?php
}elseif($sel == "E"){

?>
<script language="javascript">
//window.opener.location.reload();
//window.close();
window.location.href = "add_ans2.php?q_id=<?php echo $R[q_id]; ?>";
	</script>
	<?php
}else{

	?>
<script language="javascript">
window.opener.location.reload();
window.location.href = "add_ans.php?q_id=<?php echo $R[q_id]; ?>&num=<?php echo $num; ?>";
	</script>
	<?php
	}
		   }elseif($Flag=="B"){

$SQL = $db->query("INSERT INTO `p_question` ( `q_id` , `c_id` , `q_name` , `q_des` , `q_pos` , `q_anstype` , `q_ansnum` , `q_req` ) VALUES (
'', '$path', '$ch', '$name', '$pos', '$sel', '$num', '$just')");

  		 $SQL3 = $db->query("SELECT * FROM p_question WHERE c_id = '$path' ORDER BY q_id DESC");
		 $row = mysqli_num_rows($SQL3);
$R = mysqli_fetch_array($SQL3);
		 if($row=="1"){ 
			 
for($i=0;$i<$all;$i++){
$ans = "ans".$i;
$ans = $$ans;
 $weight = "weight".$i;
$weight = $$weight;
$WWW = $db->query("INSERT INTO p_ans (a_id,q_id,a_name,option3,a_weight) VALUES ('','$R[q_id]','$ans','$i','$weight')");
}
		 }else{
$QQQ = $db->query("SELECT distinct(p_ans.a_name),a_weight FROM p_ans,p_question WHERE p_question.c_id = '$path' AND p_question.q_id=p_ans.q_id ORDER BY p_ans.option3 ASC");
$x = 0;
while($RR = mysqli_fetch_array($QQQ)){
	$WWW = $db->query("INSERT INTO p_ans (a_id,q_id,a_name,option3,a_weight) VALUES ('','$R[q_id]','$RR[a_name]','$x','$RR[a_weight]')");
	$x++;
}
		 }
		
?>
<script language="javascript">
window.opener.location.reload();
window.close();
	</script>
	<?php
		   }elseif($Flag == "A"){
		$Current_Dir = "../ewt/".$_SESSION["EWT_SUSER"]."/images/form_pic";
		if (!(file_exists($Current_Dir))) {
		mkdir ($Current_Dir, 0777);
		@chmod ($Current_Dir, 0777);
		}
for($i=0;$i<$num;$i++){		   
 $an = "an".$i;
$an = $$an;
 $ch = "ch".$i;
$ch = $$ch;
 $weight = "weight".$i;
$weight = $$weight;
	if($_FILES["file".$i]["size"] > 0){
		copy($_FILES["file".$i]["tmp_name"],$Current_Dir."/".$_FILES["file".$i]["name"]);
		@chmod ($Current_Dir."/".$_FILES["file".$i]["name"], 0777);
		$an = $an."#@form#img@#"."images/form_pic/".$_FILES["file".$i]["name"];
	}
$z =$i+1;
if($def == $z ){
$WWW = $db->query("INSERT INTO p_ans (a_id,q_id,a_name,a_other,option3,option4,a_weight) VALUES ('','$q_id','$an','$ch','$i','Y','$weight')");		   
}else{
$WWW = $db->query("INSERT INTO p_ans (a_id,q_id,a_name,a_other,option3,a_weight) VALUES ('','$q_id','$an','$ch','$i','$weight')");		
}
$db->write_log("create","servey","สร้างคำตอบ ".$an);
}

		   ?>
<script language="javascript">
window.opener.location.reload();
window.close();
	</script>
<?php
		   }elseif($Flag == "D"){
if($de == "S"){
$WWW = $db->query("INSERT INTO p_ans (a_id,q_id,a_name,a_other,option3,option4) VALUES ('','$q_id','$def','$de','$wor','$wid2')");		   
}else{
$WWW = $db->query("INSERT INTO p_ans (a_id,q_id,a_name,a_other,option3,option4) VALUES ('','$q_id','$def','$de','$line','$wid1')");		 
}
		   ?>
<script language="javascript">
window.opener.location.reload();
window.close();

	</script>
<?php
		   }elseif($Flag == "E"){

$WWW = $db->query("INSERT INTO p_ans (a_id,q_id,a_name,a_other,option3,option4) VALUES ('','$q_id','$stype','$sdef','','')");	
		   ?>
<script language="javascript">
window.opener.location.reload();
window.close();
	</script>
<?php
		   }	
?>
<?php @$db->db_close(); ?>