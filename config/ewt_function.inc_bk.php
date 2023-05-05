<?php
function cal_contact($gen_user){
	global $db,$EWT_DB_NAME,$EWT_DB_USER;

	$db->query("USE ".$EWT_DB_USER);
	$s_gen_user = $db->query("SELECT * FROM gen_user WHERE gen_user_id = '{$gen_user}' ");
	$a_row = $db->db_num_rows($s_gen_user);
	if($a_row){
	$a_user = $db->db_fetch_array($s_gen_user);

	$txt = $a_user['name_thai']." ".$a_user['surname_thai']."<br>";

	return $txt;
	}
$db->query("USE ".$EWT_DB_NAME);
	}

function sitetitle(){
	global $db,$EWT_DB_NAME;

	$db->query("USE ".$EWT_DB_NAME);
	$s_user_info = $db->query("SELECT * FROM site_info WHERE site_info_id = '1' ");
	$a_row = $db->db_num_rows($s_user_info);
	if($a_row){
	$a_user = $db->db_fetch_array($s_user_info);

	$txt =$a_user['site_info_title'];

	return $txt;

	}
}

function genlen($data,$op){
	$s = explode($op,$data);
	return count($s);
}

function tochild($cid){
			 global $db;
			 global $glo_sql;
				$sqlc = $db->query("SELECT c_id FROM article_group WHERE c_parent = '{$cid}' ");
				while($cr = $db->db_fetch_row($sqlc)){
					$glo_sql .= " OR article_list.c_id = '{$cr[0]}' ";
					tochild($cr[0]);
				}
			 }

function tomultigroup($cid){
			 global $db;
			 global $glo_sql;
				$sqlc = $db->query("SELECT multi_cid FROM article_multigroup WHERE c_id = '{$cid}' ");
				while($cr = $db->db_fetch_row($sqlc)){
					$glo_sql .= " OR c_id = '{$cr[0]}' ";
				}
 }

function banner($bid,$temp,$title){
	global $db;

$txt = "";

$date_now = (date("Y")+543).'-'.date('m-d H:i:s');

$wh = "AND ((banner_show_start = '' AND banner_show_end = '')";
$wh .= "OR ('{$date_now}' between banner_show_start AND banner_show_end))";

if($temp == '1'){

$txt .="";
$txt .="<div class=\"container-fluid banner-slide\">".PHP_EOL;
$txt .="<div class=\"owl-carousel owl-theme\">".PHP_EOL;

$sql_banner = "SELECT * FROM banner WHERE  banner_gid = '{$bid}' {$wh} ORDER BY banner_position ASC";
$rs = $db->query($sql_banner);
while($a_banner = $db->db_fetch_array($rs)){
if(strstr($a_banner['banner_link'],'ewt_news.php')){
$Ex = explode("ewt_news.php",$a_banner['banner_link']);
$a_banner['banner_link'] = "news_view.php".$Ex[1];

}else{

	$a_banner['banner_link'] = $a_banner['banner_link'];
}
if($a_banner['banner_link'] =="#"){
$banner_ahref= "";
$banner_a= "";

}else if($a_banner['banner_link']==""){
$banner_ahref= "";
$banner_a= "";
}else{

$banner_ahref="<a href=\"".$a_banner['banner_link']."\" target=\"".$a_banner['banner_traget']."\" onclick=\"ajax_save_log('banner_ajax_log.php?banner_id=".$a_banner['banner_id'].")\">";
$banner_a= "</a>";
}

$txt .="<div class=\"item\">".PHP_EOL;
$txt .=$banner_ahref;
$txt .="<img src=\"".$a_banner['banner_pic']."\" class=\"img-responsive\" alt=\"".$a_banner['banner_name']."\" title=\"".$a_banner['banner_name']."\" />";
$txt .=$banner_a;
$txt .="</div>".PHP_EOL;

 }

$txt .="</div>".PHP_EOL;
$txt .="</div>".PHP_EOL;

} else if($temp == '2'){

$txt .="<div class=\"col-xs-12 col-md-6\">".PHP_EOL;
$txt .="<h2 class=\"news-head\"><span class=\"switching\" >".$title."</span> <i class=\"fa fa-file-text\" aria-hidden=\"true\"></i></h2>".PHP_EOL;
$txt .="<h3 hidden>hidden</h3>";
$txt .="<div class=\"row\">".PHP_EOL;

$sql_banner = "SELECT * FROM banner  WHERE  banner_gid = '{$bid}' {$wh} ORDER BY banner_position ASC";
$rs = $db->query($sql_banner);
while($a_banner = $db->db_fetch_array($rs)){

if(strstr($a_banner['banner_link'],'ewt_news.php')){
$Ex = explode("ewt_news.php",$a_banner['banner_link']);
$a_banner['banner_link'] = "news_view.php".$Ex[1];

}else{

	$a_banner['banner_link'] = $a_banner['banner_link'];
}


if($a_banner['banner_link'] == "#"){
$banner_ahref= "<a>";
$banner_a= "</a>";

}else if($a_banner['banner_link']==""){
$banner_ahref= "<a>";
$banner_a= "</a>";
}else{

$banner_ahref="<a href=\"".$a_banner['banner_link']."\" target=\"".$a_banner['banner_traget']."\" onclick=\"ajax_save_log('banner_ajax_log.php?banner_id=".$a_banner['banner_id'].")\">";
$banner_a= "</a>";
}

$txt .="<div class=\"col-xs-6 col-sm-4\" align=\"center\">".PHP_EOL;
$txt .="<div class=\"square-icon\">".PHP_EOL;
$txt .=$banner_ahref;
$txt .="<div class=\"icon-img\">".PHP_EOL;
$txt .="<img src=\"".$a_banner['banner_pic']."\" alt=\"".$a_banner['banner_name']."\" title=\"".$a_banner['banner_name']."\" />	";
$txt .="</div>".PHP_EOL;
$txt .="<div>".PHP_EOL;
$txt .="<h4>".PHP_EOL;
$txt .="<span class=\"switching\">".PHP_EOL;
$txt .=$a_banner['banner_name'];
$txt .="</span>".PHP_EOL;
$txt .="</h4>".PHP_EOL;
$txt .="</div>".PHP_EOL;
$txt .=$banner_a;
$txt .="</div>".PHP_EOL;
$txt .="</div>".PHP_EOL;
 }
$txt .="</div>".PHP_EOL;
$txt .="</div>".PHP_EOL;


} else if($temp == '3'){

$txt .="<section>".PHP_EOL;
$txt .="<div class=\"owl-carousel owl-theme\" id=\"swipe\">".PHP_EOL;
$s_banner = $db->query("SELECT * FROM banner  WHERE  banner_gid = '{$bid}' {$wh} ORDER BY banner_position ASC");
while($a_banner = $db->db_fetch_array($s_banner)){

if(strstr($a_banner['banner_link'],'ewt_news.php')){
$Ex = explode("ewt_news.php",$a_banner['banner_link']);
$a_banner['banner_link'] = "news_view.php".$Ex[1];

}else{

	$a_banner['banner_link'] = $a_banner['banner_link'];
}


if($a_banner['banner_link'] == "#"){
$banner_ahref= "<a>";
$banner_a= "</a>";

}else if($a_banner['banner_link']==""){
$banner_ahref= "<a>";
$banner_a= "</a>";
}else{

$banner_ahref="<a href=\"".$a_banner['banner_link']."\" target=\"".$a_banner['banner_traget']."\" onclick=\"ajax_save_log('banner_ajax_log.php?banner_id=".$a_banner['banner_id'].")\">";
$banner_a= "</a>";
}
$txt .="<div class=\"item\">".PHP_EOL;
$txt .=$banner_ahref;
$txt .="<img class=\"d-block w-100\" src=\"".$a_banner['banner_pic']."\" alt=\"".$a_banner['banner_name']."\" title=\"".$a_banner['banner_name']."\" />	";
$txt .=$banner_a;
$txt .="</div>".PHP_EOL;

}
$txt .="</div>".PHP_EOL;
$txt .="</section>".PHP_EOL;

} else if($temp == '4'){


$txt .="<section class=\"pt-4 pb-4\" style=\"background-color: #fff;\">".PHP_EOL;
$txt .="<div class=\"container\">".PHP_EOL;

$txt .="<div class=\"owl-carousel owl-theme\" id=\"link-banner\">".PHP_EOL;
$s_banner = $db->query("SELECT * FROM banner  WHERE  banner_gid = '{$bid}' {$wh} ORDER BY banner_position ASC");
while($a_banner = $db->db_fetch_array($s_banner)){

if(strstr($a_banner['banner_link'],'ewt_news.php')){
$Ex = explode("ewt_news.php",$a_banner['banner_link']);
$a_banner['banner_link'] = "news_view.php".$Ex[1];

}else{

	$a_banner['banner_link'] = $a_banner['banner_link'];
}


if($a_banner['banner_link'] == "#"){
$banner_ahref= "<a>";
$banner_a= "</a>";

}else if($a_banner['banner_link']==""){
$banner_ahref= "<a>";
$banner_a= "</a>";
}else{

$banner_ahref="<a href=\"".$a_banner['banner_link']."\" target=\"".$a_banner['banner_traget']."\" onclick=\"ajax_save_log('banner_ajax_log.php?banner_id=".$a_banner['banner_id'].")\">";
$banner_a= "</a>";
}
$txt .=$banner_ahref;
$txt .="<div class=\"item linkimg\">".PHP_EOL;
$txt .="<img class=\"img-fluid\" src=\"".$a_banner['banner_pic']."\" alt=\"".$a_banner['banner_name']."\" title=\"".$a_banner['banner_name']."\" />	";
$txt .="</div>".PHP_EOL;
$txt .=$banner_a;
}
$txt .="</div>".PHP_EOL;

$txt .="</div>".PHP_EOL;
$txt .="</section>".PHP_EOL;

}else if($temp == '5'){

$s_banner_g = $db->query("SELECT * FROM banner_group  WHERE  banner_gid = '{$bid}' ");
$a_banner_g = $db->db_fetch_array($s_banner_g);

$txt .="<section class=\"pt-4 pb-4\" style=\"background-color: #fff;\">".PHP_EOL;
$txt .="<div class=\"container\">".PHP_EOL;
$txt .="<div class=\"head-sec mt-4 mb-4 \">".PHP_EOL;
$txt .="<h2>".$a_banner_g['banner_name']."</h2>".PHP_EOL;
$txt .="<h3 hidden>hidden</h3>";
$txt .="</div>".PHP_EOL;

$txt .="<div class=\"container\">".PHP_EOL;
$txt .="<div class=\"row d-flex justify-content-center pb-5\">".PHP_EOL;
$s_banner = $db->query("SELECT * FROM banner  WHERE  banner_gid = '{$bid}' {$wh} ORDER BY banner_position ASC");
while($a_banner = $db->db_fetch_array($s_banner)){

if(strstr($a_banner['banner_link'],'ewt_news.php')){
$Ex = explode("ewt_news.php",$a_banner['banner_link']);
$a_banner['banner_link'] = "news_view.php".$Ex[1];

}else{

	$a_banner['banner_link'] = $a_banner['banner_link'];
}


if($a_banner['banner_link'] == "#"){
$banner_ahref= "<a>";
$banner_a= "</a>";

}else if($a_banner['banner_link']==""){
$banner_ahref= "<a>";
$banner_a= "</a>";
}else{

$banner_ahref="<a class=\"icon-news-update pt-4\" href=\"".$a_banner['banner_link']."\" target=\"".$a_banner['banner_traget']."\" onclick=\"ajax_save_log('banner_ajax_log.php?banner_id=".$a_banner['banner_id'].")\">";
$banner_a= "</a>";
}

$txt .="<div class=\"col-lg-3 col-md-3 col-sm-12 col-12 text-center\">".PHP_EOL;
$txt .=$banner_ahref;
//$txt .="<img src=\"img/icon1.png\" class=\"img-fluid\" alt=\"Responsive image\">".PHP_EOL;
$txt .="<img class=\"img-fluid\" src=\"".$a_banner['banner_pic']."\" alt=\"".$a_banner['banner_name']."\" title=\"".$a_banner['banner_name']."\" />	";
$txt .="<div class=\"title-saminar underline\"><h4>".$a_banner['banner_name']."</h4></div>".PHP_EOL;
$txt .=$banner_a;
$txt .="</div>".PHP_EOL;
}

$txt .="</div>".PHP_EOL;
$txt .="</div>".PHP_EOL;
$txt .="</div>".PHP_EOL;
$txt .="</section>".PHP_EOL;

}
		return $txt;
	}

