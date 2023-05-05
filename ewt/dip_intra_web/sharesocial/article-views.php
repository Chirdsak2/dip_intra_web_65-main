<?php
if(SYS_LANG){
if(SYS_LANG != 'TH'){
$s_article = $db->query("SELECT *,article_list.c_id AS CID
FROM article_list,lang_article_list,lang_config
WHERE article_list.n_id = lang_article_list.c_id
AND lang_config.lang_config_id = lang_article_list.lang_name
AND lang_config.lang_config_suffix = '".SYS_LANG."'
AND lang_article_list.lang_field = 'n_topic'
AND n_id = '{$a_id}' 
AND n_approve = 'Y' ");

}else{
	$s_article = $db->query("SELECT * FROM article_list WHERE n_id = '{$a_id}' AND n_approve = 'Y' ");

}
}ELSE{
	$s_article = $db->query("SELECT * FROM article_list WHERE n_id = '{$a_id}' AND n_approve = 'Y' ");

}
$a_data = $db->db_fetch_array($s_article);

if(SYS_LANG != 'TH'){
$a_data['n_topic'] = $a_data['lang_detail'];

}
if(!empty($a_data['picture'])){
	if(file_exists("images/article/news".nidshare($a_data['n_id'])."/".$a_data['picture'])){
		$img = "images/article/news".nidshare($a_data['n_id'])."/".$a_data['picture'];
		}else{
			$img = "img/default-article.jpg";
		}
	}else{
		$img = "img/default-article.jpg";
	}
$share_img = share_face($a_id).$img;  

$a_title       = $a_data['n_topic'];
$a_description = showWord(strip_tags(article_detail($a_id,$temp,'','11','1')),'500');
$a_pathimage   = $share_img;	
$a_keyword     = showWord($a_data['n_topic'],'100')." , ".showWord(strip_tags(article_detail($a_id,$temp,'','11','1')),'100');
?>