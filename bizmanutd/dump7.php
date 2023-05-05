<?php
session_start();
include("../lib/include_bizadmin.php");
include("../lib/include.php");
include("../lib/function.php");
include("../lib/ewt_config.php");
include("../lib/connect.php");
$db->query("USE ".$EWT_DB_NAME);
exit;
//$db->query("USE db_56_dmr_web");
$db->query("USE dmr_bk");
$sql = $db->query("SELECT * FROM design_list WHERE d_name LIKE 'template_%' ORDER BY d_id");
while($TP=$db->db_fetch_array($sql)){
					$did = $TP["d_id"];
					$d_site_align = $TP["d_site_align"];
					$d_site_width = $TP["d_site_width"];
					$d_site_left = $TP["d_site_left"];
					$d_site_content = $TP["d_site_content"];
					$d_site_right = $TP["d_site_right"];
					$d_site_bg_c = $TP["d_site_bg_c"];
					$d_site_bg_p = $TP["d_site_bg_p"];
					$d_top_height = $TP["d_top_height"];
					$d_top_bg_c = $TP["d_top_bg_c"];
					$d_top_bg_p = $TP["d_top_bg_p"];
					$d_body_bg_c = $TP["d_body_bg_c"];
					$d_body_bg_p = $TP["d_body_bg_p"];
					$d_left_bg_c = $TP["d_left_bg_c"];
					$d_left_bg_p = $TP["d_left_bg_p"];
					$d_right_bg_c = $TP["d_right_bg_c"];
					$d_right_bg_p = $TP["d_right_bg_p"];
					$d_bottom_height = $TP["d_bottom_height"];
					$d_bottom_bg_c = $TP["d_bottom_bg_c"];
					$d_bottom_bg_p = $TP["d_bottom_bg_p"];
			$tname=stripslashes(htmlspecialchars($TP["d_name"],ENT_QUOTES));
			$db->query("USE db_56_dmr_web");
		$db->query("INSERT INTO design_list (d_name,d_site_align,d_site_width,d_site_left,d_site_content,d_site_right,d_site_bg_c,d_site_bg_p,d_top_height,d_top_bg_c,d_top_bg_p,d_top_content,d_body_bg_c,d_body_bg_p,d_left_bg_c,d_left_bg_p,d_right_bg_c,d_right_bg_p,d_bottom_height,d_bottom_bg_c,d_bottom_bg_p,d_bottom_content) VALUES ('".$tname."','".$d_site_align."','".$d_site_width."','".$d_site_left."','".$d_site_content."','".$d_site_right."','".$d_site_bg_c."','".$d_site_bg_p."','".$d_top_height."','".$d_top_bg_c."','".$d_top_bg_p."','".$d_top_content."','".$d_body_bg_c."','".$d_body_bg_p."','".$d_left_bg_c."','".$d_left_bg_p."','".$d_right_bg_c."','".$d_right_bg_p."','".$d_bottom_height."','".$d_bottom_bg_c."','".$d_bottom_bg_p."','".$d_bottom_content."')");
		$sql_max = $db->query("SELECT MAX(d_id) FROM design_list WHERE d_name = '".$tname."' ");
		$BP = $db->db_fetch_row($sql_max);
		$DID = $BP[0];
		$db->query("USE dmr_bk");
		$sql_blockp = $db->query("SELECT * FROM design_block WHERE d_id = '$did' ");
		while($BP1 = $db->db_fetch_array($sql_blockp)){
			$sql_block = $db->query("SELECT * FROM block WHERE BID = '".$BP1["BID"]."' ");
			$R=$db->db_fetch_array($sql_block);
				
				$db->query("USE db_56_dmr_web");

				$db->query("INSERT INTO block (block_name,block_type,block_html,block_link,filename) VALUES ('".$R[block_name]."','".$R[block_type]."','".addslashes($R[block_html])."','".$R[block_link]."','') ");
				$sql_max2 = $db->query("SELECT MAX(BID) AS BID FROM block WHERE block_name = '".$R[block_name]."' ");
				$B = $db->db_fetch_row($sql_max2);

					$db->query("USE dmr_bk");
						$sql_text = $db->query("SELECT * FROM block_text WHERE BID = '".$R["BID"]."' ");
						if($db->db_num_rows($sql_text) > 0){
								$T=$db->db_fetch_array($sql_text);
								$db->query("USE db_56_dmr_web");
								$db->query("INSERT INTO block_text (BID,text_html) VALUES ('$B[0]','".addslashes($T[text_html])."')");
								$sql_max3 = $db->query("SELECT MAX(text_id) AS TID FROM block_text WHERE BID = '".$B[0]."' ");
								$BTX = $db->db_fetch_row($sql_max3);
								$db->query("UPDATE block SET block_link = '$BTX[0]' WHERE BID = '".$B[0]."' ");
								$db->query("USE dmr_bk");
						}
					$db->query("USE db_56_dmr_web");
					$db->query("INSERT INTO design_block (BID,side,position,d_id) VALUES ('$B[0]','$BP1[side]','$BP1[position]','$DID')");
					$db->query("USE dmr_bk");
		}

}
echo "Done!";
$db->db_close();
?>
