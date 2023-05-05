<?php
$nid = $_GET['nid'];
$vdo = $_GET['vdo'];

function convert_datedb_txt($date){
	$date = substr($date,0,10);
	if($date){
		$arr = explode("-",$date);
		$date = ($arr[2].'/'.$arr[1].'/'.($arr[0]+543));
		return $date;
	}//if
}//fuction


function genlen($data,$op){
	$s = explode($op,$data);
	return count($s);
}

function tochild($cid){
			 global $db;
			 global $glo_sql;
				$sqlc = $db->query("SELECT c_id FROM article_group WHERE c_parent = '{$cid}' ");
				while($cr = $db->db_fetch_row($sqlc)){
					$glo_sql .= " OR c_id = '{$cr[0]}' ";
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

			 
function share_face($nid){
	global $db,$EWT_FOLDER_USER;
	$PHPSELF = explode('/',$_SERVER["PHP_SELF"]);
	$exc = $db->query("select * from article_list where n_id = '".$nid."'");
	$row = $db->db_fetch_array($exc);
	if($row['n_sharename']!=""){
		$paths = $PHPSELF[1]."/ewt/".$row['n_sharename']."/";
	}else{
		$paths = $PHPSELF[1]."/ewt/".$EWT_FOLDER_USER."/";
		//$paths = $PHPSELF[1]."/";
	}

	return "http://".$_SERVER['HTTP_HOST']."/".$paths;	
}	
	
function nidshare($nid){
	global $db;
	
	$exc = $db->query("select * from article_list where n_id = '".$nid."'");
	$row = $db->db_fetch_array($exc);
	$imgs1 = explode('_',$row["picture"]);
	$imgs2 = explode('.',$imgs1[1]);	
	return $imgs2[0];
		
}

function linkshare(){
	global $db;
	
	$s_host = $_SERVER['HTTP_HOST'];	
	$s_name = $_SERVER['SCRIPT_NAME'];
	$s_url = $_SERVER['REQUEST_URI'];	

	return "http://".$s_host.$s_url;
		
}

function gentitle(){
	global $db,$EWT_DB_NAME;
	
	$db->query("USE ".$EWT_DB_NAME);
	$s_user_info = $db->query("SELECT * FROM site_info WHERE site_info_id = '1' ");
	$a_row = $db->db_num_rows($s_user_info);   
	if($a_row){	
	$a_user = $db->db_fetch_array($s_user_info);
	
	$txt ="".$a_user['site_info_title']."";

	return $txt;

	}
}

function meta_share($nid,$vdo){
	global $db,$EWT_FOLDER_USER;

$PHPSELF = explode('/',$_SERVER["PHP_SELF"]);
$paths = $PHPSELF[1]."/ewt/".$EWT_FOLDER_USER."/";	
	
if($nid){
$s_article = $db->query("SELECT * FROM article_list WHERE n_id = '{$nid}' AND n_approve = 'Y' "); 
$a_row = $db->db_num_rows($s_article);             
$a_article = $db->db_fetch_array($s_article);

	
if($a_article["picture"]!=null){
		$img = "images/article/news".nidshare($a_article['n_id'])."/".$a_article["picture"];
	}else{
		$img = "images/news/1-1.jpg";
	}	
	$share_img = share_face($nid).$img; 
	
$keyword = 	$a_article["n_topic"];
$description = $a_article["n_topic"];	
$og_type = "article";
$og_description = $a_article["n_topic"];
$og_image = $share_img;

}else if($vdo){
	
$vdo = convertDeCode64($vdo);	
$sql_vdo = "SELECT * 
FROM vdo_list
WHERE vdo_id = '{$vdo}' ";
$query_vdo = $db->query($sql_vdo);
$a_vdo = $db->db_fetch_array($query_vdo);

$vdo_fileyoutube = str_replace('https://www.youtube.com/watch?v=', '', $a_vdo['vdo_fileyoutube']);

	if($a_vdo['vdo_filename'] != ""){	
		if($a_vdo['vdo_image'] != ""){ 
			$vdo_image = "http://".$_SERVER['HTTP_HOST']."/".$paths.$a_vdo['vdo_image']; 
			}	
		}else{ 
			$vdo_image = "https://i.ytimg.com/vi/".$vdo_fileyoutube."/sddefault.jpg";
		} 
	
$keyword = $a_vdo['vdo_name'];
$description = $a_vdo['vdo_name'];	
$og_type = "website";
$og_description = $a_vdo['vdo_name'];	
$og_image = $vdo_image;
}else{
$keyword = gentitle();
$og_type = "website";
$og_image  = "http://".$_SERVER['HTTP_HOST']."/".$paths."images/news/1-1.jpg";
	
}
	
$txt ="";	
$txt .="<meta name=\"description\" content=\"".gentitle().",".$keyword ."  \"/>".PHP_EOL;
$txt .="<meta name=\"keyword\" content=\"".gentitle().",".$keyword ." \"/>".PHP_EOL;
$txt .="<meta property=\"og:title\" content=\"".$keyword."\"/>".PHP_EOL;
$txt .="<meta property=\"og:type\" content=\"".$og_type."\"/>".PHP_EOL;
$txt .="<meta property=\"og:url\" content=\"".linkshare()."\"/>".PHP_EOL;
$txt .="<meta property=\"og:image\" content=\"".$og_image."\"/>".PHP_EOL;
$txt .="<meta property=\"og:site_name\" content=\"".gentitle()."\"/>".PHP_EOL;
$txt .="<meta property=\"og:description\" content=\"".gentitle().",".$og_description."\"/>".PHP_EOL;

return $txt;

}

function genlogo(){
	global $db;
	
$title = gentitle();	
$s_title = explode( 'สำนักงานการท่องเที่ยวและกีฬา', $title );

if($s_title[1]){
$txt ="";
$txt .="<div>".PHP_EOL;
$txt .="<div class=\"col-md-12 col-lg-3 p0 md-center\">".PHP_EOL;
$txt .="<a href=\"index.php\"><img src=\"images/logo.png\" class=\"logo\"></a>";
$txt .="</div>".PHP_EOL;
$txt .="<div class=\"col-md-12 col-lg-9 p0 md-center\">".PHP_EOL;
$txt .="<a href=\"index.php\">";
$txt .="<h4>".PHP_EOL;
$txt .="<span class=\"brand\">";
$txt .="<span class=\"switching\" >";
$txt .=$s_title[0]."สำนักงานการท่องเที่ยวและกีฬา";
$txt .="</span>";
$txt .="</span>".PHP_EOL;
$txt .="<br>";
$txt .="<span class=\"switching\">";
$txt .=$s_title[1];
$txt .="</span>".PHP_EOL;
$txt .="</h4>".PHP_EOL;
$txt .="</a>";
$txt .="</div>".PHP_EOL;
$txt .="</div>".PHP_EOL;

	return $txt;
	
/*}else{	
$txt ="<script type=\"text/javascript\">";
$txt .="window.location.href = '../../404.html'; ";
$txt .="</script>";	

return $txt;*/

}
}


function articleparent($id){
	 global $db;
	 global $filename;
	 global $lang_shw;
	 if($lang_shw != ''){
	 $sql =$db->query("SELECT * FROM  article_group,lang_article_group,lang_config WHERE lang_article_group.c_id = article_group.c_id AND lang_config.lang_config_id = lang_article_group.lang_name AND lang_config.lang_config_suffix = '".$lang_shw."' AND  article_group.c_id = '".$id."'");
	  }else{
	 $sql = $db->query("SELECT * FROM article_group WHERE c_id = '$id' ");
	 }
	 	if($db->db_num_rows($sql)){
	 		$G = $db->db_fetch_array($sql);
			 if($lang_shw != ''){	
			$G['c_name'] = $G['lang_detail'];
			 }
			
			$txt1 = "<li class=\"active\"> <a href = \"more_news.php?cid=".$G["c_id"]."\">".$G["c_name"]."</a></li>";
			if($G['c_parent'] != "0" AND $G['c_parent'] != ""){
				$txt .= articleparent($G['c_parent']);
			}
			
	 	}
		return $txt.$txt1;
	 }


function article_comment($nid,$temp){
	global $db;
	
$txt ="";
$txt .="<div class=\"container\">".PHP_EOL;
$txt .="<h1>ร่วมแสดงความคิดเห็น</h1>".PHP_EOL;
$txt .="<h3>จำนวน 2 ความคิดเห็น</h3>".PHP_EOL;


$txt .="<div class=\"panel panel-info\">".PHP_EOL;
$txt .="<div class=\"panel-heading\"><strong><i class=\"fa fa-commenting\" aria-hidden=\"true\"></i> ความคิดเห็นที่ #2</strong></div>".PHP_EOL;
$txt .="<div class=\"panel-body\">Comment 2</div>".PHP_EOL;
$txt .="<div class=\"panel-footer\">".PHP_EOL;
$txt .="<span class=\"glyphicon glyphicon-user\" aria-hidden=\"true\"></span> น้าเดช น้าเดช".PHP_EOL;
$txt .="<i class=\"fa fa-calendar-o\" aria-hidden=\"true\"></i> 28/04/2017".PHP_EOL;
$txt .="<span class=\"glyphicon glyphicon-time\" aria-hidden=\"true\"></span> 10:48:41".PHP_EOL;
$txt .="<span class=\"glyphicon glyphicon-trash\" aria-hidden=\"true\"></span> <a href=\"#\" data-toggle=\"modal\" data-target=\"#myModalDelComment\" title=\"แจ้งลบ\">แจ้งลบ</a>".PHP_EOL;
$txt .="</div>".PHP_EOL;
$txt .="</div>".PHP_EOL;
				

				
$txt .="<div class=\"panel panel-default\">".PHP_EOL;
$txt .="<div class=\"panel-heading\"><strong>ร่วมแสดงความคิดเห็น</strong></div>".PHP_EOL;
$txt .="<div class=\"panel-body\">".PHP_EOL;
$txt .="<div class=\"alert alert-warning\" role=\"alert\">กรุณาแสดงความคิดเห็นอย่างสร้างสรรค์ หน่วยงานจะไม่รับผิดชอบต่อความคิดเห็นใดๆ ทั้งสิ้น เพราะไม่สามารถระบุได้ว่าเป็นความจริง ผู้อ่านจึงควรใช้วิจารณญาณในการกลั่นกรอง หรือถ้าท่านพบเห็นข้อความใดที่ขัดต่อกฎหมายและศีลธรรม หรือเป็นการกลั่นแกล้งเพื่อให้เกิดความเสียหาย ต่อบุคคล หรือหน่วยงานใด กรุณาแจ้งมาที่ ".PHP_EOL;
$txt .="<a href=\"#\">ผู้ดูแลระบบ </a>เพื่อให้ระบบทราบและทำการลบข้อความนั้น ออกจากระบบต่อไปขอขอบพระคุณล่วงหน้า มา ณ โอกาสนี้</div>".PHP_EOL;
$txt .="<form class=\"form-horizontal\">".PHP_EOL;
$txt .="<div class=\"form-group\">".PHP_EOL;
$txt .="<label for=\"inputEmail3\" class=\"col-sm-2 control-label\">ชื่อของคุณ</label>".PHP_EOL;
$txt .="<div class=\"col-sm-10\">".PHP_EOL;
$txt .="<input type=\"email\" class=\"form-control\" id=\"inputEmail3\" placeholder=\"ชื่อของคุณ\" />".PHP_EOL;
$txt .="</div>".PHP_EOL;
$txt .="</div>".PHP_EOL;
$txt .="<div class=\"form-group\">".PHP_EOL;
$txt .="<label for=\"inputPassword3\" class=\"col-sm-2 control-label\">ความคิดเห็น</label>".PHP_EOL;
$txt .="<div class=\"col-sm-10\">".PHP_EOL;
$txt .="<textarea class=\"form-control\" rows=\"3\"></textarea>".PHP_EOL;
$txt .="</div>".PHP_EOL;
$txt .="</div>".PHP_EOL;
$txt .="<div class=\"form-group\">".PHP_EOL;
$txt .="<div class=\"col-sm-offset-2 col-sm-10\">".PHP_EOL;
$txt .="<label>เพื่อความปลอดภัย กรุณากรอกตัวเลข <a href=\"#\">คลิกที่นี่</a> เพื่อเปลี่ยนตัวเลข<br>".PHP_EOL;
$txt .="<input type=\"email\" class=\"form-control\" id=\"inputEmail3\" placeholder=\"กรอกตัวเลข\" />".PHP_EOL;
$txt .="</label>".PHP_EOL;
$txt .="</div>".PHP_EOL;
$txt .="</div>".PHP_EOL;
$txt .="<div class=\"form-group\">".PHP_EOL;
$txt .="<div class=\"col-sm-offset-2 col-sm-10\">".PHP_EOL;
$txt .="<button type=\"submit\" class=\"btn btn-primary\">ส่งความคิดเห็น</button>".PHP_EOL;
$txt .="</div>".PHP_EOL;
$txt .="</div>".PHP_EOL;
$txt .="</form>".PHP_EOL;
$txt .="</div>".PHP_EOL;
$txt .="</div>".PHP_EOL;
$txt .="</div>".PHP_EOL;

	return $txt;

}

function article_top5($temp){
	global $db;


$txt ="";
$txt .="<div class=\"container\">".PHP_EOL;
$txt .="<h1>ข่าว/บทความที่น่าสนใจ 5 อันดับ</h1>".PHP_EOL;
$txt .="<div class=\"col-md-4\">".PHP_EOL;
$txt .="<div class=\"panel panel-info\">".PHP_EOL;
$txt .="<div class=\"panel-heading\"><i class=\"fa fa-heart\" aria-hidden=\"true\"></i> ข่าว/บทความยอดนิยม</div>".PHP_EOL;
$txt .="<ul class=\"list-group\">".PHP_EOL;

$txt .="<li class=\"list-group-item \"><a href=\"news_view.php\" title=\"ชื่อของบทความ\">บันทึกข้อตกลงความร่วมมือด้านข้อมูลท่องเที่ยว...</a></li>".PHP_EOL;
               
$txt .="</ul>".PHP_EOL;
$txt .="</div>".PHP_EOL;		
$txt .="</div>".PHP_EOL;
$txt .="<div class=\"col-md-4\">".PHP_EOL;
$txt .="<div class=\"panel panel-info\">".PHP_EOL;
$txt .="<div class=\"panel-heading\"><i class=\"fa fa-bar-chart\" aria-hidden=\"true\"></i> ข่าว/บทความที่คะแนนโหวตสูงสุด</div>".PHP_EOL;
$txt .="<ul class=\"list-group\">".PHP_EOL;

$txt .="<li class=\"list-group-item \"><a href=\"news_view.php\" title=\"ชื่อของบทความ\">บันทึกข้อตกลงความร่วมมือด้านข้อมูลท่องเที่ยว...</a></li>".PHP_EOL;
                   
$txt .="</ul>".PHP_EOL;
$txt .="</div>".PHP_EOL;
$txt .="</div>".PHP_EOL;
$txt .="<div class=\"col-md-4\">".PHP_EOL;
$txt .="<div class=\"panel panel-info\">".PHP_EOL;
$txt .="<div class=\"panel-heading\"><i class=\"fa fa-file-o\" aria-hidden=\"true\"></i> ข่าว/บทความล่าสุด</div>".PHP_EOL;
$txt .="<ul class=\"list-group\">".PHP_EOL;

$txt .="<li class=\"list-group-item \"><a href=\"news_view.php\" title=\"ชื่อของบทความ\">บันทึกข้อตกลงความร่วมมือด้านข้อมูลท่องเที่ยว...</a></li>".PHP_EOL;
  
$txt .="</ul>".PHP_EOL;
$txt .="</div>".PHP_EOL;	
$txt .="</div>".PHP_EOL;
$txt .="</div>".PHP_EOL;
	
	return $txt;
	
}

function article_vote($nid,$temp){
	global $db;
	
$txt ="";
$txt .="<div class=\"container\" align=\"center\">".PHP_EOL;
$txt .="<h2>โหวตให้คะแนนข่าว/บทความ </h2>".PHP_EOL;
$txt .="<div class=\"col-xs-12\">".PHP_EOL;
$txt .="<label class=\"radio-inline\">".PHP_EOL;
$txt .="<input type=\"radio\" name=\"inlineRadioOptions\" id=\"inlineRadio1\" value=\"option1\"> 1".PHP_EOL;
$txt .="</label>".PHP_EOL;
$txt .="<label class=\"radio-inline\">".PHP_EOL;
$txt .="<input type=\"radio\" name=\"inlineRadioOptions\" id=\"inlineRadio2\" value=\"option2\"> 2".PHP_EOL;
$txt .="</label>".PHP_EOL;
$txt .="<label class=\"radio-inline".PHP_EOL;
$txt .="<input type=\"radio\" name=\"inlineRadioOptions\" id=\"inlineRadio3\" value=\"option3\"> 3".PHP_EOL;
$txt .="</label>".PHP_EOL;
$txt .="<label class=\"radio-inline\">".PHP_EOL;
$txt .="<input type=\"radio\" name=\"inlineRadioOptions\" id=\"inlineRadio3\" value=\"option3\"> 4".PHP_EOL;
$txt .="</label>".PHP_EOL;
$txt .="<label class=\"radio-inline\">".PHP_EOL;
$txt .="<input type=\"radio\" name=\"inlineRadioOptions\" id=\"inlineRadio3\" value=\"option3\"> 5".PHP_EOL;
$txt .="</label>".PHP_EOL;
$txt .="<br><br>";
$txt .="<a href=\"#\" data-toggle=\"modal\" data-target=\"#myModalVoteAlerts\"><button type=\"button\" class=\"btn btn-primary btn-lg space\"><i class=\"fa fa-thumbs-o-up\" aria-hidden=\"true\"></i> โหวต</button></a> ";
$txt .="<a href=\"#\" data-toggle=\"modal\" data-target=\"#myModalVote\"><button type=\"button\" class=\"btn btn-success btn-lg space\"><i class=\"fa fa-bar-chart\" aria-hidden=\"true\"></i> ดูผลโหวต</button></a>";
$txt .="</div>".PHP_EOL;
$txt .="</div>".PHP_EOL;

	return $txt;
	
}

function article_attach($nid,$temp){
	global $db;

$txt ="";	
$s_attach = $db->query("SELECT * FROM article_attach WHERE n_id = '{$nid}' ORDER BY fileattact_id  ASC");
$a_row = $db->db_num_rows($s_attach);   
if($a_row){	

$txt .="<div class=\"container\">".PHP_EOL;
$txt .="<table class=\"table panel\">".PHP_EOL;
$txt .="<tr>".PHP_EOL;
$txt .="<th colspan=\"2\"><h3 align=\"center\"><i class=\"fa fa-download\" aria-hidden=\"true\"></i> เอกสารดาวน์โหลด</h3></th>";
$txt .="</tr>".PHP_EOL;
while($a_attach = $db->db_fetch_array($s_attach)) {
$txt .="<tr>".PHP_EOL;
$txt .="<td>".$a_attach["fileattach_name"]."</td>".PHP_EOL;
$txt .="<td><a href=\"article_attach/".$a_attach['fileattach_path']."\" target=\"_blank\" title=\"".$a_attach["fileattach_name"]."\"><i class=\"fa fa-file-word-o\" aria-hidden=\"true\"></i> ดาวน์โหลด</a></td>".PHP_EOL;
$txt .="</tr>".PHP_EOL;
}		
$txt .="</table>".PHP_EOL;
$txt .="</div>".PHP_EOL;

return $txt;

	}
} 

function article_video($nid,$temp){
	global $db,$EWT_FOLDER_USER;

$txt ="";	
	
$s_article = $db->query("SELECT * FROM article_list WHERE n_id = '{$nid}' ");      
$a_article = $db->db_fetch_array($s_article);	


$s_video = $db->query("SELECT * FROM article_video WHERE n_id = '{$nid}' ");
$a_row = $db->db_num_rows($s_video);   
if($a_row){	

$txt .="<div class=\"row\">".PHP_EOL;
$txt .="<br>";

$i = 1;
while($a_video = $db->db_fetch_array($s_video)) {
	
$txt .="<div class=\"col-xs-12 col-sm-12 col-lg-6 \">".PHP_EOL;
$txt .="<div class=\"item\" style=\"margin:5px;\">".PHP_EOL;

if($a_video['av_filename'] != ""){
	$type = "mp4";
}else{
	$type = "youtube";
}

$vdo_fileyoutube = str_replace('https://www.youtube.com/watch?v=', '', $a_video['av_filenameyoutube']);

if($a_video['vdo_image'] != ""){ $vdo_image = $a_video['vdo_image']; }
if($a_video['av_filename'] != ""){	
//echo "<img src=\"".$vdo_image."\" alt=\"".$rec_vdo['vdo_name']."\"  title=\"".$rec_vdo['vdo_name']."\" width=\"100%\" height=\"300\"/>";		
$txt .="<video class=\"mejs-wmp \" id=\"vplayer".$i."\" width=\"100%\" height=\"300\" src=\"download/file_vdo/".$a_video['av_filename']."\" poster=\"".$vdo_image."\"  type=\"video/mp4\" controls=\"controls\" preload=\"none\"></video>";	
}else{ 
//echo "<img src=\"https://i.ytimg.com/vi/".$vdo_fileyoutube."/sddefault.jpg\" alt=\"".$rec_vdo['vdo_name']."\"  title=\"".$rec_vdo['vdo_name']."\" width=\"100%\" height=\"300\"/>";
$txt .="<iframe  class=\"mejs-wmp \" width=\"100%\"  height=\"300\"  src=\"//www.youtube.com/embed/".$vdo_fileyoutube."?wmode=transparent&#038;iv_load_policy=3&#038;modestbranding=1&#038;rel=0&#038;autohide=1&#038;autoplay=0&#038;mute=0\" class=\"arve-inner\" allowfullscreen frameborder=\"0\" scrolling=\"no\"></iframe>";	
	} 
//$txt .="<iframe class=\"embed-responsive-item\" src=\"https://www.youtube.com/embed/cqf0QRTJ0Io\" width=\"100%\" height=\"300\" frameborder=\"0\" style=\"border:0\"></iframe>";

$txt .="</div>".PHP_EOL;
$txt .="</div>".PHP_EOL;
$i++;				
}



$txt .="<div class=\"col-xs-12\" align=\"right\">".PHP_EOL;

$n_address = explode("###",$a_article['n_address']);

for($i = 0; $i < count($n_address); $i++ ){
	
if($n_address[$i]!=''){  

$article = explode("#@#",$n_address[$i]);

$txt .="<q>แหล่งที่มา : <a href=\"".$article[0]."\" target=\"_blank\">".$article[1]."</a></q><br>";

}
	}
$txt .="</div>".PHP_EOL;
$txt .="</div>".PHP_EOL;
$txt .="<script type=\"text/javascript\" src=\"../../js/mediaelement/build/jquery.js\"></script>".PHP_EOL;
$txt .="<script src=\"../../js/mediaelement/build/mediaelement-and-player.min.js\"></script>".PHP_EOL;
$txt .="<link rel=\"stylesheet\" href=\"../../js/mediaelement/build/mediaelementplayer.min.css\" />".PHP_EOL;
$txt .="<link rel=\"stylesheet\" href=\"../../js/mediaelement/build/mejs-skins.css\" />".PHP_EOL;	
$txt .="<script>".PHP_EOL;
$txt .="$('audio,video').mediaelementplayer({".PHP_EOL;
$txt .="	success: function(player, node){".PHP_EOL;
$txt .="		$('#' + node.id + '-mode').html('mode: ' + player.pluginType);".PHP_EOL;
$txt .="	}".PHP_EOL;
$txt .="});".PHP_EOL;
$txt .="</script>".PHP_EOL;

return $txt;

	}
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

if($a_detail['ad_des'] != ''){
 //$txt .= nl2br(stripslashes($a_detail["ad_des"])); 
 $txt .= $a_detail["ad_des"];
		}	
	}
	return $txt;
}


function article_media($nid,$temp){
	global $db;

$txt ="";	
$s_detail = $db->query("SELECT * FROM article_detail WHERE n_id = '{$nid}' ");	
$a_row = $db->db_num_rows($s_detail);   
if($a_row){	 

$txt .="<div class=\"row\">".PHP_EOL;
$txt .="<div class=\"container-fluid flex-container\">".PHP_EOL;
$i = '1';
while($a_detail = $db->db_fetch_array($s_detail)) { 

 if($a_detail['ad_pic_b'] != "" OR $a_detail['ad_des'] != "" AND $a_detail['at_type_row'] != "11"){
	if($a_detail['ad_pic_b'] != ""){ 
		$ad_pic_b = "images/article/news".$nid."/".$a_detail['ad_pic_b']; 
		}else{ 
			$ad_pic_b = "images/news/1-1.jpg"; 
			} 

	if($a_detail['ad_pic_s'] != ""){ 
		$ad_pic_s = "images/article/news".$nid."/".$a_detail['ad_pic_b']; 
		}else{ 
			$ad_pic_s = "images/news/1-1.jpg";
			}
if($i%3 == '1'){
$txt .="<div class=\"col-xs-12 col-sm-12 col-md-12 clearfix\"></div>".PHP_EOL;
}			
$txt .="<div class=\"col-xs-12 col-sm-4 col-md-4\">".PHP_EOL;
$txt .="<div class=\"item\"  >".PHP_EOL;
$txt .="<a href=\"".$ad_pic_b."\" data-fancybox=\"group1\" data-caption=\"\">";
$txt .="<img src=\"".$ad_pic_s."\" alt=\"\" class=\"img-responsive\" tyle=\"margin-right:auto;margin-left:auto;\" width=\"100%\" />";		
$txt .="</a>".PHP_EOL;
$txt .="</div>".PHP_EOL;
$txt .="<div class=\"item\" style=\"margin:5px;padding-top:20px; word-wrap: break-word;\">".PHP_EOL;
$txt .=article_detail($nid,$temp,$a_detail['ad_id'],'','')."".PHP_EOL; 
$txt .="</div>".PHP_EOL;
$txt .="</div>".PHP_EOL;
$txt .="<br>".PHP_EOL;
$txt .="<br>".PHP_EOL;


 } 
 $i++;
	} 
	
$txt .="<br>".PHP_EOL;
$txt .="</div>".PHP_EOL;
$txt .="</div>".PHP_EOL;
$txt .="<br>".PHP_EOL;
$txt .="<br>".PHP_EOL;
$txt .="<br>".PHP_EOL;
$txt .="<div class=\"col-xs-12 col-sm-12 col-md-12\" style=\"margin:5px;padding-top:20px; word-wrap: break-word;\">".PHP_EOL;
$txt .="<p>".PHP_EOL; 
$txt .=article_detail($nid,$temp,'','11','1')."".PHP_EOL; 
$txt .="</p>".PHP_EOL;
$txt .="<br>".PHP_EOL;
$txt .="</div>".PHP_EOL;
$txt .="<br>".PHP_EOL;
$txt .="<br>".PHP_EOL;
$txt .=article_video($nid,$temp)."".PHP_EOL;

	return $txt;
	}
}	


function article_view($nid,$temp){
	global $db;
	global $EWT_FOLDER_USER;
	
article_count($nid);
article_insert_view($nid);

$s_article = $db->query("SELECT * FROM article_list WHERE n_id = '{$nid}' AND n_approve = 'Y' "); 
$a_row = $db->db_num_rows($s_article);             
$a_article = $db->db_fetch_array($s_article);

$txt ="";
$txt .="<section class=\"news_view\">".PHP_EOL;
$txt .="<div class=\"container\">".PHP_EOL;
$txt .="<ol class=\"breadcrumb\">	".PHP_EOL;
$txt .="<li><a href=\"index.php\"><i class=\"fa fa-home\" aria-hidden=\"true\"></i></a></li>".PHP_EOL;
$txt .=articleparent($a_article['c_id']);
$txt .="</ol>".PHP_EOL;
$txt .="<div class=\"col-xs-12\">".PHP_EOL;
$txt .="<h2>".$a_article['n_topic']."</h2>".PHP_EOL;
if($EWT_FOLDER_USER != 'motsportal'){
$txt .="<div id=\"share-buttons1\">".PHP_EOL;
$txt .="<span class=\"fa fa-calendar-o\" aria-hidden=\"true\"></span>".chg_date_short_th($a_article['n_date'])." &nbsp;&nbsp;&nbsp;&nbsp; <span class=\"fa fa-eye\" aria-hidden=\"true\"></span><span> ".$a_article['n_count']." views </span> ";              
$txt .="<h4>แชร์ทั้งหมด <span style=\"font-size:2em;\">  ".$a_article['n_count_share']." </span> ครั้ง </h4>".PHP_EOL;	    
$txt .="</div>".PHP_EOL;

$txt .=share_buttons()."<br>".PHP_EOL;

}
$txt .="</div>".PHP_EOL;
$txt .=article_media($nid,'')."<br>".PHP_EOL;
$txt .="</div>".PHP_EOL;

$txt .=article_attach($nid,'')."<br>".PHP_EOL;

if($a_article['show_vote'] == '1'){
$txt .=article_vote($nid,'')."<br>".PHP_EOL;
}
if($a_article['show_comment'] == '1'){
$txt .=article_comment($nid,'')."<br>".PHP_EOL;
} 
if($a_article['show_newstop'] == '1'){
$txt .=article_top5($nid)."<br>".PHP_EOL;
}
$txt .="</section>".PHP_EOL;

	return $txt;		
}
	
	
	
function article($nid,$tep,$lim){
	global $db;
	
$sql_group ="SELECT * FROM  article_group WHERE c_id = '{$nid}'";
$query_group = $db->query($sql_group);
$U = $db->db_fetch_array($query_group);

$txt ="";

$glo_sql = " ( c_id = '{$nid}' ";
		if($U['c_show_subnew'] == "Y"){
		tochild($nid);		
		}
		if($U["c_type"]=='M'){		
		tomultigroup($nid);
		}
$glo_sql .= " ) ";	

$date_now = (date("Y")+543).'-'.date('m-d H:i:s');

if($tep == '1'){

$txt .="<div class=\"col-xs-12\">".PHP_EOL;
$txt .="<h2 class=\"news-head\">".PHP_EOL;
$txt .="<span class=\"switching\" >".PHP_EOL;
$txt .=$U['c_name'];		
$txt .="</span>&nbsp;".PHP_EOL;

if($U['c_rss']=="Y"){ 

$txt .="<a href=\"rss/group".$U['c_id'].".xml\"  title=\"RSS ".$U['c_name']."\" />".PHP_EOL;
$txt .="<i class=\"fa fa-rss-square i-rss\" aria-hidden=\"true\"> rss</i>".PHP_EOL;
$txt .="</a>".PHP_EOL;

 } 
 
$txt .="</h2>".PHP_EOL;
$txt .="</div>".PHP_EOL;

$sql_article = $db->query("SELECT * FROM article_list WHERE {$glo_sql} AND n_approve = 'Y' AND (('{$date_now}' between n_date_start  AND n_date_end) OR (n_date_start = '' AND n_date_end = '')) ORDER BY n_date DESC,n_timestamp DESC LIMIT 0,{$lim}"); 
$numrows = $db->db_num_rows($sql_article);             
while($A = $db->db_fetch_array($sql_article)) { 

$txt .="<div class=\"col-xs-12 col-sm-6 col-md-4 col-lg-3\">".PHP_EOL;
$txt .="<div class=\"news-pic\">".PHP_EOL;

if($A['picture'] != ""){ 

if(file_exists("images/article/news".$A['n_id']."/".$A['picture'])){

$txt .="<img src=\"".$Website."images/article/news".$A['n_id']."/".$A['picture']."\" alt=\"".$A['n_topic']."\" class=\"img-responsive\" border=\"0\" />".PHP_EOL;
}else{ 
				$ccc= explode(".",$A['picture']);
				$bbb = explode("_",$ccc[0]);
				if(file_exists("../".$A['n_sharename'].'/images/article/news'.$bbb[1]."/".$A['picture'])){

$txt .="<img src=\"../".$A['n_sharename']."/images/article/news".$bbb[1]."/".$A['picture']."\"  alt=\"".$A['n_topic']."\" class=\"img-responsive\" border=\"0\" />".PHP_EOL;

} 
	}
	
}else{

$txt .="<img src=\"images/news/1-1.jpg\"  alt=\"".$A['n_topic']."\" class=\"img-responsive\" />".PHP_EOL;
	
}	
			
$txt .="<div class=\"news-date\">".PHP_EOL;
$txt .="<p><i class=\"fa fa-clock-o\" aria-hidden=\"true\"></i>".chg_date_short_th($A['n_date'])."</p>".PHP_EOL;
$txt .="</div>".PHP_EOL;
$txt .="<div class=\"news-activity\">".PHP_EOL;
$txt .="<ul>".PHP_EOL;
$txt .="<li><a href=\"#\"><i class=\"fa fa-eye\" aria-hidden=\"true\"></i>".$A['n_count']."</a></li>".PHP_EOL;
$txt .="<li><a href=\"#\"><i class=\"fa fa-facebook-square\" aria-hidden=\"true\"></i>".$A['n_count_share']."</a></li>".PHP_EOL;
$txt .="</ul>".PHP_EOL;
$txt .="</div>".PHP_EOL;
$txt .="</div>".PHP_EOL;
$txt .="<div class=\"news-descript\">".PHP_EOL;
$txt .="<h5>".PHP_EOL;
 
if($A["news_use"] == "2" or $A["news_use"] == "3"){ 
$txt .="<a href=\"news_view.php?nid=".$A['n_id']."\" target=\"_blank\">"; 
}elseif($A["news_use"] == "4"){ 
$txt .="<a href=\"ewt_dl.php?nid=".$A['n_id']."\" target=\"_blank\">"; 
}else{   
$txt .="<a href=\"ewt_dl_link.php?nid=".$A['n_id']."\" target=\"_blank\">"; 
} 			

$txt .=truncateStr($A['n_topic'],'100','.....');
$txt .="</a>".PHP_EOL;
$txt .="</h5>".PHP_EOL;
$txt .="</div>".PHP_EOL;
$txt .="<br class=\"visible-xs\">".PHP_EOL;
$txt .="</div>".PHP_EOL;

}

$txt .="<div class=\"col-xs-12\" align=\"center\">".PHP_EOL;
$txt .="<a href=\"more_news.php?cid=".$nid."\">";
$txt .="<button class=\"btn btn-info\">";
$txt .="<span class=\"switching\" > อ่านทั้งหมด </span>";
$txt .="</button>";
$txt .="</a>".PHP_EOL;
$txt .="</div>".PHP_EOL;
$txt .="</div>".PHP_EOL;

	
}else if($tep == '2'){

  /*ข่าวประชาสัมพันธ์ */
  
$txt .="<div class=\"col-md-8 col-lg-9\">".PHP_EOL;
$txt .="<div class=\"col-xs-12\"><h2 class=\"news-head\">".PHP_EOL;
$txt .="<span class=\"switching\" >".$U['c_name'];
$txt .="</span>&nbsp;".PHP_EOL;

if($U['c_rss']=="Y"){
$txt .="<a href=\"rss/group".$U['c_id'].".xml\"  title=\"RSS ".$U['c_name']."\>".PHP_EOL;
$txt .="<i class=\"fa fa-rss-square i-rss\" aria-hidden=\"true\"> rss</i>".PHP_EOL;
$txt .="</a>".PHP_EOL;
} 
			
$txt .="</h2>".PHP_EOL;
$txt .="</div>".PHP_EOL;

$sql_article = $db->query("SELECT * FROM article_list WHERE {$glo_sql} AND n_approve = 'Y' AND (('{$date_now}' between n_date_start  AND n_date_end) OR (n_date_start = '' AND n_date_end = '')) ORDER BY n_date DESC,n_timestamp DESC LIMIT 0,{$lim}"); 
$numrows = $db->db_num_rows($sql_article);             
while($A = $db->db_fetch_array($sql_article)) { 
			
$txt .="<div class=\"col-xs-12 col-sm-6 col-lg-4\">".PHP_EOL;
$txt .="<div class=\"news-pic\">".PHP_EOL;

if($A['picture'] != ""){ 

if(file_exists("images/article/news".$A['n_id']."/".$A['picture'])){

$txt .="<img src=\"".$Website."images/article/news".$A['n_id']."/".$A['picture']."\" alt=\"".$A['n_topic']."\" class=\"img-responsive\" border=\"0\" />".PHP_EOL;
}else{ 
				$ccc= explode(".",$A['picture']);
				$bbb = explode("_",$ccc[0]);
				if(file_exists("../".$A['n_sharename'].'/images/article/news'.$bbb[1]."/".$A["picture"])){

$txt .="<img src=\"../".$A['n_sharename']."/images/article/news".$bbb[1]."/".$A['picture']."\"  alt=\"".$A['n_topic']."\" class=\"img-responsive\" border=\"0\" />".PHP_EOL;

} 
	}
}else{

$txt .="<img src=\"images/news/1-1.jpg\"  alt=\"".$A['n_topic']."\" class=\"img-responsive\"/>".PHP_EOL;

}	
		
$txt .="<div class=\"news-date\">".PHP_EOL;
$txt .="<p><i class=\"fa fa-clock-o\" aria-hidden=\"true\"></i>".chg_date_short_th($A['n_date'])."</p>".PHP_EOL;
$txt .="</div>".PHP_EOL;

$txt .="<div class=\"news-activity\">".PHP_EOL;
$txt .="<ul>".PHP_EOL;
$txt .="<li><a href=\"#\"><i class=\"fa fa-eye\" aria-hidden=\"true\"></i>".$A['n_count']."</a></li>".PHP_EOL;
$txt .="<li><a href=\"#\"><i class=\"fa fa-facebook-square\" aria-hidden=\"true\"></i>".$A['n_count_share']."</a></li>".PHP_EOL;
$txt .="</ul>".PHP_EOL;
$txt .="</div>".PHP_EOL;
$txt .="</div>".PHP_EOL;
$txt .="<div class=\"news-descript\">".PHP_EOL;
$txt .="<h5>".PHP_EOL;

if($A["news_use"] == "2" or $A["news_use"] == "3"){ 

$txt .="<a href=\"news_view.php?nid=".$A['n_id']."\" target=\"_blank\">"; 
}elseif($A["news_use"] == "4"){ 
$txt .="<a href=\"ewt_dl.php?nid=".$A['n_id']."\" target=\"_blank\">"; 
}else{   
$txt .="<a href=\"ewt_dl_link.php?nid=".$A['n_id']."\" target=\"_blank\">"; 
} 			
$txt .=truncateStr($A['n_topic'],'100','.....')."</a></h5>".PHP_EOL;
$txt .="</div>".PHP_EOL;
$txt .="<br class=\"visible-xs\">".PHP_EOL;
$txt .="</div>".PHP_EOL;
 }      
$txt .="<div class=\"col-xs-12\" align=\"center\">".PHP_EOL;
$txt .="<a href=\"more_news.php?cid=".$nid."\">";
$txt .="<button class=\"btn btn-info\">";
$txt .="<span class=\"switching\" > อ่านทั้งหมด </span>";
$txt .="</button>";
$txt .="</a>".PHP_EOL;
$txt .="</div>".PHP_EOL;
		
$txt .="</div>".PHP_EOL;

}else if($tep == '3'){

$txt .="<div class=\"col-md-4 col-lg-3\">".PHP_EOL;
$txt .="<div class=\"col-xs-12\"><h2 class=\"news-head\">".PHP_EOL;
$txt .="<span class=\"switching\">".$U['c_name'].PHP_EOL;
$txt .="</span>".PHP_EOL;
$txt .="</h2></div>".PHP_EOL;
$txt .="<div class=\"well col-xs-12\">".PHP_EOL;
$txt .="<ul class=\"list-style1 link3\">".PHP_EOL;

$sql_article = $db->query("SELECT * FROM article_list WHERE {$glo_sql} AND n_approve = 'Y' AND (('{$date_now}' between n_date_start  AND n_date_end) OR (n_date_start = '' AND n_date_end = '')) ORDER BY n_date DESC,n_timestamp DESC LIMIT 0,{$lim}"); 
$numrows = $db->db_num_rows($sql_article);             
while($A = $db->db_fetch_array($sql_article)) { 
		   
$txt .="<li>".PHP_EOL;

if($A["news_use"] == "2" or $A["news_use"] == "3"){ 
$txt .="<a href=\"news_view.php?nid=".$A['n_id']."\" target=\"_blank\">"; 
}elseif($A["news_use"] == "4"){ 
$txt .="<a href=\"ewt_dl.php?nid=".$A['n_id']."\" target=\"_blank\">"; 
}else{   
$txt .="<a href=\"ewt_dl_link.php?nid=".$A['n_id']."\" target=\"_blank\">"; 
} 			

$txt .=truncateStr($A['n_topic'],'100','.....').PHP_EOL;
$txt .="</a>".PHP_EOL;
$txt .="</li>".PHP_EOL;
           
 }
 
$txt .="</ul>".PHP_EOL;

$txt .="<div class=\"col-xs-12\" align=\"center\">".PHP_EOL;
$txt .="<h4>".PHP_EOL;
$txt .="<a href=\"more_news.php?cid=".$nid."\">".PHP_EOL;
$txt .="<span class=\"switching\" > อ่านทั้งหมด </span>".PHP_EOL;
$txt .="</a>".PHP_EOL;
$txt .="</h4>".PHP_EOL;
$txt .="</div>".PHP_EOL;
            
$txt .="</div>".PHP_EOL;
$txt .="</div>".PHP_EOL;
	 
	}
	return $txt;
}


function article_all_top($temp){
	global $db;

$date_now = (date("Y")+543).'-'.date('m-d H:i:s');
		
$s_article = $db->query("SELECT * FROM  article_list WHERE n_approve = 'Y' AND (('{$date_now}' between n_date_start  AND n_date_end) OR (n_date_start = '' AND n_date_end = '')) ORDER BY n_date DESC,n_timestamp DESC LIMIT 0,10  ");	
$a_row = $db->db_num_rows($s_article);   
if($a_row){
	
$txt ="<div class=\"row\">".PHP_EOL;
$txt .="<h3>รายการข่าว/บทความล่าสุด</h3>".PHP_EOL;
$txt .="<div class=\"table-responsive\">".PHP_EOL;
$txt .="<table class=\"table table-striped table-hover\">".PHP_EOL;
while($a_article = $db->db_fetch_array($s_article)) {
	
$txt .="<tr>".PHP_EOL;
$txt .="<td><span class=\"glyphicon glyphicon-record\" aria-hidden=\"true\"></span></td>".PHP_EOL;
$txt .="<td class=\"text-left\"><a href=\"news_view.php\" title=\"".$a_article['n_topic']."\">".$a_article['n_topic']." </a>";
$txt .=" <i class=\"fa fa-calendar-o\" aria-hidden=\"true\"></i> ".chg_date_short_th($a_article['n_date']);
$txt .=" <i class=\"fa fa-eye\" aria-hidden=\"true\"></i>".$a_article['n_count'];
$txt .=" <i class=\"fa fa-download\" aria-hidden=\"true\"></i> ".$a_articleA['n_count_share']."  ครั้ง ";

if(($a_article["expire"]>=$todays) && $a_article["logo"]!=""){
	
$txt .=" <img src=\"images/new.png\" alt=\"icon\" title=\"icon\"> ";

}
$txt .="</td>".PHP_EOL;
$txt .="</tr>".PHP_EOL;
}
$txt .="</table>".PHP_EOL;
$txt .=" </div>".PHP_EOL;
$txt .="</div>".PHP_EOL;
}

return $txt;

}


function article_all_sub($cid,$temp){	
	global $db;

$txt ="";	
$s_group = $db->query("SELECT * FROM  article_group WHERE c_parent = '{$cid}' ");	
$a_row = $db->db_num_rows($s_group);   
if($a_row){
$txt .="<div class=\"row subgroup\">".PHP_EOL;
$txt .="<div class=\"col-xs-12\"><h4>หมวดย่อย</h4></div>".PHP_EOL;
while($a_group = $db->db_fetch_array($s_group)) {	  			
$txt .="<div class=\"col-md-4\">".PHP_EOL;
$txt .="<i class=\"fa fa-folder\" aria-hidden=\"true\"></i> <a href=\"more_news.php?cid=".$a_group['c_id']."\" title=\"".$a_group['c_name']."\">".$a_group['c_name']."</a>".PHP_EOL;
$txt .="</div>".PHP_EOL;
}     
$txt .="<br>&nbsp;";
$txt .="</div>".PHP_EOL;
}
	return $txt;
}
 

 
function article_all($cid,$temp,$start,$perpage,$_SERVER,$page,$wh){	
	global $db;
		
$s_group = $db->query("SELECT * FROM  article_group WHERE c_id = '{$cid}' ");
$a_group = $db->db_fetch_array($s_group);

$glo_sql = " ( c_id = '{$cid}' ";
		if($a_group['c_show_subnew'] == "Y"){
		tochild($cid);		
		}
		if($a_group['c_type']=='M'){		
		tomultigroup($cid);
		}
$glo_sql .= " ) ";	
		
$date_now = (date("Y")+543).'-'.date('m-d H:i:s');
		
$s_article = $db->query("SELECT * 
FROM  article_list  
WHERE  {$glo_sql} AND n_approve = 'Y' AND (('{$date_now}' between n_date_start  AND n_date_end) OR (n_date_start = '' AND n_date_end = '')) 
ORDER BY n_date DESC,n_timestamp DESC 
LIMIT {$start} , {$perpage} ");
$a_row = $db->db_num_rows($s_article); 
  
if($a_row){	
$s_article2 = $db->query("SELECT * FROM  article_list WHERE  {$glo_sql} AND n_approve = 'Y' AND (('{$date_now}' between n_date_start  AND n_date_end) OR (n_date_start = '' AND n_date_end = '')) ");
$total_record = $db->db_num_rows($s_article2);	
$total_page = ceil($total_record / $perpage);

$txt .="<section class=\"more_news\">".PHP_EOL;
$txt .="<div class=\"container\">".PHP_EOL;
$txt .="<ol class=\"breadcrumb\">".PHP_EOL;
$txt .="<li><a href=\"index.php\"><i class=\"fa fa-home\" aria-hidden=\"true\"></i></a></li>".PHP_EOL;
$txt .=articleparent($cid);
            /*<li class="active"><?//=$a_group['c_name'];?></li>*/
$txt .="</ol>".PHP_EOL;
$txt .="<div class=\"row\" align=\"center\">".PHP_EOL;
$txt .="<h2 align=\"left\">".$a_group['c_name']."</h2>".PHP_EOL;
	
if($a_group['c_show_pic'] == '@detail_news#'){
	
while($a_article = $db->db_fetch_array($s_article)) {	
		
$txt .="<div class=\"col-sm-6 col-md-4\" style=\"height:320px;\">".PHP_EOL;

if($a_article["news_use"] == "2" or $a_article["news_use"] == "3"){ 

$txt .="<a href=\"news_view.php?nid=".$a_article['n_id']."\" title=\"".$a_article['n_topic']."\" target=\"_blank\">"; 

}elseif($a_article["news_use"] == "4"){ 

$txt .="<a href=\"ewt_dl.php?nid=".$a_article['n_id']."\" title=\"".$a_article['n_topic']."\" target=\"_blank\">"; 

}else{  
 
$txt .="<a href=\"ewt_dl_link.php?nid=".$a_article['n_id']."\" title=\"".$a_article['n_topic']."\" target=\"_blank\">"; 

} 			

if($a_article["picture"] != ""){ 

if(file_exists("images/article/news".$a_article["n_id"]."/".$a_article["picture"])){

$txt .="<img src=\"".$Website."images/article/news".$a_article["n_id"]."/".$a_article["picture"]."\" alt=\"".$a_article['n_topic']."\" width=\"270\" height=\"210\" _class=\"img-responsive\" border=\"0\" />";

}else{ 
				$ccc= explode(".",$a_article['picture']);
				$bbb = explode("_",$ccc[0]);
				if(file_exists("../".$a_article['n_sharename'].'/images/article/news'.$bbb[1]."/".$a_article["picture"])){

					$txt .="<img src=\"../".$a_article['n_sharename']."/images/article/news".$bbb[1]."/".$a_article["picture"]."\"  alt=\"".$a_article['n_topic']."\" width=\"270\" height=\"210\" _class=\"img-responsive\" border=\"0\" />";

				} 
	}
}else{
$txt .="<img src=\"images/news/1-1.jpg\"  alt=\"".$A['n_topic']."\" width=\"270\" height=\"210\" _class=\"img-responsive\" />";
}				
$txt .="</a>".PHP_EOL;
$txt .="<br>".PHP_EOL;
$txt .="<h5>".PHP_EOL;
 
if($a_article["news_use"] == "2" or $a_article["news_use"] == "3"){ 

$txt .="<a href=\"news_view.php?nid=".$a_article['n_id']."\" title=\"".$a_article['n_topic']."\" target=\"_blank\">"; 

}else if($a_article["news_use"] == "4"){ 

$txt .="<a href=\"ewt_dl.php?nid=".$a_article['n_id']."\" title=\"".$a_article['n_topic']."\" target=\"_blank\">"; 

}else{   

$txt .="<a href=\"ewt_dl_link.php?nid=".$a_article['n_id']."\" title=\"".$a_article['n_topic']."\" target=\"_blank\">"; 

} 			
$txt .=truncateStr($a_article['n_topic'],'100','.....');
$txt .="</a>";
$txt .="</h5>"; 
$txt .="<p><i class=\"fa fa-calendar-o\" aria-hidden=\"true\"></i>".chg_date_short_th($a_article['n_date'])." | <i class=\"fa fa-eye\" aria-hidden=\"true\"></i> ".$a_article['n_count']." </p>";
$txt .="</div>".PHP_EOL;  
} 					
$txt .="</div>".PHP_EOL;

}else{ 
$txt .="<div class=\"table-responsive\">".PHP_EOL;
$txt .="<table class=\"table table-striped table-hover\">".PHP_EOL;

while($a_article = $db->db_fetch_array($s_article)) {
	
$txt .="<tr>".PHP_EOL;
$txt .="<td><span class=\"glyphicon glyphicon-record\" aria-hidden=\"true\"></span></td>".PHP_EOL;
$txt .="<td class=\"text-left\">";

if($a_article["news_use"] == "2" or $a_article["news_use"] == "3"){ 

$txt .="<a href=\"news_view.php?nid=".$a_article['n_id']."\" title=\"".$a_article['n_topic']."\" target=\"_blank\">"; 

}else if($a_article["news_use"] == "4"){ 

$txt .="<a href=\"ewt_dl.php?nid=".$a_article['n_id']."\" title=\"".$a_article['n_topic']."\" target=\"_blank\">"; 

}else{   

$txt .="<a href=\"ewt_dl_link.php?nid=".$a_article['n_id']."\" title=\"".$a_article['n_topic']."\" target=\"_blank\">"; 

} 	


$txt .=truncateStr($a_article['n_topic'],'100','.....');
$txt .="</a>";

$txt .="<i class=\"fa fa-calendar-o\" aria-hidden=\"true\"></i> ".chg_date_short_th($a_article['n_date']);
$txt .=" <i class=\"fa fa-eye\" aria-hidden=\"true\"></i>".$a_article['n_count'];
$txt .=" <i class=\"fa fa-download\" aria-hidden=\"true\"></i> ".$a_articleA['n_count_share']."  ครั้ง ";

if(($a_article["expire"]>=$todays) && $a_article["logo"]!=""){	
$txt .="<img src=\"images/new.png\" alt=\"icon\" title=\"icon\"> ";
}
$txt .="</td>".PHP_EOL;
$txt .="</tr>".PHP_EOL;
}
$txt .="</table>".PHP_EOL;
$txt .="</div>".PHP_EOL;

} 
$txt .=article_all_sub($cid,$temp);
$txt .=pagination($start,$perpage,$total_page,$_SERVER,$page,$wh);

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


function banner($bid,$tep,$title){
	global $db;	
	
$txt = "";	

$date_now = (date("Y")+543).'-'.date('m-d H:i:s');

$wh = "AND ((banner_show_start = '' AND banner_show_end = '')";
$wh .= "OR ('{$date_now}' between banner_show_start AND banner_show_end))";

if($tep == '1'){
	
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

$banner_ahref="<a href=\"".$a_banner['banner_link']."\" target=\"_blank\" onclick=\"ajax_save_log('banner_ajax_log.php?banner_id=".$a_banner['banner_id'].")\">"; 
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

} else if($tep == '2'){

$txt .="<div class=\"col-xs-12 col-md-6\">".PHP_EOL;
$txt .="<h2 class=\"news-head\"><span class=\"switching\" >".$title."</span> <i class=\"fa fa-file-text\" aria-hidden=\"true\"></i></h2>".PHP_EOL;
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

$banner_ahref="<a href=\"".$a_banner['banner_link']."\" target=\"_blank\" onclick=\"ajax_save_log('banner_ajax_log.php?banner_id=".$a_banner['banner_id'].")\">"; 
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

	}
		return $txt;
}


function sitemap($m_id,$tem){
	global $db;

$txt = "";	
	
if($tem == '1'){
$txt .="<div class=\"row\">\n";
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
$txt .="<div class=\"col-xxs-12 col-xs-6 col-sm-6 col-md-3\">".PHP_EOL;		

if($link){
$txt .="<a href=\"".$link."\">";
		}else{
			$txt .="<a>";
						}
			$txt .="<h3><span>".$a_menu['mp_name']."</span></h3>"; 
			$txt .="</a> <ul class=\"nonelist link2\">";
	$txt .=sitemap_child($m_id,$a_menu['mp_id'],$len);						
	$txt .="</ul></div>";
}

			$i++;
	}
		}
			}
$txt .="<div class=\"col-xxs-12 col-xs-6 col-sm-6 col-md-3\">".PHP_EOL;
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
              $txt .="<h3><span>".$a_menu_p['mp_name']."</span></h3></a>"; 			  
}
	}	
}
	}
      $txt .="</ul>\n</div>".PHP_EOL;
		
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
$txt .="<ul class=\"dropdown-menu dropdown-style1\">".PHP_EOL;

