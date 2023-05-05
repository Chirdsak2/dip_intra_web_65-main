<?php
$p_survey = $db->query("SELECT * FROM p_survey WHERE s_id  = '{$a_id}' AND s_approve = 'Y'  ");
$a_row = $db->db_num_rows($p_survey);   
$a_survey = $db->db_fetch_array($p_survey);
									$topic = '';
									$fp1 = @fopen("file_attach/form_topic_".$a_survey['s_id'].".html", "r");
									if(!$fp1){ die("Cannot write form_topic_".$a_survey['s_id'].".html"); }
									while($html1 = @fgets($fp1, 1024)){
										$topic .= $html1;
									}
									@fclose($fp1);
									$s_title = strip_tags($topic);
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
	
$a_title       = $s_title;
$a_description = $s_title;
$a_pathimage   = $share_img;	
$a_keyword     = $s_title;
?>