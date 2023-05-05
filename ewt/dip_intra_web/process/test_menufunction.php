<?php 
include("../lib/function.php");
include("../lib/user_config.php");
include("../lib/connect.php");

function create_menu_test($mp_id){
	global $db;
	$menu_array = array();
	$baselength = 9;
	
	$menu_data  = $db->query("SELECT * FROM menu_properties WHERE m_id='$mp_id' ORDER BY mp_pid ASC");
	
	while($menu_info = $db->db_fetch_array($menu_data)){

		if($menu_info['mp_sub']==0){
			if(!is_array($menu_array["main"])){
				$menu_array["main"] = array();
			}
			array_push($menu_array["main"],$menu_info);
		}
		else{
			if(!is_array($menu_array["sub"][$menu_info['mp_sub']])){
				$menu_array["sub"][$menu_info['mp_sub']] = array();
			}
			array_push($menu_array["sub"][$menu_info['mp_sub']],$menu_info);
		}
	}
	
	return $menu_array;
}


$index_menu = create_menu_test("0016");
/*echo '<pre>';
print_r($index_menu);
echo '</pre>';
*/

$level  = 1;
$margin = 10; 

foreach($index_menu["main"] AS $menu){
	echo '<div style="margin-left:'.($margin*($level-1)).'px;">* '.$menu["mp_name"].'</div>';
	
	$level++;
	foreach($index_menu["sub"][$menu["mp_pid"]] AS $menu){
		echo '<div style="margin-left:'.($margin*($level-1)).'px;">* '.$menu["mp_name"].'</div>';
		$level++;
		foreach($index_menu["sub"][$menu["mp_pid"]] AS $menu){
			echo '<div style="margin-left:'.($margin*($level-1)).'px;">* '.$menu["mp_name"].'</div>';
			$level++;
			foreach($index_menu["sub"][$menu["mp_pid"]] AS $menu){
				echo '<div style="margin-left:'.($margin*($level-1)).'px;">* '.$menu["mp_name"].'</div>';
			}
			$level--;
		}
		$level--;
	}
	$level--;
}
?>