function article_count($nid){
	global $db;

$a_count = $db->query("UPDATE article_list SET n_count = n_count+1 WHERE n_id = '{$nid}' ");
//return $article_count;
}


function article_insert_view($news_id){
	global $db;
	global $EWT_DB_NAME;
	global $EWT_DB_USER;

if($_SERVER["REMOTE_ADDR"]){
		$ip_view = $_SERVER["REMOTE_ADDR"];
	}else{
		$ip_view = $_SERVER["REMOTE_HOST"];
	}
$date_view = date("Y-m-d");
$time_view = date("h:i:s");
//if(!session_is_registered("newsvisit".$news_id)){
	$sqlnews_view = "INSERT INTO news_view (news_id,ip_view,date_view,time_view,id_member) VALUE ('".$news_id."','".$ip_view."','".$date_view."','".$time_view."','".$_SESSION['EWT_MID']."') ";
	$querynews_view = $db->query($sqlnews_view);
	//cese shere from site other to parent
		if($RR['n_shareuse'] =='Y'){
		$db->query("USE ".$db_name_parent);
		$sqlnews_view2 = "INSERT INTO news_view (news_id,ip_view,date_view,time_view,id_member) VALUE ('".$R_parent_id['n_id']."','".$ip_view."','".$date_view."','".$time_view."','".$_SESSION['EWT_MID']."') ";
		$querynews_view2 = $db->query($sqlnews_view2);
		$db->query("USE ".$EWT_DB_NAME);
		}
		//cese shere from site other to child
		if($RR['n_share'] =='Y'){
			$db->query("USE ".$EWT_DB_USER);
			$sqln_share = "SELECT * FROM share_article WHERE n_id ='".$news_id."' AND user_s ='".$EWT_FOLDER_USER."' AND s_status ='Y'";
			$queryn_share = $db->query($sqln_share);
			while($RRR=$db->db_fetch_array($queryn_share)){
				$sqln_share2 = "SELECT db_db FROM user_info WHERE EWT_User ='".$RRR['user_t']."'";
				$queryn_share2 = $db->query($sqln_share2);
				$N = $db->db_fetch_array($queryn_share2);
				$db_name_parent = $N['db_db'];
				$db->query("USE ".$db_name_parent);
				$sqlnews_view3 = "INSERT INTO news_view (news_id,ip_view,date_view,time_view,id_member) VALUE ('".$RRR['n_id_t']."','".$ip_view."','".$date_view."','".$time_view."','".$_SESSION['EWT_MID']."') ";
				$querynews_view3 = $db->query($sqlnews_view3);
			$db->query("USE ".$EWT_DB_USER);
			}
			$db->query("USE ".$EWT_DB_NAME);
		}
	//session_register("newsvisit".$news_id);
}