while($a_menu = $db->db_fetch_array($s_menu_properties)){
	$len = genlen($a_menu['mp_id'],"_");
	if($l+1 == $len){
		
		$s_menu_properties2 = $db->query("SELECT * FROM menu_properties WHERE m_id = '{$m_id}' AND mp_id LIKE '{$a_menu['mp_id']}_%' ORDER BY mp_id ASC"); 
		$a_row2 = $db->db_num_rows($s_menu_properties2);	
		
								$link = glink($a_menu['Glink']);							
							/*$txt .="<li>";													
								if($link){
									$txt .="<a href=\"".$link."\">".$a_menu['mp_name']."</a>";
									}else{
										$txt .="<a>".$a_menu['mp_name']."</a>";
										}*/


if($a_row2 > 0){
	$txt .="<li class=\"dropdown-submenu dropdown-style1\"><a href=\"#\" class=\"dropdown-toggle\" data-toggle=\"dropdown\" role=\"button\" aria-haspopup=\"true\" aria-expanded=\"false\" >".$a_menu['mp_name']."</a>";
	}else{
		if($link){
				$txt .="<li>";
				$txt .="<a href=\"".$link."\">".$a_menu['mp_name']."</a>";
				}else{
					$txt .="<li>";
					$txt .="<a>".$a_menu['mp_name']."</a>";
					}
		}										
																
								$txt .= menu_child($m_id,$a_menu['mp_id'],$len);								
								$txt .="</li>".PHP_EOL;	
		}
	}
