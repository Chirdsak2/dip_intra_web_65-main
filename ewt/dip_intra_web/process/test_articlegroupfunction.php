<?php 
include("../lib/function.php");
include("../lib/user_config.php");
include("../lib/connect.php");

/*
$EWT_ARTICLE_GROUP      = array();

function create_breadcrumb_test(){
	global $db;
	global $EWT_ARTICLE_GROUP;
	
	$group_data  = $db->query("SELECT * FROM article_group ORDER BY c_id ASC");
	
	while($group_info = $db->db_fetch_array($group_data)){

		if($group_info['c_parent']==0){
			if(!is_array($EWT_ARTICLE_GROUP["main"])){
				$EWT_ARTICLE_GROUP["main"] = array();
			}
			array_push($EWT_ARTICLE_GROUP["main"],$group_info["c_id"]);
			$type = "main";
		}
		else{
			if(!is_array($EWT_ARTICLE_GROUP["sub"][$group_info['c_parent']])){
				$EWT_ARTICLE_GROUP["sub"][$group_info['c_parent']] = array();
			}
			array_push($EWT_ARTICLE_GROUP["sub"][$group_info['c_parent']],$group_info["c_id"]);
			$type = "sub";
		}

		if(!is_array($EWT_ARTICLE_GROUP["detail"])){
			$EWT_ARTICLE_GROUP["detail"] = array();
		}

		$group_info["type"]                  = $type;
		$EWT_ARTICLE_GROUP["detail"][$group_info["c_id"]] = $group_info;
	}
	
	return $EWT_ARTICLE_GROUP;
}

function articlegroup_cname($c_id){
	global $EWT_ARTICLE_GROUP;
	return $EWT_ARTICLE_GROUP["detail"][$c_id]["c_name"];
}

function articlegroup_sub($c_id){
	global $EWT_ARTICLE_GROUP;
	//$sub_array = array()
	return $EWT_ARTICLE_GROUP["detail"][$c_id]["c_name"];
}


$article_bread = create_breadcrumb_test(0);
echo '<pre>';
print_r($article_bread);
echo '</pre>';

echo articlegroup_cname(151)."<br/>";
*/
/**/


function articlegroup_sub_test($c_id){
	global $db;
	global $article_subnews;


}

?>