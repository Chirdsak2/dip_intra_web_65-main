<?php
session_start();
include("../lib/permission1.php");
include("../lib/include.php");
include("../lib/function.php");
include("../lib/user_config.php");
include("../lib/connect.php");

if($_POST[flag] == "add"){
	/*print $_POST[name]; print "<br>";
	print $_POST[comment]; print "<br>";
	print $_POST[vote]; print "<br>";
	print $_POST[category_id]; print "<br>";
	print $_POST[img_id]; print "<br>";
	print $_POST[page_cat]; print "<br>";*/
	
	$sql_max_choice = "SELECT max(choice) as max_choice FROM gallery_comment WHERE category_id = '".$_POST[category_id]."' AND img_id = '".$_POST[img_id]."' ";
	$query_max_choice = $db->query($sql_max_choice);
	$rs_max_choice = $db->db_fetch_array($query_max_choice);
	$max_choice = $rs_max_choice[max_choice]+1;
	$sql =" INSERT INTO gallery_comment (category_id,img_id,choice,name,comment,vote,com_date,ip,email) VALUES ('".$_POST[category_id]."','".$_POST[img_id]."','".$max_choice."','".stripslashes(htmlspecialchars($_POST[name]))."','".stripslashes(htmlspecialchars(str_replace("\n","<br>",$_POST[comment])))."','".$_POST[vote]."',NOW(),'".$_SERVER['REMOTE_ADDR']."','')";
	$db->query($sql);
	
	$db->write_log("create","Gallery","แสดงความคิดเห็น ".stripslashes(htmlspecialchars($_POST[name])));
	
	/*$email=$_POST[email];
	$subject="Gallery"; 
	$from= $_POST[name]; 
	$link = "http://www.aaa".$_SERVER['PHP_SELF']."?category_id=".$_POST[category_id]."&img_id=".$_POST[img_id];
	$msg="Gallery<br>".$link;
	$header = "From:$from "; 
	//$header .= "Bcc: ".$bcc_email." "; 
	$header .= "Content-Type: text/html; charset='iso-620' "; 
	@mail($email,$subject,$msg,$header);*/

	print "<script>";
	print "alert('บันทึกความคิดเห็นแล้ว');";
	if($_POST[fn] == "gallery_view_img_comment2.php"){
	//print "window.opener.frm.submit();";
	}
	print "location.href = '".$_POST[fn]."?category_id=".$_POST[category_id]."&img_id=".$_POST[img_id]."&page_cat=".$_POST[page_cat]."'; ";
	print "</script>";
}
if($_GET[flag] == "del"){
	if($_GET[type] == "not_all") $sql_del = "DELETE FROM gallery_comment WHERE comment_id = '".$_GET[comment_id]."' ";
	elseif ($_GET[type] == "all") $sql_del = "DELETE FROM gallery_comment WHERE category_id = '".$_GET[category_id]."'  AND img_id = '".$_GET[img_id]."' ";
	$db->write_log("delete","Gallery","ลบข้อความคิดเห็น ".$_GET[comment_id]);
	if($sql_del) $db->query($sql_del);
	print "<script>";
	print "alert('ลบความคิดเห็นแล้ว');";
	//print "window.opener.frm.submit();";
	print "location.href = 'gallery_view_img_comment2.php?category_id=".$_GET[category_id]."&img_id=".$_GET[img_id]."'; ";
	print "</script>";
}
if($_GET[flag] == "vote"){

$sql = "update gallery_image set img_vote = img_vote+1 where img_id = '".$_GET[img_id]."'";
$db->query($sql);
$db->write_log("vote","Gallery","โหวตรูปภาพ ".$_GET[img_id]);
	print "<script>";
	print "alert('ขอบคุณที่ร่วมโหวตค่ะ');";
	//print "window.opener.frm.submit();";
	print "location.href = 'gallery_view_img_comment2.php?category_id=".$_GET[category_id]."&img_id=".$_GET[img_id]."'; ";
	print "</script>";
}
$db->db_close(); 
?>