function article_parent($id){
	 global $db;

	 if(SYS_LANG != 'TH'){
	 $s_parent = $db->query("SELECT * FROM  article_group,lang_article_group,lang_config
					   WHERE lang_article_group.c_id = article_group.c_id
					   AND lang_config.lang_config_id = lang_article_group.lang_name
					   AND lang_config.lang_config_suffix = '".SYS_LANG."'
					   AND article_group.c_id = '{$id}'");
	 }else{
	 $s_parent = $db->query("SELECT * FROM article_group WHERE c_id = '{$id}' ");
	 }
	 	if($db->db_num_rows($s_parent)){

	 		$a_parent = $db->db_fetch_array($s_parent);

			if(SYS_LANG != 'TH'){
			$a_parent['c_name'] = $a_parent['lang_detail'];
			 }

			//$txt = "<li class=\"breadcrumb-item active\">".$a_parent['c_name']."</li>";

			$txt = "<li class=\"breadcrumb-item active\" aria-current=\"page\"> <a href = \"article-more.php?cid=".$a_parent["c_id"]."&lang=".SYS_LANG."\">".$a_parent['c_name']."</a></li>";

			if($a_parent['c_parent'] != "0" AND $a_parent['c_parent'] != ""){

				$txt = article_parent($a_parent['c_parent']).$txt;

			}

	 	}

		return $txt;
	 }


function article_detail($nid,$temp,$adid,$x,$y){
	global $db;

if($x){
$wh = "AND at_type_row = '{$x}' AND at_type_col = '{$y}'";
}else{
	$wh = "AND ad_id = '{$adid}'";
}

$txt ="";
$s_detail = $db->query("SELECT * FROM article_detail WHERE n_id = '{$nid}' {$wh} ");
while($a_detail = $db->db_fetch_array($s_detail)) {

if(SYS_LANG != 'TH'){
 $a_detail['ad_des'] = article_lang_detail($nid,SYS_LANG,'ad_des'.$a_detail['ad_id'],'article_list');
}
if($a_detail['ad_des'] != ''){
 //$txt .= nl2br(stripslashes($a_detail["ad_des"]));
 $txt .= $a_detail["ad_des"];
		}
	}
	return $txt;
}

function article_lang_detail($c_id,$lang_name,$lang_field,$module){
global $db;
$tb = "lang_".$module;

$s_lang_comfig = $db->query("SELECT lang_config_id FROM lang_config WHERE lang_config_suffix = '{$lang_name}' AND lang_config_status ='O' ");
$a_data_comfig = $db->db_fetch_array($s_lang_comfig);


$s_lang_detail = $db->query("SELECT lang_detail FROM {$tb} WHERE c_id = '{$c_id}' AND lang_name = '{$a_data_comfig['lang_config_id']}' AND lang_field = '{$lang_field}' ");
$a_data = $db->db_fetch_array($s_lang_detail);

$newContent = str_replace("../js/","../../js/",$a_data['lang_detail']);

return stripslashes($newContent);

}

function article($cid,$temp,$lim){
		global $db;

if(SYS_LANG){
	include('language/lang_'.SYS_LANG.'.php');
}

$lang = SYS_LANG;

$s_group = $db->query("SELECT * FROM  article_group WHERE c_id = '{$cid}'");
$a_group = $db->db_fetch_array($s_group);

if(SYS_LANG != 'TH'){

$sql_group2 ="SELECT * FROM  article_group,lang_article_group,lang_config WHERE lang_article_group.c_id =article_group.c_id AND lang_config.lang_config_id = lang_article_group.lang_name AND lang_config.lang_config_suffix = '{$lang}' AND  article_group.c_id = '{$cid}' AND lang_article_group.lang_field = 'c_name'  ";
$query_group2 = $db->query($sql_group2);
$U2 = $db->db_fetch_array($query_group2);

$a_group['c_name'] = $U2['lang_detail'];	

	}



$txt ="";

$glo_sql = " ( c_id = '{$cid}' ";
		if($a_group['c_show_subnew'] == "Y"){
		tochild($nid);
		}
		if($a_group["c_type"] == 'M'){
		tomultigroup($nid);
		}
$glo_sql .= " ) ";

$date_now = (date("Y")+543).'-'.date('m-d H:i:s');

if(SYS_LANG != 'TH'){

$s_article = $db->query("SELECT *
FROM article_list,lang_article_list ,lang_config
WHERE article_list.n_id = lang_article_list.c_id
AND lang_config.lang_config_id = lang_article_list.lang_name
AND lang_config.lang_config_suffix = '{$lang}'
AND lang_article_list.lang_field = 'n_topic'
AND article_list.c_id = '{$cid}'
AND n_approve = 'Y'
AND (('{$date_now}' between article_list.n_date_start  AND article_list.n_date_end) OR (article_list.n_date_start = '' AND article_list.n_date_end = ''))
GROUP BY lang_article_list.c_id
ORDER BY n_date DESC,n_timestamp DESC LIMIT 0,{$lim}");


}else{

	$s_article = $db->query("SELECT * FROM article_list WHERE {$glo_sql} AND n_approve = 'Y'
	AND (('{$date_now}' between n_date_start  AND n_date_end) OR (n_date_start = '' AND n_date_end = ''))
	ORDER BY n_date DESC,n_timestamp DESC LIMIT 0,{$lim}");


	}

$a_rows = $db->db_num_rows($s_article);

if($temp == '1'){


$txt .="<section class=\"pb-4\" style=\"background-color: #fff;\">".PHP_EOL;
$txt .="<div class=\"container\">".PHP_EOL;
$txt .="<div class=\"head-sec pt-4 pb-3\">".PHP_EOL;
$txt .="<h2>".PHP_EOL;
$txt .=$a_group['c_name'];

if($a_group['c_rss']=="Y"){

$txt .="<a href=\"rss/group".$U['c_id'].".xml\"  class=\"fa-stack fa-xs\"  title=\"RSS ".$U['c_name']."\" />".PHP_EOL;
//$txt .="<a href=\"#\" class=\"fa-stack fa-xs\">".PHP_EOL;
$txt .="<em class=\"fas fa-square fa-stack-1x pl-2\" style=\"color: #fff; text-align: left;\"></em>".PHP_EOL;
$txt .="<em class=\"fas fa-rss-square fa-stack-1x fa-inverse pl-2\" style=\"color: #ff7f00; text-align: left;\"></em>".PHP_EOL;
$txt .="</a>".PHP_EOL;
}
$txt .="</h2>".PHP_EOL;
$txt .="<h3 hidden>hidden</h3>";
$txt .="</div>".PHP_EOL;




if($a_rows > 0){

$txt .="<div class=\"d-none d-sm-block d-md-block d-lg-block\">".PHP_EOL;
$txt .="<div class=\"row\">".PHP_EOL;

while($a_article = $db->db_fetch_array($s_article)) {

if(SYS_LANG != 'TH'){
	$a_article['n_topic'] = $a_article['lang_detail'];
	}

$txt .="<div class=\"col-lg-3 col-md-6 col-sm-6 col-12 mb-4\">".PHP_EOL;
$txt .="<div class=\"thumbnail img-thumb-bg shadow-card\">".PHP_EOL;

if($a_article['picture'] != ""){
if(file_exists("images/article/news".$a_article['n_id']."/".$a_article['picture'])){
$txt .="<img src=\"".$Website."images/article/news".$a_article['n_id']."/".$a_article['picture']."\" alt=\"".$a_article['n_topic']."\" class=\"img-fluid\"/>".PHP_EOL;
}else{

$ccc= explode(".",$a_article['picture']);
$bbb = explode("_",$ccc[0]);

if(file_exists("../".$a_article['n_sharename'].'/images/article/news'.$bbb[1]."/".$a_article['picture'])){
$txt .="<img src=\"../".$a_article['n_sharename']."/images/article/news".$bbb[1]."/".$a_article['picture']."\"  alt=\"".$a_article['n_topic']."\" class=\"img-fluid\"  />".PHP_EOL;
}
	}
}else{
$txt .="<img src=\"img/default-article.jpg\"  alt=\"".$a_article['n_topic']."\" class=\"img-fluid\" />".PHP_EOL;
}


$txt .="<div class=\"overlay\"></div>".PHP_EOL;
$txt .="<div class=\"caption align-self-start\">".PHP_EOL;
//$txt .="<div class=\"tag\"><a class=\"p-1\" href=\"#\">อัพเดต</a></div>".PHP_EOL;
$txt .="<div class=\"title\">".PHP_EOL;

if($a_article['news_use'] == "2" OR $a_article['news_use'] == "3"){
$txt .="<a href=\"article-views.php?nid=".$a_article['n_id']."&lang=".SYS_LANG."\" target=\"".$a_article['target']."\">";
	}elseif($a_article['news_use'] == "4"){
		$txt .="<a href=\"ewt_dl.php?nid=".$a_article['n_id']."\" target=\"".$a_article['target']."\">";
		}else{
		$txt .="<a href=\"ewt_dl_link.php?nid=".$a_article['n_id']."\" target=\"".$a_article['target']."\">";
		}


$txt .="<h4>".$a_article['n_topic'];

$date_exp = eregi_replace("-","",$a_article["expire"]);
$date_now1 = (date("Y")+543).date("md");

if(file_exists("icon/".$a_article['logo']) AND $a_article['logo'] != '' AND $date_exp >= $date_now1){
$txt .=" <img  src=\"icon/".$a_article["logo"]."\" align=\"absmiddle\" border=\"0\" alt=\"icon\" title=\"icon\">"; 							
}							
$txt ."</h4></a>".PHP_EOL;	
$txt .="</div>".PHP_EOL;
$txt .="<div class=\"clearfix mt-1\">".PHP_EOL;
$txt .="<span><a class=\"btn-share pr-2\" style=\"color: #b7b7b7; font-size: 16px;\" href=\"#\"><em class=\"far fa-calendar-alt\"></em> &nbsp;".chg_date_article($a_article['n_date'])."</a></span>".PHP_EOL;
/*$txt .="<span><a class=\"btn-share\" style=\"color: #b7b7b7; font-size: 16px;\" href=\"#\"><em class=\"far fa-eye\"></em> &nbsp;".$a_article['n_count']." views</a></span> &nbsp;".PHP_EOL;*/
$txt .="<hr class=\"hidden-hr mt-1 mb-0\"	style=\"border-color: transparent;\">".PHP_EOL;
$txt .="<span><a class=\"btn-share\" style=\"color: #b7b7b7; font-size: 16px;\" href=\"#\"> Share :</a> &nbsp;".PHP_EOL;
$txt .=share_buttons_all('article-views',$a_article['n_id'],'nid','1');
$txt .="</span>".PHP_EOL;

$txt .="</div>".PHP_EOL;
$txt .="</div>".PHP_EOL;
$txt .="</div>".PHP_EOL;
$txt .="</div>".PHP_EOL;

}
$txt .="</div>".PHP_EOL;
$txt .="</div>".PHP_EOL;
}

$txt .="</div>".PHP_EOL;



/*Mobile   */

if(SYS_LANG != 'TH'){
$s_article_m = $db->query("SELECT *
FROM article_list,lang_article_list ,lang_config
WHERE article_list.n_id = lang_article_list.c_id
AND lang_config.lang_config_id = lang_article_list.lang_name
AND lang_config.lang_config_suffix = '{$lang}'
AND lang_article_list.lang_field = 'n_topic'
AND article_list.c_id = '{$cid}'
AND n_approve = 'Y'
GROUP BY lang_article_list.c_id
ORDER BY n_date DESC,n_timestamp DESC LIMIT 0,{$lim}");

}else{

	$s_article_m = $db->query("SELECT * FROM article_list WHERE {$glo_sql} AND n_approve = 'Y' ORDER BY n_date DESC,n_timestamp DESC LIMIT 0,{$lim}");

	}
$a_rows_m = $db->db_num_rows($s_article_m);

if($a_rows_m > 0){

$txt .="<div class=\"owl-carousel owl-theme d-lg-none d-md-none d-sm-none d-block mt-4\" id=\"news\">".PHP_EOL;


while($a_article_m = $db->db_fetch_array($s_article_m)) {


$txt .="<div class=\"item\">".PHP_EOL;
$txt .="<div class=\"thumbnail img-thumb-bg shadow-card\">".PHP_EOL;

if($a_article_m['picture'] != ""){

if(file_exists("images/article/news".$a_article_m['n_id']."/".$a_article_m['picture'])){

$txt .="<img src=\"".$Website."images/article/news".$a_article_m['n_id']."/".$a_article_m['picture']."\" alt=\"".$a_article_m['n_topic']."\" class=\"img-fluid\"/>".PHP_EOL;
}else{
				$ccc= explode(".",$a_article_m['picture']);
				$bbb = explode("_",$ccc[0]);
				if(file_exists("../".$a_article_m['n_sharename'].'/images/article/news'.$bbb[1]."/".$a_article_m['picture'])){

$txt .="<img src=\"../".$a_article_m['n_sharename']."/images/article/news".$bbb[1]."/".$a_article_m['picture']."\"  alt=\"".$a_article_m['n_topic']."\" class=\"img-fluid\"  />".PHP_EOL;

}
	}

}else{

$txt .="<img src=\"img/default-article.jpg\"  alt=\"".$a_article_m['n_topic']."\" class=\"img-fluid\" />".PHP_EOL;

}

$txt .="<div class=\"overlay\"></div>".PHP_EOL;
$txt .="<div class=\"caption align-self-start\">".PHP_EOL;
//$txt .="<div class=\"tag\"><a class=\"p-1\" href=\"#\">อัพเดต</a></div>".PHP_EOL;
$txt .="<div class=\"title\">".PHP_EOL;

if($a_article_m['news_use'] == "2" or $a_article_m['news_use'] == "3"){
$txt .="<a href=\"article-views.php?nid=".$a_article_m['n_id']."&lang=".SYS_LANG."\" target=\"".$a_article_m['target']."\">";
}elseif($a_article_m['news_use'] == "4"){
$txt .="<a href=\"ewt_dl.php?nid=".$a_article_m['n_id']."\" target=\"".$a_article_m['target']."\">";
}else{
$txt .="<a href=\"ewt_dl_link.php?nid=".$a_article_m['n_id']."\" target=\"".$a_article_m['target']."\">";
}

$txt .="<h4>".$a_article_m['n_topic']."</h4></a>".PHP_EOL;
$date_exp = eregi_replace("-","",$a_article_m["expire"]);
$date_now1 = (date("Y")+543).date("md");

if(file_exists("icon/".$a_article_m['logo']) AND $a_article_m['logo'] != '' AND $date_exp >= $date_now1){
$txt .="<img  src=\"icon/".$a_article_m['logo']."\" align=\"absmiddle\" border=\"0\" alt=\"icon\" title=\"icon\">"; 							
}
$txt .="</div>".PHP_EOL;
$txt .="<div class=\"clearfix mt-1\">".PHP_EOL;
$txt .="<span><a class=\"btn-share pr-2\" style=\"color: #b7b7b7; font-size: 16px;\" href=\"#\"><em class=\"far fa-calendar-alt\"></em> &nbsp;".chg_date_article($a_article_m['n_date'])."</a> </span>".PHP_EOL;
/* $txt .="<span><a class=\"btn-share\" style=\"color: #b7b7b7; font-size: 16px;\" href=\"#\"><em class=\"far fa-eye\"></em> &nbsp;".$a_article_m['n_count']." views</a> </span> &nbsp;".PHP_EOL;*/
$txt .="<hr class=\"hidden-hr mt-1 mb-0\"	style=\"border-color: transparent;\">".PHP_EOL;
$txt .="<span><a class=\"btn-share\" style=\"color: #b7b7b7; font-size: 16px;\" href=\"#\"> Share :</a> &nbsp;".PHP_EOL;
$txt .=share_buttons_all('article-views',$a_article_m['n_id'],'nid','1');
$txt .="</span>".PHP_EOL;

$txt .="</div>".PHP_EOL;
$txt .="</div>".PHP_EOL;
$txt .="</div>".PHP_EOL;
$txt .="</div>".PHP_EOL;

}
$txt .="</div>".PHP_EOL;

}
/* END Mobile */


if($a_rows > 0){
$txt .="<div class=\"container-set\">".PHP_EOL;
$txt .="<div class=\"col-12 text-center mt-2\">".PHP_EOL;
$txt .="<a class=\"btn-viewall p-2\" href=\"article-more.php?cid=".$cid."&lang=".SYS_LANG."\" role=\"button\">";
$txt .=$text_article_viewmore;
$txt .="</a>".PHP_EOL;
$txt .="</div>".PHP_EOL;
$txt .="</div>".PHP_EOL;
}

$txt .="</section>".PHP_EOL;

}

if($temp == '2'){
	

$txt .='<div class="height-newsofvdo-1">'.PHP_EOL;
$txt .='<div class="head-sec mt-4 mb-4">'.PHP_EOL;
$txt .='<h2>'.$a_group['c_name'];

if($a_group['c_rss']=="Y"){

$txt .="<a href=\"rss/group".$U['c_id'].".xml\"  class=\"fa-stack fa-xs\"  title=\"RSS ".$U['c_name']."\" />".PHP_EOL;
//$txt .="<a href=\"#\" class=\"fa-stack fa-xs\">".PHP_EOL;
$txt .="<em class=\"fas fa-square fa-stack-1x pl-2\" style=\"color: #fff; text-align: left;\"></em>".PHP_EOL;
$txt .="<em class=\"fas fa-rss-square fa-stack-1x fa-inverse pl-2\" style=\"color: #ff7f00; text-align: left;\"></em>".PHP_EOL;
$txt .="</a>".PHP_EOL;
}
$txt .='</h2>';
$txt .='</div>'.PHP_EOL;

if($a_rows > 0){
	
$txt .='<div class="card shadow-image">'.PHP_EOL;
$txt .='<div class="list-sale border-redius8px" style="background-color: #fff;">'.PHP_EOL;
//$txt .='<table class="table table-striped mb-0">'.PHP_EOL;
if($a_rows == 1){
	$txt .='<table class="table mb-0 height-in-newsvdo">'.PHP_EOL;
}else if($a_rows > 1){
	$txt .='<table class="table table-striped mb-0 height-newsin">'.PHP_EOL;
}
$txt .='<tbody>'.PHP_EOL;

while($a_article = $db->db_fetch_array($s_article)) {

if(SYS_LANG != 'TH'){
	$a_article['n_topic'] = $a_article['lang_detail'];
	}

$txt .='<tr>'.PHP_EOL;
$txt .='<td class="pt-3 pb-3 pl-4 pr-4">';


if($a_article['news_use'] == "2" OR $a_article['news_use'] == "3"){
$txt .="<a href=\"article-views.php?nid=".$a_article['n_id']."&lang=".SYS_LANG."\" target=\"".$a_article['target']."\">";
	}else if($a_article['news_use'] == "4"){
		$txt .="<a href=\"ewt_dl.php?nid=".$a_article['n_id']."\" target=\"".$a_article['target']."\">";
		}else{
		$txt .="<a href=\"ewt_dl_link.php?nid=".$a_article['n_id']."&lang=".SYS_LANG."\" target=\"".$a_article['target']."\">";
		}
		
$txt .='<h3>'.$a_article['n_topic'];

$date_exp = eregi_replace("-","",$a_article["expire"]);
$date_now1 = (date("Y")+543).date("md");

if(file_exists("icon/".$a_article['logo']) AND $a_article['logo'] != '' AND $date_exp >= $date_now1){
$txt .=" <img  src=\"icon/".$a_article["logo"]."\" align=\"absmiddle\" border=\"0\" alt=\"icon\" title=\"icon\">"; 							
}							
$txt .='</h3></a>';

$txt .='<hr class="mt-1 mb-2">';
$txt .='<a href="#" class="btn-share text-muted" style="color: #b7b7b7; font-size: 16px;"><i class="far fa-calendar-alt"></i>&nbsp;&nbsp;'.chg_date_article($a_article['n_date']).'</a>'; 
$txt .='</td>';
$txt .='</tr>';
	 	  
 } 	  
$txt .='</tbody>';
$txt .='</table>';
$txt .='</div>';
$txt .='</div>';

}

$txt .='<div class="col-12 text-center mt-4 mb-3">';
$txt .='<a class="btn-viewall p-2" href="article-more.php?cid='.$cid.'&lang='.SYS_LANG.'"  onclick="Func_Menu_left(\'0010\',\'0010\',\'0010_0003\')" role="button">'.$text_article_viewmore.'</a>';
$txt .='</div>';
$txt .='</div>';

		
}

if($temp == '3'){
	
	
$txt .='<div class="col-lg-7 col-md-12">'.PHP_EOL;
$txt .='<div class="head-sec mt-4 mb-4">'.PHP_EOL;
$txt .='<h2>'.$a_group['c_name'];

if($a_group['c_rss']=="Y"){

$txt .="<a href=\"rss/group".$a_group['c_id'].".xml\"  class=\"fa-stack fa-xs\"  title=\"RSS ".$a_group['c_name']."\" />".PHP_EOL;
//$txt .="<a href=\"#\" class=\"fa-stack fa-xs\">".PHP_EOL;
$txt .="<em class=\"fas fa-square fa-stack-1x pl-2\" style=\"color: #fff; text-align: left;\"></em>".PHP_EOL;
$txt .="<em class=\"fas fa-rss-square fa-stack-1x fa-inverse pl-2\" style=\"color: #ff7f00; text-align: left;\"></em>".PHP_EOL;
$txt .="</a>".PHP_EOL;
}
$txt .='</h2>';
$txt .='</div>';


while($a_article = $db->db_fetch_array($s_article)) {

if(SYS_LANG != 'TH'){
	$a_article['n_topic'] = $a_article['lang_detail'];
	}
	

$txt .='<div class="text-center mb-4">';

if($a_article['news_use'] == "2" OR $a_article['news_use'] == "3"){
$txt .="<a href=\"article-views.php?nid=".$a_article['n_id']."&lang=".SYS_LANG."\" target=\"".$a_article['target']."\">";
	}else if($a_article['news_use'] == "4"){
		$txt .="<a href=\"ewt_dl.php?nid=".$a_article['n_id']."\" target=\"".$a_article['target']."\">";
		}else{
		$txt .="<a href=\"ewt_dl_link.php?nid=".$a_article['n_id']."&lang=".SYS_LANG."\" target=\"".$a_article['target']."\">";
		}
		


if($a_article['picture'] != ""){
if(file_exists("images/article/news".$a_article['n_id']."/".$a_article['picture'])){
$txt .="<img src=\"".$Website."images/article/news".$a_article['n_id']."/".$a_article['picture']."\" alt=\"".$a_article['n_topic']."\" class=\"img-fluid shadow-image border-pdf h-100\" style=\"border-bottom: 1px solid #E5E5E5; border-radius: 8px;\" />".PHP_EOL;
}else{

$ccc= explode(".",$a_article['picture']);
$bbb = explode("_",$ccc[0]);

if(file_exists("../".$a_article['n_sharename'].'/images/article/news'.$bbb[1]."/".$a_article['picture'])){
$txt .="<img src=\"../".$a_article['n_sharename']."/images/article/news".$bbb[1]."/".$a_article['picture']."\"  alt=\"".$a_article['n_topic']."\"  class=\"img-fluid shadow-image border-pdf h-100\" style=\"border-bottom: 1px solid #E5E5E5; border-radius: 8px;\"  />".PHP_EOL;
}
	}
}else{
$txt .="<img src=\"img/default-article.jpg\"  alt=\"".$a_article['n_topic']."\" class=\"img-fluid shadow-image border-pdf h-100\" />".PHP_EOL;
}



$txt .='</a>';

}

$txt .='</div>';


$txt .='<div class="col-12 text-center mt-2 mb-3">';
$txt .='<a class="btn-viewall p-2" href="article-more.php?cid='.$cid.'&lang='.SYS_LANG.'"  onclick="Func_Menu_left(\'0010\',\'0010\',\'0010_0003\')" role="button">'.$text_article_viewmore.'</a>';
$txt .='</div>';

$txt .='</div>';
	
	
}

	return $txt;

}





function glink($link_html){
	global $db ;

	if(strstr($link_html,'cid')){
		$link = $link_html;
	}else if(strstr($link_html,'http') || strstr($link_html,'wwww')){
		$link = $link_html;
	}else if(strstr($link_html,'nid')){
		$sub_link = explode("=",$link_html);

		$sql1 = "SELECT * FROM article_list WHERE n_id = '{$sub_link[1]}' ";
		$exc1 = $db->query($sql1);
		$row = $db->db_fetch_array($exc1);

		if($row["link_html"]==""){
			$link = "news_view.php?nid=".$sub_link[1];
		}else{
			$link = glink($row["link_html"]);
		}

	}else if(strstr($link_html,'news_view.php')||strstr($link_html,'news_view.php')){
		//$sub_link = explode("=",$link_html);

		$sql1 = "SELECT * FROM article_list WHERE link_html = '{$link_html}' ";
		$exc1 = $db->query($sql1);
		$row = $db->db_fetch_array($exc1);

		$link = "news_view.php?nid=".$row["n_id"];

	}else{
		if($link_html!="" && $link_html!="#"){
			$link = $path_img.$link_html;
		}else{
			$link="";
		}
	}
	return $link;
}

function menu_child($m_id,$mp_id,$l){
	global $db ;

$s_menu_properties = $db->query("SELECT * FROM menu_properties WHERE m_id = '{$m_id}' AND mp_id LIKE '{$mp_id}_%' ORDER BY mp_id ASC");
$a_row = $db->db_num_rows($s_menu_properties);

if($a_row > 0){
$txt = "";

if($l > 3){
	$txt .='<ul class="dropdown-menu p-0">'.PHP_EOL;
}else{
$txt .="<ul class=\"dropdown-menu multi-level p-0\" role=\"menu\">".PHP_EOL;
}

while($a_menu = $db->db_fetch_array($s_menu_properties)){
	$len = genlen($a_menu['mp_id'],"_");
	if($l+1 == $len){
		$s_menu_properties2 = $db->query("SELECT * FROM menu_properties WHERE m_id = '{$m_id}' AND mp_id LIKE '{$a_menu['mp_id']}_%' ORDER BY mp_id ASC");
		$a_row2 = $db->db_num_rows($s_menu_properties2);
		$link = glink($a_menu['Glink']);

if($a_row2 > 0){
	$txt .='<li class="dropdown-submenu"><a class="dropdown-item separator-line-BT pl-4 pr-4 pt-2 pb-2" tabindex="-1" href="#">';
	$txt .=$a_menu['mp_name']."</a>";
	$txt .= menu_child($m_id,$a_menu['mp_id'],$len);
	$txt .="</li>".PHP_EOL;
	}else{
		if($a_menu['Glink']){
				$txt .="<li class=\"dropdown-item separator-line-BT pl-4 pr-4 pt-2 pb-2\"><a href=\"".$a_menu['Glink']."\" onclick=\"Func_Menu_left('".$a_menu['m_id']."','".$mp_id."','".$a_menu['mp_id']."')\">".$a_menu['mp_name']."</a></li>";
				}else{
						$txt .='<li class="dropdown-item separator-line-BT pl-4 pr-4 pt-2 pb-2"><a href="'.$a_menu['Glink'].'">'.$a_menu['mp_name'].'</a></li>';
					}

				}

		}
	}

$txt .="</ul>".PHP_EOL;
	}

	return $txt;
}

function menu_left($m_id,$mp_id,$active){
	global $db;
		
	$txt = "";
	$s_menu_properties = $db->query("SELECT * FROM menu_properties WHERE m_id = '{$m_id}' AND mp_id LIKE '{$mp_id}_%' ORDER BY mp_id ASC");
	 
	$a_row = $db->db_num_rows($s_menu_properties);

	$i=0;
	if($a_row > 0){
		while($a_menu = $db->db_fetch_array($s_menu_properties)){
			if($i==0){ $menu_len = strlen($a_menu['mp_id']); }
			if($a_menu['mp_id'] == $active){			
				$menuactive = 'menu-active';
			}else{
				$menuactive = '';
			}
			
			$txt .='<div class="card" style="border: 0px;">'.PHP_EOL;
			$txt .='<div class="card-header '.$menuactive.' " role="tab" id="heading'.$a_menu['mp_id'].'">'.PHP_EOL;
			if(strlen($a_menu['mp_id']) > $menu_len){
				$txt .='<ul><li>';
			}
			$txt .='<a class="';
			if(strlen($a_menu['mp_id']) > $menu_len){
				$txt .='sub-menu-right-1 white-link';
			}else{
				$txt .='head-menu-L py-auto px-auto';
			}
			$txt .='" href="'.$a_menu['Glink'].'"  onclick="Func_Menu_left(\''.$a_menu['m_id'].'\',\''.$mp_id.'\',\''.$a_menu['mp_id'].'\');">'.PHP_EOL;
			$txt .=$a_menu['mp_name'];
			$txt .='</a>'.PHP_EOL;
			if(strlen($a_menu['mp_id']) > $menu_len){
				$txt .='</li></ul>';
			}
			$txt .='</div>'.PHP_EOL; 
			$txt .='</div>'.PHP_EOL;
			
			$i++;
			/*$txt .='<div class="card" style="border: 0px;">'.PHP_EOL;
			$txt .='<div class="card-header menu-active" role="tab" id="headingFour">'.PHP_EOL;
			$txt .='<a class="head-menu-L py-auto" href="form-information.php">'.PHP_EOL;
			$txt .='สอบถามข้อมูล'.PHP_EOL;
			$txt .='</a>'.PHP_EOL;
			$txt .='</div>'.PHP_EOL;
			$txt .='</div>'.PHP_EOL;*/
		}
	}	
	
	return $txt;
}

function menu_mobile_child($m_id,$mp_id,$l){
	global $db ;

	$s_menu_properties = $db->query("SELECT * FROM menu_properties WHERE m_id = '{$m_id}' AND mp_id LIKE '{$mp_id}_%' ORDER BY mp_id ASC");
	$a_row = $db->db_num_rows($s_menu_properties);

	if($a_row > 0){
		$txt = "";

		if($l > 3){
			$txt .="<ul class=\"sub-menu pt-3 pb-2 pl-2 pr-2\">".PHP_EOL;
		}else{
		$txt .="<ul class=\"sub-menu pt-3 pb-0 pl-1 pr-1\">".PHP_EOL;
		}
		

		while($a_menu = $db->db_fetch_array($s_menu_properties)){
			$len = genlen($a_menu['mp_id'],"_");
			if($l+1 == $len){
				$s_menu_properties2 = $db->query("SELECT * FROM menu_properties WHERE m_id = '{$m_id}' AND mp_id LIKE '{$a_menu['mp_id']}_%' ORDER BY mp_id ASC");
				$a_row2 = $db->db_num_rows($s_menu_properties2);
				$link = glink($a_menu['Glink']);

				if($a_row2 > 0){
					
					$txt .= '<li class="item-has-children separator-line-BT-mobile-sub pt-2 pb-2"><a href="#0">'.$a_menu['mp_name'].'</a>';
					$txt .= menu_mobile_child($m_id,$a_menu['mp_id'],$len);
					$txt .="</li>".PHP_EOL;
				}else{
					//if($a_menu['Glink']){
					//	$txt .="<li class=\"dropdown-item separator-line-BT pl-4 pr-4 pt-2 pb-2\"><a href=\"".$a_menu['Glink']."\" onclick=\"Func_Menu_left('".$a_menu['m_id']."','".$mp_id."','".$a_menu['mp_id']."')\">".$a_menu['mp_name']."</a></li>";
					//}else{
						$txt .='<li class="separator-line-BT-mobile-sub pt-2 pb-2"><a href="'.$a_menu['Glink'].'">'.$a_menu['mp_name'].'</a></li>';
						//$txt .='<li class="dropdown-item separator-line-BT pl-4 pr-4 pt-2 pb-2"><a href="'.$a_menu['Glink'].'">'.$a_menu['mp_name'].'</a></li>';
					//}

				}

			}
		}

		$txt .="</ul>".PHP_EOL;
	}
	return $txt;
}

function menu_mobile($m_id){
	global $db;

	if(SYS_LANG == 'TH'){
		$str_l = 'EN';
	}else{
		$str_l = 'TH';
	}
	$txt = '';
	$txt .= '<nav id="cd-lateral-nav">
		<ul class="cd-navigation pl-2 pr-2">
			<div class="row separator-line-BT-mobile w-100 pt-3 pb-3 m-0">

				<div class="col-8">';
					/*<h2>'.$text_menu_main.'</h2>*/
	$txt .= "<h3 hidden></h3>
			 </div>
			 <div class=\"col-4 text-right pr-0\">";
	if(SYS_LANG == 'EN'){
	$txt .= "<a class=\"pt-2 text-white \" style=\"cursor:pointer\" onclick=\"changlang('TH');\"><h4>TH</h4></a>";
	}else{
	$txt .= "<a class=\"pt-2 text-white \" style=\"cursor:pointer\" onclick=\"changlang('EN');\"><h4>EN</h4></a>";			
	}
	$txt .= "</div></div>";
	$i = 0;
	$s_menu_properties = $db->query("SELECT * FROM menu_properties WHERE m_id = '{$m_id}' ORDER BY mp_id ASC");
	$a_row = $db->db_num_rows($s_menu_properties);

	if($a_row){
		while($a_menu = $db->db_fetch_array($s_menu_properties)){
			
			$len = genlen($a_menu['mp_id'],"_");
			if($len=="2"){
				$txt .= "<li class=\"item-has-children separator-line-BT-mobile pt-2 pb-2\"><a href=\"#0\">".$a_menu["mp_name"]."</a>";
				$s_menu_properties2 = $db->query("SELECT * FROM menu_properties WHERE m_id = '{$m_id}' AND mp_id LIKE '{$a_menu['mp_id']}_%' ORDER BY mp_id ASC");
				$a_row2 = $db->db_num_rows($s_menu_properties2);
				$link = glink($a_menu['Glink']);
				
				if($a_row2 > 0){
					
					//$txt .="<div class=\"dropdown pt-1\">".PHP_EOL;
					//$txt .="<button class=\"btn btn-header btn-link dropdown-toggle\" type=\"button\" data-toggle=\"dropdown\" aria-haspopup=\"true\" aria-expanded=\"false\">".PHP_EOL;
					//$txt .="".$a_menu['mp_name']."";
					//$txt .="</button>".PHP_EOL;

					$txt .= menu_mobile_child($m_id,$a_menu['mp_id'],$len);
					
					//$txt .="</div>".PHP_EOL;
					
					//$txt .="<ul class=\"sub-menu pt-3 pb-0 pl-1 pr-1\">".PHP_EOL;
					//$txt .="<li class=\"separator-line-BT-mobile-sub pt-2 pb-2\"><a href=\"#0\">ความเป็นมา</a></li>".PHP_EOL;
					//$txt .="<li class=\"separator-line-BT-mobile-sub pt-2 pb-2\"><a href=\"#0\">วิสัยทัศน์ (Vision)</a></li>".PHP_EOL;
					//$txt .="<li class=\"separator-line-BT-mobile-sub pt-2 pb-2\"><a href=\"#0\">ภารกิจและอำนาจหน้าที่</a></li>".PHP_EOL;
					//$txt .="<li class=\"separator-line-BT-mobile-sub pt-2 pb-2\"><a href=\"#0\">รายงานผลการดำเนินการ</a></li>".PHP_EOL;
					//$txt .="<li class=\"item-has-children separator-line-BT-mobile-sub pt-2 pb-2\"><a href=\"#0\">โครงสร้างองค์กร</a></li>".PHP_EOL;
	
				}else{
					
					
				}
				$txt .= "</li>";
			}
			
			
		}
		//$txt .= '</ul>';
		//if(SYS_LANG == 'TH'){
		//	$txt .= '<div class="follow-us pb-2 w-100">
		//		<div class="row w-100 pl-2 m-0">
		//			<a class="text-white pt-3 mr-2">ติดตามเรา</a>
		//			<a href="https://th-th.facebook.com/Competition-Friend-542953045856784/" target="_blank" class="text-nav p-1"><em class="btn-social1 fab fa-facebook-square"></em></a>
		//			<a href="#" class="text-nav p-1"><em class="btn-social1 fab fa-line"></em></a>
		//			<a href="#" class="text-nav p-1"><em class="btn-social1 fab fa-youtube-square"></em></a>
		//		</div>
		//	</div>

		//	<form class="form-inline pl-2 pr-2 m-0">
		//		<label hidden for="search-all">search-all</label>
		//		<input class="form-control form-search-mobile w-100" id="search-all" type="search" placeholder="ค้นหาสิ่งที่ต้องการ ..." aria-label="Search">
		//	</form>';
		//}else if(SYS_LANG == 'EN'){
		//	$txt .= '';
		//}
		$txt .= '</ul></nav>';
		return $txt;
	}
}
function menu($m_id){
	global $db;

$txt = "";
$txt .='<header class="menu-nav">
			<div style="padding: 2px 9%; height: auto;">

			<nav class="navbar navbar-expand-lg navbar-light p-0" style="color: #102346d9;">
  			<a class="navbar-brand p-0" href="home.php?lang='.SYS_LANG.'">
					<img class="cd-logo pt-2 pb-1" src="img/logo.png" alt="Logo" title="สำนักงานคณะกรรมการการแข่งขันทางการค้า">
					<img class="cd-logo1 pt-2 pb-1" src="img/logo1.png" alt="Logo" title="สำนักงานคณะกรรมการการแข่งขันทางการค้า">
				</a>'.PHP_EOL;
$txt .="<div class=\"collapse navbar-collapse\" id=\"navbarSupportedContent\">".PHP_EOL;
$txt .="<div class=\"navbar-nav ml-auto\">".PHP_EOL;
$i = 0;
$s_menu_properties = $db->query("SELECT * FROM menu_properties WHERE m_id = '{$m_id}' ORDER BY mp_id ASC");
$a_row = $db->db_num_rows($s_menu_properties);

if($a_row){

while($a_menu = $db->db_fetch_array($s_menu_properties)){
$len = genlen($a_menu['mp_id'],"_");
if($len=="2"){
	$s_menu_properties2 = $db->query("SELECT * FROM menu_properties WHERE m_id = '{$m_id}' AND mp_id LIKE '{$a_menu['mp_id']}_%' ORDER BY mp_id ASC");
	$a_row2 = $db->db_num_rows($s_menu_properties2);
	$link = glink($a_menu['Glink']);
if($a_row2 > 0){
	
$txt .="<div class=\"dropdown pt-1\">".PHP_EOL;
$txt .="<button class=\"btn btn-header btn-link dropdown-toggle\" type=\"button\" data-toggle=\"dropdown\" aria-haspopup=\"true\" aria-expanded=\"false\">".PHP_EOL;
$txt .="".$a_menu['mp_name']."";
$txt .="</button>".PHP_EOL;

	$txt .= menu_child($m_id,$a_menu['mp_id'],$len);
	$txt .="</div>".PHP_EOL;

	}else{
		if($a_menu['Glink']){
$txt .="<div class=\"dropdown pt-1\">".PHP_EOL;
$txt .='<a href="'.$a_menu['Glink'].'">'.PHP_EOL;
$txt .="<button class=\"btn btn-header btn-link \" type=\"button\" >".PHP_EOL;
$txt .=$a_menu['mp_name'];
$txt .="</button>".PHP_EOL;
$txt .="</a>".PHP_EOL;
$txt .="</div>".PHP_EOL;			
				//$txt .='<li class="dropdown-item pt-1"><a href="'.$a_menu['Glink'].'">'.$a_menu['mp_name'].'</a></li>';
				}else{
					$txt .="<div class=\"dropdown pt-1\">".PHP_EOL;
					$txt .='<a href="'.$a_menu['Glink'].'">'.PHP_EOL;
					$txt .="<button class=\"btn btn-header btn-link \" type=\"button\" >".PHP_EOL;
					$txt .=$a_menu['mp_name'];
					$txt .="</button>".PHP_EOL;
					$txt .="</a>".PHP_EOL;
					$txt .="</div>".PHP_EOL;
					
				}
	
}	
	
}
$i++;

	}
		}
$txt .="<div class=\"dropdown pt-1\">".PHP_EOL;
$txt .="<!--<a class=\"btn btn-link\" href=\"search.php?lang=".SYS_LANG."\" role=\"button\"><img src=\"img/search.png\" class=\"\" alt=\"Responsive image\"></a>-->".PHP_EOL;
$txt .="</div>".PHP_EOL;
$txt .="</div>".PHP_EOL;
$txt .="</div>".PHP_EOL;
$txt .="</nav>".PHP_EOL;
$txt .="</div>".PHP_EOL;
$txt .="</header>".PHP_EOL;

	return $txt;
}


function sitemap($m_id,$tem){
	global $db;

$txt = "";

if($tem == '1'){
$txt .="<div class=\"row pt-3\">";
$i = 0;
$s_menu = $db->query("SELECT * FROM menu_properties WHERE m_id = '{$m_id}' ORDER BY mp_id ASC");
if($a_rows = $db->db_num_rows($s_menu)){
while($a_menu = $db->db_fetch_array($s_menu)){
$len = genlen($a_menu['mp_id'],"_");
if($len=="2"){

	$s_menu2 = $db->query("SELECT * FROM menu_properties WHERE m_id = '{$m_id}' AND mp_id LIKE '{$a_menu['mp_id']}_%' ORDER BY mp_id ASC");
	$a_rows2 = $db->db_num_rows($s_menu2);

if($a_rows2 > 0){
$link = glink($a_menu['Glink']);
$txt .="<div class=\"col-xxs-12 col-xs-6 col-sm-6 col-md-3 pt-3\">".PHP_EOL;

if($link){
$txt .="<a href=\"".$link."\">";
		}else{
			$txt .="<a>";
						}
			$txt .="<h2 style=\"height: 45px\" class=\"head-sec\">".$a_menu['mp_name']."</h2>";
			$txt .="<h3 hidden>hidden</h3>";
			$txt .="</a> <ul class=\"nonelist link2\">";
	$txt .=sitemap_child($m_id,$a_menu['mp_id'],$len);
	$txt .="</ul></div>";

}

			$i++;
	}
		}
			}
/*$txt .="<div class=\"col-xxs-12 col-xs-6 col-sm-6 col-md-3\">".PHP_EOL;
$txt .="<ul class=\"nonelist\">".PHP_EOL;

$s_menu_p = $db->query("SELECT * FROM menu_properties WHERE m_id = '{$m_id}' ORDER BY mp_id ASC");
if($a_rows_p = $db->db_num_rows($s_menu_p)){
while($a_menu_p = $db->db_fetch_array($s_menu_p)){
$len = genlen($a_menu_p['mp_id'],"_");

if($len=="2"){
	$s_menu_p2 = $db->query("SELECT * FROM menu_properties WHERE m_id = '{$m_id}' AND mp_id LIKE '{$a_menu_p['mp_id']}_%' ORDER BY mp_id ASC");
	$a_rows_p2 = $db->db_num_rows($s_menu_p2);
	if($a_rows_p2 == 0){
$link = glink($a_menu_p['Glink']);
	if($link){
	$txt .="<a href=\"".$link."\">";
		}else{
			$txt .="<a>";
						}
              $txt .="<h2 style=\"height: 45px\" class=\"head-sec\">".$a_menu_p['mp_name']."</h2></a>";
}
	}
}
	}
      $txt .="</ul>\n</div>".PHP_EOL;*/

$txt .="</div>".PHP_EOL;

}else if($tem == '2'){
$i = 1;
$s_menu = $db->query("SELECT * FROM menu_properties WHERE m_id = '{$m_id}' ORDER BY mp_id ASC");
$a_rows = $db->db_num_rows($s_menu);

if($a_rows){
$txt .="<p>";
while($a_menu = $db->db_fetch_array($s_menu)){
$len = genlen($a_menu['mp_id'],"_");

if($len=="2"){
$link = glink($a_menu['Glink']);
	if($link){
	$txt .="<a href=\"".$link."\">";
		}else{
		$txt .= "<a>";
				}
             $txt .= $a_menu['mp_name']."</a>";
			  if($i <> $a_rows){
				$txt .=" &#124; ";
				}
}
$i++;
	}
	$txt .="</p>".PHP_EOL;

		}
			}

	return $txt;
}


function sitemap_child($m_id,$mp_id,$l){
	global $db ;

$s_menu = $db->query("SELECT * FROM menu_properties WHERE m_id = '{$m_id}' AND mp_id LIKE '{$mp_id}_%' ORDER BY mp_id ASC");
$a_row = $db->db_num_rows($s_menu);
if($a_row > 0){
while($a_menu = $db->db_fetch_array($s_menu)){
	$len = genlen($a_menu['mp_id'],"_");
	if($l+1 == $len){
		$s_menu2 = $db->query("SELECT * FROM menu_properties WHERE m_id = '{$m_id}' AND mp_id LIKE '{$a_menu['mp_id']}_%' ORDER BY mp_id ASC");
		$a_row2 = $db->db_num_rows($s_menu2);
$txt .= "";
								$link = glink($a_menu['Glink']);
								$txt .= "<li>";
								if($link){
									$txt .= "<a href=\"".$link."\">".$a_menu['mp_name']."</a>";
									}else{
										$txt .= "<a>".$a_menu['mp_name']."</a>";
										}
								$txt .= sitemap_child($m_id,$a_menu['mp_id'],$len);
								$txt .= "</li>".PHP_EOL;
	}
}

	}

	return $txt;
}

function calendar_event($temp){
	global $db ;

if(SYS_LANG){
	include('language/lang_'.SYS_LANG.'.php');
}

$month = date("m");
$year = date("Y");
$day = date("d");
$date = $year."-".$month."-".$day;

$wh = "AND ((cal_show_event.event_show_start <= '".date('Y-m-d')."' OR cal_show_event.event_show_start = '0000-00-00'  ) and  (cal_show_event.event_show_end >= '".date('Y-m-d')."' OR cal_show_event.event_show_end = '0000-00-00'  ))";


$s_cal = $db->query("SELECT cal_event.*,
							cal_show_event.event_date_start,
							cal_show_event.event_date_end,
							cal_show_event.event_show_end,
							cal_show_event.event_show_start,
							cal_category.cat_color
							FROM cal_event
							INNER JOIN cal_show_event ON cal_event.event_id = cal_show_event.event_id
							LEFT  JOIN cal_category   ON cal_event.cat_id   = cal_category.cat_id
							WHERE  1=1 {$wh}  							
							ORDER BY cal_show_event.event_date_start DESC LIMIT 0,3");
$a_rows = $db->db_num_rows($s_cal);



$txt = "";

if($temp == '1'){

$txt .='<div class="container">'.PHP_EOL;
$txt .='<div class="head-sec mt-4 mb-4">'.PHP_EOL;
$txt .='<h2>'.$text_calendar_title.'</h2>'.PHP_EOL;
$txt .='<h3 hidden>hidden</h3>';
$txt .='</div>'.PHP_EOL;
if($a_rows){
$txt .='<div class="row">'.PHP_EOL;

	 while($a_data = $db->db_fetch_array($s_cal)){

$txt .='<div class="col-lg-4 col-md-6 col-sm-12 col-12">'.PHP_EOL;
$txt .='<div class="card card-saminar shadow-image mb-4" style="border-radius: 8px;">'.PHP_EOL;
$txt .='<div class="card-body pt-3 pb-3">'.PHP_EOL;
$txt .='<div class="row" style="margin-left: -25px;">'.PHP_EOL;
$txt .='<div class="col-1 col-sm-1 col-lg-1 pl-0 pr-0">'.PHP_EOL;
$txt .='<div class="line-saminar" style="background-color: '.$a_data['cat_color'].' !important;"></div>'.PHP_EOL;
$txt .='</div>'.PHP_EOL;
$txt .='<div class="col-11 col-sm-11 col-lg-11 pl-0">'.PHP_EOL;
	$txt .='<span class="badge badge-saminar badge-secondary mb-2">'.chg_date_cal($a_data['event_date_start']).'</span>'.PHP_EOL;
	$txt .='<div class="title-saminar"><a href="#" data-toggle="modal" data-target="#CalendarModal">'.PHP_EOL;
	$txt .='<h4>'.$a_data['event_title'].'</h4></a></div>'.PHP_EOL;

		/*$txt .="<span><a class=\"btn-share pt-3 pr-2\" style=\"color: #b7b7b7; font-size: 16px;\" href=\"#\"><em class=\"far fa-eye\"></em> &nbsp;0 views </a> </span>".PHP_EOL;*/
		$txt .="<span><a class=\"btn-share\" style=\"color: #b7b7b7; font-size: 16px;\" href=\"#\"> Share :</a> &nbsp;".PHP_EOL;
			$txt .="<a class=\"btn-share\" style=\"color: #B6B6B6 !important;\" href=\"http://www.facebook.com/sharer.php?u=".linkshare()."\" target=\"_blank\" >";
			$txt .="<em class=\"fab fa-facebook-square fa-lg \"></em>&nbsp;".PHP_EOL;
			$txt .="</a>".PHP_EOL;

			$txt .="<a class=\"btn-share\"  style=\"color: #B6B6B6 !important;\" href=\"https://twitter.com/share?url=".linkshare()."&amp;text=&amp;hashtags=\" target=\"_blank\" >";
			$txt .="<em class=\"fab fa-twitter-square fa-lg\"></em>&nbsp;".PHP_EOL;
			$txt .="</a>".PHP_EOL;

			$txt .="<a class=\"btn-share\"  style=\"color: #B6B6B6 !important;\" href=\"https://lineit.line.me/share/ui?url=".linkshare()."\" target=\"_blank\"  title=\"share line\">";
			$txt .="<em class=\"fab fa-line fa-lg\"></em>".PHP_EOL;
			$txt .="</a>".PHP_EOL;
		$txt .="</span>".PHP_EOL;

    $txt .='<hr class="mt-2 mb-2">'.PHP_EOL;
    $txt .='<p class="card-text text-saminar pb-3">'.$a_data['event_detail'].'</p>'.PHP_EOL;
    $txt .='<button type="button" class="btn btn-saminar btn-success" data-toggle="modal"  data-target="#Register-calendar">'.PHP_EOL;
    $txt .=$text_calendar_regis.PHP_EOL;
    $txt .='</button>'.PHP_EOL;
$txt .='</div>'.PHP_EOL;
$txt .='</div>'.PHP_EOL;
$txt .='</div>'.PHP_EOL;
$txt .='</div>'.PHP_EOL;
$txt .='</div>'.PHP_EOL;

	 }

$txt .='</div>'.PHP_EOL;
}
$txt .='</div>'.PHP_EOL;


$txt .='<div class="container-set">';
$txt .='<div class="col-12 text-center mt-2">';
$txt .='<a class="btn-viewall p-2" href="calendar.php" role="button">'.$text_calendar_viewmore.'</a>';
$txt .='</div>';
$txt .='</div>';

}
if($temp == '2'){

$txt .='<div class="col-lg-5">';
$txt .='<div class="head-sec mt-4 mb-4">';
$txt .='<h2>'.$text_calendar_title.'</h2>';
$txt .='</div>';
if($a_rows){
$txt .='<div class="row">';

	 while($a_data = $db->db_fetch_array($s_cal)){
		 
		$_sql_cal_event = $db->query("SELECT 
					cal_registor_event.*
					FROM cal_registor_event 
					WHERE cal_event_id = '{$a_data['event_id']}' ");
		$a_rows_event = $db->db_num_rows($_sql_cal_event);
 
$txt .='<div class="col-lg-12 col-md-12 col-sm-12 col-12">';
$txt .='<div class="card card-saminar shadow-image mb-4" style="border-radius: 8px;">';
$txt .='<div class="card-body pt-3 pb-3">';
$txt .='<div class="row" style="margin-left: -25px;">';
$txt .='<div class="col-1 col-sm-1 col-lg-1 pl-0 pr-0">';
$txt .='<div class="line-saminar" style="background-color: '.$a_data['cat_color'].' !important;"></div>';
$txt .='</div>';
$txt .='<div class="col-11 col-sm-11 col-lg-11 pl-0">';
$txt .='<span class="badge badge-saminar badge-secondary mb-2">'.chg_date_cal($a_data['event_date_start']).'</span>';

$txt .='<div class="title-saminar">';
//$txt .='<a href="#" data-toggle="modal" data-target="#CalendarModal"><h4>'.$a_data['event_title'].'</h4>';
$txt .="<a style=\"cursor:pointer\" onClick=\"Func_Count_Cal('".$a_data['event_id']."');boxPopup('popup/pop_calendar_view.php?event_id=".$a_data['event_id']."');\" ><h4>".$a_data['event_title']."</h4>";
$txt .='</a></div>';
//$txt .='<p class="card-text text-saminar pt-2 pb-2">'.$a_data['event_detail'].'</p>';
$txt .=' <p class="card-text text-saminar pt-2 pb-2">'.$a_data['event_location'].'</p>';

$txt .='<hr class="mt-1 mb-2">';
$txt .='<div class="clearfix mt-1  left-box">';
$txt .='<!-- <span><a class="btn-share pr-3" style="color: #b7b7b7; font-size: 16px;" href="#"><em class="far fa-eye"></em> &nbsp;325 views</a></span> -->';

//$txt .=share_buttons_all('calendar',$a_data['event_id'],'1');
	$txt .="<span><a class=\"btn-share\" style=\"color: #b7b7b7; font-size: 16px;\" href=\"#\"> Share :</a> &nbsp;".PHP_EOL;
	$txt .=share_buttons_all('calendar_views',$a_data['event_id'],'cid','1');		
			/*$txt .="<a class=\"btn-share\" style=\"color: #B6B6B6 !important;\" href=\"http://www.facebook.com/sharer.php?u=".linkshare()."\" target=\"_blank\" >";
			$txt .="<em class=\"fab fa-facebook-square fa-lg \"></em>&nbsp;".PHP_EOL;
			$txt .="</a>".PHP_EOL;

			$txt .="<a class=\"btn-share\"  style=\"color: #B6B6B6 !important;\" href=\"https://twitter.com/share?url=".linkshare()."&amp;text=&amp;hashtags=\" target=\"_blank\" >";
			$txt .="<em class=\"fab fa-twitter-square fa-lg\"></em>&nbsp;".PHP_EOL;
			$txt .="</a>".PHP_EOL;

			$txt .="<a class=\"btn-share\"  style=\"color: #B6B6B6 !important;\" href=\"https://lineit.line.me/share/ui?url=".linkshare()."\" target=\"_blank\"  title=\"share line\">";
			$txt .="<em class=\"fab fa-line fa-lg\"></em>".PHP_EOL;
			$txt .="</a>".PHP_EOL;*/
		
		$txt .="</span>".PHP_EOL;
		
$txt .='<br>';		
$txt .='</div>';

if($a_data['event_registor'] == 'Y'){
		if($a_data['event_registor_num'] > $a_rows_event){ //data-target=\"#Register-calendar\" 
$txt .="<div class=\"right-box\"><button type=\"button\" class=\"btn btn-saminar btn-success pad-btn-calendar\"  data-toggle=\"modal\" onClick=\"boxPopup('popup/pop_calendar_registor.php?event_id=".$a_data['event_id']."')\" >".PHP_EOL;
$txt .=$text_calendar_regis.PHP_EOL;
$txt .='</button></div>'.PHP_EOL;
		}
}
$txt .=' </div>';
$txt .='</div>';
$txt .='</div>';
$txt .='</div>';
$txt .='</div>';
	 }
$txt .='</div>';
}
$txt .='<div class="container-set">';
$txt .='<div class="col-12 text-center mt-2">';
$txt .='<a class="btn-viewall p-2" href="calendar.php?lang='.SYS_LANG.'" role="button">'.$text_calendar_viewmore.'</a>';
$txt .='</div>';
$txt .='</div>';
$txt .='</div>';
}
	
	return $txt;

}

function vdo($vdo,$temp,$title,$lim){
	global $db;
	
if(SYS_LANG){
	include('language/lang_'.SYS_LANG.'.php');
}

if(!empty($vdo)){
	$c = " where vdog_id = '{$vdo}' ";
}
$txt = "";

$vdo_LIST='LIMIT 0,'.$lim;
$s_vdo = $db->query("SELECT vl.*, vg.vdog_downloadable FROM vdo_list vl JOIN vdo_group vg ON vg.vdog_id=vl.vdo_group ".$c." ORDER BY vdo_id DESC {$vdo_LIST}");

$txt .='<div class="row">'.PHP_EOL;
$txt .='<div class="col-lg-6">'.PHP_EOL;
$txt .='<div class="head-sec mt-4 mb-4">'.PHP_EOL;
$txt .='<h2>'.$title.'</h2>'.PHP_EOL;
$txt .='</div>'.PHP_EOL;


while($a_vdo = $db->db_fetch_array($s_vdo)){
$filetype = explode('.',$a_vdo['vdo_filename']);
$fileyoutube = explode('=',$a_vdo['vdo_fileyoutube']);

$firstDetail=$a_vdo['vdo_detail'];
if($a_vdo['vdo_detail'] != ""){
	$vdo_detail = $a_vdo['vdo_detail'];
}else{
	$vdo_detail = "&nbsp;";	
}

if($a_vdo['vdo_filename'] != ""){
	$type = "mp4";
}else{
	$type = "youtube";
}
$vdo_fileyoutube = str_replace('https://www.youtube.com/watch?v=', '', $a_vdo['vdo_fileyoutube']);
if($a_vdo['vdo_image'] != ""){ $vdo_image = $a_vdo['vdo_image']; }

$txt .='<div class="col-lg-12 mb-4">'.PHP_EOL;
$txt .='<div class="card shadow-image">'.PHP_EOL;
$txt .='<div class="w-100 p-2 vdo-height">'.PHP_EOL;

if($a_vdo['vdo_filename'] != ""){
$txt .="<video class=\"mejs-wmp border-redius8px w-100 h-100\" id=\"vplayer\" width=\"100%\" src=\"".$a_vdo['vdo_filename']."\" poster=\"".$vdo_image."\"   type=\"video/mp4\"
	controls=\"controls\" preload=\"none\"></video>".PHP_EOL;
 }else{ 
$txt .="<iframe  class=\"mejs-wmp border-redius8px w-100 h-100 \" width=\"100%\"    src=\"//www.youtube.com/embed/".$vdo_fileyoutube."?wmode=transparent&#038;&#038;iv_load_policy=3&#038;modestbranding=1&#038;rel=0&#038;autohide=1&#038;autoplay=0&#038;mute=1\" class=\"arve-inner\" allowfullscreen frameborder=\"0\" scrolling=\"no\"></iframe>".PHP_EOL;
}	


$txt .='</div>'.PHP_EOL;
$txt .='<a href="#"><h3 class="pt-0 pl-3 pr-3 pb-3" style="height: 60px;">'.$a_vdo['vdo_name'].'</h3></a>'.PHP_EOL;
$txt .='</div>'.PHP_EOL;
$txt .='</div>'.PHP_EOL;
}


$txt .="<script> ".PHP_EOL;
$txt .="$('audio,video').mediaelementplayer({".PHP_EOL;
	//mode: 'shim',
$txt .="	success: function(player, node){".PHP_EOL;
$txt .="		$('#' + node.id + '-mode').html('mode: ' + player.pluginType);".PHP_EOL;
$txt .="	}".PHP_EOL;
$txt .="});".PHP_EOL;

$txt .="</script>".PHP_EOL;
$txt .="<script type=\"text/javascript\" src=\"../../js/mediaelement/build/jquery.js\"></script>".PHP_EOL;
$txt .="<script src=\"../../js/mediaelement/build/mediaelement-and-player.min.js\"></script>\n";
$txt .="<link rel=\"stylesheet\" href=\"../../js/mediaelement/build/mediaelementplayer.min.css\" />".PHP_EOL;
$txt .="<link rel=\"stylesheet\" href=\"../../js/mediaelement/build/mejs-skins.css\" />".PHP_EOL;



$txt .='<div class="col-12 text-center mt-4 mb-3">'.PHP_EOL;
$txt .="<a class=\"btn-viewall p-2 mb-3\"  href=\"vdo-category.php?lang=".SYS_LANG."\">".PHP_EOL;
$txt .=$text_calendar_viewmore.PHP_EOL;
$txt .="</a>".PHP_EOL;
$txt .="</div>".PHP_EOL;

$txt .="</div>".PHP_EOL;

		return $txt;
}

function article_to($cid,$temp,$lim){
		global $db;

if(SYS_LANG){
	include('language/lang_'.SYS_LANG.'.php');
}

$lang = SYS_LANG;

$s_group = $db->query("SELECT * FROM  article_group WHERE c_id = '{$cid}'");
$a_group = $db->db_fetch_array($s_group);

if(SYS_LANG != 'TH'){
$lang_detail = array();
$sql_group2 ="SELECT * FROM  article_group,lang_article_group,lang_config WHERE lang_article_group.c_id =article_group.c_id AND lang_config.lang_config_id = lang_article_group.lang_name AND lang_config.lang_config_suffix = '{$lang}' AND  article_group.c_id = '{$cid}'";
$query_group2 = $db->query($sql_group2);
while($U2 = $db->db_fetch_array($query_group2)){
	array_push($lang_detail,$U2['lang_detail']);
	}
	$a_group['c_name'] = $lang_detail[0];
}

$txt ="";

$glo_sql = " ( c_id = '{$cid}' ";
		if($a_group['c_show_subnew'] == "Y"){
		tochild($nid);
		}
		if($a_group["c_type"] == 'M'){
		tomultigroup($nid);
		}
$glo_sql .= " ) ";

$date_now = (date("Y")+543).'-'.date('m-d H:i:s');

if(SYS_LANG != 'TH'){

$s_article = $db->query("SELECT *
FROM article_list,lang_article_list ,lang_config
WHERE article_list.n_id = lang_article_list.c_id
AND lang_config.lang_config_id = lang_article_list.lang_name
AND lang_config.lang_config_suffix = '{$lang}'
AND lang_article_list.lang_field = 'n_topic'
AND article_list.c_id = '{$cid}'
AND n_approve = 'Y'
AND (('{$date_now}' between article_list.n_date_start  AND article_list.n_date_end) OR (article_list.n_date_start = '' AND article_list.n_date_end = ''))
GROUP BY lang_article_list.c_id
ORDER BY n_date DESC,n_timestamp DESC LIMIT 0,{$lim}");

}else{

	$s_article = $db->query("SELECT * FROM article_list WHERE {$glo_sql} AND n_approve = 'Y'
	AND (('{$date_now}' between n_date_start  AND n_date_end) OR (n_date_start = '' AND n_date_end = ''))
	ORDER BY n_date DESC,n_timestamp DESC LIMIT 0,{$lim}");

	}

$a_rows = $db->db_num_rows($s_article);

if($temp == '1'){


$txt .="<section class=\"pb-4\" style=\"background-color: #fff;\">".PHP_EOL;
$txt .="<div class=\"container\">".PHP_EOL;
$txt .="<div class=\"head-sec pt-4 pb-3\">".PHP_EOL;
$txt .="<h2>".PHP_EOL;
$txt .=$a_group['c_name'];

if($a_group['c_rss']=="Y"){

$txt .="<a href=\"rss/group".$U['c_id'].".xml\"  class=\"fa-stack fa-xs\"  title=\"RSS ".$U['c_name']."\" />".PHP_EOL;
//$txt .="<a href=\"#\" class=\"fa-stack fa-xs\">".PHP_EOL;
$txt .="<em class=\"fas fa-square fa-stack-1x pl-2\" style=\"color: #fff; text-align: left;\"></em>".PHP_EOL;
$txt .="<em class=\"fas fa-rss-square fa-stack-1x fa-inverse pl-2\" style=\"color: #ff7f00; text-align: left;\"></em>".PHP_EOL;
$txt .="</a>".PHP_EOL;
}
$txt .="</h2>".PHP_EOL;
$txt .="<h3 hidden>hidden</h3>";
$txt .="</div>".PHP_EOL;




if($a_rows > 0){

$txt .="<div class=\"d-none d-sm-block d-md-block d-lg-block\">".PHP_EOL;
$txt .="<div class=\"card-deck mb-3\">".PHP_EOL;
$txt .="<div class=\"row\">".PHP_EOL;
$i=1;
while($a_article = $db->db_fetch_array($s_article)) {

if(SYS_LANG != 'TH'){
	$a_article['n_topic'] = $a_article['lang_detail'];
	}

$txt .="<div class=\"card".$i." col-lg-4 col-md-6 p-0\">".PHP_EOL;
$txt .="<div class=\"card shadow-sm bg-card\">".PHP_EOL;
	
if($a_article['picture'] != ""){

if(file_exists("images/article/news".$a_article['n_id']."/".$a_article['picture'])){

$txt .="<img src=\"".$Website."images/article/news".$a_article['n_id']."/".$a_article['picture']."\" alt=\"".$a_article['n_topic']."\" class=\"card-img-top\"/>".PHP_EOL;
}else{
				$ccc= explode(".",$a_article['picture']);
				$bbb = explode("_",$ccc[0]);
				if(file_exists("../".$a_article['n_sharename'].'/images/article/news'.$bbb[1]."/".$a_article['picture'])){

$txt .="<img src=\"../".$a_article['n_sharename']."/images/article/news".$bbb[1]."/".$a_article['picture']."\"  alt=\"".$a_article['n_topic']."\" class=\"card-img-top\"  />".PHP_EOL;

}
	}

}else{

$txt .="<img src=\"img/default-article.jpg\"  alt=\"".$a_article['n_topic']."\" class=\"card-img-top\" />".PHP_EOL;

}
$txt .="<div class=\"card-body height-auto hover-card pt-3\">".PHP_EOL;
$txt .="<div class=\"card-text\">".PHP_EOL;
if($a_article['news_use'] == "2" OR $a_article['news_use'] == "3"){
$txt .="<a href=\"article-views.php?nid=".$a_article['n_id']."&lang=".SYS_LANG."\" target=\"".$a_article['target']."\">";
	}elseif($a_article['news_use'] == "4"){
		$txt .="<a href=\"ewt_dl.php?nid=".$a_article['n_id']."\" target=\"".$a_article['target']."\">";
		}else{
		$txt .="<a href=\"ewt_dl_link.php?nid=".$a_article['n_id']."\" target=\"".$a_article['target']."\">";
		}

$txt .="<h4>".PHP_EOL;
$txt .=$a_article['n_topic'].PHP_EOL;

$date_exp = eregi_replace("-","",$a_article["expire"]);
$date_now1 = (date("Y")+543).date("md");

if(file_exists("icon/".$a_article['logo']) AND $a_article['logo'] != '' AND $date_exp >= $date_now1){
$txt .=" <img  src=\"icon/".$a_article["logo"]."\" align=\"absmiddle\" border=\"0\" alt=\"icon\" title=\"icon\">"; 							
}	
$txt .="</h4></a>".PHP_EOL;
$txt .="</div>".PHP_EOL;
$txt .="</div>".PHP_EOL;

$txt .="<div class=\"card-footer\">".PHP_EOL;
$txt .="<span class=\"pr-3\"><a class=\"btn-share\" style=\"color: #b7b7b7; font-size: 16px;\" href=\"#\"><em class=\"far fa-calendar-alt\"></em> &nbsp".chg_date_article($a_article['n_date'])."</a></span>".PHP_EOL;
$txt .="<span>".PHP_EOL;
$txt .=share_buttons_all('article-views',$a_article['n_id'],'nid','1');
$txt .="</span>".PHP_EOL;
$txt .="</div>".PHP_EOL;

						

$txt .="</div>".PHP_EOL;
$txt .="</div>".PHP_EOL;
$i++;
}
$txt .="</div>".PHP_EOL;
$txt .="</div>".PHP_EOL;
$txt .="</div>".PHP_EOL;
}

$txt .="</div>".PHP_EOL;

$txt .="<div class=\"owl-carousel owl-theme d-lg-none d-md-none d-sm-none d-block mt-4\" id=\"news\">".PHP_EOL;
/*-- mobile slide banner --*/
if(SYS_LANG != 'TH'){
$s_article_m = $db->query("SELECT *
FROM article_list,lang_article_list ,lang_config
WHERE article_list.n_id = lang_article_list.c_id
AND lang_config.lang_config_id = lang_article_list.lang_name
AND lang_config.lang_config_suffix = '{$lang}'
AND lang_article_list.lang_field = 'n_topic'
AND article_list.c_id = '{$cid}'
AND n_approve = 'Y'
GROUP BY lang_article_list.c_id
ORDER BY n_date DESC,n_timestamp DESC LIMIT 0,{$lim}");

}else{

	$s_article_m = $db->query("SELECT * FROM article_list WHERE {$glo_sql} AND n_approve = 'Y' ORDER BY n_date DESC,n_timestamp DESC LIMIT 0,{$lim}");

	}
$a_rows_m = $db->db_num_rows($s_article_m);

if($a_rows_m > 0){ 



while($a_article_m = $db->db_fetch_array($s_article_m)) {

if(SYS_LANG != 'TH'){
	$a_article_m['n_topic'] = $a_article_m['lang_detail'];
	}
	
$txt .="<div class=\"item\">".PHP_EOL;
$txt .="<div class=\"card shadow-sm bg-card\">".PHP_EOL;
if($a_article_m['picture'] != ""){

if(file_exists("images/article/news".$a_article_m['n_id']."/".$a_article_m['picture'])){

$txt .="<img src=\"".$Website."images/article/news".$a_article_m['n_id']."/".$a_article_m['picture']."\" alt=\"".$a_article_m['n_topic']."\" class=\"card-img-top\"/>".PHP_EOL;
}else{
				$ccc= explode(".",$a_article_m['picture']);
				$bbb = explode("_",$ccc[0]);
				if(file_exists("../".$a_article_m['n_sharename'].'/images/article/news'.$bbb[1]."/".$a_article_m['picture'])){

$txt .="<img src=\"../".$a_article_m['n_sharename']."/images/article/news".$bbb[1]."/".$a_article_m['picture']."\"  alt=\"".$a_article_m['n_topic']."\" class=\"card-img-top\"  />".PHP_EOL;

}
	}

}else{

$txt .="<img src=\"img/default-article.jpg\"  alt=\"".$a_article_m['n_topic']."\" class=\"card-img-top\" />".PHP_EOL;

}
//$txt .="<img src=\"img/n1.jpg\" class=\"card-img-top\" alt=\"...\">".PHP_EOL;
$txt .="<div class=\"card-body height-auto hover-card pt-3\">".PHP_EOL;
$txt .="<div class=\"card-text\">".PHP_EOL;

if($a_article_m['news_use'] == "2" OR $a_article_m['news_use'] == "3"){
$txt .="<a href=\"article-views.php?nid=".$a_article_m['n_id']."&lang=".SYS_LANG."\" target=\"".$a_article_m['target']."\">";
	}elseif($a_article_m['news_use'] == "4"){
		$txt .="<a href=\"ewt_dl.php?nid=".$a_article_m['n_id']."\" target=\"".$a_article_m['target']."\">";
		}else{
		$txt .="<a href=\"ewt_dl_link.php?nid=".$a_article_m['n_id']."\" target=\"".$a_article_m['target']."\">";
		}
		
$txt .="<h4>".PHP_EOL;
$txt .=$a_article_m['n_topic'].'</h4>'.PHP_EOL;

$date_exp = eregi_replace("-","",$a_article_m["expire"]);
$date_now1 = (date("Y")+543).date("md");

if(file_exists("icon/".$a_article_m['logo']) AND $a_article_m['logo'] != '' AND $date_exp >= $date_now1){
$txt .=" <img  src=\"icon/".$a_article_m["logo"]."\" align=\"absmiddle\" class=\"card-img-top\" border=\"0\" alt=\"icon\" title=\"icon\">"; 							
}	
$txt .="</a>".PHP_EOL;
$txt .="</div>".PHP_EOL;
$txt .="</div>".PHP_EOL;
$txt .="<div class=\"card-footer\">".PHP_EOL;
$txt .="<span class=\pr-3\"><a class=\"btn-share\" style=\"color: #b7b7b7; font-size: 16px;\" href=\"#\"><em class=\"far fa-calendar-alt\"></em> &nbsp;".chg_date_article($a_article_m['n_date'])."</a></span>".PHP_EOL;
$txt .="<span>".PHP_EOL;
$txt .=share_buttons_all('article-views',$a_article_m['n_id'],'nid','1');
$txt .="</span>".PHP_EOL;
$txt .="</div>".PHP_EOL;
$txt .="</div>".PHP_EOL;
$txt .="</div>".PHP_EOL;

}
	}
	$txt .="</div>".PHP_EOL;

$txt .="<div class=\"container-set\">".PHP_EOL;
$txt .="<div class=\"col-12 text-center mt-2\">".PHP_EOL;
$txt .="<a class=\"btn-viewall p-2\" href=\"article-more.php?cid=".$cid."&lang=".SYS_LANG."\" onclick=\"Func_Menu_left('0010','0010','0010_0002')\" role=\"button\">";
$txt .=$text_article_viewmore;
$txt .="</a>".PHP_EOL;
$txt .="</div>".PHP_EOL;
$txt .="</div>".PHP_EOL;


$txt .="</section>".PHP_EOL;


return $txt;
}
}

function pagination($statement,$per_page=10,$page=1,$url='?'){
    global $db;

    $s_sql = "{$statement}";
	$r_result  = $db->query($s_sql);
	$a_rows = $db->db_fetch_row($r_result);
    $total = $a_rows[0];
    $adjacents = "2";

    $prevlabel = "Prev";
    $nextlabel = "Next";
	$lastlabel = "Last";
    $firstlabel = "First";


    $page = ($page == 0 ? 1 : $page);
    $start = ($page - 1) * $per_page;

    $prev = $page - 1;
    $next = $page + 1;

    $lastpage = ceil($total/$per_page);

    $lpm1 = $lastpage - 1; // //last page minus 1


if($lastpage >= $page){
    $pagination = "";
	$pagination .= "<div class='col-lg-12 col-md-12 col-sm-12 col-12 p-0'>";
	$pagination .= "<div class='row'>";
	$pagination .= "<div class='col-lg-6 col-md-6'><span class='pagination'>Page {$page} of {$lastpage}</span></div>";
	$pagination .= "<div class='col-lg-6 col-md-6'><nav aria-label='Page navigation example'>";
    if($lastpage > 1){
        $pagination .= "<ul class='pagination justify-content-end '>";

        if ($page > 1){
			$pagination.= "<li class='page-item' ><a class='page-link text-dark' href='{$url}page=1#table-view'>{$firstlabel}</a></li>";
			$pagination.= "<li class='page-item' ><a class='page-link text-dark' href='{$url}page={$prev}#table-view'>{$prevlabel}</a></li>";
		}
        if ($lastpage < 7 + ($adjacents * 2)){
            for ($counter = 1; $counter <= $lastpage; $counter++){
                if ($counter == $page)
                    $pagination.= "<li class='page-item active'><a class='page-link text-dark' >{$counter}</a></li>";
                else
                    $pagination.= "<li class='page-item'><a class='page-link text-dark' href='{$url}page={$counter}#table-view'>{$counter}</a></li>";
            }

        } elseif($lastpage > 5 + ($adjacents * 2)){

            if($page < 1 + ($adjacents * 2)) {

                for ($counter = 1; $counter < 4 + ($adjacents * 2); $counter++){
                    if ($counter == $page)
                        $pagination.= "<li class='page-item active' ><a class='page-link text-dark'>{$counter}</a></li>";
                    else
                        $pagination.= "<li class='page-item' ><a class='page-link text-dark' href='{$url}page={$counter}#table-view'>{$counter}</a></li>";
                }
                $pagination.= "<li class='page-item disabled'><a class='page-link text-dark' >...</a></li>";
                $pagination.= "<li class='page-item' ><a class='page-link text-dark' href='{$url}page={$lpm1}#table-view'>{$lpm1}</a></li>";
                $pagination.= "<li class='page-item' ><a class='page-link text-dark' href='{$url}page={$lastpage}#table-view'>{$lastpage}</a></li>";

            } elseif($lastpage - ($adjacents * 2) > $page && $page > ($adjacents * 2)) {

                $pagination.= "<li class='page-item' ><a class='page-link text-dark' href='{$url}page=1#table-view'>1</a></li>";
                $pagination.= "<li class='page-item' ><a class='page-link text-dark' href='{$url}page=2#table-view'>2</a></li>";
                $pagination.= "<li class='page-item disabled'><a class='page-link text-dark' >...</a></li>";
                for ($counter = $page - $adjacents; $counter <= $page + $adjacents; $counter++) {
                    if ($counter == $page)
                        $pagination.= "<li class='page-item active' ><a class='page-link text-dark'>{$counter}</a></li>";
                    else
                        $pagination.= "<li class='page-item' ><a class='page-link text-dark' href='{$url}page={$counter}#table-view'>{$counter}</a></li>";
                }
                $pagination.= "<li class='page-item disabled'><a class='page-link text-dark' >...</a></li>";
                $pagination.= "<li class='page-item' ><a class='page-link text-dark' href='{$url}page={$lpm1}#table-view'>{$lpm1}</a></li>";
                $pagination.= "<li class='page-item' ><a class='page-link text-dark' href='{$url}page={$lastpage}#table-view'>{$lastpage}</a></li>";

            } else {

                $pagination.= "<li class='page-item' ><a class='page-link text-dark' href='{$url}page=1#table-view'>1</a></li>";
                $pagination.= "<li class='page-item' ><a class='page-link text-dark' href='{$url}page=2#table-view'>2</a></li>";
                $pagination.= "<li class='page-item disabled'><a class='page-link text-dark'>...</a></li>";
                for ($counter = $lastpage - (2 + ($adjacents * 2)); $counter <= $lastpage; $counter++) {
                    if ($counter == $page)
                        $pagination.= "<li class='page-item active' ><a class='page-link text-dark current'>{$counter}</a></li>";
                    else
                        $pagination.= "<li class='page-item ' ><a class='page-link text-dark' href='{$url}page={$counter}#table-view'>{$counter}</a></li>";
                }
            }
        }

            if ($page < $counter - 1) {
				$pagination.= "<li class='page-item' ><a class='page-link text-dark' href='{$url}page={$next}#table-view'>{$nextlabel}</a></li>";
				$pagination.= "<li class='page-item' ><a class='page-link text-dark' href='{$url}page=$lastpage#table-view'>{$lastlabel}</a></li>";
			}

        $pagination.= "</ul>";

		$pagination.= "<ul class='pagination d-xl-none'>";
		if ($page > 1){
        $pagination.= "<li class='page-item'><a class='page-link text-dark'href='{$url}page={$prev}#table-view'>{$prevlabel}</a></li>";
		}else{
			$pagination.= "<li class='page-item disabled'><a class='page-link text-dark'>{$prevlabel}</a></li>";
		}

		if($lastpage == $page){
		$pagination.= "<li class='page-item disabled' ><a class='page-link text-dark'>{$nextlabel}</a></li>";
		}else{
			$pagination.= "<li class='page-item ' ><a class='page-link text-dark' href='{$url}page={$next}#table-view'>{$nextlabel}</a></li>";
		}

        $pagination.= "</ul>";
    }
   $pagination.= "</nav></div>";
   $pagination.= "</div>";
   $pagination.= "</div>";
}
    return $pagination;
}
?>