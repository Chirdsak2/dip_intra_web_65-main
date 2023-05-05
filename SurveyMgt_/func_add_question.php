<?php
include("../lib/permission1.php");
include("../lib/include.php");
include("../lib/function.php");
include("../lib/user_config.php");
include("../lib/connect.php");
include("../lib/set_lang.php");


if($_POST['just'] == 'Y'){ 

if($_POST['email_data'] == 'Y'){
	$just .= '#zz#Y';
}else if($_POST['email_data'] == 'N'){
	$just .= '#zz#N';
}else{
	$just .= '#zz#';
}

if($_POST['no_replate'] == 'QNR'){
	$just .= '#zz#QNR';
}else{
	$just .= '#zz#';
}

}else{
	
	$just = '';
}

if($_POST['proc'] == "Q"){	

$num = $_POST['num'];
$path = $_POST['path'];
$ch = $_POST['ch'];
$pos = $_POST['pos'];
$sel = $_POST['sel'];

$SQL = $db->query("INSERT INTO `p_question` ( `q_id` ,
											  `c_id` , 
											  `q_name` , 
											  `q_des` , 
											  `q_pos` , 
											  `q_anstype` , 
											  `q_ansnum` , 
											  `q_req` ) 
											  VALUES (
											  '', 
											  '{$path}', 
											  '{$ch}', 
											  '{$name}', 
											  '{$pos}', 
											  '{$sel}', 
											  '{$num}', 
											  '{$just}'
											  )
											  ");
											  
$db->write_log("create","servey","สร้างคำถาม ".$ch.".".$name);

/*$ex = $db->query("SELECT q_id FROM p_question ORDER BY q_id DESC");
$R =  $db->db_fetch_array($ex);*/

$p_q_max = $db->query("SELECT MAX(q_id) AS id FROM p_question");
$a_max =  $db->db_fetch_array($p_q_max);
if($num > 0){
	
for($i=0;$i<$num;$i++){		   

$ins_p_ans = $db->query("INSERT INTO p_ans (a_id,
											q_id,
											a_name,
											a_other,
											option3,
											option4,
											a_weight
											) 
											VALUES (
											'',
											'{$a_max['id']}',
											'{$an}',
											'{$ch}',
											'{$i}',
											'Y',
											'{$weight}'
											)
											");		   

	}
}

}

if($_POST['proc'] == "B"){	

$all =  $_POST['all']; 

$SQL = $db->query("INSERT INTO `p_question` ( `q_id` , `c_id` , `q_name` , `q_des` , `q_pos` , `q_anstype` , `q_ansnum` , `q_req` ) VALUES (
'', '$path', '$ch', '$name', '$pos', '$sel', '$num', '$just')");

$SQL3 = $db->query("SELECT * FROM p_question WHERE c_id = '$path' ORDER BY q_id DESC");
$row = mysql_num_rows($SQL3);
$R = mysql_fetch_array($SQL3);

if($row == "1"){ 

			 
for($i=0;$i<$all;$i++){
	
/*$ans = "ans".$i;
$ans = $$ans;
$weight = "weight".$i;
$weight = $$weight;*/

$ans = $_POST['ans'][$i];
$weight = $_POST['weight'][$i];

$WWW = $db->query("INSERT INTO p_ans (a_id,q_id,a_name,option3,a_weight) VALUES ('','$R[q_id]','$ans','$i','$weight')");
}

}else{
$QQQ = $db->query("SELECT distinct(p_ans.a_name),a_weight FROM p_ans,p_question WHERE p_question.c_id = '$path' AND p_question.q_id=p_ans.q_id ORDER BY p_ans.option3 ASC");
$x = 0;
while($RR = mysql_fetch_array($QQQ)){
	$WWW = $db->query("INSERT INTO p_ans (a_id,q_id,a_name,option3,a_weight) VALUES ('','$R[q_id]','$RR[a_name]','$x','$RR[a_weight]')");
	$x++;
}
		 }
		

}

?>