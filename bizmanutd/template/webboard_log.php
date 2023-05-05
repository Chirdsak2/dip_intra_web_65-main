<?php
if($_SESSION["EWT_MID"] != '' && $wcad !=''){
$sql="select * from w_admin,w_permission where w_admin.t_id = w_permission.t_id  and w_admin.t_id='".$_SESSION["EWT_MID"]."' and c_id='$wcad'";
$query = $db->query($sql);
$num = $db->db_num_rows($query);
if($num > 0){
$TTYPE = 'Y';
$admin = $_SESSION["EWT_MID"];
}else{
$TTYPE = 'N';
$admin  ='';
}
}
$sql = $db->query("SELECT * FROM w_config WHERE c_config = '1'");
$X = mysql_fetch_array($sql);

#check data ว่ามีคนตอบกระทู้หรือยังถ้ามีแล้วไม่ต้องส่ง แต่ถ้ายังไม่มีให้ทำการตอบอัตโนมัติ
if($wtid != ''){
$sql_Q = "select * from w_question where t_id ='$wtid'";
$query_Q = $db->query($sql_Q);
$R=mysql_fetch_array($query_Q);
$date = $R[t_date];
$time = $R[t_time];

$time_limit = $X[c_link];
if($time_limit == 0){
$time_limit = '15';
}
$date_new = explode('-',$date);
$time_new = explode(':',$time);
$time_add = mktime($time_new[0], $time_new[1], $time_new[2], $date_new[1], $date_new[2], $date_new[0]);
$time_now = mktime(date("H"),date("i"), date("s"), date("m"), date("d"), date("Y"));
$time_a = mktime($time_new[0], $time_new[1]+$time_limit, $time_new[2], $date_new[1], $date_new[2], $date_new[0]);

$sql_answer = "select * from w_answer where t_id ='$wtid'";
$query_sql_answer = $db->query($sql_answer);
$num = mysql_num_rows($query_sql_answer);
if($num==0 && $time_now >= $time_a){

##ผู้เชี่ยวชาญ
$i=1;
$key =array();
$email =array();
$sql_prof = "select professor.prof_name,professor.prof_mob,professor.prof_tel,professor.prof_email,professor_keyword.key_word,count(professor_keyword.prof_id) as num  
						from professor 
						INNER JOIN professor_keyword on professor.prof_id = professor_keyword.prof_id 
						INNER JOIN w_question ON (w_question.t_name REGEXP professor_keyword.key_word or w_question.t_detail REGEXP professor_keyword.key_word) and w_question.t_id = '$wtid'  
						group by professor.prof_name,professor_keyword.key_word  order by num";
$query_prof = $db->query($sql_prof);
$num_prof = mysql_num_rows($query_prof);
if($num_prof >0){
$txt .="กรุณาติดต่อผู้เชี่ยวชาญ<br><br>";
	while($rec_prof = $db->db_fetch_array($query_prof)){
	$db->query("USE ".$EWT_DB_USER);
			$sql_user = "select * from gen_user where gen_user_id = '".$rec_prof[prof_name]."'";
			$query_user = $db->query($sql_user);
			$num_user = $db->db_num_rows($query_user);
			$rec_user = $db->db_fetch_array($query_user);
			$db->query("USE ".$EWT_DB_NAME);
			if($rec_user[tel_in] == ''){
			$rec_user[tel_in] = 'ไม่มี';
			}
			if($rec_user[email_person] == ''){
			$rec_user[email_person] = 'ไม่มี';
			}
		$txt .="&nbsp;&nbsp;&nbsp;&nbsp;<img src=\"pic/webboard/m_name.gif\" align=\"absmiddle\" border=\"1\" style=\"border-color:#dddddd\">&nbsp;".$rec_user[name_thai].'  '.$rec_user[surname_thai]." (".$rec_prof[key_word].")<br>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<img src=\"pic/webboard/m_phone.gif\" align=\"absmiddle\" border=\"1\" style=\"border-color:#dddddd\">&nbsp;".$rec_user[tel_in]."&nbsp;&nbsp;&nbsp;&nbsp;<img src=\"pic/webboard/m_mail.gif\" align=\"absmiddle\" border=\"1\" style=\"border-color:#dddddd\">&nbsp;".$rec_user[email_person]."<br><br>";//&nbsp;&nbsp;&nbsp;&nbsp;<img src=\"pic/webboard/m_mobile.gif\" align=\"absmiddle\" border=\"1\" style=\"border-color:#dddddd\">&nbsp;".$rec_prof[prof_mob]."
		array_push ($key, $rec_prof[key_word]);
		if($rec_user[email_person] != ''){
		array_push ($email, $rec_user[email_person]);
		}
	}
}
##webboard
$a=1;
for($i=0;$i<count($key);$i++){
//$sql_webb = "select * from w_question where  ((t_name REGEXP '$key[$i]' or  t_detail REGEXP '$key[$i]') ) and w_question.t_id <> '$wtid' group by w_question.t_id";
$sql_webb = "SELECT DISTINCT(w_question.t_id),w_question.t_name FROM w_question  LEFT JOIN w_answer ON w_question.t_id = w_answer.t_id AND w_answer.s_id = '1' WHERE  w_question.s_id = '1' AND ( ( t_name REGEXP '$key[$i]'  OR t_detail REGEXP '$key[$i]'  OR a_detail REGEXP '$key[$i]'  ))  and w_question.t_id <> '$wtid' ORDER BY w_question.t_id DESC";
$query_webb = $db->query($sql_webb);
$num_webb = mysql_num_rows($query_webb);
if($num_webb >0){
$txt .="<br><hr>หรือค้นหาจากกระทู้<br><br>";
	while($rec_webb = $db->db_fetch_array($query_webb)){
		$txt .="&nbsp;&nbsp;&nbsp;&nbsp;<a href=\"index_answer.php?wcad=$wcad&wtid=$rec_webb[t_id]\">".$rec_webb[t_name].'</a><br><br>';
	}
}
}

##Faq
$a=1;
for($i=0;$i<count($key);$i++){
$sql_webb = "select * from faq where fa_name REGEXP '$key[$i]'";
$query_webb = $db->query($sql_webb);
$num_webb = mysql_num_rows($query_webb);
if($num_a>0){
$txt .="<br><hr>หรือค้นหาFAQ<br><br>";
	while($rec_webb = $db->db_fetch_array($query_webb)){
		$txt .="&nbsp;&nbsp;&nbsp;&nbsp;".$rec_webb[fa_name].'<br><br>';
	}
}
}
##By ระบบตอบAutomatic 
//$txt .= "ระบบตอบAutomatic <br>";
	if($num_a > 0 || $num_webb > 0 || $num_prof  >0){
	$Execsql = $db->query("INSERT INTO `w_answer` ( `a_id` , `t_id` , `a_detail` , `a_date` , `a_time` , `a_ip` , `a_picture` , `s_id` , `a_name` , `a_email` , `user_id`) VALUES ( '', '$wtid', '$txt','".date('Y-m-d',$time_add)."' ,'".date('H:i:s',$time_a)."', '-', 'skip', '1', 'ระบบตอบAutomatic', '','')");
	//send mail
	$message = "
						<html>
						<head>
						</head>
						<body>
						<p>New Topic From Webboard System</p>
						Topic : </td><td>".$R[t_name]." เข้ามาในระบบ</td>
						</body>
						</html>
						";
						/* subject */
						$subject = "New Topic From Webboard System";
						
						/* To send HTML mail, you can set the Content-type header. */
						$headers  = "MIME-Version: 1.0\r\n";
						$headers .= "Content-type: text/html; charset=UTF-8\r\n";
						
						/* additional headers */
						$headers .= "From: From Webboard System <support@dmr.go.th>\r\n";
						
						@mail(implode(";", $email), $subject, $message, $headers);
	}
}
}
?>
