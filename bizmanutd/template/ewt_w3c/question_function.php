<?php
$path = '../';
session_start();
include($path."lib/function.php");
include($path."lib/user_config.php");
include($path."lib/connect.php");
$Globals_Url_webb = "http://localhost/ewtadmin/ewt/pic";

function CheckTag($temp){
		global $url;
		$temp = stripslashes(htmlspecialchars($temp));
		$temp = eregi_replace ( chr(13), "<br>" , $temp ) ;
		$temp = eregi_replace ( "\[b\]", "<b>" , $temp ) ;
		$temp = eregi_replace ( "\[/b\]", "</b>" , $temp ) ;
		$temp = eregi_replace ( "\[br\]", "<br>" , $temp ) ;
		$temp = eregi_replace ( "\[i\]", "<i>" , $temp ) ;
		$temp = eregi_replace ( "\[/i\]", "</i>" , $temp ) ;
		$temp = eregi_replace ( "\[u\]", "<u>" , $temp ) ;
		$temp = eregi_replace ( "\[/u\]", "</u>" , $temp ) ;
		$temp = eregi_replace ( "\[hr\]", "<hr>" , $temp ) ;
		$temp = eregi_replace ( "\[\-\-\-\]", "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;" , $temp ) ;
		$temp = eregi_replace ( "\[color=red\]", "<font color=red>" , $temp ) ;
		$temp = eregi_replace ( "\[color=green\]", "<font color=green>" , $temp ) ;
		$temp = eregi_replace ( "\[color=blue\]", "<font color=blue>" , $temp ) ;
		$temp = eregi_replace ( "\[color=orange\]", "<font color=FF6600>" , $temp ) ;
		$temp = eregi_replace ( "\[color=pink\]", "<font color=FF00FF>" , $temp ) ;
		$temp = eregi_replace ( "\[color=gray\]", "<font color=999999>" , $temp ) ;
		$temp = eregi_replace ( "\[/color\]", "</font>" , $temp ) ;
		$temp = eregi_replace ("\[img\]([[:alnum:]]+)://([^[:space:]]*)([[:alnum:]])\[/img\]", "<img src=\"\\1://\\2\\3\">",$temp ) ;
		$temp = eregi_replace ("\[url\]([[:alnum:]]+)://([^[:space:]]*)([[:alnum:]#?/&=])\[/url\]","<a href=\"\\1://\\2\\3\" target=\"_blank\">\\1://\\2\\3</a>",$temp ) ;
		return ( $temp ) ;
	}
	
	function CheckSmile($temp){
		global $url;
		global $Globals_Url_webb;
		global $db;
		$text = array();
		$pic =array();
		$alt = array();
		$sql = "select * from emotion";
		$query = $db->query($sql);
		while($rec = $db->db_fetch_array($query)){
		array_push ($text, $rec[emotion_character]);
		array_push ($pic, $rec[emotion_img]);
		array_push ($alt, $rec[emotion_name]);
		}
		for ($i=0 ; $i<sizeof($text) ; $i++) {
			$temp = eregi_replace($text[$i],"<img src=\"$pic[$i]\" alt=\"$alt[$i]\">",$temp);
		}
		return($temp);
	}
function random_code($len){
srand((double)microtime()*10000000);
$chars = "ABCDEFGHJKMNPQRSTUVWXYZabcdefghijkmnpqrstuvwxyz123456789";
$ret_str = "";
$num = strlen($chars);
for($i=0;$i<$len;$i++){
$ret_str .= $chars[rand()%$num];
}
return $ret_str;
}
		//check username in db
	function check_name_wbb($name){
		global $db,$EWT_DB_NAME,$EWT_DB_USER;
		
		$db->query("USE ".$EWT_DB_USER);
		$sql_img = "select * from gen_user where webb_name = '".$name."'";
		$query = $db->query($sql_img);
		if($db->db_num_rows($query)>0){
			print "<script>alert('ชื่อนี้มีสมาชิกของระบบใช้อยู่ กรุณาใช้ชื่ออื่นหรือ login เข้าสู่ระบบ!!!!!!!!!');</script>";	exit;
		}
		$db->query("USE ".$EWT_DB_NAME);
	}
	
	function check_w_name($name){
		global $db;
		$sql_img = "select * from w_name where w_name = '".strtolower($name)."'";
		$query = $db->query($sql_img);
		if($db->db_num_rows($query)>0){
			print "<script>alert('ชื่อนี้เป็นชื่อห้ามที่ห้ามใช้ กรุณาใช้ชื่ออื่น!!');</script>";	exit;
		}
	}
	
	if($_SERVER["REMOTE_ADDR"]) 
	{
		$IPn = $_SERVER["REMOTE_ADDR"];
	}	 
