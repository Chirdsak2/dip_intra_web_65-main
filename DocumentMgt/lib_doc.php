<?php
function current_group_level2($gid){
	global $db;
	$sql = "select * from docload_group where dlg_id = '$gid' ";
	$query = $db->query($sql); 
	$R = mysql_fetch_array($query);
	if($R[dlg_parent] > 0){  current_group_level2($R[dlg_parent]); }
	if($gid<>0){
		 $txt =  base64_encode($R[dlg_name]);
	}
	return $txt;
}
?>