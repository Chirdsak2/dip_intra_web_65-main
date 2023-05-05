<?php
function show_block($BID){
	global $db;
	
	$sql_file = $db->query("SELECT block_type,block_link FROM block WHERE BID = '".$BID."'");
		if($db->db_num_rows($sql_file) == 1){
			$R = $db->db_fetch_array($sql_file);
				if($R["block_type"] == "text" OR $R["block_type"] == "code"){ 
						$sql_text = $db->query("SELECT * FROM block_text WHERE BID = '".$BID."' AND text_id = '".$R["block_link"]."'");
						$T = $db->db_fetch_array($sql_text);
						return stripslashes($T["text_html"]);
				}
				if($R["block_type"] == "graph"){ 
					$sql_graph = $db->query("SELECT * FROM graph_index WHERE graph_id = '".$R["block_link"]."'");
					if($db->db_num_rows($sql_graph)){
					$G = $db->db_fetch_array($sql_graph);
					$Gaph_text = "<div align=\"".$G["graph_align"]."\"><img src=\"../../ContentMgt/graph_view.php?graph_id=".$R["block_link"]."\" width=\"".$G["graph_width"]."\" height=\"".$G["graph_height"]."\"></div>";
					return $Gaph_text;
					}
				}
			
		}
}
?>
