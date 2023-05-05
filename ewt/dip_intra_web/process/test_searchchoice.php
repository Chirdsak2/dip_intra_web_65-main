<?php 
include("../lib/function.php");
include("../lib/user_config.php");
include("../lib/connect.php");

$EWT_WEB_SHORTPATH = "/";
$EWT_WEB_FULLPATH  = "/ewtadmin86_gistda/ewt/gistda_web/";

function test_searchchoice(){
	global $db;
	$group_array = array();
	$group_data  = $db->query("SELECT c_id,c_name,c_parent FROM article_group ORDER BY c_parent ASC");
	while($group_info = $db->db_fetch_array($group_data)){

		if(!is_array($group_array[$group_info["c_parent"]])){
			$group_array[$group_info["c_parent"]] = array();
		}
		array_push($group_array[$group_info["c_parent"]],array("c_id"=>$group_info["c_id"],
		                                                                 "c_name"=>$group_info["c_name"]));
	}

	return $group_array;
}

function test_constructsearchlevel($groupsearch_array,$c_parent,$level){
	global $db;
	global $groupsearch_choice;

	if(count($groupsearch_array[$c_parent])>0){
		foreach($groupsearch_array[$c_parent] AS $group){

			$spacing = "";
			if($level>1){
				for($i=0;$i<$level-1;$i++){
					$spacing .= "&nbsp;&nbsp;";
				}
			}

			array_push($groupsearch_choice,array("option_text"=>$spacing."- ".$group["c_name"],"option_value"=>$group["c_id"]));
			test_constructsearchlevel($groupsearch_array,$group["c_id"],$level+1);
		}
	}

	return $groupsearch_choice;
}	

$groupsearch_array  = test_searchchoice();

$groupsearch_choice = array();
$groupsearch_choice = test_constructsearchlevel($groupsearch_array,0,1);

/**/echo "<pre>";
print_r($groupsearch_choice);
echo "</pre>";

?>