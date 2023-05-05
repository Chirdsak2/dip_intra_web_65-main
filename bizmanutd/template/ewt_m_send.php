<?php
session_start();
include("lib/function.php");
include("lib/user_config.php");
include("lib/connect.php");

if($_POST["Flag"] == "Save"){


		//find left data -1
	$db->query("DELETE FROM block_member WHERE filename = '".$_POST["filename"]."' AND side = '1'  AND mid = '".$_SESSION["EWT_MID"]."' ");
	$data_left = explode("<!--ewt_left_design-->",$_POST["tagdetect"]);
	$data_left_s = explode("EWTID_S",$data_left[1]);
	$all_left = count($data_left_s);
		for($i=0;$i<$all_left;$i++){
			$left_id = explode("EWTID_E",$data_left_s[$i]);
			if($i != 0){
				$db->query("INSERT INTO block_member (BID,side,position,filename,mid) VALUES ('".$left_id[0]."','1','".($i-1)."','".$_POST["filename"]."','".$_SESSION["EWT_MID"]."')");
			}
		}

				//find right data -2
	$db->query("DELETE FROM block_member WHERE filename = '".$_POST["filename"]."' AND side = '2' AND mid = '".$_SESSION["EWT_MID"]."'");
	$data_right = explode("<!--ewt_right_design-->",$_POST["tagdetect"]);
	$data_right_s = explode("EWTID_S",$data_right[1]);
	$all_right = count($data_right_s);
		for($i=0;$i<$all_right;$i++){
			$right_id = explode("EWTID_E",$data_right_s[$i]);
			if($i != 0){
				$db->query("INSERT INTO block_member (BID,side,position,filename,mid) VALUES ('".$right_id[0]."','2','".($i-1)."','".$_POST["filename"]."','".$_SESSION["EWT_MID"]."')");
			}
		}

			//find content data -5
	$db->query("DELETE FROM block_member WHERE filename = '".$_POST["filename"]."' AND side = '5' AND mid = '".$_SESSION["EWT_MID"]."'");
	$data_content = explode("<!--ewt_content_design-->",$_POST["tagdetect"]);
	$data_content_s = explode("EWTID_S",$data_content[1]);
	$all_content = count($data_content_s);
		for($i=0;$i<$all_content;$i++){
			$content_id = explode("EWTID_E",$data_content_s[$i]);
			if($i != 0){
				$db->query("INSERT INTO block_member (BID,side,position,filename,mid) VALUES ('".$content_id[0]."','5','".($i-1)."','".$_POST["filename"]."','".$_SESSION["EWT_MID"]."')");
			}
		}

}



	?>
      <form name="form1" method="post" action="ewt_m_send.php">
		<input type="hidden" name="Flag" value="Save">
        <input type="hidden" name="tagdetect">
		<input type="hidden" name="DelBID" value="">
        <input type="hidden" name="filename" value="<?php echo $_REQUEST["filename"]; ?>">
      </form> 
<?php $db->db_close(); ?>
