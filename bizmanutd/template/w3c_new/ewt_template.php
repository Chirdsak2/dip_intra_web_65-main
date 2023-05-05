<?php
if($_GET["filename"] != ""){
$sql_index = $db->query("SELECT template_id_w3c FROM temp_index WHERE filename = '".$_GET["filename"]."' ");
$XX = $db->db_fetch_array($sql_index);
$sql_index = $db->query("SELECT d_id FROM design_list WHERE d_id = '$XX[0]'  ");
}else{
	$sql_index = $db->query("SELECT d_id FROM design_list WHERE d_default_w3c = 'Y'  ");
}
$FF = $db->db_fetch_array($sql_index);
$d_idtemp = $FF[d_id];
$temp = "SELECT * FROM design_list WHERE d_id = '".$d_idtemp."'";
$sql_temp= $db->query($temp);
$F = $db->db_fetch_array($sql_temp);
$design_id = $F["d_id"];
$global_theme = $F["d_bottom_content"];
$mainwidth = "0";
$template_w3c = $F[d_name];
?>