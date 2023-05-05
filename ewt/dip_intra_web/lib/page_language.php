<?php 
## >> Language can only be in upper case
if($_GET["lang"]==""){
	$language     = "TH";
	$_GET["lang"] = "TH";
}
else{
	$language = strtoupper($_GET["lang"]);
}

if(count($EWT_SEO_URL)==0){
	$seo_data  = $db->query("SELECT * FROM page_seourl");
	while($seo_info = $db->db_fetch_array($seo_data)){
		array_push($EWT_SEO_URL,$seo_info);
	}
}
##=========================================================================##


if($language!=$_GET["lang"]){

	## >> Valid language
	if(!in_array($language,array("TH","EN"))){
		$language = "TH";
	}

	//$redirect_url = "Y";
}

if($redirect_url == "Y"){

	$redirect_url = create_seourl($file_page,$language);
	$backtrack    = explode("/",$redirect_url);
	$backtrack    = count($backtrack)-1;

	if($redirect_404 == "Y"){
		//$redirect_url = $language."/404";
		$redirect_url = '404.php';
	}

	for($b=0;$b<$backtrack;$b++){
		$redirect_url = "../".$redirect_url;
	}

	header("location:".$redirect_url);
	exit();
}

## >> Has page

/*if($_GET["lala"]==123){

	echo "<pre>";
	print_r($EWT_SEO_URL);
	echo "</pre>";
	exit();
}*/


?>

