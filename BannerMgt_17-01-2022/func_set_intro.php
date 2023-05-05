<?php
include("../lib/permission1.php");
include("../lib/include.php");
include("../lib/function.php");
include("../lib/user_config.php");
include("../lib/connect.php");
include("../lib/set_lang.php");




if($_GET['proc'] == 'UnSetIntro' ){

$s_update = "UPDATE `banner` SET  `banner_intro`  = '' ";
$db->query($s_update);

}


if($_GET['proc'] == 'SetIntro' ){

$s_video = $db->query("SELECT * FROM banner WHERE banner_intro = 'Y' ");
$a_row = $db->db_num_rows($s_video);   
$a_video = $db->db_fetch_array($s_video);

if($a_row > 0){
$s_update = "UPDATE `banner` SET  `banner_intro`  = '' ";
$db->query($s_update);
}
	
$s_update_i = "UPDATE `banner` SET  `banner_intro` = 'Y' WHERE banner_id = '{$_GET['id']}' ";
$db->query($s_update_i);

}


if($_GET['proc'] == 'DelArtVdo' ){
	
$nid = $_GET['nid'];

$s_article = $db->query("SELECT * FROM `article_list` WHERE `n_id` ='{$nid}' ");
$a_row = $db->db_num_rows($s_article);

$a_article = $db->db_fetch_array($s_article);
$address = "";	

if($a_article['n_address']){
$n_address = explode("###",$a_article['n_address']);
for($i = 0; $i < count($n_address); $i++ ){	
 
$article = explode("#@#",$n_address[$i]);

if($i == $_GET[id]){ 
$article[0] = '';
$article[1] = '';
}

if($article[0] != '' OR $article[1]){	

$address .= $article[0]."#@#".$article[1]."###";
}
	}
		}

$s_update = "UPDATE `article_list` SET  `n_address`  = '{$address}' WHERE n_id = '{$nid}' ";
$db->query($s_update);		
	
}

if($_GET['proc'] == 'DelArtImg' ){
	
$s_detail = $db->query("SELECT * FROM article_detail WHERE ad_id = '{$_GET[id]}' ");
$a_row = $db->db_num_rows($s_detail);   
$a_detail = $db->db_fetch_array($s_detail);	

$dir_file_old = "../ewt/".$_SESSION["EWT_SUSER"]."/images/article/news".$a_detail['nid']."/";
$ad_pic_b = $dir_file_old.$a_detail['ad_pic_b'];
$ad_pic_s = $dir_file_old.$a_detail['ad_pic_s'];

if(file_exists($ad_pic_b) && file_exists($ad_pic_s))
				{
				@unlink($ad_pic_b);
				@unlink($ad_pic_s);
				}
				
$s_update = "UPDATE article_detail SET ad_pic_s = '', ";
				
$s_update .= "ad_pic_b = '',ad_des = ''  WHERE article_detail.ad_id ='{$a_detail[ad_id]}' ";

$db->query($s_update);	
			
}
if($_GET['proc'] == 'DelArtVdo' ){

$s_video = $db->query("SELECT * FROM article_video WHERE av_id = '{$_GET[id]}' ");
$a_row = $db->db_num_rows($s_video);   
$a_video = $db->db_fetch_array($s_video);

if($a_video['av_filename'] != ""){
	
$av_filename = "../ewt/".$_SESSION["EWT_SUSER"]."/download/file_vdo/".$a_video['av_filename'];

if(file_exists($av_filename))
				{
				@unlink($av_filename);				
				}	
}

$s_delete = "DELETE FROM article_video WHERE av_id = '{$_GET[id]}'";						
$db->query($s_delete);
}



$db->db_close(); 	
?>	