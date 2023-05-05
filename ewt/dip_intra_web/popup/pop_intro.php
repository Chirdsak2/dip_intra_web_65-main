<?php
include("assets/config.inc.php");
include("../lib/function.php");
include("../lib/user_config.php");
include("../lib/connect.php");

$bid = $_GET['bid'];

$date_now =  date('Y-m-d');

$wh = "AND ((banner.banner_show_start = '' AND banner.banner_show_end = '')";
$wh .= "OR ('{$date_now}' between banner.banner_show_start AND banner.banner_show_end))";

$s_info_popup = $db->query("SELECT * 
				 FROM site_info_popup 
				 LEFT JOIN banner ON site_info_popup.site_popup_code = banner.banner_id
				 LEFT JOIN banner_group ON banner.banner_gid = banner_group.banner_gid
				 WHERE  site_info_popup.site_popup_name = 'banner' {$wh} ");
$a_data_popup = $db->db_fetch_array($s_info_popup);

if($a_data_popup['site_popup_status'] == 'Y'){ 

if(!empty($a_data_popup['banner_w']) OR !empty($a_data_popup['banner_h'])){
	if(empty($a_data_popup['banner_w'])){
		$a_data_popup['banner_w'] = '100%';
	}else{
		$a_data_popup['banner_w'] = $a_data_popup['banner_w'].'px';
	}
	if(empty($a_data_popup['banner_h'])){
		$a_data_popup['banner_h'] = 'auto';
	}else{
		$a_data_popup['banner_h'] = $a_data_popup['banner_h'].'px';
	}	
$banner_w_h =  'style="width:'.$a_data_popup['banner_w'].';height:'.$a_data_popup['banner_h'].';"';
}



if(strstr($a_data_popup['banner_link'],'ewt_news.php')){
$Ex = explode("ewt_news.php",$a_data_popup['banner_link']);
$a_data_popup['banner_link'] = "news_view.php".$Ex[1];
	
}else{
	
	$a_data_popup['banner_link'] = $a_data_popup['banner_link'];
}
if($a_data_popup['banner_link'] =="#"){  
$banner_ahref= ""; 
$banner_a= ""; 

}else if($a_data_popup['banner_link']==""){ 
$banner_ahref= ""; 
$banner_a= ""; 
}else{ 

$banner_ahref="<a href=\"../".$a_data_popup['banner_link']."\" target=\"_blank\" onclick=\"ajax_save_log('banner_ajax_log.php?banner_id=".$a_data_popup['banner_id'].")\">"; 
$banner_a= "</a>"; 
} 
	
?>
<div class="container" <?=$banner_w_h?> > 
<span class="far fa-times-circle fa-1x" onclick="$('#box_popup').fadeOut();"  style="font-size:26px;position:fixed; top:20px; right:30px; color:#FFFFFF;cursor:pointer;" ></span> 
<div class="panel" >
<div class="panel-body">
<?php
echo $banner_ahref;	
echo "<img src=\"".$a_data_popup['banner_pic']."\" ".$banner_w_h." class=\"mx-auto d-block\" alt=\"".$a_data_popup['banner_name']."\" _title=\"".$a_data_popup['banner_name']."\" />";
echo $banner_a; 	 
?>		
</div>	 
</div>
</div>	 
<?php  }?>