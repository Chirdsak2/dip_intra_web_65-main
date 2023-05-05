<?php
session_start();
include("lib/function.php");
include("lib/user_config.php");
include("lib/connect.php");
$lang_sh1 = explode('___',$_REQUEST[filename]);
			if($lang_sh1[1] != ''){
				$lang_shw = $lang_sh1[1];
				$lang_sh = '_'.$lang_sh1[1];
				
			}else{
				$lang_sh ='';
				$lang_shw='';
			}
	include("language/language".$lang_sh.".php");
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
	$sql =" INSERT INTO gallery_comment (category_id,img_id,choice,name,comment,vote,com_date,ip,email) VALUES ('".$_POST[category_id]."','".$_POST[img_id]."','".$max_choice."','".stripslashes(htmlspecialchars($_POST[name]))."','".stripslashes(htmlspecialchars(str_replace("\n","<br>",$_POST[comment])))."','".$_POST[vote]."',NOW(),'".$_SERVER['REMOTE_ADDR']."','".stripslashes(htmlspecialchars($_POST[email]))."')";
	$db->query($sql);
	
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
	print "alert('".$text_GenGallery_add."');";
	if($_POST[fn] == "gallery_view_img_comment2.php"){
	print "window.opener.frm.submit();";
	}
	print "location.href = 'gallery_process_comment_back.php?category_id=".$_POST[category_id]."&img_id=".$_POST[img_id]."&filename=".$_POST[filename]."&page_cat=".$_POST[page_cat]."'; ";
	//print "history.go(-1)";
	print "</script>";
}
if($_GET[flag] == "del"){
	if($_GET[type] == "not_all") $sql_del = "DELETE FROM gallery_comment WHERE comment_id = '".$_GET[comment_id]."' ";
	elseif ($_GET[type] == "all") $sql_del = "DELETE FROM gallery_comment WHERE category_id = '".$_GET[category_id]."'  AND img_id = '".$_GET[img_id]."' ";
	
	if($sql_del) $db->query($sql_del);
	print "<script>";
	print "alert('".$text_GenGallery_del."');";
	//print "window.opener.frm.submit();";
	print "location.href = 'gallery_process_comment_back.php?category_id=".$_GET[category_id]."&img_id=".$_GET[img_id]."'; ";
	//print "history.go(-1)";
	print "</script>";
}
if($_GET[flag] == "vote"){

$sql = "update gallery_image set img_vote = img_vote+1 where img_id = '".$_GET[img_id]."'";
$db->query($sql);
	print "<script>";
	print "alert('".$text_GenGallery_add2."');";
	//print "window.opener.frm.submit();";
	print "location.href = 'gallery_process_comment_back.php?category_id=".$_GET[category_id]."&filename=".$_GET[filename]."&img_id=".$_GET[img_id]."'; ";
	//print "history.go(-1)";
	print "</script>";
}
$db->db_close(); 
?>
