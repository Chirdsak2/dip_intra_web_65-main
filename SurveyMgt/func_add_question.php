<?php
include("../lib/include.php");
include("../lib/function.php");
include("../lib/user_config.php");
include("../lib/connect.php");
include("../lib/set_lang.php");
include("../language.php");
include("../language/language_TH.php");
include("../lib/config_path.php");


$date = new DateTime();

$a_data = array_merge($_POST, $_FILES);
	
$s_data = array();

/*$s_data['com_form_title']  = $a_data['com_form_title'];
$s_data['com_form_createdate']  = $date->format('Y-m-d H:i:s');
$s_data['com_form_update']  = $date->format('Y-m-d H:i:s');*/


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

if($a_data['proc'] == "Q"){	

$name = $_POST['name'];
$num = $_POST['num'];
$path = $_POST['path'];
$ch = $_POST['ch'];
$pos = $_POST['pos'];
$sel = $_POST['sel'];
$de = $_POST['de'];

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
if($sel == 'D'){
if($de == "S"){
$WWW = $db->query("INSERT INTO p_ans (a_id,q_id,a_name,a_other,option3,option4) VALUES ('','{$a_max['id']}','','{$de}','','')");		   
}else{
$WWW = $db->query("INSERT INTO p_ans (a_id,q_id,a_name,a_other,option3,option4) VALUES ('','{$a_max['id']}','','{$de}','{$line}','{$wid1}')");		 
}
}else{
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
//print_r($a_data);

}

if($_POST['proc'] == "B"){	
//print_r($a_data);
//exit;
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

$ans = $_POST['ans'.$i];
$weight = $_POST['weight'.$i];

$db->query("INSERT INTO p_ans (a_id,q_id,a_name,option3,a_weight) VALUES ('','$R[q_id]','$ans','$i','$weight')");
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