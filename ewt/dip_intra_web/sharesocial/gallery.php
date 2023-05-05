<?php
//include("assets/config.inc.php");
include("../lib/function.php");
include("../lib/user_config.php");
include("../lib/connect.php");

$id = (int)(!isset($_GET['id']) ? 0 : $_GET['id']);

$s_sql  = $db->query("SELECT * FROM gallery_category WHERE category_id = '{$id}' ");
$a_data = $db->db_fetch_array($s_sql);

$s_img = $db->query("select a.img_path_b 
from gallery_image a 
join gallery_cat_img b on b.img_id = a.img_id 
where b.category_id = '{$id}' 
order by b.cat_img_id DESC LIMIT 0,1");
$a_img = $db->db_fetch_array($s_img);

$img_cover = (file_exists('../'.$a_img['img_path_b']) && $a_img['img_path_b'] != '' ) ? $a_img['img_path_b'] : "img/default-article.jpg";

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
	
	return $_protocal."://".$s_host.$chk_site.'/'.$modal.'.php?category_id='.$id;
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
	
	return $_protocal."://".$s_host.$chk_site.'/sharesocial/'.$modal.'.php?id='.$id;
}

function linkimg_face($img){
	
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
	
	return $_protocal."://".$s_host.$chk_site.'/'.$img;
}

$share_img = linkimg_face($img_cover);  

?>
<!doctype html>
<html lang="en" class="no-js">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1">	
<link rel="shortcut icon" href="img/favicon.png">
<title><?=$a_data['category_name'];?></title>
<meta name="description" content="<?=$a_data['category_name'].','.$a_data['category_detail'];?>">
<meta name="keyword" content="<?=$a_data['category_name'].','.$a_data['category_detail'];?>">
<meta property="og:title" content="<?=$a_data["category_name"]; ?>" />
<meta property="og:url" content="<?=linkshare_old_face('gallery',$id);?>" />
<meta property="og:type" content="website" />		
<meta property="og:image" content="<?=$share_img;?>" />
<meta property="og:description" content="<?=$a_data['category_name'].','.$a_data['category_detail'];?>" />  
<meta property="twitter:card" content="summary_large_image" />
<meta property="twitter:title" content="<?=$a_data['category_name'];?>" />
<meta property="twitter:site" content="OTCC_WEB" />

</head>
<body>
<div>
<?php //echo $share_img ;?>
<img src="<?=$share_img;?>" class="img-fluid shadow-ebook" alt="Responsive image" _style="border-radius: 10px;width:186px;height:186px;">
</div>
</body>
</html>				