else 
	{
		$IPn = $_SERVER["REMOTE_HOST"];
	}
function vulgar($text,$wcad){
global $db;
$vulgar_text = array();
$sql_vulgar = "SELECT *  FROM vulgar_table ";
   $query_vulgar  = mysql_query($sql_vulgar);
   $i=0;
   	while ($res_vulgar = mysql_fetch_array($query_vulgar)){
		$pos = strpos($text, $res_vulgar [vulgar_text]);
		if (!($pos === false)) { // note: three equal signs
		?>
<script language="JavaScript">
alert('ความคิดเห็นของคุณมีคำแปลกปลอม กรุณาตรวจ!!!');
window.location.href = "index_question.php?wcad=<?php echo $wcad; ?>&t=<?php echo $_POST[themes];?>&filename=<?php echo $_POST[filename];?>";
</script>
<?
exit;
			/*print "<script>alert('ความคิดเห็นของคุณมีคำแปลกปลอม กรุณาตรวจ!!!');<!--</script>";	exit;*/
		}
	}
}
$chk_config = $db->query("SELECT * FROM w_config WHERE c_config = '1'");
$CO = mysql_fetch_array($chk_config);
//if($CPD_M_GROUP_MANAGE == "Y" || $_SESSION["EWT_MID"] != ""){
//$CO[c_approve] = "1";
//}
if($_POST["flag"] =="question"){

$Execsql1 = $db->query("SELECT * FROM w_cate WHERE c_id = '$wcad'");
$QQ= mysql_fetch_array($Execsql1);
if(($QQ[c_question] == "2" || $QQ[c_question] == "3" ) AND $_SESSION["EWT_MID"] == ""){
?>
<script language="JavaScript">
alert("กรุณา login ก่อนเข้าสู่  Webboard");
window.location.href="ewt_login.php?fn=addquestion.php?wcad=<? echo $wcad; ?>&t=<?php echo $_POST[themes];?>&filename=<?php echo $_POST[filename];?>";
</script>
<?
exit;
}

if($QQ[c_question] == "3"   AND $_SESSION["EWT_MID"] != "" AND $_SESSION["EWT_TYPE_ID"]  != 1){
?>
<script language="JavaScript">
alert("Webboard นี้ท่านไม่สามารถร่วมตั้งคำถามได้");
window.location.href = "index_question.php?wcad=<? echo $wcad; ?>&t=<?php echo $_POST[themes];?>&filename=<?php echo $_POST[filename];?>";
</script>
<?
}
//check vulgar
	vulgar(addslashes(htmlspecialchars($aque)),$wcad);
	vulgar(addslashes(htmlspecialchars($amsg)),$wcad);
	if($_SESSION["EWT_MID"] == ""){ 
	vulgar(addslashes(htmlspecialchars($aname)),$wcad);
	check_name_wbb(addslashes(htmlspecialchars($aname)));
	}
	check_w_name(addslashes(htmlspecialchars($aname)));
	//check vulgar
	if($file_size > 0 && $file_size> ($CO[c_sizeupload]*1024) ){
	?>
		<script language="javascript">
			alert("ขนาดไฟล์ของท่านใหญ่เกิน<?php echo $CO[c_sizeupload];?> KB. กรุณาเลือกไฟล์ใหม่อีกครั้ง");
		window.location.href = "index_question.php?wcad=<? echo $wcad; ?>&t=<?php echo $_POST[themes];?>&filename=<?php echo $_POST[filename];?>";
		</script>
		<?php
			exit;
	}
if($file_size > 0){
	$ftype = explode(".",$file_name);
	$type_chk = $CO[c_img];
	$type_expl = explode(",",$type_chk);
	$picname = random_code(20);
	$picname = $picname.".".$ftype[1];
	for($a=0;$a<count($type_expl);$a++){
			if($type_expl[$a] == strtolower($ftype[1])){
			$img_name = $picname;
			break;
			}else{
			$img_name = 1;
			}
		
		}
		if($img_name == 1){
	?>
			<script language="JavaScript">
			alert("ประเภทเอกสารไม่ถูกต้อง ท่านไม่สามารถแนบเอกสารนี้ได้!!!!!");
			window.location.href = "index_question.php?wcad=<? echo $wcad; ?>&t=<?php echo $_POST[themes];?>&filename=<?php echo $_POST[filename];?>";
			</script>
				<?
				exit;
	}

	
@copy($file,'../userpic/'.$picname);
}else{
$picname = "";
}


	$t_topic = addslashes(htmlspecialchars($aque));
	$t_detail = addslashes(htmlspecialchars($amsg));
	$t_detail = eregi_replace(chr(13)," <br> ", $t_detail );
	$t_detail = CheckTag($t_detail);
	$t_detail = CheckSmile($t_detail);
$Execsql = $db->query("INSERT INTO `w_question` ( `t_id` , `c_id` , `t_name` , `t_detail` , `t_date` , `t_time` , `t_picture` , `t_count` , `t_ip` , `s_id` , `q_name` , `q_email`, `user_id`,`keyword` ,`t_fign`) VALUES ('', '$wcad', '$t_topic', '$t_detail', NOW( ) , NOW( ) , '".$_SESSION["EWT_IMG"]."', '0', '$IPn', '$CO[c_approve]', '$aname', '$aemail','".$_SESSION["EWT_MID"]."','$img_name','$fign')");
//สร้าง Rss
Gen_RSS($wcad);
if($_SESSION["EWT_MID"] != ""){ 
$db->query("USE ".$EWT_DB_USER);
$db->query("UPDATE gen_user SET post_num = (post_num +1) where gen_user_id ='".$_SESSION["EWT_MID"]."'");
$db->query("USE ".$EWT_DB_NAME);

}
/*$rec_max = $db->db_fetch_array($db->query("select max(t_id) as id from w_question"));
$key =array();$key_id =array();$c_id =array();
$sql_a_auto = "select * from w_question";
$query = $db->query($sql_a_auto);
while($rec = $db->db_fetch_array($query)){
	if(!empty($rec[keyword])){
	array_push ($key, $rec[keyword]);
	array_push ($key_id, $rec[t_id]);
	array_push ($c_id, $rec[c_id]);
	}
}
if(count($key) >0){
$txt .="[b]=>คำตอบ Auto[/b][br]";
for($i=0;$i<count($key);$i++){
	$sql="select * from w_question where t_name like '%$key[$i]%' and t_id = '".$rec_max[id]."'";
	$query = $db->query($sql);
	if($db->db_num_rows($query)>0){
	$chk = 1;
		while($rec =$db->db_fetch_array($query)){
		$y= 1;
			$sql_w = "select * from w_question,w_answer where w_answer.t_id = w_question.t_id and w_question.t_id ='".$key_id[$i]."' and a_detail like '%$key[$i]%'";
			$query_w = $db->query($sql_w);
			while($rec_w = $db->db_fetch_array($query_w)){
			$txt1 ="[b]คำตอบที่".$y.'[/b]'.$rec_w[a_detail].'[br]';
			$txt.=ereg_replace($key[$i]," [color=red][b]".$key[$i]."[/b][/color]", $txt1);
			$y++;
			}
		}
	}
}
if($chk ==1){
$admin = $db->query("select * from w_admin where t_id =$wcad");
$rec_admin = $db->db_fetch_array($admin);
$Execsql = $db->query("INSERT INTO `w_answer` ( `a_id` , `t_id` , `a_detail` , `a_date` , `a_time` , `a_ip` , `a_picture` , `s_id` , `a_name` , `a_email` , `user_id`) VALUES ( '', '$rec_max[id]', '$txt', NOW( ) , NOW( ) , '$IPn', '', '$CO[c_approve]', '$rec_admin[t_name]', '','')");
}
}*/
//find admin module 
$mail_user = array($CO[c_mail]);
$sql_module ="select * from email_config where module ='webboard'";
$query_module = $db->query($sql_module); 
while($rec_module = $db->db_fetch_array($query_module)){
array_push($mail_user,$rec_module[email]);
}
if(count($mail_user) > 0){
$message = "
<html>
<head>
</head>
<body>
<p>New Topic From Webboard System</p>
Topic : </td><td>".$t_topic."<br>
<b>By : </td><td>".$aemail."</b><br>
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

/* and now mail it */
$sql_admin = "select * from w_permission where c_id = '$wcad'";
$query_admin = $db->query($sql_admin);
while($rec_admin = $db->db_fetch_array($query_admin)){
$uid = $rec_admin[t_id];
$db->query("USE ".$EWT_DB_USER);
$sql_email = "select email_kh,email_person from gen_user where gen_user_id = '$uid'";
$query_email = $db->query($sql_email);
$rec_email = $db->db_fetch_array($query_email);
	if(!empty($rec_email[email_kh])){
		$mail_to = $rec_email[email_kh];
	}else{
		$mail_to = $rec_email[email_person];
	}
$db->query("USE ".$EWT_DB_NAME);
@mail($mail_to, $subject, $message, $headers);
}
@mail(implode(";", $mail_user), $subject, $message, $headers);

}
?>
<script language="JavaScript">
	<?
if($CO[c_approve] == "0"){	
?>
	alert("ข้อความของท่านถูกส่งมายังเราเพื่อพิจารณานำขึ้นแสดงบนเว็บเพจเรียบร้อยแล้ว\n ขอขอบพระคุณ");
<? } ?>
window.location.href = "index_question.php?wcad=<? echo $wcad; ?>&t=<?php echo $_POST[themes];?>&filename=<?php echo $_POST[filename];?>";
</script>
	<? }
