<?php
include("../lib/permission1.php");
include("../lib/include.php");
include("../lib/function.php");
include("../lib/user_config.php");
include("../lib/connect.php");


if($_POST["Flag"] == "ApplyToTemplate" AND $_POST["filename"] != "" AND $_POST["d_id"] != ""){

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
			echo $Update."<br>";
			$db->query($Update);
			$db->query("DELETE FROM design_block WHERE d_id = '".$_POST["d_id"]."' ");

		$block_position = $db->query("SELECT block_function.* FROM block INNER JOIN block_function ON block_function.BID = block.BID WHERE  block_function.filename = '".$_POST["filename"]."' ORDER BY block_function.side,block_function.position ASC");
		while($P = $db->db_fetch_array($block_position)){

				$BID_ID = $P["BID"];
				$db->query("UPDATE block SET filename = '',block_edit = '' WHERE BID = '".$P["BID"]."' ");

			$db->query("INSERT INTO design_block (BID,side,position,d_id) VALUES ('".$BID_ID."','".$P["side"]."','".$P["position"]."','".$_POST["d_id"]."') ");
			echo "INSERT INTO design_block (BID,side,position,d_id) VALUES ('".$BID_ID."','".$P["side"]."','".$P["position"]."','".$_POST["d_id"]."') <br>";

		}
?>
<script language="javascript">
alert("Save change success.");	
</script>
<?php
}

$db->db_close(); ?>
