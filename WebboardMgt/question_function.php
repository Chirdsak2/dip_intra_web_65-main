<?php
include("administrator.php");
include("inc.php");
include("lib/include.php");
$Globals_Url_webb = "http://".getenv(HTTP_HOST)."/ewtadmin/ewt/pic";
$Globals_Dir = "../ewt/".$_SESSION["EWT_SUSER"]."/";
	######## ตรวจสอบคำหยาบ ##############
   /*$sql_vulgar = "SELECT *  FROM vulgar_table ";
   $query_vulgar  = mysql_query($sql_vulgar);
   $i=0;
   	while ($res_vulgar = mysql_fetch_array($query_vulgar)){
   		$vulgar[$i] = $res_vulgar[vulgar_text];		
		if(strstr($amsg,$vulgar[$i])){
			$chk_a = 1;
		}
	$i++;
	}
	if ($chk_a==1){print "<script>alert('ความคิดเห็นของคุณมีคำแปลกปลอม');window.location.href = 'index_answer.php?wcad=$wcad&wtid=$wtid'</script>";	exit;}
*/
function vulgar($text){
global $db;
$vulgar_text = array();
$sql_vulgar = "SELECT *  FROM vulgar_table ";
   $query_vulgar  = mysql_query($sql_vulgar);
   $i=0;
   	while ($res_vulgar = mysql_fetch_array($query_vulgar)){
		$pos = strpos($text, $res_vulgar [vulgar_text]);
		if (!($pos === false)) { // note: three equal signs
			print "<script>alert('ความคิดเห็นของคุณมีคำแปลกปลอม กรุณาตรวจ!!!!!!!!!');</script>";	exit;
		}
	}
}

	if(getenv(HTTP_X_FORWARDED_FOR)) 
	{
		$IPn = getenv(HTTP_X_FORWARDED_FOR);
	}	 
