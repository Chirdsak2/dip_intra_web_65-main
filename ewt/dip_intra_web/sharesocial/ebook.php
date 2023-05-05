<?php
$s_sql_egroup  = $db->query("SELECT * FROM ebook_group WHERE g_ebook_id = '{$a_id}' ");
$a_data_egroup = $db->db_fetch_array($s_sql_egroup);

$s_sql  = $db->query("SELECT * FROM ebook_info WHERE g_ebook_id = '{$a_id}' order by ebook_id desc");
$a_data_ebook = $db->db_fetch_array($s_sql);

$img_cover = (file_exists('../ebook/'.$a_data_ebook['ebook_code'].'/pages/'.$a_data_ebook['ebook_cover']) && $a_data['ebook_cover'] != '' ) ? 'ebook/'.$a_data_ebook['ebook_code'].'/pages/'.$a_data_ebook['ebook_cover'] : "img/default-article.jpg";

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

$a_title       = $a_data_egroup['g_ebook_name'];
$a_description = $a_data_egroup['g_ebook_name'];
$a_pathimage   = $share_img;	
$a_keyword     = $a_data_egroup['g_ebook_name'];
/*function linkshare_face($modal,$id){
	
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
	
	return $_protocal."://".$s_host.$chk_site.'/'.$modal.'.php?category_id='.$id.'';
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
	
	return $_protocal."://".$s_host.$chk_site.'/sharesocial/'.$modal.'.php?id='.$id.'&share=otcc_web';
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
<title><?=$a_data['ebook_name'];?></title>
<meta name="description" content="<?=$a_data['ebook_name'].','.$a_data['ebook_desc'];?>">
<meta name="keyword" content="<?=$a_data['ebook_name'].','.$a_data['ebook_desc'];?>">
<meta property="og:title" content="<?=$a_data["ebook_name"]; ?>" />
<meta property="og:url" content="<?=linkshare_old_face('ebook',$id);?>" />
<meta property="og:type" content="website" />		
<meta property="og:image" content="<?=$share_img;?>" />
<meta property="og:description" content="<?=$a_data['ebook_name'].','.$a_data['ebook_desc'];?>" />  
<meta property="twitter:card" content="summary_large_image" />
<meta property="twitter:title" content="<?=$a_data['ebook_name'];?>" />
<meta property="twitter:site" content="OTCC_WEB" />

</head>
<body>
<div>
<?php
if(!empty($share)){
redirect('../ebook/'.$a_data['ebook_code'].'/index.html');
}
?>
<?php //echo $share_img ;?>
<img src="<?=$share_img;?>" class="img-fluid shadow-ebook" alt="Responsive image" _style="border-radius: 10px;width:186px;height:186px;">
</div>
</body>
</html>	
*/
?>
			