<?php
$path = '../';
session_start();
include($path."lib/function.php");
include($path."lib/user_config.php");
include($path."lib/connect.php");
$lang_sh1 = explode('___',$_REQUEST[filename]);
			if($lang_sh1[1] != ''){
				$lang_shw = $lang_sh1[1];
				$lang_sh = '_'.$lang_sh1[1];
				
			}else{
				$lang_sh ='';
				$lang_shw='';
			}
	include("../language/language".$lang_sh.".php");
if($_POST[flag] == "add"){
	
	$sql_max_choice = "SELECT max(choice) as max_choice FROM gallery_comment WHERE category_id = '".$_POST[category_id]."' AND img_id = '".$_POST[img_id]."' ";
	$query_max_choice = $db->query($sql_max_choice);
	$rs_max_choice = $db->db_fetch_array($query_max_choice);
	$max_choice = $rs_max_choice[max_choice]+1;
	$sql =" INSERT INTO gallery_comment (category_id,img_id,choice,name,comment,vote,com_date,ip,email) VALUES ('".$_POST[category_id]."','".$_POST[img_id]."','".$max_choice."','".stripslashes(htmlspecialchars($_POST[name]))."','".stripslashes(htmlspecialchars(str_replace("\n","<br>",$_POST[comment])))."','".$_POST[vote]."',NOW(),'".$_SERVER['REMOTE_ADDR']."','".stripslashes(htmlspecialchars($_POST[email]))."')";
	$db->query($sql);
	
	print "<script language=\"javascript\" type=\"text/javascript\">";
	print "alert('".$text_GenGallery_add."');";
	
	print "location.href = 'gallery_process_comment_back.php?category_id=".$_POST[category_id]."&img_id=".$_POST[img_id]."&filename=".$_POST[filename]."&page_cat=".$_POST[page_cat]."'; ";
	
	print "</script>";
}
if($_GET[flag] == "del"){
	if($_GET[type] == "not_all") $sql_del = "DELETE FROM gallery_comment WHERE comment_id = '".$_GET[comment_id]."' ";
	elseif ($_GET[type] == "all") $sql_del = "DELETE FROM gallery_comment WHERE category_id = '".$_GET[category_id]."'  AND img_id = '".$_GET[img_id]."' ";
	
	if($sql_del) $db->query($sql_del);
	print "<script language=\"javascript\" type=\"text/javascript\">";
	print "alert('".$text_GenGallery_del."');";
	print "location.href = 'gallery_process_comment_back.php?category_id=".$_GET[category_id]."&img_id=".$_GET[img_id]."'; ";

	print "</script>";
}
if($_GET[flag] == "vote"){

$sql = "update gallery_image set img_vote = img_vote+1 where img_id = '".$_GET[img_id]."'";
$db->query($sql);
	print "<script language=\"javascript\" type=\"text/javascript\">";
	print "alert('".$text_GenGallery_add2."');";
	print "location.href = 'gallery_process_comment_back.php?category_id=".$_GET[category_id]."&filename=".$_GET[filename]."&img_id=".$_GET[img_id]."'; ";
	print "</script>";
}
$db->db_close(); 
?>