else 
	{
		$IPn = getenv("REMOTE_ADDR");
	}
	
	##แปลงfile
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
		$temp = eregi_replace ("([^[:space:]]*)@([^[:space:]]*)([[:alnum:]])","<a href=\"./mail2me/mail2me.php?wemail=\\1@\\2\\3&name=\\1@\\2\\3\" target=\"_blank\">\\1@\\2\\3</a>",$temp ) ;
		return ( $temp ) ;
	}
	
	function CheckSmile($temp){
		global $url;
		global $Globals_Url_webb;
		global $db;
		$text = array();
		$pic =array();
		$sql = "select * from emotion";
		$query = $db->query($sql);
		while($rec = $db->db_fetch_array($query)){
		array_push ($text, $rec[emotion_character]);
		array_push ($pic, $rec[emotion_img]);
		}
		/*$text = array(
		":sad:",":red:", ":big:", ":ent:", ":shy:", ":sleepy:", ":sun:", ":sg:", ":embarass:", 
		":dead:", ":cool:", ":clown:", ":pukey:", ":eek:", ":roll:", ":smoke:", ":angry:", ":confused:", ":cry:", 
		":lol:", ":yawn:", ":devil:", ":tongue:", ":alien:",":tasty:",":crazy:",":agree:",":disagree:",":bawling:", 
		":crap:",":crying1:",":dunce:",":error:",":evil:",":lookaroundb:",":laugh:",":pimp:",":spiny:",":wavey:",":smash:",":angry:",
		":brain:",":phone:",":zip:",":download:",":beer:",":censore:",":nolove:",":cranium:");

		$pic =array(
		"frown.gif","redface.gif","biggrin.gif","blue.gif","shy.gif","sleepy.gif","sunglasses.gif", "supergrin.gif","embarass.gif",
		"dead.gif","cool.gif","clown.gif","pukey.gif","eek.gif","sarcblink.gif","smokin.gif","reallymad.gif","confused.gif","crying.gif",
		"lol.gif","yawn.gif","devil.gif","tongue.gif","aysmile.gif","tasty.gif","grazy.gif","agree.gif","disagree.gif","bawling.gif",
		"crap.gif","crying1.gif","dunce.gif","error.gif","evil.gif","lookaroundb.gif","laugh.gif","pimp.gif","spiny.gif","wavey.gif","smash.gif","angry.gif",
		"brain.gif","phone.gif","zip.gif","download.gif","beer.gif","censore.gif","nolove.gif","cranium.gif");
			*/
		for ($i=0 ; $i<sizeof($text) ; $i++) {
			$temp = eregi_replace($text[$i],"<img src=\"$pic[$i]\">",$temp);
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

$chk_config = $db->query("SELECT * FROM w_config WHERE c_config = '1'");
$CO = mysql_fetch_array($chk_config);	

if($flag =="question"){
	
	//check vulgar
	vulgar(addslashes(htmlspecialchars($aque)));
	vulgar(addslashes(htmlspecialchars($amsg)));
	vulgar(addslashes(htmlspecialchars($aname)));
	//check vulgar
	if($file_size > 0 && $file_size> ($CO[c_sizeupload]*1024) ){
	?>
		<script language="javascript">
			alert("ขนาดไฟล์ของท่านใหญ่เกิน<?php echo $CO[c_sizeupload];?> KB. กรุณาเลือกไฟล์ใหม่อีกครั้ง");
		//self.location.href="add_survey1.php";
		</script>
		<?php
			exit;
	}
if($file_size > 0 ){
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
			window.location.href = "index_question.php?wcad=<?php echo $wcad; ?>";
			</script>
				<?php
				exit;
	}

	
@copy($file,$Globals_Dir.'userpic/'.$picname);
}else{
$picname = "";
}
	$t_topic = addslashes(htmlspecialchars($aque));
	$t_detail = addslashes(htmlspecialchars($amsg));
	$t_detail = eregi_replace(chr(13)," <br> ", $t_detail );
	$t_detail = CheckTag($t_detail);
	$t_detail = CheckSmile($t_detail);
	
$Execsql = $db->query("INSERT INTO `w_question` ( `t_id` , `c_id` , `t_name` , `t_detail` , `t_date` , `t_time` , `t_picture` , `t_count` , `t_ip` , `s_id` , `q_name` , `q_email`,`keyword` ) VALUES ('', '$wcad', '$t_topic', '$t_detail', NOW( ) , NOW( ) , '', '0', '$IPn', '1', '$aname', '$aemail','$img_name')");
$db->write_log("create","webboard","สร้างหัวข้อกระทู้   ".$t_topic);

//multi search function
if($search_center == "Y"){  
	$query_max=$db->query("SELECT MAX(t_id) as maxid  FROM  w_question ");
	$data_max=$db->db_fetch_array($query_max);
	$max_wb_id=$data_max[maxid];

	$db->ms_module='W'; 
	$db->ms_link_id=$max_wb_id;
	$db->multi_search_update();
}

//สร้าง Rss
Gen_RSS($wcad);
?>
<script language="JavaScript">
self.parent.location.href = "index_question.php?wcad=<?php echo $wcad; ?>";
</script>
	<?php }
if($flag =="answer"){
//check vulgar
	vulgar(addslashes(htmlspecialchars($amsg)));
	vulgar(addslashes(htmlspecialchars($aname)));
	if($file_size > 0 && $file_size> ($CO[c_sizeupload]*1024) ){
	?>
		<script language="javascript">
			alert("ขนาดไฟล์ของท่านใหญ่เกิน<?php echo $CO[c_sizeupload];?> KB. กรุณาเลือกไฟล์ใหม่อีกครั้ง");
		//self.location.href="add_survey1.php";
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
			///window.location.href = "index_answer.php?wcad=<?php// echo $wcad; ?>&wtid=<?php// echo $wtid; ?>";
			</script>
				<?php
				exit;
		}
	
@copy($file,$Globals_Dir.'userpic/'.$picname);
}else{
$picname = "";
}
	$a_detail = addslashes(htmlspecialchars($amsg));
	$a_detail = eregi_replace(chr(13)," <br> ", $a_detail );
	$a_detail = CheckTag($a_detail);
	$a_detail = CheckSmile($a_detail);
$aname = $aname;
$aemail = $aemail;

$Execsql = $db->query("INSERT INTO `w_answer` ( `a_id` , `t_id` , `a_detail` , `a_date` , `a_time` , `a_ip` , `a_picture` , `s_id` , `a_name` , `a_email`, `a_attact`) VALUES ( '', '$wtid', '$a_detail', NOW( ) , NOW( ) , '$IPn', '', '1', '$aname', '$aemail','$img_name')");
$db->write_log("create","webboard","สร้างกระทู้คำตอบ  ".$a_detail);
//multi search function
if($search_center == "Y"){   
	$db->ms_module='W'; 
	$db->ms_link_id=$wtid;
	$db->multi_search_update();
}
?>
<script language="JavaScript">
self.parent.location.href = "index_answer.php?wcad=<?php echo $wcad; ?>&wtid=<?php echo $wtid; ?>";
</script>
	<?php }
