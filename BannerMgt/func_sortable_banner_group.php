<?php
/*include("../lib/include.php");
include("../lib/function.php");
include("../lib/user_config.php");
include("../lib/connect.php");
include("../lib/set_lang.php");*/

include("../EWT_ADMIN/comtop_pop.php");
include("../language/banner_language.php");

$date = new DateTime();

$a_data = array_merge($_POST, $_FILES);

if($a_data['proc']=='Sortable_Edit'){
	
	$s_data = array();
	$perpage = 10;
	$page = (int)(!isset($a_data['page']) ? 1 : $a_data['page']);
	if($page <= 0) $page = 1;
	$start = ($page * $perpage) - $perpage;
	
	//$a_data['page_id_array'];
	for($i=0; $i<count($a_data['page_id_array']); $i++){
		
		$s_data['banner_cate_order']  = ($i+$start)+1; 
		update('banner_group',$s_data,array('banner_gid'=>$a_data['page_id_array'][$i]));
		
	}
								
	print_r($a_data['page_id_array']);	

	unset($a_data);
	unset($s_data);
	
	/*
	$n = 1;
	foreach($a_data['page_id_array'] AS $group_id){
		$group_id = ready($group_id);
		echo "UPDATE banner_group SET banner_cate_order = '$n' WHERE banner_gid = '$group_id'"."<br/>";
		$db->query("UPDATE banner_group SET banner_cate_order = '$n' WHERE banner_gid = '$group_id'");
		$n++;
	}
	*/

	exit;
} 
?>