$txt .="</ul>".PHP_EOL;							
	}
	
	return $txt;	
}


function menu($m_id){
	global $db;
	
$txt = "";	
$txt .="<div class=\"col-md-12 col-lg-8 p0\">".PHP_EOL;
$txt .="<div class=\"navbar-header navbar-left\">".PHP_EOL;
$txt .="<button type=\"button\" class=\"navbar-toggle collapsed toggle-modify\" data-toggle=\"collapse\" data-target=\"#bs-example-navbar-collapse-1\">\n";
$txt .="<span class=\"sr-only\">Toggle navigation</span>".PHP_EOL;
$txt .="<span class=\"icon-bar\"></span>".PHP_EOL;
$txt .="<span class=\"icon-bar\"></span>".PHP_EOL;
$txt .="<span class=\"icon-bar\"></span>".PHP_EOL;
$txt .="</button>".PHP_EOL;
$txt .="</div>".PHP_EOL;
					
$txt .="<div class=\"collapse navbar-collapse\" id=\"bs-example-navbar-collapse-1\">".PHP_EOL;
$txt .="<nav> <ul class=\"nav navbar-nav\">".PHP_EOL;																			
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
			$txt .="<li class=\"dropdown\">";
			}else{
				$txt .="<li>";
				}
if($link){
	$txt .="<a href=\"".$link."\">";
		}else{
			$txt .="<a href=\"#\" class=\"dropdown-toggle effect-3\" data-toggle=\"dropdown\">";			
			}			
			$txt .="<span class=\"switching\">".$a_menu['mp_name']."</span> "; 
			if($a_row2 > 0){
			$txt .="<b class=\"caret\"></b>";
			}
			$txt .="</a>";
	$txt .= menu_child($m_id,$a_menu['mp_id'],$len);						
	$txt .="</li>".PHP_EOL;
}
$i++;

	}
		}
														