if($flag == "deltopic"){
$query_rec=$db->query("select * from w_question WHERE t_id = '$wtid'");
$rec = $db->db_fetch_array($query_rec);
$db->write_log("delete","webboard","ลบหัวข้อกระทู้   ".$rec[t_name]);
$db->query("DELETE FROM w_question WHERE t_id = '$wtid'");
$query_del=$db->query("select * from w_answer WHERE t_id = '$wtid'");
while($rec2 = $db->db_fetch_array($query_del)){
$db->query("DELETE FROM w_vote WHERE a_id = '$rec2[a_id]'");
}
$db->query("DELETE FROM w_answer WHERE t_id = '$wtid'");
//multi search function
if($search_center == "Y"){   
	$db->ms_module='W';
	$db->ms_link_id=$wtid;
	$db->multi_search_delete();
}
//สร้าง Rss
Gen_RSS($wcad);
?>
<script language="JavaScript">
window.location.href = "index_question.php?wcad=<?php echo $wcad; ?>";
</script>
	<?php
}
if($flag == "apptopic"){
$query_app=$db->query("select * from w_question WHERE t_id = '$wtid'");
$rec = $db->db_fetch_array($query_app);
$db->write_log("approve","webboard","อนุมัติหัวข้อกระทู้   ".$rec[t_name]);

$db->query("UPDATE  w_question SET s_id = '1' WHERE t_id = '$wtid'");

//multi search function
if($search_center == "Y"){   
	$db->ms_module='W'; 
	$db->ms_link_id=$wtid;
	$db->multi_search_update();
}

//สร้าง Rss
Gen_RSS($wcad);
?>
<script language="JavaScript">
window.location.href = "index_question.php?wcad=<?php echo $wcad; ?>";
</script>
	<?php
}
if($flag == "unapptopic"){
$query_unapp=$db->query("select * from w_question WHERE t_id = '$wtid'");
$rec = $db->db_fetch_array($query_unapp);
$db->write_log("approve","webboard","ยกเลิกการอนุมัติหัวข้อกระทู้   ".$rec[t_name]);
$db->query("UPDATE  w_question SET s_id = '0' WHERE t_id = '$wtid'");

//multi search function
if($search_center == "Y"){   
	$db->ms_module='W'; 
	$db->ms_link_id=$wtid;
	$db->multi_search_delete();
}
//สร้าง Rss
Gen_RSS($wcad);
?>
<script language="JavaScript">
window.location.href = "index_question.php?wcad=<?php echo $wcad; ?>";
</script>
	<?php
}
if($flag == "delans"){
$query_del=$db->query("select * from w_answer WHERE a_id = '$waid'");
$rec = $db->db_fetch_array($query_del);
$db->write_log("delete","webboard","ลบคำตอบกระทู้   ".$rec[a_detail]);
$db->query("DELETE FROM w_vote WHERE a_id = '$waid'");
$db->query("DELETE FROM w_answer WHERE a_id = '$waid'");

//multi search function
if($search_center == "Y"){   
	$db->ms_module='W';
	$db->ms_link_id=$wtid;
	$db->multi_search_update();
}
?>
<script language="JavaScript">
window.location.href = "index_answer.php?wcad=<?php echo $wcad; ?>&wtid=<?php echo $wtid; ?>";
</script>
	<?php
}
if($flag == "sendfaq"){
//$fid = explode('-',$fid);
$search = array ("'<script[^>]*?>.*?</script>'si",  // Strip out javascript
                 "'<[\/\!]*?[^<>]*?>'si",           // Strip out html tags
                 "'([\r\n])[\s]+'",                 // Strip out white space
                 "'&(quot|#34);'i",                 // Replace html entities
                 "'&(amp|#38);'i",
                 "'&(lt|#60);'i",
                 "'&(gt|#62);'i",
                 "'&(nbsp|#160);'i",
                 "'&(iexcl|#161);'i",
                 "'&(cent|#162);'i",
                 "'&(pound|#163);'i",
                 "'&(copy|#169);'i",
                 "'&#(\d+);'e");                    // evaluate as php

$replace = array ("",
                  "",
                  "\\1",
                  "\"",
                  "&",
                  "<",
                  ">",
                  " ",
                  chr(161),
                  chr(162),
                  chr(163),
                  chr(169),
                  "chr(\\1)");
$db->query("INSERT INTO faq (fa_id,f_id,fa_name,fa_detail,fa_ans,f_sub_id,faq_use,faq_date) VALUES ('','$fid','".preg_replace ($search, $replace, $fname)."','".preg_replace ($search, $replace, $fdetail)."','".preg_replace ($search, $replace, $fans)."','$fid','Y',NOW())");

//multi search function
if($search_center == "Y"){  
	$query_max=$db->query("SELECT MAX(fa_id) as maxid  FROM  faq ");
	$data_max=$db->db_fetch_array($query_max);
	$max_faq_id=$data_max[maxid];

	$db->ms_module='F'; 
	$db->ms_link_id=$max_faq_id;
	$db->multi_search_update();
}

$db->write_log("sendfaq","webboard","ส่งข้อมูลกระทู้คำถาม    ".$fname ."   ไป FAQ");
?>
<script language="JavaScript">
	alert("ส่งข้อมูลไปยัง FAQ เรียบร้อยแล้ว");
window.location.href = "index_answer.php?wcad=<?php echo $wcad; ?>&wtid=<?php echo $wtid; ?>";
</script>
	<?php
}
if($flag == "appans"){
$query_app=$db->query("select * from w_answer WHERE a_id = '$waid'");
$rec = $db->db_fetch_array($query_app);
$db->write_log("approve","webboard","อนุมัติคำตอบ   ".$rec[a_detail]);
$db->query("UPDATE w_answer SET s_id = '1' WHERE a_id = '$waid'");
//multi search function
if($search_center == "Y"){   
	$db->ms_module='W'; 
	$db->ms_link_id=$wtid;
	$db->multi_search_update();
}
?>
<script language="JavaScript">
window.location.href = "index_answer.php?wcad=<?php echo $wcad; ?>&wtid=<?php echo $wtid; ?>";
</script>
	<?php
}
if($flag == "unappans"){
$db->query("UPDATE w_answer SET s_id = '0' WHERE a_id = '$waid'");
$query_unapp=$db->query("select * from w_answer WHERE a_id = '$waid'");
$rec = $db->db_fetch_array($query_unapp);
$db->write_log("approve","webboard","ยกเลิกการอนุมัติคำตอบ   ".$rec[a_detail]);

//multi search function
if($search_center == "Y"){   
	$db->ms_module='W'; 
	$db->ms_link_id=$wtid;
	$db->multi_search_update();
}

?>
<script language="JavaScript">
window.location.href = "index_answer.php?wcad=<?php echo $wcad; ?>&wtid=<?php echo $wtid; ?>";
</script>
	<?php
}
if($flag == "category"){
		$t_topic = addslashes(htmlspecialchars($t_topic));
	$t_detail = addslashes(htmlspecialchars($t_detail));
	$t_detail = eregi_replace(chr(13)," <br> ", $t_detail );
$db->query("INSERT INTO `w_cate` ( `c_id` , `c_name` , `c_detail`, `c_use` , `c_view` , `c_question` , `c_answer` , `c_view_porf`) VALUES ('', '$t_topic', '$t_detail','Y','$c_view','$c_question','$c_answer','$c_download')");
$db->write_log("create","webboard","สร้างหมวดหมู่กระทู้ชื่อ   ".$t_topic);
?>
<script language="JavaScript">
window.location.href = "index_cate.php";
</script>
	<?php
}
if($flag == "change"){
		$t_topic = stripslashes(htmlspecialchars($t_topic,ENT_QUOTES));
	$t_detail = stripslashes(htmlspecialchars($t_detail,ENT_QUOTES));
	$t_detail = eregi_replace(chr(13)," <br> ", $t_detail );
	$Execsql = $db->query("UPDATE w_cate SET c_name= '$t_topic',
																		c_detail = '$t_detail',
																		c_view = '$c_view' ,
																		c_question = '$c_question' ,
																		c_answer = '$c_answer',
																		 c_view_porf = '$c_download'
																		 WHERE c_id = '$wcad'");
$db->write_log("update","webboard","แก้ไขหมวดกระทู้  ".$t_topic);
//สร้าง Rss
Gen_RSS($wcad);
?>
<script language="JavaScript">
	alert("แก้ไขข้อมูลเรียบร้อยแล้ว");
window.location.href = "index_cate.php";
</script>
<?php
exit;
}
if($flag == "dropcate"){
if($_GET["c_use"] == 'Y'){
$c_use ='N';
$status = "    จากแสดง เป็น ซ่อน";
}else{
$c_use ='Y';
$status = "    จากซ่อน เป็นแสดง ";
}
$db->query("UPDATE `w_cate` SET c_use = '$c_use' WHERE c_id = '".$_GET["wcad"]."'");
$db->write_log("view","webboard","เปลี่ยนสถานะหมวดกระทู้  ".$_GET["c_name"].$status);
?>
<script language="JavaScript">
window.location.href = "index_cate.php";
</script>
	<?php
}
if($flag == "SetRSS"){
$db->query("Update w_cate SET c_rss=NULL where c_use = 'Y'");
for($i=0;$i<$_POST["alli"];$i++){
		$chk = $_POST["chk_rss".$i];
		$nid = $_POST["chkrssH".$i];
		if($chk != ""){
			$db->query("Update w_cate SET c_rss='Y' WHERE c_id = '$chk'");
			Gen_RSS($chk);
			$db->write_log("rss","webboard","สร้าง rss ของหมวดหมู่   ".$_POST["chkrssD".$i]);
		}else{
			$db->query("Update w_cate SET c_rss=NULL WHERE c_id = '$nid'");
			$filename = "../ewt/".$_SESSION["EWT_SUSER"]."/rss/webboard".$nid.".xml";
			if(file_exists($filename)){
               unlink($filename);
			}
		}
	
	}
?>
<script language="JavaScript">
window.location.href = "index_cate.php";
</script>
	<?php
}
if($flag == "delcate"){
$db->query("DELETE FROM `w_cate`  WHERE c_id = '$wcad'");

//multi search function
if($search_center == "Y"){   
		$query_sm=$db->query("SELECT * FROM `w_question`  WHERE c_id = '$wcad'");
		while($rec0 = $db->db_fetch_array($query_sm)){
			$db->ms_module='W'; 
			$db->ms_link_id=$rec0[t_id];
			$db->multi_search_delete();
		}
}

$db->query("DELETE FROM `w_question`  WHERE c_id = '$wcad'");
$qquery=$db->query("select * from w_answer WHERE t_id = '$wtid'");
while($rec2 = $db->db_fetch_array($qquery)){
	$db->query("DELETE FROM w_vote WHERE a_id = '$rec2[a_id]'");
	$db->query("DELETE FROM w_answer WHERE a_id = '$rec2[a_id]'");
}

$db->write_log("delete","webboard","ลบหมวดหมู่กระทู้ชื่อ   ".$_GET["c_name"]);
?>
<script language="JavaScript">
window.location.href = "index_cate.php";
</script>
	<?php
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
	$fp=fopen("../ewt/".$_SESSION["EWT_SUSER"]."/rss/webboard".$cid.".xml","w");
	fputs($fp,$xml_text);
	fclose($fp);
}
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
	<?php
}
if($_POST["flag"]=='set_level'){
for($i=0;$i<count($_POST[webb_id]);$i++){
		$sql_edit = "UPDATE w_cate SET c_level='".$_POST[webb_pos][$i]."'  WHERE c_id = '".$_POST[webb_id][$i]."' ";
		$db->query($sql_edit);
		    $query_rec=$db->query("select * from w_cate WHERE c_id = '".$_POST[webb_id][$i]."' ");
			$rec=$db->db_fetch_array($query_rec);
			$db->write_log("update","webboard","ตั้งค่าลำดับ".$rec[c_name]);
	}

?>
<script language="JavaScript">
alert("ตั้งค่าเรียบร้อยแล้ว");
window.location.href = "index_cate.php";
</script>
	<?php
}
?>
<?php @$db->db_close(); ?>