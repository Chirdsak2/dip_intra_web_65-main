<?php
		if($_SESSION["EWT_MID"] != "") {
			$sql_visit = $db->query("SELECT * FROM block_visit WHERE  filename = '".$_GET["filename"]."' AND mid = '".$_SESSION["EWT_MID"]."' ");
			if($db->db_num_rows($sql_visit) > 0){
			$private_b = "Y";
			}
		}
	$use_template = "";
	if($_SESSION["EWT_TYPE_ID"] != ""){
	$sql_person = $db->query("SELECT * FROM personal_map WHERE p_group = '".$_SESSION["EWT_TYPE_ID"]."' ");
		if($db->db_num_rows($sql_person) > 0){
		$PW = $db->db_fetch_array($sql_person);
			if($PW["p_template"] != "" AND $PW["p_template"] != "0" ){
				if($page != 'news'){
					if($_GET["filename"] == 'index'){
						$tp_default = 'I';
					}else if($_GET["filename"] != 'index'){
						$tp_default = 'G';
					}else{
						$tp_default = 'D';
					}
				}else{
					$tp_default = 'A';
				}
				//echo "SELECT design_series.ds_id,ds_name,design_series_function.d_id FROM design_series,design_series_function where design_series_function.ds_id = design_series.ds_id and design_series_function.dsf_type = '$tp_default' ";
				$sql_temp = $db->query("SELECT design_series.ds_id,ds_name,design_series_function.d_id FROM design_series,design_series_function where design_series_function.ds_id = design_series.ds_id and design_series_function.dsf_type = '$tp_default' and design_series_function.ds_id = '".$PW["p_template"]."'");
				$TP = $db->db_fetch_array($sql_temp);
				$use_template = $TP["d_id"];
			}
		}
	}
	if($use_template != ""){
		$sql_theme= $db->query("SELECT d_bottom_content FROM design_list WHERE d_id = '".$use_template."'");
		$X = $db->db_fetch_row($sql_theme);
		$global_theme = $X[0];
	}else{
		$sql_theme= $db->query("SELECT d_bottom_content FROM design_list WHERE d_id = '".$F["template_id"]."'");
		$X = $db->db_fetch_row($sql_theme);
		$global_theme = $X[0];
	}
?>