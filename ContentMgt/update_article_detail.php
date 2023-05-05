<?php
set_time_limit (1000);
	include("../lib/permission1.php");
	include("../lib/include.php");
	include("../lib/function.php");
	include("../lib/user_config.php");
	include("../lib/connect.php");

$nid = array();
$sql = $db->query("select n_id from article_list");
while($S = $db->db_fetch_row($sql)){
array_push($nid,$S[0]);
}
//print_r($nid);

for($i=0;$i<count($nid);$i++){
$keyword = "";
	$sql_keyword = $db->query("SELECT ad_des FROM article_detail WHERE n_id = '".$nid[$i]."' ORDER BY at_type_row,at_type_col ");
	while($D = $db->db_fetch_row($sql_keyword)){
	$keyword .= $D[0];
	
	}
	//echo $keyword;
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

$keyword = preg_replace ($search, $replace, $keyword);
$db->query("UPDATE article_list SET keyword = '".addslashes($keyword)."', n_last_modi='".date('YmdHis')."' WHERE  n_id = '".$nid[$i]."' ");
echo $nid[$i].'<br>';
}#end for 
echo "comp!!";
?>