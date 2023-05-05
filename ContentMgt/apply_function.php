<?php
include("../lib/permission1.php");
include("../lib/include.php");
include("../lib/function.php");
include("../lib/user_config.php");
include("../lib/connect.php");
include("../ewt_block_function.php");
include("../ewt_menu_preview.php");
include("../ewt_article_preview.php");
include("../ewt_public_function.php");

if($_POST["Flag"] == "ChoosePublic" AND $_POST["filename"] != ""  AND $_POST["d_id"] != ""){
	echo "<h1>Please Wait...</h1>";
genpublic($_POST["filename"],"../",$_SESSION["EWT_SUSER"]);
$sql_temp = $db->query("SELECT * FROM temp_index WHERE filename = '".$_POST["filename"]."' ");
		$TP = $db->db_fetch_array($sql_temp);
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

			$Update = "UPDATE design_list SET d_site_align = '".$TP["d_site_align"]."',
			d_site_width = '".$TP["d_site_width"]."',
			d_site_left = '".$TP["d_site_left"]."',
			d_site_content = '".$TP["d_site_content"]."',
			d_site_right = '".$TP["d_site_right"]."',
			d_site_bg_c = '".$TP["d_site_bg_c"]."',
			d_site_bg_p = '".$TP["d_site_bg_p"]."',
			d_top_height = '".$TP["d_top_height"]."',
			d_top_bg_c = '".$TP["d_top_bg_c"]."',
			d_top_bg_p = '".$TP["d_top_bg_p"]."',
			d_body_bg_c = '".$TP["d_body_bg_c"]."',
			d_body_bg_p = '".$TP["d_body_bg_p"]."',
			d_left_bg_c = '".$TP["d_left_bg_c"]."',
			d_left_bg_p = '".$TP["d_left_bg_p"]."',
			d_right_bg_c = '".$TP["d_right_bg_c"]."',
			d_right_bg_p = '".$TP["d_right_bg_p"]."',
			d_bottom_height = '".$TP["d_bottom_height"]."',
			d_bottom_bg_c = '".$TP["d_bottom_bg_c"]."',
			d_bottom_bg_p = '".$TP["d_bottom_bg_p"]."' WHERE d_id = '".$_POST["d_id"]."'";

			$db->query($Update);
			$db->query("DELETE FROM design_block WHERE d_id = '".$_POST["d_id"]."' ");

		$block_position = $db->query("SELECT block_function.* FROM block INNER JOIN block_function ON block_function.BID = block.BID WHERE  block_function.filename = '".$_POST["filename"]."' ORDER BY block_function.side,block_function.position ASC");
		while($P = $db->db_fetch_array($block_position)){

				$BID_ID = $P["BID"];
				$db->query("UPDATE block SET filename = '',block_edit = '' WHERE BID = '".$P["BID"]."' ");

			$db->query("INSERT INTO design_block (BID,side,position,d_id) VALUES ('".$BID_ID."','".$P["side"]."','".$P["position"]."','".$_POST["d_id"]."') ");

		}

				$sql_temp = $db->query("SELECT filename FROM temp_index WHERE template_id = '".$_REQUEST["d_id"]."' ORDER BY filename ");
		if($db->db_num_rows($sql_temp) > 0){
			while($R1 = $db->db_fetch_array($sql_temp)){
				$bid = array();
				$sql_temp1 = $db->query("SELECT * FROM design_list WHERE d_id = '".$_REQUEST["d_id"]."' ");
						$R = $db->db_fetch_array($sql_temp1);
						for($i=1;$i<6;$i++){
							$sql_block = $db->query("SELECT block.BID FROM block INNER JOIN design_block ON block.BID = design_block.BID WHERE block.block_edit != 'Y' AND design_block.side = '".$i."' AND design_block.d_id = '".$_REQUEST["d_id"]."' ORDER BY design_block.position ASC");
									$x = 0;
								while($B = $db->db_fetch_row($sql_block)){
									$bid[$i][$x] = $B[0];
									$x++;
								}
						}
						echo "<li>".$R1[0]."......";
				$db->query("UPDATE temp_index SET d_site_align = '".$R["d_site_align"]."' , d_site_width = '".$R["d_site_width"]."' , d_site_left = '".$R["d_site_left"]."' , d_site_content = '".$R["d_site_content"]."' , d_site_right = '".$R["d_site_right"]."' , d_site_bg_c = '".$R["d_site_bg_c"]."' , d_site_bg_p = '".$R["d_site_bg_p"]."' , d_top_height = '".$R["d_top_height"]."' , d_top_bg_c = '".$R["d_top_bg_c"]."' , d_top_bg_p = '".$R["d_top_bg_p"]."' , d_top_content = '".$R["d_top_content"]."' , d_body_bg_c = '".$R["d_body_bg_c"]."' , d_body_bg_p = '".$R["d_body_bg_p"]."' , d_left_bg_c = '".$R["d_left_bg_c"]."' , d_left_bg_p = '".$R["d_left_bg_p"]."' , d_right_bg_c = '".$R["d_right_bg_c"]."' , d_right_bg_p = '".$R["d_right_bg_p"]."' , d_bottom_height = '".$R["d_bottom_height"]."' , d_bottom_bg_c = '".$R["d_bottom_bg_c"]."' , d_bottom_bg_p = '".$R["d_bottom_bg_p"]."' , d_bottom_content = '".$R["d_bottom_content"]."' WHERE filename = '".$R1[0]."' ");
				
						for($i=1;$i<6;$i++){
							$sql_block = $db->query("SELECT block.BID FROM block INNER JOIN block_function ON block.BID = block_function.BID WHERE block.block_edit = 'Y' AND block_function.side = '".$i."' AND block_function.filename = '".$R1[0]."'  ORDER BY block_function.position ASC");
									$x = count($bid[$i]);
								while($B = $db->db_fetch_row($sql_block)){
								//	if($i == "5"){
									$bid[$i][$x] = $B[0];
									$x++;
								//	}
								}
								$db->query("DELETE FROM block_function WHERE side = '".$i."' AND filename = '".$R1[0]."'");
								$c = count($bid[$i]);
								for($y=0;$y<$c;$y++){
										if($bid[$i][$y] != ""){
											$db->query("INSERT INTO block_function (BID,side,position,filename) VALUES ('".$bid[$i][$y]."','".$i."','".$y."','".$R1[0]."')");
										}
								}
						}
						echo "complete</li>";
			}
		}
		?>
		<script language="javascript">
		alert("Apply Template to Website Success.");
		self.close();
		</script>
		<?php
}

$db->db_close(); ?>
