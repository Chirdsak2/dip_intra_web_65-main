<?php 
include("../lib/function.php");
include("../lib/user_config.php");
include("../lib/connect.php");

/*echo '<pre>';
print_r($index_menu);
echo '</pre>';*/

$seo_array = array();
##============================================================================================##
function create_seourl_test($url,$language){
	
	global $EWT_SEO_URL;
	global $db;
	
	$seo_url = "";

	## >> Must be in-site url
	
	if(count($EWT_SEO_URL)==0){
		$seo_data  = $db->query("SELECT * FROM page_seourl");
		while($seo_info = $db->db_fetch_array($seo_data)){
			array_push($EWT_SEO_URL,$seo_info);
		}
	}

	foreach($EWT_SEO_URL AS $check){
		$pos = (string)(strpos($url,$check["filename"]));
		
		if($pos=="0"){
			$seo_url = $language."/".$check["seo_url"];
			
			## >> $_GET parameter
			$gpos = (string)strpos($url,"?");
			if($gpos!=""){
				$get_line = substr($url,strpos($url,"?")+1,strlen($url));
				$get_line = explode("&",$get_line);

				foreach($get_line AS $get){

					if((string)strpos($get,"page=")=="0" && $check["pagination"]=="Y"){
						$seo_url .= "/page/".str_replace("page=","",$get);
					}
				}
			}
			else{
				if($check["pagination"]=="Y"){
					$seo_url .= "/page/1";
				}
			}

		}
	}

	## >> Special condition


	## >> Doesn't fit any condition
	if($seo_url==""){
		$seo_url = $url;
	}

	return $seo_url;
}
##============================================================================================##

echo create_seourl_test("home.php","TH")."<br/>";
echo create_seourl_test("search_result.php","TH")."<br/>";
echo create_seourl_test("ebook_list.php","TH")."<br/>";
echo create_seourl_test("ebook_list.php?page=2","TH")."<br/>";


?>