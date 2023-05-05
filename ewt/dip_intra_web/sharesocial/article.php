<?php
include("../lib/function.php");
include("../lib/user_config.php");
include("../lib/connect.php");



$nid = (int)(!isset($_GET['id']) ? 0 : $_GET['id']);

$s_article_list = $db->query("SELECT * FROM article_list WHERE n_id = '{$nid}' ");
$a_data 		= $db->db_fetch_array($s_article_list);


function linkshare_face($modal,$id){
	
	$s_host = $_SERVER['HTTP_HOST'];
	$s_name = $_SERVER['SCRIPT_NAME'];
	$s_url  = $_SERVER['REQUEST_URI'];
	$_protocal = (isset($_SERVER['HTTPS']))?'https':'http';
	
	$s_method = strtok($s_url, '?');
    if($s_method)
    {
      $a_method = explode('/', $s_method);

		$chk_site = "/".$a_method[1]."/".$a_method[2]."/".$a_method[3];
	}
	
	return $_protocal."://".$s_host.$chk_site.'/'.$modal.'.php?id='.$id;
}


function linkshare_old_face($modal,$id){
	
	$s_host = $_SERVER['HTTP_HOST'];
	$s_name = $_SERVER['SCRIPT_NAME'];
	$s_url  = $_SERVER['REQUEST_URI'];
	$_protocal = (isset($_SERVER['HTTPS']))?'https':'http';
	
	$s_method = strtok($s_url, '?');
    if($s_method)
    {
      $a_method = explode('/', $s_method);

		$chk_site = "/".$a_method[1]."/".$a_method[2]."/".$a_method[3];
	}
	
	return $_protocal."://".$s_host.$chk_site.'/'.$modal.'.php?nid='.$id.'&share=otcc_web';
}
	
				function share_face($nid){
					global $db,$EWT_FOLDER_USER;
					$PHPSELF = explode('/',$_SERVER["PHP_SELF"]);
					$exc = $db->query("SELECT * FROM article_list WHERE n_id = '{$nid}' ");
					$row = $db->db_fetch_array($exc);
					if($row['n_sharename']!=""){
						$paths = $PHPSELF[1]."/ewt/".$row['n_sharename']."/";
						}else{
						$paths = $PHPSELF[1]."/ewt/".$EWT_FOLDER_USER."/";
					}
					$_protocal = (isset($_SERVER['HTTPS']))?'https':'http';
					
					return $_protocal."://".$_SERVER['HTTP_HOST']."/".$paths;	
				}	
				
				function nidshare($nid){
					global $db;
					$exc = $db->query("SELECT * FROM article_list WHERE n_id = '{$nid}' ");
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
		
					if(!empty($a_data['picture'])){
							$img = "images/article/news".nidshare($a_data['n_id'])."/".$a_data['picture'];
						}else{
						$img = "img/default-article.jpg";
							}
					
					$share_img = share_face($nid).$img;  
?>
<html xmlns="http://www.w3.org/1999/xhtml"
	xmlns:og="http://ogp.me/ns#"
	xmlns:fb="http://www.facebook.com/2008/fbml">
<head>
<title><?=$a_data['n_topic'];?></title>
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">		
<meta name="description" content="<?=$a_data['n_topic']; ?>">
<meta name="keyword" content="<?=$a_data['n_topic']; ?>">
<meta property="og:title" content="<?=$a_data["n_topic"]; ?>" />
<meta property="og:url" content="<?=linkshare_face('article-views',$nid);?>" />
<meta property="og:type" content="website" />		
<meta property="og:image" content="<?=$share_img?>" />
<meta property="og:description" content="<?=$a_data['n_topic'];?>" />  
<meta property="twitter:card" content="summary_large_image" />
<meta property="twitter:title" content="<?=$a_data['n_topic'];?>" />
<meta property="twitter:site" content="OTCC_WEB" />

</head>
<body>
<img src="<?=$share_img;?>">
</body>
</html>				