$txt .= "</ul>".PHP_EOL;
$txt .= "</nav>".PHP_EOL;
$txt .= "</div>".PHP_EOL;

	return $txt;
}	


function vdo($vdo,$tem,$title){
	global $db;

$vdo_LIST='LIMIT 0,1';

$s_vdo = $db->query("SELECT vl.*, vg.vdog_downloadable FROM vdo_list vl JOIN vdo_group vg ON vg.vdog_id=vl.vdo_group WHERE vdo_group = '{$vdo}' ORDER BY vdo_id DESC {$vdo_LIST}");
$a_vdo=$db->db_fetch_array($s_vdo);
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

$txt = "";
$txt .="<script type=\"text/javascript\" src=\"../../js/mediaelement/build/jquery.js\"></script>".PHP_EOL;
$txt .="<script src=\"../../js/mediaelement/build/mediaelement-and-player.min.js\"></script>\n";
$txt .="<link rel=\"stylesheet\" href=\"../../js/mediaelement/build/mediaelementplayer.min.css\" />".PHP_EOL;
$txt .="<link rel=\"stylesheet\" href=\"../../js/mediaelement/build/mejs-skins.css\" />".PHP_EOL;

$txt .="<div class=\"col-xs-12 col-md-6\">".PHP_EOL;
$txt .="<h2 class=\"news-head\"><span class=\"switching\">".$title."</span> <i class=\"fa fa-youtube-play\" aria-hidden=\"true\"></i></h2>".PHP_EOL;

if($a_vdo['vdo_filename'] != ""){
$txt .="<video class=\"mejs-wmp\" id=\"vplayer\" width=\"100%\" height=\"400\" src=\"".$a_vdo['vdo_filename']."\" poster=\"".$vdo_image."\"   type=\"video/mp4\"
	controls=\"controls\" preload=\"none\"></video>".PHP_EOL;
 }else{ 
$txt .="<iframe  class=\"mejs-wmp \" width=\"100%\"  height=\"400\"  src=\"//www.youtube.com/embed/".$vdo_fileyoutube."?wmode=transparent&#038;&#038;iv_load_policy=3&#038;modestbranding=1&#038;rel=0&#038;autohide=1&#038;autoplay=0&#038;mute=1\" class=\"arve-inner\" allowfullscreen frameborder=\"0\" scrolling=\"no\"></iframe>".PHP_EOL;
}	

$txt .="<script> ".PHP_EOL;
$txt .="$('audio,video').mediaelementplayer({".PHP_EOL;
	//mode: 'shim',
$txt .="	success: function(player, node){".PHP_EOL;
$txt .="		$('#' + node.id + '-mode').html('mode: ' + player.pluginType);".PHP_EOL;
$txt .="	}".PHP_EOL;
$txt .="});".PHP_EOL;

$txt .="</script>".PHP_EOL;

$txt .="<div class=\"col-xs-12 link2\" align=\"center\">".PHP_EOL;
$txt .="<h4>".PHP_EOL;
$txt .="<a href=\"more_video.php?gid=".convertEnCode64($vdo)."\">".PHP_EOL;
$txt .="<span class=\"switching\" > ดูวิดีโอทั้งหมด".PHP_EOL;
$txt .="</span>".PHP_EOL;
$txt .="</a>".PHP_EOL;
$txt .="</h4>".PHP_EOL;
$txt .="<br>".PHP_EOL;
$txt .="</div>".PHP_EOL;
$txt .="</div>".PHP_EOL;

		return $txt;
}


