<?php
include("../../lib/permission2.php");
include("../../lib/include.php");
include("../../lib/function.php");
include("../../lib/user_config.php");
include("../../lib/connect.php");
if($_POST["Flag"] == "Save"){
//find top data -3
	$db->query("DELETE FROM block_function WHERE filename = '".$_POST["filename"]."' AND side = '3'");
	$data_top = explode("<!--ewt_top_design-->",$_POST["tagdetect"]);
	$data_top_s = explode("EWTID_S",$data_top[1]);
	$all_top = count($data_top_s);
		for($i=0;$i<$all_top;$i++){
			$top_id = explode("EWTID_E",$data_top_s[$i]);
			if($i != 0){
				$db->query("INSERT INTO block_function (BID,side,position,filename) VALUES ('".$top_id[0]."','3','".($i-1)."','".$_POST["filename"]."')");
			}
		}

		//find left data -1
	$db->query("DELETE FROM block_function WHERE filename = '".$_POST["filename"]."' AND side = '1'");
	$data_left = explode("<!--ewt_left_design-->",$_POST["tagdetect"]);
	$data_left_s = explode("EWTID_S",$data_left[1]);
	$all_left = count($data_left_s);
		for($i=0;$i<$all_left;$i++){
			$left_id = explode("EWTID_E",$data_left_s[$i]);
			if($i != 0){
				$db->query("INSERT INTO block_function (BID,side,position,filename) VALUES ('".$left_id[0]."','1','".($i-1)."','".$_POST["filename"]."')");
			}
		}

				//find right data -2
	$db->query("DELETE FROM block_function WHERE filename = '".$_POST["filename"]."' AND side = '2'");
	$data_right = explode("<!--ewt_right_design-->",$_POST["tagdetect"]);
	$data_right_s = explode("EWTID_S",$data_right[1]);
	$all_right = count($data_right_s);
		for($i=0;$i<$all_right;$i++){
			$right_id = explode("EWTID_E",$data_right_s[$i]);
			if($i != 0){
				$db->query("INSERT INTO block_function (BID,side,position,filename) VALUES ('".$right_id[0]."','2','".($i-1)."','".$_POST["filename"]."')");
			}
		}

			//find bottom data -4
	$db->query("DELETE FROM block_function WHERE filename = '".$_POST["filename"]."' AND side = '4'");
	$data_bottom = explode("<!--ewt_bottom_design-->",$_POST["tagdetect"]);
	$data_bottom_s = explode("EWTID_S",$data_bottom[1]);
	$all_bottom = count($data_bottom_s);
		for($i=0;$i<$all_bottom;$i++){
			$bottom_id = explode("EWTID_E",$data_bottom_s[$i]);
			if($i != 0){
				$db->query("INSERT INTO block_function (BID,side,position,filename) VALUES ('".$bottom_id[0]."','4','".($i-1)."','".$_POST["filename"]."')");
			}
		}

			//find content data -5
	$db->query("DELETE FROM block_function WHERE filename = '".$_POST["filename"]."' AND side = '5'");
	$data_content = explode("<!--ewt_content_design-->",$_POST["tagdetect"]);
	$data_content_s = explode("EWTID_S",$data_content[1]);
	$all_content = count($data_content_s);
		for($i=0;$i<$all_content;$i++){
			$content_id = explode("EWTID_E",$data_content_s[$i]);
			if($i != 0){
				$db->query("INSERT INTO block_function (BID,side,position,filename) VALUES ('".$content_id[0]."','5','".($i-1)."','".$_POST["filename"]."')");
			}
		}
		if($_POST["DelBID"] != ""){
		$db->query("DELETE FROM block WHERE BID = '".$_POST["DelBID"]."' ");
		}
}

	?>
      <form name="form1" method="post" action="ewt_auto_send.php">
		<input type="hidden" name="Flag" value="Save">
        <input type="hidden" name="tagdetect">
		<input type="hidden" name="DelBID" value="">
        <input type="hidden" name="filename" value="<?php echo $_REQUEST["filename"]; ?>">
      </form> 
<?php $db->db_close(); ?>
