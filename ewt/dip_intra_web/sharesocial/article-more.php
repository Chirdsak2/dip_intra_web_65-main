<?php
if(SYS_LANG){
if(SYS_LANG != 'TH'){
	$s_group = $db->query("SELECT * FROM  article_group,lang_article_group,lang_config
						  WHERE lang_article_group.c_id = article_group.c_id
						  AND lang_config.lang_config_id = lang_article_group.lang_name
						  AND lang_config.lang_config_suffix = '".SYS_LANG."'
						  AND article_group.c_id = '{$a_id}'
						  AND lang_article_group.lang_field = 'c_name'");

}else{
	$s_group = $db->query("SELECT * FROM  article_group WHERE c_id = '{$a_id}' ");
}
}ELSE{
	$s_group = $db->query("SELECT * FROM  article_group WHERE c_id = '{$a_id}' ");

}
$a_data = $db->db_fetch_array($s_group);

if(SYS_LANG != 'TH'){
	$a_data['c_name'] = $a_data['lang_detail'];

}

$img = "img/default-article.jpg";

$share_img = $img;  

$a_title       = $a_data['c_name'];
$a_description = showWord(strip_tags($a_data['c_name']),'500');
$a_pathimage   = $share_img;	
$a_keyword     = showWord($a_data['c_name'],'100');
?>