function vdo_more($vdo,$start,$perpage,$_SERVER,$page,$wh){
	global $db;

if($vdo){

$s_vdo = $db->query("SELECT * 
FROM vdo_list
INNER JOIN vdo_group ON vdo_group.vdog_id = vdo_list.vdo_group 
WHERE vdo_group = '{$vdo}'
ORDER BY vdo_id DESC LIMIT {$start} , {$perpage}");

$s_vdo2 = $db->query("SELECT * 
FROM vdo_list
INNER JOIN vdo_group ON vdo_group.vdog_id = vdo_list.vdo_group 
WHERE vdo_group = '{$vdo}'
ORDER BY vdo_id DESC");
$total_record = $db->db_num_rows($s_vdo2);
$total_page = ceil($total_record / $perpage);

$txt = "";
$txt .="<section class=\"more_video\">".PHP_EOL;
$txt .="<div class=\"container\">".PHP_EOL;
$txt .="<ol class=\"breadcrumb\">".PHP_EOL;
$txt .="<li><a href=\"index.php\"><i class=\"fa fa-home\" aria-hidden=\"true\"></i></a></li>".PHP_EOL;
$txt .="<li class=\"active\">มัลติมีเดีย</li>".PHP_EOL;
$txt .="</ol>".PHP_EOL;
$txt .="<div class=\"col-xs-12\">".PHP_EOL;
$txt .="<div class=\"col-xs-8 p0\">".PHP_EOL;
$txt .="<h2 class=\"m-y0\">มัลติมีเดีย</h2>".PHP_EOL;
$txt .="</div>".PHP_EOL;
$txt .="</div>".PHP_EOL;
	
$txt .="<div class=\"col-xs-12\">".PHP_EOL;
$txt .="<div class=\"row md-center\">".PHP_EOL;
$i=0;
while($a_vdo = $db->db_fetch_array($s_vdo)){ 

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

$txt .="<div class=\"col-sm-4 animated fadeInDown\" style=\"height:360px;\">".PHP_EOL;
$txt .="<div class=\"blog-item-news\" >".PHP_EOL;
$txt .="<a href=\"video_view.php?vdo=".convertEnCode64($a_vdo['vdo_id'])."\" title=\"".$a_vdo['vdo_name']."\" >";
if($a_vdo['vdo_image'] != ""){ $vdo_image = $a_vdo['vdo_image']; }
if($a_vdo['vdo_filename'] != ""){	
$txt .="<img src=\"".$vdo_image."\" alt=\"".$a_vdo['vdo_name']."\"  title=\"".$a_vdo['vdo_name']."\" class=\"img-responsive\"/>";		
//echo "<video class=\"mejs-wmp\" id=\"vplayer".$i."\" width=\"100%\" height=\"300\" src=\"".$a_vdo['vdo_filename']."\" poster=\"".$vdo_image."\"  type=\"video/mp4\" controls=\"controls\" preload=\"none\"></video>";	
}else{ 
	$txt .="<img src=\"https://i.ytimg.com/vi/".$vdo_fileyoutube."/sddefault.jpg\" alt=\"".$a_vdo['vdo_name']."\"  title=\"".$a_vdo['vdo_name']."\" class=\"img-responsive\" />";
	//echo "<iframe  class=\"mejs-wmp \" width=\"100%\"  height=\"300\"  src=\"//www.youtube.com/embed/".$vdo_fileyoutube."?wmode=transparent&#038;iv_load_policy=3&#038;modestbranding=1&#038;rel=0&#038;autohide=1&#038;autoplay=0&#038;mute=0\" class=\"arve-inner\" allowfullscreen frameborder=\"0\" scrolling=\"no\"></iframe>";	
	} 				
	$txt .="</a>\n";					
                    $txt .="<h4><a href=\"video_view.php?vdo=".convertEnCode64($a_vdo['vdo_id'])."\" title=\"".$a_vdo['vdo_name']."\">";
					$txt .="<span class=\"search-highlight\">";
					$txt .=$a_vdo['vdo_name'];
					$txt .="</span>";
					$txt .="</a></h4>".PHP_EOL;
                    $txt .="<p><i class=\"fa fa-calendar-o\" aria-hidden=\"true\"></i>"; 
					$txt .=convertdatetime($a_vdo['vdo_createdate'])." | <i class=\"fa fa-eye\" aria-hidden=\"true\"></i> ".$a_vdo['vdo_count']."</p>".PHP_EOL;
$txt .="</div>".PHP_EOL;
$txt .="</div>".PHP_EOL;

$i++;
	}
$txt .="</div>\n</div>".PHP_EOL;

$txt .=pagination($start,$perpage,$total_page,$_SERVER,$page,$wh);
$txt .="</div>".PHP_EOL;
$txt .="</section>".PHP_EOL;

	return $txt;
	
		}	
}

function vdo_view($vdo){
	global $db;

vdo_count($vdo);	
	
$s_vdo = $db->query("SELECT * 
FROM vdo_list
WHERE vdo_id = '{$vdo}' ");
$a_vdo = $db->db_fetch_array($s_vdo);

$txt = "";
$txt .="<section class=\"video_view\">".PHP_EOL;
$txt .="<div class=\"container \">".PHP_EOL;
$txt .="<ol class=\"breadcrumb\">".PHP_EOL;
$txt .="<li><a href=\"index.php\"><i class=\"fa fa-home\" aria-hidden=\"true\"></i></a></li>".PHP_EOL;
$txt .="<li><a href=\"more_video.php\">มัลติมีเดีย</a></li>".PHP_EOL;
$txt .="<li class=\"active\">".$a_vdo['vdo_name']."</li>".PHP_EOL;
$txt .="</ol>".PHP_EOL;

$txt .="<div class=\"col-md-12\" align=\"center\">";
$txt .="<h1 class=\"header-title header-color\">".$a_vdo['vdo_name']."</h1>";
$txt .="</div>".PHP_EOL;
$txt .="<div class=\"col-md-12\" align=\"center\">";
$txt .="<p><i class=\"fa fa-calendar-o\" aria-hidden=\"true\"></i>".convertdatetime($a_vdo['vdo_createdate'])." | ";
$txt .="<i class=\"fa fa-eye\" aria-hidden=\"true\"></i> ".$a_vdo['vdo_count']."</p>";
$txt .="</div>".PHP_EOL;

$txt .="<div class=\"col-xs-12 video-wrap\" align=\"center\">";

if($a_vdo['vdo_filename'] != ""){
	$type = "mp4";
}else{
	$type = "youtube";
}
$vdo_fileyoutube = str_replace('https://www.youtube.com/watch?v=', '', $a_vdo['vdo_fileyoutube']);

if($a_vdo['vdo_image'] != ""){ $vdo_image = $a_vdo['vdo_image']; }
if($a_vdo['vdo_filename'] != ""){	
//echo "<img src=\"".$vdo_image."\" alt=\"".$a_vdo['vdo_name']."\"  title=\"".$a_vdo['vdo_name']."\" width=\"100%\" height=\"300\"/>";		
$txt .="<video class=\"mejs-wmp \" id=\"vplayer\" width=\"700\" height=\"400\" src=\"".$a_vdo['vdo_filename']."\" poster=\"".$vdo_image."\"  type=\"video/mp4\" controls=\"controls\" preload=\"none\"></video>";	
}else{ 
//echo "<img src=\"https://i.ytimg.com/vi/".$vdo_fileyoutube."/sddefault.jpg\" alt=\"".$a_vdo['vdo_name']."\"  title=\"".$a_vdo['vdo_name']."\" width=\"100%\" height=\"300\"/>";
$txt .="<iframe  class=\"mejs-wmp \" width=\"100%\"  height=\"400\"  src=\"//www.youtube.com/embed/".$vdo_fileyoutube."?wmode=transparent&#038;iv_load_policy=3&#038;modestbranding=1&#038;rel=0&#038;autohide=1&#038;autoplay=1&#038;mute=0\" class=\"arve-inner\" allowfullscreen frameborder=\"0\" scrolling=\"no\"></iframe>";	
	} 

/*<iframe class="embed-responsive-item" src="https://www.youtube.com/embed/cqf0QRTJ0Io" frameborder="0" style="border:0"></iframe>*/
$txt .="<h4>".$a_vdo['vdo_detail']."</h4>".PHP_EOL;
$txt .=share_buttons();

$txt .="</div>".PHP_EOL;
$txt .="</div>".PHP_EOL;
$txt .="</section>".PHP_EOL;

	return $txt;
	
}


function vdo_count($vid){
	global $db;

$a_count = $db->query("UPDATE vdo_list SET vdo_count = vdo_count+1 WHERE vdo_id = '{$vid}' ");
		
}	


function contact_form($temp){ 
	global $db;

$txt = "";
$txt .="<ol class=\"breadcrumb\">".PHP_EOL;
$txt .="<li><a href=\"index.php\"><i class=\"fa fa-home\" aria-hidden=\"true\"></i></a></li>".PHP_EOL;
$txt .="<li class=\"active\">ติดต่อเรา</li>".PHP_EOL;
$txt .="</ol>".PHP_EOL;
$txt .="<div id=\"loading\"></div>".PHP_EOL;
$txt .="<div class=\"col-xs-12\"><h3>ติดต่อสำนักงาน</h3></div>".PHP_EOL;
$txt .="<div class=\"col-xs-12 col-sm-6\">".PHP_EOL;
$txt .="<h4>กรอกข้อมูลสำหรับติดต่อสำนักงาน</h4>".PHP_EOL;
$txt .="<form id=\"form\" name=\"form\" method=\"POST\" action=\"process.php\" enctype=\"multipart/form-data\">".PHP_EOL;
$txt .="<div class=\"row\">".PHP_EOL;
$txt .="<div class=\"col-lg-3\">".PHP_EOL;
$txt .="<label for=\"example-text-input\" class=\"col-form-label\"><span class=\"text-danger\">*</span>ชื่อ :</label>".PHP_EOL;
$txt .="</div>".PHP_EOL;
$txt .="<div class=\"col-lg-9\">".PHP_EOL;
$txt .="<input class=\"form-control\" type=\"text\"  id=\"name\" name=\"name\" required>".PHP_EOL;
$txt .="</div>".PHP_EOL;
$txt .="</div><br>".PHP_EOL;
$txt .="<div class=\"row\">".PHP_EOL;
$txt .="<div class=\"col-lg-3\">".PHP_EOL;
$txt .="<label for=\"example-text-input\" class=\"col-form-label\"><span class=\"text-danger\">*</span>นามสกุล :</label>".PHP_EOL;
$txt .="</div>".PHP_EOL;
$txt .="<div class=\"col-lg-9\">".PHP_EOL;
$txt .="<input class=\"form-control\" type=\"text\"  id=\"surname\" name=\"surname\" required>".PHP_EOL;
$txt .="</div>".PHP_EOL;
$txt .="</div><br>".PHP_EOL;
$txt .="<div class=\"row\">".PHP_EOL;
$txt .="<div class=\"col-lg-3\">".PHP_EOL;
$txt .="<label for=\"example-text-input\" class=\"col-form-label\"><span class=\"text-danger\">*</span>เบอร์โทรศัพท์ :</label>".PHP_EOL;
$txt .="</div>".PHP_EOL;
$txt .="<div class=\"col-lg-9\">".PHP_EOL;
$txt .="<input class=\"form-control\" type=\"text\"  id=\"tel\" name=\"tel\" required>".PHP_EOL;
$txt .="</div>".PHP_EOL;
$txt .="</div><br>".PHP_EOL;
$txt .="<div class=\"row\">".PHP_EOL;
$txt .="<div class=\"col-lg-3\">".PHP_EOL;
$txt .="<label for=\"example-text-input\" class=\"col-form-label\"><span class=\"text-danger\">*</span>E-mail :</label>".PHP_EOL;
$txt .="</div>".PHP_EOL;
$txt .=" <div class=\"col-lg-9\">".PHP_EOL;
$txt .="<input class=\"form-control\" type=\"email\"  id=\"email\" name=\"email\" required>".PHP_EOL;
$txt .="</div>".PHP_EOL;
$txt .="</div><br>".PHP_EOL;
$txt .="<div class=\"row\">".PHP_EOL;
$txt .="<div class=\"col-lg-3\">".PHP_EOL;
$txt .="<label for=\"example-text-input\" class=\"col-form-label\"><span class=\"text-danger\">*</span>เรื่องที่ต้องการติดต่อ :</label>".PHP_EOL;
$txt .="</div>".PHP_EOL;
$txt .="<div class=\"col-lg-9\">".PHP_EOL;

$s_complain = $db->query("SELECT * FROM m_complain_info  WHERE Complain_lead_status = 'A' ORDER BY Complain_lead_ID ASC"); 
$a_row = $db->db_num_rows($s_complain);             

$txt .="<select name=\"info\" id=\"info\" class=\"form-control\" required=\"\">".PHP_EOL;
$txt .="<option value=\"\"> เลือกข้อมูล </option>".PHP_EOL;
while($a_complain = $db->db_fetch_array($s_complain)){
$txt .="<option value=\"".$a_complain['Complain_lead_ID']."\">".$a_complain['Complain_lead_name']."</option>".PHP_EOL;
}
$txt .=" </select>".PHP_EOL;
$txt .="</div>".PHP_EOL;
$txt .="</div><br>".PHP_EOL;
$txt .="<div class=\"row\">".PHP_EOL;
$txt .="<div class=\"col-lg-3\">".PHP_EOL;
$txt .="<label for=\"example-text-input\" class=\"col-form-label\"><span class=\"text-danger\">*</span>รายละเอียด :</label>".PHP_EOL;
$txt .="</div>".PHP_EOL;
$txt .="<div class=\"col-lg-9\">".PHP_EOL;
$txt .="<textarea class=\"form-control\" rows=\"5\" name=\"detail\" id=\"detail\" required></textarea>".PHP_EOL;
$txt .="</div>".PHP_EOL;
$txt .="</div><br>".PHP_EOL;
$txt .="<div class=\"row\">".PHP_EOL;
$txt .="<div class=\"col-lg-3\">".PHP_EOL;
$txt .="<label for=\"example-text-input\" class=\"col-form-label\">เอกสารที่เกี่ยวข้อง :</label>".PHP_EOL;
$txt .="</div>".PHP_EOL;
$txt .="<div class=\"col-lg-9\">".PHP_EOL;
$txt .="<input type=\"file\" class=\"form-control\"  id=\"file\"  name=\"file\" onchange=\"fncsizefile(this.id,this.value)\" /> ".PHP_EOL;
$txt .="<span class=\"text-danger\">* ประเภทไฟล์ที่สามารถใช้ได้คือ jpg,jpeg,gif,png,doc,docx,xls,xlsx,pdf เท่านั้น  <br>(ขนาดไฟล์ต้องไม่เกิน 10 MB)</span>".PHP_EOL;
$txt .="</div>".PHP_EOL;
$txt .="</div><br>".PHP_EOL;
$txt .="<div align=\"center\">".PHP_EOL;
$txt .="<input class=\"btn btn-info\" type=\"submit\" value=\"ส่งข้อความ\" />".PHP_EOL;
$txt .="</div><br>\n".PHP_EOL;
$txt .="<input type=\"hidden\" name=\"proc\" value=\"AddContact\" />".PHP_EOL;
$txt .="</form> ".PHP_EOL;   
$txt .="</div>".PHP_EOL;

	return $txt;
}



function contact_detail($temp){ 
	global $db;

$s_contact = $db->query("SELECT * 
FROM contact
WHERE contact_id = '1' ");
$a_contact = $db->db_fetch_array($s_contact);	
	
$txt = "";	
$txt .="<div class=\"col-xs-12 col-sm-12\">".PHP_EOL;
$txt .="<h4>".PHP_EOL;
$txt .="<strong>".$a_contact['contact_name']."</strong><br><br>".$a_contact['contact_address'].PHP_EOL;
$txt .="</h4>".PHP_EOL;
$txt .="<h4>โทรศัพท์ : ".$a_contact['contact_tel']."<br><br>".PHP_EOL;
$txt .="สำนักงาน : ".$a_contact['contact_off_number']."<br><br>".PHP_EOL;
$txt .="โทรสาร : ".$a_contact['contact_fax']."<br><br>".PHP_EOL;
$txt .="E-mail: <span> <a href=\"mailto:".$a_contact['contact_email']."\">".$a_contact['contact_email']."</a> </span><br><br>".PHP_EOL;
$txt .="Line ID: <span>".$a_contact['contact_line']." </span>".PHP_EOL;
$txt .="</h4>".PHP_EOL;
$txt .="<h3>".PHP_EOL;
$txt .="<br>ช่องทางติดต่ออื่น ๆ".PHP_EOL;
$txt .="</h3>".PHP_EOL;
$txt .="<h2>".PHP_EOL;

$B = explode("#@#",$a_contact['contact_other']);

if($B[0]){ 
$txt .="<a href=\"".substr($B[0],"1")."\" target=\"_blank\"><i class=\"fa fa-facebook\"></i></a>".PHP_EOL;
}
if($B[1]){ 
$txt .="<a href=\"".substr($B[1],"1")."\" target=\"_blank\"><i class=\"fa fa-twitter\"></i></a>".PHP_EOL;
}
if($B[2]){ 
$txt .="<a href=\"".substr($B[2],"1")."\" target=\"_blank\"><i class=\"fa fa-youtube\"></i></a>".PHP_EOL;
}
$txt .="</h2>".PHP_EOL;
$txt .="<br>".PHP_EOL;
$txt .="</div>".PHP_EOL;

	return $txt;
}



function contact_footer($temp){ 
	global $db;

$s_contact = $db->query("SELECT * 
FROM contact
WHERE contact_id = '1' ");
$a_contact = $db->db_fetch_array($s_contact);	
	
	
$txt = "";	
$txt .="<div class=\"row\">".PHP_EOL;
$txt .="<div class=\"col-sm-4\" align=\"center\">".PHP_EOL;
$txt .="<a href=\"contact.php\"><div class=\"circle-icon\">".PHP_EOL;
$txt .="<i class=\"fa fa-map-marker\" aria-hidden=\"true\"></i>".PHP_EOL;
$txt .="</div></a>".PHP_EOL;
$txt .="<p>".PHP_EOL;
$txt .="<span class=\"switching\" >".$a_contact['contact_name']."</span> ".PHP_EOL;
$txt .="<br>".PHP_EOL; 
$txt .="<span class=\"switching\" >".$a_contact['contact_address']."</span>".PHP_EOL;
$txt .="</p>".PHP_EOL;
$txt .="</div>".PHP_EOL;
$txt .="<div class=\"col-sm-4\" align=\"center\">".PHP_EOL;
$txt .=" <div class=\"circle-icon\">".PHP_EOL;
$txt .="<i class=\"fa fa-phone\" aria-hidden=\"true\"></i>".PHP_EOL;
$txt .="</div>".PHP_EOL;
$txt .="<p>".PHP_EOL;
$txt .="<span class=\"switching\" >มือถือ</span>: ".$a_contact['contact_tel']." <br> ".PHP_EOL;
$txt .="<span class=\"switching\" >สำนักงาน</span>: ".$a_contact['contact_off_number']." <br> ".PHP_EOL;
$txt .="<span class=\"switching\" >โทรสาร</span>: ".$a_contact['contact_fax']." <br> ".PHP_EOL;
$txt .="</p>".PHP_EOL;
$txt .="</div>".PHP_EOL;
$txt .="<div class=\"col-sm-4\" align=\"center\">".PHP_EOL;
$txt .="<div class=\"circle-icon\">".PHP_EOL;
$txt .="<i class=\"fa fa-envelope-o\" aria-hidden=\"true\"></i>".PHP_EOL;
$txt .="</div>".PHP_EOL;
$txt .="<a href=\"mailto:".$a_contact['contact_email']."\">".$a_contact['contact_email']."</a>".PHP_EOL;
$txt .="</div>".PHP_EOL;
$txt .="</div>".PHP_EOL;
	
	return $txt;
}

function vistor_stat(){
	global $db;
	
	$s_stat = $db->query("SELECT * 
FROM vdo_list
INNER JOIN vdo_group ON vdo_group.vdog_id = vdo_list.vdo_group 
WHERE vdo_group = '{$vdo}'
ORDER BY vdo_id DESC");
$total_record = $db->db_num_rows($s_vdo2);
		
}

function footer($temp){ 
	global $db;

$title = gentitle();	
$s_title = explode( 'สำนักงานการท่องเที่ยวและกีฬา', $title );
	
$txt = "";	
$txt .="<div class=\"container-fluid footer\">".PHP_EOL;
$txt .="<div class=\"container\">".PHP_EOL;
$txt .=sitemap('0002','1').PHP_EOL;
$txt .=contact_footer('').PHP_EOL;
$txt .="<br>".PHP_EOL;
$txt .="<div class=\"row copyright\" align=\"center\">".PHP_EOL;
$txt .="<p>".PHP_EOL;
$txt .="<span class=\"switching\" >สงวนลิขสิทธิ์ 2561</span>".PHP_EOL;
$txt .="<span class=\"switching\" >สำนักงานการท่องเที่ยวและกีฬา</span>".PHP_EOL;
$txt .="<span class=\"switching\" >".$s_title[1]."</span>".PHP_EOL;
$txt .="<span class=\"switching\" ></span>".PHP_EOL;
$txt .="</p>".PHP_EOL;
$txt .=sitemap('0003','2').PHP_EOL;    
$txt .="<p>".PHP_EOL;
$txt .="<span class=\"switching\" >จำนวนผู้ชมเว็บไซต์</span> <img src=\"ewt_c.php?id=1\" data-pin-nopin=\"true\" alt=\"ผู้เข้าชมเว็บไซต์\"> | ".PHP_EOL;
$txt .="<span class=\"switching\" >รวมตั้งแต่วันที่</span> 1 <span class=\"switching\" >ต.ค.</span>".PHP_EOL;
$txt .="<span class=\"switching\" >57</span>".PHP_EOL;
$txt .="</p>".PHP_EOL;
$txt .="</div>".PHP_EOL;
		
$txt .="</div>".PHP_EOL;
$txt .="</div>".PHP_EOL;

	return $txt;
}


function modal_fade(){ 

$txt = "";
$txt .="<div class=\"modal fade\" id=\"myModalSubscribe\" tabindex=\"-1\" role=\"dialog\" aria-labelledby=\"myModalSubscribe\"></div>";
	
	return $txt;
}

function news_letter_form($temp){ 
	global $db;	
	
$txt = "";	
$txt .="<div class=\"col-xs-12 col-sm-12\">".PHP_EOL;
$txt .="<h3>สมัครรับข่าวสาร</h3>".PHP_EOL;
$txt .="<br>".PHP_EOL;
$txt .="<form class=\"form-inline\" method=\"post\" name=\"formEnew\" id=\"formEnew\">".PHP_EOL;
$txt .="<div class=\"form-group center\">".PHP_EOL;
$txt .="<fieldset>".PHP_EOL;
$txt .="<input type=\"email\" class=\"form-control  space_top-bot\" id=\"email1\" name=\"email1\" required placeholder=\"yourmail@domain.com\">".PHP_EOL;
$txt .="<label class=\"radio-inline space_top-bot\" for=\"status\">".PHP_EOL;
$txt .="<input class=\"space_top-bot\" type=\"radio\" name=\"status\" id=\"status\" value=\"1\"> สมัคร".PHP_EOL;
$txt .="</label>".PHP_EOL;
$txt .="<label class=\"radio-inline space_top-bot\" for=\"status\">\n".PHP_EOL;
$txt .="<input class=\"space_top-bot\" type=\"radio\" name=\"status\" id=\"status1\" value=\"2\"> ยกเลิก".PHP_EOL;
$txt .="</label>".PHP_EOL;
$txt .="<button type=\"button\" class=\"btn btn-default space space_top-bot\" role=\"button\" onClick=\"checkemail();\"><span class=\"fa fa-envelope\" aria-hidden=\"true\"></span> ตกลง</button>".PHP_EOL;
$txt .="</fieldset>".PHP_EOL;
$txt .="</div>".PHP_EOL;
$txt .="</form>	".PHP_EOL;
$txt .="</div>".PHP_EOL;	
//$txt .="<!-- แสดงข้อความสมัครรับข่าวสาร-->\n";
//$txt .="<div class=\"modal fade\" id=\"myModalSubscribe\" tabindex=\"-1\" role=\"dialog\" aria-labelledby=\"myModalSubscribe\">\n";
//$txt .="</div>\n";
	return $txt;
}


function poll_all($c_id,$temp,$start,$perpage,$_SERVER,$page,$wh){
	global $db;	

$date_poll_now = date("Y-m-d");
$time_poll_now = date("H:i:s");

$w = "AND ((('{$date_poll_now}' between c_start AND c_stop) OR (c_start <= '{$date_poll_now}' AND c_stop = '')))";	
//$w = "AND (c_start >= '{$date_poll_now}')";

//$w = "AND ((c_start = '' and c_stop = '')";
//$w .= "AND ('".$date_poll_now."' between c_start AND c_stop + INTERVAL 1 DAY ) )";

$s_poll = $db->query("SELECT * FROM poll_cat WHERE c_approve = 'Y' {$w} ORDER BY c_id DESC
LIMIT {$start} , {$perpage}");
$a_row = $db->db_num_rows($s_poll);   

$s_poll2 = $db->query("SELECT * FROM poll_cat WHERE c_approve = 'Y' {$w} ORDER BY c_id DESC");
$total_record = $db->db_num_rows($s_poll2);	
$total_page = ceil($total_record / $perpage);
	
$txt = "";	
$txt .="<section class=\"more_formgen\">".PHP_EOL;
$txt .="<div class=\"container\">".PHP_EOL;;
$txt .="<ol class=\"breadcrumb\">".PHP_EOL;
$txt .="<li><a href=\"index.php\"><i class=\"fa fa-home\" aria-hidden=\"true\"></i></a></li>".PHP_EOL;
$txt .="<li class=\"active\">แบบสำรวจออนไลน์</li>\n".PHP_EOL;
$txt .="</ol>".PHP_EOL;
$txt .="<h2 class=\"m-y0\">แบบสำรวจออนไลน์</h2><br>".PHP_EOL;
$txt .="<div class=\"table-responsive\">".PHP_EOL;
$txt .="<table class=\"table table-hover\">".PHP_EOL;
if($a_row){	
while($a_poll = $db->db_fetch_array($s_poll)){
$txt .="<tr>".PHP_EOL;
$txt .="<td width=\"35\"><!--span class=\"glyphicon glyphicon-record\" aria-hidden=\"true\"></span--><i class=\"fa fa-pencil-square-o\" aria-hidden=\"true\"></i></td>".PHP_EOL;
$txt .="<td align=\"left\"><a href=\"polls_view.php?c_id=".$a_poll['c_id']."\" title=\"".$a_poll['c_name']."\">".$a_poll['c_name']."</a>";
$txt .=" <i class=\"fa fa-eye\" aria-hidden=\"true\"></i> ".$a_poll['c_view'];
$txt .="</td>".PHP_EOL;
$txt .="</tr>".PHP_EOL;
}
}else{
	
}	
$txt .="</table>".PHP_EOL;
$txt .="</div>".PHP_EOL;
$txt .=pagination($start,$perpage,$total_page,$_SERVER,$page,$wh);	
$txt .="</div>".PHP_EOL;
$txt .="</section>".PHP_EOL;

	return $txt;
}


function poll_count($c_id){
	global $db;
	
$a_count = $db->query("UPDATE poll_cat SET c_view = (c_view+1) WHERE c_id = '{$c_id}' ");
//return $article_count;
}


function graph_all($g_id,$temp,$start,$perpage,$_SERVER,$page,$wh){
	global $db;

	
$w = "";	
$s_graph = $db->query("SELECT * FROM graph_index {$w} ORDER BY graph_id DESC
LIMIT {$start} , {$perpage}");
$a_row = $db->db_num_rows($s_graph);   

$s_graph2 = $db->query("SELECT * FROM graph_index {$w} ORDER BY graph_id DESC");
$total_record = $db->db_num_rows($s_graph2);	
$total_page = ceil($total_record / $perpage);	

$txt = "";
$txt .="<section class=\"more_formgen\">".PHP_EOL;
$txt .="<div class=\"container\">".PHP_EOL;
$txt .="<ol class=\"breadcrumb\">".PHP_EOL;
$txt .="<li><a href=\"index.php\"><i class=\"fa fa-home\" aria-hidden=\"true\"></i></a></li>".PHP_EOL;
$txt .="<li class=\"active\">กราฟ</li>".PHP_EOL;
$txt .="</ol>".PHP_EOL;
$txt .="<h2 class=\"m-y0\">กราฟทั้งหมด</h2><br>".PHP_EOL;
           
$txt .="<div class=\"table-responsive\">".PHP_EOL;
$txt .="<table class=\"table table-hover\">".PHP_EOL;
if($a_row){	
while($a_graph = $db->db_fetch_array($s_graph)){
$txt .="<tr>".PHP_EOL;
$txt .="<td width=\"35\"><!--span class=\"glyphicon glyphicon-record\" aria-hidden=\"true\"></span--><i class=\"fa fa-pencil-square-o\" aria-hidden=\"true\"></i></td>\n";
$txt .="<td align=\"left\"><a href=\"graph_views.php?graph_id=".$a_graph['graph_id']."\" title=\"".$a_graph['graph_subject']."\">".$a_graph["graph_subject"]."</a>";
$txt .=" <i class=\"fa fa-eye\" aria-hidden=\"true\"></i> ".$a_graph['graph_count'];
$txt .="</td>".PHP_EOL;
$txt .="</tr>".PHP_EOL;
}
	}
$txt .="</table>".PHP_EOL;
$txt .="</div>".PHP_EOL;
if($a_row){	
$txt .=pagination($start,$perpage,$total_page,$_SERVER,$page,$wh);	
}	
$txt .="</div>".PHP_EOL;
$txt .="</section>".PHP_EOL;

	return $txt;
	
}


function google_map($temp){ 
	global $db;

$s_contact = $db->query("SELECT * 
FROM contact
WHERE contact_id = '1' ");
$a_contact = $db->db_fetch_array($s_contact);
	
$txt = "";		
$txt .="<div class=\"col-xs-12 col-sm-12\">".PHP_EOL;
$txt .="<br>";
$txt .="<h3>แผนที่</h3>".PHP_EOL;
$txt .="<iframe width=\"100%\" height=\"450\" frameborder=\"0\" style=\"border:0\" src=\"".$a_contact['contact_map']."\" allowfullscreen></iframe>";
//$txt .="<p><br><a href=\"images/map.png\"><i class=\"fa fa-map\"></i> ดาวน์โหลดแผนที่</a></p>";
$txt .="</div>".PHP_EOL;

	return $txt;

}

function share_buttons_count($nid){
	global $db;
	
$a_count = $db->query("UPDATE article_list SET n_count_share = n_count_share+1 WHERE n_id = '{$nid}' ");
	
}

function calendar($gid,$temp){
	global $db;
	
$txt = "";	
$txt .= "<style>".PHP_EOL;
$txt .= "	#calendar {".PHP_EOL;
$txt .= "		max-width: 900px;".PHP_EOL;
$txt .= "		margin: 0 auto;".PHP_EOL;
$txt .= "	}".PHP_EOL;
$txt .= "</style>".PHP_EOL;
$txt .= "<section class=\"calendar_module\">".PHP_EOL;
$txt .= "	<div class=\"container\">".PHP_EOL;
$txt .= "       <ol class=\"breadcrumb\">".PHP_EOL;
$txt .= "            <li><a href=\"index.php\"><i class=\"fa fa-home\" aria-hidden=\"true\"></i></a></li>".PHP_EOL;
$txt .= "            <li><a href=\"\">ปฏิทินกิจกรรม</a></li>".PHP_EOL;
$txt .= "		</ol>".PHP_EOL;           
$txt .= "       <h2 class=\"m-y0\"><i class=\"fa fa-folder-open-o\"></i> ปฏิทินกิจกรรม</h2>".PHP_EOL;
$txt .= "        <br>".PHP_EOL;   
$txt .= "        <div id='calendar'></div>".PHP_EOL;
$txt .= "        <br>".PHP_EOL;
$txt .= "        <div align=\"center\">".PHP_EOL;
$txt .= "             	<a href=\"calendar_more.php\">".PHP_EOL;
$txt .= "             		<button type=\"button\" class=\"btn btn-primary\"> <!--i class=\"fa fa-thumbs-o-up\" aria-hidden=\"true\"></i--> ดูทั้งหมด</button>".PHP_EOL;
$txt .= "             	</a>".PHP_EOL;
$txt .= "            </div>".PHP_EOL;
$txt .= "   </div>".PHP_EOL;
$txt .= "</section>".PHP_EOL;

	return $txt;
}

function calendar_all($temp){
	global $db;


}

function ebook_count($bid){
	global $db;
	
$a_count = $db->query("UPDATE ebook_info SET ebook_count = ebook_count+1 WHERE ebook_id = '{$bid}' ");

}

function share_buttons(){
	global $nid;
	
$txt = "";	
$txt .= "<div id=\"share-buttons\">".PHP_EOL;
/*-- Line --*/

//$txt .= "<div style=\"display:inline;top:10px;position:relative\" >\n";
//$txt .= "<div class=\"line-it-button\" data-lang=\"en\" data-type=\"share-c\" data-url=\"https://lineit.line.me/share/ui?url=".linkshare()."\" style=\"display: none;\" ></div></div>\n";
//$txt .= "<script src=\"https://d.line-scdn.net/r/web/social-plugin/js/thirdparty/loader.min.js\" async=\"async\" defer=\"defer\"></script>\n";  
 
$txt .= "<a href=\"https://lineit.line.me/share/ui?url=".linkshare()."\" targettarget=\"_blank\" onClick=\"return  share_buttons_count('".$nid."');\"  title=\"share line\">";
$txt .= "<img src=\"https://scdn.line-apps.com/n/line_regulation/files/ver2/LINE_Icon.png\" width=\"30\" height=\"30\">";
$txt .= "</a>".PHP_EOL; 

/*-- Facebook --*/
$txt .= "<a id=\"link\" href=\"http://www.facebook.com/sharer.php?u=".linkshare()."\" target=\"_blank\" onClick=\"return  share_buttons_count('".$nid."');\">";
$txt .= "<img src=\"https://simplesharebuttons.com/images/somacro/facebook.png\" alt=\"Facebook share\" width=\"30\"  />";
$txt .= "</a>".PHP_EOL;
 
/*-- Google+ --*/
$txt .= "<a href=\"https://plus.google.com/share?url=".linkshare()."\" target=\"_blank\" onClick=\"return  share_buttons_count('".$nid."');\">";
$txt .= "<img src=\"https://simplesharebuttons.com/images/somacro/google.png\" alt=\"Google share\" width=\"30\" />";
$txt .= "</a>".PHP_EOL;

/*-- Twitter --*/
$txt .= "<a href=\"https://twitter.com/share?url=".linkshare()."&amp;text=".gentitle()."&amp;hashtags=".gentitle()."\" target=\"_blank\" onClick=\"return  share_buttons_count('".$nid."');\" >";
$txt .= "<img src=\"https://simplesharebuttons.com/images/somacro/twitter.png\" alt=\"Twitter share\" width=\"30\" />";
$txt .= "</a>".PHP_EOL;
  
/*-- Print --*/
$txt .= "<a href=\"javascript:;\" onclick=\"window.print()\">";
$txt .= "<img src=\"https://simplesharebuttons.com/images/somacro/print.png\" alt=\"Print\" width=\"30\" />";
$txt .= "</a>".PHP_EOL;
$txt .= "</div>".PHP_EOL;

	return $txt;

}

function pagination($start,$perpage,$total_page,$_SERVER,$page,$wh){
	global $db;
	
$txt ="";				
$txt .="<div align=\"center\" >".PHP_EOL;
$txt .="<nav aria-label=\"Page navigation\" >".PHP_EOL;
$txt .="<ul class=\"pagination\" style=\"padding-top:70px;\">".PHP_EOL;

if($page == '1'){
	$disabledprevioust = 'disabled';
}else{
	$previous1 = "href=".$_SERVER."?page=1".$wh;
	$previous2 = "href=".$_SERVER."?page=".($page - 1).$wh;
}
		  
$txt .="<li class=\"previous ".$disabledprevioust."\">";
$txt .="<a ".$previous1." aria-label=\"Previous\">";
$txt .="<span aria-hidden=\"true\"> &laquo; </span> <span class=\"hidden-xs\"> หน้าแรก </span>";
$txt .="</a>";
$txt .="</li>".PHP_EOL;

$txt .="<li class=\"previous ".$disabledprevioust."\">";
$txt .="<a ".$previous2." aria-label=\"Previous\">";
$txt .="<span aria-hidden=\"true\"> &lt; </span> <span class=\"hidden-xs\"> ก่อนหน้านี้ </span>";
$txt .="</a>";
$txt .="</li>".PHP_EOL;
	
for($i=1;$i<=$total_page;$i++){ 
	if($page == $i){ 
	
$txt .="<li class=\"active\"><a href=\"".$_SERVER."?page=".$i.$wh."\">".$i."</a></li>".PHP_EOL;
 }else{ 
$txt .="<li ><a href=\"".$_SERVER."?page=".$i.$wh."\">".$i."</a></li>".PHP_EOL;
} 
	} 
	
if($page == $total_page){		
	$disablednext = 'disabled';
	$next1 = "";
	$next2 = "";
}else{
	$next1 = "href=".$_SERVER."?page=".($page + 1).$wh;
	$next2 = "href=".$_SERVER."?page=".$total_page.$wh;
}

$txt .="<li class=\"next ".$disablednext."\">";
$txt .="<a ".$next1." aria-label=\"Next\">";
$txt .="<span class=\"hidden-xs\">หน้าถัดไป</span><span aria-hidden=\"true\">  &gt; </span>";
$txt .="</a>";
$txt .="</li>".PHP_EOL;

$txt .="<li class=\"next ".$disablednext."\">";
$txt .="<a ".$next2." aria-label=\"Next\">";
$txt .="<span class=\"hidden-xs\">หน้าท้ายสุด</span> <span aria-hidden=\"true\">  &raquo; </span>";
$txt .="</a>";
$txt .="</li>";
$txt .="</ul>".PHP_EOL;
	  
$txt .="</nav>".PHP_EOL;
$txt .="</div>".PHP_EOL;

return $txt;
}


?>