if($_POST["flag"] =="answer"){

$Execsql1 = $db->query("SELECT * FROM w_cate WHERE c_id = '$wcad'");
$QQ= mysql_fetch_array($Execsql1);
if(($QQ[c_view] == "2" || $QQ[c_view] == "3" ) AND $_SESSION["EWT_MID"] == ""){
?>
<script language="JavaScript">
alert("กรุณา login ก่อนเข้าสู่  Webboard");
window.location.href="ewt_login.php?fn=index_question.php?wcad=<? echo $wcad; ?>&t=<?php echo $_POST[themes];?>&filename=<?php echo $_POST[filename];?>";
</script>
<?
exit;
}
if($QQ[c_view] == "3"   AND $_SESSION["EWT_MID"] != "" AND $_SESSION["EWT_TYPE_ID"]  != 1){
?>
<script language="JavaScript">
alert("Webboard นี้ท่านไม่สามารถร่วมตอบคำถามได้");
window.location.href = "m_webboard.php?t=<?php echo $_POST[themes];?>&filename=<?php echo $_POST[filename];?>";
</script>
<?
exit;
}
if(($QQ[c_answer] == "2" || $QQ[c_answer] == "3" ) AND $_SESSION["EWT_MID"] == ""){
?>
<script language="JavaScript">
alert("กรุณา login ก่อนเข้าสู่  Webboard");
window.location.href="ewt_login.php?fn=index_answer.php?wcad=<? echo $wcad; ?>&wtid=<? echo $wtid; ?>&t=<?php echo $_POST[themes];?>&filename=<?php echo $_POST[filename];?>";
</script>
<?
exit;
}
if($QQ[c_answer] == "3"   AND $_SESSION["EWT_MID"] != "" AND $_SESSION["EWT_TYPE_ID"]  != 1){
	?>
<script language="JavaScript">
alert("Webboard นี้ท่านไม่สามารถร่วมตอบคำถามได้");
window.location.href = "index_answer.php?wcad=<? echo $wcad; ?>&wtid=<? echo $wtid; ?>&t=<?php echo $_POST[themes];?>&filename=<?php echo $_POST[filename];?>";
</script>
<?
exit;
}
//check vulgar
	vulgar(addslashes(htmlspecialchars($amsg)),$wcad);
	if($_SESSION["EWT_MID"] == ""){ 
	vulgar(addslashes(htmlspecialchars($aname)),$wcad);
	check_name_wbb(addslashes(htmlspecialchars($aname)));
	}
	check_w_name(addslashes(htmlspecialchars($aname)));
	
	if($file_size > 0 && $file_size> ($CO[c_sizeupload]*1024) ){
	?>
		<script language="javascript">
			alert("ขนาดไฟล์ของท่านใหญ่เกิน<?php echo $CO[c_sizeupload];?> KB. กรุณาเลือกไฟล์ใหม่อีกครั้ง");
		window.location.href = "index_answer.php?wcad=<? echo $wcad; ?>&wtid=<? echo $wtid; ?>&t=<?php echo $_POST[themes];?>&filename=<?php echo $_POST[filename];?>";

		</script>
		<?php
			exit;
	}
if($file_size > 0){
	$ftype = explode(".",$file_name);
	$type_chk = $CO[c_img];
	$type_expl = explode(",",$type_chk);
	$picname = random_code(20);
	$picname = $picname.".".$ftype[1];
	for($a=0;$a<count($type_expl);$a++){
			if($type_expl[$a] == strtolower($ftype[1])){
			$img_name = $picname;
			break;
			}else{
			$img_name = 1;
			}
		}
	if($img_name == 1){
			?>
			<script language="JavaScript">
			alert("ประเภทเอกสารไม่ถูกต้อง<?php echo $type_expl[$a].$ftype[1];?> ท่านไม่สามารถแนบเอกสารนี้ได้!!!!!");
			window.location.href = "index_answer.php?wcad=<? echo $wcad; ?>&wtid=<? echo $wtid; ?>&t=<?php echo $_POST[themes];?>&filename=<?php echo $_POST[filename];?>";

			</script>
				<?
				exit;
		}
	
	
@copy($file,'../userpic/'.$picname);
}else{
$picname = "";
}

	$a_detail = addslashes(htmlspecialchars($amsg));
	$a_detail = eregi_replace(chr(13)," <br> ", $a_detail );
	$a_detail = CheckTag($a_detail);
	$a_detail = CheckSmile($a_detail);
$aname = $aname;
$aemail = $aemail;

$Execsql = $db->query("INSERT INTO `w_answer` ( `a_id` , `t_id` , `a_detail` , `a_date` , `a_time` , `a_ip` , `a_picture` , `s_id` , `a_name` , `a_email` , `user_id`, `a_attact`, `a_fign`) VALUES ( '', '$wtid', '$a_detail', NOW( ) , NOW( ) , '$IPn', '".$_SESSION["EWT_IMG"]."', '$CO[c_approve]', '$aname', '$aemail','".$_SESSION["EWT_MID"]."','$img_name','$fign')");
if($_SESSION["EWT_MID"] != ""){ 
$db->query("USE ".$EWT_DB_USER);
$db->query("UPDATE gen_user SET post_num = (post_num +1) where gen_user_id ='".$_SESSION["EWT_MID"]."'");
$db->query("USE ".$EWT_DB_NAME);

}
//find admin module 
$mail_user = array($CO[c_mail]);
$sql_module ="select * from email_config where module ='webboard'";
$query_module = $db->query($sql_module); 
while($rec_module = $db->db_fetch_array($query_module)){
array_push($mail_user,$rec_module[email]);
}
if(count($mail_user) > 0){
$message = "
<html>
<head>
</head>
<body>
<p>New Comment  From Webboard System</p>
Comment : </td><td>".$a_detail."<br>
<b>By : </td><td>".$aname."</b><br>
</body>
</html>
";
/* subject */
$subject = "New Comment  From Webboard System";

/* To send HTML mail, you can set the Content-type header. */
$headers  = "MIME-Version: 1.0\r\n";
$headers .= "Content-type: text/html; charset=UTF-8\r\n";

/* additional headers */
$headers .= "From:  From Webboard System\r\n";

/* and now mail it */
$sql_admin = "select * from w_permission where c_id = '$wcad'";
$query_admin = $db->query($sql_admin);
while($rec_admin = $db->db_fetch_array($query_admin)){
$uid = $rec_admin[t_id];
$db->query("USE ".$EWT_DB_USER);
$sql_email = "select email_kh,email_person from gen_user where gen_user_id = '$uid'";
$query_email = $db->query($sql_email);
$rec_email = $db->db_fetch_array($query_email);
	if(!empty($rec_email[email_kh])){
		$mail_to = $rec_email[email_kh];
	}else{
		$mail_to = $rec_email[email_person];
	}
$db->query("USE ".$EWT_DB_NAME);
@mail($mail_to, $subject, $message, $headers);//mail for admin sub
}
@mail(implode(";", $mail_user), $subject, $message, $headers);//mail for admin module

}
?>
<script language="JavaScript">
<? 
	if($CO[c_approve] == "0"){	
?>
	alert("ข้อความของท่านถูกส่งมายังเราเพื่อพิจารณานำขึ้นแสดงบนเว็บเพจเรียบร้อยแล้ว\n ขอขอบพระคุณ");
<? } ?>
window.location.href = "index_answer.php?wcad=<? echo $wcad; ?>&wtid=<? echo $wtid; ?>&t=<?php echo $_POST[themes];?>&filename=<?php echo $_POST[filename];?>";
</script>
	<? }
	if($flag == "delans"){
$db->query("DELETE FROM w_answer WHERE a_id = '$waid'");
$db->query("DELETE FROM w_vote WHERE a_id = '$waid");
?>
<script language="JavaScript">
window.location.href = "index_answer.php?wcad=<? echo $wcad; ?>&wtid=<? echo $wtid; ?>&t=<?php echo $_GET[t]?>&filename=<?php echo $_GET[filename];?>";
</script>
	<?
}
if($flag == "deltopic"){
$db->query("DELETE FROM w_question WHERE t_id = '$wtid'");
while($rec2 = $db->db_fetch_array($db->query("select * from w_answer WHERE t_id = '$wtid'"))){
$db->query("DELETE FROM w_vote WHERE a_id = '$rec2[a_id]'");
}
$db->query("DELETE FROM w_answer WHERE t_id = '$wtid'");
//สร้าง Rss
Gen_RSS($wcad);
?>
<script language="JavaScript">
window.location.href = "index_question.php?wcad=<? echo $wcad; ?>&t=<?php echo $_GET[t]?>&filename=<?php echo $_GET[filename];?>";
</script>
	<?
}if($flag =="question_edit"){
$Execsql1 = $db->query("SELECT * FROM w_cate WHERE c_id = '$wcad'");
$QQ= mysql_fetch_array($Execsql1);
if(($QQ[c_question] == "2" || $QQ[c_question] == "3" ) AND $_SESSION["EWT_MID"] == ""){
?>
<script language="JavaScript">
alert("กรุณา login ก่อนเข้าสู่  Webboard");
window.location.href="ewt_login.php?fn=addquestion.php?wcad=<? echo $wcad; ?>&t=<?php echo $_POST[themes];?>&filename=<?php echo $_POST[filename];?>";
</script>
<?
exit;
}

if($QQ[c_question] == "3"   AND $_SESSION["EWT_MID"] != "" AND $_SESSION["EWT_TYPE_ID"]  != 1){
?>
<script language="JavaScript">
alert("Webboard นี้ท่านไม่สามารถร่วมตั้งคำถามได้");
window.location.href = "index_question.php?wcad=<? echo $wcad; ?>&t=<?php echo $_POST[themes];?>&filename=<?php echo $_POST[filename];?>";
</script>
<?
}
//check vulgar
	vulgar(addslashes(htmlspecialchars($aque)));
	vulgar(addslashes(htmlspecialchars($amsg)));
	vulgar(addslashes(htmlspecialchars($aname)));
	//check vulgar
	$t_topic = addslashes(htmlspecialchars($aque));
	$t_detail = addslashes(htmlspecialchars($amsg));
	$t_detail = CheckTag($t_detail);
	$t_detail = CheckSmile($t_detail);
	$t_detail = eregi_replace(chr(13)," <br> ", $t_detail );
$Execsql = $db->query("UPDATE  w_question  SET c_id='$wcad',t_name='$t_topic',t_detail='$t_detail',t_picture='',q_name='$aname',q_email='$aemail' where c_id='$wcad' and t_id = '$wtid'");
//สร้าง Rss
Gen_RSS($wcad);
?>
<script language="JavaScript">
self.parent.close();
self.parent.opener.location.reload();
//window.location.reload();
</script>
	<? }
	if($flag =="answer_edit"){
$Execsql1 = $db->query("SELECT * FROM w_cate WHERE c_id = '$wcad'");
$QQ= mysql_fetch_array($Execsql1);
if(($QQ[c_view] == "2" || $QQ[c_view] == "3" ) AND $_SESSION["EWT_MID"] == ""){
?>
<script language="JavaScript">
alert("กรุณา login ก่อนเข้าสู่  Webboard");
top.location.href="ewt_login.php?fn=index_question.php?wcad=<? echo $wcad; ?>&t=<?php echo $_POST[themes];?>&filename=<?php echo $_POST[filename];?>";
</script>
<?
exit;
}
if($QQ[c_view] == "3"   AND $_SESSION["EWT_MID"] != "" AND $_SESSION["EWT_TYPE_ID"]  != 1){
?>
<script language="JavaScript">
alert("Webboard นี้ท่านไม่สามารถร่วมตอบคำถามได้");
window.location.href = "m_webboard.php?t=<?php echo $_POST[themes];?>&filename=<?php echo $_POST[filename];?>";
</script>
<?
exit;
}
if(($QQ[c_answer] == "2" || $QQ[c_answer] == "3" ) AND $_SESSION["EWT_MID"] == ""){
?>
<script language="JavaScript">
alert("กรุณา login ก่อนเข้าสู่  Webboard");
top.location.href="ewt_login.php?fn=index_answer.php?wcad=<? echo $wcad; ?>&wtid=<? echo $wtid; ?>&t=<?php echo $_POST[themes];?>&filename=<?php echo $_POST[filename];?>";
</script>
<?
exit;
}
if($QQ[c_answer] == "3"   AND $_SESSION["EWT_MID"] != "" AND $_SESSION["EWT_TYPE_ID"]  != 1){
	?>
<script language="JavaScript">
alert("Webboard นี้ท่านไม่สามารถร่วมตอบคำถามได้");
window.location.href = "index_answer.php?wcad=<? echo $wcad; ?>&wtid=<? echo $wtid; ?>&t=<?php echo $_POST[themes];?>&filename=<?php echo $_POST[filename];?>";
</script>
<?
exit;
}
//check vulgar
	vulgar(addslashes(htmlspecialchars($amsg)));
	vulgar(addslashes(htmlspecialchars($aname)));

	
	$a_detail = addslashes(htmlspecialchars($amsg));
	$a_detail = CheckTag($a_detail);
	$a_detail = CheckSmile($a_detail);
	$a_detail = eregi_replace(chr(13)," <br> ", $a_detail );

$aname = $aname;
$aemail = $aemail;

$Execsql = $db->query("UPDATE  w_answer  SET a_detail='$a_detail',a_name='$aname',a_email='$aemail' where a_id='$waid' and t_id = '$wtid'");
?>
<script language="JavaScript">
self.parent.close();
self.parent.opener.location.reload();
//window.location.href = "index_answer.php?wcad=<?// echo $wcad; ?>&wtid=<?// echo $wtid; ?>";
</script>
	<? }
	if($flag == "apptopic"){
$db->query("UPDATE  w_question SET s_id = '1' WHERE t_id = '$wtid'");
//สร้าง Rss
Gen_RSS($wcad);
?>
<script language="JavaScript">
window.location.href = "index_question.php?wcad=<? echo $wcad; ?>&t=<?php echo $_GET[t]?>&filename=<?php echo $_GET[filename];?>";
</script>
	<?
}
if($flag == "unapptopic"){
$db->query("UPDATE  w_question SET s_id = '0' WHERE t_id = '$wtid'");
//สร้าง Rss
Gen_RSS($wcad);
?>
<script language="JavaScript">
window.location.href = "index_question.php?wcad=<? echo $wcad; ?>&t=<?php echo $_GET[t]?>&filename=<?php echo $_GET[filename];?>";
</script>
	<?
}
if($flag == "appans"){
$db->query("UPDATE  w_answer SET s_id = '1' WHERE a_id = '$waid'");
?>
<script language="JavaScript">
window.location.href = "index_question.php?wcad=<? echo $wcad; ?>&t=<?php echo $_GET[t]?>&filename=<?php echo $_GET[filename];?>";
</script>
	<?
}
if($flag == "unappans"){
$db->query("UPDATE  w_answer SET s_id = '0' WHERE a_id = '$waid'");
?>
<script language="JavaScript">
window.location.href = "index_question.php?wcad=<? echo $wcad; ?>&t=<?php echo $_GET[t]?>&filename=<?php echo $_GET[filename];?>";
</script>
	<?
}
if($flag == "keyword"){
	if(!empty($_POST["txt_key"])){
	$db->query("UPDATE  w_question SET keyword = '".$_POST["txt_key"]."' WHERE t_id = '".$_POST["wtid"]."'");

?>
<script language="JavaScript">
alert("ได้กำหนด keyword เรียบร้อยแล้ว");
window.close();
</script>
	<?	}
	}
