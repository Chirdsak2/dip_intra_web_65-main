<?php
$s_vdo_list = $db->query("SELECT * FROM  vdo_group WHERE vdog_id = '{$a_id}' ");
//$s_vdo_list = $db->query("SELECT * FROM  vdo_list WHERE vdo_id = '{$a_id}' ");
$a_vdo_list = $db->db_fetch_array($s_vdo_list);



$img_cover = "img/default-article.jpg";

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
	
$a_title       = $a_vdo_list['vdog_name'];
$a_description = $a_vdo_list['vdog_name'];
$a_pathimage   = $share_img;	
$a_keyword     = $a_vdo_list['vdog_name'];
?>