<?php 
include("../lib/function.php");
include("../lib/user_config.php");
include("../lib/connect.php");
$n_id = filter_number($_GET["n_id"]);

$current_date = date("Y-m-d");
$current_date = explode("-",$current_date);
$current_date = ((int)$current_date[0]+543)."-".$current_date[1]."-".$current_date[2];

##===========================================================================================##

##===========================================================================================##
$article_data = $db->query("SELECT * FROM article_list 
                            WHERE n_id = '$n_id' AND n_approve = 'Y'
								  AND    ((n_date_start = '' AND n_date_end = '') OR 
								          (n_date_start <= '$current_date' AND n_date_end = '') OR 
										  (n_date_start = '' AND n_date_end >= '$current_date') OR 
										  (n_date_start <= '$current_date' AND n_date_end >= '$current_date'))");
if($db->db_num_rows($article_data)>0){
	$article_info = $db->db_fetch_array($article_data);

    ## >> Get article_detail
    $detail_array["detail"] = array();
    $detail_array["image"]  = array();

    $detail_data = $db->query("SELECT * FROM article_detail WHERE n_id = '$n_id'");
    while($detail_info = $db->db_fetch_array($detail_data)){
        //array_push($detail_array,$detail_info);
        if($detail_info["ad_pic_b"]!=""){
            array_push($detail_array["image"],$detail_info);
        }
        else if($detail_info["ad_des"]!=""){
            array_push($detail_array["detail"],$detail_info);
        }
    }
}

$this_detail = strip_tags($detail_array["detail"][0]["ad_des"]);

//$share_detail = trim(mb_substr(strip_tags($detail_array["detail"][0]["ad_des"]),0,100))."..";
function substring_article_test($text,$length){

	$text           = mb_substr($text,0,100,'UTF-8');
	$current_length = strlen($text);

	if($current_length>$length){
		//substring_article_test($text,$length-10);
	}

	return $text;
}


$this_detail = substring_article_test($this_detail,100);
echo $this_detail."<br/>";
echo strlen($this_detail)."<br/>";

?>