if($_POST["flag"]=='vote'){
$sql_insert = "INSERT INTO w_vote (a_id,vote_choice,vote_date,vote_ip) 
												VALUES ('".$_POST["a_id"]."','".$_POST["vote"]."',NOW(),'".$IPn."')";
$db->query($sql_insert);
?>
<script language="JavaScript">
alert("ทำการโหวตเรียบร้อยแล้ว");
window.location.href = "w_vote.php?a_id=<?php echo $_POST["a_id"];?>";
</script>
	<?
}
function Gen_RSS($cid){
global $db;
$sql="SELECT * FROM w_cate WHERE c_id='$cid'  ";
$query_rss=$db->query($sql);
$rss=$db->db_fetch_array($query_rss);

if($rss["c_rss"]=='Y'){

	$xml_text='<'.'?xml version="1.0" encoding="utf-8"?'.'>
	<rss version="2.0">
	<channel>
		  <title>'.$rss["c_name"].'</title> 
		  <link>http://'.getenv(HTTP_HOST).'/ewtadmin/ewt/'.$_SESSION["EWT_SUSER"].'/index_question.php?wcad='.$rss["c_id"].'</link> 
		  <description>Webboard</description> 
		  <language>th-TH</language> 
		  <lastBuildDate>'.date('D,d M Y H:i:s e').'</lastBuildDate> 
		  <copyright>Copyright ? 2007 All rights reserved. Bizpotential CO.,LTD.</copyright> 
	';
	$query_rss=$db->query("SELECT * FROM w_question WHERE c_id='$cid' and s_id ='1' ORDER BY c_id DESC ");
	while($rss1=$db->db_fetch_array($query_rss)){
	$answer_detail = CheckTag($rss1[t_detail]);
	$answer_detail = CheckSmile($answer_detail);
	$link = 'http://'.getenv(HTTP_HOST).'/ewtadmin/ewt/'.$_SESSION["EWT_SUSER"].'/index_answer.php?wcad='.$rss['c_id'].'&wtid='.$rss1['t_id'].'';
	$xml_text.='<item>
					<title>'.$rss1["t_name"].'</title>
					<link>http://'.getenv(HTTP_HOST).'/ewtadmin/ewt/'.$_SESSION["EWT_SUSER"].'/index_answer.php?wcad='.$rss["c_id"].'&amp;wtid='.$rss1['t_id'].'</link>
					<description>'.$answer_detail.'</description>
					<pubDate>'.$rss1["t_date"].$rss1["t_time"].'</pubDate>
					<guid>http://'.getenv(HTTP_HOST).'</guid>
	            </item>
				';
	}
	$xml_text.='</channel>
	</rss>
	';
	$fp=fopen("rss/webboard".$cid.".xml","w");
	fputs($fp,$xml_text);
	fclose($fp);
}
}
?>