<?php
$cid = (int)(!isset($_GET['cid']) ? 0 : $_GET['cid']);

$s_sql = $db->query("SELECT 
					cal_event.*,
					cal_show_event.event_date_start,
					cal_show_event.event_date_end,
					cal_category.cat_name,
					cal_category.cat_color 
					FROM cal_event 
					INNER JOIN cal_show_event ON (cal_event.event_id = cal_show_event.event_id) 
					INNER JOIN cal_category ON (cal_category.cat_id = cal_event.cat_id)
					WHERE cal_event.event_id = '{$cid}' ");
$a_data = $db->db_fetch_array($s_sql);

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
	
$a_title       = $a_data['event_title'];
$a_description = showWord($a_data['event_detail'],'100');
$a_pathimage   = $share_img;	
$a_keyword     = showWord($a_data['event_title'],'100')." , ".showWord($a_data['event_detail'],'100');
?>